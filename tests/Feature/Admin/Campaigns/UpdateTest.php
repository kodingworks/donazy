<?php

namespace Tests\Feature\Admin\Campaigns;

use App\Models\Campaign;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Feature\Admin\TestCase;

class UpdateTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function isUpdatedCampaign(): void
    {
        Storage::fake('public');

        /** @var Campaign $campaign */
        $campaign = Campaign::factory()->published()->create();

        $data = [
            'name' => 'Campaign Baru',
            'description' => $this->faker->text(),
            'funds' => 15000000,
            'closed_at' => null,
            'cover' => UploadedFile::fake()->image('cover.jpg'),
            'unique_code_sufix' => 1,
        ];

        $response = $this
            ->actingAs($this->user)
            ->put(route('admin::campaigns.update', $campaign), $data);

        $response->assertStatus(Response::HTTP_FOUND);

        $campaign->refresh();

        $this->assertEquals($data['name'], $campaign->name);
        $this->assertEquals($data['funds'], $campaign->funds);
        $this->assertNull($campaign->closed_at);
        $this->assertNull($campaign->published_at);
        $this->assertTrue($campaign->getMedia()->count() == 1);
    }
}
