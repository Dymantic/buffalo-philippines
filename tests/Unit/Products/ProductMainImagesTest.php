<?php


namespace Tests\Unit\Products;


use App\Products\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\Models\Media;
use Tests\TestCase;

class ProductMainImagesTest extends TestCase
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
    public function the_main_image_can_be_set_on_the_product()
    {
        $product = factory(Product::class)->create();

        $image = $product->setMainImage(UploadedFile::fake()->image('testpic.png'));

        $this->assertInstanceOf(Media::class, $image);
        $this->assertEquals(Product::MAIN_IMG, $image->collection_name);
        $this->assertCount(1, $product->fresh()->getMedia(Product::MAIN_IMG));
        $this->assertEquals($product->fresh()->getFirstMedia(Product::MAIN_IMG)->id, $image->id);
    }

    /**
     *@test
     */
    public function a_thumbnail_conversion_of_the_main_image_is_created()
    {
        $product = factory(Product::class)->create();

        $image = $product->setMainImage(UploadedFile::fake()->image('testpic.png'));

        $this->assertTrue(file_exists($image->getPath('thumb')));
    }

    /**
     *@test
     */
    public function a_web_conversion_is_created()
    {
        $product = factory(Product::class)->create();

        $image = $product->setMainImage(UploadedFile::fake()->image('testpic.png'));

        $this->assertTrue(file_exists($image->getPath('web')));
    }

    /**
     *@test
     */
    public function setting_a_main_image_overrides_any_previous_main_images()
    {
        $product = factory(Product::class)->create();
        $product->setMainImage(UploadedFile::fake()->image('old_test_pic.png'));

        $image = $product->setMainImage(UploadedFile::fake()->image('new_test_pic.png'));

        $this->assertCount(1, $product->fresh()->getMedia(Product::MAIN_IMG));
        $this->assertTrue(file_exists($image->getPath()));
    }

    /**
     *@test
     */
    public function the_main_image_can_be_cleared()
    {
        $product = factory(Product::class)->create();
        $product->setMainImage(UploadedFile::fake()->image('old_test_pic.png'));
        $this->assertCount(1, $product->fresh()->getMedia(Product::MAIN_IMG));

        $product->clearMainImage();

        $this->assertCount(0, $product->fresh()->getMedia(Product::MAIN_IMG));
    }

    /**
     *@test
     */
    public function a_product_can_get_its_main_image()
    {
        $product = factory(Product::class)->create();
        $image = $product->setMainImage(UploadedFile::fake()->image('old_test_pic.png'));

        $product = $product->fresh();

        $this->assertTrue($product->mainImage()->is($image));
    }

    /**
     *@test
     */
    public function a_product_can_get_its_main_image_url()
    {
        $product = factory(Product::class)->create();
        $image = $product->setMainImage(UploadedFile::fake()->image('old_test_pic.png'));

        $product = $product->fresh();

        $this->assertEquals($image->getUrl(), $product->imageUrl());
        $this->assertEquals($image->getUrl('thumb'), $product->imageUrl('thumb'));
        $this->assertEquals($image->getUrl('web'), $product->imageUrl('web'));
    }

    /**
     *@test
     */
    public function a_product_with_no_main_image_set_has_a_default()
    {
        $product = factory(Product::class)->create();
        $this->assertCount(0, $product->getMedia(Product::MAIN_IMG));

        $product = $product->fresh();

        $this->assertEquals(Product::DEFAULT_MAIN_IMG, $product->imageUrl());
        $this->assertEquals(Product::DEFAULT_MAIN_IMG, $product->imageUrl('thumb'));
        $this->assertEquals(Product::DEFAULT_MAIN_IMG, $product->imageUrl('web'));
    }

    /**
     *@test
     */
    public function new_images_do_not_keep_their_original_filename()
    {
        $product = factory(Product::class)->create();
        $image = $product->setMainImage(UploadedFile::fake()->image('original_name.png'));


        $this->assertNotEquals($image->file_name, 'original_name.png');
    }
}