<div id="book-demo-modal"
    class="fixed inset-0 z-[9999] hidden flex items-center justify-center px-4 sm:px-6 lg:px-8 overflow-y-auto"
    aria-labelledby="modal-title" role="dialog" aria-modal="true">

    <div class="absolute inset-0 bg-black/60 backdrop-blur-md transition-opacity"></div>

    <div class="relative w-full max-w-2xl my-8">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden transform transition-all">

            <div
                class="relative bg-gradient-to-br from-pink-500 via-purple-600 to-purple-700 px-10 pt-12 pb-8 overflow-hidden">

                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-pink-300/20 rounded-full blur-2xl"></div>

                <button type="button" onclick="closeDemoModal()"
                    class="absolute top-6 right-6 text-white/80 hover:text-white hover:bg-white/20 rounded-full p-2.5 transition-all duration-300 hover:rotate-90 z-10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <div class="relative z-10 text-center">
                    <h3 class="text-4xl font-extrabold text-white mb-3">Book Your Free Demo</h3>
                    <p class="text-xl text-white/90">See CompliAxe in action and discover how we make compliance
                        effortless</p>
                </div>
            </div>

            <!-- Form -->
            <form method="POST" action="" class="px-10 pb-10 pt-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-2">First Name *</label>
                        <input type="text" name="first_name" required placeholder="John"
                            class="w-full px-4 py-3.5 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-2">Last Name *</label>
                        <input type="text" name="last_name" required placeholder="Doe"
                            class="w-full px-4 py-3.5 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all outline-none">
                    </div>
                </div>

                <div class="mt-5">
                    <label class="block text-sm font-bold text-gray-900 mb-2">Work Email *</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <input type="email" name="email" required placeholder="john@company.com"
                            class="w-full pl-12 pr-4 py-3.5 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all outline-none">
                    </div>
                </div>

                <div class="mt-5">
                    <label class="block text-sm font-bold text-gray-900 mb-2">Company Name *</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                        <input type="text" name="company" required placeholder="Acme Inc."
                            class="w-full pl-12 pr-4 py-3.5 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-5">
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-2">Company Size *</label>
                        <select name="company_size" required
                            class="w-full px-4 py-3.5 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all outline-none appearance-none bg-white cursor-pointer">
                            <option value="">Select size</option>
                            <option>1-10 employees</option>
                            <option>11-50 employees</option>
                            <option>51-200 employees</option>
                            <option>201-500 employees</option>
                            <option>500+ employees</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-2">Your Role *</label>
                        <select name="role" required
                            class="w-full px-4 py-3.5 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all outline-none appearance-none bg-white cursor-pointer">
                            <option value="">Select role</option>
                            <option>Compliance Officer</option>
                            <option>Legal Counsel</option>
                            <option>CEO / Founder</option>
                            <option>Operations Manager</option>
                            <option>IT Manager</option>
                            <option>Other</option>
                        </select>
                    </div>
                </div>

                <div class="mt-8">
                    <button type="submit"
                        class="group w-full bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-600 hover:to-purple-700 text-white font-bold py-5 rounded-xl shadow-2xl hover:shadow-3xl transform hover:scale-[1.02] transition-all duration-300 flex items-center justify-center gap-3 text-lg">
                        <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span>Schedule My Free Demo</span>
                        <svg class="w-5 h-5 group-hover:translate-x-2 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </button>
                </div>

                <!-- Trust Indicators -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="flex items-center justify-center gap-6 text-sm text-gray-600">
                        <p class="text-center text-md text-black-500 mt-6">
                            No commitment • 15 minutes • Personalized walkthrough
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openDemoModal() {
        document.getElementById('book-demo-modal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeDemoModal() {
        document.getElementById('book-demo-modal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    document.getElementById('book-demo-modal')?.addEventListener('click', e => {
        if (e.target === e.currentTarget) closeDemoModal();
    });

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && !document.getElementById('book-demo-modal').classList.contains('hidden')) {
            closeDemoModal();
        }
    });
</script>
