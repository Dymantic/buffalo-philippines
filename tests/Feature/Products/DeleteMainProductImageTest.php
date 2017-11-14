<?php


namespace Tests\Feature\Products;


use App\Products\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class DeleteMainProductImageTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function the_main_product_image_may_be_deleted()
    {
        $this->disableExceptionHandling();

        $product = factory(Product::class)->create();
        $product->setMainImage(UploadedFile::fake()->image('testpic.jpg'));
        $this->assertCount(1, $product->getMedia(Product::MAIN_IMG));

        $response = $this->asLoggedInUser()->json("DELETE", "/admin/products/{$product->id}/main-image");
        $response->assertStatus(200);

        $this->assertCount(0, $product->fresh()->getMedia(Product::MAIN_IMG));
    }
}