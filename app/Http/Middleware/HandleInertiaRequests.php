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
            ->add('Dashboard', route('admin.dashboard'), fn($s) => $s->attributes(['icon' => 'IcDashboardDots']))

            // Master Data Section
            ->add('Master Data Management', '', function (Section $section) {
                $section
                    ->attributes(['icon' => 'AnFilledDatabase'])
                    ->add('Accessory Management', route('admin.accessories.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Ingredient Management', route('admin.ingredients.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Brand Management', route('admin.brands.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Supplier Management', route('admin.suppliers.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Stores Management', route('admin.stores.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Unit Management', route('admin.units.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']));
            })

            // Stock Management Section
            ->add('Stock Management', '', function (Section $section) {
                $section
                    ->attributes(['icon' => 'MdInventory'])
                    ->add('Stock Overview', route('admin.stocks.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Purchases', route('admin.purchases.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Purchase Returns', route('admin.purchase-returns.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']));
            })

            // Service Management Section
            ->add('Service Management', '', function (Section $section) {
                $section
                    ->attributes(['icon' => 'CaCloudServices'])
                    ->add('Service Types', route('admin.service-types.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Services', route('admin.services.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Addon Services', route('admin.addon-services.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']));
            })

            // Package Management Section
            ->add('Package Management', '', function (Section $section) {
                $section
                    ->attributes(['icon' => 'IcPackages'])
                    ->add('Packages', route('admin.packages.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Coupons', route('admin.coupons.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']));
            })

            // Order Management Section
            ->add('Order Management', '', function (Section $section) {
                $section
                    ->attributes(['icon' => 'GlWork'])
                    ->add('Orders', route('admin.orders.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Timeslots', route('admin.timeslots.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Delivery Scales', route('admin.delivery-scales.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']));
            })

            // Customer Loyalty Program Section
            ->add('Customer Loyalty Program', '', function (Section $section) {
                $section
                    ->attributes(['icon' => 'MdLoyalty'])
                    ->add('Points Management', route('admin.points.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Rewards Management', route('admin.rewards.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Redemption History', route('admin.redemptions.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']));
            })

            // Financial Management Section
            ->add('Financial Management', '', function (Section $section) {
                $section
                    ->attributes(['icon' => 'CaFinance'])
                    ->add('Expenses', route('admin.expenses.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Financial Year', route('admin.financial-years.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Audit Data', route('admin.audits.index'), fn($s) => $s->attributes(['icon' => 'McRoundLine']));
            })

            // Reports Section
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

            // Customer Management
            ->add('Customer Management', route('admin.customers.index'), fn($s) => $s->attributes(['icon' => 'PhUsersFour']))

            // Settings Section
            ->add('Settings', '', function (Section $section) {
                $section
                    ->attributes(['icon' => 'BySettings'])
                    ->add('Application Settings', route('admin.settings.application'), fn($s) => $s->attributes(['icon' => 'McRoundLine']))
                    ->add('Finance Settings', route('admin.settings.finance'), fn($s) => $s->attributes(['icon' => 'McRoundLine']));
            })
            ->tree();
    }
}
