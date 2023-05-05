<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Banner extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $guarded = ['id'];

    protected $appends = [
        'original_url',
        'thumbnail_url',
    ];

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumbnail')
            ->width(300)
            ->nonQueued();
    }

    public function getOriginalUrlAttribute()
    {
        return $this->getFirstMediaUrl() ?: config('app.image_placeholder');
    }

    public function getThumbnailUrlAttribute()
    {
        return $this->getFirstMediaUrl('default', 'thumbnail') ?: config('app.image_placeholder');
    }
}
