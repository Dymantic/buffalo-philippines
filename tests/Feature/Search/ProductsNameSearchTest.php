<?php

namespace Tests\Feature\Search;

use App\Products\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductsNameSearchTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function products_can_be_searched_for_by_name()
    {
        $this->disableExceptionHandling();

        $matching_product = factory(Product::class)->create(['title' => 'MATCHING PRODUCT', 'published' => true]);
        $non_matching_product = factory(Product::class)->create(['title' => 'ANOTHER PRODUCT', 'published' => true]);

        $response = $this->get("/search/products?q=matching");
        $response->assertStatus(200);

        $data = $response->baseResponse->original->getData();

        $this->assertCount(1, $data['products']);
        $this->assertTrue($data['products']->contains($matching_product));

        $this->assertEquals('matching', $data['search_term']);
    }

    /**
     *@test
     */
    public function products_can_be_searched_for_by_product_code()
    {
        $this->disableExceptionHandling();

        $matching_product = factory(Product::class)->create(['code' => 'XX-MATCH-123', 'published' => true]);
        $non_matching_product = factory(Product::class)->create(['code' => 'XX-NO-MATCH', 'published' => true]);

        $response = $this->get("/search/products?q=XX-MATCH-123");
        $response->assertStatus(200);

        $data = $response->baseResponse->original->getData();

        $this->assertCount(1, $data['products']);
        $this->assertTrue($data['products']->contains($matching_product));

        $this->assertEquals('XX-MATCH-123', $data['search_term']);
    }
    
    /**
     *@test
     */
    public function unpublished_products_are_not_returned_with_search_results()
    {
        $this->disableExceptionHandling();

        $matching_product = factory(Product::class)->create(['title' => 'MATCHING PRODUCT', 'published' => true]);
        $unpublished_match = factory(Product::class)->create(['title' => 'MATCHING PRODUCT', 'published' => false]);
        $non_matching_product = factory(Product::class)->create(['title' => 'ANOTHER PRODUCT', 'published' => true]);

        $response = $this->get("/search/products?q=matching");
        $response->assertStatus(200);

        $data = $response->baseResponse->original->getData();

        $this->assertCount(1, $data['products']);
        $this->assertTrue($data['products']->contains($matching_product));
    }
}