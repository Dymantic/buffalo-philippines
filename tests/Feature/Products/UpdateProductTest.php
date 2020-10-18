<?php


namespace Tests\Feature\Products;


use App\Products\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function an_existing_product_can_be_updated()
    {
        $this->disableExceptionHandling();

        $product = factory(Product::class)->create([
            'title'       => 'OLD TITLE',
            'code'        => 'OLD CODE',
            'description' => 'OLD DESCRIPTION',
            'price'       => 'OLD PRICE',
            'writeup'     => 'OLD WRITEUP'
        ]);

        $response = $this->asLoggedInUser()->json("POST", "/admin/products/{$product->id}", [
            'title'       => 'NEW TITLE',
            'code'        => 'NEW CODE',
            'description' => 'NEW DESCRIPTION',
            'price'       => 'NEW PRICE',
            'writeup'     => 'NEW WRITEUP'
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'title'       => 'NEW TITLE',
            'code'        => 'NEW CODE',
            'description' => 'NEW DESCRIPTION',
            'price'       => 'NEW PRICE',
            'writeup'     => 'NEW WRITEUP'
        ]);

    }

    /**
     *@test
     */
    public function successfully_updating_a_product_responds_with_the_updated_data()
    {
        $this->disableExceptionHandling();

        $product = factory(Product::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/products/{$product->id}", [
            'title'       => 'NEW TITLE',
            'code'        => 'NEW CODE',
            'description' => 'NEW DESCRIPTION',
            'price'       => 'NEW PRICE',
            'writeup'     => 'NEW WRITEUP'
        ]);
        $response->assertStatus(200);

        $this->assertEquals($product->fresh()->toJsonableArray(), $response->json());
    }

    /**
     *@test
     */
    public function the_title_of_the_product_is_still_required()
    {
        $product = factory(Product::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/products/{$product->id}", [
            'title'       => '',
            'code'        => 'NEW CODE',
            'description' => 'NEW DESCRIPTION',
            'price'       => 'NEW PRICE',
            'writeup'     => 'NEW WRITEUP'
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('title', $response->json()['errors']);
    }

    /**
     *@test
     */
    public function the_title_cannot_exceed_255_characters()
    {
        $product = factory(Product::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/products/{$product->id}", [
            'title'       => str_repeat('X', 256),
            'code'        => 'NEW CODE',
            'description' => 'NEW DESCRIPTION',
            'price'       => 'NEW PRICE',
            'writeup'     => 'NEW WRITEUP'
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('title', $response->json()['errors']);
    }

    /**
     *@test
     */
    public function the_product_code_is_still_required()
    {
        $product = factory(Product::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/products/{$product->id}", [
            'title'       => 'TEST TITLE',
            'code'        => '',
            'description' => 'NEW DESCRIPTION',
            'price'       => 'NEW PRICE',
            'writeup'     => 'NEW WRITEUP'
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('code', $response->json()['errors']);
    }

    /**
     *@test
     */
    public function the_product_code_cannot_be_more_than_255_characters()
    {
        $product = factory(Product::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/products/{$product->id}", [
            'title'       => 'TEST TITLE',
            'code'        => str_repeat('X', 256),
            'description' => 'NEW DESCRIPTION',
            'price'       => 'NEW PRICE',
            'writeup'     => 'NEW WRITEUP'
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('code', $response->json()['errors']);
    }

    /**
     *@test
     */
    public function the_price_cannot_exceed_255_characters()
    {
        $product = factory(Product::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/products/{$product->id}", [
            'title'       => 'TEST TITLE',
            'code'        => 'TEST CODE',
            'description' => 'NEW DESCRIPTION',
            'price'       => str_repeat('X', 256),
            'writeup'     => 'NEW WRITEUP'
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('price', $response->json()['errors']);
    }

    /**
     *@test
     */
    public function the_product_can_be_updated_with_an_empty_description()
    {
        $this->disableExceptionHandling();

        $product = factory(Product::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/products/{$product->id}", [
            'title'       => 'NEW TITLE',
            'code'        => 'NEW CODE',
            'description' => '',
            'price'       => 'NEW PRICE',
            'writeup'     => 'NEW WRITEUP'
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'title'       => 'NEW TITLE',
            'code'        => 'NEW CODE',
            'description' => null,
            'price'       => 'NEW PRICE',
            'writeup'     => 'NEW WRITEUP'
        ]);
    }

    /**
     *@test
     */
    public function a_product_can_be_updated_with_an_empty_price()
    {
        $this->disableExceptionHandling();

        $product = factory(Product::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/products/{$product->id}", [
            'title'       => 'NEW TITLE',
            'code'        => 'NEW CODE',
            'description' => 'TEST DESCRIPTION',
            'price'       => '',
            'writeup'     => 'NEW WRITEUP'
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'title'       => 'NEW TITLE',
            'code'        => 'NEW CODE',
            'description' => 'TEST DESCRIPTION',
            'price'       => null,
            'writeup'     => 'NEW WRITEUP'
        ]);
    }

    /**
     *@test
     */
    public function a_product_can_be_updated_with_an_empty_writeup()
    {
        $this->disableExceptionHandling();

        $product = factory(Product::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/products/{$product->id}", [
            'title'       => 'NEW TITLE',
            'code'        => 'NEW CODE',
            'description' => 'TEST DESCRIPTION',
            'price'       => 'TEST PRICE',
            'writeup'     => ''
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'title'       => 'NEW TITLE',
            'code'        => 'NEW CODE',
            'description' => 'TEST DESCRIPTION',
            'price'       => 'TEST PRICE',
            'writeup'     => null
        ]);
    }
}