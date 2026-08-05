const { chromium } = require("playwright");
(async () => {
  const browser = await chromium.launch({ headless: true });
  const context = await browser.newContext({ viewport: { width: 820, height: 1180 } });
  const page = await context.newPage();
  await page.goto("http://wsd.localhost/teams/?t=" + Date.now(), { waitUntil: "networkidle", timeout: 60000 });
  await page.locator(".js-doctor-modal-open").first().click();
  await page.waitForSelector("#teamsDoctorModal.show");
  await page.waitForTimeout(600);
  await page.evaluate(() => {
    const el = document.querySelector("#teamsDoctorResultsGallery");
    el?.scrollIntoView({ block: "start" });
    document.querySelector("#teamsDoctorModal .teams-doctor-modal-body").scrollTop =
      el.offsetTop - 20;
  });
  await page.waitForTimeout(400);
  const info = await page.evaluate(() => {
    const heading = document.querySelector("#teamsDoctorModal .teams-doctor-results-heading");
    const card = document.querySelector("#teamsDoctorModal .teams-doctor-result-card");
    const before = document.querySelector("#teamsDoctorModal .teams-doctor-result-image--before");
    const after = document.querySelector("#teamsDoctorModal .teams-doctor-result-image--after");
    const readmore = document.querySelector("#teamsDoctorModal .teams-doctor-result-readmore");
    const dots = document.querySelectorAll("#teamsDoctorModal .teams-doctor-results-dots .teams-slider-dot");
    const cs = getComputedStyle;
    return {
      headingText: heading?.innerText?.replace(/\s+/g, " ").trim(),
      patientColor: cs(document.querySelector(".teams-doctor-results-heading-patient")).color,
      accentColor: cs(document.querySelector(".teams-doctor-results-heading .teams-doctor-results-heading-accent")).color,
      card: { w: cs(card).width, h: cs(card).height },
      before: { w: cs(before).width, h: cs(before).height, left: cs(before).left, top: cs(before).top },
      after: { w: cs(after).width, h: cs(after).height, left: cs(after).left, top: cs(after).top },
      readmoreDisplay: cs(readmore).display,
      dotSize: dots[0] ? cs(dots[0]).width : null,
      dotCount: dots.length,
    };
  });
  console.log(JSON.stringify(info, null, 2));
  await page.screenshot({ path: "d:/PHP/htdocs/wsd/wp-content/themes/wsd/_debug-tablet-results.png" });
  await browser.close();
})();
