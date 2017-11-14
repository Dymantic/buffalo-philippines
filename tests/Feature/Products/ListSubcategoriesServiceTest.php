<?php


namespace Tests\Feature\Products;


use App\Products\Category;
use App\Products\Subcategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListSubcategoriesServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_list_of_subcategories_can_be_fetched()
    {
        $this->disableExceptionHandling();
        $category = factory(Category::class)->create();
        $subcategories = factory(Subcategory::class, 10)->create(['category_id' => $category]);

        $response = $this->asLoggedInUser()
                         ->json("GET", "/admin/services/categories/{$category->id}/subcategories");
        $response->assertStatus(200);

        $fetched_subcategories = $response->decodeResponseJson();

        $this->assertCount(10, $fetched_subcategories);

        $subcategories->each(function($subcategory) use ($fetched_subcategories) {
            $this->assertContains($subcategory->toJsonableArray(), $fetched_subcategories);
        });
    }
}