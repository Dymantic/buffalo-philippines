<?php


namespace Tests\Unit\Products;


use App\Products\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductGalleryImagesTest extends TestCase
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
    public function a_gallery_image_can_be_added_to_the_product()
    {
        $product = factory(Product::class)->create();

        $image = $product->addGalleryImage(UploadedFile::fake()->image('fake-img.png'));

        $this->assertCount(1, $product->fresh()->getMedia(Product::GALLERY_IMGS));
        $this->assertTrue($product->fresh()->getFirstMedia(Product::GALLERY_IMGS)->is($image));
        $this->assertTrue(file_exists($image->getPath()));
    }

    /**
     *@test
     */
    public function a_thumbnail_conversion_is_made()
    {
        $product = factory(Product::class)->create();

        $image = $product->addGalleryImage(UploadedFile::fake()->image('testpic.png'));

        $this->assertTrue(file_exists($image->getPath('thumb')));
    }

    /**
     *@test
     */
    public function a_web_conversion_is_made()
    {
        $product = factory(Product::class)->create();

        $image = $product->addGalleryImage(UploadedFile::fake()->image('testpic.png'));

        $this->assertTrue(file_exists($image->getPath('web')));
    }
}