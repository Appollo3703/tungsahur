<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
    Hapus Akun Saya
</button>

<div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <div class="modal-header">
                    <h5 class="modal-title" id="confirmUserDeletionModalLabel">Konfirmasi Hapus Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus akun Anda? Tindakan ini tidak dapat diurungkan.</p>
                    <p class="text-muted small">Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus
                        secara permanen. Harap masukkan password Anda untuk mengonfirmasi bahwa Anda ingin menghapus
                        akun Anda secara permanen.</p>

                    <div class="mt-3">
                        <label for="password_delete" class="form-label visually-hidden">Password</label>
                        <input type="password"
                            class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                            id="password_delete" name="password" placeholder="Password Anda" required>
                        @error('password', 'userDeletion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus Akun Saya</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if ($errors->userDeletion->isNotEmpty())
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var confirmUserDeletionModal = new bootstrap.Modal(document.getElementById('confirmUserDeletionModal'));
                confirmUserDeletionModal.show();
            });
        </script>
    @endpush
@endif
