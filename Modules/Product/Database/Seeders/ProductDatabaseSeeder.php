<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Setting\Entities\Unit;

class ProductDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $categories = [
            'Rooms & Accommodations',
            'Food & Beverage',
            'Spa & Wellness',
            'Sports & Recreation',
            'Business & Events',
            'Concierge & Guest Services',
            'Transportation',
            'Retail & Boutique',
            'Entertainment & Leisure',
            'Health & Medical Services',
            'Childcare & Family Services',
            'Technology & Connectivity',
            'Laundry & Housekeeping',
            'Security & Privacy Services',
            'Membership & Loyalty Programs',
        ];

        $categoryProducts = [
            'Rooms & Accommodations' => ['Deluxe Room Night', 'Suite Upgrade', 'Late Checkout Pass', 'Ocean View Add-on', 'Extra Bed Setup'],
            'Food & Beverage' => ['Breakfast Buffet', 'Signature Dinner Set', 'Fresh Juice Platter', 'Coffee Service', 'Mini Bar Refill'],
            'Spa & Wellness' => ['Swedish Massage Session', 'Aromatherapy Package', 'Facial Treatment', 'Sauna Access', 'Wellness Consultation'],
            'Sports & Recreation' => ['Tennis Court Booking', 'Gym Day Pass', 'Yoga Class Entry', 'Pool Cabana Rental', 'Bicycle Rental'],
            'Business & Events' => ['Meeting Room Hour', 'Projector Rental', 'Conference Package', 'Corporate Lunch Setup', 'Event Coordination Service'],
            'Concierge & Guest Services' => ['City Tour Booking', 'Restaurant Reservation Service', 'VIP Check-in Service', 'Luggage Assistance', 'Personal Itinerary Planning'],
            'Transportation' => ['Airport Transfer', 'Hotel Shuttle Pass', 'Private Car Hire', 'Intercity Transfer', 'Valet Parking Service'],
            'Retail & Boutique' => ['Branded Bathrobe', 'Premium Souvenir Mug', 'Local Artisan Gift Box', 'Signature Fragrance', 'Travel Essentials Kit'],
            'Entertainment & Leisure' => ['Live Music Night Ticket', 'Movie Lounge Access', 'Board Game Package', 'Karaoke Room Hour', 'Cultural Show Pass'],
            'Health & Medical Services' => ['On-call Nurse Visit', 'Basic Health Check', 'Pharmacy Delivery Service', 'Telemedicine Consultation', 'Emergency Response Support'],
            'Childcare & Family Services' => ['Kids Club Session', 'Babysitting Hour', 'Family Activity Package', 'Child Meal Plan', 'Educational Play Session'],
            'Technology & Connectivity' => ['Premium Wi-Fi Access', 'Portable Hotspot Rental', 'Printing Service Bundle', 'Video Call Room Access', 'Device Charging Station Pass'],
            'Laundry & Housekeeping' => ['Express Laundry Service', 'Dry Cleaning Service', 'Room Deep Cleaning', 'Garment Pressing Service', 'Daily Housekeeping Upgrade'],
            'Security & Privacy Services' => ['In-room Safe Service', 'Secure Storage Access', 'Private Security Escort', 'Confidential Document Handling', 'Privacy Protection Package'],
            'Membership & Loyalty Programs' => ['Silver Membership Plan', 'Gold Membership Plan', 'Loyalty Points Booster', 'Annual Rewards Renewal', 'Member Lounge Access'],
        ];

        $categoryIds = [];
        foreach ($categories as $index => $categoryName) {
            $category = Category::updateOrCreate([
                'category_code' => 'CA_' . str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT),
            ], [
                'category_name' => $categoryName,
            ]);

            $categoryIds[$categoryName] = $category->id;
        }

        $categoryCounters = array_fill_keys($categories, 0);

        Unit::firstOrCreate([
            'short_name' => 'PC',
        ], [
            'name' => 'Piece',
            'operator' => '*',
            'operation_value' => 1
        ]);

        for ($i = 1; $i <= 100; $i++) {
            $productCode = 'PRD_' . str_pad((string) $i, 4, '0', STR_PAD_LEFT);
            $categoryName = $categories[($i - 1) % count($categories)];
            $categoryId = $categoryIds[$categoryName];
            $categoryCounters[$categoryName]++;
            $baseProducts = $categoryProducts[$categoryName];
            $baseCount = count($baseProducts);
            $counter = $categoryCounters[$categoryName];
            $baseName = $baseProducts[($counter - 1) % $baseCount];
            $batch = (int) ceil($counter / $baseCount);
            $productName = $baseName . ($batch > 1 ? ' (Package ' . $batch . ')' : '');

            Product::updateOrCreate([
                'product_code' => $productCode,
            ], [
                'category_id' => $categoryId,
                'product_name' => $productName,
                'product_barcode_symbology' => 'C128',
                'product_quantity' => fake()->numberBetween(20, 500),
                'product_cost' => fake()->randomFloat(2, 5, 200),
                'product_price' => fake()->randomFloat(2, 201, 500),
                'product_unit' => 'PC',
                'product_stock_alert' => fake()->numberBetween(3, 20),
                'product_order_tax' => fake()->numberBetween(0, 18),
                'product_tax_type' => fake()->numberBetween(1, 2),
                'product_note' => Str::limit(fake()->sentence(12), 120),
            ]);
        }
    }
}
