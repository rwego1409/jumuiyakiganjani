
@extends('layouts.landing')

@section('title', 'Jumuiya Kiganjani - Faith Community Management Platform')

@section('content')
<style>
    /* Dark mode variables with expanded color palette */
    :root {
        --bg-dark: #0f172a;
        --bg-darker: #020617;
        --bg-darkest: #000212;
        --text-primary: #f8fafc;
        --text-secondary: #94a3b8;
        --text-tertiary: #64748b;
        --card-bg: rgba(15, 23, 42, 0.7);
        --card-border: rgba(148, 163, 184, 0.1);
        --primary-gradient-start: #818cf8;
        --primary-gradient-end: #c084fc;
        --accent-purple: #a855f7;
        --accent-blue: #3b82f6;
        --accent-green: #10b981;
        --accent-orange: #f59e0b;
        --accent-pink: #ec4899;
    }

    /* Ensure dark mode is applied regardless of system preference */
    body {
        @apply bg-gray-900;
        color: var(--text-primary);
    }

    /* Enhanced dark background with deeper gradient */
    .dark-bg {
        background: linear-gradient(135deg, var(--bg-darkest), var(--bg-dark));
        color: var(--text-primary);
        position: relative;
        overflow: hidden;
    }

    /* Background noise texture overlay for subtle detail */
    .noise-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.05'/%3E%3C/svg%3E");
        opacity: 0.4;
        pointer-events: none;
        z-index: 1;
    }

    /* Modern glass-morphism card styling for dark mode */
    .card-jumuiya {
        @apply p-8 rounded-2xl relative;
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        backdrop-filter: blur(10px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(255, 255, 255, 0.05) inset;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 2;
    }

    .card-jumuiya::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transform: scaleX(0);
        transition: transform 0.4s ease;
    }

    .card-jumuiya:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 30px -10px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.08) inset;
        border-color: rgba(148, 163, 184, 0.2);
    }

    .card-jumuiya:hover::before {
        transform: scaleX(1);
    }

    /* Enhanced text gradient that works in dark mode */
    .text-gradient {
        background-clip: text;
        -webkit-background-clip: text;
        color: transparent;
        background-image: linear-gradient(45deg, var(--primary-gradient-start), var(--primary-gradient-end));
    }

    /* Enhanced button styles for dark mode with hover animation */
    .btn-jumuiya {
        @apply relative overflow-hidden font-medium;
        background: linear-gradient(90deg, #6366f1, #8b5cf6);
        color: white;
        transition: all 0.4s ease;
        border-radius: 12px;
        padding: 0.75rem 2rem;
    }

    .btn-jumuiya::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, #8b5cf6, #6366f1);
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .btn-jumuiya span {
        position: relative;
        z-index: 1;
    }

    .btn-jumuiya:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -5px rgba(99, 102, 241, 0.4);
    }

    .btn-jumuiya:hover::after {
        opacity: 1;
    }

    /* Enhanced secondary button */
    .btn-secondary {
        @apply border border-gray-700 text-gray-200 relative overflow-hidden font-medium;
        background: rgba(15, 23, 42, 0.5);
        transition: all 0.3s ease;
        border-radius: 12px;
        padding: 0.75rem 2rem;
    }

    .btn-secondary:hover {
        @apply bg-gray-800 text-white;
        border-color: #4b5563;
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2);
    }

    /* Enhanced floating animation for decorative elements */
    @keyframes float {
        0% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-10px) rotate(5deg); }
        100% { transform: translateY(0px) rotate(0deg); }
    }

    @keyframes floatReverse {
        0% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-15px) rotate(-5deg); }
        100% { transform: translateY(0px) rotate(0deg); }
    }

    .floating {
        animation: float 6s ease-in-out infinite;
        opacity: 0.15;
        filter: blur(2px);
    }

    .floating-reverse {
        animation: floatReverse 8s ease-in-out infinite;
        opacity: 0.15;
        filter: blur(2px);
    }

    .glow {
        box-shadow: 0 0 40px rgba(99, 102, 241, 0.15);
    }

    /* Enhanced testimonial cards */
    .testimonial-card {
        @apply p-8 rounded-2xl relative;
        background: rgba(15, 23, 42, 0.8);
        border: 1px solid rgba(148, 163, 184, 0.1);
        transition: all 0.3s ease;
    }

    .testimonial-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px -10px rgba(0, 0, 0, 0.4);
        border-color: rgba(148, 163, 184, 0.2);
    }

    /* Subtle grid background */
    .grid-bg {
        background-image: linear-gradient(rgba(99, 102, 241, 0.05) 1px, transparent 1px),
                         linear-gradient(90deg, rgba(99, 102, 241, 0.05) 1px, transparent 1px);
        background-size: 40px 40px;
    }

    /* Feature icon animation */
    @keyframes pulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.1); opacity: 0.8; }
        100% { transform: scale(1); opacity: 1; }
    }

    .pulse-on-hover:hover .icon-container {
        animation: pulse 2s infinite;
    }

    /* Counter animation */
    @keyframes countUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .count-up {
        animation: countUp 1s forwards;
    }

    /* Stat item styling */
    .stat-item {
        @apply p-4 rounded-xl;
        background: rgba(15, 23, 42, 0.5);
        border: 1px solid rgba(148, 163, 184, 0.1);
    }

    /* Mobile optimizations */
    @media (max-width: 640px) {
        .card-jumuiya {
            @apply p-6;
        }
        
        .btn-jumuiya, .btn-secondary {
            @apply py-3 px-6 text-base;
        }
    }
