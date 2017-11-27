<?php

namespace App\Products;

use App\Publishable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model implements Stockable
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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function toolGroups()
    {
        return $this->hasMany(ToolGroup::class);
    }

    public function addToolGroup($tool_group_attributes)
    {
        return $this->toolGroups()->create($tool_group_attributes);
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
        $direct_children = $this->products;
        $descendants = $this->toolGroups->flatMap(function($tool_group) {
            return $tool_group->products;
        });

        return $direct_children->merge($descendants);
    }

    public function parent()
    {
        return $this->category;
    }


}
