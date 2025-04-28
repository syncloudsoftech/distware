<?php

namespace App\Http\Controllers;

use App\Http\Requests\LicenseCreateOrUpdateRequest;
use App\Http\Requests\LicenseSendRequest;
use App\Mail\LicenseInfo;
use App\Models\License;
use App\Models\Plan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Quarks\Laravel\Locking\LockedVersionMismatchException;

class LicenseController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(License::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('licenses.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('licenses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LicenseCreateOrUpdateRequest $request)
    {
        $data = $request->validated();
        $plan = Plan::query()->findOrFail($data['plan_id']);
        /** @var License $license */
        $license = License::query()->make($data);
        $license->plan()->associate($plan);
        $license->save();
        flash()->success(__('License ":name" has been added to system.', ['name' => $license->name]));

        return redirect()->route('licenses.show', $license);
    }

    /**
     * Display the specified resource.
     */
    public function show(License $license)
    {
        return view('licenses.show', compact('license'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(License $license)
    {
        return view('licenses.edit', compact('license'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LicenseCreateOrUpdateRequest $request, License $license)
    {
        $data = $request->validated();
        $plan = Plan::query()->findOrFail($data['plan_id']);
        $license->fill($data);
        $license->fillLockVersion();
        $license->plan()->associate($plan);
        try {
            $license->save();
        } catch (LockedVersionMismatchException) {
            flash()->warning(__('This license was already modified elsewhere.'));
            throw ValidationException::withMessages([]);
        }

        flash()->success(__('License ":name" information has been updated.', ['name' => $license->name]));

        return redirect()->route('licenses.show', $license);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(License $license)
    {
        $license->delete();
        flash()->info(__('License ":name" has been deleted from system.', ['name' => $license->name]));

        return redirect()->route('licenses.index');
    }

    public function send(LicenseSendRequest $request, License $license)
    {
        $this->authorize('view', $license);
        $data = $request->validated();
        Mail::to($data['email'])->send(new LicenseInfo($license));
        flash()->success(__('License ":code" details have been sent to :email.', ['code' => $license->short_code, 'data' => $data['email']]));

        return redirect()->route('licenses.show', $license);
    }
}
