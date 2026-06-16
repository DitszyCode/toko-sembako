<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pesan Baru - Toko Sembako</title>
</head>
<body style="margin:0;padding:0;background:#f3f4f6;font-family:Arial,sans-serif;">
    <div style="max-width:600px;margin:30px auto;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.1);">

        <!-- Header -->
        <div style="background:linear-gradient(135deg,#14532d,#166534);padding:30px;text-align:center;">
            <h1 style="color:#fff;margin:0;font-size:24px;">🛒 Toko Sembako</h1>
            <p style="color:#bbf7d0;margin:8px 0 0;font-size:14px;">Pesan Baru dari Pelanggan</p>
        </div>

        <!-- Content -->
        <div style="padding:30px;">
            <h2 style="color:#1f2937;font-size:20px;margin:0 0 20px;">Halo Admin,</h2>
            <p style="color:#4b5563;font-size:15px;line-height:1.6;margin:0 0 24px;">
                Anda menerima pesan baru dari pelanggan melalui halaman kontak. Berikut detailnya:
            </p>

            <!-- Info Box -->
            <div style="background:#f9fafb;border-radius:10px;padding:20px;margin-bottom:24px;">
                <table style="width:100%;border-collapse:collapse;">
                    <tr>
                        <td style="padding:8px 0;color:#6b7280;font-size:14px;width:120px;">Nama</td>
                        <td style="padding:8px 0;color:#111827;font-size:14px;font-weight:600;">{{ $name }}</td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0;color:#6b7280;font-size:14px;">Email</td>
                        <td style="padding:8px 0;color:#111827;font-size:14px;">
                            <a href="mailto:{{ $email }}" style="color:#059669;text-decoration:none;">{{ $email }}</a>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0;color:#6b7280;font-size:14px;">Telepon</td>
                        <td style="padding:8px 0;color:#111827;font-size:14px;">{{ $phone }}</td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0;color:#6b7280;font-size:14px;">Subjek</td>
                        <td style="padding:8px 0;">
                            <span style="background:#dcfce7;color:#166534;font-size:12px;padding:4px 10px;border-radius:20px;font-weight:600;">
                                {{ $subject }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Message -->
            <div style="background:#fffbeb;border-left:4px solid #f59e0b;border-radius:4px;padding:16px 20px;margin-bottom:24px;">
                <p style="color:#92400e;font-size:12px;font-weight:700;margin:0 0 8px;text-transform:uppercase;letter-spacing:0.5px;">Isi Pesan:</p>
                <p style="color:#1f2937;font-size:15px;line-height:1.7;margin:0;white-space:pre-wrap;">{!! nl2br(e($msgBody)) !!}</p>
            </div>

            <!-- Action -->
            <div style="text-align:center;margin-bottom:24px;">
                <a href="mailto:{{ $email }}" style="display:inline-block;background:#059669;color:#fff;text-decoration:none;padding:14px 28px;border-radius:10px;font-size:15px;font-weight:600;">
                    💬 Balas via Email
                </a>
            </div>

            <hr style="border:none;border-top:1px solid #e5e7eb;margin:24px 0;">
            <p style="color:#9ca3af;font-size:12px;text-align:center;margin:0;">
                Pesan ini dikirim otomatis dari halaman kontak website Toko Sembako.
            </p>
        </div>
    </div>
</body>
</html>
