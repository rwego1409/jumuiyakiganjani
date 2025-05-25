<?php

namespace App\Http\Controllers;

use App\Services\PalmPesaService;
use Illuminate\Http\Request;

class PalmPesaDebugController extends Controller
{
    public function testStkPush(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string',
            'amount' => 'required|numeric|min:10'
        ]);

        $service = new PalmPesaService();
        $response = $service->processPayment(
            $validated['phone'],
            $validated['amount'],
            'DEBUG-' . time()
        );

        return response()->json([
            'diagnostic' => [
                'input' => $validated,
                'environment' => config('app.env'),
                'timestamp' => now()->toDateTimeString(),
                'log_check' => 'Check storage/logs/palmpesa.log'
            ],
            'api_response' => $response,
            'troubleshooting' => $this->getTroubleshootingSteps($validated['phone'])
        ]);
    }

    protected function getTroubleshootingSteps($phone)
    {
        return [
            'if_no_stk_received' => [
                '1. Ensure phone has active internet connection',
                '2. Check PalmPesa app is installed and updated',
                '3. Verify mobile money is activated on ' . substr($phone, 0, 6) . '****',
                '4. Try again after 5 minutes',
                '5. Contact support with reference DEBUG-' . time()
            ],
            'test_numbers' => [
                'valid_format' => ['255612345678', '0755123456'],
                'invalid_format' => ['+255612345678', '612345678']
            ]
        ];
    }
}