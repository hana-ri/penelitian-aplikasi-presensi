<x-app-layout>
    <x-slot:title>Face register</x-slot:title>
    <div class="page-wrapper">
        <x-page-header title="Data {{ $user->full_name }}" />
        <x-page-body>
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="empty">
                            <img src="{{ route('user.face.show', ['user_id' => $user_id]) }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="empty">
                            <img src="{{ route('user.face.show', ['user_id' => $user_id, 'meeting_id' => $meeting_id]) }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <div class="card">
                        <div class="empty">
                            <p class="empty-title">Informasi pada LSB</p>
                            <p class="empty-subtitle text-secondary">
                                {{ $lsb_message }}
                              </p>
                            {{-- <img src="http://127.0.0.1:8000/assets/images/user.svg" alt=""> --}}
                        </div>
                    </div>
                </div>
            </div>
        </x-page-body>
    </div>
</x-app-layout>
