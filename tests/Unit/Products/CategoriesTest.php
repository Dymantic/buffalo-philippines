<?php

namespace Tests\Unit\Products;

use App\Products\Category;
use App\Products\Product;
use App\Products\Subcategory;
use App\Products\ToolGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
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
     * @test
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
     * @test
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
     * @test
     */
    public function deleting_a_category_deletes_all_its_subcategories_and_tool_groups()
    {
        $category = factory(Category::class)->create();
        $subcategories = factory(Subcategory::class, 2)->create(['category_id' => $category->id]);
        $subcategories->each(function ($subcategory) {
            factory(ToolGroup::class, 2)->create(['subcategory_id' => $subcategory->id]);
        });

        $this->assertCount(2, Subcategory::all());
        $this->assertCount(4, ToolGroup::all());

        $category->delete();

        $this->assertCount(0, Subcategory::all());
        $this->assertCount(0, ToolGroup::all());
    }

    /**
     * @test
     */
    public function a_category_can_be_published()
    {
        $category = factory(Category::class)->create(['published' => false]);

        $category->publish();

        $this->assertTrue($category->fresh()->published);
    }

    /**
     * @test
     */
    public function a_category_may_be_retracted()
    {
        $category = factory(Category::class)->create(['published' => true]);

        $category->retract();

        $this->assertFalse($category->fresh()->published);
    }

    /**
     * @test
     */
    public function a_category_can_be_presented_as_a_jsonable_array()
    {
        $category = factory(Category::class)->create([
            'title'       => 'TEST CATEGORY TITLE',
            'description' => 'TEST CATEGORY DESCRIPTION'
        ]);
        $image = $category->setImage(UploadedFile::fake()->image('testpic.jpg'));

        $expected = [
            'id'          => $category->id,
            'title'       => 'TEST CATEGORY TITLE',
            'description' => 'TEST CATEGORY DESCRIPTION',
            'image'       => [
                'thumb'    => $image->getUrl('thumb'),
                'original' => $image->getUrl()
            ]
        ];

        $this->assertEquals($expected, $category->toJsonableArray());
    }

    /**
     * @test
     */
    public function a_category_can_present_its_menu()
    {
        $category = factory(Category::class)->create(['title' => 'TEST CATEGORY TITLE']);
        $subcategoryA = factory(Subcategory::class)->create([
            'title'       => 'TEST SUBCATEGORY_A',
            'category_id' => $category->id,
            'published' => true
        ]);
        $subcategoryB = factory(Subcategory::class)->create([
            'title'       => 'TEST SUBCATEGORY_B',
            'category_id' => $category->id,
            'published' => true
        ]);
        $subcategoryC = factory(Subcategory::class)->create([
            'title'       => 'TEST SUBCATEGORY_C',
            'category_id' => $category->id,
            'published' => true
        ]);
        $tool_groupA = factory(ToolGroup::class)->create([
            'title'          => 'TEST TOOL_GROUP_A',
            'subcategory_id' => $subcategoryA->id,
            'published' => true
        ]);
        $tool_groupB = factory(ToolGroup::class)->create([
            'title'          => 'TEST TOOL_GROUP_B',
            'subcategory_id' => $subcategoryA->id,
            'published' => true
        ]);
        $tool_groupC = factory(ToolGroup::class)->create([
            'title'          => 'TEST TOOL_GROUP_C',
            'subcategory_id' => $subcategoryC->id,
            'published' => true
        ]);
        $tool_groupD = factory(ToolGroup::class)->create([
            'title'          => 'TEST TOOL_GROUP_D',
            'subcategory_id' => $subcategoryC->id,
            'published' => true
        ]);

        $expected = [
            'id'       => $category->id,
            'title'    => 'TEST CATEGORY TITLE',
            'slug'     => $category->slug,
            'link'     => "/categories/{$category->slug}",
            'children' => [
                [
                    'id'       => $subcategoryA->id,
                    'title'    => 'TEST SUBCATEGORY_A',
                    'link'     => "/subcategories/{$subcategoryA->slug}",
                    'children' => [
                        [
                            'id'    => $tool_groupA->id,
                            'title' => 'TEST TOOL_GROUP_A',
                            'link'  => "/tool-groups/{$tool_groupA->slug}"
                        ],
                        [
                            'id'    => $tool_groupB->id,
                            'title' => 'TEST TOOL_GROUP_B',
                            'link'  => "/tool-groups/{$tool_groupB->slug}"
                        ]
                    ]
                ],
                [
                    'id'       => $subcategoryB->id,
                    'title'    => 'TEST SUBCATEGORY_B',
                    'link'     => "/subcategories/{$subcategoryB->slug}",
                    'children' => []
                ],
                [
                    'id'       => $subcategoryC->id,
                    'title'    => 'TEST SUBCATEGORY_C',
                    'link'     => "/subcategories/{$subcategoryC->slug}",
                    'children' => [
                        [
                            'id'    => $tool_groupC->id,
                            'title' => 'TEST TOOL_GROUP_C',
                            'link'  => "/tool-groups/{$tool_groupC->slug}"
                        ],
                        [
                            'id'    => $tool_groupD->id,
                            'title' => 'TEST TOOL_GROUP_D',
                            'link'  => "/tool-groups/{$tool_groupD->slug}"
                        ]
                    ]
                ]
            ]
        ];

        $this->assertEquals($expected, $category->menu());
    }

    /**
     *@test
     */
    public function a_category_can_present_a_complete_menu_which_includes_unpublished_groups()
    {
        $category = factory(Category::class)->create(['title' => 'TEST CATEGORY TITLE']);
        $subcategoryA = factory(Subcategory::class)->create([
            'title'       => 'TEST SUBCATEGORY_A',
            'category_id' => $category->id,
            'published' => true
        ]);
        $subcategoryB = factory(Subcategory::class)->create([
            'title'       => 'TEST SUBCATEGORY_B',
            'category_id' => $category->id,
            'published' => false
        ]);
        $subcategoryC = factory(Subcategory::class)->create([
            'title'       => 'TEST SUBCATEGORY_C',
            'category_id' => $category->id,
            'published' => true
        ]);
        $tool_groupA = factory(ToolGroup::class)->create([
            'title'          => 'TEST TOOL_GROUP_A',
            'subcategory_id' => $subcategoryA->id,
            'published' => false
        ]);
        $tool_groupB = factory(ToolGroup::class)->create([
            'title'          => 'TEST TOOL_GROUP_B',
            'subcategory_id' => $subcategoryA->id,
            'published' => true
        ]);
        $tool_groupC = factory(ToolGroup::class)->create([
            'title'          => 'TEST TOOL_GROUP_C',
            'subcategory_id' => $subcategoryC->id,
            'published' => false
        ]);
        $tool_groupD = factory(ToolGroup::class)->create([
            'title'          => 'TEST TOOL_GROUP_D',
            'subcategory_id' => $subcategoryC->id,
            'published' => false
        ]);

        $expected = [
            'id'       => $category->id,
            'title'    => 'TEST CATEGORY TITLE',
            'slug'     => $category->slug,
            'link'     => "/categories/{$category->slug}",
            'children' => [
                [
                    'id'       => $subcategoryA->id,
                    'title'    => 'TEST SUBCATEGORY_A',
                    'link'     => "/subcategories/{$subcategoryA->slug}",
                    'children' => [
                        [
                            'id'    => $tool_groupA->id,
                            'title' => 'TEST TOOL_GROUP_A',
                            'link'  => "/tool-groups/{$tool_groupA->slug}"
                        ],
                        [
                            'id'    => $tool_groupB->id,
                            'title' => 'TEST TOOL_GROUP_B',
                            'link'  => "/tool-groups/{$tool_groupB->slug}"
                        ]
                    ]
                ],
                [
                    'id'       => $subcategoryB->id,
                    'title'    => 'TEST SUBCATEGORY_B',
                    'link'     => "/subcategories/{$subcategoryB->slug}",
                    'children' => []
                ],
                [
                    'id'       => $subcategoryC->id,
                    'title'    => 'TEST SUBCATEGORY_C',
                    'link'     => "/subcategories/{$subcategoryC->slug}",
                    'children' => [
                        [
                            'id'    => $tool_groupC->id,
                            'title' => 'TEST TOOL_GROUP_C',
                            'link'  => "/tool-groups/{$tool_groupC->slug}"
                        ],
                        [
                            'id'    => $tool_groupD->id,
                            'title' => 'TEST TOOL_GROUP_D',
                            'link'  => "/tool-groups/{$tool_groupD->slug}"
                        ]
                    ]
                ]
            ]
        ];

        $this->assertEquals($expected, $category->completeMenu());
    }

    /**
     * @test
     */
    public function the_menu_does_not_include_unpublished_stockables()
    {
        $category = factory(Category::class)->create(['title' => 'TEST CATEGORY TITLE']);
        $subcategoryA = factory(Subcategory::class)->create([
            'title'       => 'TEST SUBCATEGORY_A',
            'category_id' => $category->id,
            'published' => true
        ]);
        $subcategoryB = factory(Subcategory::class)->create([
            'title'       => 'TEST SUBCATEGORY_B',
            'category_id' => $category->id,
            'published' => false
        ]);
        $subcategoryC = factory(Subcategory::class)->create([
            'title'       => 'TEST SUBCATEGORY_C',
            'category_id' => $category->id,
            'published' => true
        ]);
        $tool_groupA = factory(ToolGroup::class)->create([
            'title'          => 'TEST TOOL_GROUP_A',
            'subcategory_id' => $subcategoryA->id,
            'published' => true
        ]);
        $tool_groupB = factory(ToolGroup::class)->create([
            'title'          => 'TEST TOOL_GROUP_B',
            'subcategory_id' => $subcategoryA->id,
            'published' => true
        ]);
        $tool_groupC = factory(ToolGroup::class)->create([
            'title'          => 'TEST TOOL_GROUP_C',
            'subcategory_id' => $subcategoryC->id,
            'published' => true
        ]);
        $tool_groupD = factory(ToolGroup::class)->create([
            'title'          => 'TEST TOOL_GROUP_D',
            'subcategory_id' => $subcategoryC->id,
            'published' => false
        ]);

        $expected = [
            'id'       => $category->id,
            'title'    => 'TEST CATEGORY TITLE',
            'slug'     => $category->slug,
            'link'     => "/categories/{$category->slug}",
            'children' => [
                [
                    'id'       => $subcategoryA->id,
                    'title'    => 'TEST SUBCATEGORY_A',
                    'link'     => "/subcategories/{$subcategoryA->slug}",
                    'children' => [
                        [
                            'id'    => $tool_groupA->id,
                            'title' => 'TEST TOOL_GROUP_A',
                            'link'  => "/tool-groups/{$tool_groupA->slug}"
                        ],
                        [
                            'id'    => $tool_groupB->id,
                            'title' => 'TEST TOOL_GROUP_B',
                            'link'  => "/tool-groups/{$tool_groupB->slug}"
                        ]
                    ]
                ],
                [
                    'id'       => $subcategoryC->id,
                    'title'    => 'TEST SUBCATEGORY_C',
                    'link'     => "/subcategories/{$subcategoryC->slug}",
                    'children' => [
                        [
                            'id'    => $tool_groupC->id,
                            'title' => 'TEST TOOL_GROUP_C',
                            'link'  => "/tool-groups/{$tool_groupC->slug}"
                        ]
                    ]
                ]
            ]
        ];

        $this->assertEquals($expected, $category->menu());
    }

    /**
     * @test
     */
    public function a_list_of_all_categories_with_subcategories_and_tool_groups_can_be_presented()
    {
        $categoryA = factory(Category::class)->create();
        $categoryB = factory(Category::class)->create();

        $subcategoryA = factory(Subcategory::class)->create(['category_id' => $categoryA->id]);
        $subcategoryB = factory(Subcategory::class)->create(['category_id' => $categoryA->id]);
        $subcategoryC = factory(Subcategory::class)->create(['category_id' => $categoryB->id]);
        $subcategoryD = factory(Subcategory::class)->create(['category_id' => $categoryB->id]);

        $toolgroupA = factory(ToolGroup::class)->create(['subcategory_id' => $subcategoryA]);
        $toolgroupB = factory(ToolGroup::class)->create(['subcategory_id' => $subcategoryA]);
        $toolgroupC = factory(ToolGroup::class)->create(['subcategory_id' => $subcategoryB]);
        $toolgroupD = factory(ToolGroup::class)->create(['subcategory_id' => $subcategoryD]);
        $toolgroupE = factory(ToolGroup::class)->create(['subcategory_id' => $subcategoryD]);
        $toolgroupF = factory(ToolGroup::class)->create(['subcategory_id' => $subcategoryD]);

        $expected = [
            [
                'id'            => $categoryA->id,
                'title'         => $categoryA->title,
                'slug'          => $categoryA->slug,
                'subcategories' => [
                    [
                        'id'         => $subcategoryA->id,
                        'title'      => $subcategoryA->title,
                        'slug'       => $subcategoryA->slug,
                        'toolgroups' => [
                            [
                                'id'    => $toolgroupA->id,
                                'title' => $toolgroupA->title,
                                'slug'  => $toolgroupA->slug,
                            ],
                            [
                                'id'    => $toolgroupB->id,
                                'title' => $toolgroupB->title,
                                'slug'  => $toolgroupB->slug,
                            ]
                        ]
                    ],
                    [
                        'id'         => $subcategoryB->id,
                        'title'      => $subcategoryB->title,
                        'slug'       => $subcategoryB->slug,
                        'toolgroups' => [
                            [
                                'id'    => $toolgroupC->id,
                                'title' => $toolgroupC->title,
                                'slug'  => $toolgroupC->slug,
                            ]
                        ]
                    ]
                ]
            ],
            [
                'id'            => $categoryB->id,
                'title'         => $categoryB->title,
                'slug'          => $categoryB->slug,
                'subcategories' => [
                    [
                        'id'         => $subcategoryC->id,
                        'title'      => $subcategoryC->title,
                        'slug'       => $subcategoryC->slug,
                        'toolgroups' => [],
                    ],
                    [
                        'id'         => $subcategoryD->id,
                        'title'      => $subcategoryD->title,
                        'slug'       => $subcategoryD->slug,
                        'toolgroups' => [
                            [
                                'id'    => $toolgroupD->id,
                                'title' => $toolgroupD->title,
                                'slug'  => $toolgroupD->slug,
                            ],
                            [
                                'id'    => $toolgroupE->id,
                                'title' => $toolgroupE->title,
                                'slug'  => $toolgroupE->slug,
                            ],
                            [
                                'id'    => $toolgroupF->id,
                                'title' => $toolgroupF->title,
                                'slug'  => $toolgroupF->slug,
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $this->assertEquals($expected, Category::completeList());
    }
}