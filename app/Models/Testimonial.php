<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = ['portfolio_id', 'quote', 'author', 'role', 'sort_order'];
}