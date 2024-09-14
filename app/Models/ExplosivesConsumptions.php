<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExplosivesConsumptions extends Model
{
    use HasFactory;

    protected $table = 'explosives_consumptions';

    protected $fillable = [
        'report_id',
        'blasting_contractor',
        'dynamite',
        'detonating_cord',
        'non_elec_blasting_caps',
        'elec_blasting_caps',
        'fuse_lighter',
        'connectors',
        'ammonium_nitrate',
        'shotshell_primer',
        'primer',
        'emulsion',
        'others',
    ];

    public function cpMonthlyReports()
    {
        return $this->belongsTo(CpMonthlyReports::class, 'report_id');
    }
}
