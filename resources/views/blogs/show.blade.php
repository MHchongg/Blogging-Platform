@props(['selectedSortOption' => 'Hottest'])

<x-layout>
    <div class="space-y-5">
        <section class="flex space-x-8 items-center">
            <a href="{{ url()->previous() }}" class="cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
            </a>

            <x-avatar name="{{ $blog->user->name }}" class="w-12" />

            <span>{{ $blog->user->name }}</span>

            <span>{{ $blog->created_at }}</span>
        </section>

        <section class="space-y-5">

            <div class="flex justify-between items-center">
                <h2 class="font-bold text-3xl">{{ $blog->title }}</h2>

                @can('edit_delete_blog', $blog)
                    <details class="dropdown dropdown-end">
                        <summary class="btn m-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                            </svg>
                        </summary>
                        <ul class="menu dropdown-content bg-slate-600 rounded-box z-[1] w-52 p-2 shadow">
                            <li><a href="/edit/{{ $blog->id }}">Edit Blog</a></li>
                            <li><button form="delete-blog-form">Delete Blog</button></li>
                        </ul>
                    </details>
                @endcan
            </div>

            <p class="text-justify">{{ $blog->content }}</p>

            <x-blog-tags :tags="$blog->tags" />

            @if ($blog->image)
                <img src="{{ asset($blog->image) }}" alt="blog" class="size-2/4 mx-auto" />
            @endif

            <div class="flex gap-x-4 mt-2">
                <div class="flex gap-x-2">
                    <button id="like-blog-button">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-6 hover:text-red-600 duration-200 {{ $blog->likes()->where('user_id', auth()->id())->count() ? 'text-red-600' : '' }}">
                            <path
                                d="m11.645 20.91-.007-.003-.022-.012a15.247 15.247 0 0 1-.383-.218 25.18 25.18 0 0 1-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0 1 12 5.052 5.5 5.5 0 0 1 16.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 0 1-4.244 3.17 15.247 15.247 0 0 1-.383.219l-.022.012-.007.004-.003.001a.752.752 0 0 1-.704 0l-.003-.001Z" />
                        </svg>
                    </button>
                    <span id="blog-likes-count">
                        {{ $blog->likes()->count() }}
                    </span>
                </div>

                <div class="flex gap-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd"
                            d="M5.337 21.718a6.707 6.707 0 0 1-.533-.074.75.75 0 0 1-.44-1.223 3.73 3.73 0 0 0 .814-1.686c.023-.115-.022-.317-.254-.543C3.274 16.587 2.25 14.41 2.25 12c0-5.03 4.428-9 9.75-9s9.75 3.97 9.75 9c0 5.03-4.428 9-9.75 9-.833 0-1.643-.097-2.417-.279a6.721 6.721 0 0 1-4.246.997Z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ $blog->comments()->count() }}
                </div>
            </div>
        </section>

        <div class="divider">Comments</div>

        <section class="space-y-8">
            <form method="POST" action="/comment/{{ $blog->id }}" class="space-y-5">
                @csrf

                <textarea name="content" id="content" class="textarea textarea-secondary textarea-md w-full"
                    placeholder="Add a comment..." required></textarea>
                <x-form-error name="content"></x-form-error>

                <div class="flex justify-end gap-x-3">
                    <input type="reset" value="Clear" class="btn btn-outline btn-error btn-sm" />
                    <input type="submit" value="Comment" class="btn btn-success btn-sm" />
                </div>
            </form>

            <div class="space-y-10">
                <form action="/comment/sort/{{ $blog->id }}" method="get" id="sort-comment-form">
                    <label for="comment-sort">Sort By:</label>
                    <select name="comment-sort" id="comment-sort" class="select select-warning max-w-xs select-sm"
                        onchange="document.getElementById('sort-comment-form').submit();">
                        <option {{ $selectedSortOption == 'Hottest' ? 'selected' : '' }}>Hottest</option>
                        <option {{ $selectedSortOption == 'Latest' ? 'selected' : '' }}>Latest</option>
                    </select>
                </form>

                <ul class="space-y-14">
                    @if (count($comments) == 0)
                        <h1 class="text-center text-3xl">No comments</h1>
                    @else
                        @foreach ($comments as $comment)
                            <x-comment :$comment />
                        @endforeach
                    @endif
                </ul>

                {{ $comments->appends(['comment-sort' => $selectedSortOption])->links() }}
            </div>
        </section>
    </div>

    <form id="delete-blog-form" method="POST" action="/blog/{{ $blog->id }}" class="hidden">
        @csrf
        @method('DELETE')
    </form>
</x-layout>

<script>
    $(document).ready(function () {
        $('#like-blog-button').on('click', function (e) {
            e.preventDefault();
            
            const button = $(this);
            
            $.ajax({
                url: '/blog/{{ $blog->id }}/like',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    button.siblings('#blog-likes-count').text(response.blog_likes_count);
                    
                    // Toggle button color (indicating like/unlike)
                    if (response.status) {
                        button.find('svg').addClass('text-red-600');
                    } else {
                        button.find('svg').removeClass('text-red-600');
                    }
                },
                error: function (error) {
                    console.error('Error:', error);

                    if (error.status === 401) window.location.href = "http://127.0.0.1:8000/login";
                }
            });
        });
    });
</script>
