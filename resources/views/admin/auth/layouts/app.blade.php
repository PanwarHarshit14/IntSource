<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#0A0D14]">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" type="image/png" href="{{ $contact->favicon ?? asset('favicon.ico') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME', 'IntSource') }} &bull; Admin Portal</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:ital,wght@0,400;0,500;1,400&family=IBM+Plex+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap">

    <!-- Remix Icon (Modern Icon System) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css">
    <!-- FontAwesome 6 CDN (Fallback) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind CSS (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('extra_styles')
</head>

<body class="min-h-full bg-[#0A0D14] font-sans text-slate-100 antialiased selection:bg-emerald-500/30 selection:text-emerald-200">
    <!-- Ambient Backdrop Effects -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-40 -left-40 size-96 rounded-full bg-emerald-500/10 blur-3xl"></div>
        <div class="absolute -bottom-40 -right-40 size-96 rounded-full bg-cyan-500/10 blur-3xl"></div>
        <div class="absolute inset-0 bg-[radial-gradient(#232c3d_1px,transparent_1px)] [background-size:24px_24px] opacity-25"></div>
    </div>

    <!-- Main Container -->
    <div class="relative flex min-h-screen flex-col items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            <!-- Brand Logo Header -->
            <div class="mb-8 text-center">
                <a href="{{ route('home') }}" class="group inline-flex flex-col items-center gap-3 transition">
                    @if(!empty($contact->logo))
                        <img src="{{ asset($contact->logo) }}" alt="{{ $contact->name ?? 'Admin Portal' }}" class="h-12 w-auto max-w-[200px] object-contain transition duration-300 group-hover:scale-105">
                    @elseif(!empty($contact->favicon))
                        <div class="grid size-12 place-items-center rounded-2xl border border-emerald-500/30 bg-emerald-500/10 text-emerald-400 shadow-lg shadow-emerald-500/10">
                            <img src="{{ asset($contact->favicon) }}" alt="{{ $contact->name ?? 'Admin' }}" class="size-8 object-contain">
                        </div>
                    @else
                        <div class="grid size-12 place-items-center rounded-2xl border border-emerald-500/30 bg-emerald-500/10 text-emerald-400 shadow-lg shadow-emerald-500/10">
                            <i class="fa-solid fa-shield-halved text-xl"></i>
                        </div>
                    @endif
                    <div class="flex items-center gap-2">
                        <span class="font-display text-xl font-bold tracking-tight text-white">{{ $contact->name ?? env('APP_NAME', 'Admin') }}</span>
                        <span class="rounded-md border border-emerald-500/30 bg-emerald-500/10 px-2 py-0.5 font-mono text-[11px] font-semibold uppercase tracking-wider text-emerald-400">Panel</span>
                    </div>
                </a>
            </div>

            <!-- Auth Screen Card Slot -->
            <div class="relative">
                @yield('content')
            </div>

            <!-- Footer Meta -->
            <div class="mt-8 text-center text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} {{ $contact->name ?? env('APP_NAME', 'IntSource') }}. All rights reserved.</p>
                <div class="mt-2 flex items-center justify-center gap-4 text-slate-600">
                    <span class="flex items-center gap-1.5">
                        <span class="size-1.5 rounded-full bg-emerald-400"></span>
                        Secure Authentication
                    </span>
                    <span>&bull;</span>
                    <a href="{{ route('home') }}" class="hover:text-emerald-400 transition">Return to Site</a>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery for legacy form handlers if needed -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    @stack('extra_scripts')
</body>
</html>