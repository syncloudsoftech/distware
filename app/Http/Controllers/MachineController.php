<?php

namespace App\Http\Controllers;

use App\Models\Machine;

class MachineController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Machine::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('machines.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Machine $machine)
    {
        return view('machines.show', compact('machine'));
    }
}
