@extends('admin.layouts.app')

@section('main_section')
<!-- Single Item Delete Form -->
<form action="" method="post" id="deleteForm" class="hidden">
    @method('DELETE')
    @csrf
</form>

<div class="space-y-6">
    <x-alert />

    <div class="rounded-2xl border border-slate-800/80 bg-[#11161F]/90 shadow-2xl backdrop-blur-xl">
        <!-- Table Header & Action Bar -->
        <div class="flex flex-col gap-4 border-b border-slate-800 p-5 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
                <span class="grid size-10 place-items-center rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                    <i class="ri-question-answer-line text-lg"></i>
                </span>
                <div>
                    <h1 class="font-display text-lg font-bold text-white">Frequently Asked Questions</h1>
                    <p class="text-xs text-slate-400">Questions and answers displayed on the public website</p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <!-- Search Form -->
                <form action="" method="GET" class="relative">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-500">
                        <i class="ri-search-line text-sm"></i>
                    </span>
                    <input type="search"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Search FAQs..."
                           class="w-48 sm:w-60 rounded-xl border border-slate-700/80 bg-[#0A0D14] py-2 pl-9 pr-3 text-xs text-white placeholder-slate-500 transition duration-200 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20">
                </form>

                <!-- Bulk Delete Trigger (Shown when items selected) -->
                <div id="bulkActionsBar" class="hidden">
                    <button type="button"
                            id="bulkDeleteBtn"
                            class="inline-flex items-center gap-1.5 rounded-xl border border-rose-500/30 bg-rose-500/10 px-3.5 py-2 text-xs font-semibold text-rose-300 transition hover:bg-rose-500 hover:text-white">
                        <i class="ri-delete-bin-line text-sm"></i>
                        <span>Delete Selected</span>
                    </button>
                </div>

                <!-- Add New FAQ Button -->
                <a href="{{ route('admin.faq.create') }}"
                   class="inline-flex items-center gap-1.5 rounded-xl bg-emerald-400 px-4 py-2 text-xs font-bold text-slate-950 shadow-lg shadow-emerald-500/20 transition duration-200 hover:-translate-y-0.5 hover:bg-emerald-300 hover:shadow-emerald-500/30 active:translate-y-0">
                    <i class="ri-add-line text-sm"></i>
                    <span>Add FAQ</span>
                </a>
            </div>
        </div>

        <!-- Table Form for Bulk Delete -->
        <form action="{{ route('admin.faq.bulk-delete') }}" id="bulkDeleteForm" method="POST">
            @csrf
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-300">
                    <thead class="border-b border-slate-800 bg-slate-900/60 font-mono text-[11px] uppercase tracking-wider text-slate-400">
                        <tr>
                            <th scope="col" class="py-3.5 pl-5 pr-3 w-16">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" id="selectAllCheckbox" class="size-4 rounded border-slate-700 bg-slate-900 text-emerald-500 focus:ring-emerald-400 focus:ring-offset-slate-900 cursor-pointer">
                                    <span>#</span>
                                </label>
                            </th>
                            <th scope="col" class="py-3.5 px-4 font-semibold">Question</th>
                            <th scope="col" class="py-3.5 px-4 font-semibold">Answer Preview</th>
                            <th scope="col" class="py-3.5 pr-5 pl-4 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60 font-sans">
                        @forelse($faqs as $key => $faq)
                            <tr class="transition-colors hover:bg-slate-800/40">
                                <td class="py-3.5 pl-5 pr-3">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox"
                                               name="delIds[]"
                                               value="{{ $faq->id }}"
                                               class="check-item size-4 rounded border-slate-700 bg-slate-900 text-emerald-500 focus:ring-emerald-400 focus:ring-offset-slate-900 cursor-pointer">
                                        <span class="font-mono text-xs text-slate-400">
                                            {{ $key + (method_exists($faqs, 'firstItem') ? $faqs->firstItem() : 1) }}
                                        </span>
                                    </label>
                                </td>
                                <td class="py-3.5 px-4 max-w-xs sm:max-w-md">
                                    <span class="font-semibold text-white leading-snug block">{{ $faq->question }}</span>
                                </td>
                                <td class="py-3.5 px-4 text-xs text-slate-400 max-w-xs truncate">
                                    {{ Str::limit(strip_tags($faq->answer), 80) }}
                                </td>
                                <td class="py-3.5 pr-5 pl-4 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5">
                                        <!-- View Modal Trigger -->
                                        <button type="button"
                                                onclick="openModal('viewModal_{{ $faq->id }}')"
                                                class="inline-flex items-center gap-1 rounded-lg border border-slate-700 bg-slate-800/80 px-2.5 py-1.5 text-xs font-medium text-slate-200 transition hover:border-emerald-500/40 hover:bg-slate-800 hover:text-emerald-300"
                                                title="Preview Answer">
                                            <i class="ri-eye-line text-emerald-400 text-xs"></i>
                                            <span class="hidden sm:inline">Preview</span>
                                        </button>

                                        <!-- Edit Button -->
                                        <a href="{{ route('admin.faq.edit', $faq) }}"
                                           class="inline-flex items-center gap-1 rounded-lg border border-slate-700 bg-slate-800/80 px-2.5 py-1.5 text-xs font-medium text-slate-200 transition hover:border-cyan-500/40 hover:bg-slate-800 hover:text-cyan-300"
                                           title="Edit FAQ">
                                            <i class="ri-edit-line text-cyan-400 text-xs"></i>
                                            <span class="hidden sm:inline">Edit</span>
                                        </a>

                                        <!-- Delete Button -->
                                        <button type="button"
                                                onclick="confirmDelete('{{ route('admin.faq.destroy', $faq) }}')"
                                                class="inline-flex items-center gap-1 rounded-lg border border-rose-500/20 bg-rose-500/10 px-2.5 py-1.5 text-xs font-medium text-rose-400 transition hover:bg-rose-500 hover:text-white"
                                                title="Delete FAQ">
                                            <i class="ri-delete-bin-line text-xs"></i>
                                            <span class="hidden sm:inline">Remove</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center text-slate-500 text-xs">
                                    <i class="ri-questionnaire-line text-3xl mb-2 text-slate-600 block"></i>
                                    <p class="font-medium text-slate-400 mb-3">No FAQs have been added yet.</p>
                                    <a href="{{ route('admin.faq.create') }}"
                                       class="inline-flex items-center gap-1.5 rounded-xl bg-emerald-400 px-4 py-2 text-xs font-bold text-slate-950 transition hover:bg-emerald-300">
                                        <i class="ri-add-line text-sm"></i>
                                        <span>Create First FAQ</span>
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        <!-- Pagination -->
        @if(method_exists($faqs, 'hasPages') && $faqs->hasPages())
            <div class="border-t border-slate-800 p-4">
                {{ $faqs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('modals')
    @foreach($faqs as $faq)
        <!-- Tailwind Preview Modal (Rendered at root for full viewport coverage) -->
        <div id="viewModal_{{ $faq->id }}"
             class="modal-backdrop fixed inset-0 z-[100] hidden overflow-y-auto bg-black/80 backdrop-blur-sm p-4 text-left transition-opacity">
            <div class="flex min-h-screen items-center justify-center">
                <div class="relative w-full max-w-lg rounded-2xl border border-slate-700/80 bg-[#171E2B] p-6 shadow-2xl transition-all"
                     onclick="event.stopPropagation()">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between border-b border-slate-700 pb-4 mb-4">
                        <div class="flex items-center gap-2.5">
                            <span class="grid size-8 place-items-center rounded-lg bg-emerald-500/10 text-emerald-400 text-xs">
                                <i class="ri-questionnaire-line text-base"></i>
                            </span>
                            <h3 class="font-display text-base font-bold text-white">FAQ Preview</h3>
                        </div>
                        <button type="button"
                                onclick="closeModal('viewModal_{{ $faq->id }}')"
                                class="grid size-7 place-items-center rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition">
                            <i class="ri-close-line text-lg"></i>
                        </button>
                    </div>

                    <!-- Modal Content -->
                    <div class="space-y-4 text-xs">
                        <div class="rounded-xl border border-slate-800 bg-slate-900/60 p-4">
                            <span class="font-mono text-[10px] uppercase tracking-wider text-emerald-400 block mb-1">Question</span>
                            <h4 class="font-display text-base font-semibold text-white leading-snug">{{ $faq->question }}</h4>
                        </div>

                        <div class="rounded-xl border border-slate-800 bg-[#0A0D14] p-4 text-slate-200 leading-relaxed max-h-60 overflow-y-auto whitespace-pre-line text-xs">
                            <span class="font-mono text-[10px] uppercase tracking-wider text-slate-500 block mb-2">Answer</span>
                            {!! $faq->answer !!}
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="mt-6 flex justify-between items-center border-t border-slate-700/80 pt-4">
                        <a href="{{ route('admin.faq.edit', $faq) }}"
                           class="inline-flex items-center gap-1.5 text-xs font-medium text-emerald-400 hover:text-emerald-300 transition">
                            <i class="ri-edit-line"></i>
                            <span>Edit this FAQ</span>
                        </a>
                        <button type="button"
                                onclick="closeModal('viewModal_{{ $faq->id }}')"
                                class="rounded-xl border border-slate-700 bg-slate-800 px-4 py-2 text-xs font-semibold text-slate-300 transition hover:bg-slate-700 hover:text-white">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endpush

@push('extra_scripts')
<script>
    function confirmDelete(actionUrl) {
        if (confirm("Are you sure you want to permanently delete this FAQ?")) {
            const form = document.getElementById('deleteForm');
            form.setAttribute('action', actionUrl);
            form.submit();
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.modal-backdrop').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            });
        });

        const selectAll = document.getElementById('selectAllCheckbox');
        const checkItems = document.querySelectorAll('.check-item');
        const bulkBar = document.getElementById('bulkActionsBar');
        const bulkBtn = document.getElementById('bulkDeleteBtn');
        const bulkForm = document.getElementById('bulkDeleteForm');

        function updateBulkBar() {
            const checkedCount = document.querySelectorAll('.check-item:checked').length;
            if (checkedCount > 0) {
                bulkBar.classList.remove('hidden');
            } else {
                bulkBar.classList.add('hidden');
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
                if (confirm(`Are you sure you want to delete ${count} selected FAQ(s)?`)) {
                    bulkForm.submit();
                }
            });
        }
    });
</script>
@endpush