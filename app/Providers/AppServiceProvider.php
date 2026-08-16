<?php

namespace App\Providers;

use App\Models\AboutUs;
use App\Models\AcademyProgram;
use App\Models\Center;
use App\Models\FranchisePage;
use App\Models\Gallery;
use App\Models\Setting;
use App\Models\Sliders;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    //    Centers
    $centers = Center::all();
    View::share('centers', $centers);

        // Settings
        $settings = Setting::first();
        View::share('settings', $settings);

        // Sliders
        $sliders = Sliders::all();
        View::share('sliders', $sliders);


        // Gallery images
        $dashboardImages = Gallery::where('is_dashboard', '1')
            ->where('media_type', '1')
            ->get();

        View::share('dashboardImages', $dashboardImages);

        // All Gallery Items
        $galleryItems = Gallery::where('is_active','1')->get();
        View::share('galleryItems', $galleryItems);
        
        // Academy Programs 
        $academyPrograms = AcademyProgram::where('is_active', '1')
            ->get();
            View::share('academyPrograms', $academyPrograms);
            
        // About us 
        $about = AboutUs::first();
        View::share('about', $about);


        $franchise = FranchisePage::first();
        View::share('franchise', $franchise);
        
        
    }
}
