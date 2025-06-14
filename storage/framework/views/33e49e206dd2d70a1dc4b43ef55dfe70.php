<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Hauz Hayag</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#00A4B8',
                        secondary: '#FFB800',
                        neutral: '#F3F4F6',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.5s ease-out',
                        'slide-down': 'slideDown 0.5s ease-out',
                        'slide-left': 'slideLeft 0.5s ease-out',
                        'slide-right': 'slideRight 0.5s ease-out',
                        'slide-in-left': 'slideInLeft 0.8s ease-out',
                        'slide-in-right': 'slideInRight 0.8s ease-out',
                        'slide-in-up': 'slideInUp 0.8s ease-out',
                        'bounce-in': 'bounceIn 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55)',
                        'bounce-in-left': 'bounceInLeft 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55)',
                        'bounce-in-right': 'bounceInRight 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55)',
                        'pulse-slow': 'pulse 3s infinite',
                        'bounce-slow': 'bounce 3s infinite',
                        'float': 'float 3s ease-in-out infinite',
                        'shake': 'shake 0.5s cubic-bezier(.36,.07,.19,.97) both',
                        'elevate': 'elevate 0.3s ease-out forwards',
                        'rotate-3d': 'rotate3d 0.5s ease-out forwards',
                        'stagger-fade': 'staggerFade 0.5s ease-out forwards',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        slideDown: {
                            '0%': { transform: 'translateY(-20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        slideLeft: {
                            '0%': { transform: 'translateX(20px)', opacity: '0' },
                            '100%': { transform: 'translateX(0)', opacity: '1' },
                        },
                        slideRight: {
                            '0%': { transform: 'translateX(-20px)', opacity: '0' },
                            '100%': { transform: 'translateX(0)', opacity: '1' },
                        },
                        slideInLeft: {
                            '0%': { transform: 'translateX(-100%)', opacity: '0' },
                            '100%': { transform: 'translateX(0)', opacity: '1' },
                        },
                        slideInRight: {
                            '0%': { transform: 'translateX(100%)', opacity: '0' },
                            '100%': { transform: 'translateX(0)', opacity: '1' },
                        },
                        slideInUp: {
                            '0%': { transform: 'translateY(100%)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        bounceIn: {
                            '0%': { transform: 'scale(0.3)', opacity: '0' },
                            '50%': { transform: 'scale(1.05)', opacity: '0.8' },
                            '70%': { transform: 'scale(0.9)', opacity: '0.9' },
                            '100%': { transform: 'scale(1)', opacity: '1' },
                        },
                        bounceInLeft: {
                            '0%': { transform: 'translateX(-100%)', opacity: '0' },
                            '60%': { transform: 'translateX(25%)', opacity: '0.8' },
                            '75%': { transform: 'translateX(-10%)', opacity: '0.9' },
                            '90%': { transform: 'translateX(5%)', opacity: '0.95' },
                            '100%': { transform: 'translateX(0)', opacity: '1' },
                        },
                        bounceInRight: {
                            '0%': { transform: 'translateX(100%)', opacity: '0' },
                            '60%': { transform: 'translateX(-25%)', opacity: '0.8' },
                            '75%': { transform: 'translateX(10%)', opacity: '0.9' },
                            '90%': { transform: 'translateX(-5%)', opacity: '0.95' },
                            '100%': { transform: 'translateX(0)', opacity: '1' },
                        },
                        float: {
                            '0%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' },
                            '100%': { transform: 'translateY(0px)' },
                        },
                        shake: {
                            '10%, 90%': { transform: 'translate3d(-1px, 0, 0)' },
                            '20%, 80%': { transform: 'translate3d(2px, 0, 0)' },
                            '30%, 50%, 70%': { transform: 'translate3d(-4px, 0, 0)' },
                            '40%, 60%': { transform: 'translate3d(4px, 0, 0)' },
                        },
                        elevate: {
                            '0%': { transform: 'translateY(0)', boxShadow: '0 4px 6px rgba(0, 0, 0, 0.1)' },
                            '100%': { transform: 'translateY(-5px)', boxShadow: '0 10px 15px rgba(0, 0, 0, 0.2)' },
                        },
                        rotate3d: {
                            '0%': { transform: 'perspective(1000px) rotateX(0deg) rotateY(0deg)' },
                            '100%': { transform: 'perspective(1000px) rotateX(5deg) rotateY(5deg)' },
                        },
                        staggerFade: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                    },
                }
            }
        }
    </script>
    <style>
        .animate-on-scroll {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease-out;
        }
        .animate-on-scroll.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .hover-scale {
            transition: transform 0.3s ease;
        }
        .hover-scale:hover {
            transform: scale(1.05);
        }
        .hover-rotate {
            transition: transform 0.3s ease;
        }
        .hover-rotate:hover {
            transform: rotate(5deg);
        }
    </style>
</head>

