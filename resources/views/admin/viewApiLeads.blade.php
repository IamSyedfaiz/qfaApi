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
                        <h3 class="card-header">Lead Details</h3>
                        <!--Add Leads -->
                        <div class="row">
                            <!---Layout -->
                            <div class="col col-12 col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        {{-- <form action="#" method="post">
                                            @csrf
                                            <div class="row mb-3">
                                                <div class="col col-12 col-md-6">
                                                    <input type="text" class="form-control mb-3" id="basic-default-name"
                                                        name="name" required value="{{ $apiLead->query_type }}" />
                                                </div>
                                                <div class="col col-12 col-md-6">
                                                    <input type="text" class="form-control mb-3" id="basic-default-name"
                                                        name="name" required value="{{ $apiLead->query_time }}" />
                                                </div>
                                                <div class="col col-12 col-md-6">
                                                    <input type="text" class="form-control mb-3" id="basic-default-name"
                                                        name="name" required value="{{ $apiLead->sender_name }}" />
                                                </div>
                                                <div class="col col-12 col-md-6">
                                                    <input type="text" class="form-control mb-3" id="basic-default-name"
                                                        name="name" required value="{{ $apiLead->sender_mobile }}" />
                                                </div>
                                                <div class="col col-12 col-md-6">
                                                    <input type="text" class="form-control mb-3" id="basic-default-name"
                                                        name="name" required value="{{ $apiLead->sender_email }}" />
                                                </div>
                                                <div class="col col-12 col-md-6">
                                                    <input type="text" class="form-control mb-3" id="basic-default-name"
                                                        name="name" required value="{{ $apiLead->subject }}" />
                                                </div>
                                                <div class="col col-12 col-md-6">
                                                    <input type="text" class="form-control mb-3" id="basic-default-name"
                                                        name="name" required value="{{ $apiLead->sender_company }}" />
                                                </div>
                                                <div class="col col-12 col-md-6">
                                                    <input type="text" class="form-control mb-3" id="basic-default-name"
                                                        name="name" required value="{{ $apiLead->sender_address }}" />
                                                </div>
                                                <div class="col col-12 col-md-6">
                                                    <input type="text" class="form-control mb-3" id="basic-default-name"
                                                        name="name" required value="{{ $apiLead->sender_city }}" />
                                                </div>
                                                <div class="col col-12 col-md-6">
                                                    <input type="text" class="form-control mb-3" id="basic-default-name"
                                                        name="name" required value="{{ $apiLead->sender_state }}" />
                                                </div>
                                                <div class="col col-12 col-md-6">
                                                    <input type="text" class="form-control mb-3" id="basic-default-name"
                                                        name="name" required value="{{ $apiLead->sender_pincode }}" />
                                                </div>
                                                <div class="col col-12 col-md-6">
                                                    <input type="text" class="form-control mb-3" id="basic-default-name"
                                                        name="name" required
                                                        value="{{ $apiLead->sender_country_iso }}" />
                                                </div>
                                                <div class="col col-12 col-md-6">
                                                    <input type="text" class="form-control mb-3" id="basic-default-name"
                                                        name="name" required
                                                        value="{{ $apiLead->sender_mobile_alt }}" />
                                                </div>
                                                <div class="col col-12 col-md-6">
                                                    <input type="text" class="form-control mb-3" id="basic-default-name"
                                                        name="name" required value="{{ $apiLead->sender_phone }}" />
                                                </div>
                                                <div class="col col-12 col-md-6">
                                                    <input type="text" class="form-control mb-3" id="basic-default-name"
                                                        name="name" required
                                                        value="{{ $apiLead->sender_phone_alt }}" />
                                                </div>
                                                <div class="col col-12 col-md-6">
                                                    <input type="text" class="form-control mb-3"
                                                        id="basic-default-name" name="name" required
                                                        value="{{ $apiLead->sender_email_alt }}" />
                                                </div>
                                                <div class="col col-12 col-md-6">
                                                    <input type="text" class="form-control mb-3"
                                                        id="basic-default-name" name="name" required
                                                        value="{{ $apiLead->query_product_name }}" />
                                                </div>
                                                <div class="col col-12 col-md-6">
                                                    <input type="text" class="form-control mb-3"
                                                        id="basic-default-name" name="name" required
                                                        value="{{ $apiLead->query_message }}" />
                                                </div>
                                                <div class="col col-12 col-md-6">
                                                    <input type="text" class="form-control mb-3"
                                                        id="basic-default-name" name="name" required
                                                        value="{{ $apiLead->query_mcat_name }}" />
                                                </div>
                                                <div class="col col-12 col-md-6">
                                                    <input type="text" class="form-control mb-3"
                                                        id="basic-default-name" name="name" required
                                                        value="{{ $apiLead->call_duration }}" />
                                                </div>
                                                <div class="col col-12 col-md-6">
                                                    <input type="text" class="form-control mb-3"
                                                        id="basic-default-name" name="name" required
                                                        value="{{ $apiLead->receiver_mobile }}" />
                                                </div>
                                            </div>
                                        </form> --}}
                                        @foreach ($filteredAttributes as $label => $value)
                                            @if ($label === 'query_type')
                                                <span style="font-weight: 700">{{ str_replace('_', ' ', $label) }}</span> :
                                                @if ($value === 'W')
                                                    Direct
                                                @elseif($value === 'P')
                                                    PNS
                                                @elseif($value === 'B')
                                                    Consumed BuyLead
                                                @else
                                                    Unknown
                                                @endif
                                                <br>
                                            @else
                                                <span style="font-weight: 700">{{ str_replace('_', ' ', $label) }}</span> :
                                                {!! $value !!}<br>
                                            @endif
                                        @endforeach
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
@endsection
