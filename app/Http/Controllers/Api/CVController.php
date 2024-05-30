<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CVService;
use Illuminate\Http\Request;

class CVController extends Controller
{
    //

    private $cvService;

    public function __construct(CVService $cvService)
    {
        $this->cvService = $cvService;
    }

    public function saveCV(Request $request)
    {
        
        $data = $request->validate([
            'cv.id' => 'integer',
            'cv.template_id' => 'required|integer',
            'cv.title' => 'nullable|string|max:255',
            'certifications.*.certification_name' => 'string|max:255',
            'certifications.*.issuing_organization' => 'nullable|string|max:255',
            'certifications.*.date_earned' => 'nullable|date',
            'education.*.institution' => 'string|max:255',
            'education.*.degree' => 'nullable|string|max:255',
            'education.*.field_of_study' => 'nullable|string|max:255',
            'education.*.start_date' => 'nullable|date',
            'education.*.end_date' => 'nullable|date',
            'languages.*.language' => 'string|max:200',
            'languages.*.proficiency' => 'integer',
            'personal_information.full_name' => 'string|max:255',
            'personal_information.date_of_birth' => 'nullable|date',
            'personal_information.address' => 'nullable|string|max:255',
            'personal_information.phone' => 'nullable|string|max:20',
            'personal_information.email' => 'nullable|string|email|max:255',
            'personal_information.summary' => 'nullable|string',
            'projects.*.project_name' => 'string|max:255',
            'projects.*.description' => 'nullable|string',
            'projects.*.start_date' => 'nullable|date',
            'projects.*.end_date' => 'nullable|date',
            'skills.*.skill_name' => 'string|max:255',
            'skills.*.skill_level' => 'nullable|string|max:50',
            'work_experience.*.company' => 'string|max:255',
            'work_experience.*.job_title' => 'string|max:255',
            'work_experience.*.start_date' => 'nullable|date',
            'work_experience.*.end_date' => 'nullable|date',
            'work_experience.*.description' => 'nullable|string',
        ]);

        $response = $this->cvService->saveCVData($data, auth()->user());

        if($response){
            return response()->json(['message' => 'CV data saved successfully!', 'data'=> $response]);
        }else{
            return response()->json(['message' => 'CV data saved successfully!'],500);
        }

    }

    public function getCv($id)
    {   
        $response = $this->cvService->getCVData($id, auth()->user());
        
        if($response){
            return response()->json($response);
        }else{
            return response()->json(['message' => 'CV data saved successfully!'],500);
        }

    }
}
