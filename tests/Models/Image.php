<?php declare(strict_types=1);

namespace Tests\BrokeYourBike\LaravelPlugin\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

final class Image extends Model
{
    use HasFactory;
    /**
     * Get the owning imageable model.
     */
    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
