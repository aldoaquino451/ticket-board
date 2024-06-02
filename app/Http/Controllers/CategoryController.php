<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Stringable;
use Illuminate\Support\Str;


class CategoryController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $categories = Category::orderBY('created_at', 'DESC')->get();

    return Inertia::render('Categories/Index', [
      'categories' => $categories,
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StoreCategoryRequest $request)
  {
    $validated_data = $request->validated();

    Category::create([
      'name' => $validated_data['name'],
      'slug' => Str::slug($validated_data['name']),
    ]);

    return redirect()->back();
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Request $request, Category $category)
  {
    $category->delete();

    return redirect()->route('dashboard.categories.index');
  }
}
