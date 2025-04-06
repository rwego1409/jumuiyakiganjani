{{-- resources/views/member/contributions/index.blade.php --}}
@extends('layouts.member')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold">Your Contributions</h2>
        <div class="mt-4">
            @if ($contributions->isEmpty())
                <p>No contributions yet. Consider contributing!</p>
            @else
                <ul>
                    @foreach ($contributions as $contribution)
                        <li class="bg-white shadow-sm p-4 mb-4 rounded">
                            <p><strong>Amount:</strong> {{ $contribution->amount }}</p>
                            <p><strong>Date:</strong> {{ $contribution->contribution_date->format('d M, Y') }}</p>
                            <p><strong>Jumuiya:</strong> {{ $contribution->jumuiya->name }}</p>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection
