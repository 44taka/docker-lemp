<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    // 自動でDB初期化してくれる
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', [
            '--class' => 'TodoSeeder',
            '--env' => 'testing',
        ]);
    }

    /**
     * 一覧取得のテスト
     *
     * @return void
     */
    public function test_index(): void
    {
        $response = $this->get('/api/todos');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * 詳細取得のテスト
     *
     * @return void
     */
    public function test_show(): void
    {
        // 200ステータス
        $res_200 = $this->get('/api/todos/1');
        $res_200->assertStatus(Response::HTTP_OK);

        // 404ステータス
        $res_404 = $this->get('/api/todos/aaa');
        $res_404->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * 新規登録のテスト
     *
     * @return void
     */
    public function test_create(): void
    {
        // 成功
        $res_201 = $this->post('/api/todos', ['task' => Str::random(200)]);
        $res_201->assertStatus(Response::HTTP_CREATED);

        // エラー
        $res_400_1 = $this->post('/api/todos');
        $res_400_1->assertStatus(Response::HTTP_BAD_REQUEST);
        $res_400_2 = $this->post('/api/todos', ['task' => Str::random(201)]);
        $res_400_2->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    /**
     * 更新のテスト
     *
     * @return void
     */
    public function test_update(): void
    {
        // 成功
        $res_204 = $this->put('/api/todos/3', ['task' => Str::random(200)]);
        $res_204->assertStatus(Response::HTTP_NO_CONTENT);

        // エラー
        $res_400_1 = $this->put('/api/todos/3');
        $res_400_1->assertStatus(Response::HTTP_BAD_REQUEST);
        $res_400_2 = $this->put('/api/todos/3', ['task' => Str::random(201)]);
        $res_400_2->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    /**
     * 削除のテスト
     *
     * @return void
     */
    public function test_delete(): void
    {
        // 成功
        $res_204 = $this->delete('/api/todos/3');
        $res_204->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
