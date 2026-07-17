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
      background: #0a0a0a;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
      color: #ffffff;
      min-height: 100vh;
      overflow: hidden;
      cursor: default;
      transition: background 0.8s ease;
    }

    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='2.5' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
      opacity: 0.03;
      pointer-events: none;
      z-index: 100;
    }

    /* Léger mouvement de respiration permanent sur la scène */
    @keyframes breathing {
      0%, 100% { transform: translateY(0) scale(1); }
      50% { transform: translateY(-3px) scale(1.001); }
    }

    .scene {
      position: relative;
      width: 100vw;
      height: 100vh;
      overflow: hidden;
      animation: breathing 14s ease-in-out infinite;
      transition: opacity 1.2s cubic-bezier(0.25, 1, 0.5, 1), 
                  transform 1.2s cubic-bezier(0.25, 1, 0.5, 1), 
                  filter 1.2s cubic-bezier(0.25, 1, 0.5, 1);
    }

    body.page-next .scene {
      opacity: 0;
      transform: scale(0.97) translateY(-15px);
      filter: blur(12px);
      pointer-events: none;
    }

    /* Parallax layers */
    .parallax-layer {
      position: absolute;
      inset: 0;
      width: 100vw;
      height: 100vh;
      pointer-events: none;
      transition: transform 0.7s cubic-bezier(0.25, 1, 0.5, 1);
    }

    /* Background silhouettes sitting low */
    .bg-skyline-layer {
      z-index: 1;
      filter: blur(4px);
      opacity: 0.12;
    }

    .mid-skyline-layer {
      z-index: 2;
      filter: blur(1.2px);
      opacity: 0.28;
    }

    .skyline-svg {
      width: 100%;
      height: 60vh; /* Taller architectural presence (30-40% taller) */
      position: absolute;
      bottom: 7vh; /* Lowered by ~50px (from 12vh to 7vh) */
      left: 0;
    }

    /* Atmosphere, halo and fog */
    .atmosphere-halo {
      position: absolute;
      inset: 0;
      background: radial-gradient(circle at 50% 45%, rgba(255, 255, 255, 0.012) 0%, rgba(0, 0, 0, 0) 65%);
      pointer-events: none;
      z-index: 0;
    }

    .atmosphere-fog {
      position: absolute;
      bottom: 7vh; /* Lowered by ~50px */
      left: 0;
      width: 100%;
      height: 140px;
      background: linear-gradient(to top, #0a0a0a 0%, rgba(10,10,10,0) 100%);
      pointer-events: none;
      z-index: 4;
      opacity: 0.9;
    }

    /* Large, discrete dark ground-slab shifted down by ~50px */
    .ground-slab {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 13vh; /* Shifted down from 18vh to 13vh */
      background: linear-gradient(to bottom, #0d0d0d 0%, #050505 100%);
      border-top: 1px solid rgba(255,255,255,0.04);
      z-index: 5;
      overflow: hidden;
    }
    
    .ground-slab-texture {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      opacity: 0.03;
      background-image: 
        linear-gradient(90deg, rgba(255,255,255,0.1) 1px, transparent 1px),
        linear-gradient(to bottom, rgba(255,255,255,0.05) 1px, transparent 1px);
      background-size: 60px 15px;
    }

    .ground-slab-reflet {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: radial-gradient(ellipse at 50% 0%, rgba(255, 255, 255, 0.008) 0%, rgba(255, 255, 255, 0) 70%);
      pointer-events: none;
    }

    .ground-slab-warm-reflection {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: radial-gradient(ellipse at 34vw 0%, rgba(255, 200, 110, 0.04) 0%, rgba(255, 200, 110, 0) 50%);
      opacity: 0;
      pointer-events: none;
      transition: opacity 2s cubic-bezier(0.25, 1, 0.5, 1);
    }
    
    body.completed-active .ground-slab-warm-reflection {
      opacity: 1;
    }

    /* Minimalist park elements - clustered strictly around logo baseline (shifted down to 13vh) */
    .ground-layer {
      z-index: 6;
    }

    .minimal-tree {
      position: absolute;
      bottom: 13vh; /* Resting on the top of the shifted slab */
      display: flex;
      flex-direction: column;
      align-items: center;
      transform-origin: bottom center;
      animation: sway-slow 9s ease-in-out infinite alternate;
      z-index: 7;
    }

    .tree-trunk {
      width: 1px;
      background: rgba(255, 255, 255, 0.15);
    }

    .tree-foliage {
      background: rgba(255, 255, 255, 0.03);
      border: 1px solid rgba(255, 255, 255, 0.08);
    }

    @keyframes sway-slow {
      0% { transform: rotate(-0.6deg); }
      100% { transform: rotate(0.8deg); }
    }

    .minimal-lamp {
      position: absolute;
      bottom: 13vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      z-index: 7;
    }

    .lamp-post {
      width: 1px;
      background: rgba(255, 255, 255, 0.16);
    }

    .lamp-light {
      position: absolute;
      top: 0;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 4px;
      height: 4px;
      background: #ffd28c;
      border-radius: 50%;
      box-shadow: 0 0 5px #ffd28c, 0 0 10px rgba(255, 210, 140, 0.25);
      animation: lamp-glow 4s ease-in-out infinite alternate;
    }

    @keyframes lamp-glow {
      0%, 100% { opacity: 0.8; box-shadow: 0 0 5px #ffd28c, 0 0 10px rgba(255, 210, 140, 0.25); }
      50% { opacity: 0.95; box-shadow: 0 0 8px #ffd28c, 0 0 14px rgba(255, 210, 140, 0.4); }
    }

    .minimal-bench {
      position: absolute;
      bottom: 13vh;
      width: 20px;
      height: 4px;
      pointer-events: none;
      z-index: 7;
    }
    
    .bench-seat {
      width: 100%;
      height: 1px;
      background: rgba(255, 255, 255, 0.2);
    }
    
    .bench-leg {
      position: absolute;
      top: 1px;
      width: 1px;
      height: 3px;
      background: rgba(255, 255, 255, 0.12);
    }
    .bench-leg.left { left: 3px; }
    .bench-leg.right { right: 3px; }

    /* Crane silhouette near the tower building - shifted down by ~50px */
    .minimal-crane {
      position: absolute;
      left: 26vw;
      bottom: 7vh; /* Lowered from 12vh to 7vh */
      z-index: 3;
      pointer-events: none;
      opacity: 0.1;
      transform-origin: bottom center;
    }
    
    .crane-mast {
      width: 1.5px;
      height: 280px;
      background: rgba(255,255,255,0.4);
    }
    
    .crane-jib {
      position: absolute;
      top: 30px;
      left: -35px;
      width: 110px;
      height: 1.5px;
      background: rgba(255,255,255,0.4);
    }
    
    .crane-counterweight {
      position: absolute;
      top: 27px;
      left: -25px;
      width: 8px;
      height: 5px;
      background: rgba(255,255,255,0.3);
    }
    
    .crane-cable {
      position: absolute;
      top: 31px;
      right: 25px;
      width: 0.5px;
      height: 90px;
      background: rgba(255,255,255,0.25);
    }

    /* Foreground Interactive layers */
    /* Tower is now integrated in the midground city (z-index: 3) */
    .tower-layer {
      z-index: 3;
    }

    .logo-layer {
      z-index: 10;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .tower-container {
      position: absolute;
      left: 34vw; /* Replacing a building near the logo */
      bottom: 7vh; /* Shifted down to 7vh */
      padding-bottom: 0px; 
      pointer-events: auto;
    }

    .tower-label {
      font-size: 0.65rem;
      text-transform: uppercase;
      letter-spacing: 0.2em;
      color: rgba(255,255,255,0.2);
      margin-bottom: 2rem;
      text-align: center;
      font-weight: 500;
      opacity: 0.8;
    }

    .tower {
      display: flex;
      flex-direction: column;
      gap: 0px; /* Perfect emboitement! No gaps */
      align-items: center;
      filter: drop-shadow(0 15px 30px rgba(0,0,0,0.6));
      transition: transform 0.3s ease;
    }

    /* Shake animation on snap */
    @keyframes tower-shake {
      0%, 100% { transform: scale(1); }
      20%, 80% { transform: translateX(-1.5px); }
      40%, 60% { transform: translateX(1.5px); }
    }

    .tower.shake {
      animation: tower-shake 0.25s cubic-bezier(.36,.07,.19,.97) both;
    }

    /* Styled Flat Lego bricks matching logo-ms-studio.jpg */
    .lego-brick,
    .draggable-brick {
      width: 130px;
      height: 64px;
      background: #ffffff;
      border-radius: 1.5px;
      position: relative;
      box-shadow: 
        inset 0 1px 0 rgba(255,255,255,0.15),
        0 8px 20px rgba(0,0,0,0.3);
    }

    .lego-brick {
      transition: all 0.6s cubic-bezier(0.25, 1, 0.5, 1);
    }

    .lego-brick-studs,
    .draggable-brick-studs {
      position: absolute;
      top: -8px;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
      gap: 34px;
      z-index: 1;
    }

    .lego-stud {
      width: 22px;
      height: 8px;
      background: #ffffff;
      border-radius: 1.5px 1.5px 0 0;
      transition: background 0.6s ease;
    }

    /* CSS logic to hide intermediate studs for building illusion */
    .lego-brick .lego-brick-studs {
      display: none;
    }
    .missing-slot + .lego-brick .lego-brick-studs {
      display: flex; /* Sticking up into the empty slot */
    }
    .tower .lego-brick:first-child .lego-brick-studs,
    .missing-slot .lego-brick .lego-brick-studs {
      display: flex; /* Topmost completes the building */
    }

    /* Windows style with realistic recess */
    .lego-brick-windows {
      position: absolute;
      inset: 14px 16px;
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 12px;
      opacity: 0;
      transition: opacity 0.6s ease;
    }

    .window {
      position: relative;
      border-radius: 1px;
      background: rgba(10, 10, 10, 0.08);
      border: 1px solid rgba(10, 10, 10, 0.12);
      overflow: hidden;
      opacity: 0;
      transition: all 0.8s cubic-bezier(0.25, 1, 0.5, 1);
    }

    /* Frame effect */
    .window::before {
      content: '';
      position: absolute;
      inset: 0;
      border: 1px solid rgba(255,255,255,0.12);
      border-radius: 1px;
      pointer-events: none;
      opacity: 0;
      transition: opacity 0.8s ease;
    }

    .window.lit::before {
      opacity: 1;
    }

    /* Divider horizontal */
    .window::after {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 100%;
      height: 1px;
      background: rgba(180, 180, 185, 0.2);
      opacity: 0;
      transition: opacity 0.8s ease;
    }

    .window.lit::after {
      opacity: 1;
    }

    /* Vertical divider */
    .window-divider {
      position: absolute;
      top: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 1px;
      height: 100%;
      background: rgba(180, 180, 185, 0.2);
      opacity: 0;
      transition: opacity 0.8s ease;
    }

    .window.lit .window-divider {
      opacity: 1;
    }

    /* Warm Organic glow */
    .window.lit {
      opacity: 1;
      background: linear-gradient(135deg, 
        rgba(255, 222, 155, 1) 0%, 
        rgba(255, 205, 120, 1) 100%);
      border: 1px solid rgba(255, 215, 140, 0.6);
      box-shadow: 
        0 0 12px rgba(255, 210, 130, 0.6),
        0 0 30px rgba(255, 210, 130, 0.3),
        inset 0 0 6px rgba(255, 255, 255, 0.2);
      transform: translateY(-0.5px);
    }

    /* Temporary flicker state */
    .window.lit-temp {
      background: rgba(255, 220, 160, 0.7);
      border-color: rgba(255, 220, 160, 0.4);
      box-shadow: 0 0 10px rgba(255, 220, 160, 0.35);
    }

    .tower.completed .lego-brick-windows {
      opacity: 1;
    }

    /* Human silhouette */
    .window-person {
      position: absolute;
      bottom: 5px;
      left: 50%;
      transform: translateX(-50%) scale(0);
      width: 16px;
      height: 24px;
      opacity: 0;
      transition: all 1.2s cubic-bezier(0.25, 1, 0.5, 1);
    }

    .window.lit.has-person .window-person {
      transform: translateX(-50%) scale(1);
      opacity: 0.85;
    }

    .person-head {
      position: absolute;
      top: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 6px;
      height: 6px;
      background: rgba(25, 25, 35, 0.9);
      border-radius: 50%;
    }

    .person-eyes {
      position: absolute;
      top: 2px;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
      gap: 2px;
      opacity: 0;
      transition: opacity 0.6s ease;
    }

    .window.lit.has-person .person-eyes {
      opacity: 1;
      transition-delay: 1s;
    }

    .person-eye {
      width: 1.5px;
      height: 1.5px;
      background: rgba(255, 255, 255, 0.9);
      border-radius: 50%;
    }

    .person-body {
      position: absolute;
      top: 6px;
      left: 50%;
      transform: translateX(-50%);
      width: 8px;
      height: 12px;
      background: rgba(25, 25, 35, 0.85);
      border-radius: 1px;
    }

    .person-legs {
      position: absolute;
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 8px;
      height: 6px;
      display: flex;
      gap: 1px;
      justify-content: center;
    }

    .person-leg {
      width: 3.5px;
      height: 6px;
      background: rgba(25, 25, 35, 0.8);
      border-radius: 1px;
    }

    @keyframes subtleMove {
      0%, 100% { transform: translateX(-50%) translateY(0); }
      50% { transform: translateX(-50%) translateY(0.8px); }
    }

    @keyframes blink {
      0%, 90%, 100% { opacity: 1; }
      95% { opacity: 0; }
    }

    .window.lit.has-person .window-person {
      animation: subtleMove 4s ease-in-out infinite;
      animation-delay: 1.5s;
    }

    .window.lit.has-person .person-eyes {
      animation: blink 5s ease-in-out infinite;
      animation-delay: 2.5s;
    }

    .missing-slot {
      width: 130px;
      height: 64px;
      border: 1px dashed rgba(255,255,255,0.12);
      border-radius: 1.5px;
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.4s cubic-bezier(0.25, 1, 0.5, 1);
      background: rgba(255,255,255,0.01);
    }

    .missing-slot.drag-over {
      border-color: rgba(255,255,255,0.4);
      background: rgba(255,255,255,0.06);
      transform: scale(1.02);
    }

    .missing-slot-hint {
      font-size: 0.65rem;
      color: rgba(255,255,255,0.2);
      letter-spacing: 0.15em;
      text-transform: uppercase;
      font-weight: 500;
    }

    .logo-container {
      position: absolute;
      left: 50%;
      top: 50%; /* Strictly centered vertically */
      transform: translate(-50%, -50%); /* Strictly centered */
      text-align: center;
      pointer-events: auto;
    }

    /* Draggable brick - weight, physics feel */
    .draggable-brick {
      margin: 0 auto 2.5rem; /* Restored to original size */
      cursor: grab;
      box-shadow: 
        inset 0 1px 0 rgba(255,255,255,0.2),
        0 8px 24px rgba(0,0,0,0.5);
      transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1), 
                  box-shadow 0.4s cubic-bezier(0.25, 1, 0.5, 1),
                  opacity 0.4s ease;
    }

    .draggable-brick:hover {
      transform: translateY(-6px) scale(1.02);
      box-shadow: 
        inset 0 1px 0 rgba(255,255,255,0.25),
        0 15px 35px rgba(0,0,0,0.6);
    }

    .draggable-brick.dragging {
      cursor: grabbing;
      opacity: 0.9;
      transform: scale(1.04) rotate(3deg); 
      z-index: 1000;
    }

    /* Fall and bounce physical entrance animation */
    @keyframes fallAndBounce {
      0% {
        transform: translateY(-100vh) rotate(-18deg);
        opacity: 0;
      }
      55% {
        transform: translateY(12px) rotate(3deg);
        opacity: 1;
      }
      70% {
        transform: translateY(-20px) rotate(-1.5deg);
      }
      85% {
        transform: translateY(5px) rotate(0.8deg);
      }
      100% {
        transform: translateY(0) rotate(0deg);
      }
    }
    
    .draggable-brick.entrance-anim {
      animation: fallAndBounce 1.5s cubic-bezier(0.25, 0.46, 0.45, 0.94) both;
    }

    /* Restored logo proportions */
    .logo-text {
      font-size: 3.5rem; /* Restored to original */
      font-weight: 700;
      letter-spacing: 0.02em;
      margin-bottom: 0.75rem;
      background: linear-gradient(135deg, #ffffff 0%, #a0a0a0 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .logo-subtitle {
      font-size: 0.8rem; /* Restored to original */
      letter-spacing: 0.25em;
      text-transform: uppercase;
      color: rgba(255,255,255,0.4);
      font-weight: 500;
    }

    .instructions {
      position: absolute;
      bottom: 6vh;
      left: 50%;
      transform: translateX(-50%);
      font-size: 0.7rem;
      color: rgba(255,255,255,0.2);
      letter-spacing: 0.15em;
      text-transform: uppercase;
      text-align: center;
      font-weight: 500;
      transition: opacity 0.8s ease, transform 0.8s ease;
      z-index: 15;
    }

    body.page-next .instructions {
      opacity: 0;
      transform: translate(-50%, 8px);
    }

    @keyframes pulse {
      0%, 100% { 
        border-color: rgba(255,255,255,0.1);
        box-shadow: 0 0 0 0 rgba(255,255,255,0);
      }
      50% { 
        border-color: rgba(255,255,255,0.25);
        box-shadow: 0 0 0 10px rgba(255,255,255,0.03);
      }
    }

    .missing-slot {
      animation: pulse 3s ease-in-out infinite;
    }

    @media (max-width: 900px) {
      .tower-container {
        left: 20vw;
        bottom: 7vh;
        transform: scale(0.85);
        transform-origin: bottom left;
      }
      .logo-container {
        transform: translate(-50%, -50%) scale(0.85);
      }
      .logo-text {
        font-size: 3rem;
      }
      .minimal-crane {
        left: 32vw;
        transform: scale(0.8);
        transform-origin: bottom center;
      }
    }

    @media (max-width: 480px) {
      .tower-container {
        left: 15vw;
        transform: scale(0.7);
      }
      .logo-container {
        transform: translate(-50%, -50%) scale(0.7);
      }
      .logo-text {
        font-size: 2.4rem;
      }
      .minimal-crane {
        left: 26vw;
        transform: scale(0.65);
      }
    }
  </style>
</head>
<body>
  <!-- Atmosphere components -->
  <div class="atmosphere-halo"></div>
  
  <div class="scene" id="scene">
    
    <!-- 1. Background Skyline (Far layer - darker, slender, minimalist rect volumes, closely spaced, 30-40% taller & slightly wider) -->
    <div class="parallax-layer bg-skyline-layer" data-speed="0.02">
      <svg class="skyline-svg" preserveAspectRatio="none" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
        <rect x="4%" y="15%" width="7%" height="85%" fill="#121212" />
        <rect x="10%" y="28%" width="7.5%" height="72%" fill="#121212" />
        <rect x="16%" y="8%" width="8%" height="92%" fill="#121212" />
        <rect x="23%" y="22%" width="7.5%" height="78%" fill="#121212" />
        <rect x="29%" y="5%" width="8%" height="95%" fill="#121212" />
        <rect x="36%" y="18%" width="7.5%" height="82%" fill="#121212" />
        <rect x="42%" y="12%" width="8%" height="88%" fill="#121212" />
        <rect x="49%" y="25%" width="7.5%" height="75%" fill="#121212" />
        <rect x="55%" y="3%" width="8%" height="97%" fill="#121212" />
        <rect x="62%" y="15%" width="7.5%" height="85%" fill="#121212" />
        <rect x="68%" y="8%" width="8%" height="92%" fill="#121212" />
        <rect x="75%" y="22%" width="7.5%" height="78%" fill="#121212" />
        <rect x="81%" y="10%" width="8%" height="90%" fill="#121212" />
        <rect x="88%" y="28%" width="7.5%" height="72%" fill="#121212" />
        <rect x="94%" y="15%" width="7.5%" height="85%" fill="#121212" />
      </svg>
    </div>

    <!-- 2. Midground Skyline (Middle layer - front, simple rect volumes, closely spaced, with space for Tower at 34vw) -->
    <div class="parallax-layer mid-skyline-layer" data-speed="0.05">
      <svg class="skyline-svg" preserveAspectRatio="none" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
        <rect x="2%" y="35%" width="8.5%" height="65%" fill="#1a1a1a" />
        <rect x="9%" y="42%" width="9%" height="58%" fill="#1a1a1a" />
        <rect x="16%" y="28%" width="8.5%" height="72%" fill="#1a1a1a" />
        <rect x="24%" y="45%" width="9%" height="55%" fill="#1a1a1a" />
        <!-- Lego Tower replaces the building from x=34% to 41.5% -->
        <rect x="42%" y="48%" width="9%" height="52%" fill="#1a1a1a" />
        <rect x="50%" y="22%" width="8.5%" height="78%" fill="#1a1a1a" />
        <rect x="57%" y="40%" width="9%" height="60%" fill="#1a1a1a" />
        <rect x="65%" y="45%" width="8.5%" height="55%" fill="#1a1a1a" />
        <rect x="72%" y="20%" width="9%" height="80%" fill="#1a1a1a" />
        <rect x="80%" y="38%" width="8.5%" height="62%" fill="#1a1a1a" />
        <rect x="87%" y="28%" width="9%" height="72%" fill="#1a1a1a" />
        <rect x="94%" y="35%" width="8.5%" height="65%" fill="#1a1a1a" />
      </svg>
    </div>

    <!-- Crane silhouette - locked to the midground parallax layer speed -->
    <div class="parallax-layer mid-skyline-layer" data-speed="0.05">
      <div class="minimal-crane">
        <div class="crane-mast"></div>
        <div class="crane-jib"></div>
        <div class="crane-counterweight"></div>
        <div class="crane-cable"></div>
      </div>
    </div>

    <!-- Atmospheric fog separating plans -->
    <div class="atmosphere-fog"></div>

    <!-- 3. Ground & Park Layer (First plan, sitting on the slab) -->
    <div class="parallax-layer ground-layer" data-speed="0.08">
      
      <!-- Park elements clustered strictly around logo baseline (approx 50vw area) -->
      <!-- Tree 1 -->
      <div class="minimal-tree" style="left: 41vw; animation-delay: 0.1s;">
        <div class="tree-trunk" style="height: 22px;"></div>
        <div class="tree-foliage" style="width: 10px; height: 10px; border-radius: 50%;"></div>
      </div>
      <!-- Tree 2 -->
      <div class="minimal-tree" style="left: 43vw; animation-delay: 0.7s;">
        <div class="tree-trunk" style="height: 14px;"></div>
        <div class="tree-foliage" style="width: 7px; height: 7px; border-radius: 0; transform: rotate(45deg);"></div>
      </div>
      
      <!-- Minimalist bench left -->
      <div class="minimal-bench" style="left: 42vw;">
        <div class="bench-seat"></div>
        <div class="bench-leg left"></div>
        <div class="bench-leg right"></div>
      </div>

      <!-- Lamp left -->
      <div class="minimal-lamp" style="left: 44.5vw;">
        <div class="lamp-post" style="height: 28px;"></div>
        <div class="lamp-light"></div>
      </div>

      <!-- Tree 3 -->
      <div class="minimal-tree" style="left: 55.5vw; animation-delay: 0.4s;">
        <div class="tree-trunk" style="height: 18px;"></div>
        <div class="tree-foliage" style="width: 8px; height: 8px; border-radius: 50%;"></div>
      </div>
      <!-- Tree 4 -->
      <div class="minimal-tree" style="left: 58vw; animation-delay: 1.1s;">
        <div class="tree-trunk" style="height: 24px;"></div>
        <div class="tree-foliage" style="width: 12px; height: 12px; border-radius: 50%;"></div>
      </div>
      
      <!-- Minimalist bench right -->
      <div class="minimal-bench" style="left: 56.5vw;">
        <div class="bench-seat"></div>
        <div class="bench-leg left"></div>
        <div class="bench-leg right"></div>
      </div>
      
      <!-- Lamp right -->
      <div class="minimal-lamp" style="left: 55vw;">
        <div class="lamp-post" style="height: 30px;"></div>
        <div class="lamp-light" style="animation-delay: 1.5s;"></div>
      </div>
    </div>

    <!-- 4. Tower Layer (Integrated into Skyline z-index context) -->
    <div class="parallax-layer tower-layer" data-speed="0.05">
      <div class="tower-container">
        <div class="tower-label">En Construction</div>
        <div class="tower" id="tower">
          <div class="missing-slot" id="dropZone">
            <span class="missing-slot-hint">Glissez ici</span>
          </div>

          <!-- Brick 4 -->
          <div class="lego-brick">
            <div class="lego-brick-studs">
              <div class="lego-stud"></div>
              <div class="lego-stud"></div>
            </div>
            <div class="lego-brick-windows">
              <div class="window">
                <div class="window-divider"></div>
              </div>
              <div class="window">
                <div class="window-divider"></div>
              </div>
            </div>
          </div>

          <!-- Brick 3 (with person) -->
          <div class="lego-brick">
            <div class="lego-brick-studs">
              <div class="lego-stud"></div>
              <div class="lego-stud"></div>
            </div>
            <div class="lego-brick-windows">
              <div class="window">
                <div class="window-divider"></div>
              </div>
              <div class="window">
                <div class="window-divider"></div>
                <div class="window-person">
                  <div class="person-head">
                    <div class="person-eyes">
                      <div class="person-eye"></div>
                      <div class="person-eye"></div>
                    </div>
                  </div>
                  <div class="person-body"></div>
                  <div class="person-legs">
                    <div class="person-leg"></div>
                    <div class="person-leg"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Brick 2 -->
          <div class="lego-brick">
            <div class="lego-brick-studs">
              <div class="lego-stud"></div>
              <div class="lego-stud"></div>
            </div>
            <div class="lego-brick-windows">
              <div class="window">
                <div class="window-divider"></div>
              </div>
              <div class="window">
                <div class="window-divider"></div>
              </div>
            </div>
          </div>

          <!-- Brick 1 (base) -->
          <div class="lego-brick">
            <div class="lego-brick-studs">
              <div class="lego-stud"></div>
              <div class="lego-stud"></div>
            </div>
            <div class="lego-brick-windows">
              <div class="window">
                <div class="window-divider"></div>
              </div>
              <div class="window">
                <div class="window-divider"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- 5. Logo & Draggable Layer (Centered vertically & horizontally relative to viewport) -->
    <div class="parallax-layer logo-layer" data-speed="0.10">
      <div class="logo-container">
        <!-- Placeholder to maintain space when dragging -->
        <div id="logoBrickPlaceholder" style="width: 130px; height: 64px; margin: 0 auto 2.5rem; display: none;"></div>
        
        <div class="draggable-brick" id="dragBrick" draggable="true">
          <div class="draggable-brick-studs">
            <div class="lego-stud"></div>
            <div class="lego-stud"></div>
          </div>
        </div>
        <div class="logo-text">MS STUDIO</div>
        <div class="logo-subtitle">Architecture & Design</div>
      </div>
    </div>

    <div class="instructions">
      Glissez la brique vers la tour
    </div>
  </div>

  <!-- Large discrete dark ground-slab cutting off background building bottoms (shifted down) -->
  <div class="ground-slab" style="pointer-events: none;">
    <div class="ground-slab-texture"></div>
    <div class="ground-slab-reflet"></div>
    <div class="ground-slab-warm-reflection"></div>
  </div>

  <script>
    const dragBrick = document.getElementById('dragBrick');
    const dropZone = document.getElementById('dropZone');
    const tower = document.getElementById('tower');
    const placeholder = document.getElementById('logoBrickPlaceholder');

    let isDragging = false;
    let offsetX, offsetY;

    // Entrance animation trigger
    window.addEventListener('DOMContentLoaded', () => {
      dragBrick.classList.add('entrance-anim');
      setTimeout(() => {
        dragBrick.classList.remove('entrance-anim');
      }, 1500);
    });

    // Mouse Parallax effect with premium transitions
    document.addEventListener('mousemove', (e) => {
      if (window.innerWidth < 768) return; // Disable parallax on mobile
      
      const mouseX = (e.clientX - window.innerWidth / 2) / (window.innerWidth / 2);
      const mouseY = (e.clientY - window.innerHeight / 2) / (window.innerHeight / 2);
      
      document.querySelectorAll('.parallax-layer').forEach(layer => {
        const speed = parseFloat(layer.getAttribute('data-speed')) || 0.1;
        const xOffset = mouseX * speed * 25; 
        const yOffset = mouseY * speed * 15;
        
        layer.style.transform = `translate(${xOffset}px, ${yOffset}px)`;
      });
    });

    // Mouse Drag-and-drop mechanics (No teleportation bug)
    dragBrick.addEventListener('mousedown', (e) => {
      isDragging = true;
      dragBrick.classList.add('dragging');

      const rect = dragBrick.getBoundingClientRect();
      offsetX = e.clientX - rect.left;
      offsetY = e.clientY - rect.top;

      // Maintain space in logo-container
      placeholder.style.display = 'block';

      // Switch style to fixed positioned relative to viewport
      dragBrick.style.position = 'fixed';
      dragBrick.style.left = rect.left + 'px';
      dragBrick.style.top = rect.top + 'px';
      dragBrick.style.width = rect.width + 'px';
      dragBrick.style.height = rect.height + 'px';
      dragBrick.style.zIndex = '1000';
      dragBrick.style.pointerEvents = 'none';
      dragBrick.style.margin = '0'; // reset margins

      // Append directly to body to avoid transformed containing block jumps
      document.body.appendChild(dragBrick);

      moveBrick(e.clientX, e.clientY);
    });

    document.addEventListener('mousemove', (e) => {
      if (isDragging) {
        moveBrick(e.clientX, e.clientY);
        checkDropZone(e.clientX, e.clientY);
      }
    });

    document.addEventListener('mouseup', (e) => {
      if (isDragging) {
        isDragging = false;
        dragBrick.classList.remove('dragging');

        if (isOverDropZone(e.clientX, e.clientY)) {
          completeTower();
        } else {
          resetBrick();
        }
      }
    });

    // Touch support (No teleportation bug)
    dragBrick.addEventListener('touchstart', (e) => {
      const touch = e.touches[0];
      isDragging = true;
      dragBrick.classList.add('dragging');

      const rect = dragBrick.getBoundingClientRect();
      offsetX = touch.clientX - rect.left;
      offsetY = touch.clientY - rect.top;

      placeholder.style.display = 'block';

      dragBrick.style.position = 'fixed';
      dragBrick.style.left = rect.left + 'px';
      dragBrick.style.top = rect.top + 'px';
      dragBrick.style.width = rect.width + 'px';
      dragBrick.style.height = rect.height + 'px';
      dragBrick.style.zIndex = '1000';
      dragBrick.style.pointerEvents = 'none';
      dragBrick.style.margin = '0';

      document.body.appendChild(dragBrick);

      moveBrick(touch.clientX, touch.clientY);
    });

    document.addEventListener('touchmove', (e) => {
      if (isDragging) {
        const touch = e.touches[0];
        moveBrick(touch.clientX, touch.clientY);
        checkDropZone(touch.clientX, touch.clientY);
      }
    });

    document.addEventListener('touchend', (e) => {
      if (isDragging) {
        const touch = e.changedTouches[0];
        isDragging = false;
        dragBrick.classList.remove('dragging');

        if (isOverDropZone(touch.clientX, touch.clientY)) {
          completeTower();
        } else {
          resetBrick();
        }
      }
    });

    function moveBrick(x, y) {
      dragBrick.style.left = (x - offsetX) + 'px';
      dragBrick.style.top = (y - offsetY) + 'px';
    }

    function isOverDropZone(x, y) {
      const dropRect = dropZone.getBoundingClientRect();
      return (
        x >= dropRect.left &&
        x <= dropRect.right &&
        y >= dropRect.top &&
        y <= dropRect.bottom
      );
    }

    function checkDropZone(x, y) {
      if (isOverDropZone(x, y)) {
        dropZone.classList.add('drag-over');
      } else {
        dropZone.classList.remove('drag-over');
      }
    }

    function completeTower() {
      const dropRect = dropZone.getBoundingClientRect();
      dragBrick.style.transition = 'all 0.5s cubic-bezier(0.25, 1, 0.5, 1)';
      dragBrick.style.left = dropRect.left + 'px';
      dragBrick.style.top = dropRect.top + 'px';
      dragBrick.style.transform = 'scale(1) rotate(0deg)';

      setTimeout(() => {
        dropZone.innerHTML = '';
        dropZone.style.border = 'none';
        dropZone.style.animation = 'none';
        dropZone.style.background = 'transparent';

        const newBrick = document.createElement('div');
        newBrick.className = 'lego-brick';
        newBrick.innerHTML = `
          <div class="lego-brick-studs">
            <div class="lego-stud"></div>
            <div class="lego-stud"></div>
          </div>
          <div class="lego-brick-windows">
            <div class="window">
              <div class="window-divider"></div>
            </div>
            <div class="window">
              <div class="window-divider"></div>
            </div>
          </div>
        `;
        dropZone.appendChild(newBrick);

        dragBrick.style.opacity = '0';

        setTimeout(() => {
          // Trigger micro vibration on snap
          tower.classList.add('shake');
          setTimeout(() => tower.classList.remove('shake'), 250);

          tower.classList.add('completed');
          document.body.classList.add('completed-active'); // Triggers warm reflection on ground slab
          lightUpWindows();
        }, 150);

        // Smooth transition to choice page
        setTimeout(() => {
          document.body.classList.add('page-next');
          setTimeout(() => {
            window.location.href = 'index.php?action=choice';
          }, 1200); 
        }, 3400);
      }, 500);
    }

    function lightUpWindows() {
      const allWindows = tower.querySelectorAll('.window');
      const windowsArray = Array.from(allWindows);

      // Randomly light up 3 windows with organic stagger and flicker
      const numLitWindows = 3;
      const shuffled = windowsArray.sort(() => Math.random() - 0.5);
      const selectedWindows = shuffled.slice(0, numLitWindows);

      selectedWindows.forEach((window, index) => {
        const staggerDelay = index * 350 + Math.random() * 200;

        setTimeout(() => {
          flickerWindow(window, () => {
            window.classList.add('lit');

            // Fade in person silhouette organically
            if (window.querySelector('.window-person')) {
              setTimeout(() => {
                window.classList.add('has-person');
              }, 400);
            }
          });
        }, staggerDelay);
      });
    }

    function flickerWindow(windowEl, callback) {
      const flickers = [40, 80, 50, 100]; 
      let count = 0;
      
      function nextFlicker() {
        if (count >= flickers.length) {
          callback();
          return;
        }
        
        if (count % 2 === 0) {
          windowEl.classList.add('lit-temp');
        } else {
          windowEl.classList.remove('lit-temp');
        }
        
        setTimeout(() => {
          count++;
          nextFlicker();
        }, flickers[count]);
      }
      
      nextFlicker();
    }

    function resetBrick() {
      dragBrick.style.transition = 'all 0.5s cubic-bezier(0.25, 1, 0.5, 1)';
      
      // Calculate original placeholder positions relative to viewport
      const targetRect = placeholder.getBoundingClientRect();
      dragBrick.style.left = targetRect.left + 'px';
      dragBrick.style.top = targetRect.top + 'px';
      dragBrick.style.transform = 'scale(1) rotate(0deg)';

      setTimeout(() => {
        dragBrick.style.transition = '';
        dragBrick.style.position = '';
        dragBrick.style.left = '';
        dragBrick.style.top = '';
        dragBrick.style.width = '';
        dragBrick.style.height = '';
        dragBrick.style.zIndex = '';
        dragBrick.style.pointerEvents = '';
        dragBrick.style.margin = '';
        
        // Hide spacer
        placeholder.style.display = 'none';

        // Re-append to logo container
        const logoContainer = document.querySelector('.logo-container');
        logoContainer.insertBefore(dragBrick, logoContainer.firstChild);
      }, 500);
    }

    dragBrick.addEventListener('dragstart', (e) => {
      e.preventDefault();
    });
  </script>
</body>
</html>