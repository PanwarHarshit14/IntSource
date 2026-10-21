@extends('admin.layouts.app')

@section('main_section')
<div class="space-y-6">
    <form action="{{ route('admin.contact.update', $contact) }}" method="POST" enctype="multipart/form-data" id="settingsForm">
        @csrf
        @method('PUT')

        <!-- Page Header with Save Button -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-b border-slate-800 pb-5">
            <div>
                <h1 class="font-display text-2xl font-bold tracking-tight text-white">System & Website Settings</h1>
                <p class="text-sm text-slate-400">Configure public business details, brand assets, and communication channels</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.dashboard') }}"
                   class="inline-flex items-center gap-1.5 rounded-xl border border-slate-700 bg-slate-800/60 px-4 py-2.5 text-xs font-semibold text-slate-300 transition hover:bg-slate-800 hover:text-white">
                    <i class="ri-arrow-left-line text-xs"></i>
                    <span>Dashboard</span>
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-xl bg-emerald-400 px-5 py-2.5 text-xs font-bold text-slate-950 shadow-lg shadow-emerald-500/20 transition duration-200 hover:-translate-y-0.5 hover:bg-emerald-300 hover:shadow-emerald-500/30 active:translate-y-0">
                    <i class="ri-save-line text-sm"></i>
                    <span>Save All Changes</span>
                </button>
            </div>
        </div>

        <div class="mt-6">
            <x-alert />
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Left 2 Columns: Contact & Information -->
            <div class="space-y-6 lg:col-span-2">
                <!-- Card 1: Core Business Information -->
                <div class="rounded-2xl border border-slate-800/80 bg-[#11161F]/90 p-6 shadow-xl backdrop-blur-xl">
                    <div class="border-b border-slate-800 pb-4 mb-5 flex items-center gap-3">
                        <span class="grid size-9 place-items-center rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                            <i class="ri-building-line text-base"></i>
                        </span>
                        <div>
                            <h2 class="font-display text-base font-bold text-white">General Information</h2>
                            <p class="text-xs text-slate-400">Basic identification details for your organization</p>
                        </div>
                    </div>

                    <div class="space-y-5">
                        <!-- Brand Name -->
                        <div>
                            <label for="name" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-slate-300">
                                Organization / Brand Name <span class="text-rose-400">*</span>
                            </label>
                            <input type="text"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $contact->name) }}"
                                   required
                                   placeholder="e.g. DPS Barmer / IntSource"
                                   class="w-full rounded-xl border border-slate-700/80 bg-[#0A0D14] py-2.5 px-4 text-sm text-white placeholder-slate-500 transition duration-200 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20">
                        </div>

                        <!-- Official Email -->
                        <div>
                            <label for="email" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-slate-300">
                                Primary Email Address
                            </label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-500">
                                    <i class="ri-mail-line text-base"></i>
                                </span>
                                <input type="email"
                                       id="email"
                                       name="email"
                                       value="{{ old('email', $contact->email) }}"
                                       placeholder="contact@company.com"
                                       class="w-full rounded-xl border border-slate-700/80 bg-[#0A0D14] py-2.5 pl-10 pr-4 text-sm text-white placeholder-slate-500 transition duration-200 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20">
                            </div>
                        </div>

                        <!-- Dynamic Phone Numbers -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300">
                                    Contact Phone Numbers
                                </label>
                                <button type="button"
                                        id="addPhoneBtn"
                                        class="inline-flex items-center gap-1.5 rounded-lg border border-emerald-500/30 bg-emerald-500/10 px-2.5 py-1 text-xs font-semibold text-emerald-300 transition hover:bg-emerald-500/20 hover:text-emerald-200">
                                    <i class="ri-add-line text-xs"></i>
                                    <span>Add Phone</span>
                                </button>
                            </div>

                            <div id="phoneInputsContainer" class="space-y-2.5">
                                @if(!empty($contact->phones) && count($contact->phones) > 0)
                                    @foreach($contact->phones as $phone)
                                        <div class="phone-row flex items-center gap-2">
                                            <div class="relative flex-1">
                                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-500">
                                                    <i class="ri-phone-line text-sm"></i>
                                                </span>
                                                <input type="text"
                                                       name="phones[]"
                                                       value="{{ $phone }}"
                                                       placeholder="+91 98765 43210"
                                                       class="w-full rounded-xl border border-slate-700/80 bg-[#0A0D14] py-2.5 pl-10 pr-4 text-sm text-white placeholder-slate-500 transition duration-200 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20">
                                            </div>
                                            <button type="button"
                                                    class="remove-phone-btn grid size-10 shrink-0 place-items-center rounded-xl border border-rose-500/30 bg-rose-500/10 text-rose-400 transition hover:bg-rose-500 hover:text-white"
                                                    title="Remove phone number">
                                                <i class="ri-delete-bin-line text-sm"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="phone-row flex items-center gap-2">
                                        <div class="relative flex-1">
                                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-500">
                                                <i class="ri-phone-line text-sm"></i>
                                            </span>
                                            <input type="text"
                                                   name="phones[]"
                                                   value=""
                                                   placeholder="+91 98765 43210"
                                                   class="w-full rounded-xl border border-slate-700/80 bg-[#0A0D14] py-2.5 pl-10 pr-4 text-sm text-white placeholder-slate-500 transition duration-200 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20">
                                        </div>
                                        <button type="button"
                                                class="remove-phone-btn grid size-10 shrink-0 place-items-center rounded-xl border border-rose-500/30 bg-rose-500/10 text-rose-400 transition hover:bg-rose-500 hover:text-white"
                                                title="Remove phone number">
                                            <i class="ri-delete-bin-line text-sm"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Social Media Platforms -->
                <div class="rounded-2xl border border-slate-800/80 bg-[#11161F]/90 p-6 shadow-xl backdrop-blur-xl">
                    <div class="border-b border-slate-800 pb-4 mb-5 flex items-center gap-3">
                        <span class="grid size-9 place-items-center rounded-xl bg-cyan-500/10 text-cyan-400 border border-cyan-500/20">
                            <i class="ri-share-forward-line text-base"></i>
                        </span>
                        <div>
                            <h2 class="font-display text-base font-bold text-white">Social Media Profiles</h2>
                            <p class="text-xs text-slate-400">Public profile and chat URLs for website visitor engagement</p>
                        </div>
                    </div>

                    @php
                        $socials = [
                            'whatsapp' => ['icon' => 'ri-whatsapp-line', 'color' => 'text-emerald-400', 'placeholder' => 'https://wa.me/910000000000'],
                            'facebook' => ['icon' => 'ri-facebook-circle-line', 'color' => 'text-blue-400', 'placeholder' => 'https://facebook.com/yourpage'],
                            'instagram' => ['icon' => 'ri-instagram-line', 'color' => 'text-pink-400', 'placeholder' => 'https://instagram.com/yourhandle'],
                            'linkedin' => ['icon' => 'ri-linkedin-box-line', 'color' => 'text-sky-400', 'placeholder' => 'https://linkedin.com/company/yourcompany'],
                        ];
                    @endphp

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        @foreach($socials as $key => $meta)
                            <div>
                                <label for="social_{{ $key }}" class="mb-1.5 flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-slate-300">
                                    <i class="{{ $meta['icon'] }} {{ $meta['color'] }} text-base"></i>
                                    <span class="capitalize">{{ $key }} URL</span>
                                </label>
                                <input type="url"
                                       id="social_{{ $key }}"
                                       name="social_links[{{ $key }}]"
                                       value="{{ old('social_links.'.$key, $contact->social_links[$key] ?? '') }}"
                                       placeholder="{{ $meta['placeholder'] }}"
                                       class="w-full rounded-xl border border-slate-700/80 bg-[#0A0D14] py-2.5 px-3.5 text-xs text-white placeholder-slate-600 transition duration-200 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20">
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Card 3: Address & Location Coordinates -->
                <div class="rounded-2xl border border-slate-800/80 bg-[#11161F]/90 p-6 shadow-xl backdrop-blur-xl">
                    <div class="border-b border-slate-800 pb-4 mb-5 flex items-center gap-3">
                        <span class="grid size-9 place-items-center rounded-xl bg-teal-500/10 text-teal-400 border border-teal-500/20">
                            <i class="ri-map-pin-line text-base"></i>
                        </span>
                        <div>
                            <h2 class="font-display text-base font-bold text-white">Physical Location & Map</h2>
                            <p class="text-xs text-slate-400">Street address and map embed/coordinates displayed on the website</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div>
                            <label for="address" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-slate-300">
                                Street Address <span class="text-rose-400">*</span>
                            </label>
                            <textarea id="address"
                                      name="address"
                                      rows="4"
                                      required
                                      placeholder="Full office or school address..."
                                      class="w-full rounded-xl border border-slate-700/80 bg-[#0A0D14] p-3 text-xs leading-relaxed text-white placeholder-slate-500 transition duration-200 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20">{{ old('address', $contact->address) }}</textarea>
                        </div>
                        <div>
                            <label for="location" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-slate-300">
                                Map Link / Coordinates <span class="text-rose-400">*</span>
                            </label>
                            <textarea id="location"
                                      name="location"
                                      rows="4"
                                      required
                                      placeholder="Google Maps URL, embed code, or coordinates..."
                                      class="w-full rounded-xl border border-slate-700/80 bg-[#0A0D14] p-3 text-xs leading-relaxed text-white placeholder-slate-500 transition duration-200 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20">{{ old('location', $contact->location) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Brand Assets (Logo & Favicon) -->
            <div class="space-y-6">
                <!-- Card: Logo Upload -->
                <div class="rounded-2xl border border-slate-800/80 bg-[#11161F]/90 p-6 shadow-xl backdrop-blur-xl">
                    <div class="border-b border-slate-800 pb-3 mb-4">
                        <h2 class="font-display text-base font-bold text-white">Header Logo</h2>
                        <p class="text-xs text-slate-400">Transparent PNG/SVG recommended (approx. 240x80)</p>
                    </div>

                    <div class="upload-dropzone group relative flex cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-slate-700 bg-slate-900/60 p-6 text-center transition duration-200 hover:border-emerald-500/60 hover:bg-slate-900"
                         data-target="logoInput"
                         data-preview="logoPreview">
                        <input type="file"
                               id="logoInput"
                               name="logo"
                               accept="image/*"
                               class="hidden file-input">

                        <div id="logoPreview" class="flex flex-col items-center">
                            @if(!empty($contact->logo))
                                <div class="rounded-xl border border-slate-700 bg-slate-950/60 p-3 mb-3">
                                    <img src="{{ asset($contact->logo) }}" alt="Current Logo" class="max-h-20 w-auto object-contain">
                                </div>
                                <span class="rounded-full border border-slate-700 bg-slate-800 px-3 py-1 text-[11px] font-medium text-slate-300 group-hover:border-emerald-500/50 group-hover:text-emerald-300 transition">
                                    Click to change logo
                                </span>
                            @else
                                <span class="grid size-12 place-items-center rounded-2xl bg-emerald-500/10 text-emerald-400 mb-3 border border-emerald-500/20 group-hover:scale-110 transition">
                                    <i class="ri-upload-cloud-line text-2xl"></i>
                                </span>
                                <span class="text-xs font-semibold text-white">Click or drag logo here</span>
                                <span class="mt-1 text-[11px] text-slate-500">PNG, SVG, WEBP up to 2MB</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Card: Favicon Upload -->
                <div class="rounded-2xl border border-slate-800/80 bg-[#11161F]/90 p-6 shadow-xl backdrop-blur-xl">
                    <div class="border-b border-slate-800 pb-3 mb-4">
                        <h2 class="font-display text-base font-bold text-white">Browser Favicon</h2>
                        <p class="text-xs text-slate-400">Square icon displayed in browser tabs (64x64 or 128x128)</p>
                    </div>

                    <div class="upload-dropzone group relative flex cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-slate-700 bg-slate-900/60 p-6 text-center transition duration-200 hover:border-emerald-500/60 hover:bg-slate-900"
                         data-target="faviconInput"
                         data-preview="faviconPreview">
                        <input type="file"
                               id="faviconInput"
                               name="favicon"
                               accept="image/*"
                               class="hidden file-input">

                        <div id="faviconPreview" class="flex flex-col items-center">
                            @if(!empty($contact->favicon))
                                <div class="rounded-xl border border-slate-700 bg-slate-950/60 p-3 mb-3">
                                    <img src="{{ asset($contact->favicon) }}" alt="Current Favicon" class="size-12 object-contain">
                                </div>
                                <span class="rounded-full border border-slate-700 bg-slate-800 px-3 py-1 text-[11px] font-medium text-slate-300 group-hover:border-emerald-500/50 group-hover:text-emerald-300 transition">
                                    Click to change favicon
                                </span>
                            @else
                                <span class="grid size-12 place-items-center rounded-2xl bg-cyan-500/10 text-cyan-400 mb-3 border border-cyan-500/20 group-hover:scale-110 transition">
                                    <i class="ri-image-add-line text-2xl"></i>
                                </span>
                                <span class="text-xs font-semibold text-white">Click or drag favicon here</span>
                                <span class="mt-1 text-[11px] text-slate-500">ICO, PNG, WEBP</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Submit Bar -->
                <div class="rounded-2xl border border-slate-800/80 bg-[#11161F]/90 p-5 shadow-xl">
                    <button type="submit"
                            class="flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-400 py-3 text-xs font-bold text-slate-950 shadow-lg shadow-emerald-500/20 transition-all duration-200 hover:-translate-y-0.5 hover:bg-emerald-300 hover:shadow-emerald-500/30 active:translate-y-0">
                        <i class="ri-save-line text-sm"></i>
                        <span>Save All Changes</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('extra_scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Dynamic Phone Numbers logic (clean vanilla JS)
    const addPhoneBtn = document.getElementById('addPhoneBtn');
    const container = document.getElementById('phoneInputsContainer');

    if (addPhoneBtn && container) {
        addPhoneBtn.addEventListener('click', function () {
            const row = document.createElement('div');
            row.className = 'phone-row flex items-center gap-2 animate-fade';
            row.innerHTML = `
                <div class="relative flex-1">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-500">
                        <i class="ri-phone-line text-sm"></i>
                    </span>
                    <input type="text"
                           name="phones[]"
                           value=""
                           placeholder="+91 98765 43210"
                           class="w-full rounded-xl border border-slate-700/80 bg-[#0A0D14] py-2.5 pl-10 pr-4 text-sm text-white placeholder-slate-500 transition duration-200 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20">
                </div>
                <button type="button"
                        class="remove-phone-btn grid size-10 shrink-0 place-items-center rounded-xl border border-rose-500/30 bg-rose-500/10 text-rose-400 transition hover:bg-rose-500 hover:text-white"
                        title="Remove phone number">
                    <i class="ri-delete-bin-line text-sm"></i>
                </button>
            `;
            container.appendChild(row);
        });

        container.addEventListener('click', function (e) {
            const btn = e.target.closest('.remove-phone-btn');
            if (btn) {
                const rows = container.querySelectorAll('.phone-row');
                if (rows.length > 1) {
                    btn.closest('.phone-row').remove();
                } else {
                    const input = btn.closest('.phone-row').querySelector('input');
                    if (input) input.value = '';
                }
            }
        });
    }

    // Image Upload Previews
    document.querySelectorAll('.upload-dropzone').forEach(dropzone => {
        const targetInputId = dropzone.getAttribute('data-target');
        const previewId = dropzone.getAttribute('data-preview');
        const fileInput = document.getElementById(targetInputId);
        const previewContainer = document.getElementById(previewId);

        dropzone.addEventListener('click', function (e) {
            if (e.target !== fileInput) {
                fileInput.click();
            }
        });

        fileInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const isFavicon = previewId.includes('favicon');
                    const imgClass = isFavicon ? 'size-12 object-contain' : 'max-h-20 w-auto object-contain';
                    previewContainer.innerHTML = `
                        <div class="rounded-xl border border-emerald-500/40 bg-slate-950/80 p-3 mb-3 shadow-lg shadow-emerald-500/10">
                            <img src="${e.target.result}" alt="Preview" class="${imgClass}">
                        </div>
                        <span class="rounded-full border border-emerald-500/40 bg-emerald-500/10 px-3 py-1 text-[11px] font-semibold text-emerald-300">
                            Ready to upload: ${file.name.substring(0, 20)}
                        </span>
                    `;
                };
                reader.readAsDataURL(file);
            }
        });
    });
});
</script>
@endpush