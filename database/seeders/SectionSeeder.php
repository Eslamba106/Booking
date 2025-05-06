<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dashboards 1 - 2
        Section::updateOrCreate(['id' => 1], ['name' => 'admin_general_dashboard', 'caption' => 'admin_general_dashboard']);
        Section::updateOrCreate(['id' => 2], ['name' => 'admin_general_dashboard_show', 'section_group_id' => 1, 'caption' => "general_dashboard_page"]);

        // Roles 3 - 7
        Section::updateOrCreate(['id' => 3], ['name' => 'admin_roles', 'caption' => 'admin_roles']);
        Section::updateOrCreate(['id' => 4], ['name' => 'show_admin_roles', 'section_group_id' => 3, 'caption' => 'show_admin_roles']);
        Section::updateOrCreate(['id' => 5], ['name' => 'create_admin_roles', 'section_group_id' => 3, 'caption' => 'create_admin_roles']);
        Section::updateOrCreate(['id' => 6], ['name' => 'edit_admin_roles', 'section_group_id' => 3, 'caption' => 'edit_admin_roles']);
        Section::updateOrCreate(['id' => 7], ['name' => 'update_admin_roles', 'section_group_id' => 3, 'caption' => 'update_admin_roles']);
        Section::updateOrCreate(['id' => 8], ['name' => 'delete_admin_roles', 'section_group_id' => 3, 'caption' => 'delete_admin_roles']);

        // Users Management 9 - 15

        Section::updateOrCreate(['id' => 9], ['name' => 'user_management', 'caption' => 'user_management']);
        Section::updateOrCreate(['id' => 10], ['name' => 'all_users', 'section_group_id' => 9, 'caption' => 'show_all_users']);
        Section::updateOrCreate(['id' => 11], ['name' => 'change_users_role', 'section_group_id' => 9, 'caption' => 'change_users_role']);
        Section::updateOrCreate(['id' => 12], ['name' => 'change_users_status', 'section_group_id' => 9, 'caption' => 'change_users_status']);
        Section::updateOrCreate(['id' => 13], ['name' => 'delete_user', 'section_group_id' => 9, 'caption' => 'delete_user']);
        Section::updateOrCreate(['id' => 14], ['name' => 'edit_user', 'section_group_id' => 9, 'caption' => 'edit_user']);
        Section::updateOrCreate(['id' => 15], ['name' => 'create_user', 'section_group_id' => 9, 'caption' => 'create_user']);
        
        // Broker Management 16 - 21 
        Section::updateOrCreate(['id' => 16], ['name' => 'broker_management', 'caption' => 'broker_management']);
        Section::updateOrCreate(['id' => 17], ['name' => 'all_brokers', 'section_group_id' => 16, 'caption' => 'show_all_brokers']);
        Section::updateOrCreate(['id' => 18], ['name' => 'change_brokers_status', 'section_group_id' => 16, 'caption' => 'change_brokers_status']);
        Section::updateOrCreate(['id' => 19], ['name' => 'create_broker', 'section_group_id' => 16, 'caption' => 'create_broker']);
        Section::updateOrCreate(['id' => 20], ['name' => 'delete_broker', 'section_group_id' => 16, 'caption' => 'delete_broker']);
        Section::updateOrCreate(['id' => 21], ['name' => 'edit_broker', 'section_group_id' => 16, 'caption' => 'edit_broker']);
        // Customer Management 22 - 27 
        Section::updateOrCreate(['id' => 22], ['name' => 'customer_management', 'caption' => 'customer_management']);
        Section::updateOrCreate(['id' => 23], ['name' => 'all_customers', 'section_group_id' => 22, 'caption' => 'show_all_customers']);
        Section::updateOrCreate(['id' => 24], ['name' => 'change_customers_status', 'section_group_id' => 22, 'caption' => 'change_customers_status']);
        Section::updateOrCreate(['id' => 25], ['name' => 'create_customer', 'section_group_id' => 22, 'caption' => 'create_customer']);
        Section::updateOrCreate(['id' => 26], ['name' => 'delete_customer', 'section_group_id' => 22, 'caption' => 'delete_customer']);
        Section::updateOrCreate(['id' => 27], ['name' => 'edit_customer', 'section_group_id' => 22, 'caption' => 'edit_customer']);
        // Unit Type Management 28 - 33 
        Section::updateOrCreate(['id' => 28], ['name' => 'unit_type_management', 'caption' => 'unit_type_management']);
        Section::updateOrCreate(['id' => 29], ['name' => 'all_unit_types', 'section_group_id' => 28, 'caption' => 'show_all_unit_types']);
        Section::updateOrCreate(['id' => 30], ['name' => 'change_unit_types_status', 'section_group_id' => 28, 'caption' => 'change_unit_types_status']);
        Section::updateOrCreate(['id' => 31], ['name' => 'create_unit_type', 'section_group_id' => 28, 'caption' => 'create_unit_type']);
        Section::updateOrCreate(['id' => 32], ['name' => 'delete_unit_type', 'section_group_id' => 28, 'caption' => 'delete_unit_type']);
        Section::updateOrCreate(['id' => 33], ['name' => 'edit_unit_type', 'section_group_id' => 28, 'caption' => 'edit_unit_type']);
        // Hotel Management 34 - 39
        Section::updateOrCreate(['id' => 34], ['name' => 'hotel_management', 'caption' => 'hotel_management']);
        Section::updateOrCreate(['id' => 35], ['name' => 'all_hotels', 'section_group_id' => 34, 'caption' => 'show_all_hotels']);
        Section::updateOrCreate(['id' => 36], ['name' => 'change_hotels_status', 'section_group_id' => 34, 'caption' => 'change_hotels_status']);
        Section::updateOrCreate(['id' => 37], ['name' => 'create_hotel', 'section_group_id' => 34, 'caption' => 'create_hotel']);
        Section::updateOrCreate(['id' => 38], ['name' => 'delete_hotel', 'section_group_id' => 34, 'caption' => 'delete_hotel']);
        Section::updateOrCreate(['id' => 39], ['name' => 'edit_hotel', 'section_group_id' => 34, 'caption' => 'edit_hotel']);
        // Driver Management 40 - 45
        Section::updateOrCreate(['id' => 40], ['name' => 'driver_management', 'caption' => 'driver_management']);
        Section::updateOrCreate(['id' => 41], ['name' => 'all_drivers', 'section_group_id' => 40, 'caption' => 'show_all_drivers']);
        Section::updateOrCreate(['id' => 42], ['name' => 'change_drivers_status', 'section_group_id' => 40, 'caption' => 'change_drivers_status']);
        Section::updateOrCreate(['id' => 43], ['name' => 'create_driver', 'section_group_id' => 40, 'caption' => 'create_driver']);
        Section::updateOrCreate(['id' => 44], ['name' => 'delete_driver', 'section_group_id' => 40, 'caption' => 'delete_driver']);
        Section::updateOrCreate(['id' => 45], ['name' => 'edit_driver', 'section_group_id' => 40, 'caption' => 'edit_driver']);
        
        // Service Management 46 - 51
        Section::updateOrCreate(['id' => 46], ['name' => 'service_management', 'caption' => 'service_management']);
        Section::updateOrCreate(['id' => 47], ['name' => 'all_services', 'section_group_id' => 46, 'caption' => 'show_all_services']);
        Section::updateOrCreate(['id' => 48], ['name' => 'change_services_status', 'section_group_id' => 46, 'caption' => 'change_services_status']);
        Section::updateOrCreate(['id' => 49], ['name' => 'create_service', 'section_group_id' => 46, 'caption' => 'create_service']);
        Section::updateOrCreate(['id' => 50], ['name' => 'delete_service', 'section_group_id' => 46, 'caption' => 'delete_service']);
        Section::updateOrCreate(['id' => 51], ['name' => 'edit_service', 'section_group_id' => 46, 'caption' => 'edit_service']);
        
        // Booking Management  51 - 57

        Section::updateOrCreate(['id' => 52], ['name' => 'booking_management', 'caption' => 'booking_management']);
        Section::updateOrCreate(['id' => 53], ['name' => 'all_bookings', 'section_group_id' => 52, 'caption' => 'show_all_bookings']);
        Section::updateOrCreate(['id' => 54], ['name' => 'change_bookings_status', 'section_group_id' => 52, 'caption' => 'change_bookings_status']);
        Section::updateOrCreate(['id' => 55], ['name' => 'create_booking', 'section_group_id' => 52, 'caption' => 'create_booking']);
        Section::updateOrCreate(['id' => 56], ['name' => 'delete_booking', 'section_group_id' => 52, 'caption' => 'delete_booking']);
        Section::updateOrCreate(['id' => 57], ['name' => 'edit_booking', 'section_group_id' => 52, 'caption' => 'edit_booking']);
        
    }
}
