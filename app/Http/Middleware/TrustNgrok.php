<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\URL;

class TrustNgrok
{
    public function handle($request, Closure $next)
    {
        if (str_contains($request->getHttpHost(), 'ngrok')) {
            config(['app.url' => 'https://' . $request->getHttpHost()]);
            URL::forceRootUrl(config('app.url'));
        }
        return $next($request);
    }
}
