<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Appointment;
use App\Models\Course;
use App\Models\Rooms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use DateTime;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_unless(Gate::allows('super_access'), 403);
        $lists = Course::join('rooms', 'courses.room_id', '=', 'rooms.id')->where('subject', 'LIKE', "%" . $request->search . "%")->get();
        $rooms = Rooms::get();
        $appointments = Appointment::join('courses', 'appointments.course_id', '=', 'courses.id')
            ->join('users', 'appointments.user_id', '=', 'users.id')
            ->join('rooms', 'courses.room_id', '=', 'rooms.id')->get();
        return view('course.index', compact('lists', 'rooms', 'appointments'));
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
    public function store(CreateCourseRequest $request)
    {
        if ($request->validated()) {
            $has_conflict = 0;
            $courses = Course::get();
            $conflict_course = $courses;

            // Split the days string into an array of individual days
            $course_day = str_ireplace(' ', '', $request->day);
            $selectedDays = explode(',', $course_day);
            foreach ($courses as $course) {
                if($course->room_id == $request->room_id){
                    // Check day conflict
                    // Split the days string into an array of individual days
                    $course_day2 = str_ireplace(' ', '', $course->day);
                    $selectedDays2 = explode(',', $course_day2);

                    // Convert times to DateTime objects
                    $start1 = DateTime::createFromFormat('H:i', $request->time_start);
                    $end1 = DateTime::createFromFormat('H:i', $request->time_end);
                    $start2 = DateTime::createFromFormat('H:i', $course->time_start);
                    $end2 = DateTime::createFromFormat('H:i', $course->time_end);

                    foreach ($selectedDays as $day) {
                        if(in_array($day, $selectedDays2)){
                            // Check for conflict
                            if (($start1 < $end2 && $end1 > $start2) || ($start2 < $end1 && $end2 > $start1)) {
                                $has_conflict = 1;
                                $conflict_course = $course;
                                break;
                            }
                        }
                    }
                }

                if($has_conflict){
                    break;
                }
            }
            
            if($has_conflict){
                $course_name = $conflict_course->subject . " (" . $conflict_course->subjectCode . ")";
                $room = Rooms::find($conflict_course->room_id)->name;
                $time = DateTime::createFromFormat('H:i', $conflict_course->time_start)->format('g:i A') . " - " . DateTime::createFromFormat('H:i', $conflict_course->time_end)->format('g:i A');
                return redirect()->back()->with('success', "Unsuccessful: $room is already occupied by $course_name $time.");
            }

            $room = Course::create($request->all());
            $room->save();

            return redirect(route("course.index"))->with('success', 'Created Successfully');
        }
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
    public function update(Request $request)
    {
        $cor = Course::where('id', $request->id)->first();
        if (isset($cor)) {
            $cor->type = $request->type;
            $cor->subject = $request->subject;
            $cor->subjectCode = $request->subjectCode;
            // $cor->room_id = $request->room_id;
            $cor->description = $request->description;
            $cor->status = $request->status;
            $cor->unit = $request->unit;
            // $cor->day = $request->day;
            $cor->year = $request->year;
            $cor->semester = $request->semester;
            $cor->time_start = $request->time_start;
            $cor->time_end = $request->time_end;
            $cor->block = $request->block;
            $cor->update();

            return redirect()->back()->with('success', 'Updated Successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
