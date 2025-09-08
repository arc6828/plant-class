<x-layout title="{{ $plant->scientific_name }}">
    <div class="container my-4">
        <a href="{{ route('plants.index') }}" class="btn btn-sm btn-outline-secondary mb-3">⬅
            กลับไปยังฐานข้อมูลพรรณไม้</a>

        <div class="row">
            <!-- Plant Image -->
            <div class="col-md-5">
                
                @if ($plant->images && count($plant->images) > 0)
                    <div id="plantCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($plant->images as $index => $img)
                                <div class="carousel-item @if ($index == 0) active @endif">
                                    <img src="{{ $img }}" class="d-block w-100 rounded shadow-sm"
                                        alt="{{ $plant->scientific_name }}">
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#plantCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#plantCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                @else
                    <img src="https://via.placeholder.com/500x400?text=No+Image" class="img-fluid rounded shadow-sm"
                        alt="No Image">
                @endif
            </div>

            <!-- Plant Info -->
            <div class="col-md-7">
                <h2 class="fw-bold">{{ $plant->common_name_th ?? ($plant->common_name ?? '—') }}</h2>
                <p class="text-muted"><em>{{ $plant->scientific_name }}</em></p>

                <ul class="list-group mb-3">
                    <li class="list-group-item"><strong>ชื่อสามัญ (EN):</strong> {{ $plant->common_name ?? '—' }}</li>
                    <li class="list-group-item"><strong>ชื่อสามัญ (TH):</strong> {{ $plant->common_name_th ?? '—' }}
                    </li>
                    <li class="list-group-item"><strong>สกุล (Genus):</strong> {{ $plant->genus ?? '—' }}</li>
                    <li class="list-group-item"><strong>วงศ์ (Family):</strong> {{ $plant->family ?? '—' }}</li>
                </ul>

                <h5>รายละเอียด</h5>
                <p>{{ $plant->description ?? 'ไม่มีข้อมูลเพิ่มเติม' }}</p>

                <div class="mt-3">
                    <span class="badge bg-primary">📸 {{ $plant->num_images ?? 0 }} ภาพ</span>
                    <span class="badge bg-success">👁 {{ $plant->num_observations ?? 0 }} การบันทึก</span>
                </div>
            </div>
        </div>
    </div>
</x-layout>
