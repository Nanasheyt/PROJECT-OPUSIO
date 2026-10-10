<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = ['portfolio_id', 'name', 'level', 'sort_order'];

    public function getPercentAttribute(): int
    {
        return Portfolio::SKILL_LEVELS[$this->level] ?? 60;
    }
}
