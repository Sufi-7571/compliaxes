<x-guest-layout>

    <x-slot:title>CompliAxe - Login</x-slot:title>

    <div class="min-h-screen flex">
        <!-- Left Section -->
        <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-12 bg-white">
            <div class="w-full max-w-md">

                <div class="text-center mb-8">
                    <img src="{{ asset('images/logo.png') }}" alt="CompliAxe Logo" class="h-16 mx-auto mb-4">
                    <h2
                        class="text-3xl font-bold bg-gradient-to-r from-pink-500 to-purple-600 bg-clip-text text-transparent">
                        Welcome Back</h2>
                    <p class="text-gray-600 mt-2">We are pleased to see you!</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="email" :value="__('Email')" class="text-gray-800 font-semibold" />
                        <x-text-input id="email"
                            class="block mt-2 w-full px-4 py-3 border-gray-300 rounded-xl focus:border-purple-500 focus:ring-purple-500 transition"
                            type="email" name="email" :value="old('email')" required autofocus
                            autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password" :value="__('Password')" class="text-gray-800 font-semibold" />
                        <x-text-input id="password"
                            class="block mt-2 w-full px-4 py-3 border-gray-300 rounded-xl focus:border-purple-500 focus:ring-purple-500 transition"
                            type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox"
                                class="rounded border-gray-300 text-purple-600 shadow-sm 
                                        focus:outline-none focus:ring-0 focus:ring-offset-0"
                                name="remember">

                            <span class="ms-2 text-sm text-gray-600 font-medium">{{ __('Remember me') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm text-purple-600 hover:text-purple-800 font-semibold transition"
                                href="{{ route('password.request') }}">
                                {{ __('Forgot password?') }}
                            </a>
                        @endif
                    </div>

                    <x-primary-button
                        class="w-full justify-center bg-gradient-to-r from-pink-500 to-purple-600 
                                hover:from-pink-600 hover:to-purple-700 text-white font-semibold 
                                py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300
                                focus:outline-none focus:ring-0 active:outline-none active:ring-0">
                        {{ __('Log in') }}
                    </x-primary-button>

                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">Don't have an account? <a href="{{ route('register') }}"
                            class="text-purple-600 hover:text-purple-800 font-semibold">Register Here</a></p>
                </div>
            </div>
        </div>

        <!-- Right Section -->
        <div
            class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-purple-50 to-pink-50 items-center justify-center p-12">
            <div class="max-w-lg">
                <div id="lottie-animation" class="w-full"></div>
                <div class="mt-8 text-center">
                    <h2 class="text-2xl font-bold text-black-800 mb-4">ADA & WCAG Compliant</h2>
                    <p class="text-black-800">Ensuring web accessibility for all users with comprehensive compliance
                        standards.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.12.2/lottie.min.js"></script>
    <script>
        const animation = lottie.loadAnimation({
            container: document.getElementById('lottie-animation'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: '{{ asset('lotties/login.json') }}'
        });
    </script>
</x-guest-layout>
