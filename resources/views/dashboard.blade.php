<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
                <p class="text-gray-600 mt-2">Welcome back, {{ $user->name }}!</p>
            </div>

            <!-- Subscription Info -->
            <div class="bg-white rounded-lg shadow p-6 mb-8">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold">Current Plan:
                            <span class="text-indigo-600">{{ $user->subscriptionPlan->name ?? 'No Plan' }}</span>
                        </h3>
                        <p class="text-gray-600 mt-1">
                            Websites: {{ $user->websites->count() }} / {{ $user->subscriptionPlan->max_websites ?? 0 }}
                        </p>
                    </div>
                    @if ($user->subscriptionPlan && $user->subscriptionPlan->name === 'Free')
                        <a href="#" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                            Upgrade Plan
                        </a>
                    @endif
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Total Issues</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalIssues }}</p>
                        </div>
                        <div class="text-red-500 text-4xl">⚠</div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Critical Issues</p>
                            <p class="text-3xl font-bold text-red-600 mt-2">{{ $criticalIssues }}</p>
                        </div>
                        <div class="text-red-600 text-4xl">🔴</div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Resolved Issues</p>
                            <p class="text-3xl font-bold text-green-600 mt-2">{{ $resolvedIssues }}</p>
                        </div>
                        <div class="text-green-600 text-4xl">✓</div>
                    </div>
                </div>
            </div>

            <!-- Websites Section -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-semibold">Your Websites</h2>
                        @if ($user->canAddWebsite())
                            <a href="{{ route('websites.create') }}"
                                class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                                + Add Website
                            </a>
                        @endif
                    </div>
                </div>

                <div class="p-6">
                    @if ($websites->count() > 0)
                        <div class="space-y-4">
                            @foreach ($websites as $website)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-lg">{{ $website->name }}</h3>
                                            <a href="{{ $website->url }}" target="_blank"
                                                class="text-indigo-600 hover:underline text-sm">
                                                {{ $website->url }}
                                            </a>

                                            @if ($website->latestScan)
                                                <div class="mt-3 flex items-center space-x-4">
                                                    <span class="text-sm text-gray-600">
                                                        Score:
                                                        <span
                                                            class="font-semibold {{ $website->last_scan_score >= 80 ? 'text-green-600' : ($website->last_scan_score >= 50 ? 'text-yellow-600' : 'text-red-600') }}">
                                                            {{ $website->last_scan_score }}/100
                                                        </span>
                                                    </span>
                                                    <span class="text-sm text-gray-600">
                                                        Issues: {{ $website->latestScan->total_issues }}
                                                    </span>
                                                    <span class="text-sm text-gray-600">
                                                        Last scan: {{ $website->last_scanned_at->diffForHumans() }}
                                                    </span>
                                                </div>
                                            @else
                                                <p class="text-sm text-gray-500 mt-2">No scans yet</p>
                                            @endif
                                        </div>

                                        <div class="flex space-x-2">
                                            <form action="{{ route('scans.store', $website) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                                                    Scan Now
                                                </button>
                                            </form>
                                            <a href="{{ route('websites.show', $website) }}"
                                                class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500 mb-4">You haven't added any websites yet.</p>
                            @if ($user->canAddWebsite())
                                <a href="{{ route('websites.create') }}"
                                    class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 inline-block">
                                    Add Your First Website
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
