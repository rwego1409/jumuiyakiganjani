<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyClickPesaSignature
{
    public function handle(Request $request, Closure $next)
    {
        $signature = $request->header('X-ClickPesa-Signature');
        $secret = config('services.clickpesa.secret');
        $payload = $request->getContent();
        $expected = base64_encode(hash_hmac('sha256', $payload, $secret, true));
        if (!$signature || !hash_equals($expected, $signature)) {
            abort(403, 'Invalid ClickPesa signature.');
        }
        return $next($request);
    }
}
