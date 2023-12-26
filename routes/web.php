<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\API\IndiamartLeadController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home', [AdminController::class, 'index'])->name('home');
    Route::get('/user-management', [AdminController::class, 'userManagement'])->name('admin.user.management');
    Route::get('/add-leads', [AdminController::class, 'addLeads'])->name('admin.add.leads');
    Route::get('/all-leads', [AdminController::class, 'allLeads'])->name('admin.all.leads');
    Route::get('/all-api-leads', [AdminController::class, 'allApiLeads'])->name('admin.all.api.leads');
    Route::get('/lead-view/{id}', [AdminController::class, 'leadView'])->name('admin.lead.view');
    Route::get('/communication-view/{id}', [AdminController::class, 'communicationView'])->name('admin.communication.view');
    Route::get('/communication-logs/{id}', [AdminController::class, 'communicationLogs'])->name('admin.communication.logs');

    // role
    Route::post('/roles/store', [RoleController::class, 'store'])->name('roles.store');
    Route::post('/role/edit', [RoleController::class, 'roleEdit'])->name('role.edit');

    Route::post('/create/user', [UserController::class, 'createUser'])->name('create.user');
    Route::post('/assign-role', [UserController::class, 'assignRole'])->name('assign.role');
    Route::get('/users/{id}', [UserController::class, 'updateActive'])->name('users.updateActive');
    Route::get('/user-edit/{id}', [UserController::class, 'userEdit'])->name('user.edit');

    // leads
    Route::post('/lead/create', [LeadController::class, 'store'])->name('lead.store');
    Route::post('/lead/update', [LeadController::class, 'update'])->name('lead.update');
    //Type call
    Route::post('/communication/call', [LeadController::class, 'storeCommunicationCall'])->name('store.communication.call');
    Route::post('/communication/email', [LeadController::class, 'storeCommunicationEmail'])->name('store.communication.email');
    Route::post('/communication/whatsapp', [LeadController::class, 'storeCommunicationWhatsapp'])->name('store.communication.whatsapp');
    Route::post('/communication/meeting', [LeadController::class, 'storeCommunicationMeeting'])->name('store.communication.meeting');
    Route::post('/set-follow-up', [LeadController::class, 'storeFollowUp'])->name('store.follow.up');
    Route::get('/follow-up-changeStatus/{id}', [LeadController::class, 'changeStatusFollowUp'])->name('changeStatus.followup');
    Route::get('/delete-followup/{id}', [LeadController::class, 'deleteFollowUp'])->name('delete.followup');

    //Standard
    Route::get('/add-standard', [LeadController::class, 'add_standard'])->name('admin.add.standard');
    Route::post('/store-standard', [LeadController::class, 'store_standard'])->name('admin.store.standard');
    Route::get('/edit-standard/{id}', [LeadController::class, 'edit_standard'])->name('admin.edit.standard');
    Route::get('/delete-standard/{id}', [LeadController::class, 'delete_standard'])->name('admin.delete.standard');

    //Accreditation
    Route::get('/add-accreditation', [LeadController::class, 'add_accreditation'])->name('admin.add.accreditation');
    Route::post('/store-accreditation', [LeadController::class, 'store_accreditation'])->name('admin.store.accreditation');
    Route::get('/edit-accreditation/{id}', [LeadController::class, 'edit_accreditation'])->name('admin.edit.accreditation');
    Route::get('/delete-accreditation/{id}', [LeadController::class, 'delete_accreditation'])->name('admin.delete.accreditation');

    //status
    Route::get('/add-status', [LeadController::class, 'add_status'])->name('admin.add.status');
    Route::post('/store-status', [LeadController::class, 'store_status'])->name('admin.store.status');
    Route::get('/edit-status/{id}', [LeadController::class, 'edit_status'])->name('admin.edit.status');
    Route::get('/delete-status/{id}', [LeadController::class, 'delete_status'])->name('admin.delete.status');

    //leadSource
    Route::get('/add-leadSource', [LeadController::class, 'add_leadSource'])->name('admin.add.leadSource');
    Route::post('/store-leadSource', [LeadController::class, 'store_leadSource'])->name('admin.store.leadSource');
    Route::get('/edit-leadSource/{id}', [LeadController::class, 'edit_leadSource'])->name('admin.edit.leadSource');
    Route::get('/delete-leadSource/{id}', [LeadController::class, 'delete_leadSource'])->name('admin.delete.leadSource');

    Route::get('dashboard/previousmonth/{date}', [UserController::class, 'previousmonth_dashboard'])->name('previousmonth.dashboard');
    Route::get('dashboard/nextmonth/{date}', [UserController::class, 'nextmonth_dashboard'])->name('nextmonth.dashboard');

    //certificate
    Route::get('/add-certificate/{id}', [CertificateController::class, 'add_certificate'])->name('admin.add.certificate');
    Route::post('/store-certificate', [CertificateController::class, 'store_certificate'])->name('admin.store.certificate');
    Route::get('/all-certificate', [CertificateController::class, 'all_certificate'])->name('admin.all.certificate');

    Route::get('/view-certificate/{id}', [CertificateController::class, 'view_certificate'])->name('admin.view.certificate');
    Route::get('/certificate-edit/{id}', [CertificateController::class, 'certificateEdit'])->name('admin.certificate.edit');
    Route::get('/certificate-delete/{id}', [CertificateController::class, 'certificateDelete'])->name('admin.certificate.delete');

    // draft
    Route::get('/certificate-create-gdpr/{id}', [CertificateController::class, 'certificateCreateGdpr']);
    Route::get('/certificate-create-cor/{id}', [CertificateController::class, 'certificateCreateCor']);
    Route::get('/certificate-create-coc/{id}', [CertificateController::class, 'certificateCreateCoc']);
    Route::get('/certificate-create/{id}', [CertificateController::class, 'certificateCreate']);
    Route::get('/certificate-create-HEC/{id}', [CertificateController::class, 'certificateCreateHEC']);
    Route::get('/certificate-create-ENERGY/{id}', [CertificateController::class, 'certificateCreateENERGY']);
    Route::get('/certificate-create-Environment/{id}', [CertificateController::class, 'certificateCreateEnvironment']);
    Route::get('/certificate-create-FoodSafety/{id}', [CertificateController::class, 'certificateCreateFoodSafety']);
    Route::get('/certificate-create-ITS/{id}', [CertificateController::class, 'certificateCreateIts']);
    Route::get('/certificate-create-OHS/{id}', [CertificateController::class, 'certificateCreateOHS']);
    Route::get('/certificate-create-qfsENERGY/{id}', [CertificateController::class, 'certificateCreateqfsENERGY']);
    Route::get('/certificate-create-qfsEnvironmental/{id}', [CertificateController::class, 'certificateCreateqfsEnvironmental']);
    Route::get('/certificate-create-qfsFoodSafety/{id}', [CertificateController::class, 'certificateCreateqfsFoodSafety']);
    Route::get('/certificate-create-qfsITS/{id}', [CertificateController::class, 'certificateCreateqfsIts']);
    Route::get('/certificate-create-qfsOHS/{id}', [CertificateController::class, 'certificateCreateqfsOHS']);
    Route::get('/certificate-create-qfsAb/{id}', [CertificateController::class, 'certificateCreateqfsAb']);
    Route::get('/certificate-create-qfsBus/{id}', [CertificateController::class, 'certificateCreateqfsBus']);
    Route::get('/certificate-create-qfsQuality/{id}', [CertificateController::class, 'certificateCreateqfsQuality']);
    Route::get('/certificate-create-qfsInformationSecurity/{id}', [CertificateController::class, 'certificateCreateqfsInformationSecurity']);

    // final
    Route::get('/certificate-create-final-gdpr/{id}', [CertificateController::class, 'certificateCreateFinalGdpr'])->name('certificate.create.final.gdpr');
    Route::get('/certificate-create-final-cor/{id}', [CertificateController::class, 'certificateCreateFinalCor'])->name('certificate.create.final.cor');
    Route::get('/certificate-create-final-coc/{id}', [CertificateController::class, 'certificateCreateFinalCoc'])->name('certificate.create.final.coc');
    Route::get('/certificate-create-final/{id}', [CertificateController::class, 'certificateCreateFinal'])->name('certificate.create.final');
    Route::get('/certificate-create-final-HEC/{id}', [CertificateController::class, 'certificateCreateFinalHEC'])->name('certificate.create.final.HEC');
    Route::get('/certificate-create-final-ENERGY/{id}', [CertificateController::class, 'certificateCreateFinalENERGY'])->name('certificate.create.final.energy');
    Route::get('/certificate-create-final-Environment/{id}', [CertificateController::class, 'certificateCreateFinalEnvironment'])->name('certificate.create.final.environment');
    Route::get('/certificate-create-final-FoodSafety/{id}', [CertificateController::class, 'certificateCreateFinalFoodSafety'])->name('certificate.create.final.foodSafety');
    Route::get('/certificate-create-final-ITS/{id}', [CertificateController::class, 'certificateCreateFinalIts'])->name('certificate.create.final.its');
    Route::get('/certificate-create-final-OHS/{id}', [CertificateController::class, 'certificateCreateFinalOHS'])->name('certificate.create.final.ohs');
    Route::get('/certificate-create-final-qfsENERGY/{id}', [CertificateController::class, 'certificateCreateFinalqfsENERGY'])->name('certificate.create.final.qfsenergy');
    Route::get('/certificate-create-final-qfsEnvironmental/{id}', [CertificateController::class, 'certificateCreateFinalqfsEnvironmental'])->name('certificate.create.final.qfsEnvironmental');
    Route::get('/certificate-create-final-qfsFoodSafety/{id}', [CertificateController::class, 'certificateCreateFinalqfsFoodSafety'])->name('certificate.create.final.qfsfoodSafety');
    Route::get('/certificate-create-final-qfsITS/{id}', [CertificateController::class, 'certificateCreateFinalqfsIts'])->name('certificate.create.final.qfsits');
    Route::get('/certificate-create-final-qfsOHS/{id}', [CertificateController::class, 'certificateCreateFinalqfsOHS'])->name('certificate.create.final.qfsohs');
    Route::get('/certificate-create-final-qfsAb/{id}', [CertificateController::class, 'certificateCreateFinalqfsAb'])->name('certificate.create.final.qfsohs');
    Route::get('/certificate-create-final-qfsBus/{id}', [CertificateController::class, 'certificateCreateFinalqfsBus'])->name('certificate.create.final.qfsohs');
    Route::get('/certificate-create-final-qfsQuality/{id}', [CertificateController::class, 'certificateCreateFinalqfsQuality'])->name('certificate.create.final.qfsohs');
    Route::get('/certificate-create-final-qfsInformationSecurity/{id}', [CertificateController::class, 'certificateCreateFinalqfsInformationSecurity'])->name('certificate.create.final.qfsohs');

    Route::post('/certificate-final', [CertificateController::class, 'certificateFinal'])->name('certificate.final');

    Route::post('/certificate-document-store', [DocumentController::class, 'certificateDocumentStore'])->name('certificate.document.store');
    Route::get('/delete-document/{id}', [DocumentController::class, 'deleteDocument'])->name('delete.document');
    Route::get('/get-document', [DocumentController::class, 'getDocument'])->name('get.document');
    Route::get('/approve-document/{id}', [DocumentController::class, 'approveDocument'])->name('approve.document');
    Route::get('/reject-document/{id}', [DocumentController::class, 'rejectDocument'])->name('reject.document');

    Route::post('/certificate-payment-store', [DocumentController::class, 'certificatePaymentStore'])->name('certificate.payment.store');
    Route::get('/get-payment', [DocumentController::class, 'getPayment'])->name('get.payment');
    Route::get('/approve-payment/{id}', [DocumentController::class, 'approvePayment'])->name('approve.payment');
    Route::get('/reject-payment/{id}', [DocumentController::class, 'rejectPayment'])->name('reject.payment');


    // IndiaMart
    Route::get('/get-lead-data', [IndiamartLeadController::class, 'getLeadData']);
});