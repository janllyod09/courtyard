<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CpMonthlyReports extends Model
{
    use HasFactory;

    protected $table = 'cp_monthly_reports';

    protected $fillable = [
        'user_id',
        'month',
        'date_encoded',
        'man_hours',
        'male_workers',
        'female_workers',
        'service_contractors',
        'non_lost_time_accident',
        'non_fatal_lost_time_accident',
        'fatal_lost_time_accident',
        'nflt_days_lost',
        'flt_days_lost',
        'minutes',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function nonLostTimeAccidents(){
        return $this->hasMany(NonLostTimeAccidents::class);
    }

    public function nonFatalLostTimeAccidents(){
        return $this->hasMany(NonFatalLostTimeAccidents::class);
    }

    public function fatalLostTimeAccidents(){
        return $this->hasMany(FatalLostTimeAccidents::class);
    }
}
