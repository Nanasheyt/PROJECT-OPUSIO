<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Portfolio extends Model
{
    public const TEMPLATES = [
        // Keys are stored in the database, so they stay the same; only the names changed.
        'simple'    => ['name' => 'Formal',    'description' => 'Classic executive résumé in navy and gold. Print-friendly.'],
        'modern'    => ['name' => 'Modern',    'description' => 'Frosted-glass cards on a soft gradient, with a sticky section menu.'],
        'creative'  => ['name' => 'Aesthetic', 'description' => 'Cyber-tech HUD with neon colours that slowly shift. Has a pause button.'],
        'minimal'   => ['name' => 'Minimal',   'description' => 'Ultra-clean, typography-first design. Zero decoration, maximum content density.'],
    ];

    public const SKILL_LEVELS = ['Beginner' => 35, 'Intermediate' => 60, 'Advanced' => 80, 'Expert' => 95];

    public const PLATFORMS = ['GitHub', 'LinkedIn', 'Facebook', 'Instagram', 'Twitter / X', 'YouTube', 'Website', 'Other'];

    protected $fillable = [
        'user_id', 'slug', 'full_name', 'job_title', 'email', 'phone', 'address',
        'about', 'profile_picture', 'template',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function educations(): HasMany
    {
        return $this->hasMany(Education::class)->orderBy('sort_order');
    }

    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class)->orderBy('sort_order');
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class)->orderBy('sort_order');
    }

    public function experiences(): HasMany
    {
        return $this->hasMany(Experience::class)->orderBy('sort_order');
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class)->orderBy('sort_order');
    }

    public function socialLinks(): HasMany
    {
        return $this->hasMany(SocialLink::class)->orderBy('sort_order');
    }

    public function testimonials(): HasMany
    {
        return $this->hasMany(Testimonial::class)->orderBy('sort_order');
    }

    public function publications(): HasMany
    {
        return $this->hasMany(Publication::class)->orderBy('sort_order');
    }

    public function languages(): HasMany
    {
        return $this->hasMany(Language::class)->orderBy('sort_order');
    }

    public function getInitialsAttribute(): string
    {
        $parts = preg_split('/\s+/', trim($this->full_name));
        $first = mb_substr($parts[0] ?? '', 0, 1);
        $last = count($parts) > 1 ? mb_substr(end($parts), 0, 1) : '';

        return mb_strtoupper($first . $last);
    }
}
