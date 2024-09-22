<x-layout>
    <div>
        <section class="space-y-16">
            <x-section-heading>Search Result</x-section-heading>

            <div>
                @foreach ($blogs as $blog)
                    <a href="/show/{{ $blog->id }}">
                        <x-card :$blog />
                    </a>
                @endforeach
            </div>

            <div>
                {{ $blogs->appends(['query' => $query])->links() }}
            </div>
        </section>
    </div>
</x-layout>