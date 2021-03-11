<?php

defined('BASEPATH') or exit('No direct script access allowed');

function app_init_admin_sidebar_menu_items()
{
    $CI = &get_instance();
	
	
	 if($CI->session->userdata('franchise')==1){ 
            echo "<style>
			
			.menu-item-mailbox{
				display:none!important;
			}
			
			</style>";
            
         }


if($CI->session->userdata('franchise')!=1){
    $CI->app_menu->add_sidebar_menu_item('dashboard', [
        'name'     => _l('als_dashboard'),
        'href'     => admin_url(),
        'position' => 1,
        'icon'     => 'fa fa-home',
    ]);
	// General customers 
	 $CI->app_menu->add_sidebar_menu_item('general', [
        'collapse' => true,
        'name'     => _l('General Customer'),
        'position' => 2,
        'icon'     => 'fa fa-user-circle menu-icon',
    ]);

    $CI->app_menu->add_sidebar_children_item('general', [
            'slug'     => 'general',
            'name'     => _l('General Customer'),
            'href'     => admin_url('general_customers/'),
            'position' => 1,
            'icon'     => 'fa fa-user-circle menu-icon',
    ]);

    $CI->app_menu->add_sidebar_children_item('general', [
            'slug'     => 'customer_invoices',
            'name'     => _l('Customer Invoices'),
            'href'     => admin_url('general_customers/customer_invoices/'),
            'position' => 1,
            'icon'     => 'fa fa-area-chart menu-icon',
    ]);
	
	
	// Franchise 
	 $CI->app_menu->add_sidebar_menu_item('franchise', [
        'collapse' => true,
        'name'     => _l('Franchise'),
        'position' => 2,
        'icon'     => 'fa fa-user-circle menu-icon',
    ]);

    $CI->app_menu->add_sidebar_children_item('franchise', [
            'slug'     => 'franchise',
            'name'     => _l('Franchise'),
            'href'     => admin_url('franchise/'),
            'position' => 1,
            'icon'     => 'fa fa-user-circle menu-icon',
    ]);
	 $CI->app_menu->add_sidebar_children_item('franchise', [
            'slug'     => 'new_franchise',
            'name'     => _l('Add Franchise'),
            'href'     => admin_url('franchise/new_franchise'),
            'position' => 1,
            'icon'     => 'fa fa-user-circle menu-icon',
    ]);

	
	
	
	

    $CI->app_menu->add_sidebar_menu_item('restuarants', [
        'collapse' => true,
        'name'     => _l('merchants'),
        'position' => 2,
        'icon'     => 'fa fa-user-o',
    ]);

    $CI->app_menu->add_sidebar_children_item('restuarants', [
            'slug'     => 'dashboard',
            'name'     => _l('dashboard'),
            'href'     => admin_url('merchant_dashboard'),
            'position' => 1,
            'icon'     => 'fa fa-home',
    ]);

    $CI->app_menu->add_sidebar_children_item('restuarants', [
            'slug'     => 'manage customers',
            'name'     => _l('Merchants'),
            'href'     => admin_url('clients/'),
            'position' => 1,
            'icon'     => 'fa fa-user-o',
    ]);
	
	$CI->app_menu->add_sidebar_children_item('restuarants', [
            'slug'     => 'Merchants Revenue Report',
            'name'     => _l('Merchants Revenue Report'),
            'href'     => admin_url('merchants/revenue_report'),
            'position' => 1,
            'icon'     => 'fa fa-area-chart',
    ]);
	
	$CI->app_menu->add_sidebar_children_item('restuarants', [
            'slug'     => 'Merchants Top Meals Report',
            'name'     => _l('Merchants Top Meals Report'),
            'href'     => admin_url('merchants/top_meals_report'),
            'position' => 1,
            'icon'     => 'fa fa-area-chart',
    ]);
	
	$CI->app_menu->add_sidebar_menu_item('platform_revenue', [
        'collapse' => true,
        'name'     => _l('Platform Revenue'),
        'position' => 2,
        'icon'     => 'fa fa-money',
    ]);


    $CI->app_menu->add_sidebar_children_item('platform_revenue', [
            'slug'     => 'platform_revenue',
            'name'     => _l('Platform Revenue'),
            'href'     => admin_url('platform_revenue'),
            'position' => 1,
            'icon'     => 'fa fa-area-chart',
    ]);

    $CI->app_menu->add_sidebar_menu_item('eaters', [
        'collapse' => true,
        'name'     => _l('customers'),
        'position' => 2,
        'icon'     => 'fa fa-user-o',
    ]);


    $CI->app_menu->add_sidebar_children_item('eaters', [
            'slug'     => 'dashboard',
            'name'     => _l('dashboard'),
            'href'     => admin_url('clients/customer_dashboard'),
            'position' => 1,
            'icon'     => 'fa fa-home',
    ]);

    $CI->app_menu->add_sidebar_children_item('eaters', [
            'slug'     => 'customers',
            'name'     => _l('Customers'),
            'href'     => admin_url('clients/all_contacts'),
            'position' => 1,
            'icon'     => 'fa fa-user',
    ]);
	
	$CI->app_menu->add_sidebar_children_item('eaters', [
            'slug'     => 'customers',
            'name'     => _l('Customers'),
            'href'     => admin_url('customers'),
            'position' => 1,
            'icon'     => 'fa fa-user',
    ]);
	
	$CI->app_menu->add_sidebar_menu_item('referrals', [
        'collapse' => true,
        'name'     => _l('Referrals'),
        'position' => 2,
        'icon'     => 'fa fa-user-plus',
    ]);


    $CI->app_menu->add_sidebar_children_item('referrals', [
            'slug'     => 'dashboard',
            'name'     => _l('dashboard'),
            'href'     => admin_url('clients/referrals_dashboard'),
            'position' => 1,
            'icon'     => 'fa fa-home',
    ]);

    $CI->app_menu->add_sidebar_children_item('referrals', [
            'slug'     => 'customers',
            'name'     => _l('Customers'),
            'href'     => admin_url('clients/referrals'),
            'position' => 1,
            'icon'     => 'fa fa-user-o',
    ]);

    $CI->app_menu->add_sidebar_menu_item('eaters_orders', [
        'collapse' => true,
        'name'     => _l('orders'),
        'position' => 2,
        'icon'     => 'fa fa-user-o',
    ]);

    $CI->app_menu->add_sidebar_children_item('eaters_orders', [
            'slug'     => 'orders_dashboard',
            'name'     => _l('dashboard'),
            'href'     => admin_url('orders_dashboard'),
            'position' => 4,
            'icon'     => 'fa fa-user-o',
    ]);

    $CI->app_menu->add_sidebar_children_item('eaters_orders', [
            'slug'     => 'orders',
            'name'     => _l('Orders'),
            'href'     => admin_url('clients/orders'),
            'position' => 4,
            'icon'     => 'fa fa-user-o',
    ]);
	
	$CI->app_menu->add_sidebar_children_item('eaters_orders', [
            'slug'     => 'orders',
            'name'     => _l('Top 10 Drop Up Location Suburb'),
            'href'     => admin_url('reports/top_10_drop_up_location_suburb'),
            'position' => 4,
            'icon'     => 'fa fa-bar-chart',
    ]);
	

	
	//Manual Orders
	
	$CI->app_menu->add_sidebar_menu_item('manual_orders', [
        'collapse' => true,
        'name'     => _l('Manual Delivery'),
        'position' => 2,
        'icon'     => 'fa fa-shopping-cart',
    ]);

    $CI->app_menu->add_sidebar_children_item('manual_orders', [
            'slug'     => 'dashboard',
            'name'     => _l('Dashboard'),
            'href'     => admin_url('orders/dashboard'),
            'position' => 4,
            'icon'     => 'fa fa-home',
    ]);

    $CI->app_menu->add_sidebar_children_item('manual_orders', [
            'slug'     => 'orders',
            'name'     => _l('Manual Delivery'),
            'href'     => admin_url('orders'),
            'position' => 4,
            'icon'     => 'fa fa-shopping-cart',
    ]);

    $CI->app_menu->add_sidebar_children_item('manual_orders', [
            'slug'     => 'orders',
            'name'     => _l('Order Revenue'),
            'href'     => admin_url('orders/manual_order_revenue'),
            'position' => 4,
            'icon'     => 'fa fa-home',
    ]);
}// END of Franchise
    
	//Drivers

    $CI->app_menu->add_sidebar_menu_item('drivers', [
        'collapse' => true,
        'name'     => _l('drivers'),
        'position' => 2,
        'icon'     => 'fa fa-car',
    ]);

   /* $CI->app_menu->add_sidebar_children_item('drivers', [
            'slug'     => 'dashboard',
            'name'     => _l('dashboard'),
            'href'     => admin_url('drivers/dashboard'),
            'position' => 5,
            'icon'     => 'fa fa-home',
    ]);*/
	
	$CI->app_menu->add_sidebar_children_item('drivers', [
            'slug'     => 'drivers',
            'name'     => _l('Drivers'),
            'href'     => admin_url('drivers'),
            'position' => 5,
            'icon'     => 'fa fa-user-o',
    ]);
	if($CI->session->userdata('franchise')!=1){
	$CI->app_menu->add_sidebar_children_item('drivers', [
            'slug'     => 'checklist',
            'name'     => _l('Driver Checklist'),
            'href'     => admin_url('drivers/checklist'),
            'position' => 5,
            'icon'     => 'fa fa-check-square-o',
    ]);
	}
	
	$CI->app_menu->add_sidebar_children_item('drivers', [
            'slug'     => 'report',
            'name'     => _l('Driver Reports'),
            'href'     => admin_url('drivers/report'),
            'position' => 5,
            'icon'     => 'fa fa-bar-chart',
    ]);
	
	$CI->app_menu->add_sidebar_children_item('drivers', [
            'slug'     => 'report',
            'name'     => _l('Driver Trips '),
            'href'     => admin_url('drivers/trip_report'),
            'position' => 5,
            'icon'     => 'fa fa-car',
    ]);
	
	// Reports

    $CI->app_menu->add_sidebar_children_item('reports', [
            'slug'     => 'revenue_report',
            'name'     => _l('Revenue Report'),
            'href'     => admin_url('reports/revenue_report'),
            'position' => 5,
            'icon'     => '',
    ]);
	
	$CI->app_menu->add_sidebar_children_item('restuarants', [
            'slug'     => 'schedule',
            'name'     => _l('schedule'),
            'href'     => admin_url('clients/schedule_message'),
            'position' => 5,
            'icon'     => 'fa fa-envelope',
    ]);
	
	$CI->app_menu->add_sidebar_children_item('restuarants', [
            'slug'     => 'notifications',
            'name'     => _l('Notifications'),
            'href'     => admin_url('clients/notifications'),
            'position' => 5,
            'icon'     => 'fa fa-bell',
    ]);

 /*   $CI->app_menu->add_sidebar_children_item('restuarants', [
            'slug'     => 'notifications',
            'name'     => _l('Notifications'),
            'href'     => admin_url('clients/notifications'),
            'position' => 5,
            'icon'     => 'fa fa-envelope',
    ]);*/
	
	
	$CI->app_menu->add_sidebar_menu_item('Revenue', [
        'collapse' => true,
        'name'     => _l('driver revenue'),
        'position' => 2,
        'icon'     => 'fa fa-user-o',
    ]);
	
	$CI->app_menu->add_sidebar_children_item('Revenue', [
            'slug'     => 'driver revenue',
            'name'     => _l('Driver Revenue'),
            'href'     => admin_url('drivers/drivers_revenue'),
            'position' => 5,
            'icon'     => 'fa fa-user-o',
    ]);

    $CI->app_menu->add_sidebar_children_item('Revenue', [
            'slug'     => 'driver revenue report',
            'name'     => _l('Driver Revenue Report'),
            'href'     => admin_url('drivers/drivers_revenue_report'),
            'position' => 6,
            'icon'     => 'fa fa-user-o',
    ]);

	if($CI->session->userdata('franchise')!=1){
	$CI->app_menu->add_sidebar_menu_item('Commission', [
        'collapse' => true,
        'name'     => _l('Commission'),
        'position' => 6,
        'icon'     => 'fa fa-user-o',
    ]);

    $CI->app_menu->add_sidebar_children_item('Commission', [
            'slug'     => 'commission',
            'name'     => _l('Order Payouts'),
            'href'     => admin_url('clients/commission'),
            'position' => 6,
            'icon'     => 'fa fa-user-o',
    ]);

    $CI->app_menu->add_sidebar_children_item('Commission', [
            'slug'     => 'commission',
            'name'     => _l('Sales Commission'),
            'href'     => admin_url('clients/sales_commission'),
            'position' => 6,
            'icon'     => 'fa fa-user-o',
    ]);
	}// END of Franchise

    

    // if (has_permission('customers', '', 'view')
    //     || (have_assigned_customers()
    //     || (!have_assigned_customers() && has_permission('customers', '', 'create')))) {
    //     $CI->app_menu->add_sidebar_menu_item('customers', [
    //         'name'     => _l('als_clients'),
    //         'href'     => admin_url('clients'),
    //         'position' => 5,
    //         'icon'     => 'fa fa-user-o',
    //     ]);
    // }

    $CI->app_menu->add_sidebar_menu_item('sales', [
            'collapse' => true,
            'name'     => _l('als_sales'),
            'position' => 10,
            'icon'     => 'fa fa-balance-scale',
        ]);

    if ((has_permission('proposals', '', 'view') || has_permission('proposals', '', 'view_own'))
        || (staff_has_assigned_proposals() && get_option('allow_staff_view_proposals_assigned') == 1)) {
        $CI->app_menu->add_sidebar_children_item('sales', [
                'slug'     => 'proposals',
                'name'     => _l('proposals'),
                'href'     => admin_url('proposals'),
                'position' => 5,
        ]);
    }

    if ((has_permission('estimates', '', 'view') || has_permission('estimates', '', 'view_own'))
        || (staff_has_assigned_estimates() && get_option('allow_staff_view_estimates_assigned') == 1)) {
        $CI->app_menu->add_sidebar_children_item('sales', [
                'slug'     => 'estimates',
                'name'     => _l('estimates'),
                'href'     => admin_url('estimates'),
                'position' => 10,
        ]);
    }

    if ((has_permission('invoices', '', 'view') || has_permission('invoices', '', 'view_own'))
         || (staff_has_assigned_invoices() && get_option('allow_staff_view_invoices_assigned') == 1)) {
        $CI->app_menu->add_sidebar_children_item('sales', [
                'slug'     => 'invoices',
                'name'     => _l('invoices'),
                'href'     => admin_url('invoices'),
                'position' => 15,
        ]);
    }

    if (has_permission('payments', '', 'view') || has_permission('invoices', '', 'view_own')
           || (get_option('allow_staff_view_invoices_assigned') == 1 && staff_has_assigned_invoices())) {
        $CI->app_menu->add_sidebar_children_item('sales', [
                'slug'     => 'payments',
                'name'     => _l('payments'),
                'href'     => admin_url('payments'),
                'position' => 20,
        ]);
    }

    if (has_permission('credit_notes', '', 'view') || has_permission('credit_notes', '', 'view_own')) {
        $CI->app_menu->add_sidebar_children_item('sales', [
                'slug'     => 'credit_notes',
                'name'     => _l('credit_notes'),
                'href'     => admin_url('credit_notes'),
                'position' => 25,
        ]);
    }

    if (has_permission('items', '', 'view')) {
        $CI->app_menu->add_sidebar_children_item('sales', [
                'slug'     => 'items',
                'name'     => _l('items'),
                'href'     => admin_url('invoice_items'),
                'position' => 30,
        ]);
    }

    if (has_permission('subscriptions', '', 'view') || has_permission('subscriptions', '', 'view_own')) {
        $CI->app_menu->add_sidebar_menu_item('subscriptions', [
                'name'     => _l('subscriptions'),
                'href'     => admin_url('subscriptions'),
                'icon'     => 'fa fa-repeat',
                'position' => 15,
        ]);
    }

    if (has_permission('expenses', '', 'view') || has_permission('expenses', '', 'view_own')) {
        $CI->app_menu->add_sidebar_menu_item('expenses', [
                'name'     => _l('expenses'),
                'href'     => admin_url('expenses'),
                'icon'     => 'fa fa-file-text-o',
                'position' => 20,
        ]);
    }

    if (has_permission('contracts', '', 'view') || has_permission('contracts', '', 'view_own')) {
        $CI->app_menu->add_sidebar_menu_item('contracts', [
                'name'     => _l('contracts'),
                'href'     => admin_url('contracts'),
                'icon'     => 'fa fa-file',
                'position' => 25,
        ]);
    }
	if($CI->session->userdata('franchise')!=1){

    $CI->app_menu->add_sidebar_menu_item('projects', [
                'name'     => _l('projects'),
                'href'     => admin_url('projects'),
                'icon'     => 'fa fa-bars',
                'position' => 30,
        ]);

    $CI->app_menu->add_sidebar_menu_item('tasks', [
                'name'     => _l('als_tasks'),
                'href'     => admin_url('tasks'),
                'icon'     => 'fa fa-tasks',
                'position' => 35,
        ]);

    if ((!is_staff_member() && get_option('access_tickets_to_none_staff_members') == 1) || is_staff_member()) {
        $CI->app_menu->add_sidebar_menu_item('support', [
                'name'     => _l('support'),
                'href'     => admin_url('tickets'),
                'icon'     => 'fa fa-ticket',
                'position' => 40,
        ]);
    }

    if (is_staff_member()) {
        $CI->app_menu->add_sidebar_menu_item('leads', [
                'name'     => _l('als_leads'),
                'href'     => admin_url('leads'),
                'icon'     => 'fa fa-tty',
                'position' => 45,
        ]);
    }

    if (has_permission('knowledge_base', '', 'view')) {
        $CI->app_menu->add_sidebar_menu_item('knowledge-base', [
                'name'     => _l('als_kb'),
                'href'     => admin_url('knowledge_base'),
                'icon'     => 'fa fa-folder-open-o',
                'position' => 50,
        ]);
    }

    // Utilities
    $CI->app_menu->add_sidebar_menu_item('utilities', [
            'collapse' => true,
            'name'     => _l('als_utilities'),
            'position' => 55,
            'icon'     => 'fa fa-cogs',
        ]);

    $CI->app_menu->add_sidebar_children_item('utilities', [
                'slug'     => 'media',
                'name'     => _l('als_media'),
                'href'     => admin_url('utilities/media'),
                'position' => 5,
        ]);

    if (has_permission('bulk_pdf_exporter', '', 'view')) {
        $CI->app_menu->add_sidebar_children_item('utilities', [
                'slug'     => 'bulk-pdf-exporter',
                'name'     => _l('bulk_pdf_exporter'),
                'href'     => admin_url('utilities/bulk_pdf_exporter'),
                'position' => 10,
        ]);
    }

    $CI->app_menu->add_sidebar_children_item('utilities', [
                'slug'     => 'calendar',
                'name'     => _l('als_calendar_submenu'),
                'href'     => admin_url('utilities/calendar'),
                'position' => 15,
        ]);


    if (is_admin()) {
        $CI->app_menu->add_sidebar_children_item('utilities', [
                'slug'     => 'announcements',
                'name'     => _l('als_announcements_submenu'),
                'href'     => admin_url('announcements'),
                'position' => 20,
        ]);

        $CI->app_menu->add_sidebar_children_item('utilities', [
                'slug'     => 'activity-log',
                'name'     => _l('als_activity_log_submenu'),
                'href'     => admin_url('utilities/activity_log'),
                'position' => 25,
        ]);

        $CI->app_menu->add_sidebar_children_item('utilities', [
                'slug'     => 'ticket-pipe-log',
                'name'     => _l('ticket_pipe_log'),
                'href'     => admin_url('utilities/pipe_log'),
                'position' => 30,
        ]);
    }

    if (has_permission('reports', '', 'view')) {
        $CI->app_menu->add_sidebar_menu_item('reports', [
                'collapse' => true,
                'name'     => _l('als_reports'),
                'href'     => admin_url('reports'),
                'icon'     => 'fa fa-area-chart',
                'position' => 60,
        ]);
        $CI->app_menu->add_sidebar_children_item('reports', [
                'slug'     => 'sales-reports',
                'name'     => _l('als_reports_sales_submenu'),
                'href'     => admin_url('reports/sales'),
                'position' => 5,
        ]);
        $CI->app_menu->add_sidebar_children_item('reports', [
                'slug'     => 'expenses-reports',
                'name'     => _l('als_reports_expenses'),
                'href'     => admin_url('reports/expenses'),
                'position' => 10,
        ]);
        $CI->app_menu->add_sidebar_children_item('reports', [
                'slug'     => 'expenses-vs-income-reports',
                'name'     => _l('als_expenses_vs_income'),
                'href'     => admin_url('reports/expenses_vs_income'),
                'position' => 15,
        ]);
        $CI->app_menu->add_sidebar_children_item('reports', [
                'slug'     => 'leads-reports',
                'name'     => _l('als_reports_leads_submenu'),
                'href'     => admin_url('reports/leads'),
                'position' => 20,
        ]);

        if (is_admin()) {
            $CI->app_menu->add_sidebar_children_item('reports', [
                    'slug'     => 'timesheets-reports',
                    'name'     => _l('timesheets_overview'),
                    'href'     => admin_url('staff/timesheets?view=all'),
                    'position' => 25,
            ]);
        }

        $CI->app_menu->add_sidebar_children_item('reports', [
                    'slug'     => 'knowledge-base-reports',
                    'name'     => _l('als_kb_articles_submenu'),
                    'href'     => admin_url('reports/knowledge_base_articles'),
                    'position' => 30,
            ]);
    }

    // Setup menu
    if (has_permission('staff', '', 'view')) {
        $CI->app_menu->add_setup_menu_item('staff', [
                    'name'     => _l('als_staff'),
                    'href'     => admin_url('staff'),
                    'position' => 5,
            ]);
    }

    if (is_admin()) {
        $CI->app_menu->add_setup_menu_item('customers', [
                    'collapse' => true,
                    'name'     => _l('clients'),
                    'position' => 10,
            ]);

        $CI->app_menu->add_setup_children_item('customers', [
                    'slug'     => 'customer-groups',
                    'name'     => _l('customer_groups'),
                    'href'     => admin_url('clients/groups'),
                    'position' => 5,
            ]);
        $CI->app_menu->add_setup_menu_item('support', [
                    'collapse' => true,
                    'name'     => _l('support'),
                    'position' => 15,
            ]);

        $CI->app_menu->add_setup_children_item('support', [
                    'slug'     => 'departments',
                    'name'     => _l('acs_departments'),
                    'href'     => admin_url('departments'),
                    'position' => 5,
            ]);
        $CI->app_menu->add_setup_children_item('support', [
                    'slug'     => 'tickets-predefined-replies',
                    'name'     => _l('acs_ticket_predefined_replies_submenu'),
                    'href'     => admin_url('tickets/predefined_replies'),
                    'position' => 10,
            ]);
        $CI->app_menu->add_setup_children_item('support', [
                    'slug'     => 'tickets-priorities',
                    'name'     => _l('acs_ticket_priority_submenu'),
                    'href'     => admin_url('tickets/priorities'),
                    'position' => 15,
            ]);
        $CI->app_menu->add_setup_children_item('support', [
                    'slug'     => 'tickets-statuses',
                    'name'     => _l('acs_ticket_statuses_submenu'),
                    'href'     => admin_url('tickets/statuses'),
                    'position' => 20,
            ]);

        $CI->app_menu->add_setup_children_item('support', [
                    'slug'     => 'tickets-services',
                    'name'     => _l('acs_ticket_services_submenu'),
                    'href'     => admin_url('tickets/services'),
                    'position' => 25,
            ]);
        $CI->app_menu->add_setup_children_item('support', [
                    'slug'     => 'tickets-spam-filters',
                    'name'     => _l('spam_filters'),
                    'href'     => admin_url('spam_filters/view/tickets'),
                    'position' => 30,
            ]);

        $CI->app_menu->add_setup_menu_item('leads', [
                    'collapse' => true,
                    'name'     => _l('acs_leads'),
                    'position' => 20,
            ]);
        $CI->app_menu->add_setup_children_item('leads', [
                    'slug'     => 'leads-sources',
                    'name'     => _l('acs_leads_sources_submenu'),
                    'href'     => admin_url('leads/sources'),
                    'position' => 5,
            ]);
        $CI->app_menu->add_setup_children_item('leads', [
                    'slug'     => 'leads-statuses',
                    'name'     => _l('acs_leads_statuses_submenu'),
                    'href'     => admin_url('leads/statuses'),
                    'position' => 10,
            ]);
        $CI->app_menu->add_setup_children_item('leads', [
                    'slug'     => 'leads-email-integration',
                    'name'     => _l('leads_email_integration'),
                    'href'     => admin_url('leads/email_integration'),
                    'position' => 15,
            ]);
        $CI->app_menu->add_setup_children_item('leads', [
                    'slug'     => 'web-to-lead',
                    'name'     => _l('web_to_lead'),
                    'href'     => admin_url('leads/forms'),
                    'position' => 20,
            ]);

        $CI->app_menu->add_setup_menu_item('finance', [
                    'collapse' => true,
                    'name'     => _l('acs_finance'),
                    'position' => 25,
            ]);
        $CI->app_menu->add_setup_children_item('finance', [
                    'slug'     => 'taxes',
                    'name'     => _l('acs_sales_taxes_submenu'),
                    'href'     => admin_url('taxes'),
                    'position' => 5,
            ]);
        $CI->app_menu->add_setup_children_item('finance', [
                    'slug'     => 'currencies',
                    'name'     => _l('acs_sales_currencies_submenu'),
                    'href'     => admin_url('currencies'),
                    'position' => 10,
            ]);
        $CI->app_menu->add_setup_children_item('finance', [
                    'slug'     => 'payment-modes',
                    'name'     => _l('acs_sales_payment_modes_submenu'),
                    'href'     => admin_url('paymentmodes'),
                    'position' => 15,
            ]);
        $CI->app_menu->add_setup_children_item('finance', [
                    'slug'     => 'expenses-categories',
                    'name'     => _l('acs_expense_categories'),
                    'href'     => admin_url('expenses/categories'),
                    'position' => 20,
            ]);

        $CI->app_menu->add_setup_menu_item('contracts', [
                    'collapse' => true,
                    'name'     => _l('acs_contracts'),
                    'position' => 30,
            ]);
        $CI->app_menu->add_setup_children_item('contracts', [
                    'slug'     => 'contracts-types',
                    'name'     => _l('acs_contract_types'),
                    'href'     => admin_url('contracts/types'),
                    'position' => 5,
            ]);

        $modules_name = _l('modules');

        if ($modulesNeedsUpgrade = $CI->app_modules->number_of_modules_that_require_database_upgrade()) {
            $modules_name .= '<span class="badge menu-badge bg-warning">' . $modulesNeedsUpgrade . '</span>';
        }

        $CI->app_menu->add_setup_menu_item('modules', [
                    'href'     => admin_url('modules'),
                    'name'     => $modules_name,
                    'position' => 35,
            ]);

        $CI->app_menu->add_setup_menu_item('custom-fields', [
                    'href'     => admin_url('custom_fields'),
                    'name'     => _l('asc_custom_fields'),
                    'position' => 45,
            ]);

        $CI->app_menu->add_setup_menu_item('gdpr', [
                    'href'     => admin_url('gdpr'),
                    'name'     => _l('gdpr_short'),
                    'position' => 50,
            ]);

        $CI->app_menu->add_setup_menu_item('roles', [
                    'href'     => admin_url('roles'),
                    'name'     => _l('acs_roles'),
                    'position' => 55,
            ]);

/*             $CI->app_menu->add_setup_menu_item('api', [
                          'href'     => admin_url('api'),
                          'name'     => 'API',
                          'position' => 65,
                  ]);*/

    }

    if (has_permission('settings', '', 'view')) {
        $CI->app_menu->add_setup_menu_item('settings', [
                    'href'     => admin_url('settings'),
                    'name'     => _l('acs_settings'),
                    'position' => 200,
            ]);
    }

    if (has_permission('email_templates', '', 'view')) {
        $CI->app_menu->add_setup_menu_item('email-templates', [
                    'href'     => admin_url('emails'),
                    'name'     => _l('acs_email_templates'),
                    'position' => 40,
            ]);
    }


    $CI->app_menu->add_sidebar_menu_item('recommended_food', [
        'collapse' => true,
        'name'     => _l('Recommended Food'),
        'position' => 41,
        'icon'     => 'fa fa-thumbs-up',
    ]);


    $CI->app_menu->add_sidebar_children_item('recommended_food', [
            'slug'     => 'recommended_item',
            'name'     => _l('Frequently Item'),
            'href'     => admin_url('clients/recommended_customers_food'),
            'position' => 1,
            'icon'     => 'fa fa-list-alt',
    ]);

    $CI->app_menu->add_sidebar_children_item('recommended_food', [
            'slug'     => 'cross_sale_item',
            'name'     => _l('Cross Sale Item'),
            'href'     => admin_url('clients/recommended_cross_customers_food'),
            'position' => 2,
            'icon'     => 'fa fa-list-alt',
    ]);

    $CI->app_menu->add_sidebar_children_item('recommended_food', [
            'slug'     => 'future_recommended_item',
            'name'     => _l('Recommend Items'),
            'href'     => admin_url('clients/future_recommended_item'),
            'position' => 3,
            'icon'     => 'fa fa-list-alt',
    ]);

    $CI->app_menu->add_sidebar_children_item('recommended_food', [
            'slug'     => 'search_recommended_item',
            'name'     => _l('Search Item'),
            'href'     => admin_url('clients/search_recommended_item'),
            'position' => 4,
            'icon'     => 'fa fa-list-alt',
    ]);


    $CI->app_menu->add_sidebar_children_item('recommended_food', [
            'slug'     => 'popular_recommended_item',
            'name'     => _l('Popular Item'),
            'href'     => admin_url('clients/popular_recommended_item'),
            'position' => 5,
            'icon'     => 'fa fa-list-alt',
    ]);

    $CI->app_menu->add_sidebar_children_item('recommended_food', [
            'slug'     => 'deal_recommended_item',
            'name'     => _l('Deal Item'),
            'href'     => admin_url('clients/deals_recommended_item'),
            'position' => 6,
            'icon'     => 'fa fa-list-alt',
    ]);

  }// NED of franchse
}
