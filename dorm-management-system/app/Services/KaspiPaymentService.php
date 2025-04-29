<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class KaspiPaymentService
{
    public function createPayment(array $data)
    {
        try {
            Log::info('Test payment service called', [
                'amount' => $data['amount'],
                'orderId' => $data['orderId']
            ]);

            // Эмулируем успешный ответ
            return [
                'success' => true,
                'data' => [
                    'paymentId' => 'TEST_' . uniqid(),
                    'paymentUrl' => route('payment.callback', [
                        'orderId' => $data['orderId'],
                        'status' => 'success'
                    ])
                ]
            ];

        } catch (\Exception $e) {
            Log::error('Test payment service error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Ошибка тестового платежа: ' . $e->getMessage()
            ];
        }
    }
}
