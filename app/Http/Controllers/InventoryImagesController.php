<?php

namespace App\Http\Controllers;

use App\Models\inventory_images;
use Illuminate\Http\Request;

class InventoryImagesController extends Controller
{
       /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(inventory_images $inventory_images)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(inventory_images $inventory_images)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, inventory_images $inventory_images)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(inventory_images $inventory_images)
    {
        //
    }
}