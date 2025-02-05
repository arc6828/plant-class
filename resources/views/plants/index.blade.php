<x-bootstrap title="Plant Database">
    <div class="container">

        <h1 class="text-center">ฐานข้อมูลเอกลักษณ์พรรณพืช</h1>
        <!-- Search Form -->
        <form method="GET" action="{{ route('plants.index') }}" class="my-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search plants..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>

        <section>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            {{-- <th>#</th> --}}
                            <th>Species</th>
                            <th>ชื่อสามัญ</th>
                            <th>ชื่อไทย</th>
                            <th>Family</th>
                            <th>Genus</th>
                            <th>Image</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($plants as $index => $plant)
                        <tr>
                            {{-- <td>{{ $loop->iteration }}</td> --}}
                            <td>{{ $plant->species_name }}</td>                            
                            <td>{{ $plant->common_name }}</td>
                            <td>{{ $plant->common_name_th }}</td>
                            <td>{{ $plant->family }}</td>
                            <td>{{ $plant->genus }}</td>
                            <td>                                
                                <a href="{{ $plant->firstImage }}" target="_blank"><img src="{{ $plant->firstImage }}" alt="Plant Image" width="50"></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            
            </div>
            
                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $plants->appends(['search' => request('search')])->links() }}
                </div>
        </section>

        <small> บริการระบุชนิดพันธุ์พืชตามภาพที่ใช้มีพื้นฐานมาจาก API การจดจำ Pl@ntNet อัปเดตเป็นประจำและเข้าถึงได้ผ่านไซต์ <a href="https://my.plantnet.org">https://my.plantnet.org</a> </small>
    </div>
</x-bootstrap>
