<?php

namespace App\Repositories;
use App\Models\Promise;


class PromiseRepository
{
    public function getByUser($userId){
        return Promise::where('user_id', $userId)
                        ->orderBy('next_billing_date', 'asc')
                        ->get();
    }


    public function create(array $data){
        return Promise::create($data);

    }

    public function getByUserAndId($userId, $id){
        return Promise::where('user_id', $userId)->findOrFail($id);
    
    }


    public function update($promise, array $data){
        $promise->update($data);
        return $promise;

    }

    public function delete($promise){
        return $promise->delete();

    }

    public function getListWithFilters($userId, array $filters, $perPage) {
        $query = Promise::where('user_id', $userId);

        $query->when(isset($filters['search']), function ($q) use ($filters) {
            $q->where('promiser_name', 'like', '%' . $filters['search'] . '%');
        });

        $allowedFilters = [
            'status',
            'importance_level'
        ];

        foreach ($filters as $keys => $value)
        {
            if(in_array($keys, $allowedFilters) && $value != null && $value != '')
            {
                $query->where($keys, $value);
            }
        }

        return $query->orderBy('deadline', 'asc')->paginate($perPage);


    }

}
