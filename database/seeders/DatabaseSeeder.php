<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Consultant;
use App\Models\Service;
use App\Models\AvailabilitySlot;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Customer
        User::create([
            'name' => 'Customer User',
            'email' => 'customer@customer.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        // Consultant
        $consultantUser = User::create([
            'name' => 'Consultant User',
            'email' => 'consultant@consultant.com',
            'password' => Hash::make('password'),
            'role' => 'consultant',
        ]);

        $consultant = Consultant::create([
            'user_id' => $consultantUser->id,
            'specialization' => 'Business Strategy',
            'experience' => 10,
            'bio' => 'Experienced business strategist helping startups scale rapidly.',
            'consultation_fee' => 150.00,
            'availability_status' => true
        ]);

        Service::create([
            'consultant_id' => $consultant->id,
            'service_name' => '1 Hour Strategy Call',
            'description' => 'A deep dive into your business model.',
            'price' => 150.00,
            'duration' => 60
        ]);

        Service::create([
            'consultant_id' => $consultant->id,
            'service_name' => '30 Min Quick Review',
            'description' => 'Quick review of your pitch deck.',
            'price' => 80.00,
            'duration' => 30
        ]);

        for ($i = 1; $i <= 5; $i++) {
            AvailabilitySlot::create([
                'consultant_id' => $consultant->id,
                'available_date' => Carbon::today()->addDays($i)->toDateString(),
                'start_time' => '10:00:00',
                'end_time' => '11:00:00',
            ]);
            AvailabilitySlot::create([
                'consultant_id' => $consultant->id,
                'available_date' => Carbon::today()->addDays($i)->toDateString(),
                'start_time' => '14:00:00',
                'end_time' => '15:00:00',
            ]);
        }
    }
}
