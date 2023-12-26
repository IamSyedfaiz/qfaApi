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
            background-image: url("{{ asset('public/assets/certificates/corDraft.png') }}");
            letter-spacing: 0px;
        }


        #canvasElement {
            position: relative;
            text-align: center;
            padding: 0px 60px;
        }

        .bname {
            padding-top: 240px;
        }

        .topH1 p {
            font-size: 20px;
        }

        .bname .second {
            margin-left: 0;
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
                                            <h2 class="first" style="letter-spacing: -1px; font-weight: 700; ">
                                                {{ $data->business_name }}</h2>
                                            <p class="second" style="text-align: start; font-size: 17px;line-height: 22px;">
                                                having been assessed by International Benchmarking and Certifications for
                                                compliance is
                                                certified to be registered in the List of Registered Organizations with
                                                regard to the
                                                standard and scope of supply as detailed below from their site:
                                                <span style="font-weight: 700">
                                                    {{ $data->business_name_secondary }}
                                                </span>
                                            </p>
                                        </div>

                                        <div class="standard" style="padding-top: 170px; height: 150px; ">
                                            <h3 style="font-weight: 700; color:red">
                                                {{ $data->standard_name }}</h3>
                                            <h3 style="margin-top: -20px;font-weight: 700;color:red">
                                                ({{ $data->standard_description }})</h3>
                                        </div>
                                        <div class="scope" style="height: 150px;">
                                            <div style="margin-top: 70px;text-align: start;">For the following scope:
                                                <span
                                                    style="font-weight: 600;letter-spacing: 1px;">{{ $data->scope_registration }}</span>
                                            </div>
                                        </div>
                                        @if (@$data->certificate_status == 'F')
                                            <p
                                                style="margin-top:-46px ;padding-left:155px ; font-weight: 600;text-align: start;">
                                                {{ @$data->certificate_number }}
                                            </p>
                                            <div style="margin-top: -22px;">
                                                <p
                                                    style="margin-top: 30px;padding-left: 160px; line-height: 2px; text-align: start;">
                                                    {{ @$data->date_initial }}</p>
                                                <p
                                                    style="margin-top: 19px;padding-left: 125px; line-height: 1px; text-align: start;">
                                                    {{ @$data->first_surveillance_audit }}</p>
                                                <p
                                                    style="margin-top: -48px;padding-right: 28px; line-height: 1px; text-align: end;">
                                                    {{ @$data->second_surveillance_audit }}</p>
                                                <p
                                                    style="padding-top: 2px;padding-right: 28px; line-height: 1px; text-align: end;">
                                                    {{ @$data->certification_due_date }}</p>
                                            </div>
                                        @else
                                            <p
                                                style="margin-top:-46px ;padding-left:155px ; font-weight: 600;text-align: start;">
                                                OR-BV-XXXX
                                            </p>
                                            <div style="margin-top: -22px;">
                                                <p
                                                    style="margin-top: 30px;padding-left: 160px; line-height: 2px; text-align: start;">
                                                    XXXX</p>
                                                <p
                                                    style="margin-top: 19px;padding-left: 125px; line-height: 1px; text-align: start;">
                                                    XXXX</p>
                                                <p
                                                    style="margin-top: -48px;padding-right: 68px; line-height: 1px; text-align: end;">
                                                    XXXX</p>
                                                <p
                                                    style="padding-top: 2px;padding-right: 68px; line-height: 1px; text-align: end;">
                                                    XXXX</p>
                                            </div>
                                        @endif
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
            var element = document.querySelector("#page-container");
            var getCanvas;

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
                $("#btn-Convert-jpg").attr("download", "RSBV GLUTEN FREE Certificate.jpg").attr("href",
                    newData);
            });
        });
    </script>
@endsection
