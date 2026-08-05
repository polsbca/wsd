const { chromium } = require("playwright");
(async () => {
  const browser = await chromium.launch({ headless: true });
  const context = await browser.newContext({ viewport: { width: 390, height: 844 }, isMobile: true, hasTouch: true });
  const page = await context.newPage();
  await page.goto("http://wsd.localhost/teams/", { waitUntil: "networkidle", timeout: 60000 });
  await page.locator(".js-doctor-modal-open").first().click();
  await page.waitForSelector("#teamsDoctorModal.show");
  await page.waitForTimeout(500);

  // Apply fix in-page and remeasure
  const before = await page.evaluate(() => {
    const hero = document.querySelector("#teamsDoctorModal .teams-doctor-hero");
    const cs = getComputedStyle(hero);
    return { h: cs.height, flexShrink: cs.flexShrink, overflow: cs.overflow, minHeight: cs.minHeight };
  });

  await page.evaluate(() => {
    const hero = document.querySelector("#teamsDoctorModal .teams-doctor-hero");
    hero.style.setProperty("flex-shrink", "0", "important");
    hero.style.setProperty("overflow", "visible", "important");
    hero.style.setProperty("min-height", "auto", "important");
    hero.style.setProperty("height", "auto", "important");
  });
  await page.waitForTimeout(200);

  const after = await page.evaluate(() => {
    const hero = document.querySelector("#teamsDoctorModal .teams-doctor-hero");
    const img = document.querySelector("#teamsDoctorModal .teams-doctor-photo-img");
    const cs = getComputedStyle(hero);
    return {
      h: cs.height,
      flexShrink: cs.flexShrink,
      overflow: cs.overflow,
      heroRect: hero.getBoundingClientRect(),
      imgRect: img.getBoundingClientRect(),
      nameVisible: document.querySelector("#teamsDoctorModal .teams-doctor-fullname").getBoundingClientRect().height > 0
    };
  });

  console.log(JSON.stringify({ before, after }, null, 2));
  await page.screenshot({ path: "d:/PHP/htdocs/wsd/wp-content/themes/wsd/_debug-modal-fixed.png" });
  await browser.close();
})();
