<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProxyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// SPH ROUTES

//Default ke LOGIN Route
Route::get('/', function () {
    return view('login');
});
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::match(['GET', 'POST'], '/logout', [AuthController::class, 'logout'])->name('logout');
Route::prefix('home')->group(function () {
Route::view('/', 'home.index')->name('home')->middleware('permission:dashboard.logbook');
Route::view('edit-profile', 'home.edit_profile')->name('edit_profile');
});
Route::any('/api/{path}', [ProxyController::class, 'handle'])->where('path', '.*');

// Test route untuk debug permission
Route::get('/test-permission', function() {
    $permissions = session('permissions', []);
    $sphMenu = $permissions['sph.menu'] ?? 'not found';
    $hasAccess = \App\Helpers\PermissionHelper::hasSubMenuAccess('sph.menu', 'sph.o.menu');

    return response()->json([
        'permissions' => $permissions,
        'sph.menu' => $sphMenu,
        'hasSubMenuAccess_sph.o.menu' => $hasAccess,
        'session_id' => session()->getId()
    ]);
})->name('test-permission');

// SPH Routes with Permission Middleware
Route::view('sph', 'sph.index')->name('sph')->middleware('permission:sph.menu');
Route::view('sph-create', 'sph.create')->name('sph_create')->middleware('permission:sph.menu');
Route::view('approval-center', 'approval.index')->name('approval_center')->middleware('permission:approval.menu');
Route::view('good-receipt', 'good_receipt.index')->name('good_receipt')->middleware('permission:sph.menu');
Route::view('delivery-request', 'delivery_request.index')->name('delivery_request')->middleware('permission:log.menu');
Route::view('delivery-note', 'delivery_note.index')->name('delivery_note')->middleware('permission:log.menu');
Route::view('cetak-po', 'purchase_order.index')->name('cetak-po')->middleware('permission:fin.menu');
Route::view('bayar-po', 'purchase_order.bayar')->name('bayar-po')->middleware('permission:fin.menu');
Route::view('vendor-database', 'vendor.index')->name('vendor-database')->middleware('permission:master.vendor');
Route::view('customer-database', 'customer.index')->name('customer-database')->middleware('permission:master.customer');
Route::view('oat-configuration', 'oat_configuration.index')->name('oat-configuration')->middleware('permission:master.oat');
Route::view('master-lokasi', 'master_lokasi.index')->name('master-lokasi')->middleware('permission:master.lokasi');
Route::view('user-management', 'user_management.index')->name('user-management')->middleware('permission:admin.user');
Route::view('permission-management', 'user_management.permission')->name('permission-management')->middleware('permission:admin.menu');
Route::view('user-log', 'user_management.userlog')->name('user-log')->middleware('permission:admin.logging');
Route::view('invoice', 'invoice.index')->name('invoice')->middleware('permission:fin.menu');


Route::get('/invoice/create', [AuthController::class, 'createInvoice'])->name('invoices.create');
Route::get('/invoice/view', [AuthController::class, 'viewInvoice'])->name('invoices.view');
Route::get('/invoice/proforma', [AuthController::class, 'proformaInvoice'])->name('invoices.proforma');


// END OF ROUTE SPH
Route::prefix('dashboard')->group(function () {
Route::view('/', 'dashboards.default_dashboard')->name('dashboard');
});
Route::view('ecommerce-dashboard', 'dashboards.ecommerce_dashboard')->name('ecommerce_dashboard');

//admin unique layouts

Route::view('dashboard-light', 'admin_unique_layout.light_dashboard')->name('dashboard-light');
Route::view('e-commerce-light', 'admin_unique_layout.e-commerce-light')->name('e-commerce-light');
Route::view('general-widget-light', 'admin_unique_layout.general-widget-light')->name('general-widget-light');
Route::view('dashboard-dark', 'admin_unique_layout.dark_dashboard')->name('dashboard-dark');
Route::view('e-commerce-dark', 'admin_unique_layout.e-commerce-dark')->name('e-commerce-dark');
Route::view('general-widget-dark', 'admin_unique_layout.general-widget-dark')->name('general-widget-dark');
Route::view('dashboard-box', 'admin_unique_layout.box_dashboard')->name('dashboard-box');
Route::view('e-commerce-box', 'admin_unique_layout.e-commerce-box')->name('e-commerce-box');
Route::view('general-widget-box', 'admin_unique_layout.general-widget-box')->name('general-widget-box');


