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
                                <h3 class="card-header">All Payment</h3>
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
                                        <th>Certificate Name</th>
                                        <th>Payment Received</th>
                                        <th>Mode</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payments as $payment)
                                        <tr>
                                            <td>{{ @$payment->user->name }}</td>
                                            <td>{{ @$payment->certificate->business_name }}</td>
                                            <td>{{ $payment->payment_balance }}</td>
                                            <td>{{ $payment->payment_type }}</td>
                                            <td>{{ date('d-m-Y', strtotime($payment->created_at)) }}</td>
                                            @if ($payment->status == 'A')
                                                <td>Approved</td>
                                            @elseif ($payment->status == 'R')
                                                <td>Rejected</td>
                                            @else
                                                <td></td>
                                            @endif
                                            <td>
                                                <a href="{{ route('approve.payment', ['id' => $payment->id]) }}"
                                                    class="btn btn-success">Approve</a>
                                                <a href="{{ route('reject.payment', ['id' => $payment->id]) }}"
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
