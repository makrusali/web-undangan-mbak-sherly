<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
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

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $setting->couple_name ?? 'Wedding Invitation' }}" />
    <meta name="twitter:description" content="Undangan Pernikahan {{ $setting->couple_name }}" />
    @if($setting && $setting->couple_photo)
    <meta name="twitter:image" content="{{ $setting->couple_photo_url }}" />
    @elseif($setting && $setting->hero_image)
    <meta name="twitter:image" content="{{ $setting->hero_image_url }}" />
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css'])
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sacramento&display=swap');
        
        * {
            scroll-behavior: smooth;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            background-color: #f8fafc;
            width: 100%;
            max-width: 100vw;
        }
        
        .font-sacramento {
            font-family: 'Sacramento', cursive;
        }
        
        .font-great {
            font-family: 'Great Vibes', cursive;
        }
        
        .font-playfair {
            font-family: 'Playfair Display', serif;
        }
        
        /* Blue Theme - Pure Blue */
        :root {
            --blue-primary: #2563eb;
            --blue-secondary: #3b82f6;
            --blue-light: #93c5fd;
            --blue-very-light: #dbeafe;
            --blue-dark: #1d4ed8;
            --blue-gradient: linear-gradient(135deg, #2563eb, #3b82f6, #60a5fa);
        }
        
        .bg-blue-gradient {
            background: var(--blue-gradient);
        }
        
        .text-blue-primary {
            color: var(--blue-primary);
        }
        
        .border-blue-primary {
            border-color: var(--blue-primary);
        }
        
        /* Hero Section with Floating Petals */
        .hero-section {
            position: relative;
            min-height: 100vh;
            width: 100%;
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('{{ $setting->hero_image_url }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            overflow: hidden;
        }
        
        .floating-petal {
            position: absolute;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 150% 0 150% 0;
            opacity: 0.4;
            pointer-events: none;
            animation: fall linear infinite;
        }
        
        @keyframes fall {
            to {
                transform: translateY(100vh) rotate(360deg);
            }
        }
        
        /* Beautiful Opening Animation - No Scale */
        .opening-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--blue-gradient);
            z-index: 15000; /* Lower than loading overlay (20000) */
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 1.5s ease, visibility 1.5s ease;
            overflow-y: auto;
            padding: 20px;
        }
        
        .opening-overlay.closing {
            opacity: 0;
            visibility: hidden;
        }
        
        .opening-content {
            text-align: center;
            color: white;
            animation: floatIn 2s ease-out;
            max-width: 90%;
            margin: auto;
        }
        
        @keyframes floatIn {
            0% {
                opacity: 0;
                transform: translateY(50px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .opening-flower {
            animation: rotate 20s linear infinite;
            margin-bottom: 2rem;
        }
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .opening-title {
            font-size: clamp(2rem, 8vw, 3rem);
            font-family: 'Great Vibes', cursive;
            margin-bottom: 1rem;
            opacity: 0;
            animation: fadeInUp 1s ease-out 0.5s forwards;
        }
        
        .opening-subtitle {
            font-size: clamp(0.9rem, 3vw, 1.2rem);
            letter-spacing: 0.3em;
            text-transform: uppercase;
            opacity: 0;
            animation: fadeInUp 1s ease-out 0.8s forwards;
        }
        
        .opening-couple {
            font-size: clamp(2.5rem, 10vw, 4rem);
            font-family: 'Great Vibes', cursive;
            margin: 2rem 0;
            opacity: 0;
            animation: fadeInUp 1s ease-out 1.1s forwards;
        }
        
        .opening-date {
            font-size: clamp(0.9rem, 3vw, 1.1rem);
            opacity: 0;
            animation: fadeInUp 1s ease-out 1.4s forwards;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .opening-button {
            margin-top: 3rem;
            padding: 1rem 2rem;
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid white;
            border-radius: 50px;
            color: white;
            font-size: clamp(0.9rem, 3vw, 1.1rem);
            cursor: pointer;
            transition: all 0.3s ease;
            opacity: 0;
            animation: fadeInUp 1s ease-out 1.7s forwards;
            backdrop-filter: blur(5px);
            width: auto;
            max-width: 90%;
            white-space: nowrap;
        }
        
        .opening-button:hover {
            background: white;
            color: var(--blue-primary);
            transform: scale(1.05);
        }
        
        /* Floating Animation */
        .float {
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        
        /* Pulse Animation */
        .pulse {
            animation: pulse 2s ease-in-out infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        /* Gallery Styles */
        .swiper {
            width: 100%;
            padding-top: 50px;
            padding-bottom: 50px;
        }
        
        .swiper-slide {
            background-position: center;
            background-size: cover;
            width: 280px;
            height: 350px;
        }
        
        @media (max-width: 640px) {
            .swiper-slide {
                width: 240px;
                height: 300px;
            }
        }
        
        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 1px;
        }
        
        ::-webkit-scrollbar-track {
            background: #dbeafe;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #3b82f6;
            border-radius: 1px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #1d4ed8;
        }
        
        /* Hide main content initially */
        .main-content {
            opacity: 0;
            transition: opacity 1.5s ease;
            width: 100%;
            overflow-x: hidden;
        }
        
        .main-content.visible {
            opacity: 1;
        }

        /* Countdown styling */
        .countdown-item {
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            border-radius: 1rem;
            padding: 1rem;
            min-width: 80px;
            box-shadow: 0 10px 25px -5px rgba(37, 99, 235, 0.3);
            color: white;
        }
        
        @media (max-width: 640px) {
            .countdown-item {
                min-width: 60px;
                padding: 0.75rem;
            }
        }

        /* SVG Icons */
        .icon {
            width: 24px;
            height: 24px;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }
        
        /* Gift Card Styles */
        .gift-card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .gift-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(37, 99, 235, 0.3);
        }
        
        /* Couple photo styles - no longer circle */
        .couple-photo {
            width: 280px;
            height: 350px;
            object-fit: cover;
            border-radius: 20px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            border: 4px solid white;
        }
        
        @media (max-width: 768px) {
            .couple-photo {
                width: 240px;
                height: 300px;
            }
        }
        
        /* Mobile container fixes */
        .container-fix {
            width: 100%;
            max-width: 100vw;
            overflow-x: hidden;
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        section {
            width: 100%;
            overflow-x: hidden;
        }

                /* Custom SweetAlert styling to match blue theme */
        .swal2-popup {
            border-radius: 20px !important;
            font-family: 'Inter', sans-serif !important;
        }

        .swal2-title {
            color: #2563eb !important;
            font-family: 'Great Vibes', cursive !important;
            font-size: 1.8rem !important;
        }

        .swal2-html-container {
            color: #4b5563 !important;
            font-size: 1rem !important;
        }

        .swal2-icon-success {
            border-color: #2563eb !important;
            color: #2563eb !important;
        }

        .swal2-icon-success .swal2-success-ring {
            border-color: #2563eb !important;
        }

        .swal2-icon-success [class^='swal2-success-line'] {
            background-color: #2563eb !important;
        }

        .swal2-icon-error {
            border-color: #ef4444 !important;
            color: #ef4444 !important;
        }

        .swal2-toast {
            background: linear-gradient(135deg, #2563eb, #3b82f6) !important;
            border-radius: 12px !important;
            color: white !important;
            box-shadow: 0 10px 25px -5px rgba(37, 99, 235, 0.3) !important;
        }

        .swal2-toast .swal2-title {
            color: white !important;
            font-size: 1rem !important;
            font-family: 'Inter', sans-serif !important;
        }

        .swal2-toast .swal2-html-container {
            color: rgba(255,255,255,0.9) !important;
        }

        .swal2-toast .swal2-icon-success {
            border-color: white !important;
            color: white !important;
        }

        .swal2-toast .swal2-icon-success .swal2-success-ring {
            border-color: rgba(255,255,255,0.3) !important;
        }

        .swal2-toast .swal2-icon-success [class^='swal2-success-line'] {
            background-color: white !important;
            border-color: white !important;
        }

        /* Improved Couple Section Styling */
        #couple .group {
            position: relative;
            padding: 2rem;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.02), rgba(59, 130, 246, 0.05));
            border-radius: 40px;
            transition: all 0.3s ease;
        }

        #couple .group:hover {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.05), rgba(59, 130, 246, 0.08));
            transform: translateY(-5px);
        }

        #couple .group::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 40px;
            padding: 2px;
            background: linear-gradient(135deg, #2563eb, #3b82f6, #60a5fa);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        #couple .group:hover::before {
            opacity: 1;
        }

        .couple-photo {
            width: 280px;
            height: 350px;
            object-fit: cover;
            border-radius: 30px;
            box-shadow: 0 20px 30px -10px rgba(37, 99, 235, 0.2);
            border: 4px solid white;
            transition: all 0.5s ease;
        }

        .couple-photo-wrapper {
            position: relative;
            display: inline-block;
        }

        .couple-photo-wrapper::after {
            content: '';
            position: absolute;
            inset: -10px;
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            border-radius: 40px;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: -1;
        }

        .group:hover .couple-photo-wrapper::after {
            opacity: 0.3;
        }

        /* Improved Thanks Section Styling */
        #thanks {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.03), rgba(59, 130, 246, 0.05));
            position: relative;
            isolation: isolate;
        }

        #thanks::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url('data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M30 0l30 30-30 30L0 30z' fill='%232563eb' fill-opacity='0.03'/%3E%3C/svg%3E');
            opacity: 0.5;
            z-index: -1;
        }

        #thanks .prose {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            padding: 3rem;
            border-radius: 40px;
            box-shadow: 0 20px 40px -15px rgba(37, 99, 235, 0.15);
            border: 1px solid rgba(37, 99, 235, 0.1);
            margin: 2rem auto;
            max-width: 800px;
        }

        #thanks .prose p {
            font-size: 1.2rem;
            line-height: 1.8;
            color: #374151;
            margin-bottom: 1.5rem;
        }

        #thanks .prose p:last-child {
            margin-bottom: 0;
        }

        #thanks .prose strong {
            color: #2563eb;
            font-weight: 600;
        }

        #thanks .prose em {
            color: #3b82f6;
            font-style: italic;
        }

        #thanks .font-great {
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        #thanks .text-gray-600 {
            position: relative;
            display: inline-block;
            padding: 0.5rem 2rem;
        }

        #thanks .text-gray-600:last-of-type {
            font-size: 1.2rem;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.1), rgba(59, 130, 246, 0.1));
            border-radius: 50px;
            padding: 1rem 3rem;
            margin-top: 2rem;
            color: #2563eb;
            font-weight: 500;
        }

        /* Decorative elements for thanks section */
        #thanks .floating-hearts {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        #thanks .floating-hearts::before,
        #thanks .floating-hearts::after {
            content: '❤️';
            position: absolute;
            font-size: 2rem;
            opacity: 0.1;
            animation: floatHeart 6s ease-in-out infinite;
        }

        #thanks .floating-hearts::before {
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        #thanks .floating-hearts::after {
            bottom: 20%;
            right: 10%;
            animation-delay: 3s;
        }

        @keyframes floatHeart {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(10deg);
            }
        }

        /* Add smooth transitions */
        #thanks img {
            transition: all 0.5s ease;
            border: 4px solid white;
            box-shadow: 0 20px 30px -10px rgba(37, 99, 235, 0.2);
        }

        #thanks img:hover {
            transform: scale(1.02);
            box-shadow: 0 25px 35px -10px rgba(37, 99, 235, 0.3);
        }

        /* Loading Animation */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--blue-gradient);
            z-index: 20000;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 1s ease, visibility 1s ease;
        }

        .loading-overlay.hidden {
            opacity: 0;
            visibility: hidden;
        }

        .loading-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            color: white;
            max-width: 90%;
        }

        .loading-heart {
            margin-bottom: 2rem;
            animation: pulse 1.5s ease-in-out infinite;
        }

        .loading-text {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            font-weight: 300;
            letter-spacing: 2px;
        }

        .loading-bar-container {
            width: 250px;
            height: 4px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            overflow: hidden;
            margin: 0 auto 1rem;
        }

        .loading-bar {
            width: 0%;
            height: 100%;
            background: white;
            border-radius: 10px;
            transition: width 0.3s ease;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
        }

        .loading-percentage {
            font-size: 1rem;
            font-weight: 300;
            color: rgba(255, 255, 255, 0.9);
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
        }
    </style>

    <script>
        // Loading animation
        $(document).ready(function() {
            // Simulate loading progress
            let progress = 0;
            const loadingBar = document.getElementById('loadingBar');
            const loadingPercentage = document.getElementById('loadingPercentage');
            const loadingOverlay = document.getElementById('loadingOverlay');
            
            const interval = setInterval(function() {
                progress += Math.random() * 15;
                if (progress >= 100) {
                    progress = 100;
                    clearInterval(interval);
                    
                    // Hide loading overlay and show opening overlay after a short delay
                    setTimeout(function() {
                        loadingOverlay.classList.add('hidden');
                    }, 500);
                }
                
                if (loadingBar) {
                    loadingBar.style.width = progress + '%';
                }
                if (loadingPercentage) {
                    loadingPercentage.textContent = Math.round(progress) + '%';
                }
            }, 200);
            
            // Preload all images
            const images = [];
            
            @if($setting && $setting->hero_image)
                images.push('{{ $setting->hero_image_url }}');
            @endif
            
            @if($setting && $setting->groom_photo)
                images.push('{{ $setting->groom_photo_url }}');
            @endif
            
            @if($setting && $setting->bride_photo)
                images.push('{{ $setting->bride_photo_url }}');
            @endif
            
            @if($setting && $setting->couple_photo)
                images.push('{{ $setting->couple_photo_url }}');
            @endif
            
            @foreach($events ?? [] as $event)
                @if($event->image)
                    images.push('{{ $event->image_url }}');
                @endif
            @endforeach
            
            @foreach($galleries ?? [] as $gallery)
                images.push('{{ $gallery->image_url }}');
            @endforeach
            
            // Preload images
            if (images.length > 0) {
                images.forEach(src => {
                    const img = new Image();
                    img.src = src;
                });
            }
        });
    </script>
