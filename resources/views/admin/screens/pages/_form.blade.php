<div class="grid gap-6 lg:grid-cols-12 items-start">
    {{-- Left Column: Primary Content (8 cols) --}}
    <div class="lg:col-span-8 space-y-6">
        {{-- Page Title --}}
        <div>
            <label for="pageTitleInput" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-slate-300">
                Page Title <span class="text-rose-400">*</span>
            </label>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-500">
                    <i class="ri-file-text-line text-base"></i>
                </span>
                <input type="text"
                       name="title"
                       id="pageTitleInput"
                       value="{{ old('title', $page->title ?? '') }}"
                       required
                       autofocus
                       placeholder="e.g. About Our Company, Privacy Policy, Terms of Service"
                       class="w-full rounded-xl border border-slate-700/80 bg-[#0A0D14] py-3 pl-10 pr-4 text-sm text-white placeholder-slate-500 transition duration-200 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20">
            </div>
            @error('title')
                <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Custom URL Slug --}}
        <div>
            <label for="pageSlugInput" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-slate-300">
                URL Slug / Route
            </label>
            <div class="flex items-center rounded-xl border border-slate-700/80 bg-[#0A0D14] px-3.5 py-2.5 text-xs text-slate-400 focus-within:border-emerald-400 focus-within:ring-2 focus-within:ring-emerald-400/20">
                <span class="font-mono text-slate-500 mr-1 select-none">{{ url('/') }}/</span>
                <input type="text"
                       name="slug"
                       id="pageSlugInput"
                       value="{{ old('slug', $page->slug ?? '') }}"
                       placeholder="auto-generated-from-title"
                       class="flex-1 bg-transparent font-mono text-emerald-400 outline-none placeholder-slate-600">
            </div>
            <p class="mt-1.5 text-[11px] text-slate-500">Leave blank to auto-generate based on page title.</p>
            @error('slug')
                <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Page Description / HTML Content --}}
        <div>
            <div class="mb-2 flex items-center justify-between">
                <label for="pageDescription" class="block text-xs font-semibold uppercase tracking-wider text-slate-300">
                    Page Content (HTML / Text) <span class="text-rose-400">*</span>
                </label>
                <span class="text-[11px] font-mono text-slate-500">Supports HTML formatting</span>
            </div>

            <!-- Formatting Helper Quick Insert Buttons -->
            <div class="mb-2 flex flex-wrap items-center gap-1.5 rounded-t-xl border border-b-0 border-slate-700/80 bg-slate-900/60 p-2 text-xs">
                <button type="button" onclick="insertTag('h2', 'Section Heading')" class="rounded-lg bg-slate-800 px-2.5 py-1 font-medium text-slate-300 hover:bg-slate-700 hover:text-white transition">H2</button>
                <button type="button" onclick="insertTag('h3', 'Sub-heading')" class="rounded-lg bg-slate-800 px-2.5 py-1 font-medium text-slate-300 hover:bg-slate-700 hover:text-white transition">H3</button>
                <button type="button" onclick="insertTag('p', 'Paragraph text here...')" class="rounded-lg bg-slate-800 px-2.5 py-1 text-slate-300 hover:bg-slate-700 hover:text-white transition">Paragraph</button>
                <button type="button" onclick="insertTag('strong', 'Bold text')" class="rounded-lg bg-slate-800 px-2.5 py-1 font-bold text-slate-300 hover:bg-slate-700 hover:text-white transition">B</button>
                <button type="button" onclick="insertTag('em', 'Italic text')" class="rounded-lg bg-slate-800 px-2.5 py-1 italic text-slate-300 hover:bg-slate-700 hover:text-white transition">I</button>
                <button type="button" onclick="insertTag('blockquote', 'A memorable quote...')" class="rounded-lg bg-slate-800 px-2.5 py-1 text-slate-300 hover:bg-slate-700 hover:text-white transition">Quote</button>
                <button type="button" onclick="insertTag('ul', '<li>Item 1</li>\n<li>Item 2</li>')" class="rounded-lg bg-slate-800 px-2.5 py-1 text-slate-300 hover:bg-slate-700 hover:text-white transition">List</button>
            </div>

            <textarea name="description"
                      id="pageDescription"
                      rows="14"
                      required
                      placeholder="Write your page content here... You can use HTML tags like <h2>, <p>, <ul>, <li>, <blockquote>, <strong>."
                      class="w-full rounded-b-xl border border-slate-700/80 bg-[#0A0D14] p-4 font-mono text-xs leading-relaxed text-slate-200 placeholder-slate-600 transition outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20">{{ old('description', $page->description ?? '') }}</textarea>
            @error('description')
                <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- Right Column: Featured Image & Publishing Meta (4 cols) --}}
    <div class="lg:col-span-4 space-y-6">
        {{-- Featured Image Upload Card --}}
        <div class="rounded-2xl border border-slate-800 bg-[#0E131C] p-5 shadow-lg">
            <label class="mb-3 block text-xs font-semibold uppercase tracking-wider text-slate-300">
                Featured Cover Image
            </label>

            <div class="space-y-3">
                <!-- Dropzone & File Input -->
                <label id="uploadDropzone"
                       class="group relative flex flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-700/80 bg-[#0A0D14] p-5 text-center transition-all duration-200 hover:border-emerald-500/50 hover:bg-emerald-500/5 cursor-pointer">
                    <div class="grid size-12 place-items-center rounded-full bg-slate-800/80 text-emerald-400 group-hover:scale-110 transition">
                        <i class="ri-upload-cloud-2-line text-2xl"></i>
                    </div>
                    <span class="mt-3 block text-xs font-semibold text-white">Click or drag image here</span>
                    <span class="mt-1 block text-[11px] text-slate-500">PNG, JPG, or WEBP (Auto-optimized)</span>

                    <!-- File input -->
                    <input type="file" id="pageImageFile" accept="image/*" class="hidden">
                    <!-- Hidden field submitting dataURI to server -->
                    <textarea name="image" id="pageImageDataUri" class="hidden"></textarea>
                </label>

                <!-- Existing & Live Image Preview Container -->
                <div id="imagePreviewContainer" class="{{ !empty($page->image) ? '' : 'hidden' }} relative overflow-hidden rounded-xl border border-slate-700/80 bg-slate-900/60 p-2">
                    <img id="imagePreviewImg" 
                         src="{{ !empty($page->image) ? $page->image : '' }}" 
                         alt="Preview" 
                         class="max-h-52 w-full rounded-lg object-cover">

                    <button type="button" 
                            id="removeImageBtn"
                            data-url="{{ !empty($page->id) ? route('admin.page.remove-image', $page->id) : '' }}"
                            class="absolute right-3.5 top-3.5 grid size-7 place-items-center rounded-lg bg-rose-500/90 text-white shadow-md transition hover:bg-rose-600 cursor-pointer"
                            title="Remove Image">
                        <i class="ri-delete-bin-line text-xs"></i>
                    </button>
                </div>
            </div>
            <p class="mt-2.5 text-[11px] text-slate-500 leading-normal">
                Featured images enhance your page layout on desktop and tablet screens.
            </p>
        </div>

        {{-- Information & Status Card --}}
        <div class="rounded-2xl border border-slate-800 bg-[#0E131C] p-5 text-xs text-slate-400 space-y-3">
            <h4 class="font-display text-xs font-bold uppercase tracking-wider text-slate-300">Publication Details</h4>
            <div class="flex items-center justify-between border-b border-slate-800 pb-2">
                <span>Visibility:</span>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-500/10 px-2.5 py-0.5 font-medium text-emerald-400">
                    <span class="size-1.5 rounded-full bg-emerald-400"></span> Public
                </span>
            </div>
            @if(!empty($page->created_at))
                <div class="flex items-center justify-between border-b border-slate-800 pb-2">
                    <span>Created:</span>
                    <span class="font-mono text-slate-300">{{ $page->created_at->format('M d, Y') }}</span>
                </div>
            @endif
            @if(!empty($page->updated_at))
                <div class="flex items-center justify-between border-b border-slate-800 pb-2">
                    <span>Last Updated:</span>
                    <span class="font-mono text-slate-300">{{ $page->updated_at->format('M d, Y H:i') }}</span>
                </div>
            @endif
            @if(!empty($page->slug))
                <div class="pt-1">
                    <a href="{{ route('page', $page->slug) }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs text-emerald-400 hover:underline">
                        <i class="ri-external-link-line"></i>
                        <span>View live page</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('extra_scripts')