//widgets
Route::view('general-widget', 'Widgets.general_widget')->name('general_widget');
Route::view('chart-widget', 'Widgets.chart_widget')->name('chart_widget');

//page_layout
Route::view('box-layout', 'page_layout.box_layout')->name('box_layout');
Route::view('layout-rtl', 'page_layout.layout_rtl')->name('layout_rtl');
Route::view('layout-dark', 'page_layout.layout_dark')->name('layout_dark');
Route::view('hide-on-scroll', 'page_layout.hide_on_scroll')->name('hide_on_scroll');
Route::view('footer-light', 'page_layout.footer_light')->name('footer_light');
Route::view('footer-dark', 'page_layout.footer_dark')->name('footer_dark');
Route::view('footer-fixed', 'page_layout.footer_fixed')->name('footer_fixed');

//projects
Route::view('projects', 'project.projects')->name('projects');
Route::view('create-projects', 'project.project_create')->name('project_create');

//file manager
Route::view('file-manager', 'file_manager')->name('file_manager');

//kanban board
Route::view('kanban', 'kanban')->name('kanban');

//ecommerce
Route::view('product', 'ecommerce.product')->name('product');
Route::view('page-product', 'ecommerce.product_page')->name('product_page');
Route::view('add-products', 'ecommerce.add_products')->name('add_products');
Route::view('list-products', 'ecommerce.list_products')->name('list_products');
Route::view('payment-details', 'ecommerce.payment_details')->name('payment_details');
Route::view('order-history', 'ecommerce.order_history')->name('order_history');
Route::view('invoice-template', 'ecommerce.invoice_template')->name('invoice_template');
Route::view('cart', 'ecommerce.cart')->name('cart');
Route::view('list-wish', 'ecommerce.list_wish')->name('list_wish');
Route::view('checkout', 'ecommerce.checkout')->name('checkout');
Route::view('pricing', 'ecommerce.pricing')->name('pricing');

//email
Route::view('email-inbox', 'email.email_inbox')->name('email_inbox');
Route::view('email-read', 'email.email_read')->name('email_read');
Route::view('email-compose', 'email.email_compose')->name('email_compose');

//chat
Route::view('chat', 'chat.chat')->name('chat');
Route::view('video-chat', 'chat.chat_video')->name('chat_video');

//users
Route::view('user-profile', 'users.user_profile')->name('user_profile');
// Route::view('edit-profile', 'users.edit_profile')->name('edit_profile');
Route::view('user-cards', 'users.user_cards')->name('user_cards');

//bookmark
Route::view('bookmark', 'bookmark')->name('bookmark');

//contacts
Route::view('contacts', 'contacts')->name('contacts');

//tasks
Route::view('task', 'task')->name('task');

//calendar
Route::view('calendar-basic', 'calendar_basic')->name('calendar_basic');

//social_app
Route::view('social-app', 'social_app')->name('social_app');

//to_do
Route::view('to-do', 'to_do')->name('to_do');

//search_result
Route::view('search', 'search')->name('search');

//Forms -> form_controls
Route::view('form-validation', 'forms.form_controls.form_validation')->name('form_validation');
Route::view('base-input', 'forms.form_controls.base_input')->name('base_input');
Route::view('radio-checkbox-control', 'forms.form_controls.radio_checkbox_control')->name('radio_checkbox_control');
Route::view('input-group', 'forms.form_controls.input_group')->name('input_group');
Route::view('megaoptions', 'forms.form_controls.megaoptions')->name('megaoptions');

//Forms -> form_widgets
Route::view('datepicker', 'forms.form_widgets.datepicker')->name('datepicker');
Route::view('time-picker', 'forms.form_widgets.time_picker')->name('time_picker');
Route::view('datetimepicker', 'forms.form_widgets.datetimepicker')->name('datetimepicker');
Route::view('daterangepicker', 'forms.form_widgets.daterangepicker')->name('daterangepicker');
Route::view('touchspin', 'forms.form_widgets.touchspin')->name('touchspin');
Route::view('select2', 'forms.form_widgets.select2')->name('select2');
Route::view('switch', 'forms.form_widgets.switch')->name('switch');
Route::view('typeahead', 'forms.form_widgets.typeahead')->name('typeahead');
Route::view('clipboard', 'forms.form_widgets.clipboard')->name('clipboard');

