<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();

        if ($user) {
            // Eager load to prevent N+1
            $user = $user->loadMissing(['professions', 'specialties', 'departments']);

            $professions = $user->professions->map(fn ($item) => [
                'id'   => $item->profession->id,
                'name' => $item->profession->name,
            ])->values()->all();

            $specialties = $user->specialties->map(fn ($item) => [
                'id'   => $item->specialty->id,
                'name' => $item->specialty->name,
            ])->values()->all();

            $departments = $user->departments->map(fn ($item) => [
                'id'   => $item->department->id,
                'name' => $item->department->name,
            ])->values()->all();
        }

        $user = $user?->toArray();
        unset($user['user_profession'], $user['user_specialty'], $user['user_department']);

        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'auth' => [
                'user'        => $user,
                'professions' => [
                    'ids'         => array_column($professions ?? [], 'id'),
                    'professions' => array_column($professions ?? [], 'name'),
                ],
                'specialties' => [
                    'ids'         => array_column($specialties ?? [], 'id'),
                    'specialties' => array_column($specialties ?? [], 'name'),
                ],
                'departments' => [
                    'ids'         => array_column($departments ?? [], 'id'),
                    'departments' => array_column($departments ?? [], 'name'),
                ],
            ],
            'sidebarOpen' => ! $request->hasCookie('sidebar_state') || $request->cookie('sidebar_state') === 'true',
        ];
    }
}
