<?php

namespace App\Products;

use App\Publishable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use Spatie\MediaLibrary\Media;

class Category extends Model implements HasMediaConversions, Stockable
{
    use Sluggable, StockableTrait, Publishable, HasMediaTrait;

    const MAIN_IMG = 'main-image';
    const DEFAULT_IMG_SRC = '/images/defaults/category.png';

    protected $fillable = ['title', 'description'];

    protected $casts = ['published' => 'boolean'];


    public function sluggable(): array
    {
        return [
            'slug' => ['source' => 'title']
        ];
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
             ->fit(Manipulations::FIT_CROP, 300, 300)
             ->keepOriginalImageFormat()
             ->optimize()
             ->performOnCollections(static::MAIN_IMG);
    }

    public function setImage($image)
    {
        $this->clearImage();

        return $this->addMedia($image)->preservingOriginal()->toMediaCollection(static::MAIN_IMG);
    }

    public function clearImage()
    {
        $this->clearMediaCollection(static::MAIN_IMG);
    }

    public function imageUrl($conversion = '')
    {
        return $this->getFirstMediaUrl(static::MAIN_IMG, $conversion) ?: static::DEFAULT_IMG_SRC;
    }

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }

    public function addSubcategory($subcategory_attributes)
    {
        return $this->subcategories()->create($subcategory_attributes);
    }

    public function toJsonableArray()
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'image'       => [
                'thumb'    => $this->imageUrl('thumb'),
                'original' => $this->imageUrl()
            ]
        ];
    }

    public function menu()
    {
        $this->load('subcategories.toolGroups');

        $children = $this->subcategories->map(function ($subcategory) {
            return [
                'id'       => $subcategory->id,
                'title'    => $subcategory->title,
                'link'     => "/subcategories/{$subcategory->slug}",
                'children' => $subcategory->toolGroups->map(function ($toolGroup) {
                    return [
                        'id'    => $toolGroup->id,
                        'title' => $toolGroup->title,
                        'link'  => "/tool-groups/{$toolGroup->slug}"
                    ];
                })->all()
            ];
        })->all();

        return [
            'id'       => $this->id,
            'title'    => $this->title,
            'link'     => "/categories/{$this->slug}",
            'children' => $children
        ];
    }

    public function descendants()
    {
        $direct_children = $this->products;
        $subcategory_products = $this->subcategories->flatMap(function($subcategory) {
            return $subcategory->products;
        });
        $tool_group_products = $this->subcategories->flatMap(function($subcategory) {
            return $subcategory->toolGroups;
        })->flatMap(function($tool_group) {
            return $tool_group->products;
        });

        return $direct_children->merge($subcategory_products)->merge($tool_group_products);
    }

    public function parent()
    {
        return null;
    }
}
