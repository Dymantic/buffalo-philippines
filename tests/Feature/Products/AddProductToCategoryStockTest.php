<?php


namespace Tests\Feature\Products;


use App\Products\Category;
use App\Products\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddProductToCategoryStockTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_product_may_be_added_to_an_existing_category()
    {
        $this->disableExceptionHandling();
        $category = factory(Category::class)->create();
        $product = factory(Product::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/stockables/categories/{$category->id}", [
            'product_id' => $product->id
        ]);
        $response->assertStatus(200);

        $this->assertTrue($category->fresh()->products->contains($product));
    }

    /**
     *@test
     */
    public function the_product_id_is_required()
    {
        $category = factory(Category::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/stockables/categories/{$category->id}", [
            'product_id' => ''
        ]);
        $response->assertStatus(422);
    }

    /**
     *@test
     */
    public function the_product_id_must_be_an_existing_product_id_in_the_db()
    {
        $category = factory(Category::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/stockables/categories/{$category->id}", [
            'product_id' => 99
        ]);
        $response->assertStatus(422);
    }
}