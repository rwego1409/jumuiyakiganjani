<?php
namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $role = $user->role;
        $member = $user->member;
        $jumuiyaId = $member ? $member->jumuiya_id : null;

        // Admin notifications sent to all
        $adminNotifications = \App\Models\AdminNotification::whereJsonContains('recipients', 'all')
            ->orderByDesc('created_at')
            ->get();

        // Jumuiya notifications for this member's jumuiya
        $jumuiyaNotifications = $jumuiyaId
            ? \App\Models\JumuiyaNotification::where('jumuiya_id', $jumuiyaId)
                ->orderByDesc('created_at')
                ->get()
            : collect();

        // Merge all and sort by date
        $allNotifications = $adminNotifications
            ->concat($jumuiyaNotifications)
            ->sortByDesc(function($n) {
                return $n->created_at;
            })->values();

        // Paginate manually (since it's a collection)
        $perPage = 10;
        $page = request()->get('page', 1);
        $paginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $allNotifications->forPage($page, $perPage),
            $allNotifications->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('notifications.index', [
            'notifications' => $paginated,
            'role' => $role
        ]);
    }

    public function show($id)
    {
        // Only allow showing admin or jumuiya notification by id
        $adminNotification = \App\Models\AdminNotification::find($id);
        if ($adminNotification) {
            return view('notifications.show', ['notification' => $adminNotification]);
        }
        $member = auth()->user()->member;
        $jumuiyaId = $member ? $member->jumuiya_id : null;
        $jumuiyaNotification = $jumuiyaId ? \App\Models\JumuiyaNotification::where('jumuiya_id', $jumuiyaId)->find($id) : null;
        if ($jumuiyaNotification) {
            return view('notifications.show', ['notification' => $jumuiyaNotification]);
        }
        abort(404);
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        
        return back()->with('success', 'All notifications marked as read');
    }   
}