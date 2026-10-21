<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#0A0D14]">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" type="image/png" href="{{ $contact->favicon ?? asset('favicon.ico') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME', 'IntSource') }} &bull; Admin Panel</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:ital,wght@0,400;0,500;1,400&family=IBM+Plex+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap">

    <!-- Remix Icon (Modern Icon System) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css">
    <!-- FontAwesome 6 CDN (Fallback) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind CSS (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('extra_styles')
</head>

<body class="min-h-full bg-[#0A0D14] font-sans text-slate-200 antialiased selection:bg-emerald-500/30 selection:text-emerald-200">
    <div class="flex min-h-screen">
        <!-- Mobile Sidebar Backdrop Overlay -->
        <div id="sidebarBackdrop"
             class="fixed inset-0 z-40 hidden bg-black/60 backdrop-blur-sm transition-opacity duration-300 lg:hidden"
             onclick="toggleMobileSidebar(false)"></div>

        <!-- Sidebar Navigation -->
        <aside id="mainSidebar"
               class="fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col border-r border-slate-800/80 bg-[#11161F] transition-transform duration-300 ease-in-out lg:sticky lg:top-0 lg:h-screen lg:shrink-0 lg:translate-x-0">
            <!-- Sidebar Header / Brand -->
            <div class="flex h-16 shrink-0 items-center justify-between border-b border-slate-800/80 px-5">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                    @if(!empty($contact->favicon))
                        <div class="grid size-9 place-items-center rounded-xl border border-emerald-500/30 bg-emerald-500/10 p-1.5 text-emerald-400 shadow-sm shadow-emerald-500/10 transition group-hover:border-emerald-500/50">
                            <img src="{{ asset($contact->favicon) }}" alt="Logo" class="size-6 object-contain">
                        </div>
                    @else
                        <div class="grid size-9 place-items-center rounded-xl border border-emerald-500/30 bg-emerald-500/10 text-emerald-400 shadow-sm shadow-emerald-500/10">
                            <i class="ri-dashboard-3-line text-lg"></i>
                        </div>
                    @endif
                    <div>
                        <span class="block font-display text-base font-bold tracking-tight text-white group-hover:text-emerald-300 transition">
                            {{ $contact->name ?? 'DPS Panel' }}
                        </span>
                        <span class="block font-mono text-[10px] uppercase tracking-wider text-emerald-400 font-medium">Control Hub</span>
                    </div>
                </a>

                <!-- Mobile Close Button -->
                <button type="button"
                        onclick="toggleMobileSidebar(false)"
                        class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-800 hover:text-white lg:hidden"
                        aria-label="Close sidebar">
                    <i class="ri-close-line text-xl"></i>
                </button>
            </div>

            <!-- Navigation Menu -->
            <div class="flex-1 overflow-y-auto px-2 py-4">
                <div class="px-4 pb-2">
                    <span class="font-mono text-[11px] font-semibold uppercase tracking-wider text-slate-500">Navigation</span>
                </div>
                <x-admin.menu-bar />
            </div>

            <!-- Sidebar Footer / Admin Quick Card -->
            <div class="border-t border-slate-800/80 p-3">
                <div class="flex items-center justify-between rounded-xl bg-slate-900/60 p-2.5">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <div class="grid size-9 shrink-0 place-items-center rounded-lg bg-emerald-500/10 text-emerald-400 font-bold border border-emerald-500/20 text-xs">
                            {{ strtoupper(substr(Auth::guard('admin')->user()->name ?? 'A', 0, 2)) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-xs font-semibold text-white">{{ Auth::guard('admin')->user()->name ?? 'Administrator' }}</p>
                            <p class="truncate font-mono text-[10px] text-emerald-400">Online</p>
                        </div>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="GET" class="m-0">
                        @csrf
                        <button type="submit"
                                title="Sign Out"
                                class="grid size-8 place-items-center rounded-lg text-slate-400 hover:bg-rose-500/10 hover:text-rose-400 transition">
                            <i class="ri-logout-box-r-line text-base"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Wrapper -->
        <div class="flex flex-1 flex-col min-w-0 overflow-x-hidden">
            <!-- Top Navbar -->
            <header class="sticky top-0 z-30 flex h-16 shrink-0 items-center justify-between border-b border-slate-800/80 bg-[#11161F]/90 px-4 backdrop-blur-md sm:px-6 lg:px-8">
                <!-- Left: Sidebar Toggle & Page Indicator -->
                <div class="flex items-center gap-3">
                    <button type="button"
                            onclick="toggleMobileSidebar(true)"
                            class="grid size-9 place-items-center rounded-lg border border-slate-700 bg-slate-800/80 text-slate-300 transition hover:bg-slate-700 hover:text-white lg:hidden"
                            aria-label="Toggle navigation">
                        <i class="ri-menu-line text-lg"></i>
                    </button>
                    <div class="hidden items-center gap-2 text-xs font-medium text-slate-400 sm:flex">
                        <span>Admin</span>
                        <i class="ri-arrow-right-s-line text-sm text-slate-600"></i>
                        <span class="text-emerald-400">{{ $pageTitle ?? 'Portal' }}</span>
                    </div>
                </div>

                <!-- Right Actions: Live Site & User Menu -->
                <div class="flex items-center gap-3">
                    <!-- View Live Site Link -->
                    <a href="{{ route('home') }}"
                       target="_blank"
                       class="hidden items-center gap-2 rounded-xl border border-slate-700/80 bg-slate-800/60 px-3 py-1.5 text-xs font-medium text-slate-300 transition duration-200 hover:border-emerald-500/40 hover:bg-slate-800 hover:text-emerald-300 sm:inline-flex">
                        <i class="ri-global-line text-emerald-400 text-sm"></i>
                        <span>Live Site</span>
                        <i class="ri-external-link-line text-xs text-slate-500"></i>
                    </a>

                    <!-- User Profile Dropdown -->
                    <div class="relative" id="userMenuContainer">
                        <button type="button"
                                id="userMenuBtn"
                                class="flex items-center gap-2.5 rounded-xl border border-slate-700/80 bg-slate-800/60 py-1.5 pl-2.5 pr-3 text-left transition duration-200 hover:border-slate-600 hover:bg-slate-800"
                                aria-expanded="false"
                                aria-haspopup="true">
                            <span class="grid size-7 place-items-center rounded-lg bg-emerald-500/20 text-emerald-400 text-xs font-bold">
                                {{ strtoupper(substr(Auth::guard('admin')->user()->name ?? 'A', 0, 1)) }}
                            </span>
                            <span class="hidden text-xs font-semibold text-slate-200 md:inline-block">
                                {{ Auth::guard('admin')->user()->name ?? 'Admin' }}
                            </span>
                            <i class="ri-arrow-down-s-line text-sm text-slate-400 transition-transform duration-200" id="userMenuArrow"></i>
                        </button>

                        <!-- Dropdown Panel -->
                        <div id="userMenuDropdown"
                             class="absolute right-0 mt-2 hidden w-56 origin-top-right rounded-2xl border border-slate-700/80 bg-[#171E2B] p-1.5 shadow-2xl backdrop-blur-xl transition duration-150 z-50">
                            <div class="border-b border-slate-700/60 px-3 py-2.5 mb-1">
                                <p class="text-xs font-bold text-white">{{ Auth::guard('admin')->user()->name ?? 'Administrator' }}</p>
                                <p class="truncate text-[11px] text-slate-400 font-mono">{{ Auth::guard('admin')->user()->email ?? 'admin@panel' }}</p>
                            </div>
                            <a href="{{ route('admin.profile') }}"
                               class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-medium text-slate-300 transition hover:bg-slate-700/60 hover:text-white">
                                <i class="ri-user-line text-emerald-400 text-sm"></i>
                                <span>My Profile</span>
                            </a>
                            <a href="{{ route('admin.contact.index') }}"
                               class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-medium text-slate-300 transition hover:bg-slate-700/60 hover:text-white">
                                <i class="ri-settings-4-line text-emerald-400 text-sm"></i>
                                <span>Settings</span>
                            </a>
                            <div class="my-1 border-t border-slate-700/60"></div>
                            <form action="{{ route('admin.logout') }}" method="GET" class="m-0">
                                @csrf
                                <button type="submit"
                                        class="flex w-full items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-medium text-rose-400 transition hover:bg-rose-500/10 hover:text-rose-300">
                                    <i class="ri-logout-box-r-line text-rose-400 text-sm"></i>
                                    <span>Sign Out</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Page Content Body -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                <div class="mx-auto max-w-7xl">
                    @yield('main_section')
                </div>
            </main>
        </div>
    </div>

    <!-- Modals Stack (Rendered directly under body for proper fixed positioning) -->
    @stack('modals')

    <!-- jQuery for dynamic forms -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- TinyMCE (kept for WYSIWYG editor if present) -->
    <script src="{{ asset('admin/tinymce/tinymce.min.js') }}"></script>
    <script>
        if (typeof tinymce !== 'undefined' && document.querySelector('textarea#description')) {
            tinymce.init({
                selector: 'textarea#description',
                theme: 'silver',
                height: 400,
                menubar: false,
                skin: 'oxide-dark',
                content_css: 'dark',
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'anchor', 'image', 'charmap', 'preview',
                    'searchreplace', 'visualblocks', 'fullscreen', 'media', 'table', 'code', 'wordcount'
                ],
                toolbar: 'blocks | bold italic underline forecolor | alignleft aligncenter alignright | bullist numlist | link image | code removeformat',
                setup: function(editor) {
                    editor.on('change', function() {
                        tinymce.triggerSave();
                    });
                }
            });
        }
    </script>

    <!-- Global Modal & Navigation Management -->
    <script>
        function openModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                // Ensure modal is attached directly to body so it escapes any CSS transform/filter containing blocks
                if (modal.parentElement !== document.body) {
                    document.body.appendChild(modal);
                }
                modal.classList.remove('hidden');
                // Lock background scrolling completely
                document.documentElement.classList.add('overflow-hidden');
                document.body.classList.add('overflow-hidden');
            }
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.add('hidden');
                // Only unlock background if no other modal is currently active
                const anyOpen = Array.from(document.querySelectorAll('.modal-backdrop')).some(m => !m.classList.contains('hidden'));
                if (!anyOpen) {
                    document.documentElement.classList.remove('overflow-hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            }
        }

        function toggleMobileSidebar(show) {
            const sidebar = document.getElementById('mainSidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            if (show) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Teleport all modals to document.body to ensure full viewport coverage
            document.querySelectorAll('.modal-backdrop').forEach(modal => {
                if (modal.parentElement !== document.body) {
                    document.body.appendChild(modal);
                }
                modal.addEventListener('click', function (e) {
                    if (e.target === this) {
                        closeModal(this.id);
                    }
                });
            });

            // ESC key to close open modals
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    const openModals = document.querySelectorAll('.modal-backdrop:not(.hidden)');
                    openModals.forEach(m => closeModal(m.id));
                }
            });

            // User Menu Dropdown
            const menuBtn = document.getElementById('userMenuBtn');
            const menuDropdown = document.getElementById('userMenuDropdown');
            const menuArrow = document.getElementById('userMenuArrow');

            if (menuBtn && menuDropdown) {
                menuBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const isHidden = menuDropdown.classList.contains('hidden');
                    if (isHidden) {
                        menuDropdown.classList.remove('hidden');
                        menuBtn.setAttribute('aria-expanded', 'true');
                        if (menuArrow) menuArrow.classList.add('rotate-180');
                    } else {
                        menuDropdown.classList.add('hidden');
                        menuBtn.setAttribute('aria-expanded', 'false');
                        if (menuArrow) menuArrow.classList.remove('rotate-180');
                    }
                });

                document.addEventListener('click', function (e) {
                    if (!menuDropdown.contains(e.target) && !menuBtn.contains(e.target)) {
                        menuDropdown.classList.add('hidden');
                        menuBtn.setAttribute('aria-expanded', 'false');
                        if (menuArrow) menuArrow.classList.remove('rotate-180');
                    }
                });

                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape') {
                        menuDropdown.classList.add('hidden');
                        menuBtn.setAttribute('aria-expanded', 'false');
                        if (menuArrow) menuArrow.classList.remove('rotate-180');
                    }
                });
            }
        });
    </script>

    @stack('extra_scripts')
</body>
</html>
