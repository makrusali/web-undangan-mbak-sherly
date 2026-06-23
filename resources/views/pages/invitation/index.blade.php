@php
    $primaryColor = $themeSetting->primary_color ?? '#9fc9f3';
    $secondaryColor = $themeSetting->secondary_color ?? '#6fa3d9';
    $accentColor = $themeSetting->accent_color ?? '#6fa3d9';
    $lightColor = $themeSetting->light_color ?? '#f7fbff';
    $veryLightColor = $themeSetting->very_light_color ?? '#fffafd';
    $darkColor = $themeSetting->dark_color ?? '#42556b';
    
    $weddingBgp = $themeSetting->backgrond_image ? Storage::url($themeSetting->backgrond_image) : 'https://images.unsplash.com/photo-1519741497674-611481863552?q=80&w=1920&auto=format&fit=crop';
    $weddingBgpPath = $themeSetting->backgrond_image ? Storage::path($themeSetting->backgrond_image) : null;
    $weddingBgpExtension = $weddingBgpPath ? pathinfo($weddingBgpPath, PATHINFO_EXTENSION) : null;
    $isVideo = in_array(strtolower($weddingBgpExtension ?? ''), ['mp4', 'webm', 'ogg', 'mov']);
    
    $decor_top_left = $themeSetting->decor_top_left_image ? Storage::url($themeSetting->decor_top_left_image) : null;
    $decor_top_right = $themeSetting->decor_top_right_image ? Storage::url($themeSetting->decor_top_right_image) : null;
    $decor_bottom_left = $themeSetting->decor_bottom_left_image ? Storage::url($themeSetting->decor_bottom_left_image) : null;
    $decor_bottom_right = $themeSetting->decor_bottom_right_image ? Storage::url($themeSetting->decor_bottom_right_image) : null;
    $decor_falling_petal = $themeSetting->decor_falling_petal_image ? Storage::url($themeSetting->decor_falling_petal_image) : null;
    
    $hex2rgb = function($hex) {
        $hex = str_replace("#", "", $hex);
        if(strlen($hex) == 3) {
            $r = hexdec(substr($hex,0,1).substr($hex,0,1));
            $g = hexdec(substr($hex,1,1).substr($hex,1,1));
            $b = hexdec(substr($hex,2,1).substr($hex,2,1));
        } else {
            $r = hexdec(substr($hex,0,2));
            $g = hexdec(substr($hex,2,2));
            $b = hexdec(substr($hex,4,2));
        }
        return "$r, $g, $b";
    };
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no font-sans">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $setting->couple_name ?? 'Wedding Invitation' }} - Pernikahan {{ $setting->couple_name }}</title>

    <!-- Open Graph / Social Media Meta Tags -->
    <meta property="og:title" content="{{ $setting->couple_name ?? 'Wedding Invitation' }} - Pernikahan {{ $setting->couple_name }}" />
    <meta property="og:description" content="Undangan Pernikahan {{ $setting->couple_name }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    @if($setting && $setting->couple_photo)
    <meta property="og:image" content="{{ $setting->couple_photo_url }}" />
    @elseif($setting && $setting->hero_image)
    <meta property="og:image" content="{{ $setting->hero_image_url }}" />
    @endif
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />

    <!-- Fonts -->
    <link rel="icon" type="image/x-icon" href="/images/favicon-32x32.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Cinzel:wght@400;500;600;700&family=Montserrat:wght@200;300;400;500;600;700&family=Great+Vibes&family=Sacramento&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet font-serif font-display">

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css'])
    
    <!-- Animate On Scroll (AOS) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Global CSS Variables Injected from Blade Variables -->
    <style>
        :root {
            --primary-color: {{ $primaryColor }};
            --primary-rgb: {{ $hex2rgb($primaryColor) }};
            
            --secondary-color: {{ $secondaryColor }};
            --secondary-rgb: {{ $hex2rgb($secondaryColor) }};
            
            --accent-color: {{ $accentColor }};
            --accent-rgb: {{ $hex2rgb($accentColor) }};
            
            --light-color: {{ $lightColor }};
            --light-rgb: {{ $hex2rgb($lightColor) }};
            
            --very-light-color: {{ $veryLightColor }};
            --very-light-rgb: {{ $hex2rgb($veryLightColor) }};
            
            --dark-color: {{ $darkColor }};
            --dark-rgb: {{ $hex2rgb($darkColor) }};
            
            --gradient-primary: linear-gradient(135deg, var(--primary-color), var(--secondary-color), var(--accent-color));
        }

        .font-great { font-family: 'Great Vibes', cursive !important; }
        .font-sacramento { font-family: 'Sacramento', cursive !important; }
        .font-playfair { font-family: 'Cormorant Garamond', 'Playfair Display', serif !important; }
        .font-display { font-family: 'Cinzel', 'Montserrat', sans-serif !important; }
        .font-sans-alt { font-family: 'Montserrat', 'Inter', sans-serif !important; }

        .bg-primary-custom { background-color: var(--primary-color); }
        .text-primary-custom { color: var(--primary-color); }
        .border-primary-custom { border-color: var(--primary-color); }
        
        .bg-secondary-custom { background-color: var(--secondary-color); }
        .text-secondary-custom { color: var(--secondary-color); }
        .border-secondary-custom { border-color: var(--secondary-color); }

        .bg-very-light-custom { background-color: var(--very-light-color); }
        
        .bg-gradient-custom { background: var(--gradient-primary); }
        .text-gradient-custom {
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: var(--very-light-color);
        }
        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--dark-color);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--very-light-color);
            transition: background 1.5s ease-in-out;
            overflow: hidden !important;
            height: 100vh !important;
            width: 100vw !important;
        }

        body.has-opened {
            background-image: linear-gradient(rgba(var(--very-light-rgb), 0.94), rgba(var(--very-light-rgb), 0.90)), url('{{ $weddingBgp }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            overflow-x: hidden !important;
            overflow-y: auto !important;
            height: auto !important;
            width: 100% !important;
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--gradient-primary);
            z-index: 20000;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.8s ease-out, visibility 0.8s ease-out;
        }
        .loading-overlay.hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        .opening-overlay {
            position: fixed;
            overflow: hidden;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(var(--dark-rgb), 0.2), rgba(var(--primary-rgb), 0.25)), url('{{ $setting->hero_image_url }}');
            background-size: cover;
            background-position: center;
            z-index: 15000;
            transition: transform 1.2s cubic-bezier(0.77, 0, 0.175, 1), opacity 1.2s ease;
            -webkit-overflow-scrolling: touch;
        }
        .opening-overlay.closing {
            transform: translateY(-100%);
            opacity: 0;
            pointer-events: none;
        }

        .animate-spin-slow {
            animation: spin 30s linear infinite;
        }
        .animate-reverse-spin {
            animation: spin-back 20s linear infinite;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        @keyframes spin-back {
            from { transform: rotate(360deg); }
            to { transform: rotate(0deg); }
        }

        .animate-sway-slow {
            animation: swaySlow 9s ease-in-out infinite alternate;
        }
        .animate-sway-medium {
            animation: swayMedium 6s ease-in-out infinite alternate;
        }
        @keyframes swaySlow {
            0% { transform: rotate(-4deg) scale(1); }
            100% { transform: rotate(4deg) scale(1.02); }
        }
        @keyframes swayMedium {
            0% { transform: rotate(-2deg) translateY(0px); }
            100% { transform: rotate(2deg) translateY(4px); }
        }

        @if ($themeSetting->backgrond_image != null)    
            @if($isVideo)
                .bg-video-container {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100vw;
                    height: 100vh;
                    overflow: hidden;
                    z-index: 0;
                }

                .bg-video-container video {
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    min-width: 100%;
                    min-height: 100%;
                    width: auto;
                    height: auto;
                    transform: translateX(-50%) translateY(-50%);
                    object-fit: cover;
                }

                /* For image background - also fixed */
                .bg-gif-container {
                    position: relative;
                    width: 100%;
                    min-height: 100vh;
                }
            @else
                .bg-gif-container {
                    position: relative;
                    background-image: linear-gradient(rgba(var(--very-light-rgb), {{ $themeSetting->bg_mask_alpha }}), rgba(var(--very-light-rgb), {{ $themeSetting->bg_mask_alpha + 0.05}})), url("{{ Storage::url($themeSetting->backgrond_image) }}");
                    background-size: cover;
                    background-position: center;
                    background-attachment: fixed;
                    background-repeat: no-repeat;
                    width: 100%;
                }
            @endif
        @endif

        /* Decor Background Images - Fixed Position Inside Container */
        .decor-wrapper {
            position: fixed;
            top: 0;
            width: 100%;
            height: 0;
            pointer-events: none;
            z-index: 10;
            overflow: visible;
            width: 100dvw;
            height: 100dvh;
        }

        .decor-item {
            position: absolute;
            pointer-events: none;
            opacity: 0.85;
            z-index: 10;
        }
        .decor-item img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .decor-tl { 
            position: absolute;
            top: 0px; 
            left: 0px; 
            height: 18rem; 
            animation: decorFloatTL 8s ease-in-out infinite; 
        }

        .decor-tr { 
            top: 0px; 
            right: 0px; 
            height: 18rem; 
            animation: decorFloatTR 7s ease-in-out infinite; 
        }

        .decor-bl { 
            bottom: 0px; 
            left: 0px; 
            height: 18rem; 
            animation: decorFloatBL 10s ease-in-out infinite; 
        }

        .decor-br { 
            bottom: 0px; 
            right: 0px; 
            height: 18rem; 
            animation: decorFloatBR 9s ease-in-out infinite; 
        }

        /* Enhanced Decor Animations */
        @keyframes decorFloatTL {
            0% { transform: translate(0, 0) rotate(-3deg) scale(1); }
            20% { transform: translate(12px, -8px) rotate(5deg) scale(1.05); }
            40% { transform: translate(5px, -18px) rotate(-2deg) scale(1.08); }
            60% { transform: translate(-8px, -12px) rotate(8deg) scale(1.05); }
            80% { transform: translate(-15px, -5px) rotate(-5deg) scale(1.02); }
            100% { transform: translate(0, 0) rotate(-3deg) scale(1); }
        }
        @keyframes decorFloatTR {
            0% { transform: translate(0, 0) rotate(3deg) scale(1); }
            20% { transform: translate(-15px, -10px) rotate(-6deg) scale(1.06); }
            40% { transform: translate(-8px, -22px) rotate(3deg) scale(1.1); }
            60% { transform: translate(10px, -15px) rotate(-8deg) scale(1.06); }
            80% { transform: translate(18px, -8px) rotate(6deg) scale(1.03); }
            100% { transform: translate(0, 0) rotate(3deg) scale(1); }
        }
        @keyframes decorFloatBL {
            0% { transform: translate(0, 0) rotate(-2deg) scale(1); }
            25% { transform: translate(10px, 10px) rotate(6deg) scale(1.06); }
            50% { transform: translate(0, 20px) rotate(-4deg) scale(1.1); }
            75% { transform: translate(-10px, 10px) rotate(6deg) scale(1.06); }
            100% { transform: translate(0, 0) rotate(-2deg) scale(1); }
        }
        @keyframes decorFloatBR {
            0% { transform: translate(0, 0) rotate(2deg) scale(1); }
            25% { transform: translate(-12px, 12px) rotate(-7deg) scale(1.06); }
            50% { transform: translate(0, 22px) rotate(4deg) scale(1.1); }
            75% { transform: translate(12px, 12px) rotate(-7deg) scale(1.06); }
            100% { transform: translate(0, 0) rotate(2deg) scale(1); }
        }

        @media (max-width: 768px) {
            .decor-tl { top: 0px; left: 0px; height: 14rem; }
            .decor-tr { top: 0px; right: 0px; height: 14rem; }
            .decor-bl { bottom: 0px; left: 0px; height: 14rem; }
            .decor-br { bottom: 0px; right: 0px; height: 14rem; }
        }

        /* Falling Petals - SVG Leaf Animation */
        .petal-container {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            overflow: hidden;
            pointer-events: none;
        }
        .floating-petal {
            position: absolute;
            width: 30px;
            height: 30px;
            opacity: 0.7;
            pointer-events: none;
            animation: fallAndSway linear infinite;
        }
        .floating-petal img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        @keyframes fallAndSway {
            0% {
                transform: translateY(-100px) rotate(0deg) translateX(0px) scale(1);
                opacity: 0.8;
            }
            25% {
                transform: translateY(25vh) rotate(90deg) translateX(30px) scale(1.1);
            }
            50% {
                transform: translateY(50vh) rotate(180deg) translateX(-20px) scale(0.9);
                opacity: 0.9;
            }
            75% {
                transform: translateY(75vh) rotate(270deg) translateX(25px) scale(1.05);
            }
            100% {
                transform: translateY(105vh) rotate(360deg) translateX(-30px) scale(1);
                opacity: 0.6;
            }
        }

        /* SVG Stem Animation - Kept from original */
        .svg-stem {
            stroke-dasharray: 200;
            stroke-dashoffset: 200;
            animation: drawFloralLine 4.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        @keyframes drawFloralLine {
            to {
                stroke-dashoffset: 0;
            }
        }

        /* Event Card - Improved Design */
        .event-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(16px);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.4);
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.06);
        }
        .event-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 24px 48px rgba(0, 0, 0, 0.12);
            border-color: var(--primary-color);
        }
        .event-card .event-image-wrap {
            position: relative;
            overflow: hidden;
            height: 220px;
        }
        .event-card .event-image-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.7s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .event-card:hover .event-image-wrap img {
            transform: scale(1.08);
        }
        .event-card .event-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.2) 50%, transparent 100%);
        }
        .event-card .event-title {
            position: absolute;
            bottom: 24px;
            left: 24px;
            right: 24px;
            color: white;
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem;
            font-weight: 600;
            text-shadow: 0 2px 20px rgba(0, 0, 0, 0.4);
            letter-spacing: 0.5px;
            line-height: 1.2;
        }
        .event-card .event-badge {
            position: absolute;
            top: 16px;
            right: 16px;
            background: var(--primary-color);
            backdrop-filter: blur(8px);
            padding: 6px 16px;
            border-radius: 30px;
            color: white;
            font-size: 0.6rem;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }
        .event-card .event-body {
            padding: 24px 24px 28px;
        }

        /* Gift Card - With Bank Icon */
        .gift-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(16px);
            border-radius: 24px;
            border: 1px solid var(--primary-color);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 24px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.04);
        }
        .gift-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.08);
            border-color: var(--primary-color);
        }
        .gift-card .bank-icon {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            object-fit: contain;
            background: white;
            padding: 4px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        }
        .gift-card .bank-icon-fallback {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .mySwiper {
            width: 100%;
            padding-top: 20px;
            padding-bottom: 50px;
            overflow: visible !important;
        }
        .mySwiper .swiper-slide {
            background-position: center;
            background-size: cover;
            width: 285px;
            height: 385px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 24px;
            box-shadow: 0 20px 45px rgba(var(--dark-rgb), 0.25);
            border: 3.5px solid var(--accent-color);
            outline: 1.5px solid var(--primary-color);
            overflow: hidden;
            transition: transform 0.6s ease, box-shadow 0.6s ease;
            margin: 0 auto;
        }
        @media (min-width: 768px) {
            .mySwiper .swiper-slide {
                width: 380px;
                height: 500px;
            }
        }
        .mySwiper .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 20px;
            transition: transform 0.6s ease;
        }
        .mySwiper .swiper-pagination-bullet-active {
            background-color: var(--primary-color) !important;
        }

        .swal2-popup {
            border-radius: 24px !important;
            font-family: 'Inter', sans-serif !important;
        }
        .swal2-title {
            color: var(--primary-color) !important;
            font-family: 'Great Vibes', cursive !important;
            font-size: 2.2rem !important;
        }
        .swal2-confirm {
            background-color: var(--primary-color) !important;
            border-radius: 50px !important;
        }

        /* Section spacing for better visual flow */
        section {
            position: relative;
            z-index: 15;
        }
    </style>
