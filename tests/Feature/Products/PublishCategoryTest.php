<?php


namespace Tests\Feature\Products;


use App\Products\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublishCategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_category_may_be_published()
    {
        $this->disableExceptionHandling();

        $category = factory(Category::class)->create(['published' => false]);

        $response = $this->asLoggedInUser()->json("POST", "/admin/published-categories", [
            'category_id' => $category->id
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('categories', [
            'id'        => $category->id,
            'published' => true
        ]);
    }

    /**
     *@test
     */
    public function the_category_id_is_required_to_publish_the_category()
    {
        $response = $this->asLoggedInUser()->json("POST", "/admin/published-categories", [
            'category_id' => ''
        ]);
        $response->assertStatus(422);
        $this->assertArrayHasKey('category_id', $response->decodeResponseJson()['errors']);
    }

    /**
     *@test
     */
    public function the_category_id_must_be_an_integer()
    {
        $response = $this->asLoggedInUser()->json("POST", "/admin/published-categories", [
            'category_id' => 'NOT-AN-INTEGER'
        ]);
        $response->assertStatus(422);
        $this->assertArrayHasKey('category_id', $response->decodeResponseJson()['errors']);
    }

    /**
     *@test
     */
    public function the_category_id_must_exist_in_the_categories_table()
    {
        $response = $this->asLoggedInUser()->json("POST", "/admin/published-categories", [
            'category_id' => 999
        ]);
        $response->assertStatus(422);
        $this->assertArrayHasKey('category_id', $response->decodeResponseJson()['errors']);
    }

    /**
     *@test
     */
    public function a_published_category_may_be_retracted()
    {
        $this->disableExceptionHandling();

        $category = factory(Category::class)->create(['published' => true]);

        $response = $this->asLoggedInUser()->json("DELETE", "/admin/published-categories/{$category->id}");
        $response->assertStatus(200);

        $this->assertDatabaseHas('categories', [
            'id'        => $category->id,
            'published' => false
        ]);
    }
}