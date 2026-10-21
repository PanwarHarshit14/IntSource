<section id="faq" class="sec alt">
    <div class="wrap grid gap-12 lg:grid-cols-[.8fr_1.2fr] lg:gap-20">
        <div class="rv">
            <div class="eyebrow">FAQ</div>
            <h2 class="h2">Questions, answered.</h2>
            <p class="lead">Can't find what you need? Send us a message and we'll get back to you promptly.</p>
        </div>

        <div class="rv">
            @foreach($faqs as $index => $faq)
                <details class="border-b border-line" {{ $index === 0 ? 'open' : '' }}>
                    <summary class="fq">{{ $faq->question }}</summary>
                    <div class="fa">{!! $faq->answer !!}</div>
                </details>
            @endforeach
        </div>
    </div>
</section>