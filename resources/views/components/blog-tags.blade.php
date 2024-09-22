@props(['tags' => null])

@if ($tags)
    <div>
        @foreach ($tags as $tag)
            <a href="/search?query={{ $tag->name }}">
                <div class="badge badge-primary cursor-pointer">{{ $tag->name }}</div>
            </a>
        @endforeach
    </div>
@endif
