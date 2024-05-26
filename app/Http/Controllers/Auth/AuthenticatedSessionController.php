<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Station;
use App\Models\StationUser;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();
        $user = User::where('id', Auth::user()->id)->first();
        $user->last_login_at = Carbon::now();
        $user->save();

        // $stationUser = StationUser::where('user_id', $user->id)->first();

        // $station = Station::where('id', $stationUser->station_id)->first();
        // $station->active = 1;
        // $station->save();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();
        $user->device_key = null;
        $user->save();

        // $stationUser = StationUser::where('user_id', Auth::user()->id)->first();

        // $station = Station::where('id', $stationUser->station_id)->first();
        // $station->active = 0;
        // $station->save();
        
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
