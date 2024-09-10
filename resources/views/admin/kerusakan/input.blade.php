@extends('layouts.backend.admin')

@section('content')
    @include('layouts.backend.alert')
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-6">
            <div class="card-box mb-30">
                <div class="card-body">
                    <h3>Form Input Kerusakan</h3>
                    <hr>
                    <form action="{{ url('kerusakan/store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#scannerModal"
                                id="btnScanner">Buka Scanner</button>
                        </div>
                        <input type="hidden" id="fasilitasId" class="form-control" readonly>

                        <div class="mb-3">
                            <label>Code Fasilitas</label>
                            <input type="text" id="code" class="form-control" readonly>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Foto Kerusakan 1</label>
                                    <input type="file" class="form-control" name="foto_kerusakan_1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Foto Kerusakan 1</label>
                                    <input type="file" class="form-control" name="foto_kerusakan_2">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Nama Pelapor</label>
                            <input type="text" value="{{ Auth::user()->name }}" class="form-control" name="nama_pelapor">
                        </div>
                        <div class="mb-3">
                            <label>No. HP</label>
                            <input type="text" value="+628" class="form-control" name="no_hp_pelapor">
                        </div>
                        <div class="mb-3">
                            <label>Keterangan Kerusakan</label>
                            <textarea class="form-control" name="keterangan"></textarea>
                        </div>
                        <input type="hidden" name="id_user" value="{{ Auth::id() }}">
                        <div class="my-3">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- modal scanner --}}
    <!-- Modal for Create and Edit -->
    <div class="modal fade" id="scannerModal" tabindex="-1" aria-labelledby="customersModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">Sacnner</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form for Create and Edit -->
                    <div class="form-group text-center">
                        <b class="text-danger text-center">*Harap arahkan pada QRcode PJU</b>
                        <div id="loadingMessage">Tidak dapat mengakses kamera (Mohon untuk mengaktifkan
                            pengaturan kamera)</div>
                        <canvas id="canvas" hidden style="width: 80% !important;"></canvas>
                        <div id="output" hidden>
                            <div id="outputMessage">Qr code tidak terdeteksi, harap perbaiki posisi kamera</div>
                            <div hidden><b>Data:</b> <span id="outputData"></span></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script> --}}
    <script src="{{ asset('/') }}js/app-qr.js" type="text/javascript"></script>
    <script src="{{ asset('/') }}js/jsQR.js" type="text/javascript"></script>

    <script>
        var scannerActive = true; // Flag to control scanner activity
        var mediaStream; // Variable to store the media stream

        function refreshPage() {
            window.location.reload();
        }

        var video = document.createElement("video");
        var canvasElement = document.getElementById("canvas");
        var canvas = canvasElement.getContext("2d");
        var loadingMessage = document.getElementById("loadingMessage");
        var outputContainer = document.getElementById("output");
        var outputMessage = document.getElementById("outputMessage");
        var outputData = document.getElementById("outputData");
        var submit = document.getElementById("submit-btn");
        var outputDatas = document.getElementById("code");
        var btnScanner = document.getElementById("btnScanner");

        function drawLine(begin, end, color) {
            canvas.beginPath();
            canvas.moveTo(begin.x, begin.y);
            canvas.lineTo(end.x, end.y);
            canvas.lineWidth = 4;
            canvas.strokeStyle = color;
            canvas.stroke();
        }

        // Use facingMode: environment to attempt to get the front camera on phones
        navigator.mediaDevices.getUserMedia({
            video: {
                facingMode: "environment"
            }
        }).then(function(stream) {
            mediaStream = stream; // Save the stream reference
            video.srcObject = stream;
            video.setAttribute("playsinline", true); // required to tell iOS safari we don't want fullscreen
            video.play();
            requestAnimationFrame(tick);
        });

        function stopCamera() {
            if (mediaStream) {
                let tracks = mediaStream.getTracks();
                tracks.forEach(track => track.stop()); // Stop each track
                mediaStream = null; // Clear the stream reference
            }
        }

        function tick() {
            if (!scannerActive) {
                // If scanner is not active, stop the function
                return;
            }

            loadingMessage.innerText = "Loading camera..."
            if (video.readyState === video.HAVE_ENOUGH_DATA) {
                loadingMessage.hidden = true;
                canvasElement.hidden = false;
                outputContainer.hidden = false;

                // Adjust canvas size to match video frame
                canvasElement.height = 400;
                canvasElement.width = 400;
                canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);
                var imageData = canvas.getImageData(0, 0, canvasElement.width, canvasElement.height);
                var code = jsQR(imageData.data, imageData.width, imageData.height, {
                    inversionAttempts: "dontInvert",
                });
                if (code) {
                    drawLine(code.location.topLeftCorner, code.location.topRightCorner, "#FF3B58");
                    drawLine(code.location.topRightCorner, code.location.bottomRightCorner, "#FF3B58");
                    drawLine(code.location.bottomRightCorner, code.location.bottomLeftCorner, "#FF3B58");
                    drawLine(code.location.bottomLeftCorner, code.location.topLeftCorner, "#FF3B58");
                    outputMessage.hidden = true;
                    outputData.parentElement.hidden = true;
                    outputData.innerText = code.data.substr(-16);
                    outputDatas.value = code.data.substr(-16);
                    $('#scannerModal').modal('hide');
                    // Hide button
                    document.getElementById('btnScanner').style.display = 'none';
                    // Disable the scanner
                    scannerActive = false;
                    // Stop the camera
                    stopCamera();
                    // Perform AJAX request to get additional data
                    fetch(`{{ url('fasilitas/get-code/${code.data.substr(-16)}') }}`)
                        .then(response => response.json())
                        .then(data => {
                            console.log(data.id);
                            $('#fasilitasId').val(data.id);
                            $('#scannerModal').modal('hide');
                            $('#openScanner').hide();
                        })
                        .catch(error => console.error('Error:', error));
                } else {
                    outputMessage.hidden = false;
                    outputData.parentElement.hidden = true;
                }
            }
            requestAnimationFrame(tick);
        }
    </script>
@endpush
