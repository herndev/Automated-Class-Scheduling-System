<?php

namespace App\Http\Controllers;

use App\Events\NewPostAdded;
use App\Models\Appointment;
use App\Models\Course;
use App\Models\Post;
use App\Models\Schedule;
use App\Models\Station;
use App\Models\StationUser;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // abort_unless(Gate::allows('admin_access'), 403);
        $events = [];

        $appointments = Appointment::select(
            'courses.subject as subject',
            'courses.subjectCode as code',
            'courses.time_start as start',
            'courses.time_end as end',
            'rooms.name as room',
            'courses.day as day',
            'appointments.month_start as m_start',
            'appointments.month_end as m_end',
            'courses.subject as subject',
            'courses.subjectCode as s_code'
        )->with(['user'])->where('user_id', Auth::user()->id)
            ->join('courses', 'appointments.course_id', '=', 'courses.id')
            ->join('rooms', 'courses.room_id', '=', 'rooms.id')
            // ->where('appointments.semester', 'LIKE', "%" . $request->semester . "%")
            ->get();

        for ($day = 1; $day <= 31; $day++) {
            // Loop through each appointment
            foreach ($appointments as $appointment) {
                // Split the days string into an array of individual days
                $selectedDays = explode(',', $appointment->day);

                // Loop through each selected day
                foreach ($selectedDays as $selectedDay) {
                    // Extract start date and time from the appointment
                    $startDateTime = $appointment->m_start . '-' . $day . ' ' . $appointment->start . ':00';

                    // Extract end date and time from the appointment
                    $endDateTime = $appointment->m_end . '-' . $day . ' ' . $appointment->end . ':00';

                    // Check if the appointment falls on the selected day
                    if (date('l', strtotime($startDateTime)) == $selectedDay) {
                        // Add the event to the events array
                        $events[] = [
                            'title' => $appointment->subject,
                            'start' => $startDateTime,
                            'end' => $endDateTime,
                        ];
                    }
                }
            }
        }
        $instructorCount = count($appointments);
        $units = Schedule::select('courses.unit as unit')->join('appointments', 'schedules.appointment_id', '=', 'appointments.id')
            ->join('courses', 'appointments.course_id', '=', 'courses.id')
            ->where('schedules.user_id', Auth::user()->id)
            ->get();
        $counts = 0;
        foreach ($units as $unit) {
            // Count the characters in the unit string
            $counts = $counts + $unit->unit;
        }

        $roomsScheds = Course::join('rooms', 'courses.room_id', '=', 'rooms.id')->get();

        $students = Schedule::join('users', 'schedules.user_id', '=', 'users.id')->get();

        $instructors = Appointment::with(['user'])->get();
        // dd($instructors);

        return view('dashboard', compact('events', 'instructorCount', 'appointments', 'counts', 'roomsScheds', 'students', 'instructors'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $events = [];

        $appointments = Appointment::with(['user'])->where('user_id', Auth::user()->id)
            ->join('courses', 'appointments.course_id', '=', 'courses.id')
            ->join('rooms', 'appointments.room_id', '=', 'rooms.id')
            ->get();

        foreach ($appointments as $appointment) {
            $events[] = [
                'title' => $appointment->user->name . ' (' . $appointment->comments . ')',
                'start' => $appointment->start_time,
                'end' => $appointment->finish_time,
                'description' => $appointment->comments,
            ];
        }
        $instructorCount = count($appointments);
        // $instructorScheds = Appointment::where('user_id', Auth::user()->id)->get();
        $schedules = [];
        if ($request->semester) {
            $schedules = Schedule::join('appointments', 'schedules.appointment_id', '=', 'appointments.id')
                ->join('users', 'schedules.user_id', '=', 'users.id')
                ->join('courses', 'appointments.course_id', '=', 'courses.id')
                ->where('schedules.user_id', '=', Auth::user()->id)
                ->where('schedules.semester', 'LIKE', "%" . $request->semester . "%")
                ->get();
        } else if ($request->year) {
            $schedules = Schedule::join('appointments', 'schedules.appointment_id', '=', 'appointments.id')
                ->join('users', 'schedules.user_id', '=', 'users.id')
                ->join('courses', 'appointments.course_id', '=', 'courses.id')
                ->where('schedules.user_id', '=', Auth::user()->id)
                ->where('courses.year', 'LIKE', "%" . $request->year . "%")
                ->get();
        } else if ($request->semester && $request->year) {
            $schedules = Schedule::join('appointments', 'schedules.appointment_id', '=', 'appointments.id')
                ->join('users', 'schedules.user_id', '=', 'users.id')
                ->join('courses', 'appointments.course_id', '=', 'courses.id')
                ->where('schedules.user_id', '=', Auth::user()->id)
                ->where('schedules.semester', 'LIKE', "%" . $request->semester . "%")
                ->where('courses.year', 'LIKE', "%" . $request->year . "%")
                ->get();
        }

        return view('dashboard', compact('events', 'instructorCount', 'appointments', 'schedules'));
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
        //
    }

    public function notifyStations($id)
    {
        //Send Push Notification

        $SERVER_API_KEY = "AAAARQtY8YQ:APA91bHtaTTvc4HeRWKrC_nD_9SQSd5uwXLSFEczWGowG2OpApGYDmC7otLMlG6dnDoNtl8DOJTzT2VIrYjzTxbFe59XmJtQmz6qcxs7Of1SAsdr24n2vkEe8VPquLyMPnN5uGkArb6G";
        $userkeys = StationUser::where('station_id', $id)
            ->join('users', 'users.id', '=', 'station_user.user_id')
            ->where('device_key', '!=', '')
            // ->where('id', '=', Auth::user()->id)
            ->get();
        if (isset($userkeys)) {
            foreach ($userkeys as $value) {
                // if ($value->device_key) {
                $data = [
                    "registration_ids" => [$value->device_key],
                    "notification" => [
                        "title" => "New alerts",
                        "body" => "Update",
                    ]
                ];
                $dataString = json_encode($data);

                $headers = [
                    'Authorization: key=' . $SERVER_API_KEY,
                    'Content-Type: application/json',
                ];

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

                curl_exec($ch);


                return redirect()->back()->with('success', 'Station Alarmed!');
                // } else {
                //     return redirect()->back()->with('success', 'Station is not active');
                // }
                // return redirect()->back()->with('success', 'Station is not active');
            }
            return redirect()->back()->with('error', 'Station is not active');
        }
    }

    public function test()
    {
        return response()->json('test', 200);
    }
}
