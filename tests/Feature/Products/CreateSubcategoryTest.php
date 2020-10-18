<?php


namespace Tests\Feature\Products;


use App\Products\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateSubcategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_subcategory_can_be_created()
    {
        $this->disableExceptionHandling();

        $category = factory(Category::class)->create();

        $response = $this->asLoggedInUser()
                         ->json("POST", "/admin/categories/{$category->id}/subcategories", [
                             'title'       => 'TEST TITLE',
                             'description' => 'TEST DESCRIPTION'
                         ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('subcategories', [
            'category_id' => $category->id,
            'title'       => 'TEST TITLE',
            'description' => 'TEST DESCRIPTION'
        ]);
    }

    /**
     * @test
     */
    public function a_newly_created_subcategory_has_a_slug()
    {
        $this->disableExceptionHandling();

        $category = factory(Category::class)->create();

        $response = $this->asLoggedInUser()
                         ->json("POST", "/admin/categories/{$category->id}/subcategories", [
                             'title'       => 'TEST TITLE',
                             'description' => 'TEST DESCRIPTION'
                         ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('subcategories', [
            'category_id' => $category->id,
            'title'       => 'TEST TITLE',
            'slug'        => 'test-title',
            'description' => 'TEST DESCRIPTION'
        ]);
    }

    /**
     *@test
     */
    public function the_subcategory_title_is_required()
    {
        $category = factory(Category::class)->create();

        $response = $this->asLoggedInUser()
                         ->json("POST", "/admin/categories/{$category->id}/subcategories", [
                             'title'       => '',
                             'description' => 'TEST DESCRIPTION'
                         ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('title', $response->json()['errors']);
    }

    /**
     *@test
     */
    public function the_title_must_not_exceed_255_characters()
    {
        $category = factory(Category::class)->create();

        $response = $this->asLoggedInUser()
                         ->json("POST", "/admin/categories/{$category->id}/subcategories", [
                             'title'       => str_repeat('X', 256),
                             'description' => 'TEST DESCRIPTION'
                         ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('title', $response->json()['errors']);
    }

    /**
     *@test
     */
    public function the_description_may_be_empty()
    {
        $this->disableExceptionHandling();

        $category = factory(Category::class)->create();

        $response = $this->asLoggedInUser()
                         ->json("POST", "/admin/categories/{$category->id}/subcategories", [
                             'title'       => 'TEST TITLE',
                             'description' => ''
                         ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('subcategories', [
            'category_id' => $category->id,
            'title'       => 'TEST TITLE',
            'description' => null
        ]);
    }
}