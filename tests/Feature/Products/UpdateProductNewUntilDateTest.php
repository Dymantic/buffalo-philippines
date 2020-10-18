<?php


namespace Tests\Feature\Products;


use App\Products\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class UpdateProductNewUntilDateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_products_new_until_date_can_be_added_to()
    {
        $this->disableExceptionHandling();

        $product = factory(Product::class)->create(['new_until' => Carbon::today()]);

        $response = $this->asLoggedInUser()->json('POST', "/admin/products/{$product->id}/new-until-date", [
            'add_days' => 20
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'id'        => $product->id,
            'new_until' => Carbon::today()->addDays(20)->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * @test
     */
    public function successfully_updating_the_new_until_date_responds_with_updated_data()
    {
        $this->disableExceptionHandling();

        $product = factory(Product::class)->create(['new_until' => Carbon::today()]);

        $response = $this->asLoggedInUser()->json('POST', "/admin/products/{$product->id}/new-until-date", [
            'add_days' => 20
        ]);
        $response->assertStatus(200);

        $expected = [
            'product_id' => $product->id,
            'is_new'     => true,
            'new_until'  => $product->fresh()->new_until->format('Y-m-d')
        ];

        $this->assertEquals($expected, $response->json());
    }

    /**
     * @test
     */
    public function a_products_new_until_date_can_be_subtracted_from()
    {
        $this->disableExceptionHandling();

        $product = factory(Product::class)->create(['new_until' => Carbon::today()]);

        $response = $this->asLoggedInUser()->json('POST', "/admin/products/{$product->id}/new-until-date", [
            'add_days' => -20
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'id'        => $product->id,
            'new_until' => Carbon::today()->subDays(20)->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * @test
     */
    public function adding_days_to_a_past_new_until_date_adds_from_the_current_date()
    {
        $this->disableExceptionHandling();

        $product = factory(Product::class)->create(['new_until' => Carbon::today()->subMonth()]);

        $response = $this->asLoggedInUser()->json('POST', "/admin/products/{$product->id}/new-until-date", [
            'add_days' => 20
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'id'        => $product->id,
            'new_until' => Carbon::today()->addDays(20)->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * @test
     */
    public function the_add_days_field_is_required()
    {
        $product = factory(Product::class)->create(['new_until' => Carbon::today()->subMonth()]);

        $response = $this->asLoggedInUser()->json('POST', "/admin/products/{$product->id}/new-until-date", [
            'add_days' => ''
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('add_days', $response->json()['errors']);
    }

    /**
     * @test
     */
    public function the_add_days_filed_must_be_an_integer()
    {
        $product = factory(Product::class)->create(['new_until' => Carbon::today()->subMonth()]);

        $response = $this->asLoggedInUser()->json('POST', "/admin/products/{$product->id}/new-until-date", [
            'add_days' => 'NOT-AN-INTEGER'
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('add_days', $response->json()['errors']);
    }
}