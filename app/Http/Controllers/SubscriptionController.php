<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreSubscriptionRequest;
use App\Http\Resources\SubscriptionResource;
use App\Services\SubscriptionService;


class SubscriptionController extends Controller
{
    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;

    }

    public function index(Request $request)
    {
        try {
            $filters = $request->only([
                'search',
                'status',
                'billing_cycle',
                'per_page',
                'page',
            ]);

            // Lấy danh sách phân trang //
            $subscriptions = $this->subscriptionService->getSubscriptionsForUser($request->user()->id, $filters);

            // Tính tổng chi phí status == active //
            $totalCost = $this->subscriptionService->getTotalCost($request->user()->id);


            return SubscriptionResource::collection($subscriptions)->additional([
                'status' => 'success',
                'message' => 'Lọc danh sách thành công!',
                'totalCost' => $totalCost
            ]);


        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);

        }

    }

    public function store(StoreSubscriptionRequest $request)
    {
        try {

            $subscriptions = $this->subscriptionService->createSubscription($request->all(), $request->user()->id);

            return response()->json([
                'status' => 'success',
                'message' => 'Tạo thành công',
                'data' => (new SubscriptionResource($subscriptions))->resolve(),
            ], 200);


        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()

            ], 500);
        }

    }

    public function update(StoreSubscriptionRequest $request, $id)
    {
        try {
            $subscriptions = $this->subscriptionService->updateSubscription($id, $request->all(), $request->user()->id);


            return response()->json([
                'status' => 'success',
                'message' => 'Update thành công',
                'data' => (new SubscriptionResource($subscriptions))->resolve(),

            ], 200);


        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()

            ], 500);
        }

    }

    public function destroy($id, Request $request)
    {
        try {

            $this->subscriptionService->deleteSubscription($id, $request->user()->id);

            return response()->json([
                'status' => 'success',
                'message' => 'Xoá thành công',

            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage(),

            ], 500);
        }
    }
}
