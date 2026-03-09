<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvitationAccess extends Model
{
    protected $fillable = [
        'ip_address',
        'user_agent',
        'referer',
        'device_type',
        'browser',
        'platform',
        'country',
        'city',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get device type from user agent
     */
    public static function getDeviceType($userAgent)
    {
        if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $userAgent)) {
            return 'tablet';
        }

        if (preg_match('/(mobile|iphone|ipod|android|blackberry|opera mini|iemobile)/i', $userAgent)) {
            return 'mobile';
        }

        return 'desktop';
    }

    /**
     * Get browser from user agent
     */
    public static function getBrowser($userAgent)
    {
        if (strpos($userAgent, 'Chrome') !== false && strpos($userAgent, 'Edg') === false) {
            return 'Chrome';
        } elseif (strpos($userAgent, 'Safari') !== false && strpos($userAgent, 'Chrome') === false) {
            return 'Safari';
        } elseif (strpos($userAgent, 'Firefox') !== false) {
            return 'Firefox';
        } elseif (strpos($userAgent, 'Edg') !== false) {
            return 'Edge';
        } elseif (strpos($userAgent, 'MSIE') !== false || strpos($userAgent, 'Trident') !== false) {
            return 'Internet Explorer';
        } else {
            return 'Unknown';
        }
    }

    /**
     * Get platform from user agent
     */
    public static function getPlatform($userAgent)
    {
        if (strpos($userAgent, 'Windows') !== false) {
            return 'Windows';
        } elseif (strpos($userAgent, 'Mac') !== false) {
            return 'macOS';
        } elseif (strpos($userAgent, 'Linux') !== false) {
            return 'Linux';
        } elseif (strpos($userAgent, 'Android') !== false) {
            return 'Android';
        } elseif (strpos($userAgent, 'iOS') !== false || strpos($userAgent, 'iPhone') !== false || strpos($userAgent, 'iPad') !== false) {
            return 'iOS';
        } else {
            return 'Unknown';
        }
    }

    /**
     * Track invitation access
     */
    public static function track($request)
    {
        $userAgent = $request->header('User-Agent');

        return self::create([
            'ip_address' => $request->ip(),
            'user_agent' => $userAgent,
            'referer' => $request->header('referer'),
            'device_type' => self::getDeviceType($userAgent),
            'browser' => self::getBrowser($userAgent),
            'platform' => self::getPlatform($userAgent),
            'country' => $request->header('CF-IPCountry'), // For Cloudflare
            'city' => null, // You can use IP geolocation service here
        ]);
    }

    /**
     * Get total access count
     */
    public static function getTotalAccessCount()
    {
        return self::count();
    }

    /**
     * Get today's access count
     */
    public static function getTodayAccessCount()
    {
        return self::whereDate('created_at', today())->count();
    }

    /**
     * Get this week's access count
     */
    public static function getWeekAccessCount()
    {
        return self::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
    }

    /**
     * Get this month's access count
     */
    public static function getMonthAccessCount()
    {
        return self::whereMonth('created_at', now()->month)->count();
    }

    /**
     * Get unique visitors by IP
     */
    public static function getUniqueVisitorsCount()
    {
        return self::distinct('ip_address')->count('ip_address');
    }

    /**
     * Get access stats by device
     */
    public static function getStatsByDevice()
    {
        return self::select('device_type', self::raw('count(*) as total'))
            ->groupBy('device_type')
            ->get()
            ->pluck('total', 'device_type')
            ->toArray();
    }

    /**
     * Get access stats by browser
     */
    public static function getStatsByBrowser()
    {
        return self::select('browser', self::raw('count(*) as total'))
            ->groupBy('browser')
            ->orderBy('total', 'desc')
            ->get()
            ->pluck('total', 'browser')
            ->toArray();
    }

    /**
     * Get access stats by platform
     */
    public static function getStatsByPlatform()
    {
        return self::select('platform', self::raw('count(*) as total'))
            ->groupBy('platform')
            ->orderBy('total', 'desc')
            ->get()
            ->pluck('total', 'platform')
            ->toArray();
    }

    /**
     * Get hourly access stats for today
     */
    public static function getHourlyStats()
    {
        $hours = [];
        for ($i = 0; $i < 24; $i++) {
            $hours[$i] = 0;
        }

        $stats = self::select(self::raw('HOUR(created_at) as hour'), self::raw('count(*) as total'))
            ->whereDate('created_at', today())
            ->groupBy('hour')
            ->get();

        foreach ($stats as $stat) {
            $hours[$stat->hour] = $stat->total;
        }

        return $hours;
    }

    /**
     * Get daily access stats for last 7 days
     */
    public static function getDailyStats($days = 7)
    {
        $dates = [];
        $data = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dates[] = $date->format('M d');

            $count = self::whereDate('created_at', $date)->count();
            $data[] = $count;
        }

        return [
            'labels' => $dates,
            'data' => $data,
        ];
    }
}
