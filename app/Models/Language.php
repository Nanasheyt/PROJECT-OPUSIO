<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = ['portfolio_id', 'name', 'proficiency', 'percent', 'sort_order'];

    public const PROFICIENCIES = [
        'Native' => 100,
        'Fluent' => 90,
        'Professional' => 75,
        'Conversational' => 50,
        'Basic' => 25,
    ];
}