<?php


namespace Tests\Feature\Products;


use App\Products\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UploadMainProductImageTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        collect(Storage::disk('test_media')->allDirectories())->each(function($directory) {
            Storage::deleteDirectory($directory);
        });
    }

    /**
     *@test
     */
    public function an_image_can_be_uploaded_as_the_main_product_image()
    {
        $this->disableExceptionHandling();

        $product = factory(Product::class)->create();
        $this->assertCount(0, $product->getMedia());

        $response = $this->asLoggedInUser()->json("POST", "/admin/products/{$product->id}/main-image", [
            'image' => UploadedFile::fake()->image('testpic.jpg')
        ]);
        $response->assertStatus(200);

        $this->assertCount(1, $product->fresh()->getMedia(Product::MAIN_IMG));
    }

    /**
     *@test
     */
    public function the_image_is_required()
    {
        $product = factory(Product::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/products/{$product->id}/main-image", [
            'image' => ''
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('image', $response->decodeResponseJson()['errors']);
    }

    /**
     *@test
     */
    public function the_image_must_be_an_image_file()
    {
        $product = factory(Product::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/products/{$product->id}/main-image", [
            'image' => 'NOT-A-FILE'
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('image', $response->decodeResponseJson()['errors']);
    }

    /**
     *@test
     */
    public function the_image_cant_be_a_non_image_file()
    {
        $product = factory(Product::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/products/{$product->id}/main-image", [
            'image' => UploadedFile::fake()->create('not-an-image.doc')
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('image', $response->decodeResponseJson()['errors']);
    }
}