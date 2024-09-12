<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyDeseases extends Model
{
    use HasFactory;

    protected $table = 'monthly_deseases';

    protected $fillable = [
        'report_id',
        'desease',
        'no_of_cases',
        'response',
    ];

    public function cpMonthlyReports(){
        return $this->belongsTo(CpMonthlyReports::class);
    }
}
