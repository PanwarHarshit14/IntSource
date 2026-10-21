@php
    $rawLoc = trim($contact?->location ?? '');
    $mapSrc = '';
    if (!empty($rawLoc)) {
        if (str_contains($rawLoc, '<iframe')) {
            if (preg_match('/src=["\']([^"\']+)["\']/', $rawLoc, $m)) {
                $mapSrc = $m[1];
            }
        } elseif (str_starts_with($rawLoc, 'http://') || str_starts_with($rawLoc, 'https://')) {
            $mapSrc = $rawLoc;
        } elseif (str_starts_with($rawLoc, 'pb=')) {
            $mapSrc = 'https://www.google.com/maps/embed?' . $rawLoc;
        } elseif (str_starts_with($rawLoc, '!1m')) {
            $mapSrc = 'https://www.google.com/maps/embed?pb=' . $rawLoc;
        } else {
            $mapSrc = 'https://maps.google.com/maps?q=' . urlencode($rawLoc) . '&output=embed';
        }
    }
    if (empty($mapSrc)) {
        $mapSrc = 'https://maps.google.com/maps?q=' . urlencode($contact?->address ?? 'San Francisco, CA') . '&output=embed';
    }

    $validPhones = array_values(array_filter($contact?->phones ?? [], fn($p) => !empty($p)));
    $primaryPhone = !empty($validPhones) ? $validPhones[0] : '+1 (800) 555-0199';
    $cleanPhone = preg_replace('/[^0-9+]/', '', (string)$primaryPhone);
    $contactEmail = $contact?->email ?? 'panwarharshit14@gmail.com';
    $contactAddress = $contact?->address ?? 'San Francisco, CA & Remote Worldwide';
    $mapLink = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($contactAddress);
@endphp

<footer class="border-t border-line bg-s1 pb-28 pt-16 text-[15px] text-mu sm:pb-10 sm:pt-20">
    <div class="wrap">
        <div class="grid grid-cols-2 gap-x-6 gap-y-12 sm:grid-cols-3 sm:gap-x-8 lg:grid-cols-[1.3fr_0.8fr_0.9fr_1.4fr] lg:gap-x-12">
            {{-- Column 1: Brand & Social Links --}}
            <div class="col-span-2 sm:col-span-3 lg:col-span-1">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 font-display text-[22px] font-bold text-[#E8ECF4]">
                    @if(!empty($contact?->logo))
                        <img src="{{ $contact->logo }}" alt="{{ $contact?->name ?? 'IntSource' }}" class="size-8 rounded-lg object-contain shadow-sm">
                    @else
                        <span class="mark"></span>
                    @endif
                    <span>{{ $contact?->name ?? 'IntSource' }}</span>
                </a>
                <p class="mt-5 max-w-[320px]">
                    Software, cloud, and AI solutions for forward-thinking businesses that build with confidence.
                </p>
                <div class="soc mt-7 flex flex-wrap gap-3">
                    @if(!empty($contact?->social_links['linkedin']))
                        <a href="{{ $contact->social_links['linkedin'] }}" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                            <svg viewBox="0 0 24 24"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect width="4" height="12" x="2" y="9"/><circle cx="4" cy="4" r="2"/></svg>
                        </a>
                    @else
                        <a href="https://linkedin.com" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                            <svg viewBox="0 0 24 24"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect width="4" height="12" x="2" y="9"/><circle cx="4" cy="4" r="2"/></svg>
                        </a>
                    @endif

                    @if(!empty($contact?->social_links['facebook']))
                        <a href="{{ $contact->social_links['facebook'] }}" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                            <svg viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                        </a>
                    @endif

                    @if(!empty($contact?->social_links['instagram']))
                        <a href="{{ $contact->social_links['instagram'] }}" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                            <svg viewBox="0 0 24 24"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><path d="M17.5 6.5h.01"/></svg>
                        </a>
                    @else
                        <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                            <svg viewBox="0 0 24 24"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><path d="M17.5 6.5h.01"/></svg>
                        </a>
                    @endif

                    @if(!empty($contact?->social_links['whatsapp']))
                        @php
                            $cWa = preg_replace('/[^0-9]/', '', (string)$contact->social_links['whatsapp']);
                        @endphp
                        <a href="https://wa.me/{{ $cWa }}" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp">
                            <svg viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </a>
                    @else
                        <a href="https://github.com" target="_blank" rel="noopener noreferrer" aria-label="GitHub">
                            <svg viewBox="0 0 24 24"><path d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4"/><path d="M9 18c-4.51 2-5-2-7-2"/></svg>
                        </a>
                    @endif
                </div>
            </div>

            {{-- Column 2: Company --}}
            <div>
                <h4 class="fh">Company</h4>
                <ul class="fl">
                    <li><a href="#about">About us</a></li>
                    <li><a href="#process">How we work</a></li>
                    <li><a href="#expertise">Expertise</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </div>

            {{-- Column 3: Services --}}
            <div>
                <h4 class="fh">Services</h4>
                <ul class="fl">
                    <li><a href="#expertise">Custom Software</a></li>
                    <li><a href="#expertise">Web &amp; Mobile Apps</a></li>
                    <li><a href="#expertise">Cloud &amp; DevOps</a></li>
                    <li><a href="#expertise">AI &amp; Data</a></li>
                    <li><a href="#expertise">UI/UX Design</a></li>
                </ul>
            </div>

            {{-- Column 4: Location Map & Contact Details (Replaces Resources) --}}
            <div class="col-span-2 sm:col-span-3 lg:col-span-1">
                <h4 class="fh flex items-center gap-2">
                    <svg class="size-4 text-ac" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21s7-6 7-11a7 7 0 0 0-14 0c0 5 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>
                    <span>Our Location</span>
                </h4>

                {{-- Interactive Map Embed Container --}}
                <div class="group relative mt-4 overflow-hidden rounded-2xl border border-line bg-s2 shadow-md transition-all duration-300 hover:border-ac/50">
                    <iframe 
                        src="{{ $mapSrc }}" 
                        class="h-[150px] w-full border-0 filter grayscale contrast-125 opacity-85 transition-all duration-500 group-hover:grayscale-0 group-hover:opacity-100" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade"
                        title="{{ ($contact?->name ?? 'IntSource') }} Office Map">
                    </iframe>
                    <a href="{{ $mapLink }}" target="_blank" rel="noopener noreferrer" class="absolute bottom-2 right-2 inline-flex items-center gap-1.5 rounded-lg border border-line/60 bg-s1/90 px-2.5 py-1 text-[11px] font-medium text-white shadow-sm backdrop-blur transition hover:bg-ac hover:text-white">
                        <span>Open in Maps</span>
                        <svg class="size-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-16 flex flex-wrap items-center justify-between gap-4 border-t border-line pt-7 text-sm">
            <span>&copy; {{ date('Y') }} {{ $contact?->name ?? 'IntSource' }}. All rights reserved.</span>
            <div class="flex flex-wrap gap-x-6 gap-y-2">
                <a class="transition-colors hover:text-ac" href="#">Privacy Policy</a>
                <a class="transition-colors hover:text-ac" href="#">Terms of Service</a>
                <a class="transition-colors hover:text-ac" href="#">Cookies</a>
            </div>
        </div>
    </div>
</footer>