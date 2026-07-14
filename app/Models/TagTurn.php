<?php

namespace App\Models;

use App\Enums\TagTurnStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'game_id',
    'user_id',
    'tagged_by_id',
    'started_at',
    'ended_at',
    'status',
    'confirmed_at',
])]
class TagTurn extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'ended_at' => 'datetime',
            'confirmed_at' => 'datetime',
            'status' => TagTurnStatus::class,
        ];
    }

    /**
     * @return BelongsTo<Game, $this>
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function taggedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tagged_by_id');
    }
}
