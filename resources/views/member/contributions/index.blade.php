@extends('layouts.member')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold">Your Contributions</h2>

        <div class="mt-4">
            <a href="{{ route('member.contributions.create') }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                + New Contribution
            </a>
        </div>

        <div class="mt-6 bg-white shadow rounded-lg p-6">
            @if ($contributions->isEmpty())
                <p class="text-gray-600">No contributions yet. Consider contributing!</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-left text-sm font-medium text-gray-700">
                                <th class="px-4 py-2 border-b">Amount</th>
                                <th class="px-4 py-2 border-b">Date</th>
                                <th class="px-4 py-2 border-b">Jumuiya</th>
                                <th class="px-4 py-2 border-b">Status</th>
                                <!-- <th class="px-4 py-2 border-b">Action</th> -->
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($contributions as $contribution)
                                <tr class="text-sm text-gray-700 hover:bg-gray-50">
                                    <td class="px-4 py-2 border-b">{{ number_format($contribution->amount) }} TZS</td>
                                    <td class="px-4 py-2 border-b">{{ \Carbon\Carbon::parse($contribution->contribution_date)->format('d M Y') }}</td>
                                    <td class="px-4 py-2 border-b">{{ $contribution->jumuiya->name }}</td>
                                    <td class="px-4 py-2 border-b">
                                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded 
                                            {{ $contribution->status === 'paid' ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }}">
                                            {{ ucfirst($contribution->status) }}
                                        </span>
                                    </td>
                                    <!-- <td class="px-4 py-2 border-b">
                                        @if($contribution->status !== 'paid')
                                            <form action="{{ route('member.contributions.create', $contribution->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                                                    Pay Now
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-green-600 font-semibold">Paid</span>
                                        @endif
                                    </td> -->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $contributions->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
