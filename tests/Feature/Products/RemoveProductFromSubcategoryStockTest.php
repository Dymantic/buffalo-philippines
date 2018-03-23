<?php


namespace Tests\Feature\Products;


use App\Products\Product;
use App\Products\Subcategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RemoveProductFromSubcategoryStockTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_product_can_be_removed_from_a_subcategory()
    {
        $this->disableExceptionHandling();

        $subcategory = factory(Subcategory::class)->create();
        $product = factory(Product::class)->create();
        $subcategory->addProduct($product);

        $delete_url = "/admin/stockables/subcategories/{$subcategory->id}/products/{$product->id}";
        $response = $this->asLoggedInUser()->json("DELETE", $delete_url);
        $response->assertStatus(200);

        $this->assertFalse($subcategory->fresh()->products->contains($product));
    }

    /**
     *@test
     */
    public function successfully_removing_a_product_from_a_subcategory_responds_with_the_fresh_product()
    {
        $this->disableExceptionHandling();

        $subcategory = factory(Subcategory::class)->create();
        $product = factory(Product::class)->create();
        $subcategory->addProduct($product);

        $delete_url = "/admin/stockables/subcategories/{$subcategory->id}/products/{$product->id}";
        $response = $this->asLoggedInUser()->json("DELETE", $delete_url);
        $response->assertStatus(200);

        $this->assertEquals($product->fresh()->toJsonableArray(), $response->decodeResponseJson());
    }
}