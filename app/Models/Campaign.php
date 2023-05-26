<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Campaign extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $guarded = ['id'];

    protected $dates = [
        'published_at',
        'closed_at',
    ];

    protected $appends = [
        'original_cover_url',
        'thumbnail_cover_url',
    ];

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumbnail')
            ->width(300)
            ->nonQueued();
    }

    protected static function booted()
    {
        static::creating(function (self $campaign) {
            if (empty($campaign->slug)) {
                $campaign->slug = Str::slug($campaign->name);
            }
        });
    }

    public function getDonorsAttribute()
    {
        return $this->attributes['donors'] ?: 0;
    }

    public function getOriginalCoverUrlAttribute()
    {
        return $this->getFirstMediaUrl() ?: config('app.image_placeholder');
    }

    public function getThumbnailCoverUrlAttribute()
    {
        return $this->getFirstMediaUrl('default', 'thumbnail') ?: config('app.image_placeholder');
    }

    public function getTimeLeftAttribute()
    {
        return $this->closed_at->diffInDays();
    }

    public function getCollectedFundsPercentageAttribute()
    {
        return $this->funds ? ($this->collected_funds / $this->funds * 100) . '%' : '100%';
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at');
    }

    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where(function (Builder $query) {
            $query->orWhereNull('closed_at')
                ->orWhere('closed_at', '>=', now());
        });
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function transactionsApi(): HasMany
    {
        return $this->hasMany(TransactionApi::class);
    }

    public function canClose(): bool
    {
        return !empty($this->closed_at);
    }

    public function isClosed(): bool
    {
        if (!$this->canClose()) {
            return false;
        }

        return $this->closed_at->lessThan(now());
    }

    public function isUnlimitedFunds(): bool
    {
        return !empty($this->funds);
    }
}
