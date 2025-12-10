<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">My Websites</h1>
                @if (auth()->user()->canAddWebsite())
                    <a href="{{ route('websites.create') }}"
                        class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                        + Add Website
                    </a>
                @endif
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            @if ($websites->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ($websites as $website)
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-xl font-semibold">{{ $website->name }}</h3>
                                    <a href="{{ $website->url }}" target="_blank"
                                        class="text-indigo-600 hover:underline text-sm">
                                        {{ $website->url }}
                                    </a>
                                </div>
                                <span
                                    class="px-3 py-1 rounded-full text-sm {{ $website->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($website->status) }}
                                </span>
                            </div>

                            @if ($website->latestScan)
                                <div class="mb-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm text-gray-600">Accessibility Score</span>
                                        <span
                                            class="text-2xl font-bold {{ $website->last_scan_score >= 80 ? 'text-green-600' : ($website->last_scan_score >= 50 ? 'text-yellow-600' : 'text-red-600') }}">
                                            {{ $website->last_scan_score }}
                                        </span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="h-2 rounded-full {{ $website->last_scan_score >= 80 ? 'bg-green-600' : ($website->last_scan_score >= 50 ? 'bg-yellow-600' : 'bg-red-600') }}"
                                            style="width: {{ $website->last_scan_score }}%">
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-3 gap-4 mb-4 text-sm">
                                    <div class="text-center">
                                        <p class="text-gray-600">Total</p>
                                        <p class="font-semibold text-lg">{{ $website->latestScan->total_issues }}</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-gray-600">Critical</p>
                                        <p class="font-semibold text-lg text-red-600">
                                            {{ $website->latestScan->critical_issues }}</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-gray-600">Pages</p>
                                        <p class="font-semibold text-lg">{{ $website->latestScan->total_pages }}</p>
                                    </div>
                                </div>

                                <p class="text-xs text-gray-500 mb-4">Last scanned:
                                    {{ $website->last_scanned_at->diffForHumans() }}</p>
                            @else
                                <div class="mb-4 text-center py-8 bg-gray-50 rounded">
                                    <p class="text-gray-500">No scans yet</p>
                                </div>
                            @endif

                            <div class="flex space-x-2">
                                <form action="{{ route('scans.store', $website) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit"
                                        class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">
                                        Scan Now
                                    </button>
                                </form>
                                <a href="{{ route('websites.show', $website) }}"
                                    class="flex-1 bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700 text-center">
                                    View Details
                                </a>
                                <form action="{{ route('websites.destroy', $website) }}" method="POST"
                                    onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-lg shadow p-12 text-center">
                    <p class="text-gray-500 text-lg mb-4">You haven't added any websites yet.</p>
                    @if (auth()->user()->canAddWebsite())
                        <a href="{{ route('websites.create') }}"
                            class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 inline-block">
                            Add Your First Website
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
