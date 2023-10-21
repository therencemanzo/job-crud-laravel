<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Support\Arr;


class JobsControllerTest extends TestCase
{
    use Withfaker;
    use DatabaseTransactions;

    public function test_create_job(): void
    {
        $jobData = [
            'title' => $this->faker->name,
            'description' => $this->faker->sentence,
            'salary' => '1111',
            'company' => $this->faker->word,
            'category' => $this->faker->word
        ];

        $response = $this->post('/api/v1/jobs', $jobData);

        $response->assertStatus(201);


        $response->assertJson(
            fn(AssertableJson $json) =>
            $json->has('data')
        );
  
    }

    public function test_retriable_job(): void
    {
        $response = $this->get('/api/v1/jobs/2');

        $response->assertStatus(200);
        echo 'test';

        $response->assertJson(
            fn(AssertableJson $json) =>
            $json->has('data')
            ->has('data.id')
            ->has('data.title')
        );
    }

    public function test_retriable_jobs(): void
    {
        $response = $this->get('/api/v1/jobs');

        $response->assertStatus(200);

        $response->assertJson(
            fn(AssertableJson $json) =>
            $json->has('data')
            ->has('links')
            ->has('links.next')
            ->etc()
        );
        
    }

    public function test_update_job(): void
    {
        $jobData = [
            'title' => $this->faker->name,
            'description' => $this->faker->sentence,
            'salary' => $this->faker->randomNumber(5),
            'company' => $this->faker->word,
            'category' => $this->faker->word
        ];

        $response = $this->put('/api/v1/jobs/2', $jobData);

        $response->assertStatus(status: 200);


        $response->assertJson(
            fn(AssertableJson $json) =>
            $json->has('data')
        );

        $this->assertDatabaseHas('jobs',[
            'title' => Arr::get($jobData, 'title'),
            'description' => Arr::get($jobData, 'description'),
            'salary' => Arr::get($jobData, 'salary'),
            'company' => Arr::get($jobData, 'company'),
            'category' => Arr::get($jobData, 'category'),
        ]);

    }

    public function test_delete_job(): void
    {
        $response = $this->delete('/api/v1/jobs/2');

        $response->assertStatus(status: 204);

    }
}