</head>
<body class="overflow-x-hidden">
    <!-- Loading Animation -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-content">
            <!-- Animated Heart -->
            <div class="loading-heart">
                <svg width="100" height="100" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" 
                        fill="white" fill-opacity="0.9" stroke="white" stroke-width="1">
                        <animate attributeName="d" 
                            dur="1.5s" 
                            values="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z;
                                M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z;
                                M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"
                            repeatCount="indefinite" />
                    </path>
                </svg>
            </div>
            
            <!-- Loading Bar -->
            <div class="loading-bar-container">
                <div class="loading-bar" id="loadingBar"></div>
            </div>
            
            <div class="loading-percentage" id="loadingPercentage">0%</div>
        </div>
    </div>

    <!-- Beautiful Opening Animation -->
    <div class="opening-overlay" id="openingOverlay">
        <div class="opening-content">
            <!-- Animated Flower SVG -->
            <div class="opening-flower">
                <svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C12 2 12 5 9 8C6 11 2 12 2 12C2 12 6 13 9 16C12 19 12 22 12 22C12 22 12 19 15 16C18 13 22 12 22 12C22 12 18 11 15 8C12 5 12 2 12 2Z" 
                        fill="white" fill-opacity="0.3" stroke="white" stroke-width="1"/>
                    <circle cx="12" cy="12" r="3" fill="white" fill-opacity="0.8"/>
                </svg>
            </div>
            
            <div class="opening-title">Undangan Pernikahan</div>
            <div class="opening-couple">{{ $setting->couple_name }}</div>
            <div class="opening-subtitle">THE WEDDING</div>
            @if($events->first())
            <div class="opening-date">{{ \Carbon\Carbon::parse($events->first()->date)->translatedFormat('l, d F Y') }}</div>
            @endif
            <button class="opening-button" id="openInvitation">
                Buka Undangan
                <svg class="inline-block ml-2" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M19 14l-7 7-7-7M12 21V3"/>
                </svg>
            </button>
        </div>
    </div>



    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Music Control -->
        @if($setting->song_file)
        <button id="musicToggle" class="fixed bottom-6 right-6 z-50 w-14 h-14 rounded-full bg-blue-gradient text-white flex items-center justify-center shadow-2xl hover:scale-110 transition-all duration-300 pulse">
            <svg id="musicIcon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path d="M9 18V5l12-2v13M9 18c0 1.105-1.119 2-2.5 2S4 19.105 4 18s1.119-2 2.5-2 2.5.895 2.5 2zm12-2c0 1.105-1.119 2-2.5 2s-2.5-.895-2.5-2 1.119-2 2.5-2 2.5.895 2.5 2zM9 10l12-2"/>
            </svg>
        </button>
        <audio id="bgMusic" loop>
            <source src="{{ $setting->song_file_url }}" type="audio/mpeg">
        </audio>
        @endif

        <!-- Hero Section -->
        <section class="hero-section relative flex items-center justify-center text-white" id="home">
            <div class="absolute inset-0 bg-gradient-to-b from-black/30 via-black/20 to-black/30"></div>
            
            <div class="relative z-10 text-center px-4 w-full max-w-6xl mx-auto" data-aos="fade-up" data-aos-duration="1500">
                <span class="text-sm tracking-[0.3em] uppercase mb-4 block opacity-90">Undangan Pernikahan</span>
                <h1 class="font-great text-5xl md:text-7xl lg:text-8xl mb-6 float break-words">{{ $setting->couple_name }}</h1>
                <div class="w-24 h-1 bg-white mx-auto mb-8"></div>
                <p class="text-lg md:text-xl lg:text-2xl max-w-2xl mx-auto mb-12 font-light leading-relaxed px-4">
                    {!! $setting->invitation_text_with_guest !!}
                </p>
                
                <!-- Scroll Indicator -->
                <div class="absolute -bottom-32 left-1/2 transform -translate-x-1/2 animate-bounce">
                    <div class="flex flex-col items-center">
                        <span class="text-xs uppercase tracking-wider mb-2 opacity-70">Scroll</span>
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7-7-7M12 21V3"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </section>

        <!-- Couple Section -->
        <section class="py-20 px-4 bg-white relative" id="couple" data-aos="fade-up">
            <div class="max-w-6xl mx-auto w-full">
                <div class="text-center mb-16">
                    <span class="text-blue-primary text-sm tracking-[0.3em] uppercase mb-4 block">Mempelai</span>
                    <h2 class="font-great text-4xl md:text-5xl lg:text-6xl text-gray-800 mb-4">Kedua Mempelai</h2>
                    <div class="w-24 h-1 bg-blue-primary mx-auto"></div>
                </div>
                
                <div class="grid md:grid-cols-2 gap-8 lg:gap-12 px-4">
                    <!-- Groom -->
                    <div class="text-center group" data-aos="fade-right" data-aos-delay="200">
                        <div class="relative mb-8 inline-block">
                            @if($setting->groom_photo)
                                <img src="{{ $setting->groom_photo_url }}" alt="{{ $setting->groom_fullname }}" 
                                     class="couple-photo group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="couple-photo bg-blue-gradient flex items-center justify-center">
                                    <span class="text-7xl text-white">{{ substr($setting->groom_nickname ?? 'G', 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <h3 class="text-3xl font-great text-gray-800 mb-2">{{ $setting->groom_nickname ?? 'Groom' }}</h3>
                        <p class="text-xl text-gray-600 mb-3">{{ $setting->groom_fullname }}</p>
                        <p class="text-gray-500 mb-4">Putra dari {{ $setting->groom_parents ?? 'Bapak & Ibu' }}</p>
                        @if($setting->groom_instagram)
                        <a href="https://instagram.com/{{ $setting->groom_instagram }}" target="_blank" 
                           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-gradient text-white rounded-full hover:shadow-xl transition-all duration-300">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
                            </svg>
                            {{ $setting->groom_instagram }}
                        </a>
                        @endif
                    </div>

                    <!-- Bride -->
                    <div class="text-center group" data-aos="fade-left" data-aos-delay="400">
                        <div class="relative mb-8 inline-block">
                            @if($setting->bride_photo)
                                <img src="{{ $setting->bride_photo_url }}" alt="{{ $setting->bride_fullname }}" 
                                     class="couple-photo group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="couple-photo bg-blue-gradient flex items-center justify-center">
                                    <span class="text-7xl text-white">{{ substr($setting->bride_nickname ?? 'B', 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <h3 class="text-3xl font-great text-gray-800 mb-2">{{ $setting->bride_nickname ?? 'Bride' }}</h3>
                        <p class="text-xl text-gray-600 mb-3">{{ $setting->bride_fullname }}</p>
                        <p class="text-gray-500 mb-4">Putri dari {{ $setting->bride_parents ?? 'Bapak & Ibu' }}</p>
                        @if($setting->bride_instagram)
                        <a href="https://instagram.com/{{ $setting->bride_instagram }}" target="_blank" 
                           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-gradient text-white rounded-full hover:shadow-xl transition-all duration-300">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
                            </svg>
                            {{ $setting->bride_instagram }}
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- Love Story Section -->
        @if($setting->love_story && $setting->love_story != "<p><br></p>")
        <section class="py-20 px-4 bg-blue-very-light relative overflow-hidden" id="story">
            <div class="absolute top-0 left-0 w-64 h-64 bg-blue-light/20 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-light/20 rounded-full translate-x-1/2 translate-y-1/2"></div>
            
            <div class="max-w-4xl mx-auto relative z-10 px-4">
                <div class="text-center mb-16" data-aos="fade-up">
                    <span class="text-blue-primary text-sm tracking-[0.3em] uppercase mb-4 block">Love Story</span>
                    <h2 class="font-great text-4xl md:text-5xl lg:text-6xl text-gray-800 mb-4">Cerita Cinta Kami</h2>
                    <div class="w-24 h-1 bg-blue-primary mx-auto"></div>
                </div>
                
                <div class="prose prose-lg max-w-none text-gray-600 leading-relaxed" data-aos="fade-up" data-aos-delay="200">
                    {!! $setting->love_story !!}
                </div>
            </div>
        </section>
        @endif

        <!-- Events Section -->
        @if($events->count() > 0)
        <section class="py-20 px-4 bg-white relative" id="events">
            <div class="max-w-6xl mx-auto w-full">
                <div class="text-center mb-16" data-aos="fade-up">
                    <span class="text-blue-primary text-sm tracking-[0.3em] uppercase mb-4 block">Wedding Events</span>
                    <h2 class="font-great text-4xl md:text-5xl lg:text-6xl text-gray-800 mb-4">Acara Pernikahan</h2>
                    <div class="w-24 h-1 bg-blue-primary mx-auto"></div>
                </div>
                
                <div class="grid md:grid-cols-{{ min($events->count(), 2) }} gap-6 md:gap-8 px-4">
                    @foreach($events as $index => $event)
                    <div class="bg-gradient-to-br from-white to-blue-50 rounded-3xl p-6 md:p-8 shadow-2xl hover:shadow-3xl transition-all duration-500 group"
                         data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 200 }}">
                        <div class="relative overflow-hidden rounded-2xl mb-6">
                            @if($event->image)
                                <img src="{{ $event->image_url }}" alt="{{ $event->name }}" 
                                     class="w-full h-48 md:h-56 object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="w-full h-48 md:h-56 bg-blue-gradient flex items-center justify-center">
                                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.5">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                        <line x1="16" y1="2" x2="16" y2="6"/>
                                        <line x1="8" y1="2" x2="8" y2="6"/>
                                        <line x1="3" y1="10" x2="21" y2="10"/>
                                        <path d="M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01M16 18h.01"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                            <h3 class="absolute bottom-4 left-4 text-xl md:text-2xl font-great text-white">{{ $event->name }}</h3>
                        </div>
                        
                        <div class="space-y-4">
                            <!-- Date (separated) -->
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-blue-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                        <line x1="16" y1="2" x2="16" y2="6"/>
                                        <line x1="8" y1="2" x2="8" y2="6"/>
                                        <line x1="3" y1="10" x2="21" y2="10"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Tanggal</p>
                                    <p class="font-semibold text-gray-800 text-sm md:text-base">{{ \Carbon\Carbon::parse($event->date)->translatedFormat('l, d F Y') }}</p>
                                </div>
                            </div>
                            
                            <!-- Time (separated) -->
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-blue-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Waktu</p>
                                    <p class="font-semibold text-gray-800 text-sm md:text-base">
                                        {{ \Carbon\Carbon::parse($event->time_start)->format('H:i') }} 
                                        @if($event->time_end)
                                            - {{ \Carbon\Carbon::parse($event->time_end)->format('H:i') }} WIB
                                        @else
                                            WIB - SELESAI
                                        @endif
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Location -->
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-blue-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                        <circle cx="12" cy="10" r="3"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Lokasi</p>
                                    <p class="font-semibold text-gray-800 text-sm md:text-base">{{ $event->location_name }}</p>
                                    <p class="text-sm text-gray-600">{{ $event->address }}</p>
                                    @if($event->gmaps_link)
                                    <a href="{{ $event->gmaps_link }}" target="_blank" 
                                       class="inline-flex items-center gap-2 mt-2 text-blue-primary hover:underline text-sm">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                                            <polyline points="15 3 21 3 21 9"/>
                                            <line x1="10" y1="14" x2="21" y2="3"/>
                                        </svg>
                                        Buka Google Maps
                                    </a>
                                    @endif
                                </div>
                            </div>
                            
                            @if($event->description)
                            <p class="text-gray-600 mt-4 italic text-sm">{{ $event->description }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Countdown -->
                @if($events->first())
                    @php
                        // Format date and time for Google Calendar
                        $eventDate = \Carbon\Carbon::parse($events->first()->date);
                        $startTime = \Carbon\Carbon::parse($events->first()->time_start);
                        $endTime = $events->first()->time_end ? \Carbon\Carbon::parse($events->first()->time_end) : $startTime->copy()->addHours(2);
                        
                        // Format for Google Calendar (YYYYMMDDTHHmmSS)
                        $startDateTime = $eventDate->format('Ymd') . 'T' . $startTime->format('His');
                        $endDateTime = $eventDate->format('Ymd') . 'T' . $endTime->format('His');
                        
                        // Format for display
                        $formattedDate = $eventDate->translatedFormat('l, d F Y');
                        $formattedStartTime = $startTime->format('H:i');
                        $formattedEndTime = $endTime->format('H:i');
                    @endphp

                    <div class="mt-16 text-center" data-aos="fade-up">
                        <h3 class="text-2xl font-great text-gray-800 mb-6">Menuju Hari Bahagia</h3>
                        
                        <!-- Event Date and Time Display -->
                        <div class="mb-6 text-gray-600">
                            <p class="text-lg font-medium">{{ $formattedDate }}</p>
                            {{-- <p class="text-md">Pukul {{ $formattedStartTime }} - {{ $formattedEndTime }} WIB</p> --}}
                        </div>
                        
                        <div class="flex justify-center gap-2 md:gap-4 flex-wrap px-4 mb-8" id="countdown">
                            <div class="countdown-item">
                                <span class="text-xl md:text-3xl font-bold block" id="days">0</span>
                                <span class="text-xs uppercase tracking-wider">Hari</span>
                            </div>
                            <div class="countdown-item">
                                <span class="text-xl md:text-3xl font-bold block" id="hours">0</span>
                                <span class="text-xs uppercase tracking-wider">Jam</span>
                            </div>
                            <div class="countdown-item">
                                <span class="text-xl md:text-3xl font-bold block" id="minutes">0</span>
                                <span class="text-xs uppercase tracking-wider">Menit</span>
                            </div>
                            <div class="countdown-item">
                                <span class="text-xl md:text-3xl font-bold block" id="seconds">0</span>
                                <span class="text-xs uppercase tracking-wider">Detik</span>
                            </div>
                        </div>
                        
                        <!-- Google Calendar Button -->
                        <div class="flex justify-center">
                            <a href="https://www.google.com/calendar/render?action=TEMPLATE&text={{ urlencode($setting->couple_name . ' - Pernikahan') }}&dates={{ $startDateTime }}/{{ $endDateTime }}&details={{ urlencode(strip_tags($setting->invitation_text_with_guest)) }}&location={{ urlencode($events->first()->location_name . ', ' . $events->first()->address) }}&sf=true&output=xml" 
                            target="_blank"
                            class="inline-flex items-center gap-3 px-6 py-3 bg-white border-2 border-blue-500 text-blue-600 rounded-full hover:bg-blue-50 transition-all duration-300 shadow-md hover:shadow-lg group">
                                <!-- Google Calendar SVG Icon -->
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 9H21M7 3V5M17 3V5M6 12H8M11 12H13M16 12H18M6 16H8M11 16H13M16 16H18M6 20H8M11 20H13M16 20H18M5 21H19C20.1046 21 21 20.1046 21 19V7C21 5.89543 20.1046 5 19 5H5C3.89543 5 3 5.89543 3 7V19C3 20.1046 3.89543 21 5 21Z" 
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    <path d="M8 12H8.01M12 12H12.01M16 12H16.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                                <span class="font-medium">Simpan ke Google Kalender</span>
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                    @endif
            </div>
        </section>
        @endif

        <!-- Gallery Section -->
        <section class="py-20 px-4 bg-blue-very-light" id="gallery">
            <div class="max-w-6xl mx-auto w-full">
                <div class="text-center mb-16" data-aos="fade-up">
                    <span class="text-blue-primary text-sm tracking-[0.3em] uppercase mb-4 block">Gallery</span>
                    <h2 class="font-great text-4xl md:text-5xl lg:text-6xl text-gray-800 mb-4">Momen Berharga</h2>
                    <div class="w-24 h-1 bg-blue-primary mx-auto"></div>
                </div>
                
                <!-- Swiper Gallery -->
                <div class="swiper mySwiper px-4" data-aos="fade-up">
                    <div class="swiper-wrapper">
                        @foreach($galleries ?? [] as $gallery)
                        <div class="swiper-slide">
                            <img src="{{ $gallery->image_url }}" alt="Gallery Image" class="rounded-2xl">
                        </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </section>

        <!-- Gifts Section -->
        <section class="py-20 px-4 bg-white" id="gifts">
            <div class="max-w-6xl mx-auto w-full">
                <div class="text-center mb-16" data-aos="fade-up">
                    <span class="text-blue-primary text-sm tracking-[0.3em] uppercase mb-4 block">Wedding Gifts</span>
                    <h2 class="font-great text-4xl md:text-5xl lg:text-6xl text-gray-800 mb-4">Hadiah Pernikahan</h2>
                    <div class="w-24 h-1 bg-blue-primary mx-auto mb-8"></div>
                    <p class="text-gray-600 max-w-2xl mx-auto">
                        Doa restu Anda adalah hadiah terbesar bagi kami. Namun jika Anda ingin memberikan hadiah lainnya, berikut adalah detail rekening kami:
                    </p>
                </div>
                
                <div class="grid md:grid-cols-2 gap-6 lg:gap-8 px-4" data-aos="fade-up">
                    @php
                        use App\Models\Gift;
                        $gifts = Gift::where('is_active', true)->get();
                    @endphp
                    
                    @forelse($gifts as $gift)
                    <div class="gift-card hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 bg-blue-gradient rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <rect x="2" y="6" width="20" height="16" rx="2" />
                                    <path d="M12 6V2" />
                                    <path d="M7 6L5 2" />
                                    <path d="M17 6l2-4" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-great text-gray-800">{{ $gift->bank_name }}</h3>
                                <p class="text-sm text-gray-500">{{ $gift->account_name }}</p>
                            </div>
                        </div>
                        <div class="bg-blue-50 rounded-xl p-4">
                            <p class="text-sm text-gray-600 mb-1">Nomor Rekening</p>
                            <p class="text-xl font-bold text-blue-primary break-all">{{ $gift->account_number }}</p>
                        </div>
                        <button onclick="copyAccountNumber('{{ $gift->account_number }}')" 
                                class="mt-4 w-full py-2 bg-blue-100 text-blue-primary rounded-lg hover:bg-blue-200 transition-all duration-300 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                            </svg>
                            Salin Nomor Rekening
                        </button>
                    </div>
                    @empty
                    <div class="col-span-2 text-center py-12">
                        <p class="text-gray-500">Belum ada informasi hadiah.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Wishes Section -->
        <section class="py-20 px-4 bg-white" id="wishes">
            <div class="max-w-6xl mx-auto w-full">
                <div class="text-center mb-16" data-aos="fade-up">
                    <span class="text-blue-primary text-sm tracking-[0.3em] uppercase mb-4 block">Wishes</span>
                    <h2 class="font-great text-4xl md:text-5xl lg:text-6xl text-gray-800 mb-4">Doa & Harapan</h2>
                    <div class="w-24 h-1 bg-blue-primary mx-auto"></div>
                </div>
                
                <div class="grid md:grid-cols-2 gap-6 lg:gap-8 px-4 max-w-full">
                    <!-- Wish Form -->
                    <div class="bg-gradient-to-br from-blue-50 to-white rounded-3xl p-6 md:p-8 shadow-xl w-full" data-aos="fade-right">
                        <h3 class="text-2xl font-great text-gray-800 mb-6">Tulis Doa & Harapan</h3>
                        
                        <form id="wishForm" class="space-y-4">
                            @csrf
                            <div>
                                <input type="text" id="wishName" name="name" placeholder="Nama Anda" required
                                       class="w-full px-4 py-3 rounded-xl border border-blue-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition text-sm">
                            </div>
                            <div>
                                <input type="email" id="wishEmail" name="email" placeholder="Email (opsional)"
                                       class="w-full px-4 py-3 rounded-xl border border-blue-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition text-sm">
                            </div>
                            <div>
                                <textarea id="wishMessage" name="message" rows="4" placeholder="Tulis doa dan harapan Anda..." required
                                          class="w-full px-4 py-3 rounded-xl border border-blue-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition resize-none text-sm"></textarea>
                            </div>
                            <button type="submit" id="submitWishBtn"
                                    class="w-full py-3 bg-blue-gradient text-white rounded-xl hover:shadow-xl transition-all duration-300">
                                <span class="btn-text">Kirim Doa & Harapan</span>
                                <span class="btn-loading hidden">Mengirim...</span>
                            </button>
                        </form>
                    </div>
                    
                    <!-- Wishes List -->
                    <div class="bg-gradient-to-br from-white to-blue-50 rounded-3xl p-6 md:p-8 shadow-xl w-full overflow-hidden" data-aos="fade-left">
                        <h3 class="text-2xl font-great text-gray-800 mb-6">Ucapan Terbaru</h3>
                        
                        <div class="space-y-4 max-h-96 overflow-y-auto pr-2 custom-scroll" id="wishesList">
                            @forelse($wishes as $wish)
                            <div class="bg-white rounded-xl p-4 shadow-sm w-full">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 rounded-full bg-blue-gradient flex items-center justify-center text-white font-semibold flex-shrink-0">
                                        <span>{{ strtoupper(substr($wish->name, 0, 1)) }}</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between mb-1 flex-wrap gap-1">
                                            <h4 class="font-semibold text-gray-800 text-sm truncate max-w-[150px]">{{ $wish->name }}</h4>
                                            <span class="text-xs text-gray-500 whitespace-nowrap">{{ $wish->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-gray-600 text-sm break-words whitespace-pre-wrap">{{ $wish->message }}</p>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <p class="text-gray-500 text-center py-4">Belum ada ucapan. Jadilah yang pertama!</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Thanks Section -->
        @if($setting->thanks_message && $setting->tnaks_message != "<p><br></p>")
        <!-- Footer/Thanks Section -->
        <footer class="relative bg-gradient-to-br from-blue-50 to-white py-16 overflow-hidden" id="thanks">
            <!-- Decorative Elements -->
            <div class="absolute top-0 left-0 w-64 h-64 bg-blue-100/30 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-100/20 rounded-full translate-x-1/2 translate-y-1/2"></div>
            
            <div class="max-w-4xl mx-auto text-center relative z-10 px-4">
                <!-- Couple Photo (if exists) -->
                @if($setting->couple_photo)
                <div class="mb-8" data-aos="zoom-in">
                    <img src="{{ $setting->couple_photo_url }}" alt="{{ $setting->couple_name }}" 
                        class="w-32 h-32 md:w-40 md:h-40 rounded-full object-cover mx-auto border-4 border-white shadow-xl">
                </div>
                @endif
                
                <!-- Thank You Message -->
                @if($setting->thanks_message)
                <div class="mb-8 text-gray-700 leading-relaxed max-w-2xl mx-auto" data-aos="fade-up">
                    {!! $setting->thanks_message !!}
                </div>
                @endif
                
                <!-- Couple Names -->
                <div class="mb-8" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="text-3xl md:text-4xl font-great text-blue-600 mb-3">{{ $setting->couple_name }}</h3>
                    <div class="w-20 h-0.5 bg-blue-200 mx-auto"></div>
                </div>
                
                <!-- Closing Text -->
                <p class="text-gray-500 text-sm mb-6" data-aos="fade-up" data-aos-delay="150">
                    Kami yang berbahagia,
                </p>
                <p class="text-gray-700 font-medium mb-8" data-aos="fade-up" data-aos-delay="200">
                    {{ $setting->groom_fullname ?? $setting->groom_nickname }} & {{ $setting->bride_fullname ?? $setting->bride_nickname }}
                </p>
                
                <!-- Wedding Date (if events exist) -->
                @if($events->first())
                <p class="text-sm text-gray-400 mb-12" data-aos="fade-up" data-aos-delay="250">
                    {{ \Carbon\Carbon::parse($events->first()->date)->translatedFormat('d F Y') }}
                </p>
                @endif
                
                <!-- Footer Bottom -->
                <div class="pt-8 border-t border-blue-100">
                    <p class="text-xs text-gray-400 mt-1">
                        Made with <span class="text-red-400">❤️</span> for the happy couple
                    </p>
                </div>
            </div>
        </footer>
        @endif

        <!-- Navigation Dots -->
        <div class="fixed right-3 top-1/2 -translate-y-1/2 z-40 hidden lg:block">
            <div class="flex flex-col gap-3">
                <a href="#home" class="nav-dot w-3 h-3 rounded-full bg-gray-300 hover:bg-blue-500 transition-colors" title="Home"></a>
                <a href="#couple" class="nav-dot w-3 h-3 rounded-full bg-gray-300 hover:bg-blue-500 transition-colors" title="Couple"></a>
                <a href="#story" class="nav-dot w-3 h-3 rounded-full bg-gray-300 hover:bg-blue-500 transition-colors" title="Love Story"></a>
                <a href="#events" class="nav-dot w-3 h-3 rounded-full bg-gray-300 hover:bg-blue-500 transition-colors" title="Events"></a>
                <a href="#gallery" class="nav-dot w-3 h-3 rounded-full bg-gray-300 hover:bg-blue-500 transition-colors" title="Gallery"></a>
                <a href="#gifts" class="nav-dot w-3 h-3 rounded-full bg-gray-300 hover:bg-blue-500 transition-colors" title="Gifts"></a>
                <a href="#wishes" class="nav-dot w-3 h-3 rounded-full bg-gray-300 hover:bg-blue-500 transition-colors" title="Wishes"></a>
                <a href="#thanks" class="nav-dot w-3 h-3 rounded-full bg-gray-300 hover:bg-blue-500 transition-colors" title="Thanks"></a>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize AOS
            AOS.init({
                duration: 1000,
                once: true,
                offset: 100
            });

            // Create floating petals
            function createFloatingPetals() {
                for (let i = 0; i < 30; i++) {
                    setTimeout(() => {
                        const petal = document.createElement('div');
                        petal.className = 'floating-petal';
                        petal.style.left = Math.random() * 100 + '%';
                        petal.style.width = Math.random() * 20 + 10 + 'px';
                        petal.style.height = Math.random() * 20 + 10 + 'px';
                        petal.style.animationDuration = Math.random() * 3 + 2 + 's';
                        petal.style.animationDelay = Math.random() * 5 + 's';
                        document.querySelector('.hero-section').appendChild(petal);
                    }, i * 100);
                }
            }
            createFloatingPetals();

            // Beautiful opening animation - no scale
            $('#openInvitation').on('click', function() {
                $('#openingOverlay').addClass('closing');
                
                // Auto play music if enabled
                @if($setting->song_autoplay)
                document.getElementById('bgMusic')?.play();
                @endif
                
                // Change music icon if playing
                @if($setting->song_autoplay)
                if (musicIcon) {
                    musicIcon.innerHTML = '<path d="M9 18V5l12-2v13M9 18c0 1.105-1.119 2-2.5 2S4 19.105 4 18s1.119-2 2.5-2 2.5.895 2.5 2zm12-2c0 1.105-1.119 2-2.5 2s-2.5-.895-2.5-2 1.119-2 2.5-2 2.5.895 2.5 2zM9 10l12-2"/>';
                }
                @endif
                
                setTimeout(() => {
                    $('#openingOverlay').css('display', 'none');
                    $('#mainContent').addClass('visible');
                }, 1500);
            });

            // Music control
            const audio = document.getElementById('bgMusic');
            const musicToggle = document.getElementById('musicToggle');
            const musicIcon = document.getElementById('musicIcon');
            let isPlaying = {{ $setting->song_autoplay ? 'true' : 'false' }};

            // Define SVG icons
            const playIcon = '<path d="M9 18V5l12-2v13M9 18c0 1.105-1.119 2-2.5 2S4 19.105 4 18s1.119-2 2.5-2 2.5.895 2.5 2zm12-2c0 1.105-1.119 2-2.5 2s-2.5-.895-2.5-2 1.119-2 2.5-2 2.5.895 2.5 2zM9 10l12-2"/>';
            const pauseIcon = '<path d="M6 4h4v16H6z M14 4h4v16h-4z" stroke="currentColor" stroke-width="2" fill="none"/>';

            if (musicToggle) {
                musicToggle.onclick = function() {
                    if (isPlaying) {
                        audio.pause();
                        musicIcon.innerHTML = pauseIcon;
                    } else {
                        audio.play();
                        musicIcon.innerHTML = playIcon; // Same icon for both states
                    }
                    isPlaying = !isPlaying;
                };

                // Set initial icon
                if (isPlaying) {
                    musicIcon.innerHTML = pauseIcon;
                } else {
                    musicIcon.innerHTML = playIcon;
                }
            }

            // Countdown
            @if($events->first())
            function updateCountdown() {
                @php
                    $targetDateTime = $events->first()->date->format('Y-m-d') . ' ' . $events->first()->time_start->format('H:i:s');
                @endphp
                const targetDate = new Date('{{ $targetDateTime }}').getTime();
                
                setInterval(function() {
                    const now = new Date().getTime();
                    const distance = targetDate - now;

                    if (distance < 0) {
                        document.getElementById('days').textContent = '0';
                        document.getElementById('hours').textContent = '0';
                        document.getElementById('minutes').textContent = '0';
                        document.getElementById('seconds').textContent = '0';
                        return;
                    }

                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    document.getElementById('days').textContent = days;
                    document.getElementById('hours').textContent = hours;
                    document.getElementById('minutes').textContent = minutes;
                    document.getElementById('seconds').textContent = seconds;
                }, 1000);
            }
            updateCountdown();
            @endif

            // Wish form submission
            $('#wishForm').on('submit', function(e) {
                e.preventDefault();
                
                const submitBtn = $('#submitWishBtn');
                const btnText = submitBtn.find('.btn-text');
                const btnLoading = submitBtn.find('.btn-loading');
                
                btnText.addClass('hidden');
                btnLoading.removeClass('hidden');
                submitBtn.prop('disabled', true);

                $.ajax({
                    url: '{{ route("api.wishes.store") }}',
                    method: 'POST',
                    data: {
                        name: $('#wishName').val(),
                        email: $('#wishEmail').val(),
                        message: $('#wishMessage').val(),
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Terima Kasih!',
                                text: 'Doa dan harapan Anda sangat berarti bagi kami.',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                iconColor: '#ffffff',
                                background: 'linear-gradient(135deg, #2563eb, #3b82f6)',
                                customClass: {
                                    title: 'text-white font-inter text-sm',
                                    htmlContainer: 'text-white text-opacity-90 text-xs'
                                }
                            });
                            
                            // Clear form
                            $('#wishName').val('');
                            $('#wishEmail').val('');
                            $('#wishMessage').val('');
                            
                            // Reload wishes
                            loadWishes();
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: xhr.responseJSON?.message || 'Terjadi kesalahan. Silakan coba lagi.',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            background: '#ef4444',
                            iconColor: 'white',
                            customClass: {
                                title: 'text-white font-inter text-sm',
                                htmlContainer: 'text-white text-opacity-90 text-xs'
                            }
                        });
                    },
                    complete: function() {
                        btnText.removeClass('hidden');
                        btnLoading.addClass('hidden');
                        submitBtn.prop('disabled', false);
                    }
                });
            });

            // Load wishes
            function loadWishes() {
                $.ajax({
                    url: '{{ route("api.wishes") }}',
                    method: 'GET',
                    success: function(wishes) {
                        const wishesList = $('#wishesList');
                        wishesList.empty();
                        
                        if (wishes.length === 0) {
                            wishesList.html('<p class="text-gray-500 text-center py-4">Belum ada ucapan. Jadilah yang pertama!</p>');
                            return;
                        }
                        
                        wishes.forEach(function(wish) {
                            // Create date object
                            const wishDate = new Date(wish.created_at);
                            const now = new Date();
                            const diffTime = Math.abs(now - wishDate);
                            const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
                            const diffHours = Math.floor(diffTime / (1000 * 60 * 60));
                            const diffMinutes = Math.floor(diffTime / (1000 * 60));
                            
                            let timeAgo = '';
                            if (diffDays > 30) {
                                const diffMonths = Math.floor(diffDays / 30);
                                timeAgo = diffMonths + ' bulan lalu';
                            } else if (diffDays > 0) {
                                timeAgo = diffDays + ' hari lalu';
                            } else if (diffHours > 0) {
                                timeAgo = diffHours + ' jam lalu';
                            } else if (diffMinutes > 0) {
                                timeAgo = diffMinutes + ' menit lalu';
                            } else {
                                timeAgo = 'baru saja';
                            }
                            
                            const initial = wish.name.charAt(0).toUpperCase();
                            
                            wishesList.append(`
                                <div class="bg-white rounded-xl p-4 shadow-sm w-full">
                                    <div class="flex items-start gap-3">
                                        <div class="w-10 h-10 rounded-full bg-blue-gradient flex items-center justify-center text-white font-semibold flex-shrink-0">
                                            <span>${initial}</span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between mb-1 flex-wrap gap-1">
                                                <h4 class="font-semibold text-gray-800 text-sm truncate max-w-[150px]">${wish.name}</h4>
                                                <span class="text-xs text-gray-500 whitespace-nowrap">${timeAgo}</span>
                                            </div>
                                            <p class="text-gray-600 text-sm break-words whitespace-pre-wrap">${wish.message}</p>
                                        </div>
                                    </div>
                                </div>
                            `);
                        });
                    }
                });
            }

            // Copy account number function
            window.copyAccountNumber = function(accountNumber) {
                navigator.clipboard.writeText(accountNumber).then(function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Tersalin!',
                        text: 'Nomor rekening berhasil disalin',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        background: 'linear-gradient(135deg, #2563eb, #3b82f6)',
                        iconColor: 'white',
                        customClass: {
                            title: 'text-white font-inter text-sm',
                            htmlContainer: 'text-white text-opacity-90 text-xs'
                        }
                    });
                }).catch(function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal menyalin nomor rekening',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        background: '#ef4444',
                        iconColor: 'white',
                        customClass: {
                            title: 'text-white font-inter text-sm',
                            htmlContainer: 'text-white text-opacity-90 text-xs'
                        }
                    });
                });
            };

            // Initialize Swiper
            new Swiper(".mySwiper", {
                effect: "coverflow",
                grabCursor: true,
                centeredSlides: true,
                slidesPerView: "auto",
                coverflowEffect: {
                    rotate: 50,
                    stretch: 0,
                    depth: 100,
                    modifier: 1,
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
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
            });

            // Navigation dots active state
            const sections = document.querySelectorAll('section[id]');
            const navDots = document.querySelectorAll('.nav-dot');
            
            $(window).on('scroll', function() {
                let current = '';
                
                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.clientHeight;
                    
                    if (window.pageYOffset >= sectionTop - 200) {
                        current = section.getAttribute('id');
                    }
                });
                
                navDots.forEach(dot => {
                    dot.classList.remove('bg-blue-500', 'scale-150');
                    dot.classList.add('bg-gray-300');
                    
                    if (dot.getAttribute('href') === `#${current}`) {
                        dot.classList.add('bg-blue-500', 'scale-150');
                        dot.classList.remove('bg-gray-300');
                    }
                });
            });
        });
    </script>
</body>
</html>