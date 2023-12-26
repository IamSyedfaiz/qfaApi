<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Document;
use App\Models\Lead;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function add_certificate($id)
    {
        try {
            $lead = Lead::find($id);
            return view('admin.addCertificate', compact('lead'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }

    public function store_certificate()
    {
        try {
            $validatedData = request()->validate([
                'user_id' => 'nullable',
                'lead_id' => 'required',
                'certificate_template' => 'required',
                'certificate_status' => 'required|in:D,F',
                'standard_name' => 'required',
                'standard_description' => 'required',
                'business_name' => 'required',
                'business_name_secondary' => 'nullable',
                'scope_registration' => 'required',
            ]);

            $validatedData['user_id'] = auth()->user()->id;
            $certificateID = request()->input('certificate_id');
            $certificateTemplate = request()->input('certificate_template');

            if ($certificateID) {
                $certificate = Certificate::findOrFail($certificateID);
                $certificate->update($validatedData);
            } else {
                $certificate = Certificate::create($validatedData);
            }

            if ($certificateTemplate == 'GDPR') {
                return redirect('/certificate-create-gdpr/' . $certificate->id);
            } elseif ($certificateTemplate == 'COR') {
                return redirect('/certificate-create-cor/' . $certificate->id);
            } elseif ($certificateTemplate == 'COC') {
                return redirect('/certificate-create-coc/' . $certificate->id);
            } elseif ($certificateTemplate == 'ENERGY') {
                return redirect('/certificate-create-ENERGY/' . $certificate->id);
            } elseif ($certificateTemplate == 'E') {
                return redirect('/certificate-create-Environment/' . $certificate->id);
            } elseif ($certificateTemplate == 'FS') {
                return redirect('/certificate-create-FoodSafety/' . $certificate->id);
            } elseif ($certificateTemplate == 'ITS') {
                return redirect('/certificate-create-ITS/' . $certificate->id);
            } elseif ($certificateTemplate == 'OHS') {
                return redirect('/certificate-create-OHS/' . $certificate->id);
            } elseif ($certificateTemplate == 'HEC') {
                return redirect('/certificate-create-HEC/' . $certificate->id);
            } elseif ($certificateTemplate == 'qfsENERGY') {
                return redirect('/certificate-create-qfsENERGY/' . $certificate->id);
            } elseif ($certificateTemplate == 'qfsE') {
                return redirect('/certificate-create-qfsEnvironmental/' . $certificate->id);
            } elseif ($certificateTemplate == 'qfsFS') {
                return redirect('/certificate-create-qfsFoodSafety/' . $certificate->id);
            } elseif ($certificateTemplate == 'qfsITS') {
                return redirect('/certificate-create-qfsITS/' . $certificate->id);
            } elseif ($certificateTemplate == 'qfsOHS') {
                return redirect('/certificate-create-qfsOHS/' . $certificate->id);
            } elseif ($certificateTemplate == 'qfsBus') {
                return redirect('/certificate-create-qfsBus/' . $certificate->id);
            } elseif ($certificateTemplate == 'qfsAb') {
                return redirect('/certificate-create-qfsAb/' . $certificate->id);
            } elseif ($certificateTemplate == 'qfsQ') {
                return redirect('/certificate-create-qfsQuality/' . $certificate->id);
            } elseif ($certificateTemplate == 'IS') {
                return redirect('/certificate-create-qfsInformationSecurity/' . $certificate->id);
            } else {
                return redirect()
                    ->back()
                    ->with('error', 'Certificate not found');
            }
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }

    public function all_certificate()
    {
        try {
            $user = auth()->user();

            if ($user->active == 'Y') {
                Auth::logout();
                return redirect()
                    ->back()
                    ->with('danger', 'Your Account has been Suspended');
            } else {
                $users = User::all();
                $authUserId = auth()->id();

                $leads = Lead::where('status_id', 7)
                    ->where(function ($query) use ($authUserId) {
                        $query->where('user_id', $authUserId)->orWhereRaw("FIND_IN_SET($authUserId, allocate_user) > 0");
                    })
                    ->get();

                $leadIds = $leads->pluck('id')->toArray();
                $certificates = Certificate::whereIn('lead_id', $leadIds)->get();

                return view('admin.allCertificates', compact('certificates', 'leads', 'users'));
            }
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }

    public function certificateCreate($id)
    {
        try {
            $data = Certificate::find($id);

            return view('admin.certificatePreview', compact('data'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function certificateCreateCoc($id)
    {
        try {
            $data = Certificate::find($id);

            return view('admin.certificatePreviewCoc', compact('data'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function certificateCreateGdpr($id)
    {
        try {
            $data = Certificate::find($id);

            return view('admin.certificatePreviewGdpr', compact('data'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function certificateCreateCor($id)
    {
        try {
            $data = Certificate::find($id);

            return view('admin.certificatePreviewCor', compact('data'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function certificateCreateENERGY($id)
    {
        try {
            $data = Certificate::find($id);

            return view('admin.draft.certificatePreviewENERGY', compact('data'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function certificateCreateEnvironment($id)
    {
        try {
            $data = Certificate::find($id);

            return view('admin.draft.certificatePreviewEnvironment', compact('data'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function certificateCreateFoodSafety($id)
    {
        try {
            $data = Certificate::find($id);

            return view('admin.draft.certificatePreviewFoodSafety', compact('data'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function certificateCreateIts($id)
    {
        try {
            $data = Certificate::find($id);

            return view('admin.draft.certificatePreviewITS', compact('data'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function certificateCreateOHS($id)
    {
        try {
            $data = Certificate::find($id);

            return view('admin.draft.certificatePreviewOHS', compact('data'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function certificateCreateHEC($id)
    {
        try {
            $data = Certificate::find($id);

            return view('admin.draft.certificatePreviewHEC', compact('data'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function certificateCreateqfsENERGY($id)
    {
        try {
            $data = Certificate::find($id);

            return view('admin.draft.certificatePreviewqfsENERGY', compact('data'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function certificateCreateqfsEnvironmental($id)
    {
        try {
            $data = Certificate::find($id);

            return view('admin.draft.certificatePreviewqfsEnvironment', compact('data'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function certificateCreateqfsFoodSafety($id)
    {
        try {
            $data = Certificate::find($id);

            return view('admin.draft.certificatePreviewqfsFoodSafety', compact('data'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function certificateCreateqfsIts($id)
    {
        try {
            $data = Certificate::find($id);

            return view('admin.draft.certificatePreviewqfsIts', compact('data'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function certificateCreateqfsOHS($id)
    {
        try {
            $data = Certificate::find($id);

            return view('admin.draft.certificatePreviewqfsOHS', compact('data'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function certificateCreateqfsAb($id)
    {
        try {
            $data = Certificate::find($id);

            return view('admin.draft.certificatePreviewqfsAb', compact('data'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function certificateCreateqfsBus($id)
    {
        try {
            $data = Certificate::find($id);

            return view('admin.draft.certificatePreviewqfsBus', compact('data'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function certificateCreateqfsQuality($id)
    {
        try {
            $data = Certificate::find($id);

            return view('admin.draft.certificatePreviewqfsQuality', compact('data'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function certificateCreateqfsInformationSecurity($id)
    {
        try {
            $data = Certificate::find($id);

            return view('admin.draft.certificatePreviewqfsInformationSecurity', compact('data'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }

    // final function
    public function certificateCreateFinalCoc($id)
    {
        try {
            $data = Certificate::find($id);

            return view('admin.final.certificatePreviewCoc', compact('data'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function certificateCreateFinalGdpr($id)
    {
        try {
            $data = Certificate::find($id);

            return view('admin.final.certificatePreviewGdpr', compact('data'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function certificateCreateFinalCor($id)
    {
        try {
            $data = Certificate::find($id);

            return view('admin.final.certificatePreviewCor', compact('data'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function certificateCreateFinalENERGY($id)
    {
        try {
            $data = Certificate::find($id);

            return view('admin.final.certificatePreviewENERGY', compact('data'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function certificateCreateFinalEnvironment($id)
    {
        try {
            $data = Certificate::find($id);

            return view('admin.final.certificatePreviewEnvironment', compact('data'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function certificateCreateFinalFoodSafety($id)
    {
        try {
            $data = Certificate::find($id);

            return view('admin.final.certificatePreviewFoodSafety', compact('data'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function certificateCreateFinalIts($id)
    {
        try {
            $data = Certificate::find($id);

            return view('admin.final.certificatePreviewITS', compact('data'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function certificateCreateFinalOHS($id)
    {
        try {
            $data = Certificate::find($id);

            return view('admin.final.certificatePreviewOHS', compact('data'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function certificateCreateFinalHEC($id)
    {
        try {
            $data = Certificate::find($id);

            return view('admin.final.certificatePreviewHEC', compact('data'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function certificateCreateFinalqfsENERGY($id)
    {
        try {
            $data = Certificate::find($id);

            return view('admin.final.certificatePreviewqfsENERGY', compact('data'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function certificateCreateFinalqfsEnvironmental($id)
    {
        try {
            $data = Certificate::find($id);

            return view('admin.final.certificatePreviewqfsEnvironment', compact('data'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function certificateCreateFinalqfsFoodSafety($id)
    {
        try {
            $data = Certificate::find($id);

            return view('admin.final.certificatePreviewqfsFoodSafety', compact('data'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function certificateCreateFinalqfsIts($id)
    {
        try {
            $data = Certificate::find($id);

            return view('admin.final.certificatePreviewqfsIts', compact('data'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function certificateCreateFinalqfsOHS($id)
    {
        try {
            $data = Certificate::find($id);

            return view('admin.final.certificatePreviewqfsOHS', compact('data'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function certificateCreateFinalqfsAb($id)
    {
        try {
            $data = Certificate::find($id);

            return view('admin.final.certificatePreviewqfsAb', compact('data'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function certificateCreateFinalqfsBus($id)
    {
        try {
            $data = Certificate::find($id);

            return view('admin.final.certificatePreviewqfsBus', compact('data'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function certificateCreateFinalqfsQuality($id)
    {
        try {
            $data = Certificate::find($id);

            return view('admin.final.certificatePreviewqfsQuality', compact('data'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function certificateCreateFinalqfsInformationSecurity($id)
    {
        try {
            $data = Certificate::find($id);

            return view('admin.final.certificatePreviewqfsInformationSecurity', compact('data'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function certificateEdit($id)
    {
        try {
            // $certificate = Certificate::where('lead_id', $id)->first();
            $certificate = Certificate::find($id);

            $leadId = $certificate->lead_id;
            $documents = Document::where('certificate_id', $id)->get();
            $payments = Payment::where('certificate_id', $id)->get();
            return view('admin.editCertificate', compact('certificate', 'leadId', 'documents', 'payments'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function view_certificate($id)
    {
        try {
            // $certificate = Certificate::where('lead_id', $id)->first();
            $certificate = Certificate::find($id);

            if ($certificate->certificate_status == 'D') {
                if ($certificate->certificate_template == 'GDPR') {
                    return redirect('/certificate-create-gdpr/' . $certificate->id);
                } elseif ($certificate->certificate_template == 'COR') {
                    return redirect('/certificate-create-cor/' . $certificate->id);
                } elseif ($certificate->certificate_template == 'COC') {
                    return redirect('/certificate-create-coc/' . $certificate->id);
                } elseif ($certificate->certificate_template == 'ENERGY') {
                    return redirect('/certificate-create-ENERGY/' . $certificate->id);
                } elseif ($certificate->certificate_template == 'E') {
                    return redirect('/certificate-create-Environment/' . $certificate->id);
                } elseif ($certificate->certificate_template == 'FS') {
                    return redirect('/certificate-create-FoodSafety/' . $certificate->id);
                } elseif ($certificate->certificate_template == 'ITS') {
                    return redirect('/certificate-create-ITS/' . $certificate->id);
                } elseif ($certificate->certificate_template == 'OHS') {
                    return redirect('/certificate-create-OHS/' . $certificate->id);
                } elseif ($certificate->certificate_template == 'HEC') {
                    return redirect('/certificate-create-HEC/' . $certificate->id);
                } elseif ($certificate->certificate_template == 'qfsENERGY') {
                    return redirect('/certificate-create-qfsENERGY/' . $certificate->id);
                } elseif ($certificate->certificate_template == 'qfsE') {
                    return redirect('/certificate-create-qfsEnvironmental/' . $certificate->id);
                } elseif ($certificate->certificate_template == 'qfsFS') {
                    return redirect('/certificate-create-qfsFoodSafety/' . $certificate->id);
                } elseif ($certificate->certificate_template == 'qfsITS') {
                    return redirect('/certificate-create-qfsITS/' . $certificate->id);
                } elseif ($certificate->certificate_template == 'qfsOHS') {
                    return redirect('/certificate-create-qfsOHS/' . $certificate->id);
                } elseif ($certificate->certificate_template == 'qfsBus') {
                    return redirect('/certificate-create-qfsBus/' . $certificate->id);
                } elseif ($certificate->certificate_template == 'qfsAb') {
                    return redirect('/certificate-create-qfsAb/' . $certificate->id);
                } elseif ($certificate->certificate_template == 'qfsQ') {
                    return redirect('/certificate-create-qfsQuality/' . $certificate->id);
                } elseif ($certificate->certificate_template == 'IS') {
                    return redirect('/certificate-create-qfsInformationSecurity/' . $certificate->id);
                } else {
                    return redirect()
                        ->back()
                        ->with('error', 'Certificate not found');
                }
            } else {
                if ($certificate->certificate_template == 'GDPR') {
                    return redirect('/certificate-create-final-gdpr/' . $certificate->id);
                } elseif ($certificate->certificate_template == 'COR') {
                    return redirect('/certificate-create-final-cor/' . $certificate->id);
                } elseif ($certificate->certificate_template == 'COC') {
                    return redirect('/certificate-create-final-coc/' . $certificate->id);
                } elseif ($certificate->certificate_template == 'ENERGY') {
                    return redirect('/certificate-create-final-ENERGY/' . $certificate->id);
                } elseif ($certificate->certificate_template == 'E') {
                    return redirect('/certificate-create-final-Environment/' . $certificate->id);
                } elseif ($certificate->certificate_template == 'FS') {
                    return redirect('/certificate-create-final-FoodSafety/' . $certificate->id);
                } elseif ($certificate->certificate_template == 'ITS') {
                    return redirect('/certificate-create-final-ITS/' . $certificate->id);
                } elseif ($certificate->certificate_template == 'OHS') {
                    return redirect('/certificate-create-final-OHS/' . $certificate->id);
                } elseif ($certificate->certificate_template == 'HEC') {
                    return redirect('/certificate-create-final-HEC/' . $certificate->id);
                } elseif ($certificate->certificate_template == 'qfsENERGY') {
                    return redirect('/certificate-create-final-qfsENERGY/' . $certificate->id);
                } elseif ($certificate->certificate_template == 'qfsE') {
                    return redirect('/certificate-create-final-qfsEnvironmental/' . $certificate->id);
                } elseif ($certificate->certificate_template == 'qfsFS') {
                    return redirect('/certificate-create-final-qfsFoodSafety/' . $certificate->id);
                } elseif ($certificate->certificate_template == 'qfsITS') {
                    return redirect('/certificate-create-final-qfsITS/' . $certificate->id);
                } elseif ($certificate->certificate_template == 'qfsOHS') {
                    return redirect('/certificate-create-final-qfsOHS/' . $certificate->id);
                } elseif ($certificate->certificate_template == 'qfsBus') {
                    return redirect('/certificate-create-final-qfsBus/' . $certificate->id);
                } elseif ($certificate->certificate_template == 'qfsAb') {
                    return redirect('/certificate-create-final-qfsAb/' . $certificate->id);
                } elseif ($certificate->certificate_template == 'qfsQ') {
                    return redirect('/certificate-create-final-qfsQuality/' . $certificate->id);
                } elseif ($certificate->certificate_template == 'IS') {
                    return redirect('/certificate-create-final-qfsInformationSecurity/' . $certificate->id);
                } else {
                    return redirect()
                        ->back()
                        ->with('error', 'Certificate not found');
                }
            }
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function certificateDelete($id)
    {
        try {
            $certificate = Certificate::find($id);

            if ($certificate) {
                $certificate->payments()->delete();
                $certificate->documents()->delete();
                $certificate->delete();

                return redirect()
                    ->back()
                    ->with('success', 'Certificate and associated records deleted successfully');
            } else {
                return redirect()
                    ->back()
                    ->with('error', 'Certificate not found');
            }
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
    public function certificateFinal(Request $request)
    {
        try {
            $certificateId = request()->input('certificate_id');

            $certificate = Certificate::find($certificateId);

            if ($certificate) {
                request()->validate([
                    'certificate_number' => ['required', 'unique:certificates,certificate_number,' . $certificate->id, 'lowercase'],
                ]);
                $certificate->certificate_number = request()->input('certificate_number');
                $certificate->date_initial = request()->input('date_initial');
                $certificate->first_surveillance_audit = request()->input('first_surveillance_audit');
                $certificate->second_surveillance_audit = request()->input('second_surveillance_audit');
                $certificate->certification_due_date = request()->input('certification_due_date');
                $certificate->certificate_status = 'F';
                $certificate->save();
            }

            if ($certificate->certificate_template == 'GDPR') {
                return redirect('/certificate-create-final-gdpr/' . $certificate->id);
            } elseif ($certificate->certificate_template == 'COR') {
                return redirect('/certificate-create-final-cor/' . $certificate->id);
            } elseif ($certificate->certificate_template == 'COC') {
                return redirect('/certificate-create-final-coc/' . $certificate->id);
            } elseif ($certificate->certificate_template == 'ENERGY') {
                return redirect('/certificate-create-final-ENERGY/' . $certificate->id);
            } elseif ($certificate->certificate_template == 'E') {
                return redirect('/certificate-create-final-Environment/' . $certificate->id);
            } elseif ($certificate->certificate_template == 'FS') {
                return redirect('/certificate-create-final-FoodSafety/' . $certificate->id);
            } elseif ($certificate->certificate_template == 'ITS') {
                return redirect('/certificate-create-final-ITS/' . $certificate->id);
            } elseif ($certificate->certificate_template == 'OHS') {
                return redirect('/certificate-create-final-OHS/' . $certificate->id);
            } elseif ($certificate->certificate_template == 'HEC') {
                return redirect('/certificate-create-final-HEC/' . $certificate->id);
            } elseif ($certificate->certificate_template == 'qfsENERGY') {
                return redirect('/certificate-create-final-qfsENERGY/' . $certificate->id);
            } elseif ($certificate->certificate_template == 'qfsE') {
                return redirect('/certificate-create-final-qfsEnvironmental/' . $certificate->id);
            } elseif ($certificate->certificate_template == 'qfsFS') {
                return redirect('/certificate-create-final-qfsFoodSafety/' . $certificate->id);
            } elseif ($certificate->certificate_template == 'qfsITS') {
                return redirect('/certificate-create-final-qfsITS/' . $certificate->id);
            } elseif ($certificate->certificate_template == 'qfsOHS') {
                return redirect('/certificate-create-final-qfsOHS/' . $certificate->id);
            } elseif ($certificate->certificate_template == 'qfsBus') {
                return redirect('/certificate-create-final-qfsBus/' . $certificate->id);
            } elseif ($certificate->certificate_template == 'qfsAb') {
                return redirect('/certificate-create-final-qfsAb/' . $certificate->id);
            } elseif ($certificate->certificate_template == 'qfsQ') {
                return redirect('/certificate-create-final-qfsQuality/' . $certificate->id);
            } elseif ($certificate->certificate_template == 'IS') {
                return redirect('/certificate-create-final-qfsInformationSecurity/' . $certificate->id);
            } else {
                return redirect()
                    ->back()
                    ->with('error', 'Certificate not found');
            }
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
}
