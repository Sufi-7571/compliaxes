<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $website->name }}</h1>
                    <a href="{{ $website->url }}" target="_blank" class="text-indigo-600 hover:underline">
                        {{ $website->url }}
                    </a>
                </div>
                <div class="flex space-x-3">
                    <form action="{{ route('scans.store', $website) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                            Scan Now
                        </button>
                    </form>
                    <a href="{{ route('websites.index') }}"
                        class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700">
                        Back to Websites
                    </a>
                </div>
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

            <!-- Latest Scan Summary -->
            @if ($website->latestScan)
                <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                    <h2 class="text-xl font-semibold mb-4">Latest Scan Summary</h2>
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                        <div class="text-center">
                            <p class="text-gray-600 text-sm mb-2">Accessibility Score</p>
                            <p
                                class="text-4xl font-bold {{ $website->last_scan_score >= 80 ? 'text-green-600' : ($website->last_scan_score >= 50 ? 'text-yellow-600' : 'text-red-600') }}">
                                {{ $website->last_scan_score }}
                            </p>
                        </div>
                        <div class="text-center">
                            <p class="text-gray-600 text-sm mb-2">Total Issues</p>
                            <p class="text-4xl font-bold text-gray-900">{{ $website->latestScan->total_issues }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-gray-600 text-sm mb-2">Critical</p>
                            <p class="text-4xl font-bold text-red-600">{{ $website->latestScan->critical_issues }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-gray-600 text-sm mb-2">Moderate</p>
                            <p class="text-4xl font-bold text-yellow-600">{{ $website->latestScan->moderate_issues }}
                            </p>
                        </div>
                        <div class="text-center">
                            <p class="text-gray-600 text-sm mb-2">Minor</p>
                            <p class="text-4xl font-bold text-blue-600">{{ $website->latestScan->minor_issues }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Scan History -->
            <div class="bg-white rounded-lg shadow-md">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold">Scan History</h2>
                </div>

                @if ($scans->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Score
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total
                                        Issues</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Critical
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pages
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($scans as $scan)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            {{ $scan->created_at->format('M d, Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-semibold
                                        {{ $scan->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $scan->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $scan->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $scan->status === 'failed' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ ucfirst($scan->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($scan->accessibility_score !== null)
                                                <span
                                                    class="font-semibold {{ $scan->accessibility_score >= 80 ? 'text-green-600' : ($scan->accessibility_score >= 50 ? 'text-yellow-600' : 'text-red-600') }}">
                                                    {{ $scan->accessibility_score }}
                                                </span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $scan->total_issues }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600 font-semibold">
                                            {{ $scan->critical_issues }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $scan->total_pages }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if ($scan->status === 'completed')
                                                <a href="{{ route('scans.show', $scan) }}"
                                                    class="text-indigo-600 hover:underline">
                                                    View Details
                                                </a>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="p-6">
                        {{ $scans->links() }}
                    </div>
                @else
                    <div class="p-12 text-center">
                        <p class="text-gray-500 mb-4">No scans available yet.</p>
                        <form action="{{ route('scans.store', $website) }}" method="POST" class="inline-block">
                            @csrf
                            <button type="submit"
                                class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700">
                                Run First Scan
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
