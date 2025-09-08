<x-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="text-center mb-5">
                    <h1 class="fw-bold">เกี่ยวกับโครงการ</h1>
                    <p class="text-muted">ระบบจำแนกพรรณไม้จากภาพถ่าย และฐานข้อมูลพรรณไม้</p>
                </div>

                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body p-4">
                        <h4 class="mb-3">หลักการและเหตุผล</h4>
                        <p>
                            โครงการนี้มีวัตถุประสงค์เพื่อพัฒนาระบบที่ช่วยให้ผู้ใช้สามารถถ่ายภาพพืชและอัปโหลดเข้าสู่แพลตฟอร์ม
                            เพื่อให้โมเดลปัญญาประดิษฐ์ทำการจำแนกพรรณไม้ได้อย่างแม่นยำ
                            พร้อมทั้งเชื่อมโยงกับฐานข้อมูลพรรณไม้
                            ที่จัดเก็บรายละเอียด เช่น ชื่อวิทยาศาสตร์ ชื่อสามัญ ชื่อท้องถิ่น และข้อมูลด้านสัณฐานวิทยา
                            ซึ่งจะช่วยสนับสนุนการเรียนรู้ การวิจัย และการอนุรักษ์ทรัพยากรพืชของชุมชน
                        </p>

                        <h4 class="mt-4 mb-3">วัตถุประสงค์</h4>
                        <ul>
                            <li>พัฒนาระบบจำแนกพรรณไม้จากภาพถ่ายโดยใช้ Machine Learning</li>
                            <li>สร้างฐานข้อมูลพรรณไม้ที่เข้าถึงง่ายและค้นหาได้</li>
                            <li>ให้บริการผ่านเว็บไซต์และ LINE Chatbot เพื่อความสะดวกในการใช้งาน</li>
                        </ul>

                        <h4 class="mt-4 mb-3">ผู้มีส่วนเกี่ยวข้อง</h4>
                        <p>
                            โครงการนี้ดำเนินการโดยคณะผู้วิจัยด้านวิทยาการคอมพิวเตอร์
                            ร่วมกับภาคีเครือข่ายด้านสิ่งแวดล้อมและการเกษตร
                            เพื่อสร้างสรรค์นวัตกรรมที่ตอบโจทย์การเรียนรู้และการอนุรักษ์ทรัพยากรธรรมชาติ
                        </p>

                        <div class="text-center mt-4">
                            <a href="{{ route('plants.index') }}" class="btn btn-success px-4">
                                <i class="bi bi-search"></i> เข้าสู่ฐานข้อมูลพรรณไม้
                            </a>
                        </div>

                        <h4 class="mt-5 mb-3 text-center">ทีมผู้วิจัย</h4>
                        <div class="row g-4">
                            @foreach ($researchers as $researcher)
                                <div class="col-md-4">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <img src="{{ $researcher->image }}" class="card-img-top"
                                            alt="{{ $researcher->name }}">
                                        <div class="card-body text-center">
                                            <h5 class="card-title fw-bold">{{ $researcher->name }}</h5>
                                            <p class="card-text mb-1"><em>{{ $researcher->position }}</em></p>
                                            <p class="card-text text-muted">{{ $researcher->organization }}</p>
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
