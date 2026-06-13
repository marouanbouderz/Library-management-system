<div class="col-md-4 mb-4">
    <div class="stat-card shadow-sm border-0 rounded-lg p-4 bg-white d-flex align-items-center justify-content-between">
        <div>
            <p class="text-muted small text-uppercase font-weight-bold mb-1">{{ $title }}</p>
            <h3 class="font-weight-bold mb-0">{{ $value }}</h3>
        </div>
        <div class="icon-box bg-light-{{ $color }} text-{{ $color }} rounded-circle p-3">
            <i class="fas {{ $icon }} fa-2x"></i>
        </div>
    </div>
</div>