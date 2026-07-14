<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'game_id',
    'user_id',
    'total_seconds',
    'times_as_tagger',
    'longest_turn_seconds',
    'shortest_turn_seconds',
    'average_turn_seconds',
    'last_calculated_at',
])]
class GameStatistic extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'last_calculated_at' => 'datetime',
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
}
