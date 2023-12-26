<?php

namespace App\Http\Controllers;

use App\Models\FollowUp;
use App\Models\Lead;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function createUser(Request $request)
    {
        try {
            $id = $request->user_id;
            $validatedData = $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . ($id ? $id : 'id'),
                'status' => 'required|in:Active,InActive',
                'parent' => 'required|array',
                'password' => $id ? 'nullable|confirmed' : 'required|confirmed',
            ]);

            $status = $validatedData['status'] === 'InActive' ? 'Y' : 'N';
            $parents = implode(',', $validatedData['parent']);

            if ($id) {
                // Editing an existing user
                $user = User::findOrFail($id);
                $user->update([
                    'name' => $validatedData['name'],
                    'email' => $validatedData['email'],
                    'active' => $status,
                    'parent_id' => $parents,
                    'password' => $validatedData['password'] ? bcrypt($validatedData['password']) : $user->password,
                ]);
            } else {
                // Creating a new user
                $user = User::create([
                    'name' => $validatedData['name'],
                    'email' => $validatedData['email'],
                    'active' => $status,
                    'parent_id' => $parents,
                    'password' => bcrypt($validatedData['password']),
                ]);
            }

            return redirect()
                ->back()
                ->with('success', 'User ' . ($id ? 'updated' : 'created') . ' successfully.');
        } catch (ValidationException $e) {
            return redirect()
                ->back()
                ->withErrors($e->validator->errors())
                ->withInput();
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }

    public function assignRole(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'role_id' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $user = User::find($request->input('user_id'));
            $role = Role::find($request->input('role_id'));

            if ($user && $role) {
                $user->role_id = $role->id;
                $user->save();
                return redirect()
                    ->back()
                    ->with('success', 'Role assigned successfully.');
            }

            return redirect()
                ->back()
                ->with('error', 'User or Role not found.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function updateActive($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->active = $user->active === 'Y' ? 'N' : 'Y';
            $user->save();
            return redirect()
                ->back()
                ->with('success', 'successfully.');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function previousmonth_dashboard($date)
    {
        try {
            $yearmonth = date('m', strtotime($date));
            if ($yearmonth == '01') {
                $year = date('Y', strtotime($date . ' -1 year'));
            } else {
                $year = date('Y', strtotime($date));
            }
            $month = date('m', strtotime($date . ' -1 months'));
            $current_date = Carbon::createFromDate($year, $month)->toArray();
            $current_day = $current_date['day'];
            $current_month = $current_date['month'];
            $current_year = $current_date['year'];
            $currentmonth = date('F', strtotime($date . ' -1 months'));
            $followUp = FollowUp::where(['user_id' => auth()->id()])->get();

            $followUps = FollowUp::where(['user_id' => auth()->id()])
                ->where('date_time', '>=', Carbon::now()->toDateString())
                ->where(function ($query) {
                    $query->where('status', '!=', 'C')->orWhereNull('status');
                })
                ->whereMonth('date_time', $current_month)
                ->take(5)
                ->get();

            $showpinkbox = false;
            $daysinmonth = Carbon::createFromDate($year, $month)->daysInMonth;
            $leads = Lead::where('user_id', auth()->id())->get();
            return view('admin.home', compact('showpinkbox', 'year', 'followUp', 'followUps', 'currentmonth', 'leads', 'current_year', 'current_month', 'current_date', 'daysinmonth', 'current_day'));
        } catch (\Exception $th) {
            return redirect()
                ->back()
                ->with('error', $th->getMessage());
        }
    }

    public function nextmonth_dashboard($date)
    {
        try {
            $yearmonth = date('m', strtotime($date));
            if ($yearmonth == '12') {
                $year = date('Y', strtotime($date . ' +1 year'));
            } else {
                $year = date('Y', strtotime($date));
            }
            $month = date('m', strtotime($date . ' +1 months'));
            $current_date = Carbon::createFromDate($year, $month)->toArray();
            $current_day = $current_date['day'];
            $current_month = $current_date['month'];
            $current_year = $current_date['year'];
            $showpinkbox = false;
            $currentmonth = date('F', strtotime($date . ' +1 months'));
            $followUp = FollowUp::where(['user_id' => auth()->id()])->get();

            $followUps = FollowUp::where(['user_id' => auth()->id()])
                ->where('date_time', '>=', Carbon::now()->toDateString())
                ->where(function ($query) {
                    $query->where('status', '!=', 'C')->orWhereNull('status');
                })
                ->whereMonth('date_time', $current_month)
                ->take(5)
                ->get();

            $daysinmonth = Carbon::createFromDate($year, $month)->daysInMonth;
            $leads = Lead::where('user_id', auth()->id())->get();
            return view('admin.home', compact('showpinkbox', 'year', 'followUp', 'followUps', 'currentmonth', 'leads', 'current_year', 'current_month', 'current_date', 'daysinmonth', 'current_day'));
        } catch (\Exception $th) {
            return redirect()
                ->back()
                ->with('error', $th->getMessage());
        }
    }
    public function userEdit($id)
    {
        try {
            $user = User::findOrFail($id);
            $users = User::whereNotNull('parent_id')
                ->orderBy('created_at', 'desc')
                ->get();
            $createUsers = User::orderBy('created_at', 'desc')->get();

            $roles = Role::orderBy('created_at', 'desc')->get();

            return view('admin.userManagement', compact('user', 'createUsers', 'users', 'roles'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $validatedData = $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'status' => 'required|in:Active,InActive',
                'parent' => 'required|array',
                'password' => 'nullable|min:6|confirmed',
            ]);
            $user->update($validatedData);
            if ($request->has('password') && $request->input('password')) {
                $user->password = bcrypt($request->input('password'));
                $user->save();
            }

            return redirect()
                ->back()
                ->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
