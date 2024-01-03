<?php

namespace App\Http\Controllers;

use App\Models\Accreditation;
use App\Models\Communication;
use App\Models\FollowUp;
use App\Models\Lead;
use App\Models\Standard;
use App\Models\User;
use App\Models\Status;
use App\Models\LeadSource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class LeadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'nullable',
                'email' => 'nullable|email',
                'number' => 'nullable|min:10',
                'allocate_user' => 'nullable|array',
                'standard_id' => 'nullable',
                'accreditation_id' => 'nullable',
                'address' => 'nullable',
                'city' => 'nullable',
                'status_id' => 'nullable',
                'date' => 'nullable|date',
                'lead_source_id' => 'nullable',
                'amount' => 'nullable',
                'gst' => 'nullable|in:w,o',
                'additional_options' => 'nullable|in:i,e',
                'lead_source_text' => 'nullable',
                'scope_activity' => 'nullable',
                'contact_person' => 'nullable',
                'comment' => 'nullable',
            ]);
            // Get the authenticated user's ID
            $user_id = auth()->id();
            $allocateUser = implode(',', $validatedData['allocate_user']);
            $gst = $request->input('gst');
            $additionalOptions = $request->input('additional_options');
            $amount = $request->input('amount');
            if ($gst === 'w' && $additionalOptions === 'i') {
                // Calculate the amount with inclusive GST
                $amountWithGST = $amount;
            } elseif ($gst === 'w' && $additionalOptions === 'e') {
                // Calculate the amount with exclusive GST (18% added)
                $amountWithGST = $amount * 1.18;
            } else {
                // No GST or other cases, amount remains the same
                $amountWithGST = $amount;
            }
            $validatedData['amount'] = $amountWithGST;

            $lead = new Lead($validatedData);
            $lead->user_id = $user_id;
            $lead->allocate_user = $allocateUser;

            $lead->save();
            if ($lead->status == 'w') {
                $userEmail = [];
                $userIds = explode(',', $allocateUser);
                foreach ($userIds as $userId) {
                    $user = User::find($userId);
                    if ($user) {
                        $userEmail[] = $user->email;
                    }
                }

                // dd($userEmail);

                $data['lead_name'] = $lead->name;
                $data['msg'] = $lead->comment;

                foreach ($userEmail as $recipient) {
                    Mail::send('email.email_lead', @$data, function ($msg) use ($recipient) {
                        $msg->from(env('MAIL_FROM_ADDRESS'));
                        $msg->to($recipient, env('MAIL_FROM_NAME'));
                        $msg->subject('RICL Intervention Form');
                    });
                }
            }

            return redirect()
                ->back()
                ->with('success', 'Lead created successfully.');
        } catch (ValidationException $e) {
            // Validation errors occurred
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
    public function update(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'nullable',
                'email' => 'nullable|email',
                'number' => 'nullable|min:10',
                'allocate_user' => 'nullable',
                'standard_id' => 'nullable',
                'accreditation_id' => 'nullable',
                'address' => 'nullable',
                'city' => 'nullable',
                'status_id' => 'nullable',
                'date' => 'nullable|date',
                'amount' => 'nullable',
                'gst' => 'nullable|in:w,o',
                'additional_options' => 'nullable|in:i,e',
                'lead_source_id' => 'nullable',
                'lead_source_text' => 'nullable',
                'scope_activity' => 'nullable',
                'contact_person' => 'nullable',
                'comment' => 'nullable',
            ]);
            $lead = Lead::find($request->input('lead_id'));
            if ($lead) {
                $allocateUser = implode(',', $validatedData['allocate_user']);

                // Update the lead attributes based on the validated data
                $lead->update(array_merge($validatedData, ['allocate_user' => $allocateUser]));

                if ($lead->status == 'w') {
                    $userEmail = [];
                    $userIds = explode(',', $allocateUser);
                    foreach ($userIds as $userId) {
                        $user = User::find($userId);
                        if ($user) {
                            $userEmail[] = $user->email;
                        }
                    }

                    // dd($userEmail);

                    $data['lead_name'] = $lead->name;
                    $data['msg'] = $lead->comment;

                    foreach ($userEmail as $recipient) {
                        Mail::send('email.email_lead', @$data, function ($msg) use ($recipient) {
                            $msg->from(env('MAIL_FROM_ADDRESS'));
                            $msg->to($recipient, env('MAIL_FROM_NAME'));
                            $msg->subject('RICL Intervention Form');
                        });
                    }
                }

                return redirect()
                    ->back()
                    ->with('success', 'Lead updated successfully.');
            } else {
                return redirect()
                    ->back()
                    ->with('error', 'Lead not found.');
            }
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function storeCommunicationCall(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'lead_id' => 'required|exists:leads,id',
                'type' => 'required',
                'date_time' => 'required|date',
                'message' => 'required',
                'status' => 'required|in:o,i',
            ]);

            Communication::create($validatedData);

            return redirect()
                ->back()
                ->with('success', 'Communication saved successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function storeCommunicationEmail(Request $request)
    {
        try {
            $currentDateTimeIST = Carbon::now('Asia/Kolkata');
            $request->merge(['date_time' => $currentDateTimeIST]);

            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'lead_id' => 'required|exists:leads,id',
                'type' => 'required',
                'date_time' => 'required|date',
                'message' => 'required',
                'subject' => 'required',
            ]);
            $files = $request->file('file');
            $fileNames = [];

            if ($files && is_array($files)) {
                foreach ($files as $file) {
                    $extension = $file->getClientOriginalExtension();
                    $originalFileNameWithExtension = $file->getClientOriginalName();
                    $fileNameWithoutExtension = pathinfo($originalFileNameWithExtension, PATHINFO_FILENAME);

                    // Replacing spaces with underscores and adding a timestamp to the filename
                    $filename = str_replace(' ', '_', $fileNameWithoutExtension) . '_' . time() . '.' . $extension;

                    // Determine the storage directory path
                    $storagePath = public_path('assets/files');

                    // Move the uploaded file to the storage directory
                    $file->move($storagePath, $filename);

                    // Store the filename in the array
                    $fileNames[] = $filename;
                }

                // Serialize the array before saving
                $validatedData['file'] = implode(',', $fileNames);
            }

            $lead = Lead::find($request->lead_id);
            $users = User::all();

            $leadUsers = explode(',', $lead->allocate_user);

            $matchingUserEmails = [];

            foreach ($leadUsers as $leadUserId) {
                foreach ($users as $user) {
                    if ($user->id == $leadUserId) {
                        $matchingUserEmails[] = $user->email;
                    }
                }
            }

            $user = $lead->executive->email;

            // return $leadUsers;
            $recipients = array_merge($matchingUserEmails, [$user]);
            $data['date_time'] = $request->date_time;
            $data['msg'] = @$request->message;

            foreach ($recipients as $recipient) {
                Mail::send('email.email_info', @$data, function ($msg) use ($recipient) {
                    $msg->from(env('MAIL_FROM_ADDRESS'));
                    $msg->to($recipient, env('MAIL_FROM_NAME'));
                    $msg->subject('RICL Intervention Form');
                });
            }
            Communication::create($validatedData);

            return redirect()
                ->back()
                ->with('success', 'Communication saved successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function storeCommunicationWhatsapp(Request $request)
    {
        try {
            $currentDateTimeIST = Carbon::now('Asia/Kolkata');
            $request->merge(['date_time' => $currentDateTimeIST]);
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'lead_id' => 'required|exists:leads,id',
                'type' => 'required',
                'date_time' => 'required|date',
                'message' => 'required',
                'file' => 'nullable', // Adjust max file size as needed (in KB)
            ]);

            $files = $request->file('file');
            $fileNames = [];

            if ($files && is_array($files)) {
                foreach ($files as $file) {
                    $extension = $file->getClientOriginalExtension();
                    $originalFileNameWithExtension = $file->getClientOriginalName();
                    $fileNameWithoutExtension = pathinfo($originalFileNameWithExtension, PATHINFO_FILENAME);

                    // Replacing spaces with underscores and adding a timestamp to the filename
                    $filename = str_replace(' ', '_', $fileNameWithoutExtension) . '_' . time() . '.' . $extension;

                    // Determine the storage directory path
                    $storagePath = public_path('assets/files');

                    // Move the uploaded file to the storage directory
                    $file->move($storagePath, $filename);

                    // Store the filename in the array
                    $fileNames[] = $filename;
                }

                // Serialize the array before saving
                $validatedData['file'] = implode(',', $fileNames);
            }

            // Communication::create($validatedData);
            $communication = Communication::create($validatedData);

            $originalMessage = $request->input('message'); // Assuming this contains the original message

            // Remove the word "massage" from the original message
            $modifiedMessage = str_replace(' ', '%20', $originalMessage);

            $leadNumber = Lead::where('id', $request->lead_id)->first();
            $uploadedImagePath = 'https://omegastaging.com.au/ril/public/assets/files/' . $communication->file;
            // dd($uploadedImagePath);

            $url = "http://cloudapi.msg24.in/wapp/api/send?apikey=eb450d95b8734326a3b74f3a7197c4b6&mobile=$leadNumber->number&msg=$modifiedMessage&img1=$uploadedImagePath";
            $options = [
                CURLOPT_RETURNTRANSFER => true, // return web page
                // CURLOPT_HEADER         => false,  // don't return headers
                // CURLOPT_FOLLOWLOCATION => true,   // follow redirects
                // CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
                // CURLOPT_ENCODING       => "",     // handle compressed
                // CURLOPT_USERAGENT      => "test", // name of client
                // CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
                // CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
                // CURLOPT_TIMEOUT        => 120,    // time-out on response
            ];

            $cha = curl_init();
            curl_setopt_array($cha, $options);

            curl_setopt($cha, CURLOPT_URL, $url);
            $cont = json_decode(curl_exec($cha));
            curl_close($cha);

            return redirect()
                ->back()
                ->with('success', 'Communication saved successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function storeCommunicationMeeting(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'lead_id' => 'required|exists:leads,id',
                'type' => 'required',
                'date_time' => 'required|date',
                'message' => 'required',
                'status' => 'required|in:o,i',
                'file' => 'nullable', // Adjust max file size as needed
            ]);

            $files = $request->file('file');
            $fileNames = [];

            if ($files && is_array($files)) {
                foreach ($files as $file) {
                    $extension = $file->getClientOriginalExtension();
                    $originalFileNameWithExtension = $file->getClientOriginalName();
                    $fileNameWithoutExtension = pathinfo($originalFileNameWithExtension, PATHINFO_FILENAME);

                    // Replacing spaces with underscores and adding a timestamp to the filename
                    $filename = str_replace(' ', '_', $fileNameWithoutExtension) . '_' . time() . '.' . $extension;

                    // Determine the storage directory path
                    $storagePath = public_path('assets/files');

                    // Move the uploaded file to the storage directory
                    $file->move($storagePath, $filename);

                    // Store the filename in the array
                    $fileNames[] = $filename;
                }

                // Serialize the array before saving
                $validatedData['file'] = implode(',', $fileNames);
            }

            Communication::create($validatedData);
            return redirect()
                ->back()
                ->with('success', 'Communication saved successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function storeFollowUp()
    {
        try {
            $validatedData = request()->validate([
                'lead_id' => 'required|exists:leads,id',
                'date_time' => 'required|date',
                'status' => 'nullable|in:C,R',
            ]);
            $existingFollowUp = FollowUp::where([
                'lead_id' => $validatedData['lead_id'],
                'user_id' => auth()->id(),
            ])
                ->latest('created_at')
                ->first();
            if (!$existingFollowUp || Carbon::now()->gt($existingFollowUp->date_time)) {
                $followUp = FollowUp::create([
                    'lead_id' => $validatedData['lead_id'],
                    'user_id' => auth()->id(),
                    'date_time' => $validatedData['date_time'],
                ]);

                return redirect()
                    ->back()
                    ->with('success', 'Follow-up added successfully.');
            } else {
                $existingFollowUp->update([
                    'date_time' => $validatedData['date_time'],
                ]);

                return redirect()
                    ->back()
                    ->with('success', 'Follow-up updated successfully.');
            }
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function changeStatusFollowUp($id)
    {
        try {
            $followUp = FollowUp::find($id);
            $followUp->status = 'C';
            $followUp->save();
            return redirect()
                ->back()
                ->with('success', 'FollowUp marked as complete.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function deleteFollowUp($id)
    {
        try {
            // Find the FollowUp by ID
            $followUp = FollowUp::findOrFail($id);

            // Your logic to delete the FollowUp
            $followUp->delete();

            return redirect()
                ->back()
                ->with('success', 'FollowUp deleted successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function add_standard()
    {
        try {
            $standards = Standard::all();
            return view('admin.addStandard', compact('standards'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function store_standard()
    {
        try {
            $validatedData = request()->validate([
                'standard_name' => 'required',
                'description' => 'required',
            ]);
            $id = request()->input('id');

            if ($id) {
                $standard = Standard::findOrFail($id);
                $standard->update($validatedData);
                $message = 'Update standard successfully';
            } else {
                Standard::create($validatedData);
                $message = 'Add standard successfully';
            }

            return redirect()
                ->back()
                ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function edit_standard($id)
    {
        try {
            $standards = Standard::all();

            $stand = Standard::find($id);
            return view('admin.addStandard', compact('stand', 'standards'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function delete_standard($id)
    {
        try {
            $standard = Standard::find($id);
            $standard->delete();

            return redirect()
                ->back()
                ->with('warning', 'Delete standard successfully');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function add_accreditation()
    {
        try {
            $accreditations = Accreditation::all();
            return view('admin.addAccreditation', compact('accreditations'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function edit_accreditation($id)
    {
        try {
            $accreditations = Accreditation::all();
            $accr = Accreditation::find($id);
            return view('admin.addAccreditation', compact('accreditations', 'accr'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function store_accreditation()
    {
        try {
            $validatedData = request()->validate([
                'accreditation_name' => 'required',
            ]);

            $id = request()->input('id');

            if ($id) {
                $accreditation = Accreditation::findOrFail($id);
                $accreditation->update($validatedData);
                $message = 'Update Accreditation successfully';
            } else {
                Accreditation::create($validatedData);
                $message = 'Add Accreditation successfully';
            }

            return redirect()
                ->back()
                ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function delete_accreditation($id)
    {
        try {
            $accreditation = Accreditation::find($id);
            $accreditation->delete();

            return redirect()
                ->back()
                ->with('warning', 'Delete accreditation successfully');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function add_status()
    {
        try {
            $statuses = Status::all();
            return view('admin.addstatus', compact('statuses'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function edit_status($id)
    {
        try {
            $statuses = Status::all();
            $stat = Status::find($id);
            return view('admin.addStatus', compact('statuses', 'stat'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function store_status()
    {
        try {
            $validatedData = request()->validate([
                'name' => 'required',
            ]);

            $id = request()->input('id');

            if ($id) {
                $statuses = Status::findOrFail($id);
                $statuses->update($validatedData);
                $message = 'Update Status successfully';
            } else {
                Status::create($validatedData);
                $message = 'Add Status successfully';
            }

            return redirect()
                ->back()
                ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function delete_status($id)
    {
        try {
            $statuses = Status::find($id);
            $statuses->delete();

            return redirect()
                ->back()
                ->with('warning', 'Delete Status successfully');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function add_leadSource()
    {
        try {
            $leadSources = LeadSource::all();
            return view('admin.addLeadSource', compact('leadSources'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function edit_leadSource($id)
    {
        try {
            $leadSources = LeadSource::all();
            $leadSou = LeadSource::find($id);
            return view('admin.addLeadSource', compact('leadSources', 'leadSou'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function store_leadSource()
    {
        try {
            $validatedData = request()->validate([
                'name' => 'required',
            ]);

            $id = request()->input('id');

            if ($id) {
                $leadSources = LeadSource::findOrFail($id);
                $leadSources->update($validatedData);
                $message = 'Update Lead Source successfully';
            } else {
                LeadSource::create($validatedData);
                $message = 'Add Lead Source successfully';
            }

            return redirect()
                ->back()
                ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function delete_leadSource($id)
    {
        try {
            $leadSource = LeadSource::find($id);
            $leadSource->delete();

            return redirect()
                ->back()
                ->with('warning', 'Delete Lead Source successfully');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
}
