<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'address',
        'position',
        'qualification',
        // 'file_name',
        // 'file_path',
        'property_title_path',
        'hoa_due_certificate_path',
        'special_power_of_attorney_path',
        'property_title_name',
        'hoa_due_certificate_name',
        'special_power_of_attorney_name',
        'upload_file_path',
        'email',
        'password',
        'user_role',
        'status',
        'active_status',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'firstname',
        'middlename',
        'lastname',
        'address',
        'position',
        'qualification',
        'property_title_path',
        'hoa_due_certificate_path',
        'special_power_of_attorney_path',
        'property_title_name',
        'hoa_due_certificate_name',
        'special_power_of_attorney_name',
        'upload_file_path',
        'email',
        'password',
        'status',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    public function cpMonthlyReports()
    {
        return $this->hasMany(CpMonthlyReports::class);
    }

    public function quarterlyEmergencyDrillReports()
    {
        return $this->hasMany(QuarterlyEmergencyDrillReports::class);
    }

    public function permits()
    {
        return $this->hasMany(Permits::class);
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function scopeSearch($query, $term){
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('users.firstname', 'like', $term)
                ->orWhere('users.middlename', 'like', $term)
                ->orWhere('users.lastname', 'like', $term);
        });
    }

}
