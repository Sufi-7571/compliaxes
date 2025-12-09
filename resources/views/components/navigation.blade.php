<nav
    class="bg-white/90 backdrop-blur-md shadow-md fixed w-full lg:w-[calc(100%-20rem)] top-0 lg:top-6 z-50 border border-gray-100 lg:mx-40 lg:rounded-2xl">
    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-10">
        <div class="flex justify-between h-18 items-center">
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="CompliAxe Logo" class="h-10 sm:h-14 w-auto">
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-8">
                <div class="relative group">
                    <button class="text-black-800 hover:text-purple-800 transition font-medium flex items-center gap-1">
                        Solutions
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                </div>

                <div class="relative group">
                    <button class="text-black-800 hover:text-purple-800 transition font-medium flex items-center gap-1">
                        Company
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                </div>

                <div class="relative group">
                    <button class="text-black-800 hover:text-purple-800 transition font-medium flex items-center gap-1">
                        Partners
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                </div>

                <div class="relative group">
                    <button class="text-black-800 hover:text-purple-800 transition font-medium flex items-center gap-1">
                        Resources
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                </div>

                <a href="#pricing" class="text-black-800 hover:text-purple-800 transition font-medium">Pricing</a>
            </div>

            <!-- Action Buttons -->
            <div class="hidden lg:flex items-center space-x-3">
                <a href="#login"
                    class="text-gray-800 hover:text-purple-600 transition-all duration-300 font-semibold px-4 py-2 flex items-center gap-2 group">
                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="group-hover:translate-x-0.5 transition-transform duration-300">LOGIN</span>
                </a>

                <a href="#demo"
                    class="text-purple-600 hover:text-purple-800 transition-all duration-300 font-semibold px-4 py-2 flex items-center gap-2 group">
                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:rotate-12" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span class="group-hover:translate-x-0.5 transition-transform duration-300">BOOK A DEMO</span>
                </a>

                <a href="#contact"
                    class="bg-gradient-to-r from-pink-500 to-purple-600 text-white px-6 py-2.5 rounded-xl hover:from-pink-600 hover:to-purple-700 transition-all duration-300 font-semibold flex items-center gap-2 shadow-lg hover:shadow-xl group">
                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <span class="group-hover:translate-x-1 transition-transform duration-300">START FREE TRIAL</span>
                    <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>

            <!-- Mobile menu button -->
            <div class="lg:hidden">
                <button type="button" id="mobile-menu-button"
                    class="text-gray-700 hover:text-purple-600 focus:outline-none p-2">

                    <!-- Modern Hamburger (distinct style) -->
                    <svg id="hamburger-icon" class="h-7 w-7 transition-transform duration-300" fill="none"
                        stroke="currentColor" stroke-width="1.8" stroke-linecap="round" viewBox="0 0 24 24">
                        <path d="M4 7h16" />
                        <path d="M7 12h13" />
                        <path d="M10 17h10" />
                    </svg>

                    <!-- Close Icon -->
                    <svg id="close-icon" class="h-7 w-7 hidden transition-transform duration-300" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" viewBox="0 0 24 24">
                        <path d="M6 6l12 12" />
                        <path d="M6 18L18 6" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden lg:hidden bg-white/95 backdrop-blur-md border-t border-gray-100">
        <div class="px-4 pt-2 pb-4 space-y-2">
            <a href="#solutions"
                class="block px-4 py-3 text-gray-800 hover:bg-purple-50 hover:text-purple-600 rounded-lg transition font-medium">Solutions</a>
            <a href="#company"
                class="block px-4 py-3 text-gray-800 hover:bg-purple-50 hover:text-purple-600 rounded-lg transition font-medium">Company</a>
            <a href="#partners"
                class="block px-4 py-3 text-gray-800 hover:bg-purple-50 hover:text-purple-600 rounded-lg transition font-medium">Partners</a>
            <a href="#resources"
                class="block px-4 py-3 text-gray-800 hover:bg-purple-50 hover:text-purple-600 rounded-lg transition font-medium">Resources</a>
            <a href="#pricing"
                class="block px-4 py-3 text-gray-800 hover:bg-purple-50 hover:text-purple-600 rounded-lg transition font-medium">Pricing</a>

            <div class="border-t border-gray-200 pt-4 space-y-2">
                <a href="#login"
                    class="block px-4 py-3 text-gray-800 hover:bg-purple-50 hover:text-purple-600 rounded-lg transition font-semibold">
                    LOGIN
                </a>
                <a href="#demo"
                    class="block px-4 py-3 text-purple-600 hover:bg-purple-50 rounded-lg transition font-semibold">
                    BOOK A DEMO
                </a>
                <a href="#contact"
                    class="block text-center bg-gradient-to-r from-pink-500 to-purple-600 text-white px-6 py-3 rounded-xl hover:from-pink-600 hover:to-purple-700 transition font-semibold shadow-lg">
                    START FREE TRIAL
                </a>
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const hamburgerIcon = document.getElementById('hamburger-icon');
        const closeIcon = document.getElementById('close-icon');

        menuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
            hamburgerIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            const isClickInside = menuButton.contains(event.target) || mobileMenu.contains(event
            .target);
            if (!isClickInside && !mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.add('hidden');
                hamburgerIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
            }
        });
    });
</script>
