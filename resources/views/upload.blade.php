<x-bootstrap title="Upload Plant Image">
    <div class="container">

        <h1>Upload an Image for Plant Classification</h1>

        <section>
            <div class="row my-5">
                <div class="col-lg-12">
                    <form action="{{ route('classify.plant') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="image" accept="image/*" required>
                        <button class="btn btn-primary" type="submit">Classify Plant</button>
                    </form>
                </div>
            </div>
        </section>

        <hr />
        <section>
            <h2># For example</h2>
            <div class="row">
                <div class="col-lg-3">
                    
                    <img class="img-thumbnail" src="{{ asset('img/banana.jpg') }}" height="200" />

                </div>
                <div class="col-lg-9">
                    <p>Plant Classification คือกระบวนการจัดกลุ่มและระบุชนิดของพืชโดยอิงตามลักษณะทางกายภาพ สัณฐานวิทยา พันธุกรรม หรือคุณสมบัติอื่น ๆ ที่สามารถตรวจวัดได้ โดยมีวัตถุประสงค์เพื่อให้สามารถแยกแยะหรือจัดกลุ่มพืชในลักษณะระบบระเบียบ ซึ่งเป็นประโยชน์ทั้งในทางชีววิทยา การเกษตร และสิ่งแวดล้อม ปัจจุบันการใช้ AI ในการจำแนกพืชกำลังเป็นที่นิยม โดยใช้ Machine Learning และ Deep Learning เพื่อวิเคราะห์ภาพถ่ายพืชแล้วระบุชนิดพืชได้อย่างแม่นยำ</p>


                </div>
            </div>
        </section>

        <hr />
        <section>
            <div class="row">
                <div class="col-lg-6">
                    <h2># ใช้งานฟีเจอร์นี้ผ่านไลน์ - เพิ่มเพื่อน</h2>
                    <img src="{{ asset('img/M_285yxxte_BW.png') }}" height="200" />
                    <a href="https://lin.ee/0Xx8QEw"><img src="https://scdn.line-apps.com/n/line_add_friends/btn/th.png"
                            alt="เพิ่มเพื่อน" height="36" border="0"></a>
                </div>
            </div>
        </section>

        <hr />
        <section>
            <div class="row">
                <div class="col-lg-12">
                    <h2># ตัวอย่างการใช้งานผ่านไลน์ - ส่งรูปรับคำตอบ</h2>
                    <img src="{{ asset('img/example-line-2.jpg') }}" height="700" />
                </div>
            </div>
        </section>
    </div>
</x-bootstrap>
