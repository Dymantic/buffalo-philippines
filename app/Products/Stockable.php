<?php


namespace App\Products;


interface Stockable
{
    public function descendants();

    public function publishedDescendants();

    public function parent();
}