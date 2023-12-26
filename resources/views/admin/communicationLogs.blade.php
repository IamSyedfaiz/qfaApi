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
                        <div class="col ">
                            <h3 class="card-header float-start">Communication Logs</h3>
                        </div>
                    </div>

                    <!-- Basic Bootstrap Table -->
                    <div class="card shadow p-3 ">


                        <table id="example" class="table " style="width:100%">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Message</th>
                                    <th>Sender</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($communications as $communication)
                                <tr>
                                    <td>{{ $communication->getTypeLabel() }}</td>
                                    <td>{{ $communication->created_at->format('d F Y') }}</td>
                                    <td>{{ $communication->created_at->format('h:i A') }}</td>
                                    <td>{{ $communication->message }}</td>
                                    <td>
                                        @if ($communication->user)
                                        {{ $communication->user->name }}
                                        @else
                                        N/A
                                        @endif
                                    </td>
                                    <td><a href="{{ route('admin.communication.view', ['id' => $communication->id]) }}">View</a>
                                    </td>

                                </tr>
                                @endforeach

                            </tbody>

                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Message</th>
                                    <th>Sender</th>
                                    <th>Action</th>

                                </tr>
                            </thead>

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
