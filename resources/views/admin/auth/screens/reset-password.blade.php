@extends('admin.auth.layouts.app')

@section('content')
<div class="relative overflow-hidden rounded-2xl border border-slate-800 bg-[#11161F]/90 p-8 shadow-2xl backdrop-blur-xl">
    <!-- Top accent glow bar -->
    <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-emerald-500 via-teal-400 to-cyan-500"></div>

    <div class="mb-6 text-center">
        <div class="mx-auto mb-3 grid size-12 place-items-center rounded-2xl border border-emerald-500/30 bg-emerald-500/10 text-emerald-400 shadow-lg shadow-emerald-500/10">
            <i class="ri-lock-password-line text-2xl"></i>
        </div>
        <h1 class="font-display text-2xl font-bold tracking-tight text-white">Create New Password</h1>
        <p class="mt-1 text-sm text-slate-400">Choose a strong, unique password for your admin account</p>
    </div>

    <x-alert />

    <form action="{{ route('admin.reset-password.post') }}" method="post" autocomplete="off" class="space-y-5">
        @csrf

        <!-- New Password Input -->
        <div>
            <label for="password" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-slate-300">
                New Password <span class="text-rose-400">*</span>
            </label>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-500">
                    <i class="ri-lock-line text-base"></i>
                </span>
                <input type="password"
                       name="password"
                       id="password"
                       required
                       autofocus
                       placeholder="At least 6 characters"
                       class="w-full rounded-xl border border-slate-700/80 bg-[#0A0D14] py-2.5 pl-10 pr-11 text-sm text-white placeholder-slate-500 transition duration-200 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20">
                <button type="button"
                        class="toggle-password-btn absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 transition hover:text-slate-200"
                        data-target="password"
                        aria-label="Toggle password visibility"
                        tabindex="-1">
                    <i class="ri-eye-off-line text-base"></i>
                </button>
            </div>
        </div>

        <!-- Confirm Password Input -->
        <div>
            <label for="password_confirmation" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-slate-300">
                Confirm Password <span class="text-rose-400">*</span>
            </label>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-500">
                    <i class="ri-shield-keyhole-line text-base"></i>
                </span>
                <input type="password"
                       name="password_confirmation"
                       id="password_confirmation"
                       required
                       placeholder="Re-enter password"
                       class="w-full rounded-xl border border-slate-700/80 bg-[#0A0D14] py-2.5 pl-10 pr-11 text-sm text-white placeholder-slate-500 transition duration-200 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20">
                <button type="button"
                        class="toggle-password-btn absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 transition hover:text-slate-200"
                        data-target="password_confirmation"
                        aria-label="Toggle password confirmation visibility"
                        tabindex="-1">
                    <i class="ri-eye-off-line text-base"></i>
                </button>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit"
                    class="group relative flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-400 px-4 py-3 text-sm font-bold text-slate-950 shadow-lg shadow-emerald-500/20 transition-all duration-200 hover:-translate-y-0.5 hover:bg-emerald-300 hover:shadow-emerald-500/30 active:translate-y-0">
                <span>Save New Password</span>
                <i class="ri-check-line text-sm transition-transform duration-200 group-hover:scale-125"></i>
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

@push('extra_scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.toggle-password-btn').forEach(button => {
            button.addEventListener('click', function () {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon = this.querySelector('i');
                if (input && icon) {
                    const isPassword = input.getAttribute('type') === 'password';
                    input.setAttribute('type', isPassword ? 'text' : 'password');
                    if (isPassword) {
                        icon.className = 'ri-eye-line text-base';
                    } else {
                        icon.className = 'ri-eye-off-line text-base';
                    }
                }
            });
        });
    });
</script>
@endpush