<?php


namespace Tests\Unit\Products;


use App\Products\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\Media;
use Tests\TestCase;

class CategoryImagesTest extends TestCase
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
    public function an_image_can_be_set_on_a_category()
    {
        $category = factory(Category::class)->create();

        $image = $category->setImage(UploadedFile::fake()->image('testpic.png'));

        $this->assertInstanceOf(Media::class, $image);

        $this->assertTrue($category->fresh()->getFirstMedia(Category::MAIN_IMG)->is($image));
    }

    /**
     *@test
     */
    public function a_thumbnail_conversion_is_made()
    {
        $category = factory(Category::class)->create();

        $image = $category->setImage(UploadedFile::fake()->image('testpic.png'));

        $this->assertTrue(file_exists($image->getPath('thumb')));
    }

    /**
     *@test
     */
    public function setting_an_image_overwrites_any_previous_images()
    {
        $category = factory(Category::class)->create();
        $image = $category->setImage(UploadedFile::fake()->image('testpic.png'));

        $this->assertCount(1, $category->fresh()->getMedia(Category::MAIN_IMG));

        $image = $category->setImage(UploadedFile::fake()->image('new_testpic.png'));

        $this->assertCount(1, $category->fresh()->getMedia(Category::MAIN_IMG));
    }

    /**
     *@test
     */
    public function the_set_images_url_can_be_retrieved()
    {
        $category = factory(Category::class)->create();
        $image = $category->setImage(UploadedFile::fake()->image('testpic.png'));

        $this->assertEquals($image->getUrl(), $category->fresh()->imageUrl());
        $this->assertEquals($image->getUrl('thumb'), $category->fresh()->imageUrl('thumb'));
    }

    /**
     *@test
     */
    public function a_category_has_a_default_image()
    {
        $category = factory(Category::class)->create();
        $this->assertCount(0, $category->fresh()->getMedia(Category::MAIN_IMG));

        $this->assertEquals(Category::DEFAULT_IMG_SRC, $category->fresh()->imageUrl());
        $this->assertEquals(Category::DEFAULT_IMG_SRC, $category->fresh()->imageUrl('thumb'));
    }

    /**
     *@test
     */
    public function the_category_image_can_be_cleared()
    {
        $category = factory(Category::class)->create();
        $image = $category->setImage(UploadedFile::fake()->image('testpic.png'));
        $this->assertCount(1, $category->fresh()->getMedia(Category::MAIN_IMG));

        $category->clearImage();

        $this->assertCount(0, $category->fresh()->getMedia(Category::MAIN_IMG));
    }
}