</style>

<div class="dark-bg min-h-screen relative">
    <!-- Noise overlay for texture -->
    <div class="noise-overlay"></div>
    
    <!-- Grid background for subtle pattern -->
    <div class="grid-bg absolute inset-0 z-0"></div>

    <!-- Hero Section with enhanced visuals -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-16 relative z-10">
        <div class="text-center">
            <span class="inline-block px-4 py-1 rounded-full bg-indigo-900 bg-opacity-30 text-indigo-300 text-sm font-medium mb-6 border border-indigo-800">
                Faith Community Management Platform
            </span>
            
            <h1 class="text-5xl font-extrabold tracking-tight sm:text-6xl md:text-7xl">
                <span class="block text-gray-200">Welcome to</span>
                <span class="block text-gradient mt-2">Jumuiya Kiganjani</span>
            </h1>
            
            <p class="mt-6 max-w-lg mx-auto text-xl text-gray-400 md:max-w-3xl">
                The complete digital solution for managing your faith community - connect, organize, and grow together in faith
            </p>
            
            <div class="mt-10 flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('register') }}" class="btn-jumuiya inline-flex items-center justify-center">
                    <span>Get Started Free</span>
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
                
                <a href="#features" class="btn-secondary inline-flex items-center justify-center">
                    <span>Explore Features</span>
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </a>
            </div>
        </div>
        
        <!-- Hero image or mockup -->
        <div class="mt-16 relative mx-auto max-w-4xl">
            <div class="bg-indigo-900 bg-opacity-30 rounded-2xl p-2 shadow-2xl border border-indigo-800">
                <div class="bg-gray-800 rounded-xl overflow-hidden">
                    <div class="h-8 bg-gray-900 flex items-center px-4">
                        <div class="flex space-x-2">
                            <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                            <div class="w-3 h-3 rounded-full bg-green-500"></div>
                        </div>
                        <div class="mx-auto text-xs text-gray-400">Jumuiya Kiganjani Dashboard</div>
                    </div>
                    <div class="h-64 sm:h-96 bg-gradient-to-br from-gray-900 to-indigo-900 flex items-center justify-center">
                        <p class="text-indigo-300 text-lg font-medium">Dashboard Preview</p>
                    </div>
                </div>
            </div>
            
            <!-- Decorative elements -->
            <div class="absolute -top-12 -right-12 w-24 h-24 rounded-full bg-indigo-900 floating opacity-10"></div>
            <div class="absolute -bottom-8 -left-8 w-16 h-16 rounded-full bg-purple-900 floating-reverse opacity-10"></div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 relative z-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
            <div class="stat-item text-center">
                <h3 class="text-3xl sm:text-4xl font-bold text-gradient">500+</h3>
                <p class="mt-2 text-gray-400">Communities</p>
            </div>
            
            <div class="stat-item text-center">
                <h3 class="text-3xl sm:text-4xl font-bold text-gradient">15,000+</h3>
                <p class="mt-2 text-gray-400">Members</p>
            </div>
            
            <div class="stat-item text-center">
                <h3 class="text-3xl sm:text-4xl font-bold text-gradient">98%</h3>
                <p class="mt-2 text-gray-400">Satisfaction</p>
            </div>
            
            <div class="stat-item text-center">
                <h3 class="text-3xl sm:text-4xl font-bold text-gradient">30%</h3>
                <p class="mt-2 text-gray-400">Growth Rate</p>
            </div>
        </div>
    </div>

    <!-- Floating Feature Icons (Decorative) -->
    <div class="hidden md:block">
        <div class="absolute top-1/4 left-1/6 w-32 h-32 rounded-full bg-indigo-900 floating opacity-10" style="animation-delay: 0s;"></div>
        <div class="absolute top-1/3 right-1/5 w-40 h-40 rounded-full bg-green-900 floating-reverse opacity-10" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-1/4 left-1/4 w-48 h-48 rounded-full bg-purple-900 floating opacity-10" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-1/3 right-1/6 w-36 h-36 rounded-full bg-blue-900 floating-reverse opacity-10" style="animation-delay: 3s;"></div>
    </div>

    <!-- Features Grid with Enhanced Details -->
    <div id="features" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 relative z-10">
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-1 rounded-full bg-purple-900 bg-opacity-30 text-purple-300 text-sm font-medium mb-6 border border-purple-800">
                Powerful Features
            </span>
            
            <h2 class="text-3xl font-bold text-gray-200 sm:text-4xl">
                Everything your <span class="text-gradient">community</span> needs
            </h2>
            
            <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-400">
                Designed to help you connect, organize, and grow your faith community with tools that make administration effortless
            </p>
        </div>

        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Member Management -->
            <div class="card-jumuiya pulse-on-hover">
                <div class="flex items-center justify-center h-16 w-16 rounded-xl bg-indigo-900 text-indigo-400 mx-auto icon-container">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                
                <h3 class="mt-6 text-xl font-bold text-gray-200 text-center">Member Directory</h3>
                
                <p class="mt-3 text-base text-gray-400 text-center">
                    Create comprehensive member profiles with photos, contact details, and family relationships. Track important information like birthdays, baptism dates, and ministry involvement.
                </p>
                
                <ul class="mt-4 text-sm text-gray-400 space-y-2">
                    <li class="flex items-center">
                        <svg class="h-4 w-4 text-indigo-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Family relationship mapping
                    </li>
                    <li class="flex items-center">
                        <svg class="h-4 w-4 text-indigo-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Ministry involvement tracking
                    </li>
                    <li class="flex items-center">
                        <svg class="h-4 w-4 text-indigo-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Special date notifications
                    </li>
                </ul>
                
                <div class="mt-6 text-center">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-900 text-indigo-300">
                        Community
                    </span>
                </div>
            </div>

            <!-- Contribution Tracking -->
            <div class="card-jumuiya pulse-on-hover">
                <div class="flex items-center justify-center h-16 w-16 rounded-xl bg-green-900 text-green-400 mx-auto icon-container">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                
                <h3 class="mt-6 text-xl font-bold text-gray-200 text-center">Harambee Tracking</h3>
                
                <p class="mt-3 text-base text-gray-400 text-center">
                    Manage all community contributions with transparent reporting. Track tithes, offerings, and special project fundraising with detailed financial reports.
                </p>
                
                <ul class="mt-4 text-sm text-gray-400 space-y-2">
                    <li class="flex items-center">
                        <svg class="h-4 w-4 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Multiple contribution categories
                    </li>
                    <li class="flex items-center">
                        <svg class="h-4 w-4 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Custom fundraising campaigns
                    </li>
                    <li class="flex items-center">
                        <svg class="h-4 w-4 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Financial transparency reporting
                    </li>
                </ul>
                
                <div class="mt-6 text-center">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-900 text-green-300">
                        Finance
                    </span>
                </div>
            </div>

            <!-- Event Management -->
            <div class="card-jumuiya pulse-on-hover">
                <div class="flex items-center justify-center h-16 w-16 rounded-xl bg-purple-900 text-purple-400 mx-auto icon-container">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                
                <h3 class="mt-6 text-xl font-bold text-gray-200 text-center">Event Management</h3>
                
                <p class="mt-3 text-base text-gray-400 text-center">
                    Organize Jumuiya meetings, prayer services, and special events with powerful scheduling tools and automated reminders.
                </p>
                
                <ul class="mt-4 text-sm text-gray-400 space-y-2">
                    <li class="flex items-center">
                        <svg class="h-4 w-4 text-purple-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Attendance tracking
                    </li>
                    <li class="flex items-center">
                        <svg class="h-4 w-4 text-purple-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Automated notifications
                    </li>
                    <li class="flex items-center">
                        <svg class="h-4 w-4 text-purple-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Mobile calendar integration
                    </li>
                </ul>
                
                <div class="mt-6 text-center">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-900 text-purple-300">
                        Organization
                    </span>
                </div>
            </div>

            <!-- Spiritual Resources -->
            <div class="card-jumuiya pulse-on-hover">
                <div class="flex items-center justify-center h-16 w-16 rounded-xl bg-blue-900 text-blue-400 mx-auto icon-container">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                
                <h3 class="mt-6 text-xl font-bold text-gray-200 text-center">Spiritual Resources</h3>
                
                <p class="mt-3 text-base text-gray-400 text-center">
                    Access daily devotionals, sermon notes, and scripture readings shared by community leaders. Build a digital library of spiritual growth materials.
                </p>
                
                <ul class="mt-4 text-sm text-gray-400 space-y-2">
                    <li class="flex items-center">
                        <svg class="h-4 w-4 text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Daily scripture readings
                    </li>
                    <li class="flex items-center">
                        <svg class="h-4 w-4 text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Prayer request sharing
                    </li>
                    <li class="flex items-center">
                        <svg class="h-4 w-4 text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Sermon archive access
                    </li>
                </ul>
                
                <div class="mt-6 text-center">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-900 text-blue-300">
                        Growth
                    </span>
                </div>
            </div>

            <!-- Reporting & Analytics -->
            <div class="card-jumuiya pulse-on-hover">
                <div class="flex items-center justify-center h-16 w-16 rounded-xl bg-orange-900 text-orange-400 mx-auto icon-container">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                
               
