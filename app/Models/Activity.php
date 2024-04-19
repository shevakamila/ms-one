<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'amount', 'due_date'];

    public function students()
    {
        return $this->belongsToMany(Student::class, "student_activities", "activity_id", "student_id")->withPivot('is_paid_off');
    }
    public function studentActivity($studentId, $activityId)
    {
        return $this->whereHas('students', function ($query) use ($studentId) {
            $query->where('student_id', $studentId);
        })->get();
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }



    public function getCountPayment($studentId, $activityId)
    {
        return $this->payments()->where('student_id', $studentId)->where('activity_id', $activityId)->where('status', 'paid')->count();
    }

    public function getTotalAmountPayment($studentId, $activityId)
    {
        return $this->payments()->where('student_id', $studentId)->where('activity_id', $activityId)->where('status', 'paid')->sum('amount');
    }

    public function getOutstandingAmountPayment($studentId, $activityId)
    {
        $totalPaid = $this->getTotalAmountPayment($studentId, $activityId);

        $activityAmount = $this->find($activityId)->amount;
        $outstandingPayment = $activityAmount - $totalPaid;

        return $outstandingPayment;
    }
}
