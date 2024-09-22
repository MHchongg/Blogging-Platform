@props(['selectedSortOption' => 'Latest'])

<x-layout>
    <div class="flex flex-col items-center gap-y-20">
        <section class="w-5/6 flex flex-col items-center gap-y-10 mt-4">
            <x-section-heading>Let's Get Started</x-section-heading>

            <form method="GET" action="/search" class="w-9/12">
                <label class="input input-bordered input-info flex items-center gap-2">
                    <input name="query" id="query" autocomplete="query" type="text" class="grow"
                        placeholder="Search Blog..." />

                    <button type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                            class="h-4 w-4 opacity-70">
                            <path fill-rule="evenodd"
                                d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </label>
            </form>
        </section>

        <section class="w-5/6 space-y-16">
            <x-section-heading>Blogs</x-section-heading>

            <div class="flex justify-between">
                <form method="GET" action="/blog/sort" id="sort-blog-form">
                    <select name="blog-sort" id="blog-sort" class="select select-warning w-full max-w-xs select-sm"
                        onchange="document.getElementById('sort-blog-form').submit();">
                        <option {{ $selectedSortOption == 'Latest' ? 'selected' : '' }}>Lastest</option>
                        <option {{ $selectedSortOption == 'Hottest' ? 'selected' : '' }}>Hottest</option>
                    </select>
                </form>

                <a href="/create" class="flex justify-between btn btn-active btn-accent btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd"
                            d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z"
                            clip-rule="evenodd" />
                    </svg>

                    New Blog
                </a>
            </div>

            <div>
                @foreach ($blogs as $blog)
                    <a href="/show/{{ $blog->id }}">
                        <x-card :$blog />
                    </a>
                @endforeach
            </div>

            <div>
                {{ $blogs->appends(['blog-sort' => $selectedSortOption])->links() }}
            </div>
        </section>
    </div>
</x-layout>
