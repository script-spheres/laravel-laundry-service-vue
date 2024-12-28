<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFaqRequest;
use App\Http\Requests\UpdateFaqRequest;
use App\Http\Resources\FaqResource;
use App\Models\Faq;
use App\Services\FaqService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, FaqService $faqService)
    {
        $faqs = $faqService->getFaqs();

        return Inertia::render('Faq/FaqIndex', [
            'faqs' => FaqResource::collection($faqs),
            'filters' => $request->get('filter'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Faq/FaqForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFaqRequest $request, FaqService $faqService)
    {
        $faqService->create($request);

        return redirect()->route('faqs.index')->with(['message' => 'Created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Faq $faq)
    {
        return Inertia::render('Faq/FaqForm', [
            'faq' => FaqResource::make($faq)->resolve()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq)
    {
        return Inertia::render('Faq/FaqForm', [
            'faq' => FaqResource::make($faq)->resolve()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFaqRequest $request, Faq $faq, FaqService $faqService)
    {
        $faqService->update($faq, $request);

        return redirect()->route('faqs.index')->with(['message' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq, FaqService $faqService)
    {
        $faqService->delete($faq);

        return redirect()->route('faqs.index')->with(['message' => 'Deleted successfully']);
    }
}
