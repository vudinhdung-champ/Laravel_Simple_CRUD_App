<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreSubscriptionRequest;
use App\Http\Resources\SubscriptionResource;
use App\Services\SubscriptionService;


class SubscriptionController extends Controller
{
    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService){
        $this->subscriptionService = $subscriptionService;

    }

    public function index(Request $request) {
        try {
            $subscriptions = $this->subscriptionService->getAllSubscriptions($request->user()->id);

            return response()->json([
                'status' => 'success',
                'data' => SubscriptionResource::collection($subscriptions)->resolve(),

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

            $subscriptions = $this->subscriptionService->createSubscription($request->all(), $request->user()->id);

            return response()->json([
                'status' => 'success',
                'message' => 'Tạo thành công',
                'data' => (new SubscriptionResource($subscriptions))->resolve(),
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
            $subscriptions = $this->subscriptionService->update($id, $request->all(), $request->user()->id);
            
            $subscriptions->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Update thành công',
                'data' => (new SubscriptionResource($subscriptions))->resolve(),

            ], 200);


        } catch(\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()

            ], 500);
        }

    }

    public function Destroy($id, Request $request) {
        try {

        $this->subscriptionService->deleteSubscription($id, $request->user()->id);

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
