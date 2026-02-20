<?php

use App\Http\Livewire\AuditManagement\AuditDefaults;
use App\Http\Livewire\AuditManagement\AuditDetails;
use App\Http\Livewire\AuditManagement\AuditList;
use App\Http\Livewire\AuditManagement\CreateAudit;
use App\Http\Livewire\Boards\BoardDetails;
use App\Http\Livewire\Boards\BoardIndex;
use App\Http\Livewire\Boards\BoardSettings;
use App\Http\Livewire\Boards\CreateBoard;
use App\Http\Livewire\Calendar\Calendar;
use App\Http\Livewire\Clients\ClientDetails;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Clients\ClientIndex;
use App\Http\Livewire\Clients\CreateClient;
use App\Http\Livewire\Contacts\ContactDetails;
use App\Http\Livewire\Contacts\ContactIndex;
use App\Http\Livewire\Contacts\CreateContact;
use App\Http\Livewire\Products\ProductIndex;
use App\Http\Livewire\Quotes\CreateQuote;
use App\Http\Livewire\Quotes\QuoteIndex;
use App\Http\Livewire\Roles\RoleBuilder;
use App\Http\Livewire\Roles\RoleDetails;
use App\Http\Livewire\Roles\RoleIndex;
use App\Http\Livewire\Users\UserDetails;
use App\Http\Livewire\Users\UserIndex;
use App\Http\Livewire\Consultations\ConsultationIndex;
use App\Http\Livewire\Consultations\ConsultationDetails;
use App\Http\Livewire\Consultations\CreateConsultation;
use App\Http\Livewire\Dashboard\Dashboard;
use App\Http\Livewire\Files\FileIndex;
use App\Http\Livewire\Files\FileSettings;
use App\Http\Livewire\Invoices\CreateInvoice;
use App\Http\Livewire\Invoices\InvoiceDetails;
use App\Http\Livewire\KnowledgePanel\KnowledgePanelCategory;
use App\Http\Livewire\KnowledgePanel\KnowledgePanelIndex;
use App\Http\Livewire\KnowledgePanel\Topic;
use App\Http\Livewire\Leads\CreateLead;
use App\Http\Livewire\Leads\LeadDetails;
use App\Http\Livewire\Products\CreateProduct;
use App\Http\Livewire\Products\ProductDetails;
use App\Http\Livewire\Quotes\QuoteDetails;
use App\Http\Livewire\Services\CreateService;
use App\Http\Livewire\Services\ServiceDetails;
use App\Http\Livewire\Services\ServiceIndex;
use App\Http\Livewire\Suppliers\SupplierIndex;
use App\Http\Livewire\Suppliers\CreateSupplier;
use App\Http\Livewire\Management\ManagementDetails;
use App\Mail\MyTestMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Livewire\Leads\LeadIndex;
use App\Http\Livewire\Management\CreateManagementProcess;
use App\Http\Livewire\Management\ManagementIndex;
use App\Http\Livewire\Procurement\ProcurmentIndex;
use App\Http\Livewire\Projects\ProjectIndex;
use App\Http\Livewire\Reports\ReportIndex;
use App\Http\Livewire\Settings\MainPage as SettingsMainPage;
use App\Http\Livewire\Support\MainPage;
use App\Http\Livewire\Tasks\TaskIndex;
use App\Models\Board;
use App\Models\File;
use App\Models\Invoice;
use App\Http\Controllers\AuditController;
use App\Http\Livewire\AuditTemplateBuilder;
use App\Http\Livewire\Settings\AuditFields;
use App\Http\Livewire\ProjectsTaskCategoryOverview;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::redirect('/', './login');

//MSO Calendar and OneDrive
// Route::get('/', '\App\Http\Controllers\HomeController@welcome');
Route::get('/signin', '\App\Http\Controllers\AuthController@signin');
Route::get('/callback', '\App\Http\Controllers\AuthController@callback');
Route::get('/signout', '\App\Http\Controllers\AuthController@signout');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('calendar', Calendar::class)->name('calendar');    
});

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified'
// ])->group(function () {
//     Route::get('files', FileIndex::class)->name('files');    
//     Route::get('fileSettings', FileSettings::class)->name('fileSettings');
// });

