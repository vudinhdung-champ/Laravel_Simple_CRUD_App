<?php

namespace App\Services;

use App\Repositories\SubscriptionRepository;

class SubscriptionService
{
    protected $repository;

    public function __construct(SubscriptionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllSubscriptions($userId)
    {
        return $this->repository->getByUser($userId);
    }

    public function createSubscription(array $data, $userId)
    {
        
        $data['user_id'] = $userId;
        $data['status'] = $data['status'] ?? 'active';

        return $this->repository->create($data);
    }

    public function updateSubscription($id, array $data, $userId)
    {
        $subscription = $this->repository->findByUserAndId($userId, $id);

        return $this->repository->update($subscription, $data);
    }

    public function deleteSubscription($id, $userId)
    {
        
        $subscription = $this->repository->findByUserAndId($userId, $id);

        return $this->repository->delete($subscription);
    }

    public function getSubscriptionsForUser($userId, array $rawFilters) {

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