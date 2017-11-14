<?php

namespace App\Products;

use App\Publishable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use Sluggable, Stockable, Publishable;

    protected $fillable = ['title', 'description'];

    protected $casts = ['published' => 'boolean'];

    public function sluggable()
    {
        return [
            'slug' => ['source' => 'title']
        ];
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
}
