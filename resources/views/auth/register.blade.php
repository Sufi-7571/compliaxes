<x-guest-layout>

    <x-slot:title>CompliAxe - Register</x-slot:title>

    <div class="min-h-screen flex">
        <!-- Left Section - Lottie Animation -->
        <div
            class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-pink-50 to-purple-50 items-center justify-center p-12">
            <div class="max-w-lg">
                <div id="lottie-animation" class="w-full"></div>
                <div class="mt-8 text-center">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Join CompliAxe Today</h3>
                    <p class="text-gray-600">Start your journey towards complete web accessibility compliance with our
                        comprehensive solutions.</p>
                </div>
            </div>
        </div>

        <!-- Right Section - Register Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-12 bg-white">
            <div class="w-full max-w-md">
                <!-- Logo -->
                <div class="text-center mb-8">
                    <img src="{{ asset('images/logo.png') }}" alt="CompliAxe Logo" class="h-16 mx-auto mb-4">
                    <h2
                        class="text-3xl font-bold bg-gradient-to-r from-pink-500 to-purple-600 bg-clip-text text-transparent">
                        Create Account</h2>
                    <p class="text-gray-600 mt-2">Get started with your free account</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Full Name')" class="text-gray-800 font-semibold" />
                        <x-text-input id="name"
                            class="block mt-2 w-full px-4 py-3 border-gray-300 rounded-xl focus:border-purple-500 focus:ring-purple-500 transition"
                            type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email Address')" class="text-gray-800 font-semibold" />
                        <x-text-input id="email"
                            class="block mt-2 w-full px-4 py-3 border-gray-300 rounded-xl focus:border-purple-500 focus:ring-purple-500 transition"
                            type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" class="text-gray-800 font-semibold" />
                        <x-text-input id="password"
                            class="block mt-2 w-full px-4 py-3 border-gray-300 rounded-xl focus:border-purple-500 focus:ring-purple-500 transition"
                            type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')"
                            class="text-gray-800 font-semibold" />
                        <x-text-input id="password_confirmation"
                            class="block mt-2 w-full px-4 py-3 border-gray-300 rounded-xl focus:border-purple-500 focus:ring-purple-500 transition"
                            type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <x-primary-button
                        class="w-full justify-center bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-600 hover:to-purple-700 text-white font-semibold py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 mt-6">
                        {{ __('Create Account') }}
                    </x-primary-button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">Already have an account? <a href="{{ route('login') }}"
                            class="text-purple-600 hover:text-purple-800 font-semibold">Sign in</a></p>
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
            path: '{{ asset("lotties/welcome.json") }}'
        });
    </script>
</x-guest-layout>
