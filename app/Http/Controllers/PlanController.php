<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanCreateOrUpdateRequest;
use App\Models\Plan;
use Illuminate\Validation\ValidationException;
use Quarks\Laravel\Locking\LockedVersionMismatchException;

class PlanController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Plan::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('plans.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('plans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlanCreateOrUpdateRequest $request)
    {
        $data = $request->validated();
        $exists = Plan::query()
            ->where('name', $data['name'])
            ->exists();
        if ($exists) {
            throw ValidationException::withMessages([
                'name' => __('validation.unique', ['attribute' => 'name']),
            ]);
        }

        $data['published'] = $data['published'] ?? false;
        /** @var Plan $plan */
        $plan = Plan::query()->create($data);
        flash()->success(__('Plan ":name" has been added to system.', ['name' => $plan->name]));

        return redirect()->route('plans.show', $plan);
    }

    /**
     * Display the specified resource.
     */
    public function show(Plan $plan)
    {
        return view('plans.show', compact('plan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plan $plan)
    {
        return view('plans.edit', compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PlanCreateOrUpdateRequest $request, Plan $plan)
    {
        $data = $request->validated();
        $exists = Plan::query()
            ->where('name', $data['name'])
            ->whereKeyNot($plan->getKey())
            ->exists();
        if ($exists) {
            throw ValidationException::withMessages([
                'name' => __('validation.unique', ['attribute' => 'name']),
            ]);
        }

        $data['published'] = $data['published'] ?? false;
        $plan->fill($data);
        $plan->fillLockVersion();
        try {
            $plan->save();
        } catch (LockedVersionMismatchException) {
            flash()->warning(__('This plan was already modified elsewhere.'));
            throw ValidationException::withMessages([]);
        }

        flash()->success(__('Plan ":name" information has been updated.', ['name' => $plan->name]));

        return redirect()->route('plans.show', $plan);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plan $plan)
    {
        $plan->delete();
        flash()->info(__('Plan ":name" has been deleted from system.', ['name' => $plan->name]));

        return redirect()->route('plans.index');
    }
}
