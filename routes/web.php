<?php

use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ClassRoomController;
use App\Http\Controllers\Admin\DashboardAdminControlller;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\Pengguna\ActivityController as PenggunaActivityController;
use App\Http\Controllers\Pengguna\CheckActivityController;
use App\Http\Controllers\Pengguna\PaymentController;
use App\Http\Controllers\Pengguna\PaymentHistoryController;
use App\Http\Controllers\Pengguna\ProfileController;
use App\Http\Controllers\Student\HomeStudentController;




use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\BlankPageController;
use App\Http\Controllers\Student\PaymentController as StudentPaymentController;
use App\Http\Controllers\Student\ProfileController as StudentProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Route::get('/', function () {
//     $data['user'] = Auth::user();
//     return view('index.user.payment_invoice', compact('data'));
// });
Route::get('/', [IndexController::class, 'index'])->name('home');
Route::get('/404', [BlankPageController::class, 'index'])->name('blank-page');
Route::get('/page-login', [AuthController::class, 'pageLogin'])->name('pageLogin');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/page-registrasi', [AuthController::class, 'pageRegistrasi']);
Route::post('/registrasi', [AuthController::class, 'registrasi']);

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('/about-us', [AboutUsController::class, 'index'])->name('pageAboutUs');
Route::get('/list-kegiatan', [PenggunaActivityController::class, 'listActivity'])->name('pageListKegiatan');


Route::prefix('pengguna')->middleware(['auth', 'checkRole:pengguna'])->group(function () {

    Route::get('/', [HomeStudentController::class, 'index'])->name('homePengguna');
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'pageProfile'])->name('pageProfile');
        Route::post('/updateProfile', [ProfileController::class, 'updateProfile'])->name('updateProfile');
    });

    Route::prefix('payment')->group(function () {
        Route::get('/list-payment', [PaymentController::class, 'pageListPayment']);
        Route::post('/cek-list-payment', [PaymentController::class, 'checkPaymentList']);

        Route::get('/payment-detail/{activity}/{student}', [PaymentController::class, 'detailPayment']);
        Route::post('/payment-checkout', [PaymentController::class, 'checkOut']);

        Route::get('/payment-success/{payment}', [PaymentController::class, 'successPayment'])->name('paymentSuccess');
        Route::get('/payment-batal/{payment}', [PaymentController::class, 'batalPayment'])->name('paymentBatal');

        Route::get('/payment-history', [PaymentHistoryController::class, 'pageHistory']);
    });
});

Route::prefix('admin')->middleware(['auth', 'checkRole:admin'])->group(function () {

    Route::get('/', [DashboardAdminControlller::class, 'index'])->name('homeAdmin');


    Route::prefix('profile')->group(function () {
        Route::get('/', [AdminProfileController::class, 'pageProfile']);
    });


    Route::prefix('pengguna')->group(function () {
        Route::get('/', [PenggunaController::class, 'index']);
        Route::get('/page-tambah-pengguna', [PenggunaController::class, 'pageFormStore']);
        Route::post('/tambah-pengguna', [PenggunaController::class, 'store']);
        Route::get('/{user}/detail-pengguna', [PenggunaController::class, 'show']);
        Route::get('/{user}/hapus-pengguna', [PenggunaController::class, 'delete']);
    });

    Route::prefix('admins')->group(function () {
        Route::get('/', [AdminController::class, 'index']);
        Route::get('/page-tambah-admin', [AdminController::class, 'pageFormStore']);
        Route::post('/tambah-admin', [AdminController::class, 'store']);
        Route::get('/{user}/detail-admin', [AdminController::class, 'show']);
        Route::get('/{user}/hapus-admin', [AdminController::class, 'delete']);
        Route::get('/{user}/update-admin', [AdminController::class, 'pageFormUpdate']);
        Route::put('/{user}/update-admin', [AdminController::class, 'update']);
    });

    Route::prefix('students')->group(function () {
        Route::get('/', [StudentController::class, 'index']);
        Route::get('/page-tambah-siswa', [StudentController::class, 'pageFormStore'])->name('pageFormAddStudent');
        Route::post('/tambah-siswa', [StudentController::class, 'store']);
        Route::get('/{student}/detail-siswa', [StudentController::class, 'show'])->name('admin.studentDetail');
        Route::get('/{student}/hapus-siswa', [StudentController::class, 'delete']);
        Route::get('/{student}/update-siswa', [StudentController::class, 'pageFormUpdate']);
        Route::put('/{student}/update-siswa', [StudentController::class, 'update']);
        Route::post('/{student}/tambah-kegiatan', [StudentController::class, 'addActivityToStudent'])->name('admin.addActivityToStudent');
        Route::get('/{activity}/{student}/hapus-kegiatan-siswa', [StudentController::class, 'deleteActivityFromStudent'])->name('admin.deleteActivityFromStudent');
    });
    Route::prefix('activities')->group(function () {
        Route::get('/', [ActivityController::class, 'index']);
        Route::get('/page-tambah-kegiatan', [ActivityController::class, 'pageFormStore'])->name('pageFormAddActivity');
        Route::post('/tambah-kegiatan', [ActivityController::class, 'store']);
        Route::get('/{activity}/detail-kegiatan', [ActivityController::class, 'show']);
        Route::get('/{activity}/hapus-kegiatan', [ActivityController::class, 'delete']);
        Route::get('/{activity}/update-kegiatan', [ActivityController::class, 'pageFormUpdate']);
        Route::put('/{activity}/update-kegiatan', [ActivityController::class, 'update']);

        Route::post('/{activity}/tambah-siswa', [ActivityController::class, 'addStudentToActivity']);
        Route::get('/{activity}/{student}/hapus-siswa', [ActivityController::class, 'deleteStudentFromActivity']);
    });
    Route::prefix('classRoom')->group(function () {
        Route::get('/', [ClassRoomController::class, 'index']);
        Route::post('/tambah-kelas', [ClassRoomController::class, 'store']);
        Route::get('/{classRoom}/show', [ClassRoomController::class, 'show']);
        Route::get('/{classRoom}/hapus-kelas', [ClassRoomController::class, 'delete']);
        Route::put('/{classRoom}/update-kelas', [ClassRoomController::class, 'update']);
    });

    Route::prefix('payment')->group(function () {
        Route::get('/', [AdminPaymentController::class, 'index']);
    });
});


Route::prefix('student')->middleware(['auth', 'checkRole:student'])->group(function () {

    Route::prefix('profile')->group(function () {
        Route::get('/', [StudentProfileController::class, 'pageProfile'])->name('pageProfile');
        Route::post('/updateProfile', [StudentProfileController::class, 'updateProfile'])->name('updateProfileStudent');
        Route::post('/generate-new-unique-code', [StudentProfileController::class, 'generateNewUniqueCode'])->name('generateNewUniqueCode');
    });

    Route::prefix('payment')->group(function () {
        Route::get('/list-payment', [StudentPaymentController::class, 'pageListPayment']);
        Route::get('/payment-detail/{activity}/{student}', [StudentPaymentController::class, 'detailPayment']);
        // Route::get('/payment-detail/{activity}/{student}', [StudentPaymentController::class, 'detailPayment']);
        Route::post('/payment-checkout', [StudentPaymentController::class, 'checkOut']);
        Route::get('/payment-success/{payment}', [StudentPaymentController::class, 'successPayment'])->name('paymentSuccessStudent');
        Route::get('/payment-batal/{payment}', [StudentPaymentController::class, 'batalPayment'])->name('paymentBatal');
        Route::get('/payment-history', [StudentPaymentController::class, 'pageHistory']);
    });
});
