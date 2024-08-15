<x-guest-layout>
    <x-slot:title>Login</x-slot:title>
    <h2 class="h3 text-center mb-3">
        Login to your account
    </h2>
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <div class="alert alert-warning">
                        <i class="ti ti-alert-triangle-filled"></i>
                        {{ $error }}
                    </div>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ url('login') }}" method="POST" autocomplete="off" novalidate="">
        @method('POST')
        @csrf
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" class="form-control" name="username" placeholder="username" autocomplete="off"
                required>
        </div>
        <div class="mb-2">
            <label class="form-label">
                Password
            </label>
            <input type="password" class="form-control" name="password" placeholder="your password" autocomplete="off"
                required>
        </div>
        <div class="mb-2">
            <label class="form-check">
                <input type="checkbox" name="remember" class="form-check-input" value="1">
                <span class="form-check-label">Remember me on this device</span>
            </label>
        </div>
        <div class="form-footer">
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </div>
    </form>
</x-guest-layout>
