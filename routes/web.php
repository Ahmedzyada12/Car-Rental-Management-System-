<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\CustodyController;
use App\Http\Controllers\Admin\CustomerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Admin\OrderController;


use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Vendor\Vendor_CategoryController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


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



require __DIR__ . '/auth.php';

//mcamara translate package

Route::get('get_states/{country}', [CustomerController::class, 'get_states'])->name('admin.get_states');

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {


        Route::get('/', function () {
            return redirect(route('login'));
        });


        Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
        Route::get('/charts', [DashboardController::class, 'charts'])->middleware(['auth'])->name('charts');
        Route::get('/calender', [DashboardController::class, 'calender'])->middleware(['auth'])->name('calender');
        Route::get('/calender_driver', [DashboardController::class, 'calender_driver'])->middleware(['auth'])->name('calender_driver');
        Route::get('/calender_company', [DashboardController::class, 'calender_company'])->middleware(['auth'])->name('calender_company');
        Route::get('/calender_vendor', [DashboardController::class, 'calender_vendor'])->middleware(['auth'])->name('calender_vendor');
        Route::get('/year/{id}', [DashboardController::class, 'year'])->middleware(['auth'])->name('year');

        // super admin permetions
        Route::middleware('maneger')->group(function () {

            Route::get('about-us', [AboutController::class, 'index'])->name('about');
            Route::post('about-us', [AboutController::class, 'update'])->name('about.update');

            Route::group(['namespace' => 'App\Http\Controllers\Admin', 'prefix' => 'admin/mang'], function () {
                Route::get('/', 'MangerController@index')->name('admin.mang.index');
                Route::get('/index', 'MangerController@index')->name('admin.mang.index');
                Route::get('/api-dataManage', 'MangerController@api_data')->name('admin.mang.api_data');
                Route::get('create', 'MangerController@create')->name('admin.mang.create');
                Route::post('store', 'MangerController@store')->name('admin.mang.store');
                Route::get('delete/{id}', 'MangerController@delete')->name('admin.mang.delete');
                Route::get('show/{id}', 'MangerController@show')->name('admin.mang.show');
                Route::post('edit/{id}', 'MangerController@edit')->name('admin.mang.edit');
                Route::get('export', 'MangerController@export')->name('admin.mang.export');
            });

            Route::group(['namespace' => 'App\Http\Controllers\Admin', 'prefix' => 'admin/mangers'], function () {
                Route::get('/', 'MangerController copy@index')->name('admin.mangers.index');
                Route::get('create', 'MangerController copy@create')->name('admin.mangers.create');
                Route::post('store', 'MangerController copy@store')->name('admin.mangers.store');
                Route::delete('delete/{id}', 'MangerController copy@delete')->name('admin.mangers.delete');
                Route::get('show/{id}', 'MangerController copy@show')->name('admin.mangers.show');
                Route::get('edit/{id}', 'MangerController copy@edit')->name('admin.mangers.edit');
            });

            // adminRole6
            Route::group(['namespace' => 'App\Http\Controllers\Admin', 'prefix' => 'admin/adminRole'], function () {
                Route::get('/', 'AdminsRole6Controller@index')->name('admin.adminRole.index');
                Route::get('/api-dataadminRole6', 'AdminsRole6Controller@api_data')->name('admin.adminRole.api_data');
                Route::get('/index', 'AdminsRole6Controller@index')->name('admin.adminRole.index');
                Route::get('create', 'AdminsRole6Controller@create')->name('admin.adminRole.create');
                Route::post('store', 'AdminsRole6Controller@store')->name('admin.adminRole.store');
                Route::get('delete/{id}', 'AdminsRole6Controller@delete')->name('admin.adminRole.delete');
                Route::get('show/{id}', 'AdminsRole6Controller@show')->name('admin.adminRole.show');
                Route::post('edit/{id}', 'AdminsRole6Controller@edit')->name('admin.adminRole.edit');
            });

            // destinations for super admin
            Route::group(['namespace' => 'App\Http\Controllers\Admin', 'prefix' => 'admin/destination'], function () {
                // Route::get('/api-dataadminRole6', 'AdminsRole6Controller@api_data')->name('admin.adminRole.api_data');
                Route::get('/', 'DestinationController@index')->name('admin.destination.index');
                Route::get('/index', 'DestinationController@index')->name('admin.destination.index');
                Route::get('create', 'DestinationController@create')->name('admin.destination.create');
                Route::post('store', 'DestinationController@store')->name('admin.destination.store');
                Route::get('delete/{id}', 'DestinationController@delete')->name('admin.destination.delete');
                Route::get('show/{id}', 'DestinationController@show')->name('admin.destination.show');
                Route::post('update', 'DestinationController@update')->name('admin.destination.update');
                // dests price
                Route::get('prices', 'DestinationController@prices')->name('admin.destination.prices');
                Route::get('price/create', 'DestinationController@create_price')->name('admin.destination.price.create');
                Route::post('price/store', 'DestinationController@store_price')->name('admin.destination.price.store');
                Route::post('price/update', 'DestinationController@update_price')->name('admin.destination.price.update');
                Route::get('price/delete/{id}', 'DestinationController@delete_price')->name('admin.destination.price.delete');
            });
        });

        // driver permetions
        Route::middleware('driver')->group(function () {
            Route::group(['namespace' => 'App\Http\Controllers\Driver', 'prefix' => 'driver'], function () {
                Route::get('/', 'DriverController@index')->name('driver.index');
                Route::get('/orders', 'DriverController@index')->name('driver.index');
                Route::get('/order/api-dataOrder', 'DriverController@api_data_order')->name('driver.api');
                Route::get('repair', 'DriverController@show_repair')->name('driver.show.repair');
                Route::post('repair', 'DriverController@store_repair')->name('driver.store.repair');
            });
        });

        // company permitions
        Route::middleware('company')->group(function () {
            Route::group(['namespace' => 'App\Http\Controllers\Company', 'prefix' => 'company'], function () {
                // Route::get('/', 'DriverController@index')->name('company.index');

                Route::get('/customer/add', 'CompanyController@customer')->name('company.customer.add');
                Route::get('/customer/show/{id}', 'CompanyController@show')->name('company.customer.show');
                Route::post('/customer/edit', 'CompanyController@edit')->name('company.customer.edit');
                Route::get('/customer/api-dataCustomer', 'CompanyController@api_data_customer')->name('company.customer.api-data.add');
                Route::post('/customer/store', 'CompanyController@storeCustomer')->name('company.customer.store');

                Route::get('/order/add', 'CompanyController@order')->name('company.order.add');
                Route::get('/order/show/{id}', 'CompanyController@order_show')->name('company.order.show');
                Route::post('/order/edit', 'CompanyController@order_edit')->name('company.order.edit');
                Route::get('/order/api-dataOrder', 'CompanyController@api_data_order')->name('company.order.api-data.add');
                Route::post('/order/store', 'CompanyController@storeOrder')->name('company.order.store');

                Route::get('/customers', 'CompanyController@customers')->name('company.customers');
                Route::get('/delete/customer/{id}', 'CompanyController@delete')->name('company.delete.customer');
                Route::get('/orders', 'CompanyController@orders')->name('company.orders');

                Route::get('/getcars/{id}', 'CompanyController@getCarsByCategory')->name('company.getCarsByCategory');
                Route::get('getprice/{id}/{driver_id}/{hours}/{days}/{dist_id}', 'CompanyController@getPrice')->name('company.orders.getPrice');
                Route::post('check-dates-ajax', 'CompanyController@checkDateRange')->name('company.orders.check-dates-ajax');

                // this routed are deleted
                // Route::get('destinations', 'CompanyController@destinations')->name('company.destinations');
                // Route::get('api-dists', 'CompanyController@api_dists')->name('company.dists');
                // Route::post('destination', 'CompanyController@store_dists')->name('company.dists.store');
                // Route::get('destination/delete/{id}', 'CompanyController@delete_dists')->name('company.dists.delete');
            });
        });


        //vendors with drivers
        Route::group(['prefix' => 'vendor', 'middleware' => 'vendor'], function () {
            Route::get('/index', [VendorController::class, 'showDrivers'])->name('vendor.drivers.index');
            Route::get('api-dataDriver', [VendorController::class, 'driver_api_data'])->name('vendors.driver.api_data');
            Route::get('create', [DriverController::class, 'create'])->name('vendor.drivers.create');
            Route::post('store', [DriverController::class, 'store'])->name('admin.drivers.store');
            Route::get('delete/{id}', [DriverController::class, 'delete'])->name('admin.drivers.delete');
            Route::get('show/{id}', [VendorController::class, 'showDriver'])->name('vendor.driver.show');
            Route::post('edit/{id}', [DriverController::class, 'edit'])->name('admin.drivers.edit');
        });
        //vendors with orders
        Route::group(['prefix' => 'vendors', 'middleware' => 'vendor'], function () {
            Route::get('orders/api_dataOrder', [VendorController::class, 'api_dataOrder']);
            Route::get('index', [VendorController::class, 'orders'])->name('vendor.showOrders');
        });

        //vendors with categories and cars
        Route::group(['prefix' => 'vendor/category', 'middleware' => 'vendor'], function () {
            Route::get('create', [Vendor_CategoryController::class, 'create'])->name('vendor.category.create');  //show category page
            Route::post('store', [Vendor_CategoryController::class, 'store'])->name('vendor.category.store');  //store category
            Route::get('create_car', [Vendor_CategoryController::class, 'createCar'])->name('vendor.category.create_car');  //show car page for store
            Route::post('store_car', [Vendor_CategoryController::class, 'storeCar'])->name('vendor.category.store_car'); //store data for car in database
            Route::get('/', [Vendor_CategoryController::class, 'index'])->name('vendor.category.index');
            Route::get('/api-dataCategory', [Vendor_CategoryController::class, 'api_data'])->name('vendor.category.api_data');
            Route::get('show/{id}', [Vendor_CategoryController::class, 'showCategory'])->name('vendor.category.show');  //show category page for edit
            Route::post('update/vendor/category/{id}', [Vendor_CategoryController::class, 'updateCategory'])->name('vendor.category.update');  //store category
            Route::get('delete/{id}', [Vendor_CategoryController::class, 'delete'])->name('vendor.category.delete');  //show category page for edit
            Route::get('/api-dataCar/{id}', [Vendor_CategoryController::class, 'api_data_cars'])->name('category.car.api_data_cars'); //get cars data by category
            Route::get('/index/{id}', [Vendor_CategoryController::class, 'showCars'])->name('vendor.cars.index');   //show cars
            Route::get('cars/show/{id}', [Vendor_CategoryController::class, 'showCar'])->name('vendor.category.cars.show');  //show cars by
            Route::get('cars/delete/{id}', [Vendor_CategoryController::class, 'deleteCar'])->name('vendor.category.cars.delete');  //show category page for edit
            Route::post('update/car/{id}', [Vendor_CategoryController::class, 'updateCar'])->name('vendor.cars.update');
        });


        // accountant permitions
        Route::middleware('accountantOrManager')->group(function () {
            //custodies
            Route::group(['prefix' => 'admin'], function () {
                Route::get('/custodies', [CustodyController::class, 'index'])->name('custodies');
                Route::get('/custody/create', [CustodyController::class, 'create'])->name('add.custody');
                Route::post('/custody/store', [CustodyController::class, 'store'])->name('store.custody');
                Route::get('/custody/api-dataCustody', [CustodyController::class, 'api_data'])->name('custody.api_data');
                Route::get('delete/{id}', [CustodyController::class, 'delete'])->name('delete');
                Route::get('residual_custody/{id}', [CustodyController::class, 'residualCustody'])->name('residual_custody');
                Route::post('store_residual', [CustodyController::class, 'storeResidual'])->name('store.residual');
            });


            //discounts
            Route::group(['prefix' => 'admin'], function () {

                Route::get('/discounts', [DiscountController::class, 'index'])->name('discounts');
                Route::get('/discount/create', [DiscountController::class, 'create'])->name('add.discount');
                Route::post('/discount/store', [DiscountController::class, 'store'])->name('store.discount');
                Route::post('/discount/store-driver', [DiscountController::class, 'store_for_driver'])->name('store.discount_for_driver');
                Route::get('/discount/api-dataDiscount', [DiscountController::class, 'api_data'])->name('discount.api_data');
                Route::get('show/discount/{id}', [DiscountController::class, 'show'])->name('show.discounts');
                Route::post('/update/{id}', [DiscountController::class, 'update'])->name('update.discounts');
                Route::get('/discount/delete/{id}', [DiscountController::class, 'delete'])->name('delete.discount');

                Route::get('/driver_discount', [DiscountController::class, 'api_data_driver_discount']);
            });

            Route::group(['prefix' => 'admin/invoice'], function () {

                Route::get('/', [InvoiceController::class, 'index'])->name('admin.invoice.index');
                Route::get('/index', [InvoiceController::class, 'index'])->name('admin.invoice.index');
                Route::get('/api-dataInvoices', [InvoiceController::class, 'apidataInvoices'])->name('admin.invoice.api');
                Route::get('/api-dataInvoices-for-dashboard', [InvoiceController::class, 'apidataInvoicesDashboard'])->name('admin.invoice.api');
                Route::get('/create', [InvoiceController::class, 'create'])->name('admin.invoice.create');
                Route::post('/store', [InvoiceController::class, 'store'])->name('admin.invoice.store');
                Route::get('/show/{id}', [InvoiceController::class, 'show'])->name('admin.invoice.show');
                Route::post('/edit/{id}', [InvoiceController::class, 'edit'])->name('admin.invoice.edit');
                Route::get('/delete/{id}', [InvoiceController::class, 'delete'])->name('admin.invoice.delete');
                Route::post('/change-status', [InvoiceController::class, 'changeStatus'])->name('admin.invoice.changeStatus');
                Route::get('/details/{id}', [InvoiceController::class, 'details'])->name('admin.invoice.details');
                Route::get('/invoice-details/{id}', [InvoiceController::class, 'api_invoice_details'])->name('admin.invoice.api_invoice_details');
                Route::get('/mail/{id}', [InvoiceController::class, 'invoiceMail'])->name('admin.invoice.mail');
            });
        });


        // admin or super admin
        Route::middleware('adminOrManager')->group(function () {
            Route::group(['namespace' => 'App\Http\Controllers\Admin', 'prefix' => 'admin/customer'], function () {
                Route::get('/', 'CustomerController@index')->name('admin.customer.index');
                Route::get('/api-dataCustomers', 'CustomerController@api_data')->name('admin.customer.api_data');
                Route::get('/filter-customer/{id}', 'CustomerController@filterCustomer')->name('admin.customers.filter.index');
                Route::get('/filter-customer-order-data/{id}', 'CustomerController@filterOrderData')->name('admin.companys.filter.order.index');
                Route::get('/index', 'CustomerController@index')->name('admin.customer.index');
                Route::get('create', 'CustomerController@create')->name('admin.customer.create');
                Route::post('store', 'CustomerController@store')->name('admin.customer.store');
                Route::get('delete/{id}', 'CustomerController@delete')->name('admin.customer.delete');
                Route::get('show/{id}', 'CustomerController@show')->name('admin.customer.show');
                Route::post('edit/{id}', 'CustomerController@edit')->name('admin.customer.edit');
                Route::get('export', 'CustomerController@export')->name('admin.customer.export');
            });

            Route::group(['namespace' => 'App\Http\Controllers\Admin', 'prefix' => 'admin/company'], function () {
                Route::get('/', 'CompanyController@index')->name('admin.companys.index');
                Route::get('/filter-customer-data/{id}', 'CompanyController@filterCustomerData')->name('admin.companys.filter.customer.index');
                Route::get('/filter-order-data/{id}', 'CompanyController@filterOrderData')->name('admin.companys.filter.order.index');
                Route::get('/filter-customer/{id}', 'CompanyController@filterCustomer')->name('admin.companys.filter.index');
                Route::get('/api-dataCompany', 'CompanyController@api_data')->name('admin.company.api_data');
                Route::get('/index', 'CompanyController@index')->name('admin.companys.index');
                Route::get('create', 'CompanyController@create')->name('admin.companys.create');
                Route::post('store', 'CompanyController@store')->name('admin.companys.store');
                Route::get('delete/{id}', 'CompanyController@delete')->name('admin.companys.delete');
                Route::get('show/{id}', 'CompanyController@show')->name('admin.companys.show');
                Route::post('edit/{id}', 'CompanyController@edit')->name('admin.companys.edit');
                Route::get('export', 'CompanyController@export')->name('admin.companys.export');
            });


            Route::group(['namespace' => 'App\Http\Controllers\Admin', 'prefix' => 'admin/driver'], function () {
                Route::get('/', 'DriverController@index')->name('admin.drivers.index');
                Route::get('/index', 'DriverController@index')->name('admin.drivers.index');
                Route::get('create', 'DriverController@create')->name('admin.drivers.create');
                Route::post('store', 'DriverController@store')->name('admin.drivers.store');
                Route::get('delete/{id}', 'DriverController@delete')->name('admin.drivers.delete');
                Route::get('show/{id}', 'DriverController@show')->name('admin.drivers.show');
                Route::post('edit/{id}', [DriverController::class, 'edit'])->name('admin.drivers.edit');
                Route::get('export', 'DriverController@export')->name('admin.drivers.export');

                Route::get('repairs', 'DriverController@repairs')->name('admin.drivers.repairs');
                Route::get('api-dataRepire', 'DriverController@api_dataRepire')->name('admin.drivers.repire.repairs');

                Route::get('check-email/{email}', 'DriverController@check_email')->name('admin.drivers.email');
            });

            Route::group(['namespace' => 'App\Http\Controllers\Admin', 'prefix' => 'admin/category'], function () {
                Route::get('/', 'CategoryController@index')->name('admin.category.index');
                Route::get('/api-dataCategory', 'CategoryController@api_data')->name('admin.category.api_data');
                Route::get('/index', 'CategoryController@index')->name('admin.category.index');
                Route::get('create', 'CategoryController@create')->name('admin.category.create');
                Route::post('store', 'CategoryController@store')->name('admin.category.store');
                Route::get('delete/{id}', 'CategoryController@delete')->name('admin.category.delete');
                Route::get('show/{id}', 'CategoryController@show')->name('admin.category.show');
                Route::post('edit/{id}', 'CategoryController@edit')->name('admin.category.edit');
            });


            Route::group(['namespace' => 'App\Http\Controllers\Admin', 'prefix' => 'admin/orders'], function () {
                Route::get('/', 'OrderController@index')->name('admin.orders.index');
                Route::get('/api-dataOrder', 'OrderController@api_data')->name('admin.orders.api.index');
                Route::get('/index', 'OrderController@index')->name('admin.orders.index');
                Route::get('create', 'OrderController@create')->name('admin.orders.create');
                Route::post('store', 'OrderController@store')->name('admin.orders.store');
                Route::get('delete/{id}', 'OrderController@destroy')->name('admin.orders.delete');
                Route::get('show/{id}', 'OrderController@show')->name('admin.orders.show');
                Route::post('edit/{id}', 'OrderController@edit')->name('admin.orders.edit');
                Route::get('getcars/{id}', 'OrderController@getCarsByCategory')->name('admin.orders.getcars');
                Route::get('getcustomer/{id}', 'OrderController@getCustomersByCompany')->name('admin.orders.getcustomers');
                Route::get('getprice/{id}/{driver_id}/{hours}/{days}/{dist_id}', 'OrderController@getPrice')->name('admin.orders.getPrice');
                Route::post('check-dates-ajax', 'OrderController@checkDateRange')->name('admin.orders.check-dates-ajax');
                Route::get('export', 'OrderController@export')->name('admin.orders.export');
                Route::get('invoice/{id}', 'OrderController@invoice')->name('admin.orders.invoice');
                Route::get('status/{id}', 'OrderController@status')->name('admin.orders.status');
                Route::get('new_status/{id}/{selectedValue}', 'OrderController@new_status')->name('admin.orders.new_status');

                Route::get('read_all', 'OrderController@read_all')->name('admin.orders.read_all');

                Route::get('getdists/{id}', 'OrderController@getdists')->name('admin.orders.getdists');
            });


            Route::group(['namespace' => 'App\Http\Controllers\Admin', 'prefix' => 'admin/cars'], function () {
                Route::get('/', 'CarController@index')->name('admin.cars.index');
                Route::get('/index/{id}', 'CarController@index')->name('admin.cars.index');
                Route::get('create', 'CarController@create')->name('admin.cars.create');
                Route::post('store', 'CarController@store')->name('admin.cars.store');
                Route::get('delete/{id}', 'CarController@delete')->name('admin.cars.delete');
                Route::get('show/{id}', 'CarController@show')->name('admin.cars.show');
                Route::post('edit/{id}', 'CarController@edit')->name('admin.cars.edit');

                Route::get('/api-dataCar/{id}', 'CarController@api_data')->name('admin.car.api_data');
            });

            Route::group(['namespace' => 'App\Http\Controllers\Admin', 'prefix' => 'admin/accountant'], function () {
                Route::get('/', 'AccountantController@index')->name('admin.Accountant.index');
                Route::get('/api-dataAccountants', 'AccountantController@api_data')->name('admin.Accountant.api_data');
                Route::get('/index', 'AccountantController@index')->name('admin.Accountant.index');
                Route::get('create', 'AccountantController@create')->name('admin.Accountant.create');
                Route::post('store', 'AccountantController@store')->name('admin.Accountant.store');
                Route::get('delete/{id}', 'AccountantController@delete')->name('admin.Accountant.delete');
                Route::get('show/{id}', 'AccountantController@show')->name('admin.Accountant.show');
                Route::post('edit/{id}', 'AccountantController@edit')->name('admin.Accountant.edit');
            });

            //vendors
            Route::group(['prefix' => 'admin'], function () {
                Route::get('/vendors', [VendorController::class, 'index'])->name('admin.vendors.index');
                Route::get('create', [VendorController::class, 'create'])->name('admin.vendors.create');
                Route::post('store', [VendorController::class, 'store'])->name('admin.vendors.store');
                Route::get('delete/vendor/{id}', [VendorController::class, 'delete'])->name('admin.vendors.delete');
                Route::get('show/vendor/{id}', [VendorController::class, 'show'])->name('admin.vendors.show');
                Route::post('update/vendor/{id}', [VendorController::class, 'update'])->name('admin.vendor.update');
                Route::get('/vendors/api-dataVendors', [VendorController::class, 'api_data'])->name('vendor.apiDataProfile');
            });
            Route::group(['namespace' => 'App\Http\Controllers\Admin', 'prefix' => 'admin/driver'], function () {

                //set of route DriverController
                Route::get('/', 'DriverController@index')->name('index');
                Route::get('/api-dataDriver', 'DriverController@api_data')->name('admin.driver.api_data');
                Route::get('show', 'DriverController@show');
                Route::delete('show', 'DriverController@delte');
                Route::get('show', 'DriverController@show');
                Route::put('show', 'DriverController@update');
            });

            //employees
            Route::group(['prefix' => 'admin'], function () {

                Route::get('/employees', [EmployeeController::class, 'index'])->name('employees');
                Route::get('/employee/create', [EmployeeController::class, 'create'])->name('add.employee');
                Route::post('/employee/store', [EmployeeController::class, 'store'])->name('store.employee');
                Route::post('update/employee/{id}', [EmployeeController::class, 'update'])->name('update.employee');
                Route::get('/api-dataEmployee', [EmployeeController::class, 'api_data'])->name('employee.api_data');
                Route::get('delete/employee/{id}', [EmployeeController::class, 'delete'])->name('delete');
                Route::get('show/employee/{id}', [EmployeeController::class, 'show']);
                Route::get('employee/profile/{id}', [EmployeeController::class, 'profile']);
                Route::get('/apiDataProfile/{id}', [EmployeeController::class, 'apiDataProfile'])->name('apiDataProfile');
                Route::get('/apiDataProfile_driver/{id}', [EmployeeController::class, 'apiDataProfile_driver'])->name('apiDataProfile_driver');
                Route::get('driver/profile/{id}', [EmployeeController::class, 'profile_driver']);
            });
        });
    }
);
