<?php


namespace Tests\Feature\Products;


use App\Products\ToolGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateToolGroupTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function an_existing_tool_group_can_be_updated()
    {
        $this->disableExceptionHandling();

        $tool_group = factory(ToolGroup::class)->create([
            'title'       => 'OLD TITLE',
            'description' => 'OLD DESCRIPTION'
        ]);

        $response = $this->asLoggedInUser()->json('POST', "/admin/tool-groups/{$tool_group->id}", [
            'title'       => 'NEW TITLE',
            'description' => 'NEW DESCRIPTION'
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('tool_groups', [
            'id'          => $tool_group->id,
            'title'       => 'NEW TITLE',
            'description' => 'NEW DESCRIPTION'
        ]);
    }

    /**
     *@test
     */
    public function successfully_updating_a_tool_group_responds_with_the_updated_data()
    {
        $this->disableExceptionHandling();

        $tool_group = factory(ToolGroup::class)->create();

        $response = $this->asLoggedInUser()->json('POST', "/admin/tool-groups/{$tool_group->id}", [
            'title'       => 'NEW TITLE',
            'description' => 'NEW DESCRIPTION'
        ]);
        $response->assertStatus(200);

        $this->assertEquals($tool_group->fresh()->toJsonableArray(), $response->decodeResponseJson());
    }

    /**
     *@test
     */
    public function a_tool_group_can_be_updated_with_an_empty_description()
    {
        $this->disableExceptionHandling();

        $tool_group = factory(ToolGroup::class)->create([
            'title'       => 'OLD TITLE',
            'description' => 'OLD DESCRIPTION'
        ]);

        $response = $this->asLoggedInUser()->json('POST', "/admin/tool-groups/{$tool_group->id}", [
            'title'       => 'NEW TITLE',
            'description' => ''
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('tool_groups', [
            'id'          => $tool_group->id,
            'title'       => 'NEW TITLE',
            'description' => null
        ]);
    }

    /**
     *@test
     */
    public function the_tool_group_title_is_still_required()
    {
        $tool_group = factory(ToolGroup::class)->create();

        $response = $this->asLoggedInUser()->json('POST', "/admin/tool-groups/{$tool_group->id}", [
            'title'       => '',
            'description' => 'NEW DESCRIPTION'
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('title', $response->decodeResponseJson()['errors']);
    }

    /**
     *@test
     */
    public function the_tool_group_title_cannot_exceed_255_characters()
    {
        $tool_group = factory(ToolGroup::class)->create();

        $response = $this->asLoggedInUser()->json('POST', "/admin/tool-groups/{$tool_group->id}", [
            'title'       => str_repeat('X', 260),
            'description' => 'NEW DESCRIPTION'
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('title', $response->decodeResponseJson()['errors']);
    }
}