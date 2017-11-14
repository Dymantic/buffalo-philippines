<?php


namespace Tests\Feature\Products;


use App\Products\Subcategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteSubcategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_subcategory_may_be_deleted()
    {
        $this->disableExceptionHandling();

        $subcategory = factory(Subcategory::class)->create();

        $response = $this->asLoggedInUser()->delete("/admin/subcategories/{$subcategory->id}");
        $response->assertStatus(302);
        $response->assertRedirect("/admin/categories/{$subcategory->category_id}");

        $this->assertDatabaseMissing('subcategories', ['id' => $subcategory->id]);
    }
}