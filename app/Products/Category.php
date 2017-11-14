<?php

namespace App\Products;

use App\Publishable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Sluggable, Stockable, Publishable;

    protected $fillable = ['title', 'description'];

    protected $casts = ['published' => 'boolean'];


    public function sluggable(): array
    {
        return [
            'slug' => ['source' => 'title']
        ];
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
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description
        ];
    }
}
