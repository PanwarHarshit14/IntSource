@extends('admin.auth.layouts.app')

@section('content')
<div class="relative overflow-hidden rounded-2xl border border-slate-800 bg-[#11161F]/90 p-8 shadow-2xl backdrop-blur-xl">
    <!-- Top accent glow bar -->
    <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-emerald-500 via-teal-400 to-cyan-500"></div>

    <div class="mb-6 text-center">
        <h1 class="font-display text-2xl font-bold tracking-tight text-white">Sign In</h1>
        <p class="mt-1 text-sm text-slate-400">Enter your credentials to access the admin portal</p>
    </div>

    <x-alert />

    <form action="{{ route('admin.login.post') }}" method="post" autocomplete="off" class="space-y-5">
        @csrf

        <!-- Username Input -->
        <div>
            <label for="username" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-slate-300">
                Username <span class="text-rose-400">*</span>
            </label>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-500">
                    <i class="ri-user-line text-base"></i>
                </span>
                <input type="text"
                       name="username"
                       id="username"
                       value="{{ old('username') }}"
                       required
                       autofocus
                       placeholder="Enter your username"
                       class="w-full rounded-xl border border-slate-700/80 bg-[#0A0D14] py-2.5 pl-10 pr-4 text-sm text-white placeholder-slate-500 transition duration-200 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20">
            </div>
        </div>

        <!-- Password Input -->
        <div>
            <div class="mb-1.5 flex items-center justify-between">
                <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-300">
                    Password <span class="text-rose-400">*</span>
                </label>
                <a href="{{ route('admin.forgot-password') }}" class="text-xs font-medium text-emerald-400 transition hover:text-emerald-300 hover:underline">
                    Forgot password?
                </a>
            </div>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-500">
                    <i class="ri-lock-2-line text-base"></i>
                </span>
                <input type="password"
                       name="password"
                       id="password"
                       required
                       placeholder="Enter your password"
                       class="w-full rounded-xl border border-slate-700/80 bg-[#0A0D14] py-2.5 pl-10 pr-11 text-sm text-white placeholder-slate-500 transition duration-200 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20">
                <button type="button"
                        id="togglePasswordBtn"
                        class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 transition hover:text-slate-200"
                        aria-label="Toggle password visibility"
                        tabindex="-1">
                    <i id="passwordIcon" class="ri-eye-off-line text-base"></i>
                </button>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit"
                    class="group relative flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-400 px-4 py-3 text-sm font-bold text-slate-950 shadow-lg shadow-emerald-500/20 transition-all duration-200 hover:-translate-y-0.5 hover:bg-emerald-300 hover:shadow-emerald-500/30 active:translate-y-0">
                <span>Sign in to Dashboard</span>
                <i class="ri-arrow-right-line text-sm transition-transform duration-200 group-hover:translate-x-1"></i>
            </button>
        </div>
    </form>
</div>
@endsection

@push('extra_scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('togglePasswordBtn');
        const passwordInput = document.getElementById('password');
        const passwordIcon = document.getElementById('passwordIcon');

        if (toggleBtn && passwordInput && passwordIcon) {
            toggleBtn.addEventListener('click', function () {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                if (isPassword) {
                    passwordIcon.className = 'ri-eye-line text-base';
                } else {
                    passwordIcon.className = 'ri-eye-off-line text-base';
                }
            });
        }
    });
</script>
@endpush