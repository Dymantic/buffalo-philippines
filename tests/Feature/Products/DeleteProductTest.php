<?php


namespace Tests\Feature\Products;


use App\Products\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_product_can_be_deleted()
    {
        $this->disableExceptionHandling();

        $product = factory(Product::class)->create();

        $response = $this->asLoggedInUser()->json("DELETE", "/admin/products/{$product->id}");
        $response->assertStatus(302);

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}