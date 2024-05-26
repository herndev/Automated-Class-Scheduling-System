<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy("id", "desc")->paginate();

        return view('users.index', compact('users'));
    }

    public function store(CreateUserRequest $request)
    {
        if ($request->validated()) {
            $user = User::create($request->all());
            $user->save();
        }
    }

    public function updateToken($token)
    {
        if (Auth::user()) {
            $user = User::where('id', Auth::user()->id)->first();
            $user->device_key = $token;
            $user->save();

            return response()->json([
                'message' => 'Device Key Updated'
            ], 200);
        } else {
            return response()->json([
                'message' => 402
            ], 200);
        }
    }

    public function updateStatus($id)
    {
        $user = User::where('id', $id)->first();
        if ($user->status == null || $user->status == "inactive") {
            $user->status = 'active';
            $user->save();
        } else {
            $user->status = "inactive";
            $user->save();
        }
        return redirect()->back()->with('success', 'Status Updated!');
    }

    public function removeUser($id)
    {
        $user = User::where('id', $id)->first();
        $user->delete();
        return redirect()->back()->with('success', 'User Deleted!');
    }

    public function destroy()
    {
        $user = User::where('id', Auth::user()->id);
        $user->delete();
    }

    public function uploadProfile(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();
        if ($request->hasFile('selfie')) {
            $imageNameSelfie = time() . '.' . $request->selfie->getClientOriginalExtension();
            $request->selfie->move(public_path('uploads/selfies'), $imageNameSelfie);
            $path = env('APP_URL').'/uploads/selfies/'.$imageNameSelfie;

            $user->avatar = $path;
            $user->save();

            return response()->json(['success' => true, 'selfieImage' => $path]);
        } else {
            return response()->json(['success' => false, 'message' => 'Image not found.']);
        }
    }

    public function approve($id)
    {
        $user = User::where('id', $id)->first();
        $user->verification_status = 'Verified';
        $user->save();

        return redirect()->back()->with('success', 'User Approved!');
    }

    public function decline($id)
    {
        $user = User::where('id', $id)->first();
        $user->verification_status = 'Rejected';
        $user->save();

        return redirect()->back()->with('success', 'User Declined!');
    }

    public function block($id)
    {
        $user = User::where('id', $id)->first();
        $user->block = '1';
        $user->save();

        return redirect()->back()->with('success', 'User Block!');
    }

    public function unblock($id)
    {
        $user = User::where('id', $id)->first();
        $user->block = '0';
        $user->save();

        return redirect()->back()->with('success', 'User Unblock!');
    }
}
