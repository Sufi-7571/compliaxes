<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Add New Website</h1>
                <p class="text-gray-600 mt-2">Enter your website details to start scanning for accessibility issues.</p>
            </div>

            <div class="bg-white rounded-lg shadow-md p-8">
                <form action="{{ route('websites.store') }}" method="POST">
                    @csrf

                    <div class="mb-6">
                        <label for="name" class="block text-gray-700 font-semibold mb-2">Website Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-600 focus:border-transparent"
                            placeholder="My Awesome Website">
                        @error('name')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="url" class="block text-gray-700 font-semibold mb-2">Website URL *</label>
                        <input type="url" id="url" name="url" value="{{ old('url') }}" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-600 focus:border-transparent"
                            placeholder="https://example.com">
                        @error('url')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                        <p class="text-sm text-gray-500 mt-2">Enter the full URL including https://</p>
                    </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <p class="text-sm text-blue-800">
                            <strong>Note:</strong> After adding your website, you can run an accessibility scan to
                            detect WCAG compliance issues.
                        </p>
                    </div>

                    <div class="flex space-x-4">
                        <button type="submit"
                            class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 font-semibold">
                            Add Website
                        </button>
                        <a href="{{ route('websites.index') }}"
                            class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400 font-semibold">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
