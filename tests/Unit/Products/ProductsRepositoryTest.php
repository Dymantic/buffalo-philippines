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
        $subcategory = factory(Subcategory::class)->create(['published' => true, 'category_id' => $category->id]);
        $tool_group = factory(ToolGroup::class)->create(['published' => true, 'subcategory_id' => $subcategory->id]);

        $productA = $category->addProduct(factory(Product::class)->create());
        $productB = $subcategory->addProduct(factory(Product::class)->create());
        $productC = $subcategory->addProduct(factory(Product::class)->create());
        $productD = $tool_group->addProduct(factory(Product::class)->create());
        $productE = $tool_group->addProduct(factory(Product::class)->create());


        $fetched_products = (new ProductsRepository())->productsUnder($category);

        $this->assertCount(5, $fetched_products);

        $this->assertTrue($fetched_products->contains($productA));
        $this->assertTrue($fetched_products->contains($productB));
        $this->assertTrue($fetched_products->contains($productC));
        $this->assertTrue($fetched_products->contains($productD));
        $this->assertTrue($fetched_products->contains($productE));
    }

    /**
     *@test
     */
    public function it_can_return_only_published_descendants()
    {
        $category = factory(Category::class)->create(['published' => true]);
        $subcategory = factory(Subcategory::class)->create(['published' => false, 'category_id' => $category->id]);
        $tool_group = factory(ToolGroup::class)->create(['published' => false, 'subcategory_id' => $subcategory->id]);

        $productA = $category->addProduct(factory(Product::class)->create());
        $productB = $subcategory->addProduct(factory(Product::class)->create());
        $productC = $subcategory->addProduct(factory(Product::class)->create());
        $productD = $tool_group->addProduct(factory(Product::class)->create());
        $productE = $tool_group->addProduct(factory(Product::class)->create());


        $fetched_products = (new ProductsRepository())->publishedProductsUnder($category);

        $this->assertCount(1, $fetched_products);

        $this->assertTrue($fetched_products->contains($productA));
        $this->assertFalse($fetched_products->contains($productB));
        $this->assertFalse($fetched_products->contains($productC));
        $this->assertFalse($fetched_products->contains($productD));
        $this->assertFalse($fetched_products->contains($productE));
    }

    /**
     *@test
     */
    public function the_repository_caches_the_category_products()
    {
        $category = factory(Category::class)->create();
        $subcategory = factory(Subcategory::class)->create(['category_id' => $category->id]);
        $tool_group = factory(ToolGroup::class)->create(['subcategory_id' => $subcategory->id]);

        $productA = $category->addProduct(factory(Product::class)->create());
        $productB = $subcategory->addProduct(factory(Product::class)->create());
        $productC = $subcategory->addProduct(factory(Product::class)->create());
        $productD = $tool_group->addProduct(factory(Product::class)->create());
        $productE = $tool_group->addProduct(factory(Product::class)->create());

        $this->assertFalse(cache()->has($category->slug));


        $fetched_products = (new ProductsRepository())->productsUnder($category);

        $this->assertTrue(cache()->has($category->slug));
    }

    /**
     *@test
     */
    public function it_returns_the_products_under_a_given_subcategory()
    {
        $subcategory = factory(Subcategory::class)->create();
        $tool_groupA = factory(ToolGroup::class)->create(['subcategory_id' => $subcategory->id]);
        $tool_groupB = factory(ToolGroup::class)->create(['subcategory_id' => $subcategory->id]);

        $productA = $subcategory->addProduct(factory(Product::class)->create());
        $productB = $tool_groupA->addProduct(factory(Product::class)->create());
        $productC = $tool_groupB->addProduct(factory(Product::class)->create());
        $productD = factory(Product::class)->create();
        $productE = factory(Product::class)->create();


        $fetched_products = (new ProductsRepository())->productsUnder($subcategory);

        $this->assertCount(3, $fetched_products);

        $this->assertTrue($fetched_products->contains($productA));
        $this->assertTrue($fetched_products->contains($productB));
        $this->assertTrue($fetched_products->contains($productC));
        $this->assertFalse($fetched_products->contains($productD));
        $this->assertFalse($fetched_products->contains($productE));
    }

    /**
     *@test
     */
    public function it_returns_the_products_under_a_given_tool_group()
    {
        $tool_groupA = factory(ToolGroup::class)->create();
        $tool_groupB = factory(ToolGroup::class)->create();

        $productA = $tool_groupA->addProduct(factory(Product::class)->create());
        $productB = $tool_groupA->addProduct(factory(Product::class)->create());
        $productC = $tool_groupB->addProduct(factory(Product::class)->create());
        $productD = $tool_groupB->addProduct(factory(Product::class)->create());


        $fetched_products = (new ProductsRepository())->productsUnder($tool_groupA);

        $this->assertCount(2, $fetched_products);

        $this->assertTrue($fetched_products->contains($productA));
        $this->assertTrue($fetched_products->contains($productB));
        $this->assertFalse($fetched_products->contains($productC));
        $this->assertFalse($fetched_products->contains($productD));
    }

    /**
     *@test
     */
    public function it_can_search_for_products_by_name()
    {
        $matching_product = factory(Product::class)->create(['title' => 'MATCHING PRODUCT']);
        $non_matching_product = factory(Product::class)->create(['title' => 'ANOTHER PRODUCT']);

        $products = (new ProductsRepository())->searchByName('matching');

        $this->assertCount(1, $products);
        $this->assertTrue($products->first()->is($matching_product));
    }

    /**
     *@test
     */
    public function the_repository_can_fetch_the_siblings_of_a_given_product()
    {
        $tool_group = factory(ToolGroup::class)->create();
        $subcategory = factory(Subcategory::class)->create();
        $category = factory(Category::class)->create();

        $productA = $tool_group->createProduct(factory(Product::class)->raw());
        $productB = $tool_group->createProduct(factory(Product::class)->raw());
        $productC = $subcategory->createProduct(factory(Product::class)->raw());
        $productD = $category->createProduct(factory(Product::class)->raw());
        $productE = factory(Product::class)->create();
        $productF = factory(Product::class)->create();

        $subcategory->addProduct($productA);
        $category->addProduct($productA);

        $siblings = app()->make(ProductsRepository::class)->siblingsOf($productA);

        $this->assertContains($productB->id, $siblings->pluck('id')->all());
        $this->assertContains($productC->id, $siblings->pluck('id')->all());
        $this->assertContains($productD->id, $siblings->pluck('id')->all());
        $this->assertNotContains($productE->id, $siblings->pluck('id')->all());
        $this->assertNotContains($productF->id, $siblings->pluck('id')->all());
    }



    /**
     *@test
     */
    public function it_can_return_products_related_to_a_given_product()
    {
        $tool_group = factory(ToolGroup::class)->create();
        $product = factory(Product::class)->create(['published' => true]);
        $related_products = factory(Product::class, 4)->create(['published' => true]);
        $unrelated_products = factory(Product::class, 3)->create(['published' => true]);

        //product and relations are in same tool group (closest form of relation)
        $tool_group->addProduct($product);
        $related_products->each(function($product) use ($tool_group) {
            $tool_group->addProduct($product);
        });

        $fetched_products = app()->make(ProductsRepository::class)->productsRelatedTo($product->slug);

        $this->assertCount(4, $fetched_products);

        $related_products->each(function($product) use ($fetched_products) {
            $this->assertContains($product->id, $fetched_products->pluck('id')->all());
        });
    }

    /**
     *@test
     */
    public function the_repository_can_do_a_full_search_by_name_and_code()
    {
        $matching = collect([]);
        $matching->push(factory(Product::class)->create([
            'title' => 'MATCHES-ON-TITLE'
        ]));
        $matching->push(factory(Product::class)->create([
            'code' => 'CODE-MATCHES'
        ]));
        factory(Product::class, 3)->create();

        $search_results = app()->make(ProductsRepository::class)->fullSearch('match');

        $this->assertCount(2, $search_results);
        $matching->each(function($match) use ($search_results) {
            $this->assertTrue($search_results->contains($match));
        });
    }
}