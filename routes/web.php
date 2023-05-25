<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\SiteFormController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiteEventController;
use App\Http\Controllers\ConferenceController;
use App\Http\Controllers\UploadFileController;
use App\Http\Controllers\FaqCategoryController;
use App\Http\Controllers\Site\AwardsController;
use App\Http\Controllers\StaffCourseController;
use App\Http\Controllers\AuthorizeNetController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\SiteTrainingController;
use App\Http\Controllers\StaffExpenseController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UploadFolderController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\ReimbursementController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\CourseAttendeeController;
use App\Http\Controllers\SiteConferenceController;
use App\Http\Controllers\StaffDashboardController;
use App\Http\Controllers\TrainingCourseController;
use App\Http\Controllers\AwardSubmissionController;
use App\Http\Controllers\StaffConferenceController;
use App\Http\Controllers\DashboardTrainingController;
use App\Http\Controllers\ConferenceAttendeeController;
use App\Http\Controllers\LiveFireSubmissionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardConferenceController;
use App\Http\Controllers\StaffCourseAttendeeController;
use App\Http\Controllers\ConferenceVenueMedicController;
use App\Http\Controllers\DashboardOrganizationController;
use App\Http\Controllers\Site\DashboardVendorsController;
use App\Http\Controllers\ConferenceHotelRequestController;
use App\Http\Controllers\TrainingCourseAttendeeController;
use App\Http\Controllers\StaffTrainingCourseAttendeeController;
use App\Http\Controllers\VendorRegistrationSubmissionController;
use App\Http\Controllers\Dashboard\OrganizationTrainingController;
use App\Http\Controllers\Dashboard\OrganizationConferenceController;

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
    return view('welcome');
});




Route::middleware('guest')->group(function () {
    Route::get('register-choice', [RegisteredUserController::class, 'choice'])
        ->name('register-choice');

    Route::get('register-vendor', [RegisteredUserController::class, 'createVendor'])
        ->name('register-vendor');

    Route::post('register-vendor', [RegisteredUserController::class, 'storeVendor']);

    Route::get('register-admin', [RegisteredUserController::class, 'createAdmin'])
        ->name('register-admin');

    Route::post('register-admin', [RegisteredUserController::class, 'storeAdmin']);
});




Route::get('conference-training-locations', function () {
    return view('site.conference-training-locations');
});
Route::get('contact', function () {
    return view('site.contact');
})->name('contact');

Route::get('/', [SiteController::class, 'home'])->name('home');


Route::get('ttpoa-w-9-form', [SiteController::class, 'w9'])->name('w9');
Route::get('media-kit', [SiteController::class, 'mediaKit'])->name('media-kit');
Route::get('host-an-otoa-training-class', [SiteController::class, 'host'])->name('host');
Route::get('frequently-asked-questions', [SiteController::class, 'faqs'])->name('faqs-site');
Route::get('conference-brochure-ad-specs', [SiteController::class, 'adSpecs'])->name('ad-specs');
Route::get('conference-hotels', [SiteController::class, 'conferenceHotels'])->name('conference-hotels');

Route::get('conference-agenda-attendee', [SiteController::class, 'conferenceAgendaAttendee'])->name('conference-agenda-attendee');
Route::get('monday-speakers-at-the-general-session-lecture-series', [SiteController::class, 'mondaySpeakers'])->name('monday-speakers');

Route::get('awards', [AwardsController::class, 'index'])->name('awards.index');
Route::get('awards/{award:slug}', [AwardsController::class, 'show'])->name('awards.show');
Route::post('awards/{award:slug}', [AwardsController::class, 'store'])->name('awards.store');

Route::get('staff', [SiteController::class, 'staff'])->name('staff');
Route::get('staff/{user}', [SiteController::class, 'staffProfile'])->name('staffProfile');
Route::get('conferences', [SiteConferenceController::class, 'conferences'])->name('conferences');
Route::get('conferences/{conference:slug}', [SiteConferenceController::class, 'conference'])->name('conference');
Route::get('conferences/{conference:slug}/vendors', [SiteConferenceController::class, 'vendors'])->name('conference.vendors');
Route::get('conferences/{conference:slug}/vendors/{vendorRegistrationSubmission}', [SiteConferenceController::class, 'vendor'])->name('conference.vendor');

