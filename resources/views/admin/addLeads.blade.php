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
                        <h3 class="card-header">Add Leads</h3>
                        <!--Add Leads -->
                        <div class="row">
                            <!---Layout -->
                            <div class="col col-12 col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <form action="{{ route('lead.store') }}" method="post">
                                            @csrf
                                            <div class="row mb-3">
                                                <div class="col col-12 col-md-6">
                                                    <input type="text" class="form-control mb-3" id="basic-default-name"
                                                        placeholder="Name" name="name" required
                                                        value="{{ old('name') }}" />
                                                    @error('name')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col col-12 col-md-6">
                                                    <input type="email" class="form-control mb-3" id="basic-default-email"
                                                        placeholder="Email" name="email" required
                                                        value="{{ old('email') }}" />
                                                    @error('email')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col  col-12 col-md-6">
                                                    <input type="number" class="form-control mb-3"
                                                        id="basic-default-number" placeholder="Mobile Number" name="number"
                                                        required value="{{ old('number') }}" />
                                                    @error('number')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col  col-12 col-md-6">
                                                    <input type="number" class="form-control mb-3"
                                                        id="basic-default-number" placeholder="Number of employees"
                                                        name="contact_person" value="{{ old('contact_person') }}"
                                                        required />
                                                    @error('contact_person')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col col-12 col-md-6">
                                                    <select class="form-select form-control mb-3" multiple
                                                        name="allocate_user[]" required>
                                                        <option value=""> Select Allocate User</option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}"
                                                                {{ in_array($user->id, old('allocate_user', [])) ? 'selected' : '' }}>
                                                                {{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('allocate_user'))
                                                        <div class="error text-danger text-sm">
                                                            {{ $errors->first('allocate_user') }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col col-12 col-md-6">
                                                    <select class="form-select form-control mb-3" name="standard_id"
                                                        required>
                                                        <option value="">Select Standard</option>
                                                        @foreach ($standards as $standard)
                                                            <option value="{{ $standard->id }}"
                                                                {{ old('standard_id') == $standard->id ? 'selected' : '' }}>
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
                                                        <option value="">Select Accreditation</option>
                                                        @foreach ($accreditations as $accreditation)
                                                            <option value="{{ $accreditation->id }}"
                                                                {{ old('accreditation_id') == $accreditation->id ? 'selected' : '' }}>
                                                                {{ $accreditation->accreditation_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('accreditation_id'))
                                                        <div class="error text-danger text-sm">
                                                            {{ $errors->first('accreditation_id') }}
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="col  col-12 col-md-6">
                                                    <textarea class="form-control mb-3" id="" cols="10" rows="3" placeholder="Address" required
                                                        name="address">{{ old('address') }}</textarea>
                                                    @if ($errors->has('address'))
                                                        <div class="error text-danger text-sm">
                                                            {{ $errors->first('address') }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col col-12 col-md-6">
                                                    <input type="text" class="form-control mb-3" name="city"
                                                        value="{{ old('city') }}" id="basic-default-date"
                                                        placeholder="State/country" required />
                                                    @if ($errors->has('city'))
                                                        <div class="error text-danger text-sm">
                                                            {{ $errors->first('city') }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col  col-12 col-md-6">
                                                    <select class="form-select form-control mb-3" name="status_id" required>
                                                        <option value="">Select Status</option>

                                                        @foreach ($statuses as $status)
                                                            <option value="{{ $status->id }}"
                                                                {{ old('status_id') == $status->id ? 'selected' : '' }}>
                                                                {{ $status->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('status_id'))
                                                        <div class="error text-danger text-sm">
                                                            {{ $errors->first('status_id') }}
                                                        </div>
                                                    @endif
                                                </div>


                                                <div class="col col-12 col-md-6">
                                                    <input type="date" class="form-control mb-3" name="date"
                                                        value="{{ old('date') }}" id="basic-default-date"
                                                        placeholder="Lead Status Text Box" required />
                                                    @if ($errors->has('date'))
                                                        <div class="error text-danger text-sm">
                                                            {{ $errors->first('date') }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col col-12 col-md-3">
                                                    <select class="form-select form-control mb-3" id="gstSelect"
                                                        name="gst" required>
                                                        <option value="">Select GST</option>
                                                        <option value="w" {{ old('gst') == 'w' ? 'selected' : '' }}>
                                                            With GST</option>
                                                        <option value="o" {{ old('gst') == 'o' ? 'selected' : '' }}>
                                                            Without GST
                                                        </option>
                                                    </select>
                                                    @if ($errors->has('gst'))
                                                        <div class="text-danger text-sm">
                                                            {{ $errors->first('gst') }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col col-12 col-md-3">
                                                    <input type="number" class="form-control mb-3"
                                                        id="basic-default-amount" placeholder="amount"
                                                        id="basic-default-amount" name="amount"
                                                        value="{{ old('amount') }}" />
                                                    @error('amount')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col col-12 col-md-3" id="additionalOptionsContainer"
                                                    style="display: none;">
                                                    <select class="form-select form-control mb-3" id="additionalOptions"
                                                        name="additional_options">
                                                        <option value="">Select Additional Option</option>
                                                        <option value="i">Inclusive</option>
                                                        <option value="e">Exclusive</option>
                                                    </select>
                                                    @if ($errors->has('additional_options'))
                                                        <div class="text-danger text-sm">
                                                            {{ $errors->first('additional_options') }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <span id="adjustedAmount" class="col col-12 col-md-3"
                                                    style="display: none;"></span>
                                                <div class="col  col-12 col-md-6">
                                                    <select class="form-select form-control mb-3" name="lead_source_id"
                                                        required>
                                                        <option value="">Select Lead Source</option>
                                                        @foreach ($leadSources as $leadSource)
                                                            <option value="{{ $leadSource->id }}"
                                                                {{ old('lead_source_id') == $leadSource->id ? 'selected' : '' }}>
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
                                                    <input type="text" class="form-control mb-3"
                                                        value="{{ old('lead_source_text') }}" name="lead_source_text"
                                                        id="basic-default-status" placeholder="Lead Source Text Box"
                                                        required />
                                                    @if ($errors->has('lead_source_text'))
                                                        <div class="error text-danger text-sm">
                                                            {{ $errors->first('lead_source_text') }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col  col-12 col-md-6">
                                                    <textarea class="form-control mb-3" id="" cols="30" rows="3" placeholder="Scope of Activity"
                                                        name="scope_activity">{{ old('scope_activity') }}</textarea>
                                                    @error('scope_activity')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col  col-12 col-md-12">
                                                    <textarea class="form-control mb-3" id="" cols="30" rows="3" placeholder="Comments"
                                                        name="comment">{{ old('comment') }}</textarea>
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
                        </div>
                    </div>
                    <!-- / Content -->
                </div>
                <!-- Content wrapper -->

            </div>
        </div>
    </div>

    <script>
        // Get references to the select elements
        const gstSelect = document.getElementById('gstSelect');
        const additionalOptionsContainer = document.getElementById('additionalOptionsContainer');
        const basicAmount = document.getElementById('basic-default-amount');

        // Add an event listener to the GST select
        gstSelect.addEventListener('change', function() {
            // Show the "Additional Options" dropdown if "With GST" is selected
            if (gstSelect.value === 'w') {
                additionalOptionsContainer.style.display = 'block';
            } else {
                // Hide the "Additional Options" dropdown for other options
                additionalOptionsContainer.style.display = 'none';
            }
        });
        additionalOptions.addEventListener('change', function() {
            const amount = parseFloat(basicAmount.value);

            if (additionalOptions.value === 'i') {
                // Calculate the amount with inclusive GST (18% less)
                const inclusiveAmount = amount * 0.82;
                adjustedAmount.textContent = `Adjusted Amount (Inclusive GST): ${inclusiveAmount.toFixed(2)}`;
            } else if (additionalOptions.value === 'e') {
                // Calculate the amount with exclusive GST (18% added)
                const exclusiveAmount = amount * 1.18;
                adjustedAmount.textContent = `Adjusted Amount (Exclusive GST): ${exclusiveAmount.toFixed(2)}`;
            }

            adjustedAmount.style.display = 'block';
        });
    </script>
@endsection
