<div class="btn-group">
    <button class="btn btn-sm btn-success " onclick="qrCode({{ $Fasilitas->id }})"><i class="bi bi-qr-code"></i></button>
    <button class="btn btn-sm btn-primary" onclick="editCustomer({{ $Fasilitas->id }})">Edit</button>
    <button class="btn btn-sm btn-danger " onclick="deleteCustomers({{ $Fasilitas->id }})">Delete</button>
</div>
