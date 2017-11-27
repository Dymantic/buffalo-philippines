<?php


namespace Tests\Feature\Products;


use App\Products\Product;
use App\Products\ToolGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FetchRelatedProductsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function related_products_for_a_product_can_be_fetched()
    {
        $this->disableExceptionHandling();

        $tool_group = factory(ToolGroup::class)->create();
        $product = factory(Product::class)->create(['published' => true]);
        $related_products = factory(Product::class, 4)->create(['published' => true]);
        $unrelated_products = factory(Product::class, 3)->create(['published' => true]);

        //product and relations are in same tool group (closest form of relation)
        $tool_group->addProduct($product);
        $related_products->each(function($product) use ($tool_group) {
           $tool_group->addProduct($product);
        });

        $response = $this->json('GET', "/services/products/{$product->slug}/related-products");
        $response->assertStatus(200);

        $fetched_products = $response->decodeResponseJson();

        $this->assertCount(4, $fetched_products);

        $related_products->each(function($product) use ($fetched_products) {
           $this->assertContains($product->toJsonableArray(), $fetched_products);
        });
    }
}