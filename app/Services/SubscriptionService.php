<?php

namespace App\Services;

use App\Repositories\SubscriptionRepository;
use Illuminate\Support\Arr;
use App\Models\Subscription;

class SubscriptionService
{
    protected $repository;

    public function __construct(SubscriptionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllSubscriptions($userId)
    {
        return $this->repository->getByUsers($userId);
    }

    public function createSubscription(array $data, $userId)
    {
        return $this->repository->create([
            'user_id' => $userId,
            'service_name' => Arr::get($data, 'serviceName'),
            'price' => Arr::get($data, 'price'),
            'billing_cycle' => Arr::get($data, 'billingCycle'),
            'next_billing_date' => Arr::get($data, 'nextBillingDate'),
            'status' => Arr::get($data, 'status'),
            'notes' => Arr::get($data, 'notes'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    public function updateSubscription($id, array $data, $userId)
    {
        \Log::info('UPDATE DATA:', $data); // ← thêm dòng này tạm thời để test //

        $subscription = $this->repository->findByUserAndId($userId, $id);

        $mapped = array_filter([
            'service_name' => Arr::get($data, 'serviceName'),
            'price' => Arr::get($data, 'price'),
            'billing_cycle' => Arr::get($data, 'billingCycle'),
            'next_billing_date' => Arr::get($data, 'nextBillingDate'),
            'status' => Arr::get($data, 'status'),
            'notes' => Arr::get($data, 'notes'),
            'updated_at' => now()

        ], fn($v) => $v !== null);

        return $this->repository->update($subscription, $mapped);

    }

    public function deleteSubscription($id, $userId)
    {

        $subscription = $this->repository->findByUserAndId($userId, $id);

        return $this->repository->delete($subscription);
    }

    public function getSubscriptionsForUser($userId, array $rawFilters)
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

        return $this->repository->getListByFilters($userId, $rawFilters, $perPage);

    }

    public function getTotalCost($userId)
    {
        $totals = Subscription::where('user_id', $userId)
            ->where('status', 'active')
            ->selectRaw("
                SUM(CASE WHEN billing_cycle = 'monthly' THEN price ELSE 0 END) as sum_monthly,
                SUM(CASE WHEN billing_cycle = 'yearly' THEN price ELSE 0 END) as sum_yearly     
            ")->first();
            info("totals: " . json_encode($totals));

        $sumMonthly = (float) ($totals->sum_monthly ?? 0);
        $sumYearly = (float) ($totals->sum_yearly ?? 0);

        $totalMonthly = $sumMonthly;
        $totalYearly = $sumYearly + ($sumMonthly * 12);

        return [
            'totalMonthly' => $totalMonthly,
            'totalYearly' => $totalYearly
        ];

    }
}