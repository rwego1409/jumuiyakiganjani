<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-white dark:bg-gray-900 transition-colors duration-300">
    <!-- Hero Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-24">
        <div class="text-center">
            <span class="inline-block px-4 py-1 rounded-full bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 text-sm font-medium mb-6 border border-indigo-100 dark:border-indigo-800/50">
                Faith Community Management Platform
            </span>
            
            <h1 class="text-5xl font-extrabold tracking-tight sm:text-6xl md:text-7xl mb-8 hero-heading">
                <span class="block text-gray-900 dark:text-white">Welcome to</span>
                <span class="block text-indigo-600 dark:text-indigo-400">Jumuiya Kiganjani</span>
            </h1>
            
            <p class="text-xl text-gray-700 dark:text-gray-300 max-w-2xl mx-auto mb-12">
                The complete digital solution for managing your faith community - connect, organize, and grow together in faith
            </p>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="<?php echo e(route('register')); ?>" 
                   class="inline-flex items-center justify-center px-8 py-3 text-base font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 transition-all duration-200 shadow-lg hover:shadow-xl">
                    Get Started Free
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
                
                <a href="#features" 
                   class="inline-flex items-center justify-center px-8 py-3 text-base font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/70 border border-gray-300 dark:border-gray-600 transition-all duration-200 shadow-lg hover:shadow-xl">
                    Explore Features
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Dashboard Preview -->
    <div class="mt-16 relative mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <div class="dashboard-preview p-2 shadow-2xl border border-indigo-200 dark:border-indigo-800 transition-all duration-300">
            <div class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden transition-colors duration-300">
                <!-- Window Controls -->
                <div class="h-8 bg-gray-100 dark:bg-gray-900 flex items-center px-4 transition-colors duration-300">
                    <div class="flex space-x-2">
                        <div class="w-3 h-3 rounded-full bg-red-500"></div>
                        <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                        <div class="w-3 h-3 rounded-full bg-green-500"></div>
                    </div>
                    <div class="mx-auto text-xs text-gray-600 dark:text-gray-400 transition-colors duration-300">
                        Jumuiya Kiganjani Dashboard
                    </div>
                </div>
                
                <!-- Dashboard Content -->
                <div class="h-[600px] sm:h-[90vh] flex items-center justify-center bg-gray-100 dark:bg-gray-900">
                    <div class="text-center p-8">
                        <div class="mx-auto bg-indigo-100 dark:bg-indigo-900 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-users text-indigo-600 dark:text-indigo-300 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Admin Dashboard</h3>
                        <p class="text-gray-600 dark:text-gray-300">Complete overview of your community with key metrics and management tools</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 relative z-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
            <div class="stat-item text-center">
                <h3 class="text-3xl sm:text-4xl font-bold text-indigo-600 dark:text-indigo-400">5+</h3>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Communities</p>
            </div>
            
            <div class="stat-item text-center">
                <h3 class="text-3xl sm:text-4xl font-bold text-indigo-600 dark:text-indigo-400">71+</h3>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Members</p>
            </div>
            
            <div class="stat-item text-center">
                <h3 class="text-3xl sm:text-4xl font-bold text-indigo-600 dark:text-indigo-400">98%</h3>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Satisfaction</p>
            </div>
            
            <div class="stat-item text-center">
                <h3 class="text-3xl sm:text-4xl font-bold text-indigo-600 dark:text-indigo-400">30%</h3>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Growth Rate</p>
            </div>
        </div>
    </div>

    <!-- Features Grid -->
    <div id="features" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 relative z-10">
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-1 rounded-full bg-purple-900 bg-opacity-30 text-purple-300 text-sm font-medium mb-6 border border-purple-800">
                Powerful Features
            </span>
            
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white sm:text-4xl">
                Everything your <span class="text-indigo-600 dark:text-indigo-400">community</span> needs
            </h2>
            
            <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600 dark:text-gray-400">
                Designed to help you connect, organize, and grow your faith community with tools that make administration effortless
            </p>
        </div>

        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Member Management -->
            <div class="feature-card bg-white dark:bg-gray-800 rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-center h-16 w-16 rounded-xl bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-400 mx-auto">
                    <i class="fas fa-users text-xl"></i>
                </div>
                
                <h3 class="mt-6 text-xl font-bold text-gray-900 dark:text-white text-center">Member Directory</h3>
                
                <p class="mt-3 text-base text-gray-600 dark:text-gray-400 text-center">
                    Create comprehensive member profiles with contact details.
                </p>
            </div>

            <!-- Contribution Tracking -->
            <div class="feature-card bg-white dark:bg-gray-800 rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-center h-16 w-16 rounded-xl bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400 mx-auto">
                    <i class="fas fa-coins text-xl"></i>
                </div>
                
                <h3 class="mt-6 text-xl font-bold text-gray-900 dark:text-white text-center">Harambee Tracking</h3>
                
                <p class="mt-3 text-base text-gray-600 dark:text-gray-400 text-center">
                    Manage all community contributions with transparent reporting and detailed financial reports.
                </p>
            </div>

            <!-- Event Management -->
            <div class="feature-card bg-white dark:bg-gray-800 rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-center h-16 w-16 rounded-xl bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-400 mx-auto">
                    <i class="fas fa-calendar-check text-xl"></i>
                </div>
                
                <h3 class="mt-6 text-xl font-bold text-gray-900 dark:text-white text-center">Event Management</h3>
                
                <p class="mt-3 text-base text-gray-600 dark:text-gray-400 text-center">
                    Organize Jumuiya meetings, prayer services, and special events with powerful scheduling tools.
                </p>
            </div>

            <!-- Spiritual Resources -->
            <div class="feature-card bg-white dark:bg-gray-800 rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-center h-16 w-16 rounded-xl bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 mx-auto">
                    <i class="fas fa-book-bible text-xl"></i>
                </div>
                
                <h3 class="mt-6 text-xl font-bold text-gray-900 dark:text-white text-center">Spiritual Resources</h3>
                
                <p class="mt-3 text-base text-gray-600 dark:text-gray-400 text-center">
                    Access daily devotionals, sermon notes, and scripture readings shared by community leaders.
                </p>
            </div>

            <!-- Reporting & Analytics -->
            <div class="feature-card bg-white dark:bg-gray-800 rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-center h-16 w-16 rounded-xl bg-orange-100 dark:bg-orange-900 text-orange-600 dark:text-orange-400 mx-auto">
                    <i class="fas fa-chart-line text-xl"></i>
                </div>
                
                <h3 class="mt-6 text-xl font-bold text-gray-900 dark:text-white text-center">Performance Analytics</h3>
                
                <p class="mt-3 text-base text-gray-600 dark:text-gray-400 text-center">
                    Track community engagement with visual reports on contributions and member growth.
                </p>
            </div>

            <!-- Notifications System -->
            <div class="feature-card bg-white dark:bg-gray-800 rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-center h-16 w-16 rounded-xl bg-pink-100 dark:bg-pink-900 text-pink-600 dark:text-pink-400 mx-auto">
                    <i class="fas fa-bell text-xl"></i>
                </div>
                
                <h3 class="mt-6 text-xl font-bold text-gray-900 dark:text-white text-center">Smart Reminders</h3>
                
                <p class="mt-3 text-base text-gray-600 dark:text-gray-400 text-center">
                    Keep everyone informed with notifications for events and important dates.
                </p>
            </div>
        </div>
    </div>
    
    <!-- Authentication Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                    Join Our Growing Community
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-400 mb-6">
                    Become part of the movement transforming faith communities across Tanzania. Sign up today and experience the difference.
                </p>
                <!-- <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-6 w-6 rounded-md bg-indigo-500 text-white">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="ml-3 text-base text-gray-600 dark:text-gray-400">
                            Free for communities under 50 members
                        </p>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-6 w-6 rounded-md bg-indigo-500 text-white">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="ml-3 text-base text-gray-600 dark:text-gray-400">
                            14-day premium trial for larger communities
                        </p>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-6 w-6 rounded-md bg-indigo-500 text-white">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="ml-3 text-base text-gray-600 dark:text-gray-400">
                            Dedicated support for all community leaders
                        </p>
                    </div>
                </div> -->
            </div>
            
            <div class="bg-gray-50 dark:bg-gray-800 rounded-2xl p-8 shadow-lg">
                <div class="text-center mb-8">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Get Started Today</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">Create your account in minutes</p>
                </div>
                
                <div class="space-y-6">
                    <div class="grid grid-cols-1 gap-4">
                        <a href="<?php echo e(route('register')); ?>" class="btn-primary flex items-center justify-center px-6 py-3 rounded-lg text-white font-medium transition">
                            <i class="fas fa-user-plus mr-2"></i> Create New Account
                        </a>
                        <a href="<?php echo e(route('login')); ?>" class="btn-secondary flex items-center justify-center px-6 py-3 rounded-lg font-medium transition">
                            <i class="fas fa-sign-in-alt mr-2"></i> Sign In
                        </a>
                    </div>
                    
                    <div class="relative mt-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300 dark:border-gray-700"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <!-- <span class="px-2 bg-gray-50 dark:bg-gray-800 text-gray-500 dark:text-gray-400">
                                University Project
                            </span> -->
                        </div>
                    </div>
                    
                    <!-- <div class="text-center text-sm text-gray-600 dark:text-gray-400">
                        <p>Final Year Project by University of Dar es Salaam Students</p>
                    </div> -->
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-16 bg-gray-100 dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                    What Our Community Says
                </h2>
                <p class="text-gray-600 dark:text-gray-400">
                    Hear from our members about their experience with Jumuiya Kiganjani
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="testimonial-card bg-white dark:bg-gray-700 rounded-lg p-6 shadow-md border border-gray-200 dark:border-gray-600">
                    <div class="flex items-center mb-4">
                        <div class="h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center">
                            <svg class="h-6 w-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-gray-900 dark:text-white">Magdalena</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Community Member</p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        "The platform has made it incredibly easy to track our community events and contributions. It's a valuable tool for our organization."
                    </p>
                </div>

                <!-- Testimonial 2 -->
                <div class="testimonial-card bg-white dark:bg-gray-700 rounded-lg p-6 shadow-md border border-gray-200 dark:border-gray-600">
                    <div class="flex items-center mb-4">
                        <div class="h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center">
                            <svg class="h-6 w-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-gray-900 dark:text-white">Modimo Mendoza</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Group Leader</p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        "Managing our group has become much more efficient. The reporting features are especially helpful."
                    </p>
                </div>

                <!-- Testimonial 3 -->
                <div class="testimonial-card bg-white dark:bg-gray-700 rounded-lg p-6 shadow-md border border-gray-200 dark:border-gray-600">
                    <div class="flex items-center mb-4">
                        <div class="h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center">
                            <svg class="h-6 w-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-gray-900 dark:text-white">Sarah Mwaifuge</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Administrator</p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        "The platform is intuitive for all members to use, regardless of their technical expertise."
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section id="team-section" class="py-16 bg-white dark:bg-gray-900">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                    Meet the Developers
                </h2>
                <p class="text-gray-600 dark:text-gray-400">
                    The team behind Jumuiya Kiganjani
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Ludovick Bakera -->
                <div class="transition hover:scale-105 hover:shadow-lg bg-indigo-50 dark:bg-indigo-900/30 rounded-lg p-8 shadow-md text-center">
                    <div class="flex items-center justify-center mb-4">
                        <div class="h-14 w-14 rounded-full bg-indigo-200 dark:bg-indigo-800 flex items-center justify-center">
                            <i class="fas fa-user-tie text-indigo-700 dark:text-indigo-300 text-2xl"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Ludovick Bakera</h3>
                    <p class="text-indigo-700 dark:text-indigo-300 font-medium mb-1">Full Stack Developer</p>
                </div>
                <!-- Dickson Boniphace -->
                <div class="transition hover:scale-105 hover:shadow-lg bg-indigo-50 dark:bg-indigo-900/30 rounded-lg p-8 shadow-md text-center">
                    <div class="flex items-center justify-center mb-4">
                        <div class="h-14 w-14 rounded-full bg-indigo-200 dark:bg-indigo-800 flex items-center justify-center">
                            <i class="fas fa-user-cog text-indigo-700 dark:text-indigo-300 text-2xl"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Dickson Boniphace</h3>
                    <p class="text-indigo-700 dark:text-indigo-300 font-medium mb-1">Front End Developer & Project Manager</p>
                </div>
                <!-- Magdalena Munisi -->
                <div class="transition hover:scale-105 hover:shadow-lg bg-indigo-50 dark:bg-indigo-900/30 rounded-lg p-8 shadow-md text-center">
                    <div class="flex items-center justify-center mb-4">
                        <div class="h-14 w-14 rounded-full bg-indigo-200 dark:bg-indigo-800 flex items-center justify-center">
                            <i class="fas fa-user-edit text-indigo-700 dark:text-indigo-300 text-2xl"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Magdalena Munisi</h3>
                    <p class="text-indigo-700 dark:text-indigo-300 font-medium mb-1">Web Designer & Database Development</p>
                </div>
            </div>
        </div>
    </section>
    <!-- End Team Section -->

    <!-- Final CTA -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white sm:text-4xl">
            Ready to strengthen your <span class="text-indigo-600 dark:text-indigo-400">community</span>?
        </h2>
        <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600 dark:text-gray-400">
            Join thousands of faith communities already using Jumuiya Kiganjani
        </p>
        <div class="mt-8">
            <a href="<?php echo e(route('register')); ?>" class="btn-primary inline-flex items-center justify-center px-8 py-4 text-lg font-semibold rounded-xl">
                Get Started for Free
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.landing', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\jumuiyakiganjani\resources\views/welcome.blade.php ENDPATH**/ ?>