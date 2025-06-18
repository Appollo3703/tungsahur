<form method="post" action="{{ route('password.update') }}">
    @csrf
    @method('put')

    <div class="mb-3">
        <label for="update_password_current_password" class="form-label fw-medium">Password Saat Ini</label>
        <input type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
            id="update_password_current_password" name="current_password" autocomplete="current-password">
        @error('current_password', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="update_password_password" class="form-label fw-medium">Password Baru</label>
        <input type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror"
            id="update_password_password" name="password" autocomplete="new-password">
        @error('password', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="update_password_password_confirmation" class="form-label fw-medium">Konfirmasi Password Baru</label>
        <input type="password"
            class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
            id="update_password_password_confirmation" name="password_confirmation" autocomplete="new-password">
        @error('password_confirmation', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex align-items-center">
        <button type="submit" class="btn btn-primary">Simpan Password</button>
    </div>
</form>
