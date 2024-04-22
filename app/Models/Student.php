<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'id';


    protected $fillable = [
        'id',
        'nisn',
        'gender', 'birthdate', 'class_room_id', 'user_id'
    ];

    public function activities()
    {
        return $this->belongsToMany(Activity::class, "student_activities", "student_id", "activity_id")->withPivot('is_paid_off');
    }

    public function activities_notRegistered()
    {
        return Activity::whereDoesntHave('students', function ($query) {
            $query->where('student_id', $this->id);
        });
    }



    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
