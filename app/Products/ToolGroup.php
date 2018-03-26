<?php

namespace App\Products;

use App\Publishable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class ToolGroup extends Model implements Stockable
{
    use Sluggable, StockableTrait, Publishable;

    protected $fillable = ['title', 'description'];

    protected $casts = ['published' => 'boolean'];

    public function sluggable()
    {
        return [
            'slug' => ['source' => 'title']
        ];
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function toJsonableArray()
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'slug'        => $this->slug,
            'description' => $this->description,
            'published'   => $this->published
        ];
    }

    public function descendants()
    {
        return $this->products;
    }

    public function publishedDescendants()
    {

    }

    public function parent()
    {
        return $this->subcategory;
    }


}
