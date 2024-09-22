<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',

        'cash',
        'bank',
        'tokens',
        'premium',

        'energy',
        'nerve',
        'health',
        'power',

        'max_energy',
        'max_nerve',
        'max_health',

        'regenerated_at',

        'city_id',
        'property_id',

        'strength',
        'agility',
        'defense',
        'intelligence',
        'endurance',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

            'cash' => 'integer',
            'bank' => 'integer',
            'tokens' => 'integer',
            'premium' => 'immutable_datetime',

            'energy' => 'float',
            'nerve' => 'float',
            'health' => 'float',
            'power' => 'float',

            'max_energy' => 'integer',
            'max_nerve' => 'integer',
            'max_health' => 'integer',

            'regenerated_at' => 'immutable_datetime',

            'city_id' => 'integer',
            'property_id' => 'integer',

            'strength' => 'float',
            'agility' => 'float',
            'defense' => 'float',
            'intelligence' => 'float',
            'endurance' => 'float',
        ];
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function regenerate(bool $force = false): self
    {
        $now = now()->toImmutable();
        $seconds = $now->diffInSeconds($this->regenerated_at, true);
        if (($force && ($seconds > 0)) || ($seconds >= 300)) {
            // Energy increases by 10 units every 5 minutes
            $this->energy = min($this->max_energy, $this->energy + $seconds / 30);

            // Nerve increases by 1 unit every 5 minutes
            $this->nerve = min($this->max_nerve, $this->nerve + $seconds / 300);

            // Health increases by 5 units every 5 minutes
            $this->health = min($this->max_health, $this->health + $seconds / 60);

            // Power increases by 3 units every 5 minutes
            $this->power = min($this->property->capacity, $this->power + $seconds / 100);

            // Update regenerated_at timestamp
            $this->regenerated_at = $now;

            // Save any changes
            $this->save();
        }

        return $this;
    }
}
