    <?php

    use App\Http\Controllers\ProfileController;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\DashboardController;
    use App\Http\Controllers\SurveyController;
    use App\Http\Controllers\AnalyticsController;

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');
    });


    Route::middleware(['auth'])->group(function () {
        Route::get('/', [SurveyController::class, 'index'])->name('survey');
        Route::post('/survey/progress', function (Request $request) {
            $completedDepartments = session('completed_departments', 0);
            $visitedDepartments = session('visited_departments', []);
        
            // Tambahkan department ke daftar visited jika belum ada
            if (!in_array($request->department_id, $visitedDepartments)) {
                $visitedDepartments[] = $request->department_id;
                session(['visited_departments' => $visitedDepartments]);
                session(['completed_departments' => $completedDepartments + 1]);
            }
        
            return response()->json([
                'completedDepartments' => session('completed_departments'),
                'progressPercentage' => (session('completed_departments') / session('totalDepartments', 1)) * 100
            ]);
        })->name('survey.progress');
        Route::post('/survey/store', [SurveyController::class, 'store'])->name('survey.store');
        Route::post('/survey/submit', [SurveyController::class, 'submit'])->name('survey.submit');
        Route::get('/survey/completed', function () {
            return view('users.completed');
        })->name('survey.completed');
        Route::get('/survey/select-departments', [SurveyController::class, 'selectDepartments'])->name('survey.select_departments');
        Route::get('/survey/branch', [BranchSurveyController::class, 'index'])->name('survey.branch');
        Route::post('/survey/store-selected-departments', [SurveyController::class, 'storeSelectedDepartments'])->name('survey.store_selected_departments');
        Route::get('/survey/select', function () {
            return view('users.select_survey'); 
        })->name('survey.select');
    });
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });


    require __DIR__.'/auth.php';
