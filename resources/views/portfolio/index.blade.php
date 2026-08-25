<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $hero->brand_name ?? "Sazzad's Dev." }} | Portfolio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background-color: #090a0f;
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            position: relative;
        }

        /* Fullscreen WebGL Smoke / Fluid Canvas (Global across all sections) */
        #antigravity-canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            pointer-events: none;
            z-index: 2;
            opacity: 0.85;
            mix-blend-mode: screen;
        }

        /* Glass & Lighting background accents */
        .ambient-glow {
            position: absolute;
            top: -150px;
            left: -150px;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(124, 58, 237, 0.08) 0%, rgba(0, 0, 0, 0) 70%);
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
        }

        .ambient-glow-2 {
            position: absolute;
            top: 20%;
            right: -100px;
            width: 450px;
            height: 450px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.06) 0%, rgba(0, 0, 0, 0) 70%);
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
        }

        /* Header / Navbar */
        header {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 1280px;
            margin: 0 auto;
            padding: 2.2rem 2rem 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand-logo {
            font-size: 1.6rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: #ffffff;
            text-decoration: none;
            background: linear-gradient(135deg, #ffffff 0%, #e4e4e7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Desktop Nav */
        .nav-menu {
            display: flex;
            align-items: center;
            gap: 2.2rem;
        }

        .nav-link {
            color: #d4d4d8;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            padding: 0.75rem 0.5rem;
            min-height: 44px;
            display: inline-flex;
            align-items: center;
            transition: color 0.2s ease;
        }

        .nav-link:hover {
            color: #ffffff;
        }

        /* Secondary Nav CTA (Ghost style) */
        .btn-talk-ghost {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.65rem 1.4rem;
            min-height: 44px;
            min-width: 44px;
            border-radius: 100px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #e4e4e7;
            text-decoration: none;
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.12);
            transition: all 0.25s ease;
        }

        .btn-talk-ghost:hover {
            background-color: rgba(255, 255, 255, 0.12);
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.25);
        }

        /* Mobile Hamburger Toggle */
        .hamburger {
            display: none;
            background: none;
            border: none;
            color: #ffffff;
            cursor: pointer;
            padding: 0.5rem;
            min-height: 44px;
            min-width: 44px;
            z-index: 20;
        }

        .hamburger svg {
            width: 28px;
            height: 28px;
            stroke: #ffffff;
        }

        /* Main Hero Section - Full Viewport Height */
        main.hero-container {
            position: relative;
            z-index: 5;
            width: 100%;
            max-width: 1280px;
            margin: 0 auto;
            min-height: calc(100vh - 100px);
            padding: 1rem 2rem 3rem 2rem;
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 3.5rem;
            align-items: center;
        }

        /* Hero Left Column */
        .hero-left {
            position: relative;
            z-index: 5;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        /* Magic Rings Animation Container */
        .magic-rings-container {
            position: relative;
            width: 210px;
            height: 210px;
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Animated Concentric Magic Rings (React Bits) */
        .magic-ring {
            position: absolute;
            border-radius: 50%;
            border: 1.5px solid transparent;
            pointer-events: none;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation: magicRingPulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        .magic-ring-1 {
            width: 228px;
            height: 228px;
            border-color: rgba(99, 102, 241, 0.45);
            box-shadow: 0 0 15px rgba(99, 102, 241, 0.25);
            animation-delay: 0s;
        }

        .magic-ring-2 {
            width: 250px;
            height: 250px;
            border-color: rgba(139, 92, 246, 0.35);
            box-shadow: 0 0 20px rgba(139, 92, 246, 0.2);
            animation-delay: 0.8s;
        }

        .magic-ring-3 {
            width: 275px;
            height: 275px;
            border-color: rgba(236, 72, 153, 0.25);
            box-shadow: 0 0 25px rgba(236, 72, 153, 0.15);
            animation-delay: 1.6s;
        }

        .magic-ring-4 {
            width: 302px;
            height: 302px;
            border-color: rgba(59, 130, 246, 0.18);
            animation-delay: 2.4s;
        }

        @keyframes magicRingPulse {

            0%,
            100% {
                transform: translate(-50%, -50%) scale(0.96) rotate(0deg);
                opacity: 0.3;
            }

            50% {
                transform: translate(-50%, -50%) scale(1.04) rotate(180deg);
                opacity: 0.85;
                filter: blur(0.5px);
            }
        }

        /* Profile Avatar Wrapper */
        .avatar-wrapper {
            position: relative;
            z-index: 5;
            width: 210px;
            height: 210px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.03));
            border: 3px solid rgba(255, 255, 255, 0.25);
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.6);
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            cursor: pointer;
        }

        .avatar-wrapper:hover {
            transform: scale(1.06) translateY(-4px);
            border-color: rgba(255, 255, 255, 0.7);
            box-shadow: 0 30px 60px rgba(59, 130, 246, 0.4), 0 0 45px rgba(139, 92, 246, 0.35);
        }

        .avatar-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .avatar-wrapper:hover img {
            transform: scale(1.08);
        }

        .avatar-placeholder {
            color: #a1a1aa;
            font-weight: 600;
            font-size: 1rem;
        }

        .hero-name {
            font-size: 3.25rem;
            font-weight: 800;
            letter-spacing: -1.5px;
            padding-top: 0.8rem;
            margin-top: 0.5rem;
            margin-bottom: 0.35rem;
            color: #ffffff;
            line-height: 1.1;
            display: inline-flex;
            align-items: center;
            min-height: 3.6rem;
        }

        .typewriter-cursor {
            display: inline-block;
            width: 4px;
            height: 2.8rem;
            background-color: #3b82f6;
            margin-left: 6px;
            border-radius: 2px;
            animation: cursorBlink 0.8s infinite;
            box-shadow: 0 0 10px #3b82f6;
        }

        @keyframes cursorBlink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }
        }

        /* Slide Up Entrance Animations for Work Details, Description & CTA */
        .slide-up-animate {
            opacity: 0;
            transform: translateY(35px);
            animation: fadeInUp 0.9s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .delay-1 {
            animation-delay: 0.35s;
        }

        .delay-2 {
            animation-delay: 0.55s;
        }

        .delay-3 {
            animation-delay: 0.85s;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-title {
            font-size: 1.4rem;
            font-weight: 600;
            color: #d4d4d8;
            margin-bottom: 1.25rem;
            line-height: 1.35;
        }

        .hero-description {
            font-size: 1.05rem;
            line-height: 1.7;
            color: #a1a1aa;
            max-width: 520px;
            margin-bottom: 2.25rem;
        }

        .btn-consultancy-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #ffffff;
            color: #090a0f;
            border: 2px solid #ffffff;
            padding: 1rem 2.4rem;
            min-height: 48px;
            border-radius: 100px;
            font-size: 0.95rem;
            font-weight: 800;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            text-decoration: none;
            box-shadow: 0 10px 30px rgba(255, 255, 255, 0.2);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-consultancy-primary:hover {
            background-color: #e4e4e7;
            border-color: #e4e4e7;
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(255, 255, 255, 0.3);
        }

        /* Hero Right Column Media */
        .hero-right {
            position: relative;
            z-index: 5;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .video-card {
            width: 100%;
            height: 460px;
            border-radius: 24px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.04), rgba(255, 255, 255, 0.01));
            border: 1px solid rgba(255, 255, 255, 0.1);
            overflow: hidden;
            position: relative;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.6);
            display: flex;
            justify-content: center;
            align-items: center;
            filter: contrast(0.95) brightness(0.9);
            transition: filter 0.3s ease;
        }

        .video-card:hover {
            filter: contrast(1) brightness(1);
        }

        .video-card video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .video-placeholder {
            padding: 2rem;
            text-align: center;
            color: #a1a1aa;
            font-size: 1.1rem;
            font-weight: 500;
            line-height: 1.6;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.03) 0%, rgba(0, 0, 0, 0) 70%);
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .video-placeholder svg {
            width: 44px;
            height: 44px;
            margin-bottom: 1rem;
            stroke: #71717a;
        }

        .artwork-status-tag {
            margin-top: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            padding: 0.4rem 1rem;
            border-radius: 100px;
            font-size: 0.8rem;
            font-weight: 600;
            color: #a1a1aa;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background-color: #10b981;
            border-radius: 50%;
            box-shadow: 0 0 10px #10b981;
        }

        /* --- PROJECTS SECTION (WHITE BACKGROUND) --- */
        section.projects-section {
            background-color: #ffffff;
            color: #090a0f;
            position: relative;
            z-index: 10;
            padding: 6rem 0;
            width: 100%;
            overflow: hidden;
        }

        .projects-container-inner {
            max-width: 1300px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .projects-header-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 3.5rem;
        }

        .projects-heading-block h2 {
            font-size: 2.75rem;
            font-weight: 900;
            letter-spacing: 12px;
            color: #090a0f;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            min-height: 3.5rem;
            perspective: 1000px;
        }

        .flip-char {
            display: inline-block;
            opacity: 0;
            transform: rotateX(-90deg) translateY(-15px);
            animation: smoothLetterFlip 0.85s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
            backface-visibility: hidden;
            transform-style: preserve-3d;
        }

        @keyframes smoothLetterFlip {
            0% {
                opacity: 0;
                transform: rotateX(-90deg) translateY(-15px);
                filter: blur(4px);
            }

            70% {
                transform: rotateX(15deg) translateY(2px);
                filter: blur(0px);
            }

            100% {
                opacity: 1;
                transform: rotateX(0deg) translateY(0px);
                filter: blur(0px);
            }
        }

        .projects-heading-block p {
            font-size: 0.95rem;
            font-weight: 700;
            letter-spacing: 3px;
            color: #71717a;
            text-transform: uppercase;
        }

        .btn-more-projects {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1.5px solid #d4d4d8;
            padding: 0.85rem 2rem;
            border-radius: 100px;
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 1px;
            color: #090a0f;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-more-projects:hover {
            border-color: #090a0f;
            background-color: #090a0f;
            color: #ffffff;
        }

        /* Continuous Slow Auto-Carousel Slider */
        .projects-carousel-wrapper {
            width: 100%;
            overflow: hidden;
            cursor: grab;
            position: relative;
            user-select: none;
            padding: 1rem 0 3rem 0;
        }

        .projects-carousel-wrapper:active {
            cursor: grabbing;
        }

        .projects-carousel-track {
            display: flex;
            gap: 3rem;
            width: max-content;
            will-change: transform;
            transition: transform 0.1s linear;
        }

        .project-card {
            width: 780px;
            flex-shrink: 0;
            cursor: pointer;
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .project-card:hover {
            transform: translateY(-10px);
        }

        .project-card-image-box {
            width: 100%;
            height: 500px;
            border-radius: 24px;
            overflow: hidden;
            background-color: #f4f4f5;
            position: relative;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
            margin-bottom: 1.25rem;
        }

        .project-card-image-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .project-card:hover .project-card-image-box img {
            transform: scale(1.04);
        }

        .project-card-tags {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #71717a;
            margin-bottom: 0.5rem;
        }

        .project-card-tags span {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .project-card-tags span::before {
            content: '•';
            color: #10b981;
            font-size: 1.2rem;
        }

        .project-card-title {
            font-size: 1.4rem;
            font-weight: 800;
            color: #090a0f;
            line-height: 1.3;
        }

        /* --- PROJECT DETAIL POPUP MODAL --- */
        .project-modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(9, 10, 15, 0.85);
            backdrop-filter: blur(12px);
            z-index: 99999;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .project-modal-overlay.active {
            display: flex;
            opacity: 1;
        }

        .project-modal-container {
            background: #ffffff;
            color: #090a0f;
            border-radius: 28px;
            width: 100%;
            max-width: 1100px;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.4);
            transform: scale(0.92) translateY(20px);
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            padding: 3rem;
        }

        .project-modal-overlay.active .project-modal-container {
            transform: scale(1) translateY(0);
        }

        .project-modal-close-btn {
            position: absolute;
            top: 2rem;
            right: 2rem;
            background: #f4f4f5;
            border: none;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1.2rem;
            font-weight: 700;
            color: #090a0f;
            transition: all 0.2s ease;
            z-index: 10;
        }

        .project-modal-close-btn:hover {
            background: #e4e4e7;
            transform: scale(1.1);
        }

        .project-modal-header {
            margin-bottom: 2.5rem;
            padding-right: 3rem;
        }

        .project-modal-title {
            font-size: 2.2rem;
            font-weight: 800;
            color: #090a0f;
            margin-bottom: 0.75rem;
        }

        .project-modal-subtitle {
            font-size: 1.05rem;
            color: #71717a;
            font-weight: 500;
            margin-bottom: 1.25rem;
        }

        .project-modal-meta-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .project-modal-tags {
            display: flex;
            align-items: center;
            gap: 16px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #52525b;
        }

        .project-modal-tags span::before {
            content: '•';
            color: #10b981;
            font-size: 1.3rem;
            margin-right: 4px;
        }

        .project-modal-links {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .btn-modal-link {
            border: 1.5px solid #e4e4e7;
            padding: 0.65rem 1.4rem;
            border-radius: 100px;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.8px;
            color: #090a0f;
            text-decoration: none;
            text-transform: uppercase;
            transition: all 0.25s ease;
        }

        .btn-modal-link:hover {
            border-color: #090a0f;
            background: #090a0f;
            color: #ffffff;
        }

        .project-modal-gallery {
            display: flex;
            flex-direction: column;
            gap: 2rem;
            margin-top: 2rem;
        }

        .project-modal-gallery-img {
            width: 100%;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            background: #f4f4f5;
        }

        .project-modal-gallery-img img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* --- WORK EXPERIENCE SECTION (WHITE BACKGROUND) --- */
        section.experience-section {
            background-color: #ffffff;
            color: #090a0f;
            position: relative;
            z-index: 10;
            padding: 7rem 0 8rem 0;
            width: 100%;
            overflow: hidden;
        }

        .exp-container-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .exp-section-header {
            margin-bottom: 4rem;
        }

        .exp-section-header h2 {
            font-size: 2.75rem;
            font-weight: 900;
            letter-spacing: 8px;
            color: #090a0f;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
        }

        .exp-section-header p {
            font-size: 0.95rem;
            font-weight: 700;
            letter-spacing: 3px;
            color: #2563eb;
            text-transform: uppercase;
        }

        .exp-grid-container {
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
            gap: 4rem;
            align-items: center;
        }

        /* Timeline List */
        .exp-timeline-list {
            display: flex;
            flex-direction: column;
            gap: 2rem;
            position: relative;
            padding-left: 1.5rem;
            border-left: 2px dashed #e4e4e7;
        }

        .exp-item-card {
            background: #ffffff;
            border: 1px solid #d4d4d8;
            border-radius: 24px;
            padding: 1.5rem 1.75rem;
            position: relative;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .exp-item-card::before {
            content: '';
            position: absolute;
            left: -2.35rem;
            top: 50%;
            transform: translateY(-50%);
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: #2563eb;
            border: 3px solid #ffffff;
            box-shadow: 0 0 10px rgba(37, 99, 235, 0.4);
            transition: all 0.3s ease;
        }

        .exp-item-card:hover {
            transform: translateX(10px) translateY(-4px);
            border-color: #2563eb;
            box-shadow: 0 20px 45px rgba(37, 99, 235, 0.12);
        }

        .exp-item-card:hover::before {
            background: #1d4ed8;
            transform: translateY(-50%) scale(1.3);
            box-shadow: 0 0 16px rgba(29, 78, 216, 0.6);
        }

        /* Left Logo Box Column */
        .exp-logo-col {
            width: 120px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            padding-right: 0.5rem;
        }

        .exp-company-logo {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1.25rem;
            color: #2563eb;
            overflow: hidden;
        }

        .exp-company-logo img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        /* Vertical Separator Line */
        .exp-card-divider {
            width: 1px;
            align-self: stretch;
            background-color: #000000;
            flex-shrink: 0;
        }

        /* Right Side Content Block */
        .exp-details-col {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }

        .exp-card-top-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .exp-company-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: #090a0f;
            line-height: 1.2;
        }

        .exp-company-location {
            font-size: 0.85rem;
            font-weight: 600;
            color: #71717a;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .exp-duration-badge {
            background: rgba(37, 99, 235, 0.06);
            border: 1.5px solid #bfdbfe;
            color: #2563eb;
            padding: 0.4rem 1.2rem;
            border-radius: 100px;
            font-size: 0.82rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .exp-designation {
            font-size: 1.05rem;
            font-weight: 700;
            color: #3f3f46;
        }

        /* Right Side Developer Illustration Card */
        .exp-illustration-card {
            width: 100%;
            height: 540px;
            border-radius: 28px;
            overflow: hidden;
            position: relative;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.05), rgba(255, 255, 255, 0.01));
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .exp-illustration-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.9) contrast(1.05);
            transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .exp-illustration-card:hover img {
            transform: scale(1.05);
        }

        .exp-illustration-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(9, 10, 15, 0.95) 0%, rgba(9, 10, 15, 0) 60%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 2.5rem;
        }

        .exp-illustration-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(59, 130, 246, 0.2);
            border: 1px solid rgba(59, 130, 246, 0.4);
            color: #60a5fa;
            padding: 0.4rem 1rem;
            border-radius: 100px;
            font-size: 0.8rem;
            font-weight: 700;
            width: fit-content;
            margin-bottom: 0.75rem;
        }

        .exp-illustration-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 0.25rem;
        }

        .exp-illustration-desc {
            font-size: 0.9rem;
            color: #a1a1aa;
        }

        /* Responsive Design */
        @media (max-width: 900px) {
            header {
                padding: 1.5rem 1.5rem;
            }

            .hamburger {
                display: block;
            }

            .nav-menu {
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background: #0d0e14;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
                flex-direction: column;
                padding: 1.5rem;
                gap: 1.25rem;
                display: none;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.8);
            }

            .nav-menu.active {
                display: flex;
            }

            .nav-link,
            .btn-talk-ghost {
                width: 100%;
                justify-content: center;
            }

            main.hero-container {
                grid-template-columns: 1fr;
                gap: 3rem;
                padding: 1.5rem 1.5rem 4rem 1.5rem;
            }

            .hero-left {
                align-items: center;
                text-align: center;
            }

            .hero-name {
                font-size: 2.5rem;
            }

            .hero-description {
                max-width: 100%;
            }

            .video-card {
                height: 340px;
            }

            .project-card {
                width: 320px;
            }

            .project-card-image-box {
                height: 240px;
            }

            .project-modal-container {
                padding: 1.75rem;
            }
        }
    </style>
