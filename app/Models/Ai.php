<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Ai extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $guarded = [];

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(550)
            ->height(240);
    }

    public function image(){
//        return null;
        if(!$this->media->first()) return null;
        return $this->media->first()->getFullUrl('thumb');
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }
}
