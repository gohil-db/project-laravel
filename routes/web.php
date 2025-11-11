<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PropertyTypeController;
use App\Http\Controllers\HeaderSliderController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\PropertyAgentController;
use App\Http\Controllers\dashboard\Analytics;

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/property/property-list', [HomeController::class, 'propertyList'])->name('propertyList');
Route::get('/property/property-type', [HomeController::class, 'propertyType'])->name('propertyType');
Route::get('/property/property-agent', [HomeController::class, 'propertyAgent'])->name('propertyAgent');


//Search 
Route::get('/search', [PropertyController::class, 'search'])->name('property.search');


// Backend Admin Routes

// Admin routes
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::get('/admin/register', [AdminAuthController::class, 'showRegisterForm'])->name('admin.register');
Route::post('/admin/register', [AdminAuthController::class, 'register'])->name('admin.register.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
Route::get('/admin/forgot-password', [AdminAuthController::class, 'forgotPassword'])->name('admin.forgot-password');
Route::post('/admin/forgot-password', [AdminAuthController::class, 'sendResetLink'])->name('admin.sendResetLink');


// Admin protected routes
Route::middleware(['admin'])->group(function () {

Route::get('/admin', [Analytics::class, 'index'])->name('dashboard-analytics');
Route::get('/admin/website-settings', [SettingController::class, 'index'])->name('admin-website-settings-logo');
Route::post('website-settings', [SettingController::class, 'update'])->name('website-settings');
// Route::post('/admin/website-settings/update', [SettingController::class, 'update'])->name('admin-website-settings-logo');
// Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

// Property Types
Route::get('/admin/property-types-list', [PropertyTypeController::class, 'index'])->name('admin-properties-types-list');
Route::get('/admin/property-types-create', [PropertyTypeController::class, 'create'])->name('admin-properties-types-create');
Route::resource('/admin/property-types', PropertyTypeController::class);

//Header Slider
Route::get('/admin/header-slider', [HeaderSliderController::class, 'index'])->name('admin-header-slider-add');
Route::post('/admin/header-slider', [HeaderSliderController::class, 'store'])->name('header-slider');
Route::resource('header-slider', HeaderSliderController::class);


// Properties
Route::get('/admin/property-list', [PropertyController::class, 'index'])->name('admin-property-list');
Route::get('/admin/property-create', [PropertyController::class, 'create'])->name('admin-property-create');
// Route::resource('/admin/property', PropertyTypeController::class);
Route::get('/property/{id}', [PropertyController::class, 'show'])->name('properties.show');
Route::resource('properties', PropertyController::class);


// Testimonials
Route::get('/admin/testimonials-list', [TestimonialController::class, 'index'])->name('admin-testimonials-list');
Route::get('/admin/testimonials-create', [TestimonialController::class, 'create'])->name('admin-testimonials-create');
Route::resource('testimonials', TestimonialController::class);


//property agents
Route::get('/admin/property-agents-list', [PropertyAgentController::class, 'index'])->name('admin-agents-list');
Route::get('/admin/property-agents-create', [PropertyAgentController::class, 'create'])->name('admin-agents-create');
Route::resource('property-agents', PropertyAgentController::class);

});







// // layout
// Route::get('/layouts/without-menu', [WithoutMenu::class, 'index'])->name('layouts-without-menu');
// Route::get('/layouts/without-navbar', [WithoutNavbar::class, 'index'])->name('layouts-without-navbar');
// Route::get('/layouts/fluid', [Fluid::class, 'index'])->name('layouts-fluid');
// Route::get('/layouts/container', [Container::class, 'index'])->name('layouts-container');
// Route::get('/layouts/blank', [Blank::class, 'index'])->name('layouts-blank');

// // pages
// Route::get('/pages/account-settings-account', [AccountSettingsAccount::class, 'index'])->name('pages-account-settings-account');
// Route::get('/pages/account-settings-notifications', [AccountSettingsNotifications::class, 'index'])->name('pages-account-settings-notifications');
// Route::get('/pages/account-settings-connections', [AccountSettingsConnections::class, 'index'])->name('pages-account-settings-connections');
// Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');
// Route::get('/pages/misc-under-maintenance', [MiscUnderMaintenance::class, 'index'])->name('pages-misc-under-maintenance');

// // authentication
// Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
// Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
// Route::get('/auth/forgot-password-basic', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');

// // cards
// Route::get('/cards/basic', [CardBasic::class, 'index'])->name('cards-basic');

// // User Interface
// Route::get('/ui/accordion', [Accordion::class, 'index'])->name('ui-accordion');
// Route::get('/ui/alerts', [Alerts::class, 'index'])->name('ui-alerts');
// Route::get('/ui/badges', [Badges::class, 'index'])->name('ui-badges');
// Route::get('/ui/buttons', [Buttons::class, 'index'])->name('ui-buttons');
// Route::get('/ui/carousel', [Carousel::class, 'index'])->name('ui-carousel');
// Route::get('/ui/collapse', [Collapse::class, 'index'])->name('ui-collapse');
// Route::get('/ui/dropdowns', [Dropdowns::class, 'index'])->name('ui-dropdowns');
// Route::get('/ui/footer', [Footer::class, 'index'])->name('ui-footer');
// Route::get('/ui/list-groups', [ListGroups::class, 'index'])->name('ui-list-groups');
// Route::get('/ui/modals', [Modals::class, 'index'])->name('ui-modals');
// Route::get('/ui/navbar', [Navbar::class, 'index'])->name('ui-navbar');
// Route::get('/ui/offcanvas', [Offcanvas::class, 'index'])->name('ui-offcanvas');
// Route::get('/ui/pagination-breadcrumbs', [PaginationBreadcrumbs::class, 'index'])->name('ui-pagination-breadcrumbs');
// Route::get('/ui/progress', [Progress::class, 'index'])->name('ui-progress');
// Route::get('/ui/spinners', [Spinners::class, 'index'])->name('ui-spinners');
// Route::get('/ui/tabs-pills', [TabsPills::class, 'index'])->name('ui-tabs-pills');
// Route::get('/ui/toasts', [Toasts::class, 'index'])->name('ui-toasts');
// Route::get('/ui/tooltips-popovers', [TooltipsPopovers::class, 'index'])->name('ui-tooltips-popovers');
// Route::get('/ui/typography', [Typography::class, 'index'])->name('ui-typography');

// // extended ui
// Route::get('/extended/ui-perfect-scrollbar', [PerfectScrollbar::class, 'index'])->name('extended-ui-perfect-scrollbar');
// Route::get('/extended/ui-text-divider', [TextDivider::class, 'index'])->name('extended-ui-text-divider');

// // icons
// Route::get('/icons/boxicons', [Boxicons::class, 'index'])->name('icons-boxicons');

// // form elements
// Route::get('/forms/basic-inputs', [BasicInput::class, 'index'])->name('forms-basic-inputs');
// Route::get('/forms/input-groups', [InputGroups::class, 'index'])->name('forms-input-groups');

// // form layouts
// Route::get('/form/layouts-vertical', [VerticalForm::class, 'index'])->name('form-layouts-vertical');
// Route::get('/form/layouts-horizontal', [HorizontalForm::class, 'index'])->name('form-layouts-horizontal');

// // tables
// Route::get('/tables/basic', [TablesBasic::class, 'index'])->name('tables-basic');