Route::get('conferences/{conference:slug}/register', [SiteConferenceController::class, 'conferenceRegister'])->name('conference.register');
Route::post('conferences/{conference:slug}/register', [SiteConferenceController::class, 'conferenceRegisterPost'])->name('conference.registerPost');
Route::get('conferences/{conference:slug}/register-choice', [SiteConferenceController::class, 'conferenceRegisterChoice'])->name('conference.register-choice');
Route::post('conferences/{conference:slug}/register-civilian', [SiteConferenceController::class, 'conferenceRegisterCivilian'])->name('conference.register-civilian');
Route::get('conferences/{conference:slug}/register-general-session', [SiteConferenceController::class, 'conferenceRegisterGeneral'])->name('conference.register-general-session');
Route::post('conferences/{conference:slug}/register-general-session', [SiteConferenceController::class, 'conferenceRegisterGeneralPost'])->name('conference.register-general-session');

Route::get('conferences/{conference:slug}/sponsorships', [SiteConferenceController::class, 'sponsorships'])->name('conference.sponsorships');
Route::get('conferences/{conference:slug}/vendor-information', [SiteConferenceController::class, 'vendorInformation'])->name('conference.vendor-information');
Route::get('conferences/{conference:slug}/kalahari-shipping-and-receiving', [SiteConferenceController::class, 'shipping'])->name('conference.shipping');
Route::get('conferences/{conference:slug}/conference-instructor-information', [SiteConferenceController::class, 'conferenceInstructorInformation'])->name('conference.conference-instructor-information');

Route::get('conferences/{conference:slug}/courses', [SiteConferenceController::class, 'courses'])->name('courses');
Route::get('conferences/{conference:slug}/courses/{course}', [SiteConferenceController::class, 'course'])->name('course');

Route::get('conferences/{conference:slug}/vendor-registration',  [SiteFormController::class, 'exhibitionRegistration'])->name('exhibitionRegistration');
Route::post('conferences/{conference:slug}/vendor-registration',  [SiteFormController::class, 'exhibitionRegistrationPost'])->name('exhibitionRegistrationPost');

Route::get('live-fire/{vendorRegistrationSubmission:uuid}',  [SiteFormController::class, 'liveFire'])->name('liveFireForm');
Route::post('live-fire/{vendorRegistrationSubmission:uuid}',  [SiteFormController::class, 'liveFirePost'])->name('liveFireFormPost');


Route::post('check-courses', [SiteConferenceController::class, 'checkCourses'])->name('checkCourses');

Route::get('advanced-training',  [SiteTrainingController::class, 'trainings'])->name('trainings');
Route::get('advanced-training/calendar', [SiteTrainingController::class, 'calendar'])->name('trainings.calendar');
Route::get('advanced-training/{training:slug}', [SiteTrainingController::class, 'training'])->name('training');
Route::get('advanced-training/{training:slug}/courses',  [SiteTrainingController::class, 'trainingCourses'])->name('trainingCourses');
Route::get('advanced-training/{training:slug}/courses/{trainingCourse}', [SiteTrainingController::class, 'trainingCourse'])->name('trainingCourse');
Route::get('advanced-training/{training:slug}/courses/{trainingCourse}/register', [SiteTrainingController::class, 'trainingCourseRegister'])->name('trainingCourse.register');
Route::post('advanced-training/{training:slug}/courses/{trainingCourse}/register', [SiteTrainingController::class, 'trainingCourseRegisterPost'])->name('trainingCourse.registerPost');
Route::post('advanced-training/{training:slug}/courses/{trainingCourse}/waitlist', [SiteTrainingController::class, 'trainingCourseWaitlistPost'])->name('trainingCourse.waitlistPost');


Route::get('events', [SiteEventController::class, 'index'])->name('events.index');
Route::get('events/{event}', [SiteEventController::class, 'show'])->name('events.show');
Route::post('events/{event}/register', [SiteEventController::class, 'register'])->name('events.register');


Route::get('venues',  [SiteController::class, 'venues'])->name('venues');
Route::get('venues/{venue:slug}', [SiteController::class, 'venue'])->name('venue');


Route::get('training-partners',  [SiteController::class, 'partners'])->name('partners');
Route::get('training-partners/{partner}',  [SiteController::class, 'partner'])->name('partner');