//----------------------------------------------------------------

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified'
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('dashboard', Dashboard::class)->name('dashboard');
});

//----------------------------------------------------------------
//USERS
//VIEW users
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('users', UserIndex::class)->name('users');

    Route::get('users/{id}', UserDetails::class);
});

//----------------------------------------------------------------
//ROLES
//CREATE roles
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'permission:create roles'
])->group(function () {
    Route::get('roles/create', RoleBuilder::class)->name('createRole');
});

//VIEW roles
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'permission:view roles'
])->group(function () {
    Route::get('roles', RoleIndex::class)->name('roles');
    Route::get('roles/{id}', RoleDetails::class);
});

//----------------------------------------------------------------
//CLIENTS
//CREATE clients
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'permission:create clients'
])->group(function () {
    Route::get('clients/create', CreateClient::class)->name('createClient');
});

//VIEW clients
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('clients', ClientIndex::class)->name('clients');
    Route::get('clients/{id}', ClientDetails::class)->name('clientDetails');
});

//----------------------------------------------------------------
//CONTACTS
//CREATE contacts
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'permission:create contacts'
])->group(function () {
    Route::get('contacts/create', CreateContact::class)->name('createContact');
});

//VIEW contacts
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'permission:view contacts'
])->group(function () {
    Route::get('contacts', ContactIndex::class)->name('contacts');

    Route::get('contacts/{id}', ContactDetails::class);
});

//----------------------------------------------------------------

//PRODUCTS
//VIEW products
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'permission:view products'
])->group(function () {
    Route::get('products', ProductIndex::class)->name('products');
    Route::get('products/{id}', ProductDetails::class);
});

//CREATE products
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'permission:create products'
])->group(function () {
    Route::get('product/create', CreateProduct::class)->name('createProduct');
});

//----------------------------------------------------------------

//SERVICES
//VIEW services
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'permission:view products'
])->group(function () {
    Route::get('services', ServiceIndex::class)->name('services');
    Route::get('services/{id}', ServiceDetails::class);
});

//VIEW services
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'permission:view products'
])->group(function () {
    Route::get('service/create', CreateService::class);
});

//----------------------------------------------------------------
//QUOTES
//CREATE quotes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'permission:view quotes'
])->group(function () {
    Route::get('quotes/create', CreateQuote::class)->name('createQuotes');
});

//VIEW quotes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'permission:view quotes'
])->group(function () {
    Route::get('quotes', QuoteIndex::class)->name('quotes');
    Route::get('quotes/{id}', QuoteDetails::class);
});

//----------------------------------------------------------------
//INVOICES
//CREATE invoices
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',

])->group(function () {
    Route::get('invoices/create', CreateInvoice::class);
});

//VIEW invoices
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',

])->group(function () {
    Route::get('invoices/{id}', InvoiceDetails::class);
});

//----------------------------------------------------------------
//CONSULTATIONS
//VIEW consultations
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'permission:view consultations'
])->group(function () {
    Route::get('consultations', ConsultationIndex::class)->name('consultations');

    Route::get('consultations/{id}', ConsultationDetails::class);
});

//CREATE consultations
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'permission:create consultations'
])->group(function () {
    Route::get('consultation/create', CreateConsultation::class)->name('createConsultation');
});

//----------------------------------------------------------------
//SUPPLIERS
//CREATE suppliers
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'permission:create suppliers'
])->group(function () {
    Route::get('suppliers/create', CreateSupplier::class)->name('suppliers');
});

//VIEW suppliers
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'permission:view suppliers'
])->group(function () {
    Route::get('suppliers', SupplierIndex::class)->name('suppliers');
});

//----------------------------------------------------------------
//CALENDAR
//VIEW calendar


Route::get('send-mail', function() {
    $details = [
        'title' => 'Mail Test',
        'body' => 'This is an email test'
    ];

    Mail::to('keshav.badul06@gmail.com')->send(new MyTestMail($details));

    dd('Email sent');
});
//----------------------------------------------------------------
//LEADS
//CREATE lead
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'permission:create leads'
])->group(function () {
    Route::get('leads/create', CreateLead::class)->name('createLeads');
});

