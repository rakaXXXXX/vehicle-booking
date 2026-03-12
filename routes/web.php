<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;

// Halaman Utama - Arahkan ke login jika belum login, atau ke dashboard jika sudah login
Route::middleware('web')->get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.login');
})->name('home');

Route::middleware(['guest'])->group(function () {
    Route::get('/', function () {
        return view('auth.login');
    })->name('home');
    
    Route::post('/login', [LoginController::class, 'login'])->name('login');
});

// Route untuk logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/vehicles', [App\Http\Controllers\VehicleController::class, 'index'])->name('vehicles.index');
    Route::resource('vehicles', App\Http\Controllers\VehicleController::class);
    
    Route::get('/bookings', [App\Http\Controllers\BookingController::class, 'index'])->name('bookings.index');
    Route::resource('bookings', App\Http\Controllers\BookingController::class);
    
    Route::get('/approvals', [App\Http\Controllers\ApprovalController::class, 'index'])->name('approvals.index');
    Route::post('/approvals/{booking}/approve', [App\Http\Controllers\ApprovalController::class, 'approve'])->name('approvals.approve');
    Route::post('/approvals/{booking}/reject', [App\Http\Controllers\ApprovalController::class, 'reject'])->name('approvals.reject');
    
    Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [App\Http\Controllers\ReportController::class, 'export'])->name('reports.export');
});

// Test route sederhana tanpa middleware
Route::get('/test', function() {
    return 'Test page - no redirects';
});

// Debug route - untuk testing
// TEMPORARY DEBUG ROUTE - HAPUS SETELAH SELESAI
Route::get('/debug-users', function() {
    $users = App\Models\User::all();
    
    $html = '<h1>Debug Users</h1>';
    $html .= '<table border="1" cellpadding="5">';
    $html .= '<tr><th>ID</th><th>Email</th><th>Role</th><th>Active</th><th>Test Password</th></tr>';
    
    foreach($users as $user) {
        $html .= '<tr>';
        $html .= '<td>' . $user->id . '</td>';
        $html .= '<td>' . $user->email . '</td>';
        $html .= '<td>' . $user->role . '</td>';
        $html .= '<td>' . ($user->is_active ? '✅' : '❌') . '</td>';
        $html .= '<td>';
        $html .= '<form method="POST" style="display:inline;">';
        $html .= '<input type="hidden" name="_token" value="' . csrf_token() . '">';
        $html .= '<input type="hidden" name="email" value="' . $user->email . '">';
        $html .= '<input type="password" name="password" placeholder="test password">';
        $html .= '<button type="submit">Test</button>';
        $html .= '</form>';
        $html .= '</td>';
        $html .= '</tr>';
    }
    
    $html .= '</table>';
    
    // Handle password test
    if (request()->isMethod('POST')) {
        $email = request('email');
        $password = request('password');
        $user = App\Models\User::where('email', $email)->first();
        
        if ($user && \Illuminate\Support\Facades\Hash::check($password, $user->password)) {
            $html .= '<div style="color:green; margin-top:20px;">✅ Password benar untuk ' . $email . '</div>';
        } else {
            $html .= '<div style="color:red; margin-top:20px;">❌ Password salah untuk ' . $email . '</div>';
        }
    }
    
    return $html;
});

