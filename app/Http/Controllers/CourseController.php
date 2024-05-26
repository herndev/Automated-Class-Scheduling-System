<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Appointment;
use App\Models\Course;
use App\Models\Rooms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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