//VIEW lead
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'permission:view leads'
])->group(function () {
    Route::get('leads', LeadIndex::class)->name('leads');
    Route::get('leads/{id}', LeadDetails::class);
});

//----------------------------------------------------------------
//PROJECTS
//VIEW project
Route::get('projects', ProjectIndex::class)->name('projects');


//----------------------------------------------------------------
//REPORTS
//CREATE reports
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'permission:view reports'
])->group(function () {
    Route::get('reports', ReportIndex::class)->name('reports');
});

//----------------------------------------------------------------
//BOARDS
//VIEW boards
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',

])->group(function () {
    Route::get('boards', BoardIndex::class)->name('boards');
    Route::get('boards/create', CreateBoard::class)->name('createBoard');
    Route::get('boards/{id}', BoardDetails::class);
    Route::get('board-settings/{id}', BoardSettings::class);
});

//----------------------------------------------------------------
//TASKS
//VIEW tasks
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'permission:view tasks'
])->group(function () {
    Route::get('tasks', TaskIndex::class)->name('tasks');
});

//----------------------------------------------------------------
//SUPPORT
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('support', MainPage::class)->name('support');
});

//----------------------------------------------------------------
//AUDIT MANAGEMENT
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'permission:view audits',
])->group(function () {
    Route::get('audits', AuditList::class)->name('audits');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'permission:create audits'
])->group(function () {
    Route::get('audits/create', CreateAudit::class)->name('create-audit');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'permission:view audits'
])->group(function () {
    Route::get('audits/{id}', AuditDetails::class);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'permission:create audits',
    'permission:edit audits'
])->group(function () {
    Route::get('audit-defaults', AuditDefaults::class)->name('audit-defaults');
});

//MANAGEMENT
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'permission:access management'
])->group(function () {
    Route::get('management/create', CreateManagementProcess::class)->name('createManagement');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'permission:access management'
])->group(function () {
    Route::get('management', ManagementIndex::class)->name('management');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'permission:access management'
])->group(function () {
    Route::get('management/{id}', ManagementDetails::class);
});

//************ CHANGE THIS ************
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('file-viewer/{id}', function($id) {
        $file = File::find($id);
        return response()->file(storage_path('app/' . $file->file_path . '/' . $file->file_name . '.' . $file->type));
    });
});
//************ CHANGE THIS ************

// Route::name('test.')->group(function() {
//     Route::get('/test', function() {
//         if(request()->routeIs('test.*'))
//     })->name('testRoute');
// });

//----------------------------------------------------------------

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',

// ])->group(function () {
//     Route::get('management', ManagementDetails::class)->name('management');
// });

//----------------------------------------------------------------
//RESOURCES
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('resources', KnowledgePanelIndex::class)->name('resources');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('resources/{id}', KnowledgePanelCategory::class);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('resources/{categoryID}/{resourceID}', Topic::class);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:Administrator',
])->group(function () {
    Route::get('/settings', SettingsMainPage::class)->name('settings');
});

//-----------------------------------------------------------------------
//PROCUREMENT
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('procurement', ProcurmentIndex::class)->name('procurement.index');
});

Route::get('/trigger-audit-summary', [AuditController::class, 'sendSummaryReport']);

Route::get('/get-audit-data/{auditId}', [AuditController::class, 'getAuditData'])->name('get-audit-data');

Route::post('/send-audit-report', [AuditController::class, 'sendAuditReport'])->name('send-audit-report');

Route::middleware(['auth'])
     ->get('/settings/audit-templates', function () {
         return view('settings.audit-templates');
     })
     ->name('settings.audit-templates');


Route::middleware(['auth'])->group(function () {
    Route::get('/settings/audit-fields', AuditFields::class)->name('settings.audit-fields');
});

Route::get('/boards_overview', ProjectsTaskCategoryOverview::class)
    ->name('boards.overview')
    ->middleware(['auth']);