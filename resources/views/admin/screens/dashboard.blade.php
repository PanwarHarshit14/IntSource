@extends('admin.layouts.app')

@section('main_section')
<div class="space-y-8">
    <x-alert />

    <!-- Hero Welcome Banner -->
    <div class="relative overflow-hidden rounded-3xl border border-slate-800 bg-gradient-to-br from-[#11161F] via-[#171E2B] to-[#11161F] p-6 sm:p-8 lg:p-10 shadow-2xl">
        <!-- Ambient decorative glow -->
        <div class="absolute -right-20 -top-20 size-72 rounded-full bg-emerald-500/10 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-20 -left-20 size-72 rounded-full bg-cyan-500/10 blur-3xl pointer-events-none"></div>

        <div class="relative flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center gap-5">
                <div class="relative shrink-0">
                    @if(!empty($contact->favicon))
                        <div class="grid size-16 place-items-center rounded-2xl border border-emerald-500/30 bg-emerald-500/10 p-2 shadow-lg shadow-emerald-500/10">
                            <img src="{{ asset($contact->favicon) }}" alt="{{ $contact->name ?? 'Admin' }}" class="size-11 object-contain">
                        </div>
                    @else
                        <div class="grid size-16 place-items-center rounded-2xl border border-emerald-500/30 bg-emerald-500/10 text-emerald-400 shadow-lg shadow-emerald-500/10 text-2xl">
                            <i class="ri-dashboard-3-line text-3xl"></i>
                        </div>
                    @endif
                    <span class="absolute -bottom-1 -right-1 flex size-4">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex size-4 rounded-full bg-emerald-500 border-2 border-[#11161F]"></span>
                    </span>
                </div>
                <div>
                    <div class="flex flex-wrap items-center gap-2.5">
                        <h1 class="font-display text-2xl font-bold tracking-tight text-white sm:text-3xl">
                            Welcome, <span class="bg-gradient-to-r from-emerald-400 via-teal-300 to-cyan-400 bg-clip-text text-transparent">{{ Auth::guard('admin')->user()->name }}</span>
                        </h1>
                        <span class="inline-flex items-center gap-1.5 rounded-full border border-emerald-500/30 bg-emerald-500/10 px-2.5 py-0.5 text-xs font-semibold text-emerald-300">
                            <span class="size-1.5 rounded-full bg-emerald-400"></span>
                            Live
                        </span>
                    </div>
                    <p class="mt-1.5 text-sm text-slate-400 max-w-xl">
                        Administrator Dashboard for <strong class="text-slate-200">{{ $contact->name ?? 'DPS / IntSource' }}</strong>. Manage site settings, contact profiles, and system preferences.
                    </p>
                </div>
            </div>

            <!-- Quick Action Buttons -->
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.contact.index') }}"
                   class="inline-flex items-center gap-2 rounded-xl bg-emerald-400 px-4 py-2.5 text-xs font-bold text-slate-950 shadow-lg shadow-emerald-500/20 transition duration-200 hover:-translate-y-0.5 hover:bg-emerald-300 hover:shadow-emerald-500/30">
                    <i class="ri-settings-4-line text-sm"></i>
                    <span>Site Settings</span>
                </a>
                <a href="{{ route('home') }}"
                   target="_blank"
                   class="inline-flex items-center gap-2 rounded-xl border border-slate-700 bg-slate-800/80 px-4 py-2.5 text-xs font-semibold text-slate-200 transition duration-200 hover:bg-slate-700 hover:text-white">
                    <i class="ri-global-line text-sm text-emerald-400"></i>
                    <span>Preview Site</span>
                    <i class="ri-external-link-line text-xs text-slate-500"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection