<?php if (isset($component)) { $__componentOriginal69dc84650370d1d4dc1b42d016d7226b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b = $attributes; } ?>
<?php $component = App\View\Components\GuestLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\GuestLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 bg-jumuiya-pattern py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-sm">
            <div class="text-center">
                <svg class="mx-auto h-12 w-12 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <h2 class="mt-6 text-center text-2xl font-extrabold text-gray-900">
                    Verify Your Email Address
                </h2>
            </div>

            <div class="mb-4 text-sm text-gray-600 text-center">
                Thanks for signing up! Before getting started, please verify your email address by clicking on the link we sent to you.
            </div>

            <?php if(session('status') == 'verification-link-sent'): ?>
                <div class="mb-4 font-medium text-sm text-green-600 text-center">
                    A new verification link has been sent to your email address.
                </div>
            <?php endif; ?>

            <div class="mt-6 space-y-4">
                <form method="POST" action="<?php echo e(route('verification.send')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Resend Verification Email
                    </button>
                </form>

                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" 
                        class="w-full text-center text-sm font-medium text-primary-600 hover:text-primary-500 focus:outline-none">
                        Log Out
                    </button>
                </form>
            </div>

            <div class="mt-4 text-center text-sm text-gray-600">
                Didn't receive the email? Check your spam folder or 
                <button type="submit" formaction="<?php echo e(route('verification.send')); ?>" 
                    class="font-medium text-primary-600 hover:text-primary-500">
                    click here to resend
                </button>.
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $attributes = $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $component = $__componentOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\jumuiyakiganjani\resources\views/auth/verify-email.blade.php ENDPATH**/ ?>