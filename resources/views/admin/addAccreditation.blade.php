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
                        <h3 class="card-header">Add Accreditation</h3>
                        <!--Add Leads -->
                        <div class="row">
                            <!---Layout -->
                            <div class="col col-12 col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <form class="row g-3" action="{{ route('admin.store.accreditation') }}"
                                            method="post">
                                            @csrf
                                            <!-- Use auto complete js https://jqueryui.com/autocomplete/ -->

                                            {{-- <div class="col-12 col-lg-7">
                                                <label for="cat" class="form-label">Active</label>
                                                <select class="form-control" name="active">
                                                    <option value="">Select</option>
                                                    <option value="Y">Yes</option>
                                                    <option value="N">No</option>
                                                </select>
                                                @error('certificate_template')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div> --}}
                                            <div class="col-7">
                                                <label for="accreditation_name" class="form-label">Accreditation
                                                    name</label>
                                                <input type="text" name="accreditation_name" class="form-control"
                                                    id="accreditation_name" value="{{ @$accr->accreditation_name }}">
                                                <input type="hidden" name="id" value="{{ @$accr->id }}">

                                            </div>



                                            <div class="">
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


                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <div class="d-flex col-12">
                                <h3 class="card-header">All Accreditations</h3>
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
                                        <th>Accreditation Name</th>
                                        {{-- <th>Active</th> --}}
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (@$accreditations as $index => $accreditation)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $accreditation->accreditation_name }}</td>
                                            <td>
                                                <a
                                                    href="{{ route('admin.edit.accreditation', ['id' => $accreditation->id]) }}">Edit</a>
                                                @if (@$accr->id == null)
                                                    |
                                                    <a
                                                        href="{{ route('admin.delete.accreditation', ['id' => $accreditation->id]) }}">Delete</a>
                                                @endif
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

            </div>
        </div>
    </div>
@endsection