<body class="bg-neutral font-sans">
    <header class="bg-white shadow fixed w-full top-0 z-50 animate-slide-down">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                    <img src="<?php echo e(asset('image/logohauzhayag.jpg')); ?>"
                         alt="Hauz Hayag Logo"
                         class="h-16 w-auto rounded-lg shadow-md">
                    <span class="text-2xl font-bold text-primary">Hauz Hayag</span>
                    <button id="mobileMenuButton" class="md:hidden text-gray-600 hover:text-primary">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
               
                <!-- Desktop Navigation -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="flex items-center space-x-2 text-gray-700 hover:text-primary transition">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
                    </a>
                    <a href="#scholarships" class="flex items-center space-x-2 text-gray-700 hover:text-primary transition">
                        <i class="fas fa-graduation-cap"></i>
                        <span>Scholarships</span>
                    </a>
                    <a href="#job-offers" class="flex items-center space-x-2 text-gray-700 hover:text-primary transition">
                        <i class="fas fa-briefcase"></i>
                        <span>Job Offers</span>
                    </a>
                    <a href="#events" class="flex items-center space-x-2 text-gray-700 hover:text-primary transition">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Events</span>
                    </a>
                    <a href="#about-us" class="flex items-center space-x-2 text-gray-700 hover:text-primary transition">
                        <i class="fas fa-info-circle"></i>
                        <span>About Us</span>
                    </a>
                    <a href="/login" class="flex items-center space-x-2 bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-400 transition">
                        <i class="fas fa-lock"></i>
                        <span>Login</span>
                    </a>
                </nav>                
            </div>

            <!-- Mobile Navigation -->
            <nav id="mobileMenu" class="md:hidden hidden py-4 space-y-4">
                <a href="#home" class="flex items-center space-x-2 text-gray-700 hover:text-primary transition">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
                <a href="#scholarships" class="flex items-center space-x-2 text-gray-700 hover:text-primary transition">
                    <i class="fas fa-graduation-cap"></i>
                    <span>Scholarships</span>
                </a>
                <a href="#job-offers" class="flex items-center space-x-2 text-gray-700 hover:text-primary transition">
                    <i class="fas fa-briefcase"></i>
                    <span>Job Offers</span>
                </a>
                <a href="#events" class="flex items-center space-x-2 text-gray-700 hover:text-primary transition">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Events</span>
                </a>
                <a href="#about-us" class="flex items-center space-x-2 text-gray-700 hover:text-primary transition">
                    <i class="fas fa-info-circle"></i>
                    <span>About Us</span>
                </a>
                <a href="/login" class="flex items-center space-x-2 bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-400 transition">
                    <i class="fas fa-lock"></i>
                    <span>Login</span>
                </a>
                <a href="/scholarship/login" class="flex items-center space-x-2 bg-secondary text-white px-4 py-2 rounded-lg hover:bg-yellow-500 transition">
                    <i class="fas fa-graduation-cap"></i>
                    <span>Scholarship Login</span>
                </a>
            </nav>
        </div>
    </header>

    <main class="pt-24">
        <!-- Hero Section with enhanced animations -->
        <section id="home" class="relative h-screen">
            <div class="absolute inset-0 overflow-hidden">
                <div id="heroSlides" class="flex h-full transition-transform duration-700 ease-in-out">
                    <!-- Slide 1 -->
                    <div class="min-w-full h-full">
                        <img src="<?php echo e(asset('image/feedingprogram.jpg')); ?>" alt="Description 1" class="w-full h-full object-cover"
                             alt="Students Learning"
                             class="w-full h-full object-cover">
                    </div>
                    <!-- Slide 2 -->
                    <div class="min-w-full h-full">
                        <img src="<?php echo e(asset('image/firedrill.jpg')); ?>" alt="Description 1" class="w-full h-full object-cover"
                             alt="Community Support"
                             class="w-full h-full object-cover">
                    </div>
                    <!-- Slide 3 -->
                    <div class="min-w-full h-full">
                        <img src="<?php echo e(asset('image/goods.jpg')); ?>" alt="Description 1" class="w-full h-full object-cover"
                             alt="Education Success"
                             class="w-full h-full object-cover">
                    </div>
                </div>
                <div class="absolute inset-0 bg-black/40 animate-fade-in"></div>
            </div>

            <div class="relative z-10 h-full flex items-center justify-center">
                <div class="text-center px-4 animate-slide-up">
                    <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 animate-fade-in">Welcome to Hauz Hayag</h1>
                    <p class="text-xl md:text-2xl text-white/90 mb-8 animate-fade-in delay-100">Empowering communities through education and opportunities</p>
                    <div class="flex flex-col md:flex-row gap-4 justify-center animate-slide-up delay-200">
            <button class="bg-primary text-white px-8 py-3 rounded-lg hover:bg-blue-400 transition hover-scale"
                      onclick="window.location.href='<?php echo e(route('donation')); ?>'">
                     <i class="fas fa-heart mr-2 animate-pulse-slow"></i>Donate Now
            </button>
                        <button class="bg-white text-primary border-2 border-white px-8 py-3 rounded-lg hover:bg-white/90 transition hover-scale" onclick="openEventModal()">
                            <i class="fas fa-calendar-alt mr-2 animate-bounce-slow"></i>Register for Events
                        </button>
                    </div>
                </div>
            </div>
        </section>

    
<!-- <?php if (isset($component)) { $__componentOriginal5511be387be4bdd1af94c928174f3c61 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5511be387be4bdd1af94c928174f3c61 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.test','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('test'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <p>Testing component rendering.</p>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5511be387be4bdd1af94c928174f3c61)): ?>
<?php $attributes = $__attributesOriginal5511be387be4bdd1af94c928174f3c61; ?>
<?php unset($__attributesOriginal5511be387be4bdd1af94c928174f3c61); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5511be387be4bdd1af94c928174f3c61)): ?>
<?php $component = $__componentOriginal5511be387be4bdd1af94c928174f3c61; ?>
<?php unset($__componentOriginal5511be387be4bdd1af94c928174f3c61); ?>
<?php endif; ?> -->

        <!-- Urgent Campaigns Section -->
        <?php if($urgentCampaigns->count() > 0): ?>
            <section id="urgent-campaigns" class="py-16 bg-neutral">
                <div class="max-w-4xl mx-auto px-4">
                    <h2 class="text-3xl font-bold text-gray-800 mb-8">Urgent Donation Needs</h2>
                    <?php $__currentLoopData = $urgentCampaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campaign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-white rounded-xl shadow p-6 mb-6">
                            <h3 class="text-xl font-bold mb-2"><?php echo e($campaign->title); ?></h3>
                            <p class="text-gray-600 mb-4"><?php echo e($campaign->description); ?></p>
                            <?php
                                $progress = ($campaign->goal_amount > 0) ? ($campaign->current_amount / $campaign->goal_amount) * 100 : 0;
                                $progress = min(100, max(0, $progress)); // Ensure progress is between 0 and 100
                            ?>
                            <div class="flex justify-between items-center text-sm text-gray-700 mb-2">
                                <span><?php echo e(number_format($progress, 2)); ?>% of the goal achieved (Goal: ₱<?php echo e(number_format($campaign->goal_amount, 2)); ?>)</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
                                <div class="bg-primary h-2.5 rounded-full" style="width: <?php echo e($progress); ?>%"></div>
                            </div>
                            <a href="<?php echo e(route('donation')); ?>" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-blue-400 transition">Donate Now</a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </section>
        <?php endif; ?>

        <!-- Scholarships Section with scroll animations -->
        <section id="scholarships" class="max-w-7xl mx-auto py-16 px-4 bg-gradient-to-br from-blue-50 via-white to-blue-50 rounded-3xl shadow-lg my-12">
            <h2 class="text-3xl font-bold text-center mb-12 text-primary animate-bounce-in">Scholarship & Programs</h2>
  <div class="grid md:grid-cols-3 gap-8">
      <!-- Scholarship 1 -->
                <div class="bg-white shadow-lg p-6 rounded-xl flex flex-col border-t-4 border-primary hover:animate-elevate hover:animate-rotate-3d transition-all duration-300 animate-bounce-in-left" style="animation-delay: 0.1s">
                    <div class="text-primary text-2xl mb-4"><i class="fas fa-users"></i></div>
          <h3 class="text-xl font-semibold mb-2">Community-based Scholarship</h3>
          <p class="text-gray-600 mb-4">Open to all qualified students who demonstrate academic excellence and financial need.</p>
          <ul class="list-disc list-inside text-gray-600 mb-6">
              <li>Full tuition coverage</li>
              <li>Monthly allowance</li>
              <li>Mentorship program</li>
          </ul>
                    <button class="flex items-center justify-center gap-2 bg-primary text-white py-2 px-6 rounded-lg hover:bg-blue-400 mt-auto transition mb-2 font-semibold shadow" onclick="openScholarshipModal()">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"></path></svg>
                        Apply Now
                    </button>
      </div>
     
      <!-- Scholarship 2 -->
                <div class="bg-white shadow-lg p-6 rounded-xl flex flex-col border-t-4 border-primary hover:animate-elevate hover:animate-rotate-3d transition-all duration-300 animate-bounce-in" style="animation-delay: 0.2s">
                    <div class="text-primary text-2xl mb-4"><i class="fas fa-female"></i></div>
          <h3 class="text-xl font-semibold mb-2">In-house Scholarship for Girls</h3>
          <p class="text-gray-600 mb-4">Exclusive program designed to empower young women through education and leadership.</p>
          <ul class="list-disc list-inside text-gray-600 mb-6">
              <li>Full tuition and housing</li>
              <li>Leadership training</li>
              <li>Career guidance</li>
          </ul>
                    <button class="flex items-center justify-center gap-2 bg-primary text-white py-2 px-6 rounded-lg hover:bg-blue-400 mt-auto transition mb-2 font-semibold shadow" onclick="openScholarshipModal()">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"></path></svg>
                        Apply Now
                    </button>
      </div>
     
      <!-- Scholarship 3 -->
                <div class="bg-white shadow-lg p-6 rounded-xl flex flex-col border-t-4 border-primary hover:animate-elevate hover:animate-rotate-3d transition-all duration-300 animate-bounce-in-right" style="animation-delay: 0.3s">
                    <div class="text-primary text-2xl mb-4"><i class="fas fa-female"></i></div>
          <h3 class="text-xl font-semibold mb-2">Feeding Program</h3>
          <p class="text-gray-600 mb-4">A feeding program for less fortunate children living nearby area.</p>
          <ul class="list-disc list-inside text-gray-600 mb-6">
              <li>Food Every Sunday</li>
              <li>Parent's Orientation about Food Consumption</li>
              <li>Free Check-up</li>
          </ul>
      </div>
  </div>
