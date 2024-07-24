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
                <h5 class="modal-title" id="userModalLabel">Tambah Mitra</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for Create and Edit -->
                <form id="createUserForm">
                    <div class="mb-3">
                        <label for="formCustomerName" class="form-label">Nama Mitra</label>
                        <input type="text" class="form-control" id="formCustomerName" name="nama_mitra" required>
                    </div>
                    <div class="mb-3">
                        <label for="formCustomerPhone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="formCustomerPhone" name="no_hp" required
                            value="+62">
                    </div>
                    <div class="mb-3">
                        <label for="formCustomerAddress" class="form-label">Email</label>
                        <input type="email" class="form-control" id="formCustomerEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="formCustomerAddress" class="form-label">Alamat</label>
                        <textarea class="form-control" id="formCustomerAlamat" name="alamat"></textarea>
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
