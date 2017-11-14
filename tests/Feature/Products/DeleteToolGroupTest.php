<?php


namespace Tests\Feature\Products;


use App\Products\ToolGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteToolGroupTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_tool_group_can_be_deleted()
    {
        $this->disableExceptionHandling();

        $tool_group = factory(ToolGroup::class)->create();

        $response = $this->asLoggedInUser()->delete("/admin/tool-groups/{$tool_group->id}");
        $response->assertStatus(302);
        $response->assertRedirect("/admin/subcategories/{$tool_group->subcategory_id}");

        $this->assertDatabaseMissing('tool_groups', [
            'id' => $tool_group->id
        ]);

    }
}