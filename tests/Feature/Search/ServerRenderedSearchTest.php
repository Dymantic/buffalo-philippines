<?php


namespace Tests\Feature\Search;


use App\Products\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServerRenderedSearchTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function search_in_admin_can_be_done_by_requesting_search_page_with_query()
    {
        $matching = collect([]);
        $matching->push(factory(Product::class)->create(['title' => 'MATCHING TITLE']));
        $matching->push(factory(Product::class)->create(['code' => 'CODE_MATCHES']));
        factory(Product::class, 3)->create();

        $response = $this->asLoggedInUser()->get("/admin/search/products?q=match");
        $response->assertStatus(200);

        $this->assertEquals($matching->map->toJsonableArray(), $response->original->getData()['products']);
        $this->assertEquals('match', $response->original->getData()['search_term']);
    }
}