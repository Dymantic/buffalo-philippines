<?php


namespace App\Products;


use Illuminate\Support\Facades\DB;

class StockablesObserver
{
    public function deleted(Stockable $stockable)
    {
        DB::table('stockables')
          ->where('stockable_id', $stockable->id)
          ->where('stockable_type', get_class($stockable))
          ->delete();
    }
}