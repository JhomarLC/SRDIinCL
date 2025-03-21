<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FarmersProfileController extends Controller
{
    public function validateStep(Request $request)
    {
        $step = $request->input('step');

        if ($step == 'personal-info') {
            $rules = [
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:50',
            'nickname' => 'nullable|string|max:100',
            'phone_number' => 'required|string|regex:/^[0-9]{10,15}$/',
            'birth_date' => 'required|date|before:today',
            'age_group' => 'required|string',
            'is_pwd' => 'required|boolean',
            'disability' => 'nullable|required_if:is_pwd,1|string',
            'is_indigenous' => 'required|boolean',
            'tribe_name' => 'nullable|required_if:is_indigenous,1|string',
            'gender' => 'required|string',
            'civil_status' => 'required|string',
            'religion' => 'required|string',
            'province' => 'required|string',
            'municipality' => 'required|string',
            'barangay' => 'required|string',
            'zip_code' => 'required|digits_between:4,6',
            'house_number_sitio_purok' => 'nullable|string',
            'primary_sector' => 'required|in:Farmer/Seed Grower,Extension Worker,Researcher,Educator,Student,Policy Maker,Media,Industry Player,Others',
            'years_in_farming' => 'required|integer|min:0|max:100',
            'farmer_association' => 'required|string',
            'education_level' => 'required|in:Elementary,High School,Vocational,College Degree,Master’s Degree,Doctorate Degree,Undergraduate,Others',
            'farm_role' => 'required|in:Farm Owner,Relative of Farm Owner',
            'rsbsa_number' => 'required|string|max:50',
            ];
            $messages = [
                'tribe_name.required_if' => 'Please enter tribe name if the person is indigenous.',
                'disability.required_if' => 'Please select type of disability if the person is PWD.',
                'zip_code.number' => 'The ZIP code must be a valid number.',
            ];

       }

       $validated = $request->validate($rules, $messages);

       return response()->json(['success' => true]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.farmers-profile.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.farmers-profile.create');
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
    public function destroy(string $id)
    {
        //
    }
}
