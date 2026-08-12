<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NewsPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by',
        'slug',
        'title_bs',
        'title_en',
        'category_bs',
        'category_en',
        'excerpt_bs',
        'excerpt_en',
        'body_bs',
        'body_en',
        'image_path',
        'image_alt_bs',
        'image_alt_en',
        'status',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function localized(string $field, ?string $locale = null): ?string
    {
        $locale ??= app()->getLocale();
        $column = $field.'_'.($locale === 'en' ? 'en' : 'bs');

        return $this->getAttribute($column);
    }

    public function isPublished(): bool
    {
        return $this->status === 'published'
            && $this->published_at !== null
            && $this->published_at->isPast();
    }
}
