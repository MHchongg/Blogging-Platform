<x-layout>
    <div class="flex flex-col items-center gap-y-14">
        <section class="flex flex-col items-center gap-y-10">
            <x-section-heading>Profile</x-section-heading>

            <x-avatar name="{{ auth()->user()->name }}" class="w-24 text-2xl font-bold" />

            <ul class="text-center text-2xl">
                <li>Name: {{ auth()->user()->name }}</li>
                <li>Email: {{ auth()->user()->email }}</li>
            </ul>
        </section>

        <section class="w-5/6">
            <div role="tablist" class="tabs tabs-bordered">
                <input type="radio" name="my_tabs_1" role="tab" class="tab" aria-label="Your Blogs"
                    checked="checked" />
                <div role="tabpanel" class="tab-content">
                    @foreach ($myBlogs as $blog)
                        <a href="/show/{{ $blog->id }}">
                            <x-card :$blog />
                        </a>
                    @endforeach
                    <div class="mt-8">
                        {{ $myBlogs->appends(['tab' => 'myBlogs'])->links() }}
                    </div>
                </div>

                <input type="radio" name="my_tabs_1" role="tab" class="tab" aria-label="Your Favourites" />
                <div role="tabpanel" class="tab-content">
                    @foreach ($likedBlogs as $blog)
                        <a href="/show/{{ $blog->id }}">
                            <x-card :$blog />
                        </a>
                    @endforeach
                    <div class="mt-8">
                        {{ $likedBlogs->appends(['tab' => 'likedBlogs'])->links() }}
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-layout>

<script>
    const tabs = {
        "Your Blogs": 'myBlogs',
        "Your Favourites": 'likedBlogs',
    };

    $(document).ready(function() {
        $(":input[role='tab']").click(function() {
            const currentURL = new URL(window.location.href);

            let params = new URLSearchParams(currentURL.search);

            params.set('tab', tabs[$(this).attr('aria-label')]);

            const newURL = `${currentURL.pathname}?${params.toString()}`;

            window.history.pushState({}, '', newURL);
        });
    });
</script>
