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

}
