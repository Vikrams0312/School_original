<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Session;

Route::get('/createPayment', [AdminController::class, 'createPaymentForm']);
Route::post('/paymentCheckout', [AdminController::class, 'paymentCheckout']);
Route::get('/getPaymentFeesType/{stypeid}/{register_number}', [Admincontroller::class, 'getPaymentFeesType']);
Route::get('/getStudentDetails/{regno}', [AdminController::class, 'getStudentDetails']);
Route::get('/getFeesDetails/{register_number}/{department_id}/{student_type_id}/{fees_academic_year}/{study_year}', [AdminController::class, 'getFeesDetails']);
Route::get('/paymentComplete/{pid}', [AdminController::class, 'paymentComplete']);
Route::view('/paymentStatus', 'admin/payment/paymentStatus');
Route::view('/paymentHistory', 'admin/payment/paymentHistory')->name('Payment Recipt');
Route::get('/getStudentDetailsForPaymentHistory/{regno}', [AdminController::class, 'getStudentDetailsForPaymentHistory']);
Route::get('/getPaymentHistory/{register_number}/{fees_academic_year}', [AdminController::class, 'getPaymentHistory']);
Route::get('/generatePDF', [AdminController::class, 'generatePDF']);
Route::get('/paymentReceipt/{register_number}/{payment_id}/{term}', [AdminController::class, 'paymentReceipt']);

Route::view('/', 'admin/home/index');
Route::view('/login', 'admin/login/login')->name('login');
Route::post('/loginauth', [AdminController::class, 'loginAuthentication']);

Route::middleware(['loginAuth'])->group(function () {
    // This name "loginAuth" given from Kernal

    Route::get('/sendEmail', [AdminController::class, 'sendEmail']);
    Route::view('/npay', 'admin/razorpay/npay');
    Route::view('/myform', 'admin/payment/myform');
    Route::post('/checkout', [AdminController::class, 'checkout']);

    Route::get('/balanceFeesList', [AdminController::class, 'balanceFeesList']);
    Route::get('/getBalanceFeesList/{department_id}/{fees_academic_year}', [AdminController::class, 'getBalanceFeesList']);
//Route::get('/balanceFeesReport', [AdminController::class, 'balanceFeesReport']);
    Route::get('/printBalanceFeesReport/{department_id}/{fees_academic_year}', [AdminController::class, 'printBalanceFeesReport']);

    Route::get('/logout', [AdminController::class, 'logout']);
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::view('/createDepartment', 'admin/department/createdpt');
    Route::post('/saveDepartmentData', [AdminController::class, 'createDepartment']);
    Route::post('/updateDepartmentData', [AdminController::class, 'updateDepartment']);
    Route::get('/departmentList', [AdminController::class, 'retriveDepartment'])->name('Department List');
    Route::get('/editDepartment/{id}', [AdminController::class, 'editDepartment']);
    Route::get('/deleteDepartment/{id}', [AdminController::class, 'deleteDepartment']);

    Route::get('/createFeesCategory', [AdminController::class, 'createFeesCategory']);
    Route::post('/saveFeesCategory', [AdminController::class, 'saveFeesCategory']);
    Route::post('/updateFeesCategory', [AdminController::class, 'updateFeesCategory']);
    Route::get('/feesCategory', [AdminController::class, 'retriveFeesCategory'])->name('Fees Category List');
    Route::get('/editFeesCategory/{id}', [AdminController::class, 'editFeesCategory']);
    Route::get('/deleteFeesCategory/{id}', [AdminController::class, 'deleteFeesCategory']);

    Route::view('/createStudentType', 'admin/studentType/createStudentType');
    Route::post('/saveStudentType', [AdminController::class, 'createStudentType']);
    Route::get('/studentType', [AdminController::class, 'retriveStudentType'])->name('Student Type');
    Route::get('/editStudentType/{id}', [AdminController::class, 'editStudentType']);
    Route::post('/updateStudentType', [AdminController::class, 'updateStudentType']);
    Route::get('/deleteStudentType/{id}', [AdminController::class, 'deleteStudentType']);

    Route::get('/createStudent', [AdminController::class, 'studentForm']);
    Route::post('/saveStudent', [AdminController::class, 'createStudent']);
    Route::get('/studentList', [AdminController::class, 'retriveStudent'])->name('Student List');
    Route::get('/editStudent/{id}', [AdminController::class, 'editStudent']);
    Route::post('/updateStudent', [AdminController::class, 'updateStudent']);
    Route::get('/deleteStudent/{id}', [AdminController::class, 'deleteStudent']);

    Route::get('/createStudentFees', [AdminController::class, 'studentfeesForm']);
    Route::post('/saveStudentFees', [AdminController::class, 'createStudentFees']);
    Route::get('/studentFees', [AdminController::class, 'retriveStudentFees'])->name('Fees List');
    Route::post('/assignStudentFees', [AdminController::class, 'assignStudentFees']);
    Route::get('/editStudentFees/{register_number}', [AdminController::class, 'editStudentFees']);
    Route::post('/updateStudentFees', [AdminController::class, 'updateStudentFees']);
    Route::get('/deleteStudentFees/{id}', [AdminController::class, 'deleteStudentFees']);
    Route::get('/getFeesType/{stypeid}/{student_fees_id}', [Admincontroller::class, 'getFeesType']);
    Route::get('/getStudentList/{stdbatch}/{stdyear}/{stypeid}/{departmentid}', [Admincontroller::class, 'getStudentList']);
});

