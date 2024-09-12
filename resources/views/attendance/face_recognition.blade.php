<x-app-layout>
    <x-slot:title>Face Recognition</x-slot:title>
    <div class="page-wrapper">
        <x-page-header title="Face Recognition" />
        <x-page-body>
            <div class="row">
                <div class="col-12 col-sm-12 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <video class="img-fluid rounded" id="video" width="auto" height="auto" autoplay></video>
                            <canvas id="canvas" style="display:none;"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Status presensi</label>
                                <input type="text" class="form-control" name="status-presensi"
                                    placeholder="Readonly..." value="Belum presensi" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status Anda</label>
                                <input type="text" class="form-control" name="last-status" placeholder="Readonly..."
                                    value="-" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-page-body>
    </div>

    @push('styles')
        <style>
            #video {
                transform: scaleX(-1);
            }
        </style>
    @endpush
    @push('scripts')
        <script>
            async function setupCamera() {
                const stream = await navigator.mediaDevices.getUserMedia({
                    video: true
                });
                document.getElementById('video').srcObject = stream;
            }

            async function captureAndRecognize() {
                const video = document.getElementById('video');
                const canvas = document.getElementById('canvas');
                const context = canvas.getContext('2d');

                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                context.drawImage(video, 0, 0, canvas.width, canvas.height);

                const dataUrl = canvas.toDataURL('image/jpeg');
                const base64Image = dataUrl.split(',')[1];

                const response = await fetch('{{ route('user.attendance.recognize', $meeting->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        image: base64Image
                    })
                });

                const result = await response.json();
                if (result.status === 'success') {
                    if (result.status_presensi == 'Hadir') {
                        location.reload();
                    }
                    $('input[name="status-presensi"]').val(result.status_presensi);
                    $('input[name="last-status"]').val('Memperhatikan');
                } else {
                    $('input[name="last-status"]').val('Tidak Memperhatikan');
                }
            }

            setupCamera();

            // Set an interval to capture and recognize every 5 seconds
            setInterval(captureAndRecognize, 5000);
        </script>
    @endpush
</x-app-layout>