</section>

        <!-- Job Offers Section with enhanced animations -->
<section id="job-offers" class="bg-white py-16">
         <div class="max-w-7xl mx-auto px-4">
                <h2 class="text-3xl font-bold text-center mb-12 animate-bounce-in">Job Opportunities</h2>
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Job Cards (3) -->
                    <div class="bg-neutral shadow rounded-lg p-6 flex flex-col hover:animate-elevate hover:animate-rotate-3d transition-all duration-300 animate-bounce-in-left" style="animation-delay: 0.1s">
                        <span class="bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full">Full-time</span>
                        <h3 class="mt-4 font-semibold text-lg">Software Developer</h3>
                        <p class="text-gray-600">Build innovative solutions for education.</p>
                        <p class="text-sm text-gray-500 mt-2">Tech Solutions Inc. | San Francisco, CA</p>
                        <button class="mt-auto bg-primary text-white w-full py-2 px-6 rounded-lg hover:bg-blue-700 transition" onclick="openJobDetailsModal()">View Details</button>
                    </div>
                    <div class="bg-neutral shadow rounded-lg p-6 flex flex-col hover:animate-elevate hover:animate-rotate-3d transition-all duration-300 animate-bounce-in" style="animation-delay: 0.2s">
                        <span class="bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">Part-time</span>
                        <h3 class="mt-4 font-semibold text-lg">Marketing Coordinator</h3>
                        <p class="text-gray-600">Promote our mission through marketing.</p>
                        <p class="text-sm text-gray-500 mt-2">Global Marketing Agency | New York, NY</p>
                        <button class="mt-auto bg-primary text-white w-full py-2 px-6 rounded-lg hover:bg-blue-700 transition" onclick="openJobDetailsModal()">View Details</button>
                    </div>
                    <div class="bg-neutral shadow rounded-lg p-6 flex flex-col hover:animate-elevate hover:animate-rotate-3d transition-all duration-300 animate-bounce-in-right" style="animation-delay: 0.3s">
                        <span class="bg-yellow-100 text-yellow-800 text-sm px-3 py-1 rounded-full">Internship</span>
                        <h3 class="mt-4 font-semibold text-lg">Research Assistant</h3>
                        <p class="text-gray-600">Gain experience in education research.</p>
                        <p class="text-sm text-gray-500 mt-2">Education Institute | Boston, MA</p>
                        <button class="mt-auto bg-primary text-white w-full py-2 px-6 rounded-lg hover:bg-blue-700 transition" onclick="openJobDetailsModal()">View Details</button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Events Section with enhanced animations -->
