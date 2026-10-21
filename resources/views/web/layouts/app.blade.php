<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth bg-bg">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="color-scheme" content="dark">
    <title>@yield('title', 'IntSource | IT Solutions')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:ital,wght@0,400;0,500;1,400&family=IBM+Plex+Sans:wght@400;500;600&family=Space+Grotesk:wght@500;600;700&display=swap">

    <!-- Remix Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body id="top" class="overflow-x-hidden bg-bg font-sans text-[17px] leading-relaxed text-[#E8ECF4] antialiased">

    {{-- Header Layout Component --}}
    <x-web.header />

    {{-- Main Content --}}
    <main id="main-content">
        @yield('content')
    </main>

    {{-- Footer Layout Component --}}
    <x-web.footer />

    {{-- Floating Action Button: WhatsApp (Left Side) --}}
    <div class="fixed bottom-[calc(20px+env(safe-area-inset-bottom,0px))] left-4 z-40 sm:left-6">
        <a href="https://wa.me/910000000000?text=Hello%20IntSource%2C%20I%27d%20like%20to%20discuss%20a%20project." target="_blank" rel="noopener noreferrer" aria-label="Chat on WhatsApp" class="group relative grid size-14 animate-wa place-items-center rounded-full bg-[#1EA952] text-white shadow-lg transition-transform duration-300 hover:scale-110">
            <span class="pointer-events-none absolute left-full ml-3 hidden whitespace-nowrap rounded-lg border border-line bg-s2 px-3 py-1.5 text-sm text-[#E8ECF4] opacity-0 transition group-hover:opacity-100 lg:block">Chat on WhatsApp</span>
            <svg class="size-7 fill-current" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
        </a>
    </div>

    {{-- Floating Action Button: Back to Top (Right Side) --}}
    <div class="fixed bottom-[calc(20px+env(safe-area-inset-bottom,0px))] right-4 z-40 sm:right-6">
        <a id="bt" href="#top" aria-label="Back to top" class="pointer-events-none grid size-12 translate-y-3 place-items-center rounded-full border border-line bg-s2/80 text-ac opacity-0 shadow-lg backdrop-blur-md transition duration-300 hover:-translate-y-1 hover:border-ac hover:bg-ac hover:text-[#04130D]">
            <svg class="i size-5" viewBox="0 0 24 24"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
        </a>
    </div>

    {{-- Interactive Service Details Modal --}}
    <dialog id="m" class="m-auto max-h-[88dvh] w-[min(92vw,580px)] overflow-auto overscroll-contain rounded-3xl border border-line bg-s1 text-[#E8ECF4] open:animate-pop backdrop:bg-black/70 backdrop:backdrop-blur-sm">
        <div class="relative p-7 sm:p-10">
            <button id="x" type="button" aria-label="Close" class="absolute right-4 top-4 grid size-10 place-items-center rounded-full border border-line text-xl transition hover:border-ac hover:text-ac">×</button>
            <div id="mi" class="ico !mb-6"></div>
            <h3 id="mt" class="text-[28px]"></h3>
            <p id="md" class="mt-4 text-mu"></p>
            <h4 id="mbh" class="eyebrow mt-7 !font-mono !text-[13px] !font-normal">What we deliver</h4>
            <ul id="mb" class="mt-4 grid gap-3"></ul>
            <div class="mt-9 grid gap-3 sm:flex sm:flex-wrap">
                <a id="mc" href="#contact" class="btn btn-p group justify-center">Discuss this service <svg viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
                <button id="x2" type="button" class="btn btn-g justify-center">Close</button>
            </div>
        </div>
    </dialog>

    {{-- Interactive Student Registration Modal --}}
    <x-web.register-modal />

    @stack('scripts')
</body>
</html>