<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MS STUDIO</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background: #f5f1eb;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
      color: #1a1a1a;
      min-height: 100vh;
      overflow: hidden;
      cursor: default;
      transition: background 0.8s ease;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='2.5' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
      opacity: 0.015;
      pointer-events: none;
      z-index: 100;
    }

    /* Screen transition to next page */
    body.page-next {
      opacity: 0;
      transform: scale(0.98);
      filter: blur(10px);
      pointer-events: none;
      transition: opacity 1s cubic-bezier(0.25, 1, 0.5, 1),
                  transform 1s cubic-bezier(0.25, 1, 0.5, 1),
                  filter 1s cubic-bezier(0.25, 1, 0.5, 1);
    }

    /* Soft premium warm light halo in the center */
    .logo-halo {
      position: absolute;
      width: 450px;
      height: 450px;
      background: radial-gradient(circle, rgba(255, 255, 255, 0.8) 0%, rgba(245, 241, 235, 0) 70%);
      pointer-events: none;
      z-index: 1;
      opacity: 0;
      animation: halo-fade-in 2s ease-out forwards;
      animation-delay: 0.8s;
    }

    @keyframes halo-fade-in {
      0% { opacity: 0; transform: scale(0.8); }
      100% { opacity: 1; transform: scale(1); }
    }

    /* Main centered container */
    .logo-container {
      text-align: center;
      z-index: 10;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    /* Assembly Container */
    .lego-assembly {
      position: relative;
      width: 130px;
      height: 72px; /* 64px brick + 8px studs */
      margin-bottom: 2.5rem;
      filter: drop-shadow(0 8px 20px rgba(0,0,0,0.08));
      animation: snap-click 0.3s cubic-bezier(0.25, 1, 0.5, 1) forwards;
      animation-delay: 1.2s; /* Trigger exactly when all parts snap */
    }

    /* Sub-lego brick pieces styling (using white brick on warm cream background) */
    .sub-brick {
      position: absolute;
      width: 65px;
      height: 32px;
      background: #ffffff;
      border: 1px solid rgba(0, 0, 0, 0.08); /* Bevel effect during flight */
      box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.4), 0 2px 4px rgba(0,0,0,0.03);
      opacity: 0;
      transition: border-color 0.4s ease;
    }

    /* Outer rounded corners only - prevents inner gap notches upon merging */
    .sub-3 { border-radius: 1.5px 0 0 0; } /* Top-Left */
    .sub-4 { border-radius: 0 1.5px 0 0; } /* Top-Right */
    .sub-1 { border-radius: 0 0 0 1.5px; } /* Bottom-Left */
    .sub-2 { border-radius: 0 0 1.5px 0; } /* Bottom-Right */

    /* Studs styling */
    .sub-stud {
      position: absolute;
      width: 22px;
      height: 8px;
      background: #ffffff;
      border-radius: 1.5px 1.5px 0 0;
      border: 1px solid rgba(0, 0, 0, 0.08);
      border-bottom: none;
      opacity: 0;
      z-index: 2;
      transition: border-color 0.4s ease;
    }

    /* Sub-brick 1: Bottom-Left */
    .sub-1 {
      left: 0;
      top: 40px;
      animation: assemble-sub-1 1s cubic-bezier(0.25, 1, 0.5, 1) forwards;
      animation-delay: 0.2s;
    }

    /* Sub-brick 2: Bottom-Right */
    .sub-2 {
      left: 65px;
      top: 40px;
      animation: assemble-sub-2 1s cubic-bezier(0.25, 1, 0.5, 1) forwards;
      animation-delay: 0.3s;
    }

    /* Sub-brick 3: Top-Left */
    .sub-3 {
      left: 0;
      top: 8px;
      animation: assemble-sub-3 1s cubic-bezier(0.25, 1, 0.5, 1) forwards;
      animation-delay: 0.5s;
    }

    /* Sub-brick 4: Top-Right */
    .sub-4 {
      left: 65px;
      top: 8px;
      animation: assemble-sub-4 1s cubic-bezier(0.25, 1, 0.5, 1) forwards;
      animation-delay: 0.6s;
    }

    /* Stud 1: Left */
    .stud-1 {
      left: 20px;
      top: 0;
      animation: drop-stud-1 0.6s cubic-bezier(0.25, 1, 0.5, 1) forwards;
      animation-delay: 0.9s;
    }

    /* Stud 2: Right */
    .stud-2 {
      left: 88px;
      top: 0;
      animation: drop-stud-2 0.6s cubic-bezier(0.25, 1, 0.5, 1) forwards;
      animation-delay: 1.0s;
    }

    /* Shockwave ring that expands when studs land */
    .shockwave-ring {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%) scale(0.5);
      width: 130px;
      height: 72px;
      border: 1px solid rgba(26, 26, 26, 0.2);
      border-radius: 4px;
      opacity: 0;
      pointer-events: none;
      z-index: -1;
      animation: ring-expand 0.8s cubic-bezier(0.1, 0.8, 0.3, 1) forwards;
      animation-delay: 1.2s;
    }

    /* Animation Keyframes (animate border-color to #ffffff to disappear and merge completely) */
    @keyframes assemble-sub-1 {
      0% { transform: translate(-140px, 140px) rotate(-60deg) scale(0.8); opacity: 0; border-color: rgba(0, 0, 0, 0.08); }
      85% { border-color: rgba(0, 0, 0, 0.08); }
      100% { transform: translate(0, 0) rotate(0deg) scale(1); opacity: 1; border-color: #ffffff; }
    }

    @keyframes assemble-sub-2 {
      0% { transform: translate(140px, 140px) rotate(60deg) scale(0.8); opacity: 0; border-color: rgba(0, 0, 0, 0.08); }
      85% { border-color: rgba(0, 0, 0, 0.08); }
      100% { transform: translate(0, 0) rotate(0deg) scale(1); opacity: 1; border-color: #ffffff; }
    }

    @keyframes assemble-sub-3 {
      0% { transform: translate(-140px, -140px) rotate(-90deg) scale(0.8); opacity: 0; border-color: rgba(0, 0, 0, 0.08); }
      85% { border-color: rgba(0, 0, 0, 0.08); }
      100% { transform: translate(0, 0) rotate(0deg) scale(1); opacity: 1; border-color: #ffffff; }
    }

    @keyframes assemble-sub-4 {
      0% { transform: translate(140px, -140px) rotate(90deg) scale(0.8); opacity: 0; border-color: rgba(0, 0, 0, 0.08); }
      85% { border-color: rgba(0, 0, 0, 0.08); }
      100% { transform: translate(0, 0) rotate(0deg) scale(1); opacity: 1; border-color: #ffffff; }
    }

    @keyframes drop-stud-1 {
      0% { transform: translateY(-80px) scale(0.5); opacity: 0; border-color: rgba(0, 0, 0, 0.08); }
      80% { border-color: rgba(0, 0, 0, 0.08); }
      60% { transform: translateY(4px) scale(1.1); opacity: 1; }
      100% { transform: translateY(0) scale(1); opacity: 1; border-color: #ffffff; }
    }

    @keyframes drop-stud-2 {
      0% { transform: translateY(-80px) scale(0.5); opacity: 0; border-color: rgba(0, 0, 0, 0.08); }
      80% { border-color: rgba(0, 0, 0, 0.08); }
      60% { transform: translateY(4px) scale(1.1); opacity: 1; }
      100% { transform: translateY(0) scale(1); opacity: 1; border-color: #ffffff; }
    }

    /* General click/snap shock animation on the container */
    @keyframes snap-click {
      0% { transform: scale(1); filter: drop-shadow(0 8px 20px rgba(0,0,0,0.1)) brightness(1); }
      30% { transform: scale(1.06); filter: drop-shadow(0 12px 30px rgba(255, 255, 255, 0.8)) brightness(1.05); }
      100% { transform: scale(1); filter: drop-shadow(0 8px 24px rgba(0, 0, 0, 0.08)) brightness(1); }
    }

    @keyframes ring-expand {
      0% { transform: translate(-50%, -50%) scale(0.8); opacity: 0.6; }
      100% { transform: translate(-50%, -50%) scale(2.4); opacity: 0; filter: blur(5px); }
    }

    /* Logo Text styling with premium fade-in (Dark theme color) */
    .logo-text {
      font-size: 3.5rem;
      font-weight: 700;
      letter-spacing: 0.02em;
      margin-bottom: 0.75rem;
      background: linear-gradient(135deg, #1a1a1a 0%, #444444 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      opacity: 0;
      animation: text-reveal 1.4s cubic-bezier(0.25, 1, 0.5, 1) forwards;
      animation-delay: 1.3s;
    }

    .logo-subtitle {
      font-size: 0.8rem;
      letter-spacing: 0.25em;
      text-transform: uppercase;
      color: rgba(26, 26, 26, 0.6);
      font-weight: 500;
      opacity: 0;
      animation: text-reveal 1.6s cubic-bezier(0.25, 1, 0.5, 1) forwards;
      animation-delay: 1.5s;
    }

    @keyframes text-reveal {
      0% { opacity: 0; transform: translateY(12px); filter: blur(8px); }
      100% { opacity: 1; transform: translateY(0); filter: blur(0); }
    }
  </style>
</head>
<body>
  
  <div class="logo-halo"></div>

  <div class="logo-container">
    <!-- Assembly Lego Block -->
    <div class="lego-assembly">
      <!-- Studs -->
      <div class="sub-stud stud-1"></div>
      <div class="sub-stud stud-2"></div>
      <!-- Sub-bricks quarters -->
      <div class="sub-brick sub-3"></div> <!-- Top-Left -->
      <div class="sub-brick sub-4"></div> <!-- Top-Right -->
      <div class="sub-brick sub-1"></div> <!-- Bottom-Left -->
      <div class="sub-brick sub-2"></div> <!-- Bottom-Right -->
      <!-- Expansion ring -->
      <div class="shockwave-ring"></div>
    </div>

    <!-- Brand texts -->
    <div class="logo-text">MS STUDIO</div>
    <div class="logo-subtitle">Architecture & Design</div>
  </div>

  <script>
    // Automatic premium page transition after animation completes
    window.addEventListener('DOMContentLoaded', () => {
      setTimeout(() => {
        document.body.classList.add('page-next');
        setTimeout(() => {
          window.location.href = 'index.php?action=choice';
        }, 1000); 
      }, 4200); 
    });
  </script>
</body>
</html>