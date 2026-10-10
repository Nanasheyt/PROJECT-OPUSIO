<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = ['portfolio_id', 'company', 'position', 'start_date', 'end_date', 'description', 'sort_order'];
}