<h3 class="mt-6 text-xl font-bold text-gray-200 text-center">Performance Analytics</h3>
                
                <p class="mt-3 text-base text-gray-400 text-center">
                    Track community engagement with visual reports on attendance, contributions, and member growth. Make data-driven decisions for your community.
                </p>
                
                <ul class="mt-4 text-sm text-gray-400 space-y-2">
                    <li class="flex items-center">
                        <svg class="h-4 w-4 text-orange-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Interactive dashboards
                    </li>
                    <li class="flex items-center">
                        <svg class="h-4 w-4 text-orange-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Growth trend analysis
                    </li>
                    <li class="flex items-center">
                        <svg class="h-4 w-4 text-orange-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Exportable reports
                    </li>
                </ul>
                
                <div class="mt-6 text-center">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-orange-900 text-orange-300">
                        Insights
                    </span>
                </div>
            </div>

            <!-- Notifications System -->
            <div class="card-jumuiya pulse-on-hover">
                <div class="flex items-center justify-center h-16 w-16 rounded-xl bg-pink-900 text-pink-400 mx-auto icon-container">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>
                
                <h3 class="mt-6 text-xl font-bold text-gray-200 text-center">Smart Reminders</h3>
                
                <p class="mt-3 text-base text-gray-400 text-center">
                    Keep everyone informed with automated SMS and email notifications for events, contribution deadlines, prayer requests, and birthdays.
                </p>
                
                <ul class="mt-4 text-sm text-gray-400 space-y-2">
                    <li class="flex items-center">
                        <svg class="h-4 w-4 text-pink-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Multi-channel alerts
                    </li>
                    <li class="flex items-center">
                        <svg class="h-4 w-4 text-pink-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Customizable templates
                    </li>
                    <li class="flex items-center">
                        <svg class="h-4 w-4 text-pink-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Scheduled messaging
                    </li>
                </ul>
                
                <div class="mt-6 text-center">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-pink-900 text-pink-300">
                        Engagement
                    </span>
                </div>
            </div>
            
            <!-- Mobile Access -->
            <div class="card-jumuiya pulse-on-hover">
                <div class="flex items-center justify-center h-16 w-16 rounded-xl bg-teal-900 text-teal-400 mx-auto icon-container">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                </div>
                
                <h3 class="mt-6 text-xl font-bold text-gray-200 text-center">Mobile Access</h3>
                
                <p class="mt-3 text-base text-gray-400 text-center">
                    Stay connected on the go with our mobile app. Access all features from anywhere, even with limited connectivity.
                </p>
                
                <ul class="mt-4 text-sm text-gray-400 space-y-2">
                    <li class="flex items-center">
                        <svg class="h-4 w-4 text-teal-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Offline functionality
                    </li>
                    <li class="flex items-center">
                        <svg class="h-4 w-4 text-teal-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Push notifications
                    </li>
                    <li class="flex items-center">
                        <svg class="h-4 w-4 text-teal-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Low data consumption
                    </li>
                </ul>
                
                <div class="mt-6 text-center">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-teal-900 text-teal-300">
                        Accessibility
                    </span>
                </div>
            </div>
            
            <!-- Prayer Network -->
            <div class="card-jumuiya pulse-on-hover">
                <div class="flex items-center justify-center h-16 w-16 rounded-xl bg-amber-900 text-amber-400 mx-auto icon-container">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                
                <h3 class="mt-6 text-xl font-bold text-gray-200 text-center">Prayer Network</h3>
                
                <p class="mt-3 text-base text-gray-400 text-center">
                    Share prayer requests, testimonies, and prayer commitments with your entire community. Support each other spiritually.
                </p>
                
                <ul class="mt-4 text-sm text-gray-400 space-y-2">
                    <li class="flex items-center">
                        <svg class="h-4 w-4 text-amber-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Private prayer chains
                    </li>
                    <li class="flex items-center">
                        <svg class="h-4 w-4 text-amber-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Testimony sharing
                    </li>
                    <li class="flex items-center">
                        <svg class="h-4 w-4 text-amber-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Prayer commitment tracking
                    </li>
                </ul>
                
                <div class="mt-6 text-center">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-amber-900 text-amber-300">
                        Spiritual Support
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- How It Works Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10">
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-1 rounded-full bg-blue-900 bg-opacity-30 text-blue-300 text-sm font-medium mb-6 border border-blue-800">
                Getting Started Is Easy
            </span>
            
            <h2 class="text-3xl font-bold text-gray-200 sm:text-4xl">
                How <span class="text-gradient">Jumuiya Kiganjani</span> Works
            </h2>
            
            <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-400">
                Our platform is designed to be intuitive and easy to use, even for those with limited technical experience
            </p>
        </div>
        
        <div class="relative">
            <!-- Center line -->
            <div class="hidden md:block absolute left-1/2 top-0 bottom-0 w-0.5 bg-gradient-to-b from-indigo-900 via-purple-900 to-transparent"></div>
            
            <div class="space-y-12 relative">
                <!-- Step 1 -->
                <div class="relative grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                    <div class="md:text-right">
                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-indigo-900 text-indigo-300 text-sm font-semibold mb-4">1</span>
                        <h3 class="text-2xl font-bold text-gray-200">Create Your Community</h3>
                        <p class="mt-2 text-gray-400">
                            Register your account and set up your community profile with customized branding and structure. Add your leadership team and define roles.
                        </p>
                    </div>
                    <div class="bg-gray-800 rounded-xl overflow-hidden p-4 border border-gray-700">
                        <div class="h-48 bg-gradient-to-br from-gray-900 to-indigo-900 rounded-lg flex items-center justify-center">
                            <svg class="h-16 w-16 text-indigo-500 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Step 2 -->
                <div class="relative grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                    <div class="md:order-last md:text-left">
                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-purple-900 text-purple-300 text-sm font-semibold mb-4">2</span>
                        <h3 class="text-2xl font-bold text-gray-200">Import Member Data</h3>
                        <p class="mt-2 text-gray-400">
                            Easily import your existing member data or add members individually. Our system helps you organize members by households and ministries.
                        </p>
                    </div>
                    <div class="md:order-first bg-gray-800 rounded-xl overflow-hidden p-4 border border-gray-700">
                        <div class="h-48 bg-gradient-to-br from-gray-900 to-purple-900 rounded-lg flex items-center justify-center">
                            <svg class="h-16 w-16 text-purple-500 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Step 3 -->
                <div class="relative grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                    <div class="md:text-right">
                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-blue-900 text-blue-300 text-sm font-semibold mb-4">3</span>
                        <h3 class="text-2xl font-bold text-gray-200">Configure Your Modules</h3>
                        <p class="mt-2 text-gray-400">
                            Set up contribution categories, event types, and communication preferences. Customize the platform to match your community's unique needs.
                        </p>
                    </div>
                    <div class="bg-gray-800 rounded-xl overflow-hidden p-4 border border-gray-700">
                        <div class="h-48 bg-gradient-to-br from-gray-900 to-blue-900 rounded-lg flex items-center justify-center">
                            <svg class="h-16 w-16 text-blue-500 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Step 4 -->
                <div class="relative grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                    <div class="md:order-last md:text-left">
                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-green-900 text-green-300 text-sm font-semibold mb-4">4</span>
                        <h3 class="text-2xl font-bold text-gray-200">Invite Your Community</h3>
                        <p class="mt-2 text-gray-400">
                            Send automated invitations to all members through email or SMS. They'll receive personalized access to their mobile and web dashboards.
                        </p>
                    </div>
                    <div class="md:order-first bg-gray-800 rounded-xl overflow-hidden p-4 border border-gray-700">
                        <div class="h-48 bg-gradient-to-br from-gray-900 to-green-900 rounded-lg flex items-center justify-center">
                            <svg class="h-16 w-16 text-green-500 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonial Section with Enhanced Design -->
    <!-- <div class="bg-gray-900 bg-opacity-80 py-20 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-1 rounded-full bg-pink-900 bg-opacity-30 text-pink-300 text-sm font-medium mb-6 border border-pink-800">
                    Success Stories
                </span>
                
                <h2 class="text-3xl font-bold text-gray-200 sm:text-4xl">
                    Loved by <span class="text-gradient">faith communities</span> worldwide
                </h2>
                
                <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-400">
                    See how Jumuiya Kiganjani is transforming faith communities across the globe
                </p>
            </div>
            
            <div class="mt-12 grid grid-cols-1 gap-8 md:grid-cols-3">
                <div class="testimonial-card">
                    <div class="absolute top-4 right-4">
                        <svg class="h-8 w-8 text-indigo-500 opacity-30" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14.017 18L14.017 10.609C14.017 4.905 17.748 1.039 23 0L23.995 2.151C21.563 3.068 20 5.789 20 8H24V18H14.017ZM0 18V10.609C0 4.905 3.748 1.038 9 0L9.996 2.151C7.563 3.068 6 5.789 6 8H9.983L9.983 18L0 18Z"/>
                        </svg>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-12 w-12 rounded-full bg-indigo-900 flex items-center justify-center glow">
                                <span class="text-indigo-300 font-bold">JM</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-semibold text-gray-200">John Mwangi</h4>
                            <p class="text-gray-400">Kiganjani Leader</p>
                        </div>
                    </div>
                    
                    <div class="mt-6 flex mb-4">
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                    
                    <p class="mt-2 text-gray-400 italic">
                        "Jumuiya Kiganjani has transformed how we manage our community. The contribution tracking alone has saved us hours of work each week, and our member engagement has increased by 45% since implementation."
                    </p>
                    
                    <div class="mt-6 pt-6 border-t border-gray-800">
                        <p class="text-sm text-gray-500">Using Jumuiya since 2023</p>
                    </div>
                </div> -->

    <!-- Testimonial Section
    <div class="bg-gray-900 bg-opacity-80 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-200 sm:text-4xl">
                    Loved by <span class="text-gradient">faith communities</span> worldwide
                </h2>
            </div>
            
            <div class="mt-12 grid grid-cols-1 gap-8 md:grid-cols-3">
                <div class="testimonial-card">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-12 w-12 rounded-full bg-primary-900 flex items-center justify-center">
                                <span class="text-primary-400 font-bold">JM</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-semibold text-gray-200">John Mwangi</h4>
                            <p class="text-gray-400">Kiganjani Leader</p>
                        </div>
                    </div>
                    <p class="mt-4 text-gray-400 italic">
                        "Jumuiya Kiganjani has transformed how we manage our community. The contribution tracking alone has saved us hours of work each week."
                    </p>
                </div>
                
                <div class="testimonial-card">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-12 w-12 rounded-full bg-green-900 flex items-center justify-center">
                                <span class="text-green-400 font-bold">SN</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-semibold text-gray-200">Sarah Njeri</h4>
                            <p class="text-gray-400">Treasurer</p>
                        </div>
                    </div>
                    <p class="mt-4 text-gray-400 italic">
                        "The reporting features give us complete transparency into our finances. Our members appreciate seeing exactly where their contributions go."
                    </p>
                </div>
                
                <div class="testimonial-card">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-12 w-12 rounded-full bg-purple-900 flex items-center justify-center">
                                <span class="text-purple-400 font-bold">DK</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-semibold text-gray-200">David Kamau</h4>
                            <p class="text-gray-400">Youth Coordinator</p>
                        </div>
                    </div>
                    <p class="mt-4 text-gray-400 italic">
                        "Our youth group engagement has doubled since we started using the event management tools. The reminders keep everyone informed!"
                    </p>
                </div>
            </div>
        </div>
    </div> -->
