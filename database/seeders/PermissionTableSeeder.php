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
          
            // "users-list",
            // "update-user",
            // "delete-user",
            // "add-user",
            // "about",
            // "update-or-create-about",
            // "booking-list",
            // "booking",
            // "change-booking-status",
            // "contact",
            // "update-or-create-contact",
            // "questions",
            // "questions-list",
            // "update-question",
            // "delete-question",
            // "add-question",
            // "role",
            // "roles-list",
            // "update-role",
            // "delete-role",
            // "add-role",
            // "service",
            // "service-list",
            // "update-service",
            // "delete-service",
            // "add-service",
            // "subscription",
            // "update-subscription-status",
            // "subscription-list",
            // "update-subscription",
            // "delete-subscription",
            // "add-subscription",
            "term",
            "update-or-create-term",
            "privacy",
            "update-or-create-privacy",
            "setting",
            "update-or-create-setting",





        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
    
}
