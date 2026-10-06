<?php

namespace App\Providers;

use App\Models\AboutUs;
use App\Models\AcademyProgram;
use App\Models\Center;
use App\Models\Faq;
use App\Models\Feedback;
use App\Models\FranchisePage;
use App\Models\Gallery;
use App\Models\PrivacyPolicy;
use App\Models\ProgramWriteup;
use App\Models\Setting;
use App\Models\Sliders;
use App\Models\Statistics;
use App\Models\TermsCondition;
use App\Models\GlobalPresence;
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
        try {
            //Counts
            $statistics = Statistics::first();
            View::share('statistics', $statistics);

            // Feedbacks
            $feedbacks = Feedback::where('status', '1')->get()->reverse();
            View::share('feedbacks', $feedbacks);

            // Centers
            $centers = Center::all();
            View::share('centers', $centers);

            // Settings
            $settings = Setting::first();
            View::share('settings', $settings);
            $privacyPolicy = PrivacyPolicy::where('status', 1)->latest('id')->first();
            View::share('privacyPolicy', $privacyPolicy);

            $termsCondition = TermsCondition::where('status', 1)->latest('id')->first();
            View::share('termsCondition', $termsCondition);

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

            // Program writeUp
            $academyProgramWriteup = ProgramWriteup::first();
            View::share('academyProgramWriteup', $academyProgramWriteup);

            // About us
            $about = AboutUs::first();
            View::share('about', $about);

            $franchise = FranchisePage::first();
            View::share('franchise', $franchise);
            $globalPresences = GlobalPresence::where('status', 1)
                ->orderBy('id', 'asc')
                ->get();

            View::share('globalPresences', $globalPresences);

            $faqs = Faq::where('is_active', 1)
                ->orderBy('id', 'asc')
                ->get();

            View::share('faqs', $faqs);
        } catch (\Throwable $e) {
            // Avoid failing CLI commands (such as artisan serve or migrate) if DB is temporarily unreachable
        }
    }
}
