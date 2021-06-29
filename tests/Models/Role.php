<?php declare(strict_types=1);

namespace Tests\BrokeYourBike\LaravelPlugin\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

final class Role extends Model {
    use HasFactory;
    protected $table = 'roles';

    /**
     * @psalm-return BelongsToMany<User>
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
