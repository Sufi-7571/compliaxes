<nav
    class="bg-white/90 backdrop-blur-md shadow-md fixed 
            w-[calc(100%-2rem)] mx-4 rounded-lg    <!-- Mobile/Tablet -->
            xl:w-[calc(100%-20rem)] xl:mx-40 xl:rounded-2xl  <!-- Desktop -->
            top-6 z-50 border border-gray-100">

    <div class="max-w-8xl mx-auto px-4 sm:px-6 xl:px-10">
        <div class="flex justify-between h-18 items-center">
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="CompliAxe Logo" class="h-10 sm:h-14 w-auto">
                </a>
            </div>

            <!-- Desktop Navigation - Shows on XL screens and above -->
            <div class="hidden xl:flex items-center space-x-8">
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

            <!-- Desktop Action Buttons - Shows on XL screens and above -->
            <div class="hidden xl:flex items-center space-x-3">
                <a href="{{ route('login') }}" target="_blank"
                    class="text-gray-800 hover:text-purple-600 transition-all duration-300 font-semibold px-4 py-2 flex items-center gap-2 group">
                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="group-hover:translate-x-0.5 transition-transform duration-300">LOGIN</span>
                </a>

<!-- Desktop version (inside the xl:flex block) -->
<button type="button" onclick="openDemoModal()"
        class="text-purple-600 hover:text-purple-800 transition-all duration-300 font-semibold px-4 py-2 flex items-center gap-2 group cursor-pointer">
    <svg class="w-5 h-5 transition-transform duration-300 group-hover:rotate-12" fill="none"
         stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
    </svg>
    <span class="group-hover:translate-x-0.5 transition-transform duration-300">BOOK A DEMO</span>
</button>

                <a href="{{ route('register') }}" target="_blank"
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

            <!-- Mobile menu button - Shows on screens smaller than XL -->
            <div class="xl:hidden">
                <button type="button" id="mobile-menu-button"
                    class="text-black-800 hover:text-purple-800 focus:outline-none p-2 relative">

                    <div class="w-7 h-7 flex flex-col justify-center items-center gap-1.5 transition-all duration-300">
                        <span id="line1"
                            class="block w-6 h-0.5 bg-current transition-all duration-300 ease-in-out"></span>
                        <span id="line2"
                            class="block w-5 h-0.5 bg-current transition-all duration-300 ease-in-out"></span>
                        <span id="line3"
                            class="block w-4 h-0.5 bg-current transition-all duration-300 ease-in-out"></span>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu - Shows on screens smaller than XL -->
    <div id="mobile-menu"
        class="hidden xl:hidden bg-white/95 backdrop-blur-md border border-gray-100 
           mt-4 mx-0 rounded-2xl shadow-md absolute w-full left-0 top-12 z-40">

        <div class="px-4 pt-2 pb-4 space-y-2">

            <a href="#solutions"
                class="block px-4 py-3 text-black-800 hover:bg-purple-50 hover:text-purple-600 
                   rounded-lg transition font-medium">
                Solutions
            </a>

            <a href="#company"
                class="block px-4 py-3 text-black-800 hover:bg-purple-50 hover:text-purple-600 
                   rounded-lg transition font-medium">
                Company
            </a>

            <a href="#partners"
                class="block px-4 py-3 text-black-800 hover:bg-purple-50 hover:text-purple-600 
                   rounded-lg transition font-medium">
                Partners
            </a>

            <a href="#resources"
                class="block px-4 py-3 text-black-800 hover:bg-purple-50 hover:text-purple-600 
                   rounded-lg transition font-medium">
                Resources
            </a>

            <a href="#pricing"
                class="block px-4 py-3 text-black-800 hover:bg-purple-50 hover:text-purple-600 
                   rounded-lg transition font-medium">
                Pricing
            </a>

            <div class="border-t border-gray-200 pt-4 space-y-2">

                <a href="#login"
                    class="flex items-center justify-center gap-2 px-4 py-3 
                       text-black-800 hover:bg-purple-50 hover:text-purple-600 
                       rounded-lg transition font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    LOGIN
                </a>

                <a href="#demo"
                    class="flex items-center justify-center gap-2 px-4 py-3 
                       text-purple-600 hover:bg-purple-50 rounded-lg 
                       transition font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    BOOK A DEMO
                </a>

                <a href="#contact"
                    class="flex items-center justify-center gap-2 bg-gradient-to-r 
                       from-pink-500 to-purple-600 text-white px-6 py-3 
                       rounded-xl hover:from-pink-600 hover:to-purple-700 
                       transition font-semibold shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
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
        const line1 = document.getElementById('line1');
        const line2 = document.getElementById('line2');
        const line3 = document.getElementById('line3');
        let isOpen = false;

        menuButton.addEventListener('click', function() {
            isOpen = !isOpen;

            // Toggle menu
            mobileMenu.classList.toggle('hidden');

            if (isOpen) {
                line1.style.transform = 'rotate(45deg) translateY(6px)';
                line1.style.width = '24px';
                line2.style.opacity = '0';
                line2.style.transform = 'translateX(10px)';
                line3.style.transform = 'rotate(-45deg) translateY(-6px)';
                line3.style.width = '24px';
            } else {
                line1.style.transform = 'rotate(0) translateY(0)';
                line1.style.width = '24px';
                line2.style.opacity = '1';
                line2.style.transform = 'translateX(0)';
                line3.style.transform = 'rotate(0) translateY(0)';
                line3.style.width = '16px';
            }
        });

        document.addEventListener('click', function(event) {
            const isClickInside = menuButton.contains(event.target) || mobileMenu.contains(event
                .target);
            if (!isClickInside && !mobileMenu.classList.contains('hidden')) {
                isOpen = false;
                mobileMenu.classList.add('hidden');

                // Reset hamburger animation
                line1.style.transform = 'rotate(0) translateY(0)';
                line1.style.width = '24px';
                line2.style.opacity = '1';
                line2.style.transform = 'translateX(0)';
                line3.style.transform = 'rotate(0) translateY(0)';
                line3.style.width = '16px';
            }
        });

        // Close menu when clicking on a link
        const mobileLinks = mobileMenu.querySelectorAll('a');
        mobileLinks.forEach(link => {
            link.addEventListener('click', function() {
                isOpen = false;
                mobileMenu.classList.add('hidden');

                // Reset hamburger animation
                line1.style.transform = 'rotate(0) translateY(0)';
                line1.style.width = '24px';
                line2.style.opacity = '1';
                line2.style.transform = 'translateX(0)';
                line3.style.transform = 'rotate(0) translateY(0)';
                line3.style.width = '16px';
            });
        });
    });
</script>
