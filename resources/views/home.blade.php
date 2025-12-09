<x-app-layout>
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-5xl font-bold mb-6">Web Accessibility Tailored for Your Business</h1>
                <p class="text-xl mb-8">Expert-driven. AI-powered.</p>
                <div class="flex justify-center space-x-4">
                    <a href="#contact"
                        class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">Book
                        a Demo</a>
                    <a href="#pricing"
                        class="bg-transparent border-2 border-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-indigo-600 transition">Start
                        Free Trial</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="text-indigo-600 text-4xl mb-4">✓</div>
                    <h3 class="text-xl font-semibold mb-2">ADA & EAA Compliance</h3>
                    <p class="text-gray-600">WCAG 2.1 AA-based remediation for legal compliance</p>
                </div>
                <div class="text-center">
                    <div class="text-indigo-600 text-4xl mb-4">⚙</div>
                    <h3 class="text-xl font-semibold mb-2">Customizable</h3>
                    <p class="text-gray-600">Solutions & plans designed to fit every business type</p>
                </div>
                <div class="text-center">
                    <div class="text-indigo-600 text-4xl mb-4">🚀</div>
                    <h3 class="text-xl font-semibold mb-2">Heavy-lifting on us</h3>
                    <p class="text-gray-600">Quick to implement, we take care of the rest</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center mb-12">Our Services</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach ($services as $service)
                    <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition">
                        <h3 class="text-xl font-semibold mb-3">{{ $service->title }}</h3>
                        <p class="text-gray-600">{{ $service->description }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center mb-12">Plans Customized to Fit Your Needs</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                @foreach ($plans as $plan)
                    <div
                        class="border rounded-lg p-6 {{ $plan->is_popular ? 'border-indigo-600 shadow-xl' : 'border-gray-200' }}">
                        @if ($plan->is_popular)
                            <span class="bg-indigo-600 text-white px-3 py-1 rounded-full text-sm">Recommended</span>
                        @endif
                        <h3 class="text-2xl font-bold mt-4">{{ $plan->name }}</h3>
                        <p class="text-4xl font-bold my-4">
                            @if ($plan->price > 0)
                                ${{ number_format($plan->price) }}
                            @else
                                Custom
                            @endif
                        </p>
                        @if ($plan->price > 0)
                            <p class="text-gray-600 mb-6">/{{ $plan->billing_period }}</p>
                        @endif
                        <ul class="space-y-3 mb-6">
                            @foreach ($plan->features as $feature)
                                <li class="flex items-start">
                                    <span class="text-green-500 mr-2">✓</span>
                                    <span class="text-gray-700">{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <a href="#contact"
                            class="block text-center bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 transition">Get
                            Started</a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center mb-12">What Our Clients Say</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach ($testimonials as $testimonial)
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <p class="text-gray-700 mb-4">"{{ $testimonial->testimonial_text }}"</p>
                        <div class="flex items-center">
                            <div>
                                <p class="font-semibold">{{ $testimonial->client_name }}</p>
                                <p class="text-sm text-gray-600">{{ $testimonial->client_position }},
                                    {{ $testimonial->company_name }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

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
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-600 focus:border-transparent">
                    @error('full_name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Business Email *</label>
                    <input type="email" name="email" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-600 focus:border-transparent">
                    @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Phone Number *</label>
                    <input type="text" name="phone" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-600 focus:border-transparent">
                    @error('phone')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Website Link</label>
                    <input type="url" name="website"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-600 focus:border-transparent">
                    @error('website')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Message</label>
                    <textarea name="message" rows="4"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-600 focus:border-transparent"></textarea>
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
                    class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">Schedule
                    a Demo</button>
            </form>
        </div>
    </section>
</x-app-layout>
