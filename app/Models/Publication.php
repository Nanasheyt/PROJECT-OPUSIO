<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    protected $fillable = ['portfolio_id', 'title', 'venue', 'year', 'url', 'sort_order'];
}