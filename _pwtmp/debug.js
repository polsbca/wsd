const { chromium } = require("playwright");
(async () => {
  const browser = await chromium.launch({ headless: true });
  const context = await browser.newContext({
    viewport: { width: 390, height: 844 },
    deviceScaleFactor: 2,
    isMobile: true,
    hasTouch: true,
  });
  const page = await context.newPage();
  page.on("console", (msg) => console.log("CONSOLE", msg.type(), msg.text()));
  page.on("pageerror", (err) => console.log("PAGEERROR", err.message));

  await page.goto("http://wsd.localhost/teams/", { waitUntil: "networkidle", timeout: 60000 });
  await page.waitForTimeout(1500);

  const btn = page.locator(".js-doctor-modal-open").first();
  await btn.click();
  await page.waitForSelector("#teamsDoctorModal.show", { timeout: 10000 });
  await page.waitForTimeout(1000);

  const info = await page.evaluate(() => {
    const hero = document.querySelector("#teamsDoctorModal .teams-doctor-hero");
    const inner = document.querySelector("#teamsDoctorModal .teams-doctor-hero-inner");
    const copy = document.querySelector("#teamsDoctorModal .teams-doctor-hero-copy");
    const img = document.querySelector("#teamsDoctorModal .teams-doctor-photo-img");
    const name = document.querySelector("#teamsDoctorModal .teams-doctor-fullname");
    const ctas = document.querySelector("#teamsDoctorModal .teams-doctor-hero-ctas");
    const pick = (el) => {
      if (!el) return null;
      const cs = getComputedStyle(el);
      const r = el.getBoundingClientRect();
      return {
        tag: el.tagName,
        className: el.className,
        text: (el.textContent || "").trim().slice(0, 80),
        display: cs.display,
        visibility: cs.visibility,
        opacity: cs.opacity,
        position: cs.position,
        overflow: cs.overflow,
        width: cs.width,
        height: cs.height,
        maxHeight: cs.maxHeight,
        transform: cs.transform,
        zIndex: cs.zIndex,
        color: cs.color,
        fontSize: cs.fontSize,
        top: cs.top,
        left: cs.left,
        order: cs.order,
        rect: { x: r.x, y: r.y, w: r.width, h: r.height, top: r.top, bottom: r.bottom },
        htmlHidden: el.hidden,
        inline: el.getAttribute("style"),
      };
    };
    return {
      viewport: { w: window.innerWidth, h: window.innerHeight },
      hero: pick(hero),
      inner: pick(inner),
      copy: pick(copy),
      img: Object.assign(pick(img) || {}, {
        src: img && img.currentSrc,
        naturalWidth: img && img.naturalWidth,
        naturalHeight: img && img.naturalHeight,
        complete: img && img.complete,
      }),
      name: pick(name),
      ctas: pick(ctas),
      bodyScroll: document.querySelector("#teamsDoctorModal .teams-doctor-modal-body")?.scrollTop,
    };
  });

  console.log(JSON.stringify(info, null, 2));
  await page.screenshot({
    path: "d:/PHP/htdocs/wsd/wp-content/themes/wsd/_debug-modal-mobile.png",
    fullPage: false,
  });
  await browser.close();
})().catch((e) => {
  console.error(e);
  process.exit(1);
});
