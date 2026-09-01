@props(['current' => 1, 'total' => 4])

@php
    $steps = [
        1 => 'Data Dasar',
        2 => 'Pilih Template',
        3 => 'Identitas Visual',
        4 => 'Profil & Struktur',
    ];
@endphp

<nav aria-label="Progress wizard" class="mb-8">
    <ol class="flex items-center w-full">
        @foreach($steps as $number => $label)
            <li class="flex items-center {{ $number < $total ? 'flex-1' : '' }}">
                <div class="flex flex-col items-center">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full border-2 text-sm font-semibold transition-all duration-200
                        @if($number < $current)
                            bg-cobalt border-cobalt text-white
                        @elseif($number === $current)
                            border-cobalt text-cobalt bg-cobalt/10
                        @else
                            border-slate-border text-ash-text bg-graphite-card
                        @endif
                    ">
                        @if($number < $current)
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        @else
                            {{ $number }}
                        @endif
                    </div>
                    <span class="mt-2 text-xs font-medium
                        @if($number <= $current) text-cobalt @else text-ash-text @endif
                    ">{{ $label }}</span>
                </div>

                @if($number < $total)
                    <div class="flex-1 h-0.5 mx-3 mt-[-1.25rem]
                        @if($number < $current) bg-cobalt @else bg-slate-border/30 @endif
                    "></div>
                @endif
            </li>
        @endforeach
    </ol>
    <p class="text-center text-sm text-ash-text mt-4">Langkah {{ $current }} dari {{ $total }}</p>
</nav>
