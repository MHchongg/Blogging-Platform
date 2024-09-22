<x-layout>
    <div>
        <section>
            <x-section-heading>Login</x-section-heading>

            <form method="POST" action="/login" class="space-y-10">
                @csrf
                <x-form-field>
                    <x-form-label for="email">Email:</x-form-label>
                    <x-form-input name="email" id="email" type="email" autocomplete="email" placeholder="Your Email"
                        :value="old('email')" required />
                    <x-form-error name="email"></x-form-error>
                </x-form-field>

                <x-form-field>
                    <x-form-label for="password">Password:</x-form-label>
                    <x-form-input name="password" id="password" type="password" autocomplete="password"
                        placeholder="Your Password" required />
                    <x-form-error name="password"></x-form-error>
                </x-form-field>

                <div class="flex justify-center gap-x-5">
                    <input type="submit" value="Log In" class="btn btn-secondary" />
                    <input type="reset" value="Clear" class="btn btn-outline" />
                </div>
            </form>
        </section>
    </div>
</x-layout>
