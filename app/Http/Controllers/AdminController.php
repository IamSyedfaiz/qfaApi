<?php

namespace App\Http\Controllers;

use App\Models\Accreditation;
use App\Models\ApiLead;
use App\Models\Communication;
use App\Models\FollowUp;
use App\Models\Lead;
use App\Models\Role;
use App\Models\Standard;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Status;
use App\Models\LeadSource;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        try {
            $user = auth()->user();

            if ($user->active == 'Y') {
                Auth::logout();
                return redirect()
                    ->back()
                    ->with('danger', 'Your Account has been Suspended');
            } else {
                $current_date = Carbon::now()->toArray();
                $current_day = $current_date['day'];
                $current_month = $current_date['month'];
                $currentmonth = date('F');
                $showpinkbox = true;

                $current_year = $current_date['year'];
                $followUp = FollowUp::where(['user_id' => auth()->id()])->get();

                $followUps = FollowUp::where(['user_id' => auth()->id()])
                    ->where('date_time', '>=', Carbon::now()->toDateString())
                    ->where(function ($query) {
                        $query->where('status', '!=', 'C')->orWhereNull('status');
                    })
                    ->whereMonth('date_time', $current_month)
                    ->take(5)
                    ->get();
                // dd($followUps);
                $daysinmonth = Carbon::now()->daysInMonth;

                $leads = Lead::where('user_id', auth()->id())->get();

                return view('admin.home', compact('showpinkbox', 'followUp', 'followUps', 'leads', 'currentmonth', 'current_month', 'current_year', 'current_date', 'daysinmonth', 'current_day'));
            }
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function userManagement()
    {
        try {
            $user = auth()->user();

            if ($user->active == 'Y') {
                Auth::logout();
                return redirect()
                    ->back()
                    ->with('danger', 'Your Account has been Suspended');
            } else {
                $users = User::whereNotNull('parent_id')
                    ->orderBy('created_at', 'desc')
                    ->get();
                $createUsers = User::orderBy('created_at', 'desc')->get();

                $roles = Role::orderBy('created_at', 'desc')->get();
                return view('admin.userManagement', compact('users', 'roles', 'createUsers'));
            }
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function addLeads()
    {
        try {
            $users = User::whereNotNull('parent_id')->get();
            $standards = Standard::where('active', 'Y')->get();
            $accreditations = Accreditation::where('active', 'Y')->get();
            $statuses = Status::all();
            $leadSources = LeadSource::all();
            return view('admin.addLeads', compact('users', 'standards', 'accreditations', 'statuses', 'leadSources'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function allLeads()
    {
        try {
            $user = auth()->user();

            if ($user->active == 'Y') {
                Auth::logout();
                return redirect()
                    ->back()
                    ->with('danger', 'Your Account has been Suspended');
            } else {
                $userId = auth()->user()->id;
                if (auth()->user()->name == 'Admin') {
                    $leads = Lead::orderBy('created_at', 'desc')->get();
                } else {
                    $leads = Lead::orderBy('created_at', 'desc')
                        ->where('user_id', $userId)
                        ->orWhereRaw("FIND_IN_SET('$userId', allocate_user) > 0")
                        ->get();
                }
                return view('admin.allLeads', compact('leads'));
            }
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function allApiLeads()
    {
        try {
            $user = auth()->user();

            if ($user->active == 'Y') {
                Auth::logout();
                return redirect()
                    ->back()
                    ->with('danger', 'Your Account has been Suspended');
            } else {
                $userId = auth()->user()->id;
                if (auth()->user()->name == 'Admin') {
                    $leads = ApiLead::all();
                } else {
                    $leads = ApiLead::orderBy('created_at', 'desc')
                        ->where('user_id', $userId)
                        ->orWhereRaw("FIND_IN_SET('$userId', allocate_user) > 0")
                        ->get();
                }
                return view('admin.allApiLeads', compact('leads'));
            }
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function leadView($id)
    {
        try {
            $lead = Lead::find($id);
            $attributes = $lead->getAttributes();
            $excludeAttributes = ['id', 'created_at', 'updated_at', 'user_id', 'standard_id', 'accreditation_id', 'lead_source_id', 'status_id', 'gst', 'additional_options'];
            $filteredAttributes = array_diff_key($attributes, array_flip($excludeAttributes));
            $users = User::whereNotNull('parent_id')
                ->orderBy('created_at', 'desc')
                ->get();
            $communications = Communication::where('lead_id', $id)
                ->orderBy('created_at', 'desc')
                ->get();
            $standards = Standard::where('active', 'Y')->get();
            $accreditations = Accreditation::where('active', 'Y')->get();
            $statuses = Status::all();
            $leadSources = LeadSource::all();
            $followUps = FollowUp::where('lead_id', $id)->get();
            return view('admin.leadView', compact('lead', 'users', 'communications', 'standards', 'accreditations', 'statuses', 'leadSources', 'followUps', 'filteredAttributes'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function communicationView($id)
    {
        try {
            $communication = Communication::find($id);

            return view('admin.communicationView', compact('communication'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function communicationLogs($id)
    {
        try {
            $communications = Communication::where('lead_id', $id)
                ->orderBy('created_at', 'desc')
                ->get();
            return view('admin.communicationLogs', compact('communications'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
}