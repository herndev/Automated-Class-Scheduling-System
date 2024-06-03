<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAppointmentRequest;
use App\Models\Appointment;
use App\Models\Schedule;
use Illuminate\Http\Request;

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
