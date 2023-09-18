<div>
    <h3 class="text-lg font-semibold text-gray-900 mb-3">Recommended Topics</h3>
    <div class="topics flex flex-wrap justify-start gap-x-2">

        @foreach ($tags as $tag)
            <x-badge wire:navigate href="{{ route('posts.index', ['tag' => $tag->slug]) }}" :textColor="$tag->text_color"
                :bgColor="$tag->bg_color">
                {{ $tag->title }}
            </x-badge>
        @endforeach

    </div>
</div>
