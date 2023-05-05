<?php

namespace Tests\Feature\Admin\Sliders;

use App\Models\Slider;
use Illuminate\Http\Response;
use Tests\Feature\Admin\TestCase;

class DeleteTest extends TestCase
{
    /** @test */
    public function isCanBeDeleted(): void
    {
        /** @var Slider */
        $slider = Slider::factory()->create();

        $response = $this
            ->actingAs($this->user)
            ->delete(route('admin::sliders.destroy', $slider));

        $response
            ->assertStatus(Response::HTTP_FOUND)
            ->assertSessionDoesntHaveErrors();

        $this->assertDatabaseMissing('sliders', ['id' => $slider->id]);
    }
}
