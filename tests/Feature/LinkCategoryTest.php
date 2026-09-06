<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LinkCategoryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        config(['app.key' => 'base64:'.base64_encode(str_repeat('a', 32))]);
    }

    public function test_guests_cannot_manage_categories(): void
    {
        $category = Category::create(['name' => '链接分类', 'level' => 1]);
        foreach ([['GET', '/category'], ['GET', '/category/create'], ['GET', "/category/{$category->id}/edit"], ['POST', '/category'], ['PUT', "/category/{$category->id}"], ['PATCH', "/category/{$category->id}"], ['DELETE', "/category/{$category->id}"]] as [$method, $url]) {
            $this->call($method, $url, ['name' => '未授权修改'])->assertRedirect(route('login'));
        }
        $this->putJson(route('category.update', $category), ['name' => '未授权修改'])->assertUnauthorized();
        $this->assertDatabaseCount('categories', 1);
        $this->assertSame('链接分类', $category->fresh()->name);
        $this->get(route('link.index'))->assertDontSee('管理分类');
    }

    public function test_categories_can_be_created_and_renamed_without_changing_their_type_or_links(): void
    {
        $this->actingAs(User::factory()->create());
        $this->get(route('category.create'))->assertOk()->assertSee('添加链接分类');
        $this->post(route('category.store'), ['name' => '办公平台', 'level' => 2, 'parent_id' => 99])
            ->assertRedirect(route('category.index'));
        $category = Category::first();
        $this->assertDatabaseHas('categories', ['id' => $category->id, 'name' => '办公平台', 'level' => 1, 'parent_id' => 0]);
        $link = Link::create(['title' => '办公系统', 'url' => 'https://example.com', 'category_id' => $category->id]);
        $this->get(route('category.edit', $category))->assertOk()->assertSee('办公平台');
        $this->put(route('category.update', $category), ['name' => '校园办公', 'level' => 2, 'parent_id' => 99])
            ->assertRedirect(route('category.index'));
        $this->assertDatabaseHas('categories', ['id' => $category->id, 'name' => '校园办公', 'level' => 1, 'parent_id' => 0]);
        $this->assertEquals($category->id, $link->fresh()->category_id);
        $this->get(route('link.index'))->assertSee('校园办公')->assertSee('管理分类');
    }

    public function test_ai_categories_cannot_be_listed_or_modified_by_link_category_management(): void
    {
        $ai = Category::create(['name' => 'AI 专属分类', 'level' => 2]);
        $linkCategory = Category::create(['name' => '链接专属分类', 'level' => 1]);
        $this->actingAs(User::factory()->create());
        $this->get(route('category.index'))->assertOk()->assertSee('链接专属分类')->assertDontSee('AI 专属分类');
        $this->get(route('category.edit', $ai))->assertNotFound();
        $this->put(route('category.update', $ai), ['name' => '被改动', 'level' => 1])->assertNotFound();
        $this->assertSame('AI 专属分类', $ai->fresh()->name);
        $this->get(route('category.show', $linkCategory))->assertNotFound();
    }

    public function test_link_forms_and_writes_only_accept_link_categories(): void
    {
        $ai = Category::create(['name' => 'AI 专属分类', 'level' => 2]);
        $category = Category::create(['name' => '链接专属分类', 'level' => 1]);
        $link = Link::create(['title' => '办公系统', 'url' => 'https://example.com', 'category_id' => $category->id]);
        $this->actingAs(User::factory()->create());
        foreach ([route('link.create'), route('link.edit', $link)] as $url) {
            $this->get($url)->assertOk()->assertSee('链接专属分类')->assertDontSee('AI 专属分类');
        }
        $this->post(route('link.store'), ['title' => '不应新增', 'url' => 'https://new.example.com', 'category_id' => $ai->id])->assertSessionHasErrors('category_id');
        $this->put(route('link.update', $link), ['title' => $link->title, 'url' => $link->url, 'category_id' => $ai->id])->assertSessionHasErrors('category_id');
        $this->assertDatabaseCount('links', 1);
        $this->assertEquals($category->id, $link->fresh()->category_id);
        $aiLink = Link::create(['title' => '历史 AI 链接', 'url' => 'https://ai.example.com', 'category_id' => $ai->id]);
        $this->get(route('link.edit', $aiLink))->assertNotFound();
        $this->put(route('link.update', $aiLink), ['title' => '跨分类修改', 'url' => $aiLink->url, 'category_id' => $category->id])->assertNotFound();
        $this->assertSame('历史 AI 链接', $aiLink->fresh()->title);
    }

    public function test_invalid_category_names_are_rejected_and_input_preserved(): void
    {
        $category = Category::create(['name' => '原名称', 'level' => 1]);
        $this->actingAs(User::factory()->create());
        $this->post(route('category.store'), ['name' => ''])->assertSessionHasErrors('name');
        $this->from(route('category.edit', $category))->put(route('category.update', $category), ['name' => str_repeat('a', 256)])
            ->assertSessionHasErrors('name')->assertSessionHasInput('name', str_repeat('a', 256));
        $this->get(route('category.edit', $category))->assertOk()->assertSee('name-error');
        $this->assertSame('原名称', $category->fresh()->name);
        $this->assertDatabaseCount('categories', 1);
    }
}
