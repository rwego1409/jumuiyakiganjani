{{-- resources/views/member/contributions/create.blade.php --}}
@extends('layouts.member')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold">Create Contribution</h2>
        <form action="{{ route('member.contributions.store') }}" method="POST" class="mt-6">
            @csrf
            <div class="mb-4">
                <label for="amount" class="block">Amount</label>
                <input type="number" name="amount" id="amount" class="mt-1 block w-full" required>
            </div>
            <div class="mb-4">
                <label for="jumuiya_id" class="block">Select Jumuiya</label>
                <select name="jumuiya_id" id="jumuiya_id" class="mt-1 block w-full" required>
                    @foreach($jumuiyas as $jumuiya)
                        <option value="{{ $jumuiya->id }}">{{ $jumuiya->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="contribution_date" class="block">Date of Contribution</label>
                <input type="date" name="contribution_date" id="contribution_date" class="mt-1 block w-full" required>
            </div>
            <button type="submit" class="btn-primary">Create Contribution</button>
        </form>
    </div>
</div>
@endsection
