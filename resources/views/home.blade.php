<x-app-layout>

    <!-- Hero Section -->
    <section
        class="bg-gradient-to-br from-pink-500 via-purple-600 to-purple-700 text-white py-60 relative overflow-hidden"
        style="margin-top: -65px">

        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-20 left-10 w-72 h-72 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-pink-300 rounded-full blur-3xl"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center">
                <div class="inline-block mb-4 px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm font-semibold">
                    ADA & WCAG Compliance Made Easy
                </div>
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold mb-6 leading-tight">
                    Web Accessibility<br>
                    <span class="block bg-gradient-to-r from-yellow-200 to-pink-200 bg-clip-text text-transparent mt-3">
                        Tailored for Your Business
                    </span>
                </h1>
                <p class="text-xl md:text-2xl mb-12 text-white/90 font-medium max-w-3xl mx-auto">
                    Expert-driven. AI-powered. Effortlessly compliant.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4 sm:space-x-4">
                    <a href="#contact"
                        class="group bg-white text-purple-600 px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-50 transition-all duration-300 shadow-2xl hover:shadow-3xl hover:scale-105 flex items-center justify-center gap-2">
                        <svg class="w-6 h-6 transition-transform duration-300 group-hover:rotate-12" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                            </path>
                        </svg>
                        Book a Demo
                        <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                    <a href="{{ route('register') }}" target="_blank"
                        class="group bg-white/10 backdrop-blur-md border-2 border-white/50 px-8 py-4 rounded-xl font-bold text-lg hover:bg-white hover:text-purple-600 transition-all duration-300 shadow-xl hover:shadow-2xl hover:scale-105 flex items-center justify-center gap-2">
                        <svg class="w-6 h-6 transition-transform duration-300 group-hover:scale-110" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Start Free Trial
                    </a>
                </div>
                <p class="mt-8 text-white/80 text-sm">✓ No credit card required • ✓ 14-day free trial • ✓ Cancel anytime
                </p>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-24 bg-gradient-to-b from-white to-purple-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Why Choose <span
                        class="bg-gradient-to-br from-pink-600 to-purple-800 bg-clip-text text-transparent">
                        CompliAxe?
                    </span></h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Comprehensive accessibility solutions that protect
                    your business and empower your users</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <div
                    class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                    <div
                        class="bg-gradient-to-br from-pink-500 to-purple-600 w-16 h-16 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-gray-900">ADA & EAA Compliance</h3>
                    <p class="text-gray-600 leading-relaxed">WCAG 2.1 AA-based remediation ensuring full legal
                        compliance and protection from accessibility lawsuits</p>
                </div>

                <div
                    class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                    <div
                        class="bg-gradient-to-br from-purple-500 to-pink-600 w-16 h-16 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-gray-900">Fully Customizable</h3>
                    <p class="text-gray-600 leading-relaxed">Flexible solutions and tailored plans designed to perfectly
                        fit every business type and size</p>
                </div>

                <div
                    class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                    <div
                        class="bg-gradient-to-br from-pink-600 to-purple-500 w-16 h-16 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-gray-900">We Do The Heavy Lifting</h3>
                    <p class="text-gray-600 leading-relaxed">Lightning-fast implementation with ongoing support, Focus
                        on
                        your business while we handle compliance</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Our <span
                        class="bg-gradient-to-br from-pink-600 to-purple-800 bg-clip-text text-transparent">
                        Services
                    </span></h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Comprehensive accessibility solutions designed to
                    meet your specific needs</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($services as $service)
                    <div
                        class="group bg-gradient-to-br from-white to-purple-50 p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-purple-100 relative overflow-hidden">

                        <div
                            class="absolute inset-0 bg-gradient-to-br from-pink-500/5 to-purple-600/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>

                        <div class="relative z-10">
                            <div
                                class="w-14 h-14 bg-gradient-to-br from-pink-500 to-purple-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>

                            <h3
                                class="text-2xl font-bold mb-4 text-gray-900 group-hover:text-purple-600 transition-colors duration-300">
                                {{ $service->title }}</h3>
                            <p class="text-gray-600 leading-relaxed mb-4">{{ $service->description }}</p>

                            <div
                                class="flex items-center text-purple-600 font-semibold group-hover:gap-2 transition-all duration-300">
                                <span>Learn more</span>
                                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform duration-300"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-24 bg-gradient-to-b from-purple-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Plans <span
                        class="bg-gradient-to-br from-pink-600 to-purple-800 bg-clip-text text-transparent">
                        Customized
                    </span> to Fit Your Needs</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Choose the perfect plan for your business and start
                    your accessibility journey today</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($plans as $plan)
                    <div
                        class="relative bg-white rounded-2xl p-8 transition-all duration-300 hover:-translate-y-2 {{ $plan->is_popular ? 'border-2 border-purple-600 shadow-2xl scale-105' : 'border border-gray-200 shadow-lg hover:shadow-xl' }}">
                        @if ($plan->is_popular)
                            <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                                <span
                                    class="whitespace-nowrap bg-gradient-to-r from-pink-500 to-purple-600 text-white px-12 py-2 rounded-full text-sm font-bold shadow-lg">
                                    Most Popular
                                </span>
                            </div>
                        @endif

                        <div class="text-center mb-6">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $plan->name }}</h3>
                            <div class="mt-4">
                                @if ($plan->price > 0)
                                    <span
                                        class="text-5xl font-extrabold bg-gradient-to-r from-pink-500 to-purple-600 bg-clip-text text-transparent">${{ number_format($plan->price) }}</span>
                                    <span class="text-gray-600 text-lg">/{{ $plan->billing_period }}</span>
                                @else
                                    <span
                                        class="text-5xl font-extrabold bg-gradient-to-r from-pink-500 to-purple-600 bg-clip-text text-transparent">Custom</span>
                                @endif
                            </div>
                        </div>

                        <ul class="space-y-4 mb-8">
                            @foreach ($plan->features as $feature)
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0 mt-0.5" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-gray-700">{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <a href="#contact"
                            class="group block text-center font-bold py-4 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl {{ $plan->is_popular ? 'bg-gradient-to-r from-pink-500 to-purple-600 text-white hover:from-pink-600 hover:to-purple-700' : 'bg-gray-900 text-white hover:bg-gray-800' }}">
                            <span class="flex items-center justify-center gap-2">
                                Get Started
                                <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </span>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-12">
                <p class="text-gray-600">All plans include 14-day free trial • No credit card required • Cancel anytime
                </p>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-24 bg-gradient-to-b from-white to-purple-50 relative overflow-hidden">

        <div class="absolute top-20 right-0 w-72 h-72 bg-pink-200 rounded-full blur-3xl opacity-20"></div>
        <div class="absolute bottom-20 left-0 w-72 h-72 bg-purple-200 rounded-full blur-3xl opacity-20"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <div
                    class="inline-block mb-4 px-4 py-2 bg-gradient-to-r from-pink-500 to-purple-600 text-white rounded-full text-sm font-semibold">
                    Client Success Stories
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">What Our <span
                        class="bg-gradient-to-br from-pink-600 to-purple-800 bg-clip-text text-transparent">
                        Clients
                    </span> Say</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">See how we've helped businesses achieve full
                    accessibility compliance</p>
            </div>


            <div class="relative max-w-4xl mx-auto">
                <div class="overflow-hidden">
                    <div id="testimonials-slider" class="flex transition-transform duration-500 ease-in-out">
                        @foreach ($testimonials as $index => $testimonial)
                            <div class="w-full flex-shrink-0 px-4">
                                <div
                                    class="group bg-white p-10 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-purple-100 relative">

                                    <div
                                        class="absolute top-6 right-6 w-16 h-16 bg-gradient-to-br from-pink-500 to-purple-600 rounded-full flex items-center justify-center opacity-10 group-hover:opacity-20 transition-opacity">
                                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z">
                                            </path>
                                        </svg>
                                    </div>

                                    <div class="mb-8">

                                        <div class="flex gap-1 mb-6">
                                            @for ($i = 0; $i < 5; $i++)
                                                <svg class="w-6 h-6 text-yellow-400" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                    </path>
                                                </svg>
                                            @endfor
                                        </div>

                                        <p class="text-gray-700 text-xl leading-relaxed italic">
                                            "{{ $testimonial->testimonial_text }}"</p>
                                    </div>

                                    <div class="flex items-center gap-4 pt-6 border-t border-gray-100">
                                        <!-- Avatar -->
                                        <div
                                            class="w-16 h-16 bg-gradient-to-br from-pink-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-2xl">
                                            {{ substr($testimonial->client_name, 0, 1) }}
                                        </div>

                                        <div>
                                            <p class="font-bold text-gray-900 text-xl">{{ $testimonial->client_name }}
                                            </p>
                                            <p class="text-sm text-gray-600">{{ $testimonial->client_position }}</p>
                                            <p class="text-sm font-semibold text-purple-600">
                                                {{ $testimonial->company_name }}</p>
                                        </div>

                                        <!-- Verified Badge -->
                                        <div
                                            class="ml-auto flex items-center gap-1 text-green-600 text-xs font-semibold">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            Verified
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>


                <button id="prev-btn"
                    class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 lg:-translate-x-16 w-14 h-14 bg-white rounded-full shadow-xl flex items-center justify-center text-purple-600 hover:bg-gradient-to-r hover:from-pink-500 hover:to-purple-600 hover:text-white transition-all duration-300 hover:scale-110 z-10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                </button>

                <button id="next-btn"
                    class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 lg:translate-x-16 w-14 h-14 bg-white rounded-full shadow-xl flex items-center justify-center text-purple-600 hover:bg-gradient-to-r hover:from-pink-500 hover:to-purple-600 hover:text-white transition-all duration-300 hover:scale-110 z-10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                        </path>
                    </svg>
                </button>


                <div class="flex justify-center gap-3 mt-10">
                    @foreach ($testimonials as $index => $testimonial)
                        <button
                            class="slider-dot w-3 h-3 rounded-full transition-all duration-300 {{ $index === 0 ? 'bg-gradient-to-r from-pink-500 to-purple-600 w-8' : 'bg-gray-300 hover:bg-gray-400' }}"
                            data-index="{{ $index }}"></button>
                    @endforeach
                </div>
            </div>

            <!-- CTA Banner -->
            <div class="mt-16 bg-gradient-to-r from-pink-500 to-purple-600 rounded-2xl p-8 text-center shadow-2xl">
                <h3 class="text-3xl font-bold text-white mb-4">Ready to Join Our Happy Clients?</h3>
                <p class="text-white/90 text-lg mb-6">Start your accessibility journey today with a 14-day free trial
                </p>
                <a href="#contact"
                    class="inline-flex items-center gap-2 bg-white text-purple-600 px-8 py-4 rounded-xl font-bold hover:bg-gray-100 transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105">
                    Get Started Now
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slider = document.getElementById('testimonials-slider');
            const prevBtn = document.getElementById('prev-btn');
            const nextBtn = document.getElementById('next-btn');
            const dots = document.querySelectorAll('.slider-dot');
            const totalSlides = {{ count($testimonials) }};
            let currentSlide = 0;

            function updateSlider() {
                slider.style.transform = `translateX(-${currentSlide * 100}%)`;

                dots.forEach((dot, index) => {
                    if (index === currentSlide) {
                        dot.classList.add('bg-gradient-to-r', 'from-pink-500', 'to-purple-600', 'w-8');
                        dot.classList.remove('bg-gray-300', 'w-3');
                    } else {
                        dot.classList.remove('bg-gradient-to-r', 'from-pink-500', 'to-purple-600', 'w-8');
                        dot.classList.add('bg-gray-300', 'w-3');
                    }
                });
            }

            prevBtn.addEventListener('click', () => {
                currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                updateSlider();
            });

            nextBtn.addEventListener('click', () => {
                currentSlide = (currentSlide + 1) % totalSlides;
                updateSlider();
            });

            dots.forEach(dot => {
                dot.addEventListener('click', () => {
                    currentSlide = parseInt(dot.dataset.index);
                    updateSlider();
                });
            });

            // Auto-slide
            setInterval(() => {
                currentSlide = (currentSlide + 1) % totalSlides;
                updateSlider();
            }, 5000);
        });
    </script>

    <!-- Contact Section -->
    <section id="contact" class="py-16 bg-white">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center mb-12">Talk to an Accessibility Expert</h2>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-gray-700 mb-2">Full Name *</label>
                    <input type="text" name="full_name" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                    @error('full_name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Business Email *</label>
                    <input type="email" name="email" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                    @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Phone Number *</label>
                    <input type="text" name="phone" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                    @error('phone')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Website Link</label>
                    <input type="url" name="website"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                    @error('website')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Message</label>
                    <textarea name="message" rows="4"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-600 focus:border-transparent"></textarea>
                </div>
                <div>
                    <label class="flex items-start">
                        <input type="checkbox" name="is_agency" value="1" class="mt-1 mr-2">
                        <span class="text-gray-700">My agency is seeking web accessibility solutions for clients</span>
                    </label>
                </div>
                <div>
                    <label class="flex items-start">
                        <input type="checkbox" name="consent" required class="mt-1 mr-2">
                        <span class="text-gray-700">I consent to receiving marketing communications *</span>
                    </label>
                    @error('consent')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit"
                    class="w-full bg-gradient-to-r from-pink-500 to-purple-600 text-white py-3 rounded-lg font-semibold hover:from-pink-600 hover:to-purple-700 transition">Schedule
                    a Demo</button>
            </form>
        </div>
    </section>

    <!-- Get Audit Section -->
    <section class="py-24 bg-gradient-to-br from-purple-600 via-pink-500 to-purple-700 relative overflow-hidden">

        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 left-20 w-64 h-64 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-20 w-96 h-96 bg-pink-300 rounded-full blur-3xl"></div>
            <div
                class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-purple-300 rounded-full blur-3xl">
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-12">
                <div
                    class="inline-block mb-4 px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm font-semibold text-white">
                    Free Accessibility Audit
                </div>
                <h2 class="text-4xl md:text-5xl font-extrabold text-white mb-6">
                    Is Your Website <span
                        class="bg-gradient-to-r from-yellow-200 to-pink-200 bg-clip-text text-transparent">ADA
                        Compliant?</span>
                </h2>
                <p class="text-xl text-white/90 max-w-2xl mx-auto">Get a comprehensive accessibility audit report in
                    minutes. Enter your website URL below to discover compliance issues and recommendations.</p>
            </div>

            <!-- Audit Form -->
            <div class="bg-white rounded-2xl shadow-2xl p-2 md:p-2">
                <form action="" method="POST" class="flex gap-4 items-center">
                    @csrf

                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9
                      c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9
                      m-9 9a9 9 0 019-9"></path>
                            </svg>
                        </div>

                        <input type="url" id="website_url" name="website_url"
                            placeholder="https://www.yourwebsite.com" required
                            class="w-full pl-14 pr-4 py-5 text-lg border-2 border-black-700 rounded-2xl 
                   focus:border-purple-500 focus:ring-100 focus:ring-purple-100 
                   transition-all duration-300 outline-none">
                    </div>

                    <button type="submit"
                        class="bg-gradient-to-r from-pink-500 to-purple-600 text-white font-bold 
               px-8 py-5 rounded-2xl whitespace-nowrap shadow-xl 
               hover:from-pink-600 hover:to-purple-700 
               transition-all duration-300 hover:shadow-2xl hover:scale-105 flex items-center gap-3">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2
                  0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0
                  012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                        Get Free Audit
                    </button>
                </form>


            </div>

            <!-- Stats -->
            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6 text-center text-white">
                <div>
                    <p class="text-5xl font-extrabold mb-2">10,000+</p>
                    <p class="text-lg text-white/90">Websites Audited</p>
                </div>
                <div>
                    <p class="text-5xl font-extrabold mb-2">98%</p>
                    <p class="text-lg text-white/90">Compliance Rate</p>
                </div>
                <div>
                    <p class="text-5xl font-extrabold mb-2">24/7</p>
                    <p class="text-lg text-white/90">Expert Support</p>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
