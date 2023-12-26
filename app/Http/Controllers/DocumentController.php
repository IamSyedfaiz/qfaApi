<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Lead;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    //

    public function certificateDocumentStore(Request $request)
    {
        try {
            $request->validate([
                'file_name' => 'required',
                'file' => 'required',
                'certificate_id' => 'nullable',
            ]);

            $fileNames = [];
            // dd($request->file('file'));

            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $file) {
                    // Generate a unique filename for each uploaded file
                    $originalFileName = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $randomNumber = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
                    $uniqueFileName = pathinfo($originalFileName, PATHINFO_FILENAME) . '_' . $randomNumber . '.' . $extension;

                    // Determine the storage directory path within the public directory
                    $storagePath = public_path('assets/files');

                    // Move the uploaded file to the storage directory
                    $file->move($storagePath, $uniqueFileName);

                    // Save the filename in the array
                    $fileNames[] = $uniqueFileName;
                }
            }

            foreach ($fileNames as $fileName) {
                $file = new Document();
                $file->user_id = auth()->user()->id;
                $file->file_name = $request->input('file_name');
                $file->file_path = $fileName;
                $file->certificate_id = $request->input('certificate_id');
                $file->save();
            }

            return redirect()
                ->back()
                ->with('success', 'Files uploaded successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function deleteDocument($id)
    {
        try {
            $data = Document::find($id);
            $data->delete();

            return redirect()
                ->back()
                ->with('success', 'File Delete successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function certificatePaymentStore(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'user_id' => 'nullable',
                'certificate_id' => 'required|exists:certificates,id',
                'payment_type' => 'required',
                'payment_balance' => 'required',
                'status' => 'nullable',
            ]);
            $validatedData['user_id'] = auth()->user()->id;
            Payment::create($validatedData);

            return redirect()
                ->back()
                ->with('success', 'File Delete successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function getDocument()
    {
        try {
            $user = auth()->user();

            if ($user->active == 'Y') {
                Auth::logout();
                return redirect()
                    ->back()
                    ->with('danger', 'Your Account has been Suspended');
            } else {
                if (auth()->user()->id == 1) {
                    $documents = Document::all();
                } else {
                    $leads = Lead::where('status_id', 7)
                        ->where(function ($query) {
                            $query->where('user_id', auth()->id())->orWhere('allocate_user', auth()->id());
                        })
                        ->get();
                    $documents = [];

                    foreach ($leads as $lead) {
                        // Check if the lead has a certificate and payment
                        if ($lead->certificate && $lead->certificate->document) {
                            $documents[] = $lead->certificate->document;
                        }
                    }
                }
                return view('admin.allDocument', compact('documents'));
            }
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function getPayment()
    {
        try {
            $user = auth()->user();

            if ($user->active == 'Y') {
                Auth::logout();
                return redirect()
                    ->back()
                    ->with('danger', 'Your Account has been Suspended');
            } else {
                if (auth()->user()->id == 1) {
                    $payments = Payment::all();
                } else {
                    $leads = Lead::where('status_id', 7)
                        ->where(function ($query) {
                            $query->where('user_id', auth()->id())->orWhere('allocate_user', auth()->id());
                        })
                        ->get();
                    $payments = [];

                    foreach ($leads as $lead) {
                        // Check if the lead has a certificate and payment
                        if ($lead->certificate && $lead->certificate->payment) {
                            $payments[] = $lead->certificate->payment;
                        }
                    }
                }
                return view('admin.allPayment', compact('payments'));
            }
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function approvePayment($id)
    {
        try {
            $payment = Payment::find($id);

            if ($payment) {
                $payment->status = 'A'; // Set the status to "A" for approve
                $payment->save();
            }
            return redirect()
                ->back()
                ->with('success', 'Payment approve successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function rejectPayment($id)
    {
        try {
            $payment = Payment::find($id);

            if ($payment) {
                $payment->status = 'R'; // Set the status to "R" for reject
                $payment->save();
            }
            return redirect()
                ->back()
                ->with('success', 'Payment reject successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function approveDocument($id)
    {
        try {
            $document = Document::find($id);

            if ($document) {
                $document->status = 'A';
                $document->save();
            }
            return redirect()
                ->back()
                ->with('success', 'Document approve successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function rejectDocument($id)
    {
        try {
            $document = Document::find($id);

            if ($document) {
                $document->status = 'R';
                $document->save();
            }
            return redirect()
                ->back()
                ->with('success', 'Document reject successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
}
