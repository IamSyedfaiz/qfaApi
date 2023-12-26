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
            background-image: url("{{ asset('public/assets/certificates/final/SAMPLE.png') }}");
            letter-spacing: 0px;
        }


        #canvasElement {
            position: relative;
            text-align: center;
            width: 660px;
            margin-left: 125px;
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
                                            <h3 class="first"
                                                style="letter-spacing: 1px; font-weight: 600;padding-top: 30px;">
                                                {{ $data->business_name }}</h3>
                                            <p class="second"
                                                style="letter-spacing: 1px;padding-top: 20px;font-weight: 700;">
                                                {{ $data->business_name_secondary }}</p>
                                        </div>
                                        <div class="scope" style="height: 110px;margin-top: 340px;">
                                            {{-- <h5 style="padding-top: 40px">For the scope of activities described below:</h5> --}}
                                            <h5 style="margin-top: 10px; font-weight: 600;letter-spacing: 1px;">
                                                {{ $data->scope_registration }}
                                            </h5>
                                        </div>
                                        <p style="margin-top: -5px ;margin-left: 120px;  font-weight: 700">
                                            {{ @$data->certificate_number }}</p>

                                        <div
                                            style="margin: 45px 20px; display: flex; justify-content: space-between;font-weight: 700;">
                                            <p style="margin-top: -10x; line-height: 2px">{{ @$data->date_initial }}</p>
                                            <p style="margin-top: -10x; line-height: 1px">
                                                {{ @$data->first_surveillance_audit }}
                                            </p>
                                            <p style="margin-top: -10x; line-height: 1px">
                                                {{ @$data->second_surveillance_audit }}
                                            </p>
                                            <p style="margin-top: -10x; line-height: 1px">
                                                {{ @$data->certification_due_date }}
                                            </p>
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
