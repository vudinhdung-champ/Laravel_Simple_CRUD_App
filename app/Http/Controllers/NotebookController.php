<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notebook;
use App\Http\Requests\StoreNotebookRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\NotebookResource;



class NotebookController extends Controller
{
    public function index() {
        try {
            $documents = Notebook::where('user_id', Auth::id())
                                  ->orderBy('created_at', 'desc')
                                  ->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Thành công',
                'data' => NotebookResource::collection($documents)->resolve(),
            ], 200);


        } catch(\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Đã xảy ra lỗi: ' . $e->getMessage()

            ], 500);
        }

    }


    public function Store(StoreNotebookRequest $request) {
        try {
            $documents = Notebook::create([
                'user_id' => Auth->user()->id,
                'title' => $request->title,
                'content' => $request->content,
                'category' => $request->category

            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Tạo thành công',
                'data' => (new NotebookResource($documents))->resolve(),
        
            ], 200);


        } catch(\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Đã xảy ra lỗi: ' . $e->getMessage()

            ], 500);

        }
    }

    public function Update(StoreNotebookRequest $request, $id) {
        try {
            $documents = Notebook::where('user_id', Auth::id())
                                 ->findOrFail($id);
            
            $documents->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Sửa thành công',
                'data' => (new NotebookResource($documents))->resolve(),

            ], 200);

        } catch(\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Lỗi xảy ra: ' .$e->getMessage()

            ], 500);

        }
    }

    public function Destroy($id) {
        try {
            $documents = Notebook::where('user_id', Auth::id())
                                  ->findOrFail($id);
            
            $documents->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Xoá thành công',

            ], 200);

        } catch(\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra: ' .$e->getMessage()

            ], 500);
        }
    }
    
}
