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
                            <table id="example" class="table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        {{-- <th>Unique Query ID</th> --}}
                                        {{-- <th>Query Type</th>
                                        <th>Query Time</th> --}}
                                        <th>Sender Name</th>
                                        <th>Sender Mobile</th>
                                        <th>Sender Email</th>
                                        <th>Subject</th>
                                        <th>Sender Company</th>
                                        <th>Sender Address</th>
                                        <th>Sender City</th>
                                        {{-- <th>Sender State</th> --}}
                                        {{-- <th>Sender Pincode</th>
                                        <th>Sender Country ISO</th>
                                        <th>Sender Mobile Alt</th>
                                        <th>Sender Phone</th>
                                        <th>Sender Phone Alt</th>
                                        <th>Sender Email Alt</th>
                                        <th>Query Product Name</th>
                                        <th>Query Message</th>
                                        <th>Query MCAT Name</th> --}}
                                        {{-- <th>Call Duration</th> --}}
                                        {{-- <th>Receiver Mobile</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($leads as $lead)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            {{-- <td>{{ $lead['unique_query_id'] ?? 'N/A' }}</td> --}}
                                            {{-- <td>{{ $lead['query_type'] ?? 'N/A' }}</td>
                                            <td>{{ $lead['query_time'] ?? 'N/A' }}</td> --}}
                                            <td>{{ $lead['sender_name'] ?? '--' }}</td>
                                            <td>{{ $lead['sender_mobile'] ?? '--' }}</td>
                                            <td>{{ $lead['sender_email'] ?? '--' }}</td>
                                            <td>{{ $lead['subject'] ?? '--' }}</td>
                                            <td>{{ $lead['sender_company'] ?? '--' }}</td>
                                            <td>{{ $lead['sender_address'] ?? '--' }}</td>
                                            <td>{{ $lead['sender_city'] ?? '--' }}</td>
                                            {{-- <td>{{ $lead['sender_state'] ?? 'N/A' }}</td> --}}
                                            {{-- <td>{{ $lead['sender_pincode'] ?? 'N/A' }}</td>
                                            <td>{{ $lead['sender_country_iso'] ?? 'N/A' }}</td>
                                            <td>{{ $lead['sender_mobile_alt'] ?? 'N/A' }}</td>
                                            <td>{{ $lead['sender_phone'] ?? 'N/A' }}</td>
                                            <td>{{ $lead['sender_phone_alt'] ?? 'N/A' }}</td>
                                            <td>{{ $lead['sender_email_alt'] ?? 'N/A' }}</td>
                                            <td>{{ $lead['query_product_name'] ?? 'N/A' }}</td>
                                            <td>{{ $lead['query_message'] ?? 'N/A' }}</td>
                                            <td>{{ $lead['query_mcat_name'] ?? 'N/A' }}</td> --}}
                                            {{-- <td>{{ $lead['call_duration'] ?? 'N/A' }}</td> --}}
                                            {{-- <td>{{ $lead['receiver_mobile'] ?? 'N/A' }}</td> --}}
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
