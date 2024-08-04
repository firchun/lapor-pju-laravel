<div class="btn-group">
    <button class="btn btn-sm btn-success " onclick="qrCode({{ $customer->id }})"><i class="bi bi-qr-code"></i></button>
    <button class="btn btn-sm btn-primary" onclick="editCustomer({{ $customer->id }})">Edit</button>
    <button class="btn btn-sm btn-danger " onclick="deleteCustomers({{ $customer->id }})">Delete</button>
</div>
