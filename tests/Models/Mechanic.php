<?php declare(strict_types=1);

namespace Tests\BrokeYourBike\LaravelPlugin\Models;

use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

final class Mechanic extends Model {
    use HasFactory;
    protected $table = 'mechanics';

    /**
     * @psalm-return HasOneThrough<User>
     */
    public function carOwner(): HasOneThrough
    {
        return $this->hasOneThrough(User::class, Car::class);
    }
}
