<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clients extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'city',
        'province',
        'country',
        'fye',
        'deadline',
        'next_report_required',
        'next_audit',
        'engagement_type',
        'manager',
        'analyst',
        'fye_id',
        'report_status_id',
        'report_notes',
        'due_date_report',
        'audit_progress_id',
        'planned_audit_month_id',
        'rating_agency_id',
        'rating_analyst_id',
        'size',
        'sector',
        'region',
        'engagement_type_id',
        'state',
        'bee_level_id',
        'date_cert_issued',
        'current_certificate_expiry',
    ];

    public static function codes()
    {
        return collect(
            [
                ['month' => 1, 'label' => 'January'],
                ['month' => 2, 'label' => 'February'],
                ['month' => 3, 'label' => 'March'],
                ['month' => 4, 'label' => 'April'],
                ['month' => 5, 'label' => 'May'],
                ['month' => 6, 'label' => 'June'],
                ['month' => 7, 'label' => 'July'],
                ['month' => 8, 'label' => 'August'],
                ['month' => 9, 'label' => 'September'],
                ['month' => 10, 'label' => 'October'],
                ['month' => 11, 'label' => 'November'],
                ['month' => 12, 'label' => 'December'],

            ]
        );
    }

    // protected $dates = [
    //     'fye',
    //     'deadline',
    //     'date_cert_issued',
    //     'current_certificate_expiry',
    //     'next_report_required',
    //     'planned_audit_date',
    //     'date_engaged',
    //     'next_audit',
    // ];

    public function getFye()
    {
        return $this->belongsTo(Month::class, 'fye_id');
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'client_id');
    }

    public function contactsMorph()
    {
        return $this->morphMany(Contact::class, 'contactable');
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class, 'client_id')->get();
    }

    public function consulations()
    {
        return $this->hasMany(Consultation::class, 'client_id')->get();
    }

    public function files()
    {
        // return $this->hasMany(File::class, 'client_id');
        return $this->morphMany(File::class, 'fileable');
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager', 'id')->first();
    }

    public function analyst()
    {
        return $this->belongsTo(User::class, 'analyst', 'id')->first();
    }

    public function getAnalyst()
    {
        return $this->belongsTo(User::class, 'analyst');
    }

    public function size()
    {
        return $this->belongsTo(Size::class, 'size', 'id')->first();
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class, 'sector', 'id')->first();
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region', 'id')->first();
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state', 'id')->first();
    }

    public function erpCertificate()
    {
        return $this->hasOne(File::class, 'id', 'certificate_erp_key');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function boards()
    {
        return $this->hasMany(Board::class, 'client_id');
    }

    public function boardsMorph()
    {
        return $this->morphMany(Board::class, 'boardable');
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'activityable');
    }

    public function audits()
    {
        return $this->hasMany(Audit::class, 'client_id');
    }

    public function engagementType()
    {
        return $this->belongsTo(EngagementType::class, 'engagement_type_id');
    }

    public function reportStatus()
    {
        return $this->belongsTo(ReportStatus::class, 'report_status_id');
    }

    public function ratingAgency()
    {
        return $this->belongsTo(RatingAgency::class, 'rating_agency_id');
    }

    public function beeLevel()
    {
        return $this->belongsTo(BeeLevel::class, 'bee_level_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'client_id');
    }

    public function procurementLogs()
    {
        return $this->hasMany(ProcurementLog::class);
    }

    public function plannedAuditMonth()
    {
        return $this->belongsTo(Month::class, 'planned_audit_month_id');
    }
    public function ratingAnalyst()
    {
        return $this->belongsTo(\App\Models\User::class, 'rating_analyst_id');
    }

    public function client()
    {
        return $this->belongsTo(\App\Models\Clients::class, 'client_id');
    }
}
