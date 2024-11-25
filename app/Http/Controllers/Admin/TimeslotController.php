<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTimeslotRequest;
use App\Http\Requests\Admin\UpdateTimeslotRequest;
use App\Http\Resources\Admin\TimeslotResource;
use App\Models\Timeslot;
use App\Services\TimeslotService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TimeslotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, TimeslotService $timeslotService)
    {
        $timeslots = $timeslotService->getTimeslots();

        return Inertia::render('Admin/Timeslot/TimeslotIndex', [
            'timeslots' => TimeslotResource::collection($timeslots),
            'filters' => $request->get('filter'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Timeslot/TimeslotForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTimeslotRequest $request, TimeslotService $timeslotService)
    {
        $timeslotService->create($request);

        return redirect()->route('admin.timeslots.index')->with(['message' => 'Created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Timeslot $timeslot)
    {
        return Inertia::render('Admin/Timeslot/TimeslotForm', [
            'timeslot' => TimeslotResource::make($timeslot)->resolve()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Timeslot $timeslot)
    {
        return Inertia::render('Admin/Timeslot/TimeslotForm', [
            'timeslot' => TimeslotResource::make($timeslot)->resolve()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTimeslotRequest $request, Timeslot $timeslot, TimeslotService $timeslotService)
    {
        $timeslotService->update($timeslot, $request);

        return redirect()->route('admin.timeslots.index')->with(['message' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Timeslot $timeslot, TimeslotService $timeslotService)
    {
        $timeslotService->delete($timeslot);

        return redirect()->route('admin.timeslots.index')->with(['message' => 'Deleted successfully']);
    }
}
