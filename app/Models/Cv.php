<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CvCertification;

class Cv extends Model
{
    use HasFactory;

    protected $table = 'cv';

    protected $fillable = [
        'user_id',
        'template_id',
        'title',
    ];

    public function certifications()
    {
        return $this->hasMany(CvCertification::class, 'cv_id');
    }

    public function education()
    {
        return $this->hasMany(CvEducation::class, 'cv_id');
    }

    public function languages()
    {
        return $this->hasMany(CvLanguage::class, 'cv_id');
    }

    public function personalInformation()
    {
        return $this->hasOne(CvPersonalInformation::class, 'cv_id');
    }

    public function projects()
    {
        return $this->hasMany(CvProject::class, 'cv_id');
    }

    public function skills()
    {
        return $this->hasMany(CvSkill::class, 'cv_id');
    }

    public function workExperience()
    {
        return $this->hasMany(CvWorkExperience::class, 'cv_id');
    }

}
