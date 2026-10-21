<div class="space-y-6">
    <!-- Title Field -->
    <div>
        <label for="title" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-slate-300">
            Service Title <span class="text-rose-400">*</span>
        </label>
        <div class="relative">
            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-500">
                <i class="ri-service-line text-base"></i>
            </span>
            <input type="text"
                   name="title"
                   id="title"
                   value="{{ old('title', $service->title ?? '') }}"
                   required
                   autofocus
                   placeholder="e.g. Cloud Architecture & DevOps"
                   class="w-full rounded-xl border border-slate-700/80 bg-[#0A0D14] py-3 pl-10 pr-4 text-sm text-white placeholder-slate-500 transition duration-200 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20">
        </div>
        <p class="mt-1.5 text-xs text-slate-500">A clear, engaging name for the service offering.</p>
    </div>

    <!-- Icon & Visual Asset Selector -->
    <div class="rounded-xl border border-slate-800 bg-slate-900/40 p-4 sm:p-5">
        <label class="mb-2 block text-xs font-semibold uppercase tracking-wider text-slate-300">
            Service Icon / Visual Identity
        </label>
        
        <div class="grid gap-6 md:grid-cols-12 items-start">
            <!-- Left: Icon Options & Input -->
            <div class="md:col-span-8 space-y-4">
                <!-- Preset Icon Quick Select -->
                <div>
                    <span class="block text-xs font-medium text-slate-400 mb-2">Click to choose a preset icon:</span>
                    <div class="flex flex-wrap gap-2" id="iconPresets">
                        @php
                            $presetIcons = [
                                'ri-code-box-line' => 'Code / Software',
                                'ri-smartphone-line' => 'Mobile App',
                                'ri-cloud-line' => 'Cloud / DevOps',
                                'ri-robot-2-line' => 'AI / ML',
                                'ri-palette-line' => 'UI/UX Design',
                                'ri-shield-check-line' => 'Cybersecurity',
                                'ri-database-2-line' => 'Database / SQL',
                                'ri-bar-chart-box-line' => 'Analytics',
                                'ri-server-line' => 'Server / Infra',
                                'ri-global-line' => 'Web Platforms',
                                'ri-rocket-2-line' => 'Startup / Scale',
                                'ri-cpu-line' => 'IoT / Systems',
                            ];
                        @endphp
                        @foreach ($presetIcons as $iconClass => $tooltip)
                            <button type="button"
                                    data-icon="{{ $iconClass }}"
                                    title="{{ $tooltip }}"
                                    class="preset-icon-btn grid size-10 place-items-center rounded-xl border border-slate-700/80 bg-slate-800/60 text-slate-300 transition duration-200 hover:border-emerald-400 hover:bg-emerald-500/10 hover:text-emerald-400 focus:outline-none cursor-pointer">
                                <i class="{{ $iconClass }} text-lg"></i>
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Custom Icon / Image Upload Selector -->
                <div class="grid gap-3 sm:grid-cols-2">
                    <div>
                        <label for="customIconInput" class="block text-xs font-medium text-slate-400 mb-1">
                            Icon Class or SVG Code:
                        </label>
                        <input type="text"
                               id="customIconInput"
                               placeholder="e.g. ri-terminal-box-line"
                               class="w-full rounded-xl border border-slate-700/80 bg-[#0A0D14] px-3.5 py-2 text-xs text-white placeholder-slate-500 outline-none focus:border-emerald-400 focus:ring-1 focus:ring-emerald-400">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-400 mb-1">
                            Or Upload Custom Image / Icon:
                        </label>
                        <label class="flex items-center justify-center gap-2 rounded-xl border border-dashed border-slate-700 bg-[#0A0D14] px-3.5 py-2 text-xs font-medium text-slate-300 transition hover:border-emerald-400 hover:text-emerald-300 cursor-pointer">
                            <i class="ri-upload-cloud-line text-sm text-emerald-400"></i>
                            <span>Choose Image (PNG/SVG)</span>
                            <input type="file" id="imageFileInput" accept="image/*" class="hidden">
                        </label>
                    </div>
                </div>

                <!-- Hidden Input bound to form -->
                <input type="hidden" name="icon" id="finalIconValue" value="{{ old('icon', $service->icon ?? 'ri-code-box-line') }}">
            </div>

            <!-- Right: Live Preview Box -->
            <div class="md:col-span-4 flex flex-col items-center justify-center rounded-xl border border-slate-800 bg-[#0A0D14] p-4 text-center">
                <span class="text-[11px] font-mono uppercase tracking-wider text-slate-500 mb-2">Live Icon Preview</span>
                <div id="iconPreviewContainer" class="grid size-16 place-items-center rounded-2xl border border-emerald-500/30 bg-emerald-500/10 text-emerald-400 shadow-lg shadow-emerald-500/10 mb-2 overflow-hidden">
                    <!-- Icon / Image dynamically rendered -->
                </div>
                <span id="iconLabelPreview" class="truncate max-w-[140px] font-mono text-[11px] text-slate-400"></span>
                <button type="button" id="clearIconBtn" class="mt-2 text-[11px] text-rose-400 hover:text-rose-300 transition cursor-pointer">
                    Clear / Reset
                </button>
            </div>
        </div>
    </div>

    <!-- Short Description Field -->
    <div>
        <label for="short_description" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-slate-300">
            Short Description <span class="text-rose-400">*</span>
        </label>
        <div class="relative">
            <textarea name="short_description"
                      id="short_description"
                      rows="3"
                      required
                      placeholder="e.g. End-to-end cloud migration, automated CI/CD pipelines, and secure infrastructure orchestration..."
                      class="w-full rounded-xl border border-slate-700/80 bg-[#0A0D14] p-3.5 text-sm leading-relaxed text-white placeholder-slate-500 transition duration-200 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20">{{ old('short_description', $service->short_description ?? '') }}</textarea>
        </div>
        <p class="mt-1.5 text-xs text-slate-500">Brief summary displayed on cards across the public website (typically 1–2 sentences).</p>
    </div>

    <!-- Detailed Rich Description Field -->
    <div>
        <label for="description" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-slate-300">
            Detailed Scope & Deliverables <span class="text-rose-400">*</span>
        </label>
        <div class="relative">
            <textarea name="description"
                      id="description"
                      rows="8"
                      placeholder="Write comprehensive details, key deliverables, technical stack, and workflow..."
                      class="w-full rounded-xl border border-slate-700/80 bg-[#0A0D14] p-4 text-sm leading-relaxed text-white placeholder-slate-500 transition duration-200 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20">{{ old('description', $service->description ?? '') }}</textarea>
        </div>
        <p class="mt-1.5 text-xs text-slate-500">Detailed breakdown of the service offering shown in detail views and client modals. Rich HTML and lists are supported.</p>
    </div>
