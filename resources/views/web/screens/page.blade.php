@extends('web.layouts.app')

@section('title', $page->title . ' | ' . ($contact?->name ?? 'IntSource'))

@section('content')
    {{-- Breadcrumb Header --}}
    <x-web.breadcrumb 
        :title="$page->title" 
        :links="[
            'Home' => route('home'),
            $page->title => null
        ]" 
    />

    {{-- Page Body Section --}}
    <section class="sec relative overflow-hidden py-16 sm:py-24">
        <!-- Ambient Background Glow -->
        <div class="pointer-events-none absolute left-1/4 top-1/3 size-[400px] -translate-x-1/2 rounded-full bg-[#0c2454]/20 blur-[140px]"></div>

        <div class="wrap relative">
            @if(!empty($page->image))
                {{-- 2-Column Layout when Featured Image exists --}}
                <div class="grid gap-12 lg:grid-cols-[1fr_420px] xl:grid-cols-[1fr_460px] items-start">
                    {{-- Primary Article Content --}}
                    <article class="prose-intsource rounded-3xl border border-line bg-s1/60 p-6 sm:p-10 lg:p-12 backdrop-blur-xl shadow-xl">
                        <div class="mb-8 border-b border-line pb-6">
                            <span class="inline-flex items-center gap-2 rounded-full border border-line bg-s2 px-3 py-1 text-xs font-mono text-mu">
                                <span class="size-1.5 rounded-full bg-ac"></span>
                                <span>Official Page</span>
                            </span>
                            <h2 class="mt-4 font-display text-2xl font-bold tracking-tight text-white sm:text-3xl">
                                {{ $page->title }}
                            </h2>
                        </div>

                        <div class="page-content leading-relaxed text-[#E8ECF4]">
                            @if(strip_tags($page->description) === $page->description)
                                {!! nl2br(e($page->description)) !!}
                            @else
                                {!! $page->description !!}
                            @endif
                        </div>
                    </article>

                    {{-- Sticky Sidebar with Featured Image & Quick Info --}}
                    <aside class="space-y-6 lg:sticky lg:top-24">
                        {{-- Featured Image Card --}}
                        <div class="group overflow-hidden rounded-3xl border border-line bg-s1 p-3.5 shadow-xl transition-all duration-300 hover:border-ac/50">
                            <div class="relative overflow-hidden rounded-2xl bg-s2">
                                <img src="{{ $page->image }}" 
                                     alt="{{ $page->title }}" 
                                     class="max-h-[380px] w-full object-cover transition-transform duration-500 group-hover:scale-105">
                            </div>
                            <div class="p-3 text-center">
                                <p class="text-xs font-medium text-mu">{{ $page->title }}</p>
                            </div>
                        </div>

                        {{-- Quick Contact / Assistance Card --}}
                        <div class="rounded-3xl border border-line bg-gradient-to-b from-s1 to-s2 p-6 sm:p-7 shadow-lg">
                            <div class="flex items-center gap-3">
                                <span class="grid size-10 place-items-center rounded-xl bg-[#0c2454] text-white shadow-md">
                                    <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                </span>
                                <div>
                                    <h4 class="font-display text-base font-bold text-white">Have questions?</h4>
                                    <p class="text-xs text-mu">Our team is here to assist you.</p>
                                </div>
                            </div>
                            <p class="mt-4 text-xs text-mu leading-relaxed">
                                Get in touch with {{ $contact?->name ?? 'IntSource' }} experts to discuss custom technology, software solutions, or project details.
                            </p>
                            <div class="mt-6 flex flex-col gap-2.5">
                                <a href="{{ route('home') }}#contact" class="btn btn-p justify-center w-full !text-xs !py-2.5">
                                    <span>Contact Team</span>
                                    <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                                </a>
                                <a href="{{ route('home') }}" class="btn btn-g justify-center w-full !text-xs !py-2.5">
                                    <span>Back to Home</span>
                                </a>
                            </div>
                        </div>
                    </aside>
                </div>
            @else
                {{-- Centered Magazine Article Layout when no image --}}
                <div class="mx-auto max-w-4xl">
                    <article class="prose-intsource rounded-3xl border border-line bg-s1/60 p-6 sm:p-12 lg:p-14 backdrop-blur-xl shadow-2xl">
                        <div class="mb-10 border-b border-line pb-8 text-center sm:text-left">
                            <span class="inline-flex items-center gap-2 rounded-full border border-line bg-s2 px-3.5 py-1 text-xs font-mono text-mu">
                                <span class="size-1.5 rounded-full bg-ac"></span>
                                <span>Published Information</span>
                            </span>
                            <h2 class="mt-4 font-display text-3xl font-bold tracking-tight text-white sm:text-4xl">
                                {{ $page->title }}
                            </h2>
                        </div>

                        <div class="page-content leading-relaxed text-[#E8ECF4]">
                            @if(strip_tags($page->description) === $page->description)
                                {!! nl2br(e($page->description)) !!}
                            @else
                                {!! $page->description !!}
                            @endif
                        </div>

                        <div class="mt-12 flex flex-wrap items-center justify-between gap-4 border-t border-line pt-8">
                            <a href="{{ route('home') }}" class="btn btn-g !py-2 !px-4 text-xs">
                                <svg class="size-3.5 rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                                <span>Back to Home</span>
                            </a>
                            <a href="{{ route('home') }}#contact" class="btn btn-p !py-2 !px-4 text-xs">
                                <span>Discuss with us</span>
                                <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                            </a>
                        </div>
                    </article>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('styles')
