@extends('admin.layouts.app')

@section('title', __('Global Settings'))

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 bg-white">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="rounded-3 p-3 bg-primary bg-opacity-10 text-primary">
                            <i class="fa-solid fa-sliders fa-2x"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1 text-dark">{{ __('Global Settings') }}</h4>
                            <p class="text-muted small mb-0">{{ __('Manage your platform name, branding, social networks, and other general configurations.') }}</p>
                        </div>
                    </div>

                    <!-- Tabs Navigation -->
                    <ul class="nav nav-pills nav-fill bg-light p-1.5 rounded-3 mb-4" id="settingsTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active py-2.5 rounded-3 fw-semibold d-flex align-items-center justify-content-center gap-2" 
                                    id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab">
                                <i class="fa-solid fa-circle-info"></i> {{ __('General Info') }}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link py-2.5 rounded-3 fw-semibold d-flex align-items-center justify-content-center gap-2" 
                                    id="contacts-tab" data-bs-toggle="tab" data-bs-target="#contacts" type="button" role="tab">
                                <i class="fa-solid fa-share-nodes"></i> {{ __('Contacts & Socials') }}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link py-2.5 rounded-3 fw-semibold d-flex align-items-center justify-content-center gap-2" 
                                    id="video-tab" data-bs-toggle="tab" data-bs-target="#video" type="button" role="tab">
                                <i class="fa-solid fa-play"></i> {{ __('Hero Video') }}
                            </button>
                        </li>
                    </ul>

                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Tabs Content -->
                        <div class="tab-content pt-2" id="settingsTabsContent">
                            
                            <!-- Tab 1: General Info -->
                            <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-dark">{{ __('Site Name') }}</label>
                                            <input type="text" name="site_name" class="form-control rounded-3 py-2.5 @error('site_name') is-invalid @enderror" 
                                                   value="{{ old('site_name', $settings['site_name'] ?? 'Codify') }}" 
                                                   placeholder="e.g. Codify">
                                            @error('site_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-dark">{{ __('Site Description / Slogan') }}</label>
                                            <textarea name="site_description" class="form-control rounded-3 @error('site_description') is-invalid @enderror" 
                                                      rows="5" placeholder="{{ __('Build skills with courses, certificates, and degrees online...') }}">{{ old('site_description', $settings['site_description'] ?? '') }}</textarea>
                                            @error('site_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <!-- Logo Upload -->
                                        <div class="mb-4 p-3 border border-dashed rounded-4 bg-light bg-opacity-50">
                                            <label class="form-label fw-bold text-dark d-block mb-2">{{ __('Site Logo') }}</label>
                                            
                                            <div class="d-flex align-items-center gap-3 mb-3">
                                                <div class="logo-preview-box rounded-3 border bg-dark d-flex align-items-center justify-content-center p-2" style="width: 120px; height: 60px; overflow: hidden;">
                                                    @if(isset($settings['site_logo']))
                                                        <img id="logo-preview" src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Logo Preview" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                                                    @else
                                                        <span id="logo-placeholder" class="text-white-50 text-xs">No logo</span>
                                                    @endif
                                                </div>
                                                <div>
                                                    <span class="text-muted small d-block mb-1">{{ __('PNG, JPG, SVG, WebP up to 2MB') }}</span>
                                                    <input type="file" name="site_logo" class="form-control form-control-sm @error('site_logo') is-invalid @enderror" accept="image/*" onchange="previewImage(this, 'logo-preview')">
                                                    @error('site_logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Favicon Upload -->
                                        <div class="mb-3 p-3 border border-dashed rounded-4 bg-light bg-opacity-50">
                                            <label class="form-label fw-bold text-dark d-block mb-2">{{ __('Site Favicon') }}</label>
                                            
                                            <div class="d-flex align-items-center gap-3 mb-3">
                                                <div class="favicon-preview-box rounded-3 border bg-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; overflow: hidden;">
                                                    @if(isset($settings['site_favicon']))
                                                        <img id="favicon-preview" src="{{ asset('storage/' . $settings['site_favicon']) }}" alt="Favicon Preview" style="width: 32px; height: 32px; object-fit: contain;">
                                                    @else
                                                        <i id="favicon-placeholder" class="fa-solid fa-globe fa-lg text-muted"></i>
                                                    @endif
                                                </div>
                                                <div>
                                                    <span class="text-muted small d-block mb-1">{{ __('ICO, PNG, SVG up to 1MB') }}</span>
                                                    <input type="file" name="site_favicon" class="form-control form-control-sm @error('site_favicon') is-invalid @enderror" accept="image/*" onchange="previewImage(this, 'favicon-preview')">
                                                    @error('site_favicon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab 2: Contacts & Socials -->
                            <div class="tab-pane fade" id="contacts" role="tabpanel" aria-labelledby="contacts-tab">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <h5 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="fa-solid fa-address-book me-2 text-primary"></i>{{ __('Contact Channels') }}</h5>
                                        
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-dark">{{ __('Support Email Address') }}</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light text-muted border-end-0"><i class="fa-solid fa-envelope"></i></span>
                                                <input type="email" name="support_email" class="form-control rounded-start-0 py-2.5 @error('support_email') is-invalid @enderror" 
                                                       value="{{ old('support_email', $settings['support_email'] ?? '') }}" 
                                                       placeholder="support@example.com">
                                                @error('support_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-dark">{{ __('Support Phone') }}</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light text-muted border-end-0"><i class="fa-solid fa-phone"></i></span>
                                                <input type="text" name="support_phone" class="form-control rounded-start-0 py-2.5 @error('support_phone') is-invalid @enderror" 
                                                       value="{{ old('support_phone', $settings['support_phone'] ?? '') }}" 
                                                       placeholder="+1 (555) 000-0000">
                                                @error('support_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <h5 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="fa-solid fa-hashtag me-2 text-primary"></i>{{ __('Social Media Links') }}</h5>
                                        
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-dark">Telegram Link</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-info bg-opacity-10 text-info border-end-0"><i class="fa-brands fa-telegram"></i></span>
                                                <input type="url" name="social_telegram" class="form-control rounded-start-0 py-2.5 @error('social_telegram') is-invalid @enderror" 
                                                       value="{{ old('social_telegram', $settings['social_telegram'] ?? '') }}" 
                                                       placeholder="https://t.me/your_channel">
                                                @error('social_telegram')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-dark">Instagram Link</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-danger bg-opacity-10 text-danger border-end-0"><i class="fa-brands fa-instagram"></i></span>
                                                <input type="url" name="social_instagram" class="form-control rounded-start-0 py-2.5 @error('social_instagram') is-invalid @enderror" 
                                                       value="{{ old('social_instagram', $settings['social_instagram'] ?? '') }}" 
                                                       placeholder="https://instagram.com/your_profile">
                                                @error('social_instagram')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-dark">YouTube Link</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-danger bg-opacity-10 text-danger border-end-0"><i class="fa-brands fa-youtube"></i></span>
                                                <input type="url" name="social_youtube" class="form-control rounded-start-0 py-2.5 @error('social_youtube') is-invalid @enderror" 
                                                       value="{{ old('social_youtube', $settings['social_youtube'] ?? '') }}" 
                                                       placeholder="https://youtube.com/c/your_channel">
                                                @error('social_youtube')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab 3: Hero Video -->
                            <div class="tab-pane fade" id="video" role="tabpanel" aria-labelledby="video-tab">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-4">
                                            <label class="form-label fw-bold text-dark">{{ __('Video on Home Page') }} (Hero Video URL)</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light text-muted border-end-0"><i class="fa-solid fa-link"></i></span>
                                                <input type="text" name="hero_video_url" class="form-control rounded-start-0 py-2.5 @error('hero_video_url') is-invalid @enderror" 
                                                       value="{{ old('hero_video_url', $settings['hero_video_url'] ?? '') }}" 
                                                       placeholder="https://www.youtube.com/embed/...&autoplay=1">
                                                @error('hero_video_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="form-text mt-3 bg-light p-3 rounded-3 text-muted">
                                                <i class="fa-solid fa-lightbulb me-1 text-warning"></i>
                                                {{ __('Paste the direct link to the embed version of your YouTube video.') }}
                                                {{ __('To make the video autoplay, mute sound, and loop, append') }} 
                                                <code>?autoplay=1&mute=1&loop=1&controls=0</code> {{ __('to the end of the URL.') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Submit Buttons -->
                        <div class="border-top pt-4 mt-4 d-flex justify-content-end">
                            <button type="submit" class="btn btn-save-settings rounded-pill px-5 py-2.5 fw-bold text-white">
                                <i class="fa-solid fa-floppy-disk me-2"></i> {{ __('Save Settings') }}
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .nav-pills .nav-link {
        color: var(--text-soft);
        background: transparent;
        transition: all 0.2s ease;
    }
    .nav-pills .nav-link.active {
        color: var(--brand) !important;
        background: #fff !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }
    .input-group-text {
        border-color: rgba(15, 23, 42, 0.15);
    }
    .form-control, .form-select {
        border-color: rgba(15, 23, 42, 0.15);
        color: var(--text) !important;
    }
    .form-control:focus, .form-select:focus {
        border-color: var(--brand);
        box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.15);
    }
    .btn-save-settings {
        background: linear-gradient(135deg, var(--brand), #fb923c);
        border: none;
        box-shadow: 0 8px 20px rgba(249, 115, 22, 0.25);
        transition: all 0.25s ease;
    }
    .btn-save-settings:hover {
        transform: translateY(-1px);
        box-shadow: 0 12px 24px rgba(249, 115, 22, 0.4);
        filter: brightness(1.05);
    }
</style>

<script>
    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var img = document.getElementById(previewId);
                var placeholder = document.getElementById(previewId.replace('-preview', '-placeholder'));
                
                if (placeholder) placeholder.style.display = 'none';
                
                if (!img) {
                    // Create image element if not exists
                    var container = document.querySelector('.' + previewId + '-box');
                    container.innerHTML = '';
                    img = document.createElement('img');
                    img.id = previewId;
                    img.style.maxHeight = '100%';
                    img.style.maxWidth = '100%';
                    img.style.objectFit = 'contain';
                    if (previewId === 'favicon-preview') {
                        img.style.width = '32px';
                        img.style.height = '32px';
                    }
                    container.appendChild(img);
                }
                img.src = e.target.result;
                img.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection