@php
    $technologies = ['React', 'Node.js', 'TypeScript', 'Python', 'AWS', 'Azure', 'Kubernetes', 'Docker', 'Flutter', 'PostgreSQL', 'TensorFlow', 'Figma'];
@endphp

<div class="overflow-hidden border-y border-line bg-s1 py-6">
    <div id="track" class="track flex w-max animate-marq gap-14 hover:[animation-play-state:paused]">
        {{-- First sequence of tech badges --}}
        @foreach($technologies as $tech)
            <span>{{ $tech }}</span>
        @endforeach
        {{-- Repeated sequence for continuous infinite loop --}}
        @foreach($technologies as $tech)
            <span>{{ $tech }}</span>
        @endforeach
    </div>
</div>