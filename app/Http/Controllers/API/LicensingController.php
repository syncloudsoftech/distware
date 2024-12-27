<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\LicenseResource;
use App\Http\Resources\UpdateResource;
use App\Models\License;
use App\Models\Machine;
use App\Models\Update;
use App\Notifications\LicenseActivated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class LicensingController extends Controller
{
    public function activate(Request $request)
    {
        $data = $this->validate($request, [
            'license' => ['required', 'string'],
            'machine' => ['required', 'string', 'uuid'],
            'platform' => ['required', 'string'],
        ]);
        /** @var License|null $license */
        $license = License::query()
            ->where('code', $data['license'])
            ->where('expires_at', '>=', now())
            ->where('status', '!=', 'revoked')
            ->first();
        if (! $license) {
            throw ValidationException::withMessages([
                'license' => __('validation.exists', ['attribute' => 'license']),
            ]);
        }

        if ($license->status === 'fresh') {
            /** @var Machine|null $machine */
            $machine = $license->machines()->latest()->first();
            if ($machine && $machine->fingerprint === $data['machine']) {
                $machine->ip = $request->ip();
                $machine->last_active_at = now();
                $machine->save();
            } else {
                $machine = $license->machines()->create([
                    'fingerprint' => $data['machine'],
                    'platform' => $data['platform'],
                    'ip' => $request->ip(),
                    'last_active_at' => now(),
                ]);
            }

            $license->status = 'active';
            $license->save();

            Notification::route('slack', config('services.slack.notifications.channel'))
                ->notify(new LicenseActivated($license, $machine));
        } else {
            /** @var Machine|null $machine */
            $machine = $license->machines()->latest()->first();
            if ($machine && $machine->fingerprint !== $data['machine']) {
                throw ValidationException::withMessages([
                    'machine' => __('validation.exists', ['attribute' => 'machine']),
                ]);
            }

            $machine->ip = $request->ip();
            $machine->last_active_at = now();
            $machine->save();
        }

        return LicenseResource::make($license);
    }

    public function heartbeat(Request $request)
    {
        $data = $this->validate($request, [
            'license' => ['required', 'string'],
            'machine' => ['required', 'string', 'uuid'],
        ]);
        /** @var License|null $license */
        $license = License::query()
            ->where('code', $data['license'])
            ->where('expires_at', '>=', now())
            ->where('status', '!=', 'revoked')
            ->first();
        if (! $license) {
            throw ValidationException::withMessages([
                'license' => __('validation.exists', ['attribute' => 'license']),
            ]);
        }

        /** @var Machine|null $machine */
        $machine = $license->machines()
            ->where('fingerprint', $data['machine'])
            ->first();
        if (! $machine) {
            throw ValidationException::withMessages([
                'machine' => __('validation.exists', ['attribute' => 'machine']),
            ]);
        }

        $machine->ip = $request->ip();
        $machine->last_active_at = now();
        $machine->save();

        return LicenseResource::make($license);
    }

    public function updates(Request $request)
    {
        $data = $this->validate($request, [
            'license' => ['required', 'string'],
            'machine' => ['required', 'string', 'uuid'],
            'platform' => ['required', 'string', Rule::in(array_keys(config('fixtures.platforms')))],
        ]);
        /** @var License|null $license */
        $license = License::query()
            ->where('code', $data['license'])
            ->where('expires_at', '>=', now())
            ->where('status', '!=', 'revoked')
            ->first();
        if (! $license) {
            throw ValidationException::withMessages([
                'license' => __('validation.exists', ['attribute' => 'license']),
            ]);
        }

        /** @var Machine|null $machine */
        $machine = $license->machines()
            ->where('fingerprint', $data['machine'])
            ->first();
        if (! $machine) {
            throw ValidationException::withMessages([
                'machine' => __('validation.exists', ['attribute' => 'machine']),
            ]);
        }

        /** @var Update $update */
        $update = Update::query()
            ->where('published', true)
            ->latest()
            ->firstOrFail();
        $installer = $update->getMedia('installers')
            ->filter(function (Media $media) use ($data) {
                return $media->getCustomProperty('platform') === $data['platform'];
            })
            ->first();
        abort_if(empty($installer), 404, 'No installers uploaded.');

        return UpdateResource::make($update)
            ->additional([
                'download' => URL::signedRoute('updates.download', [$update, $installer], now()->addDay()),
            ]);
    }
}