<script>
    // Live slug generation from title if slug field is empty or pristine
    const titleInput = document.getElementById('pageTitleInput');
    const slugInput = document.getElementById('pageSlugInput');
    let userEditedSlug = Boolean(slugInput && slugInput.value.trim().length > 0);

    if (slugInput) {
        slugInput.addEventListener('input', function() {
            userEditedSlug = Boolean(this.value.trim().length > 0);
        });
    }

    if (titleInput && slugInput) {
        titleInput.addEventListener('input', function() {
            if (!userEditedSlug) {
                slugInput.value = this.value
                    .toLowerCase()
                    .trim()
                    .replace(/[^\w\s-]/g, '')
                    .replace(/[\s_-]+/g, '-')
                    .replace(/^-+|-+$/g, '');
            }
        });
    }

    // HTML Insert Helper function
    function insertTag(tag, sampleText) {
        const textarea = document.getElementById('pageDescription');
        if (!textarea) return;

        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const selectedText = textarea.value.substring(start, end) || sampleText;

        const replacement = `<${tag}>${selectedText}</${tag}>`;
        textarea.setRangeText(replacement, start, end, 'end');
        textarea.focus();
    }

    // Client-side Image Optimization to DataUri & Live Preview
    const fileInput = document.getElementById('pageImageFile');
    const dataUriField = document.getElementById('pageImageDataUri');
    const previewContainer = document.getElementById('imagePreviewContainer');
    const previewImg = document.getElementById('imagePreviewImg');
    const removeBtn = document.getElementById('removeImageBtn');

    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file || !file.type.startsWith('image/')) return;

            const reader = new FileReader();
            reader.onload = function(event) {
                const img = new Image();
                img.onload = function() {
                    const canvas = document.createElement('canvas');
                    const maxDim = 1200;
                    let width = img.width;
                    let height = img.height;

                    if (width > height) {
                        if (width > maxDim) {
                            height = Math.round((height * maxDim) / width);
                            width = maxDim;
                        }
                    } else {
                        if (height > maxDim) {
                            width = Math.round((width * maxDim) / height);
                            height = maxDim;
                        }
                    }

                    canvas.width = width;
                    canvas.height = height;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, width, height);

                    const webpDataUri = canvas.toDataURL('image/webp', 0.88);
                    dataUriField.value = webpDataUri;
                    previewImg.src = webpDataUri;
                    previewContainer.classList.remove('hidden');
                };
                img.src = event.target.result;
            };
            reader.readAsDataURL(file);
        });
    }

    // Remove Image Button Handler
    if (removeBtn) {
        removeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.getAttribute('data-url');

            if (!confirm('Are you sure you want to remove this image?')) return;

            // If it's already in the database
            if (url) {
                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    previewContainer.classList.add('hidden');
                    previewImg.src = '';
                    dataUriField.value = '';
                    if (fileInput) fileInput.value = '';
                })
                .catch(err => {
                    alert('Error removing image from server.');
                });
            } else {
                // Just client preview
                previewContainer.classList.add('hidden');
                previewImg.src = '';
                dataUriField.value = '';
                if (fileInput) fileInput.value = '';
            }
        });
    }
</script>
@endpush