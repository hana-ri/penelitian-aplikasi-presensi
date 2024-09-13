<x-app-layout>
    <x-slot:title>Face register</x-slot:title>
    <div class="page-wrapper">
        <x-page-header title="Data -" />
        <x-page-body>
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="empty">
                            <img src="http://127.0.0.1:8000/assets/images/user.svg" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="empty">
                            <img src="http://127.0.0.1:8000/assets/images/user.svg" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <div class="card">
                        <div class="empty">
                            <p class="empty-title">No results found</p>
                            <p class="empty-subtitle text-secondary">
                                Try adjusting your search or filter to find what you're looking for.
                              </p>
                            {{-- <img src="http://127.0.0.1:8000/assets/images/user.svg" alt=""> --}}
                        </div>
                    </div>
                </div>
            </div>
        </x-page-body>
    </div>
</x-app-layout>
