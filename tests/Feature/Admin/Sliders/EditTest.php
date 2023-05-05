<?php

namespace Tests\Feature\Admin\Sliders;

use App\Models\Slider;
use Illuminate\Http\Response;
use Tests\Feature\Admin\TestCase;

class EditTest extends TestCase
{
    /** @test */
    public function isCanBeRendered(): void
    {
        /** @var Slider */
        $slider = Slider::factory()->create();

        $response = $this
            ->actingAs($this->user)
            ->get(route('admin::sliders.edit', $slider));

        $response->assertStatus(Response::HTTP_OK);
    }
}
