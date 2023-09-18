<div class="nav nav-pills flex-column">
    <li class="nav-item">
        <a class="nav-link @if (Route::is('dashboard')) active @endif" href="{{ route('dashboard') }}" @if (Route::is('dashboard')) aria-current="true" @endif>
            <i class="fa-solid fa-gauge fa-fw me-1"></i> {{ __('Dashboard') }}
        </a>
    </li>
    @can('viewAny', App\Models\License::class)
        <li class="nav-item">
            <a class="nav-link @if (Route::is('licenses.*')) active @endif" href="{{ route('licenses.index') }}" @if (Route::is('licenses.*')) aria-current="true" @endif>
                <i class="fa-solid fa-unlock-keyhole fa-fw me-1"></i> {{ __('Licenses') }}
            </a>
        </li>
    @endcan
    @can('viewAny', App\Models\Update::class)
        <li class="nav-item">
            <a class="nav-link @if (Route::is('updates.*')) active @endif" href="{{ route('updates.index') }}" @if (Route::is('updates.*')) aria-current="true" @endif>
                <i class="fa-solid fa-file-zipper fa-fw me-1"></i> {{ __('Software updates') }}
            </a>
        </li>
    @endcan
    @can('viewAny', App\Models\Plan::class)
        <li class="nav-item">
            <a class="nav-link @if (Route::is('plans.*')) active @endif" href="{{ route('plans.index') }}" @if (Route::is('plans.*')) aria-current="true" @endif>
                <i class="fa-solid fa-boxes-stacked fa-fw me-1"></i> {{ __('Pricing plans') }}
            </a>
        </li>
    @endcan
    @can('viewAny', App\Models\User::class)
        <li class="nav-item">
            <a class="nav-link @if (Route::is('users.*')) active @endif" href="{{ route('users.index') }}" @if (Route::is('users.*')) aria-current="true" @endif>
                <i class="fa-solid fa-user-group fa-fw me-1"></i> {{ __('Users & staff') }}
            </a>
        </li>
    @endcan
    @can('viewAny', App\Models\Role::class)
        <li class="nav-item">
            <a class="nav-link @if (Route::is('roles.*')) active @endif" href="{{ route('roles.index') }}" @if (Route::is('roles.*')) aria-current="true" @endif>
                <i class="fa-solid fa-user-lock fa-fw me-1"></i> {{ __('Roles') }}
            </a>
        </li>
    @endcan
</div>
<footer class="d-none d-lg-block py-3">
    <p class="text-center mb-0">
        <small class="text-muted">
            {{ __(':app © :year.', ['app' => config('app.name', 'Laravel'), 'year' => date('Y')]) }}<br>
            {{ __('All rights reserved.') }}
        </small>
    </p>
</footer>
