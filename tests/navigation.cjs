// Focus, short-view scrolling, parent links, resizing and desktop flyouts.
const {chromium,webkit}=require('playwright');
const assert=require('node:assert/strict');
const path=require('node:path');
const fs=require('node:fs');
const output=process.env.AUDIT_OUTPUT||'/tmp/wswa-responsive';
(async()=>{
  for(const [name,type] of Object.entries({chromium,webkit})){
    const b=await type.launch();const p=await b.newPage({viewport:{width:390,height:420},hasTouch:true});
    if(process.argv.includes('--local')) {
      await p.route('**/wp-content/themes/winter/assets/css/*.css*',r=>r.fulfill({path:path.resolve('assets/css',new URL(r.request().url()).pathname.split('/').pop()),contentType:'text/css'}));
      await p.route('**/wp-content/themes/winter/assets/js/main.js*',r=>r.fulfill({path:path.resolve('assets/js/main.js'),contentType:'text/javascript'}));
    }
    await p.goto((process.env.AUDIT_URL||'https://webstudiowa.com.au')+'/?navigation-audit=20261019',{waitUntil:'networkidle'});
    const buttons=p.locator('.home-pathways .button');
    const boxes=await buttons.evaluateAll(es=>es.map(e=>{const r=e.getBoundingClientRect();return {x:r.x,y:r.y,w:r.width,h:r.height,scroll:e.scrollWidth,client:e.clientWidth};}));
    assert.equal(boxes.length,4);
    boxes.forEach((r,i)=>{assert(r.h>=44&&r.x>=0&&r.x+r.w<=390&&r.scroll<=r.client+1);if(i)assert(r.y-(boxes[i-1].y+boxes[i-1].h)>=11);});
    fs.mkdirSync(output,{recursive:true});
    await p.setViewportSize({width:390,height:1100});
    await p.locator('.home-pathways').screenshot({path:path.join(output,`${name}-support-buttons.png`)});
    await p.setViewportSize({width:390,height:900});
    await p.locator('.footer__brand img').evaluate(async img=>{img.loading='eager';await img.decode();});
    await p.locator('.site-footer').screenshot({path:path.join(output,`${name}-footer.png`)});
    await p.setViewportSize({width:390,height:420});
    await p.evaluate(()=>window.scrollTo({top:0,behavior:'instant'}));
    const nav=p.locator('[data-primary-nav]'),toggle=p.locator('[data-menu-toggle]');
    await toggle.focus();await p.keyboard.press('Space');assert.equal(await toggle.getAttribute('aria-expanded'),'true');
    const plugins=nav.getByRole('button',{name:'Toggle WordPress Plugins submenu',exact:true});
    await plugins.focus();await p.keyboard.press('Enter');
    const social=nav.getByRole('button',{name:'Toggle SocialFeed submenu',exact:true});
    await social.focus();await p.keyboard.press('Space');
    assert.equal(await social.getAttribute('aria-expanded'),'true');assert.equal(await plugins.getAttribute('aria-expanded'),'true');
    assert(await nav.evaluate(e=>e.scrollHeight>e.clientHeight),'Short viewport must exercise actual scrolling');
    await nav.locator('a').last().scrollIntoViewIfNeeded();
    const rect=await nav.locator('a').last().boundingBox();assert(rect.y>=0&&rect.y+rect.height<=421);
    fs.mkdirSync(output,{recursive:true});await p.screenshot({path:path.join(output,`${name}-short-menu.png`)});
    await social.focus();await p.keyboard.press('Escape');assert.equal(await social.getAttribute('aria-expanded'),'false');
    await toggle.focus();await p.keyboard.press('Escape');assert.equal(await toggle.getAttribute('aria-expanded'),'false');
    await p.setViewportSize({width:390,height:844});await toggle.click();
    await p.locator('main a').first().focus();await p.waitForFunction(()=>document.querySelector('[data-menu-toggle]').getAttribute('aria-expanded')==='false');assert.equal(await toggle.getAttribute('aria-expanded'),'false');
    await p.evaluate(()=>window.scrollTo(0,500));await p.waitForTimeout(100);assert(await p.evaluate(()=>scrollY>0));
    await p.evaluate(()=>window.scrollTo(0,0));await toggle.click();
    await p.setViewportSize({width:1440,height:900});await p.waitForFunction(()=>document.querySelector('[data-menu-toggle]').getAttribute('aria-expanded')==='false');assert.equal(await toggle.getAttribute('aria-expanded'),'false');
    // Desktop keyboard focus opens both levels, and the flyout fits the viewport.
    const parent=nav.getByRole('link',{name:/WordPress Plugins/});await parent.focus();
    const socialLink=nav.getByRole('link',{name:/SocialFeed/});await socialLink.focus();
    const third=nav.locator('.sub-menu .sub-menu');await third.waitFor({state:'visible'});await p.waitForTimeout(200);assert(await third.isVisible());
    await p.screenshot({path:path.join(output,`${name}-desktop-flyout.png`)});
    const r=await third.boundingBox();assert(r.x>=0&&r.x+r.width<=1441,'Desktop flyout outside viewport');
    await p.setViewportSize({width:390,height:844});await p.waitForTimeout(50);assert.equal(await toggle.getAttribute('aria-expanded'),'false');await toggle.click();
    await nav.getByRole('link',{name:'About',exact:true}).click();await p.waitForURL('**/about-us/');
    assert.equal(await toggle.getAttribute('aria-expanded'),'false');
    console.log(name+' short-height, keyboard, focus exit, scrolling, resize, desktop flyout and real parent link PASS');await b.close();
  }
})();
