@extends('admin.layouts.app')

@section('main_section')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex flex-col gap-4 border-b border-slate-800 pb-5 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center gap-2 text-xs font-medium text-slate-400 mb-1">
                <a href="{{ route('admin.page.index') }}" class="hover:text-emerald-400 transition">Pages</a>
                <i class="ri-arrow-right-s-line text-slate-600"></i>
                <span class="text-emerald-400">Edit: {{ Str::limit($page->title, 25) }}</span>
            </div>
            <h1 class="font-display text-2xl font-bold tracking-tight text-white">Update Page</h1>
            <p class="text-xs text-slate-400">Modify content, layout settings, and featured assets for this page</p>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('page', $page->slug) }}"
               target="_blank"
               class="inline-flex items-center gap-1.5 rounded-xl border border-emerald-500/30 bg-emerald-500/10 px-3.5 py-2 text-xs font-semibold text-emerald-300 transition hover:bg-emerald-500 hover:text-slate-950">
                <i class="ri-external-link-line text-xs"></i>
                <span>View Live</span>
            </a>
            <a href="{{ route('admin.page.index') }}"
               class="inline-flex items-center gap-1.5 rounded-xl border border-slate-700 bg-slate-800/60 px-3.5 py-2 text-xs font-semibold text-slate-300 transition hover:bg-slate-800 hover:text-white">
                <i class="ri-arrow-left-line text-xs"></i>
                <span>Back to Pages</span>
            </a>
        </div>
    </div>

    <x-alert />

    <!-- Form Card -->
    <div class="relative overflow-hidden rounded-2xl border border-slate-800/80 bg-[#11161F]/90 p-6 sm:p-8 shadow-2xl backdrop-blur-xl">
        <!-- Top accent gradient -->
        <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-emerald-500 via-teal-400 to-cyan-500"></div>

        <form action="{{ route('admin.page.update', $page) }}" method="POST">
            @method('PUT')
            @csrf

            @include('admin.screens.pages._form')

            <div class="mt-8 flex items-center justify-end gap-3 border-t border-slate-800 pt-5">
                <a href="{{ route('admin.page.index') }}"
                   class="rounded-xl border border-slate-700 bg-slate-800/80 px-4 py-2.5 text-xs font-semibold text-slate-300 transition hover:bg-slate-700 hover:text-white">
                    Cancel
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-xl bg-emerald-400 px-5 py-2.5 text-xs font-bold text-slate-950 shadow-lg shadow-emerald-500/20 transition-all duration-200 hover:-translate-y-0.5 hover:bg-emerald-300 hover:shadow-emerald-500/30 active:translate-y-0 cursor-pointer">
                    <i class="ri-save-line text-sm"></i>
                    <span>Update Page Changes</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection