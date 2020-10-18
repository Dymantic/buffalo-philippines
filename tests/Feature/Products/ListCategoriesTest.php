<?php


namespace Tests\Feature\Products;


use App\Products\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListCategoriesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_list_of_all_categories_can_be_fetched()
    {
        $this->disableExceptionHandling();
        $categories = factory(Category::class, 10)->create();

        $response = $this->asLoggedInUser()->json("GET", "/admin/services/categories");
        $response->assertStatus(200);

        $fetched_categories = $response->json();

        $this->assertCount(10, $fetched_categories);

        $categories->each(function($category) use ($fetched_categories) {
            $this->assertContains($category->toJsonableArray(), $fetched_categories);
        });
    }
}