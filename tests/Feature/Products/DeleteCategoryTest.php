<?php


namespace Tests\Feature\Products;


use App\Products\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteCategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_category_may_be_deleted()
    {
        $this->disableExceptionHandling();

        $category = factory(Category::class)->create();

        $response = $this->asLoggedInUser()->delete("/admin/categories/{$category->id}");
        $response->assertStatus(302);
        $response->assertRedirect("/admin/categories");

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}