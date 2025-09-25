<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::view('/myform', 'admin/payment/myform');
Route::view('/', 'admin/login/login');
Route::view('/login', 'admin/login/login')->name('login');
Route::get('/logout', [AdminController::class, 'logout']);
Route::post('/loginauth', [AdminController::class, 'loginAuthentication']);

Route::middleware(['loginAuth'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);

    Route::get('/create-teacher', [AdminController::class, 'create']);

    Route::view('/create-group', 'admin/group/create-group');
    Route::post('/save-group', [AdminController::class, 'createGroup']);
    Route::post('/update-group', [AdminController::class, 'updateGroup']);
    Route::get('/group-list', [AdminController::class, 'retriveGroup']);
    Route::get('/edit-group/{id}', [AdminController::class, 'editGroup']);
    Route::get('/deleteGroup/{id}', [AdminController::class, 'deleteGroup']);

    Route::get('/create-student', [AdminController::class, 'studentForm']);
    Route::post('/save-student', [AdminController::class, 'createStudent']);
    Route::get('/student-list', [AdminController::class, 'retriveStudent']);
    Route::get('/edit-student/{id}', [AdminController::class, 'editStudent']);
    Route::post('/update-student', [AdminController::class, 'updateStudent']);
    Route::get('/deleteStudent/{id}', [AdminController::class, 'deleteStudent']);

    Route::get('/create-exams', [AdminController::class, 'createExams']);
    Route::post('/save-exams', [AdminController::class, 'saveExams']);
    Route::get('/list-exams', [AdminController::class, 'listExams']);
    Route::get('/edit-exams/{id}', [AdminController::class, 'editExams']);
    Route::post('/update-exams/{id}', [AdminController::class, 'updateExams']);
    Route::get('/delete-exams/{id}', [AdminController::class, 'deleteExams']);

    // mark
    Route::get('/marktable', [AdminController::class, 'marktablepage']);
    Route::post('/create-mark-table', [AdminController::class, 'createMarkTable']);
    Route::get('/mark-entry', [AdminController::class,'markEntry']);
    //subject
    Route::get('/create-subject', [AdminController::class, 'subjectForm']);
    Route::post('/save-subject', [AdminController::class, 'createSubject']);
    Route::get('/subject-list', [AdminController::class, 'retriveSubject']);
    Route::get('/edit-subject/{id}', [AdminController::class, 'editSubject']);
    Route::post('/update-subject', [AdminController::class, 'updateSubject']);
    Route::get('/deleteSubject/{id}', [AdminController::class, 'deleteSubject']);

    Route::get('/create-teacher', [AdminController::class, 'createTeacher']);
    Route::post('/save-teacher', [AdminController::class, 'saveTeacher']);
    Route::post('/update-teacher', [AdminController::class, 'updateTeacher']);
    Route::get('/teacher-list', [AdminController::class, 'retriveTeacher']);
    Route::get('/edit-teacher/{id}', [AdminController::class, 'editTeacher']);
    Route::get('/deleteTeacher/{id}', [AdminController::class, 'deleteTeacher']);

    //teacher subject allotment
    Route::get('/create-subject-allotment', [AdminController::class, 'subjectAllotment']);
    Route::post('/save-subject-allotments', [AdminController::class, 'saveSubjectAllotments']);
    Route::get('/subject-allotment-list/{teacher_id}', [AdminController::class, 'subjectAllotmentList']);
    Route::get('/edit-subject-allotment/{teacherId}', [AdminController::class, 'subjectAllotmentEdit']);
    Route::post('/update-subject-allotment', [AdminController::class, 'subjectAllotmentUpdate']);
    Route::get('/subjectAllotmentDelete/{id}', [AdminController::class, 'subjectAllotmentDelete']);
    Route::get('/get-teacher-allotments/{teacherId}', [AdminController::class, 'getTeacherAllotments']);

    //designation
    Route::get('/create-designation', [AdminController::class, 'createDesignation']);
    Route::post('/save-designation', [AdminController::class, 'saveDesignation']);
    Route::get('designation-list', [AdminController::class, 'designationList']);
    Route::get('/delete-designation/{id}', [AdminController::class, 'deleteDesignation']);
    Route::get('/edit-designation/{id}', [AdminController::class, 'editDesignation']);
    Route::post('/update-designation/{id}', [AdminController::class, 'updateDesignation']);
});

//Route::get('/createStudentFees', [AdminController::class, 'studentfeesForm']);
//Route::post('/saveStudentFees', [AdminController::class, 'createStudentFees']);
//Route::get('/studentFees', [AdminController::class, 'retriveStudentFees']);
//Route::post('/assignStudentFees', [AdminController::class, 'assignStudentFees']);
//Route::get('/editStudentFees/{register_number}', [AdminController::class, 'editStudentFees']);
//Route::post('/updateStudentFees', [AdminController::class, 'updateStudentFees']);
//Route::get('/deleteStudentFees/{id}', [AdminController::class, 'deleteStudentFees']);
//Route::get('/getFeesType/{stypeid}/{student_fees_id}', [Admincontroller::class, 'getFeesType']);
//Route::get('/getStudentList/{stdbatch}/{stdyear}/{stypeid}/{departmentid}', [Admincontroller::class, 'getStudentList']);
//
//Route::get('/createPayment', [AdminController::class, 'createPaymentForm']);
//Route::post('/savePayment', [AdminController::class, 'savePayment']);
//Route::get('/getPaymentFeesType/{stypeid}/{register_number}', [Admincontroller::class, 'getPaymentFeesType']);
//Route::get('/getStudentDetails/{regno}',[AdminController::class,'getStudentDetails']);
//Route::get('/getFeesDetails/{register_number}/{department_id}/{student_type_id}/{fees_academic_year}/{study_year}',[AdminController::class,'getFeesDetails']);
//Route::view('/paymentSuccess','admin/payment/paymentSuccess');
//Route::view('/paymentHistory','admin/payment/paymentHistory');
//Route::get('/getStudentDetailsForPaymentHistory/{regno}', [AdminController::class, 'getStudentDetailsForPaymentHistory']);
//Route::get('/getPaymentHistory/{register_number}/{fees_academic_year}',[AdminController::class,'getPaymentHistory']);



