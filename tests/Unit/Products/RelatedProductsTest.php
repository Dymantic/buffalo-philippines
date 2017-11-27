<?php


namespace Tests\Unit\Products;


use App\Products\Product;
use App\Products\ProductsRepository;
use App\Products\Subcategory;
use App\Products\ToolGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RelatedProductsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function if_a_products_has_less_than_four_siblings_next_closest_relations_will_be_used()
    {
        $subcategory = factory(Subcategory::class)->create();
        $tool_groupA = factory(ToolGroup::class)->create(['subcategory_id' => $subcategory->id]);
        $tool_groupB = factory(ToolGroup::class)->create(['subcategory_id' => $subcategory->id]);

        $product = $tool_groupA->addProduct(factory(Product::class)->create(['published' => true]));
        $sibling = $tool_groupA->addProduct(factory(Product::class)->create(['published' => true]));

        $relationA = $subcategory->addProduct(factory(Product::class)->create(['published' => true]));
        $relationB = $tool_groupB->addProduct(factory(Product::class)->create(['published' => true]));
        $relationC = $tool_groupB->addProduct(factory(Product::class)->create(['published' => true]));

        $not_related = factory(Product::class)->create();

        $fetched_relations = app()->make(ProductsRepository::class)->productsRelatedTo($product);

        $this->assertCount(4, $fetched_relations);

        $this->assertContains($sibling->id, $fetched_relations->pluck('id')->all());
        $this->assertContains($relationA->id, $fetched_relations->pluck('id')->all());
        $this->assertContains($relationB->id, $fetched_relations->pluck('id')->all());
        $this->assertContains($relationC->id, $fetched_relations->pluck('id')->all());
    }

    /**
     *@test
     */
    public function a_product_with_no_clear_relations_will_have_its_related_products_filled_out_with_random_products()
    {
        $subcategory = factory(Subcategory::class)->create();
        $tool_groupA = factory(ToolGroup::class)->create(['subcategory_id' => $subcategory->id]);
        $tool_groupB = factory(ToolGroup::class)->create(['subcategory_id' => $subcategory->id]);

        $product = $tool_groupA->addProduct(factory(Product::class)->create(['published' => true]));
        $sibling = $tool_groupA->addProduct(factory(Product::class)->create(['published' => true]));
        $relationA = $subcategory->addProduct(factory(Product::class)->create(['published' => true]));
        factory(Product::class, 5)->create(['published' => true]);

        $fetched_relations = app()->make(ProductsRepository::class)->productsRelatedTo($product);

        $this->assertCount(4, $fetched_relations);

        $this->assertContains($sibling->id, $fetched_relations->pluck('id')->all());
        $this->assertContains($relationA->id, $fetched_relations->pluck('id')->all());
    }
}