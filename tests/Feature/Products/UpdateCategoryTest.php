<?php


namespace Tests\Feature\Products;


use App\Products\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateCategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function an_existing_category_can_be_updated()
    {
        $this->disableExceptionHandling();

        $category = factory(Category::class)->create([
            'title'       => 'OLD TITLE',
            'description' => 'OLD DESCRIPTION'
        ]);

        $response = $this->asLoggedInUser()->json("POST", "/admin/categories/{$category->id}", [
            'title'       => 'NEW TITLE',
            'description' => 'NEW DESCRIPTION'
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('categories', [
            'id'          => $category->id,
            'title'       => 'NEW TITLE',
            'description' => 'NEW DESCRIPTION'
        ]);
    }

    /**
     *@test
     */
    public function successfully_updating_a_product_responds_with_the_updated_data()
    {
        $this->disableExceptionHandling();

        $category = factory(Category::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/categories/{$category->id}", [
            'title'       => 'NEW TITLE',
            'description' => 'NEW DESCRIPTION'
        ]);
        $response->assertStatus(200);

        $this->assertEquals($category->fresh()->toJsonableArray(), $response->json());
    }

    /**
     * @test
     */
    public function the_title_is_still_required()
    {
        $category = factory(Category::class)->create([
            'title'       => 'OLD TITLE',
            'description' => 'OLD DESCRIPTION'
        ]);

        $response = $this->asLoggedInUser()->json("POST", "/admin/categories/{$category->id}", [
            'title'       => '',
            'description' => 'NEW DESCRIPTION'
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('title', $response->json()['errors']);
    }

    /**
     * @test
     */
    public function the_updated_title_must_be_under_255_characters()
    {
        $category = factory(Category::class)->create([
            'title'       => 'OLD TITLE',
            'description' => 'OLD DESCRIPTION'
        ]);

        $response = $this->asLoggedInUser()->json("POST", "/admin/categories/{$category->id}", [
            'title'       => str_repeat('X', 260),
            'description' => 'NEW DESCRIPTION'
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('title', $response->json()['errors']);
    }

    /**
     * @test
     */
    public function an_updated_description_may_be_empty()
    {
        $category = factory(Category::class)->create([
            'title'       => 'OLD TITLE',
            'description' => 'OLD DESCRIPTION'
        ]);

        $response = $this->asLoggedInUser()->json("POST", "/admin/categories/{$category->id}", [
            'title'       => 'TEST TITLE',
            'description' => ''
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('categories', [
            'id'          => $category->id,
            'title'       => 'TEST TITLE',
            'description' => null
        ]);
    }
}