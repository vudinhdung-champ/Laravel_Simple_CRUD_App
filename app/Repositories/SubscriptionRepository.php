<?php

// Nhiệm vụ của file SubscriptionRepository là lấy từ database ra hoặc đưa vào database //
namespace App\Repositories;
use App\Models\Subscription;


class SubscriptionRepository
{

    public function getByUsers($userId){
        return Subscription::where('user_id', $userId)
                            ->orderBy('next_billing_date', 'asc')
                            ->get();

    }

    public function create(array $data){
        return Subscription::create($data);
    }

    public function findByUserAndId($userId, $id){
        return Subscription::where('user_id', $userId)->findOrFail($id);

    }

    public function update($subscription, array $data){
        $subscription->update($data);
        return $subscription;
    }

    public function delete($subscription){
        return $subscription->delete();

    }

    public function getListWithFilters($userId, array $filters, $perPage) {
        $query = Subscription::where('user_id', $userId);
        
        $query->when(isset($filters['search']), function ($q) use ($filters) {
            $q->where('service_name', 'like', '%' . $filters['search'] . '%');

        });

        $allowedFilters = [
            'status',
            'billing_cycle',
        ];

        foreach($filters as $key => $value)
        {
            if(in_array($key, $allowedFilters) && $value != null && $value != '')
            {
                $query->where($key, $value);
            }
        }

        return $query->orderBy('next_billing_date', 'asc')->paginate($perPage);
        
    }

}
