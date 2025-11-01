<?php

namespace App\Http\Middleware;

use App\Models\MySetting;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        $settings = MySetting::whereIn('key', ['academy_name', 'academy_email','academy_contact_no','logo','address','date_type'])
            ->pluck('value', 'key'); // returns collection: [key => value]

        return array_merge(parent::share($request), [
            'flash' => [
                'success' => fn() => $request->session()->get('success'),
                'error'   => fn() => $request->session()->get('error'),
            ],
            'academy' => [
                'name' => $settings->get('academy_name'),
                'academy_email' => $settings->get('academy_email'),
                'phone' => $settings->get('academy_contact_no'),
                'address' => $settings->get('address'),
                'logo' => "/storage/".$settings->get('logo'),
            ],
            'date_type'=>$settings->get('date_type')
        ]);
    }
}
