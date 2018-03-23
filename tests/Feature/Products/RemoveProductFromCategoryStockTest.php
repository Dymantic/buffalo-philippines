<?php


namespace Tests\Feature\Products;


use App\Products\Category;
use App\Products\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RemoveProductFromCategoryStockTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_product_can_be_removed_from_a_category()
    {
        $this->disableExceptionHandling();

        $category = factory(Category::class)->create();
        $product = factory(Product::class)->create();
        $category->addProduct($product);

        $delete_url = "/admin/stockables/categories/{$category->id}/products/{$product->id}";
        $response = $this->asLoggedInUser()->json("DELETE", $delete_url);
        $response->assertStatus(200);

        $this->assertFalse($category->fresh()->products->contains($product));
    }

    /**
     *@test
     */
    public function successfully_removing_a_product_from_the_category_responds_with_the_fresh_product()
    {
        $this->disableExceptionHandling();

        $category = factory(Category::class)->create();
        $product = factory(Product::class)->create();
        $category->addProduct($product);

        $delete_url = "/admin/stockables/categories/{$category->id}/products/{$product->id}";
        $response = $this->asLoggedInUser()->json("DELETE", $delete_url);
        $response->assertStatus(200);

        $this->assertEquals($product->fresh()->toJsonableArray(), $response->decodeResponseJson());
    }
}