<x-app-layout>
    <x-slot:title>Face register</x-slot:title>
    <div class="page-wrapper">
        <x-page-header title="Face register" />
        <x-page-body>
            <form action="" method="post" class="card">
                <div class="card-body">
                    <div class="mb-3 row">
                        <label class="col-3 col-form-label required">Nama</label>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Jhon doe">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-3 col-form-label required">NIM</label>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="20012345">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-3 col-form-label required">Fakultas/Kampus daerah</label>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Kampus Daerah Cibiru">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-3 col-form-label required">Program studi</label>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Teknik Komputer">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-3 col-form-label required">Wajah</label>
                        <div class="col">
                            <div class="row">
                                <input type="hidden" name="register_image">
                                <div class="col-12 col-sm-12 col-md-6 mb-3 mb-sm-3">
                                    <video id="video" class="rounded" width="320" height="240"
                                        autoplay></video>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 mb-3 mb-sm-3">
                                    <canvas id="canvas" class="rounded" width="320" height="240"></canvas>
                                </div>
                                <button type="button" id="click-photo" class="btn btn-outline-primary w-100">Ambil
                                    gambar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <div class="d-flex">
                        <a href="#" class="btn btn-link">Batal</a>
                        <button type="submit" class="btn btn-primary ms-auto">Simpan</button>
                    </div>
                </div>
            </form>
        </x-page-body>
    </div>
    @push('styles')
        <style>
            #video {
                transform: scaleX(-1);
            }

            #canvas {
                transform: scaleX(-1);
            }
        </style>
    @endpush
    @push('scripts')
        <script>
            let camera_button = document.querySelector("#start-camera");
            let video = document.querySelector("#video");
            let click_button = document.querySelector("#click-photo");
            let canvas = document.querySelector("#canvas");

            async function startCamera() {
                try {
                    let stream = await navigator.mediaDevices.getUserMedia({
                        video: true,
                        audio: false
                    });
                    video.srcObject = stream;
                    // defaultImage.src = 'path/to/your/default-image.jpg'; // Ganti dengan path gambar default kamu
                    // defaultImage.onload = function() {
                    //     context.drawImage(defaultImage, 0, 0, canvas.width, canvas.height);
                    // }
                } catch (error) {
                    console.error("Error accessing camera: ", error);
                }
            }

            // Panggil fungsi startCamera saat halaman dimuat
            window.addEventListener('load', startCamera);

            click_button.addEventListener('click', function() {
                canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
                let image_data_url = canvas.toDataURL('image/jpeg');
                console.log(image_data_url);
            });
        </script>
    @endpush
</x-app-layout>
