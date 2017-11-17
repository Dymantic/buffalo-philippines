<?php


namespace Tests\Unit\Products;


use App\Products\Category;
use App\Products\Product;
use App\Products\ProductsRepository;
use App\Products\Subcategory;
use App\Products\ToolGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductsRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function it_returns_the_products_belonging_to_a_given_category()
    {
        $category = factory(Category::class)->create();
        $subcategory = factory(Subcategory::class)->create(['category_id' => $category->id]);
        $tool_group = factory(ToolGroup::class)->create(['subcategory_id' => $subcategory->id]);

        $productA = $category->addProduct(factory(Product::class)->create());
        $productB = $subcategory->addProduct(factory(Product::class)->create());
        $productC = $subcategory->addProduct(factory(Product::class)->create());
        $productD = $tool_group->addProduct(factory(Product::class)->create());
        $productE = $tool_group->addProduct(factory(Product::class)->create());


        $fetched_products = (new ProductsRepository())->productsForCategory($category);

        $this->assertCount(5, $fetched_products);

        $this->assertTrue($fetched_products->contains($productA));
        $this->assertTrue($fetched_products->contains($productB));
        $this->assertTrue($fetched_products->contains($productC));
        $this->assertTrue($fetched_products->contains($productD));
        $this->assertTrue($fetched_products->contains($productE));
    }
}