//Forms -> form_layout
Route::view('default-form', 'forms.form_layout.default_form')->name('default_form');
Route::view('form-wizard', 'forms.form_layout.form_wizard')->name('form_wizard');
Route::view('two-form-wizard', 'forms.form_layout.form_wizard_two')->name('form_wizard_two');
Route::view('three-form-wizard', 'forms.form_layout.form_wizard_three')->name('form_wizard_three');

//Tables -> bootstrap_tables
Route::view('bootstrap-basic-table', 'tables.bootstrap_tables.bootstrap_basic_table')->name('bootstrap_basic_table');
Route::view('bootstrap-sizing-table', 'tables.bootstrap_tables.bootstrap_sizing_table')->name('bootstrap_sizing_table');
Route::view('bootstrap-border-table', 'tables.bootstrap_tables.bootstrap_border_table')->name('bootstrap_border_table');
Route::view('bootstrap-styling-table', 'tables.bootstrap_tables.bootstrap_styling_table')->name('bootstrap_styling_table');
Route::view('table-components', 'tables.bootstrap_tables.table_components')->name('table_components');

//Tables -> data_tables
Route::view('datatable-basic-init', 'tables.data_tables.datatable_basic_init')->name('datatable_basic_init');
Route::view('datatable-advance', 'tables.data_tables.datatable_advance')->name('datatable_advance');
Route::view('datatable-styling', 'tables.data_tables.datatable_styling')->name('datatable_styling');
Route::view('datatable-ajax', 'tables.data_tables.datatable_ajax')->name('datatable_ajax');
Route::view('datatable-server-side', 'tables.data_tables.datatable_server_side')->name('datatable_server_side');
Route::view('datatable-plugin', 'tables.data_tables.datatable_plugin')->name('datatable_plugin');
Route::view('datatable-api', 'tables.data_tables.datatable_api')->name('datatable_api');
Route::view('datatable-data-source', 'tables.data_tables.datatable_data_source')->name('datatable_data_source');

//Tables -> extension_data_tables
Route::view('datatable-ext-autofill', 'tables.datatable_ext_autofill')->name('datatable_ext_autofill');

//Tables ->jsgrid-table
Route::view('jsgrid-table', 'tables.jsgrid_table')->name('jsgrid_table');

//ui_kits
Route::view('typography', 'ui_kits.typography')->name('typography');
Route::view('avatars', 'ui_kits.avatars')->name('avatars');
Route::view('helper-classes', 'ui_kits.helper_classes')->name('helper_classes');
Route::view('grid', 'ui_kits.grid')->name('grid');
Route::view('tag-pills', 'ui_kits.tag_pills')->name('tag_pills');
Route::view('progress-bar', 'ui_kits.progress_bar')->name('progress_bar');
Route::view('modal', 'ui_kits.modal')->name('modal');
Route::view('alert', 'ui_kits.alert')->name('alert');
Route::view('popover', 'ui_kits.popover')->name('popover');
Route::view('tooltip', 'ui_kits.tooltip')->name('tooltip');
Route::view('loader', 'ui_kits.loader')->name('loader');
Route::view('dropdown', 'ui_kits.dropdown')->name('dropdown');
Route::view('according', 'ui_kits.according')->name('according');
Route::view('tab-bootstrap', 'ui_kits.tabs.tab_bootstrap')->name('tab_bootstrap');
Route::view('tab-material', 'ui_kits.tabs.tab_material')->name('tab_material');
Route::view('box-shadow', 'ui_kits.box_shadow')->name('box_shadow');
Route::view('list', 'ui_kits.list')->name('list');

