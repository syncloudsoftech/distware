<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Http\Resources\LicenseResource;
use App\Http\Resources\UserResource;
use App\Models\License;
use App\Models\User;

class DashboardController extends Controller
{
    public function search(SearchRequest $request)
    {
        $data = $request->validated();
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
