<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}">
    @csrf
    @method('patch')

    <div class="mb-3">
        <label for="name" class="form-label fw-medium">Nama</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
            value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label fw-medium">Email</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
            value="{{ old('email', $user->email) }}" required autocomplete="username">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
            <div class="mt-2">
                <p class="small text-warning">
                    Alamat email Anda belum terverifikasi.
                    <button form="send-verification" class="btn btn-link btn-sm p-0 text-decoration-none">
                        Klik di sini untuk mengirim ulang email verifikasi.
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                    <p class="small text-success">
                        Link verifikasi baru telah dikirim ke alamat email Anda.
                    </p>
                @endif
            </div>
        @endif
    </div>

    <div class="d-flex align-items-center">
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </div>
</form>
