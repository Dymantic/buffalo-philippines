<?php


namespace Tests\Unit\Products;


use App\Products\Category;
use App\Products\Product;
use App\Products\Subcategory;
use App\Products\ToolGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockablesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_stockable_category_can_present_its_heritage()
    {
        $category = factory(Category::class)->create();

        $expected = [
            'id' => $category->id,
            'type' => 'Category',
            'title' => $category->title,
            'parent' => null
        ];

        $this->assertEquals($expected, $category->heritage());
    }

    /**
     *@test
     */
    public function a_stockable_subcategory_can_present_its_heritage()
    {
        $category = factory(Category::class)->create();
        $subcategory = factory(Subcategory::class)->create(['category_id' => $category->id]);

        $expected = [
            'id' => $subcategory->id,
            'type' => 'Subcategory',
            'title' => $subcategory->title,
            'parent' => [
                'id' => $category->id,
                'type' => 'Category',
                'title' => $category->title,
                'parent' => null
            ]
        ];

        $this->assertEquals($expected, $subcategory->heritage());
    }

    /**
     *@test
     */
    public function a_tool_group_can_present_its_heritage()
    {
        $category = factory(Category::class)->create();
        $subcategory = factory(Subcategory::class)->create(['category_id' => $category->id]);
        $toolgroup = factory(ToolGroup::class)->create(['subcategory_id' => $subcategory->id]);

        $expected = [
            'id' => $toolgroup->id,
            'type' => 'ToolGroup',
            'title' => $toolgroup->title,
            'parent' => [
                'id' => $subcategory->id,
                'type' => 'Subcategory',
                'title' => $subcategory->title,
                'parent' => [
                    'id' => $category->id,
                    'type' => 'Category',
                    'title' => $category->title,
                    'parent' => null
                ]
            ]
        ];

        $this->assertEquals($expected, $toolgroup->heritage());
    }

    /**
     *@test
     */
    public function a_product_can_be_removed_from_a_stockable()
    {
        $category = factory(Category::class)->create();
        $product = factory(Product::class)->create();
        $category->addProduct($product);
        $this->assertTrue($category->fresh()->products->contains($product));

        $category->removeProduct($product);

        $this->assertFalse($category->fresh()->products->contains($product));
    }

    /**
     *@test
     */
    public function deleting_a_stockable_also_deletes_any_associated_rows_in_stockable_pivot()
    {
        $category = factory(Category::class)->create();
        $product = factory(Product::class)->create();
        $category->addProduct($product);

        $category->delete();

        $this->assertDatabaseMissing('stockables', ['stockable_id' => $category->id]);
    }
}