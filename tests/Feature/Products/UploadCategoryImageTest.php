<?php


namespace Tests\Feature\Products;


use App\Products\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UploadCategoryImageTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() :void
    {
        parent::setUp();

        collect(Storage::disk('test_media')->allDirectories())->each(function($directory) {
            Storage::deleteDirectory($directory);
        });
    }

    /**
     *@test
     */
    public function an_image_can_be_uploaded_for_a_given_category()
    {
        $this->disableExceptionHandling();
        $category = factory(Category::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/categories/{$category->id}/image", [
            'image' => UploadedFile::fake()->image('testpic.png')
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('media', [
            'model_id' => $category->id,
            'model_type' => Category::class
        ]);
    }

    /**
     *@test
     */
    public function the_image_is_required()
    {
        $category = factory(Category::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/categories/{$category->id}/image", [
            'image' => ''
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('image', $response->decodeResponseJson()['errors']);

    }

    /**
     *@test
     */
    public function the_image_must_be_a_image_file()
    {
        $category = factory(Category::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/categories/{$category->id}/image", [
            'image' => UploadedFile::fake()->create('test.doc')
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('image', $response->decodeResponseJson()['errors']);
    }

    /**
     *@test
     */
    public function the_category_image_can_be_cleared()
    {
        $this->disableExceptionHandling();
        $category = factory(Category::class)->create();
        $category->setImage(UploadedFile::fake()->image('old_image.png'));

        $response = $this->asLoggedInUser()->json("DELETE", "/admin/categories/{$category->id}/image");
        $response->assertStatus(200);

        $this->assertCount(0, $category->fresh()->getMedia(Category::MAIN_IMG));

        $this->assertDatabaseMissing('media', [
            'model_id' => $category->id,
            'model_type' => Category::class
        ]);
    }
}