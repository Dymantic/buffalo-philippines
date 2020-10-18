<?php


namespace Tests\Feature\Products;


use App\Products\Subcategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateToolGroupTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_tool_group_can_be_created()
    {
        $this->disableExceptionHandling();

        $subcategory = factory(Subcategory::class)->create();

        $response = $this->asLoggedInUser()
                         ->json("POST", "/admin/subcategories/{$subcategory->id}/tool-groups", [
                             'title'       => 'TEST TITLE',
                             'description' => 'TEST DESCRIPTION'
                         ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('tool_groups', [
            'subcategory_id' => $subcategory->id,
            'title'          => 'TEST TITLE',
            'description'    => 'TEST DESCRIPTION'
        ]);
    }

    /**
     * @test
     */
    public function a_newly_created_tool_group_has_a_slug()
    {
        $this->disableExceptionHandling();

        $subcategory = factory(Subcategory::class)->create();

        $response = $this->asLoggedInUser()
                         ->json("POST", "/admin/subcategories/{$subcategory->id}/tool-groups", [
                             'title'       => 'TEST TITLE',
                             'description' => 'TEST DESCRIPTION'
                         ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('tool_groups', [
            'subcategory_id' => $subcategory->id,
            'title'          => 'TEST TITLE',
            'slug'           => 'test-title',
            'description'    => 'TEST DESCRIPTION'
        ]);
    }

    /**
     *@test
     */
    public function a_tool_group_can_be_created_with_an_empty_description()
    {
        $this->disableExceptionHandling();

        $subcategory = factory(Subcategory::class)->create();

        $response = $this->asLoggedInUser()
                         ->json("POST", "/admin/subcategories/{$subcategory->id}/tool-groups", [
                             'title'       => 'TEST TITLE',
                             'description' => ''
                         ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('tool_groups', [
            'subcategory_id' => $subcategory->id,
            'title'          => 'TEST TITLE',
            'description'    => null
        ]);
    }

    /**
     *@test
     */
    public function the_tool_group_title_is_required()
    {
        $subcategory = factory(Subcategory::class)->create();

        $response = $this->asLoggedInUser()
                         ->json("POST", "/admin/subcategories/{$subcategory->id}/tool-groups", [
                             'title'       => '',
                             'description' => 'TEST DESCRIPTION'
                         ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('title', $response->json()['errors']);
    }

    /**
     *@test
     */
    public function the_title_of_the_tool_group_should_not_exceed_255_characters()
    {
        $subcategory = factory(Subcategory::class)->create();

        $response = $this->asLoggedInUser()
                         ->json("POST", "/admin/subcategories/{$subcategory->id}/tool-groups", [
                             'title'       => str_repeat('X', 260),
                             'description' => 'TEST DESCRIPTION'
                         ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('title', $response->json()['errors']);
    }
}