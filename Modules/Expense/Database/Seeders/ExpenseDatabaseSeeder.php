<?php

namespace Modules\Expense\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Expense\Entities\Expense;
use Modules\Expense\Entities\ExpenseCategory;

class ExpenseDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $baseCategories = [
            'Payroll & Staff Costs',
            'Food & Beverage Supplies',
            'Housekeeping & Laundry Supplies',
            'Rooms & Accommodation Maintenance',
            'Spa & Wellness Supplies',
            'Sports & Recreation Maintenance',
            'Technology & IT Infrastructure',
            'Marketing & Advertising',
            'Sales & Distribution Costs',
            'Utilities (Water, Electricity, Gas)',
            'Telecommunications',
            'Security & Surveillance',
            'Insurance',
            'Legal & Compliance',
            'Accounting & Finance',
            'Administration & Office Supplies',
            'Transportation & Fleet',
            'Furniture, Fixtures & Equipment (FF&E)',
            'Building & Property Maintenance',
            'Renovation & Refurbishment',
            'Licenses & Permits',
            'Loyalty & Rewards Programs',
            'Events & Entertainment Costs',
            'Outsourced & Contract Services',
            'Depreciation & Amortization',
            'Bank Charges & Payment Processing',
            'Taxes & Government Levies',
            'Training & Staff Development',
            'Guest Relations & Amenities',
            'Miscellaneous & Contingency',
        ];

        $targetCount = 100;
        $baseCount = count($baseCategories);

        for ($i = 1; $i <= $targetCount; $i++) {
            $baseName = $baseCategories[($i - 1) % $baseCount];
            $batch = (int) ceil($i / $baseCount);

            $categoryName = $batch === 1
                ? $baseName
                : $baseName . ' (Group ' . $batch . ')';

            ExpenseCategory::updateOrCreate([
                'category_name' => $categoryName,
            ], [
                'category_description' => 'Seeded expense category generated from hospitality expense taxonomy.',
            ]);
        }

        $seededCategories = ExpenseCategory::query()
            ->where('category_description', 'Seeded expense category generated from hospitality expense taxonomy.')
            ->get();

        if ($seededCategories->isEmpty()) {
            return;
        }

        // Remove previous seeded expenses so reruns remain deterministic.
        Expense::query()->where('details', 'like', 'Seeded expense #%')->delete();

        for ($i = 1; $i <= 100; $i++) {
            $category = $seededCategories->random();

            Expense::create([
                'category_id' => $category->id,
                'date' => now()->subDays(fake()->numberBetween(0, 120))->toDateString(),
                'amount' => fake()->randomFloat(2, 50, 5000),
                'details' => 'Seeded expense #' . $i . ' - ' . $category->category_name,
            ]);
        }
    }
}
