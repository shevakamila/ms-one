<?php


namespace App\Http\Repositories\Admin;

use App\Models\Activity;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ActivityRepository
{
    public function index()
    {
        return Activity::latest()->get();
    }


    public function find(Activity $activity)
    {
        if (!$activity) {
            return redirect()->route('notFound');
        }

        return $activity;
    }

    public function create(Request $request)
    {
        $activity = new Activity();
        $activity->name = $request->name;
        $activity->description = $request->description;
        $activity->amount = $request->amount;
        $activity->due_date = $request->due_date;
        $activity->save();

        return $activity;
    }

    public function delete(Activity $activity)
    {
        if (!$activity) {
            abort(Response::HTTP_NOT_FOUND, 'Kegiatan tidak ditemukan');
        }

        return $activity->delete();
    }

    public function update(Request $request, Activity $activity)
    {
        $activity->name = $request->name;
        $activity->description = $request->description;
        $activity->amount = $request->amount;
        $activity->due_date = $request->due_date;
        $activity->save();

        return $activity;
    }
}
