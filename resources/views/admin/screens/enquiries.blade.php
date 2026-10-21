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
                    <i class="ri-inbox-line text-lg"></i>
                </span>
                <div>
                    <h1 class="font-display text-lg font-bold text-white">Enquiries</h1>
                    <p class="text-xs text-slate-400">Visitor messages and contact submissions</p>
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
                           placeholder="Search enquiries..."
                           class="w-48 sm:w-64 rounded-xl border border-slate-700/80 bg-[#0A0D14] py-2 pl-9 pr-3 text-xs text-white placeholder-slate-500 transition duration-200 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20">
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
            </div>
        </div>

        <!-- Table Form for Bulk Delete -->
        <form action="{{ route('admin.enquiry.bulk-delete') }}" id="bulkDeleteForm" method="POST">
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
                            <th scope="col" class="py-3.5 px-4 font-semibold">Name</th>
                            <th scope="col" class="py-3.5 px-4 font-semibold">Details</th>
                            <th scope="col" class="py-3.5 pr-5 pl-4 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60 font-sans">
                        @forelse($enquiries as $key => $enquiry)
                            <tr class="transition-colors hover:bg-slate-800/40">
                                <td class="py-3.5 pl-5 pr-3">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox"
                                               name="delIds[]"
                                               value="{{ $enquiry->id }}"
                                               class="check-item size-4 rounded border-slate-700 bg-slate-900 text-emerald-500 focus:ring-emerald-400 focus:ring-offset-slate-900 cursor-pointer">
                                        <span class="font-mono text-xs text-slate-400">
                                            {{ $key + (method_exists($enquiries, 'firstItem') ? $enquiries->firstItem() : 1) }}
                                        </span>
                                    </label>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="font-semibold text-white">{{ $enquiry->name }}</span>
                                    <p class="text-xs text-slate-400">{{ $enquiry->email }}</p>
                                </td>
                                <td class="py-3.5 px-4">
                                    <button type="button"
                                            onclick="openModal('viewModal_{{ $enquiry->id }}')"
                                            class="inline-flex items-center gap-1.5 rounded-lg border border-slate-700 bg-slate-800/80 px-2.5 py-1.5 text-xs font-medium text-slate-200 transition hover:border-emerald-500/40 hover:bg-slate-800 hover:text-emerald-300">
                                        <i class="ri-eye-line text-emerald-400 text-xs"></i>
                                        <span>View Message</span>
                                    </button>
                                </td>
                                <td class="py-3.5 pr-5 pl-4 text-right">
                                    <button type="button"
                                            onclick="confirmDelete('{{ route('admin.enquiry.destroy', $enquiry) }}')"
                                            class="inline-flex items-center gap-1.5 rounded-lg border border-rose-500/20 bg-rose-500/10 px-2.5 py-1.5 text-xs font-medium text-rose-400 transition hover:bg-rose-500 hover:text-white"
                                            title="Delete Enquiry">
                                        <i class="ri-delete-bin-line text-xs"></i>
                                        <span>Remove</span>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center text-slate-500 text-xs">
                                    <i class="ri-inbox-line text-3xl mb-2 text-slate-600 block"></i>
                                    No enquiries found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        <!-- Pagination -->
        @if(method_exists($enquiries, 'hasPages') && $enquiries->hasPages())
            <div class="border-t border-slate-800 p-4">
                {{ $enquiries->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('modals')
    @foreach($enquiries as $enquiry)
        <!-- Tailwind Native Modal (Rendered at root for full viewport coverage) -->
        <div id="viewModal_{{ $enquiry->id }}"
             class="modal-backdrop fixed inset-0 z-[100] hidden overflow-y-auto bg-black/80 backdrop-blur-sm p-4 transition-opacity">
            <div class="flex min-h-screen items-center justify-center">
                <div class="relative w-full max-w-lg rounded-2xl border border-slate-700/80 bg-[#171E2B] p-6 shadow-2xl transition-all"
                     onclick="event.stopPropagation()">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between border-b border-slate-700 pb-4 mb-4">
                        <div class="flex items-center gap-2.5">
                            <span class="grid size-8 place-items-center rounded-lg bg-emerald-500/10 text-emerald-400 text-xs">
                                <i class="ri-mail-open-line text-base"></i>
                            </span>
                            <h3 class="font-display text-base font-bold text-white">Enquiry Details</h3>
                        </div>
                        <button type="button"
                                onclick="closeModal('viewModal_{{ $enquiry->id }}')"
                                class="grid size-7 place-items-center rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition">
                            <i class="ri-close-line text-lg"></i>
                        </button>
                    </div>

                    <!-- Modal Content -->
                    <div class="space-y-4 text-xs">
                        <div class="rounded-xl border border-slate-800 bg-slate-900/60 p-3.5 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400">Sender Name:</span>
                                <span class="font-semibold text-white">{{ $enquiry->name }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400">Email Address:</span>
                                <a href="mailto:{{ $enquiry->email }}" target="_blank" class="text-emerald-400 hover:underline">{{ $enquiry->email }}</a>
                            </div>
                            @if(!empty($enquiry->phone))
                                <div class="flex items-center justify-between">
                                    <span class="text-slate-400">Phone Number:</span>
                                    <a href="tel:{{ $enquiry->phone }}" target="_blank" class="text-emerald-400 hover:underline">{{ $enquiry->phone }}</a>
                                </div>
                            @endif
                        </div>

                        <div>
                            <span class="block mb-1.5 font-semibold text-slate-300 uppercase tracking-wider text-[11px]">Message Content:</span>
                            <div class="rounded-xl border border-slate-800 bg-[#0A0D14] p-4 text-slate-200 leading-relaxed max-h-60 overflow-y-auto whitespace-pre-line text-xs">
                                {!! strip_tags($enquiry->messages) !!}
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="mt-6 flex justify-end gap-2 border-t border-slate-700/80 pt-4">
                        <button type="button"
                                onclick="closeModal('viewModal_{{ $enquiry->id }}')"
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
        if (confirm("Are you sure you want to permanently delete this item?")) {
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
                if (confirm(`Are you sure you want to delete ${count} selected item(s)?`)) {
                    bulkForm.submit();
                }
            });
        }
    });
</script>
@endpush