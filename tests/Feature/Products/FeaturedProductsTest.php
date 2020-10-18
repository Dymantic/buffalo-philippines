<?php


namespace Tests\Feature\Products;


use App\Products\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeaturedProductsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_product_may_be_featured()
    {
        $this->disableExceptionHandling();

        $product = factory(Product::class)->create(['featured' => false]);

        $response = $this->asLoggedInUser()->json("POST", "/admin/featured-products", [
            'product_id' => $product->id
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'id'       => $product->id,
            'featured' => true
        ]);
    }

    /**
     *@test
     */
    public function the_product_id_is_required()
    {
        $response = $this->asLoggedInUser()->json("POST", "/admin/featured-products", [
            'product_id' => ''
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('product_id', $response->json()['errors']);
    }

    /**
     *@test
     */
    public function the_product_id_must_be_an_integer()
    {
        $response = $this->asLoggedInUser()->json("POST", "/admin/featured-products", [
            'product_id' => 'NOT-AN-INTEGER'
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('product_id', $response->json()['errors']);
    }

    /**
     *@test
     */
    public function the_product_id_must_exist_in_the_products_table()
    {
        $response = $this->asLoggedInUser()->json("POST", "/admin/featured-products", [
            'product_id' => 999
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('product_id', $response->json()['errors']);
    }

    /**
     *@test
     */
    public function a_featured_product_may_be_demoted()
    {
        $this->disableExceptionHandling();

        $product = factory(Product::class)->create(['featured' => true]);

        $response = $this->asLoggedInUser()->json("DELETE", "/admin/featured-products/{$product->id}");
        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'id'       => $product->id,
            'featured' => false
        ]);
    }
}