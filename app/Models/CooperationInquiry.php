<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CooperationInquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'organization',
        'partner_type',
        'initiative_title',
        'message',
        'locale',
        'viewed_at',
        'viewed_by',
    ];

    protected function casts(): array
    {
        return [
            'viewed_at' => 'datetime',
        ];
    }

    public function viewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'viewed_by');
    }

    public function scopeUnread(Builder $query): Builder
    {
        return $query->whereNull('viewed_at');
    }

    public function isUnread(): bool
    {
        return $this->viewed_at === null;
    }
}
