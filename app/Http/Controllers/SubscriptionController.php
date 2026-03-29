<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Http\Requests\StoreSubscriptionRequest;
use Illuminate\Support\Facades\Auth;


class SubscriptionController extends Controller
{
    public function index() {
        try {
            $subscriptions = Subscription::where('user_id', Auth::id())
                                         ->orderBy('next_billing_date', 'asc')
                                         ->get();

            return response()->json([
                'status' => 'success',
                'data' => $subscriptions,

            ], 200);

        } catch(\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage() 
            ], 500);

        }

    }

    public function store(StoreSubscriptionRequest $request) {
        try {

            $subscriptions= Subscription::create([
                'user_id' => $request->user()->id,
                'service_name' => $request->service_name,
                'price' => $request->price,
                'billing_cycle' => $request->billing_cycle,
                'next_billing_date' => $request->next_billing_date,
                'status' => $request->status ?? 'active', // Mặc định là active nếu không gửi lên
                'color_code' => $request->color_code,
                'notes' => $request->notes,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Tạo thành công',
                'data' => $subscriptions,
            ], 200);


        } catch(\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()

            ], 500);
        }

    }

    public function Update(StoreSubscriptionRequest $request, $id) {
        try {
            $subscriptions = Subscription::where('user_id', $request->user()->id)
                                          ->findOrFail($id);
            

            $subscriptions->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Update thành công',
                'data' => $subscriptions

            ], 200);


        } catch(\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()

            ], 500);
        }

    }

    public function Destroy($id) {
        try {

        $subscriptions = Subscription::where('user_id', Auth::id())->findOrFail($id);

        $subscriptions->delete();

        return response()->json([
                'status' => 'success',
                'message' => 'Xoá thành công',

        ], 200);

        } catch(\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage(),

            ], 500);

        }

    }
}
