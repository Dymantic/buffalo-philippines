<?php


namespace Tests\Feature\Products;


use App\Products\Subcategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateSubcategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function an_existing_subcategory_can_be_updated()
    {
        $this->disableExceptionHandling();

        $subcategory = factory(Subcategory::class)->create([
            'title'       => 'OLD TITLE',
            'description' => 'OLD DESCRIPTION'
        ]);

        $response = $this->asLoggedInUser()->json("POST", "/admin/subcategories/{$subcategory->id}", [
            'title'       => 'NEW TITLE',
            'description' => 'NEW DESCRIPTION'
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('subcategories', [
            'id' => $subcategory->id,
            'title'       => 'NEW TITLE',
            'description' => 'NEW DESCRIPTION'
        ]);
    }

    /**
     *@test
     */
    public function successfully_updating_a_subcategory_responds_with_the_updated_data()
    {
        $this->disableExceptionHandling();

        $subcategory = factory(Subcategory::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/subcategories/{$subcategory->id}", [
            'title'       => 'NEW TITLE',
            'description' => 'NEW DESCRIPTION'
        ]);
        $response->assertStatus(200);

        $this->assertEquals($subcategory->fresh()->toJsonableArray(), $response->decodeResponseJson());
    }

    /**
     *@test
     */
    public function the_description_may_be_empty()
    {
        $this->disableExceptionHandling();

        $subcategory = factory(Subcategory::class)->create([
            'title'       => 'OLD TITLE',
            'description' => 'OLD DESCRIPTION'
        ]);

        $response = $this->asLoggedInUser()->json("POST", "/admin/subcategories/{$subcategory->id}", [
            'title'       => 'NEW TITLE',
            'description' => ''
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('subcategories', [
            'id' => $subcategory->id,
            'title'       => 'NEW TITLE',
            'description' => null
        ]);
    }

    /**
     *@test
     */
    public function the_subcategory_title_is_still_required()
    {
        $subcategory = factory(Subcategory::class)->create([
            'title'       => 'OLD TITLE',
            'description' => 'OLD DESCRIPTION'
        ]);

        $response = $this->asLoggedInUser()->json("POST", "/admin/subcategories/{$subcategory->id}", [
            'title'       => '',
            'description' => 'NEW DESCRIPTION'
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('title', $response->decodeResponseJson()['errors']);
    }

    /**
     *@test
     */
    public function the_subcategory_title_must_not_be_more_than_255_characters()
    {
        $subcategory = factory(Subcategory::class)->create([
            'title'       => 'OLD TITLE',
            'description' => 'OLD DESCRIPTION'
        ]);

        $response = $this->asLoggedInUser()->json("POST", "/admin/subcategories/{$subcategory->id}", [
            'title'       => str_repeat('X', 260),
            'description' => 'NEW DESCRIPTION'
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('title', $response->decodeResponseJson()['errors']);
    }
}