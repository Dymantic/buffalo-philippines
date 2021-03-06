<?php


namespace Tests\Feature\Products;


use App\Products\Category;
use App\Products\Product;
use App\Products\Subcategory;
use App\Products\ToolGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListProductsServiceTest extends TestCase
{
    use RefreshDatabase;



    /**
     *@test
     */
    public function a_paginated_list_of_subcategory_products_can_be_fetched()
    {
        $this->disableExceptionHandling();

        $subcategory = factory(Subcategory::class)->create();
        $products = factory(Product::class, 50)->create();
        $products->each(function($product) use ($subcategory) {
            $subcategory->addProduct($product);
        });

        $response = $this->asLoggedInUser()
                         ->json("GET", "/admin/services/subcategories/{$subcategory->id}/products");
        $response->assertStatus(200);

        $response_data = $response->json();
        $listed_products = collect($response_data['products']);

        $this->assertCount(40, $response_data['products']);
        $this->assertEquals(2, $response_data['total_pages']);
        $this->assertEquals(1, $response_data['current_page']);

        $products->take(40)->each(function($product) use ($listed_products) {
            $this->assertEquals($product->toJsonableArray(), $listed_products->first(fn ($item) => $item['id'] == $product->id));
        });
    }

    /**
     *@test
     */
    public function a_paginated_list_of_tool_group_products_can_be_fetched()
    {
        $this->disableExceptionHandling();

        $tool_group = factory(ToolGroup::class)->create();
        $products = factory(Product::class, 50)->create();
        $products->each(function($product) use ($tool_group) {
            $tool_group->addProduct($product);
        });

        $response = $this->asLoggedInUser()
                         ->json("GET", "/admin/services/tool-groups/{$tool_group->id}/products");
        $response->assertStatus(200);

        $response_data = $response->json();
        $listed_products = collect($response_data['products']);

        $this->assertCount(40, $response_data['products']);
        $this->assertEquals(2, $response_data['total_pages']);
        $this->assertEquals(1, $response_data['current_page']);

        $products->take(40)->each(function($product) use ($listed_products) {
            $this->assertEquals($product->toJsonableArray(), $listed_products->first(fn ($item) => $item['id'] == $product->id));
        });
    }
}