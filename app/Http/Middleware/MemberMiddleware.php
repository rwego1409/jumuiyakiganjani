<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MemberMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        \Log::debug('MemberMiddleware check', [
            'user_id' => auth()->id(),
            'role' => optional(auth()->user())->role,
            'is_member' => optional(auth()->user())->isMember() ?? null
        ]);
        if (!auth()->check() || !auth()->user()->isMember()) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}