</head>
<body class="overflow-hidden w-full h-screen">

    <!-- Loading Animation -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="flex flex-col items-center justify-center">
            <svg class="w-14 h-14 text-white/90 animate-pulse" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
            </svg>
            
            <div class="flex items-center gap-1.5 mt-5">
                <div class="w-1.5 h-1.5 bg-white/30 rounded-full animate-bounce" style="animation-delay: 0s"></div>
                <div class="w-1.5 h-1.5 bg-white/50 rounded-full animate-bounce" style="animation-delay: 0.15s"></div>
                <div class="w-1.5 h-1.5 bg-white/70 rounded-full animate-bounce" style="animation-delay: 0.3s"></div>
            </div>
        </div>
    </div>

    <!-- Opening Animation Overlay -->
    <div class="opening-overlay" id="openingOverlay">
        <!-- Animated SVG elegant gold lineart corner branches representing wind breeze -->
        <div class="absolute top-0 left-0 w-36 md:w-56 lg:w-72 opacity-85 select-none pointer-events-none z-20 animate-sway-slow origin-top-left text-(--accent-color)">
            <svg viewBox="0 0 100 100" class="w-full h-full" fill="none" stroke="currentColor" stroke-width="1.2">
                <path d="M0,0 Q30,10 50,50 T90,100" stroke-linecap="round" class="svg-stem" />
                <path d="M15,10 Q5,25 0,35 Z" fill="currentColor" fill-opacity="0.15" />
                <path d="M25,12 Q35,5 45,0 Z" fill="currentColor" fill-opacity="0.15" />
                <path d="M30,22 Q15,35 10,48 Z" fill="currentColor" fill-opacity="0.15" />
                <path d="M42,28 Q55,20 62,10 Z" fill="currentColor" fill-opacity="0.15" />
                <path d="M50,50 Q30,65 15,75 Z" fill="currentColor" fill-opacity="0.15" />
                <path d="M50,50 Q70,42 85,32 Z" fill="currentColor" fill-opacity="0.15" />
                <circle cx="15" cy="20" r="1.5" fill="currentColor" class="animate-pulse" stroke="none" />
                <circle cx="35" cy="15" r="1" fill="currentColor" stroke="none" />
                <circle cx="55" cy="35" r="2" fill="currentColor" class="animate-pulse" stroke="none" />
            </svg>
        </div>
        <div class="absolute top-0 right-0 w-36 md:w-56 lg:w-72 opacity-85 select-none pointer-events-none z-20 animate-sway-medium origin-top-right text-(--accent-color)">
            <svg viewBox="0 0 100 100" class="w-full h-full transform scale-x-[-1]" fill="none" stroke="currentColor" stroke-width="1.2">
                <path d="M0,0 Q30,10 50,50 T90,100" stroke-linecap="round" class="svg-stem" />
                <path d="M15,10 Q5,25 0,35 Z" fill="currentColor" fill-opacity="0.15" />
                <path d="M25,12 Q35,5 45,0 Z" fill="currentColor" fill-opacity="0.15" />
                <path d="M30,22 Q15,35 10,48 Z" fill="currentColor" fill-opacity="0.15" />
                <path d="M42,28 Q55,20 62,10 Z" fill="currentColor" fill-opacity="0.15" />
                <path d="M50,50 Q30,65 15,75 Z" fill="currentColor" fill-opacity="0.15" />
                <path d="M50,50 Q70,42 85,32 Z" fill="currentColor" fill-opacity="0.15" />
                <circle cx="15" cy="20" r="1.5" fill="currentColor" class="animate-pulse" stroke="none" />
                <circle cx="55" cy="35" r="2" fill="currentColor" class="animate-pulse" stroke="none" />
            </svg>
        </div>
        <div class="absolute bottom-0 left-0 w-32 md:w-48 lg:w-64 opacity-80 select-none pointer-events-none z-20 animate-sway-medium origin-bottom-left text-(--accent-color)">
            <svg viewBox="0 0 100 100" class="w-full h-full transform scale-y-[-1]" fill="none" stroke="currentColor" stroke-width="1.2">
                <path d="M0,0 Q30,10 50,50 T90,100" stroke-linecap="round" class="svg-stem" />
                <path d="M15,10 Q5,25 0,35 Z" fill="currentColor" fill-opacity="0.15" />
                <path d="M25,12 Q35,5 45,0 Z" fill="currentColor" fill-opacity="0.15" />
                <path d="M30,22 Q15,35 10,48 Z" fill="currentColor" fill-opacity="0.15" />
                <circle cx="15" cy="20" r="1.5" fill="currentColor" class="animate-pulse" stroke="none" />
                <circle cx="55" cy="35" r="2" fill="currentColor" class="animate-pulse" stroke="none" />
            </svg>
        </div>
        <div class="absolute bottom-0 right-0 w-32 md:w-48 lg:w-64 opacity-80 select-none pointer-events-none z-20 animate-sway-slow origin-bottom-right text-(--accent-color)">
            <svg viewBox="0 0 100 100" class="w-full h-full transform scale-x-[-1] scale-y-[-1]" fill="none" stroke="currentColor" stroke-width="1.2">
                <path d="M0,0 Q30,10 50,50 T90,100" stroke-linecap="round" class="svg-stem" />
                <path d="M15,10 Q5,25 0,35 Z" fill="currentColor" fill-opacity="0.15" />
                <path d="M25,12 Q35,5 45,0 Z" fill="currentColor" fill-opacity="0.15" />
                <path d="M30,22 Q15,35 10,48 Z" fill="currentColor" fill-opacity="0.15" />
                <circle cx="15" cy="20" r="1.5" fill="currentColor" class="animate-pulse" stroke="none" />
                <circle cx="55" cy="35" r="2" fill="currentColor" class="animate-pulse" stroke="none" />
            </svg>
        </div>

        <div class="min-h-full w-full flex flex-col items-center justify-center p-4 py-12 md:py-16 relative z-10">
            <div class="relative max-w-lg w-full text-center text-white px-6 py-12 rounded-3xl backdrop-blur-lg bg-[rgba(var(--dark-rgb),0.35)] border border-white/15 shadow-[0_25px_60px_-15px_rgba(0,0,0,0.6)] mx-4" data-aos="zoom-in" data-aos-duration="1400">
                
                <div class="uppercase text-[10px] tracking-[0.4em] text-(--accent-color) mb-3 font-['Montserrat'] font-light">The Wedding Invitation</div>
                
                <h2 class="font-['Great_Vibes'] text-6xl md:text-7xl text-white my-3 drop-shadow-[0_2px_10px_rgba(0,0,0,0.4)] py-1">{{ $setting->couple_name }}</h2>
                
                <div class="flex items-center justify-center gap-3 my-5">
                    <div class="w-12 h-px bg-linear-to-r from-transparent to-white/40"></div>
                    <svg class="w-4 h-4 text-(--accent-color) opacity-75" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                    <div class="w-12 h-px bg-linear-to-l from-transparent to-white/40"></div>
                </div>
                
                <p class="text-xs font-light font-['Montserrat'] tracking-wide leading-relaxed text-white/80 max-w-sm mx-auto mb-6">
                    Tanpa mengurangi rasa hormat, kami mengundang Bapak/Ibu/Saudara/i untuk menghadiri hari istimewa kami.
                </p>

                <div class="my-6 p-6 rounded-2xl bg-[rgba(var(--dark-rgb),0.25)] border border-white/10 backdrop-blur-md shadow-2xl max-w-sm mx-auto transition-all duration-500 hover:border-(--accent-color)/30">
                    <p class="text-[9px] tracking-[0.3em] uppercase text-white/60 mb-2.5 font-['Montserrat'] font-light">Kepada Yth. Bapak/Ibu/Saudara/i:</p>
                    <div class="text-2xl font-['Cormorant_Garamond'] italic font-medium text-(--accent-color) tracking-wide border-b border-white/15 pb-2 mb-3 inline-block min-w-55">
                        {!! $guestName !!}
                    </div>
                    
                    @if($setting->max_guest && $setting->max_guest > 0)
                    <div class="items-center justify-center gap-1.5 text-[10px] font-light text-white/70 font-['Montserrat'] bg-white/5 py-1 px-3.5 rounded-full border border-white/5 inline-flex mt-1">
                        <svg class="w-3.5 h-3.5 text-(--accent-color) opacity-85" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg>
                        <span>Maks. <span class="font-medium text-white">{{ $setting->max_guest }} Orang</span></span>
                    </div>
                    @endif
                </div>

                @if($events->first())
                    <div class="text-[10px] font-['Montserrat'] uppercase tracking-[0.25em] bg-white/10 py-2.5 px-6 rounded-full inline-block mb-8 border border-white/5 backdrop-blur-sm shadow-inner text-white/90">
                        {{ \Carbon\Carbon::parse($events->first()->date)->translatedFormat('l, d F Y') }}
                    </div>
                @endif

                <div class="relative">
                    <button type="button" id="openInvitation" class="px-8 py-3.5 bg-linear-to-r from-(--primary-color) to-(--secondary-color) text-white hover:text-white rounded-full font-['Montserrat'] text-xs font-semibold uppercase tracking-[0.2em] shadow-lg hover:shadow-2xl hover:scale-105 active:scale-95 transition-all duration-300 flex items-center justify-center gap-3.5 mx-auto border border-white/10">
                        <span>Buka Undangan</span>
                        <svg class="w-4 h-4 animate-bounce text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M19 14l-7 7-7-7M12 21V3"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Container -->
    <div class="main-content opacity-0 transition-opacity duration-1000 w-full" id="mainContent">
        
        @if($setting->song_file)
        <button id="musicToggle" class="fixed bottom-6 right-6 z-50 w-14 h-14 rounded-full bg-gradient-custom text-white flex items-center justify-center shadow-2xl hover:scale-110 active:scale-95 transition-all duration-300 pulse">
            <svg id="musicIcon" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 18V5l12-2v13M9 18c0 1.105-1.119 2-2.5 2S4 19.105 4 18s1.119-2 2.5-2 2.5.895 2.5 2zm12-2c0 1.105-1.119 2-2.5 2s-2.5-.895-2.5-2 1.119-2 2.5-2 2.5.895 2.5 2zM9 10l12-2"/>
            </svg>
        </button>
        <audio id="bgMusic" loop>
            <source src="{{ $setting->song_file_url }}" type="audio/mpeg">
        </audio>
        @endif

        <!-- HERO SECTION -->
        <section id="home" class="relative min-height-[100vh] min-h-screen flex items-end justify-center bg-cover bg-center overflow-hidden" 
                 style="background-image: url('{{ $setting->hero_image_url }}');">
            
            @if($decor_falling_petal)
            <div class="petal-container" id="heroPetals"></div>
            @endif

            <div class="relative max-w-3xl w-full text-center text-white px-6 py-12 md:py-16 rounded-3xl backdrop-blur-lg bg-[rgba(var(--dark-rgb),0.35)] border border-white/15 shadow-[0_25px_60px_-15px_rgba(0,0,0,0.6)] mx-4 z-10 mb-12" data-aos="fade-up" data-aos-duration="1500">
                <span class="text-[10px] tracking-[0.4em] uppercase block mb-4 text-(--accent-color) font-['Montserrat']">Undangan Pernikahan</span>
                <h1 class="font-['Great_Vibes'] text-6xl md:text-7xl lg:text-8xl mb-6 drop-shadow-[0_2px_10px_rgba(0,0,0,0.4)] py-1">{{ $setting->couple_name }}</h1>
                
                <div class="flex items-center justify-center gap-3 my-6">
                    <div class="w-12 h-px bg-linear-to-r from-transparent to-white/40"></div>
                    <svg class="w-4 h-4 text-(--accent-color) opacity-75" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                    <div class="w-12 h-px bg-linear-to-l from-transparent to-white/40"></div>
                </div>

                @if ( $setting->invitation_text_with_guest)
                    <div class="text-xs md:text-base font-light leading-relaxed max-w-2xl mx-auto mb-8 text-white font-['Montserrat']">
                        {!! $setting->invitation_text_with_guest !!}
                    </div>
                @else
                    <div class="text-xs md:text-base font-light leading-relaxed max-w-2xl mx-auto mb-8 text-white font-['Montserrat']">
                        Kepada Yth. Bapak/Ibu/Saudara/i: <br> Tamu Undangan
                    </div>
                @endif
                
                <div class="animate-bounce mt-6">
                    <svg class="w-5 h-5 mx-auto text-(--accent-color) opacity-85" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M19 14l-7 7-7-7M12 21V3"/>
                    </svg>
                </div>
            </div>
        </section>

        @if($isVideo)
            <div class="bg-video-container fixed top-0 left-0 w-full h-screen overflow-hidden" style="z-index: 0;">
                <video 
                    autoplay 
                    muted 
                    loop 
                    playsinline 
                    preload="auto" 
                    class="absolute w-full h-full object-cover"
                >
                    <source src="{{ Storage::url($themeSetting->backgrond_image) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        @endif



        <div class="bg-gif-container relative w-full">
            
            <!-- Decor Images - Fixed Position Wrapper -->
            <div class="decor-wrapper">
                @if($decor_top_left)
                <div class="decor-item decor-tl" data-aos="fade-down-right" data-aos-duration="1000">
                    <img src="{{ $decor_top_left }}" alt="Decor Top Left" loading="lazy">
                </div>
                @endif

                @if($decor_top_right)
                <div class="decor-item decor-tr" data-aos="fade-down-left" data-aos-duration="1000">
                    <img src="{{ $decor_top_right }}" alt="Decor Top Right" loading="lazy">
                </div>
                @endif

                @if($decor_bottom_left)
                <div class="decor-item decor-bl" data-aos="fade-up-right" data-aos-duration="1000">
                    <img src="{{ $decor_bottom_left }}" alt="Decor Bottom Left" loading="lazy">
                </div>
                @endif

                @if($decor_bottom_right)
                <div class="decor-item decor-br" data-aos="fade-up-left" data-aos-duration="1000">
                    <img src="{{ $decor_bottom_right }}" alt="Decor Bottom Right" loading="lazy">
                </div>
                @endif
            </div>

            <!-- COUPLE SECTION -->
            <section id="couple" class="relative py-24 px-4 bg-transparent overflow-hidden">
            <div class="max-w-6xl mx-auto w-full relative z-15">
                <div class="text-center mb-20" data-aos="fade-up">
                    <span class="text-primary-custom text-sm tracking-[0.3em] uppercase mb-3 block font-semibold">Mempelai</span>
                    <h2 class="font-great text-4xl md:text-5xl lg:text-6xl text-gray-800 mb-4">Kedua Mempelai</h2>
                    <div class="w-20 h-1 bg-primary-custom mx-auto"></div>
                </div>
                
                <div class="grid md:grid-cols-2 gap-12 lg:gap-16 px-4">
                    <div class="text-center md:pb-0" data-aos="fade-right" data-aos-duration="1200">
                        <div class="relative inline-block mb-8">
                            <div class="absolute -inset-2 bg-gradient-custom rounded-[35px] opacity-25 blur-sm"></div>
                            @if($setting->groom_photo)
                                <img src="{{ $setting->groom_photo_url }}" alt="{{ $setting->groom_fullname }}" 
                                     class="couple-photo relative z-10 hover:scale-[1.03] transition-transform duration-500 rounded-[30px] w-80">
                            @else
                                <div class="couple-photo bg-gradient-custom flex items-center justify-center relative z-10 rounded-[30px]">
                                    <span class="text-7xl text-white font-great">{{ substr($setting->groom_nickname ?? 'G', 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <h3 class="text-3xl font-great text-gray-800 mb-2">{{ $setting->groom_nickname ?? 'Groom' }}</h3>
                        <p class="text-xl font-semibold text-gray-700 mb-2 font-playfair">{{ $setting->groom_fullname }}</p>
                        <div class="text-sm text-gray-500! mb-4 font-normal!">{!! $setting->groom_parents ?? 'Bapak & Ibu' !!}</div>
                        
                        @if($setting->groom_instagram)
                        <a href="https://instagram.com/{{ $setting->groom_instagram }}" target="_blank" 
                           class="inline-flex items-center gap-2 px-5 py-2 bg-gradient-custom text-white text-sm rounded-full hover:shadow-lg transition-all duration-300">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
                            </svg>
                            <span>{{ $setting->groom_instagram }}</span>
                        </a>
                        @endif
                    </div>

                    <div class="text-center" data-aos="fade-left" data-aos-duration="1200">
                        <div class="relative inline-block mb-8">
                            <div class="absolute -inset-2 bg-gradient-custom rounded-[35px] opacity-25 blur-sm"></div>
                            @if($setting->bride_photo)
                                <img src="{{ $setting->bride_photo_url }}" alt="{{ $setting->bride_fullname }}" 
                                     class="couple-photo relative z-10 hover:scale-[1.03] transition-transform duration-500 rounded-[30px] w-80">
                            @else
                                <div class="couple-photo bg-gradient-custom flex items-center justify-center relative z-10 rounded-[30px]">
                                    <span class="text-7xl text-white font-great">{{ substr($setting->bride_nickname ?? 'B', 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <h3 class="text-3xl font-great text-gray-800 mb-2">{{ $setting->bride_nickname ?? 'Bride' }}</h3>
                        <p class="text-xl font-semibold text-gray-700 mb-2 font-playfair">{{ $setting->bride_fullname }}</p>
                        <div class="text-sm text-gray-500! mb-4 font-normal!">{!! $setting->bride_parents ?? 'Bapak & Ibu' !!}</div>
                        
                        @if($setting->bride_instagram)
                        <a href="https://instagram.com/{{ $setting->bride_instagram }}" target="_blank" 
                           class="inline-flex items-center gap-2 px-5 py-2 bg-gradient-custom text-white text-sm rounded-full hover:shadow-lg transition-all duration-300">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
                            </svg>
                            <span>{{ $setting->bride_instagram }}</span>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        @if($setting->love_story && $setting->love_story != "<p><br></p>")
        <section id="story" class="relative py-24 px-4 bg-transparent overflow-hidden">
            <div class="max-w-4xl mx-auto relative z-15 px-4">
                <div class="text-center mb-16" data-aos="fade-up">
                    <span class="text-primary-custom text-sm tracking-[0.3em] uppercase mb-3 block font-semibold">Love Story</span>
                    <h2 class="font-great text-4xl md:text-5xl lg:text-6xl text-gray-800 mb-4">Cerita Cinta Kami</h2>
                    <div class="w-20 h-1 bg-primary-custom mx-auto"></div>
                </div>
                
                <div class="bg-white/60 backdrop-blur-md p-8 md:p-12 rounded-3xl shadow-xl border border-white/20 prose prose-lg max-w-none text-gray-700 leading-relaxed font-sans" data-aos="zoom-in" data-aos-duration="1200">
                    {!! $setting->love_story !!}
                </div>
            </div>
        </section>
        @endif

        @if($events->count() > 0)
        <section id="events" class="relative py-24 px-4 bg-transparent overflow-hidden">
            <div class="max-w-6xl mx-auto w-full relative z-15">
                <div class="text-center mb-16" data-aos="fade-up">
                    <span class="text-primary-custom text-sm tracking-[0.3em] uppercase mb-3 block font-semibold">Acara Pernikahan</span>
                    <h2 class="font-great text-4xl md:text-5xl lg:text-6xl text-gray-800 mb-4">Rangkaian Acara</h2>
                    <div class="w-20 h-1 bg-primary-custom mx-auto"></div>
                </div>
                
                <div class="grid md:grid-cols-{{ min($events->count(), 2) }} gap-8 px-4 max-w-5xl mx-auto">
                    @foreach($events as $index => $event)
                    <div class="event-card group"
                         data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 200 }}">
                        
                        <div class="event-image-wrap">
                            @if($event->image)
                                <img src="{{ $event->image_url }}" alt="{{ $event->name }}">
                            @else
                                <div class="w-full h-full bg-gradient-custom flex items-center justify-center">
                                    <svg class="w-20 h-20 text-white/40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                        <line x1="16" y1="2" x2="16" y2="6"/>
                                        <line x1="8" y1="2" x2="8" y2="6"/>
                                        <line x1="3" y1="10" x2="21" y2="10"/>
                                        <path d="M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01M16 18h.01"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="event-overlay"></div>
                            
                            <div class="event-badge">
                                {{ $event->name }}
                            </div>
                            
                            <h3 class="event-title">{{ $event->name }}</h3>
                        </div>
                        
                        <div class="event-body space-y-4">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-(--primary-color)/10 rounded-full flex items-center justify-center shrink-0 text-(--primary-color)">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                        <line x1="16" y1="2" x2="16" y2="6"/>
                                        <line x1="8" y1="2" x2="8" y2="6"/>
                                        <line x1="3" y1="10" x2="21" y2="10"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 uppercase tracking-wider font-medium">Tanggal</p>
                                    <p class="font-semibold text-gray-800 text-sm">{{ \Carbon\Carbon::parse($event->date)->translatedFormat('l, d F Y') }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-(--primary-color)/10 rounded-full flex items-center justify-center shrink-0 text-(--primary-color)">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 uppercase tracking-wider font-medium">Waktu</p>
                                    <p class="font-semibold text-gray-800 text-sm">
                                        {{ \Carbon\Carbon::parse($event->time_start)->format('H:i') }} 
                                        @if($event->time_end)
                                            - {{ \Carbon\Carbon::parse($event->time_end)->format('H:i') }} WIB
                                        @else
                                            WIB - Selesai
                                        @endif
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-(--primary-color)/10 rounded-full flex items-center justify-center shrink-0 text-(--primary-color)">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                        <circle cx="12" cy="10" r="3"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 uppercase tracking-wider font-medium">Lokasi</p>
                                    <p class="font-semibold text-gray-800 text-sm mb-1">{{ $event->location_name }}</p>
                                    <p class="text-xs text-gray-500 leading-relaxed mb-2">{{ $event->address }}</p>
                                    @if($event->gmaps_link)
                                    <a href="{{ $event->gmaps_link }}" target="_blank" 
                                       class="inline-flex items-center gap-1.5 text-sm text-(--primary-color) font-medium hover:underline">
                                        <span>Buka Google Maps</span>
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                                            <polyline points="15 3 21 3 21 9"/>
                                            <line x1="10" y1="14" x2="21" y2="3"/>
                                        </svg>
                                    </a>
                                    @endif
                                </div>
                            </div>
                            
                            @if($event->description)
                            <div class="pt-3 border-t border-gray-100">
                                <p class="text-gray-500 text-xs italic">{{ $event->description }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                
                @if($events->first())
                    @php
                        $eventDate = \Carbon\Carbon::parse($events->first()->date);
                        $startTime = \Carbon\Carbon::parse($events->first()->time_start);
                        $endTime = $events->first()->time_end ? \Carbon\Carbon::parse($events->first()->time_end) : $startTime->copy()->addHours(2);
                        
                        $startDateTime = $eventDate->format('Ymd') . 'T' . $startTime->format('His');
                        $endDateTime = $eventDate->format('Ymd') . 'T' . $endTime->format('His');
                        
                        $formattedDate = $eventDate->translatedFormat('l, d F Y');
                    @endphp

                    <div class="mt-20 text-center" data-aos="zoom-in" data-aos-duration="1000">
                        <h3 class="text-2xl font-great text-gray-800 mb-6">Menuju Hari Bahagia</h3>
                        
                        <div class="flex justify-center flex-wrap gap-4 mb-10 px-4" id="countdown">
                            <div class="min-w-18.75 md:min-w-22.5 bg-gradient-custom text-white rounded-2xl p-3 md:p-4 shadow-md">
                                <span class="text-2xl md:text-4xl font-bold block" id="days">0</span>
                                <span class="text-[10px] uppercase tracking-widest text-white/80">Hari</span>
                            </div>
                            <div class="min-w-18.75 md:min-w-22.5 bg-gradient-custom text-white rounded-2xl p-3 md:p-4 shadow-md">
                                <span class="text-2xl md:text-4xl font-bold block" id="hours">0</span>
                                <span class="text-[10px] uppercase tracking-widest text-white/80">Jam</span>
                            </div>
                            <div class="min-w-18.75 md:min-w-22.5 bg-gradient-custom text-white rounded-2xl p-3 md:p-4 shadow-md">
                                <span class="text-2xl md:text-4xl font-bold block" id="minutes">0</span>
                                <span class="text-[10px] uppercase tracking-widest text-white/80">Menit</span>
                            </div>
                            <div class="min-w-18.75 md:min-w-22.5 bg-gradient-custom text-white rounded-2xl p-3 md:p-4 shadow-md">
                                <span class="text-2xl md:text-4xl font-bold block" id="seconds">0</span>
                                <span class="text-[10px] uppercase tracking-widest text-white/80">Detik</span>
                            </div>
                        </div>
                        
                        <div class="flex justify-center">
                            <a href="https://www.google.com/calendar/render?action=TEMPLATE&text={{ urlencode($setting->couple_name . ' - Pernikahan') }}&dates={{ $startDateTime }}/{{ $endDateTime }}&details={{ urlencode(strip_tags($setting->invitation_text_with_guest)) }}&location={{ urlencode($events->first()->location_name . ', ' . $events->first()->address) }}&sf=true&output=xml" 
                               target="_blank"
                               class="inline-flex items-center gap-3 px-6 py-3 bg-white border-2 border-primary-custom text-primary-custom rounded-full font-medium shadow-md hover:bg-opacity-95 hover:scale-[1.02] active:scale-95 transition-all duration-300">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                    <line x1="16" y1="2" x2="16" y2="6"/>
                                    <line x1="8" y1="2" x2="8" y2="6"/>
                                    <line x1="3" y1="10" x2="21" y2="10"/>
                                </svg>
                                <span>Simpan ke Google Kalender</span>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </section>
        @endif

        @if($galleries && count($galleries) > 0)
        <section id="gallery" class="relative py-24 px-4 bg-transparent overflow-hidden">
            <div class="max-w-6xl mx-auto w-full relative z-15">
                <div class="text-center mb-16" data-aos="fade-up">
                    <span class="text-primary-custom text-sm tracking-[0.3em] uppercase mb-3 block font-semibold">Gallery</span>
                    <h2 class="font-great text-4xl md:text-5xl lg:text-6xl text-gray-800 mb-4">Momen Berharga</h2>
                    <div class="w-20 h-1 bg-primary-custom mx-auto"></div>
                </div>
                
                <div class="swiper mySwiper" data-aos="zoom-in" data-aos-duration="1200">
                    <div class="swiper-wrapper">
                        @foreach($galleries as $gallery)
                        <div class="swiper-slide overflow-hidden rounded-3xl">
                            <img src="{{ $gallery->image_url }}" alt="Gallery Momen" class="rounded-3xl hover:scale-105 transition-transform duration-500">
                        </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination mt-8"></div>
                    <div class="swiper-button-next text-primary-custom"></div>
                    <div class="swiper-button-prev text-primary-custom"></div>
                </div>
            </div>
        </section>
        @endif

        @if($gifts && count($gifts) > 0)
        <section id="gifts" class="relative py-24 px-4 bg-transparent overflow-hidden">
            <div class="max-w-6xl mx-auto w-full relative z-15">
                <div class="text-center mb-16" data-aos="fade-up">
                    <span class="text-primary-custom text-sm tracking-[0.3em] uppercase mb-3 block font-semibold">Wedding Gifts</span>
                    <h2 class="font-great text-4xl md:text-5xl lg:text-6xl text-gray-800 mb-4">Hadiah Pernikahan</h2>
                    <div class="w-20 h-1 bg-primary-custom mx-auto mb-8"></div>
                    <p class="text-gray-600 max-w-2xl mx-auto text-sm md:text-base leading-relaxed px-4">
                        Doa restu Anda adalah karunia terindah bagi kami. Namun apabila Anda ingin mengirimkan tanda kasih berupa dana, berikut rincian rekening kami:
                    </p>
                </div>
                
                <div class="grid sm:grid-cols-2 gap-8 max-w-4xl mx-auto px-4" data-aos="fade-up" data-aos-duration="1200"> 
                    @foreach($gifts as $gift)
                    <div class="gift-card">
                        <div class="flex items-center gap-4 mb-4">
                            @if($gift->bank_image)
                                <img src="{{ Storage::url($gift->bank_image) }}" alt="{{ $gift->bank_name }}" class="bank-icon">
                            @else
                                <div class="bank-icon-fallback">
                                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="2" y="6" width="20" height="16" rx="2" />
                                        <path d="M12 6V2" />
                                        <path d="M7 6L5 2" />
                                        <path d="M17 6l2-4" />
                                    </svg>
                                </div>
                            @endif
                            <div>
                                <h3 class="text-lg font-bold text-gray-800 font-playfair">{{ $gift->bank_name }}</h3>
                                <p class="text-xs text-gray-400">Atas Nama: {{ $gift->account_name }}</p>
                            </div>
                        </div>
                        <div class="bg-white/40 backdrop-blur-sm rounded-xl p-4 border border-white/10 mb-4">
                            <p class="text-xs text-gray-500 mb-1">Nomor Rekening</p>
                            <p class="text-lg font-bold text-(--primary-color) tracking-wider break-all">{{ $gift->account_number }}</p>
                        </div>
                        <button onclick="copyAccountNumber('{{ $gift->account_number }}')" 
                                class="w-full py-2.5 bg-(--primary-color)/10 text-(--primary-color) font-medium rounded-xl hover:bg-(--primary-color) hover:text-white transition-all duration-300 flex items-center justify-center gap-2 text-sm">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                            </svg>
                            <span>Salin Nomor Rekening</span>
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <section id="wishes" class="relative py-24 px-4 bg-transparent overflow-hidden">
            <div class="max-w-6xl mx-auto w-full relative z-15">
                <div class="text-center mb-16" data-aos="fade-up">
                    <span class="text-primary-custom text-sm tracking-[0.3em] uppercase mb-3 block font-semibold">Wishes</span>
                    <h2 class="font-great text-4xl md:text-5xl lg:text-6xl text-gray-800 mb-4">Doa & Ucapan</h2>
                    <div class="w-20 h-1 bg-primary-custom mx-auto"></div>
                </div>
                
                <div class="grid lg:grid-cols-2 gap-10 max-w-5xl mx-auto px-4">
                    <div class="bg-white/60 backdrop-blur-md rounded-3xl p-6 md:p-8 shadow-xl border border-white/20" data-aos="fade-right">
                        <h3 class="text-2xl font-great text-gray-800 mb-6">Tulis Doa & Harapan</h3>
                        
                        <form id="wishForm" class="space-y-4">
                            @csrf
                            <div>
                                <input type="text" id="wishName" name="name" placeholder="Nama Anda" required
                                       class="w-full px-4 py-3 rounded-xl border border-(--primary-color)/20 bg-white/40 backdrop-blur-sm focus:border-(--primary-color) focus:ring-2 focus:ring-(--primary-color)/25 outline-none transition text-sm text-gray-800">
                            </div>
                            <div>
                                <input type="email" id="wishEmail" name="email" placeholder="Email Anda (opsional)"
                                       class="w-full px-4 py-3 rounded-xl border border-(--primary-color)/20 bg-white/40 backdrop-blur-sm focus:border-(--primary-color) focus:ring-2 focus:ring-(--primary-color)/25 outline-none transition text-sm text-gray-800">
                            </div>
                            <div>
                                <textarea id="wishMessage" name="message" rows="4" placeholder="Tuliskan pesan bahagia dan doa terbaik Anda di sini..." required
                                          class="w-full px-4 py-3 rounded-xl border border-(--primary-color)/20 bg-white/40 backdrop-blur-sm focus:border-(--primary-color) focus:ring-2 focus:ring-(--primary-color)/25 outline-none transition resize-none text-sm text-gray-800"></textarea>
                            </div>
                            <button type="submit" id="submitWishBtn"
                                    class="w-full py-3 bg-gradient-custom text-white font-medium rounded-xl hover:shadow-lg hover:scale-[1.01] transition-all duration-300">
                                <span class="btn-text">Kirim Ucapan</span>
                                <span class="btn-loading hidden">Mengirim...</span>
                            </button>
                        </form>
                    </div>
                    
                    <div class="bg-white/60 backdrop-blur-md rounded-3xl p-6 md:p-8 shadow-xl border border-white/20 flex flex-col" data-aos="fade-left">
                        <h3 class="text-2xl font-great text-gray-800 mb-6">Ucapan Terbaru</h3>
                        
                        <div class="space-y-4 overflow-y-auto max-h-96 pr-2 flex-1" id="wishesList">
                            @forelse($wishes as $wish)
                            <div class="bg-white/40 backdrop-blur-sm rounded-2xl p-4 border border-white/10">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-custom flex items-center justify-center text-white font-semibold shrink-0 text-sm">
                                        <span>{{ strtoupper(substr($wish->name, 0, 1)) }}</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between gap-2 mb-1 flex-wrap">
                                            <h4 class="font-semibold text-gray-800 text-sm truncate max-w-37.5">{{ $wish->name }}</h4>
                                            <span class="text-[10px] text-gray-400 font-medium">{{ $wish->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-gray-600 text-sm wrap-break-word whitespace-pre-wrap leading-relaxed">{{ $wish->message }}</p>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <p class="text-gray-400 text-center py-8 text-sm">Belum ada ucapan. Kirim ucapan pertama Anda!</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @if($setting->thanks_message && $setting->thanks_message != "<p><br></p>")
        <footer id="thanks" class="relative py-20 bg-transparent overflow-hidden">
            <div class="max-w-3xl mx-auto text-center relative z-15 px-6">
                @if($setting->couple_photo)
                <div class="mb-8" data-aos="zoom-in" data-aos-duration="1000">
                    <img src="{{ $setting->couple_photo_url }}" alt="{{ $setting->couple_name }}" 
                        class="w-32 h-32 md:w-36 md:h-36 rounded-full object-cover mx-auto border-4 border-white shadow-lg animate-pulse">
                </div>
                @endif
                
                <div class="prose prose-sm md:prose-base text-gray-600 leading-relaxed max-w-2xl mx-auto mb-8" data-aos="fade-up">
                    {!! $setting->thanks_message !!}
                </div>
                
                <div class="mb-10" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="text-3xl font-great text-primary-custom mb-3">{{ $setting->couple_name }}</h3>
                    <div class="w-16 h-0.5 bg-primary-custom/30 mx-auto"></div>
                </div>
                
                <p class="text-xs uppercase tracking-[0.2em] text-gray-400 mb-2" data-aos="fade-up" data-aos-delay="150">Kami yang berbahagia,</p>
                <p class="text-gray-800 font-semibold text-lg font-playfair mb-10" data-aos="fade-up" data-aos-delay="200">
                    {{ $setting->groom_fullname ?? $setting->groom_nickname }} & {{ $setting->bride_fullname ?? $setting->bride_nickname }}
                </p>
                
                @if($events->first())
                <p class="text-xs text-gray-400 mb-8" data-aos="fade-up" data-aos-delay="250">
                    {{ \Carbon\Carbon::parse($events->first()->date)->translatedFormat('d F Y') }}
                </p>
                @endif
                
                <div class="pt-8 border-t border-gray-100 flex flex-col items-center gap-2">
                    <p class="text-[11px] text-gray-400 uppercase tracking-widest font-medium">Made with ❤️ for the happy couple</p>
                </div>
            </div>
        </footer>
        @endif

        </div>

        @if($isVideo)
            </div>
        </div>
        @endif

        <div class="fixed right-5 top-1/2 -track-y-1/2 -translate-y-1/2 z-40 hidden lg:block">
            <div class="flex flex-col gap-3.5 bg-white/40 backdrop-blur-md p-3.5 rounded-full shadow-lg border border-white/20">
                <a href="#home" class="nav-dot w-3 h-3 rounded-full bg-gray-300 hover:bg-primary-custom transition-all duration-300 transform hover:scale-125" title="Home"></a>
                <a href="#couple" class="nav-dot w-3 h-3 rounded-full bg-gray-300 hover:bg-primary-custom transition-all duration-300 transform hover:scale-125" title="Mempelai"></a>
                @if($setting->love_story && $setting->love_story != "<p><br></p>")
                <a href="#story" class="nav-dot w-3 h-3 rounded-full bg-gray-300 hover:bg-primary-custom transition-all duration-300 transform hover:scale-125" title="Cerita"></a>
                @endif
                <a href="#events" class="nav-dot w-3 h-3 rounded-full bg-gray-300 hover:bg-primary-custom transition-all duration-300 transform hover:scale-125" title="Acara"></a>
                @if($galleries && count($galleries) > 0)
                <a href="#gallery" class="nav-dot w-3 h-3 rounded-full bg-gray-300 hover:bg-primary-custom transition-all duration-300 transform hover:scale-125" title="Galeri"></a>
                @endif
                @if($gifts && count($gifts) > 0)
                <a href="#gifts" class="nav-dot w-3 h-3 rounded-full bg-gray-300 hover:bg-primary-custom transition-all duration-300 transform hover:scale-125" title="Hadiah"></a>
                @endif
                <a href="#wishes" class="nav-dot w-3 h-3 rounded-full bg-gray-300 hover:bg-primary-custom transition-all duration-300 transform hover:scale-125" title="Ucapan"></a>
                @if($setting->thanks_message && $setting->thanks_message != "<p><br></p>")
                <a href="#thanks" class="nav-dot w-3 h-3 rounded-full bg-gray-300 hover:bg-primary-custom transition-all duration-300 transform hover:scale-125" title="Closing"></a>
                @endif
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        $(document).ready(function() {
            AOS.init({
                duration: 1000,
                once: true,
                offset: 80,
                easing: 'ease-in-out'
            });

            // Optimized loading with actual resource tracking
            function optimizedLoading() {
                const loadingBar = $('#loadingBar');
                const loadingOverlay = $('#loadingOverlay');
                const startTime = Date.now();
                const minDuration = 1200;
                const maxDuration = 5000;
                
                let resourcesLoaded = 0;
                let totalResources = 0;
                let isComplete = false;
                
                // Count all resources
                function countResources() {
                    const images = document.querySelectorAll('img');
                    const bgImages = document.querySelectorAll('[style*="background-image"]');
                    const fonts = document.querySelectorAll('link[rel="stylesheet"]');
                    const scripts = document.querySelectorAll('script[src]');
                    
                    totalResources = images.length + bgImages.length + fonts.length + scripts.length + 10; // Buffer
                }
                
                // Track progress with weighted scoring
                function calculateProgress() {
                    const images = document.querySelectorAll('img');
                    let loadedImages = 0;
                    images.forEach(img => {
                        if (img.complete && img.naturalHeight > 0) loadedImages++;
                    });
                    
                    // 60% from images, 30% from time, 10% from other resources
                    const imageScore = images.length > 0 ? (loadedImages / images.length) * 60 : 60;
                    const timeScore = Math.min(((Date.now() - startTime) / maxDuration) * 30, 30);
                    const resourceScore = Math.min((resourcesLoaded / totalResources) * 10, 10);
                    
                    return Math.min(imageScore + timeScore + resourceScore, 100);
                }
                
                // Update progress bar
                function updateProgress() {
                    if (isComplete) return;
                    
                    const progress = calculateProgress();
                    loadingBar.css('width', progress + '%');
                    
                    if (progress >= 100) {
                        isComplete = true;
                        loadingBar.css('width', '100%');
                        setTimeout(() => {
                            loadingOverlay.addClass('hidden');
                        }, 400);
                    } else {
                        requestAnimationFrame(updateProgress);
                    }
                }
                
                // Track resource loads
                function trackResource() {
                    resourcesLoaded++;
                }
                
                // Track all images
                document.querySelectorAll('img').forEach(img => {
                    if (img.complete && img.naturalHeight > 0) {
                        trackResource();
                    } else {
                        img.addEventListener('load', trackResource);
                        img.addEventListener('error', trackResource);
                    }
                });
                
                // Track background images
                document.querySelectorAll('[style*="background-image"]').forEach(el => {
                    const bgUrl = getComputedStyle(el).backgroundImage.replace(/url\(['"]?(.*?)['"]?\)/i, '$1');
                    if (bgUrl && bgUrl !== 'none') {
                        const img = new Image();
                        img.onload = trackResource;
                        img.onerror = trackResource;
                        img.src = bgUrl;
                    }
                });
                
                // Track fonts and styles
                document.querySelectorAll('link[rel="stylesheet"]').forEach(el => {
                    el.addEventListener('load', trackResource);
                    el.addEventListener('error', trackResource);
                });
                
                // Track scripts
                document.querySelectorAll('script[src]').forEach(el => {
                    el.addEventListener('load', trackResource);
                    el.addEventListener('error', trackResource);
                });
                
                // Count initial resources
                countResources();
                
                // Start the loading animation
                requestAnimationFrame(updateProgress);
                
                // Force complete after max duration
                setTimeout(() => {
                    if (!loadingOverlay.hasClass('hidden')) {
                        isComplete = true;
                        loadingBar.css('width', '100%');
                        setTimeout(() => {
                            loadingOverlay.addClass('hidden');
                        }, 300);
                    }
                }, maxDuration);
            }
            
            // Start optimized loading
            optimizedLoading();

            @if($decor_falling_petal)
            function generateFallingPetals() {
                const container = $('#heroPetals');
                if (!container.length) return;
                
                const petalCount = 20;
                for (let i = 0; i < petalCount; i++) {
                    const petal = $(`
                        <div class="floating-petal">
                            <img src="{{ $decor_falling_petal }}" alt="Petal" loading="lazy">
                        </div>
                    `);
                    const size = Math.floor(Math.random() * 25) + 15;
                    const left = Math.random() * 100;
                    const delay = Math.random() * 12;
                    const duration = Math.random() * 10 + 8;

                    petal.css({
                        'width': size + 'px',
                        'height': size + 'px',
                        'left': left + '%',
                        'animation-delay': delay + 's',
                        'animation-duration': duration + 's'
                    });
                    container.append(petal);
                }
            }
            generateFallingPetals();
            @endif

            $('#openInvitation').on('click', function() {
                const overlay = $('#openingOverlay');
                const main = $('#mainContent');
                
                window.scrollTo({ top: 0, left: 0, behavior: 'instant' });
                
                overlay.addClass('closing');
                $('body').removeClass('overflow-hidden h-screen').addClass('has-opened');
                main.removeClass('opacity-0').addClass('opacity-100');
                
                @if($setting->song_autoplay)
                const music = document.getElementById('bgMusic');
                if (music) {
                    music.play().then(() => {
                        $('#musicIcon').html('<path d="M6 4h4v16H6z M14 4h4v16h-4z" stroke="currentColor" stroke-width="2" fill="none"/>');
                    }).catch(err => {
                        console.log("Audio play deferred waiting for active permission:", err);
                    });
                }
                @endif
                
                setTimeout(() => {
                    AOS.refresh();
                }, 100);
            });

            const audio = document.getElementById('bgMusic');
            const musicToggle = document.getElementById('musicToggle');
            const musicIcon = $('#musicIcon');
            let isMusicPlaying = {{ $setting->song_autoplay ? 'true' : 'false' }};

            const iconPlayMarkup = '<path d="M9 18V5l12-2v13M9 18c0 1.105-1.119 2-2.5 2S4 19.105 4 18s1.119-2 2.5-2 2.5.895 2.5 2zm12-2c0 1.105-1.119 2-2.5 2s-2.5-.895-2.5-2 1.119-2 2.5-2 2.5.895 2.5 2zM9 10l12-2" stroke="currentColor" stroke-width="2" fill="none"/>';
            const iconPauseMarkup = '<path d="M6 4h4v16H6z M14 4h4v16h-4z" stroke="currentColor" stroke-width="2" fill="none"/>';

            if (musicToggle && audio) {
                musicToggle.onclick = function() {
                    if (isMusicPlaying) {
                        audio.pause();
                        musicIcon.html(iconPlayMarkup);
                    } else {
                        audio.play().then(() => {
                            musicIcon.html(iconPauseMarkup);
                        });
                    }
                    isMusicPlaying = !isMusicPlaying;
                };
            }

            @if($events->first())
                function startWeddingCountdown() {
                    @php
                        $targetDateRaw = $events->first()->date->format('Y-m-d') . ' ' . $events->first()->time_start->format('H:i:s');
                    @endphp
                    const targetTime = new Date('{{ $targetDateRaw }}').getTime();
                    
                    const tracker = setInterval(function() {
                        const now = new Date().getTime();
                        const gap = targetTime - now;

                        if (gap < 0) {
                            clearInterval(tracker);
                            $('#days').text('0');
                            $('#hours').text('0');
                            $('#minutes').text('0');
                            $('#seconds').text('0');
                            return;
                        }

                        const d = Math.floor(gap / (1000 * 60 * 60 * 24));
                        const h = Math.floor((gap % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const m = Math.floor((gap % (1000 * 60 * 60)) / (1000 * 60));
                        const s = Math.floor((gap % (1000 * 60)) / 1000);

                        $('#days').text(d);
                        $('#hours').text(h);
                        $('#minutes').text(m);
                        $('#seconds').text(s);
                    }, 1000);
                }
                startWeddingCountdown();
            @endif

            $('#wishForm').on('submit', function(event) {
                event.preventDefault();
                
                const submitButton = $('#submitWishBtn');
                const btnText = submitButton.find('.btn-text');
                const btnLoading = submitButton.find('.btn-loading');
                
                btnText.addClass('hidden');
                btnLoading.removeClass('hidden');
                submitButton.prop('disabled', true);

                $.ajax({
                    url: '{{ route("api.wishes.store") }}',
                    method: 'POST',
                    data: {
                        name: $('#wishName').val(),
                        email: $('#wishEmail').val(),
                        message: $('#wishMessage').val(),
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                text: 'Terima kasih banyak atas pesan bahagia dan doanya.',
                                showConfirmButton: false,
                                timer: 2500,
                            });
                            
                            $('#wishName').val('');
                            $('#wishEmail').val('');
                            $('#wishMessage').val('');
                            
                            reloadWishesFeed();
                        }
                    },
                    error: function(err) {
                        Swal.fire({
                            icon: 'error',
                            text: err.responseJSON?.message || 'Terjadi gangguan saat mengirim doa. Coba kembali beberapa saat.',
                            confirmButtonText: 'Kembali'
                        });
                    },
                    complete: function() {
                        btnText.removeClass('hidden');
                        btnLoading.addClass('hidden');
                        submitButton.prop('disabled', false);
                    }
                });
            });

            function reloadWishesFeed() {
                $.ajax({
                    url: '{{ route("api.wishes") }}',
                    method: 'GET',
                    success: function(data) {
                        const wishesList = $('#wishesList');
                        wishesList.empty();
                        
                        if (data.length === 0) {
                            wishesList.html('<p class="text-gray-400 text-center py-8 text-sm">Belum ada ucapan. Kirim ucapan pertama Anda!</p>');
                            return;
                        }
                        
                        data.forEach(function(item) {
                            const dateObj = new Date(item.created_at);
                            const now = new Date();
                            const diffInMs = Math.abs(now - dateObj);
                            
                            const mins = Math.floor(diffInMs / (1000 * 60));
                            const hrs = Math.floor(diffInMs / (1000 * 60 * 60));
                            const days = Math.floor(diffInMs / (1000 * 60 * 60 * 24));
                            
                            let relativeTime = '';
                            if (days > 30) {
                                relativeTime = Math.floor(days / 30) + ' bulan lalu';
                            } else if (days > 0) {
                                relativeTime = days + ' hari lalu';
                            } else if (hrs > 0) {
                                relativeTime = hrs + ' jam lalu';
                            } else if (mins > 0) {
                                relativeTime = mins + ' menit lalu';
                            } else {
                                relativeTime = 'Baru saja';
                            }
                            
                            const initials = item.name.charAt(0).toUpperCase();
                            
                            wishesList.append(`
                                <div class="bg-gray-50/50 rounded-2xl p-4 border border-gray-100" data-aos="fade-up">
                                    <div class="flex items-start gap-4">
                                        <div class="w-10 h-10 rounded-full bg-gradient-custom flex items-center justify-center text-white font-semibold flex-shrink-0 text-sm">
                                            <span>${initials}</span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between mb-1 gap-2 flex-wrap">
                                                <h4 class="font-semibold text-gray-800 text-sm truncate max-w-[150px]">${item.name}</h4>
                                                <span class="text-[10px] text-gray-400 font-medium">${relativeTime}</span>
                                            </div>
                                            <p class="text-gray-600 text-sm break-words whitespace-pre-wrap leading-relaxed">${item.message}</p>
                                        </div>
                                    </div>
                                </div>
                            `);
                        });
                    }
                });
            }

            window.copyAccountNumber = function(accNo) {
                navigator.clipboard.writeText(accNo).then(function() {
                    Swal.fire({
                        icon: 'success',
                        text: 'Nomor rekening berhasil disalin ke papan klip.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        background: 'var(--primary-color)',
                        iconColor: '#ffffff',
                        customClass: {
                            title: 'text-white text-sm font-sans',
                            htmlContainer: 'text-white/90 text-xs'
                        }
                    });
                }).catch(function() {
                    Swal.fire({
                        icon: 'error',
                        text: 'Gagal menyalin nomor rekening.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000
                    });
                });
            };

            @if($galleries && count($galleries) > 0)
            new Swiper(".mySwiper", {
                effect: "coverflow",
                grabCursor: true,
                centeredSlides: true,
                slidesPerView: "auto",
                coverflowEffect: {
                    rotate: 35,
                    stretch: 5,
                    depth: 100,
                    modifier: 1.2,
                    slideShadows: true,
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                loop: true,
            });
            @endif

            const sections = $('section[id]');
            const navDots = $('.nav-dot');
            
            $(window).on('scroll', function() {
                let activeId = '';
                const scrollPos = $(window).scrollTop() + 250;
                
                sections.each(function() {
                    const top = $(this).offset().top;
                    const height = $(this).outerHeight();
                    
                    if (scrollPos >= top && scrollPos < top + height) {
                        activeId = $(this).attr('id');
                    }
                });
                
                navDots.each(function() {
                    const dot = $(this);
                    dot.removeClass('bg-primary-custom scale-125').addClass('bg-gray-300');
                    if (dot.attr('href') === `#${activeId}`) {
                        dot.addClass('bg-primary-custom scale-125').removeClass('bg-gray-300');
                    }
                });
            });
        });
    </script>
</body>
</html>