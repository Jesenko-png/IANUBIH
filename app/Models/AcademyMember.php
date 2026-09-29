<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AcademyMember extends Model
{
    protected $fillable = [
        'slug', 'name', 'academic_title', 'category_bs', 'category_en',
        'position_bs', 'position_en', 'field_bs', 'field_en',
        'institution_bs', 'institution_en', 'country_bs', 'country_en',
        'bio_bs', 'bio_en', 'email', 'website_url', 'photo_path',
        'status', 'sort_order', 'created_by',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    public function localized(string $field): ?string
    {
        $locale = app()->getLocale() === 'en' ? 'en' : 'bs';
        $other = $locale === 'en' ? 'bs' : 'en';

        return $this->{$field.'_'.$locale} ?: $this->{$field.'_'.$other};
    }
}
