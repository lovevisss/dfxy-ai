<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LinkManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        config(['app.key' => 'base64:'.base64_encode(str_repeat('a', 32))]);
    }

    private function link(): Link
    {
        $category = Category::create(['name' => '常用工具', 'level' => 1]);

        return Link::create(['title' => '示例工具', 'url' => 'https://example.com', 'desc' => '工具介绍', 'category_id' => $category->id]);
    }

    public function test_guests_can_browse_but_cannot_see_edit_controls(): void
    {
        $link = $this->link();
        $this->get(route('link.index'))->assertOk()->assertSee('示例工具')
            ->assertSee('登录管理')->assertDontSee(route('link.edit', $link));
        $this->assertFalse($link->editable());
    }

    public function test_all_management_routes_require_login_and_leave_data_unchanged(): void
    {
        $link = $this->link();
        foreach ([['GET', '/link/create'], ['GET', "/link/{$link->id}/edit"], ['POST', '/link'], ['PUT', "/link/{$link->id}"], ['PATCH', "/link/{$link->id}"], ['DELETE', "/link/{$link->id}"]] as [$method, $url]) {
            $this->call($method, $url, ['title' => 'unauthorized'])->assertRedirect(route('login'));
        }
        $this->putJson(route('link.update', $link), ['title' => 'unauthorized'])->assertUnauthorized();
        $this->assertDatabaseCount('links', 1);
        $this->assertSame('示例工具', $link->fresh()->title);
    }

    public function test_authenticated_users_can_open_forms_create_and_update(): void
    {
        $link = $this->link();
        $this->actingAs(User::factory()->create());
        $this->assertTrue($link->editable());
        $this->get(route('link.index'))->assertOk()->assertSee(route('link.edit', $link));
        $this->get(route('link.create'))->assertOk()->assertSee('multipart/form-data');
        $this->get(route('link.edit', $link))->assertOk()->assertSee('保存修改');
        $this->post(route('link.store'), ['title' => '新工具', 'url' => 'https://new.example.com', 'category_id' => $link->category_id])->assertRedirect(route('link.index'));
        $this->put(route('link.update', $link), ['title' => '更新工具', 'url' => $link->url, 'desc' => '新介绍', 'category_id' => $link->category_id, 'id' => 999])->assertRedirect(route('link.index'));
        $this->assertDatabaseHas('links', ['id' => $link->id, 'title' => '更新工具']);
        $this->assertDatabaseCount('links', 2);
    }

    public function test_invalid_updates_are_rejected_and_input_is_preserved(): void
    {
        $link = $this->link();
        $this->actingAs(User::factory()->create())->from(route('link.edit', $link))
            ->put(route('link.update', $link), ['title' => '保留输入', 'url' => 'javascript:alert(1)', 'category_id' => 999])
            ->assertSessionHasErrors(['url', 'category_id'])->assertSessionHasInput('title', '保留输入');
        $this->assertSame('示例工具', $link->fresh()->title);
        $this->get(route('link.edit', $link))->assertSee('保留输入');
    }

    public function test_child_categories_and_uncategorized_links_are_visible(): void
    {
        $category = Category::create(['name' => '子分类', 'level' => 2]);
        Link::create(['title' => '子分类工具', 'url' => 'https://child.example.com', 'category_id' => $category->id]);
        Link::create(['title' => '未归类工具', 'url' => 'https://other.example.com']);
        $this->get(route('link.index'))->assertOk()->assertSee('子分类工具')->assertSee('未归类工具');
    }

    public function test_login_returns_user_to_requested_edit_page(): void
    {
        $link = $this->link();
        $user = User::factory()->create();
        $this->get(route('link.edit', $link))->assertRedirect(route('login'));
        $this->post(route('login'), ['email' => $user->email, 'password' => 'password'])
            ->assertRedirect(route('link.edit', $link));
    }

    public function test_images_can_be_uploaded_replaced_and_preserved(): void
    {
        Storage::fake('public');
        Queue::fake();
        $this->actingAs(User::factory()->create());
        $this->post(route('link.store'), [
            'title' => '图标测试',
            'url' => 'https://image.example.com',
            'image_path' => UploadedFile::fake()->image('first.png'),
        ])->assertRedirect(route('link.index'));
        $link = Link::first();
        $original = $link->getFirstMedia('image');
        $this->assertNotNull($original);
        $data = ['title' => $link->title, 'url' => $link->url];
        $this->put(route('link.update', $link), $data)->assertRedirect(route('link.index'));
        $this->assertSame($original->id, $link->fresh()->getFirstMedia('image')->id);
        $this->put(route('link.update', $link), $data + [
            'image_path' => UploadedFile::fake()->image('second.png'),
        ])->assertRedirect(route('link.index'));
        $this->assertCount(1, $link->fresh()->getMedia('image'));
        $this->assertSame('second.png', $link->fresh()->getFirstMedia('image')->file_name);
        $this->assertDatabaseMissing('media', ['id' => $original->id]);
    }
}
