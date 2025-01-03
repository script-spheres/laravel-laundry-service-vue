<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Banner;
use App\Models\Category;
use App\Models\City;
use App\Models\Faq;
use App\Models\Review;
use App\Models\Service;
use App\Models\ServiceItem;
use App\Models\Store;
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
    public function index(Request $request)
    {
        return Inertia::render('Welcome', [
            'banners' => Banner::all(),
            'services' => Service::all(),
            'faqItems' => Faq::all(),
            'testimonials' => Review::all(),
            'heroSection' => ServiceItem::all(),
            'about' => ServiceItem::all(),
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function services(Request $request): Response
    {
        return Inertia::render('Services', [
            'banners' => Banner::all(),
            'serviceItems' => ServiceItem::all(),
            'services' => Service::all(),
            'citiesOptions' => City::pluck('name', 'id'),
            'storesOptions' => Store::pluck('name', 'id'),
            'categories' => Category::all(),
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function about(Request $request): Response
    {
        return Inertia::render('About', [
            'banners' => Banner::all(),
            'services' => ServiceItem::all(),
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function contact(Request $request): Response
    {
        return Inertia::render('Contact', [
            'banners' => Banner::all(),
            'services' => ServiceItem::all(),
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

    public function cart()
    {
        return Inertia::render('Cart');
    }
}
