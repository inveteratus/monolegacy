<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use DateTimeImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property DateTimeImmutable|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property DateTimeImmutable $created_at
 * @property DateTimeImmutable $updated_at
 * @property int $cash
 * @property int $bank
 * @property int $tokens
 * @property DateTimeImmutable|null $premium
 * @property int $city_id
 * @property int $property_id
 * @property float $energy
 * @property float $nerve
 * @property float $health
 * @property float $power           // $max_power comes from property->capacity
 * @property int $max_energy
 * @property int $max_nerve
 * @property int $max_health
 * @property DateTimeImmutable $regenerated_at
 * @property float $experience
 * @property float $strength
 * @property float $agility
 * @property float $defense
 * @property float $intelligence
 * @property float $endurance
 * @property DateTimeImmutable $hospital
 * @property DateTimeImmutable $jail
 * @property string|null $reason
 */
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

        'city_id',
        'property_id',

        'energy',
        'nerve',
        'health',
        'power',

        'max_energy',
        'max_nerve',
        'max_health',

        'regenerated_at',

        'experience',

        'strength',
        'agility',
        'defense',
        'intelligence',
        'endurance',

        'hospital',
        'jail',
        'reason',
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

            'city_id' => 'integer',
            'property_id' => 'integer',

            'energy' => 'float',
            'nerve' => 'float',
            'health' => 'float',
            'power' => 'float',

            'max_energy' => 'integer',
            'max_nerve' => 'integer',
            'max_health' => 'integer',

            'regenerated_at' => 'immutable_datetime',

            'experience' => 'float',

            'strength' => 'float',
            'agility' => 'float',
            'defense' => 'float',
            'intelligence' => 'float',
            'endurance' => 'float',

            'hospital' => 'immutable_datetime',
            'jail' => 'immutable_datetime',
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

    public function regenerate(): void
    {
        $now = now()->toImmutable();
        $diffInSeconds = $now->diffInSeconds($this->regenerated_at, true);
        if ($diffInSeconds >= 300) {
            // Increase energy by 1 unit every 2 minutes (
            $this->energy = min($this->max_energy, $this->energy + $diffInSeconds / 120);

            // Increase nerve by 1 unit every minute
            $this->nerve = min($this->max_nerve, $this->nerve + $diffInSeconds / 60);

            // Increase energy by 1 unit every 3 minutes (
            $this->health = min($this->max_health, $this->health + $diffInSeconds / 180);

            // Increase power by 10 units every 5 minutes (1 unit every 30 seconds)
            $this->power = min($this->property->capacity, $this->power + $diffInSeconds / 30);

            $this->regenerated_at = $now;
            $this->save();
        }
    }
}
