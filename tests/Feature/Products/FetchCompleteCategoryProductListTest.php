<?php


namespace Tests\Feature\Products;


use App\Products\Category;
use App\Products\Product;
use App\Products\Subcategory;
use App\Products\ToolGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FetchCompleteCategoryProductListTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function all_products_the_belong_to_a_category_or_its_children_can_be_fetched()
    {
        $this->disableExceptionHandling();

        $category = factory(Category::class)->create();
        $subcategory = factory(Subcategory::class)->create(['category_id' => $category->id]);
        $tool_group = factory(ToolGroup::class)->create(['subcategory_id' => $subcategory->id]);

        $productA = $category->addProduct(factory(Product::class)->create());
        $productB = $subcategory->addProduct(factory(Product::class)->create());
        $productC = $subcategory->addProduct(factory(Product::class)->create());
        $productD = $tool_group->addProduct(factory(Product::class)->create());
        $productE = $tool_group->addProduct(factory(Product::class)->create());

        $response = $this->json("GET", "/services/categories/{$category->slug}/products");
        $response->assertStatus(200);

        $fetched_products = $response->decodeResponseJson();

        $this->assertCount(5, $fetched_products);

        $this->assertContains($productA->toJsonableArray(), $fetched_products);
        $this->assertContains($productB->toJsonableArray(), $fetched_products);
        $this->assertContains($productC->toJsonableArray(), $fetched_products);
        $this->assertContains($productD->toJsonableArray(), $fetched_products);
        $this->assertContains($productE->toJsonableArray(), $fetched_products);
    }
}