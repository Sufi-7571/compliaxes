<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Scan Details</h1>
                    <p class="text-gray-600 mt-2">{{ $scan->website->name }} -
                        {{ $scan->created_at->format('M d, Y H:i') }}</p>
                </div>
                <a href="{{ route('websites.show', $scan->website) }}"
                    class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700">
                    Back to Website
                </a>
            </div>

            <!-- Scan Summary -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-6 gap-6">
                    <div class="text-center">
                        <p class="text-gray-600 text-sm mb-2">Status</p>
                        <span
                            class="px-3 py-1 rounded-full text-xs font-semibold
                            {{ $scan->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $scan->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $scan->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $scan->status === 'failed' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ ucfirst($scan->status) }}
                        </span>
                    </div>
                    <div class="text-center">
                        <p class="text-gray-600 text-sm mb-2">Score</p>
                        <p
                            class="text-3xl font-bold {{ $scan->accessibility_score >= 80 ? 'text-green-600' : ($scan->accessibility_score >= 50 ? 'text-yellow-600' : 'text-red-600') }}">
                            {{ $scan->accessibility_score ?? '-' }}
                        </p>
                    </div>
                    <div class="text-center">
                        <p class="text-gray-600 text-sm mb-2">Total Issues</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $scan->total_issues }}</p>
                    </div>
                    <div class="text-center">
                        <p class="text-gray-600 text-sm mb-2">Critical</p>
                        <p class="text-3xl font-bold text-red-600">{{ $scan->critical_issues }}</p>
                    </div>
                    <div class="text-center">
                        <p class="text-gray-600 text-sm mb-2">Moderate</p>
                        <p class="text-3xl font-bold text-yellow-600">{{ $scan->moderate_issues }}</p>
                    </div>
                    <div class="text-center">
                        <p class="text-gray-600 text-sm mb-2">Minor</p>
                        <p class="text-3xl font-bold text-blue-600">{{ $scan->minor_issues }}</p>
                    </div>
                </div>
            </div>

            <!-- Issues List -->
            <div class="bg-white rounded-lg shadow-md">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold">Issues Found</h2>
                </div>

                @if ($issues->count() > 0)
                    <div class="divide-y divide-gray-200">
                        @foreach ($issues as $issue)
                            <div class="p-6 hover:bg-gray-50">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-3 mb-2">
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-semibold
                                        {{ $issue->severity === 'critical' ? 'bg-red-100 text-red-800' : '' }}
                                        {{ $issue->severity === 'moderate' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $issue->severity === 'minor' ? 'bg-blue-100 text-blue-800' : '' }}">
                                                {{ ucfirst($issue->severity) }}
                                            </span>
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                                                WCAG {{ $issue->wcag_level }} - {{ $issue->wcag_rule }}
                                            </span>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $issue->description }}
                                        </h3>
                                        <p class="text-sm text-gray-600 mb-2">
                                            <strong>Page:</strong> {{ $issue->page_url }}
                                        </p>
                                    </div>
                                </div>

                                @if ($issue->element_html)
                                    <div class="mb-3">
                                        <p class="text-sm font-semibold text-gray-700 mb-1">Element:</p>
                                        <pre class="bg-gray-100 p-3 rounded text-xs overflow-x-auto">{{ $issue->element_html }}</pre>
                                    </div>
                                @endif

                                @if (auth()->user()->subscriptionPlan && auth()->user()->subscriptionPlan->fix_suggestions)
                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                        <p class="text-sm font-semibold text-blue-900 mb-2">💡 Fix Suggestion:</p>
                                        <p class="text-sm text-blue-800 mb-3">{{ $issue->fix_suggestion }}</p>

                                        @if ($issue->code_before && $issue->code_after)
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <p class="text-xs font-semibold text-gray-700 mb-1">Before:</p>
                                                    <pre class="bg-white p-2 rounded text-xs overflow-x-auto border">{{ $issue->code_before }}</pre>
                                                </div>
                                                <div>
                                                    <p class="text-xs font-semibold text-gray-700 mb-1">After:</p>
                                                    <pre class="bg-white p-2 rounded text-xs overflow-x-auto border border-green-300">{{ $issue->code_after }}</pre>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                        <p class="text-sm text-yellow-800">
                                            🔒 Upgrade to Basic or Pro plan to see fix suggestions and code examples.
                                        </p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="p-6">
                        {{ $issues->links() }}
                    </div>
                @else
                    <div class="p-12 text-center">
                        <p class="text-green-600 text-lg font-semibold">🎉 No issues found!</p>
                        <p class="text-gray-600 mt-2">Your website passed all accessibility checks.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
