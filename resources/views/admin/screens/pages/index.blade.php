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
                    <i class="ri-pages-line text-lg"></i>
                </span>
                <div>
                    <h1 class="font-display text-lg font-bold text-white">Dynamic Pages & Content</h1>
                    <p class="text-xs text-slate-400">Manage client-facing custom pages, policies, and rich content</p>
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
                           placeholder="Search pages..."
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

                <!-- Add New Page Button -->
                <a href="{{ route('admin.page.create') }}"
                   class="inline-flex items-center gap-1.5 rounded-xl bg-emerald-400 px-4 py-2 text-xs font-bold text-slate-950 shadow-lg shadow-emerald-500/20 transition duration-200 hover:-translate-y-0.5 hover:bg-emerald-300 hover:shadow-emerald-500/30 active:translate-y-0">
                    <i class="ri-add-line text-sm"></i>
                    <span>Add New Page</span>
                </a>
            </div>
        </div>

        <!-- Table Form for Bulk Delete -->
        <form action="{{ route('admin.page.bulk-delete') }}" id="bulkDeleteForm" method="POST">
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
                            <th scope="col" class="py-3.5 px-3 w-20 text-center font-semibold">Image</th>
                            <th scope="col" class="py-3.5 px-4 font-semibold">Title & Slug</th>
                            <th scope="col" class="py-3.5 px-4 font-semibold">Content Preview</th>
                            <th scope="col" class="py-3.5 px-4 font-semibold hidden md:table-cell">Created</th>
                            <th scope="col" class="py-3.5 pr-5 pl-4 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60 font-sans">
                        @forelse($pages as $key => $page)
                            <tr class="transition-colors hover:bg-slate-800/40">
                                <td class="py-3.5 pl-5 pr-3">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox"
                                               name="delIds[]"
                                               value="{{ $page->id }}"
                                               class="check-item size-4 rounded border-slate-700 bg-slate-900 text-emerald-500 focus:ring-emerald-400 focus:ring-offset-slate-900 cursor-pointer">
                                        <span class="font-mono text-xs text-slate-400">
                                            {{ $key + (method_exists($pages, 'firstItem') ? $pages->firstItem() : 1) }}
                                        </span>
                                    </label>
                                </td>
                                <td class="py-3.5 px-3 text-center">
                                    @if (!empty($page->image))
                                        <div class="mx-auto size-12 overflow-hidden rounded-xl border border-slate-700/80 bg-slate-800">
                                            <img src="{{ $page->image }}" alt="{{ $page->title }}" class="size-full object-cover">
                                        </div>
                                    @else
                                        <div class="mx-auto grid size-12 place-items-center rounded-xl border border-slate-800 bg-slate-900/70 text-slate-500">
                                            <i class="ri-image-line text-lg"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 font-semibold text-white">
                                    <div class="space-y-1">
                                        <span class="block text-sm leading-snug">{{ $page->title }}</span>
                                        <div class="flex items-center gap-1.5 font-mono text-[11px] text-slate-400 font-normal">
                                            <span class="text-emerald-400">/{{ $page->slug }}</span>
                                            <a href="{{ route('page', $page->slug) }}"
                                               target="_blank"
                                               class="text-slate-500 transition hover:text-emerald-300"
                                               title="View live page">
                                                <i class="ri-external-link-line"></i>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 text-xs text-slate-400 max-w-xs sm:max-w-md truncate">
                                    {{ Str::limit(strip_tags($page->description), 95) }}
                                </td>
                                <td class="py-3.5 px-4 text-xs text-slate-400 font-mono hidden md:table-cell whitespace-nowrap">
                                    {{ $page->created_at ? $page->created_at->format('M d, Y') : '—' }}
                                </td>
                                <td class="py-3.5 pr-5 pl-4 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5">
                                        <!-- Live Preview Link -->
                                        <a href="{{ route('page', $page->slug) }}"
                                           target="_blank"
                                           class="grid size-8 place-items-center rounded-lg border border-slate-700/80 bg-slate-800/60 text-slate-300 transition duration-150 hover:border-emerald-400 hover:bg-emerald-500/10 hover:text-emerald-400"
                                           title="View Live Page">
                                            <i class="ri-external-link-line text-sm"></i>
                                        </a>

                                        <!-- View Modal Trigger -->
                                        <button type="button"
                                                onclick="openModal('viewModal_{{ $page->id }}')"
                                                class="grid size-8 place-items-center rounded-lg border border-slate-700/80 bg-slate-800/60 text-slate-300 transition duration-150 hover:border-blue-400 hover:bg-blue-500/10 hover:text-blue-400 cursor-pointer"
                                                title="View Details">
                                            <i class="ri-eye-line text-sm"></i>
                                        </button>

                                        <!-- Edit Link -->
                                        <a href="{{ route('admin.page.edit', $page) }}"
                                           class="grid size-8 place-items-center rounded-lg border border-slate-700/80 bg-slate-800/60 text-slate-300 transition duration-150 hover:border-emerald-400 hover:bg-emerald-500/10 hover:text-emerald-400"
                                           title="Edit Page">
                                            <i class="ri-edit-line text-sm"></i>
                                        </a>

                                        <!-- Delete Modal Trigger -->
                                        <button type="button"
                                                onclick="openModal('deleteModal_{{ $page->id }}')"
                                                class="grid size-8 place-items-center rounded-lg border border-slate-700/80 bg-slate-800/60 text-slate-300 transition duration-150 hover:border-rose-500 hover:bg-rose-500/10 hover:text-rose-400 cursor-pointer"
                                                title="Delete Page">
                                            <i class="ri-delete-bin-line text-sm"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-12 text-center">
                                    <div class="mx-auto mb-3 grid size-12 place-items-center rounded-2xl border border-slate-800 bg-slate-900/60 text-slate-500">
                                        <i class="ri-pages-line text-2xl"></i>
                                    </div>
                                    <p class="font-semibold text-white">No pages found</p>
                                    <p class="mt-1 text-xs text-slate-400">
                                        @if(request('search'))
                                            No pages matched your search query "{{ request('search') }}".
                                        @else
                                            Get started by adding your first dynamic page.
                                        @endif
                                    </p>
                                    @if(request('search'))
                                        <a href="{{ route('admin.page.index') }}" class="mt-3 inline-flex items-center gap-1 text-xs text-emerald-400 hover:underline">
                                            <span>Clear search filter</span>
                                        </a>
                                    @else
                                        <a href="{{ route('admin.page.create') }}" class="mt-4 inline-flex items-center gap-1.5 rounded-xl bg-emerald-400 px-4 py-2 text-xs font-bold text-slate-950 hover:bg-emerald-300 transition">
                                            <i class="ri-add-line"></i>
                                            <span>Create First Page</span>
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
        @if($pages->hasPages())
            <div class="border-t border-slate-800 p-4">
                {{ $pages->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

<!-- ============================================== -->
<!-- MODALS SECTION (View & Delete Confirmations)  -->
<!-- ============================================== -->
@foreach($pages as $page)
    <!-- View Page Detail Modal -->
    <div id="viewModal_{{ $page->id }}" class="modal-backdrop fixed inset-0 z-50 hidden bg-black/75 backdrop-blur-md overflow-y-auto p-4 sm:p-6 grid place-items-center">
        <div class="relative w-full max-w-2xl rounded-2xl border border-slate-800 bg-[#11161F] p-6 shadow-2xl text-left my-8" onclick="event.stopPropagation()">
            <!-- Modal Header -->
            <div class="flex items-start justify-between border-b border-slate-800 pb-4 mb-5">
                <div class="flex items-center gap-3">
                    <div class="grid size-12 place-items-center rounded-xl border border-emerald-500/30 bg-emerald-500/10 text-emerald-400">
                        <i class="ri-pages-line text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="font-display text-lg font-bold text-white">{{ $page->title }}</h3>
                        <p class="font-mono text-xs text-slate-400">Slug: <span class="text-emerald-400">/{{ $page->slug }}</span> • Created: {{ $page->created_at ? $page->created_at->format('M d, Y') : '—' }}</p>
                    </div>
                </div>
                <button type="button"
                        onclick="closeModal('viewModal_{{ $page->id }}')"
                        class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-800 hover:text-white transition cursor-pointer">
                    <i class="ri-close-line text-xl"></i>
                </button>
            </div>

            <!-- Modal Content -->
            <div class="space-y-4 max-h-[60vh] overflow-y-auto pr-1">
                @if (!empty($page->image))
                    <div class="overflow-hidden rounded-xl border border-slate-800 bg-[#0A0D14] p-2">
                        <img src="{{ $page->image }}" alt="{{ $page->title }}" class="max-h-64 w-full rounded-lg object-cover">
                    </div>
                @endif

                <!-- Detailed Rich Description Box -->
                <div class="rounded-xl border border-slate-800 bg-[#0A0D14] p-4">
                    <span class="block font-mono text-[11px] uppercase tracking-wider text-slate-400 mb-2">Page Content</span>
                    <div class="text-sm leading-relaxed text-slate-300 space-y-2">
                        @if(strip_tags($page->description) === $page->description)
                            {!! nl2br(e($page->description)) !!}
                        @else
                            {!! $page->description !!}
                        @endif
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="mt-6 flex items-center justify-between border-t border-slate-800 pt-4">
                <a href="{{ route('page', $page->slug) }}"
                   target="_blank"
                   class="inline-flex items-center gap-1.5 rounded-xl border border-emerald-500/30 bg-emerald-500/10 px-3.5 py-2 text-xs font-semibold text-emerald-300 hover:bg-emerald-500 hover:text-slate-950 transition">
                    <i class="ri-external-link-line"></i>
                    <span>Open Live Page</span>
                </a>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.page.edit', $page) }}"
                       class="rounded-xl bg-emerald-400 px-4 py-2 text-xs font-bold text-slate-950 hover:bg-emerald-300 transition">
                        <i class="ri-edit-line mr-1"></i> Edit
                    </a>
                    <button type="button"
                            onclick="closeModal('viewModal_{{ $page->id }}')"
                            class="rounded-xl border border-slate-700 bg-slate-800/80 px-4 py-2 text-xs font-semibold text-slate-300 transition hover:bg-slate-700 hover:text-white cursor-pointer">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Single Delete Confirmation Modal -->
    <div id="deleteModal_{{ $page->id }}" class="modal-backdrop fixed inset-0 z-50 hidden bg-black/75 backdrop-blur-md overflow-y-auto p-4 sm:p-6 grid place-items-center">
        <div class="relative w-full max-w-md rounded-2xl border border-slate-800 bg-[#11161F] p-6 shadow-2xl text-center my-8" onclick="event.stopPropagation()">
            <div class="mx-auto mb-4 grid size-12 place-items-center rounded-2xl border border-rose-500/30 bg-rose-500/10 text-rose-400">
                <i class="ri-delete-bin-line text-2xl"></i>
            </div>
            <h3 class="font-display text-lg font-bold text-white">Delete Page?</h3>
            <p class="mt-2 text-xs text-slate-400 leading-relaxed">
                Are you sure you want to delete <span class="font-semibold text-slate-200">"{{ $page->title }}"</span>? This will remove the page and its content permanently.
            </p>
            <div class="mt-6 flex items-center justify-center gap-3">
                <button type="button"
                        onclick="closeModal('deleteModal_{{ $page->id }}')"
                        class="rounded-xl border border-slate-700 bg-slate-800/80 px-4 py-2.5 text-xs font-semibold text-slate-300 transition hover:bg-slate-700 hover:text-white cursor-pointer">
                    Cancel
                </button>
                <button type="button"
                        onclick="submitSingleDelete('{{ route('admin.page.destroy', $page) }}')"
                        class="rounded-xl bg-rose-500 px-5 py-2.5 text-xs font-bold text-white shadow-lg shadow-rose-500/20 transition hover:bg-rose-600 cursor-pointer">
                    Yes, Delete Page
                </button>
            </div>
        </div>
    </div>
@endforeach

<!-- Bulk Delete Confirmation Modal -->
<div id="bulkDeleteModal" class="modal-backdrop fixed inset-0 z-50 hidden bg-black/75 backdrop-blur-md overflow-y-auto p-4 sm:p-6 grid place-items-center">
    <div class="relative w-full max-w-md rounded-2xl border border-slate-800 bg-[#11161F] p-6 shadow-2xl text-center my-8" onclick="event.stopPropagation()">
        <div class="mx-auto mb-4 grid size-12 place-items-center rounded-2xl border border-rose-500/30 bg-rose-500/10 text-rose-400">
            <i class="ri-error-warning-line text-2xl"></i>
        </div>
        <h3 class="font-display text-lg font-bold text-white">Bulk Delete Pages?</h3>
        <p class="mt-2 text-xs text-slate-400 leading-relaxed">
            Are you sure you want to permanently delete all selected pages? This action cannot be undone.
        </p>
        <div class="mt-6 flex items-center justify-center gap-3">
            <button type="button"
                    onclick="closeModal('bulkDeleteModal')"
                    class="rounded-xl border border-slate-700 bg-slate-800/80 px-4 py-2.5 text-xs font-semibold text-slate-300 transition hover:bg-slate-700 hover:text-white cursor-pointer">
                Cancel
            </button>
            <button type="button"
                    onclick="document.getElementById('bulkDeleteForm').submit()"
                    class="rounded-xl bg-rose-500 px-5 py-2.5 text-xs font-bold text-white shadow-lg shadow-rose-500/20 transition hover:bg-rose-600 cursor-pointer">
                Yes, Delete Selected
            </button>
        </div>
    </div>
</div>
@endsection

@push('extra_scripts')
<script>
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }
    }

    function submitSingleDelete(actionUrl) {
        const form = document.getElementById('deleteForm');
        form.action = actionUrl;
        form.submit();
    }

    // Backdrop click close
    document.querySelectorAll('.modal-backdrop').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
                document.body.style.overflow = '';
            }
        });
    });

    // ESC key close
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-backdrop:not(.hidden)').forEach(modal => {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            });
        }
    });

    // Checkbox selection & bulk action bar logic
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    const checkItems = document.querySelectorAll('.check-item');
    const bulkActionsBar = document.getElementById('bulkActionsBar');
    const selectedCountSpan = document.getElementById('selectedCount');

    function updateBulkState() {
        const checkedCount = document.querySelectorAll('.check-item:checked').length;
        if (selectedCountSpan) selectedCountSpan.textContent = checkedCount;

        if (checkedCount > 0) {
            bulkActionsBar.classList.remove('hidden');
        } else {
            bulkActionsBar.classList.add('hidden');
        }

        if (selectAllCheckbox) {
            selectAllCheckbox.checked = (checkedCount === checkItems.length && checkItems.length > 0);
            selectAllCheckbox.indeterminate = (checkedCount > 0 && checkedCount < checkItems.length);
        }
    }

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            checkItems.forEach(item => item.checked = this.checked);
            updateBulkState();
        });
    }

    checkItems.forEach(item => {
        item.addEventListener('change', updateBulkState);
    });
</script>
@endpush