</head>

<body>

    <div class="ambient-glow"></div>
    <div class="ambient-glow-2"></div>

    <!-- Global Antigravity Fluid Smoke Canvas across entire website -->
    <canvas id="antigravity-canvas"></canvas>

    <header>
        <a href="{{ route('portfolio.index') }}" class="brand-logo">{{ $hero->brand_name ?? "Sazzad's Dev." }}</a>

        <button class="hamburger" id="hamburgerBtn" aria-label="Toggle navigation">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>

        <nav class="nav-menu" id="navMenu">
            <a href="#experience" class="nav-link">EXPERIENCE</a>
            <a href="#projects" class="nav-link">PROJECTS</a>
            <a href="{{ route('portfolio.projects') }}" class="nav-link">ALL WORKS</a>
            <a href="{{ $hero->talk_button_url ?? '#contact' }}" class="btn-talk-ghost">
                {{ $hero->talk_button_text ?? "Contact Me" }}
            </a>
        </nav>
    </header>

    <main class="hero-container" id="heroContainer">
        <div class="hero-left">
            <!-- Profile Avatar surrounded by React Bits Magic Rings -->
            <div class="magic-rings-container">
                <div class="magic-ring magic-ring-1"></div>
                <div class="magic-ring magic-ring-2"></div>
                <div class="magic-ring magic-ring-3"></div>
                <div class="magic-ring magic-ring-4"></div>

                <div class="avatar-wrapper">
                    @if(!empty($hero->avatar_path))
                    <img src="{{ asset('storage/' . $hero->avatar_path) }}" alt="{{ $hero->name }}">
                    @else
                    <span class="avatar-placeholder">Image</span>
                    @endif
                </div>
            </div>

            <h1 class="hero-name" id="heroNameText" data-text="{{ $hero->name ?? 'Sazzad Hossain' }}"></h1>
            <h2 class="hero-title slide-up-animate delay-1">{{ $hero->work_details ?? 'Full-Stack Developer & AI Specialist' }}</h2>
            <p class="hero-description slide-up-animate delay-2">
                {{ $hero->description ?? 'Building interactive, robust, and scalable web solutions using modern tech stacks.' }}
            </p>

            <a href="{{ $hero->consultancy_button_url ?? '#contact' }}" class="btn-consultancy-primary slide-up-animate delay-3">
                {{ $hero->consultancy_button_text ?? 'BOOK A CALL' }}
            </a>
        </div>

        <div class="hero-right">
            <div class="video-card">
                @if(!empty($hero->video_path))
                <video autoplay loop muted playsinline>
                    <source src="{{ asset('storage/' . $hero->video_path) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                @else
                <div class="video-placeholder">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.91 11.672a.375.375 0 0 1 0 .656l-5.603 3.113a.375.375 0 0 1-.557-.328V8.887c0-.286.307-.466.557-.327l5.603 3.112Z" />
                    </svg>
                    <p>Featured Work Showcase<br><span style="font-size: 0.85rem; color: #71717a;">Auto-playing video feed</span></p>
                </div>
                @endif
            </div>
            <div class="artwork-status-tag">
                <span class="status-dot"></span> Available for new projects & consulting
            </div>
        </div>
    </main>

    <!-- PROJECTS SECTION (WHITE BACKGROUND) -->
    <section class="projects-section" id="projects">
        <div class="projects-container-inner">
            <div class="projects-header-row">
                <div class="projects-heading-block">
                    <h2 id="projectsTitleText" data-text="P R O J E C T S"></h2>
                    <p>WE HAVE DONE</p>
                </div>
                <a href="{{ route('portfolio.projects') }}" class="btn-more-projects">MORE PROJECTS ↗</a>
            </div>
        </div>

        <!-- Continuous Slow Auto-Carousel Slider -->
        <div class="projects-carousel-wrapper" id="projectsCarouselWrapper">
            <div class="projects-carousel-track" id="projectsCarouselTrack">
                @foreach($projects as $project)
                <div class="project-card" data-project='@json($project)'>
                    <div class="project-card-image-box">
                        @if($project->cover_image)
                        <img src="{{ asset('storage/' . $project->cover_image) }}" alt="{{ $project->title }}">
                        @else
                        <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; color:#a1a1aa; font-weight:600;">No Image Uploaded</div>
                        @endif
                    </div>
                    <div class="project-card-tags">
                        @if($project->category_tags)
                        @foreach(explode(',', $project->category_tags) as $tag)
                        <span>{{ trim($tag) }}</span>
                        @endforeach
                        @endif
                    </div>
                    <h3 class="project-card-title">{{ $project->title }}</h3>
                </div>
                @endforeach

                <!-- Duplicate set for seamless continuous looping -->
                @foreach($projects as $project)
                <div class="project-card" data-project='@json($project)'>
                    <div class="project-card-image-box">
                        @if($project->cover_image)
                        <img src="{{ asset('storage/' . $project->cover_image) }}" alt="{{ $project->title }}">
                        @else
                        <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; color:#a1a1aa; font-weight:600;">No Image Uploaded</div>
                        @endif
                    </div>
                    <div class="project-card-tags">
                        @if($project->category_tags)
                        @foreach(explode(',', $project->category_tags) as $tag)
                        <span>{{ trim($tag) }}</span>
                        @endforeach
                        @endif
                    </div>
                    <h3 class="project-card-title">{{ $project->title }}</h3>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- WORK EXPERIENCE SECTION -->
    <section class="experience-section" id="experience">
        <div class="exp-container-inner">
            <div class="exp-section-header">
                <h2>EXPERIENCE</h2>
                <p>CAREER JOURNEY & ROLES</p>
            </div>

            <div class="exp-grid-container">
                <!-- Left Side: Dynamic Timeline List -->
                <div class="exp-timeline-list">
                    @foreach($experiences as $exp)
                    <div class="exp-item-card">
                        <!-- Left Logo Box Column -->
                        <div class="exp-logo-col">
                            <div class="exp-company-logo">
                                @if($exp->company_logo)
                                <img src="{{ asset('storage/' . $exp->company_logo) }}" alt="{{ $exp->company_name }}">
                                @else
                                <span>{{ strtoupper(substr($exp->company_name, 0, 2)) }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Vertical Black Line Divider -->
                        <div class="exp-card-divider"></div>

                        <!-- Right Side Details Column -->
                        <div class="exp-details-col">
                            <div class="exp-card-top-row">
                                <h3 class="exp-company-title">{{ $exp->company_name }}</h3>
                                <div class="exp-duration-badge">{{ $exp->duration }}</div>
                            </div>
                            @if($exp->location)
                            <div class="exp-company-location">📍 {{ $exp->location }}</div>
                            @endif
                            <div class="exp-designation">{{ $exp->designation }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Right Side: Big Working Developer Image Card -->
                <div class="exp-illustration-card">
                    <img src="{{ asset('storage/developer_illustration.jpg') }}" alt="Developer Working">
                    <div class="exp-illustration-overlay">
                        <div class="exp-illustration-badge">💻 FULL-STACK WORKSPACE</div>
                        <h3 class="exp-illustration-title">Engineering Scalable Systems</h3>
                        <p class="exp-illustration-desc">Delivering high-performance backend architectures, RESTful APIs, and modern Laravel web platforms.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PROJECT DETAIL POPUP MODAL -->
    <div class="project-modal-overlay" id="projectDetailModal">
        <div class="project-modal-container">
            <button class="project-modal-close-btn" id="modalCloseBtn">✕</button>

            <div class="project-modal-header">
                <h2 class="project-modal-title" id="modalProjectTitle">Project Title</h2>
                <div class="project-modal-subtitle" id="modalProjectSubtitle">Sub title summary</div>

                <div class="project-modal-meta-row">
                    <div class="project-modal-tags" id="modalProjectTags"></div>
                    <div class="project-modal-links" id="modalProjectLinks"></div>
                </div>
            </div>

            <p style="font-size:1.05rem; line-height:1.7; color:#52525b; margin-bottom:2rem;" id="modalProjectDesc"></p>

            <div class="project-modal-gallery" id="modalProjectGallery"></div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile Nav Toggle
            const hamburgerBtn = document.getElementById('hamburgerBtn');
            const navMenu = document.getElementById('navMenu');

            if (hamburgerBtn && navMenu) {
                hamburgerBtn.addEventListener('click', function() {
                    navMenu.classList.toggle('active');
                });
            }

            // Typewriter Animation for Name Section
            const heroNameElem = document.getElementById('heroNameText');
            if (heroNameElem) {
                const fullText = heroNameElem.getAttribute('data-text') || 'Sazzad Hossain';
                let charIndex = 0;
                heroNameElem.innerHTML = '<span class="typewriter-text"></span><span class="typewriter-cursor"></span>';
                const textContainer = heroNameElem.querySelector('.typewriter-text');

                function typeChar() {
                    if (charIndex < fullText.length) {
                        textContainer.textContent += fullText.charAt(charIndex);
                        charIndex++;
                        setTimeout(typeChar, 80 + Math.random() * 50);
                    }
                }

                setTimeout(typeChar, 200);
            }

            // Smooth 3D Letter Flip Animation for Projects Section Title
            const projectsTitleElem = document.getElementById('projectsTitleText');
            if (projectsTitleElem) {
                const projText = projectsTitleElem.getAttribute('data-text') || 'P R O J E C T S';

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            projectsTitleElem.innerHTML = '';
                            [...projText].forEach((char, idx) => {
                                const span = document.createElement('span');
                                span.className = 'flip-char';
                                span.innerHTML = char === ' ' ? '&nbsp;' : char;
                                span.style.animationDelay = `${idx * 0.08}s`;
                                projectsTitleElem.appendChild(span);
                            });
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.5
                });

                observer.observe(projectsTitleElem);
            }

            // --- CONTINUOUS SLOW CAROUSEL WITH DRAG TO SCROLL ---
            const wrapper = document.getElementById('projectsCarouselWrapper');
            const track = document.getElementById('projectsCarouselTrack');

            if (wrapper && track) {
                let currentTranslate = 0;
                let isDragging = false;
                let startX = 0;
                let prevTranslate = 0;
                const speed = 0.5; // Slow continuous scroll speed
                let animationId = null;

                function animateCarousel() {
                    if (!isDragging) {
                        currentTranslate -= speed;
                        // Half track width loop
                        const halfWidth = track.scrollWidth / 2;
                        if (Math.abs(currentTranslate) >= halfWidth) {
                            currentTranslate = 0;
                        }
                        track.style.transform = `translateX(${currentTranslate}px)`;
                    }
                    animationId = requestAnimationFrame(animateCarousel);
                }

                animateCarousel();

                // Mouse / Touch Drag Events
                wrapper.addEventListener('mousedown', (e) => {
                    isDragging = true;
                    startX = e.clientX;
                    prevTranslate = currentTranslate;
                });

                window.addEventListener('mousemove', (e) => {
                    if (!isDragging) return;
                    const deltaX = e.clientX - startX;
                    currentTranslate = prevTranslate + deltaX;
                    track.style.transform = `translateX(${currentTranslate}px)`;
                });

                window.addEventListener('mouseup', () => {
                    if (isDragging) {
                        isDragging = false;
                    }
                });

                wrapper.addEventListener('touchstart', (e) => {
                    isDragging = true;
                    startX = e.touches[0].clientX;
                    prevTranslate = currentTranslate;
                });

                window.addEventListener('touchmove', (e) => {
                    if (!isDragging) return;
                    const deltaX = e.touches[0].clientX - startX;
                    currentTranslate = prevTranslate + deltaX;
                    track.style.transform = `translateX(${currentTranslate}px)`;
                });

                window.addEventListener('touchend', () => {
                    isDragging = false;
                });
            }

            // --- PROJECT DETAIL POPUP MODAL ---
            const modalOverlay = document.getElementById('projectDetailModal');
            const modalCloseBtn = document.getElementById('modalCloseBtn');
            const modalTitle = document.getElementById('modalProjectTitle');
            const modalSubtitle = document.getElementById('modalProjectSubtitle');
            const modalTags = document.getElementById('modalProjectTags');
            const modalLinks = document.getElementById('modalProjectLinks');
            const modalDesc = document.getElementById('modalProjectDesc');
            const modalGallery = document.getElementById('modalProjectGallery');

            document.querySelectorAll('.project-card').forEach(card => {
                card.addEventListener('click', () => {
                    const rawData = card.getAttribute('data-project');
                    if (!rawData) return;
                    const project = JSON.parse(rawData);

                    modalTitle.innerText = project.title || 'Project Showcase';
                    modalSubtitle.innerText = project.sub_title || '';
                    modalDesc.innerText = project.description || '';

                    // Tags
                    modalTags.innerHTML = '';
                    if (project.category_tags) {
                        project.category_tags.split(',').forEach(tag => {
                            const span = document.createElement('span');
                            span.innerText = tag.trim();
                            modalTags.appendChild(span);
                        });
                    }

                    // Links
                    modalLinks.innerHTML = '';
                    if (project.live_mobile_app_url) {
                        const appBtn = document.createElement('a');
                        appBtn.href = project.live_mobile_app_url;
                        appBtn.target = '_blank';
                        appBtn.className = 'btn-modal-link';
                        appBtn.innerText = 'LIVE MOBILE APP';
                        modalLinks.appendChild(appBtn);
                    }
                    if (project.live_website_url) {
                        const webBtn = document.createElement('a');
                        webBtn.href = project.live_website_url;
                        webBtn.target = '_blank';
                        webBtn.className = 'btn-modal-link';
                        webBtn.innerText = 'LIVE WEBSITE';
                        modalLinks.appendChild(webBtn);
                    }

                    // Gallery Images
                    modalGallery.innerHTML = '';
                    if (project.cover_image) {
                        const div = document.createElement('div');
                        div.className = 'project-modal-gallery-img';
                        div.innerHTML = `<img src="/storage/${project.cover_image}" alt="Cover Image">`;
                        modalGallery.appendChild(div);
                    }
                    if (project.detail_images && Array.isArray(project.detail_images)) {
                        project.detail_images.forEach(imgUrl => {
                            const div = document.createElement('div');
                            div.className = 'project-modal-gallery-img';
                            div.innerHTML = `<img src="/storage/${imgUrl}" alt="Showcase Image">`;
                            modalGallery.appendChild(div);
                        });
                    }

                    modalOverlay.classList.add('active');
                });
            });

            if (modalCloseBtn && modalOverlay) {
                modalCloseBtn.addEventListener('click', () => {
                    modalOverlay.classList.remove('active');
                });

                modalOverlay.addEventListener('click', (e) => {
                    if (e.target === modalOverlay) {
                        modalOverlay.classList.remove('active');
                    }
                });
            }

            // Antigravity Fluid Smoke Cursor (Global across entire screen)
            const canvas = document.getElementById('antigravity-canvas');
            if (!canvas) return;

            const ctx = canvas.getContext('2d');
            let width = canvas.width = window.innerWidth;
            let height = canvas.height = window.innerHeight;

            window.addEventListener('resize', () => {
                width = canvas.width = window.innerWidth;
                height = canvas.height = window.innerHeight;
            });

            class SmokeParticle {
                constructor(x, y, vx, vy, color) {
                    this.x = x;
                    this.y = y;
                    this.vx = vx;
                    this.vy = vy;
                    this.radius = Math.random() * 40 + 20;
                    this.alpha = 0.65;
                    this.color = color;
                    this.rotation = Math.random() * Math.PI * 2;
                    this.spin = (Math.random() - 0.5) * 0.04;
                }

                update() {
                    this.x += this.vx;
                    this.y += this.vy;
                    this.vx *= 0.96;
                    this.vy *= 0.96;
                    this.radius += 0.4;
                    this.alpha *= 0.955;
                    this.rotation += this.spin;
                }

                draw() {
                    ctx.save();
                    ctx.translate(this.x, this.y);
                    ctx.rotate(this.rotation);
                    ctx.globalAlpha = this.alpha;

                    const gradient = ctx.createRadialGradient(0, 0, 0, 0, 0, this.radius);
                    gradient.addColorStop(0, this.color);
                    gradient.addColorStop(0.5, this.color.replace('0.7)', '0.2)'));
                    gradient.addColorStop(1, 'rgba(0,0,0,0)');

                    ctx.fillStyle = gradient;
                    ctx.beginPath();
                    ctx.arc(0, 0, this.radius, 0, Math.PI * 2);
                    ctx.fill();
                    ctx.restore();
                }
            }

            let particles = [];
            let prevMouseX = null;
            let prevMouseY = null;
            let hue = 260; // Sleek Antigravity purple/indigo theme

            window.addEventListener('mousemove', function(e) {
                const currentX = e.clientX;
                const currentY = e.clientY;

                if (prevMouseX !== null && prevMouseY !== null) {
                    const dx = currentX - prevMouseX;
                    const dy = currentY - prevMouseY;
                    const dist = Math.hypot(dx, dy);

                    if (dist > 1.5) {
                        hue = (hue + 0.6) % 360;
                        const smokeColor = `hsla(${hue}, 80%, 60%, 0.7)`;

                        const count = Math.min(Math.floor(dist / 3) + 2, 8);
                        for (let i = 0; i < count; i++) {
                            const vx = dx * 0.08 + (Math.random() - 0.5) * 1.5;
                            const vy = dy * 0.08 + (Math.random() - 0.5) * 1.5;
                            const px = prevMouseX + (dx * (i / count));
                            const py = prevMouseY + (dy * (i / count));
                            particles.push(new SmokeParticle(px, py, vx, vy, smokeColor));
                        }
                    }
                }

                prevMouseX = currentX;
                prevMouseY = currentY;
            });

            function render() {
                ctx.clearRect(0, 0, width, height);

                for (let i = particles.length - 1; i >= 0; i--) {
                    const p = particles[i];
                    p.update();
                    p.draw();
                    if (p.alpha <= 0.01) {
                        particles.splice(i, 1);
                    }
                }

                requestAnimationFrame(render);
            }

            render();
        });
    </script>

</body>

</html>