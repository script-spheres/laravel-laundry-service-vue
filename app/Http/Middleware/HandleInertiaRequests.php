<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

use Spatie\Navigation\Navigation;
use Spatie\Navigation\Section;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'csrf_token' => csrf_token(),
            'navigations' => $this->adminNavigation(),
        ];
    }

    protected function adminNavigation(): array
    {
        return app(Navigation::class)
            ->add('Dashboard', route('admin.dashboard'))
            ->add('Coupons Management', route('admin.coupons.index'))
            ->add('Stores  Management', route('admin.stores.index'))
            ->add('Customers Management', route('admin.customers.index'))
            ->add('Service Types Management', route('admin.service-types.index'))
            ->add('Services Management', route('admin.services.index'))
            ->add('Timeslots Management', route('admin.timeslots.index'))
            ->add('Expenses Management', route('admin.expenses.index'))
            ->add('Orders Management', route('admin.orders.index'))
            ->add('Blog Management', route('admin.orders.index'), function (Section $section) {
                $section
                    ->add('All Posts', route('admin.coupons.index'))
                    ->add('Categories', route('admin.orders.index'));
            })
            ->tree();

    }
}
