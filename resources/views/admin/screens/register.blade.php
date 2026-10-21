@extends('admin.layouts.app')

@section('main_section')
<!-- Single Item Delete Hidden Form -->
<form action="" method="post" id="deleteForm" class="hidden">
    @method('DELETE')
    @csrf
</form>

<div class="space-y-6">
    <x-alert />

    <!-- Top KPI Cards -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Card 1: Total Registrations -->
        <div class="relative overflow-hidden rounded-2xl border border-slate-800/80 bg-[#11161F]/90 p-5 shadow-xl backdrop-blur-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="font-mono text-xs uppercase tracking-wider text-slate-400">Total Enrolled</p>
                    <h3 class="mt-1 font-display text-2xl font-bold text-white">{{ number_format($stats['total'] ?? 0) }}</h3>
                    <p class="mt-1 text-[11px] text-slate-500">All registered students</p>
                </div>
                <div class="grid size-12 place-items-center rounded-xl border border-emerald-500/20 bg-emerald-500/10 text-emerald-400 shadow-lg shadow-emerald-500/10">
                    <i class="ri-user-add-line text-xl"></i>
                </div>
            </div>
            <div class="absolute -bottom-6 -right-6 size-20 rounded-full bg-emerald-500/5 blur-xl pointer-events-none"></div>
        </div>

        <!-- Card 2: Today's Registrations -->
        <div class="relative overflow-hidden rounded-2xl border border-slate-800/80 bg-[#11161F]/90 p-5 shadow-xl backdrop-blur-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="font-mono text-xs uppercase tracking-wider text-slate-400">Today</p>
                    <h3 class="mt-1 font-display text-2xl font-bold text-emerald-400">{{ number_format($stats['today'] ?? 0) }}</h3>
                    <p class="mt-1 text-[11px] text-slate-500">Received today</p>
                </div>
                <div class="grid size-12 place-items-center rounded-xl border border-cyan-500/20 bg-cyan-500/10 text-cyan-400 shadow-lg shadow-cyan-500/10">
                    <i class="ri-calendar-check-line text-xl"></i>
                </div>
            </div>
            <div class="absolute -bottom-6 -right-6 size-20 rounded-full bg-cyan-500/5 blur-xl pointer-events-none"></div>
        </div>

        <!-- Card 3: This Month -->
        <div class="relative overflow-hidden rounded-2xl border border-slate-800/80 bg-[#11161F]/90 p-5 shadow-xl backdrop-blur-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="font-mono text-xs uppercase tracking-wider text-slate-400">This Month</p>
                    <h3 class="mt-1 font-display text-2xl font-bold text-white">{{ number_format($stats['this_month'] ?? 0) }}</h3>
                    <p class="mt-1 text-[11px] text-slate-500">{{ now()->format('F Y') }}</p>
                </div>
                <div class="grid size-12 place-items-center rounded-xl border border-indigo-500/20 bg-indigo-500/10 text-indigo-400 shadow-lg shadow-indigo-500/10">
                    <i class="ri-line-chart-line text-xl"></i>
                </div>
            </div>
            <div class="absolute -bottom-6 -right-6 size-20 rounded-full bg-indigo-500/5 blur-xl pointer-events-none"></div>
        </div>

        <!-- Card 4: Top Program -->
        <div class="relative overflow-hidden rounded-2xl border border-slate-800/80 bg-[#11161F]/90 p-5 shadow-xl backdrop-blur-xl">
            <div class="flex items-center justify-between">
                <div class="min-w-0 pr-2">
                    <p class="font-mono text-xs uppercase tracking-wider text-slate-400">Top Program</p>
                    <h3 class="mt-1 font-display text-base font-bold text-white truncate" title="{{ $stats['top_course'] ?? 'None' }}">
                        {{ $stats['top_course'] ?? 'None' }}
                    </h3>
                    <p class="mt-1 text-[11px] text-slate-500">Highest applicant demand</p>
                </div>
                <div class="grid size-12 shrink-0 place-items-center rounded-xl border border-amber-500/20 bg-amber-500/10 text-amber-400 shadow-lg shadow-amber-500/10">
                    <i class="ri-award-line text-xl"></i>
                </div>
            </div>
            <div class="absolute -bottom-6 -right-6 size-20 rounded-full bg-amber-500/5 blur-xl pointer-events-none"></div>
        </div>
    </div>

    <!-- Main Table Container -->
    <div class="rounded-2xl border border-slate-800/80 bg-[#11161F]/90 shadow-2xl backdrop-blur-xl">
        <!-- Action & Filter Bar -->
        <div class="flex flex-col gap-4 border-b border-slate-800 p-5 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center gap-3">
                <span class="grid size-10 place-items-center rounded-xl border border-emerald-500/20 bg-emerald-500/10 text-emerald-400">
                    <i class="ri-graduation-cap-line text-lg"></i>
                </span>
                <div>
                    <h1 class="font-display text-lg font-bold text-white">Student Registrations</h1>
                    <p class="text-xs text-slate-400">Review admissions, contact student applicants, and manage course enrollments</p>
                </div>
            </div>

            <!-- Search, Filter & Bulk Actions -->
            <div class="flex flex-wrap items-center gap-2.5 sm:gap-3">
                <!-- Search & Filter Form -->
                <form action="{{ route('admin.register.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
                    <!-- Course Filter Dropdown -->
                    @if($availableCourses->isNotEmpty())
                        <div class="relative">
                            <select name="course"
                                    onchange="this.form.submit()"
                                    class="h-9 rounded-xl border border-slate-700/80 bg-[#0A0D14] pl-3 pr-8 text-xs text-slate-200 outline-none transition focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20 cursor-pointer appearance-none">
                                <option value="">All Programs</option>
                                @foreach($availableCourses as $course)
                                    <option value="{{ $course }}" {{ request('course') === $course ? 'selected' : '' }}>
                                        {{ $course }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2.5 text-slate-400">
                                <i class="ri-arrow-down-s-line text-xs"></i>
                            </span>
                        </div>
                    @endif

                    <!-- Search Input -->
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-500">
                            <i class="ri-search-line text-xs"></i>
                        </span>
                        <input type="search"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Search name, phone, course..."
                               class="h-9 w-44 rounded-xl border border-slate-700/80 bg-[#0A0D14] pl-8 pr-3 text-xs text-white placeholder-slate-500 outline-none transition focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20 sm:w-56">
                    </div>

                    @if(request()->filled('search') || request()->filled('course'))
                        <a href="{{ route('admin.register.index') }}"
                           title="Clear Filters"
                           class="grid size-9 place-items-center rounded-xl border border-slate-700 bg-slate-800 text-slate-400 transition hover:bg-slate-700 hover:text-white">
                            <i class="ri-close-line text-sm"></i>
                        </a>
                    @endif
                </form>

                <!-- Print Certificate Button for Selected Students -->
                <button type="button"
                        id="bulkPrintCertBtn"
                        class="inline-flex h-9 items-center gap-1.5 rounded-xl border border-amber-500/30 bg-amber-500/10 px-3.5 text-xs font-semibold text-amber-300 transition hover:bg-amber-400 hover:text-slate-950 cursor-pointer shadow-lg shadow-amber-500/10"
                        title="Print certificates for selected students">
                    <i class="ri-award-line text-sm"></i>
                    <span>Print Certificate<span id="printCertCount"></span></span>
                </button>

                <!-- Bulk Delete Trigger (Shown dynamically when items are selected) -->
                <div id="bulkActionsBar" class="hidden">
                    <button type="button"
                            id="bulkDeleteBtn"
                            class="inline-flex h-9 items-center gap-1.5 rounded-xl border border-rose-500/30 bg-rose-500/10 px-3 text-xs font-semibold text-rose-300 transition hover:bg-rose-500 hover:text-white cursor-pointer shadow-lg shadow-rose-500/10">
                        <i class="ri-delete-bin-line text-xs"></i>
                        <span>Delete Selected (<span id="selectedCount">0</span>)</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Table Form for Bulk Delete -->
        <form action="{{ route('admin.register.bulk-delete') }}" id="bulkDeleteForm" method="POST">
            @csrf
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-300">
                    <thead class="border-b border-slate-800 bg-slate-900/60 font-mono text-[11px] uppercase tracking-wider text-slate-400">
                        <tr>
                            <th scope="col" class="py-3.5 pl-5 pr-3 w-14">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" id="selectAllCheckbox" class="size-4 rounded border-slate-700 bg-slate-900 text-emerald-500 focus:ring-emerald-400 focus:ring-offset-slate-900 cursor-pointer">
                                    <span>#</span>
                                </label>
                            </th>
                            <th scope="col" class="py-3.5 px-4 font-semibold">Student / Father</th>
                            <th scope="col" class="py-3.5 px-4 font-semibold">Program</th>
                            <th scope="col" class="py-3.5 px-4 font-semibold">Gender & DOB</th>
                            <th scope="col" class="py-3.5 px-4 font-semibold">Contact Info</th>
                            <th scope="col" class="py-3.5 px-4 font-semibold">Applied At</th>
                            <th scope="col" class="py-3.5 pr-5 pl-4 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60 font-sans">
                        @forelse($registrations as $key => $registration)
                            @php
                                $initials = strtoupper(substr($registration->student_name, 0, 2));
                                $age = $registration->dob ? \Carbon\Carbon::parse($registration->dob)->age : null;
                                $cleanPhone = preg_replace('/[^0-9]/', '', $registration->mobile);
                            @endphp
                            <tr class="transition-colors hover:bg-slate-800/40">
                                <!-- Checkbox & Index -->
                                <td class="py-3.5 pl-5 pr-3">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox"
                                               name="delIds[]"
                                               value="{{ $registration->id }}"
                                               class="check-item size-4 rounded border-slate-700 bg-slate-900 text-emerald-500 focus:ring-emerald-400 focus:ring-offset-slate-900 cursor-pointer">
                                        <span class="font-mono text-xs text-slate-500">
                                            {{ $key + ($registrations->firstItem() ?? 1) }}
                                        </span>
                                    </label>
                                </td>

                                <!-- Student Name & Father -->
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="grid size-9 shrink-0 place-items-center rounded-xl border border-slate-700 bg-slate-800/80 font-mono text-xs font-bold text-emerald-400 shadow-sm">
                                            {{ $initials }}
                                        </div>
                                        <div>
                                            <span class="font-semibold text-white hover:text-emerald-300 transition">{{ $registration->student_name }}</span>
                                            <p class="text-xs text-slate-400 flex items-center gap-1 mt-0.5">
                                                <i class="ri-user-line text-[11px] text-slate-500"></i>
                                                <span>Father: {{ $registration->father_name }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <!-- Course -->
                                <td class="py-3.5 px-4">
                                    <span class="inline-flex items-center gap-1.5 rounded-lg border border-emerald-500/20 bg-emerald-500/10 px-2.5 py-1 text-xs font-medium text-emerald-300">
                                        <span class="size-1.5 rounded-full bg-emerald-400"></span>
                                        {{ $registration->course }}
                                    </span>
                                </td>

                                <!-- Gender & DOB -->
                                <td class="py-3.5 px-4">
                                    <div class="flex flex-col gap-0.5 text-xs">
                                        <div class="flex items-center gap-1.5">
                                            @if(strtolower($registration->gender) === 'female')
                                                <span class="inline-flex items-center gap-1 rounded-md border border-pink-500/20 bg-pink-500/10 px-1.5 py-0.5 text-[11px] font-medium text-pink-300">
                                                    <i class="ri-women-line text-[11px]"></i> Female
                                                </span>
                                            @elseif(strtolower($registration->gender) === 'male')
                                                <span class="inline-flex items-center gap-1 rounded-md border border-cyan-500/20 bg-cyan-500/10 px-1.5 py-0.5 text-[11px] font-medium text-cyan-300">
                                                    <i class="ri-men-line text-[11px]"></i> Male
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 rounded-md border border-slate-700 bg-slate-800 px-1.5 py-0.5 text-[11px] font-medium text-slate-300">
                                                    {{ $registration->gender }}
                                                </span>
                                            @endif
                                            @if($age)
                                                <span class="font-mono text-[11px] text-slate-500">({{ $age }} yrs)</span>
                                            @endif
                                        </div>
                                        <span class="font-mono text-[11px] text-slate-400 mt-0.5">
                                            <i class="ri-cake-2-line text-slate-500 text-[10px]"></i>
                                            {{ $registration->dob ? \Carbon\Carbon::parse($registration->dob)->format('d M, Y') : 'N/A' }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Contact Info with Direct Shortcuts -->
                                <td class="py-3.5 px-4 text-xs">
                                    <div class="flex items-center gap-2">
                                        <a href="tel:{{ $registration->mobile }}"
                                           class="font-mono text-slate-200 hover:text-emerald-400 transition"
                                           title="Call student">
                                            {{ $registration->mobile }}
                                        </a>
                                        @if($cleanPhone)
                                            <a href="https://wa.me/{{ $cleanPhone }}"
                                               target="_blank"
                                               rel="noopener noreferrer"
                                               class="grid size-5 place-items-center rounded bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500 hover:text-white transition"
                                               title="Chat on WhatsApp">
                                                <i class="ri-whatsapp-line text-xs"></i>
                                            </a>
                                        @endif
                                    </div>
                                    <a href="mailto:{{ $registration->email }}"
                                       class="text-slate-400 hover:text-emerald-300 hover:underline transition truncate max-w-[170px] block mt-0.5"
                                       title="{{ $registration->email }}">
                                        {{ $registration->email }}
                                    </a>
                                </td>

                                <!-- Registration Date -->
                                <td class="py-3.5 px-4 text-xs">
                                    <span class="text-slate-300 font-medium block">
                                        {{ optional($registration->created_at)->diffForHumans() }}
                                    </span>
                                    <span class="font-mono text-[11px] text-slate-500">
                                        {{ optional($registration->created_at)->format('d M Y, h:i A') }}
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="py-3.5 pr-5 pl-4 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <!-- Open Modal Button -->
                                        <button type="button"
                                                onclick="openRegistrationModal('viewModal_{{ $registration->id }}')"
                                                class="inline-flex items-center gap-1.5 rounded-lg border border-slate-700 bg-slate-800/80 px-2.5 py-1.5 text-xs font-medium text-slate-200 transition hover:border-emerald-500/40 hover:bg-slate-800 hover:text-emerald-300 cursor-pointer"
                                                title="View Full Profile">
                                            <i class="ri-eye-line text-emerald-400 text-xs"></i>
                                            <span>Details</span>
                                        </button>

                                        <!-- Delete Button -->
                                        <button type="button"
                                                onclick="confirmRegistrationDelete('{{ route('admin.register.destroy', $registration) }}', '{{ addslashes($registration->student_name) }}')"
                                                class="grid size-8 place-items-center rounded-lg border border-rose-500/20 bg-rose-500/10 text-rose-400 transition hover:bg-rose-500 hover:text-white cursor-pointer"
                                                title="Delete Registration">
                                            <i class="ri-delete-bin-line text-xs"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-16 text-center text-slate-500 text-xs">
                                    <div class="mx-auto grid size-16 place-items-center rounded-2xl border border-slate-800 bg-slate-900/50 text-slate-600 mb-3">
                                        <i class="ri-user-search-line text-3xl"></i>
                                    </div>
                                    <p class="text-sm font-semibold text-slate-300">No student registrations found</p>
                                    <p class="mt-1 text-slate-500">
                                        @if(request()->filled('search') || request()->filled('course'))
                                            Try adjusting your search criteria or clear the filters.
                                        @else
                                            New applicant submissions from the website will automatically appear here.
                                        @endif
                                    </p>
                                    @if(request()->filled('search') || request()->filled('course'))
                                        <div class="mt-4">
                                            <a href="{{ route('admin.register.index') }}"
                                               class="inline-flex items-center gap-1.5 rounded-xl border border-slate-700 bg-slate-800 px-3.5 py-1.5 text-xs font-medium text-slate-300 transition hover:bg-slate-700 hover:text-white">
                                                <i class="ri-refresh-line text-xs"></i>
                                                <span>Clear Filters</span>
                                            </a>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        <!-- Pagination -->
        @if($registrations->hasPages())
            <div class="border-t border-slate-800 p-4">
                {{ $registrations->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('modals')
    @foreach($registrations as $registration)
        @php
            $initials = strtoupper(substr($registration->student_name, 0, 2));
            $age = $registration->dob ? \Carbon\Carbon::parse($registration->dob)->age : null;
            $cleanPhone = preg_replace('/[^0-9]/', '', $registration->mobile);
        @endphp
        <!-- Registration Detail Modal -->
        <div id="viewModal_{{ $registration->id }}"
             class="modal-backdrop fixed inset-0 z-[100] hidden overflow-y-auto bg-black/85 backdrop-blur-sm p-4 transition-all">
            <div class="flex min-h-screen items-center justify-center">
                <div class="relative w-full max-w-lg rounded-3xl border border-slate-800 bg-[#141B26] p-6 sm:p-7 shadow-2xl transition-all"
                     onclick="event.stopPropagation()">

                    <!-- Modal Header -->
                    <div class="flex items-start justify-between border-b border-slate-800/80 pb-5 mb-5">
                        <div class="flex items-center gap-3.5">
                            <div class="grid size-12 place-items-center rounded-2xl border border-emerald-500/30 bg-emerald-500/10 text-emerald-400 font-display font-bold text-base shadow-lg shadow-emerald-500/10">
                                {{ $initials }}
                            </div>
                            <div>
                                <h3 class="font-display text-lg font-bold text-white">{{ $registration->student_name }}</h3>
                                <p class="text-xs text-slate-400 flex items-center gap-1 mt-0.5">
                                    <span class="inline-flex items-center gap-1 text-emerald-400 font-medium">
                                        <i class="ri-book-open-line text-xs"></i>
                                        {{ $registration->course }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <button type="button"
                                onclick="closeRegistrationModal('viewModal_{{ $registration->id }}')"
                                class="grid size-8 place-items-center rounded-xl border border-slate-700 bg-slate-800 text-slate-400 hover:bg-slate-700 hover:text-white transition cursor-pointer">
                            <i class="ri-close-line text-lg"></i>
                        </button>
                    </div>

                    <!-- Modal Content -->
                    <div class="space-y-4 text-xs">
                        <!-- Application Metadata Pill Banner -->
                        <div class="flex flex-wrap items-center justify-between gap-2 rounded-xl border border-slate-800 bg-[#0A0D14] p-3 text-slate-400">
                            <span class="flex items-center gap-1.5 font-mono text-[11px]">
                                <i class="ri-time-line text-emerald-400"></i>
                                <span>Applied: {{ optional($registration->created_at)->format('d M Y, h:i A') }}</span>
                            </span>
                            <span class="rounded-md border border-slate-700 bg-slate-800 px-2 py-0.5 font-mono text-[10px] text-slate-300">
                                ID #REG-{{ str_pad($registration->id, 4, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>

                        <!-- Personal Information Group -->
                        <div class="rounded-2xl border border-slate-800/80 bg-slate-900/60 p-4 space-y-3">
                            <h4 class="font-mono text-[11px] font-semibold uppercase tracking-wider text-slate-400 flex items-center gap-1.5">
                                <i class="ri-user-smile-line text-emerald-400"></i>
                                Personal Information
                            </h4>

                            <div class="grid grid-cols-2 gap-3 text-xs pt-1">
                                <div>
                                    <span class="text-slate-500 block text-[11px]">Full Name</span>
                                    <span class="font-semibold text-white mt-0.5 block">{{ $registration->student_name }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-500 block text-[11px]">Father's Name</span>
                                    <span class="font-medium text-slate-200 mt-0.5 block">{{ $registration->father_name }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-500 block text-[11px]">Gender</span>
                                    <span class="font-medium text-slate-200 mt-0.5 block">{{ $registration->gender }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-500 block text-[11px]">Date of Birth</span>
                                    <span class="font-mono text-slate-200 mt-0.5 block">
                                        {{ $registration->dob ? \Carbon\Carbon::parse($registration->dob)->format('d M, Y') : 'N/A' }}
                                        @if($age)
                                            <span class="text-emerald-400">({{ $age }} yrs old)</span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information Group -->
                        <div class="rounded-2xl border border-slate-800/80 bg-slate-900/60 p-4 space-y-3">
                            <h4 class="font-mono text-[11px] font-semibold uppercase tracking-wider text-slate-400 flex items-center gap-1.5">
                                <i class="ri-phone-line text-emerald-400"></i>
                                Contact & Communication
                            </h4>

                            <div class="space-y-2 pt-1">
                                <div class="flex items-center justify-between border-b border-slate-800/60 pb-2.5">
                                    <div>
                                        <span class="text-slate-500 text-[11px] block">Mobile Number</span>
                                        <span class="font-mono text-slate-200 font-semibold">{{ $registration->mobile }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <a href="tel:{{ $registration->mobile }}"
                                           class="inline-flex items-center gap-1 rounded-lg border border-slate-700 bg-slate-800 px-2.5 py-1 text-xs text-slate-200 hover:border-emerald-500/40 hover:bg-slate-700 hover:text-emerald-300 transition">
                                            <i class="ri-phone-line text-xs text-emerald-400"></i>
                                            <span>Call</span>
                                        </a>
                                        @if($cleanPhone)
                                            <a href="https://wa.me/{{ $cleanPhone }}"
                                               target="_blank"
                                               rel="noopener noreferrer"
                                               class="inline-flex items-center gap-1 rounded-lg border border-emerald-500/30 bg-emerald-500/10 px-2.5 py-1 text-xs text-emerald-400 hover:bg-emerald-500 hover:text-white transition">
                                                <i class="ri-whatsapp-line text-xs"></i>
                                                <span>WhatsApp</span>
                                            </a>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex items-center justify-between pt-1">
                                    <div class="min-w-0 pr-2">
                                        <span class="text-slate-500 text-[11px] block">Email Address</span>
                                        <span class="font-mono text-slate-200 truncate block">{{ $registration->email }}</span>
                                    </div>
                                    <a href="mailto:{{ $registration->email }}"
                                       class="inline-flex shrink-0 items-center gap-1 rounded-lg border border-slate-700 bg-slate-800 px-2.5 py-1 text-xs text-slate-200 hover:border-emerald-500/40 hover:bg-slate-700 hover:text-emerald-300 transition">
                                        <i class="ri-mail-send-line text-xs text-emerald-400"></i>
                                        <span>Email</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Course Applied -->
                        <div class="rounded-2xl border border-slate-800/80 bg-slate-900/60 p-4">
                            <span class="text-slate-500 text-[11px] block">Selected Specialization</span>
                            <div class="mt-1 flex items-center justify-between">
                                <span class="font-display font-semibold text-white text-sm">{{ $registration->course }}</span>
                                <span class="inline-flex items-center gap-1 rounded-full border border-emerald-500/30 bg-emerald-500/15 px-2.5 py-0.5 text-[11px] font-medium text-emerald-300">
                                    <span class="size-1.5 rounded-full bg-emerald-400"></span>
                                    Verified Program
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="mt-6 flex items-center justify-between border-t border-slate-800/80 pt-4">
                        <button type="button"
                                onclick="closeRegistrationModal('viewModal_{{ $registration->id }}'); confirmRegistrationDelete('{{ route('admin.register.destroy', $registration) }}', '{{ addslashes($registration->student_name) }}')"
                                class="inline-flex items-center gap-1.5 text-xs text-rose-400 hover:text-rose-300 transition cursor-pointer">
                            <i class="ri-delete-bin-line text-xs"></i>
                            <span>Delete Record</span>
                        </button>

                        <button type="button"
                                onclick="closeRegistrationModal('viewModal_{{ $registration->id }}')"
                                class="rounded-xl border border-slate-700 bg-slate-800 px-4 py-2 text-xs font-semibold text-slate-300 transition hover:bg-slate-700 hover:text-white cursor-pointer">
                            Close Profile
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endpush


@push('extra_scripts')
<script>
    function openRegistrationModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }
    }

    function closeRegistrationModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    }

    function confirmRegistrationDelete(actionUrl, studentName) {
        if (confirm(`Are you sure you want to delete the registration for "${studentName}"? This action cannot be undone.`)) {
            const form = document.getElementById('deleteForm');
            form.setAttribute('action', actionUrl);
            form.submit();
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Modal backdrop click-to-close
        document.querySelectorAll('.modal-backdrop').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            });
        });

        // Close on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('.modal-backdrop:not(.hidden)').forEach(modal => {
                    modal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                });
            }
        });

        // Bulk Selection Logic
        const selectAll = document.getElementById('selectAllCheckbox');
        const checkItems = document.querySelectorAll('.check-item');
        const bulkBar = document.getElementById('bulkActionsBar');
        const bulkBtn = document.getElementById('bulkDeleteBtn');
        const bulkForm = document.getElementById('bulkDeleteForm');
        const selectedCount = document.getElementById('selectedCount');

        function updateBulkBar() {
            const checkedCount = document.querySelectorAll('.check-item:checked').length;
            if (selectedCount) {
                selectedCount.textContent = checkedCount;
            }

            const printCertCount = document.getElementById('printCertCount');
            const bulkPrintCertBtn = document.getElementById('bulkPrintCertBtn');
            if (printCertCount) {
                printCertCount.textContent = checkedCount > 0 ? ` (${checkedCount})` : '';
            }
            if (bulkPrintCertBtn) {
                if (checkedCount > 0) {
                    bulkPrintCertBtn.classList.remove('bg-amber-500/10', 'text-amber-300');
                    bulkPrintCertBtn.classList.add('bg-amber-400', 'text-slate-950', 'font-bold');
                } else {
                    bulkPrintCertBtn.classList.remove('bg-amber-400', 'text-slate-950', 'font-bold');
                    bulkPrintCertBtn.classList.add('bg-amber-500/10', 'text-amber-300');
                }
            }

            if (checkedCount > 0) {
                bulkBar.classList.remove('hidden');
            } else {
                bulkBar.classList.add('hidden');
            }

            if (selectAll) {
                selectAll.checked = checkItems.length > 0 && checkedCount === checkItems.length;
            }
        }

        if (selectAll) {
            selectAll.addEventListener('change', function () {
                checkItems.forEach(item => item.checked = selectAll.checked);
                updateBulkBar();
            });
        }

        checkItems.forEach(item => {
            item.addEventListener('change', updateBulkBar);
        });

        if (bulkBtn && bulkForm) {
            bulkBtn.addEventListener('click', function () {
                const count = document.querySelectorAll('.check-item:checked').length;
                if (count === 0) return;
                if (confirm(`Are you sure you want to permanently delete ${count} selected student registration(s)?`)) {
                    bulkForm.submit();
                }
            });
        }

        // Multiple certificates print handler
        const bulkPrintBtn = document.getElementById('bulkPrintCertBtn');
        if (bulkPrintBtn) {
            bulkPrintBtn.addEventListener('click', function () {
                const checkedBoxes = Array.from(document.querySelectorAll('.check-item:checked'));
                if (checkedBoxes.length === 0) {
                    alert('Please select at least one student using the checkboxes on the left to print certificates.');
                    return;
                }
                const ids = checkedBoxes.map(cb => cb.value);
                const url = '{{ route('admin.register.certificate') }}?ids=' + ids.join(',');
                window.open(url, '_blank');
            });
        }
    });
</script>
@endpush