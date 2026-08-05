const { chromium } = require("playwright");
(async () => {
  const browser = await chromium.launch({ headless: true });
  // mobile check regression
  const mobile = await browser.newContext({ viewport: { width: 390, height: 844 }, isMobile: true, hasTouch: true });
  const mpage = await mobile.newPage();
  await mpage.goto("http://wsd.localhost/teams/?t=" + Date.now(), { waitUntil: "networkidle", timeout: 60000 });
  await mpage.locator(".js-doctor-modal-open").first().click();
  await mpage.waitForSelector("#teamsDoctorModal.show");
  await mpage.waitForTimeout(700);
  const minfo = await mpage.evaluate(() => {
    const hero = document.querySelector("#teamsDoctorModal .teams-doctor-hero");
    const img = document.querySelector("#teamsDoctorModal .teams-doctor-photo-img");
    const refer = getComputedStyle(document.querySelector("#teamsDoctorModal .teams-doctor-hero-cta-refer")).display;
    const book = getComputedStyle(document.querySelector("#teamsDoctorModal .teams-doctor-hero-cta-book-mobile")).display;
    return {
      heroH: getComputedStyle(hero).height,
      flexShrink: getComputedStyle(hero).flexShrink,
      imgH: img.getBoundingClientRect().height,
      imgVisible: img.getBoundingClientRect().height > 100,
      refer, book,
      name: document.querySelector("#teamsDoctorModal .teams-doctor-fullname").textContent
    };
  });
  console.log("MOBILE", JSON.stringify(minfo));
  await mpage.screenshot({ path: "d:/PHP/htdocs/wsd/wp-content/themes/wsd/_debug-mobile-check.png" });
  await browser.close();
})();
