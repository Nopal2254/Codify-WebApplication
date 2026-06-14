@extends('layouts.app')

@section('title', 'Edit Course | Codify')
@section('page-title', 'Edit Course')

@section('extra-css')
<style>
    /* ── Zero Digital Overrides ────────────── */
    .edit-page {
        --zd-accent: #6366f1;
        --zd-accent-dark: #4f46e5;
        --zd-bg: #0A0A0A;
        --zd-card: #141414;
        --zd-card2: #1A1A1A;
        --zd-border: rgba(255,255,255,0.08);
        --zd-border-md: rgba(255,255,255,0.15);
        --zd-text: #FFFFFF;
        --zd-text2: #A0A0A0;
        --zd-muted: #666666;
    }

    .edit-page {
        min-height: calc(100vh - 70px);
        padding: 40px 0 80px;
    }

    .edit-inner {
        max-width: 780px;
        margin: 0 auto;
        padding: 0 24px;
    }

    /* ── Back Link ────────────── */
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 500;
        color: var(--zd-text2);
        margin-bottom: 28px;
        transition: all 0.2s ease;
    }
    .back-link:hover {
        color: var(--zd-accent);
    }
    .back-link i {
        font-size: 12px;
        transition: transform 0.2s ease;
    }
    .back-link:hover i {
        transform: translateX(-3px);
    }

    /* ── Page Heading ────────────── */
    .page-heading {
        margin-bottom: 32px;
    }
    .page-heading h1 {
        font-size: 28px;
        font-weight: 800;
        color: var(--zd-text);
        letter-spacing: -0.5px;
        margin-bottom: 6px;
    }
    .page-heading p {
        font-size: 15px;
        color: var(--zd-text2);
        line-height: 1.5;
    }

    /* ── Form Card ────────────── */
    .form-card {
        background: var(--zd-card);
        border: 1px solid var(--zd-border);
        border-radius: 16px;
        overflow: hidden;
    }
    .form-card-body {
        padding: 36px;
    }

    /* ── Section Divider ────────────── */
    .form-section {
        margin-bottom: 32px;
    }
    .form-section:last-child {
        margin-bottom: 0;
    }
    .form-section-title {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: var(--zd-accent);
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 1px solid var(--zd-border);
    }

    /* ── Form Controls ────────────── */
    .zd-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: var(--zd-text2);
        margin-bottom: 8px;
    }
    .zd-label .required {
        color: var(--zd-accent);
        margin-left: 2px;
    }

    .zd-input {
        width: 100%;
        padding: 12px 16px;
        background: var(--zd-card2);
        border: 1.5px solid var(--zd-border);
        border-radius: 10px;
        font-family: 'Okta Neue', sans-serif;
        font-size: 14px;
        color: var(--zd-text);
        outline: none;
        transition: all 0.2s ease;
    }
    .zd-input::placeholder {
        color: var(--zd-muted);
    }
    .zd-input:focus {
        border-color: var(--zd-accent);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.12);
        background: var(--zd-card);
    }
    .zd-input.is-invalid {
        border-color: #EF4444;
    }

    select.zd-input {
        appearance: none;
        cursor: pointer;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23666' d='M6 8.825a.5.5 0 0 1-.354-.146l-4-4a.5.5 0 0 1 .708-.708L6 7.617l3.646-3.646a.5.5 0 0 1 .708.708l-4 4A.5.5 0 0 1 6 8.825z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        padding-right: 36px;
    }
    select.zd-input option {
        background: var(--zd-card2);
        color: var(--zd-text);
    }

    textarea.zd-input {
        resize: vertical;
        min-height: 120px;
        line-height: 1.6;
    }

    .form-row-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-field {
        margin-bottom: 20px;
    }

    /* ── Validation Error ────────────── */
    .field-error {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        color: #EF4444;
        margin-top: 6px;
    }
    .field-error i {
        font-size: 11px;
        flex-shrink: 0;
    }

    /* ── Current Thumbnail Preview ────────────── */
    .current-thumb {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        height: 200px;
        max-width: 360px;
        margin-bottom: 16px;
        border: 1px solid var(--zd-border);
    }
    .current-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .current-thumb-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.55);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
        opacity: 0;
        transition: opacity 0.25s ease;
    }
    .current-thumb:hover .current-thumb-overlay {
        opacity: 1;
    }
    .current-thumb-overlay span {
        font-size: 12px;
        color: rgba(255,255,255,0.7);
    }
    .current-thumb-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        padding: 4px 10px;
        background: rgba(0,0,0,0.6);
        backdrop-filter: blur(8px);
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
        color: rgba(255,255,255,0.8);
    }

    /* ── File Upload / Drag-Drop ────────────── */
    .file-drop-area {
        position: relative;
        border: 2px dashed var(--zd-border-md);
        border-radius: 12px;
        padding: 40px 24px;
        text-align: center;
        transition: all 0.25s ease;
        cursor: pointer;
        background: var(--zd-card2);
    }
    .file-drop-area:hover,
    .file-drop-area.is-dragover {
        border-color: var(--zd-accent);
        background: rgba(99, 102, 241, 0.04);
    }
    .file-drop-icon {
        width: 56px;
        height: 56px;
        margin: 0 auto 16px;
        background: rgba(99, 102, 241, 0.1);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: var(--zd-accent);
    }
    .file-drop-text {
        font-size: 14px;
        color: var(--zd-text2);
        line-height: 1.5;
    }
    .file-drop-text strong {
        color: var(--zd-accent);
        font-weight: 600;
    }
    .file-drop-hint {
        font-size: 12px;
        color: var(--zd-muted);
        margin-top: 8px;
    }
    .file-drop-input {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }
    .file-drop-preview {
        display: none;
        margin-top: 16px;
        padding: 12px 16px;
        background: rgba(99, 102, 241, 0.06);
        border: 1px solid rgba(99, 102, 241, 0.15);
        border-radius: 8px;
        font-size: 13px;
        color: var(--zd-text);
        align-items: center;
        gap: 10px;
    }
    .file-drop-preview.active {
        display: flex;
    }
    .file-drop-preview i {
        color: var(--zd-accent);
    }
    .file-drop-preview .file-name {
        flex: 1;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* ── Card Footer / Actions ────────────── */
    .form-card-footer {
        padding: 20px 36px;
        border-top: 1px solid var(--zd-border);
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 12px;
        background: rgba(10, 10, 10, 0.5);
    }

    .btn-zd-cancel {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 24px;
        background: transparent;
        border: 1.5px solid var(--zd-border-md);
        border-radius: 10px;
        font-family: 'Okta Neue', sans-serif;
        font-size: 14px;
        font-weight: 600;
        color: var(--zd-text2);
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    .btn-zd-cancel:hover {
        border-color: var(--zd-text2);
        color: var(--zd-text);
        background: var(--zd-card2);
    }

    .btn-zd-primary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 28px;
        background: var(--zd-accent);
        border: 1.5px solid var(--zd-accent);
        border-radius: 10px;
        font-family: 'Okta Neue', sans-serif;
        font-size: 14px;
        font-weight: 700;
        color: #FFFFFF;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-zd-primary:hover {
        background: var(--zd-accent-dark);
        border-color: var(--zd-accent-dark);
        box-shadow: 0 4px 20px rgba(99, 102, 241, 0.3);
        transform: translateY(-1px);
    }

    /* ── Danger Zone ────────────── */
    .danger-zone {
        margin-top: 32px;
    }
    .danger-zone-card {
        background: var(--zd-card);
        border: 1px solid rgba(239, 68, 68, 0.2);
        border-radius: 16px;
        overflow: hidden;
    }
    .danger-zone-body {
        padding: 28px 36px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }
    .danger-zone-info {
        flex: 1;
    }
    .danger-zone-title {
        font-size: 15px;
        font-weight: 700;
        color: #EF4444;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .danger-zone-title i {
        font-size: 14px;
    }
    .danger-zone-text {
        font-size: 13px;
        color: var(--zd-text2);
        line-height: 1.5;
    }

    .btn-zd-danger {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 24px;
        background: transparent;
        border: 1.5px solid rgba(239, 68, 68, 0.4);
        border-radius: 10px;
        font-family: 'Okta Neue', sans-serif;
        font-size: 14px;
        font-weight: 600;
        color: #EF4444;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    .btn-zd-danger:hover {
        background: rgba(239, 68, 68, 0.1);
        border-color: #EF4444;
        box-shadow: 0 4px 16px rgba(239, 68, 68, 0.15);
    }

    /* ── Responsive ────────────── */
    @media (max-width: 640px) {
        .form-card-body {
            padding: 24px 20px;
        }
        .form-card-footer {
            padding: 16px 20px;
            flex-direction: column-reverse;
        }
        .form-card-footer .btn-zd-cancel,
        .form-card-footer .btn-zd-primary {
            width: 100%;
            justify-content: center;
        }
        .form-row-2 {
            grid-template-columns: 1fr;
        }
        .page-heading h1 {
            font-size: 24px;
        }
        .danger-zone-body {
            flex-direction: column;
            align-items: flex-start;
            padding: 24px 20px;
        }
        .btn-zd-danger {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<div class="edit-page">
    <div class="edit-inner">

        {{-- Back Link --}}
        <a href="{{ route('teacher.courses.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to My Courses
        </a>

        {{-- Page Heading --}}
        <div class="page-heading">
            <h1>Edit Course</h1>
            <p>Update the details of your existing course.</p>
        </div>

        {{-- Form Card --}}
        <div class="form-card">
            <form id="edit-form" action="{{ route('teacher.courses.update', $course) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-card-body">

                    {{-- Section: Basic Info --}}
                    <div class="form-section">
                        <div class="form-section-title">Basic Information</div>

                        <div class="form-field">
                            <label class="zd-label" for="title">Course Title <span class="required">*</span></label>
                            <input
                                type="text"
                                id="title"
                                name="title"
                                class="zd-input @error('title') is-invalid @enderror"
                                value="{{ old('title', $course->title) }}"
                                placeholder="e.g. Advanced JavaScript Concepts"
                                required
                            >
                            @error('title')
                                <div class="field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-row-2">
                            <div class="form-field">
                                <label class="zd-label" for="category_id">Category <span class="required">*</span></label>
                                <select
                                    id="category_id"
                                    name="category_id"
                                    class="zd-input @error('category_id') is-invalid @enderror"
                                    required
                                >
                                    <option value="">Select a category...</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $course->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label class="zd-label" for="level">Level <span class="required">*</span></label>
                                <select
                                    id="level"
                                    name="level"
                                    class="zd-input @error('level') is-invalid @enderror"
                                    required
                                >
                                    <option value="Beginner" {{ old('level', $course->level) == 'Beginner' ? 'selected' : '' }}>Beginner</option>
                                    <option value="Intermediate" {{ old('level', $course->level) == 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                                    <option value="Advanced" {{ old('level', $course->level) == 'Advanced' ? 'selected' : '' }}>Advanced</option>
                                </select>
                                @error('level')
                                    <div class="field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-field">
                            <label class="zd-label" for="description">Description <span class="required">*</span></label>
                            <textarea
                                id="description"
                                name="description"
                                class="zd-input @error('description') is-invalid @enderror"
                                rows="5"
                                placeholder="Describe what students will learn in this course..."
                                required
                            >{{ old('description', $course->description) }}</textarea>
                            @error('description')
                                <div class="field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Section: Pricing --}}
                    <div class="form-section">
                        <div class="form-section-title">Pricing</div>

                        <div class="form-field" style="max-width: 360px;">
                            <label class="zd-label" for="price">Price ($)</label>
                            <input
                                type="number"
                                id="price"
                                name="price"
                                class="zd-input @error('price') is-invalid @enderror"
                                value="{{ old('price', $course->price) }}"
                                placeholder="0.00"
                                min="0"
                                step="0.01"
                            >
                            @error('price')
                                <div class="field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Section: Thumbnail --}}
                    <div class="form-section">
                        <div class="form-section-title">Thumbnail</div>

                        {{-- Show current thumbnail if exists --}}
                        @if($course->thumbnail)
                        <div class="form-field">
                            <label class="zd-label">Current Image</label>
                            <div class="current-thumb">
                                <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}">
                                <div class="current-thumb-badge">
                                    <i class="fas fa-image" style="margin-right: 4px;"></i> Current
                                </div>
                                <div class="current-thumb-overlay">
                                    <i class="fas fa-camera" style="font-size: 20px; color: #fff;"></i>
                                    <span>Upload a new image below to replace</span>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="form-field">
                            <label class="zd-label">{{ $course->thumbnail ? 'Replace Image' : 'Cover Image' }}</label>
                            <div class="file-drop-area" id="file-drop-area">
                                <input
                                    type="file"
                                    id="thumbnail"
                                    name="thumbnail"
                                    class="file-drop-input"
                                    accept="image/png,image/jpeg,image/gif,image/webp"
                                >
                                <div class="file-drop-icon">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                </div>
                                <div class="file-drop-text">
                                    <strong>Click to upload</strong> or drag and drop
                                </div>
                                <div class="file-drop-hint">PNG, JPG, GIF or WebP — max 2MB</div>
                            </div>
                            <div class="file-drop-preview" id="file-preview">
                                <i class="fas fa-image"></i>
                                <span class="file-name" id="file-name"></span>
                            </div>
                            @error('thumbnail')
                                <div class="field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>

                {{-- Footer Actions --}}
                <div class="form-card-footer">
                    <a href="{{ route('teacher.courses.index') }}" class="btn-zd-cancel">Cancel</a>
                    <button type="submit" class="btn-zd-primary">
                        <i class="fas fa-save"></i> Update Course
                    </button>
                </div>
            </form>
        </div>

        {{-- Danger Zone: Delete --}}
        <div class="danger-zone">
            <div class="danger-zone-card">
                <div class="danger-zone-body">
                    <div class="danger-zone-info">
                        <div class="danger-zone-title">
                            <i class="fas fa-exclamation-triangle"></i> Delete this course
                        </div>
                        <p class="danger-zone-text">
                            Once you delete a course, all of its content, enrollments, and data will be permanently removed. This action cannot be undone.
                        </p>
                    </div>
                    <form id="delete-form" action="{{ route('teacher.courses.destroy', $course) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this course? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-zd-danger">
                            <i class="fas fa-trash-alt"></i> Delete Course
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('extra-js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const dropArea = document.getElementById('file-drop-area');
    const fileInput = document.getElementById('thumbnail');
    const preview   = document.getElementById('file-preview');
    const fileName  = document.getElementById('file-name');

    // Show selected file name
    fileInput.addEventListener('change', function () {
        if (this.files && this.files.length > 0) {
            fileName.textContent = this.files[0].name;
            preview.classList.add('active');
        } else {
            preview.classList.remove('active');
        }
    });

    // Drag-and-drop visual feedback
    ['dragenter', 'dragover'].forEach(evt => {
        dropArea.addEventListener(evt, function (e) {
            e.preventDefault();
            dropArea.classList.add('is-dragover');
        });
    });
    ['dragleave', 'drop'].forEach(evt => {
        dropArea.addEventListener(evt, function (e) {
            e.preventDefault();
            dropArea.classList.remove('is-dragover');
        });
    });
    dropArea.addEventListener('drop', function (e) {
        if (e.dataTransfer.files.length > 0) {
            fileInput.files = e.dataTransfer.files;
            fileInput.dispatchEvent(new Event('change'));
        }
    });
});
</script>
@endsection
