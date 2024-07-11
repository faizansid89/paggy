<?php

use App\Http\Controllers\AppoinmentController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\MissSaleController;
use App\Http\Controllers\SaleReturnController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ServicesAssessmentsController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\ServicesDownloadFileController;
use App\Http\Controllers\SyncController;
use App\Http\Controllers\SyncLogController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\SubCategoriesController;
use App\Http\Controllers\ProductUnitController;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PurchasesController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\LiveStreamController;
use App\Http\Controllers\WebinarController;

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

Route::get('/', function () {
    return redirect()->route('dashboard');
});

//Route::get('temp_table', function () {
//    $tempData = DB::table('temp_table')->select('id', 'tax', 'discount')->get();
//    foreach ($tempData as $data) {
//        $product = \App\Models\Products::find($data->id);
//
//
//        echo '<p>================================================== <br/> === OLD DATA === <br/>Product Name: '.$product->name.'<br/>Discount: '.$product->discount.'<br/>Tax: '.$product->tax.'</p><hr>';
//        if ($product) {
//            // Update the tax and discount columns
//            $product->tax = $data->tax;
//            $product->discount = $data->discount;
//            $product->save();
//        }
//        echo '<p>=== NEW DATA === <br/>Product Name: '.$product->name.'<br/>Discount: '.$product->discount.'<br/>Tax: '.$product->tax.'</p>';
//    }
//});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth']], function () {



    
    
    
    
    // Route::get('certificate',[LiveStreamController::class,'certificate'])->name('livestream.certificate');
    // Route::get('buy/{id}',[LiveStreamController::class,'buy'])->name('livestream.buy');
    

    Route::group(['prefix' => 'livestream'], function () {
        Route::get('booked',[LiveStreamController::class,'booked'])->name('livestream.booked');
        Route::group(['prefix' => 'booked'], function () {
            Route::get('general',[LiveStreamController::class,'general'])->name('livestream.general');
            Route::get('professional',[LiveStreamController::class,'professional'])->name('livestream.professional');
        });

        Route::group(['prefix' => 'evolution'], function () {
            Route::get('/',[LiveStreamController::class,'evolution'])->name('livestream.evolution');
            Route::get('form',[LiveStreamController::class,'evaluation_form'])->name('livestream.evaluation_form');
            Route::post('create',[LiveStreamController::class,'evaluation_create'])->name('livestream.evaluation_create');
            Route::get('/{id}',[LiveStreamController::class,'evolution_show'])->name('livestream.evolution_show');
        });

        Route::get('assessment',[LiveStreamController::class,'assessment'])->name('livestream.assessment');
        Route::get('certificate',[CertificateController::class,'index'])->name('livestream.certificate');
        Route::get('certificate/create',[CertificateController::class,'create'])->name('livestream.certificate.create');
        Route::get('certificate/store',[CertificateController::class,'store'])->name('livestream.certificate.store');

        Route::post('buy',[LiveStreamController::class,'buy'])->name('livestream.buy');
    });
    Route::resource('livestream',LiveStreamController::class);


    Route::group(['prefix' => 'webinar'], function () {
        Route::get('booked',[WebinarController::class,'booked'])->name('webinar.booked');
        Route::group(['prefix' => 'booked'], function () {
            Route::get('general',[WebinarController::class,'general'])->name('webinar.generalw');
            Route::get('professional',[WebinarController::class,'professional'])->name('webinar.professionalw');
        });

        Route::group(['prefix' => 'evolution'], function () {
            Route::get('/',[WebinarController::class,'evolution'])->name('webinar.evolution');
            Route::get('form',[WebinarController::class,'evaluation_form'])->name('webinar.evaluation_form');
            Route::post('create',[WebinarController::class,'evaluation_create'])->name('webinar.evaluation_create');
            Route::get('/{id}',[WebinarController::class,'evolution_show'])->name('webinar.evolution_show');
        });
        Route::get('assessment',[WebinarController::class,'assessment'])->name('webinar.assessment');
        Route::get('certificate',[CertificateController::class,'index'])->name('webinar.certificate');
        Route::get('certificate/create',[CertificateController::class,'create'])->name('webinar.certificate.create');
        Route::get('certificate/store',[CertificateController::class,'store'])->name('webinar.certificate.store');

        Route::post('buy',[WebinarController::class,'buy'])->name('webinar.buy');
    });
    Route::resource('webinar',WebinarController::class);
    
    
    
    
    
    
    // Route::get('buyw/{id}',[WebinarController::class,'buy'])->name('webinar.buy');
    // Route::get('generalw',[WebinarController::class,'general'])->name('webinar.generalw');
    // Route::get('professionalw',[WebinarController::class,'professional'])->name('webinar.professionalw');
    
    Route::get('general_wE',[WebinarController::class,'general_wE'])->name('webinar.general_wE');
    Route::get('professional_wE',[WebinarController::class,'professional_wE'])->name('webinar.professional_wE');


    // Route::resource('text', TextTypeController::class);
    // Route::get('get/{id}', [TextTypeController::class, 'get']);

    Route::post('image/upload/store',[AttachmentController::class, 'fileStore']);
    Route::post('image/delete',[AttachmentController::class, 'fileDestroy']);

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    // Route::resource('categories', CategoriesController::class);
    // Route::post('uploadcate',[CategoriesController::class,'uploadcate'])->name('uploadcate');

    Route::resource('role', RoleController::class);

    Route::resource('user', UserController::class);
    Route::get('profile', [UserController::class, 'profile'])->name('user.profile');

    // Route::resource('supplier', SupplierController::class);
    // Route::post('uploadsupplair',[SupplierController::class,'uploadsupplair'])->name('uploadsupplair');

    Route::resource('appoinments',AppoinmentController::class);

    Route::resource('rolepermission', RolePermissionController::class);

    Route::post('services/therapy_form', [ServicesController::class, 'therapySubmit'])->name('services.therapySubmit');
    Route::get('services/therapy_form', [ServicesController::class, 'form_one'])->name('services.form_one');
    
    
    Route::post('services/service_payment', [ServicesController::class, 'servicePaymentPost'])->name('services.servicePayment');
    Route::get('services/select_service', [ServicesController::class, 'selectService'])->name('services.selectService');
    Route::get('services/service_payment_recevied', [ServicesController::class, 'servicePaymentRecevied'])->name('services.servicePaymentRecevied');
    Route::get('services/service_payment/{id}', [ServicesController::class, 'servicePayment'])->name('services.servicePaymentID');
    Route::post('services/getServiceDayTimings', [ServicesController::class, 'getServiceDayTimings'])->name('services.getServiceDayTimings');
    Route::post('services/getServiceDays', [ServicesController::class, 'getServiceDays'])->name('services.getServiceDays');
    Route::post('services/clinical_supervision', [ServicesController::class, 'clinicalSupervisionSubmit'])->name('services.clinicalSupervisionSubmit');
    Route::get('services/clinical_supervision', [ServicesController::class, 'form_two'])->name('services.form_two');
    Route::post('services/consultation', [ServicesController::class, 'consultationSubmit'])->name('services.consultationSubmit');
    Route::get('services/consultation', [ServicesController::class, 'form_three'])->name('services.form_three');
    Route::post('services/expert_testimony', [ServicesController::class, 'expertTestimonySubmit'])->name('services.expertTestimonySubmit');
    Route::get('services/expert_testimony', [ServicesController::class, 'form_four'])->name('services.form_four');
    Route::resource('services',ServicesController::class);
    Route::group(['prefix' => 'services/{id}'], function () {
        Route::resource('services_assessments', ServicesAssessmentsController::class);
        Route::resource('services_download_file', ServicesDownloadFileController::class);
    });
    
  
    Route::impersonate();

    // Route::get('role-permission', [RoleController::class,'role_permission']);

});


Route::get('clear-cache', function() {
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    \Request::session()->flash('alert-success', 'System Cache has been cleared!');
    return back();
})->name('clear-cache');
