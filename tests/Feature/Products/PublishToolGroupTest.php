<?php


namespace Tests\Feature\Products;


use App\Products\ToolGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublishToolGroupTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_tool_group_may_be_published()
    {
        $this->disableExceptionHandling();

        $tool_group = factory(ToolGroup::class)->create(['published' => false]);

        $response = $this->asLoggedInUser()->json("POST", "/admin/published-tool-groups", [
            'tool_group_id' => $tool_group->id
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('tool_groups', [
            'id'        => $tool_group->id,
            'published' => true
        ]);
    }

    /**
     *@test
     */
    public function the_tool_group_id_is_required()
    {
        $response = $this->asLoggedInUser()->json("POST", "/admin/published-tool-groups", [
            'tool_group_id' => ''
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('tool_group_id', $response->json()['errors']);
    }

    /**
     *@test
     */
    public function the_tool_group_id_must_be_an_integer()
    {
        $response = $this->asLoggedInUser()->json("POST", "/admin/published-tool-groups", [
            'tool_group_id' => 'NOT-AN-INTEGER'
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('tool_group_id', $response->json()['errors']);
    }

    /**
     *@test
     */
    public function the_tool_group_id_must_exist_in_the_tool_group_table()
    {
        $response = $this->asLoggedInUser()->json("POST", "/admin/published-tool-groups", [
            'tool_group_id' => 999
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('tool_group_id', $response->json()['errors']);
    }

    /**
     *@test
     */
    public function a_published_tool_group_may_be_retracted()
    {
        $this->disableExceptionHandling();

        $tool_group = factory(ToolGroup::class)->create(['published' => true]);

        $response = $this->asLoggedInUser()->json("DELETE", "/admin/published-tool-groups/{$tool_group->id}");
        $response->assertStatus(200);

        $this->assertDatabaseHas('tool_groups', [
            'id'        => $tool_group->id,
            'published' => false
        ]);
    }
}