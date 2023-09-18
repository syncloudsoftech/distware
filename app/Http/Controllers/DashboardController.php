<?php

namespace App\Http\Controllers;

use App\Http\Resources\LicenseResource;
use App\Http\Resources\UserResource;
use App\Models\License;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    public function search(Request $request)
    {
        $data = $this->validate($request, [
            'index' => ['required', 'string', Rule::in(['licenses', 'users'])],
            'q' => ['nullable', 'string'],
        ]);

        $query = match ($data['index']) {
            'licenses' => License::search($data['q'] ?: ''),
            'users' => User::search($data['q'] ?: ''),
            default => throw new \InvalidArgumentException(
                "Search index '{$data['index']}' is unrecognized." // impossible
            )
        };

        $matches = $query->paginate(5);

        return match ($data['index']) {
            'licenses' => LicenseResource::collection($matches),
            'users' => UserResource::collection($matches),
            default => throw new \InvalidArgumentException(
                "Search index '{$data['index']}' is unrecognized." // impossible
            )
        };
    }
}
