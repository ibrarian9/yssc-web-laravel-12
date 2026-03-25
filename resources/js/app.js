import './bootstrap';

/**
 * Global file upload size validation
 * Shows SweetAlert2 warning when file is too large
 */
document.addEventListener('change', function (e) {
    if (e.target.type !== 'file' || !e.target.files.length) return;

    const file = e.target.files[0];
    const isImage = file.type.startsWith('image/');
    const maxSizeMB = isImage ? 2 : 10; // 2MB for images, 10MB for documents
    const maxSizeBytes = maxSizeMB * 1024 * 1024;

    if (file.size > maxSizeBytes) {
        const fileSizeMB = (file.size / (1024 * 1024)).toFixed(1);

        // Clear the file input
        e.target.value = '';
        e.target.dispatchEvent(new Event('input', { bubbles: true }));

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'warning',
                title: 'File Terlalu Besar!',
                html: `
                    <div style="text-align:left; font-size:14px; line-height:1.7">
                        <p><strong>${file.name}</strong></p>
                        <p>Ukuran: <strong>${fileSizeMB} MB</strong></p>
                        <p>Maksimal: <strong>${maxSizeMB} MB</strong></p>
                    </div>
                `,
                confirmButtonText: 'Mengerti',
                confirmButtonColor: '#0d9488',
            });
        } else {
            alert(`File "${file.name}" terlalu besar (${fileSizeMB} MB). Maksimal ${maxSizeMB} MB.`);
        }
    }
});

/**
 * Livewire upload error handler
 * Catches server-side upload failures (413, validation, etc.)
 */
document.addEventListener('livewire:init', () => {
    Livewire.hook('request', ({ fail }) => {
        fail(({ status }) => {
            if (status === 413) {
                Swal.fire({
                    icon: 'error',
                    title: 'Upload Gagal!',
                    text: 'File terlalu besar untuk diproses server. Gunakan file di bawah 2 MB.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#0d9488',
                });
            }
        });
    });
});
