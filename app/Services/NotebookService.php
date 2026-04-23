<?php

namespace App\Services;
use App\Repositories\NotebookRepository;

class NotebookService
{
    protected $repository;

    public function __construct(NotebookRepository $repository){
        $this->repository = $repository;

    }
    
    public function getAllNotebooks($userId)
    {
        return $this->repository->getByUser($userId);
    }

    public function createNotebook(array $data, $userId)
    {
        
        $data['user_id'] = $userId;

        return $this->repository->create($data);
    }

    public function updateNotebook($id, array $data, $userId)
    {
        $document = $this->repository->findByUserAndId($userId, $id);

        return $this->repository->update($document, $data);
    }

    public function deleteNotebook($id, $userId)
    {
        $document = $this->repository->findByUserAndId($userId, $id);
        
        return $this->repository->delete($document);
    }

    public function getNotebooksForUsers($userId, array $rawFilters)
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