<style>
    /* IntSource Page Content Prose Styling */
    .page-content h1, .page-content h2, .page-content h3, .page-content h4 {
        color: #FFFFFF;
        font-family: 'Space Grotesk', sans-serif;
        font-weight: 700;
        margin-top: 1.75rem;
        margin-bottom: 0.75rem;
        line-height: 1.3;
    }
    .page-content h1 { font-size: 1.875rem; }
    .page-content h2 { font-size: 1.5rem; }
    .page-content h3 { font-size: 1.25rem; }
    .page-content h4 { font-size: 1.1rem; }
    .page-content p {
        margin-bottom: 1.25rem;
        line-height: 1.8;
        color: #D3DBE8;
    }
    .page-content ul, .page-content ol {
        margin-top: 0.75rem;
        margin-bottom: 1.25rem;
        padding-left: 1.5rem;
        color: #D3DBE8;
    }
    .page-content ul { list-style-type: disc; }
    .page-content ol { list-style-type: decimal; }
    .page-content li {
        margin-bottom: 0.5rem;
        line-height: 1.7;
    }
    .page-content a {
        color: #60a5fa;
        text-decoration: underline;
        text-underline-offset: 4px;
        transition: color 0.2s ease;
    }
    .page-content a:hover {
        color: #93c5fd;
    }
    .page-content blockquote {
        border-left: 3px solid #0c2454;
        background: rgba(18, 24, 38, 0.6);
        padding: 1rem 1.25rem;
        border-radius: 0 0.75rem 0.75rem 0;
        font-style: italic;
        margin: 1.5rem 0;
        color: #cbd5e1;
    }
    .page-content code {
        font-family: 'IBM Plex Mono', monospace;
        font-size: 0.875em;
        background: rgba(17, 22, 31, 0.9);
        border: 1px solid rgba(42, 52, 72, 0.7);
        padding: 0.2em 0.4em;
        border-radius: 0.375rem;
        color: #93c5fd;
    }
    .page-content pre {
        background: #0A0D14;
        border: 1px solid rgba(42, 52, 72, 0.8);
        border-radius: 1rem;
        padding: 1.25rem;
        overflow-x: auto;
        margin: 1.5rem 0;
    }
</style>
@endpush
