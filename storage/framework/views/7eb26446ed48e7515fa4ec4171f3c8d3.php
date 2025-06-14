<?php
 // Start session in case we need to track user type (optional)
 session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1.0" />
 <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
 <title>Make a Difference Today</title>
 <script src="https://cdn.tailwindcss.com"></script>
 <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
 <style>
     body {
         font-family: 'Poppins', sans-serif;
         /* background-color:rgb(175, 177, 182); /* Tailwind gray-100 for a soft background */
     }
     .custom-button {
        background-color: #0A90A4;
        color: white;
        padding: 0.5rem 1.5rem;
        border-radius: 0.5rem;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }
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
        #desktop-login-button {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            background-color: #0A90A4;
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

                <!-- Container for Desktop Navigation and Login Button -->
                <div class="hidden md:flex items-center space-x-8">
                    <!-- Desktop Navigation -->
                    <nav class="flex items-center space-x-8">
                        <a href="/" class="flex items-center space-x-2 text-gray-700 hover:text-primary transition">
                            <i class="fas fa-home"></i>
                            <span>Home</span>
                        </a>
                        <a href="/#scholarships" class="flex items-center space-x-2 text-gray-700 hover:text-primary transition">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Scholarships</span>
                        </a>
                        <a href="/#job-offers" class="flex items-center space-x-2 text-gray-700 hover:text-primary transition">
                            <i class="fas fa-briefcase"></i>
                            <span>Job Offers</span>
                        </a>
                        <a href="/events" class="flex items-center space-x-2 text-gray-700 hover:text-primary transition">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Events</span>
                        </a>
                        <a href="#about-us" class="flex items-center space-x-2 text-gray-700 hover:text-primary transition">
                            <i class="fas fa-info-circle"></i>
                            <span>About Us</span>
                        </a>
                    </nav>

                    <!-- Login Button -->
                    <a href="/login" id="desktop-login-button" class="flex items-center space-x-2 text-white px-4 py-2 rounded-lg transition">
                        <i class="fas fa-lock"></i>
                        <span>Login</span>
                    </a>
                </div>

                <!-- Mobile Navigation -->
                <nav id="mobileMenu" class="md:hidden hidden py-4 space-y-4">
                    <a href="/" class="flex items-center space-x-2 text-gray-700 hover:text-primary transition">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
                    </a>
                    <a href="/#scholarships" class="flex items-center space-x-2 text-gray-700 hover:text-primary transition">
                        <i class="fas fa-graduation-cap"></i>
                        <span>Scholarships</span>
                    </a>
                    <a href="/#job-offers" class="flex items-center space-x-2 text-gray-700 hover:text-primary transition">
                        <i class="fas fa-briefcase"></i>
                        <span>Job Offers</span>
                    </a>
                    <a href="/events" class="flex items-center space-x-2 text-gray-700 hover:text-primary transition">
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
                    <a href="/login" class="flex items-center space-x-2 bg-secondary text-white px-4 py-2 rounded-lg hover:bg-yellow-500 transition">
                        <i class="fas fa-graduation-cap"></i>
                        <span>Scholarship Login</span>
                    </a>
                </nav>
            </div>
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

            <!-- Header Section -->
            <div class="relative z-10 max-w-7xl mx-auto text-center mb-12 pt-12">
                 <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Make a Difference Today</h1>
                 <p class="text-white">Your generosity can transform lives. Choose how you want to contribute to our cause.</p>
            </div>

            <!-- Donation Cards -->
            <div class="relative z-10 max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-12">
                 <!-- Monetary Donation Card -->
                 <div class="bg-white rounded-2xl shadow-lg p-12 transform transition hover:scale-105 border-t-4 border-[#0A90A4]">
                     <div class="mb-4 flex items-center justify-center">
                         <svg class="w-12 h-12" fill="none" stroke="#0A90A4" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0-2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                         </svg>
                     </div>
                     <h2 class="text-xl font-semibold text-gray-800 mb-2">Monetary Donation</h2>
                     <p class="text-black mb-6">Support our cause with financial contributions</p>
                     <a href="<?php echo e(route('monetary_donation')); ?>" class="block w-full bg-[#0A90A4] text-white text-center py-4 rounded-lg hover:bg-[#0A90A4] transition-colors font-medium">
                         Donate Now
                     </a>
                 </div>

                 <!-- Non-Monetary Donation Card -->
                 <div class="bg-white rounded-2xl shadow-lg p-12 transform transition hover:scale-105 border-t-4 border-[#0A90A4]">
                     <div class="mb-4 flex items-center justify-center">
                         <svg class="w-12 h-12" fill="none" stroke="#0A90A4" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                         </svg>
                     </div>
                     <h2 class="text-xl font-semibold text-gray-800 mb-2">Non-Monetary Donation</h2>
                     <p class="text-black mb-6">Donate goods, supplies, or materials</p>
                     <a href="<?php echo e(route('non_monetary')); ?>" class="block w-full bg-[#0A90A4] text-white text-center py-4 rounded-lg hover:bg-[#0A90A4] transition-colors font-medium">
                         Donate Now
                     </a>
                 </div>

                 <!-- Campaigns Card -->
                 <div class="bg-white rounded-2xl shadow-lg p-12 transform transition hover:scale-105 border-t-4 border-[#0A90A4]">
                     <div class="mb-4 flex items-center justify-center">
                         <svg class="w-12 h-12" fill="none" stroke="#0A90A4" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                         </svg>
                     </div>
                     <h2 class="text-xl font-semibold text-black mb-2">Campaigns</h2>
                     <p class="text-black mb-6">Join our specific donation campaigns</p>
                     <a href="<?php echo e(route('user.calendar')); ?>" class="block w-full bg-[#0A90A4] text-white text-center py-4 rounded-lg hover:bg-[#0A90A4] transition-colors font-medium">
                         Join Campaign
                     </a>
                 </div>
             </div>
        </div>


 <!-- Updated Urgent Donation Needs container -->
