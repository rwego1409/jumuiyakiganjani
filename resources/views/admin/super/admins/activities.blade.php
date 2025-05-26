@extends('layouts.dashboard')

@section('title', 'Admin Activities - ' . $admin->name)

@section('content')
<div class="container px-6 mx-auto grid">
    <div class="flex justify-between items-center">
        <h2 class="my-6 text-2xl font-semibold text-gray-700">
            Activities for {{ $admin->name }}
        </h2>
        <a href="{{ route('super_admin.admins.index') }}"
           class="px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
            Back to Admins List
        </a>
    </div>

    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                        <th class="px-4 py-3">Activity</th>
                        <th class="px-4 py-3">Details</th>
                        <th class="px-4 py-3">Performed By</th>
                        <th class="px-4 py-3">Date & Time</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y">
                    @forelse($activities as $activity)
                    <tr class="text-gray-700">
                        <td class="px-4 py-3 text-sm">
                            @switch($activity->description)
                                @case('created_admin')
                                    <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full">
                                        Created
                                    </span>
                                    @break
                                @case('updated_admin')
                                    <span class="px-2 py-1 font-semibold leading-tight text-orange-700 bg-orange-100 rounded-full">
                                        Updated
                                    </span>
                                    @break
                                @case('deleted_admin')
                                    <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full">
                                        Deleted
                                    </span>
                                    @break
                                @default
                                    {{ ucfirst($activity->description) }}
                            @endswitch
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <div class="text-sm">
                                @if($activity->properties->has('admin_name'))
                                    <p>Name: {{ $activity->properties->get('admin_name') }}</p>
                                @endif
                                @if($activity->properties->has('admin_email'))
                                    <p>Email: {{ $activity->properties->get('admin_email') }}</p>
                                @endif
                                @if($activity->properties->has('status'))
                                    <p>Status: {{ ucfirst($activity->properties->get('status')) }}</p>
                                @endif
                                @if($activity->properties->has('password_changed') && $activity->properties->get('password_changed'))
                                    <p>Password was changed</p>
                                @endif
                                @if($activity->properties->has('managed_jumuiyas'))
                                    <p>Assigned Jumuiyas: {{ implode(', ', $activity->properties->get('managed_jumuiyas')) }}</p>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{ $activity->causer ? $activity->causer->name : 'System' }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{ $activity->created_at->format('M d, Y H:i:s') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-3 text-sm text-center text-gray-500">
                            No activities found for this administrator.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t">
            {{ $activities->links() }}
        </div>
    </div>
</div>
@endsection
