<?php

namespace App\Http\Controllers;

use App\Models\Specialization;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $specializations = Specialization::where('type', 'specialization')->get();
        $programming_languages = Specialization::where('type', 'programming_language')->get();

        $query = JobApplication::query();

        if ($request->has('specialization') && $request->specialization != '') {
            $query->where('specialization', $request->specialization);
        }

        if ($request->has('programming_language') && $request->programming_language != '') {
            $query->where('course', $request->programming_language);
        }

        $jobApplications = $query->with(['student', 'company'])->get();

        return view('home', compact('specializations', 'programming_languages', 'jobApplications'));
    }
}