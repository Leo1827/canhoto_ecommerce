<?php

namespace App\Observers;

use App\Models\Subscription;
use App\Models\SubscriptionHistory;

class SubscriptionObserver
{
    /**
     * Handle the Subscription "created" event.
     */
    public function created(Subscription $subscription): void
    {
        //
        $this->logHistory($subscription, 'created', 'Assinatura criada.');
    }

    /**
     * Handle the Subscription "updated" event.
     */
    public function updated(Subscription $subscription): void
    {
        //
        $this->logHistory($subscription, 'updated', 'Assinatura atualizada.');
    }

    /**
     * Handle the Subscription "deleted" event.
     */
    public function deleted(Subscription $subscription): void
    {
        //
        $this->logHistory($subscription, 'deleted', 'Assinatura removida.');
    }

    /**
     * Handle the Subscription "logHistory" event.
     */
        protected function logHistory(Subscription $subscription, $status, $description = null)
    {
        SubscriptionHistory::create([
            'user_id' => $subscription->user_id,
            'subscription_id' => $subscription->id,
            'status' => $status,
            'description' => $description,
            'subscribed_at' => now(),
        ]);
    }
}
