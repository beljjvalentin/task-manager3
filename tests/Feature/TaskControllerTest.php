<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TaskCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_all_tasks()
    {
        Task::factory()->count(5)->create();

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200)
            ->assertJsonCount(5, 'tasks');
    }

    /** @test */
    public function it_can_create_a_task()
    {
        $category = TaskCategory::factory()->create();

        $data = [
            'title' => 'Test Task',
            'date' => '2024-09-01',
            'category_id' => $category->id,
            'urgency' => 1
        ];

        $response = $this->postJson('/api/tasks', $data);

        $response->assertStatus(201)
            ->assertJson(['task' => $data]);
    }

    /** @test */
    public function it_can_show_a_task()
    {
        $task = Task::factory()->create();

        $response = $this->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJson(['task' => $task->toArray()]);
    }

    /** @test */
    public function it_can_update_a_task()
    {
        $task = Task::factory()->create();
        $category = TaskCategory::factory()->create();

        $data = [
            'title' => 'Updated Task',
            'date' => '2024-09-02',
            'category_id' => $category->id,
        ];

        $response = $this->putJson("/api/tasks/{$task->id}", $data);

        $response->assertStatus(200)
            ->assertJson(['task' => $data]);
    }

    /** @test */
    public function it_can_delete_a_task()
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Task deleted successfully']);
    }
}
