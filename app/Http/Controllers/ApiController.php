<?php

namespace App\Http\Controllers;

use App\Models\Communication;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\Role;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'isSuccess' => true,
                'status' => 200,
                'message' => 'Login successful',
                'data' => [
                    'token' => $token,
                    'user' => $user,
                ],
            ]);
        } else {
            return response()->json(
                [
                    'isSuccess' => false,
                    'status' => 401,
                    'message' => 'The provided credentials are incorrect.',
                    'data' => null,
                ],
                401,
            );
        }
    }
    public function getLeads()
    {
        try {
            $userId = auth()->id();

            if (auth()->user()->role->meeting === 'Y') {
                $leads = Lead::with(['status', 'accreditation', 'standard', 'leadSource'])
                    ->whereRaw("FIND_IN_SET($userId, allocate_user)")
                    ->get();
            } else {
                $leads = collect();
            }
            $heading = ['Name', 'Email', 'Number', 'Contact Person', 'Scope Activity', 'Allocate User', 'Standard', 'Accreditation', 'Amount', 'Address', 'City', 'Status', 'Gst', 'Additional Options', 'Date', 'Lead Source', 'Lead Source Text', 'Comment'];
            return response()->json([
                'isSuccess' => true,
                'status' => 200,
                'message' => 'Leads and users retrieved successfully',
                'data' => [
                    'headers' => $heading,
                    'leads' => $leads,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'isSuccess' => false,
                    'status' => 500,
                    'message' => 'An error occurred while retrieving data' . $e->getMessage(),
                    'data' => null,
                ],
                500,
            );
        }
    }
    public function postLead(Request $request)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'lead_id' => 'required|exists:leads,id',
            'type' => 'required',
            'date_time' => 'required|date',
            'message' => 'required',
            'status' => 'required|in:o,i',
            'file' => 'nullable', // Adjust max file size as needed
        ]);

        try {
            // Extract the validated data as an array
            $data = $validatedData;

            // $files = $request->file('file');
            $fileNames = [];

            if ($request->file) {
                foreach ($request->file as $key => $value) {
                    $base64_image = $value['image']; // your base64 encoded
                    $imageName = Str::random(10) . '.' . 'png';
                    file_put_contents(public_path() . '/uploads/leads/' . $imageName, base64_decode($base64_image));
                    array_push($fileNames, asset('public/uploads/leads/' . $imageName));
                }
                $data['file'] = json_encode($fileNames);
            }
            // dd($data);
            // Create a new Communication record in the database
            Communication::create($data);

            return response()->json([
                'isSuccess' => true,
                'status' => 200,
                'message' => 'Lead added successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'isSuccess' => false,
                    'status' => 500,
                    'message' => 'An error occurred while retrieving data',
                    'data' => null,
                ],
                500,
            );
        }
    }
    public function get_logo()
    {
        try {
            $url = asset('public/admin/assets/img/logo.jpg');
            // dd($url);
            $array = [
                'message' => 'Logo',
                'status' => 200,
                'data' => $url,
            ];
            return response()->json($array, 200);
            // dd($domain);
        } catch (\Exception $e) {
            $array = [
                'message' => 'Api Error',
                'status' => 500,
                'data' => $e->getMessage(),
            ];
            return response()->json($array, 200);
        }
    }

    public function getCommunication($id)
    {
        try {
            $userId = auth()->id();
            $communications = Communication::where('lead_id', $id)
                ->get()
                ->toArray();
            $lead = Lead::find($id);

            return response()->json([
                'isSuccess' => true,
                'status' => 200,
                'message' => 'Communications and users retrieved successfully',
                'lead_name' => $lead->name,
                'data' => $communications,
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'isSuccess' => false,
                    'status' => 500,
                    'message' => 'An error occurred while retrieving data' . $e->getMessage(),
                    'data' => null,
                ],
                500,
            );
        }
    }
}