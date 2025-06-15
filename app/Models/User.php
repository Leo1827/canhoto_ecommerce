<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomVerifyEmail;
use App\Notifications\CustomResetPassword;
use Laravel\Cashier\Billable;
/**
 * @method bool hasActiveSubscription()
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Billable;
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail());
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }

     public function payments()
    {
        return $this->hasMany(UserPayment::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)
            ->where(function($query) {
                $query->where('stripe_status', 'active')
                      ->where(function($q) {
                          $q->whereNull('ends_at')
                            ->orWhere('ends_at', '>', now());
                      });
            });
    }

    public function subscriptionHistory()
    {
        return $this->hasManyThrough(
            SubscriptionHistory::class,
            Subscription::class
        );
    }

    public function hasActiveSubscription()
    {
        return $this->activeSubscription()->exists();
    }


}
