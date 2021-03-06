<?php

namespace App\Products;

use App\Publishable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use Sluggable, Publishable, InteractsWithMedia;

    const MAIN_IMG = 'main-images';
    const GALLERY_IMGS = 'gallery-images';
    const DEFAULT_MAIN_IMG = '/images/defaults/product.png';

    protected $fillable = ['title', 'code', 'description', 'price', 'writeup', 'new_until'];

    protected $casts = ['published' => 'boolean', 'featured' => 'boolean'];

    protected $dates = ['new_until'];

    public function sluggable(): array
    {
        return [
            'slug' => ['source' => 'title']
        ];
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
             ->fit(Manipulations::FIT_FILL, 300, 300)
             ->background('#FFFFFF')
             ->keepOriginalImageFormat()
             ->optimize()
             ->performOnCollections(static::MAIN_IMG, static::GALLERY_IMGS);

        $this->addMediaConversion('web')
             ->fit(Manipulations::FIT_MAX, 600, 600)
             ->keepOriginalImageFormat()
             ->optimize()
             ->performOnCollections(static::MAIN_IMG, static::GALLERY_IMGS);
    }

    public function mainImage()
    {
        return $this->getFirstMedia(static::MAIN_IMG);
    }

    public function imageUrl($conversion = '')
    {
        $img = $this->getFirstMedia(static::MAIN_IMG);

        return $img ? $img->getUrl($conversion) : static::DEFAULT_MAIN_IMG;
    }

    public function setMainImage($image)
    {
        $this->clearMainImage();

        return $this->addMedia($image)
                    ->usingFileName(str_random(10))
                    ->preservingOriginal()
                    ->toMediaCollection(static::MAIN_IMG);
    }

    public function clearMainImage()
    {
        $this->clearMediaCollection(static::MAIN_IMG);
    }

    public function addGalleryImage($image)
    {
        return $this->addMedia($image)
                    ->usingFileName(str_random(10))
                    ->preservingOriginal()
                    ->toMediaCollection(static::GALLERY_IMGS);
    }

    public function categories()
    {
        return $this->morphedByMany(Category::class, 'stockable');
    }

    public function subcategories()
    {
        return $this->morphedByMany(Subcategory::class, 'stockable');
    }

    public function toolGroups()
    {
        return $this->morphedByMany(ToolGroup::class, 'stockable');
    }

    public function feature()
    {
        $this->featured = true;
        $this->save();
    }

    public function demote()
    {
        $this->featured = false;
        $this->save();
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function addDaysToNewUntil($days)
    {
        $new_date = $this->new_until ?? Carbon::today();
        $this->new_until = $new_date->isPast() ? Carbon::today()->addDays($days) : $new_date->addDays($days);
        $this->save();
    }

    public function isNew()
    {
        if (!$this->new_until) {
            return false;
        }

        return !$this->new_until->isPast();
    }

    public function parents()
    {
        return $this->toolGroups->merge($this->subcategories)->merge($this->categories);
    }

    public function toJsonableArray()
    {
        return [
            'id'             => $this->id,
            'title'          => $this->title,
            'slug'           => $this->slug,
            'code'           => $this->code,
            'description'    => $this->description,
            'writeup'        => $this->writeup,
            'price'          => $this->price,
            'published'      => $this->published,
            'featured'       => $this->featured,
            'is_new'         => $this->isNew(),
            'new_until'      => $this->new_until ? $this->new_until->format('Y-m-d') : null,
            'parents'        => $this->parentsJson(),
            'main_image'     => [
                'id'       => $this->mainImage() ? $this->mainImage()->id : null,
                'thumb'    => $this->imageUrl('thumb'),
                'web'      => $this->imageUrl('web'),
                'original' => $this->imageUrl()
            ],
            'gallery_images' => $this->galleryJson()
        ];
    }

    private function parentsJson()
    {

        return \DB::table('stockables')->where('product_id', $this->id)
                  ->get()
                  ->map(function ($stockable) {
                      return (new $stockable->stockable_type)->find($stockable->stockable_id);
                  })
                  ->reject(function ($stockable) {
                      return !$stockable;
                  })
                  ->map(function ($parent) {
                      return $parent->heritage();
                  })
                  ->all();
    }

    private function galleryJson()
    {
        return $this->getMedia(static::GALLERY_IMGS)->map(function ($image) {
            return [
                'id'       => $image->id,
                'thumb'    => $image->getUrl('thumb'),
                'web'      => $image->getUrl('web'),
                'original' => $image->getUrl()
            ];
        })->all();
    }
}
