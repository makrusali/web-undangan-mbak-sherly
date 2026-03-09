<?php

namespace App\Http\Controllers;

use App\Models\Wish;
use App\Models\Guest;
use App\Models\WeddingEvent;
use App\Models\InvitationSetting;
use App\Models\InvitationAccess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Wishes Statistics
        $wishesStats = [
            'total' => Wish::count(),
            'approved' => Wish::where('is_approved', true)->count(),
            'pending' => Wish::where('is_approved', false)->count(),
            'today' => Wish::whereDate('created_at', today())->count(),
            'thisWeek' => Wish::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'thisMonth' => Wish::whereMonth('created_at', now()->month)->count(),
        ];

        // Recent wishes (last 10)
        $recentWishes = Wish::latest()->take(10)->get();

        // Guest Statistics (without access tracking)
        $guestsStats = [
            'total' => Guest::count(),
            'today' => Guest::whereDate('created_at', today())->count(),
            'thisWeek' => Guest::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'thisMonth' => Guest::whereMonth('created_at', now()->month)->count(),
        ];

        // Invitation Access Statistics
        $accessStats = [
            'total' => InvitationAccess::getTotalAccessCount(),
            'unique' => InvitationAccess::getUniqueVisitorsCount(),
            'today' => InvitationAccess::getTodayAccessCount(),
            'thisWeek' => InvitationAccess::getWeekAccessCount(),
            'thisMonth' => InvitationAccess::getMonthAccessCount(),
            'byDevice' => InvitationAccess::getStatsByDevice(),
            'byBrowser' => InvitationAccess::getStatsByBrowser(),
            'byPlatform' => InvitationAccess::getStatsByPlatform(),
            'hourly' => InvitationAccess::getHourlyStats(),
            'daily' => InvitationAccess::getDailyStats(7),
        ];

        // Recent invitation accesses
        $recentAccesses = InvitationAccess::latest()->take(10)->get();

        // Wedding Events Statistics
        $eventsStats = [
            'total' => WeddingEvent::count(),
            'upcoming' => WeddingEvent::where('date', '>=', now()->toDateString())->count(),
            'past' => WeddingEvent::where('date', '<', now()->toDateString())->count(),
            'nextEvent' => WeddingEvent::where('date', '>=', now()->toDateString())
                ->orderBy('date')
                ->orderBy('time_start')
                ->first(),
        ];

        // Invitation Settings
        $invitationSetting = InvitationSetting::first();

        // Chart data for wishes (last 7 days)
        $wishesChartData = $this->getWishesChartData();

        // Suggestions based on data
        $suggestions = $this->generateSuggestions($wishesStats, $guestsStats, $accessStats, $eventsStats, $invitationSetting);

        return view('pages.dashboard.index', compact(
            'wishesStats',
            'recentWishes',
            'guestsStats',
            'accessStats',
            'recentAccesses',
            'eventsStats',
            'invitationSetting',
            'wishesChartData',
            'suggestions'
        ));
    }

    private function getWishesChartData()
    {
        $data = [];
        $labels = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $labels[] = $date->format('D, M d');

            $count = Wish::whereDate('created_at', $date)->count();
            $data[] = $count;
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    private function generateSuggestions($wishesStats, $guestsStats, $accessStats, $eventsStats, $invitationSetting)
    {
        $suggestions = [];

        // Wishes suggestions
        if ($wishesStats['pending'] > 0) {
            $suggestions[] = [
                'type' => 'warning',
                'icon' => 'chat',
                'title' => 'Pending Wishes',
                'message' => "You have {$wishesStats['pending']} pending wish(es) waiting for approval.",
                'action' => [
                    'text' => 'Review Wishes',
                    'url' => route('panel.wishes.index', ['filter' => 'pending'])
                ]
            ];
        }

        if ($wishesStats['total'] == 0) {
            $suggestions[] = [
                'type' => 'info',
                'icon' => 'chat',
                'title' => 'No Wishes Yet',
                'message' => 'Share your invitation link to start receiving wishes from guests.',
                'action' => [
                    'text' => 'Copy Invitation Link',
                    'url' => '#',
                    'onclick' => 'copyInvitationLink()'
                ]
            ];
        }

        // Guest suggestions (updated without access tracking)
        if ($guestsStats['total'] == 0) {
            $suggestions[] = [
                'type' => 'info',
                'icon' => 'users',
                'title' => 'No Guests Added',
                'message' => 'Start by adding guests to your invitation list.',
                'action' => [
                    'text' => 'Add Guests',
                    'url' => route('panel.guests.create')
                ]
            ];
        }

        // Invitation access suggestions
        if ($accessStats['total'] > 0 && $guestsStats['total'] > 0) {
            $ratio = round(($accessStats['unique'] / $guestsStats['total']) * 100);

            if ($ratio < 30) {
                $suggestions[] = [
                    'type' => 'info',
                    'icon' => 'globe',
                    'title' => 'Low Invitation Views',
                    'message' => "Only {$ratio}% of your guests have viewed the invitation. Consider sending reminders.",
                    'action' => [
                        'text' => 'View Guests',
                        'url' => route('panel.guests.index')
                    ]
                ];
            } elseif ($ratio > 80) {
                $suggestions[] = [
                    'type' => 'success',
                    'icon' => 'globe',
                    'title' => 'Great Engagement!',
                    'message' => "{$ratio}% of your guests have viewed the invitation. Excellent!",
                    'action' => null
                ];
            }
        }

        if ($accessStats['total'] > 100) {
            $suggestions[] = [
                'type' => 'success',
                'icon' => 'chart',
                'title' => 'Popular Invitation',
                'message' => "Your invitation has been accessed {$accessStats['total']} times! Great engagement.",
                'action' => null
            ];
        }

        // Wedding event suggestions
        if ($eventsStats['total'] == 0) {
            $suggestions[] = [
                'type' => 'warning',
                'icon' => 'calendar',
                'title' => 'No Wedding Events',
                'message' => 'Add wedding events to display on your invitation.',
                'action' => [
                    'text' => 'Add Event',
                    'url' => route('panel.wedding-events.create')
                ]
            ];
        }

        if ($eventsStats['nextEvent']) {
            $daysUntil = now()->startOfDay()->diffInDays(Carbon::parse($eventsStats['nextEvent']->date), false);

            if ($daysUntil <= 7 && $daysUntil >= 0) {
                $suggestions[] = [
                    'type' => 'success',
                    'icon' => 'calendar',
                    'title' => 'Wedding Approaching',
                    'message' => "Your {$eventsStats['nextEvent']->name} is in {$daysUntil} day(s)!",
                    'action' => [
                        'text' => 'View Event',
                        'url' => route('panel.wedding-events.show', $eventsStats['nextEvent'])
                    ]
                ];
            } elseif ($daysUntil < 0) {
                $suggestions[] = [
                    'type' => 'info',
                    'icon' => 'calendar',
                    'title' => 'Event Passed',
                    'message' => "Your {$eventsStats['nextEvent']->name} has passed. Hope it was wonderful!",
                    'action' => null
                ];
            }
        }

        // Invitation settings suggestions
        if (!$invitationSetting) {
            $suggestions[] = [
                'type' => 'warning',
                'icon' => 'settings',
                'title' => 'Invitation Not Configured',
                'message' => 'Complete your invitation settings to personalize your wedding page.',
                'action' => [
                    'text' => 'Configure Now',
                    'url' => route('panel.invitation-settings.index')
                ]
            ];
        } else {
            $missingFields = [];
            if (!$invitationSetting->hero_image) $missingFields[] = 'Hero Image';
            if (!$invitationSetting->groom_fullname) $missingFields[] = 'Groom Name';
            if (!$invitationSetting->bride_fullname) $missingFields[] = 'Bride Name';
            if (!$invitationSetting->love_story) $missingFields[] = 'Love Story';
            if (!$invitationSetting->invitation_text) $missingFields[] = 'Invitation Text';

            if (!empty($missingFields)) {
                $suggestions[] = [
                    'type' => 'info',
                    'icon' => 'settings',
                    'title' => 'Incomplete Settings',
                    'message' => 'Missing: ' . implode(', ', array_slice($missingFields, 0, 3)) . (count($missingFields) > 3 ? '...' : ''),
                    'action' => [
                        'text' => 'Complete Settings',
                        'url' => route('panel.invitation-settings.index')
                    ]
                ];
            }
        }

        // Weekly report suggestion (on Mondays)
        if (now()->dayOfWeek == Carbon::MONDAY) {
            $suggestions[] = [
                'type' => 'info',
                'icon' => 'chart',
                'title' => 'Weekly Report',
                'message' => "Last week: {$wishesStats['thisWeek']} new wishes, {$accessStats['thisWeek']} invitation views.",
                'action' => null
            ];
        }

        // Performance tip
        if ($accessStats['byDevice'] && isset($accessStats['byDevice']['mobile']) && $accessStats['byDevice']['mobile'] > 0) {
            $mobilePercentage = round(($accessStats['byDevice']['mobile'] / $accessStats['total']) * 100);
            if ($mobilePercentage > 60) {
                $suggestions[] = [
                    'type' => 'info',
                    'icon' => 'globe',
                    'title' => 'Mobile Friendly',
                    'message' => "{$mobilePercentage}% of your visitors use mobile devices. Your invitation looks great on mobile!",
                    'action' => null
                ];
            }
        }

        return $suggestions;
    }
}
