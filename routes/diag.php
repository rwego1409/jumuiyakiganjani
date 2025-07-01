Route::get('/diag', function() {
    return response()->json([
        'asset_url' => asset('css/app.css'),
        'config_app_url' => config('app.url'),
        'request_host' => request()->getHost()
    ]);
});
