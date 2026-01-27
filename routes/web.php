<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
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
// Dashboard route alias (used in breadcrumbs and navigation)
Route::get('/dashboard', function () {
    return redirect()->route('home');
})->name('dashboard')->middleware('permission:dashboard.logbook');
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
// Route untuk serve OAT Gawi JSON file (harus sebelum route dynamic form agar tidak bentrok)
Route::get('sph/form/oat_gawi.json', function () {
    $jsonPath = resource_path('views/sph/form/oat_gawi.json');
    if (file_exists($jsonPath)) {
        $jsonContent = file_get_contents($jsonPath);
        return response($jsonContent, 200)
            ->header('Content-Type', 'application/json');
    }
    return response()->json(['error' => 'File not found'], 404);
})->name('sph.form.oat_gawi.json');
// Route untuk update OAT Gawi JSON file
Route::post('sph/form/oat_gawi.json/update', function (Request $request) {
    $jsonPath = resource_path('views/sph/form/oat_gawi.json');
    
    if (!file_exists($jsonPath)) {
        return response()->json(['error' => 'File not found'], 404);
    }
    
    $request->validate([
        'lokasi' => 'required|string|in:Kalteng,Kalsel',
        'details' => 'required|array',
        'details.*.nama_lokasi' => 'required|string',
        'details.*.oat5kl' => 'required|numeric',
        'details.*.oat10kl' => 'required|numeric',
    ]);
    
    // Baca data JSON yang ada
    $existingData = json_decode(file_get_contents($jsonPath), true);
    if (!is_array($existingData)) {
        $existingData = [];
    }
    
    // Cari index lokasi yang akan di-update
    $lokasiIndex = -1;
    foreach ($existingData as $index => $item) {
        if ($item['lokasi'] === $request->lokasi) {
            $lokasiIndex = $index;
            break;
        }
    }
    
    // Update atau tambah data
    $newDetails = [];
    foreach ($request->details as $detail) {
        $newDetails[] = [
            'nama_lokasi' => $detail['nama_lokasi'],
            'oat5kl' => floatval($detail['oat5kl']),
            'oat10kl' => floatval($detail['oat10kl']),
        ];
    }
    
    if ($lokasiIndex >= 0) {
        // Update existing lokasi
        $existingData[$lokasiIndex]['details'] = $newDetails;
    } else {
        // Tambah lokasi baru
        $existingData[] = [
            'lokasi' => $request->lokasi,
            'details' => $newDetails,
        ];
    }
    
    // Simpan ke file dengan format yang rapi
    $jsonContent = json_encode($existingData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    file_put_contents($jsonPath, $jsonContent);
    
    return response()->json([
        'success' => true,
        'message' => 'Data OAT berhasil diupdate',
        'data' => $existingData
    ]);
})->name('sph.form.oat_gawi.json.update');
// Dynamic SPH form route: renders blade in resources/views/sph/form/{form}.blade.php
Route::get('sph/form/{form}', function ($form) {
    $view = 'sph.form.' . $form;
    if (view()->exists($view)) {
        return view($view);
    }
    return view('sph.form.not_found', ['form' => $form]);
})->name('sph.form.dynamic')->middleware('permission:sph.menu');
Route::view('approval-center', 'approval.index')->name('approval_center')->middleware('permission:approval.menu');
Route::view('good-receipt', 'good_receipt.index')->name('good_receipt')->middleware('permission:sph.menu');
Route::view('delivery-request', 'delivery_request.index')->name('delivery_request')->middleware('permission:log.menu');
Route::view('delivery-note', 'delivery_note.index')->name('delivery_note')->middleware('permission:log.menu');
Route::view('cetak-po', 'purchase_order.index')->name('cetak-po')->middleware('permission:fin.menu');
Route::view('bayar-po', 'purchase_order.bayar')->name('bayar-po')->middleware('permission:fin.menu');
Route::view('purchase-order', 'purchase_order.purchase_order')->name('purchase_order.index')->middleware('permission:fin.menu');
Route::view('purchase-order/create-supplier', 'purchase_order.create_supplier')->name('purchase_order.create_supplier')->middleware('permission:fin.menu');
Route::view('purchase-order/create-transportir', 'purchase_order.create_transportir')->name('purchase_order.create_transportir')->middleware('permission:fin.menu');
Route::view('vendor-database', 'vendor.index')->name('vendor-database')->middleware('permission:master.vendor');
Route::view('customer-database', 'customer.index')->name('customer-database')->middleware('permission:master.customer');
Route::view('oat-configuration', 'oat_configuration.index')->name('oat-configuration')->middleware('permission:master.oat');
Route::view('master-lokasi', 'master_lokasi.index')->name('master-lokasi')->middleware('permission:master.lokasi');
Route::view('master-wilayah', 'master_lokasi.wilayah')->name('master-wilayah')->middleware('permission:master.wilayah');
Route::view('workflow-engine', 'user_management.workflow')->name('workflow-engine')->middleware('permission:admin.workflow');
Route::view('user-management', 'user_management.index')->name('user-management')->middleware('permission:admin.user');
Route::view('manual-guide', 'manual.manual')->name('manual-guide')->middleware('permission:admin.manual');
Route::view('manual-books', 'manual.books')->name('manual-books');
Route::view('permission-management', 'user_management.permission')->name('permission-management')->middleware('permission:admin.menu');
Route::view('user-log', 'user_management.userlog')->name('user-log')->middleware('permission:admin.logging');
Route::view('invoice', 'invoice.index')->name('invoice')->middleware('permission:fin.menu');
Route::view('master-engine', 'user_management.workflow')->name('master-engine')->middleware('permission:master.engine');

// Invoice routes
Route::get('/invoice/create', [AuthController::class, 'createInvoice'])->name('invoices.create');
Route::get('/invoice/view', [AuthController::class, 'viewInvoice'])->name('invoices.view');
Route::get('/invoice/proforma', [AuthController::class, 'proformaInvoice'])->name('invoices.proforma');
