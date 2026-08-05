const { chromium } = require("playwright");
(async () => {
  const browser = await chromium.launch({ headless: true });
  const context = await browser.newContext({ viewport: { width: 390, height: 844 }, isMobile: true, hasTouch: true });
  const page = await context.newPage();
  // bust cache
  await page.goto("http://wsd.localhost/teams/?nocache=" + Date.now(), { waitUntil: "networkidle", timeout: 60000 });
  await page.locator(".js-doctor-modal-open").first().click();
  await page.waitForSelector("#teamsDoctorModal.show");
  await page.waitForTimeout(800);
  const info = await page.evaluate(() => {
    const hero = document.querySelector("#teamsDoctorModal .teams-doctor-hero");
    const img = document.querySelector("#teamsDoctorModal .teams-doctor-photo-img");
    const cs = getComputedStyle(hero);
    return {
      height: cs.height,
      flex: cs.flex,
      flexShrink: cs.flexShrink,
      overflow: cs.overflow,
      imgH: img.getBoundingClientRect().height,
      imgVisible: img.getBoundingClientRect().top < window.innerHeight && img.getBoundingClientRect().height > 100,
      nameText: document.querySelector("#teamsDoctorModal .teams-doctor-fullname").textContent,
    };
  });
  console.log(JSON.stringify(info, null, 2));
  await page.screenshot({ path: "d:/PHP/htdocs/wsd/wp-content/themes/wsd/_debug-modal-verify.png" });
  await browser.close();
})();
