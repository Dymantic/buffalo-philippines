<?php


namespace Tests\Unit\Products;


use App\Products\Product;
use App\Products\Subcategory;
use App\Products\ToolGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubcategoriesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_subcategory_can_add_a_tool_group()
    {
        $subcategory = factory(Subcategory::class)->create();

        $subcategory->addToolGroup([
            'title'       => 'TEST TITLE',
            'description' => 'TEST DESCRIPTION'
        ]);

        $this->assertCount(1, $subcategory->fresh()->toolGroups);

        $this->assertEquals('TEST TITLE', $subcategory->fresh()->toolGroups->first()->title);
        $this->assertEquals('TEST DESCRIPTION', $subcategory->fresh()->toolGroups->first()->description);
    }

    /**
     * @test
     */
    public function a_subcategory_can_create_a_product()
    {
        $subcategory = factory(Subcategory::class)->create();

        $product = $subcategory->createProduct([
            'title'       => 'TEST TITLE',
            'code'        => 'TEST CODE',
            'description' => 'TEST DESCRIPTION',
            'price'       => 'TEST PRICE'
        ]);

        $this->assertEquals('TEST TITLE', $product->title);
        $this->assertEquals('TEST CODE', $product->code);
        $this->assertEquals('TEST DESCRIPTION', $product->description);
        $this->assertEquals('TEST PRICE', $product->price);

        $this->assertTrue($subcategory->fresh()->products->first()->is($product));
        $this->assertTrue($product->subcategories->first()->is($subcategory));
    }

    /**
     * @test
     */
    public function an_existing_product_can_be_added_to_a_subcategory()
    {
        $subcategory = factory(Subcategory::class)->create();
        $product = factory(Product::class)->create();

        $subcategory->addProduct($product);
        $this->assertCount(1, $subcategory->fresh()->products);
        $this->assertTrue($subcategory->fresh()->products->first()->is($product));
        $this->assertTrue($product->fresh()->subcategories->first()->is($subcategory));
    }

    /**
     * @test
     */
    public function deleting_a_subcategory_deletes_any_tool_groups_that_belong_to_it()
    {
        $subcategory = factory(Subcategory::class)->create();
        $tool_groups = factory(ToolGroup::class, 3)->create(['subcategory_id' => $subcategory->id]);
        $this->assertCount(3, $subcategory->fresh()->toolGroups);

        $subcategory->delete();

        $tool_groups->each(function ($tool_group) {
            $this->assertDatabaseMissing('tool_groups', ['id' => $tool_group->id]);
        });
    }

    /**
     * @test
     */
    public function a_subcategory_can_be_published()
    {
        $subcategory = factory(Subcategory::class)->create(['published' => false]);

        $subcategory->publish();

        $this->assertTrue($subcategory->fresh()->published);
    }

    /**
     * @test
     */
    public function a_subcategory_can_be_retracted()
    {
        $subcategory = factory(Subcategory::class)->create(['published' => true]);

        $subcategory->retract();

        $this->assertFalse($subcategory->fresh()->published);
    }

    /**
     * @test
     */
    public function a_subcategory_can_be_presented_as_a_jsonable_array()
    {
        $subcategory = factory(Subcategory::class)->create([
            'title'       => 'TEST TITLE',
            'description' => 'TEST DESCRIPTION',
            'published'   => true
        ]);

        $expected = [
            'id'          => $subcategory->id,
            'title'       => 'TEST TITLE',
            'slug'        => 'test-title',
            'description' => 'TEST DESCRIPTION',
            'published'   => true
        ];

        $this->assertEquals($expected, $subcategory->toJsonableArray());
    }
}