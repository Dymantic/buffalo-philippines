<?php


namespace Tests\Feature\Products;


use App\Products\Category;
use App\Products\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class CreateProductInCategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_product_can_be_created_for_a_category()
    {
        $this->disableExceptionHandling();

        $category = factory(Category::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/categories/{$category->id}/products", [
            'title'       => 'TEST TITLE',
            'code'        => 'TEST CODE',
            'description' => 'TEST DESCRIPTION',
            'price'       => 'TEST PRICE',
            'writeup'     => 'TEST WRITEUP'
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'title'       => 'TEST TITLE',
            'code'        => 'TEST CODE',
            'description' => 'TEST DESCRIPTION',
            'price'       => 'TEST PRICE',
            'writeup'     => 'TEST WRITEUP',
            'new_until'   => Carbon::today()->addMonth()->format('Y-m-d H:i:s')
        ]);
        $this->assertCount(1, Product::all());
        $product = Product::first();

        $this->assertDatabaseHas('stockables', [
            'product_id'     => $product->id,
            'stockable_id'   => $category->id,
            'stockable_type' => Category::class
        ]);
    }

    /**
     * @test
     */
    public function the_newly_created_product_has_a_slug()
    {
        $this->disableExceptionHandling();

        $category = factory(Category::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/categories/{$category->id}/products", [
            'title'       => 'TEST TITLE',
            'code'        => 'TEST CODE',
            'description' => 'TEST DESCRIPTION',
            'price'       => 'TEST PRICE',
            'writeup'     => 'TEST WRITEUP'
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'title'       => 'TEST TITLE',
            'slug'        => 'test-title',
            'code'        => 'TEST CODE',
            'description' => 'TEST DESCRIPTION',
            'price'       => 'TEST PRICE',
            'writeup'     => 'TEST WRITEUP'
        ]);
    }

    /**
     * @test
     */
    public function the_products_title_is_required()
    {
        $category = factory(Category::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/categories/{$category->id}/products", [
            'title'       => '',
            'code'        => 'TEST CODE',
            'description' => 'TEST DESCRIPTION',
            'price'       => 'TEST PRICE',
            'writeup'     => 'TEST WRITEUP'
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('title', $response->decodeResponseJson()['errors']);
    }

    /**
     * @test
     */
    public function the_title_of_the_product_should_not_exceed_255_characters()
    {
        $category = factory(Category::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/categories/{$category->id}/products", [
            'title'       => str_repeat('X', 256),
            'code'        => 'TEST CODE',
            'description' => 'TEST DESCRIPTION',
            'price'       => 'TEST PRICE',
            'writeup'     => 'TEST WRITEUP'
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('title', $response->decodeResponseJson()['errors']);
    }

    /**
     * @test
     */
    public function the_product_code_is_required()
    {
        $category = factory(Category::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/categories/{$category->id}/products", [
            'title'       => 'TEST TITLE',
            'code'        => '',
            'description' => 'TEST DESCRIPTION',
            'price'       => 'TEST PRICE',
            'writeup'     => 'TEST WRITEUP'
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('code', $response->decodeResponseJson()['errors']);
    }

    /**
     * @test
     */
    public function the_product_code_should_not_exceed_255_characters()
    {
        $category = factory(Category::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/categories/{$category->id}/products", [
            'title'       => 'TEST TITLE',
            'code'        => str_repeat('X', 256),
            'description' => 'TEST DESCRIPTION',
            'price'       => 'TEST PRICE',
            'writeup'     => 'TEST WRITEUP'
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('code', $response->decodeResponseJson()['errors']);
    }

    /**
     * @test
     */
    public function a_product_can_be_added_with_an_empty_description()
    {
        $this->disableExceptionHandling();

        $category = factory(Category::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/categories/{$category->id}/products", [
            'title'       => 'TEST TITLE',
            'code'        => 'TEST CODE',
            'description' => '',
            'price'       => 'TEST PRICE',
            'writeup'     => 'TEST WRITEUP'
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'title'       => 'TEST TITLE',
            'code'        => 'TEST CODE',
            'description' => null,
            'price'       => 'TEST PRICE',
            'writeup'     => 'TEST WRITEUP'
        ]);
    }

    /**
     * @test
     */
    public function a_product_can_be_created_with_an_empty_price()
    {
        $this->disableExceptionHandling();

        $category = factory(Category::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/categories/{$category->id}/products", [
            'title'       => 'TEST TITLE',
            'code'        => 'TEST CODE',
            'description' => 'TEST DESCRIPTION',
            'price'       => '',
            'writeup'     => 'TEST WRITEUP'
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'title'       => 'TEST TITLE',
            'code'        => 'TEST CODE',
            'description' => 'TEST DESCRIPTION',
            'price'       => null,
            'writeup'     => 'TEST WRITEUP'
        ]);
    }

    /**
     * @test
     */
    public function a_product_can_be_created_with_an_empty_writeup()
    {
        $this->disableExceptionHandling();

        $category = factory(Category::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/categories/{$category->id}/products", [
            'title'       => 'TEST TITLE',
            'code'        => 'TEST CODE',
            'description' => 'TEST DESCRIPTION',
            'price'       => 'TEST PRICE',
            'writeup'     => ''
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'title'       => 'TEST TITLE',
            'code'        => 'TEST CODE',
            'description' => 'TEST DESCRIPTION',
            'price'       => 'TEST PRICE',
            'writeup'     => null
        ]);
    }

    /**
     * @test
     */
    public function the_products_price_must_not_exceed_255_characters()
    {
        $category = factory(Category::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/categories/{$category->id}/products", [
            'title'       => 'TEST TITLE',
            'code'        => 'TEST CODE',
            'description' => 'TEST DESCRIPTION',
            'price'       => str_repeat('X', 256),
            'writeup'     => 'TEST WRITEUP'
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('price', $response->decodeResponseJson()['errors']);
    }
}