<section id="events" class="py-16 bg-neutral">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12 animate-bounce-in">Upcoming Events</h2>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php $__empty_1 = true; $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:animate-elevate hover:animate-rotate-3d transition-all duration-300 animate-bounce-in-left" style="animation-delay: 0.1s">
                <div class="relative h-48 overflow-hidden bg-primary/10">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <svg class="w-20 h-20 text-primary/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2"><?php echo e($event->title); ?></h3>
                    <div class="flex items-center text-gray-600 mb-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-sm">
                            <?php echo e($event->start_date); ?>

                        </span>
                    </div>
                    <div class="flex items-center text-gray-600 mb-4">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="text-sm"><?php echo e($event->location); ?></span>
                    </div>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2"><?php echo e($event->description); ?></p>
                    <div class="flex justify-end">
                        <button onclick="showEventDetails('<?php echo e($event->id); ?>')" 
                                class="text-primary hover:text-primary/80 text-sm font-medium flex items-center">
                            Learn More
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <h3 class="text-xl font-medium text-gray-500">No upcoming events at the moment</h3>
                <p class="text-gray-400 mt-2">Check back later for new events!</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

        <!-- Success Stories Section with enhanced animations -->
        <section id="success-stories" class="py-20 bg-gradient-to-b from-neutral to-white">
            <div class="max-w-7xl mx-auto px-2 sm:px-6">
                <h2 class="text-4xl font-extrabold text-center text-primary mb-12 tracking-tight animate-bounce-in">Our Top Testimony</h2>
                <div class="relative overflow-hidden">
                    <div id="slides" class="flex transition-transform duration-500 ease-in-out" style="width: 100%;">
                        <!-- Slide 1 -->
                        <div class="slide flex flex-col md:flex-row items-center min-w-full gap-8 bg-gray-50 rounded-2xl shadow-xl p-6 md:p-14 hover:animate-elevate transition-all duration-300" style="animation-delay: 0.1s">
                            <div class="relative flex flex-col items-center w-full md:w-1/2">
                                <!-- Large Orange Circle Background -->
                                <div class="absolute z-0 flex justify-center items-center" style="top: 0; left: 50%; transform: translateX(-50%);">
                                    <div class="w-72 h-72 md:w-96 md:h-96 rounded-full bg-blue-400 ring-4 ring-black flex items-center justify-center">
                                        <img src="<?php echo e(asset('image/alumni2.jpg')); ?>"
                                             alt="Daylan Unabia, Scholarship Graduate Alumni"
                                             class="w-48 h-48 md:w-64 md:h-64 object-contain rounded-full transform scale-[1.15]">
                                    </div>
                                </div>
                                <!-- Profile Image (overlapping the bottom of the circle) -->
                                <img src="<?php echo e(asset('image/alumni2.jpg')); ?>"
                                     alt="Daylan Unabia, Scholarship Graduate Alumni"
                                     class="relative z-10 w-48 h-48 md:w-64 md:h-64 object-contain rounded-full mt-10 transform scale-[1.15]" style="margin-bottom: -2.5rem;">
                                <!-- Name and Banner -->
                                <div class="relative z-20 w-64 md:w-80 mt-2">
                                    <div class="bg-yellow-200 text-center py-2 rounded-t-lg font-bold text-xl md:text-2xl shadow" style="transform: skew(-10deg);">
                                        <span style="transform: skew(10deg); display: inline-block;">Daylyn Unabia</span>
                                    </div>
                                    <div class="bg-blue-700 text-white text-center py-1 rounded-b-lg text-sm md:text-base shadow -mt-1" style="transform: skew(-10deg);">
                                        <span style="transform: skew(10deg); display: inline-block;">ALUMNA</span>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full md:w-1/2 flex flex-col justify-center mt-4 md:mt-0">
                                <p class="text-lg md:text-2xl text-gray-700 font-medium leading-relaxed">Growing up in a low-income family with eight siblings was 
                                    extremely difficult, as we struggled to meet even our basic needs. 
                                    Sacrifices were part of our daily life, and the future often felt uncertain. 
                                    Being accepted into the Hauz Hayag Scholarship and Training Program 
                                    was a life-changing blessing that opened doors to new opportunities. 
                                    Now, as a researcher and graduate student, I work hard to uplift my 
                                    family and contribute positively to society.</p>
                            </div>
                        </div>
                        <!-- Slide 2 -->
                        <div class="slide flex flex-col md:flex-row items-center min-w-full gap-8 bg-gray-50 rounded-2xl shadow-xl p-6 md:p-14 hover:animate-elevate transition-all duration-300" style="animation-delay: 0.2s">
                            <div class="relative flex flex-col items-center w-full md:w-1/2">
                                <div class="absolute z-0 flex justify-center items-center" style="top: 0; left: 50%; transform: translateX(-50%);">
                                    <div class="w-72 h-72 md:w-96 md:h-96 rounded-full bg-blue-400 ring-4 ring-black flex items-center justify-center">
                                        <!-- Removed duplicate image -->
                                    </div>
                                </div>
                                <img src="<?php echo e(asset('image/employee3.jpg')); ?>"
                                     alt="Nissan Geagonia, Cebu City Employee"
                                     class="relative z-10 w-48 h-48 md:w-64 md:h-64 object-contain rounded-full mt-10 transform scale-[1.15]" style="margin-bottom: -2.5rem;">
                                <div class="relative z-20 w-64 md:w-80 mt-2">
                                    <div class="bg-yellow-200 text-center py-2 rounded-t-lg font-bold text-xl md:text-2xl shadow" style="transform: skew(-10deg);">
                                        <span style="transform: skew(10deg); display: inline-block;">Geagonia Nissan</span>
                                    </div>
                                    <div class="bg-blue-700 text-white text-center py-1 rounded-b-lg text-sm md:text-base shadow -mt-1" style="transform: skew(-10deg);">
                                        <span style="transform: skew(10deg); display: inline-block;">CEBU CITY EMPLOYEE</span>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full md:w-1/2 flex flex-col justify-center mt-4 md:mt-0">
                                <p class="text-lg md:text-2xl text-gray-700 font-medium leading-relaxed">I'm inspired to work at Hayag because I've seen 
                                    how it brings real change to people's 
                                    lives through scholarships and feeding programs. 
                                    Over the past nine years, I've witnessed many families, 
                                    including my own, receive the support they need my daughter 
                                    even got to go to college. The benefits and financial help make 
                                    working here even more meaningful. It's more than just a job and it's a 
                                    place where I've grown and found purpose by helping others.</p>
                            </div>
                        </div>
                        <!-- Slide 3 -->
                        <div class="slide flex flex-col md:flex-row items-center min-w-full gap-8 bg-gray-50 rounded-2xl shadow-xl p-6 md:p-14 hover:animate-elevate transition-all duration-300" style="animation-delay: 0.3s">
                            <div class="relative flex flex-col items-center w-full md:w-1/2">
                                <div class="absolute z-0 flex justify-center items-center" style="top: 0; left: 50%; transform: translateX(-50%);">
                                    <div class="w-72 h-72 md:w-96 md:h-96 rounded-full bg-blue-400 ring-4 ring-black flex items-center justify-center">
                                        <img src="<?php echo e(asset('image/student2.jpg')); ?>"
                                             alt="Gwyne Otida, Current Student"
                                             class="w-48 h-48 md:w-64 md:h-64 object-contain rounded-full transform scale-[1.15]">
                                    </div>
                                </div>
                                <img src="<?php echo e(asset('image/student2.jpg')); ?>"
                                     alt="Gwyne Otida, Current Student"
                                     class="relative z-10 w-48 h-48 md:w-64 md:h-64 object-contain rounded-full mt-10 transform scale-[1.15]" style="margin-bottom: -2.5rem;">
                                <div class="relative z-20 w-64 md:w-80 mt-2">
                                    <div class="bg-yellow-200 text-center py-2 rounded-t-lg font-bold text-xl md:text-2xl shadow" style="transform: skew(-10deg);">
                                        <span style="transform: skew(10deg); display: inline-block;">Gwyne Otida</span>
                                    </div>
                                    <div class="bg-blue-700 text-white text-center py-1 rounded-b-lg text-sm md:text-base shadow -mt-1" style="transform: skew(-10deg);">
                                        <span style="transform: skew(10deg); display: inline-block;">CURRENT STUDENT</span>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full md:w-1/2 flex flex-col justify-center mt-4 md:mt-0">
                                <p class="text-lg md:text-2xl text-gray-700 font-medium leading-relaxed">As a child from a less privileged background, 
                                    I often felt trapped by poverty and unsure of my purpose. But Hauz Hayag 
                                    became the light that helped me escape hopelessness and believe in myself again. 
                                    Through their support, I started to rebuild my dreams and see my worth. 
                                    I'm grateful for the kind souls behind Hayag who helped me thrive, 
                                    and I know the younger me would be proud of how far I've come.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Slider Controls -->
                    <button onclick="prevSlide()" class="absolute left-0 top-1/2 -translate-y-1/2 bg-primary text-white p-3 rounded-full shadow-lg hover:bg-blue-400 transition z-10 focus:outline-none focus:ring-2 focus:ring-primary/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                    </button>
                    <button onclick="nextSlide()" class="absolute right-0 top-1/2 -translate-y-1/2 bg-primary text-white p-3 rounded-full shadow-lg hover:bg-blue-400 transition z-10 focus:outline-none focus:ring-2 focus:ring-primary/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </button>
                    <!-- Dots -->
                    <div class="flex justify-center mt-8 space-x-3">
                        <button class="dot w-4 h-4 rounded-full bg-gray-300 border-2 border-primary transition" onclick="goToSlide(0)"></button>
                        <button class="dot w-4 h-4 rounded-full bg-gray-300 border-2 border-primary transition" onclick="goToSlide(1)"></button>
                        <button class="dot w-4 h-4 rounded-full bg-gray-300 border-2 border-primary transition" onclick="goToSlide(2)"></button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Track Application Section -->
        <section id="track-application" class="py-20 bg-gradient-to-b from-white to-neutral">
            <div class="max-w-3xl mx-auto px-4">
                <h2 class="text-4xl font-extrabold text-center text-primary mb-8 tracking-tight animate-bounce-in">Track Your Application</h2>
                <p class="text-center text-gray-600 mb-8">Enter your tracking code to check your scholarship application status</p>
                <div class="bg-white/90 p-10 rounded-3xl shadow-2xl border border-primary/20 animate-fade-in">
                    <form method="POST" action="<?php echo e(route('scholarship.track')); ?>" class="space-y-8">
                        <?php echo csrf_field(); ?>
                        <div>
                            <label for="tracking_code" class="block text-base font-semibold mb-2 text-gray-700">Tracking Code</label>
                            <input type="text" name="tracking_code" id="tracking_code"
                                class="w-full px-5 py-3 border-2 border-primary/30 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-colors text-lg placeholder-gray-400 shadow-sm"
                                placeholder="Enter your 8-digit tracking code"
                                maxlength="8"
                                required>
                        </div>
                        <?php if(session('error')): ?>
                            <div class="flex items-center bg-red-50 border-l-4 border-red-400 p-4 rounded-xl shadow animate-fade-in">
                                <svg class="h-6 w-6 text-red-400 mr-3" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-base text-red-700"><?php echo e(session('error')); ?></span>
                            </div>
                        <?php endif; ?>
                        <div class="flex justify-center">
                            <button type="submit"
                                class="inline-flex items-center px-8 py-3 border border-transparent text-lg font-semibold rounded-xl shadow-md text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all gap-2 group">
                                <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                Track Application
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <!-- About Us Section -->
        <section id="about-us" class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4">
                <h2 class="text-3xl font-bold text-center mb-12 animate-bounce-in">About Us</h2>
               
                <!-- Vision and Mission -->
                <div class="grid md:grid-cols-2 gap-8 mb-16">
                    <div class="bg-primary/5 p-8 rounded-xl hover:animate-elevate hover:animate-rotate-3d transition-all duration-300 animate-bounce-in-left" style="animation-delay: 0.1s">
                        <div class="text-primary text-4xl mb-4">
                            <i class="fas fa-eye"></i>
                        </div>
                        <h3 class="text-2xl font-semibold mb-4">Our Vision</h3>
                        <p class="text-gray-700 leading-relaxed">To create a world where every student has access to quality education and career opportunities, regardless of their background or circumstances.</p>
                    </div>
                    <div class="bg-primary/5 p-8 rounded-xl hover:animate-elevate hover:animate-rotate-3d transition-all duration-300 animate-bounce-in-right" style="animation-delay: 0.2s">
                        <div class="text-primary text-4xl mb-4">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h3 class="text-2xl font-semibold mb-4">Our Mission</h3>
                        <p class="text-gray-700 leading-relaxed">To empower students through comprehensive scholarship programs, guidance, and development, creating a lasting impact on their lives and communities.</p>
                    </div>
                </div>

                <!-- Impact Slider -->
                <div class="relative overflow-hidden rounded-2xl shadow-xl animate-on-scroll">
                    <div id="impactSlides" class="flex transition-transform duration-500 ease-in-out">
                        <!-- Slide 1 -->
                        <div class="min-w-full">
                            <div class="relative h-96">
                                <img src="<?php echo e(asset('image/feeding2.jpg')); ?>" alt="Description 1" class="w-full h-full object-cover"
                                     alt="Hauz Hayag feeding"
                                     class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                                    <div class="text-center text-white p-8">
                                        <h3 class="text-3xl font-bold mb-4">Feeding program</h3>
                                        <p class="text-xl">The mission is to reduce hunger and support the health of individuals, especially children and those in need. This is done by providing regular access to nutritious meals.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Slide 2 -->
                        <div class="min-w-full">
                            <div class="relative h-96">
                                <img src="<?php echo e(asset('image/education.jpg')); ?>" alt="Description 1" class="w-full h-full object-cover"
                                     alt="Hauz Hayag Education"
                                     class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                                    <div class="text-center text-white p-8">
                                        <h3 class="text-3xl font-bold mb-4">Education</h3>
                                        <p class="text-xl">The goal is to equip individuals with knowledge, skills, and values for a better future. It aims to help them lead successful and meaningful lives.
