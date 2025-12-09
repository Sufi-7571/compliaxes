<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
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
        'subscription_plan_id',
        'subscription_started_at',
        'subscription_ends_at',
        'stripe_customer_id',
        'stripe_subscription_id'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'subscription_started_at' => 'datetime',
        'subscription_ends_at' => 'datetime',
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

    // Relationship
    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    public function websites()
    {
        return $this->hasMany(Website::class);
    }

    public function hasActiveSubscription()
    {
        return $this->subscription_plan_id &&
            (!$this->subscription_ends_at || $this->subscription_ends_at->isFuture());
    }

    public function canAddWebsite()
    {
        if (!$this->subscriptionPlan) {
            return false;
        }
        return $this->websites()->count() < $this->subscriptionPlan->max_websites;
    }
}
