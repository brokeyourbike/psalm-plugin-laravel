<?php declare(strict_types=1);

namespace Tests\BrokeYourBike\LaravelPlugin\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

final class Comment extends Model
{
    use HasFactory;
    /**
     * @psalm-return BelongsTo<Post>
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Get the owning commentable model.
     */
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
}