</p>
                                    </div>  
                                </div>
                            </div>
                        </div>
                        <!-- Slide 3 -->
                        <div class="min-w-full">
                            <div class="relative h-96">
                                <img src="<?php echo e(asset('image/growth.jpg')); ?>" alt="Description 1" class="w-full h-full object-cover"
                                     alt="Award Ceremony"
                                     class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                                    <div class="text-center text-white p-8">
                                        <h3 class="text-3xl font-bold mb-4">Growth of Knowledge</h3>
                                        <p class="text-xl">The aim is to develop the ability to read, understand, and use information effectively. This empowers individuals to make wise decisions and actively participate in society.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Slider Controls -->
                    <button onclick="prevImpactSlide()" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/80 text-primary p-3 rounded-full shadow-lg hover:bg-white transition z-10">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button onclick="nextImpactSlide()" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/80 text-primary p-3 rounded-full shadow-lg hover:bg-white transition z-10">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                    <!-- Dots -->
                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2">
                        <button class="w-3 h-3 rounded-full bg-white/80 hover:bg-white transition" onclick="goToImpactSlide(0)"></button>
                        <button class="w-3 h-3 rounded-full bg-white/80 hover:bg-white transition" onclick="goToImpactSlide(1)"></button>
                        <button class="w-3 h-3 rounded-full bg-white/80 hover:bg-white transition" onclick="goToImpactSlide(2)"></button>
                    </div>
                </div>
            </div>
        </section>

        <footer class="bg-[#e6f4ea] text-gray-800 py-10 px-6 mt-12 animate-fade-in">
            <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
              <!-- About Section -->
              <div>
                <h2 class="text-lg font-semibold mb-4">Hauz Hayag Scholarship</h2>
                <p class="text-sm leading-relaxed">
                  Supporting education through scholarship and nourishment. Hauz Hayag believes in empowering the youth for a brighter future.
                </p>
              </div>
         
              <!-- Quick Links -->
              <div>
                <h2 class="text-lg font-semibold mb-4">Quick Links</h2>
                <ul class="space-y-2 text-sm">
                  <li><a href="#home" class="hover:underline">Home</a></li>
                  <li><a href="#scholarships" class="hover:underline">Programs</a></li>
                  <li><a href="#about-us" class="hover:underline">About Us</a></li>
                  <li><button class="hover:underline text-left" onclick="handleLoginClick()">Login</button></li>
                </ul>
              </div>
         
              <!-- Contact Info -->
              <div>
                <h2 class="text-lg font-semibold mb-4">Contact Us</h2>
                <p class="text-sm">📍 Carlock Street, San Nicolas Proper, Cebu City, Philippines</p>
                <p class="text-sm">📧 hauzhayag143@gmail.com</p>
                <p class="text-sm">📞 (032) 384 6594</p>
                <p class="text-sm">🌐 hayag-project.com</p>
              </div>
            </div>
         
            <div class="border-t mt-10 pt-4 text-center text-sm text-gray-500">
              &copy; 2025 Hauz Hayag Scholarship. All rights reserved.
            </div>
          </footer>
    </main>

    <!-- Job Details Modal -->
    <div id="jobDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden">
        <div class="bg-white p-6 md:p-10 rounded-xl shadow-lg w-full max-w-md mx-2 relative">
            <button onclick="closeJobDetailsModal()" class="absolute top-2 right-3 text-gray-400 hover:text-black text-2xl font-bold">&times;</button>
            <h2 class="text-2xl font-bold mb-4 text-primary text-center">Job Details</h2>
            <div class="space-y-4">
                <div>
                    <h3 class="font-semibold text-gray-700">Company</h3>
                    <p class="text-gray-600">Sample Company</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-700">Role</h3>
                    <p class="text-gray-600">Sample Role</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-700">Qualifications</h3>
                    <ul class="list-disc list-inside text-gray-600">
                        <li>Sample Qualification 1</li>
                        <li>Sample Qualification 2</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Event Registration Modal -->
    <div id="eventRegistrationModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden">
        <div class="bg-white p-6 md:p-10 rounded-xl shadow-lg w-full max-w-md mx-2 relative">
            <button onclick="closeEventModal()" class="absolute top-2 right-3 text-gray-400 hover:text-black text-2xl font-bold">&times;</button>
            <h2 class="text-2xl font-bold mb-4 text-primary text-center">Event Registration</h2>
            <form class="space-y-4">
                <div>
                    <label for="full_name" class="block text-sm font-medium mb-1">Full Name</label>
                    <input type="text" id="full_name" name="full_name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" required>
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" required>
                </div>
                <div>
                    <label for="phone_number" class="block text-sm font-medium mb-1">Phone Number</label>
                    <input type="tel" id="phone_number" name="phone_number" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" required>
                </div>
                <button type="submit" class="w-full bg-primary text-white py-2 rounded-lg hover:bg-blue-400 transition">
                    Register Now
                </button>
            </form>
        </div>
    </div>

    <!-- Scholarship Application Modal -->
    <div id="scholarshipApplicationModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden" onclick="backgroundCloseDonationModal(event)">
        <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-lg relative" onclick="event.stopPropagation()">
            <button onclick="closeScholarshipModal()" class="absolute top-2 right-3 text-gray-400 hover:text-black text-xl font-bold">&times;</button>
            <h2 class="text-2xl font-bold mb-4 text-primary text-center">Scholarship Application</h2>

            <?php if($errors->scholarship->any()): ?>
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg border border-red-300">
                    <p class="font-semibold">Please fix the following errors:</p>
                    <ul class="list-disc list-inside mt-2">
                        <?php $__currentLoopData = $errors->scholarship->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="/scholarship/apply" method="POST" enctype="multipart/form-data" class="space-y-4">
                <?php echo csrf_field(); ?>
                <div>
                    <label for="welcome_full_name" class="block text-sm font-medium mb-1">Full Name</label>
                    <input type="text" id="welcome_full_name" name="full_name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" value="<?php echo e(old('full_name')); ?>" required>
                </div>
                <div>
                    <label for="welcome_email" class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" id="welcome_email" name="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" value="<?php echo e(old('email')); ?>" required>
                </div>
                <div>
                    <label for="welcome_phone_number" class="block text-sm font-medium mb-1">Phone Number</label>
                    <input type="tel" id="welcome_phone_number" name="phone_number" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" value="<?php echo e(old('phone_number')); ?>">
                </div>
                <div>
                    <label for="welcome_scholarship_type" class="block text-sm font-medium text-gray-700">Scholarship Type</label>
                    <select name="scholarship_type" id="welcome_scholarship_type" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                        <option value="" disabled <?php echo e(old('scholarship_type') ? '' : 'selected'); ?>>Select Type</option>
                        <option value="home_based" <?php echo e(old('scholarship_type') == 'home_based' ? 'selected' : ''); ?>>Home Based</option>
                        <option value="in_house" <?php echo e(old('scholarship_type') == 'in_house' ? 'selected' : ''); ?>>In House</option>
                    </select>
                </div>
                <div>
                    <label for="welcome_transcript" class="block text-sm font-medium mb-1">Upload Transcript (PDF, JPG, PNG - Max 5MB)</label>
                    <input type="file" id="welcome_transcript" name="transcript" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20" required accept=".pdf,.jpg,.jpeg,.png">
                </div>
                <button type="submit" class="w-full bg-primary text-white py-2 rounded-lg hover:bg-blue-400 transition">
                    Submit Application
                </button>
            </form>
        </div>
    </div>

          <!-- Login Modal -->
    <div id="loginModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden">
        <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-sm mx-2 relative">
            <button onclick="closeLoginModal()" class="absolute top-2 right-3 text-gray-400 hover:text-black text-xl font-bold">&times;</button>
            <h2 class="text-2xl font-bold mb-4 text-primary text-center">Login</h2>
            <form id="loginForm" class="space-y-4" onsubmit="handleLogin(event)">
                <div>
                    <label for="loginEmail" class="text-sm font-medium">Email</label>
                    <input type="email" id="loginEmail" name="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>
                <div>
                    <label for="loginPassword" class="text-sm font-medium">Password</label>
                    <input type="password" id="loginPassword" name="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>
                <button type="submit" class="w-full bg-primary text-white py-2 rounded-lg hover:bg-blue-400 transition">
                    Login
                </button>
                <div id="loginError" class="text-red-500 text-sm text-center hidden"></div>
            </form>
            <!-- <div class="text-center mt-4">
                <span class="text-gray-600">No account?</span>
                <button class="text-primary font-semibold hover:underline ml-1" onclick="switchToRegister()">Register here</button>
            </div> -->
        </div>
    </div>

    <!-- Donation Modal -->
    <div id="donationModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden" onclick="backgroundCloseDonationModal(event)">
        <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-sm relative" onclick="event.stopPropagation()">
            <button onclick="closeDonationModal()" class="absolute top-2 right-3 text-gray-400 hover:text-black text-xl font-bold">&times;</button>
            <h2 class="text-2xl font-bold mb-4 text-primary text-center">Make a Donation</h2>
            <form id="donationForm" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Amount</label>
                    <input type="number" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Name</label>
                    <input type="text" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" required>
        </div>
        <div>
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" required>
                </div>
                <button type="submit" class="w-full bg-primary text-white py-2 rounded-lg hover:bg-blue-400 transition">
                    Donate Now
                </button>
            </form>
        </div>
    </div>

    <!-- Registration Modal -->
    <div id="registrationModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden">
        <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md mx-2 relative">
            <button onclick="closeRegistrationModal()" class="absolute top-2 right-3 text-gray-400 hover:text-black text-xl font-bold">&times;</button>
            <h2 class="text-2xl font-bold mb-4 text-primary text-center">Create Account</h2>
            <form id="registrationForm" class="space-y-4" onsubmit="handleRegister(event)">
                <div>
                    <label class="block text-sm font-medium mb-1">Full Name</label>
                    <input type="text" name="name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Password</label>
                    <input type="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" required>
                </div>
                <button type="submit" class="w-full bg-primary text-white py-2 rounded-lg hover:bg-blue-400 transition">
                    Register
                </button>
                <div id="registerError" class="text-red-500 text-sm text-center hidden"></div>
            </form>
            <div class="text-center mt-4">
                <span class="text-gray-600">Already have an account?</span>
                <button class="text-primary font-semibold hover:underline ml-1" onclick="switchToLogin()">Login here</button>
            </div>
        </div>
    </div>

    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobileMenuButton');
        const mobileMenu = document.getElementById('mobileMenu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!mobileMenuButton.contains(e.target) && !mobileMenu.contains(e.target)) {
                mobileMenu.classList.add('hidden');
            }
        });

        // Modal Functions
        function openLoginModal() {
            document.getElementById('loginModal').classList.remove('hidden');
        }

        function closeLoginModal() {
            document.getElementById('loginModal').classList.add('hidden');
        }

        function openDonationModal() {
            document.getElementById('donationModal').classList.remove('hidden');
        }

        function closeDonationModal() {
            document.getElementById('donationModal').classList.add('hidden');
        }

        function openScholarshipModal() {
            document.getElementById('scholarshipApplicationModal').classList.remove('hidden');
        }

        function closeScholarshipModal() {
            document.getElementById('scholarshipApplicationModal').classList.add('hidden');
        }

        function openJobDetailsModal() {
            document.getElementById('jobDetailsModal').classList.remove('hidden');
        }

        function closeJobDetailsModal() {
            document.getElementById('jobDetailsModal').classList.add('hidden');
        }

        function openEventModal() {
            document.getElementById('eventRegistrationModal').classList.remove('hidden');
        }

        function closeEventModal() {
            document.getElementById('eventRegistrationModal').classList.add('hidden');
        }

        // Close modals when clicking outside
        document.addEventListener('click', function(event) {
            const loginModal = document.getElementById('loginModal');
            const donationModal = document.getElementById('donationModal');
            const scholarshipModal = document.getElementById('scholarshipApplicationModal');
            const jobDetailsModal = document.getElementById('jobDetailsModal');
            const eventModal = document.getElementById('eventRegistrationModal');

            if (event.target === loginModal) {
                closeLoginModal();
            }
            if (event.target === donationModal) {
                closeDonationModal();
            }
            if (event.target === scholarshipModal) {
                closeScholarshipModal();
            }
            if (event.target === jobDetailsModal) {
                closeJobDetailsModal();
            }
            if (event.target === eventModal) {
                closeEventModal();
            }
        });

        // Close modals when pressing Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeLoginModal();
                closeDonationModal();
                closeScholarshipModal();
                closeJobDetailsModal();
                closeEventModal();
            }
        });

        // Improved Slider functionality
        let currentSlide = 0;
        let slideInterval;
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.dot');
        const slidesContainer = document.getElementById('slides');

        function showSlide(index) {
            // Update slide position
            slidesContainer.style.transform = `translateX(-${index * 100}%)`;
           
            // Update dots
            dots.forEach((dot, i) => {
                dot.classList.toggle('bg-primary', i === index);
                dot.classList.toggle('bg-gray-300', i !== index);
            });
           
            currentSlide = index;
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }

        function prevSlide() {
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(currentSlide);
        }

        function goToSlide(index) {
            showSlide(index);
        }

        // Auto-advance slides every 5 seconds
        function startAutoSlide() {
            slideInterval = setInterval(nextSlide, 5000);
        }

        function stopAutoSlide() {
            clearInterval(slideInterval);
        }

        // Initialize slider
        showSlide(0);
        startAutoSlide();

        // Pause auto-slide when hovering over slides
        slidesContainer.addEventListener('mouseenter', stopAutoSlide);
        slidesContainer.addEventListener('mouseleave', startAutoSlide);

        // Touch support for mobile devices
        let touchStartX = 0;
        let touchEndX = 0;

        slidesContainer.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        });

        slidesContainer.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        });

        function handleSwipe() {
            const swipeThreshold = 50;
            if (touchEndX < touchStartX - swipeThreshold) {
                nextSlide();
            } else if (touchEndX > touchStartX + swipeThreshold) {
                prevSlide();
            }
        }

        // Scholarship Form Submission
        function handleScholarshipSubmit(event) {
            event.preventDefault();
            alert('Thank you for your interest! Scholarship applications will be available soon.');
            closeScholarshipModal();
        }

        // Tracking Form Submission
        function handleTrackingSubmit(event) {
            event.preventDefault();
            const trackingCode = document.querySelector('input[name="tracking_code"]').value;
            
            // Show a demo tracking result
            const trackingResult = document.getElementById('trackingResult');
            const statusMessage = document.getElementById('statusMessage');
            
            trackingResult.classList.remove('hidden');
            statusMessage.textContent = 'Demo Status: Application is under review';
            trackingResult.className = 'mt-4 p-4 rounded-lg bg-yellow-50 text-yellow-700';
        }

        // Registration Modal Functions
        function openRegistrationModal() {
            document.getElementById('registrationModal').classList.remove('hidden');
        }

        function closeRegistrationModal() {
            document.getElementById('registrationModal').classList.add('hidden');
        }

        function switchToLogin() {
            closeRegistrationModal();
            openLoginModal();
        }

        // Add registration modal to the click-outside handler
        document.addEventListener('click', function(event) {
            const registrationModal = document.getElementById('registrationModal');
            if (event.target === registrationModal) {
                closeRegistrationModal();
            }
        });

        // Add registration modal to the escape key handler
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeRegistrationModal();
            }
        });

        // Registration form submission
        document.getElementById('registrationForm').addEventListener('submit', function(e) {
            e.preventDefault();
           
            const formData = new FormData(this);
           
            fetch('/register', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Registration successful! Please check your email to verify your account.');
                    closeRegistrationModal();
                    openLoginModal();
                } else {
                    alert(data.message || 'Registration failed. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });

        // Update the "No account?" link in login modal to open registration
        document.querySelector('#loginModal .text-primary').addEventListener('click', function(e) {
            e.preventDefault();
            closeLoginModal();
            openRegistrationModal();
        });

        // Impact Slider functionality
        let currentImpactSlide = 0;
        const impactSlides = document.getElementById('impactSlides');
        const totalImpactSlides = 3;

        function showImpactSlide(index) {
            impactSlides.style.transform = `translateX(-${index * 100}%)`;
            impactSlides.style.transition = 'transform 0.7s cubic-bezier(0.4, 0, 0.2, 1)';
            currentImpactSlide = index;
        }

        function nextImpactSlide() {
            currentImpactSlide = (currentImpactSlide + 1) % totalImpactSlides;
            showImpactSlide(currentImpactSlide);
        }

        function prevImpactSlide() {
            currentImpactSlide = (currentImpactSlide - 1 + totalImpactSlides) % totalImpactSlides;
            showImpactSlide(currentImpactSlide);
        }

        function goToImpactSlide(index) {
            showImpactSlide(index);
        }

        // Auto-advance impact slides
        setInterval(nextImpactSlide, 5000);

        // Hero Slider functionality
        let currentHeroSlide = 0;
        const heroSlides = document.getElementById('heroSlides');
        const totalHeroSlides = 3;

        function showHeroSlide(index) {
            heroSlides.style.transform = `translateX(-${index * 100}%)`;
            heroSlides.style.transition = 'transform 0.7s cubic-bezier(0.4, 0, 0.2, 1)';
            currentHeroSlide = index;
        }

        function nextHeroSlide() {
            currentHeroSlide = (currentHeroSlide + 1) % totalHeroSlides;
            showHeroSlide(currentHeroSlide);
        }

        // Auto-advance hero slides every 5 seconds
        setInterval(nextHeroSlide, 5000);

        // Add scroll animation observer
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, {
            threshold: 0.1
        });

        document.querySelectorAll('.animate-on-scroll').forEach((el) => observer.observe(el));

        // Enhanced slider animations
        function showSlide(index) {
            slidesContainer.style.transform = `translateX(-${index * 100}%)`;
            slidesContainer.style.transition = 'transform 0.7s cubic-bezier(0.4, 0, 0.2, 1)';
           
            dots.forEach((dot, i) => {
                dot.classList.toggle('bg-primary', i === index);
                dot.classList.toggle('bg-gray-300', i !== index);
            });
           
            currentSlide = index;
        }

        // Enhanced impact slider animations
        function showImpactSlide(index) {
            impactSlides.style.transform = `translateX(-${index * 100}%)`;
            impactSlides.style.transition = 'transform 0.7s cubic-bezier(0.4, 0, 0.2, 1)';
            currentImpactSlide = index;
        }

        // Enhanced hero slider animations
        function showHeroSlide(index) {
            heroSlides.style.transform = `translateX(-${index * 100}%)`;
            heroSlides.style.transition = 'transform 0.7s cubic-bezier(0.4, 0, 0.2, 1)';
            currentHeroSlide = index;
        }

        async function handleLogin(event) {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(form);
            const loginError = document.getElementById('loginError');
            loginError.classList.add('hidden');

            try {
                const response = await fetch('/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({
                        email: formData.get('email'),
                        password: formData.get('password'),
                        _token: document.querySelector('meta[name="csrf-token"]').content
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    // Redirect to dashboard on successful login
                    window.location.href = '/dashboard';
                } else {
                    // Show error message
                    loginError.textContent = data.message || 'Invalid credentials';
                    loginError.classList.remove('hidden');
                }
            } catch (error) {
                console.error('Login error:', error);
                loginError.textContent = 'An error occurred. Please try again.';
                loginError.classList.remove('hidden');
            }
        }

        async function handleRegister(event) {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(form);

            try {
                const response = await fetch('/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(Object.fromEntries(formData))
                });

                if (response.ok) {
                    window.location.href = '/dashboard';
                } else {
                    const data = await response.json();
                    const errorDiv = document.getElementById('registerError');
                    errorDiv.textContent = data.message || 'Registration failed';
                    errorDiv.classList.remove('hidden');
                }
            } catch (error) {
                console.error('Registration error:', error);
            }
        }
    </script>
</body>
</html><?php /**PATH C:\collab\resources\views/welcome.blade.php ENDPATH**/ ?>