<!-- Testimonial Section with Enhanced Design -->
<div class="bg-gray-900 bg-opacity-80 py-20 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-1 rounded-full bg-pink-900 bg-opacity-30 text-pink-300 text-sm font-medium mb-6 border border-pink-800">
                    Success Stories
                </span>
                
                <h2 class="text-3xl font-bold text-gray-200 sm:text-4xl">
                    Loved by <span class="text-gradient">faith communities</span> worldwide
                </h2>
                
                <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-400">
                    See how Jumuiya Kiganjani is transforming faith communities across the globe
                </p>
            </div>
            
            <div class="mt-12 grid grid-cols-1 gap-8 md:grid-cols-3">
                <div class="testimonial-card">
                    <div class="absolute top-4 right-4">
                        <svg class="h-8 w-8 text-indigo-500 opacity-30" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14.017 18L14.017 10.609C14.017 4.905 17.748 1.039 23 0L23.995 2.151C21.563 3.068 20 5.789 20 8H24V18H14.017ZM0 18V10.609C0 4.905 3.748 1.038 9 0L9.996 2.151C7.563 3.068 6 5.789 6 8H9.983L9.983 18L0 18Z"/>
                        </svg>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-12 w-12 rounded-full bg-indigo-900 flex items-center justify-center glow">
                                <span class="text-indigo-300 font-bold">JM</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-semibold text-gray-200">John Mwangi</h4>
                            <p class="text-gray-400">Kiganjani Leader</p>
                        </div>
                    </div>
                    
                    <div class="mt-6 flex mb-4">
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                    
                    <p class="mt-2 text-gray-400 italic">
                        "Jumuiya Kiganjani has transformed how we manage our community. The contribution tracking alone has saved us hours of work each week, and our member engagement has increased by 45% since implementation."
                    </p>
                    
                    <div class="mt-6 pt-6 border-t border-gray-800">
                        <p class="text-sm text-gray-500">Using Jumuiya since 2023</p>
                    </div>
                </div>
                
                <div class="testimonial-card">
                    <div class="absolute top-4 right-4">
                        <svg class="h-8 w-8 text-green-500 opacity-30" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14.017 18L14.017 10.609C14.017 4.905 17.748 1.039 23 0L23.995 2.151C21.563 3.068 20 5.789 20 8H24V18H14.017ZM0 18V10.609C0 4.905 3.748 1.038 9 0L9.996 2.151C7.563 3.068 6 5.789 6 8H9.983L9.983 18L0 18Z"/>
                        </svg>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-12 w-12 rounded-full bg-green-900 flex items-center justify-center glow">
                                <span class="text-green-300 font-bold">SN</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-semibold text-gray-200">Sarah Njeri</h4>
                            <p class="text-gray-400">Treasurer</p>
                        </div>
                    </div>
                    
                    <div class="mt-6 flex mb-4">
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                    
                    <p class="mt-2 text-gray-400 italic">
                        "The reporting features give us complete transparency into our finances. Our members appreciate seeing exactly where their contributions go, which has increased both trust and giving."
                    </p>
                    
                    <div class="mt-6 pt-6 border-t border-gray-800">
                        <p class="text-sm text-gray-500">Using Jumuiya since 2022</p>
                    </div>
                </div>
    <!-- Final CTA -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
        <h2 class="text-3xl font-bold text-gray-200 sm:text-4xl">
            Ready to strengthen your <span class="text-gradient">community</span>?
        </h2>
        <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-400">
            Join thousands of faith communities already using Jumuiya Kiganjani
        </p>
        <div class="mt-8">
            <a href="{{ route('register') }}" class="btn-jumuiya inline-flex items-center justify-center px-8 py-4 text-lg font-semibold rounded-xl">
                Get Started for Free
            </a>
        </div>
    </div>
</div>

<script>
    // Add some interactive elements
    document.addEventListener('DOMContentLoaded', function() {
        // Animate cards when they come into view
        const cards = document.querySelectorAll('.card-jumuiya, .testimonial-card');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = 1;
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });
        
        cards.forEach((card, index) => {
            card.style.opacity = 0;
            card.style.transform = 'translateY(20px)';
            card.style.transition = `all 0.5s ease ${index * 0.1}s`;
            observer.observe(card);
        });
        
        // Add hover effect to buttons
        const buttons = document.querySelectorAll('a[href*="register"], a[href*="features"]');
        buttons.forEach(button => {
            button.addEventListener('mouseenter', () => {
                button.style.transform = 'translateY(-2px)';
            });
            button.addEventListener('mouseleave', () => {
                button.style.transform = 'translateY(0)';
            });
        });
    });
</script>
@endsection