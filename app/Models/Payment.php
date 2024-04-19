<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'id';

    protected  $fillable = [
        'id',
        'user_id',
        'student_id',
        'activity_id',
        'status',
        'snap_token',
        'amount',
        'payment_time'
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public static function getCountPayment($studentId, $activityId)
    // {
    //     return self::where('student_id', $studentId)
    //         ->where('activity_id', $activityId)
    //         ->where('status', 'paid')
    //         ->count();
    // }

    // public static function getTotalAmountPayment($studentId, $activityId)
    // {
    //     return self::where('student_id', $studentId)
    //         ->where('activity_id', $activityId)
    //         ->where('status', 'paid')
    //         ->sum('amount');
    // }

    // public static function getOutstandingAmountPayment($studentId, $activityId)
    // {
    //     $totalPaid = self::getTotalAmountPayment($studentId, $activityId);
    //     $activityAmount = Activity::find($activityId)->amount;
    //     return max(0, $activityAmount - $totalPaid);
    // }
}
