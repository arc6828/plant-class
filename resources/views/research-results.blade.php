<x-layout>
    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="fw-bold">ผลการทดลองวิจัย (ตัวอย่าง)</h1>
            <p class="text-muted">
                หน้านี้แสดงผลการทดลองการจำแนกพรรณพืชด้วยโมเดลการเรียนรู้เชิงลึก
                โดยเปรียบเทียบประสิทธิภาพของโมเดล CNNs, Vision Transformers (ViTs) และโมเดลไฮบริด
            </p>
        </div>

        <!-- Table Results -->
        <div class="card shadow-sm border-0 rounded-3 mb-5">
            <div class="card-body">
                <h5 class="fw-bold mb-3">สรุปผลลัพธ์การทดสอบโมเดล</h5>
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead class="table-success">
                            <tr>
                                <th>โมเดล</th>
                                <th>Accuracy</th>
                                <th>Precision</th>
                                <th>Recall</th>
                                <th>F1-score</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>ResNet50 (CNN)</td>
                                <td>89.5%</td>
                                <td>88.7%</td>
                                <td>87.9%</td>
                                <td>88.3%</td>
                            </tr>
                            <tr>
                                <td>EfficientNet-B3 (CNN)</td>
                                <td>91.2%</td>
                                <td>90.5%</td>
                                <td>90.1%</td>
                                <td>90.3%</td>
                            </tr>
                            <tr>
                                <td>DeiT (Vision Transformer)</td>
                                <td>92.4%</td>
                                <td>91.8%</td>
                                <td>91.2%</td>
                                <td>91.5%</td>
                            </tr>
                            <tr>
                                <td>Hybrid (CNN + Transformer)</td>
                                <td><strong>94.1%</strong></td>
                                <td><strong>93.6%</strong></td>
                                <td><strong>93.0%</strong></td>
                                <td><strong>93.3%</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Chart Placeholder -->
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body text-center">
                <h5 class="fw-bold mb-3">การเปรียบเทียบผลลัพธ์แบบกราฟ</h5>
                <p class="text-muted">สามารถเพิ่มกราฟหรือ visualization ภายหลัง เช่น Chart.js หรือ Plotly</p>
                <img src="https://via.placeholder.com/800x400?text=Research+Results+Chart" alt="Chart Placeholder"
                    class="img-fluid rounded">
            </div>
        </div>
    </div>
</x-layout>
