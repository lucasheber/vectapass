<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers;

use App\Application\UseCases\CreateEventUseCase;
use DomainException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class CreateEventController extends Controller
{
    public function __invoke(Request $request, CreateEventUseCase $useCase): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'date' => ['required', 'date_format:Y-m-d'],
            'price' => ['required', 'integer'],
            'currency' => ['sometimes', 'string'],
            'document' => ['required', 'file', 'mimes:pdf'],
        ]);

        $document = $request->file('document');

        if (! $document instanceof UploadedFile) {
            throw ValidationException::withMessages([
                'document' => 'The document must be a PDF file.',
            ]);
        }

        $path = $document->store('events', 'local');

        if ($path === false) {
            abort(500, 'The document could not be stored.');
        }

        try {
            $event = $useCase->execute(
                name: (string) $data['name'],
                date: (string) $data['date'],
                price: (int) $data['price'],
                currency: isset($data['currency']) ? (string) $data['currency'] : 'BRL',
                documentPath: $path,
            );
        } catch (DomainException $exception) {
            Storage::disk('local')->delete($path);

            throw ValidationException::withMessages([
                'event' => $exception->getMessage(),
            ]);
        }

        return response()->json([
            'id' => $event->id()->value(),
            'name' => $event->name(),
            'date' => $event->date()->value()->format('Y-m-d'),
            'price' => $event->price()->amountInCents(),
            'currency' => $event->price()->currency(),
            'document_path' => $event->documentPath(),
        ], Response::HTTP_CREATED);
    }
}
