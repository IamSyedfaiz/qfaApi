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
                                <h3 class="card-header">All Certificates</h3>
                                {{-- <a href="#" class="btn btn-primary my-auto float-end">EXPORT DATA</a> --}}
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
                                            <td>{{ $certificate->certificate_status }}</td>
                                            <td>{{ $certificate->certificate_template }}</td>
                                            <td>{{ $certificate->standard }}</td>
                                            <td>
                                                <a href="{{ route('certificate.create', ['id' => $certificate->id]) }}"
                                                    class="btn btn-primary">View</a>
                                                <a href="{{ route('admin.certificate.edit', ['id' => $certificate->id]) }}"
                                                    class="btn btn-danger">Edit</a>
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
