<?php

namespace Tests\Feature\Api\Campaigns;

use Illuminate\Http\Response;
use Tests\TestCase;

class IndexTest extends TestCase
{
    /** @test */
    public function isResponseSuccessfully(): void
    {
        $response = $this->get('/api/campaigns', [
            'X-Requested-With' => 'XMLHttpRequest',
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }
}
