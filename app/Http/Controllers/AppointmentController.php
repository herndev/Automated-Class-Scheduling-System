<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAppointmentRequest;
use App\Models\Appointment;
use App\Models\Course;
use App\Models\Schedule;
use Illuminate\Http\Request;
use DateTime;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAppointmentRequest $request)
    {
        // Check conflicts
        $has_conflict = 0;
        $courses = Appointment::where('user_id', $request->user_id)->get();
        $conflict_course = $courses;
        $course2 = Course::find($request->course_id);

        // Split the days string into an array of individual days
        $course_day = str_ireplace(' ', '', $course2->day);
        $selectedDays = explode(',', $course_day);
        foreach ($courses as $course) {
            // Check day conflict
            // Split the days string into an array of individual days
            $fcourse = Course::find($course->course_id);
            $course_day2 = str_ireplace(' ', '', $fcourse->day);
            $selectedDays2 = explode(',', $course_day2);

            // Convert times to DateTime objects
            $start1 = DateTime::createFromFormat('H:i', $course2->time_start);
            $end1 = DateTime::createFromFormat('H:i', $course2->time_end);
            $start2 = DateTime::createFromFormat('H:i', $fcourse->time_start);
            $end2 = DateTime::createFromFormat('H:i', $fcourse->time_end);

            foreach ($selectedDays as $day) {
                if(in_array($day, $selectedDays2)){
                    // Check for conflict
                    if (($start1 < $end2 && $end1 > $start2) || ($start2 < $end1 && $end2 > $start1)) {
                        $has_conflict = 1;
                        $conflict_course = $fcourse;
                        break;
                    }
                }
            }

            if($has_conflict){
                break;
            }
        }
        
        if($has_conflict){
            $course_name = $conflict_course->subject . " (" . $conflict_course->subjectCode . ")";
            $time = DateTime::createFromFormat('H:i', $conflict_course->time_start)->format('g:i A') . " - " . DateTime::createFromFormat('H:i', $conflict_course->time_end)->format('g:i A');
            return redirect()->back()->with('success', "Unsuccessful: Schedule is already occupied by $course_name $time.");
        }

        $app = new Appointment();
        $app->user_id = $request->user_id;
        $app->course_id = $request->course_id;
        // $app->subject_code = $request->subject_code;
        // $app->semester = $request->semester;
        $app->description = $request->description;
        $app->month_start = $request->month_start;
        $app->month_end = $request->month_end;
        $app->save();
        if($request->semester){
            return redirect(route("faculty.schedule"))->with('success', 'Created Successfully');
        }
        return redirect(route("faculty.schedule"))->with('success', 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $appointment = Appointment::find($id);

        if ($appointment) {
            $appointment->delete();
            Schedule::where('appointment_id', $id)->delete();
            return redirect()->back()->with('success', 'Appointment deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Appointment not found');
        }
    }

    public function destroy2($id)
    {
        $appointment = Schedule::find($id);

        if ($appointment) {
            $appointment->delete();
            return redirect()->back()->with('success', 'Schedule deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Schedule not found');
        }
    }
}
