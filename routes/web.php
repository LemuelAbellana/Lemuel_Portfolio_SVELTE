<?php

use App\Http\Controllers\ContactController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Inertia::render('Portfolio/Home', [
        'profile' => [
            'name' => 'Lemuel G. Abellana',
            'title' => 'Full-Stack Developer',
            'tagline' => 'Building elegant digital systems for communities and organizations.',
            'email' => 'labellana_23000002074@uic.edu.ph',
            'phone' => '0951-257-5802',
            'location' => 'Davao City, Philippines',
            'linkedin' => 'https://www.linkedin.com',
            'github' => 'https://github.com',
            'photo' => null,
        ],
    ]);
});

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
