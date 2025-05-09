<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\KaspiPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class KaspiPaymentController extends Controller
{
    private $kaspiService;

    public function __construct(KaspiPaymentService $kaspiService)
    {
        $this->kaspiService = $kaspiService;
    }

    public function initiatePayment(Request $request)
    {
        Log::info('Payment initiation started', ['request' => $request->all()]);

        $request->validate([
            'amount' => 'required|numeric|min:100',
        ]);

        try {
            DB::beginTransaction();

            $payment = Payment::create([
                'user_id' => auth()->id(),
                'amount' => $request->amount,
                'status' => 'pending',
                'payment_method' => 'kaspi',
                'description' => 'Тестовая оплата обучения',
                'date' => now(),
            ]);

            $paymentData = [
                'amount' => $request->amount,
                'orderId' => $payment->id,
                'description' => 'Тестовая оплата обучения',
                'returnUrl' => route('payment.callback')
            ];

            $response = $this->kaspiService->createPayment($paymentData);

            if ($response['success']) {
                DB::commit();
                return response()->json([
                    'success' => true,
                    'payment_url' => $response['data']['paymentUrl'],
                    'message' => 'Тестовый платёж создан'
                ]);
            }

            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $response['message'] ?? 'Ошибка создания тестового платежа'
            ], 422);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Ошибка при обработке платежа: ' . $e->getMessage()
            ], 500);
        }
    }

    public function callback(Request $request)
    {
        Log::info('Payment callback received', ['data' => $request->all()]);

        try {
            $payment = Payment::find($request->orderId);

            if (!$payment) {
                throw new \Exception('Платёж не найден');
            }

            // В тестовом режиме всегда отмечаем как успешный
            $payment->update([
                'status' => 'completed',
                'external_id' => 'TEST_' . uniqid()
            ]);

            return redirect()->route('student.personal')
                ->with('success', 'Тестовый платёж успешно выполнен!')->with('successType', 'payment_success');

        } catch (\Exception $e) {
            Log::error('Callback error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('student.personal')
                ->with('error', 'Ошибка при обработке платежа: ' . $e->getMessage());
        }
    }
}
