<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Services\MerchantService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Order;

class MerchantController extends Controller
{
    public function __construct(
        MerchantService $merchantService
    ) {}

    /**
     * Useful order statistics for the merchant API.
     * 
     * @param Request $request Will include a from and to date
     * @return JsonResponse Should be in the form {count: total number of orders in range, commission_owed: amount of unpaid commissions for orders with an affiliate, revenue: sum order subtotals}
     */
    public function orderStats(Request $request): JsonResponse
    {
        // TODO: Complete this method

        $from = $request->input('from');
        $to = $request->input('to');

        // Get the authenticated user
        $user = auth()->user();

        $merchant = $user->merchant;

        $orders = Order::where('merchant_id', $merchant->id)
                ->whereBetween('created_at', [$from, $to])
                ->get();

        $count = $orders->count();
        $revenue = $orders->sum('subtotal');
        $commissionsOwed = $orders->filter(function ($order) {
            return $order->affiliate_id !== null;
        })->sum('commission_owed');

        $response = [
            'count' => $count,
            'revenue' => $revenue,
            'commissions_owed' => $commissionsOwed,
        ];

        return response()->json($response);
    }
}
