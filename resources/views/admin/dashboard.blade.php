<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio Dashboard | Admin Panel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Cropper.js CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
    <!-- Sortable.js for Drag and Drop -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background-color: #09090b; color: #f4f4f5; min-height: 100vh; display: flex; }
        
        /* Sidebar */
        aside {
            width: 260px;
            background: #121215;
            border-right: 1px solid rgba(255,255,255,0.08);
            padding: 2rem 1.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .sidebar-brand { font-size: 1.25rem; font-weight: 800; color: #fff; margin-bottom: 2.5rem; }
        .sidebar-menu { list-style: none; }
        .sidebar-item { margin-bottom: 0.5rem; }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.75rem 1rem;
            color: #a1a1aa;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.2s ease;
            cursor: pointer;
        }
        .sidebar-link.active, .sidebar-link:hover { background: rgba(255,255,255,0.08); color: #fff; }
        .logout-btn {
            background: none;
            border: none;
            color: #ef4444;
            font-weight: 600;
            cursor: pointer;
            padding: 0.75rem 1rem;
            width: 100%;
            text-align: left;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Main Content area */
        main { flex: 1; padding: 2.5rem; overflow-y: auto; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 1rem; }
        .page-title { font-size: 1.75rem; font-weight: 800; }
        .btn-view-site {
            background: rgba(255,255,255,0.1);
            color: #fff;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            border: 1px solid rgba(255,255,255,0.15);
        }

        /* Tabs */
        .admin-tab { display: none; }
        .admin-tab.active { display: block; }

        /* Card Form */
        .card {
            background: #121215;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .card-header { font-size: 1.2rem; font-weight: 700; margin-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 0.75rem; display: flex; justify-content: space-between; align-items: center; }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
        .full-width { grid-column: span 2; }
        .form-group { margin-bottom: 1.25rem; }
        .form-group label { display: block; font-size: 0.85rem; font-weight: 600; color: #a1a1aa; margin-bottom: 0.5rem; }
        .form-group input[type="text"], .form-group textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            background: #18181b;
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 8px;
            color: #fff;
            font-size: 0.9rem;
            outline: none;
        }
        .form-group textarea { resize: vertical; min-height: 100px; }
        .form-group input[type="file"] {
            width: 100%;
            padding: 0.6rem;
            background: #18181b;
            border: 1px dashed rgba(255,255,255,0.2);
            border-radius: 8px;
            color: #a1a1aa;
            font-size: 0.85rem;
            cursor: pointer;
        }
        .media-preview { margin-top: 0.5rem; max-width: 120px; max-height: 120px; border-radius: 8px; overflow: hidden; border: 1px solid rgba(255,255,255,0.1); }
        .media-preview img, .media-preview video { width: 100%; height: 100%; object-fit: cover; }

        .btn-save {
            background: #3b82f6;
            color: #fff;
            border: none;
            padding: 0.85rem 2rem;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .btn-save:hover { background: #2563eb; }

        .btn-add-project {
            background: #10b981;
            color: #fff;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.85rem;
            cursor: pointer;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #4ade80;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        /* Project Drag and Drop Table */
        .project-list-container {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .project-item-card {
            background: #18181b;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: grab;
            transition: background 0.2s ease;
        }
        .project-item-card:active { cursor: grabbing; }
        .project-item-left { display: flex; align-items: center; gap: 1.25rem; }
        .drag-handle { color: #52525b; font-size: 1.2rem; }
        .project-thumb { width: 60px; height: 60px; border-radius: 8px; overflow: hidden; background: #000; border: 1px solid rgba(255,255,255,0.1); }
        .project-thumb img { width: 100%; height: 100%; object-fit: cover; }
        .project-meta-title { font-weight: 700; font-size: 1rem; color: #fff; margin-bottom: 4px; }
        .project-meta-tags { font-size: 0.8rem; color: #a1a1aa; }
        .project-actions { display: flex; align-items: center; gap: 0.75rem; }
        .btn-action-edit { background: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.3); padding: 0.4rem 0.8rem; border-radius: 6px; font-weight: 600; font-size: 0.8rem; cursor: pointer; }
        .btn-action-delete { background: rgba(239, 68, 68, 0.15); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3); padding: 0.4rem 0.8rem; border-radius: 6px; font-weight: 600; font-size: 0.8rem; cursor: pointer; }

        .btn-category-chip {
            background: #18181b;
            color: #d4d4d8;
            border: 1px solid rgba(255, 255, 255, 0.15);
            padding: 0.3rem 0.75rem;
            border-radius: 100px;
            font-size: 0.78rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .btn-category-chip:hover {
            background: #3b82f6;
            color: #ffffff;
            border-color: #3b82f6;
        }

        /* Modal Styles */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.85);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            overflow-y: auto;
        }
        .modal-overlay.active { display: flex; }
        .modal-box {
            background: #121215;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 16px;
            padding: 2rem;
            max-width: 700px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
        }
        .modal-title { font-size: 1.3rem; font-weight: 800; margin-bottom: 1.5rem; }
    </style>
</head>
<body>

    <aside>
        <div>
            <div class="sidebar-brand">⚡ Admin Console</div>
            <ul class="sidebar-menu">
                <li class="sidebar-item">
                    <div class="sidebar-link active" onclick="switchTab('hero')">🖥️ Hero Section</div>
                </li>
                <li class="sidebar-item">
                    <div class="sidebar-link" onclick="switchTab('projects')">🚀 Projects Section</div>
                </li>
                <li class="sidebar-item">
                    <div class="sidebar-link" onclick="switchTab('categories')">🏷️ Project Categories</div>
                </li>
                <li class="sidebar-item">
                    <div class="sidebar-link" onclick="switchTab('experience')">💼 Work Experience</div>
                </li>
            </ul>
        </div>
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">🚪 Sign Out</button>
        </form>
    </aside>

    <main>
        <div class="page-header">
            <h1 class="page-title" id="pageTitle">Manage Hero Section</h1>
            <a href="{{ route('portfolio.index') }}" target="_blank" class="btn-view-site">👁️ View Live Website</a>
        </div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <!-- TAB 1: HERO SECTION -->
        <div id="tab-hero" class="admin-tab active">
            <form id="heroForm" action="{{ route('admin.hero.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="cropped_avatar" id="croppedAvatarInput">

                <div class="card">
                    <div class="card-header">General Header & Branding</div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Brand Logo Name</label>
                            <input type="text" name="brand_name" value="{{ old('brand_name', $hero->brand_name ?? "Sazzad's Dev.") }}" required>
                        </div>
                        <div class="form-group">
                            <label>Let's Talk Button Text</label>
                            <input type="text" name="talk_button_text" value="{{ old('talk_button_text', $hero->talk_button_text ?? "LET'S TALK") }}">
                        </div>
                        <div class="form-group">
                            <label>Let's Talk Button Link (URL / Anchor)</label>
                            <input type="text" name="talk_button_url" value="{{ old('talk_button_url', $hero->talk_button_url ?? "#contact") }}">
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">Hero Left Side Content</div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Your Name</label>
                            <input type="text" name="name" value="{{ old('name', $hero->name ?? "Sazzad Hossain") }}" required>
                        </div>
                        <div class="form-group">
                            <label>Work Details / Tagline</label>
                            <input type="text" name="work_details" value="{{ old('work_details', $hero->work_details ?? "Full-Stack Developer & AI Specialist") }}" required>
                        </div>
                        <div class="form-group full-width">
                            <label>Description</label>
                            <textarea name="description">{{ old('description', $hero->description ?? "") }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Consultancy Button Text</label>
                            <input type="text" name="consultancy_button_text" value="{{ old('consultancy_button_text', $hero->consultancy_button_text ?? "GET FREE CONSULTANCY") }}">
                        </div>
                        <div class="form-group">
                            <label>Consultancy Button Link (URL / Anchor)</label>
                            <input type="text" name="consultancy_button_url" value="{{ old('consultancy_button_url', $hero->consultancy_button_url ?? "#contact") }}">
                        </div>
                        <div class="form-group full-width">
                            <label>Upload & Crop Profile Avatar Image</label>
                            <input type="file" id="avatarFileInput" accept="image/*">
                            <div class="media-preview" id="avatarPreviewBox">
                                @if(!empty($hero->avatar_path))
                                    <img id="avatarPreviewImg" src="{{ asset('storage/' . $hero->avatar_path) }}" alt="Avatar Preview">
                                @else
                                    <img id="avatarPreviewImg" src="" alt="Avatar Preview" style="display:none;">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">Hero Right Side Media (Video Run Section)</div>
                    <div class="form-group">
                        <label>Upload Auto-Playing Video (MP4 / WebM)</label>
                        <input type="file" name="video" accept="video/mp4,video/webm">
                        @if(!empty($hero->video_path))
                            <div class="media-preview" style="max-width: 240px; max-height: 140px;">
                                <video muted autoplay loop style="width:100%; height:100%; object-fit:cover;">
                                    <source src="{{ asset('storage/' . $hero->video_path) }}" type="video/mp4">
                                </video>
                            </div>
                        @endif
                    </div>
                </div>

                <button type="submit" class="btn-save">💾 Save & Update Hero Section</button>
            </form>
        </div>

        <!-- TAB 2: PROJECTS SECTION -->
        <div id="tab-projects" class="admin-tab">
            <div class="card">
                <div class="card-header">
                    <span>All Portfolio Projects (Drag & Drop to Reorder)</span>
                    <button class="btn-add-project" onclick="openAddProjectModal()">➕ Add New Project</button>
                </div>

                <div class="project-list-container" id="sortableProjectList">
                    @foreach($projects as $proj)
                        <div class="project-item-card" data-id="{{ $proj->id }}">
                            <div class="project-item-left">
                                <div class="drag-handle">☰</div>
                                <div class="project-thumb">
                                    @if($proj->cover_image)
                                        <img src="{{ asset('storage/' . $proj->cover_image) }}" alt="{{ $proj->title }}">
                                    @else
                                        <div style="color:#52525b; text-align:center; padding-top:18px; font-size:0.7rem;">No Image</div>
                                    @endif
                                </div>
                                <div>
                                    <div class="project-meta-title">{{ $proj->title }}</div>
                                    <div class="project-meta-tags">{{ $proj->category_tags ?? 'General Project' }}</div>
                                </div>
                            </div>
                            <div class="project-actions">
                                <button class="btn-action-edit" onclick='openEditProjectModal(@json($proj))'>✏️ Edit</button>
                                <form action="{{ route('admin.projects.delete', $proj->id) }}" method="POST" onsubmit="return confirm('Delete this project?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action-delete">🗑️ Delete</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- TAB 3: CATEGORIES SECTION -->
        <div id="tab-categories" class="admin-tab">
            <div class="card">
                <div class="card-header">
                    <span>Create New Category</span>
                </div>
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Category Name</label>
                            <input type="text" name="name" required placeholder="e.g. Mobile App, Product Design">
                        </div>
                        <div class="form-group" style="display:flex; align-items:flex-end;">
                            <button type="submit" class="btn-save" style="margin-bottom:1.25rem;">Add Category</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card">
                <div class="card-header">All Project Categories</div>
                <div style="display:flex; flex-direction:column; gap:0.75rem;">
                    @foreach($categories as $cat)
                        <div style="background:#18181b; border:1px solid rgba(255,255,255,0.1); border-radius:10px; padding:0.75rem 1.25rem; display:flex; justify-content:space-between; align-items:center;">
                            <div>
                                <span style="font-weight:700; color:#fff;">{{ $cat->name }}</span>
                                <span style="font-size:0.8rem; color:#a1a1aa; margin-left:12px;">({{ $cat->slug }})</span>
                            </div>
                            <form action="{{ route('admin.categories.delete', $cat->id) }}" method="POST" onsubmit="return confirm('Delete category?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action-delete">🗑️ Delete</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        <!-- TAB 4: WORK EXPERIENCE SECTION -->
        <div id="tab-experience" class="admin-tab">
            <div class="card">
                <div class="card-header">
                    <span>Work Experience List (Drag & Drop to Reorder)</span>
                    <button class="btn-add-project" onclick="openAddExpModal()">➕ Add New Experience</button>
                </div>

                <div class="project-list-container" id="sortableExpList">
                    @foreach($experiences as $exp)
                        <div class="project-item-card" data-id="{{ $exp->id }}">
                            <div class="project-item-left">
                                <div class="drag-handle">☰</div>
                                <div class="project-thumb" style="width:50px; height:50px; border-radius:50%; background:#1f1f23; display:flex; align-items:center; justify-content:center;">
                                    @if($exp->company_logo)
                                        <img src="{{ asset('storage/' . $exp->company_logo) }}" alt="{{ $exp->company_name }}" style="width:100%; height:100%; object-fit:cover; border-radius:50%;">
                                    @else
                                        <span style="font-size:0.75rem; font-weight:800; color:#3b82f6;">{{ strtoupper(substr($exp->company_name, 0, 2)) }}</span>
                                    @endif
                                </div>
                                <div>
                                    <div class="project-meta-title">{{ $exp->company_name }} @if($exp->location)<span style="font-size:0.8rem; font-weight:500; color:#a1a1aa;">— {{ $exp->location }}</span>@endif</div>
                                    <div class="project-meta-tags"><strong style="color:#60a5fa;">{{ $exp->designation }}</strong> | {{ $exp->duration }}</div>
                                </div>
                            </div>
                            <div class="project-actions">
                                <button class="btn-action-edit" onclick='openEditExpModal(@json($exp))'>✏️ Edit</button>
                                <form action="{{ route('admin.experiences.delete', $exp->id) }}" method="POST" onsubmit="return confirm('Delete this experience?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action-delete">🗑️ Delete</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>

    <!-- Cropper Modal -->
    <div class="cropper-modal-container" id="cropperModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.85); z-index:9999; align-items:center; justify-content:center; padding:2rem;">
        <div class="cropper-modal-box" style="background:#18181b; border:1px solid rgba(255,255,255,0.15); border-radius:16px; padding:1.5rem; max-width:600px; width:100%; display:flex; flex-direction:column; gap:1rem;">
            <h3 style="font-size: 1.1rem; font-weight: 700;">Crop Profile Avatar</h3>
            <div class="cropper-img-wrapper" style="max-height:400px; overflow:hidden; border-radius:8px; background:#09090b;">
                <img id="cropperImage" src="" style="max-width:100%;">
            </div>
            <div class="cropper-actions" style="display:flex; justify-flex:end; gap:1rem;">
                <button type="button" class="btn-crop-cancel" id="btnCancelCrop">Cancel</button>
                <button type="button" class="btn-crop-confirm" id="btnConfirmCrop">Apply Crop</button>
            </div>
        </div>
    </div>

    <!-- Create Project Modal -->
    <div class="modal-overlay" id="addProjectModal">
        <div class="modal-box">
            <h3 class="modal-title">Create New Project</h3>
            <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Project Title</label>
                    <input type="text" name="title" required placeholder="e.g. Qanun Marketplace">
                </div>
                <div class="form-group">
                    <label>Subtitle / Short Summary</label>
                    <input type="text" name="sub_title" placeholder="e.g. Avianicare online shop, trusted for pet lovers">
                </div>
                <div class="form-group">
                    <label>Category Tags (Type custom tags OR click categories below to select)</label>
                    <input type="text" name="category_tags" id="add_category_tags" placeholder="e.g. Product Design, Custom Development">
                    <div style="margin-top:0.75rem; display:flex; flex-wrap:wrap; gap:8px;">
                        <span style="font-size:0.75rem; color:#a1a1aa; width:100%;">Select from created categories:</span>
                        @foreach($categories as $cat)
                            <button type="button" class="btn-category-chip" onclick="toggleAddCategoryTag('{{ $cat->name }}')">
                                + {{ $cat->name }}
                            </button>
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label>Full Description (Appears in detail popup)</label>
                    <textarea name="description" placeholder="Enter detailed overview of the project..."></textarea>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Live Website URL</label>
                        <input type="text" name="live_website_url" placeholder="https://example.com">
                    </div>
                    <div class="form-group">
                        <label>Live Mobile App URL</label>
                        <input type="text" name="live_mobile_app_url" placeholder="https://example.com/app">
                    </div>
                </div>
                <div class="form-group">
                    <label>Cover Image (Carousel Display Card)</label>
                    <input type="file" name="cover_image" accept="image/*">
                </div>
                <div class="form-group">
                    <label>Detail Showcase Gallery Images (Multiple)</label>
                    <input type="file" name="detail_images[]" accept="image/*" multiple>
                </div>
                <div class="form-group" style="display:flex; align-items:center; gap:8px;">
                    <input type="checkbox" name="is_featured" value="1" id="add_is_featured" checked>
                    <label for="add_is_featured" style="margin:0;">Show on Website Carousel</label>
                </div>
                <div style="display:flex; justify-content:flex-end; gap:1rem; margin-top:1.5rem;">
                    <button type="button" class="btn-crop-cancel" onclick="closeAddProjectModal()">Cancel</button>
                    <button type="submit" class="btn-save">Save Project</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Project Modal -->
    <div class="modal-overlay" id="editProjectModal">
        <div class="modal-box">
            <h3 class="modal-title">Edit Project</h3>
            <form id="editProjectForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Project Title</label>
                    <input type="text" name="title" id="edit_title" required>
                </div>
                <div class="form-group">
                    <label>Subtitle / Short Summary</label>
                    <input type="text" name="sub_title" id="edit_sub_title">
                </div>
                <div class="form-group">
                    <label>Category Tags (Type custom tags OR click categories below to select)</label>
                    <input type="text" name="category_tags" id="edit_category_tags">
                    <div style="margin-top:0.75rem; display:flex; flex-wrap:wrap; gap:8px;">
                        <span style="font-size:0.75rem; color:#a1a1aa; width:100%;">Select from created categories:</span>
                        @foreach($categories as $cat)
                            <button type="button" class="btn-category-chip" onclick="toggleEditCategoryTag('{{ $cat->name }}')">
                                + {{ $cat->name }}
                            </button>
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label>Full Description</label>
                    <textarea name="description" id="edit_description"></textarea>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Live Website URL</label>
                        <input type="text" name="live_website_url" id="edit_live_website_url">
                    </div>
                    <div class="form-group">
                        <label>Live Mobile App URL</label>
                        <input type="text" name="live_mobile_app_url" id="edit_live_mobile_app_url">
                    </div>
                </div>
                <div class="form-group">
                    <label>Change Cover Image</label>
                    <input type="file" name="cover_image" accept="image/*">
                </div>
                <div class="form-group">
                    <label>Add Additional Showcase Images</label>
                    <input type="file" name="detail_images[]" accept="image/*" multiple>
                </div>
                <div class="form-group" style="display:flex; align-items:center; gap:8px;">
                    <input type="checkbox" name="is_featured" value="1" id="edit_is_featured">
                    <label for="edit_is_featured" style="margin:0;">Show on Website Carousel</label>
                </div>
                <div style="display:flex; justify-content:flex-end; gap:1rem; margin-top:1.5rem;">
                    <button type="button" class="btn-crop-cancel" onclick="closeEditProjectModal()">Cancel</button>
                    <button type="submit" class="btn-save">Update Project</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Create Experience Modal -->
    <div class="modal-overlay" id="addExpModal">
        <div class="modal-box">
            <h3 class="modal-title">Add Work Experience</h3>
            <form action="{{ route('admin.experiences.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Company Name</label>
                    <input type="text" name="company_name" required placeholder="e.g. Softvence Agency">
                </div>
                <div class="form-group">
                    <label>Location (City / Country)</label>
                    <input type="text" name="location" placeholder="e.g. Dhaka">
                </div>
                <div class="form-group">
                    <label>Designation / Role</label>
                    <input type="text" name="designation" required placeholder="e.g. Mid-level Laravel Developer">
                </div>
                <div class="form-group">
                    <label>Duration / Period</label>
                    <input type="text" name="duration" required placeholder="e.g. July 2025 - Present">
                </div>
                <div class="form-group">
                    <label>Company Logo Image (Optional)</label>
                    <input type="file" name="company_logo" accept="image/*">
                </div>
                <div style="display:flex; justify-content:flex-end; gap:1rem; margin-top:1.5rem;">
                    <button type="button" class="btn-crop-cancel" onclick="closeAddExpModal()">Cancel</button>
                    <button type="submit" class="btn-save">Save Experience</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Experience Modal -->
    <div class="modal-overlay" id="editExpModal">
        <div class="modal-box">
            <h3 class="modal-title">Edit Work Experience</h3>
            <form id="editExpForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Company Name</label>
                    <input type="text" name="company_name" id="edit_exp_company_name" required>
                </div>
                <div class="form-group">
                    <label>Location (City / Country)</label>
                    <input type="text" name="location" id="edit_exp_location">
                </div>
                <div class="form-group">
                    <label>Designation / Role</label>
                    <input type="text" name="designation" id="edit_exp_designation" required>
                </div>
                <div class="form-group">
                    <label>Duration / Period</label>
                    <input type="text" name="duration" id="edit_exp_duration" required>
                </div>
                <div class="form-group">
                    <label>Change Company Logo</label>
                    <input type="file" name="company_logo" accept="image/*">
                </div>
                <div style="display:flex; justify-content:flex-end; gap:1rem; margin-top:1.5rem;">
                    <button type="button" class="btn-crop-cancel" onclick="closeEditExpModal()">Cancel</button>
                    <button type="submit" class="btn-save">Update Experience</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
    <script>
        function switchTab(tabName) {
            document.querySelectorAll('.admin-tab').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('.sidebar-link').forEach(el => el.classList.remove('active'));

            if (tabName === 'hero') {
                document.getElementById('tab-hero').classList.add('active');
                document.querySelectorAll('.sidebar-link')[0].classList.add('active');
                document.getElementById('pageTitle').innerText = 'Manage Hero Section';
            } else if (tabName === 'projects') {
                document.getElementById('tab-projects').classList.add('active');
                document.querySelectorAll('.sidebar-link')[1].classList.add('active');
                document.getElementById('pageTitle').innerText = 'Manage Projects Section';
            } else if (tabName === 'categories') {
                document.getElementById('tab-categories').classList.add('active');
                document.querySelectorAll('.sidebar-link')[2].classList.add('active');
                document.getElementById('pageTitle').innerText = 'Manage Project Categories';
            } else if (tabName === 'experience') {
                document.getElementById('tab-experience').classList.add('active');
                document.querySelectorAll('.sidebar-link')[3].classList.add('active');
                document.getElementById('pageTitle').innerText = 'Manage Work Experience';
            }
        }

        // Modals
        function openAddProjectModal() { document.getElementById('addProjectModal').classList.add('active'); }
        function closeAddProjectModal() { document.getElementById('addProjectModal').classList.remove('active'); }

        function openAddExpModal() { document.getElementById('addExpModal').classList.add('active'); }
        function closeAddExpModal() { document.getElementById('addExpModal').classList.remove('active'); }

        function openEditExpModal(exp) {
            const form = document.getElementById('editExpForm');
            form.action = '/admin/experiences/' + exp.id + '/update';
            document.getElementById('edit_exp_company_name').value = exp.company_name || '';
            document.getElementById('edit_exp_location').value = exp.location || '';
            document.getElementById('edit_exp_designation').value = exp.designation || '';
            document.getElementById('edit_exp_duration').value = exp.duration || '';
            document.getElementById('editExpModal').classList.add('active');
        }
        function closeEditExpModal() { document.getElementById('editExpModal').classList.remove('active'); }

        function toggleAddCategoryTag(catName) {
            const input = document.getElementById('add_category_tags');
            let tags = input.value.split(',').map(t => t.trim()).filter(t => t.length > 0);
            if (tags.includes(catName)) {
                tags = tags.filter(t => t !== catName);
            } else {
                tags.push(catName);
            }
            input.value = tags.join(', ');
        }

        function toggleEditCategoryTag(catName) {
            const input = document.getElementById('edit_category_tags');
            let tags = input.value.split(',').map(t => t.trim()).filter(t => t.length > 0);
            if (tags.includes(catName)) {
                tags = tags.filter(t => t !== catName);
            } else {
                tags.push(catName);
            }
            input.value = tags.join(', ');
        }

        function openEditProjectModal(project) {
            const form = document.getElementById('editProjectForm');
            form.action = '/admin/projects/' + project.id + '/update';
            document.getElementById('edit_title').value = project.title || '';
            document.getElementById('edit_sub_title').value = project.sub_title || '';
            document.getElementById('edit_category_tags').value = project.category_tags || '';
            document.getElementById('edit_description').value = project.description || '';
            document.getElementById('edit_live_website_url').value = project.live_website_url || '';
            document.getElementById('edit_live_mobile_app_url').value = project.live_mobile_app_url || '';
            document.getElementById('edit_is_featured').checked = project.is_featured ? true : false;
            document.getElementById('editProjectModal').classList.add('active');
        }
        function closeEditProjectModal() { document.getElementById('editProjectModal').classList.remove('active'); }

        // Sortable Drag & Drop Reordering
        document.addEventListener('DOMContentLoaded', function() {
            const listElem = document.getElementById('sortableProjectList');
            if (listElem) {
                new Sortable(listElem, {
                    handle: '.drag-handle',
                    animation: 150,
                    onEnd: function() {
                        const order = [];
                        document.querySelectorAll('#sortableProjectList .project-item-card').forEach(item => {
                            order.push(item.getAttribute('data-id'));
                        });

                        fetch('/admin/projects/reorder', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ order: order })
                        });
                    }
                });
            const expListElem = document.getElementById('sortableExpList');
            if (expListElem) {
                new Sortable(expListElem, {
                    handle: '.drag-handle',
                    animation: 150,
                    onEnd: function() {
                        const order = [];
                        document.querySelectorAll('#sortableExpList .project-item-card').forEach(item => {
                            order.push(item.getAttribute('data-id'));
                        });

                        fetch('/admin/experiences/reorder', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ order: order })
                        });
                    }
                });
            }

            // Cropper setup
            const avatarFileInput = document.getElementById('avatarFileInput');
            const cropperModal = document.getElementById('cropperModal');
            const cropperImage = document.getElementById('cropperImage');
            const btnCancelCrop = document.getElementById('btnCancelCrop');
            const btnConfirmCrop = document.getElementById('btnConfirmCrop');
            const croppedAvatarInput = document.getElementById('croppedAvatarInput');
            const avatarPreviewImg = document.getElementById('avatarPreviewImg');

            let cropper = null;

            if (avatarFileInput) {
                avatarFileInput.addEventListener('change', function(e) {
                    const files = e.target.files;
                    if (files && files.length > 0) {
                        const file = files[0];
                        const reader = new FileReader();
                        reader.onload = function(evt) {
                            cropperImage.src = evt.target.result;
                            cropperModal.style.display = 'flex';

                            if (cropper) { cropper.destroy(); }

                            cropper = new Cropper(cropperImage, {
                                aspectRatio: 1,
                                viewMode: 1,
                                dragMode: 'move',
                                autoCropArea: 1,
                                restore: false,
                                guides: true,
                                center: true,
                                highlight: false,
                                cropBoxMovable: true,
                                cropBoxResizable: true,
                            });
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            if (btnCancelCrop) {
                btnCancelCrop.addEventListener('click', function() {
                    cropperModal.style.display = 'none';
                    if (cropper) { cropper.destroy(); cropper = null; }
                    avatarFileInput.value = '';
                });
            }

            if (btnConfirmCrop) {
                btnConfirmCrop.addEventListener('click', function() {
                    if (cropper) {
                        const canvas = cropper.getCroppedCanvas({ width: 500, height: 500 });
                        const base64Image = canvas.toDataURL('image/jpeg', 0.92);
                        croppedAvatarInput.value = base64Image;
                        avatarPreviewImg.src = base64Image;
                        avatarPreviewImg.style.display = 'block';
                        cropperModal.style.display = 'none';
                        cropper.destroy();
                        cropper = null;
                    }
                });
            }
        });
    </script>
</body>
</html>