Route::get('preferred-vendors',  [SiteController::class, 'vendors'])->name('vendors');
Route::get('preferred-vendors/{vendorPage}', [SiteController::class, 'vendor'])->name('vendor');

Route::get('hotels',  [SiteController::class, 'hotels'])->name('hotels');
Route::get('hotels/{hotel:slug}', [SiteController::class, 'hotel'])->name('hotel');

Route::get('instructional-videos',  [DashboardController::class, 'instructionalVideos'])->name('instructional-videos');


Route::get('billing-portal', function (Request $request) {
    // dd($request);
    return $request->user()->redirectToBillingPortal(route('dashboard'));
})->middleware(['auth'])->name('billing-portal');

// Route::get('subscribe', function () {
//     $user = auth()->user();
//     return view('site.subscribe', [
//         'intent' => $user->createSetupIntent()
//     ]);
// })->middleware(['auth'])->name('subscribe');


Route::get('email-test', [VendorRegistrationSubmissionController::class, 'emailTest']);


Route::get('subscribe', [SubscriptionController::class, 'showSubscription'])->name('subscribe');
Route::post('subscribe', [SubscriptionController::class, 'processSubscription'])->name('subscribePost');
// welcome page only for subscribed users
Route::get('welcome', [SubscriptionController::class, 'showWelcome'])->middleware('subscribed');


Route::middleware(['auth'])->group(function () {

    Route::get('organization/create',  [DashboardController::class, 'createOrganization'])->name('organization.create');
    Route::post('organization/store',  [DashboardController::class, 'storeOrganization'])->name('organization.store');

    Route::get('instructor/training-courses/{trainingCourse}', [TrainingCourseController::class, 'showInstructor'])->name('training-courses.show.instructor');

    Route::get('dashboard',  [DashboardController::class, 'dashboard'])->name('dashboard');
});



