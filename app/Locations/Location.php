<?php

namespace App\Locations;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'store_locations';

    protected $fillable = ['name', 'address', 'lat', 'lng'];

    public function toJsonableArray()
    {
        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'address' => $this->address,
            'lat'     => $this->lat,
            'lng'     => $this->lng
        ];
    }

}
