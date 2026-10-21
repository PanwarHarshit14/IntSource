<section id="expertise" class="sec alt">
    <div class="wrap">
        <div class="rv mb-14 max-w-[680px]">
            <div class="eyebrow">Our expertise</div>
            <h2 class="h2">Everything you need to ship and scale.</h2>
            <p class="lead">End-to-end services across the whole product lifecycle. Select any card to see what we deliver.</p>
        </div>

        <div id="cards" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($services as $index => $service)
                <button type="button" data-n="{{ $index }}" class="card rv group w-full text-left">
                    <span class="ico">
                        @if (!empty($service->icon))
                            @if (str_starts_with($service->icon, 'data:image') || str_starts_with($service->icon, 'http'))
                                <img src="{{ $service->icon }}" alt="{{ $service->title }}" class="size-[26px] object-contain">
                            @elseif (str_starts_with($service->icon, 'ri-') || str_starts_with($service->icon, 'fa-'))
                                <i class="{{ $service->icon }} text-[26px]"></i>
                            @elseif (str_starts_with($service->icon, '<svg'))
                                {!! $service->icon !!}
                            @else
                                <svg class="i size-[26px]" viewBox="0 0 24 24">{!! $service->icon !!}</svg>
                            @endif
                        @else
                            <svg class="i size-[26px]" viewBox="0 0 24 24"><path d="M12 3l8 3v6c0 5-3.5 8-8 9-4.5-1-8-4-8-9V6z"/></svg>
                        @endif
                    </span>
                    <h3 class="text-2xl font-bold">{{ $service->title }}</h3>
                    <p class="mt-3 text-[15px] text-mu">{{ $service->short_description }}</p>
                    <span class="mt-6 inline-flex items-center gap-2 text-sm font-medium text-ac">
                        <span>View details</span>
                        <svg class="i size-4 transition-transform group-hover:translate-x-1" viewBox="0 0 24 24">
                            <path d="M5 12h14M13 6l6 6-6 6"/>
                        </svg>
                    </span>
                </button>
            @empty
                <div class="sm:col-span-2 lg:col-span-3 text-center py-12">
                    <p class="text-mu text-lg">Services coming soon — stay tuned!</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- Pass services data to JS for the detail modal --}}
<script id="servicesData" type="application/json">
    {!! json_encode($services->map(function ($s) {
        $rawDesc = $s->description ?? '';
        $lines = array_values(array_filter(array_map('trim', explode("\n", $rawDesc))));
        $bullets = [];
        $descParts = [];
        foreach ($lines as $line) {
            if (preg_match('/^[-*•]\s*(.+)$/u', $line, $matches)) {
                $bullets[] = $matches[1];
            } else {
                $descParts[] = $line;
            }
        }
        return [
            't' => $s->title,
            'd' => $s->short_description,
            'l' => count($descParts) > 0 ? implode("\n\n", $descParts) : ($s->short_description ?? ''),
            'b' => $bullets,
            'i' => $s->icon ?? '',
        ];
    })) !!}
</script>