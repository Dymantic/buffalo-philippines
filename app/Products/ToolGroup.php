<?php

namespace App\Products;

use App\Publishable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class ToolGroup extends Model
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
