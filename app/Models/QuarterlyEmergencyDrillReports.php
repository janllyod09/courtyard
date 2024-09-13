<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuarterlyEmergencyDrillReports extends Model
{
    use HasFactory;

    protected $table = 'quarterly_emergency_drill_reports';

    protected $fillable = [
        'user_id',
        'year',
        'quarter',
        'date_uploaded',
        'type_of_emergency_drill',
        'report',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
