<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"></head>
<body style="font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; margin: 0; padding: 40px 20px;">
    <div style="max-width: 560px; margin: 0 auto; background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.06);">
        <div style="background: linear-gradient(135deg, #059669, #10b981); padding: 32px; text-align: center;">
            <h1 style="color: white; margin: 0; font-size: 20px;">✅ Pendaftaran Disetujui!</h1>
        </div>

        <div style="padding: 32px;">
            <p style="color: #374151; font-size: 15px; line-height: 1.6;">Halo <strong>{{ $mitra->nama_perusahaan }}</strong>,</p>
            <p style="color: #6b7280; font-size: 14px; line-height: 1.6;">Selamat! Pendaftaran Anda sebagai <strong>Mitra {{ $mitra->jenis_mitra->label() }}</strong> di Yayasan Seribu Satu Cita telah <span style="color: #059669; font-weight: 700;">disetujui</span>.</p>

            {{-- Login Credentials --}}
            <div style="background: #f0fdf4; border: 2px solid #bbf7d0; border-radius: 12px; padding: 20px; margin: 20px 0;">
                <p style="color: #059669; font-weight: 700; font-size: 14px; margin: 0 0 12px;">🔐 Akun Login Mitra Panel</p>
                <table style="width: 100%; font-size: 14px;">
                    <tr><td style="color: #6b7280; padding: 4px 0; width: 80px;">Email</td><td style="color: #111827; font-weight: 600;">{{ $mitra->email }}</td></tr>
                    <tr><td style="color: #6b7280; padding: 4px 0;">Password</td><td style="color: #111827; font-weight: 600; font-family: monospace;">{{ $mitra->tempPassword ?? '(Lihat email terpisah)' }}</td></tr>
                </table>
                <p style="color: #6b7280; font-size: 12px; margin: 12px 0 0; font-style: italic;">⚠️ Segera ganti password setelah login pertama.</p>
            </div>

            @if($mitra->catatan_admin)
                <div style="background: #f0fdf4; border-left: 4px solid #10b981; padding: 16px; border-radius: 0 8px 8px 0; margin: 20px 0;">
                    <p style="color: #6b7280; font-size: 12px; margin: 0 0 4px;">Catatan dari Admin:</p>
                    <p style="color: #374151; font-size: 14px; margin: 0;">{{ $mitra->catatan_admin }}</p>
                </div>
            @endif

            <p style="color: #6b7280; font-size: 14px; line-height: 1.6;">Gunakan akun di atas untuk login ke Mitra Panel dan mulai membuat program donasi serta berita.</p>

            <div style="text-align: center; margin: 24px 0;">
                <a href="{{ url('/mitra-panel') }}" style="display: inline-block; background: linear-gradient(135deg, #059669, #10b981); color: white; text-decoration: none; padding: 12px 32px; border-radius: 10px; font-weight: 700; font-size: 14px;">
                    Masuk ke Mitra Panel
                </a>
            </div>
        </div>

        <div style="padding: 20px 32px; background: #f9fafb; border-top: 1px solid #e5e7eb; text-align: center;">
            <p style="color: #9ca3af; font-size: 12px; margin: 0;">© {{ date('Y') }} Yayasan Seribu Satu Cita</p>
        </div>
    </div>
</body>
</html>
