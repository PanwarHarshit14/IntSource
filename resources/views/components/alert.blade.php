@if (isset($errors) && $errors->any())
    <div class="mb-5 flex items-start gap-3 rounded-xl border border-rose-500/30 bg-rose-500/10 p-4 text-rose-300 backdrop-blur-md transition duration-300" role="alert">
        <svg class="mt-0.5 size-5 shrink-0 text-rose-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="8" x2="12" y2="12"></line>
            <line x1="12" y1="16" x2="12.01" y2="16"></line>
        </svg>
        <div class="flex-1 text-sm leading-relaxed">
            <p class="font-semibold text-rose-200">There were some problems with your input:</p>
            <ul class="mt-1.5 list-inside list-disc space-y-1 text-rose-300/90">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-rose-400/70 hover:text-rose-200 transition" aria-label="Dismiss">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </button>
    </div>
@endif

@if (Session::has('success'))
    <div class="mb-5 flex items-start gap-3 rounded-xl border border-emerald-500/30 bg-emerald-500/10 p-4 text-emerald-300 backdrop-blur-md transition duration-300" role="alert">
        <svg class="mt-0.5 size-5 shrink-0 text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
            <polyline points="22 4 12 14.01 9 11.01"></polyline>
        </svg>
        <div class="flex-1 text-sm font-medium leading-relaxed text-emerald-200">
            {{ Session::get('success') }}
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-emerald-400/70 hover:text-emerald-200 transition" aria-label="Dismiss">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </button>
    </div>
@endif

@if (Session::has('danger'))
    <div class="mb-5 flex items-start gap-3 rounded-xl border border-rose-500/30 bg-rose-500/10 p-4 text-rose-300 backdrop-blur-md transition duration-300" role="alert">
        <svg class="mt-0.5 size-5 shrink-0 text-rose-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="8" x2="12" y2="12"></line>
            <line x1="12" y1="16" x2="12.01" y2="16"></line>
        </svg>
        <div class="flex-1 text-sm font-medium leading-relaxed text-rose-200">
            {{ Session::get('danger') }}
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-rose-400/70 hover:text-rose-200 transition" aria-label="Dismiss">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </button>
    </div>
@endif