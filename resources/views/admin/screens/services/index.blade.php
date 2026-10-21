@extends('admin.layouts.app')

@section('main_section')
<!-- Single Item Delete Form -->
<form action="" method="POST" id="deleteForm" class="hidden">
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
                    <i class="ri-service-line text-lg"></i>
                </span>
                <div>
                    <h1 class="font-display text-lg font-bold text-white">Services & Capabilities</h1>
                    <p class="text-xs text-slate-400">Manage client-facing service offerings, descriptions, and visual icons</p>
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
                           placeholder="Search services..."
                           class="w-48 sm:w-60 rounded-xl border border-slate-700/80 bg-[#0A0D14] py-2 pl-9 pr-3 text-xs text-white placeholder-slate-500 transition duration-200 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20">
                </form>

                <!-- Bulk Delete Trigger (Shown when items selected) -->
                <div id="bulkActionsBar" class="hidden">
                    <button type="button"
                            onclick="openModal('bulkDeleteModal')"
                            class="inline-flex items-center gap-1.5 rounded-xl border border-rose-500/30 bg-rose-500/10 px-3.5 py-2 text-xs font-semibold text-rose-300 transition hover:bg-rose-500 hover:text-white cursor-pointer">
                        <i class="ri-delete-bin-line text-sm"></i>
                        <span>Delete Selected (<span id="selectedCount">0</span>)</span>
                    </button>
                </div>

                <!-- Add New Service Button -->
                <a href="{{ route('admin.service.create') }}"
                   class="inline-flex items-center gap-1.5 rounded-xl bg-emerald-400 px-4 py-2 text-xs font-bold text-slate-950 shadow-lg shadow-emerald-500/20 transition duration-200 hover:-translate-y-0.5 hover:bg-emerald-300 hover:shadow-emerald-500/30 active:translate-y-0">
                    <i class="ri-add-line text-sm"></i>
                    <span>Add Service</span>
                </a>
            </div>
        </div>

        <!-- Table Form for Bulk Delete -->
        <form action="{{ route('admin.service.bulk-delete') }}" id="bulkDeleteForm" method="POST">
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
                            <th scope="col" class="py-3.5 px-3 w-16 text-center font-semibold">Icon</th>
                            <th scope="col" class="py-3.5 px-4 font-semibold">Service Title</th>
                            <th scope="col" class="py-3.5 px-4 font-semibold">Short Description</th>
                            <th scope="col" class="py-3.5 px-4 font-semibold hidden md:table-cell">Created</th>
                            <th scope="col" class="py-3.5 pr-5 pl-4 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60 font-sans">
                        @forelse($services as $key => $service)
                            <tr class="transition-colors hover:bg-slate-800/40">
                                <td class="py-3.5 pl-5 pr-3">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox"
                                               name="delIds[]"
                                               value="{{ $service->id }}"
                                               class="check-item size-4 rounded border-slate-700 bg-slate-900 text-emerald-500 focus:ring-emerald-400 focus:ring-offset-slate-900 cursor-pointer">
                                        <span class="font-mono text-xs text-slate-400">
                                            {{ $key + (method_exists($services, 'firstItem') ? $services->firstItem() : 1) }}
                                        </span>
                                    </label>
                                </td>
                                <td class="py-3.5 px-3 text-center">
                                    <div class="mx-auto grid size-10 place-items-center rounded-xl border border-emerald-500/30 bg-emerald-500/10 text-emerald-400 overflow-hidden">
                                        @if (!empty($service->icon))
                                            @if (str_starts_with($service->icon, 'data:image') || str_starts_with($service->icon, 'http'))
                                                <img src="{{ $service->icon }}" alt="{{ $service->title }}" class="size-7 object-contain">
                                            @elseif (str_contains($service->icon, '<svg') || str_contains($service->icon, '<path') || str_contains($service->icon, '<polyline'))
                                                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">{!! $service->icon !!}</svg>
                                            @else
                                                <i class="{{ $service->icon }} text-lg"></i>
                                            @endif
                                        @else
                                            <i class="ri-service-line text-lg"></i>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 font-semibold text-white">
                                    <span class="block text-sm leading-snug">{{ $service->title }}</span>
                                </td>
                                <td class="py-3.5 px-4 text-xs text-slate-400 max-w-xs sm:max-w-md truncate">
                                    {{ Str::limit($service->short_description, 90) }}
                                </td>
                                <td class="py-3.5 px-4 text-xs text-slate-400 font-mono hidden md:table-cell whitespace-nowrap">
                                    {{ $service->created_at ? $service->created_at->format('M d, Y') : '—' }}
                                </td>
                                <td class="py-3.5 pr-5 pl-4 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5">
                                        <!-- View Modal Trigger -->
                                        <button type="button"
                                                onclick="openModal('viewModal_{{ $service->id }}')"
                                                class="grid size-8 place-items-center rounded-lg border border-slate-700/80 bg-slate-800/60 text-slate-300 transition duration-150 hover:border-emerald-400 hover:bg-emerald-500/10 hover:text-emerald-400 cursor-pointer"
                                                title="View Details">
                                            <i class="ri-eye-line text-sm"></i>
                                        </button>

                                        <!-- Edit Link -->
                                        <a href="{{ route('admin.service.edit', $service) }}"
                                           class="grid size-8 place-items-center rounded-lg border border-slate-700/80 bg-slate-800/60 text-slate-300 transition duration-150 hover:border-blue-400 hover:bg-blue-500/10 hover:text-blue-400"
                                           title="Edit Service">
                                            <i class="ri-edit-line text-sm"></i>
                                        </a>

                                        <!-- Delete Modal Trigger -->
                                        <button type="button"
                                                onclick="openModal('deleteModal_{{ $service->id }}')"
                                                class="grid size-8 place-items-center rounded-lg border border-slate-700/80 bg-slate-800/60 text-slate-300 transition duration-150 hover:border-rose-500 hover:bg-rose-500/10 hover:text-rose-400 cursor-pointer"
                                                title="Delete Service">
                                            <i class="ri-delete-bin-line text-sm"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-12 text-center">
                                    <div class="mx-auto mb-3 grid size-12 place-items-center rounded-2xl border border-slate-800 bg-slate-900/60 text-slate-500">
                                        <i class="ri-service-line text-2xl"></i>
                                    </div>
                                    <p class="font-semibold text-white">No services found</p>
                                    <p class="mt-1 text-xs text-slate-400">
                                        @if(request('search'))
                                            No services matched your search query "{{ request('search') }}".
                                        @else
                                            Get started by adding your first service offering.
                                        @endif
                                    </p>
                                    @if(request('search'))
                                        <a href="{{ route('admin.service.index') }}" class="mt-3 inline-flex items-center gap-1 text-xs text-emerald-400 hover:underline">
                                            <span>Clear search filter</span>
                                        </a>
                                    @else
                                        <a href="{{ route('admin.service.create') }}" class="mt-4 inline-flex items-center gap-1.5 rounded-xl bg-emerald-400 px-4 py-2 text-xs font-bold text-slate-950 hover:bg-emerald-300 transition">
                                            <i class="ri-add-line"></i>
                                            <span>Add First Service</span>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        <!-- Pagination Footer -->
        @if($services->hasPages())
            <div class="border-t border-slate-800 p-4">
                {{ $services->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

<!-- ============================================== -->
<!-- MODALS SECTION (View & Delete Confirmations)  -->
<!-- ============================================== -->
@foreach($services as $service)
    <!-- View Service Detail Modal -->
    <div id="viewModal_{{ $service->id }}" class="modal-backdrop fixed inset-0 z-50 hidden bg-black/75 backdrop-blur-md overflow-y-auto p-4 sm:p-6 grid place-items-center">
        <div class="relative w-full max-w-2xl rounded-2xl border border-slate-800 bg-[#11161F] p-6 shadow-2xl text-left my-8" onclick="event.stopPropagation()">
            <!-- Modal Header -->
            <div class="flex items-start justify-between border-b border-slate-800 pb-4 mb-5">
                <div class="flex items-center gap-3">
                    <div class="grid size-12 place-items-center rounded-xl border border-emerald-500/30 bg-emerald-500/10 text-emerald-400">
                        @if (!empty($service->icon))
                            @if (str_starts_with($service->icon, 'data:image') || str_starts_with($service->icon, 'http'))
                                <img src="{{ $service->icon }}" alt="{{ $service->title }}" class="size-8 object-contain">
                            @elseif (str_contains($service->icon, '<svg') || str_contains($service->icon, '<path') || str_contains($service->icon, '<polyline'))
                                <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">{!! $service->icon !!}</svg>
                            @else
                                <i class="{{ $service->icon }} text-2xl"></i>
                            @endif
                        @else
                            <i class="ri-service-line text-2xl"></i>
                        @endif
                    </div>
                    <div>
                        <h3 class="font-display text-lg font-bold text-white">{{ $service->title }}</h3>
                        <p class="font-mono text-xs text-slate-400">ID: #{{ $service->id }} • Created: {{ $service->created_at ? $service->created_at->format('M d, Y') : '—' }}</p>
                    </div>
                </div>
                <button type="button"
                        onclick="closeModal('viewModal_{{ $service->id }}')"
                        class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-800 hover:text-white transition cursor-pointer">
                    <i class="ri-close-line text-xl"></i>
                </button>
            </div>

            <!-- Modal Content -->
            <div class="space-y-4 max-h-[60vh] overflow-y-auto pr-1">
                <!-- Short Description Box -->
                <div class="rounded-xl border border-slate-800 bg-[#0A0D14] p-4">
                    <span class="block font-mono text-[11px] uppercase tracking-wider text-emerald-400 mb-1">Short Summary (Cards)</span>
                    <p class="text-sm leading-relaxed text-slate-200">{{ $service->short_description }}</p>
                </div>

                <!-- Detailed Rich Description Box -->
                <div class="rounded-xl border border-slate-800 bg-[#0A0D14] p-4">
                    <span class="block font-mono text-[11px] uppercase tracking-wider text-slate-400 mb-2">Scope & Detailed Breakdown</span>
                    <div class="prose prose-invert prose-sm max-w-none text-slate-300 leading-relaxed space-y-2">
                        {!! $service->description !!}
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="mt-6 flex items-center justify-end gap-3 border-t border-slate-800 pt-4">
                <button type="button"
                        onclick="closeModal('viewModal_{{ $service->id }}')"
                        class="rounded-xl border border-slate-700 bg-slate-800/80 px-4 py-2 text-xs font-semibold text-slate-300 transition hover:bg-slate-700 hover:text-white cursor-pointer">
                    Close
                </button>
                <a href="{{ route('admin.service.edit', $service) }}"
                   class="inline-flex items-center gap-1.5 rounded-xl bg-emerald-400 px-4 py-2 text-xs font-bold text-slate-950 transition hover:bg-emerald-300">
                    <i class="ri-edit-line"></i>
                    <span>Edit Service</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal_{{ $service->id }}" class="modal-backdrop fixed inset-0 z-50 hidden bg-black/75 backdrop-blur-md overflow-y-auto p-4 grid place-items-center">
        <div class="relative w-full max-w-md rounded-2xl border border-slate-800 bg-[#11161F] p-6 shadow-2xl text-center" onclick="event.stopPropagation()">
            <div class="mx-auto mb-4 grid size-12 place-items-center rounded-2xl border border-rose-500/30 bg-rose-500/10 text-rose-400">
                <i class="ri-error-warning-line text-2xl"></i>
            </div>
            <h3 class="font-display text-lg font-bold text-white">Delete Service</h3>
            <p class="mt-2 text-xs text-slate-400 leading-relaxed">
                Are you sure you want to delete <span class="font-semibold text-white">"{{ $service->title }}"</span>? This action cannot be undone.
            </p>
            <div class="mt-6 flex items-center justify-center gap-3">
                <button type="button"
                        onclick="closeModal('deleteModal_{{ $service->id }}')"
                        class="rounded-xl border border-slate-700 bg-slate-800/80 px-4 py-2 text-xs font-semibold text-slate-300 transition hover:bg-slate-700 hover:text-white cursor-pointer">
                    Cancel
                </button>
                <button type="button"
                        onclick="submitSingleDelete('{{ route('admin.service.destroy', $service) }}')"
                        class="inline-flex items-center gap-1.5 rounded-xl bg-rose-500 px-4 py-2 text-xs font-bold text-white transition hover:bg-rose-600 cursor-pointer">
                    <i class="ri-delete-bin-line"></i>
                    <span>Yes, Delete</span>
                </button>
            </div>
        </div>
    </div>
@endforeach

<!-- Bulk Delete Confirmation Modal -->
<div id="bulkDeleteModal" class="modal-backdrop fixed inset-0 z-50 hidden bg-black/75 backdrop-blur-md overflow-y-auto p-4 grid place-items-center">
    <div class="relative w-full max-w-md rounded-2xl border border-slate-800 bg-[#11161F] p-6 shadow-2xl text-center" onclick="event.stopPropagation()">
        <div class="mx-auto mb-4 grid size-12 place-items-center rounded-2xl border border-rose-500/30 bg-rose-500/10 text-rose-400">
            <i class="ri-delete-bin-line text-2xl"></i>
        </div>
        <h3 class="font-display text-lg font-bold text-white">Delete Selected Services</h3>
        <p class="mt-2 text-xs text-slate-400 leading-relaxed">
            Are you sure you want to permanently delete all selected services? This action cannot be undone.
        </p>
        <div class="mt-6 flex items-center justify-center gap-3">
            <button type="button"
                    onclick="closeModal('bulkDeleteModal')"
                    class="rounded-xl border border-slate-700 bg-slate-800/80 px-4 py-2 text-xs font-semibold text-slate-300 transition hover:bg-slate-700 hover:text-white cursor-pointer">
                Cancel
            </button>
            <button type="button"
                    onclick="document.getElementById('bulkDeleteForm').submit()"
                    class="inline-flex items-center gap-1.5 rounded-xl bg-rose-500 px-4 py-2 text-xs font-bold text-white transition hover:bg-rose-600 cursor-pointer">
                <i class="ri-delete-bin-line"></i>
                <span>Confirm Bulk Delete</span>
            </button>
        </div>
    </div>
</div>
@endsection

@push('extra_scripts')
<script>
    function submitSingleDelete(actionUrl) {
        const form = document.getElementById('deleteForm');
        form.action = actionUrl;
        form.submit();
    }

    document.addEventListener('DOMContentLoaded', function () {
        const selectAll = document.getElementById('selectAllCheckbox');
        const itemCheckboxes = document.querySelectorAll('.check-item');
        const bulkBar = document.getElementById('bulkActionsBar');
        const countSpan = document.getElementById('selectedCount');

        function updateBulkBar() {
            const checkedCount = document.querySelectorAll('.check-item:checked').length;
            if (countSpan) countSpan.textContent = checkedCount;

            if (checkedCount > 0) {
                bulkBar.classList.remove('hidden');
            } else {
                bulkBar.classList.add('hidden');
            }

            if (selectAll) {
                selectAll.checked = itemCheckboxes.length > 0 && checkedCount === itemCheckboxes.length;
            }
        }

        if (selectAll) {
            selectAll.addEventListener('change', function () {
                itemCheckboxes.forEach(cb => cb.checked = selectAll.checked);
                updateBulkBar();
            });
        }

        itemCheckboxes.forEach(cb => {
            cb.addEventListener('change', updateBulkBar);
        });
    });
</script>
@endpush