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
                                <h3 class="card-header">All Document</h3>
                            </div>
                        </div>
                    </div>

                    <div class="container-xxl flex-grow-1 container-p-y">



                        <!-- Basic Bootstrap Table -->
                        <div class="card shadow p-3 ">
                            <table id="example" class="table " style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Uploaded By</th>
                                        <th>Consultant</th>
                                        <th>Business Name</th>
                                        <th>Certificate Status</th>
                                        <th>Date</th>
                                        <th>File Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($documents as $document)
                                        <tr>
                                            <td>{{ $document->user->name }}</td>
                                            <td>{{ $document->certificate->lead->name }}</td>
                                            <td>{{ $document->certificate->business_name }}</td>
                                            <td>
                                                @if ($document->certificate->certificate_status == 'D')
                                                    Draft
                                                @else
                                                    Final
                                                @endif
                                            </td>
                                            <td>{{ date('Y-m-d', strtotime($document->created_at)) }}</td>
                                            <td>
                                                {{ $document->file_name }}
                                            </td>
                                            <td>
                                                @if ($document->status == 'A')
                                                    Approved
                                                @elseif ($document->status == 'R')
                                                    Rejected
                                                @else
                                                    --
                                                @endif
                                            </td>

                                            <td>
                                                <a href="{{ route('approve.document', ['id' => $document->id]) }}"
                                                    class="btn btn-success">Approve</a>
                                                <a href="{{ route('reject.document', ['id' => $document->id]) }}"
                                                    class="btn btn-danger">Reject</a>
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
