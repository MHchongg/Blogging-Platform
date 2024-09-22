@props(['blog'])

@php
    if (count($blog->tags) > 0) {
        foreach ($blog->tags as $tag) {
            $tags[] = $tag['name'];
        }

        $tags = implode(',', $tags);
    }
    else {
        $tags = "";
    }
@endphp

<x-layout>
    <div>
        <section>
            <x-section-heading>Edit Blog</x-section-heading>

            <form method="POST" action="/update/{{ $blog->id }}" enctype="multipart/form-data" class="space-y-10">
                @csrf
                @method('PATCH')

                <x-form-field>
                    <x-form-label for="title">Title:</x-form-label>
                    <x-form-input name="title" id="title" type="text" autocomplete="title"
                        placeholder="Blog's Titlte" value="{{ $blog->title }}" required />
                    <x-form-error name="title"></x-form-error>
                </x-form-field>

                <x-form-field>
                    <x-form-label for="content">Content:</x-form-label>
                    <textarea name="content" id="content" class="textarea textarea-bordered bg-white text-black"
                        placeholder="Write something..." required>{{ $blog->content }}</textarea>
                    <x-form-error name="content"></x-form-error>
                </x-form-field>

                <x-form-field>
                    <x-form-label for="tags">Tags (comma separated):</x-form-label>
                    <x-form-input name="tags" id="tags" type="text" autocomplete="tags"
                        placeholder="travel, game, sport" value="{{ $tags }}" />
                    <x-form-error name="tags"></x-form-error>
                </x-form-field>

                <x-form-field>
                    <x-form-label for="image">Image:</x-form-label>
                    <input name="image" id="image" type="file"
                        class="file-input file-input-bordered file-input-info w-full max-w-xs file-input-sm" />
                    <x-form-error name="image"></x-form-error>
                </x-form-field>

                <div class="flex justify-center gap-x-5">
                    <input type="submit" value="Update" class="btn btn-secondary" />
                    <input type="reset" value="Clear" class="btn btn-outline" />
                </div>
            </form>
        </section>
    </div>
</x-layout>
