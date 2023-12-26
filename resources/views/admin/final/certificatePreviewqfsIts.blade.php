@extends('layouts.app')

@section('content')
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
    <link rel="stylesheet" href="{{ asset('public/assets/certificates/fonts/arialFonts/ARIAL.TTF') }}" />
    <link rel="stylesheet" href="{{ asset('public/assets/certificates/fonts/TimesNewRoman/times new roman.ttf') }}" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

    <style>
        #page-container {
            width: 211mm;
            height: 297mm;
            background-repeat: no-repeat;
            background-size: contain;
            background-image: url("{{ asset('public/assets/certificates/final/qfsIt.png') }}");
            letter-spacing: 0px;
            font-family: times;

        }


        #canvasElement {
            position: relative;
            text-align: center;
            width: 780px;
            /* border: 2px solid black; */
        }

        .bname {
            padding-top: 300px;
        }

        .topH1 p {
            font-size: 20px;
        }

        .bname .second {
            margin-top: -15px;
        }
    </style>
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
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Certificate Preview</h5>
                                <div id="previewImage" class="img-fluid"></div>
                                <div id="page-container">
                                    <div id="canvasElement" class="pb-5">

                                        <div class="bname" style="height: 60px;">
                                            <h1 style="margin-top:-50px;font-weight: 700;color:red;font-family: ARIAL;">QFS
                                                MANAGEMENT
                                                SYSTEMS
                                                LLP</h1>
                                            <h3 style="margin-top: -20px;font-weight: 700;font-family: ARIAL;">This is to
                                                Certify
                                                that
                                                the IT Service Management System of</h3>
                                            <h2 class="first"
                                                style="letter-spacing: 1px; font-weight: 600;padding-top: 0px;margin-top:-10px;">
                                                {{ $data->business_name }}</h2>
                                            <p class="second"
                                                style="letter-spacing: 1px;padding-top: 10px;font-weight: 700;font-size: 18px">
                                                {{ $data->business_name_secondary }}</p>
                                            <h4
                                                style="margin-top: -10px;font-family: ARIAL;font-weight: 700;font-size: 22px">
                                                Has been found to
                                                be of the
                                                IT Service Management Standard</h4>
                                        </div>

                                        <div class="standard" style="padding-top: 170px; height: 80px;">
                                            <h3 style="font-weight: 700;color:#2F2482;font-size: 36px">
                                                {{ $data->standard_name }}</h3>
                                            {{-- <h3 style="margin-top: -20px;font-weight: 700;color:#2F2482">
                                                ({{ $data->standard_description }})</h3> --}}
                                        </div>
                                        <div class="scope" style="height: 150px;margin-top:50px;">
                                            <h3 style="font-family: ARIAL;">This certificate is valid for the following
                                                product or service range</h3>
                                            <h6
                                                style="margin-top: -30px;font-size: 13px; font-weight: 600;letter-spacing: 1px;padding-top: 20px">
                                                {{ $data->scope_registration }}
                                            </h6>
                                        </div>
                                        <div
                                            style="display:flex;margin-top: 20px;justify-content: space-between; width: 670px;margin-left: 60px;">
                                            <div style="text-align: start;font-family: ARIAL;">
                                                <h5 style="letter-spacing: 0px; font-size: 18px">Certificate Number:
                                                    <span style="font-family: times;">{{ $data->certificate_number }}</span>
                                                </h5>
                                                <h5 style="letter-spacing: 0px; font-size: 18px">Initial Date of
                                                    Certification:
                                                    <span style="font-family: times;">
                                                        {{ \Carbon\Carbon::parse($data->created_at)->format('d-m-Y') }}</span>
                                                </h5>
                                                <h5 style="letter-spacing: 0px; font-size: 18px">Date of Certificate:
                                                    <span style="font-family: times;">
                                                        {{ \Carbon\Carbon::parse($data->date_initial)->format('d-m-Y') }}</span>
                                                </h5>
                                                <h5 style="letter-spacing: 0px; font-size: 18px">Date of Expiry:
                                                    <span style="font-family: times;">
                                                        {{ \Carbon\Carbon::parse($data->certification_due_date)->format('d-m-Y') }}</span>
                                                </h5>
                                            </div>
                                            <div style="text-align: start; font-family: ARIAL;">
                                                <h5 style="letter-spacing: 0px; font-size: 18px">Surv. Audit on or
                                                    Before:
                                                    <span style="font-family: times;">
                                                        {{ \Carbon\Carbon::parse($data->first_surveillance_audit)->format('d-m-Y') }}</span>
                                                </h5>
                                                <h5 style="letter-spacing: 0px; font-size: 18px">Re-certification Due
                                                    on:
                                                    <span style="font-family: times;">
                                                        {{ \Carbon\Carbon::parse($data->second_surveillance_audit)->format('d-m-Y') }}</span>
                                                </h5>
                                            </div>
                                        </div>
                                        <div style="margin-top: 34px; margin-left: -50px;">
                                            <span style="font-family: times;">
                                                {{ \Carbon\Carbon::parse($data->date_initial)->format('d-m-Y') }}</span>
                                        </div>
                                        <br>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-center">
                                    <a id="btn-Convert-jpg" class="btn btn-primary">Download JPG</a>
                                    <a id="btn-Convert-Html2Image" class="btn btn-primary"> <i
                                            class="fas fa-file-download"></i>
                                        Download PDF</a>
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
        $(document).ready(function() {
            var $certFileName = 'IT Service Certificate.pdf';
            var element = document.querySelector("#page-container"); // global variable
            var getCanvas; // global variable

            html2canvas(element).then(canvas => {
                $("#previewImage").append(canvas);
                getCanvas = canvas;
                element.remove();
            });

            $("#btn-Convert-Html2Image").on('click', function() {
                var imgageData = getCanvas.toDataURL("image/png");
                var pdf = new jsPDF({
                    orientation: "portrait",
                    unit: "mm",
                    format: "a4"
                });


                pdf.addImage(imgageData, 'JPEG', 0, 0);

                pdf.save($certFileName);
            });

            $("#btn-Convert-jpg").on('click', function() {
                var imgageData = getCanvas.toDataURL("image/jpeg");
                var newData = imgageData.replace(/^data:image\/jpeg/,
                    "data:application/octet-stream");
                $("#btn-Convert-jpg").attr("download", "IT Service Certificate.jpg").attr("href",
                    newData);
            });
        });
    </script>
@endsection
