<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\LeadCollection;
use App\Http\Resources\LeadResource;
use App\Models\Communication;
use App\Models\Lead;
use Illuminate\Support\Str;

class LeadController extends Controller
{
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
            
            return new LeadCollection($leads);
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
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'lead_id' => 'required|exists:leads,id',
            'type' => 'required',
            'date_time' => 'required|date',
            'message' => 'required',
            'status' => 'required|in:o,i',
            'file' => 'nullable', 
        ]);

        try {
            $data = $validatedData;
            $fileNames = [];

            if ($request->file) {
                foreach ($request->file as $key => $value) {
                    $base64_image = $value['image']; 
                    $imageName = Str::random(10) . '.' . 'png';
                    file_put_contents(public_path() . '/uploads/leads/' . $imageName, base64_decode($base64_image));
                    array_push($fileNames, asset('public/uploads/leads/' . $imageName));
                }
                $data['file'] = json_encode($fileNames);
            }
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
            $array = [
                'message' => 'Logo',
                'status' => 200,
                'data' => $url,
            ];
            return response()->json($array, 200);
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