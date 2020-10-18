<?php


namespace Tests\Feature\Products;


use App\Products\Product;
use App\Products\ToolGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RemoveProductFromToolGroupStockTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_product_can_be_removed_from_a_tool_group()
    {
        $this->disableExceptionHandling();

        $toolgroup = factory(ToolGroup::class)->create();
        $product = factory(Product::class)->create();
        $toolgroup->addProduct($product);

        $delete_url = "/admin/stockables/tool-groups/{$toolgroup->id}/products/{$product->id}";
        $response = $this->asLoggedInUser()->json("DELETE", $delete_url);
        $response->assertStatus(200);

        $this->assertFalse($toolgroup->fresh()->products->contains($product));
    }

    /**
     *@test
     */
    public function successfully_removing_a_product_from_a_tool_group_responds_with_fresh_product_data()
    {
        $this->disableExceptionHandling();

        $toolgroup = factory(ToolGroup::class)->create();
        $product = factory(Product::class)->create();
        $toolgroup->addProduct($product);

        $delete_url = "/admin/stockables/tool-groups/{$toolgroup->id}/products/{$product->id}";
        $response = $this->asLoggedInUser()->json("DELETE", $delete_url);
        $response->assertStatus(200);

        $this->assertEquals($product->fresh()->toJsonableArray(), $response->json());
    }
}