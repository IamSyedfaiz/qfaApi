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
                                <h3 class="card-header">All Leads</h3>
                            </div>
                        </div>
                    </div>

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <!-- Basic Bootstrap Table -->
                        <div class="card shadow p-3 ">
                            <table id="example" class="table " style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Company Name</th>
                                        <th>Date</th>
                                        <th>Number Of Employees</th>
                                        <th>Status</th>
                                        <th>Number</th>
                                        <th>State/country</th>
                                        <th>location</th>
                                        <th>standard</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (@$leads as $index => $lead)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $lead->name }}</td>
                                            <td>{{ $lead->date }}</td>
                                            <td>{{ $lead->contact_person ?? '--' }}</td>
                                            <td>{{ $lead->status->name ?? '--' }}</td>
                                            <td>{{ $lead->number }}</td>
                                            <td>{{ $lead->city }}</td>
                                            <td>{{ $lead->address }}</td>
                                            <td>{{ @$lead->standard->standard_name }}</td>
                                            <td><a href="{{ route('admin.lead.view', ['id' => $lead->id]) }}">View</a></td>

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
