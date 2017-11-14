<?php


namespace Tests\Feature\Products;


use App\Products\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublishProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_product_can_be_published()
    {
        $this->disableExceptionHandling();

        $product = factory(Product::class)->create(['published' => false]);

        $response = $this->asLoggedInUser()->json("POST", "/admin/published-products", [
            'product_id' => $product->id
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'id'        => $product->id,
            'published' => true
        ]);
    }

    /**
     *@test
     */
    public function the_product_id_is_required()
    {
        $response = $this->asLoggedInUser()->json("POST", "/admin/published-products", [
            'product_id' => ''
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('product_id', $response->decodeResponseJson()['errors']);
    }

    /**
     *@test
     */
    public function the_product_id_must_be_an_integer()
    {
        $response = $this->asLoggedInUser()->json("POST", "/admin/published-products", [
            'product_id' => 'NOT-AN-INTEGER'
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('product_id', $response->decodeResponseJson()['errors']);
    }

    /**
     *@test
     */
    public function the_product_id_must_exist_in_the_products_database()
    {
        $response = $this->asLoggedInUser()->json("POST", "/admin/published-products", [
            'product_id' => 999
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('product_id', $response->decodeResponseJson()['errors']);
    }

    /**
     *@test
     */
    public function a_published_product_may_be_retracted()
    {
        $this->disableExceptionHandling();

        $product = factory(Product::class)->create(['published' => true]);

        $response = $this->asLoggedInUser()->json("DELETE", "/admin/published-products/{$product->id}");
        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'id'        => $product->id,
            'published' => false
        ]);
    }
}