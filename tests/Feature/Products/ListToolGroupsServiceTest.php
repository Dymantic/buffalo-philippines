<?php


namespace Tests\Feature\Products;


use App\Products\Subcategory;
use App\Products\ToolGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListToolGroupsServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_list_of_a_subcategories_tool_groups_can_be_fetched()
    {
        $this->disableExceptionHandling();
        $subcategory = factory(Subcategory::class)->create();
        $tool_groups = factory(ToolGroup::class, 10)->create(['subcategory_id' => $subcategory]);

        $response = $this->asLoggedInUser()
                         ->json('GET', "/admin/services/subcategories/{$subcategory->id}/tool-groups");
        $response->assertStatus(200);

        $fetched_tool_groups = $response->decodeResponseJson();

        $this->assertCount(10, $fetched_tool_groups);
        $tool_groups->each(function($tool_group) use ($fetched_tool_groups) {
            $this->assertContains($tool_group->toJsonableArray(), $fetched_tool_groups);
        });
    }
}