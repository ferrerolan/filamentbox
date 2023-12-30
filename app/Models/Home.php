<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Home extends Model
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
        'slider',
        'visible',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('Imagem Capa')
            ->performOnCollections('capa')
            ->crop('crop-center', 1920, 960)
            ->nonQueued();
        $this->addMediaConversion('Imagem Projetos')
            ->performOnCollections('projetos')
            ->crop('crop-center', 192, 96)
            ->nonQueued();
        $this->addMediaConversion('Imagem Colaboradores')
            ->performOnCollections('colaboradores')
            ->crop('crop-center', 600, 800)
            ->nonQueued();
        $this->addMediaConversion('Avaliações')
            ->performOnCollections('avaliações')
            ->crop('crop-center', 120, 160)
            ->nonQueued();
    }

    // protected function price(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => number_format(intval($value),0,'',','),
    //         set: fn ($value) => preg_replace('/[^0-9]/','',intval($value)),
    //     );
    // }

}
