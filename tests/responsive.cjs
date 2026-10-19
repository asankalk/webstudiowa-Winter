// Read-only integration audit against published WordPress HTML. --local substitutes working CSS/JS.
const { chromium, webkit } = require('playwright');
const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const base = process.env.AUDIT_URL || 'https://webstudiowa.com.au';
const output = process.env.AUDIT_OUTPUT || '/tmp/wswa-responsive';
const widths = [320,375,390,393,414,430,768,1024,1440];
const local = process.argv.includes('--local');
const failures = [], results = [];
fs.mkdirSync(output, {recursive:true});
async function overflow(page) {
  return page.evaluate(() => {
    const bad = [...document.querySelectorAll('body *')].filter(el => {
      const r = el.getBoundingClientRect(), css = getComputedStyle(el);
      if (!r.width || !r.height || css.visibility === 'hidden') return false;
      // Intentional clipped marquee/decorations and offscreen accessibility fields are not page overflow.
      if (el.closest('.client-marquee,.wswa-honeypot,.screen-reader-text,.skip-link')) return false;
      if (el.matches('h1,h2,h3,.button') && (r.left < -1 || r.right > innerWidth + 1)) return true;
      let parent = el.parentElement;
      while (parent && parent !== document.body) {
        if (['hidden','clip','auto','scroll'].includes(getComputedStyle(parent).overflowX)) {
          const pr = parent.getBoundingClientRect();
          if (pr.left >= -1 && pr.right <= innerWidth + 1) return false;
        }
        parent = parent.parentElement;
      }
      return r.left < -1 || r.right > innerWidth + 1;
    }).map(el => ({tag:el.tagName,class:el.className,text:el.textContent.trim().slice(0,60),left:el.getBoundingClientRect().left,right:el.getBoundingClientRect().right}));
    return {width:innerWidth,scroll:document.documentElement.scrollWidth,bad};
  });
}
(async()=>{
  // REST API inventories all published page templates, including legal/support/resource pages.
  const pages = [];
  for (let pageNumber=1; ; pageNumber++) {
    const response = await fetch(base + '/wp-json/wp/v2/pages?per_page=100&_fields=link,slug,template&page='+pageNumber);
    assert(response.ok, 'Published page inventory unavailable');
    pages.push(...await response.json());
    if(pageNumber>=Number(response.headers.get('x-wp-totalpages')||1)) break;
  }
  const urls = [...new Set([base+'/', ...pages.map(p=>p.link)])];
  fs.writeFileSync(path.join(output,'pages.json'), JSON.stringify(pages,null,2));
  await Promise.all(Object.entries({chromium,webkit}).map(async ([engine,type]) => {
    const browser = await type.launch();
    const context = await browser.newContext({viewport:{width:390,height:844},hasTouch:true});
    if(local) {
      await context.route('**/wp-content/themes/winter/assets/css/*.css*', route => {
        const filename = new URL(route.request().url()).pathname.split('/').pop();
        return route.fulfill({path:path.resolve('assets/css',filename),contentType:'text/css'});
      });
      await context.route('**/wp-content/themes/winter/assets/js/main.js*', route=>route.fulfill({path:path.resolve('assets/js/main.js'),contentType:'text/javascript'}));
      // Mirrors the sole markup change: the official compact Turnstile size.
      await context.route('**/contact/**', async route=>{
        if(route.request().resourceType()!=='document') return route.continue();
        const r=await route.fetch();
        await route.fulfill({response:r,body:(await r.text()).replace(/class="cf-turnstile"(?: data-size="[^"]*")?/, 'class="cf-turnstile" data-size="compact"')});
      });
    }
    const page = await context.newPage();
    page.setDefaultTimeout(10000);
    page.setDefaultNavigationTimeout(60000);
    for (const url of urls) {
      const response = await page.goto(url + (url.includes('?')?'&':'?') + 'responsive-audit=20261019', {waitUntil:'load'});
      assert(response.ok(),url + ' HTTP ' + response.status());
      // Complete lazy images, then measure the whole rendered page, not only the first screen.
      await page.evaluate(async()=>{for(const img of document.images){img.loading='eager';} await Promise.all([...document.images].map(i=>i.decode().catch(()=>{})));});
      for(const width of widths) {
        await page.setViewportSize({width,height:844});
        await page.evaluate(()=>window.scrollTo(0,0));
        await page.waitForTimeout(50);
        const label = `${engine} ${new URL(url).pathname} ${width}`;
        try {
          let o=await overflow(page);
          assert(o.scroll <= width+1 && !o.bad.length,JSON.stringify(o));
          const toggle = page.locator('[data-menu-toggle]');
          if(width<=1100) {
            assert.equal(await toggle.getAttribute('aria-expanded'),'false');
            assert.equal(await page.locator('[data-primary-nav]').isVisible(),false);
            await toggle.click();
            assert.equal(await toggle.getAttribute('aria-expanded'),'true');
            assert.equal(await page.locator('[data-primary-nav] .sub-menu:visible').count(),0);
            o=await overflow(page); assert(o.scroll<=width+1 && !o.bad.length,JSON.stringify(o));
            if(url===urls[0]) {
            const branches=page.locator('[data-primary-nav] > .menu > li > .submenu-toggle');
            for(let i=0;i<await branches.count();i++) {
              await branches.nth(i).click();
              assert.equal(await branches.nth(i).getAttribute('aria-expanded'),'true');
              assert.equal(await page.locator('[data-primary-nav] > .menu > li > .submenu-toggle[aria-expanded="true"]').count(),1);
            }
            // Exercise every level, collapse/reopen, then reach the very last item by scrolling.
            for(const button of await page.locator('[data-primary-nav] .submenu-toggle:visible').all()) {
              if(await button.getAttribute('aria-expanded')==='false') await button.click();
              await button.click(); assert.equal(await button.getAttribute('aria-expanded'),'false');
              await button.click();
            }
            }
            const nav=page.locator('[data-primary-nav]');
            const bounds=await nav.boundingBox(); assert(bounds.y+bounds.height<=845,'Menu exceeds viewport');
            await nav.locator('a').last().scrollIntoViewIfNeeded();
            const last=await nav.locator('a').last().boundingBox(); assert(last.y+last.height<=845,'Last menu link unreachable');
            await toggle.focus(); await page.keyboard.press('Escape');
            assert.equal(await toggle.getAttribute('aria-expanded'),'false');
            await toggle.click(); await page.mouse.click(width / 2, 10);
            assert.equal(await toggle.getAttribute('aria-expanded'),'false');
            if(width<=640) {
              const columns=await page.locator('.footer__grid').evaluate(e=>getComputedStyle(e).gridTemplateColumns.split(' ').length);
              assert.equal(columns,2,'Footer should have two columns');
            }
          }
          if(url===urls[0] && [320,390,768,1440].includes(width)) {
            await page.screenshot({path:path.join(output,`${engine}-home-${width}.png`),fullPage:true});
            if(width<=1100){await toggle.click();await page.screenshot({path:path.join(output,`${engine}-menu-${width}.png`)});await toggle.click();}
          }
          if(engine==='chromium' && width===390 && url!==urls[0] && !new URL(url).pathname.startsWith('/resources/')) await page.screenshot({path:path.join(output,'page-'+new URL(url).pathname.replaceAll('/','_')+'-390.png'),fullPage:true});
          results.push({engine,url,width,status:'pass'});
        }catch(error){console.log('FAIL', label, error.message); failures.push({engine,url,width,error:error.message});await page.screenshot({path:path.join(output,`failure-${engine}-${new URL(url).pathname.replaceAll('/','_')}-${width}.png`)});await page.evaluate(()=>{document.querySelector('[data-menu-toggle]').setAttribute('aria-expanded','false');document.querySelector('[data-primary-nav]').classList.remove('is-open');});}
      }
      fs.writeFileSync(path.join(output,engine+'-progress.json'),JSON.stringify({results:results.filter(r=>r.engine===engine),failures:failures.filter(f=>f.engine===engine)},null,2));
      console.log(`${engine} ${new URL(url).pathname}: ${failures.filter(f=>f.engine===engine&&f.url===url).length} failures`);
    }
    await browser.close();
  }));
  fs.writeFileSync(path.join(output,'results.json'),JSON.stringify({mode:local?'staged assets over live HTML':'live',widths,results,failures},null,2));
  console.log(`${results.length} passed; ${failures.length} failed`);
  if(failures.length){console.log(JSON.stringify(failures,null,2));process.exitCode=1;}
})();
