{{-- Student Registration Modal Dialog --}}
<dialog id="registerModal" class="m-auto max-h-[94dvh] w-[min(94vw,640px)] overflow-y-auto overscroll-contain rounded-[28px] border border-line bg-s1 text-[#E8ECF4] shadow-2xl backdrop:bg-black/85 backdrop:backdrop-blur-md open:animate-pop [&::-webkit-scrollbar]:w-1.5 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-thumb]:bg-slate-700">
    <div class="relative p-6 sm:p-8">
        {{-- Close Modal Button --}}
        <button id="closeRegisterBtn" type="button" aria-label="Close" class="absolute right-4 top-4 grid size-9 place-items-center rounded-full border border-line text-xl text-mu transition-colors duration-200 hover:border-ac hover:bg-s2 hover:text-ac cursor-pointer">
            &times;
        </button>

        {{-- Modal Header --}}
        <div class="mb-5 pr-8">
            <h3 class="font-display text-2xl font-bold tracking-tight text-white sm:text-[26px]">Student Registration</h3>
            <p class="mt-1 text-xs sm:text-sm text-mu">Select your specialized program and fill in your details to secure your admission seat.</p>
        </div>

        {{-- Registration Form Content --}}
        <div id="regFormContainer">
            {{-- Global Error Banner (JS handled) --}}
            <div id="regGlobalAlert" class="mb-4 hidden rounded-xl border border-rose-500/30 bg-rose-500/10 p-3 text-xs text-rose-300">
                <div class="flex items-start gap-2">
                    <i class="ri-error-warning-line text-sm mt-0.5 shrink-0"></i>
                    <span id="regGlobalAlertMsg">Please correct the errors in the form before submitting.</span>
                </div>
            </div>

            <form id="studentRegistrationForm" action="{{ route('register.post') }}" method="POST" class="grid gap-4 sm:grid-cols-2">
                @csrf
                @honeypot

                {{-- Field 1: Course to select (Full-width) --}}
                <label class="f sm:col-span-2">
                    <span class="flex items-center justify-between text-xs font-semibold uppercase tracking-wider text-slate-300">
                        <span>Specialized Course <span class="text-rose-400">*</span></span>
                        <span class="font-mono text-[11px] text-ac lowercase">certified curriculum</span>
                    </span>
                    <div class="relative">
                        <select name="course" id="regCourse" required class="w-full appearance-none pr-10">
                            <option value="" disabled selected>-- Select a Specialized Program --</option>
                            <option value="ACE MERN 21 Days Training">ACE MERN 21 Days Training</option>
                            {{-- <option value="MERN Stack Web Development">MERN Stack Web Development</option>
                            <option value="Python & Django Full Stack">Python & Django Full Stack</option>
                            <option value="Cloud Computing & DevOps">Cloud Computing & DevOps</option>
                            <option value="AI, Machine Learning & Data Science">AI, Machine Learning & Data Science</option>
                            <option value="Mobile App Development (Flutter / React Native)">Mobile App Development (Flutter / React Native)</option>
                            <option value="UI/UX Design & Frontend Engineering">UI/UX Design & Frontend Engineering</option>
                            <option value="Cyber Security & Ethical Hacking">Cyber Security & Ethical Hacking</option> --}}
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-mu">
                            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
                        </div>
                    </div>
                    <span class="field-error hidden text-[11px] text-rose-400 font-medium" data-error-field="course"></span>
                </label>

                {{-- Field 2: Student Name (Half-width) --}}
                <label class="f">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-300">
                        Student Full Name <span class="text-rose-400">*</span>
                    </span>
                    <input type="text" name="student_name" id="regStudentName" required placeholder="John Doe" autocomplete="name">
                    <span class="field-error hidden text-[11px] text-rose-400 font-medium" data-error-field="student_name"></span>
                </label>

                {{-- Field 3: Father's Name (Half-width) --}}
                <label class="f">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-300">
                        Father's Name <span class="text-rose-400">*</span>
                    </span>
                    <input type="text" name="father_name" id="regFatherName" required placeholder="Robert Doe">
                    <span class="field-error hidden text-[11px] text-rose-400 font-medium" data-error-field="father_name"></span>
                </label>

                {{-- Field 4: Gender (Half-width) --}}
                <label class="f">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-300">
                        Gender <span class="text-rose-400">*</span>
                    </span>
                    <div class="relative">
                        <select name="gender" id="regGender" required class="w-full appearance-none pr-10">
                            <option value="" disabled selected>-- Select Gender --</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-mu">
                            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
                        </div>
                    </div>
                    <span class="field-error hidden text-[11px] text-rose-400 font-medium" data-error-field="gender"></span>
                </label>

                {{-- Field 5: Date of Birth (Half-width) --}}
                <label class="f">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-300">
                        Date of Birth <span class="text-rose-400">*</span>
                    </span>
                    <input type="date" name="dob" id="regDob" required max="{{ date('Y-m-d') }}" class="w-full [color-scheme:dark]">
                    <span class="field-error hidden text-[11px] text-rose-400 font-medium" data-error-field="dob"></span>
                </label>

                {{-- Field 6: Mobile No. (Half-width) --}}
                <label class="f">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-300">
                        Mobile No. <span class="text-rose-400">*</span>
                    </span>
                    <input type="tel" name="mobile" id="regMobile" required placeholder="+91 98765 43210" autocomplete="tel">
                    <span class="field-error hidden text-[11px] text-rose-400 font-medium" data-error-field="mobile"></span>
                </label>

                {{-- Field 7: E-mail (Half-width) --}}
                <label class="f">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-300">
                        E-mail Address <span class="text-rose-400">*</span>
                    </span>
                    <input type="email" name="email" id="regEmail" required placeholder="student@example.com" autocomplete="email">
                    <span class="field-error hidden text-[11px] text-rose-400 font-medium" data-error-field="email"></span>
                </label>

                {{-- Submit Button --}}
                <div class="pt-2 sm:col-span-2">
                    <button type="submit" id="submitRegBtn" class="btn btn-p group w-full cursor-pointer justify-center !py-3.5 text-base font-semibold shadow-lg shadow-emerald-500/20">
                        <span>Register Now</span>
                        <svg class="i size-5 transition-transform duration-200 group-hover:translate-x-1" viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </button>
                </div>

                {{-- Trust Badges --}}
                <div class="flex flex-wrap items-center justify-center gap-4 pt-2 text-xs text-mu sm:col-span-2">
                    <span class="inline-flex items-center gap-1.5">
                        <svg class="size-3.5 text-ac" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        100% Verified Admission
                    </span>
                    <span class="inline-flex items-center gap-1.5">
                        <svg class="size-3.5 text-ac" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                        Instant Seat Reservation
                    </span>
                    <span class="inline-flex items-center gap-1.5">
                        <svg class="size-3.5 text-ac" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                        Free Career Guidance
                    </span>
                </div>
            </form>
        </div>

        {{-- Success State --}}
        <div id="regSuccessState" class="hidden py-6 text-center">
            <div class="mx-auto mb-4 grid size-16 place-items-center rounded-2xl border border-ac/30 bg-ac/10 text-ac">
                <svg class="size-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
            <h4 class="font-display text-2xl font-bold text-white">Registration Submitted!</h4>
            <p id="regSuccessMessage" class="mx-auto mt-2 max-w-sm text-sm text-mu">
                Thank you for applying. We have received your application and an admissions counselor will get in touch with you shortly.
            </p>
            <div class="mt-6 flex flex-wrap items-center justify-center gap-3">
                <button type="button" id="closeRegSuccessBtn" class="btn btn-p !px-8 cursor-pointer">
                    <span>Close</span>
                </button>
                <button type="button" id="registerAnotherBtn" class="btn btn-g !px-6 cursor-pointer">
                    <span>Register Another</span>
                </button>
            </div>
        </div>
    </div>
</dialog>
