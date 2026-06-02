<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreSubscriptionRequest;
use App\Http\Resources\SubscriptionResource;
use App\Services\SubscriptionService;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AllDataExport;
use App\Mail\AllDataExportMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;


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
            info('>>>check subscrip:  ' . json_encode($subscriptions));
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

    public function exportAllAndEmail(Request $request)
    {
        try {
            $user   = $request->user();
            $userId = $user->id;

            // 1. Đặt tên file theo user + timestamp
            $fileName = 'du_lieu_' . $userId . '_' . now()->format('Ymd_His') . '.xlsx';
            $relativePath = 'exports/' . $fileName;

            // 2. Tạo thư mục exports nếu chưa có
            Storage::disk('local')->makeDirectory('exports');

            // 3. Tạo file Excel gồm 3 sheet
            Excel::store(new AllDataExport($userId), $relativePath);

            // 4. Gửi mail kèm file
            Mail::to($user->email)->send(
                new AllDataExportMail($relativePath, $user->username)
            );

            // 5. Xóa file tạm sau khi gửi xong
            Storage::delete($relativePath);

            return response()->json([
                'status'  => 'success',
                'message' => 'Dữ liệu đã được xuất và gửi tới: ' . $user->email,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage(),
            ], 500);
        }
    }
}
