<?php

namespace App\Services;
use App\Repositories\NotebookRepository;
use Illuminate\Support\Arr;

class NotebookService
{
    protected $repository;

    public function __construct(NotebookRepository $repository)
    {
        $this->repository = $repository;

    }

    public function getAllNotebooks($userId)
    {
        return $this->repository->getByUser($userId);
    }

    public function createNotebook(array $data, $userId)
    {

        return $this->repository->create([
            'user_id' => $userId,
            'title' => Arr::get($data, 'title'),
            'content' => Arr::get($data, 'content'),
            'category' => Arr::get($data, 'category'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    public function updateNotebook($id, array $data, $userId)
    {
        $document = $this->repository->getByUserAndId($userId, $id);

        return $this->repository->update($document, $data);
    }

    public function deleteNotebook($id, $userId)
    {
        $document = $this->repository->getByUserAndId($userId, $id);

        return $this->repository->delete($document);
    }

    public function getNotebooksForUsers($userId, array $rawFilters)
    {
        if (isset($rawFilters['search'])) {
            $rawFilters['search'] = trim($rawFilters['search']);
        }

        $perPage = (int) ($rawFilters['per_page'] ?? 9);

        if ($perPage > 30) {
            $perPage = 30;
        } else if ($perPage < 1) {
            $perPage = 9;
        }

        return $this->repository->getListByFilters($userId, $perPage, $rawFilters);

    }

    public function getNotebookById($id, $userId)
    {
        return $this->repository->getByUserAndId($userId, $id);
    }
}
