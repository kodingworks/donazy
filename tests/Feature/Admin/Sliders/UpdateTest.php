<?php

namespace Tests\Feature\Admin\Sliders;

use App\Models\Slider;
use Illuminate\Http\Response;
use Tests\Feature\Admin\TestCase;

class UpdateTest extends TestCase
{
    /** @test */
    public function isCanBeUpdated(): void
    {
        /** @var Slider */
        $slider = Slider::factory()->create();

        $response = $this
            ->actingAs($this->user)
            ->put(route('admin::sliders.update', $slider), [
                'name' => 'Updated slider',
                'campaign_ids' => [2, 3, 4],
            ]);

        $response
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('sliders', [
            'name' => 'Updated slider',
            'campaign_ids' => json_encode([2, 3, 4]),
        ]);
    }
}
