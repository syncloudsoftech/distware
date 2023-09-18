<?php

namespace App\Http\Controllers;

use App\Http\Requests\DownloadRequest;
use App\Models\License;
use App\Models\Update;
use Illuminate\Validation\ValidationException;

class HomeController extends Controller
{
    public function download(DownloadRequest $request)
    {
        $data = $request->validated();
        $exists = License::query()
            ->where('code', $data['code'])
            ->where('expires_at', '>=', now())
            ->where('status', '!=', 'revoked')
            ->exists();
        if (! $exists) {
            throw ValidationException::withMessages([
                'code' => __('validation.exists', ['attribute' => 'license']),
            ]);
        }

        /** @var Update|null $update */
        $update = Update::query()->where('published', true)->latest()->first();
        $installers = $update?->getMedia('installers');

        return view('home', compact('installers', 'update'))
            ->with($data);
    }
}
