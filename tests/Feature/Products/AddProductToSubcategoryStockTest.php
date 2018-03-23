<?php


namespace Tests\Feature\Products;


use App\Products\Product;
use App\Products\Subcategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddProductToSubcategoryStockTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_product_may_be_added_to_an_existing_subcategory()
    {
        $this->disableExceptionHandling();

        $product = factory(Product::class)->create();
        $subcategory = factory(Subcategory::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/stockables/subcategories/{$subcategory->id}", [
            'product_id' => $product->id
        ]);
        $response->assertStatus(200);

        $this->assertTrue($subcategory->fresh()->products->contains($product));
    }

    /**
     *@test
     */
    public function successfully_adding_a_product_to_the_subcategory_responds_with_fresh_product_data()
    {
        $this->disableExceptionHandling();

        $product = factory(Product::class)->create();
        $subcategory = factory(Subcategory::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/stockables/subcategories/{$subcategory->id}", [
            'product_id' => $product->id
        ]);
        $response->assertStatus(200);

        $this->assertEquals($product->fresh()->toJsonableArray(), $response->decodeResponseJson());

        $this->assertTrue($subcategory->fresh()->products->contains($product));
    }

    /**
     *@test
     */
    public function the_product_id_is_required()
    {
        $subcategory = factory(Subcategory::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/stockables/subcategories/{$subcategory->id}", [
            'product_id' => null
        ]);
        $response->assertStatus(422);
    }

    /**
     *@test
     */
    public function the_product_id_must_be_for_an_existing_product()
    {
        $subcategory = factory(Subcategory::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/stockables/subcategories/{$subcategory->id}", [
            'product_id' => 99
        ]);
        $response->assertStatus(422);
    }
}