//bonus_ui
Route::view('scrollable', 'bonus_ui.scrollable')->name('scrollable');
Route::view('tree', 'bonus_ui.tree')->name('tree');
Route::view('bootstrap-notify', 'bonus_ui.bootstrap_notify')->name('bootstrap_notify');
Route::view('rating', 'bonus_ui.rating')->name('rating');
Route::view('dropzone', 'bonus_ui.dropzone')->name('dropzone');
Route::view('tour', 'bonus_ui.tour')->name('tour');
Route::view('sweet-alert2', 'bonus_ui.sweet_alert2')->name('sweet_alert2');
Route::view('animation-modal', 'bonus_ui.modal_animated')->name('modal_animated');
Route::view('owl-carousel', 'bonus_ui.owl_carousel')->name('owl_carousel');
Route::view('ribbons', 'bonus_ui.ribbons')->name('ribbons');
Route::view('pagination', 'bonus_ui.pagination')->name('pagination');
Route::view('breadcrumb', 'bonus_ui.breadcrumb')->name('breadcrumb');
Route::view('range-slider', 'bonus_ui.range_slider')->name('range_slider');
Route::view('image-cropper', 'bonus_ui.image_cropper')->name('image_cropper');
Route::view('sticky', 'bonus_ui.sticky')->name('sticky');
Route::view('basic-card', 'bonus_ui.basic_card')->name('basic_card');
Route::view('creative-card', 'bonus_ui.creative_card')->name('creative_card');
Route::view('tabbed-card', 'bonus_ui.tabbed_card')->name('tabbed_card');
Route::view('dragable-card', 'bonus_ui.dragable_card')->name('dragable_card');
Route::view('timeline-v-1', 'bonus_ui.timeline.timeline_v_1')->name('timeline_v_1');
Route::view('timeline-v-2', 'bonus_ui.timeline.timeline_v_2')->name('timeline_v_2');

//builders
Route::view('form-builder-1', 'builders.form_builder_1')->name('form_builder_1');
Route::view('form-builder-2', 'builders.form_builder_2')->name('form_builder_2');
Route::view('pagebuild', 'builders.pagebuild')->name('pagebuild');
Route::view('button-builder', 'builders.button_builder')->name('button_builder');

//animation
Route::view('animate', 'animation.animate')->name('animate');
Route::view('scroll-reval', 'animation.scroll_reval')->name('scroll_reval');
Route::view('aos', 'animation.aos')->name('aos');
Route::view('tilt', 'animation.tilt')->name('tilt');
Route::view('wow', 'animation.wow')->name('wow');

//icons
Route::view('flag-icon', 'icons.flag_icon')->name('flag_icon');
Route::view('font-awesome', 'icons.font_awesome')->name('font_awesome');
Route::view('ico-icon', 'icons.ico_icon')->name('ico_icon');
Route::view('themify-icon', 'icons.themify_icon')->name('themify_icon');
Route::view('feather-icon', 'icons.feather_icon')->name('feather_icon');
Route::view('whether-icon', 'icons.whether_icon')->name('whether_icon');

//buttons
Route::view('buttons', 'buttons.buttons')->name('buttons');
Route::view('buttons-flat', 'buttons.buttons_flat')->name('buttons_flat');
Route::view('buttons-edge', 'buttons.buttons_edge')->name('buttons_edge');
Route::view('raised-button', 'buttons.raised_button')->name('raised_button');
Route::view('button-group', 'buttons.button_group')->name('button_group');

//charts
Route::view('chart-apex', 'charts.chart_apex')->name('chart_apex');
Route::view('chart-sparkline', 'charts.chart_sparkline')->name('chart_sparkline');
Route::view('chart-flot', 'charts.chart_flot')->name('chart_flot');
Route::view('chart-knob', 'charts.chart_knob')->name('chart_knob');
Route::view('chart-morris', 'charts.chart_morris')->name('chart_morris');
Route::view('chartjs', 'charts.chartjs')->name('chartjs');
Route::view('chartist', 'charts.chartist')->name('chartist');
Route::view('chart-peity', 'charts.chart_peity')->name('chart_peity');

//landing_page
Route::view('landing-page', 'pages.landing_page')->name('landing_page');

//sample-page
Route::view('sample-page', 'pages.sample_page')->name('sample_page');

//internationalization
Route::view('internationalization', 'pages.internationalization')->name('internationalization');

//others -> error_page
Route::view('error-page1', 'others.error_pages.error_page1')->name('error_page1');
Route::view('error-page2', 'others.error_pages.error_page2')->name('error_page2');
Route::view('error-page3', 'others.error_pages.error_page3')->name('error_page3');
Route::view('error-page4', 'others.error_pages.error_page4')->name('error_page4');
Route::view('error-page5', 'others.error_pages.error_page5')->name('error_page5');

