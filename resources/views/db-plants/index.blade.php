<x-layout title="Plant Database">
    <div class="container my-4">
        <h2 class="mb-4">🌿 Plant Database</h2>

        <!-- Search & Filter -->
        <form method="GET" action="{{ route('plants.index') }}" class="row g-2 mb-4">
            <div class="col-md-6">
                <input type="text" name="q" class="form-control"
                    placeholder="ค้นหาชื่อพืช (ไทย/อังกฤษ/วิทยาศาสตร์)" value="{{ request('q') }}">
            </div>
            <div class="col-md-4">
                <select name="family" class="form-select">
                    <option value="">-- เลือกวงศ์ (Family) --</option>
                    @foreach ($families as $family)
                        <option value="{{ $family }}" @selected(request('family') == $family)>{{ $family }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-grid">
                <button type="submit" class="btn btn-success">ค้นหา</button>
            </div>
        </form>

        <!-- Plant List -->
        <div class="row">
            @forelse($plants as $plant)
                <div class="col-md-3 mb-4">
                    <a href="{{ route('plants.show', $plant) }}" class="text-decoration-none text-dark">
                        <div class="card h-100 shadow-sm">
                            @if ($plant->first_image)
                                <img src="{{ $plant->first_image }}" class="card-img-top"
                                    alt="{{ $plant->scientific_name }}">
                            @else
                                <img src="https://via.placeholder.com/300x200?text=No+Image" class="card-img-top"
                                    alt="No Image">
                            @endif
                            <div class="card-body">
                                <h6 class="card-title">{{ $plant->common_name_th ?? ($plant->common_name ?? '-') }}</h6>
                                <p class="card-text"><em>{{ $plant->scientific_name }}</em></p>
                                <span class="badge bg-secondary">{{ $plant->family }}</span>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">ไม่พบข้อมูลพรรณไม้</div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $plants->links('pagination::bootstrap-5') }}
        </div>
    </div>
</x-layout>
