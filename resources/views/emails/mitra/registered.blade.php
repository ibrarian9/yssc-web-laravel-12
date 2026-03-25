<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"></head>
<body style="font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; margin: 0; padding: 40px 20px;">
    <div style="max-width: 560px; margin: 0 auto; background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.06);">
        {{-- Header --}}
        <div style="background: linear-gradient(135deg, #0d9488, #14b8a6); padding: 32px; text-align: center;">
            <h1 style="color: white; margin: 0; font-size: 20px;">🤝 Pendaftaran Mitra Baru</h1>
        </div>

        {{-- Body --}}
        <div style="padding: 32px;">
            <p style="color: #374151; font-size: 15px; line-height: 1.6;">Halo Admin,</p>
            <p style="color: #6b7280; font-size: 14px; line-height: 1.6;">Ada pendaftaran mitra baru yang memerlukan persetujuan Anda:</p>

            <div style="background: #f0fdfa; border-radius: 12px; padding: 20px; margin: 20px 0;">
                <table style="width: 100%; font-size: 14px;">
                    <tr><td style="color: #6b7280; padding: 6px 0; width: 120px;">Jenis Mitra</td><td style="color: #111827; font-weight: 600;">{{ $mitra->jenis_mitra->label() }}</td></tr>
                    <tr><td style="color: #6b7280; padding: 6px 0;">Perusahaan</td><td style="color: #111827; font-weight: 600;">{{ $mitra->nama_perusahaan }}</td></tr>
                    <tr><td style="color: #6b7280; padding: 6px 0;">Email</td><td style="color: #111827;">{{ $mitra->email }}</td></tr>
                    <tr><td style="color: #6b7280; padding: 6px 0;">Telepon</td><td style="color: #111827;">{{ $mitra->telepon }}</td></tr>
                    <tr><td style="color: #6b7280; padding: 6px 0;">NPWP</td><td style="color: #111827; font-family: monospace;">{{ $mitra->npwp }}</td></tr>
                </table>
            </div>

            <p style="color: #6b7280; font-size: 14px;">Silakan login ke panel admin untuk meninjau dan menyetujui/menolak pendaftaran ini.</p>

            <div style="text-align: center; margin: 24px 0;">
                <a href="{{ url('/admin/mitra') }}" style="display: inline-block; background: linear-gradient(135deg, #0d9488, #14b8a6); color: white; text-decoration: none; padding: 12px 32px; border-radius: 10px; font-weight: 700; font-size: 14px;">
                    Tinjau di Admin Panel
                </a>
            </div>
        </div>

        {{-- Footer --}}
        <div style="padding: 20px 32px; background: #f9fafb; border-top: 1px solid #e5e7eb; text-align: center;">
            <p style="color: #9ca3af; font-size: 12px; margin: 0;">© {{ date('Y') }} Yayasan Seribu Satu Cita</p>
        </div>
    </div>
</body>
</html>
