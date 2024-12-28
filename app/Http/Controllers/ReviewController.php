<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Order;
use App\Models\Review;
use App\Models\User;
use App\Services\ReviewService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ReviewService $reviewService)
    {
        $reviews = $reviewService->getReviews();

        return Inertia::render('Review/ReviewIndex', [
            'reviews' => ReviewResource::collection($reviews),
            'filters' => $request->get('filter'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest $request, ReviewService $reviewService)
    {
        $reviewService->create($request);

        return redirect()->route('reviews.index')->with(['message' => 'Created successfully']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Review/ReviewForm', [
            'usersOptions' => User::pluck('name', 'id')->all(),
            'ordersOptions' => Order::pluck('order_display_id', 'id')->all(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        return Inertia::render('Review/ReviewForm', [
            'review' => ReviewResource::make($review)->resolve()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        return Inertia::render('Review/ReviewForm', [
            'review' => ReviewResource::make($review)->resolve()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReviewRequest $request, Review $review, ReviewService $reviewService)
    {
        $reviewService->update($review, $request);

        return redirect()->route('reviews.index')->with(['message' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review, ReviewService $reviewService)
    {
        $reviewService->delete($review);

        return redirect()->route('reviews.index')->with(['message' => 'Deleted successfully']);
    }
}
