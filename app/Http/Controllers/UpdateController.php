<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCreateOrUpdateRequest;
use App\Models\Update;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use PHPHtmlParser\Dom;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class UpdateController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Update::class);
    }

    public function index()
    {
        return view('updates.index');
    }

    public function create()
    {
        return view('updates.create');
    }

    public function store(UpdateCreateOrUpdateRequest $request)
    {
        $data = $request->validated();
        $exists = Update::query()
            ->where('version', $data['version'])
            ->exists();
        if ($exists) {
            throw ValidationException::withMessages([
                'version' => __('validation.unique', ['attribute' => 'version']),
            ]);
        }

        $dom = new Dom();
        $dom->loadStr($data['changelog']);
        $end = $dom->lastChild();
        $end->setAttribute('style', 'margin-bottom: 0;');
        $data['changelog'] = (string) $dom;

        $update = Update::query()->create($data);
        flash()->success(__('Update ":version" has been added to system.', ['version' => $update->version]));

        return redirect()->route('updates.show', $update);
    }

    public function show(Update $update)
    {
        return view('updates.show', compact('update'));
    }

    public function edit(Update $update)
    {
        return view('updates.edit', compact('update'));
    }

    public function update(UpdateCreateOrUpdateRequest $request, Update $update)
    {
        $data = $request->validated();
        $exists = Update::query()
            ->where('version', $data['version'])
            ->whereKeyNot($update->getKey())
            ->exists();
        if ($exists) {
            throw ValidationException::withMessages([
                'version' => __('validation.unique', ['attribute' => 'version']),
            ]);
        }

        $dom = new Dom();
        $dom->loadStr($data['changelog']);
        $end = $dom->lastChild();
        $end->setAttribute('style', 'margin-bottom: 0;');
        $data['changelog'] = (string) $dom;

        $data['published'] = $data['published'] ?? false;

        $update->fill($data);
        $update->save();
        flash()->success(__('Update ":version" information has been updated.', ['version' => $update->version]));

        return redirect()->route('updates.show', $update);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Update $update)
    {
        $update->delete();
        flash()->info(__('Update ":version" has been deleted from system.', ['version' => $update->version]));

        return redirect()->route('updates.index');
    }

    public function attach(Request $request, Update $update)
    {
        $this->authorize('update', $update);
        $data = $this->validate($request, [
            'platform' => ['required', 'string', Rule::in(array_keys(config('fixtures.platforms')))],
            'file' => ['required', 'file', 'max:'.config('media-library.max_file_size')],
        ]);
        /** @var UploadedFile $file */
        $file = $data['file'];
        $update->addMedia($file)
            ->usingFileName($name = Str::random(10).'.'.$file->getClientOriginalExtension())
            ->usingName($file->getClientOriginalName())
            ->withCustomProperties([
                'original_file_name' => $file->getClientOriginalName(),
                'platform' => $data['platform'],
            ])
            ->toMediaCollection('installers');
        flash()->info(__('Installer was uploaded to update ":version".', ['version' => $update->version]));

        return redirect()->route('updates.show', $update);
    }

    public function detach(Update $update, Media $installer)
    {
        $this->authorize('update', $update);
        /** @var Media|null $existing */
        $existing = $update->getMedia('installers')
            ->where('id', $installer->getKey())
            ->first();
        if ($existing) {
            $existing->delete();
        }

        flash()->info(__('Installer attached to update ":version" was deleted.', ['version' => $update->version]));

        return redirect()->route('updates.show', $update);
    }

    public function download(Update $update, Media $installer)
    {
        abort_if(! $update->published, 404);

        return response()
            ->download(
                $installer->getPath(),
                $installer->getCustomProperty('original_file_name'),
                ['content-type' => $installer->mime_type]
            );
    }
}
