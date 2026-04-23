<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StorePromiseRequest;
use App\Http\Resources\PromiseResource;
use App\Services\PromiseService;



class PromiseController extends Controller
{
    protected $promiseService;
    public function __construct(PromiseService $promiseService){
        $this->promiseService = $promiseService;

    }

    public function index(Request $request) {
        try {

    
            $filters = $request->only([
                'promiser_name',
                'importance_level',
                'status',
                'page',
                'per_page'

            ]);

            $promises = $this->promiseService->getPromisesForUser($request->user()->id, $filters);
            
            return PromiseResource::collection($promises)->additional([
                'status' => 'success',
                'message' => 'Lọc danh sách thành công!'

            ]);
        
        } catch(\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()

            ], 500);
        }

    }

    public function Store(StorePromiseRequest $request) {
        try {

            $newPromises = $this->promiseService->createPromise($request->all(), $request->user()->id);

            return response()->json([
                'status' => 'success',
                'message' => 'Tạo thành công',
                'data' => (new PromiseResource($newPromises))->resolve(),
            ], 200);


        } catch(\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()

            ], 500);
        }
    }

    public function Update(StorePromiseRequest $request, $id) {
        try {
            $promises = $this->promiseService->updatePromise($id, $request->all(), $request->user()->id);

            return response()->json([
                'status' => 'success',
                'message' => 'Update thành công',
                'data' => (new PromiseResource($promises))->resolve(),
            ], 200);


        } catch(\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);

        }

    }

    public function Delete($id, Request $request) {
        try {
            $this->promiseService->deletePromise($request->user()->id, $id);

            return response()->json([
                'status' => 'success',
                'message' => 'Xoá thành công'

            ], 200);

        } catch(\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }

    }

}
