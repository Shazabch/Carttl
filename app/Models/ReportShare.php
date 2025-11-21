<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportShare extends Model
{
    protected $table = 'report_shares';
    protected $keyType = 'string';
    public $incrementing = false; // UUID
    protected $fillable = ['id', 'report_id', 'token', 'expires_at'];

    // Optional relation to report (not enforced in DB)
    public function report()
    {
        return $this->belongsTo(VehicleInspectionReport::class, 'report_id');
    }
}
