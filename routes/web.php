<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Mail\JobPosted;
use App\Models\Job;
use Illuminate\Support\Facades\Route;



// $jobs = [
//     [
//         "id" => 1,
//         "title" => "Director",
//         "salary" => "50000"
//     ],
//     [
//         "id" => 2,
//         "title" => "Programmer",
//         "salary" => "10000"
//     ],
//     [
//         "id" => 3,
//         "title" => "Teacher",
//         "salary" => "40000"
//     ]
// ];



Route::get('/', function () {
    return view('home');
});

Route::get("/register", [RegisteredUserController::class, "create"]);
Route::post("/register", [RegisteredUserController::class, "store"]);
Route::get("/login", [SessionController::class, "create"])->name("login");
Route::post("/login", [SessionController::class, "store"]);
Route::post("/logout", [SessionController::class, "destroy"]);


// Route::get('/jobs', function () use($jobs) {
//     return view('jobs', $jobs);
// });

Route::controller(JobController::class)->group(function() {

    Route::get('/jobs', 'index');
    Route::get("jobs/create", 'create')->middleware('auth');
    Route::post("/jobs", 'store');
    // Route::get("/jobs/{job:slug}") -> if unique identifier is some other column other than id or we want to make other than ID
    Route::get('/jobs/{job}', 'show');
    // Route::get('/jobs/{job}/edit', 'edit')->middleware(['auth', 'can:edit-job, job']);
    Route::get('/jobs/{job}/edit', 'edit')
        ->middleware('auth')
        // ->can("edit-job", 'job');with gates
        ->can('edit', 'job'); //with policy


    Route::patch("/jobs/{job}", 'update');

    Route::delete("/jobs/{job}", 'destroy');

});

Route::get("test", function() {
     
    // return new JobPosted();
});

// Apply mkddleware on route resource
// Route::resource('jobs', JobController::class)->only(['index', 'show']);
// Route::resource('jobs', JobController::class)->except(['index', 'show'])->middleware('auth);

// Route::resource("jobs", JobController::class, [
//     // 'only' => []
//     // "except" => ['edit']
// ])

Route::view("/contact", 'contact');
// Route::get('/contact', function () {
//     return view('contact');
// });
