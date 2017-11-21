<?php


namespace Tests\Unit\Products;


use App\Products\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublishableTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_publishable_model_has_a_published_scope()
    {
        $published = factory(Product::class, 2)->create(['published' => true]);
        $unpublished = factory(Product::class, 3)->create(['published' => false]);

        $scoped = Product::published()->get();

        $this->assertCount(2, $scoped);

        $published->each(function($product) use ($scoped) {
            $this->assertTrue($scoped->contains($product));
        });
    }
}