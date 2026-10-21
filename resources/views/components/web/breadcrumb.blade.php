{{-- Dynamic Breadcrumb Header Component --}}
<section class="relative overflow-hidden border-b border-line bg-bg py-14 sm:py-20">
    <!-- Animated Subtle Tech Grid Pattern Background -->
    <div class="pointer-events-none absolute inset-0 animate-drift opacity-40 [background-image:linear-gradient(#232C3D_1px,transparent_1px),linear-gradient(90deg,#232C3D_1px,transparent_1px)] [background-size:56px_56px] [mask-image:radial-gradient(ellipse_at_50%_50%,#000_20%,transparent_75%)]"></div>

    <!-- Soft Ambient Navy/Blue Glow -->
    <div class="pointer-events-none absolute left-1/2 top-0 -translate-x-1/2 -translate-y-1/2 size-[500px] rounded-full bg-[#0c2454]/30 blur-[120px]"></div>

    <div class="wrap relative text-center">
        <!-- Breadcrumb Nav Trail Pill -->
        <div class="inline-flex items-center justify-center">
            <nav aria-label="Breadcrumb" class="inline-flex flex-wrap items-center gap-2 rounded-full border border-line bg-s1/80 px-4 py-1.5 text-xs font-medium text-mu shadow-sm backdrop-blur-md">
                @foreach ($links as $label => $url)
                    @if (!$loop->first)
                        <svg class="size-3 text-slate-600 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
                    @endif

                    @if ($loop->last || empty($url))
                        <span class="max-w-[220px] truncate font-semibold text-white sm:max-w-xs" aria-current="page">
                            {{ $label }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="inline-flex items-center gap-1.5 transition-colors hover:text-white hover:underline">
                            @if ($loop->first)
                                <svg class="size-3.5 text-ac" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                            @endif
                            <span>{{ $label }}</span>
                        </a>
                    @endif
                @endforeach
            </nav>
        </div>

        <!-- Page Title -->
        <h1 class="mt-5 font-display text-[32px] font-bold tracking-tight text-white sm:text-[42px] lg:text-[48px]">
            {{ $title }}
        </h1>

        <!-- Decorative Accent Bar -->
        <div class="mx-auto mt-4 h-1 w-12 rounded-full bg-gradient-to-r from-[#0c2454] via-blue-500 to-[#0c2454]"></div>
    </div>
</section>