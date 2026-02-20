<x-guest-layout>
  <div class="w-full max-w-3xl">
    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden ring-1 ring-black/5">
      <div class="grid md:grid-cols-2">
        {{-- Accent / branding side (hidden on small screens) --}}
        <div class="hidden md:flex flex-col items-center justify-center gap-4 bg-gradient-to-br from-indigo-600 to-blue-500 p-10 text-white">
          <x-jet-authentication-card-logo class="w-14 h-14" />
          <h2 class="text-2xl font-semibold tracking-tight" style="color:black !important;">Forgot Password</h2>
          <p class="text-white/90 text-sm leading-6 text-center" style="color:black !important;">
            We’ll email you a link to reset your password. It only takes a moment.
          </p>
        </div>

        {{-- Form side --}}
        <div class="p-8 md:p-10">
          <div class="md:hidden mb-6 text-center">
            <x-jet-authentication-card-logo class="mx-auto w-12 h-12" />
            <h1 class="mt-3 text-xl font-semibold text-gray-900" style="color:black !important;">Forgot Password</h1>
            <p class="mt-2 text-sm text-gray-600">
              Enter your email and we’ll send you a reset link.
            </p>
          </div>

          @if (session('status'))
            <div class="mb-4 rounded-lg bg-green-50 text-green-800 px-4 py-3 text-sm">
              {{ session('status') }}
            </div>
          @endif

          <x-jet-validation-errors class="mb-4" />

          <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            <div>
              <x-jet-label for="email" value="{{ __('Email address') }}" class="text-gray-800" />
              <x-jet-input
                id="email"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                class="mt-2 w-full"
                placeholder="you@company.com"
              />
            </div>

            <div class="space-y-3">
              <x-jet-button class="w-full justify-center" style="margin-top:15px;">
                {{ __('Email Password Reset Link') }}
              </x-jet-button>

              <a href="{{ route('login') }}"
                 class="block text-center text-sm text-gray-600 hover:text-gray-900">
                Back to sign in
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>

    <p class="mt-6 text-center text-xs text-gray-500">
      If you don’t see the email in a few minutes, check your spam folder.
    </p>
  </div>
</x-guest-layout>
