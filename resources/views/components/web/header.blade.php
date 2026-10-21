<header class="sticky top-[env(safe-area-inset-top,0px)] z-50 border-b border-line bg-bg/70 backdrop-blur-xl">
    <div class="wrap flex h-[72px] items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center gap-2.5 font-display text-[22px] font-bold text-[#E8ECF4]">
            @if(!empty($contact?->logo))
                <img src="{{ $contact->logo }}" alt="{{ $contact?->name ?? 'IntSource' }}" class="size-8 rounded-lg object-contain shadow-sm">
            @else
                <span class="mark"></span>
            @endif
            <span>{{ $contact?->name ?? 'IntSource' }}</span>
        </a>

        <nav class="hidden gap-9 text-[15px] text-mu lg:flex">
            <a class="nl" href="#about">About</a>
            <a class="nl" href="#expertise">Expertise</a>
            <a class="nl" href="#process">How we work</a>
            <a class="nl" href="#faq">FAQ</a>
            <a class="nl" href="#contact">Contact</a>
        </nav>

        <div class="flex items-center gap-3">
            <button type="button" id="openRegisterBtn" class="btn btn-p group !hidden lg:!inline-flex !min-h-[42px] !px-5 text-[15px] cursor-pointer">
                <span>Enroll Now</span>
                <svg class="i" viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </button>
            <button id="nb" type="button" aria-label="Toggle menu" aria-expanded="false" aria-controls="np" class="grid size-11 place-items-center rounded-full border border-line transition hover:border-ac hover:text-ac lg:hidden">
                <svg class="i size-6" viewBox="0 0 24 24"><path id="nm" d="M4 7h16M4 12h16M4 17h16"/></svg>
            </button>
        </div>
    </div>

    {{-- Mobile Navigation Dropdown --}}
    <div id="np" class="hidden max-h-[calc(100dvh-72px)] overflow-auto border-t border-line bg-bg/95 pb-6 lg:hidden">
        <nav class="wrap grid pt-2">
            <a class="ml" href="#about">About</a>
            <a class="ml" href="#expertise">Expertise</a>
            <a class="ml" href="#process">How we work</a>
            <a class="ml" href="#faq">FAQ</a>
            <a class="ml" href="#contact">Contact</a>
        </nav>
        <div class="wrap pt-5">
            <button type="button" id="openRegisterBtnMobile" class="btn btn-p group w-full justify-center cursor-pointer">
                <span>Enroll Now</span>
                <svg class="i" viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </button>
        </div>
    </div>
</header>