</div>

@push('extra_scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const iconInput = document.getElementById('finalIconValue');
        const customInput = document.getElementById('customIconInput');
        const fileInput = document.getElementById('imageFileInput');
        const previewContainer = document.getElementById('iconPreviewContainer');
        const labelPreview = document.getElementById('iconLabelPreview');
        const clearBtn = document.getElementById('clearIconBtn');
        const presetBtns = document.querySelectorAll('.preset-icon-btn');

        function updatePreview(val) {
            val = (val || '').trim();
            iconInput.value = val;

            if (!val) {
                previewContainer.innerHTML = '<i class="ri-service-line text-2xl"></i>';
                labelPreview.textContent = 'None';
                return;
            }

            // Check if it's a data URL image
            if (val.startsWith('data:image') || val.startsWith('http://') || val.startsWith('https://')) {
                previewContainer.innerHTML = `<img src="${val}" alt="Icon" class="size-10 object-contain rounded-lg">`;
                labelPreview.textContent = 'Custom Image';
            } else if (val.startsWith('<svg') || val.includes('<path') || val.includes('<polyline') || val.includes('<rect')) {
                previewContainer.innerHTML = `<svg class="size-7 text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">${val}</svg>`;
                labelPreview.textContent = 'SVG Asset';
            } else {
                // Assume Remix Icon or FontAwesome class
                previewContainer.innerHTML = `<i class="${val} text-2xl"></i>`;
                labelPreview.textContent = val;
            }

            // Highlight active preset button if matched
            presetBtns.forEach(btn => {
                if (btn.dataset.icon === val) {
                    btn.classList.add('border-emerald-400', 'bg-emerald-500/20', 'text-emerald-400');
                } else {
                    btn.classList.remove('border-emerald-400', 'bg-emerald-500/20', 'text-emerald-400');
                }
            });
        }

        // Initialize preview
        const initialVal = iconInput.value || 'ri-code-box-line';
        if (!initialVal.startsWith('data:image') && !initialVal.startsWith('<')) {
            customInput.value = initialVal;
        }
        updatePreview(initialVal);

        // Click preset button
        presetBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                const icon = this.dataset.icon;
                customInput.value = icon;
                updatePreview(icon);
            });
        });

        // Type custom icon class or SVG
        customInput.addEventListener('input', function () {
            updatePreview(this.value);
        });

        // Upload custom image with client-side WebP compression
        if (fileInput) {
            fileInput.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (!file || !file.type.match(/image.*/)) return;

                const reader = new FileReader();
                reader.onload = function (readerEvent) {
                    const img = new Image();
                    img.onload = function () {
                        const maxSize = 256;
                        let width = img.width;
                        let height = img.height;

                        if (width > height) {
                            if (width > maxSize) {
                                height *= maxSize / width;
                                width = maxSize;
                            }
                        } else {
                            if (height > maxSize) {
                                width *= maxSize / height;
                                height = maxSize;
                            }
                        }

                        const canvas = document.createElement('canvas');
                        canvas.width = width;
                        canvas.height = height;
                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(img, 0, 0, width, height);

                        const dataUrl = canvas.toDataURL('image/webp', 0.88);
                        customInput.value = '';
                        updatePreview(dataUrl);
                    };
                    img.src = readerEvent.target.result;
                };
                reader.readAsDataURL(file);
            });
        }

        // Clear / Reset
        if (clearBtn) {
            clearBtn.addEventListener('click', function () {
                customInput.value = 'ri-code-box-line';
                if (fileInput) fileInput.value = '';
                updatePreview('ri-code-box-line');
            });
        }
    });
</script>
@endpush
