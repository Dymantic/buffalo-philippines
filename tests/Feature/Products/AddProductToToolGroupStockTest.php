<?php


namespace Tests\Feature\Products;


use App\Products\Product;
use App\Products\ToolGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddProductToToolGroupStockTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_product_can_be_added_to_an_existing_toolgroup()
    {
        $this->disableExceptionHandling();
        $product = factory(Product::class)->create();
        $toolgroup = factory(ToolGroup::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/stockables/tool-groups/{$toolgroup->id}", [
            'product_id' => $product->id
        ]);
        $response->assertStatus(200);

        $this->assertTrue($toolgroup->fresh()->products->contains($product));
    }

    /**
     *@test
     */
    public function the_product_id_is_required()
    {
        $toolgroup = factory(ToolGroup::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/stockables/tool-groups/{$toolgroup->id}", [
            'product_id' => ''
        ]);
        $response->assertStatus(422);
    }

    /**
     *@test
     */
    public function the_product_id_must_be_for_an_existing_product()
    {
        $toolgroup = factory(ToolGroup::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/stockables/tool-groups/{$toolgroup->id}", [
            'product_id' => 99
        ]);
        $response->assertStatus(422);
    }
}