<?php

namespace Tests\Feature\Products;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateCategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_category_can_be_created()
    {
        $this->disableExceptionHandling();

        $response = $this->asLoggedInUser()->json("POST", "/admin/categories", [
            'title'       => 'TEST TITLE',
            'description' => 'TEST DESCRIPTION'
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('categories', [
            'title'       => 'TEST TITLE',
            'description' => 'TEST DESCRIPTION'
        ]);
    }

    /**
     * @test
     */
    public function the_category_title_is_required()
    {
        $response = $this->asLoggedInUser()->json("POST", "/admin/categories", [
            'title'       => '',
            'description' => 'TEST DESCRIPTION'
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('title', $response->json()['errors']);
    }

    /**
     * @test
     */
    public function the_title_cannot_be_longer_than_255_characters()
    {
        $response = $this->asLoggedInUser()->json("POST", "/admin/categories", [
            'title'       => str_repeat('X', 260),
            'description' => 'TEST DESCRIPTION'
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('title', $response->json()['errors']);
    }

    /**
     *@test
     */
    public function the_description_may_be_empty()
    {
        $this->disableExceptionHandling();

        $response = $this->asLoggedInUser()->json("POST", "/admin/categories", [
            'title'       => 'TEST TITLE',
            'description' => ''
        ]);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function a_created_category_has_a_slug()
    {
        $this->disableExceptionHandling();

        $response = $this->asLoggedInUser()->json("POST", "/admin/categories", [
            'title'       => 'TEST TITLE',
            'description' => 'TEST DESCRIPTION'
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('categories', [
            'title'       => 'TEST TITLE',
            'slug'        => 'test-title',
            'description' => 'TEST DESCRIPTION'
        ]);
    }
}