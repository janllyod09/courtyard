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
        'status',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function nonLostTimeAccidents(){
        return $this->hasMany(NonLostTimeAccidents::class, 'report_id');
    }

    public function nonFatalLostTimeAccidents(){
        return $this->hasMany(NonFatalLostTimeAccidents::class, 'report_id');
    }

    public function fatalLostTimeAccidents(){
        return $this->hasMany(FatalLostTimeAccidents::class, 'report_id');
    }

    public function monthlyDeseases(){
        return $this->hasMany(MonthlyDeseases::class, 'report_id');
    }
    

    public function explosivesConsumptions(){
        return $this->hasOne(ExplosivesConsumptions::class, 'report_id');
    }

    public function scopeSearch($query, $term){
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('users.company_name', 'like', $term);
        });
    }
}
