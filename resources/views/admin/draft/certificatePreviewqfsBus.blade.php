@extends('layouts.app')

@section('content')
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

    <style>
        #page-container {
            width: 211mm;
            height: 297mm;
            background-repeat: no-repeat;
            background-size: contain;
            background-image: url("{{ asset('public/assets/certificates/draft/qfsbusiness.png') }}");
            letter-spacing: 0px;
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
                                            <h1 style="margin-top:-40px;font-weight: 700;color:red;letter-spacing: 1px;">
                                                QFS MANAGEMENT
                                                SYSTEMS
                                                LLP</h1>
                                            <h4 style="margin-top: -10px;font-weight: 400;letter-spacing: -0.5px;">This is
                                                to
                                                Certify
                                                that
                                                the Business Management System of</h4>
                                            <h2 class="first"
                                                style="letter-spacing: 2px; font-weight: 600;padding-top: 0px;margin-top:-10px;">
                                                {{ $data->business_name }}</h2>
                                            <p class="second"
                                                style="letter-spacing: 1px;padding-top: 10px;font-weight: 700;font-size: 18px">
                                                {{ $data->business_name_secondary }}</p>
                                            <h4 style="margin-top: -10px;font-weight: 700;font-size: 22px">Has been found to
                                                be of the
                                                Business Management Standard</h4>
                                        </div>

                                        <div class="standard" style="padding-top: 170px; height: 80px;">
                                            <h3 style="font-weight: 700;color:#2F2482;font-size: 36px">
                                                {{ $data->standard_name }}</h3>
                                            {{-- <h3 style="margin-top: -20px;font-weight: 700;color:#2F2482">
                                                ({{ $data->standard_description }})</h3> --}}
                                        </div>
                                        <div class="scope" style="height: 150px;margin-top:50px;">
                                            <h3>This certificate is valid for the following product or service range</h3>
                                            <h6
                                                style="margin-top: -30px;font-size: 13px; font-weight: 600;letter-spacing: 1px;padding-top: 20px">
                                                {{ $data->scope_registration }}
                                            </h6>
                                        </div>
                                        <div
                                            style="display:flex;margin-top: 20px;justify-content: space-between; width: 670px;margin-left: 60px;">
                                            <div style="text-align: start;">
                                                <h5 style="letter-spacing: -1px; font-size: 18px">Certificate Number:
                                                    00/00/000/0000
                                                </h5>
                                                <h5 style="letter-spacing: -1px; font-size: 18px">Initial Date of
                                                    Certification:
                                                    DD.MM.YYYY
                                                </h5>
                                                <h5 style="letter-spacing: -1px; font-size: 18px">Date of Certificate:
                                                    DD.MM.YYYY </h5>
                                                <h5 style="letter-spacing: -1px; font-size: 18px">Date of Expiry:
                                                    DD.MM.YYYY</h5>
                                            </div>
                                            <div style="text-align: start;">
                                                <h5 style="letter-spacing: -1px; font-size: 18px">Surv. Audit on or
                                                    Before: DD.MM.YYYY
                                                </h5>
                                                <h5 style="letter-spacing: -1px; font-size: 18px">Re-certification Due
                                                    on: DD.MM.YYYY
                                                </h5>
                                            </div>
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
            var $certFileName = 'Certificate.pdf';
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
                $("#btn-Convert-jpg").attr("download", "Certificate.jpg").attr("href",
                    newData);
            });
        });
    </script>
@endsection
