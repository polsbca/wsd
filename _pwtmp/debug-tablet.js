const { chromium } = require("playwright");
(async () => {
  const browser = await chromium.launch({ headless: true });
  const context = await browser.newContext({ viewport: { width: 820, height: 1180 } });
  const page = await context.newPage();
  await page.goto("http://wsd.localhost/teams/?t=" + Date.now(), { waitUntil: "networkidle", timeout: 60000 });
  await page.locator(".js-doctor-modal-open").first().click();
  await page.waitForSelector("#teamsDoctorModal.show");
  await page.waitForTimeout(900);

  const info = await page.evaluate(() => {
    const hero = document.querySelector("#teamsDoctorModal .teams-doctor-hero");
    const photo = document.querySelector("#teamsDoctorModal .teams-doctor-photo");
    const img = document.querySelector("#teamsDoctorModal .teams-doctor-photo-img");
    const copy = document.querySelector("#teamsDoctorModal .teams-doctor-hero-copy");
    const refer = document.querySelector("#teamsDoctorModal .teams-doctor-hero-cta-refer");
    const readmore = document.querySelector("#teamsDoctorModal .teams-doctor-hero-cta-readmore");
    const gallery = document.querySelector("#teamsDoctorModal .teams-doctor-hero-cta-gallery");
    const bookMobile = document.querySelector("#teamsDoctorModal .teams-doctor-hero-cta-book-mobile");
    const cs = (el) => el && getComputedStyle(el);
    const r = (el) => el && el.getBoundingClientRect();
    return {
      viewport: { w: innerWidth, h: innerHeight },
      hero: { h: cs(hero).height, overflow: cs(hero).overflow },
      copy: { pos: cs(copy).position, top: cs(copy).top, left: cs(copy).left, gap: cs(copy).gap },
      photo: { pos: cs(photo).position, w: cs(photo).width, h: cs(photo).height, right: cs(photo).right, bottom: cs(photo).bottom, display: cs(photo).display },
      img: { pos: cs(img).position, left: cs(img).left, top: cs(img).top, w: cs(img).width, h: cs(img).height, src: img.currentSrc, nw: img.naturalWidth },
      refer: { display: cs(refer).display, rect: r(refer) },
      readmore: { display: cs(readmore).display, rect: r(readmore) },
      gallery: { display: cs(gallery).display },
      bookMobile: { display: cs(bookMobile).display },
      aboutBadge: document.querySelector("#teamsDoctorModal .teams-doctor-about-badge-title")?.innerText,
    };
  });
  console.log(JSON.stringify(info, null, 2));
  await page.screenshot({ path: "d:/PHP/htdocs/wsd/wp-content/themes/wsd/_debug-tablet-hero.png" });
  // scroll to about
  await page.evaluate(() => {
    document.querySelector("#teamsDoctorModal .teams-doctor-modal-body").scrollTop = 700;
  });
  await page.waitForTimeout(300);
  await page.screenshot({ path: "d:/PHP/htdocs/wsd/wp-content/themes/wsd/_debug-tablet-about.png" });
  await browser.close();
})();
