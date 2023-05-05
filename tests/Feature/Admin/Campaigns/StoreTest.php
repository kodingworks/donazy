<?php

namespace Tests\Feature\Admin\Campaigns;

use App\Models\Campaign;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Feature\Admin\TestCase;

class StoreTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function isCampaignSaved()
    {
        Storage::fake('public');

        $data = [
            'name' => 'Campaign Satu',
            'description' => $this->faker->text(),
            'funds' => 10000000,
            'closed_at' => now()->addWeek()->format('Y-m-d'),
            'publish' => 1,
            'cover' => UploadedFile::fake()->image('cover.jpg'),
            'unique_code_sufix' => 1,
        ];

        $response = $this
            ->actingAs($this->user)
            ->post(route('admin::campaigns.store'), $data);

        $response->assertStatus(Response::HTTP_FOUND);

        $campaign = Campaign::where('name', 'Campaign Satu')->firstOrFail();

        $this->assertEquals($data['name'], $campaign->name);
        $this->assertEquals($data['funds'], $campaign->funds);
        $this->assertNotNull($campaign->closed_at);
        $this->assertNotNull($campaign->published_at);
        $this->assertTrue($campaign->getMedia()->isNotEmpty());
    }
}
