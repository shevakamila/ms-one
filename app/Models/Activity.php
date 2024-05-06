<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'image',
        'is_active',
        'name',
        'description',
        'amount',
        'due_date'
    ];

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
    public function getCountPaymentFailed($studentId, $activityId)
    {
        return $this->payments()->where('student_id', $studentId)->where('activity_id', $activityId)->where('status', 'failed')->count();
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
    public function calculateAmountDue($studentId, $activityId)
    {
        // Temukan kegiatan berdasarkan ID
        $activity = Activity::find($activityId);

        if (!$activity) {
            return null; // Kegiatan tidak ditemukan
        }

        // Dapatkan jumlah yang sudah dibayarkan oleh siswa untuk kegiatan ini
        $totalPaid = $activity->students()->where('student_id', $studentId)->first()->pivot->paid_amount;

        // Hitung jumlah yang masih harus dibayarkan
        $outstandingPayment = $activity->amount - $totalPaid;

        return max(0, $outstandingPayment); // Pastikan jumlahnya tidak negatif
    }
}
