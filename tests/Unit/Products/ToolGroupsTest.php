<?php


namespace Tests\Unit\Products;


use App\Products\Product;
use App\Products\ToolGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ToolGroupsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_product_can_be_created_for_a_tool_group()
    {
        $tool_group = factory(ToolGroup::class)->create();

        $product = $tool_group->createProduct([
            'title'       => 'TEST TITLE',
            'code'        => 'TEST CODE',
            'description' => 'TEST DESCRIPTION',
            'price'       => 'TEST PRICE'
        ]);

        $this->assertEquals('TEST TITLE', $product->title);
        $this->assertEquals('TEST CODE', $product->code);
        $this->assertEquals('TEST DESCRIPTION', $product->description);
        $this->assertEquals('TEST PRICE', $product->price);

        $this->assertTrue($tool_group->fresh()->products->first()->is($product));
        $this->assertTrue($product->toolGroups->first()->is($tool_group));
    }

    /**
     * @test
     */
    public function an_existing_product_can_be_added_to_a_tool_group()
    {
        $tool_group = factory(ToolGroup::class)->create();
        $product = factory(Product::class)->create();

        $tool_group->addProduct($product);
        $this->assertCount(1, $tool_group->fresh()->products);
        $this->assertTrue($tool_group->fresh()->products->first()->is($product));
        $this->assertTrue($product->fresh()->toolGroups->first()->is($tool_group));
    }

    /**
     * @test
     */
    public function a_tool_group_can_be_published()
    {
        $tool_group = factory(ToolGroup::class)->create(['published' => false]);

        $tool_group->publish();

        $this->assertTrue($tool_group->fresh()->published);
    }

    /**
     * @test
     */
    public function a_tool_group_can_be_retracted()
    {
        $tool_group = factory(ToolGroup::class)->create(['published' => true]);

        $tool_group->retract();

        $this->assertFalse($tool_group->fresh()->published);
    }

    /**
     * @test
     */
    public function a_tool_group_can_be_presented_as_a_jsonable_array()
    {
        $tool_group = factory(ToolGroup::class)->create([
            'title'       => 'TEST TITLE',
            'description' => 'TEST DESCRIPTION',
            'published'   => true
        ]);

        $expected = [
            'id'          => $tool_group->id,
            'title'       => 'TEST TITLE',
            'slug'        => 'test-title',
            'description' => 'TEST DESCRIPTION',
            'published'   => true
        ];

        $this->assertEquals($expected, $tool_group->toJsonableArray());
    }
}