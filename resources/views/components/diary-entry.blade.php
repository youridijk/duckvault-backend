<div class="p-5">
    <div class="flex items-center gap-3">
        @if (count($imageUrls))
            <div class="w-1/12">
                {{--                            <img src="http://localhost:3300/nl_po3_335a_001.jpeg" alt="image"/>--}}
                <img src="{{ $imageUrls[0]  }}" alt="image"/>
            </div>
        @endif
        <div>
            <h3 class="text-xl font-bold">{{ $title }}</h3>
            <p>{{$diaryEntry->read_on}}</p>
            <div class="flex gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="{{ $diaryEntry->liked ? 'red' : 'grey'  }}"
                     viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                </svg>

                @if ($diaryEntry->reread)
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                @endif
            </div>
        </div>
    </div>
</div>
