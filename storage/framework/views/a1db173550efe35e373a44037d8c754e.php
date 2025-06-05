<?php if (isset($component)) { $__componentOriginalcb8170ac00b272413fe5b25f86fc5e3a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcb8170ac00b272413fe5b25f86fc5e3a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.guest-layout','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <h2 class="text-center text-2xl font-bold mb-6">Register</h2>

            <form method="POST" action="<?php echo e(route('register')); ?>">
                <?php echo csrf_field(); ?>

                <!-- Name -->
                <div>
                    <label for="name" class="block font-medium text-sm text-gray-700">Name</label>
                    <input id="name" type="text" name="name" value="<?php echo e(old('name')); ?>" required autofocus
                        class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                    <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required
                        class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label for="password" class="block font-medium text-sm text-gray-700">Password</label>
                    <input id="password" type="password" name="password" required
                        class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <label for="password_confirmation" class="block font-medium text-sm text-gray-700">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>

                <!-- Role Selection -->
                <div class="mt-4">
                    <label for="role" class="block font-medium text-sm text-gray-700">Role</label>
                    <select id="role" name="role" required
                        class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="student">Student</option>
                        <option value="volunteer">Volunteer</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a href="<?php echo e(route('login')); ?>" class="underline text-sm text-gray-600 hover:text-gray-900">
                        Already registered?
                    </a>

                    <button type="submit"
                        class="ml-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcb8170ac00b272413fe5b25f86fc5e3a)): ?>
<?php $attributes = $__attributesOriginalcb8170ac00b272413fe5b25f86fc5e3a; ?>
<?php unset($__attributesOriginalcb8170ac00b272413fe5b25f86fc5e3a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcb8170ac00b272413fe5b25f86fc5e3a)): ?>
<?php $component = $__componentOriginalcb8170ac00b272413fe5b25f86fc5e3a; ?>
<?php unset($__componentOriginalcb8170ac00b272413fe5b25f86fc5e3a); ?>
<?php endif; ?><?php /**PATH C:\Users\PNPh\Desktop\sheila\collab - Copy\resources\views\auth\register.blade.php ENDPATH**/ ?>