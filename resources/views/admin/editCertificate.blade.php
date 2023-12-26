@extends('layouts.app')

@section('content')
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            @include('inc.menu')
            <!-- / Menu -->
            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                @include('inc.nav')

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <h3 class="card-header">Edit Certificate</h3>
                        <!--Add Leads -->
                        <div class="row">
                            <!---Layout -->
                            <div class="col col-12 col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <form class="row g-3" action="{{ route('admin.store.certificate') }}"
                                            method="post">
                                            @csrf
                                            <div class="col-12 col-lg-6">
                                                <label for="certificate_template" class="form-label">Certificate
                                                    Template</label>
                                                <select class="form-control" name="certificate_template">
                                                    <option value="">Select an Option</option>

                                                    @php
                                                        $certificateOption = @auth()->user()->role->certificate_option;
                                                        $certificateTemplates = [];

                                                        switch ($certificateOption) {
                                                            case 'Q':
                                                                $certificateTemplates = [['value' => 'ENERGY', 'shortForm' => 'qfsENERGY'], ['value' => 'Anti-bribery', 'shortForm' => 'qfsAb'], ['value' => 'Occupational Health & Safety', 'shortForm' => 'qfsOHS'], ['value' => 'Environment', 'shortForm' => 'qfsE'], ['value' => 'IT Service', 'shortForm' => 'qfsITS'], ['value' => 'Food Safety', 'shortForm' => 'qfsFS'], ['value' => 'Business', 'shortForm' => 'qfsBus'], ['value' => 'Information Security', 'shortForm' => 'IS'], ['value' => 'Quality', 'shortForm' => 'qfsQ']];
                                                                break;

                                                            case 'H':
                                                                $certificateTemplates = [['value' => 'Food Safety', 'shortForm' => 'FS'], ['value' => 'IT Service', 'shortForm' => 'ITS'], ['value' => 'Environment', 'shortForm' => 'E'], ['value' => 'ENERGY', 'shortForm' => 'ENERGY'], ['value' => 'Occupational Health & Safety', 'shortForm' => 'OHS'], ['value' => 'hawk-eye', 'shortForm' => 'HEC']];
                                                                break;

                                                            case 'I':
                                                                $certificateTemplates = [['value' => 'GDPR', 'shortForm' => 'GDPR'], ['value' => 'Certificate of Registration', 'shortForm' => 'COR'], ['value' => 'Certificate of Compliance', 'shortForm' => 'COC']];
                                                                break;
                                                        }
                                                    @endphp

                                                    @foreach ($certificateTemplates as $template)
                                                        <option value="{{ $template['shortForm'] }}"
                                                            {{ $certificate->certificate_template == $template['shortForm'] ? 'selected' : '' }}>
                                                            {{ $template['value'] }}</option>
                                                    @endforeach
                                                </select>

                                                @error('certificate_template')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <label for="cat" class="form-label">Certificate Status</label>
                                                <select class="form-control" name="certificate_status">
                                                    @if (@$certificate->certificate_status == 'F')
                                                        <option value="F">
                                                            Final
                                                        </option>
                                                    @else
                                                        <option value="D">
                                                            Draft
                                                        </option>
                                                    @endif

                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label for="cat" class="form-label">Standard</label>
                                                <input type="text" class="form-control" name="standard_name"
                                                    value="{{ @$certificate->standard_name }}" id="cat">
                                                <input type="hidden" name="certificate_id" value="{{ @$certificate->id }}">
                                                <input type="hidden" name="lead_id" value="{{ @$leadId }}">
                                            </div>
                                            <div class="col-12">
                                                <label for="cat" class="form-label">Standard Full Form</label>
                                                <input type="text" class="form-control" name="standard_description"
                                                    value="{{ @$certificate->standard_description }}" id="cat">
                                            </div>
                                            <div class="col-12">
                                                <label for="cat" class="form-label">Business Name</label>
                                                <textarea class="form-control" name="business_name"> {{ @$certificate->business_name }}</textarea>
                                            </div>
                                            <div class="col-12">
                                                <label for="cat" class="form-label">Address</label>
                                                <textarea class="form-control" name="business_name_secondary">{{ @$certificate->business_name_secondary }}</textarea>
                                            </div>
                                            <div class="col-12">
                                                <label for="subcat" class="form-label">Scope of Registration</label>
                                                <textarea class="form-control" name="scope_registration">{{ @$certificate->scope_registration }}</textarea>
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- End Left side columns -->
                            <div class="col-lg-12">

                                <div class="card">
                                    <div class="card-body pt-3">
                                        <!-- Bordered Tabs -->
                                        <ul class="nav nav-tabs nav-tabs-bordered">

                                            <li class="nav-item">
                                                <button class="nav-link active" data-bs-toggle="tab"
                                                    data-bs-target="#profile-overview">Documents</button>
                                            </li>

                                            <li class="nav-item">
                                                <button class="nav-link" data-bs-toggle="tab"
                                                    data-bs-target="#profile-edit">Payment</button>
                                            </li>

                                            <li class="nav-item">
                                                <button class="nav-link" data-bs-toggle="tab"
                                                    data-bs-target="#profile-settings">Final
                                                    Certificate</button>
                                            </li>

                                        </ul>
                                        <div class="tab-content pt-2">

                                            <div class="tab-pane fade show active profile-overview" id="profile-overview">


                                                <h5 class="card-title">Documents</h5>

                                                <form action="{{ route('certificate.document.store') }}" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row mb-3">
                                                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">File
                                                            Name</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <input name="file_name" type="text" class="form-control"
                                                                value="{{ old('file_name') }}" id="fullName">
                                                            <input name="certificate_id" type="text"
                                                                value="{{ @$certificate->id }}" hidden>
                                                        </div>
                                                        @error('file_name')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="fullName"
                                                            class="col-md-4 col-lg-3 col-form-label">Upload
                                                            File</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <input type="file" name="file[]" class="form-control"
                                                                multiple>
                                                        </div>
                                                        @error('file')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>


                                                    <div class="text-center">
                                                        <button type="submit" class="btn btn-primary">Save
                                                            Changes</button>
                                                    </div>
                                                </form>

                                                <hr>
                                                <table class="table">
                                                    <tr>
                                                        <th>Particulars</th>
                                                        <th>Document</th>
                                                        <th>Upload Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    @foreach (@$documents as $document)
                                                        <tr>
                                                            <td>{{ $document->file_name }}</td>
                                                            <td>{{ @$document->file_path }}</td>
                                                            <td>{{ date('Y-m-d', strtotime($document->created_at)) }}
                                                            </td>
                                                            <td>
                                                                {{-- <a target="_blank" href="{{ asset('/public/assets/files/' . $document->file_path) }}">
                                                                        View</a>  --}}
                                                                @php
                                                                    $imageExtensions = ['.jpg', '.jpeg', '.png', '.gif'];
                                                                    $fileExtension = strtolower(pathinfo($document->file_path, PATHINFO_EXTENSION));
                                                                @endphp

                                                                @if (in_array($fileExtension, $imageExtensions))
                                                                    <!-- Display the image -->
                                                                    <img src="{{ asset('/public/assets/files/' . $document->file_path) }}"
                                                                        alt="Image">
                                                                @else
                                                                    <!-- Display a link to the PDF/Excel file -->
                                                                    <a target="_blank"
                                                                        href="{{ asset('/public/assets/files/' . $document->file_path) }}">View</a>
                                                                @endif
                                                                | <a
                                                                    href="{{ route('delete.document', ['id' => $document->id]) }}">Delete</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>

                                            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                                                <!-- Profile Edit Form -->
                                                <form class="row g-3" action="{{ route('certificate.payment.store') }}"
                                                    method="post">
                                                    @csrf
                                                    <div class="col-12 mb-3">
                                                        <label for="cat" class="form-label">Payment Details</label>
                                                        <select class="form-control" name="payment_type">
                                                            <option value="">Select</option>
                                                            <option value="Pending">Pending</option>
                                                            <option value="Paytm">Paytm</option>
                                                            <option value="Gpay">Gpay</option>
                                                            <option value="Phonepay">Phonepay</option>
                                                            <option value="B. Account">B. Account</option>
                                                            <option value="P. Account">P. Account</option>
                                                            <option value="Cash">Cash</option>
                                                            <option value="PayPal">PayPal</option>
                                                        </select>
                                                        @error('payment_type')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-12 mb-3">
                                                        <label for="cat" class="form-label">Amount</label>
                                                        <input type="text" class="form-control" name="payment_balance"
                                                            id="cat">
                                                        @error('payment_balance')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <input type="text" name="certificate_id"
                                                        value="{{ @$certificate->id }}" hidden>
                                                    <div class="text-center">
                                                        <button type="submit" class="btn btn-primary">Submit</button>

                                                    </div>

                                                </form>
                                                <!-- End Profile Edit Form -->

                                            </div>

                                            <div class="tab-pane fade pt-3" id="profile-settings">

                                                <!-- Settings Form -->
                                                <form class="row g-3" action="{{ route('certificate.final') }}"
                                                    method="post">
                                                    @csrf
                                                    <div class="">
                                                        <input type="text" name="certificate_id" class="form-control"
                                                            id="cat" value="{{ @$certificate->id }}" hidden>
                                                    </div>


                                                    <div class="col-12">
                                                        <label for="refno" class="form-label">Certificate No</label>
                                                        <input type="text" class="form-control" id="refno"
                                                            placeholder="Certificate No" name="certificate_number">
                                                    </div>

                                                    <div class="col-12 col-lg-6">
                                                        <label for="email" class="form-label">Date of initial
                                                            Certification</label>
                                                        <input type="date" class="form-control" id="date_initial"
                                                            placeholder="DD/MM/YYYY" name="date_initial">
                                                    </div>
                                                    <div class="col-12 col-lg-6">
                                                        <label for="email" class="form-label">First Surveillance Audit
                                                            on or
                                                            before</label>
                                                        <input type="date" class="form-control"
                                                            placeholder="DD/MM/YYYY" id="first_surveillance_audit"
                                                            name="first_surveillance_audit">
                                                    </div>
                                                    <div class="col-12 col-lg-6">
                                                        <label for="email" class="form-label">Second Surveillance Audit
                                                            on or
                                                            before</label>
                                                        <input type="date" class="form-control"
                                                            id="second_surveillance_audit" placeholder="DD/MM/YYYY"
                                                            name="second_surveillance_audit">
                                                    </div>

                                                    <div class="col-12 col-lg-6">
                                                        <label for="email" class="form-label">Certification Valid
                                                            Until</label>
                                                        <input type="date" class="form-control"
                                                            placeholder="DD/MM/YYYY" id="certification_due_date"
                                                            name="certification_due_date">
                                                    </div>
                                                    @php
                                                        @$showButton = false;
                                                        @$showButtondDcuments = false;
                                                    @endphp
                                                    @foreach (@$payments as $payment)
                                                        <div class="alert alert-primary">
                                                            <p class="">
                                                                Payment
                                                                {{ $payment->status == 'A' ? 'Approved' : ($payment->status == 'R' ? 'Rejected' : 'Pending ') }}
                                                            </p>
                                                        </div>

                                                        @if (@$payment->status == 'A')
                                                            @php
                                                                $showButton = true;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                    @foreach (@$documents as $document)
                                                        <div class="alert alert-primary">
                                                            <p class="">
                                                                Document
                                                                {{ $document->status == 'A' ? 'Approved' : ($document->status == 'R' ? 'Rejected' : 'Pending ') }}
                                                            </p>
                                                        </div>

                                                        @if (@$document->status == 'A')
                                                            @php
                                                                $showButtondDcuments = true;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                    @if (@$showButton && @$showButtondDcuments)
                                                        <div class="text-center">
                                                            <button type="submit" class="btn btn-primary">Generate Final
                                                                Cert</button>
                                                        </div>
                                                    @endif
                                                    {{-- <div class="text-center">
                                                        <button type="submit" class="btn btn-primary">Generate Final
                                                            Cert</button>
                                                    </div> --}}
                                                </form><!-- End settings Form -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
