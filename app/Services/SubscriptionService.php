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
}