<?php

namespace App\Services;
use App\Repositories\PromiseRepository;
use Illuminate\Support\Arr;

class PromiseService
{
    protected $repository;

    public function __construct(PromiseRepository $repository)
    {
        $this->repository = $repository;

    }

    public function getAllPromises($userId)
    {
        return $this->repository->getByUser($userId);
    }

    public function createPromise(array $data, $userId)
    {
        return $this->repository->create([
            'user_id' => $userId,
            'promiser_name' => Arr::get($data, 'promiserName'),
            'promise_content' => Arr::get($data, 'promiseContent'),
            'deadline' => Arr::get($data, 'deadline'),
            'date_made' => Arr::get($data, 'dateMade'),
            'status' => Arr::get($data, 'status'),
            'importance_level' => Arr::get($data, 'importanceLevel'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    public function updatePromise($id, array $data, $userId)
    {
        $promise = $this->repository->getByUserAndId($userId, $id);

        $mapped = array_filter ([
            'promiser_name' => Arr::get($data, 'promiserName'),
            'promise_content' => Arr::get($data, 'promiseContent'),
            'deadline' => Arr::get($data, 'deadline'),
            'date_made' => Arr::get($data, 'dateMade'),
            'status' => Arr::get($data, 'status'),
            'importance_level' => Arr::get($data, 'importanceLevel'),
            'updated_at' => now()

        ], fn($v) => $v !== null);

        return $this->repository->update($promise, $mapped);
    }

    public function deletePromise($id, $userId)
    {
        $promise = $this->repository->getByUserAndId($userId, $id);

        return $this->repository->delete($promise);
    }

    public function getPromisesForUser($userId, array $rawFilters)
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

        return $this->repository->getListWithFilters($userId, $rawFilters, $perPage);

    }
}
