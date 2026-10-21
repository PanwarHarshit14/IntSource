@extends('admin.auth.layouts.app')

@section('content')
<div class="relative overflow-hidden rounded-2xl border border-slate-800 bg-[#11161F]/90 p-8 shadow-2xl backdrop-blur-xl">
    <!-- Top accent glow bar -->
    <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-emerald-500 via-teal-400 to-cyan-500"></div>

    <div class="mb-6 text-center">
        <div class="mx-auto mb-3 grid size-12 place-items-center rounded-2xl border border-emerald-500/30 bg-emerald-500/10 text-emerald-400 shadow-lg shadow-emerald-500/10">
            <i class="ri-key-2-line text-2xl"></i>
        </div>
        <h1 class="font-display text-2xl font-bold tracking-tight text-white">Reset Password</h1>
        <p class="mt-1 text-sm text-slate-400">Enter your registered email to receive a one-time OTP</p>
    </div>

    <x-alert />

    <form action="{{ route('admin.forgot-password.post') }}" method="post" autocomplete="off" class="space-y-5">
        @csrf

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
                       value="{{ old('email') }}"
                       required
                       autofocus
                       placeholder="admin@example.com"
                       class="w-full rounded-xl border border-slate-700/80 bg-[#0A0D14] py-2.5 pl-10 pr-4 text-sm text-white placeholder-slate-500 transition duration-200 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20">
            </div>
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit"
                    class="group relative flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-400 px-4 py-3 text-sm font-bold text-slate-950 shadow-lg shadow-emerald-500/20 transition-all duration-200 hover:-translate-y-0.5 hover:bg-emerald-300 hover:shadow-emerald-500/30 active:translate-y-0">
                <span>Send Verification OTP</span>
                <i class="ri-send-plane-line text-sm transition-transform duration-200 group-hover:translate-x-1"></i>
            </button>
        </div>

        <!-- Back to Login -->
        <div class="text-center pt-2">
            <a href="{{ route('admin.login') }}" class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-400 transition hover:text-emerald-400">
                <i class="ri-arrow-left-line text-xs"></i>
                <span>Back to Sign In</span>
            </a>
        </div>
    </form>
</div>
@endsection