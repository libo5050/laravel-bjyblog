<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Admin\CURD\TestDestroy;
use Tests\Feature\Admin\CURD\TestForceDelete;
use Tests\Feature\Admin\CURD\TestIndex;
use Tests\Feature\Admin\CURD\TestRestore;

class CommentControllerTest extends TestCase
{
    use TestIndex, TestDestroy, TestRestore, TestForceDelete;
    protected $urlPrefix = 'admin/comment/';
    protected $table = 'comments';

    public function testReplaceView()
    {
        $this->adminGet('replaceView')
            ->assertStatus(200);
    }

    public function testReplace()
    {
        $this->adminPost('replace', [
            'search' => '评论',
            'replace' => '替换'
        ])->assertSessionHasAll([
            'laravel-flash' => [
                [
                    'alert-message' => '修改成功',
                    'alert-type' => 'success'
                ]
            ]
        ]);

        $this->assertDatabaseMissing('comments', [
            'content' => '评论的内容'
        ]);

        $this->assertDatabaseHas('comments', [
            'content' => '替换的内容'
        ]);
    }
}
