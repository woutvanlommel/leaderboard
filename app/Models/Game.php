<?php

namespace App\Models;

use App\Enums\GameStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name',
    'slug',
    'invite_code',
    'color',
    'rules',
    'starts_at',
    'ends_at',
    'min_tagger_seconds',
    'back_tag_allowed',
    'notifications_enabled',
    'auto_confirm_minutes',
    'status',
])]
class Game extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'rules' => 'array',
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'back_tag_allowed' => 'boolean',
            'notifications_enabled' => 'boolean',
            'status' => GameStatus::class,
        ];
    }

    /**
     * @return HasMany<GameParticipant, $this>
     */
    public function participants(): HasMany
    {
        return $this->hasMany(GameParticipant::class);
    }

    /**
     * @return BelongsToMany<User, $this>
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'game_participants')
            ->withPivot(['display_name', 'game_onboarding_completed_at', 'joined_at'])
            ->withTimestamps();
    }

    /**
     * @return HasMany<TagTurn, $this>
     */
    public function tagTurns(): HasMany
    {
        return $this->hasMany(TagTurn::class);
    }

    /**
     * @return BelongsTo<TagTurn, $this>
     */
    public function currentTagTurn(): BelongsTo
    {
        return $this->belongsTo(TagTurn::class, 'current_tag_turn_id');
    }

    /**
     * @return HasMany<GameStatistic, $this>
     */
    public function statistics(): HasMany
    {
        return $this->hasMany(GameStatistic::class);
    }

    /**
     * @return HasMany<GameRivalry, $this>
     */
    public function rivalries(): HasMany
    {
        return $this->hasMany(GameRivalry::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
}
