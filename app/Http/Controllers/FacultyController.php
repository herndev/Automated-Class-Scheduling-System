<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFacultyRequest;
use App\Models\Appointment;
use App\Models\Course;
use App\Models\Faculty;
use App\Models\Rooms;
use App\Models\Schedule;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_unless(Gate::allows('super_access'), 403);
        $lists = Faculty::where('name', 'LIKE', "%" . $request->search . "%")->orderBy("created_at", "desc")->get();
        $users = User::where('email_verified_at', '!=', null)
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.user_id', '=', 'roles.id')
            ->where('roles.title', '=', 'Instructor')
            ->get();
        return view('faculties.index', compact('lists', 'users'));
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
    public function store(CreateFacultyRequest $request)
    {
        if ($request->validated()) {
            $user = User::where('id', $request->user_id)->first();
            $room = new Faculty();
            $room->name = $user->name;
            $room->idNo = $request->idNo;
            $room->email = $request->email;
            $room->contact = $request->contact;
            $room->user_id = $request->user_id;
            $room->save();

            return redirect(route("faculty.index"))->with('success', 'Created Successfully');
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
        $fac = Faculty::where('id', $request->id)->first();
        if (isset($fac)) {
            $fac->name = $request->name;
            $fac->idNo = $request->idNo;
            $fac->email = $request->email;
            $fac->contact = $request->contact;
            $fac->update();

            return redirect()->back()->with('success', 'Updated Successfully');
        }
    }

    public function statusUpdate(Request $request)
    {
        $up = Faculty::where('id', $request->id)->first();
        $up->status = $request->status;
        $up->update();

        return redirect()->back()->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Faculty::where('id', $id)->first();
        $delete->delete();

        return redirect()->back()->with('success', 'Deleted Successfully');
    }

    public function schedule(Request $request)
    {
        // dd($request->search);
        abort_unless(Gate::allows('super_access'), 403);
        $lists = Faculty::where('name', 'LIKE', "%" . $request->search . "%")->orderBy("created_at", "desc")->get();
        $events = [];
        $appointments = [];
        if ($request->search) {
            $appointments = Appointment::with(['user'])
                ->join('courses', 'appointments.course_id', '=', 'courses.id')
                ->where('appointments.user_id', 'LIKE', "%" . $request->search . "%")->get();
            // dd($appointments);
        }
        for ($day = 1; $day <= 31; $day++) {
            // Loop through each appointment
            foreach ($appointments as $appointment) {
                // Split the days string into an array of individual days
                $selectedDays = explode(',', $appointment->day);

                // Loop through each selected day
                foreach ($selectedDays as $selectedDay) {
                    // Extract start date and time from the appointment
                    $startDateTime = $appointment->month_start . '-' . $day . ' ' . $appointment->time_start . ':00';

                    // Extract end date and time from the appointment
                    $endDateTime = $appointment->month_end . '-' . $day . ' ' . $appointment->time_end . ':00';

                    // Check if the appointment falls on the selected day
                    if (date('l', strtotime($startDateTime)) == $selectedDay) {
                        // Add the event to the events array
                        $events[] = [
                            'title' => $appointment->user_id,
                            'start' => $startDateTime,
                            'end' => $endDateTime,
                            'description' => 'html: <b>' . $appointment->description . '</b>',
                        ];
                    }
                }
            }
        }
        $users = User::select('users.id as id', 'users.name as name')->where('email_verified_at', '!=', null)
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.title', '=', 'Instructor')
            ->get();

            // dd($users);
        $rooms = Rooms::all();
        $courses = Course::get();
        return view('faculties.schedule.index', compact('lists', 'events', 'users', 'rooms', 'courses'));
    }

    public function studentSchedule(Request $request)
    {
        // dd($request->search);
        abort_unless(Gate::allows('super_access'), 403);
        $events = [];
        $appointments = [];
        if ($request->search) {
            $appointments = Schedule::join('appointments', 'schedules.appointment_id', '=', 'appointments.id')
            ->join('courses', 'appointments.course_id', '=', 'courses.id')
            ->where('schedules.user_id', '=', $request->search)->get();
        }
        for ($day = 1; $day <= 31; $day++) {
            // Loop through each appointment
            foreach ($appointments as $appointment) {
                // Split the days string into an array of individual days
                $selectedDays = explode(',', $appointment->day);

                // Loop through each selected day
                foreach ($selectedDays as $selectedDay) {
                    // Extract start date and time from the appointment
                    $startDateTime = $appointment->month_start . '-' . $day . ' ' . $appointment->time_start . ':00';

                    // Extract end date and time from the appointment
                    $endDateTime = $appointment->month_end . '-' . $day . ' ' . $appointment->time_end . ':00';

                    // Check if the appointment falls on the selected day
                    if (date('l', strtotime($startDateTime)) == $selectedDay) {
                        // Add the event to the events array
                        $events[] = [
                            'title' => $appointment->user_id,
                            'start' => $startDateTime,
                            'end' => $endDateTime,
                            'description' => 'html: <b>' . $appointment->description . '</b>',
                        ];
                    }
                }
            }
        }
        $users = User::select('users.id as id', 'users.name as name')->where('email_verified_at', '!=', null)
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.title', '=', 'Student')
            ->get();
        $subjects = Appointment::join('courses', 'appointments.course_id', '=', 'courses.id')->get();
        return view('student.schedule.index', compact('events', 'users', 'subjects'));
    }

    public function viewSchedule()
    {
        $events = [];
        $schedules = Schedule::select('schedules.user_id as studentID', 'courses.subject as subject', 'courses.day as day', 'appointments.month_start as m_start', 'appointments.month_end as m_end', 'courses.time_start as start', 'courses.time_end as finish', 'courses.subjectCode as code', 'rooms.name as roomName', 'rooms.description as roomType', 'users.name as studentName')
            ->where('schedules.user_id', Auth::user()->id)
            ->join('appointments', 'schedules.appointment_id', '=', 'appointments.id')
            ->join('users', 'appointments.user_id', '=', 'users.id')
            ->join('courses', 'appointments.course_id', 'courses.id')
            ->join('rooms', 'courses.room_id', '=', 'rooms.id')
            ->get();
        for ($day = 1; $day <= 31; $day++) {
            // Loop through each schedule
            foreach ($schedules as $schedule) {
                // Split the days string into an array of individual days
                $selectedDays = explode(',', $schedule->day);

                // Loop through each selected day
                foreach ($selectedDays as $selectedDay) {
                    // Extract start date and time from the schedule
                    $startDateTime = $schedule->m_start . '-' . $day . ' ' . $schedule->start . ':00';

                    // Extract end date and time from the schedule
                    $endDateTime = $schedule->m_end . '-' . $day . ' ' . $schedule->end . ':00';

                    // Check if the schedule falls on the selected day
                    if (date('l', strtotime($startDateTime)) == $selectedDay) {
                        // Add the event to the events array
                        $events[] = [
                            'title' => $schedule->subject,
                            'start' => $startDateTime,
                            'end' => $endDateTime,
                        ];
                    }
                }
            }
        }
        $units = Schedule::select('courses.unit as unit')->join('appointments', 'schedules.appointment_id', '=', 'appointments.id')
            ->join('courses', 'appointments.course_id', '=', 'courses.id')
            ->where('schedules.user_id', Auth::user()->id)
            ->get();
        $counts = 0;
        foreach ($units as $unit) {
            // Count the characters in the unit string
            $counts = $counts + $unit->unit;
        }
        foreach ($schedules as $schedule) {
            $events[] = [
                'title' => $schedule->code . ' (' . $schedule->roomName . ' ' . $schedule->roomType . ')',
                'start' => $schedule->start,
                'end' => $schedule->finish,
                'description' => 'html: <b>' . $schedule->instructorName . '</b>',
            ];
        }

        return view('student.view.index', compact('events', 'schedules', 'counts'));
    }
}
