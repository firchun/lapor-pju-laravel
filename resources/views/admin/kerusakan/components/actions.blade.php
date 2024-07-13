<div class="btn-group">
    <a class="btn btn-sm btn-success" href="{{ url('kerusakan/detail', $Kerusakan->id) }}">Detail</a>
    @if ($Kerusakan->is_verified == 0)
        <a class="btn btn-sm btn-primary" href="{{ url('kerusakan/terima', $Kerusakan->id) }}">Terima</a>
        <a class="btn btn-sm btn-danger " href="{{ url('kerusakan/tolak', $Kerusakan->id) }}">Tolak</a>
    @else
        <a class="btn btn-sm btn-primary" target="__blank"
            href="https://www.google.com/maps/dir/?api=1&destination={{ $Kerusakan->fasilitas->latitude }},{{ $Kerusakan->fasilitas->longitude }}">Rute</a>
    @endif
</div>