//others -> authentication
Route::view('login', 'others.authentication.login')->name('login');
Route::view('login-one', 'others.authentication.login_one')->name('login_one');
Route::view('login-two', 'others.authentication.login_two')->name('login_two');
Route::view('login-bs-validation', 'others.authentication.login_bs_validation')->name('login_bs_validation');
Route::view('login-bs-tt-validation', 'others.authentication.login_bs_tt_validation')->name('login_bs_tt_validation');
Route::view('login-sa-validation', 'others.authentication.login_sa_validation')->name('login_sa_validation');
Route::view('sign-up', 'others.authentication.sign_up')->name('sign_up');
Route::view('sign-up-one', 'others.authentication.sign_up_one')->name('sign_up_one');
Route::view('sign-up-two', 'others.authentication.sign_up_two')->name('sign_up_two');
Route::view('unlock', 'others.authentication.unlock')->name('unlock');
Route::view('forget-password', 'others.authentication.forget_password')->name('forget_password');
Route::view('reset-password', 'others.authentication.reset_password')->name('reset_password');
Route::view('maintenance', 'others.authentication.maintenance')->name('maintenance');

//others -> coming_soon
Route::view('comingsoon', 'others.coming_soon.comingsoon')->name('comingsoon');
Route::view('comingsoon-bg-video', 'others.coming_soon.comingsoon_bg_video')->name('comingsoon_bg_video');
Route::view('comingsoon-bg-img', 'others.coming_soon.comingsoon_bg_img')->name('comingsoon_bg_img');

//others -> email_templates
Route::view('basic-template', 'others.email_templates.basic_template')->name('basic_template');
Route::view('email-header', 'others.email_templates.email_header')->name('email_header');
Route::view('ecommerce-templates', 'others.email_templates.ecommerce_templates')->name('ecommerce_templates');
Route::view('email-order-success', 'others.email_templates.email_order_success')->name('email_order_success');
Route::view('template-email', 'others.email_templates.template_email')->name('template_email');
Route::view('template-email-2', 'others.email_templates.template_email_2')->name('template_email_2');



//gallery
Route::view('gallery', 'gallery.gallery')->name('gallery');
Route::view('with-description', 'gallery.gallery_with_description')->name('gallery_with_description');
Route::view('masonry', 'gallery.gallery_masonry')->name('gallery_masonry');
Route::view('swith-disc-masonry', 'gallery.masonry_gallery_with_disc')->name('masonry_gallery_with_disc');
Route::view('hover', 'gallery.gallery_hover')->name('gallery_hover');

//blog
Route::view('blog', 'blog.blog')->name('blog');
Route::view('single-blog', 'blog.blog_single')->name('blog_single');
Route::view('add-post', 'blog.add_post')->name('add_post');

//faq
Route::view('faq', 'faq')->name('faq');

//job_search
Route::view('job-cards-view', 'job_search.job_cards_view')->name('job_cards_view');
Route::view('job-list-view', 'job_search.job_list_view')->name('job_list_view');
Route::view('job-details', 'job_search.job_details')->name('job_details');
Route::view('job-apply', 'job_search.job_apply')->name('job_apply');

//learning
Route::view('learning-list-view', 'learning.learning_list_view')->name('learning_list_view');
Route::view('learning-detailed', 'learning.learning_detailed')->name('learning_detailed');

//maps
Route::view('map-js', 'maps.map_js')->name('map_js');
Route::view('vector-map', 'maps.vector_map')->name('vector_map');

//editors
Route::view('summernote', 'editors.summernote')->name('summernote');
Route::view('ckeditor', 'editors.ckeditor')->name('ckeditor');
Route::view('simple-mde', 'editors.simple_mde')->name('simple_mde');
Route::view('ace-code-editor', 'editors.ace_code_editor')->name('ace_code_editor');

//knowledgebase
Route::view('knowledgebase', 'knowledgebase.knowledgebase')->name('knowledgebase');
Route::view('knowledge-category', 'knowledgebase.knowledge_category')->name('knowledge_category');
Route::view('knowledge-detail', 'knowledgebase.knowledge_detail')->name('knowledge_detail');

//support_ticket
Route::view('support-ticket', 'support_ticket')->name('support_ticket');




