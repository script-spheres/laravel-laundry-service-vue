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
                'permissions' => $request->user() ? $request->user()->getAllPermissions()->pluck('name') : [],
            ],
            'flash' => [
                'message' => fn () => $request->session()->get('message')
            ],
            'app' => [
                'name' => config('app.name'),
                'url' => config('app.url'),
                'version' => config('app.version', '1.0.0'),
                'environment' => app()->environment(),
            ],
            'csrf_token' => csrf_token(),
            'navigations' => $this->adminNavigation(),
        ];
    }

    protected function adminNavigation(): array
    {
        return app(Navigation::class)
            ->add('Dashboard', route('dashboard'), fn($s) => $s->attributes(['icon' => 'IcDashboardDots']))
            ->add('Orders Pos Portal', route('orders.create'), fn($s) => $s->attributes(['icon' => 'MdPointOfSale']))
            ->add('Orders Status Screen', route('orders-status.index'), fn($s) => $s->attributes(['icon' => 'FlFilledDualScreenStatusBar']))
            ->add('Orders Management', route('orders.index'), fn($s) => $s->attributes(['icon' => 'GlWork']))
            ->add('Stores Management', route('stores.index'), fn($s) => $s->attributes(['icon' => 'AnFilledDatabase']))
            ->add('Banners Management', route('banners.index'), fn($s) => $s->attributes(['icon' => 'GlWork']))
            ->add('Customer Management', route('customers.index'), fn($s) => $s->attributes(['icon' => 'PhUsersFour']))
            ->add('Coupons Management', route('coupons.index'), fn($s) => $s->attributes(['icon' => 'BxSolidCoupon']))
            ->add('Services Management', '', function (Section $section) {
                $section
                    ->attributes(['icon' => 'CaCustomerService'])
                    ->add('Categories', route('categories.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Services', route('services.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Service Items', route('service-items.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Fare Management', route('service-details.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Addon Services', route('addon-services.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']));
            })
            ->add('Expenses Management', '', function (Section $section) {
                $section
                    ->attributes(['icon' => 'CaFinance'])
                    ->add('Expenses Type', route('expense-types.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Expenses Management', route('expenses.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']));
            })
            ->add('Report Management', '', function (Section $section) {
                $section
                    ->attributes(['icon' => 'BxSolidReport'])
                    ->add('Financial Reports', route('reports.financial'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Order Reports', route('reports.orders'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Customer Reports', route('reports.customers'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Expense Reports', route('reports.expenses'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Sales Reports', route('reports.sales'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Profit Reports', route('reports.profits'), fn($s) => $s->attributes(['icon' => 'McRoundLine']));
            })
            ->add('User Management', route('users.index'), fn($s) => $s->attributes(['icon' => 'BxSolidCoupon']))
            ->add('Role Management', route('roles.index'), fn($s) => $s->attributes(['icon' => 'BxSolidCoupon']))
            ->add('Master Sections', '', function (Section $section) {
                $section
                    ->attributes(['icon' => 'BySettings'])
                    ->add('Timeslots', route('timeslots.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Order Label', route('order-labels.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Cities', route('cities.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Units', route('units.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Delivery Scales', route('delivery-scales.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Financial Year', route('financial-years.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Faqs', route('faqs.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Reviews', route('reviews.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']));
            })
            ->add('Settings', route('settings.index'), fn($s) => $s->attributes(['icon' => 'BySettings']))
            ->tree();
    }
}
