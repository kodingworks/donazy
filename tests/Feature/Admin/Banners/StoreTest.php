<?php

namespace Tests\Feature\Admin\Banners;

use App\Models\Banner;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Feature\Admin\TestCase;

class StoreTest extends TestCase
{
    /** @test */
    public function isErrorWhenImageIsNull(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->post(route('admin::banners.store'));

        $response->assertSessionHasErrors('image');
    }

    /** @test */
    public function isSaved(): void
    {
        Storage::fake('public');

        $data = [
            'image' => UploadedFile::fake()->image('image.jpg'),
        ];

        $response = $this
            ->actingAs($this->user)
            ->post(route('admin::banners.store'), $data);

        $response->assertStatus(Response::HTTP_FOUND);

        /** @var Banner */
        $banner = Banner::first();
        $this->assertTrue($banner->getMedia()->isNotEmpty());
    }
}
