<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FatalLostTimeAccidents extends Model
{
    use HasFactory;

    protected $table = 'fatal_lost_time_accidents';

    protected $fillable = [
        'report_id',
        'name',
        'gender',
        'position',
        'date_of_accident_illness',
        'time',
        'location',
        'has_physical_injury',
        'has_property_damage',
        'is_service_contractor',
        'company',
        'cause_of_accident_illness',
        'is_unsafe_acts',
        'is_unsafe_acts_description',
        'is_unsafe_conditions',
        'is_unsafe_conditions_description',
        'kind_of_accident',
        'type_of_injury',
        'part_of_body_injured',
        'treatment',
    ];

    public function cpMonthlyReports(){
        return $this->belongsTo(CpMonthlyReports::class);
    }
}
