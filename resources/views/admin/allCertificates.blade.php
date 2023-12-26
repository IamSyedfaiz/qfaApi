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
                        <div class="row">
                            <div class="d-flex col-12">
                                <h3 class="card-header">All Lead</h3>
                            </div>
                        </div>
                    </div>

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="card shadow p-3 ">
                            <table id="example" class="table " style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Lead Name</th>
                                        <th>Business Name</th>
                                        <th>Status</th>
                                        <th>Last Contacted</th>
                                        <th>Allocation</th>
                                        <th>Certificate Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (@$leads as $index => $lead)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $lead->name }}</td>
                                            <td>{{ $lead->certificate->business_name ?? '--' }}</td>
                                            <td>{{ $lead->status->name }}</td>
                                            <td>{{ $lead->date }}</td>
                                            <td>
                                                @php
                                                    $leadUsers = explode(',', $lead->allocate_user);
                                                @endphp

                                                @foreach ($leadUsers as $leadUserId)
                                                    @foreach ($users as $user)
                                                        @if ($user->id == $leadUserId)
                                                            {{ $user->name }},
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            </td>
                                            <td>
                                                @if ($lead->certificate)
                                                    @if ($lead->certificate->certificate_status == 'D')
                                                        Draft
                                                    @elseif ($lead->certificate->certificate_status == 'F')
                                                        Final
                                                    @else
                                                        --
                                                    @endif
                                                @else
                                                    --
                                                @endif

                                            </td>
                                            <td>
                                                {{-- @if ($lead->certificate)
                                                    <a
                                                        href="{{ route('admin.certificate.edit', ['id' => $lead->id]) }}">Edit</a>
                                                    |
                                                @endif --}}
                                                <a
                                                    href="{{ route('admin.add.certificate', ['id' => $lead->id]) }}">Create</a>
                                                {{-- @if ($lead->certificate)
                                                    <a href="{{ route('admin.certificate.edit', ['id' => $lead->id]) }}">Edit
                                                        Certificate</a> |
                                                    <a
                                                        href="{{ route('admin.view.certificate', ['id' => $lead->id]) }}">View</a>
                                                @else
                                                    <a href="{{ route('admin.add.certificate', ['id' => $lead->id]) }}">Create
                                                        Certificate</a>
                                                @endif --}}
                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>

                        </div>
                        <!--/ Basic Bootstrap Table -->
                    </div>
                    <!-- / Content -->
                </div>
                <!-- Content wrapper -->
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <div class="d-flex col-12">
                                <h3 class="card-header">All Certificates</h3>
                                {{-- <a href="#" class="btn btn-primary my-auto float-end">EXPORT DATA</a> --}}
                            </div>
                        </div>
                    </div>

                    <div class="container-xxl flex-grow-1 container-p-y">


                        {{-- // $certificateTemplates = [['value' => 'ENERGY', 'shortForm' => 'qfsENERGY'], ['value' => 'Anti-bribery', 'shortForm' => 'qfsAb'], ['value' => 'Occupational Health & Safety', 'shortForm' => 'qfsOHS'], ['value' => 'Environment', 'shortForm' => 'qfsE'], ['value' => 'IT Service', 'shortForm' => 'qfsITS'], ['value' => 'Food Safety', 'shortForm' => 'qfsFS'], ['value' => 'Business', 'shortForm' => 'qfsBus'], ['value' => 'Information Security', 'shortForm' => 'IS'], ['value' => 'Quality', 'shortForm' => 'qfsQ'], ['value' => 'Food Safety', 'shortForm' => 'FS'], ['value' => 'IT Service', 'shortForm' => 'ITS'], ['value' => 'Environment', 'shortForm' => 'E'], ['value' => 'ENERGY', 'shortForm' => 'ENERGY'], ['value' => 'Occupational Health & Safety', 'shortForm' => 'OHS'], ['value' => 'hawk-eye', 'shortForm' => 'HEC'], ['value' => 'GDPR', 'shortForm' => 'GDPR'], ['value' => 'Certificate of Registration', 'shortForm' => 'COR'], ['value' => 'Certificate of Compliance', 'shortForm' => 'COC']];
                        // $selectedCertificate = $certificate->certificate_template;
                        // $displayedValue = '';

                        // foreach ($certificateTemplates as $template) {
                        //     if ($selectedCertificate == $template['shortForm']) {
                        //         $displayedValue = $template['value'];
                        //         break;
                        //     }
                        // } --}}
                        <!-- Basic Bootstrap Table -->
                        <div class="card shadow p-3 ">
                            <table id="example2" class="table " style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Business Name</th>
                                        <th>Certificate Status</th>
                                        <th>Certificate Template</th>
                                        <th>standard</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($certificates as $index => $certificate)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $certificate->business_name }}</td>
                                            <td>
                                                @if ($certificate->certificate_status == 'D')
                                                    Draft
                                                @elseif ($certificate->certificate_status == 'F')
                                                    Final
                                                @else
                                                    --
                                                @endif
                                            </td>
                                            <td>
                                                @php

                                                    $certificateOption = $certificate->certificate_template;
                                                    $certificateTemplates = [];
                                                    $displayedValue = '';
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
                                                    foreach ($certificateTemplates as $template) {
                                                        if ($selectedCertificate == $template['shortForm']) {
                                                            $displayedValue = $template['value'];
                                                            break;
                                                        }
                                                    }
                                                @endphp

                                                {{ $displayedValue }}
                                            </td>
                                            <td>{{ $certificate->standard_name }}</td>
                                            <td>
                                                <a href="{{ route('admin.view.certificate', ['id' => $certificate->id]) }}"
                                                    class="btn btn-primary">View</a>
                                                <a href="{{ route('admin.certificate.edit', ['id' => $certificate->id]) }}"
                                                    class="btn btn-warning">Edit</a>
                                                <a href="{{ route('admin.certificate.delete', ['id' => $certificate->id]) }}"
                                                    class="btn btn-danger">Delete</a>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!--/ Basic Bootstrap Table -->
                    </div>
                    <!-- / Content -->
                </div>
                <!-- Content wrapper -->
            </div>
        </div>
    </div>
@endsection