Route::prefix('dashboard')->name('dashboard.')->middleware(['auth'])->group(function () {

    // Route::get('/',  [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::middleware('permission:file-sharing')->group(function () {
        Route::get('files', [DashboardController::class, 'folders'])->name('upload-files.folders');
        Route::get('files/{uploadFolder:slug}', [DashboardController::class, 'files'])->name('upload-files.index');
        Route::post('files/{uploadFolder:slug}/upload', [DashboardController::class, 'fileUpload'])->middleware('permission:staff-instructor')->name('upload-files.store');
        Route::get('files/{uploadFolder:slug}/{uploadFile}/edit', [DashboardController::class, 'fileEdit'])->middleware('permission:staff-instructor')->name('upload-files.edit');
        Route::patch('files/{uploadFolder:slug}/{uploadFile}/update', [DashboardController::class, 'fileUpdate'])->middleware('permission:staff-instructor')->name('upload-files.update');
        Route::delete('files/{uploadFile}/upload-destroy', [DashboardController::class, 'fileDestroy'])->middleware('permission:staff-instructor')->name('upload-files.destroy');
    });

    Route::get('subscribe', [SubscriptionController::class, 'create'])->name('subscribe');
    Route::post('subscribe', [SubscriptionController::class, 'store'])->name('subscribePost');

    Route::get('profile', [DashboardController::class, 'profile'])->name('profile');
    Route::patch('profile', [DashboardController::class, 'profilePatch'])->name('profilePatch');
    Route::get('profile-image', [DashboardController::class, 'profileImage'])->name('profileImage');
    Route::post('profile/profileImageUpload', [DashboardController::class, 'profileImageUpload'])->name('profileImageUpload');
    Route::get('change-password', [DashboardController::class, 'changePassword'])->name('changePassword');
    Route::patch('change-password', [DashboardController::class, 'changePasswordPatch'])->name('changePasswordPatch');
    Route::get('membership-benefits', [DashboardController::class, 'benefits'])->name('membership-benefits');

    Route::get('conferences', [DashboardConferenceController::class, 'index'])->name('conferences.index');
    Route::get('conferences/{conferenceAttendee}', [DashboardConferenceController::class, 'show'])->name('conferences.show');

    Route::get('conferences/survey/{courseAttendee}', [DashboardConferenceController::class, 'survey'])->name('conferences.survey');
    Route::post('conferences/survey/{courseAttendee}', [DashboardConferenceController::class, 'surveyPost'])->name('conferences.surveyPost');
    Route::get('conferences/certificate/{courseAttendee}', [DashboDashboardConferenceControllerardController::class, 'certificate'])->name('conferences.certificate');

    Route::get('vendor-registrations/{vendorRegistrationSubmission}/edit', [DashboardVendorsController::class, 'editVendorRegistration'])->name('vendor-registrations.edit');
    Route::patch('vendor-registrations/{vendorRegistrationSubmission}/update', [DashboardVendorsController::class, 'updateVendorRegistration'])->name('vendor-registrations.update');
    Route::get('vendor-registrations/{vendorRegistrationSubmission}/live-fire', [DashboardVendorsController::class, 'liveFire'])->name('vendor-registrations.live-fire');
    Route::post('vendor-registrations/{vendorRegistrationSubmission}/live-fire-post', [DashboardVendorsController::class, 'liveFirePost'])->name('vendor-registrations.live-fire-post');
    Route::patch('vendor-registrations/{vendorRegistrationSubmission}/barter/{barter}', [DashboardVendorsController::class, 'barter'])->name('vendor-registrations.barter');

    Route::get('advanced-training', [DashboardTrainingController::class, 'index'])->name('trainings.index');
    Route::get('advanced-training/{trainingCourseAttendee}', [DashboardTrainingController::class, 'show'])->name('trainings.show');

    Route::get('advanced-training/survey/{trainingCourseAttendee}', [DashboardTrainingController::class, 'trainingSurvey'])->name('trainings.survey');
    Route::post('advanced-training/survey/{trainingCourseAttendee}', [DashboardTrainingController::class, 'trainingSurveyPost'])->name('trainings.surveyPost');
    Route::get('advanced-training/certificate/{trainingCourseAttendee}', [DashboardTrainingController::class, 'trainingCertificate'])->name('trainings.certificate');


    Route::get('company/edit', [DashboardOrganizationController::class, 'edit'])->name('company.edit');
    Route::patch('company/update', [DashboardOrganizationController::class, 'update'])->name('company.update');

    Route::get('events/{event}', [DashboardEventController::class, 'show'])->name('events.show');

    Route::get('organization', [DashboardOrganizationController::class, 'index'])->middleware(['auth', 'permission:organization-admin'])->name('organization.index');
    Route::prefix('organization')->name('organization.')->middleware(['auth', 'permission:organization-admin'])->group(function () {
        Route::post('change-organization', [DashboardOrganizationController::class, 'changeOrganization'])->name('change-organization');
        Route::get('users', [DashboardOrganizationController::class, 'users'])->name('users');
        Route::get('users/create', [DashboardOrganizationController::class, 'userCreate'])->name('user-create');
        Route::post('users/store', [DashboardOrganizationController::class, 'userStore'])->name('user-store');
        Route::get('users/{user}', [DashboardOrganizationController::class, 'user'])->name('user');
        Route::get('users/{user}/edit', [DashboardOrganizationController::class, 'userEdit'])->name('users.edit');
        Route::patch('users/{user}/update', [DashboardOrganizationController::class, 'userUpdate'])->name('users.update');
        Route::post('users/{user}/subscribe/{authorizeSubscription}', [DashboardOrganizationController::class, 'userSubscribe'])->name('users.subscribe');
        Route::post('users/{user}/cancel', [DashboardOrganizationController::class, 'userCancel'])->name('users.cancel');
        Route::prefix('trainings')->name('trainings.')->group(function () {
            Route::get('', [OrganizationTrainingController::class, 'index'])->name('index');
            Route::get('{trainingCourse}', [OrganizationTrainingController::class, 'show'])->name('show');
            Route::get('{trainingCourse}/attendees/{trainingCourseAttendee}', [OrganizationTrainingController::class, 'attendee'])->name('attendee');
        });
        Route::prefix('conferences')->name('conferences.')->group(function () {
            Route::get('', [OrganizationConferenceController::class, 'index'])->name('index');
            Route::get('{conference}', [OrganizationConferenceController::class, 'show'])->name('show');
            Route::get('{conference}/attendees/{conferenceAttendee}', [OrganizationConferenceController::class, 'attendee'])->name('attendee');
        });
    });

    Route::prefix('staff')->name('staff.')->middleware('permission:hotel-request-form')->group(function () {
        Route::get('conferences/{conference}/hotel-reservation', [StaffConferenceController::class, 'hotelRequest'])->name('conferences.hotelRequest');
        Route::post('conferences/{conference}/hotel-reservation', [StaffConferenceController::class, 'hotelRequestPost'])->name('conferences.hotelRequestPost');
        Route::get('conferences/{conference}/hotel-edit', [StaffConferenceController::class, 'hotelEdit'])->name('conferences.hotel-edit');
        Route::patch('conferences/{conference}/hotel-edit-post', [StaffConferenceController::class, 'hotelEditPost'])->name('conferences.hotel-edit-post');
    });

    Route::prefix('staff')->name('staff.')->middleware('permission:staff')->group(function () {
        Route::get('conferences/{conference}/checkin', [StaffConferenceController::class, 'checkin'])->name('conferences.checkin');
    });

    Route::prefix('staff')->name('staff.')->middleware(['auth', 'permission:staff|staff-instructor|conference-instructor'])->group(function () {
        Route::get('signature-generator', [StaffDashboardController::class, 'signatureGenerator'])->name('signature-generator');
        Route::get('signature-generator-frame', [StaffDashboardController::class, 'signatureGeneratorFrame'])->name('signature-generator-frame');

        Route::get('staff-directory', [DashboardController::class, 'staffDirectory'])->name('staffDirectory');
        Route::get('staff-directory/{user}', [DashboardController::class, 'staffDirectoryStaff'])->name('staffDirectory.staff');

        Route::get('advanced-training-courses', [StaffDashboardController::class, 'indexTrainings'])->name('trainings.index');
        Route::get('advanced-training-courses/{trainingCourse}', [StaffDashboardController::class, 'showTrainingCourses'])->name('trainingCourses.show');
        Route::patch('advanced-training-courses/{trainingCourse}/attendees/update-batch', [StaffTrainingCourseAttendeeController::class, 'updateBatch'])->name('training-course-attendees.updateBatch');
        Route::post('advanced-training-courses/{trainingCourse}/attendees/send-emails', [StaffTrainingCourseAttendeeController::class, 'sendEmails'])->name('training-course-attendees.sendEmails');
        Route::get('advanced-training-courses/{trainingCourse}/email', [StaffTrainingCourseAttendeeController::class, 'email'])->name('training-course-attendees.email');

        Route::get('conferences', [StaffConferenceController::class, 'index'])->name('conferences.index');
        Route::get('conferences/{conference}', [StaffConferenceController::class, 'show'])->name('conferences.show');


        Route::get('conferences/{conference}/reimbursement', [StaffConferenceController::class, 'reimbursement'])->name('conferences.reimbursement');
        Route::patch('conferences/{conference}/reimbursement', [StaffConferenceController::class, 'reimbursementPatch'])->name('conferences.reimbursement-patch');

        Route::get('conferences/{conference}/courses', [StaffCourseController::class, 'index'])->name('courses.index');
        Route::get('conferences/{conference}/courses/{course}', [StaffCourseController::class, 'show'])->name('courses.show');
        Route::get('conferences/{conference}/courses/{course}/edit', [StaffCourseController::class, 'edit'])->name('courses.edit');
        Route::patch('conferences/{conference}/courses/{course}/update', [StaffCourseController::class, 'update'])->name('courses.update');

        Route::get('conferences/{conference}/courses/{course}/attendees', [StaffCourseAttendeeController::class, 'index'])->name('course-attendees.index');
        Route::patch('conferences/{conference}/courses/{course}/attendees/update-batch', [StaffCourseAttendeeController::class, 'updateBatch'])->name('course-attendees.updateBatch');

        Route::get('expenses', [StaffExpenseController::class, 'index'])->name('expenses.index');
        Route::get('expenses/create', [StaffExpenseController::class, 'create'])->name('expenses.create');
        Route::post('expenses/store', [StaffExpenseController::class, 'store'])->name('expenses.store');

        // Route::get('courses/{course}/show', [StaffDashboardController::class, 'showCourses'])->name('courses.show');
        // Route::get('courses/{course}/edit', [StaffDashboardController::class, 'editCourses'])->name('courses.edit');
        // Route::get('courses/{course}/roster', [StaffDashboardController::class, 'rosterCourses'])->name('courses.roster');
        // Route::patch('courses/{course}', [StaffDashboardController::class, 'updateCourses'])->name('courses.update');
        // Route::get('courses', [StaffDashboardController::class, 'indexCourses'])->name('courses.index');
    });
});


