<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_bs', 'title_en', 'kind_bs', 'kind_en', 'programme_bs', 'programme_en',
        'summary_bs', 'summary_en', 'meta_bs', 'meta_en', 'project_status',
        'status', 'sort_order', 'created_by',
    ];

    protected function casts(): array
    {
        return [
            'meta_bs' => 'array',
            'meta_en' => 'array',
            'sort_order' => 'integer',
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function localized(string $field, ?string $locale = null): mixed
    {
        $locale ??= app()->getLocale();

        return $this->getAttribute($field.'_'.($locale === 'en' ? 'en' : 'bs'));
    }

    public function publicData(?string $locale = null): array
    {
        $locale ??= app()->getLocale();
        $isEnglish = $locale === 'en';

        return [
            'status_class' => $this->project_status,
            'status' => $this->project_status === 'completed'
                ? ($isEnglish ? 'Completed project' : 'Završen projekat')
                : ($isEnglish ? 'Active project' : 'Aktivni projekat'),
            'kind' => $this->localized('kind', $locale),
            'programme' => $this->localized('programme', $locale),
            'title' => $this->localized('title', $locale),
            'text' => $this->localized('summary', $locale),
            'meta' => $this->localized('meta', $locale) ?? [],
        ];
    }
}
