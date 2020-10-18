<?php


namespace Tests\Feature\Products;


use App\Products\Category;
use App\Products\Product;
use App\Products\Subcategory;
use App\Products\ToolGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FetchAllCategoryProductsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function products_from_a_category_can_be_fetched()
    {
        $this->disableExceptionHandling();

        $category = factory(Category::class)->create();
        $subcategory = factory(Subcategory::class)->create(['category_id' => $category->id]);
        $tool_group = factory(ToolGroup::class)->create(['subcategory_id' => $subcategory->id]);

        $productA = $category->addProduct(factory(Product::class)->create(['published' => true]));
        $productB = $subcategory->addProduct(factory(Product::class)->create(['published' => true]));
        $productC = $subcategory->addProduct(factory(Product::class)->create(['published' => true]));
        $productD = $tool_group->addProduct(factory(Product::class)->create(['published' => true]));
        $productE = $tool_group->addProduct(factory(Product::class)->create(['published' => true]));

        $response = $this->asLoggedInUser()->json("GET", "/admin/services/categories/{$category->id}/products");
        $response->assertStatus(200);

        $fetched_products = $response->json();

        $this->assertCount(5, $fetched_products);

        $this->assertContains($productA->toJsonableArray(), $fetched_products);
        $this->assertContains($productB->toJsonableArray(), $fetched_products);
        $this->assertContains($productC->toJsonableArray(), $fetched_products);
        $this->assertContains($productD->toJsonableArray(), $fetched_products);
        $this->assertContains($productE->toJsonableArray(), $fetched_products);
    }

    /**
     *@test
     */
    public function unpublished_products_are_included_in_the_fetched_results()
    {
        $this->disableExceptionHandling();

        $category = factory(Category::class)->create();
        $subcategory = factory(Subcategory::class)->create(['category_id' => $category->id]);
        $tool_group = factory(ToolGroup::class)->create(['subcategory_id' => $subcategory->id]);

        $productA = $tool_group->addProduct(factory(Product::class)->create(['published' => false]));

        $response = $this->asLoggedInUser()->json("GET", "/admin/services/categories/{$category->id}/products");
        $response->assertStatus(200);

        $fetched_products = $response->json();

        $this->assertCount(1, $fetched_products);

        $this->assertContains($productA->toJsonableArray(), $fetched_products);
    }
}