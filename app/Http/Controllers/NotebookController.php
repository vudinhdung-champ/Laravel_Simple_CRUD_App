<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreNotebookRequest;
use App\Http\Resources\NotebookResource;
use App\Services\NotebookService;


class NotebookController extends Controller
{
    protected $notebookService;

    public function __construct(NotebookService $notebookService){
        $this->notebookService = $notebookService;

    }

    public function index(Request $request) {
        try {

            $filters = [
                'category',
                'page',
                'per_page'
            ];
            
            $documents = $this->notebookService->getNotebooksForUser($request->user()->id, $filters)

            return NotebookResource::collection($documents)->additional([
                'status' => 'success',
                'message' => 'Lọc danh sách thành công'

            ]);

        } catch(\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Đã xảy ra lỗi: ' . $e->getMessage()

            ], 500);
        }

    }


    public function Store(StoreNotebookRequest $request) {
        try {
            $documents = $this->notebookService->createNotebook($request->user()->id, $request->all());

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
            $documents = $this->notebookService->updateNotebook($id, $request->all(), $request->user()->id);

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

    public function Destroy($id, Request $request) {
        try {
            $this->notebookService->deleteNotebook($id, $request->user()->id);

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
