@props(['post'])

<div {{ $attributes }}>
    <a href="#">
        <div>
            <img class="w-full rounded-xl" src="{{ $post->getThumbnailImage() }}">
        </div>
    </a>
    <div class="mt-3">
        <div class="flex items-center mb-2 gap-x-2">
            @if ($tag = $post->tags()->first())
                <x-badge wire:navigate href="{{ route('posts.index', ['tag' => $tag->slug]) }}" :textColor="$tag->text_color"
                    :bgColor="$tag->bg_color">
                    {{ $tag->title }}
                </x-badge>
            @endif
            <p class="text-gray-500 text-sm">{{ $post->published_at }}</p>
        </div>
        <a href="#" class="text-xl font-bold text-gray-900">{{ $post->title }}</a>
    </div>
</div>
