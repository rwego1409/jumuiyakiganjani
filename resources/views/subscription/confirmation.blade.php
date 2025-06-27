@extends('layouts.landing')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-50 to-pink-100 dark:from-gray-900 dark:to-indigo-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white/80 dark:bg-gray-800/80 rounded-2xl shadow-2xl p-8 backdrop-blur-md text-center">
        <div class="mb-6">
            <i class="fas fa-check-circle text-green-500 text-5xl mb-4"></i>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-2">Request Sent!</h2>
            <p class="text-gray-600 dark:text-gray-300 mb-4">Your jumuiya registration request has been submitted successfully.<br>We will review your request and notify you soon.</p>
        </div>
        <div>
            <span class="text-sm text-gray-500 dark:text-gray-400">Redirecting to home...</span>
        </div>
    </div>
</div>
<script>
    setTimeout(function() {
        window.location.href = '/jumuiyakiganjani/public';
    }, 3000);
</script>
@endsection
