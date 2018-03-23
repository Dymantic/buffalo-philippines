<?php


namespace Tests\Unit\Products;


use App\Products\Category;
use App\Products\Product;
use App\Products\Subcategory;
use App\Products\ToolGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_product_can_be_published()
    {
        $product = factory(Product::class)->create(['published' => false]);

        $product->publish();

        $this->assertTrue($product->fresh()->published);
    }

    /**
     * @test
     */
    public function a_product_can_be_retracted()
    {
        $product = factory(Product::class)->create(['published' => true]);

        $product->retract();

        $this->assertFalse($product->fresh()->published);
    }

    /**
     * @test
     */
    public function a_product_can_be_featured()
    {
        $product = factory(Product::class)->create(['featured' => false]);

        $product->feature();

        $this->assertTrue($product->fresh()->featured);
    }

    /**
     * @test
     */
    public function a_product_can_be_demoted()
    {
        $product = factory(Product::class)->create(['featured' => true]);

        $product->demote();

        $this->assertFalse($product->fresh()->featured);
    }

    /**
     * @test
     */
    public function a_number_of_days_can_be_added_to_the_new_until_date()
    {
        $product = factory(Product::class)->create(['new_until' => Carbon::today()]);

        $product->addDaysToNewUntil(20);

        $this->assertTrue(Carbon::today()->addDays(20)->isSameDay($product->fresh()->new_until));
    }

    /**
     * @test
     */
    public function a_negative_number_passed_to_the_add_days_to_new_until_will_subtract_days()
    {
        $product = factory(Product::class)->create(['new_until' => Carbon::today()]);

        $product->addDaysToNewUntil(-20);

        $this->assertTrue(Carbon::today()->subDays(20)->isSameDay($product->fresh()->new_until));
    }

    /**
     * @test
     */
    public function adding_days_to_a_past_new_until_date_adds_from_the_current_date()
    {
        $product = factory(Product::class)->create(['new_until' => Carbon::today()->subMonth()]);

        $product->addDaysToNewUntil(20);

        $this->assertTrue(Carbon::today()->addDays(20)->isSameDay($product->fresh()->new_until));
    }

    /**
     * @test
     */
    public function a_product_is_new_if_its_new_until_date_has_not_passed()
    {
        $old_product = factory(Product::class)->create(['new_until' => Carbon::today()->subMonth()]);
        $new_product = factory(Product::class)->create(['new_until' => Carbon::today()->addMonth()]);

        $this->assertTrue($new_product->isNew());
        $this->assertFalse($old_product->isNew());
    }

    /**
     *@test
     */
    public function products_can_be_scoped_to_featured()
    {
        $featured_products = factory(Product::class, 2)->create(['featured' => true]);
        $unfeatured_products = factory(Product::class, 3)->create(['featured' => false]);

        $scoped = Product::featured()->get();

        $this->assertCount(2, $scoped);

        $scoped->each(function($product) use ($featured_products) {
            $this->assertTrue($featured_products->contains($product));
        });
    }

    /**
     *@test
     */
    public function a_product_can_return_a_collection_of_its_parents()
    {
        $product = factory(Product::class)->create();
        $tool_group = factory(ToolGroup::class)->create();
        $unrelated_tool_group = factory(ToolGroup::class)->create();
        $subcategory = factory(Subcategory::class)->create();
        $category = factory(Category::class)->create();

        $tool_group->addProduct($product);
        $subcategory->addProduct($product);
        $category->addProduct($product);

        $parents = $product->parents();

        $this->assertCount(3, $parents);

        $this->assertTrue($parents->contains($tool_group));
        $this->assertFalse($parents->contains($unrelated_tool_group));
        $this->assertTrue($parents->contains($subcategory));
        $this->assertTrue($parents->contains($category));
    }


    /**
     * @test
     */
    public function a_product_can_be_presented_as_a_jsonable_array()
    {
        $product = factory(Product::class)->create([
            'title'       => 'TEST PRODUCT TITLE',
            'code'        => 'TEST CODE',
            'description' => 'TEST PRODUCT DESCRIPTION',
            'writeup'     => 'TEST PRODUCT WRITEUP',
            'price'       => 'TEST PRODUCT PRICE'
        ]);
        $category = factory(Category::class)->create(['title' => 'TEST CATEGORY TITLE']);
        $tool_group = factory(ToolGroup::class)->create(['title' => 'TEST TOOL GROUP TITLE']);
        $category->addProduct($product);
        $tool_group->addProduct($product);
        $main_image = $product->setMainImage(UploadedFile::fake()->image('main_image.jpg'));
        $gallery_imageA = $product->addGalleryImage(UploadedFile::fake()->image('gallery_imageA.jpg'));
        $gallery_imageB = $product->addGalleryImage(UploadedFile::fake()->image('gallery_imageB.jpg'));

        $expected = [
            'id'             => $product->id,
            'title'          => 'TEST PRODUCT TITLE',
            'code'           => 'TEST CODE',
            'slug'           => 'test-product-title',
            'description'    => 'TEST PRODUCT DESCRIPTION',
            'writeup'        => 'TEST PRODUCT WRITEUP',
            'price'          => 'TEST PRODUCT PRICE',
            'published'      => false,
            'featured'       => false,
            'is_new'         => true,
            'new_until'      => Carbon::parse('+1 month')->format('Y-m-d'),
            'parents'        => [
                ['id' => $category->id, 'type' => 'Category', 'title' => 'TEST CATEGORY TITLE', 'parent' => null],
                [
                    'id' => $tool_group->id,
                    'type' => 'ToolGroup',
                    'title' => 'TEST TOOL GROUP TITLE',
                    'parent' => [
                        'id' => $tool_group->subcategory->id,
                        'type' => 'Subcategory',
                        'title' => $tool_group->subcategory->title,
                        'parent' => [
                            'id' => $tool_group->subcategory->category->id,
                            'type' => 'Category',
                            'title' => $tool_group->subcategory->category->title,
                            'parent' => null
                        ]
                    ]
                ]
            ],
            'main_image'     => [
                'id'       => $main_image->id,
                'thumb'    => $main_image->getUrl('thumb'),
                'web'      => $main_image->getUrl('web'),
                'original' => $main_image->getUrl()
            ],
            'gallery_images' => [
                [
                    'id'       => $gallery_imageA->id,
                    'thumb'    => $gallery_imageA->getUrl('thumb'),
                    'web'      => $gallery_imageA->getUrl('web'),
                    'original' => $gallery_imageA->getUrl()
                ],
                [
                    'id'       => $gallery_imageB->id,
                    'thumb'    => $gallery_imageB->getUrl('thumb'),
                    'web'      => $gallery_imageB->getUrl('web'),
                    'original' => $gallery_imageB->getUrl()
                ]
            ]
        ];

        $this->assertEquals($expected, $product->fresh()->toJsonableArray());
    }
}