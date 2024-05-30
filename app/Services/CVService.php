<?php

namespace App\Services;

use App\Models\Cv;
use App\Models\CvPersonalInformation;
use DB;
use HTMLPurifier;
use HTMLPurifier_Config;

class CVService
{
    //
    public function saveCVData($data, $user)
    {

        DB::beginTransaction();

        try {

            // Sanitize input data using HTMLPurifier
            $config = HTMLPurifier_Config::createDefault();
            $purifier = new HTMLPurifier($config);

            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $subKey => $subValue) {
                        if (is_string($subValue)) {
                            $data[$key][$subKey] = $purifier->purify($subValue);
                        }
                    }
                } else {
                    if (is_string($value)) {
                        $data[$key] = $purifier->purify($value);
                    }
                }
            }

            // Save CV
            $cv = Cv::updateOrCreate(
                ['id' => $data['cv']['id'], 'user_id' => $user->id],
                [
                    'template_id' => $data['cv']['template_id'],
                    'title' => $data['cv']['title'],
                ]
            );

            // Save Certifications
            if (isset($data['certifications'])) {
                $cv->certifications()->delete();
                foreach ($data['certifications'] as $certification) {
                    $cv->certifications()->create([
                        'certification_name' => $certification['certification_name'],
                        'issuing_organization' => $certification['issuing_organization'],
                        'date_earned' => $certification['date_earned'],
                    ]);
                }
            }

            // Save Education
            if (isset($data['education'])) {
                $cv->education()->delete();
                foreach ($data['education'] as $education) {
                    $cv->education()->create([
                        'institution' => $education['institution'],
                        'degree' => $education['degree'],
                        'field_of_study' => $education['field_of_study'],
                        'start_date' => $education['start_date'],
                        'end_date' => $education['end_date'],
                    ]);
                }
            }

            // Save Languages
            if (isset($data['languages'])) {
                $cv->languages()->delete();
                foreach ($data['languages'] as $language) {
                    $cv->languages()->create([
                        'language' => $language['language'],
                        'proficiency' => $language['proficiency'],
                    ]);
                }
            }

            // Save Personal Information
            if (isset($data['personal_information'])) {
                CvPersonalInformation::updateOrCreate(
                    ['cv_id' => $cv->id],
                    [
                        'full_name' => $data['personal_information']['full_name'],
                        'date_of_birth' => $data['personal_information']['date_of_birth'],
                        'address' => $data['personal_information']['address'],
                        'phone' => $data['personal_information']['phone'],
                        'email' => $data['personal_information']['email'],
                        'summary' => $data['personal_information']['summary'],
                    ]
                );
            }

            // Save Projects
            if (isset($data['projects'])) {
                $cv->projects()->delete();
                foreach ($data['projects'] as $project) {
                    $cv->projects()->create([
                        'project_name' => $project['project_name'],
                        'description' => $project['description'],
                        'start_date' => $project['start_date'],
                        'end_date' => $project['end_date'],
                    ]);
                }
            }

            // Save Skills
            if (isset($data['skills'])) {
                $cv->skills()->delete();
                foreach ($data['skills'] as $skill) {
                    $cv->skills()->create([
                        'skill_name' => $skill['skill_name'],
                        'skill_level' => $skill['skill_level'],
                    ]);
                }
            }

            // Save Work Experience
            if (isset($data['work_experience'])) {
                $cv->workExperience()->delete();
                foreach ($data['work_experience'] as $workExperience) {
                    $cv->workExperience()->create([
                        'company' => $workExperience['company'],
                        'job_title' => $workExperience['job_title'],
                        'start_date' => $workExperience['start_date'],
                        'end_date' => $workExperience['end_date'],
                        'description' => $workExperience['description'],
                    ]);
                }
            }
     
            DB::commit();
            
            return $this->getCVData($cv->id, $user);

        } catch (Exception $ex) {
            DB::rollback();
            \Log::error($ex->getMessage());
            return false;
        }

    }

    public function getCVData($id, $user)
    {

        try {

            $cv = Cv::with([
                'certifications',
                'education',
                'languages',
                'personalInformation',
                'projects',
                'skills',
                'workExperience',
            ])->where('id', '=', $id)->where('user_id', '=', $user->id)->get();

            return $cv;

        } catch (Exception $ex) {
            return false;
        }

    }

}
