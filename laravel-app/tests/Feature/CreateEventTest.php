<?php

declare(strict_types=1);

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

describe('CreateEvent', function (): void {
    it('stores the pdf and creates the event', function (): void {
        Storage::fake('local');

        $date = date('Y-m-d', strtotime('now +1 day'));
        $document = UploadedFile::fake()->createWithContent('rules.pdf', "%PDF-1.4\n%%EOF\n");

        $response = $this->post('/events', [
            'name' => 'Event 1',
            'date' => $date,
            'price' => 10000,
            'currency' => 'BRL',
            'document' => $document,
        ], [
            'Accept' => 'application/json',
        ]);

        $response->assertCreated();

        $path = $response->json('document_path');

        expect($path)->toBeString();
        expect(Storage::disk('local')->exists($path))->toBeTrue();

        $this->assertDatabaseHas('events', [
            'id' => $response->json('id'),
            'name' => 'Event 1',
            'date' => $date,
            'price' => 10000,
            'currency' => 'BRL',
            'document_path' => $path,
        ]);
    });

    it('rejects a past date and removes the stored pdf', function (): void {
        Storage::fake('local');

        $response = $this->post('/events', [
            'name' => 'Event 1',
            'date' => '2000-01-01',
            'price' => 10000,
            'document' => UploadedFile::fake()->createWithContent('rules.pdf', "%PDF-1.4\n%%EOF\n"),
        ], [
            'Accept' => 'application/json',
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors('event');
        expect(Storage::disk('local')->allFiles('events'))->toBeEmpty();
    });
});
