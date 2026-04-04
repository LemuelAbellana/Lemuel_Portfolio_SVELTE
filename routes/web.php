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
            'email' => 'lemuelabellana84@gmail.com',
            'phone' => '09512575802',
            'location' => 'Molave Street, Barangay Santo Nino, Tugbok District, Davao City',
            'linkedin' => 'https://www.linkedin.com/in/lemuel-g-abellana-7123a7369/',
            'github' => 'https://github.com/LemuelAbellana',
            'twitter' => 'https://x.com',
            'instagram' => 'https://www.instagram.com/sen_gomz/',
            'whatsapp' => 'https://wa.me/639512575802',
            'facebook' => 'https://www.facebook.com/sen.gomz',
            'photo' => null,
        ],
    ]);
});

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/download-cv', function () {
    $cvPath = public_path('resume.pdf');

    abort_unless(file_exists($cvPath), 404);

    return response()->download($cvPath, 'Lemuel_Abellana_CV.pdf');
})->name('cv.download');
 
Route::get('/projects', function () {
    return Inertia::render('Portfolio/Projects', [
        'profile' => [
            'name' => 'Lemuel G. Abellana',
            'title' => 'BSIT Student | Full-Stack Developer',
            'tagline' => 'Building practical web and mobile systems with AI integration for education and community impact.',
            'email' => 'lemuelabellana84@gmail.com',
            'phone' => '09512575802',
            'location' => 'Molave Street, Barangay Santo Nino, Tugbok District, Davao City',
            'linkedin' => 'https://www.linkedin.com/in/lemuel-g-abellana-7123a7369/',
            'github' => 'https://github.com/LemuelAbellana',
            'twitter' => 'https://x.com',
            'instagram' => 'https://www.instagram.com/sen_gomz/',
            'whatsapp' => 'https://wa.me/639512575802',
            'facebook' => 'https://www.facebook.com/sen.gomz',
            'photo' => null,
        ],
    ]);
})->name('projects');

Route::get('/leadership', function () {
    return Inertia::render('Portfolio/Leadership', [
        'profile' => [
            'name' => 'Lemuel G. Abellana',
            'title' => 'BSIT Student | Full-Stack Developer',
            'tagline' => 'Building practical web and mobile systems with AI integration for education and community impact.',
            'email' => 'lemuelabellana84@gmail.com',
            'phone' => '09512575802',
            'location' => 'Molave Street, Barangay Santo Nino, Tugbok District, Davao City',
            'linkedin' => 'https://www.linkedin.com/in/lemuel-g-abellana-7123a7369/',
            'github' => 'https://github.com/LemuelAbellana',
            'twitter' => 'https://x.com',
            'instagram' => 'https://www.instagram.com/sen_gomz/',
            'whatsapp' => 'https://wa.me/639512575802',
            'facebook' => 'https://www.facebook.com/sen.gomz',
            'photo' => null,
        ],
    ]);
})->name('leadership');

Route::get('/achievements-gallery', function () {
    return Inertia::render('Portfolio/AchievementsGallery');
})->name('achievements.gallery');
