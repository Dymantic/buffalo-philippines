<?php


namespace Tests\Feature\Products;


use App\Products\Subcategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublishSubcategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_subcategory_may_be_published()
    {
        $this->disableExceptionHandling();

        $subcategory = factory(Subcategory::class)->create(['published' => false]);

        $response = $this->asLoggedInUser()->json("POST", "/admin/published-subcategories", [
            'subcategory_id' => $subcategory->id
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('subcategories', [
            'id'        => $subcategory->id,
            'published' => true
        ]);
    }

    /**
     *@test
     */
    public function the_subcategory_id_is_required()
    {
        $response = $this->asLoggedInUser()->json("POST", "/admin/published-subcategories", [
            'subcategory_id' => ''
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('subcategory_id', $response->decodeResponseJson()['errors']);
    }

    /**
     *@test
     */
    public function the_subcategory_id_must_be_an_integer()
    {
        $response = $this->asLoggedInUser()->json("POST", "/admin/published-subcategories", [
            'subcategory_id' => 'NOT-AN-INTEGER'
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('subcategory_id', $response->decodeResponseJson()['errors']);
    }

    /**
     *@test
     */
    public function the_subcategory_id_must_exist_in_the_subcategories_table()
    {
        $response = $this->asLoggedInUser()->json("POST", "/admin/published-subcategories", [
            'subcategory_id' => 999
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('subcategory_id', $response->decodeResponseJson()['errors']);
    }

    /**
     *@test
     */
    public function a_published_subcategory_may_be_retracted()
    {
        $this->disableExceptionHandling();

        $subcategory = factory(Subcategory::class)->create(['published' => true]);

        $response = $this->asLoggedInUser()
                         ->json("DELETE", "/admin/published-subcategories/{$subcategory->id}");
        $response->assertStatus(200);

        $this->assertDatabaseHas('subcategories', [
            'id'        => $subcategory->id,
            'published' => false
        ]);
    }
}