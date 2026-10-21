@extends('admin.layouts.app')

@section('main_section')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between border-b border-slate-800 pb-5">
        <div>
            <div class="flex items-center gap-2 text-xs font-medium text-slate-400 mb-1">
                <a href="{{ route('admin.faq.index') }}" class="hover:text-emerald-400 transition">FAQs</a>
                <i class="ri-arrow-right-s-line text-slate-600"></i>
                <span class="text-emerald-400">Edit FAQ #{{ $faq->id }}</span>
            </div>
            <h1 class="font-display text-2xl font-bold tracking-tight text-white">Update FAQ</h1>
            <p class="text-xs text-slate-400">Edit the question or refine the answer</p>
        </div>
        <a href="{{ route('admin.faq.index') }}"
           class="inline-flex items-center gap-1.5 rounded-xl border border-slate-700 bg-slate-800/60 px-3.5 py-2 text-xs font-semibold text-slate-300 transition hover:bg-slate-800 hover:text-white">
            <i class="ri-arrow-left-line text-xs"></i>
            <span>Back to FAQs</span>
        </a>
    </div>

    <x-alert />

    <!-- Form Card -->
    <div class="relative overflow-hidden rounded-2xl border border-slate-800/80 bg-[#11161F]/90 p-6 sm:p-8 shadow-2xl backdrop-blur-xl">
        <!-- Top accent gradient -->
        <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-emerald-500 via-teal-400 to-cyan-500"></div>

        <form action="{{ route('admin.faq.update', $faq) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.screens.faq._form')

            <div class="mt-8 flex items-center justify-end gap-3 border-t border-slate-800 pt-5">
                <a href="{{ route('admin.faq.index') }}"
                   class="rounded-xl border border-slate-700 bg-slate-800/80 px-4 py-2.5 text-xs font-semibold text-slate-300 transition hover:bg-slate-700 hover:text-white">
                    Cancel
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-xl bg-emerald-400 px-5 py-2.5 text-xs font-bold text-slate-950 shadow-lg shadow-emerald-500/20 transition-all duration-200 hover:-translate-y-0.5 hover:bg-emerald-300 hover:shadow-emerald-500/30 active:translate-y-0">
                    <i class="ri-check-line text-sm"></i>
                    <span>Update FAQ</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection