<x-app-layout>
    <x-slot:title>Face register</x-slot:title>
    <div class="page-wrapper">
        <x-page-header title="Face register" />
        <x-page-body>
            @if (session('success'))
                <div class="col-12 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="col-12 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if ($errors->any())
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <form action="{{ route('user.create.face.register') }}" method="POST" class="card">
                @csrf
                @method('POST')
                <div class="card-body">
                    <div class="mb-3 row">
                        <label class="col-3 col-form-label required">Nama</label>
                        <div class="col">
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', auth()->user()->full_name ?? '') }}" placeholder="Jhon doe">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-3 col-form-label required">NIM</label>
                        <div class="col">
                            <input type="text" name="nim" value="{{ old('nim') }}" class="form-control"
                                placeholder="20012345">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-3 col-form-label required">Fakultas/Kampus daerah</label>
                        <div class="col">
                            <input type="text" name="faculty" value="{{ old('faculty') }}" class="form-control"
                                placeholder="Kampus UPI di Cibiru">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-3 col-form-label required">Program studi</label>
                        <div class="col">
                            <input type="text" name="majoring" value="{{ old('majoring') }}" class="form-control"
                                placeholder="Teknik Komputer">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-3 col-form-label required">Wajah</label>
                        <div class="col">
                            <div class="row">
                                <input type="hidden" name="registered_face" id="register_image">
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
            const camera_button = document.querySelector("#start-camera");
            const video = document.querySelector("#video");
            const click_button = document.querySelector("#click-photo");
            const canvas = document.querySelector("#canvas");
            const registerImageInput = document.getElementById('register_image');


            async function startCamera() {
                try {
                    const stream = await navigator.mediaDevices.getUserMedia({
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
                registerImageInput.value = image_data_url;
            });
        </script>
    @endpush
</x-app-layout>
