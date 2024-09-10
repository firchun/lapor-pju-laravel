<!-- Modal for Create and Edit -->
<div class="modal fade" id="customersModal" tabindex="-1" aria-labelledby="customersModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Ubah Mitra</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for Create and Edit -->
                <form id="userForm">
                    <input type="hidden" id="formMitraId" name="id">
                    <div class="mb-3">
                        <label for="formUpdateCustomerName" class="form-label">Nama Mitra</label>
                        <input type="text" class="form-control" id="formUpdateCustomerName" name="nama_mitra"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="formUpdateCustomerPhone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="formUpdateCustomerPhone" name="no_hp" required
                            value="+62">
                    </div>
                    <div class="mb-3">
                        <label for="formUpdateCustomerAddress" class="form-label">Email</label>
                        <input type="email" class="form-control" id="formUpdateCustomerEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="formUpdateCustomerAddress" class="form-label">Alamat</label>
                        <textarea class="form-control" id="formUpdateCustomerAlamat" name="alamat"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveCustomerBtn">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="create" tabindex="-1" aria-labelledby="customersModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Tambah Pemantauan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for Create and Edit -->
                <form id="createUserForm">
                    <div class="mb-3">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#scannerModal"
                            id="btnScanner">Buka Scanner</button>
                    </div>
                    <input type="hidden" id="fasilitasId" class="form-control" readonly>
                    <div class="mb-3">
                        <label>Code Fasilitas</label>
                        <input type="text" id="code" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label>Tunggakan</label>
                        <input type="number" class="form-control" name="tunggakan" value="0">
                    </div>
                    <div class="mb-3">
                        <label>Keterangan</label>
                        <input type="text" class="form-control" name="keterangan" placeholder="Baik/mati/lainnya..">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="createCustomerBtn">Save</button>
            </div>
        </div>
    </div>
</div>
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
@push('js')
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
