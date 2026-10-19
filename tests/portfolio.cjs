// Full-width thumbnail contract: verifies all six real images after lazy-loading.
const {chromium,webkit}=require('playwright');
const fs=require('node:fs');
const path=require('node:path');
const assert=require('node:assert/strict');
const {execFileSync}=require('node:child_process');
const base=process.env.AUDIT_URL||'https://webstudiowa.com.au';
const output=process.env.AUDIT_OUTPUT||'/tmp/wswa-portfolio';
const widths=[320,375,390,393,414,430,768,1024,1440];
const local=process.argv.includes('--local');
fs.mkdirSync(output,{recursive:true});
(async()=>{
 const results=[];
 await Promise.all(Object.entries({chromium,webkit}).map(async([engine,type])=>{
  const b=await type.launch();
  try{
   const p=await b.newPage({viewport:{width:390,height:900},hasTouch:true});
   if(local){
    const previews=JSON.parse(execFileSync('php',['tests/portfolio-helper.php'],{encoding:'utf8'}));
    await p.route('**/our-clients/**',async route=>{
     if(route.request().resourceType()!=='document') return route.continue();
     const response=await route.fetch();
     const html=(await response.text()).replace(/<img class="[^"]*client-preview--[^"]*"[^>]*>/g,tag=>{
      const slug=tag.match(/client-preview--([^" ]+)/)[1];
      const preview=Object.values(previews).find(value=>new URL(value.image).pathname.endsWith('/client-'+slug+'.webp'));
      assert(preview,'Curated image mapping missing for '+slug);
      return tag.replace(/src="[^"]*"/,'src="'+preview.image+'"').replace(/width="\d+" height="\d+"/,'width="1240" height="720"');
     });
     await route.fulfill({response,body:html});
    });
    await p.route('**/wp-content/themes/winter/assets/css/main.css*',r=>r.fulfill({path:path.resolve('assets/css/main.css'),contentType:'text/css'}));
    await p.route('**/wp-content/themes/winter/assets/img/client-*.webp*',r=>r.fulfill({path:path.resolve('assets/img',new URL(r.request().url()).pathname.split('/').pop()),contentType:'image/webp'}));
   }
   const response=await p.goto(base+'/our-clients/?portfolio-audit=20261019',{waitUntil:'networkidle',timeout:60000});
   assert(response.ok());
   await p.locator('.portfolio-card img').evaluateAll(async images=>{images.forEach(i=>i.loading='eager');await Promise.all(images.map(i=>i.decode()));});
   const content=await p.locator('.portfolio-card').evaluateAll(cards=>cards.map(c=>({name:c.querySelector('h2').textContent.trim(),details:c.querySelector('.portfolio-card__details').textContent.trim(),links:[...c.querySelectorAll('a')].map(a=>({url:a.href,target:a.target,rel:a.rel})),image:c.querySelector('img').currentSrc})));
   assert.equal(content.length,6);
   assert.equal(new Set(content.map(c=>c.name)).size,6);
   assert(content.every(c=>c.links.every(l=>l.target==='_blank'&&l.rel.includes('noopener')&&l.url===c.links[0].url)));
   fs.writeFileSync(path.join(output,engine+'-content.json'),JSON.stringify(content,null,2));
   for(const width of widths){
    await p.setViewportSize({width,height:1000});
    const metrics=await p.locator('.portfolio-card').evaluateAll(cards=>cards.map(c=>{
     const img=c.querySelector('img'),media=c.querySelector('.portfolio-card__media'),panel=c.querySelector('.portfolio-card__details');
     const ir=img.getBoundingClientRect(),mr=media.getBoundingClientRect(),css=getComputedStyle(img);
     return {name:c.querySelector('h2').textContent.trim(),imageWidth:ir.width,mediaWidth:mr.width,imageHeight:ir.height,mediaHeight:mr.height,leftOffset:ir.left-mr.left,padding:css.padding,fit:css.objectFit,naturalWidth:img.naturalWidth,naturalHeight:img.naturalHeight,panelBackground:getComputedStyle(panel).backgroundImage};
    }));
    for(const m of metrics){
     assert(Math.abs(m.imageWidth-m.mediaWidth)<1,`${engine}/${width} ${m.name}: image does not fill width ${JSON.stringify(m)}`);
     assert(Math.abs(m.imageHeight-m.mediaHeight)<1,'Image must fill media height');
     assert(Math.abs(m.mediaWidth/m.mediaHeight-1240/720)<.01,'Uniform desktop-viewport ratio');
     assert.equal(m.padding,'0px');assert.equal(m.fit,'cover');assert(Math.abs(m.leftOffset)<1);
     assert.equal(m.naturalWidth,1240);assert.equal(m.naturalHeight,720);
     assert(m.panelBackground.includes('linear-gradient'),'Dark detail panel preserved');
    }
    const layout=await p.locator('.client-portfolio').evaluate(e=>({columns:getComputedStyle(e).gridTemplateColumns.split(' ').length,gap:getComputedStyle(e).gap,viewport:innerWidth,scroll:document.documentElement.scrollWidth}));
    assert.equal(layout.columns,width<=980?1:2);assert.equal(layout.gap,'24px');assert(layout.scroll<=width+1);
    await p.screenshot({path:path.join(output,engine+'-portfolio-'+width+'.png'),fullPage:true});
    if(width===390) {
     const cards=p.locator('.portfolio-card');
     for(let i=0;i<6;i++) await cards.nth(i).screenshot({path:path.join(output,`${engine}-card-${i+1}-390.png`)});
    }
    results.push({engine,width,layout,cards:metrics,status:'pass'});
   }
  }finally{await b.close()}
 }));
 fs.writeFileSync(path.join(output,'portfolio-results.json'),JSON.stringify({mode:local?'candidate CSS and assets over live HTML':'live',results},null,2));
 console.log(`${results.length} viewport/engine cases; all six thumbnails fill their containers, proportional and loaded; PASS`);
})();
