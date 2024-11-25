<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIngredientRequest;
use App\Http\Requests\UpdateIngredientRequest;
use App\Http\Resources\IngredientResource;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Unit;
use App\Services\IngredientService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, IngredientService $ingredientService)
    {
        $ingredients = $ingredientService->getIngredients();

        return Inertia::render('Admin/Ingredient/IngredientIndex', [
            'ingredients' => IngredientResource::collection($ingredients),
            'unitsOptions' => Unit::pluck('actual_name', 'id'),
            'filters' => $request->get('filter'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIngredientRequest $request, IngredientService $ingredientService)
    {
        $ingredientService->create($request);

        return redirect()->route('admin.ingredients.index')->with(['message' => 'Created successfully']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Ingredient/IngredientForm', [
            'unitsOptions' => Unit::pluck('actual_name', 'id'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ingredient $ingredient)
    {
        return Inertia::render('Admin/Ingredient/IngredientForm', [
            'ingredient' => IngredientResource::make($ingredient)->resolve(),
            'unitsOptions' => Unit::pluck('actual_name', 'id'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ingredient $ingredient)
    {
        return Inertia::render('Admin/Ingredient/IngredientForm', [
            'ingredient' => IngredientResource::make($ingredient)->resolve(),
            'unitsOptions' => Unit::pluck('actual_name', 'id'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIngredientRequest $request, Ingredient $ingredient, IngredientService $ingredientService)
    {
        $ingredientService->update($ingredient, $request);

        return redirect()->route('admin.ingredients.index')->with(['message' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ingredient $ingredient, IngredientService $ingredientService)
    {
        $ingredientService->delete($ingredient);

        return redirect()->route('admin.ingredients.index')->with(['message' => 'Deleted successfully']);
    }
}
