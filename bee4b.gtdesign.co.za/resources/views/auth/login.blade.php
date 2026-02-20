<x-guest-layout>
    <div class="grid grid-cols-2">
        <div class="bg-[url('/assets/logo/Login_Background.png')] bg-center">

        </div>
        <x-jet-authentication-card>
            <x-slot name="logo">
                <img src="{{asset('/assets/logo/Main_Logo_Dark.png')}}" width="300px" alt="BEE4Business Logo">
                <!-- <x-jet-authentication-card-logo /> -->
            </x-slot>

            <x-jet-validation-errors class="mb-4" />

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <x-jet-input id="email" class="block mt-1 w-full text-center" type="email" name="email" :value="old('email')" placeholder="Email Address" required autofocus />
                </div>

                <div class="mt-4">
                    <x-jet-input id="password" class="block mt-1 w-full text-center" type="password" name="password" placeholder="Password" required autocomplete="current-password" />
                </div>

                <div class="block mt-4">
{{--                    <input type="checkbox" id="popi" name="popi" />--}}
{{--                    <div>Popi checkbox</div>--}}
                     <label for="popi" class="flex items-center">
                        <x-jet-checkbox id="popi" name="popi" />
                        <span class="ml-2 text-sm text-gray-600">{{ __('By signing in, you agree to our privacy policy and POPIA compliance policies.') }}</span>
                    </label>
                </div>

                {{-- <div class="block mt-4">
                    <label for="remember_me" class="flex items-center">
                        <x-jet-checkbox id="remember_me" name="remember" />
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div> --}}

                <div class="flex items-center justify-end mt-4">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-jet-button class="ml-4">
                        {{ __('Log in') }}
                    </x-jet-button>
                </div>
            </form>
        </x-jet-authentication-card>
    </div>
</x-guest-layout>