<div class="max-w-6xl mx-auto bg-white rounded-2xl shadow-lg p-12 mb-20 mt-80 border-t-4 border-primary">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Urgent Donation Needs</h2>
    <?php
        $donationGoal = 50000.00;
        $currentDonation = DB::table('donations')
            ->where('type', 'monetary')
            ->where('status', 'completed')
            ->sum('amount');
        $progressPercentage = ($currentDonation / $donationGoal) * 100;
    ?>
    <div class="mb-8">
        <div class="flex justify-between text-sm text-black mb-2">
            <span class="font-semibold">Help Those Affected by Typhoon X</span>
            <span><?php echo number_format($progressPercentage, 2); ?>% of the goal achieved (Goal: ₱<?php echo number_format($donationGoal, 2); ?>)</span>
        </div>
        <div class="h-4 bg-blue-200 rounded-full overflow-hidden">
            <div class="h-full bg-cyan-400 rounded-full" style="width: <?php echo $progressPercentage; ?>%; background-color: #37b1c4;"></div>
        </div>
        <p class="text-sm text-black mt-2">Urgent support needed for food, shelter, and medical supplies.</p>
        <a href="<?php echo e(route('monetary_donation')); ?>" class="inline-block bg-[#0A90A4] text-white px-6 py-2 rounded-lg mt-4 font-medium">
            Donate Now
        </a>
    </div>
</div>

 <!-- Top Donors --> 
 <div class="max-w-6xl mx-auto mb-40 mt-12">
     <h2 class="text-2xl font-semibold text-gray-800 mb-8 text-center">Our Top Donors</h2>
     <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
         <?php $__currentLoopData = $topDonors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $donor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
             <div class="bg-[#B7E4FA] rounded-2xl shadow-lg p-8 flex items-center space-x-6">
                 <div class="w-16 h-16 bg-[#B7E4FA] rounded-full flex items-center justify-center">
                     <span class="text-black font-semibold text-lg">
                         <?php echo e(strtoupper(substr($donor->donor_name, 0, 1))); ?><?php echo e(isset(explode(' ', $donor->donor_name)[1]) ? strtoupper(substr(explode(' ', $donor->donor_name)[1], 0, 1)) : ''); ?>

                     </span>
                 </div>
                 <span class="text-gray-800 font-medium text-lg"><?php echo e($donor->donor_name); ?></span>
             </div>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         
         <?php for($i = $topDonors->count(); $i < 3; $i++): ?>
             <div class="bg-[#B7E4FA] rounded-2xl shadow-lg p-8 flex items-center space-x-6">
                 <div class="w-16 h-16 bg-[#B7E4FA] rounded-full flex items-center justify-center">
                     <svg class="w-8 h-8 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                     </svg>
                 </div>
                 <span class="text-gray-800 font-medium text-lg">Anonymous Donor</span>
             </div>
         <?php endfor; ?>
         
         <?php if($topDonors->isEmpty()): ?>
             <div class="col-span-3 text-center text-gray-500">No acknowledged donors yet.</div>
         <?php endif; ?>
     </div>
 </div>
  

      <!-- Footer -->
<footer class="bg-[#e6f4ea] text-gray-800 py-10 px-6 mt-12 animate-fade-in">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- About Section -->
        <div id="about-us">
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
</body><?php /**PATH C:\collab\resources\views/donation/donation.blade.php ENDPATH**/ ?>