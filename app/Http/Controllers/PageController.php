<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Banner;
use App\Models\ServiceItem;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
class PageController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Welcome', [
            'banners' => Banner::all(),
            'serviceTypes' => ServiceItem::all(),
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function services(Request $request): Response
    {
        return Inertia::render('Services', [
            'banners' => Banner::all(),
            'serviceTypes' => ServiceItem::all(),
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function about(Request $request): Response
    {
        return Inertia::render('About', [
            'banners' => Banner::all(),
            'serviceTypes' => ServiceItem::all(),
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function contact(Request $request): Response
    {
        return Inertia::render('Contact', [
            'banners' => Banner::all(),
            'serviceTypes' => ServiceItem::all(),
        ]);
    }

    public function privacyPolicy()
    {
        return Inertia::render('PrivacyPolicy');
    }

    public function termsAndConditions()
    {
        return Inertia::render('TermsAndConditions');
    }
}
