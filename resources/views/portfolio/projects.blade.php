<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Projects | {{ $hero->brand_name ?? "Sazzad's Dev." }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
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
        }

        /* WebGL Smoke Canvas */
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

        /* Header */
        header {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 1300px;
            margin: 0 auto;
            padding: 2rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand-logo {
            font-size: 1.6rem;
            font-weight: 800;
            color: #ffffff;
            text-decoration: none;
            background: linear-gradient(135deg, #ffffff 0%, #e4e4e7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .btn-back-home {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 0.65rem 1.4rem;
            border-radius: 100px;
            font-size: 0.85rem;
            font-weight: 700;
            color: #ffffff;
            text-decoration: none;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: all 0.25s ease;
        }

        .btn-back-home:hover {
            background: rgba(255, 255, 255, 0.18);
            transform: translateX(-3px);
        }

        /* Showcase Banner */
        .showcase-banner {
            max-width: 1300px;
            margin: 1rem auto 3rem auto;
            padding: 0 2rem;
            text-align: center;
        }

        .showcase-title {
            font-size: 3.5rem;
            font-weight: 900;
            letter-spacing: -1px;
            margin-bottom: 0.75rem;
            background: linear-gradient(135deg, #ffffff 0%, #a1a1aa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .showcase-subtitle {
            font-size: 1.1rem;
            color: #a1a1aa;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Filter Pills */
        .filter-container {
            max-width: 1300px;
            margin: 0 auto 3.5rem auto;
            padding: 0 2rem;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .filter-pill {
            display: inline-flex;
            align-items: center;
            padding: 0.65rem 1.4rem;
            border-radius: 100px;
            font-size: 0.85rem;
            font-weight: 700;
            color: #a1a1aa;
            text-decoration: none;
            background: #121215;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.25s ease;
        }

        .filter-pill:hover, .filter-pill.active {
            background: #ffffff;
            color: #090a0f;
            border-color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 255, 255, 0.15);
        }

        /* Grid Section (Large Featured Image Layout) */
        .projects-grid-section {
            background-color: #ffffff;
            color: #090a0f;
            padding: 5rem 0 8rem 0;
            flex: 1;
        }

        .projects-grid-container {
            max-width: 1300px;
            margin: 0 auto;
            padding: 0 2rem;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 3.5rem;
        }

        .grid-project-card {
            display: flex;
            flex-direction: column;
            cursor: pointer;
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .grid-project-card:hover {
            transform: translateY(-10px);
        }

        /* Exceptionally Large Showcase Image Height (520px) */
        .grid-card-image-box {
            width: 100%;
            height: 520px;
            border-radius: 28px;
            overflow: hidden;
            background-color: #f4f4f5;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.09);
            margin-bottom: 1.5rem;
            position: relative;
        }

        .grid-card-image-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .grid-project-card:hover .grid-card-image-box img {
            transform: scale(1.05);
        }

        .grid-card-tags {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #71717a;
            margin-bottom: 0.5rem;
        }

        .grid-card-tags span::before {
            content: '•';
            color: #10b981;
            font-size: 1.2rem;
            margin-right: 4px;
        }

        .grid-card-title {
            font-size: 1.6rem;
            font-weight: 800;
            color: #090a0f;
            line-height: 1.35;
        }

        /* Popup Detail Modal */
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

        @media (max-width: 900px) {
            .projects-grid-container {
                grid-template-columns: 1fr;
                gap: 2.5rem;
            }

            .grid-card-image-box {
                height: 320px;
            }

            .showcase-title {
                font-size: 2.5rem;
            }
        }
    </style>
</head>

<body>

    <canvas id="antigravity-canvas"></canvas>

    <header>
        <a href="{{ route('portfolio.index') }}" class="brand-logo">{{ $hero->brand_name ?? "Sazzad's Dev." }}</a>
        <a href="{{ route('portfolio.index') }}" class="btn-back-home">← Back to Portfolio</a>
    </header>

    <div class="showcase-banner">
        <h1 class="showcase-title">Explore All Projects</h1>
        <p class="showcase-subtitle">Filter through my latest works, product designs, web platforms, and mobile application developments.</p>
    </div>

    <!-- Category Filter Pills -->
    <div class="filter-container">
        <a href="{{ route('portfolio.projects') }}" class="filter-pill {{ empty($selectedCategory) ? 'active' : '' }}">
            All Projects
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('portfolio.projects', ['category' => $cat->name]) }}" 
               class="filter-pill {{ $selectedCategory === $cat->name ? 'active' : '' }}">
                {{ $cat->name }}
            </a>
        @endforeach
    </div>

    <!-- Large Image Grid Showcase Section -->
    <section class="projects-grid-section">
        <div class="projects-grid-container">
            @forelse($projects as $project)
                <div class="grid-project-card" data-project='@json($project)'>
                    <div class="grid-card-image-box">
                        @if($project->cover_image)
                            <img src="{{ asset('storage/' . $project->cover_image) }}" alt="{{ $project->title }}">
                        @else
                            <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; color:#a1a1aa; font-weight:600;">No Image Uploaded</div>
                        @endif
                    </div>
                    <div class="grid-card-tags">
                        @if($project->category_tags)
                            @foreach(explode(',', $project->category_tags) as $tag)
                                <span>{{ trim($tag) }}</span>
                            @endforeach
                        @endif
                    </div>
                    <h2 class="grid-card-title">{{ $project->title }}</h2>
                </div>
            @empty
                <div style="grid-column: span 2; text-align:center; padding: 4rem 0; color:#71717a; font-size:1.2rem; font-weight:600;">
                    No projects found for this category.
                </div>
            @endforelse
        </div>
    </section>

    <!-- Detail Popup Modal -->
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
            const modalOverlay = document.getElementById('projectDetailModal');
            const modalCloseBtn = document.getElementById('modalCloseBtn');
            const modalTitle = document.getElementById('modalProjectTitle');
            const modalSubtitle = document.getElementById('modalProjectSubtitle');
            const modalTags = document.getElementById('modalProjectTags');
            const modalLinks = document.getElementById('modalProjectLinks');
            const modalDesc = document.getElementById('modalProjectDesc');
            const modalGallery = document.getElementById('modalProjectGallery');

            document.querySelectorAll('.grid-project-card').forEach(card => {
                card.addEventListener('click', () => {
                    const rawData = card.getAttribute('data-project');
                    if (!rawData) return;
                    const project = JSON.parse(rawData);

                    modalTitle.innerText = project.title || 'Project Showcase';
                    modalSubtitle.innerText = project.sub_title || '';
                    modalDesc.innerText = project.description || '';

                    modalTags.innerHTML = '';
                    if (project.category_tags) {
                        project.category_tags.split(',').forEach(tag => {
                            const span = document.createElement('span');
                            span.innerText = tag.trim();
                            modalTags.appendChild(span);
                        });
                    }

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

            // Antigravity Smoke Canvas
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
            let hue = 260;

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
