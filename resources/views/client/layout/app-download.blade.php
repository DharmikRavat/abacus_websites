<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>App Download Banner</title>
<style>
  :root{
    --yellow: #F4A012;
    --text-dark: #1F3971;
    --stripe-1: #4ecdc4;
    --stripe-2: #f5e64c;
    --stripe-3: #e8583a;
  }

  * { box-sizing: border-box; }

  body { margin: 0; }

  .banner {
    background: var(--yellow);
    padding: 40px 160px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 20px;
    position: relative;
    overflow: hidden;
    font-family: 'Poppins',sans-serif;
  }

  .banner::after{
    content: "";
    position: absolute;
    left: 0; right: 0; bottom: 0;
    height: 6px;
    background: linear-gradient(90deg, var(--stripe-1) 33.33%, var(--stripe-2) 33.33% 66.66%, var(--stripe-3) 66.66%);
  }

  .banner__title {
    color: var(--text-dark);
    font-size: clamp(22px, 4vw, 42px);
    font-weight: 500;
    margin: 0;
    white-space: nowrap;
  }

  .banner__badges {
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
  }

  .badge {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #000;
    color: #fff;
    border-radius: 8px;
    padding: 8px 18px;
    text-decoration: none;
    line-height: 1.15;
    white-space: nowrap;
  }

  .badge__icon { flex-shrink: 0; }
  .badge__icon svg { display: block; width: 32px; height: 32px; }

  .badge__text .eyebrow {
    display: block;
    font-size: 11px;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    opacity: 0.9;
  }

  .badge__text .store-name {
    display: block;
    font-size: 20px;
    font-family: Georgia, "Times New Roman", serif;
    font-weight: 500;
  }

  .badge--apple .badge__text .eyebrow { font-family: -apple-system, sans-serif; }

  /* Responsive breakpoints */
  @media (max-width: 700px) {
    .banner {
      justify-content: center;
      text-align: center;
      padding: 24px 20px;
    }
    .banner__title { white-space: normal; }
  }

  @media (max-width: 420px) {
    .badge { padding: 6px 12px; }
    .badge__text .store-name { font-size: 16px; }
    .badge__icon svg { width: 26px; height: 26px; }
  }
</style>
</head>
<body>

<div class="banner">
  <h2 class="banner__title">Bring Fun Life To Your Kids</h2>

  <div class="banner__badges">
    <a href="#" class="badge badge--google" aria-label="Get it on Google Play">
      <span class="badge__icon">
        <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
          <defs>
            <linearGradient id="g1" x1="0%" y1="0%" x2="100%" y2="100%">
              <stop offset="0%" stop-color="#63d9ff"/>
              <stop offset="100%" stop-color="#3ab6f8"/>
            </linearGradient>
            <linearGradient id="g2" x1="0%" y1="0%" x2="100%" y2="0%">
              <stop offset="0%" stop-color="#ffd200"/>
              <stop offset="100%" stop-color="#ff8a00"/>
            </linearGradient>
            <linearGradient id="g3" x1="0%" y1="0%" x2="100%" y2="100%">
              <stop offset="0%" stop-color="#ff4d5e"/>
              <stop offset="100%" stop-color="#c6206e"/>
            </linearGradient>
            <linearGradient id="g4" x1="0%" y1="0%" x2="100%" y2="100%">
              <stop offset="0%" stop-color="#25d97a"/>
              <stop offset="100%" stop-color="#0fae6a"/>
            </linearGradient>
          </defs>
          <path d="M68 32 L328 256 L68 480 Z" fill="url(#g1)"/>
          <path d="M68 32 L328 256 L400 220 L120 20 Z" fill="url(#g2)"/>
          <path d="M68 480 L328 256 L400 292 L120 492 Z" fill="url(#g3)"/>
          <path d="M328 256 L400 220 L470 256 L400 292 Z" fill="url(#g4)"/>
        </svg>
      </span>
      <span class="badge__text">
        <span class="eyebrow">Android app on</span>
        <span class="store-name">Google Play</span>
      </span>
    </a>

    <a href="#" class="badge badge--apple" aria-label="Download on the App Store">
      <span class="badge__icon">
        <svg viewBox="0 0 384 512" fill="#fff" xmlns="http://www.w3.org/2000/svg">
          <path d="M318.7 268.7c-.2-36.7 16.4-64.4 50-84.8-18.8-26.9-47.2-41.7-84.7-44.6-35.5-2.8-74.3 20.7-88.5 20.7-15 0-49.4-19.7-76.4-19.7C63.3 141 0 184.5 0 273.6c0 26.6 4.9 54.1 14.6 82.6 13 37.9 59.7 130.7 108.4 129.2 25.5-.6 43.5-18.1 76.7-18.1 32.2 0 48.8 18.1 77.3 18.1 49.2-.7 91.3-85.2 103.7-123.2-65.9-31.1-62-91.2-62-93.5zm-56.6-164.2c27.5-32.7 25-62.4 24.2-73.1-24.3 1.4-52.5 16.6-68.4 35.2-17.4 20-27.7 45.5-25.5 71.5 26.1 2 51.4-11.6 69.7-33.6z"/>
        </svg>
      </span>
      <span class="badge__text">
        <span class="eyebrow">Download on the</span>
        <span class="store-name">App Store</span>
      </span>
    </a>
  </div>
</div>

</body>
</html>