<div class="space-y-1.5 px-3 py-2">
    @foreach ($menus as $menu)
        @if (!empty($menu['children']))
            <details class="group select-none" {{ !empty($menu['active']) ? 'open' : '' }}>
                <summary class="flex cursor-pointer items-center justify-between gap-3 rounded-xl px-3.5 py-2.5 text-sm font-medium transition-all duration-200 list-none {{ !empty($menu['active']) ? 'bg-emerald-500/15 text-emerald-300 shadow-sm border border-emerald-500/20' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                    <div class="flex items-center gap-3">
                        <span class="grid size-8 place-items-center rounded-lg {{ !empty($menu['active']) ? 'bg-emerald-500/20 text-emerald-400' : 'bg-slate-800/80 text-slate-400 group-hover:text-slate-200' }}">
                            <i class="{{ $menu['icon'] }} text-xs"></i>
                        </span>
                        <span>{{ $menu['label'] }}</span>
                    </div>
                    <svg class="size-4 text-slate-500 transition-transform duration-200 group-open:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </summary>
                <div class="mt-1 space-y-1 pl-11 pr-2">
                    @foreach ($menu['children'] as $smenu)
                        <a href="{{ !empty($smenu['url']) ? $smenu['url'] : '#' }}"
                           class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-400 transition hover:bg-slate-800/60 hover:text-emerald-300">
                            {{ $smenu['label'] }}
                        </a>
                    @endforeach
                </div>
            </details>
        @else
            <a href="{{ !empty($menu['url']) ? $menu['url'] : '#' }}"
               target="{{ $menu['target'] ?? '_self' }}"
               class="group flex items-center justify-between rounded-xl px-3.5 py-2.5 text-sm font-medium transition-all duration-200 {{ !empty($menu['active']) ? 'bg-gradient-to-r from-emerald-500/20 to-emerald-500/5 text-emerald-300 border-l-2 border-emerald-400 shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                <div class="flex items-center gap-3">
                    <span class="grid size-8 place-items-center rounded-lg transition-colors {{ !empty($menu['active']) ? 'bg-emerald-500/25 text-emerald-300 shadow-sm shadow-emerald-500/20' : 'bg-slate-800/70 text-slate-400 group-hover:bg-slate-700/80 group-hover:text-emerald-400' }}">
                        <i class="{{ $menu['icon'] }} text-base"></i>
                    </span>
                    <span>{{ $menu['label'] }}</span>
                </div>
                @if(!empty($menu['target']) && $menu['target'] === '_blank')
                    <svg class="size-3.5 text-slate-500 opacity-60 transition group-hover:opacity-100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6M15 3h6v6M10 14L21 3"/></svg>
                @endif
            </a>
        @endif
    @endforeach
</div>