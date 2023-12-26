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

                                <h3 class="card-header float-start">Communication Details</h3>
                                {{-- <a href="{{ route('back') }}" class="card-header float-end"><i class="bi bi-arrow-left"></i>
                                    Return</a> --}}

                            </div>
                        </div>
                        <!-- Basic Bootstrap Table -->
                        <div class="row ">
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <h5 class="mb-0">Message</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row   ">
                                            <div class="col col-12 ">
                                                <ul class="logssmall ">
                                                    <p class="">{{ $communication->message }}</p>
                                                </ul>
                                            </div>

                                        </div>
                                    </div>
                                    @if ($communication->subject)
                                        <div class="card-header d-flex align-items-center justify-content-between">
                                            <h5 class="mb-0">Subject</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col col-12">
                                                    <ul class="logssmall">
                                                        <p>{{ $communication->subject }}</p>
                                                    </ul>
                                                </div>

                                            </div>
                                        </div>
                                    @endif
                                    @if ($communication->status)
                                        <div class="card-header d-flex align-items-center justify-content-between">
                                            <h5 class="mb-0">Status</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col col-12">
                                                    <ul class="logssmall">
                                                        <p>
                                                            @if ($communication->type == 'm')
                                                                @if ($communication->status === 'o')
                                                                    Done
                                                                @elseif ($communication->status === 'i')
                                                                    In Progress
                                                                @endif
                                                            @else
                                                                @if ($communication->status === 'o')
                                                                    Outgoing
                                                                @elseif ($communication->status === 'i')
                                                                    Incoming
                                                                @endif
                                                            @endif
                                                        </p>
                                                    </ul>
                                                </div>

                                            </div>
                                        </div>
                                    @endif
                                    @if (@$communication->file)
                                        @php
                                            $imageUrls = json_decode($communication->file);
                                        @endphp

                                        @if (is_array($imageUrls) && count($imageUrls) > 0)
                                            <div class="card-header d-flex align-items-center justify-content-between">
                                                <h5 class="mb-0">File</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col col-12">
                                                        <img src="{{ asset($imageUrls[0]) }}" alt="File Image"
                                                            class="img-fluid">
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif

                                    {{-- @if ($communication->file)
                                        <div class="card-header d-flex align-items-center justify-content-between">
                                            <h5 class="mb-0">File</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                @php
                                                    $fileNames = explode(',', $communication->file);
                                                @endphp
                                                @if (is_array($fileNames))
                                                    @foreach ($fileNames as $filename)
                                                        <div class="col col-12 mt-2">
                                                            <img src="{{ $filename }}" alt="File Image"
                                                                class="img-fluid">
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="col col-12">
                                                        <p>No valid files found.</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif --}}


                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <h5 class="mb-0">Date Time</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col col-12">
                                                <ul class="logssmall">
                                                    <p>{{ $communication->formattedDateTime }}</p>
                                                </ul>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <h5 class="mb-0">Type</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col col-12">
                                                <ul class="logssmall">
                                                    <p>{{ $communication->getTypeLabel() }}</p>
                                                </ul>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <h5 class="mb-0">Date Time</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col col-12">
                                                <ul class="logssmall">
                                                    <p>
                                                        @if ($communication->user)
                                                            {{ $communication->user->name }}
                                                        @else
                                                            N/A
                                                        @endif
                                                    </p>
                                                </ul>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
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
