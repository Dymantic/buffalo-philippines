<?php


namespace Tests\Feature\Products;


use App\Products\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminProductSearchTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function products_can_be_searched_for_as_an_admin_user()
    {
        $this->disableExceptionHandling();
        $matching = collect([]);

        $matching->push(factory(Product::class)->create([
            'title' => 'MATCHES-ON-TITLE'
        ]));
        $matching->push(factory(Product::class)->create([
            'code' => 'CODE-MATCHES'
        ]));
        factory(Product::class, 3)->create();

        $response = $this->asLoggedInUser()->json("GET", "/admin/services/search/products?q=match");
        $response->assertStatus(200);

        $fetched_products = $response->json();

        $this->assertCount(2, $fetched_products);
        $matching->each(function($match) use ($fetched_products) {
            $this->assertEquals($match->toJsonableArray(), collect($fetched_products)->first(fn($item) => $item['id'] == $match->id));
        });
    }
}