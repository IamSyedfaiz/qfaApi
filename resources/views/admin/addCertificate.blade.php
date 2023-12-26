@extends('layouts.app')

@section('content')
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            @include('inc.menu')
            <div class="layout-page">
                @include('inc.nav')
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <h3 class="card-header">Add Certificate</h3>
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
                                                        <option value="{{ $template['shortForm'] }}">
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
                                                    <option value="D">Draft</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label for="cat" class="form-label">Standard</label>
                                                <input type="text" class="form-control" name="standard_name"
                                                    value="{{ @$lead->standard->standard_name }}" id="cat">
                                                <input type="hidden" name="certificate_id" value="{{ @$certificate->id }}">
                                                <input type="hidden" name="lead_id" value="{{ @$lead->id }}">
                                            </div>
                                            <div class="col-12">
                                                <label for="cat" class="form-label">Standard Full Form</label>
                                                <input type="text" class="form-control" name="standard_description"
                                                    value="{{ @$lead->standard->description }}" id="cat">
                                            </div>
                                            <div class="col-12">
                                                <label for="cat" class="form-label">Business Name</label>
                                                <textarea class="form-control" name="business_name"> {{ @$lead->name }}</textarea>
                                            </div>
                                            <div class="col-12">
                                                <label for="cat" class="form-label">Address</label>
                                                <textarea class="form-control" name="business_name_secondary">{{ @$lead->address }}</textarea>
                                            </div>
                                            <div class="col-12">
                                                <label for="subcat" class="form-label">Scope of Registration</label>
                                                <textarea class="form-control" name="scope_registration">{{ @$lead->scope_activity }}</textarea>
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Content -->
                </div>
                <!-- Content wrapper -->

            </div>
        </div>
    </div>
@endsection
