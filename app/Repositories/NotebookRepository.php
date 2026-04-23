<?php

namespace App\Repositories;
use App\Models\Notebook;


class NotebookRepository
{
    public function getByUser($userId){
        return Notebook::where('user_id', $userId)
                        ->orderBy('next_billing_date', 'asc')
                        ->get();
    }


    public function create(array $data){
        return Notebook::create($data);

    }

    public function getByUserAndId($userId, $id){
        return Notebook::where('user_id', $userId)->findOrFail($id);
    
    }


    public function update($document, array $data){
        $document->update($data);
        return $document;

    }

    public function delete($document){
        return $document->delete();

    }


    public function getListByFilters($userId, $perPage, array $filters) {

        $query = Notebook::where('user_id', $userId);

        $query->when(isset($filters['search']), function ($q) use ($filters) {
            $q->where('title', 'like', '%' . $filters['search'] . '%')

        });

        $allowedFilters = [
            'category',

        ];

        foreach ($filters as $keys => $value)
        {
            if(in_array($keys, $allowedFilters) && $value != null && $value != '')
            {
                $query->where($keys, $value);
            }

        }

        return $query->orderBy('created_at', 'asc')->paginate($perPage);


    }

}
