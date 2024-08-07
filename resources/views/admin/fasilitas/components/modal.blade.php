<div class="modal fade" id="create" tabindex="-1" aria-labelledby="customersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Tambah Fasilitas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for Create and Edit -->
                <form id="createFasilitasForm">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="formCustomerName" class="form-label">Foto Fasilitas (opsional)</label>
                                <input type="file" class="form-control" id="formCreateFasilitasFoto" name="foto">
                            </div>
                            <div class="mb-3">
                                <label for="formCustomerNama" class="form-label">Nama Fasilitas</label>
                                <input type="text" class="form-control" id="formCreateFasilitasNama" name="nama"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="formCustomerNama" class="form-label">ID Pelanggan PLN</label>
                                <input type="text" class="form-control" id="formCreateFasilitasIdPelangganPln"
                                    name="id_pelanggan_pln" required>
                            </div>
                            <div class="mb-3">
                                <label for="formCustomerNama" class="form-label">Tarip</label>
                                <input type="text" class="form-control" id="formCreateFasilitasTarip" name="tarip"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="formCustomerNama" class="form-label">Daya Listrik</label>
                                <input type="text" class="form-control" id="formCreateFasilitasDaya" name="daya"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="formCustomerName" class="form-label">Alamat Fasilitas</label>
                                <textarea class="form-control" id="formCreateFasilitasAlamat" name="alamat" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-8">

                            <div id="map" style="height: 400px;"></div>
                            <label>Latitude</label>
                            <input type="text" class="form-control" readonly name="latitude"
                                id="formCreateFasilitasLatitude">
                            <label>Longitude</label>
                            <input type="text" class="form-control" readonly name="longitude"
                                id="formCreateFasilitasLongitude">
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="createFasilitasBtn">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="edit" tabindex="-1" aria-labelledby="editFasilitasModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editFasilitasModalLabel">Edit Fasilitas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for Edit -->
                <form id="editFasilitasForm">
                    <input type="hidden" name="id_fasilitas" id="idFasilitas">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="formEditFasilitasFoto" class="form-label">Foto Fasilitas
                                    (opsional)</label>
                                <input type="file" class="form-control" id="formEditFasilitasFoto"
                                    name="foto">
                            </div>
                            <div class="mb-3">
                                <label for="formEditFasilitasNama" class="form-label">Nama Fasilitas</label>
                                <input type="text" class="form-control" id="formEditFasilitasNama" name="nama"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="formEditFasilitasIdPelangganPln" class="form-label">ID Pelanggan
                                    PLN</label>
                                <input type="text" class="form-control" id="formEditFasilitasIdPelangganPln"
                                    name="id_pelanggan_pln" required>
                            </div>
                            <div class="mb-3">
                                <label for="formEditFasilitasTarip" class="form-label">Tarip</label>
                                <input type="text" class="form-control" id="formEditFasilitasTarip"
                                    name="tarip" required>
                            </div>
                            <div class="mb-3">
                                <label for="formEditFasilitasDaya" class="form-label">Daya Listrik</label>
                                <input type="text" class="form-control" id="formEditFasilitasDaya" name="daya"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="formEditFasilitasAlamat" class="form-label">Alamat Fasilitas</label>
                                <textarea class="form-control" id="formEditFasilitasAlamat" name="alamat" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div id="editMap" style="height: 400px;"></div>
                            <label>Latitude</label>
                            <input type="text" class="form-control" readonly name="latitude"
                                id="formEditFasilitasLatitude">
                            <label>Longitude</label>
                            <input type="text" class="form-control" readonly name="longitude"
                                id="formEditFasilitasLongitude">
                        </div>
                    </div>
                    <!-- Hidden input for facility ID -->
                    <input type="hidden" name="id" id="editFasilitasId">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="updateFasilitasBtn">Save Changes</button>
            </div>
        </div>
    </div>
</div>
