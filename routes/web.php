<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\SiteSettingController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Teacher\AnnouncementController as TeacherAnnouncementController;
use Illuminate\Support\Facades\Route;

// ─── PUBLIC FRONTEND ROUTES ───
Route::get('/lang/{locale}', [\App\Http\Controllers\LanguageController::class, 'switch'])->name('lang.switch');
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/courses', [HomeController::class, 'search'])->name('courses');
Route::get('/course/{slug}', [HomeController::class, 'courseShow'])->name('course.show');
Route::get('/contact', function () { return view('pages.contact'); })->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// ─── AUTHENTICATED USER ROUTES ───
Route::middleware('auth')->group(function () {
    // Profile
    Route::middleware('lms_module:profile')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Global dashboard redirect
    Route::get('/dashboard', function() {
        $user = auth()->user();
        if ($user && $user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        if ($user && $user->role === 'instructor') {
            return redirect()->route('teacher.dashboard');
        }
        return redirect()->route('student.dashboard');
    })->name('dashboard');

    // Student pages
    Route::get('/dashboard/student', [\App\Http\Controllers\Student\DashboardController::class, 'index'])->name('student.dashboard');
    Route::get('/my-learning', [HomeController::class, 'myLearning'])->name('my-learning')->middleware('lms_module:my_learning');
    Route::get('/leaderboard', function () { return view('pages.leaderboard'); })->name('leaderboard');

    // Certificates
    Route::middleware('lms_module:certificates')->group(function () {
        Route::get('/certificates', [\App\Http\Controllers\CertificateController::class, 'index'])->name('certificates');
        Route::get('/certificates/{code}', [\App\Http\Controllers\CertificateController::class, 'show'])->name('certificates.show');
        Route::get('/certificates/{code}/download', [\App\Http\Controllers\CertificateController::class, 'download'])->name('certificates.download');
    });

    // Wishlist
    Route::middleware('lms_module:wishlist')->group(function () {
        Route::get('/wishlist', [\App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist.index');
        Route::post('/wishlist/{course}/toggle', [\App\Http\Controllers\WishlistController::class, 'toggle'])->name('wishlist.toggle');
    });

    // Internal Messaging
    Route::middleware('lms_module:messages')->group(function () {
        Route::get('/messages', [\App\Http\Controllers\MessagesController::class, 'index'])->name('messages.index');
        Route::post('/messages', [\App\Http\Controllers\MessagesController::class, 'store'])->name('messages.store');
        Route::get('/messages/{userId}', [\App\Http\Controllers\MessagesController::class, 'show'])->name('messages.show');
        Route::delete('/messages/{message}', [\App\Http\Controllers\MessagesController::class, 'destroy'])->name('messages.destroy');
    });

    // Notifications
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{notification}/read', [\App\Http\Controllers\NotificationController::class, 'read'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [\App\Http\Controllers\NotificationController::class, 'markAllRead'])->name('notifications.mark-all-read');
    Route::delete('/notifications-clear', [\App\Http\Controllers\NotificationController::class, 'destroyAll'])->name('notifications.clear-all');
    Route::delete('/notifications/{notification}', [\App\Http\Controllers\NotificationController::class, 'destroy'])->name('notifications.destroy');

    // Course Enrollment & Learning
    Route::post('/course/{slug}/enroll', [\App\Http\Controllers\EnrollmentController::class, 'enroll'])->name('course.enroll');
    Route::get('/course/{slug}/checkout', [\App\Http\Controllers\EnrollmentController::class, 'checkout'])->name('course.checkout');
    Route::post('/course/{slug}/checkout', [\App\Http\Controllers\EnrollmentController::class, 'processCheckout'])->name('course.checkout.process');
    Route::delete('/course/{slug}/unenroll', [\App\Http\Controllers\EnrollmentController::class, 'unenroll'])->name('course.unenroll');
    Route::get('/course/{slug}/learn/{lesson?}', [HomeController::class, 'learn'])->name('course.learn');

    // AJAX Student Actions
    Route::post('/student/lessons/{id}/complete', [\App\Http\Controllers\Student\LessonProgressController::class, 'toggleComplete'])->name('lessons.complete');
    Route::post('/student/courses/{id}/toggle-list', [\App\Http\Controllers\Student\StudentListController::class, 'toggleList'])->name('courses.toggle-list');
    Route::post('/student/lessons/{id}/review', [\App\Http\Controllers\Student\ReviewController::class, 'storeReview'])->name('lessons.review');
    Route::post('/student/lessons/{id}/comment', [\App\Http\Controllers\Student\CommentController::class, 'storeComment'])->name('lessons.comment');
    Route::post('/student/ai-chat', [\App\Http\Controllers\Student\AiController::class, 'sendMessage'])->name('student.ai-chat');
    Route::post('/student/courses/{courseId}/discussions', [\App\Http\Controllers\Student\DiscussionController::class, 'store'])->name('student.discussions.store');
    Route::post('/student/discussions/{discussionId}/reply', [\App\Http\Controllers\Student\DiscussionController::class, 'reply'])->name('student.discussions.reply');

    // Progress tracking
    Route::post('/lessons/{lesson}/complete', [\App\Http\Controllers\LessonProgressController::class, 'complete'])->name('lesson.complete');
    Route::post('/lessons/{lesson}/uncomplete', [\App\Http\Controllers\LessonProgressController::class, 'uncomplete'])->name('lesson.uncomplete');
    Route::post('/student/lessons/{lesson}/complete', [\App\Http\Controllers\LessonProgressController::class, 'complete']);
    Route::post('/student/lessons/{lesson}/uncomplete', [\App\Http\Controllers\LessonProgressController::class, 'uncomplete']);

    // Student: Quizzes
    Route::middleware('lms_module:quizzes')->group(function () {
        Route::get('/student/quizzes', [\App\Http\Controllers\Student\QuizController::class, 'index'])->name('student.quizzes.index');
        Route::get('/student/quizzes/{quiz}', [\App\Http\Controllers\Student\QuizController::class, 'show'])->name('student.quizzes.show');
        Route::post('/student/quizzes/{quiz}/submit', [\App\Http\Controllers\Student\QuizController::class, 'submit'])->name('student.quizzes.submit');
    });

    // Student: Assignments
    Route::middleware('lms_module:assignments')->group(function () {
        Route::get('/student/assignments', [\App\Http\Controllers\Student\AssignmentController::class, 'index'])->name('student.assignments.index');
        Route::get('/student/assignments/{assignment}', [\App\Http\Controllers\Student\AssignmentController::class, 'show'])->name('student.assignments.show');
        Route::post('/student/assignments/{assignment}/submit', [\App\Http\Controllers\Student\AssignmentController::class, 'submit'])->name('student.assignments.submit');
    });

    // Student: Coding Platform
    Route::middleware('lms_module:practice')->group(function () {
        Route::get('/student/coding', [\App\Http\Controllers\Student\CodingController::class, 'index'])->name('student.coding.index');
        Route::get('/student/coding/{problem}', [\App\Http\Controllers\Student\CodingController::class, 'show'])->name('student.coding.show');
        Route::post('/student/coding/{problem}/submit', [\App\Http\Controllers\Student\CodingController::class, 'submit'])->name('student.coding.submit');
        Route::post('/student/coding/{problem}/run', [\App\Http\Controllers\Student\CodingController::class, 'run'])->name('student.coding.run');
    });

    // Student: Orders & Purchases
    Route::get('/student/orders', [\App\Http\Controllers\Student\OrderController::class, 'index'])->name('student.orders.index')->middleware('lms_module:purchases');

    // Student: Playlist & Watch Later
    Route::middleware('lms_module:playlist')->group(function () {
        Route::get('/student/playlist', [\App\Http\Controllers\Student\PlaylistController::class, 'index'])->name('student.playlist');
        Route::post('/student/playlist/{course}/toggle', [\App\Http\Controllers\Student\PlaylistController::class, 'toggle'])->name('student.playlist.toggle');
    });
    Route::middleware('lms_module:watch_later')->group(function () {
        Route::get('/student/watch-later', [\App\Http\Controllers\Student\WatchLaterController::class, 'index'])->name('student.watch-later');
        Route::post('/student/watch-later/{course}/toggle', [\App\Http\Controllers\Student\WatchLaterController::class, 'toggle'])->name('student.watch-later.toggle');
    });

    // Cart
    Route::get('/cart', [\App\Http\Controllers\Student\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{courseId}', [\App\Http\Controllers\Student\CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{itemId}', [\App\Http\Controllers\Student\CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/coupon', [\App\Http\Controllers\Student\CartController::class, 'applyCoupon'])->name('cart.coupon');
    Route::get('/checkout', [\App\Http\Controllers\Student\CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/checkout', [\App\Http\Controllers\Student\CartController::class, 'processCheckout'])->name('cart.checkout.process');

    // AI Assistant
    Route::post('/ai/ask', [\App\Http\Controllers\AiAssistantController::class, 'ask'])->name('ai.ask');

    // Reviews
    Route::post('/course/{course}/review', [ReviewController::class, 'store'])->name('review.store');
    Route::delete('/review/{review}', [ReviewController::class, 'destroy'])->name('review.destroy');

    // Comments
    Route::post('/comments', [\App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [\App\Http\Controllers\CommentController::class, 'destroy'])->name('comments.destroy');
});

// ─── ADMIN PANEL ───
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/analytics', [\App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('analytics.index');
    Route::resource('courses', CourseController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('lessons', LessonController::class);
    Route::resource('announcements', AnnouncementController::class);
    Route::resource('contacts', AdminContactController::class);
    Route::resource('users', UserController::class);
    Route::get('/sales', [\App\Http\Controllers\Admin\SalesController::class, 'index'])->name('sales.index');
    Route::get('/content-review', [\App\Http\Controllers\Admin\ContentReviewController::class, 'index'])->name('content-review.index');
    Route::post('/content-review/{id}/approve', [\App\Http\Controllers\Admin\ContentReviewController::class, 'approve'])->name('content-review.approve');
    Route::post('/content-review/{id}/reject', [\App\Http\Controllers\Admin\ContentReviewController::class, 'reject'])->name('content-review.reject');

    // Teacher Applications
    Route::get('/teachers', [\App\Http\Controllers\Admin\TeacherApprovalController::class, 'index'])->name('teachers.index');
    Route::get('/teachers/{id}', [\App\Http\Controllers\Admin\TeacherApprovalController::class, 'show'])->name('teachers.show');
    Route::post('/teachers/{id}/approve', [\App\Http\Controllers\Admin\TeacherApprovalController::class, 'approve'])->name('teachers.approve');
    Route::post('/teachers/{id}/reject', [\App\Http\Controllers\Admin\TeacherApprovalController::class, 'reject'])->name('teachers.reject');

    // Coupons
    Route::resource('coupons', \App\Http\Controllers\Admin\CouponController::class);
    Route::get('/payments', [\App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('payments.index');

    // Revenue
    Route::get('/revenue', [\App\Http\Controllers\Admin\RevenueController::class, 'index'])->name('revenue.index');
    Route::post('/revenue/withdraw/{id}/approve', [\App\Http\Controllers\Admin\RevenueController::class, 'approveWithdraw'])->name('revenue.withdraw.approve');
    Route::post('/revenue/withdraw/{id}/reject', [\App\Http\Controllers\Admin\RevenueController::class, 'rejectWithdraw'])->name('revenue.withdraw.reject');

    // Coding Platform
    Route::get('/coding', [\App\Http\Controllers\Admin\CodingController::class, 'index'])->name('coding.index');
    Route::post('/coding/language/store', [\App\Http\Controllers\Admin\CodingController::class, 'storeLanguage'])->name('coding.language.store');
    Route::post('/coding/language/{id}/toggle', [\App\Http\Controllers\Admin\CodingController::class, 'toggleLanguage'])->name('coding.language.toggle');

    // Support Tickets
    Route::get('/support', [\App\Http\Controllers\Admin\SupportController::class, 'index'])->name('support.index');
    Route::get('/support/{id}', [\App\Http\Controllers\Admin\SupportController::class, 'show'])->name('support.show');
    Route::post('/support/{id}/reply', [\App\Http\Controllers\Admin\SupportController::class, 'reply'])->name('support.reply');
    Route::post('/support/{id}/close', [\App\Http\Controllers\Admin\SupportController::class, 'close'])->name('support.close');

    // CMS
    Route::get('/cms', [\App\Http\Controllers\Admin\CmsController::class, 'index'])->name('cms.index');
    Route::post('/cms/faq', [\App\Http\Controllers\Admin\CmsController::class, 'storeFaq'])->name('cms.faq.store');
    Route::delete('/cms/faq/{id}', [\App\Http\Controllers\Admin\CmsController::class, 'destroyFaq'])->name('cms.faq.destroy');

    // Audit Log
    Route::get('/audit', [\App\Http\Controllers\Admin\AuditLogController::class, 'index'])->name('audit.index');

    // Certificate Templates
    Route::get('/certificates', [\App\Http\Controllers\Admin\CertificateTemplateController::class, 'index'])->name('certificates.index');
    Route::post('/certificates', [\App\Http\Controllers\Admin\CertificateTemplateController::class, 'store'])->name('certificates.store');

    // Site Settings
    Route::get('/settings', [SiteSettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SiteSettingController::class, 'update'])->name('settings.update');

    // LMS Modules Settings
    Route::get('/modules', [\App\Http\Controllers\Admin\ModuleSettingsController::class, 'index'])->name('modules.index');
    Route::post('/modules', [\App\Http\Controllers\Admin\ModuleSettingsController::class, 'update'])->name('modules.update');
});

// ─── TEACHER PANEL ───
Route::middleware(['auth', 'teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/', [TeacherDashboardController::class, 'index'])->name('dashboard');
    Route::resource('courses', \App\Http\Controllers\Teacher\CourseController::class);
    // Course LMS Modules Settings
    Route::get('/courses/{course}/modules', [\App\Http\Controllers\Teacher\CourseModuleController::class, 'index'])->name('courses.modules.index');
    Route::post('/courses/{course}/modules', [\App\Http\Controllers\Teacher\CourseModuleController::class, 'update'])->name('courses.modules.update');

    Route::resource('lessons', \App\Http\Controllers\Teacher\LessonController::class);

    // Modules
    Route::resource('modules', \App\Http\Controllers\Teacher\ModuleController::class);

    // Assignments
    Route::resource('assignments', \App\Http\Controllers\Teacher\AssignmentController::class);
    Route::get('/assignments/{assignment}/submissions', [\App\Http\Controllers\Teacher\AssignmentController::class, 'submissions'])->name('assignments.submissions');
    Route::post('/assignments/submission/{submissionId}/grade', [\App\Http\Controllers\Teacher\AssignmentController::class, 'grade'])->name('assignments.grade');

    // Quizzes
    Route::resource('quizzes', \App\Http\Controllers\Teacher\QuizController::class);
    Route::get('/quizzes/{quiz}/results', [\App\Http\Controllers\Teacher\QuizController::class, 'results'])->name('quizzes.results');
    Route::get('/quizzes/{quiz}/questions', [\App\Http\Controllers\Teacher\QuizController::class, 'questions'])->name('quizzes.questions');
    Route::post('/quizzes/{quiz}/questions', [\App\Http\Controllers\Teacher\QuizController::class, 'storeQuestion'])->name('quizzes.questions.store');
    Route::put('/quizzes/{quiz}/questions/{question}', [\App\Http\Controllers\Teacher\QuizController::class, 'updateQuestion'])->name('quizzes.questions.update');
    Route::delete('/quizzes/{quiz}/questions/{question}', [\App\Http\Controllers\Teacher\QuizController::class, 'destroyQuestion'])->name('quizzes.questions.destroy');

    // Coding Problems
    Route::resource('coding', \App\Http\Controllers\Teacher\CodingController::class);
    Route::get('/coding/{id}/test-cases', [\App\Http\Controllers\Teacher\CodingController::class, 'testCases'])->name('coding.test-cases');
    Route::post('/coding/{id}/test-cases', [\App\Http\Controllers\Teacher\CodingController::class, 'storeTestCase'])->name('coding.test-cases.store');
    Route::get('/coding/{id}/submissions', [\App\Http\Controllers\Teacher\CodingController::class, 'submissions'])->name('coding.submissions');

    // Students
    Route::get('/students', [\App\Http\Controllers\Teacher\StudentController::class, 'index'])->name('students.index');
    Route::get('/students/{id}', [\App\Http\Controllers\Teacher\StudentController::class, 'show'])->name('students.show');

    // Discussions
    Route::get('/discussions', [\App\Http\Controllers\Teacher\DiscussionController::class, 'index'])->name('discussions.index');
    Route::get('/discussions/{id}', [\App\Http\Controllers\Teacher\DiscussionController::class, 'show'])->name('discussions.show');
    Route::post('/discussions/{id}/reply', [\App\Http\Controllers\Teacher\DiscussionController::class, 'reply'])->name('discussions.reply');

    // Reviews
    Route::get('/reviews', [\App\Http\Controllers\Teacher\ReviewController::class, 'index'])->name('reviews.index');

    // Announcements (course-specific)
    Route::resource('announcements', TeacherAnnouncementController::class);

    // Revenue & Payouts
    Route::get('/revenue', [\App\Http\Controllers\Teacher\RevenueController::class, 'index'])->name('revenue.index');
    Route::post('/revenue/withdraw', [\App\Http\Controllers\Teacher\RevenueController::class, 'requestWithdraw'])->name('revenue.withdraw');
});

// ─── INSTRUCTOR ALIAS (redirect to teacher panel) ───
Route::middleware(['auth'])->get('/instructor/dashboard', function () {
    return redirect()->route('teacher.dashboard');
})->name('instructor.dashboard');

require __DIR__.'/auth.php';