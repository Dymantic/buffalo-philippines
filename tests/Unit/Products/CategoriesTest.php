<?php

namespace Tests\Unit\Products;

use App\Products\Category;
use App\Products\Product;
use App\Products\Subcategory;
use App\Products\ToolGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoriesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_subcategory_can_be_added_to_a_category()
    {
        $category = factory(Category::class)->create();

        $category->addSubcategory([
            'title'       => 'TEST TITLE',
            'description' => 'TEST DESCRIPTION'
        ]);

        $this->assertCount(1, $category->fresh()->subcategories);

        $this->assertEquals('TEST TITLE', $category->fresh()->subcategories->first()->title);
        $this->assertEquals('TEST DESCRIPTION', $category->fresh()->subcategories->first()->description);
    }

    /**
     *@test
     */
    public function a_product_can_be_created_for_a_category()
    {
        $category = factory(Category::class)->create();

        $product = $category->createProduct([
            'title'       => 'TEST TITLE',
            'code'        => 'TEST CODE',
            'description' => 'TEST DESCRIPTION',
            'price'       => 'TEST PRICE'
        ]);

        $this->assertCount(1, $category->fresh()->products);

        $this->assertEquals('TEST TITLE', $product->title);
        $this->assertEquals('TEST CODE', $product->code);
        $this->assertEquals('TEST DESCRIPTION', $product->description);
        $this->assertEquals('TEST PRICE', $product->price);

        $this->assertTrue($product->categories->first()->is($category));
    }

    /**
     *@test
     */
    public function an_existing_product_can_be_added_to_a_category()
    {
        $category = factory(Category::class)->create();
        $product = factory(Product::class)->create();

        $category->addProduct($product);
        $this->assertCount(1, $category->fresh()->products);
        $this->assertTrue($category->fresh()->products->first()->is($product));
        $this->assertTrue($product->fresh()->categories->first()->is($category));
    }

    /**
     *@test
     */
    public function deleting_a_category_deletes_all_its_subcategories_and_tool_groups()
    {
        $category = factory(Category::class)->create();
        $subcategories = factory(Subcategory::class, 2)->create(['category_id' => $category->id]);
        $subcategories->each(function($subcategory) {
            factory(ToolGroup::class, 2)->create(['subcategory_id' => $subcategory->id]);
        });

        $this->assertCount(2, Subcategory::all());
        $this->assertCount(4, ToolGroup::all());

        $category->delete();

        $this->assertCount(0, Subcategory::all());
        $this->assertCount(0, ToolGroup::all());
    }

    /**
     *@test
     */
    public function a_category_can_be_published()
    {
        $category = factory(Category::class)->create(['published' => false]);

        $category->publish();

        $this->assertTrue($category->fresh()->published);
    }

    /**
     *@test
     */
    public function a_category_may_be_retracted()
    {
        $category = factory(Category::class)->create(['published' => true]);

        $category->retract();

        $this->assertFalse($category->fresh()->published);
    }

    /**
     *@test
     */
    public function a_category_can_be_presented_as_a_jsonable_array()
    {
        $category = factory(Category::class)->create([
            'title' => 'TEST CATEGORY TITLE',
            'description' => 'TEST CATEGORY DESCRIPTION'
        ]);

        $expected = [
            'id' => $category->id,
            'title' => 'TEST CATEGORY TITLE',
            'description' => 'TEST CATEGORY DESCRIPTION'
        ];

        $this->assertEquals($expected, $category->toJsonableArray());
    }
}