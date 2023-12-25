<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Property extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
        'password',
        'country',
        'address',
        'city',
        'slider',
        'price',
        'status',
        'visible',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('sliderbild')
            ->performOnCollections('slider')
            ->crop('crop-center', 1920, 968)
            ->nonQueued();
        
        $this->addMediaConversion('hauptbild')
            ->performOnCollections('hauptbild')
            ->crop('crop-center', 600, 800)
            ->nonQueued();
    }
}
