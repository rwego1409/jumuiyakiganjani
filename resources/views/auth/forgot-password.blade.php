<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 bg-jumuiya-pattern py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-sm">
            <div class="text-center">
                <svg class="mx-auto h-12 w-12 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                <h2 class="mt-6 text-center text-2xl font-extrabold text-gray-900">
                    Reset Your Password
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Enter your email to receive a password reset link
                </p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <div class="mb-4 text-sm text-gray-600 text-center">
                Forgot your password? No problem. Just let us know your email address and we'll email you a password reset link.
            </div>

            <form class="mt-4 space-y-6" method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="rounded-md shadow-sm space-y-4">
                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                        <input id="email" name="email" type="email" required autofocus
                            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500 focus:z-10 sm:text-sm"
                            placeholder="email@example.com" value="{{ old('email') }}">
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="text-sm">
                        <a href="{{ route('login') }}" class="font-medium text-primary-600 hover:text-primary-500">
                            Remember your password? Sign in
                        </a>
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Email Password Reset Link
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>