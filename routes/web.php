<?php

use App\Http\Controllers\ContactController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Inertia::render('Portfolio/Home', [
        'profile' => [
            'name' => 'Lemuel G. Abellana',
            'title' => 'BSIT Student | Full-Stack Developer',
            'tagline' => 'Building practical web and mobile systems with AI integration for education and community impact.',
            'email' => 'labellana_23000002074@uic.edu.ph',
            'phone' => '09512575802',
            'location' => 'Molave Street, Barangay Santo Nino, Tugbok District, Davao City',
            'linkedin' => 'https://www.linkedin.com',
            'github' => 'https://github.com',
            'photo' => null,
        ],
    ]);
});

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
