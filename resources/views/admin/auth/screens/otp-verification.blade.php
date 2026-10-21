@extends('admin.auth.layouts.app')

@section('content')
<div class="relative overflow-hidden rounded-2xl border border-slate-800 bg-[#11161F]/90 p-8 shadow-2xl backdrop-blur-xl">
    <!-- Top accent glow bar -->
    <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-emerald-500 via-teal-400 to-cyan-500"></div>

    <div class="mb-6 text-center">
        <div class="mx-auto mb-3 grid size-12 place-items-center rounded-2xl border border-emerald-500/30 bg-emerald-500/10 text-emerald-400 shadow-lg shadow-emerald-500/10">
            <i class="ri-shield-keyhole-line text-2xl"></i>
        </div>
        <h1 class="font-display text-2xl font-bold tracking-tight text-white">Enter OTP</h1>
        <p class="mt-1 text-sm text-slate-400">
            A 6-digit verification code was sent to
            @if(session('email'))
                <span class="font-medium text-emerald-400">{{ session('email') }}</span>
            @else
                <span>your registered email</span>
            @endif
        </p>
    </div>

    <x-alert />

    <form action="{{ route('admin.otp-verification.post') }}" method="post" autocomplete="off" class="space-y-5">
        @csrf

        <!-- OTP Input -->
        <div>
            <label for="otp" class="mb-1.5 block text-center text-xs font-semibold uppercase tracking-wider text-slate-300">
                6-Digit Verification Code <span class="text-rose-400">*</span>
            </label>
            <div class="relative">
                <input type="text"
                       name="otp"
                       id="otp"
                       required
                       autofocus
                       inputmode="numeric"
                       pattern="[0-9]*"
                       maxlength="6"
                       placeholder="&bull;&bull;&bull;&bull;&bull;&bull;"
                       class="w-full rounded-xl border border-slate-700/80 bg-[#0A0D14] py-3 text-center font-mono text-2xl font-bold tracking-[0.5em] text-emerald-300 placeholder-slate-600 transition duration-200 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20">
            </div>
            <p class="mt-1.5 text-center text-xs text-slate-500">The code will expire in 5 minutes.</p>
        </div>

        <!-- Verify Button -->
        <div class="pt-2">
            <button type="submit"
                    class="group relative flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-400 px-4 py-3 text-sm font-bold text-slate-950 shadow-lg shadow-emerald-500/20 transition-all duration-200 hover:-translate-y-0.5 hover:bg-emerald-300 hover:shadow-emerald-500/30 active:translate-y-0">
                <span>Verify & Proceed</span>
                <i class="ri-check-line text-sm transition-transform duration-200 group-hover:scale-125"></i>
            </button>
        </div>

        <!-- Back to Login / Resend -->
        <div class="flex items-center justify-between pt-2 text-xs">
            <a href="{{ route('admin.forgot-password') }}" class="font-medium text-slate-400 transition hover:text-emerald-400">
                Request new code
            </a>
            <a href="{{ route('admin.login') }}" class="font-medium text-slate-400 transition hover:text-emerald-400">
                Back to Sign In
            </a>
        </div>
    </form>
</div>
@endsection

@push('extra_scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const otpInput = document.getElementById('otp');
        if (otpInput) {
            otpInput.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        }
    });
</script>
@endpush