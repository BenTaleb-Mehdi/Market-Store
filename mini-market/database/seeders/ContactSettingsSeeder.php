<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class ContactSettingsSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $contactSettings = [
            [
                'key' => 'contact_get_in_touch_title',
                'value' => 'Get in Touch',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Contact Page Title',
                'description' => 'The main title displayed on the contact page'
            ],
            [
                'key' => 'contact_get_in_touch_description',
                'value' => "We'd love to hear from you! Whether you have questions about our products, need help with an order, or want to provide feedback, we're here to help.",
                'type' => 'string',
                'group' => 'general',
                'label' => 'Contact Page Description',
                'description' => 'The description text displayed below the contact page title'
            ]
        ];

        foreach ($contactSettings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
