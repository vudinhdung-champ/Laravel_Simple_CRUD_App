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

    public function getPromisesForUser($userId, array $rawFilters)
    {
        if(isset($rawFilters['search']))
        {
            $rawFilters['search'] = trim($rawFilters['search']);
        }

        $perPage = (int) ($rawFilters['per_page'] ?? 10);

        if($perPage > 30)
        {
            $perPage = 30;
        }

        else if($perPage < 1)
        {
            $perPage = 10;
        }

        return $this->repository->getListWithFilters($userId, $rawFilters, $perPage);

    }
}
