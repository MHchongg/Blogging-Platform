<x-layout>
    <div>
        <section>
            <x-section-heading>Register</x-section-heading>

            <form method="POST" action="/register" class="space-y-10">
                @csrf
                <x-form-field>
                    <x-form-label for="name">Name:</x-form-label>
                    <x-form-input name="name" id="name" type="text" autocomplete="name" placeholder="Your Name"
                        :value="old('name')" required />
                    <x-form-error name="name"></x-form-error>
                </x-form-field>

                <x-form-field>
                    <x-form-label for="email">Email:</x-form-label>
                    <x-form-input name="email" id="email" type="email" autocomplete="email"
                        placeholder="Your Email" :value="old('email')" required />
                    <x-form-error name="email"></x-form-error>
                </x-form-field>

                <x-form-field>
                    <x-form-label for="password">Password:</x-form-label>
                    <x-form-input name="password" id="password" type="password" autocomplete="password"
                        placeholder="Your Password" required />
                    <x-form-error name="password"></x-form-error>
                </x-form-field>

                <x-form-field>
                    <x-form-label for="password_confirmation">Confirm Password:</x-form-label>
                    <x-form-input name="password_confirmation" id="password_confirmation" type="password"
                        autocomplete="password_confirmation" placeholder="Confirm Your Password" required />
                    <x-form-error name="password_confirmation"></x-form-error>
                </x-form-field>

                <div class="flex justify-center gap-x-5">
                    <input type="submit" value="Register" class="btn btn-secondary" />
                    <input type="reset" value="Clear" class="btn btn-outline" />
                </div>
            </form>
        </section>
    </div>
</x-layout>
