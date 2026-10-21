<section id="contact" class="sec">
    <div class="wrap">
        <div class="rv grid overflow-hidden rounded-[24px] border border-line sm:rounded-[32px] lg:grid-cols-2">
            <!-- Left Info Card -->
            <div class="relative flex flex-col justify-between gap-10 overflow-hidden bg-ac p-8 text-[#04130D] sm:p-14">
                <div class="pointer-events-none absolute -right-[90px] -top-[90px] size-[280px] animate-[spin_40s_linear_infinite] rounded-full border-2 border-dashed border-[#04130D]/30"></div>
                <div class="relative">
                    <div class="eyebrow !text-[#0B3626]">Contact</div>
                    <h2 class="h2 lg:!text-[46px]">Have an idea? Let's build it together.</h2>
                    <p class="mt-5 text-lg text-[#0B3626]">Tell us about your project and we'll come back with a plan, a timeline, and a clear next step.</p>
                </div>

                <div class="cl relative grid gap-3.5 font-medium">
                    @php
                        $contactEmail = $contact->email ?? 'hello@intsource.com';
                        $primaryPhone = (!empty($contact->phones) && is_array($contact->phones) && count($contact->phones) > 0) ? $contact->phones[0] : '+1 (800) 555-0199';
                        $cleanPhone = preg_replace('/[^0-9+]/', '', (string)$primaryPhone);
                        $contactAddress = $contact->address ?? 'San Francisco, CA & Remote Worldwide';
                    @endphp

                    <a href="mailto:{{ $contactEmail }}" class="flex items-center gap-3.5 transition-opacity hover:opacity-80">
                        <svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
                        <span>{{ $contactEmail }}</span>
                    </a>
                    <a href="tel:{{ $cleanPhone }}" class="flex items-center gap-3.5 transition-opacity hover:opacity-80">
                        <svg viewBox="0 0 24 24"><path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2z"/></svg>
                        <span>{{ $primaryPhone }}</span>
                    </a>
                    <span class="flex items-center gap-3.5">
                        <svg viewBox="0 0 24 24"><path d="M12 21s7-6 7-11a7 7 0 0 0-14 0c0 5 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>
                        <span>{{ $contactAddress }}</span>
                    </span>
                </div>

                <a class="btn btn-d group relative max-sm:justify-center max-sm:self-stretch" href="#enquiry">
                    <span>Book a free consultation</span>
                    <svg viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </a>
            </div>

            <!-- Right Enquiry Form -->
            <div id="enquiry" class="bg-s1 p-8 sm:p-14">
                <h3 class="text-[28px] font-bold">Send an enquiry</h3>
                <p class="mb-7 mt-2 text-[15px] text-mu">We usually reply within 24 business hours.</p>

                @if(session('success'))
                    <div class="mb-6 flex items-start gap-3 rounded-xl border border-emerald-500/30 bg-emerald-500/10 p-4 text-emerald-300">
                        <svg class="mt-0.5 size-5 shrink-0 text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                        <div class="text-sm">
                            <p class="font-semibold text-emerald-200">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 flex items-start gap-3 rounded-xl border border-rose-500/30 bg-rose-500/10 p-4 text-rose-300">
                        <svg class="mt-0.5 size-5 shrink-0 text-rose-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        <div class="text-sm">
                            <p class="font-semibold text-rose-200">Please review the following errors:</p>
                            <ul class="mt-1 list-inside list-disc space-y-0.5 text-xs text-rose-300/90">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form action="{{ route('enquiry.mail') }}" method="POST" class="grid gap-5 sm:grid-cols-2">
                    @csrf
                    @honeypot

                    <!-- Row 1: Full-width Name -->
                    <label class="f sm:col-span-2">
                        <span>Name <span class="text-rose-400">*</span></span>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="John Doe" autocomplete="name">
                        @error('name')
                            <span class="text-xs text-rose-400">{{ $message }}</span>
                        @enderror
                    </label>

                    <!-- Row 2: Col-1 Phone, Col-2 E-mail -->
                    <label class="f">
                        <span>Phone <span class="text-rose-400">*</span></span>
                        <input type="tel" name="phone" value="{{ old('phone') }}" required placeholder="+911234567890" autocomplete="tel">
                        @error('phone')
                            <span class="text-xs text-rose-400">{{ $message }}</span>
                        @enderror
                    </label>

                    <label class="f">
                        <span>E-mail <span class="text-rose-400">*</span></span>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="example@domain.com" autocomplete="email">
                        @error('email')
                            <span class="text-xs text-rose-400">{{ $message }}</span>
                        @enderror
                    </label>

                    <!-- Row 3: Full-width Message textarea -->
                    <label class="f sm:col-span-2">
                        <span>Message <span class="text-rose-400">*</span></span>
                        <textarea name="messages" required class="min-h-[150px] resize-y" placeholder="Write your message here...">{{ old('messages', old('message')) }}</textarea>
                        @error('messages')
                            <span class="text-xs text-rose-400">{{ $message }}</span>
                        @enderror
                        @error('message')
                            <span class="text-xs text-rose-400">{{ $message }}</span>
                        @enderror
                    </label>

                    <button type="submit" class="btn btn-p group w-full justify-center sm:col-span-2">
                        <span>Send enquiry</span>
                        <svg viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>