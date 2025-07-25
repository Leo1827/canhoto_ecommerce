<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomVerifyEmail;
use App\Notifications\CustomResetPassword;
use Laravel\Cashier\Billable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Billable;
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail());
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }

    // Relación con pagos
    public function payments()
    {
        return $this->hasMany(UserPayment::class);
    }

    // Relación general con suscripciones
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    // Relación activa para Eloquent (se puede usar en with())
    public function activeSubscriptionRelation()
    {
        return $this->hasOne(Subscription::class)
            ->where('stripe_status', 'COMPLETED')
            ->where(function($q) {
                $q->whereNull('ends_at')
                  ->orWhere('ends_at', '>', now());
            });
    }

    // Esta es la relación para usar con Eloquent (ej: with('activeSubscription'))
    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)
            ->where('stripe_status', 'COMPLETED')
            ->where(function ($q) {
                $q->whereNull('ends_at')
                ->orWhere('ends_at', '>', now());
            });
    }

    // Esta es una función auxiliar que devuelve la suscripción activa
    public function getActiveSubscription()
    {
        return $this->activeSubscription()->first();
    }

    // Booleano para saber si tiene suscripción activa
    public function hasActiveSubscription()
    {
        return $this->getActiveSubscription() !== null;
    }

    // Relación con historial de suscripciones
    public function subscriptionHistory()
    {
        return $this->hasManyThrough(
            SubscriptionHistory::class,
            Subscription::class
        );
    }
}
