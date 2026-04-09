<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promise;
use App\Http\Requests\StorePromiseRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resource\PromiseResource;



class PromiseController extends Controller
{
    public function index() {
        try {
            $promises = Promise::where('user_id', Auth::id())
                                ->orderBy('deadline', 'asc')
                                ->get();
            
            return response()->json([
                'status' => 'success',
                'message' => 'Xem danh sách thành công',
                'data' => PromiseResource::collection($promises)->resolve(),

            ], 200);

        } catch(\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()

            ], 500);
        }

    }

    public function Store(StorePromiseRequest $request) {
        try {

            $newPromises = Promise::create([
                'user_id' => $request->user()->id,
                'promiser_name' => $request->promiser_name,
                'promise_content' => $request->promise_content,
                'date_made' => $request->date_made,
                'deadline' => $request->deadline,
                'status' => $request->status,
                'importance_level' => $request->importance_level
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Tạo thành công',
                'data' => (new PromiseResource($promises))->resolve(),
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
            $promises = Promise::where('user_id', Auth::id())
                                ->findOrFail($id);

            $promises->update($request->all());

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

    public function Delete($id) {
        try {
            $promise = Promise::where('user_id', Auth::id())
                               ->findOrFail($id);

            $promise->delete();

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
