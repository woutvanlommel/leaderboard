<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'game_id',
    'tagger_id',
    'tagged_id',
    'tag_count',
    'last_tagged_at',
])]
class GameRivalry extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'last_tagged_at' => 'datetime',
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
    public function tagger(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tagger_id');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function tagged(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tagged_id');
    }
}
