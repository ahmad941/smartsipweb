<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\SugarConsumptionController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\TpbResponseController;
use App\Http\Controllers\BeverageController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\TpbQuestionController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\AdminEducationController;
use App\Http\Controllers\AdminKnowledgeController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminTeamController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminExportController;
use App\Http\Controllers\PublicSurveyController;
use App\Models\Beverage;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $beverages = Beverage::with('category')->get();
    $sugarDataMap = $beverages->pluck('sugar_per_100ml', 'id');
    return view('welcome', compact('beverages', 'sugarDataMap'));
});

// Standalone Public Survey Route for School Students (Without Login)
Route::get('/kuesioner-siswa', [PublicSurveyController::class, 'index'])->name('public.survey');
Route::post('/kuesioner-siswa', [PublicSurveyController::class, 'store'])->name('public.survey.store');
Route::get('/kuesioner-siswa/sukses/{student}', [PublicSurveyController::class, 'success'])->name('public.survey.success');



Route::middleware('auth')->group(function () {
    Route::get('/student/setup', [StudentProfileController::class, 'create'])->name('student.profile.setup');
    Route::post('/student/setup', [StudentProfileController::class, 'store'])->name('student.profile.setup.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'student.profile.complete'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Sugar Consumption Routes
    Route::get('/sugar-consumptions/create', [SugarConsumptionController::class, 'create'])->name('sugar-consumptions.create');
    Route::post('/sugar-consumptions', [SugarConsumptionController::class, 'store'])->name('sugar-consumptions.store');
    Route::delete('/sugar-consumptions/{id}', [SugarConsumptionController::class, 'destroy'])->name('sugar-consumptions.destroy');

    // Challenges Routes
    Route::get('/challenges', [ChallengeController::class, 'index'])->name('challenges.index');
    Route::post('/challenges/claim/{id}', [ChallengeController::class, 'claim'])->name('challenges.claim');

    // Leaderboard Routes
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');

    // Education & Quiz Routes
    Route::get('/education', [EducationController::class, 'index'])->name('education.index');
    Route::post('/education/quiz/answer', [EducationController::class, 'answer'])->name('education.quiz.answer');

    // Integrated Survey Routes
    Route::get('/survey', [SurveyController::class, 'index'])->name('survey.index');
    
    // FFQ Routes
    Route::get('/survey/ffq', [SurveyController::class, 'ffqForm'])->name('survey.ffq');
    Route::post('/survey/ffq', [SurveyController::class, 'ffqStore'])->name('survey.ffq.store');

    // Knowledge Questionnaire Routes
    Route::get('/survey/knowledge', [SurveyController::class, 'knowledgeForm'])->name('survey.knowledge');
    Route::post('/survey/knowledge', [SurveyController::class, 'knowledgeStore'])->name('survey.knowledge.store');

    // Usability Evaluation Routes (SUS)
    Route::get('/survey/usability', [SurveyController::class, 'usabilityForm'])->name('survey.usability');
    Route::post('/survey/usability', [SurveyController::class, 'usabilityStore'])->name('survey.usability.store');

    // Questionnaire TPB Routes
    Route::get('/questionnaire', [TpbResponseController::class, 'index'])->name('questionnaire.index');
    Route::post('/questionnaire', [TpbResponseController::class, 'store'])->name('questionnaire.store');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Beverages CRUD
    Route::get('/beverages', [BeverageController::class, 'index'])->name('beverages.index');
    Route::post('/beverages', [BeverageController::class, 'store'])->name('beverages.store');
    Route::put('/beverages/{beverage}', [BeverageController::class, 'update'])->name('beverages.update');
    Route::delete('/beverages/{beverage}', [BeverageController::class, 'destroy'])->name('beverages.destroy');

    // Schools & Classes CRUD
    Route::get('/schools', [SchoolController::class, 'index'])->name('schools.index');
    Route::post('/schools', [SchoolController::class, 'store'])->name('schools.store');
    Route::put('/schools/{school}', [SchoolController::class, 'update'])->name('schools.update');
    Route::delete('/schools/{school}', [SchoolController::class, 'destroy'])->name('schools.destroy');
    Route::post('/schools/{school}/classes', [SchoolController::class, 'storeClass'])->name('schools.classes.store');
    Route::delete('/classes/{class}', [SchoolController::class, 'destroyClass'])->name('schools.classes.destroy');

    // TPB Instruments CRUD
    Route::get('/instruments', [TpbQuestionController::class, 'instrumentsIndex'])->name('admin.instruments.index');
    Route::post('/instruments/questions', [TpbQuestionController::class, 'storeQuestion'])->name('admin.instruments.questions.store');
    Route::put('/instruments/questions/{question}', [TpbQuestionController::class, 'updateQuestion'])->name('admin.instruments.questions.update');
    Route::delete('/instruments/questions/{question}', [TpbQuestionController::class, 'destroyQuestion'])->name('admin.instruments.questions.destroy');
    Route::post('/instruments/challenges', [TpbQuestionController::class, 'storeChallenge'])->name('admin.instruments.challenges.store');
    Route::put('/instruments/challenges/{challenge}', [TpbQuestionController::class, 'updateChallenge'])->name('admin.instruments.challenges.update');
    Route::delete('/instruments/challenges/{challenge}', [TpbQuestionController::class, 'destroyChallenge'])->name('admin.instruments.challenges.destroy');

    // Educations CRUD
    Route::get('/educations', [AdminEducationController::class, 'index'])->name('admin.educations.index');
    Route::post('/educations', [AdminEducationController::class, 'store'])->name('admin.educations.store');
    Route::put('/educations/{education}', [AdminEducationController::class, 'update'])->name('admin.educations.update');
    Route::delete('/educations/{education}', [AdminEducationController::class, 'destroy'])->name('admin.educations.destroy');

    // Knowledge Questions CRUD
    Route::get('/knowledge-questions', [AdminKnowledgeController::class, 'index'])->name('admin.knowledge.index');
    Route::post('/knowledge-questions', [AdminKnowledgeController::class, 'store'])->name('admin.knowledge.store');
    Route::put('/knowledge-questions/{question}', [AdminKnowledgeController::class, 'update'])->name('admin.knowledge.update');
    Route::delete('/knowledge-questions/{question}', [AdminKnowledgeController::class, 'destroy'])->name('admin.knowledge.destroy');

    // Categories CRUD
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('admin.categories.index');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('admin.categories.store');
    Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('admin.categories.destroy');

    // Research Team CRUD
    Route::get('/teams', [AdminTeamController::class, 'index'])->name('admin.teams.index');
    Route::post('/teams', [AdminTeamController::class, 'store'])->name('admin.teams.store');
    Route::put('/teams/{team}', [AdminTeamController::class, 'update'])->name('admin.teams.update');
    Route::delete('/teams/{team}', [AdminTeamController::class, 'destroy'])->name('admin.teams.destroy');

    // Users & Responden Management
    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::post('/users', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

    // Research Raw Data Exports
    Route::get('/exports', [AdminExportController::class, 'index'])->name('admin.exports.index');
    Route::get('/exports/demographics', [AdminExportController::class, 'exportDemographics'])->name('admin.exports.demographics');
    Route::get('/exports/ffq', [AdminExportController::class, 'exportFfq'])->name('admin.exports.ffq');
    Route::get('/exports/tpb', [AdminExportController::class, 'exportTpb'])->name('admin.exports.tpb');
    Route::get('/exports/knowledge', [AdminExportController::class, 'exportKnowledge'])->name('admin.exports.knowledge');
    Route::get('/exports/usability', [AdminExportController::class, 'exportUsability'])->name('admin.exports.usability');
    Route::get('/exports/sugar-logs', [AdminExportController::class, 'exportSugarLogs'])->name('admin.exports.sugar_logs');
});

Route::get('/panduan/{role}', function ($role) {
    $files = [
        'siswa' => 'Panduan_Pengguna_Siswa.pdf',
        'guru' => 'Panduan_Pengguna_Guru.pdf',
        'admin' => 'Panduan_Pengguna_Admin.pdf',
    ];

    if (array_key_exists($role, $files)) {
        $path = public_path('panduan/' . $files[$role]);
        if (file_exists($path)) {
            return response()->download($path);
        }
    }
    abort(404);
})->name('panduan.download');

require __DIR__.'/auth.php';
