<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;

use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PropertyTypeController;
use App\Http\Controllers\HeaderSliderController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\PropertyAgentController;
use App\Http\Controllers\BuilderController;


// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/property/property-list', [HomeController::class, 'propertyList'])->name('propertyList');
Route::get('/property/property-builder', [BuilderController::class, 'propertyBuilderList'])->name('property-builder');
Route::get('/property-builder/{slug}', [BuilderController::class, 'show'])->name('builders.show');
Route::get('/ajax/filter-properties', [HomeController::class, 'getFilterPropertiesAjax'])->name('ajax.properties');


Route::get('/property/property-agent', [HomeController::class, 'propertyAgent'])->name('propertyAgent');
Route::get('/property/{id}', [PropertyController::class, 'show'])->name('propertiesList.show');
Route::post('/property/{property}/inquiry', [PropertyController::class, 'storeInquiry'])->name('property.inquiry');
Route::get('/property/type/{slug}', [PropertyTypeController::class, 'propertyByType'])->name('property.byType');


//Search 
Route::get('/search', [PropertyController::class, 'search'])->name('property.search');



// Backend Admin Routes
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::get('/admin/register', [AdminAuthController::class, 'showRegisterForm'])->name('admin.register');
Route::post('/admin/register', [AdminAuthController::class, 'register'])->name('admin.register.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
Route::get('/admin/forgot-password', [AdminAuthController::class, 'forgotPassword'])->name('admin.forgot-password');
Route::post('/admin/forgot-password', [AdminAuthController::class, 'sendResetLink'])->name('admin.sendResetLink');


//Backend Admin protected routes
Route::middleware(['admin'])->group(function () {
Route::get('/admin', [Analytics::class, 'index'])->name('dashboard-analytics');
Route::get('/admin/website-settings', [SettingController::class, 'index'])->name('admin-website-settings-logo');
Route::post('website-settings', [SettingController::class, 'update'])->name('website-settings');


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
Route::resource('properties', PropertyController::class);
// Route::delete('/property-video/{id}', [PropertyController::class, 'deleteVideo'])->name('property.video.delete');
Route::delete('/delete-image/{id}', [PropertyController::class, 'deleteImage'])->name('property.image.delete');
Route::delete('/delete-video/{id}', [PropertyController::class, 'deleteVideo'])->name('property.video.delete');
Route::patch('/properties/{id}/property-status', [PropertyController::class, 'propertyStatus'])->name('properties.propertyStatus');
Route::patch('/properties/{id}/toggle-top', [PropertyController::class, 'toggleTop'])->name('properties.toggleTop');


// Testimonials
Route::get('/admin/testimonials-list', [TestimonialController::class, 'index'])->name('admin-testimonials-list');
Route::get('/admin/testimonials-create', [TestimonialController::class, 'create'])->name('admin-testimonials-create');
Route::resource('testimonials', TestimonialController::class);


//property agents
Route::get('/admin/property-agents-list', [PropertyAgentController::class, 'index'])->name('admin-agents-list');
Route::get('/admin/property-agents-create', [PropertyAgentController::class, 'create'])->name('admin-agents-create');
Route::resource('property-agents', PropertyAgentController::class);

//property Builder
Route::get('/admin/property-builders-list', [BuilderController::class, 'index'])->name('admin-builders-list');
Route::get('/admin/property-builders-create', [BuilderController::class, 'create'])->name('admin-builders-create');
Route::resource('property-builders', BuilderController::class);

 Route::get('/admin/inquiriesList', [PropertyController::class, 'inquiriesList'])->name('admin.property.inquiriesList');
Route::delete('/admin/inquiries/{inquiry}', [PropertyController::class, 'destroyInquiry'])->name('inquiries.destroy');
//  Route::post('/property/{property}/inquiry', [PropertyController::class, 'storeInquiry'])->name('property.inquiry');

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
