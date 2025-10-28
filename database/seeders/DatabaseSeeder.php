<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;
use App\Models\RolePage;
use App\Models\RoleButton;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $routes = Route::getRoutes();

        foreach ($routes as $route) {
            // Only include named GET routes with controller actions
            if (
                in_array('GET', $route->methods()) &&
                $route->getName() &&
                is_callable($route->getAction('uses'))
            ) {
                try {
                    // Call the route action to see if it returns a view
                    $response = app()->call($route->getAction('uses'));

                    if ($response instanceof \Illuminate\View\View) {
                        $routeName = $route->getName();

                        // Check if it already exists
                        $existingPage = RolePage::where('url', $routeName)->first();
                        if ($existingPage) continue;

                        // Insert into RolePage
                        $rolePage = RolePage::create([
                            'name' => ucwords(str_replace(['.', '_'], ' ', $routeName)),
                            'url' => $routeName,
                            'follow_to_id' => null,
                            'notes' => 'Auto-generated from route file',
                        ]);

                        // Optional: Generate standard buttons
                        $defaultButtons = ['view', 'create', 'edit', 'delete'];
                        foreach ($defaultButtons as $btn) {
                            RoleButton::create([
                                'name' => ucfirst($btn) . ' Button',
                                'follow_to_page' => $rolePage->id,
                                'notes' => 'Auto-generated button',
                            ]);
                        }
                    }
                } catch (\Throwable $e) {
                    // You can log the error if needed
                    Log::warning("Route '{$route->getName()}' skipped: " . $e->getMessage());
                    continue;
                }
            }
        }
    }
}
