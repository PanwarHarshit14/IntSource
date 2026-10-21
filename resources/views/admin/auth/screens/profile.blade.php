@extends('admin.layouts.app')

@section('main_section')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-display text-2xl font-bold tracking-tight text-white">Administrator Profile</h1>
            <p class="text-sm text-slate-400">Update your account credentials, display name, and contact email</p>
        </div>
        <a href="{{ route('admin.dashboard') }}"
           class="inline-flex items-center gap-1.5 rounded-xl border border-slate-700 bg-slate-800/60 px-3.5 py-2 text-xs font-semibold text-slate-300 transition hover:bg-slate-800 hover:text-white">
            <i class="ri-arrow-left-line text-xs"></i>
            <span>Dashboard</span>
        </a>
    </div>

    <x-alert />

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Left: Identity Overview Card -->
        <div class="flex flex-col items-center justify-center rounded-2xl border border-slate-800/80 bg-[#11161F]/90 p-8 text-center shadow-xl">
            <div class="relative">
                <div class="grid size-24 place-items-center rounded-3xl bg-gradient-to-br from-emerald-400 to-teal-500 font-display text-3xl font-extrabold text-slate-950 shadow-xl shadow-emerald-500/20">
                    {{ strtoupper(substr($admin->name ?? 'A', 0, 2)) }}
                </div>
                <span class="absolute -bottom-1 -right-1 flex size-5">
                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex size-5 rounded-full bg-emerald-500 border-2 border-[#11161F]"></span>
                </span>
            </div>

            <h2 class="mt-4 font-display text-lg font-bold text-white">{{ $admin->name }}</h2>
            <p class="font-mono text-xs text-emerald-400">&#64;{{ $admin->username }}</p>

            <div class="mt-4 inline-flex items-center gap-1.5 rounded-full border border-emerald-500/30 bg-emerald-500/10 px-3 py-1 font-mono text-[11px] font-semibold uppercase tracking-wider text-emerald-400">
                <i class="ri-shield-check-line text-xs"></i>
                Super Administrator
            </div>

            <div class="mt-6 w-full rounded-xl border border-slate-800 bg-slate-900/60 p-3.5 text-left text-xs text-slate-400">
                <p class="flex items-center gap-1.5 font-semibold text-slate-300 mb-1">
                    <i class="ri-information-line text-emerald-400 text-sm"></i>
                    <span>Notice</span>
                </p>
                <p class="leading-relaxed text-[11px]">
                    Updating your email address will automatically sign you out so you can authenticate with your new credentials.
                </p>
            </div>
        </div>

        <!-- Right: Profile Edit Form -->
        <div class="rounded-2xl border border-slate-800/80 bg-[#11161F]/90 p-6 sm:p-8 shadow-xl lg:col-span-2">
            <div class="border-b border-slate-800 pb-4 mb-6">
                <h2 class="font-display text-lg font-bold text-white">Account Details</h2>
                <p class="text-xs text-slate-400">Ensure your administrative contact information is up to date</p>
            </div>

            <form action="{{ route('admin.profile.post', $admin) }}" method="POST" class="space-y-5">
                @csrf

                <!-- Name Input -->
                <div>
                    <label for="name" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-slate-300">
                        Full Name <span class="text-rose-400">*</span>
                    </label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-500">
                            <i class="ri-user-line text-base"></i>
                        </span>
                        <input type="text"
                               name="name"
                               id="name"
                               value="{{ old('name', $admin->name) }}"
                               required
                               placeholder="e.g. John Doe"
                               class="w-full rounded-xl border border-slate-700/80 bg-[#0A0D14] py-2.5 pl-10 pr-4 text-sm text-white placeholder-slate-500 transition duration-200 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20">
                    </div>
                </div>

                <!-- Username Input -->
                <div>
                    <label for="username" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-slate-300">
                        Username <span class="text-rose-400">*</span>
                    </label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-500">
                            <i class="ri-at-line text-base"></i>
                        </span>
                        <input type="text"
                               name="username"
                               id="username"
                               value="{{ old('username', $admin->username) }}"
                               required
                               placeholder="e.g. admin"
                               class="w-full rounded-xl border border-slate-700/80 bg-[#0A0D14] py-2.5 pl-10 pr-4 text-sm text-white placeholder-slate-500 transition duration-200 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20">
                    </div>
                </div>

                <!-- Email Input -->
                <div>
                    <label for="email" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-slate-300">
                        Email Address <span class="text-rose-400">*</span>
                    </label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-500">
                            <i class="ri-mail-line text-base"></i>
                        </span>
                        <input type="email"
                               name="email"
                               id="email"
                               value="{{ old('email', $admin->email) }}"
                               required
                               placeholder="admin@example.com"
                               class="w-full rounded-xl border border-slate-700/80 bg-[#0A0D14] py-2.5 pl-10 pr-4 text-sm text-white placeholder-slate-500 transition duration-200 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-xl bg-emerald-400 px-5 py-2.5 text-sm font-bold text-slate-950 shadow-lg shadow-emerald-500/20 transition-all duration-200 hover:-translate-y-0.5 hover:bg-emerald-300 hover:shadow-emerald-500/30 active:translate-y-0">
                        <i class="ri-check-line text-base"></i>
                        <span>Save Profile Changes</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection