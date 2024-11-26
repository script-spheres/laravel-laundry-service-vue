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
            'flash' => [
                'message' => fn () => $request->session()->get('message')
            ],
            'csrf_token' => csrf_token(),
            'navigations' => $this->adminNavigation(),
        ];
    }

    protected function adminNavigation(): array
    {
        return app(Navigation::class)
            ->add('Dashboard', route('admin.dashboard'), fn($s) => $s->attributes(['icon' => 'IcDashboardDots']))
            ->add('Stores Management', route('admin.stores.index'), fn($s) => $s->attributes(['icon' => 'AnFilledDatabase']))
            ->add('Orders Management', route('admin.orders.index'), fn($s) => $s->attributes(['icon' => 'GlWork']))
            ->add('Orders Status Screen', route('admin.orders.index'), fn($s) => $s->attributes(['icon' => 'GlWork']))
            ->add('Banners Management', route('admin.banners.index'), fn($s) => $s->attributes(['icon' => 'GlWork']))
            ->add('Service Management', '', function (Section $section) {
                $section
                    ->attributes(['icon' => 'CaCloudServices'])
                    ->add('Service Types', route('admin.service-types.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Services', route('admin.services.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Addon Services', route('admin.addon-services.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']));
            })
            ->add('Customer Management', route('admin.customers.index'), fn($s) => $s->attributes(['icon' => 'PhUsersFour']))
            ->add('Packages Management', route('admin.packages.index'), fn($s) => $s->attributes(['icon' => 'IcPackages']))
            ->add('Offers Management', route('admin.coupons.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
            ->add('Coupons Management', route('admin.coupons.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
            ->add('Customer Loyalty Program', '', function (Section $section) {
                $section
                    ->attributes(['icon' => 'MdLoyalty'])
                    ->add('Points Management', route('admin.points.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Rewards Management', route('admin.rewards.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Redemption History', route('admin.redemptions.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']));
            })
            ->add('Stock Management', '', function (Section $section) {
                $section
                    ->attributes(['icon' => 'MdInventory'])
                    ->add('Accessory Management', route('admin.accessories.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Ingredient Management', route('admin.ingredients.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Brand Management', route('admin.brands.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Supplier Management', route('admin.suppliers.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Unit Management', route('admin.units.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Stock Overview', route('admin.stocks.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Purchases', route('admin.purchases.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Purchase Returns', route('admin.purchase-returns.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']));
            })
            ->add('Expenses Management', route('admin.expenses.index'), fn($s) => $s->attributes(['icon' => 'CaFinance']))
            ->add('Report Management', '', function (Section $section) {
                $section
                    ->attributes(['icon' => 'BxSolidReport'])
                    ->add('Financial Reports', route('admin.reports.financial'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Order Reports', route('admin.reports.orders'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Customer Reports', route('admin.reports.customers'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Inventory Reports', route('admin.reports.inventory'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Expense Reports', route('admin.reports.expenses'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Sales Reports', route('admin.reports.sales'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Profit Reports', route('admin.reports.profits'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Audit Logs Reports', route('admin.reports.audit-logs'), fn($s) => $s->attributes(['icon' => 'McRoundLine']));
            })
            ->add('Settings', '', function (Section $section) {
                $section
                    ->attributes(['icon' => 'BySettings'])
                    ->add('Timeslots', route('admin.timeslots.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Delivery Scales', route('admin.delivery-scales.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Application Settings', route('admin.settings.application'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Financial Year', route('admin.financial-years.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Finance Settings', route('admin.settings.finance'), fn($s) => $s->attributes(['icon' => 'McRoundLine']));
            })
            ->tree();
    }
}
