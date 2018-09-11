<?php


namespace Tests\Feature\Products;


use App\Products\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\Models\Media;
use Tests\TestCase;

class UploadProductGalleryImageTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        collect(Storage::disk('test_media')->allDirectories())->each(function ($directory) {
            Storage::deleteDirectory($directory);
        });
    }

    /**
     * @test
     */
    public function an_image_can_be_uploaded_to_a_products_gallery()
    {
        $this->disableExceptionHandling();

        $product = factory(Product::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/products/{$product->id}/gallery-images", [
            'image' => UploadedFile::fake()->image('test-pic.png')
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('media', [
            'model_type' => Product::class,
            'model_id'   => $product->id
        ]);

        $this->assertCount(1, $product->getMedia(Product::GALLERY_IMGS));
    }

    /**
     * @test
     */
    public function successfully_uploading_a_gallery_image_responds_with_the_image_id_and_delete_url()
    {
        $this->disableExceptionHandling();

        $product = factory(Product::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/products/{$product->id}/gallery-images", [
            'image' => UploadedFile::fake()->image('test-pic.png')
        ]);
        $response->assertStatus(200);

        $this->assertCount(1, Media::all());

        $this->assertEquals([
            'image_id'   => Media::first()->id,
            'delete_url' => '/admin/gallery-images/' . Media::first()->id
        ], $response->decodeResponseJson());
    }

    /**
     * @test
     */
    public function the_image_is_required()
    {
        $product = factory(Product::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/products/{$product->id}/gallery-images", [
            'image' => ''
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('image', $response->decodeResponseJson()['errors']);
    }

    /**
     * @test
     */
    public function the_image_must_be_an_actual_file()
    {
        $product = factory(Product::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/products/{$product->id}/gallery-images", [
            'image' => 'NOT-A-FILE'
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('image', $response->decodeResponseJson()['errors']);
    }

    /**
     * @test
     */
    public function the_image_must_be_a_recognised_image_format()
    {
        $product = factory(Product::class)->create();

        $response = $this->asLoggedInUser()->json("POST", "/admin/products/{$product->id}/gallery-images", [
            'image' => UploadedFile::fake()->create('not-a-recognised-image-file.txt')
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('image', $response->decodeResponseJson()['errors']);
    }
}