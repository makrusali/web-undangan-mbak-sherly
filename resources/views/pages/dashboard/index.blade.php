@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Dashboard" />

    <!-- Welcome Section -->
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">
            Welcome back, {{ auth()->user()->name }}!
        </h2>
        <p class="text-gray-600 dark:text-gray-400">
            Here's what's happening with your wedding invitation today.
        </p>
    </div>

    <!-- Suggestions Section -->
    @if(count($suggestions) > 0)
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-3">Suggestions & Alerts</h3>
            <div class="grid grid-cols-1 gap-3">
                @foreach($suggestions as $suggestion)
                    <div class="rounded-lg p-4 {{ 
                        $suggestion['type'] == 'success' ? 'bg-emerald-50 border-l-4 border-emerald-500' : 
                        ($suggestion['type'] == 'warning' ? 'bg-orange-50 border-l-4 border-orange-500' : 
                        'bg-blue-50 border-l-4 border-blue-500') 
                    }} dark:bg-opacity-10">
                        <div class="flex items-start justify-between">
                            <div class="flex items-start gap-3">
                                <div class="mt-0.5">
                                    @if($suggestion['icon'] == 'chat')
                                        <svg class="w-5 h-5 {{ $suggestion['type'] == 'success' ? 'text-emerald-600' : ($suggestion['type'] == 'warning' ? 'text-orange-600' : 'text-blue-600') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                        </svg>
                                    @elseif($suggestion['icon'] == 'users')
                                        <svg class="w-5 h-5 {{ $suggestion['type'] == 'success' ? 'text-emerald-600' : ($suggestion['type'] == 'warning' ? 'text-orange-600' : 'text-blue-600') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    @elseif($suggestion['icon'] == 'calendar')
                                        <svg class="w-5 h-5 {{ $suggestion['type'] == 'success' ? 'text-emerald-600' : ($suggestion['type'] == 'warning' ? 'text-orange-600' : 'text-blue-600') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    @elseif($suggestion['icon'] == 'settings')
                                        <svg class="w-5 h-5 {{ $suggestion['type'] == 'success' ? 'text-emerald-600' : ($suggestion['type'] == 'warning' ? 'text-orange-600' : 'text-blue-600') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    @elseif($suggestion['icon'] == 'globe')
                                        <svg class="w-5 h-5 {{ $suggestion['type'] == 'success' ? 'text-emerald-600' : ($suggestion['type'] == 'warning' ? 'text-orange-600' : 'text-blue-600') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @elseif($suggestion['icon'] == 'chart')
                                        <svg class="w-5 h-5 {{ $suggestion['type'] == 'success' ? 'text-emerald-600' : ($suggestion['type'] == 'warning' ? 'text-orange-600' : 'text-blue-600') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 {{ $suggestion['type'] == 'success' ? 'text-emerald-600' : ($suggestion['type'] == 'warning' ? 'text-orange-600' : 'text-blue-600') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-semibold {{ $suggestion['type'] == 'success' ? 'text-emerald-800' : ($suggestion['type'] == 'warning' ? 'text-orange-800' : 'text-blue-800') }} dark:text-opacity-90">
                                        {{ $suggestion['title'] }}
                                    </h4>
                                    <p class="text-sm {{ $suggestion['type'] == 'success' ? 'text-emerald-700' : ($suggestion['type'] == 'warning' ? 'text-orange-700' : 'text-blue-700') }} dark:text-opacity-75">
                                        {{ $suggestion['message'] }}
                                    </p>
                                </div>
                            </div>
                            @if($suggestion['action'])
                                <a 
                                    href="{{ $suggestion['action']['url'] }}" 
                                    @if(isset($suggestion['action']['onclick'])) onclick="{{ $suggestion['action']['onclick'] }}; return false;" @endif
                                    class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-md {{ 
                                        $suggestion['type'] == 'success' ? 'bg-emerald-600 text-white hover:bg-emerald-700' : 
                                        ($suggestion['type'] == 'warning' ? 'bg-orange-600 text-white hover:bg-orange-700' : 
                                        'bg-blue-600 text-white hover:bg-blue-700') 
                                    }} transition-colors"
                                >
                                    {{ $suggestion['action']['text'] }}
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-5 mb-6 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Wishes Card -->
        <div class="bg-white rounded-2xl border border-gray-200 p-5 dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Total Wishes</span>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $wishesStats['total'] }}</h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center dark:bg-purple-500/10">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                </div>
            </div>
            <div class="flex items-center gap-3 text-sm">
                <span class="text-emerald-600 bg-emerald-100 px-2 py-1 rounded-full dark:bg-emerald-500/20 dark:text-emerald-400">
                    {{ $wishesStats['approved'] }} Approved
                </span>
                <span class="text-orange-600 bg-orange-100 px-2 py-1 rounded-full dark:bg-orange-500/20 dark:text-orange-400">
                    {{ $wishesStats['pending'] }} Pending
                </span>
            </div>
            <div class="mt-3 text-xs text-gray-500">
                {{ $wishesStats['today'] }} today · {{ $wishesStats['thisWeek'] }} this week
            </div>
        </div>

        <!-- Guests Card -->
        <div class="bg-white rounded-2xl border border-gray-200 p-5 dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Total Guests</span>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $guestsStats['total'] }}</h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center dark:bg-blue-500/10">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-3 text-xs text-gray-500">
                Added {{ $guestsStats['today'] }} today · {{ $guestsStats['thisWeek'] }} this week
            </div>
        </div>

        <!-- Invitation Access Card -->
        <div class="bg-white rounded-2xl border border-gray-200 p-5 dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Invitation Accessed</span>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $accessStats['total'] }}</h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center dark:bg-indigo-500/10">
                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="flex items-center gap-3 text-sm">
                <span class="text-indigo-600 bg-indigo-100 px-2 py-1 rounded-full dark:bg-indigo-500/20 dark:text-indigo-400">
                    {{ $accessStats['unique'] }} Unique
                </span>
            </div>
            <div class="mt-3 text-xs text-gray-500">
                {{ $accessStats['today'] }} today · {{ $accessStats['thisWeek'] }} this week
            </div>
        </div>

        <!-- Wedding Events Card -->
        <div class="bg-white rounded-2xl border border-gray-200 p-5 dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Wedding Events</span>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $eventsStats['total'] }}</h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center dark:bg-amber-500/10">
                    <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <div class="flex items-center gap-3 text-sm">
                <span class="text-emerald-600 bg-emerald-100 px-2 py-1 rounded-full dark:bg-emerald-500/20 dark:text-emerald-400">
                    {{ $eventsStats['upcoming'] }} Upcoming
                </span>
                <span class="text-gray-600 bg-gray-100 px-2 py-1 rounded-full dark:bg-gray-700 dark:text-gray-400">
                    {{ $eventsStats['past'] }} Past
                </span>
            </div>
            @if($eventsStats['nextEvent'])
                <div class="mt-3 text-xs">
                    <span class="text-gray-500">Next: </span>
                    <span class="font-medium text-gray-700 dark:text-gray-300">{{ $eventsStats['nextEvent']->name }}</span>
                    <span class="text-gray-500"> · {{ $eventsStats['nextEvent']->formatted_date_time }}</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Charts Section - Fixed height -->
    <div class="grid grid-cols-1 gap-5 mb-6 lg:grid-cols-2">
        <!-- Wishes Chart -->
        <div class="bg-white rounded-2xl border border-gray-200 p-5 dark:bg-gray-800 dark:border-gray-700">
            <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Wishes Received (Last 7 Days)</h4>
            <div style="height: 250px; position: relative;">
                <canvas id="wishesChart"></canvas>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-2xl border border-gray-200 p-5 dark:bg-gray-800 dark:border-gray-700">
            <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Recent Wishes</h4>
            <div class="space-y-4 max-h-[250px] overflow-y-auto">
                @forelse($recentWishes->take(5) as $wish)
                    <div class="flex items-start gap-3 pb-3 border-b border-gray-100 dark:border-gray-700 last:border-0">
                        <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center flex-shrink-0 dark:bg-purple-500/20">
                            <span class="text-sm font-medium text-purple-600 dark:text-purple-400">
                                {{ substr($wish->name, 0, 1) }}
                            </span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-800 dark:text-white truncate">
                                {{ $wish->name }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                {{ \Str::limit($wish->message, 50) }}
                            </p>
                            <p class="text-xs text-gray-400 mt-1">
                                {{ $wish->created_at->diffForHumans() }}
                                @if($wish->is_approved)
                                    <span class="text-emerald-500 ml-2">✓ Approved</span>
                                @else
                                    <span class="text-orange-500 ml-2">⏳ Pending</span>
                                @endif
                            </p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 text-center py-4">No wishes yet</p>
                @endforelse
            </div>
            <div class="mt-4 text-right">
                <a href="{{ route('panel.wishes.index') }}" class="text-sm text-brand-600 hover:underline">
                    View all wishes →
                </a>
            </div>
        </div>
    </div>

    <!-- Access Analytics Section -->
    <div class="grid grid-cols-1 gap-5 mb-6 lg:grid-cols-2">
        <!-- Device Stats -->
        <div class="bg-white rounded-2xl border border-gray-200 p-5 dark:bg-gray-800 dark:border-gray-700">
            <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Access by Device</h4>
            <div class="space-y-3">
                @php
                    $deviceStats = $accessStats['byDevice'];
                    $totalDevices = array_sum($deviceStats);
                    $deviceColors = [
                        'desktop' => 'blue',
                        'mobile' => 'green',
                        'tablet' => 'purple',
                    ];
                @endphp
                @if($totalDevices > 0)
                    @foreach($deviceStats as $device => $count)
                        @php $percentage = round(($count / $totalDevices) * 100); @endphp
                        <div>
                            <div class="flex items-center justify-between text-sm mb-1">
                                <span class="text-gray-700 dark:text-gray-300 capitalize">{{ $device }}</span>
                                <span class="text-gray-600 dark:text-gray-400">{{ $count }} ({{ $percentage }}%)</span>
                            </div>
                            <div class="w-full h-2 bg-gray-200 rounded-full dark:bg-gray-700">
                                <div class="h-2 bg-{{ $deviceColors[$device] ?? 'gray' }}-500 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-sm text-gray-500 text-center py-4">No access data yet</p>
                @endif
            </div>
        </div>

        <!-- Browser Stats -->
        <div class="bg-white rounded-2xl border border-gray-200 p-5 dark:bg-gray-800 dark:border-gray-700">
            <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Access by Browser</h4>
            <div class="space-y-3">
                @php
                    $browserStats = $accessStats['byBrowser'];
                    $totalBrowsers = array_sum($browserStats);
                    $browserColors = [
                        'Chrome' => 'green',
                        'Firefox' => 'orange',
                        'Safari' => 'blue',
                        'Edge' => 'indigo',
                        'Internet Explorer' => 'red',
                    ];
                @endphp
                @if($totalBrowsers > 0)
                    @foreach($browserStats as $browser => $count)
                        @php $percentage = round(($count / $totalBrowsers) * 100); @endphp
                        <div>
                            <div class="flex items-center justify-between text-sm mb-1">
                                <span class="text-gray-700 dark:text-gray-300">{{ $browser }}</span>
                                <span class="text-gray-600 dark:text-gray-400">{{ $count }} ({{ $percentage }}%)</span>
                            </div>
                            <div class="w-full h-2 bg-gray-200 rounded-full dark:bg-gray-700">
                                <div class="h-2 bg-{{ $browserColors[$browser] ?? 'gray' }}-500 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-sm text-gray-500 text-center py-4">No access data yet</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Hourly Access Chart - Fixed height -->
    <div class="grid grid-cols-1 gap-5 mb-6">
        <div class="bg-white rounded-2xl border border-gray-200 p-5 dark:bg-gray-800 dark:border-gray-700">
            <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Today's Access by Hour</h4>
            @if(array_sum($accessStats['hourly']) > 0)
                <div style="height: 200px; position: relative;">
                    <canvas id="hourlyChart"></canvas>
                </div>
            @else
                <p class="text-sm text-gray-500 text-center py-4">No access data for today</p>
            @endif
        </div>
    </div>

    <!-- Recent Invitation Accesses -->
    <div class="grid grid-cols-1 gap-5 mb-6">
        <div class="bg-white rounded-2xl border border-gray-200 p-5 dark:bg-gray-800 dark:border-gray-700">
            <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Recent Invitation Accesses</h4>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Time</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">IP Address</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Device</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Browser</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Platform</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($recentAccesses as $access)
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $access->created_at->format('H:i:s') }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-800 dark:text-white">{{ $access->ip_address }}</td>
                                <td class="px-4 py-3 text-sm capitalize text-gray-600 dark:text-gray-400">{{ $access->device_type }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $access->browser }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $access->platform }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-sm text-gray-500">
                                    No accesses yet
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <a href="{{ route('panel.guests.create') }}" class="bg-white rounded-2xl border border-gray-200 p-5 hover:shadow-lg transition-shadow dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-brand-100 flex items-center justify-center dark:bg-brand-500/20">
                    <svg class="w-6 h-6 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800 dark:text-white">Add Guest</h4>
                    <p class="text-sm text-gray-500">Create new guest</p>
                </div>
            </div>
        </a>

        <a href="{{ route('panel.wedding-events.create') }}" class="bg-white rounded-2xl border border-gray-200 p-5 hover:shadow-lg transition-shadow dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center dark:bg-amber-500/20">
                    <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800 dark:text-white">Add Event</h4>
                    <p class="text-sm text-gray-500">Create wedding event</p>
                </div>
            </div>
        </a>

        <a href="{{ route('panel.invitation-settings.index') }}" class="bg-white rounded-2xl border border-gray-200 p-5 hover:shadow-lg transition-shadow dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center dark:bg-emerald-500/20">
                    <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800 dark:text-white">Invitation Settings</h4>
                    <p class="text-sm text-gray-500">Configure invitation</p>
                </div>
            </div>
        </a>

        <a href="#" onclick="copyInvitationLink()" class="bg-white rounded-2xl border border-gray-200 p-5 hover:shadow-lg transition-shadow dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center dark:bg-indigo-500/20">
                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800 dark:text-white">Copy Link</h4>
                    <p class="text-sm text-gray-500">Share invitation</p>
                </div>
            </div>
        </a>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Wishes Chart
        const wishesCtx = document.getElementById('wishesChart');
        if (wishesCtx) {
            new Chart(wishesCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($wishesChartData['labels']) !!},
                    datasets: [{
                        label: 'Wishes',
                        data: {!! json_encode($wishesChartData['data']) !!},
                        borderColor: '#8B5CF6',
                        backgroundColor: 'rgba(139, 92, 246, 0.1)',
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#8B5CF6',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                precision: 0,
                                callback: function(value) {
                                    if (Number.isInteger(value)) {
                                        return value;
                                    }
                                }
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)',
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

        // Hourly Access Chart
        @if(array_sum($accessStats['hourly']) > 0)
        const hourlyCtx = document.getElementById('hourlyChart');
        if (hourlyCtx) {
            new Chart(hourlyCtx, {
                type: 'bar',
                data: {
                    labels: Array.from({length: 24}, (_, i) => i + ':00'),
                    datasets: [{
                        label: 'Accesses',
                        data: {!! json_encode(array_values($accessStats['hourly'])) !!},
                        backgroundColor: '#6366F1',
                        borderRadius: 4,
                        barPercentage: 0.7,
                        categoryPercentage: 0.8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                precision: 0,
                                callback: function(value) {
                                    if (Number.isInteger(value)) {
                                        return value;
                                    }
                                }
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)',
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                maxRotation: 45,
                                minRotation: 45,
                                font: {
                                    size: 10
                                }
                            }
                        }
                    }
                }
            });
        }
        @endif
    });

    // Copy invitation link function
    function copyInvitationLink() {
        // Replace with your actual invitation URL
        const invitationUrl = '{{ url("/invitation") }}';
        
        navigator.clipboard.writeText(invitationUrl).then(function() {
            Swal.fire({
                icon: 'success',
                title: 'Copied!',
                text: 'Invitation link copied to clipboard',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000
            });
        }).catch(function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to copy link',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000
            });
        });
    }
</script>
@endpush