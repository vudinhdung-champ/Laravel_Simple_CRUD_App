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

}
