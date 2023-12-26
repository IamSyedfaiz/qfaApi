<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|unique:roles,name',
                'certificate_option' => $request->input('certificate') === 'Y' ? 'required|in:Q,H,I' : '',
            ]);
            $certificateOption = $validatedData['certificate_option'] ?? ($request->input('certificate') === 'Y' ? $request->input('certificate_option') : null);

            $role = Role::create([
                'name' => $validatedData['name'],
                'lead' => $request->has('lead') ? 'Y' : 'N',
                'user' => $request->has('user') ? 'Y' : 'N',
                'meeting' => $request->has('meeting') ? 'Y' : 'N',
                'proposal' => $request->has('proposal') ? 'Y' : 'N',
                'certificate' => $request->has('certificate') ? 'Y' : 'N',
                'account' => $request->has('account') ? 'Y' : 'N',
                'certificate_option' => $certificateOption,
            ]);

            return redirect()
                ->back()
                ->with('success', 'Role created successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function roleEdit(Request $request)
    {
        try {
            $roleId = $request->roleId;
            $role = Role::find($roleId);

            $validatedData = $request->validate([
                'name' => 'required|unique:roles,name,' . $role->id,
                'certificate_option' => $request->input('certificate') === 'Y' ? 'required|in:Q,H,I' : '',
            ]);

            $role->name = $validatedData['name'];
            $role->lead = $request->has('lead') ? 'Y' : 'N';
            $role->user = $request->has('user') ? 'Y' : 'N';
            $role->meeting = $request->has('meeting') ? 'Y' : 'N';
            $role->proposal = $request->has('proposal') ? 'Y' : 'N';
            $role->certificate = $request->has('certificate') ? 'Y' : 'N';
            $role->account = $request->has('account') ? 'Y' : 'N';
            $role->certificate_option = $request->input('certificate') === 'Y' ? $validatedData['certificate_option'] : $role->certificate_option;

            $role->save();

            return redirect()
                ->back()
                ->with('success', 'Role edited successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
}
