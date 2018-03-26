<?php


namespace App\Products;


use Illuminate\Support\Facades\Cache;

class ProductsRepository
{
    public function productsUnder(Stockable $stockable)
    {
        return Cache::remember($stockable->slug, 60*24, function() use ($stockable) {
            return $stockable->descendants();
        });
    }

    public function publishedProductsUnder(Stockable $stockable)
    {
        return $stockable->publishedDescendants();
    }

    public function searchByName($search_term)
    {
        return Product::where('title', 'LIKE', "%{$search_term}%")->get();
    }

    public function fullSearch($search_term)
    {
        return Product::where('title', 'LIKE', "%{$search_term}%")
                      ->orWhere('code', 'LIKE', "%{$search_term}%")
                      ->get();
    }

    public function siblingsOf($product)
    {
        return $product->parents()->flatMap->products->reject(function ($related_product) use ($product) {
            return $related_product->id === $product->id;
        });
    }

    public function productsRelatedTo($product)
    {
        if (!$product instanceof Product) {
            $product = Product::where('slug', $product)->firstOrFail();
        }

        $relations = $this->siblingsOf($product)->filter(function ($sibling) {
            return $sibling->published;
        });


        $parents = $product->parents();

        while ($relations->count() < 4 && $parents->count() > 0) {
            $relations = $this->nextDegreeOfRelations($relations, $parents, $relations->merge(collect([$product])));
            $parents = $this->nextLevelOfParents($parents);
        }

        if ($relations->count() > 3) {
            return $relations->shuffle()->take(4);
        }

        return $relations->merge($this->fillerRelations(
            $relations->merge(collect([$product])),
            4 - $relations->count()
        ));
    }

    private function nextDegreeOfRelations($current_relations, $parents, $excludes)
    {
        return $current_relations->merge($this->otherDescendents(
            $parents,
            $excludes,
            (4 - $current_relations->count()
            )));
    }

    private function nextLevelOfParents($parents)
    {
        return $parents->map->parent()->reject(function ($grandparent) {
            return $grandparent === null;
        });
    }

    private function otherDescendents($stockables, $exclude, $count = 4)
    {

        return $stockables->flatMap(function (Stockable $stockable) {
            return $stockable->descendants();
        })->reject(function ($product) use ($exclude) {
            return in_array($product->id, $exclude->pluck('id')->all());
        })->filter(function ($product) {
            return $product->published;
        })->shuffle()->take($count);
    }

    private function fillerRelations($exclude, $count) {
        return Product::published()->whereNotIn('id',
            $exclude->pluck('id')->all())->get()->shuffle()->take($count);
    }
}