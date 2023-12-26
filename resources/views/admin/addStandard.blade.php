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
                        <h3 class="card-header">Add standard</h3>
                        <!--Add Leads -->
                        <div class="row">
                            <!---Layout -->
                            <div class="col col-12 col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <form class="row g-3" action="{{ route('admin.store.standard') }}" method="post">
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
                                                <label for="standard_name" class="form-label">Standard Name</label>
                                                <input type="text" name="standard_name" class="form-control"
                                                    value="{{ @$stand->standard_name }}" id="standard_name">
                                                <input type="hidden" name="id" value="{{ @$stand->id }}">
                                            </div>
                                            <div class="col-7">
                                                <label for="description" class="form-label">Standard Full Form</label>
                                                <input type="text" name="description" class="form-control"
                                                    value="{{ @$stand->description }}" id="description">
                                                <input type="hidden" name="id" value="{{ @$stand->id }}">
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
                                <h3 class="card-header">All standards</h3>
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
                                        <th>Standard Name</th>
                                        <th>Standard Full Form</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (@$standards as $index => $standard)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $standard->standard_name }}</td>
                                            <td>{{ $standard->description }}</td>
                                            <td>
                                                <a
                                                    href="{{ route('admin.edit.standard', ['id' => $standard->id]) }}">Edit</a>
                                                @if (@$stand->id == null)
                                                    |
                                                    <a
                                                        href="{{ route('admin.delete.standard', ['id' => $standard->id]) }}">Delete</a>
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
