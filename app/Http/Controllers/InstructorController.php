<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Instructor;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request):View
    {
        $inst = Instructor::all();
        return view('theem.pages.instructors',[
            'user'=>$request->user(),
            'instructors'=>$inst,

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $instructor = Instructor::findOrFail($id);
        return view('theem.pages.instructorProfile',compact('instructor'));
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
    public function destroy(string $id)
    {
        //
    }
}