Route::post('back-to-me', [UserController::class, 'backToMe'])->name('users.back-to-me');

// Route::name('admin.')->group(['middleware' => ['auth']], function () {
Route::prefix('admin')->name('admin.')->middleware(['auth', 'can:admin-dashboard'])->group(function () {
    // Route::group(['middleware' => ['auth']], function () {

    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::middleware('can:vendor-registrations')->group(function () {
        Route::get('conferences/{conference}/vendor-registration-submissions/{vendorRegistrationSubmission}/print', [VendorRegistrationSubmissionController::class, 'print'])->name('vendor-registration-submissions.print');
        Route::get('conferences/{conference}/vendor-registration-submissions/send-emails', [VendorRegistrationSubmissionController::class, 'sendEmails'])->name('vendor-registration-submissions.send-emails');
        Route::get('conferences/{conference}/vendor-registration-submissions/send-emails/view', [VendorRegistrationSubmissionController::class, 'sendEmailsView'])->name('vendor-registration-submissions.send-emails-view');
        Route::post('conferences/{conference}/vendor-registration-submissions/send-emails', [VendorRegistrationSubmissionController::class, 'sendEmailsPost'])->name('vendor-registration-submissions.send-emails-post');
        Route::get('conferences/{conference}/vendor-registration-submissions/export', [VendorRegistrationSubmissionController::class, 'export'])->name('vendor-registration-submissions.export');
        Route::get('conferences/{conference}/vendor-registration-submissions/fill-badges', [VendorRegistrationSubmissionController::class, 'fillBadges'])->name('vendor-registration-submissions.fill-badges');
        Route::get('conferences/{conference}/vendor-registration-submissions/{vendorRegistrationSubmission}/badge/view', [VendorRegistrationSubmissionController::class, 'viewBadge'])->name('vendor-registration-submissions.view-badge');
        Route::get('conferences/{conference}/vendor-registration-submissions/{vendorRegistrationSubmission}/badge/pdf', [VendorRegistrationSubmissionController::class, 'pdfBadge'])->name('vendor-registration-submissions.pdf-badge');
        Route::get('conferences/{conference}/vendor-registration-submissions/badges/view', [VendorRegistrationSubmissionController::class, 'viewBadges'])->name('vendor-registration-submissions.view-badges');
        Route::get('conferences/{conference}/vendor-registration-submissions/badges/pdf', [VendorRegistrationSubmissionController::class, 'pdfBadges'])->name('vendor-registration-submissions.pdf-badges');
        Route::resource('conferences/{conference}/vendor-registration-submissions', VendorRegistrationSubmissionController::class);
        Route::post('conferences/{conference}/vendor-registration-submissions/{vendorRegistrationSubmission}/add-barter', [VendorRegistrationSubmissionController::class, 'addBarter'])->name('vendor-registration-submissions.add-barter');
        Route::patch('conferences/{conference}/vendor-registration-submissions/{vendorRegistrationSubmission}/update-barter', [VendorRegistrationSubmissionController::class, 'updateBarter'])->name('vendor-registration-submissions.update-barter');
        Route::post('conferences/{conference}/vendor-registration-submissions/{vendorRegistrationSubmission}/add-note', [VendorRegistrationSubmissionController::class, 'storenote'])->name('vendor-registration-submissions.add-note');
    });


    Route::middleware('can:live-fire')->group(function () {
        Route::get('conferences/{conference}/live-fire-submissions/export', [LiveFireSubmissionController::class, 'export'])->name('live-fire-submissions.export');
        Route::resource('conferences/{conference}/live-fire-submissions', LiveFireSubmissionController::class);
    });

    Route::middleware('can:hotel-requests')->group(function () {
        Route::get('conferences/{conference}/conference-hotel-requests/export', [ConferenceHotelRequestController::class, 'export'])->name('conference-hotel-requests.export');
        Route::resource('conferences/{conference}/conference-hotel-requests', ConferenceHotelRequestController::class);
    });

    Route::middleware('can:awards')->group(function () {
        Route::resource('award-submissions', AwardSubmissionController::class);
    });

    Route::resource('conferences', ConferenceController::class);

    Route::middleware(['auth', 'can:full-access'])->group(function () {

        Route::get('conferences/{conference}/conference-attendees/export', [ConferenceAttendeeController::class, 'export'])->name('conference-attendees.export');

        // Route::get('conferences/{conference}/roster', [ConferenceController::class, 'roster'])->name('conferences.roster');
        Route::get('conferences/{conference}/conference-attendees/send-emails', [ConferenceAttendeeController::class, 'sendEmails'])->name('conference-attendees.send-emails');
        Route::get('conferences/{conference}/conference-attendees/send-emails/view', [ConferenceAttendeeController::class, 'sendEmailsView'])->name('conference-attendees.send-emails-view');
        Route::post('conferences/{conference}/conference-attendees/send-emails', [ConferenceAttendeeController::class, 'sendEmailsPost'])->name('conference-attendees.send-emails-post');
        Route::get('conferences/{conference}/conference-attendees/fill-badges', [ConferenceAttendeeController::class, 'fillBadges'])->name('conference-attendees.fill-badges');
        Route::get('conferences/{conference}/conference-attendees/badge', [ConferenceAttendeeController::class, 'badge'])->name('conference-attendees.badge');
        Route::post('conferences/{conference}/conference-attendees/badge', [ConferenceAttendeeController::class, 'badgePost'])->name('conference-attendees.badge');
        Route::get('conferences/{conference}/conference-attendees/{conferenceAttendee}/badge/view', [ConferenceAttendeeController::class, 'viewBadge'])->name('conference-attendees.view-badge');
        Route::get('conferences/{conference}/conference-attendees/{conferenceAttendee}/badge/pdf', [ConferenceAttendeeController::class, 'pdfBadge'])->name('conference-attendees.pdf-badge');
        Route::get('conferences/{conference}/conference-attendees/badges/view', [ConferenceAttendeeController::class, 'viewBadges'])->name('conference-attendees.view-badges');
        Route::get('conferences/{conference}/conference-attendees/badges/pdf', [ConferenceAttendeeController::class, 'pdfBadges'])->name('conference-attendees.pdf-badges');
        Route::post('conferences/{conference}/conference-attendees/badges', [ConferenceAttendeeController::class, 'badges'])->name('conference-attendees.badges');
        Route::post('conferences/{conference}/conference-attendees/add-attendee', [ConferenceAttendeeController::class, 'addAttendee'])->name('conference-attendees.add-attendee');

        Route::resource('conferences/{conference}/reimbursements', ReimbursementController::class);

        Route::resource('conferences/{conference}/conference-venue-medics', ConferenceVenueMedicController::class);


        Route::resource('conferences/{conference}/conference-attendees', ConferenceAttendeeController::class);

        Route::get('users/export', [UserController::class, 'export'])->name('users.export');

        Route::get('users/send-emails', [UserController::class, 'sendEmails'])->name('users.send-emails');
        Route::post('users/send-emails', [UserController::class, 'sendEmailsPost'])->name('users.send-emails-post');

        Route::get('users/{user}/sendResetEmail', [UserController::class, 'sendResetEmail'])->name('sendResetEmail');
        Route::post('users/{user}/sendEmail', [UserController::class, 'sendEmail'])->name('users.sendEmail');
        Route::post('users/{user}/subscribe', [UserController::class, 'subscribe'])->name('users.subscribe');
        Route::post('users/{user}/cancel', [UserController::class, 'cancel'])->name('users.cancel');
        Route::post('users/{user}/markPaid/{id}', [UserController::class, 'markPaid'])->name('users.mark-paid');
        Route::post('users/{user}/add-note', [UserController::class, 'storenote'])->name('users.add-note');

        Route::get('login-as/{user}', [UserController::class, 'loginAs'])->name('users.login-as');

        Route::resource('users', UserController::class);

        Route::resource('roles', RoleController::class);
        Route::resource('faqs', FaqController::class);
        Route::resource('faqCategories', FaqCategoryController::class);

        Route::resource('upload-folders', UploadFolderController::class);
        Route::resource('upload-files', UploadFileController::class);

        Route::resource('expenses', ExpenseController::class);

        Route::get('events/{event}/export', [EventController::class, 'export'])->name('events.export');
        Route::resource('events', EventController::class);

        Route::post('events/{event}/add-attendee', [EventAttendeeController::class, 'addAttendee'])->name('event-attendees.add-attendee');
        Route::resource('events/{event}/event-attendees', EventAttendeeController::class);

        Route::resource('subscribes', SubscribeController::class);

        Route::resource('trainings', TrainingController::class);
        // Route::get('training-courses/create/{training}', [TrainingCourseController::class, 'createTraining'])->name('training-courses.create.training');

        Route::post('trainings/{training}/training-courses/{trainingCourse}/add-attendee', [TrainingCourseAttendeeController::class, 'addAttendee'])->name('training-course-attendees.add-attendee');
        Route::resource('trainings/{training}/training-courses', TrainingCourseController::class);

        Route::patch('trainings/{training}/training-courses/{trainingCourse}/training-course-attendees/update-batch', [TrainingCourseAttendeeController::class, 'updateBatch'])->name('training-course-attendees.updateBatch');
        Route::get('trainings/{training}/training-courses/{trainingCourse}/training-course-attendees/export', [TrainingCourseAttendeeController::class, 'export'])->name('training-course-attendees.export');
        Route::resource('trainings/{training}/training-courses/{trainingCourse}/training-course-attendees', TrainingCourseAttendeeController::class);

        // Route::resource('conference-attendees', ConferenceAttendeeController::class);
        Route::resource('conferences/{conference}/courses', CourseController::class);

        Route::get('conferences/{conference}/courses/{course}/course-attendees/view', [CourseAttendeeController::class, 'viewRoster'])->name('course-attendees.view-roster');
        Route::get('conferences/{conference}/courses/{course}/course-attendees/pdf', [CourseAttendeeController::class, 'pdfRoster'])->name('course-attendees.pdf-roster');
        Route::post('conferences/{conference}/course-attendees/rosters', [CourseAttendeeController::class, 'rosters'])->name('course-attendees.rosters');
        Route::patch('conferences/{conference}/courses/{course}/course-attendees/update-batch', [CourseAttendeeController::class, 'updateBatch'])->name('course-attendees.updateBatch');
        Route::resource('conferences/{conference}/courses/{course}/course-attendees', CourseAttendeeController::class);

        Route::get('organizations/export', [OrganizationController::class, 'export'])->name('organizations.export');
        Route::post('organizations/{organization}/link/{user}', [OrganizationController::class, 'link'])->name('organizations.link');
        Route::post('organizations/create-and-link/{user}', [OrganizationController::class, 'createAndLink'])->name('organizations.create-and-link');

        Route::post('organizations/{organization}/add-note', [OrganizationController::class, 'storenote'])->name('organizations.add-note');
        Route::resource('organizations', OrganizationController::class);

        Route::resource('vendors', VendorController::class);
        Route::resource('venues', VenueController::class);
        Route::resource('hotels', HotelController::class);

        Route::resource('radios', RadioController::class);
        Route::resource('awards', AwardController::class);

        Route::resource('staffs', StaffController::class);

        Route::resource('email-templates', EmailTemplateController::class);
        Route::resource('pages', PageController::class);

        Route::get('training-course-attendees/{trainingCourseAttendee}/email', [TrainingCourseAttendeeController::class, 'emailTest'])->name('testEmail');
        Route::get('training-course-attendees/{trainingCourseAttendee}/email/view', [TrainingCourseAttendeeController::class, 'emailview'])->name('testEmail.view');

        Route::get('conference-attendees/{conferenceAttendee}/export', [ConferenceAttendeeController::class, 'export'])->name('conferenceAttendees.export');

        Route::get('conference-attendees/{conferenceAttendee}/email', [ConferenceAttendeeController::class, 'emailRegisteredAttendee'])->name('emailRegisteredAttendee');
        Route::get('conference-attendees/{conferenceAttendee}/email/view', [ConferenceAttendeeController::class, 'emailRegisteredAttendeeView'])->name('emailRegisteredAttendee.view');
    });
});



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard-old', function () {
        return view('dashboard');
    })->name('dashboard-JET');
});


Route::get('transtest', [AuthorizeNetController::class, 'createSubscription']);
Route::get('transtestget', [AuthorizeNetController::class, 'getSubscription']);

Route::get('{page:slug}', [SiteController::class, 'page'])->name('page');
