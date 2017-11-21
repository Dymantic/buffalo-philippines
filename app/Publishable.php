<?php


namespace App;


trait Publishable
{
    public function publish()
    {
        $this->published = true;
        $this->save();
    }

    public function retract()
    {
        $this->published = false;
        $this->save();
    }

    public function scopePublished($query)
    {
        return $query->where('published', true);
    }
}