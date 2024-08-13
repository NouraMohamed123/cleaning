<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'service-list',
            'create-service',
            'update-service',
            'delete-service',
            'package-list',
            'create-package',
            'update-package',
            'delete-package',
            'booking-list',
            'controle-booking',
            'city-list',
            'create-city',
            'update-city',
            'delete-city',
            'area-list',
            'create-area',
            'update-area',
            'delete-area',
            'review-list',
            'create-review',
            'update-review',
            'delete-review',
            'coupon-list',
            'create-coupon',
            'update-coupon',
            'delete-coupon',
            'notifiction-booking',
            'notifiction-register',
            'notifiction-message',
            'notifiction-send',
            'report-order',
            'report-payment',
            'user-list',
            'create-user',
            'update-user',
            'delete-user',
            'role-list',
            'create-role',
            'update-role',
            'delete-role',
            'setting',
            'update-setting',
            'privacy',
            'update-privacy',
            'term',
            'update-term',
            'about-us',
            'update-about-us',
            'question-list',
            'create-question',
            'update-question',
            'delete-question'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }

}
