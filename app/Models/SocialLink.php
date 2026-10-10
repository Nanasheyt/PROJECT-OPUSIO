<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    protected $fillable = ['portfolio_id', 'platform', 'url', 'sort_order'];
}
