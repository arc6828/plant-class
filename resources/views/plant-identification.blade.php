<x-layout title="Plant Identification">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">🌿 อัปโหลดภาพเพื่อจำแนกพรรณไม้</h4>
                    </div>
                    <script>
                        // image onchange event handler
                        function onChangedImage(event) {
                            const [file] = event.target.files ?? [];
                            if (file) {
                                const img = document.getElementById('uploadedImage');
                                img.src = URL.createObjectURL(file);
                                img.style.display = 'inline';

                                // render resultSection to none
                                const resultSection = document.getElementById('resultSection');
                                if (resultSection) {
                                    resultSection.style.display = 'none';
                                }

                                // send Request to upload image to server and get URL
                                const formData = new FormData();
                                formData.append('file', file);
                                const log = document.getElementById('log');
                                fetch('https://ml.ckartisan.com/photo/upload', {
                                        method: 'POST',
                                        body: formData,
                                        headers: {
                                            // 'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        }
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        console.log(data);
                                        log.innerText = 'อัปโหลดภาพสำเร็จ: ' + JSON.stringify(data);
                                        if (data) {
                                            document.querySelector('input[name="plantImageURL"]').value = data.jpeg_url;
                                        } else {
                                            console.error('Error uploading image:', data.error);
                                            log.innerText = 'อัปโหลดภาพสำเร็จ แต่ Return อะไรมาไม่รู้: ' + JSON.stringify(data);
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error uploading image:', error);
                                        log.innerText = 'อัปโหลดภาพไม่สำเร็จ ' + JSON.stringify(error);
                                    });
                            }
                        }
                    </script>
                    <div class="card-body">
                        <form method="POST" action="{{ route('plant.identify') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="plantImage" class="form-label">เลือกไฟล์ภาพ</label>
                                <input type="file" name="plantImage" id="plantImage" class="form-control"
                                    accept="image/*" onchange="onChangedImage(event)" required >
                                <input type="text" name="plantImageURL" value="" required>
                            </div>
                            <div id="log"></div>
                            <button type="submit" class="btn btn-success w-100">🔍 วิเคราะห์พรรณไม้</button>
                        </form>
                    </div>
                </div>
                {{-- Display image after input file change --}}
                <div class="text-center mt-4">
                    <img id="uploadedImage" src="#" alt="Uploaded Plant Image"
                        class="img-fluid rounded shadow-sm" style="max-height: 300px; display: none;">
                </div>                

                <!-- ส่วนแสดงผลลัพธ์ -->

                @if (session('result'))
                    <div id="resultSection" class="mt-4">
                        {{-- display image from storage --}}
                        <div class="text-center mt-4">
                            {{-- <img src="{{ asset('storage/' . session('imagePath')) }}" alt="Uploaded Plant Image"
                                class="img-fluid rounded shadow-sm" style="max-height: 300px;"> --}}
                            <img src="{{ session('imagePath') }}" alt="Uploaded Plant Image"
                                class="img-fluid rounded shadow-sm" style="max-height: 300px;">
                        </div>
                        <div class="alert alert-info mt-4">
                            <h5>ผลการจำแนก:</h5>
                            <p class="d-none">{{ session('result') }}</p>
                            @php
                                // save string to variable from session('result')
                                $str = session('result');
                                // clean up the string if it contains unwanted characters like ```json
                                $str = preg_replace('/^```json|```$/', '', trim($str));

                                // decode json string to object
                                $result = json_decode($str, false);

                            @endphp
                            @if ($result && isset($result->scientific_name))
                                <ul>
                                    <li><strong>ชื่อวิทยาศาสตร์:</strong> {{ $result->scientific_name }}</li>
                                    <li><strong>ชื่อสามัญ (ไทย):</strong> {{ $result->common_name_th }}</li>
                                    <li><strong>ชื่อสามัญ (อังกฤษ):</strong> {{ $result->common_name_en }}</li>
                                    <li><strong>รายละเอียด:</strong> {{ $result->description }}</li>
                                </ul>
                                {{-- Query ข้อมูลจาก DB --}}
                                @php
                                    // Query
                                    $plant = \App\Models\Plant::where(
                                        'scientific_name',
                                        $result->scientific_name,
                                    )->first();
                                    // if null query from soft condition
                                    if (!$plant) {
                                        $plant = \App\Models\Plant::where(
                                            'common_name',
                                            'like',
                                            "%{$result->common_name_en}%",
                                        )->first();
                                    }
                                    if (!$plant) {
                                        $plant = \App\Models\Plant::where(
                                            'common_name_th',
                                            'like',
                                            "%{$result->common_name_th}%",
                                        )->first();
                                    }

                                @endphp
                                @if ($plant)
                                    <div class="card mt-3">
                                        <div id="plantCarousel" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-inner">
                                                @foreach ($plant->images as $index => $img)
                                                    <div
                                                        class="carousel-item @if ($index == 0) active @endif">
                                                        <img src="{{ $img }}"
                                                            class="d-block w-100 rounded shadow-sm"
                                                            alt="{{ $plant->common_name_th }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button class="carousel-control-prev" type="button"
                                                data-bs-target="#plantCarousel" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon"></span>
                                            </button>
                                            <button class="carousel-control-next" type="button"
                                                data-bs-target="#plantCarousel" data-bs-slide="next">
                                                <span class="carousel-control-next-icon"></span>
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $plant->common_name_th }}
                                                ({{ $plant->common_name }})</h5>
                                            <p class="card-text">{{ $plant->description }}</p>
                                        </div>
                                        {{-- ลิงค์ไปยังหน้ารายละเอียด --}}
                                        <div class="card-footer text-center">
                                            <a href="{{ route('plants.show', $plant) }}"
                                                class="btn btn-primary">ดูรายละเอียดเพิ่มเติม</a>
                                        </div>

                                    </div>
                                @endif
                            @else
                                <p>ไม่สามารถแยกวิเคราะห์ผลลัพธ์ได้อย่างถูกต้อง</p>
                            @endif
                        </div>
                    </div>
                @endif


            </div>
        </div>
    </div>
</x-layout>
