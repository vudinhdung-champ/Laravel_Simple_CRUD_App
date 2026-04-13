<?php

namespace App\Services;
use App\Repositories\PromiseRepository;

class PromiseService
{
    protected $repository;

    public function __construct(PromiseRepository $repository){
        $this->repository = $repository;

    }
    
    public function getAllPromises($userId)
    {
        return $this->repository->getByUser($userId);
    }

    public function createPromise(array $data, $userId)
    {
        
        $data['user_id'] = $userId;

        return $this->repository->create($data);
    }

    public function updatePromise($id, array $data, $userId)
    {
        $promise = $this->repository->findByUserAndId($userId, $id);

        return $this->repository->update($promise, $data);
    }

    public function deletePromise($id, $userId)
    {
        $promise = $this->repository->findByUserAndId($userId, $id);
        
        return $this->repository->delete($promise);
    }
}
