<x-layout title="Plant Identification">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">🌿 อัปโหลดภาพเพื่อจำแนกพรรณพืช</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('plant.identify') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="plantImage" class="form-label">เลือกไฟล์ภาพ</label>
                                <input type="file" name="plantImage" id="plantImage" class="form-control"
                                    accept="image/*" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100">🔍 วิเคราะห์พรรณพืช</button>
                        </form>
                    </div>
                </div>

                <!-- ส่วนแสดงผลลัพธ์ -->
                @if (session('result'))
                    <div class="alert alert-info mt-4">
                        <h5>ผลการจำแนก:</h5>
                        <p>{{ session('result') }}</p>
                    </div>
                @endif

                
            </div>
        </div>
    </div>
</x-layout>
