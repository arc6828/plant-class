<x-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="text-center mb-5">
                    <h1 class="fw-bold">ติดต่อเรา</h1>
                    <p class="text-muted">หากมีข้อสงสัย ข้อเสนอแนะ หรืออยากร่วมมือกับโครงการ
                        สามารถติดต่อได้ตามช่องทางด้านล่าง</p>
                </div>

                <div class="row g-4">
                    <!-- Contact Info -->
                    <div class="col-md-5">
                        <div class="card shadow-sm border-0 rounded-3 mb-4">
                            <div class="card-body">
                                <h5 class="fw-bold mb-3">ข้อมูลการติดต่อทีมวิจัย</h5>
                                <p><i class="bi bi-geo-alt-fill text-success"></i> คณะวิทยาศาสตร์และเทคโนโลยี มหาวิทยาลัยราชภัฏวไลยอลงกรณ์ ในพระบรมราชูปถัมภ์ จังหวัดปทุมธานี</p>
                                <p><i class="bi bi-envelope-fill text-success"></i> sciencetech@vru.ac.th</p>
                                <p><i class="bi bi-telephone-fill text-success"></i> 09-2265-8433</p>
                            </div>
                        </div>
                        <div class="card shadow-sm border-0 rounded-3">
                            <div class="card-body">
                                <h5 class="fw-bold mb-3">ข้อมูลการติดต่อหัวหน้าวิจัย</h5>
                                <p><i class="bi bi-person-fill text-success"></i><label><strong> ผศ.ดร.วิศรุต ขวัญคุ้ม</strong> (หัวหน้าโครงการวิจัย)</label></p>
                                <p><i class="bi bi-geo-alt-fill text-success"></i> คณะวิทยาศาสตร์และเทคโนโลยี มหาวิทยาลัยราชภัฏวไลยอลงกรณ์ ในพระบรมราชูปถัมภ์ จังหวัดปทุมธานี</p>
                                <p><i class="bi bi-envelope-fill text-success"></i> wisrut@vru.ac.th</p>
                                <p><i class="bi bi-telephone-fill text-success"></i> 08-6202-0656</p>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div class="col-md-7">
                        <div class="card shadow-sm border-0 rounded-3">
                            <div class="card-body">
                                <h5 class="fw-bold mb-3">ส่งข้อความถึงเรา</h5>
                                <form method="POST" action="{{ route('contact.send') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">ชื่อ-นามสกุล</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">อีเมล</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="message" class="form-label">ข้อความ</label>
                                        <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-success px-4">
                                        <i class="bi bi-send-fill"></i> ส่งข้อความ
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-layout>
