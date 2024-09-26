@props(['comment'])

<li class="space-y-3">
    <div class="space-x-5">
        <x-avatar name="{{ $comment->user->name }}" class="w-12" />
        <span>{{ $comment->user->name }}</span>
        <span>{{ $comment->created_at }}</span>
    </div>

    <div>
        <p class="text-justify">{{ $comment->content }}</p>
    </div>

    <div class="flex gap-x-2">
        <button id="like-comment-{{ $comment->id }}-button">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                class="size-6 hover:text-red-600 duration-200 {{ $comment->likes()->where('user_id', auth()->id())->count() ? 'text-red-600' : '' }}">
                <path
                    d="m11.645 20.91-.007-.003-.022-.012a15.247 15.247 0 0 1-.383-.218 25.18 25.18 0 0 1-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0 1 12 5.052 5.5 5.5 0 0 1 16.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 0 1-4.244 3.17 15.247 15.247 0 0 1-.383.219l-.022.012-.007.004-.003.001a.752.752 0 0 1-.704 0l-.003-.001Z" />
            </svg>
        </button>
        <span class="comment-likes-count">
            {{ $comment->likes()->count() }}
        </span>
    </div>
</li>

<script>
    $(document).ready(function () {
        $('#like-comment-{{ $comment->id }}-button').on('click', function (e) {
            e.preventDefault();
            
            const button = $(this);
            
            $.ajax({
                url: '/comment/{{ $comment->id }}/like',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    button.siblings('.comment-likes-count').text(response.comment_likes_count);
                    
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
