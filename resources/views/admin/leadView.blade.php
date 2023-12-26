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
                        <h3 class="card-header">View Lead</h3>
                        <!-- Basic Layout & Basic with Icons -->
                        <div class="row">
                            <!-- Basic Layout -->
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <form action="{{ route('lead.update') }}" method="post">
                                            @csrf
                                            <div class="row mb-3">
                                                <div class="col col-12 col-md-6">
                                                    <input type="text" class="form-control mb-3" id="basic-default-name"
                                                        name="name" placeholder="Name" value="{{ $lead->name }}" />
                                                    <input type="hidden" name="lead_id" value="{{ $lead->id }}">
                                                </div>
                                                <div class="col col-12 col-md-6">
                                                    <input type="email" class="form-control mb-3" id="basic-default-email"
                                                        name="email" placeholder="Email" value="{{ $lead->email }}" />
                                                </div>

                                                <div class="col  col-12 col-md-6">
                                                    <input type="number" class="form-control mb-3"
                                                        id="basic-default-number" placeholder="Number" name="number"
                                                        value="{{ $lead->number }}" />
                                                </div>
                                                <div class="col  col-12 col-md-6">
                                                    <input type="number" class="form-control mb-3"
                                                        id="basic-default-number" placeholder="Number Of Employees"
                                                        name="contact_person" value="{{ $lead->contact_person }}" />
                                                </div>

                                                <div class="col col-12 col-md-6">
                                                    @php
                                                        $leadUsers = explode(',', $lead->allocate_user);

                                                    @endphp
                                                    <select class="form-select form-control mb-3" name="allocate_user[]"
                                                        multiple>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}"
                                                                {{ in_array($user->id, $leadUsers) ? 'selected' : '' }}>
                                                                {{ $user->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                                <div class="col  col-12 col-md-6">
                                                    <textarea class="form-control mb-3" name="address" id="" cols="30" rows="3" placeholder="Address">{{ $lead->address }}</textarea>
                                                </div>
                                                <div class="col col-12 col-md-6">
                                                    <select class="form-select form-control mb-3" name="standard_id"
                                                        required>
                                                        @foreach ($standards as $standard)
                                                            <option value="{{ $standard->id }}"
                                                                {{ $standard->id == old('standard_id', $lead->standard) ? 'selected' : '' }}>
                                                                {{ $standard->standard_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('standard_id'))
                                                        <div class="error text-danger text-sm">
                                                            {{ $errors->first('standard_id') }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col col-12 col-md-6">
                                                    <select class="form-select form-control mb-3" name="accreditation_id"
                                                        required>
                                                        @foreach ($accreditations as $accreditation)
                                                            <option value="{{ $accreditation->id }}"
                                                                {{ $accreditation->id == old('accreditation_id', $lead->accreditation) ? 'selected' : '' }}>
                                                                {{ $accreditation->accreditation_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('accreditation_id'))
                                                        <div class="error text-danger text-sm">
                                                            {{ $errors->first('accreditation_id') }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col  col-12 col-md-12">
                                                    <select class="form-select form-control mb-3" name="status_id">
                                                        @foreach ($statuses as $status)
                                                            <option value="{{ $status->id }}"
                                                                {{ $status->id == old('status_id', $lead->status_id) ? 'selected' : '' }}>
                                                                {{ $status->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col  col-12 col-md-6">
                                                    <select class="form-select form-control mb-3" name="lead_source_id"
                                                        required>
                                                        @foreach ($leadSources as $leadSource)
                                                            <option value="{{ $leadSource->id }}"
                                                                {{ $leadSource->id == old('lead_source_id', $lead->lead_source_id) ? 'selected' : '' }}>
                                                                {{ $leadSource->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('lead_source_id'))
                                                        <div class="error text-danger text-sm">
                                                            {{ $errors->first('lead_source_id') }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col  col-12 col-md-6">
                                                    <input type="text" class="form-control mb-3" name="lead_source_text"
                                                        id="basic-default-status" value="{{ $lead->lead_source_text }}"
                                                        placeholder="Lead Source Text Box" required />
                                                    @if ($errors->has('lead_source_text'))
                                                        <div class="error text-danger text-sm">
                                                            {{ $errors->first('lead_source_text') }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col col-12 col-md-3">
                                                    <select class="form-select form-control mb-3" id="gstSelect"
                                                        name="gst">
                                                        <option value="">Select GST</option>
                                                        <option value="w" {{ $lead->gst == 'w' ? 'selected' : '' }}>
                                                            With GST</option>
                                                        <option value="o" {{ $lead->gst == 'o' ? 'selected' : '' }}>
                                                            Without GST
                                                        </option>
                                                    </select>
                                                    @if ($errors->has('gst'))
                                                        <div class="text-danger text-sm">
                                                            {{ $errors->first('gst') }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col col-12 col-md-3" id="additionalOptionsContainer">
                                                    <select class="form-select form-control mb-3" id="additionalOptions"
                                                        name="additional_options">
                                                        <option value="">Select Additional Option</option>
                                                        <option value="i"
                                                            {{ $lead->additional_options == 'i' ? 'selected' : '' }}>
                                                            Inclusive</option>
                                                        <option value="e"
                                                            {{ $lead->additional_options == 'e' ? 'selected' : '' }}>
                                                            Exclusive</option>
                                                    </select>
                                                    @if ($errors->has('additional_options'))
                                                        <div class="text-danger text-sm">
                                                            {{ $errors->first('additional_options') }}
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="col col-12 col-md-6">
                                                    <input type="text" class="form-control mb-3" name="city"
                                                        value="{{ $lead->city }}" id="basic-default-date"
                                                        placeholder="State/country" required />

                                                    @if ($errors->has('city'))
                                                        <div class="error text-danger text-sm">
                                                            {{ $errors->first('city') }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col col-12 col-md-6">
                                                    <input type="number" class="form-control mb-3"
                                                        id="basic-default-amount" placeholder="amount" name="amount"
                                                        value="{{ $lead->amount }}" />
                                                    @error('amount')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col  col-12 col-md-12">
                                                    <textarea class="form-control mb-3" id="" cols="30" rows="3" placeholder="Scope of Activity"
                                                        name="scope_activity">{{ $lead->scope_activity }}</textarea>
                                                    @if ($errors->has('scope_activity'))
                                                        <div class="error text-danger text-sm">
                                                            {{ $errors->first('scope_activity') }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col  col-12 col-md-12">
                                                    <textarea class="form-control mb-3" id="" cols="30" rows="3" placeholder="Comments"
                                                        name="comment">{{ $lead->comment }}</textarea>
                                                    @if ($errors->has('comment'))
                                                        <div class="error text-danger text-sm">
                                                            {{ $errors->first('comment') }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <input type="submit" class="btn btn-primary" value="Submit">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <h5 class="mb-0">Recent Interaction</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col col-12">
                                                <ul class="logssmall">
                                                    @foreach ($communications as $communication)
                                                        <li>
                                                            <p>{{ $communication->getTypeLabel() }}
                                                                @if ($communication->type == 'm')
                                                                    @if ($communication->status === 'o')
                                                                        -Done
                                                                    @elseif ($communication->status === 'i')
                                                                        -In Progress
                                                                    @endif
                                                                @else
                                                                    @if ($communication->status === 'o')
                                                                        -Outgoing
                                                                    @elseif ($communication->status === 'i')
                                                                        -Incoming
                                                                    @endif
                                                                @endif
                                                            </p>
                                                            <p>{{ $communication->formattedDateTime }}</p>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <a href="{{ route('admin.communication.logs', ['id' => $lead->id]) }}">View
                                            All</a>
                                    </div>
                                </div>

                            </div>
                            <!-- Basic with Icons -->
                            <div class="col-12">
                                <div class="card mb-4">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <h5 class="mb-0">Intervention</h5>
                                    </div>
                                    <div class="card-body">

                                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                                    data-bs-target="#pills-home" type="button" role="tab"
                                                    aria-controls="pills-home" aria-selected="true"><i
                                                        class="fas fa-phone"></i>
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                                    data-bs-target="#pills-profile" type="button" role="tab"
                                                    aria-controls="pills-profile" aria-selected="false"><i
                                                        class="fas fa-envelope"></i>
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                                    data-bs-target="#pills-contact" type="button" role="tab"
                                                    aria-controls="pills-contact" aria-selected="false"><i
                                                        class="fab fa-whatsapp" aria-hidden="true"></i></button>
                                            </li>
                                            @if (@auth()->user()->role->meeting == 'Y' || auth()->user()->id == 1)
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="pills-meeting-tab" data-bs-toggle="pill"
                                                        data-bs-target="#pills-meeting" type="button" role="tab"
                                                        aria-controls="pills-meeting" aria-selected="false"><i
                                                            class="fa fa-handshake" aria-hidden="true"></i></button>
                                                </li>
                                            @endif

                                        </ul>
                                        <div class="tab-content" id="pills-tabContent">
                                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                                aria-labelledby="pills-home-tab" tabindex="0">
                                                <form action="{{ route('store.communication.call') }}" method="post">
                                                    @csrf
                                                    <textarea name="message" id="" cols="30" rows="5" placeholder="Conversation Summary here"
                                                        class="form-control" required></textarea>
                                                    <div class="row mt-4">
                                                        <div class="col col-12 col-md-4">
                                                            <label for="Call">Call Date Time</label>
                                                            <input type="datetime-local" name="date_time" id=""
                                                                required class="form-control">
                                                            <input type="hidden" name="type" value="c">
                                                            <input type="hidden" name="lead_id"
                                                                value="{{ $lead->id }}">
                                                            <input type="hidden" name="user_id"
                                                                value="{{ auth()->user()->id }}">
                                                        </div>
                                                        <div class="col col-12 col-md-4">
                                                            <label for="Call">Call Status</label>
                                                            <select class="form-select" name="status" required
                                                                aria-label="Default select example">
                                                                <option value="">Select Status</option>
                                                                <option value="o">Outgoing</option>
                                                                <option value="i">Incoming</option>
                                                            </select>
                                                        </div>

                                                    </div>
                                                    <button type="submit"
                                                        class="btn btn-primary mt-5 w-100">Submit</button>
                                                </form>
                                            </div>
                                            <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                                aria-labelledby="pills-profile-tab" tabindex="0">
                                                <form action="{{ route('store.communication.email') }}" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <textarea name="message" id="" cols="30" rows="5" placeholder="Mail content here"
                                                        class="form-control" required></textarea>
                                                    <div class="row mt-4">
                                                        <div class="col col-12 col-md-4">
                                                            <label for="Call">Mail Subject</label>
                                                            <input type="text" name="subject" id="" required
                                                                class="form-control">
                                                            <input type="hidden" name="type" value="e">
                                                            <input type="hidden" name="lead_id"
                                                                value="{{ $lead->id }}">
                                                            <input type="hidden" name="user_id"
                                                                value="{{ auth()->user()->id }}">
                                                        </div>
                                                        <div class="col col-12 col-md-4 ms-auto">
                                                            <label for="file">Attachment</label>
                                                            <input type="file" name="file[]" id="file" multiple
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    <button type="submit"
                                                        class="btn btn-primary mt-5 w-100">Submit</button>
                                                </form>
                                            </div>
                                            <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                                aria-labelledby="pills-contact-tab" tabindex="0">
                                                <form action="{{ route('store.communication.whatsapp') }}" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <textarea name="message" id="" cols="30" rows="5" placeholder="Chat Summary here"
                                                        class="form-control" required></textarea>
                                                    <div class="row mt-4">
                                                        <div class="col col-12 col-md-4">
                                                            <label for="Call">Attachment</label>
                                                            <input type="file" name="file[]" class="form-control">
                                                            <input type="hidden" name="lead_id"
                                                                value="{{ $lead->id }}">
                                                            <input type="hidden" name="type" value="w">
                                                            <input type="hidden" name="user_id"
                                                                value="{{ auth()->user()->id }}">
                                                        </div>
                                                    </div>
                                                    <button type="submit"
                                                        class="btn btn-primary mt-5 w-100">Submit</button>
                                                </form>
                                            </div>
                                            @if (@auth()->user()->role->meeting == 'Y' || auth()->user()->id == 1)
                                                <div class="tab-pane fade" id="pills-meeting" role="tabpanel"
                                                    aria-labelledby="pills-meeting-tab" tabindex="0">
                                                    <form action="{{ route('store.communication.meeting') }}"
                                                        method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <textarea name="message" id="" cols="30" rows="5" placeholder="Chat Summary here"
                                                            class="form-control" required></textarea>
                                                        <div class="row mt-4">
                                                            <div class="col col-12 col-md-4">
                                                                <label for="Call">Attachment</label>
                                                                <input type="file" name="file[]" id=""
                                                                    multiple class="form-control">
                                                            </div>
                                                            <div class="col col-12 col-md-4">
                                                                <label for="Call">Date Time</label>
                                                                <input type="datetime-local" name="date_time"
                                                                    id="" required class="form-control">
                                                                <input type="hidden" name="lead_id"
                                                                    value="{{ $lead->id }}">
                                                                <input type="hidden" name="type" value="m">
                                                                <input type="hidden" name="user_id"
                                                                    value="{{ auth()->user()->id }}">
                                                            </div>
                                                            <div class="col col-12 col-md-4">
                                                                <label for="Call">Meeting Status</label>
                                                                <select class="form-select" name="status" required
                                                                    aria-label="Default select example">
                                                                    <option value="">Select Status</option>
                                                                    <option value="o">Done</option>
                                                                    <option value="i">In Progress</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <button type="submit"
                                                            class="btn btn-primary mt-5 w-100">Submit</button>
                                                    </form>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5>Set Follow up</h5>

                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('store.follow.up') }}" method="POST">
                                            @csrf
                                            <div class="col col-12 col-md-4">
                                                <label for="Call">Next Followup</label>
                                                <input type="datetime-local" class="form-control" required
                                                    name="date_time">
                                            </div>
                                            <input type="text" value="{{ $lead->id }}" name="lead_id" hidden>

                                            <button type="submit" class="btn btn-primary mt-5 w-100">Submit</button>
                                        </form>

                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Set Follow up</h5>
                                    </div>
                                    <div class="card-body">
                                        <table id="example" class="table " style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Set By</th>
                                                    <th>Status</th>
                                                    <th>Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($followUps as $index => $followUp)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $followUp->user->name }}</td>
                                                        <td>
                                                            @if ($followUp->status == 'C')
                                                                <span class="text-success">Complete</span>
                                                            @else
                                                                @if (\Carbon\Carbon::now()->gt($followUp->date_time))
                                                                    <span class="text-danger">InComplete</span>
                                                                @else
                                                                    <span class="text-success">Padding</span>
                                                                @endif
                                                            @endif

                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($followUp->date_time)->format('d-m-Y') }}
                                                        </td>
                                                        <td>
                                                            @if (\Carbon\Carbon::now()->gt($followUp->date_time))
                                                                <span class="text-danger">InComplete</span>
                                                            @else
                                                                @if ($followUp->status == 'C')
                                                                    Done
                                                                @else
                                                                    <a
                                                                        href="{{ route('changeStatus.followup', ['id' => $followUp->id]) }}">Mark
                                                                        a Complete</a>
                                                                @endif
                                                            @endif
                                                            | <a class="text-secondary"
                                                                href="{{ route('delete.followup', ['id' => $followUp->id]) }}">Delete</a>
                                                        </td>
                                                    </tr>
                                                @endforeach


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Row 2  -->

                    </div>
                    <!-- / Content -->
                </div>
                <!-- Content wrapper -->

            </div>
        </div>
    </div>
@endsection
