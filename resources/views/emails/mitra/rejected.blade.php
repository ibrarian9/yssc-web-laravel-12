<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"></head>
<body style="font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; margin: 0; padding: 40px 20px;">
    <div style="max-width: 560px; margin: 0 auto; background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.06);">
        <div style="background: linear-gradient(135deg, #dc2626, #ef4444); padding: 32px; text-align: center;">
            <h1 style="color: white; margin: 0; font-size: 20px;">❌ Pendaftaran Ditolak</h1>
        </div>

        <div style="padding: 32px;">
            <p style="color: #374151; font-size: 15px; line-height: 1.6;">Halo <strong>{{ $mitra->nama_perusahaan }}</strong>,</p>
            <p style="color: #6b7280; font-size: 14px; line-height: 1.6;">Mohon maaf, pendaftaran Anda sebagai Mitra di Yayasan Seribu Satu Cita <span style="color: #dc2626; font-weight: 700;">tidak dapat disetujui</span> saat ini.</p>

            @if($mitra->catatan_admin)
                <div style="background: #fef2f2; border-left: 4px solid #ef4444; padding: 16px; border-radius: 0 8px 8px 0; margin: 20px 0;">
                    <p style="color: #6b7280; font-size: 12px; margin: 0 0 4px;">Alasan:</p>
                    <p style="color: #374151; font-size: 14px; margin: 0;">{{ $mitra->catatan_admin }}</p>
                </div>
            @endif

            <p style="color: #6b7280; font-size: 14px; line-height: 1.6;">Jika Anda merasa ada kesalahan atau ingin mengajukan kembali, silakan hubungi kami melalui email atau kunjungi website kami.</p>

            <div style="text-align: center; margin: 24px 0;">
                <a href="{{ url('/mitra') }}" style="display: inline-block; background: linear-gradient(135deg, #0d9488, #14b8a6); color: white; text-decoration: none; padding: 12px 32px; border-radius: 10px; font-weight: 700; font-size: 14px;">
                    Daftar Ulang
                </a>
            </div>
        </div>

        <div style="padding: 20px 32px; background: #f9fafb; border-top: 1px solid #e5e7eb; text-align: center;">
            <p style="color: #9ca3af; font-size: 12px; margin: 0;">© {{ date('Y') }} Yayasan Seribu Satu Cita</p>
        </div>
    </div>
</body>
</html>
