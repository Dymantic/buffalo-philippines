<?php


namespace Tests\Feature\Products;


use App\Products\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class DeleteProductGalleryImagesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_gallery_image_can_be_deleted_from_a_product()
    {
        $this->disableExceptionHandling();
        $product = factory(Product::class)->create();
        $image = $product->addGalleryImage(UploadedFile::fake()->image('test-pic.png'));
        $this->assertCount(1, $product->fresh()->getMedia(Product::GALLERY_IMGS));

        $response = $this->asLoggedInUser()->json("DELETE", "/admin/gallery-images/{$image->id}");
        $response->assertStatus(200);

        $this->assertDatabaseMissing('media', ['id' => $image->id]);
        $this->assertCount(0, $product->fresh()->getMedia(Product::GALLERY_IMGS));
    }
}