<?php declare(strict_types=1);

namespace Tests\BrokeYourBike\LaravelPlugin\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

final class Phone extends Model {
    use HasFactory;
    protected $table = 'phone_numbers';

    /**
     * @psalm-return BelongsTo<User>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
