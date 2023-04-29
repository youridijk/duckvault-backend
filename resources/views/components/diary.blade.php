<x-layout>
    <div class="w-4/5 bg-sky-400 mx-auto h-full">
        @foreach ($diaryEntries as $diaryEntry)
            <x-diary-entry :diary-entry="$diaryEntry"/>
        @endforeach
    </div>
</x-layout>
