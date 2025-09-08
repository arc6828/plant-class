<x-layout title="หน้าแรก - ระบบจำแนกพรรณไม้">
    <div class="container py-5">
        <!-- Hero Section -->
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold">ระบบจำแนกพรรณไม้จากภาพถ่าย</h1>
            <p class="lead text-muted">
                งานวิจัยเพื่อพัฒนาบริการวิเคราะห์และฐานข้อมูลพรรณไม้ ผ่านเว็บไซต์และ LINE Application
            </p>
            <a href="{{ url('/identify') }}" class="btn btn-success btn-lg mt-3">
                เริ่มอัปโหลดภาพ 🌱
            </a>
        </div>

        <!-- Features Section -->
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">📷 อัปโหลดภาพ</h5>
                        <p class="card-text text-muted">
                            ผู้ใช้สามารถอัปโหลดภาพพืชเพื่อให้ระบบวิเคราะห์และจำแนกพรรณไม้ได้ทันที
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">🌿 ฐานข้อมูลพรรณไม้</h5>
                        <p class="card-text text-muted">
                            รวมข้อมูลพรรณไม้จาก PlantNet และฐานข้อมูลวิชาการ ค้นหาได้ทั้งชื่อสามัญและชื่อวิทยาศาสตร์
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">📊 ผลการวิจัย</h5>
                        <p class="card-text text-muted">
                            นำเสนอผลการเปรียบเทียบโมเดล Deep Learning เช่น CNNs, ViTs และ Hybrid Models
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Line App Section -->
        <div class="text-center mt-5">
            <h2 class="fw-bold mb-3">เชื่อมต่อผ่าน LINE Application</h2>
            <p class="text-muted mb-4">
                เพิ่มเพื่อนใน LINE แล้วส่งภาพพรรณไม้เพื่อรับการวิเคราะห์และข้อมูลพรรณไม้ได้ทันที
            </p>
            <img src="{{ asset('img/M_285yxxte_BW.png') }}" alt="LINE QR Code" class="img-fluid"
                style="max-width: 200px;">
            <p class="text-muted mt-2">สแกน QR Code เพื่อเพิ่มเพื่อนใน LINE</p>
            
            <!-- Line App Example Section -->
            <div class="text-center mt-4">
                <img src="{{ asset('img/example-line-2.jpg') }}" alt="LINE App Example" class="img-fluid rounded"
                    style="max-width: 400px;">
                <p class="text-muted mt-2">ตัวอย่างการใช้งานผ่าน LINE Application</p>
            </div>
        </div>

    </div>
</x-layout>
