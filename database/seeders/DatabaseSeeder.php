<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $company = Company::factory()->create();
        $employee = Employee::factory()->create(['company_id' => $company->id]);
        $userWithoutCompany = User::factory()->create();
        $userWithoutPostsNotifications = User::factory()->create([
            'company_id' => $company->id,
            'products_notifications' => true
        ]);
        $userWithoutProductsNotifications = User::factory()->create([
            'company_id' => $company->id,
            'posts_notifications' => true
        ]);
    }
}
