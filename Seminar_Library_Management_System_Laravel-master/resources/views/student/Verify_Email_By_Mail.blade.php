<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f6f8;font-family:'Segoe UI',Arial,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f8;padding:40px 0;">
        <tr>
            <td align="center">
                <table width="520" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.08);">

                    {{-- Header --}}
                    <tr>
                        <td style="background:linear-gradient(135deg,#1d7a53,#2E9E6B);padding:36px 40px;text-align:center;">
                            <div style="width:56px;height:56px;background:rgba(255,255,255,0.15);border-radius:14px;display:inline-flex;align-items:center;justify-content:center;margin-bottom:14px;">
                                <span style="font-size:28px;">📚</span>
                            </div>
                            <h1 style="margin:0;color:#ffffff;font-size:20px;font-weight:700;letter-spacing:-0.3px;">Seminar Library</h1>
                            <p style="margin:4px 0 0;color:rgba(255,255,255,0.75);font-size:13px;">Management System</p>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding:40px 40px 32px;">
                            <h2 style="margin:0 0 8px;color:#1C1F2E;font-size:22px;font-weight:700;">Verify your email address</h2>
                            <p style="margin:0 0 28px;color:#6B7280;font-size:14px;line-height:1.6;">
                                To complete your registration, enter the verification code below on the confirmation page.
                            </p>

                            {{-- Code box --}}
                            <div style="background:#f0fdf4;border:2px dashed #2E9E6B;border-radius:12px;padding:24px;text-align:center;margin-bottom:28px;">
                                <p style="margin:0 0 6px;color:#6B7280;font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:1px;">Your verification code</p>
                                <p style="margin:0;color:#1d7a53;font-size:40px;font-weight:800;letter-spacing:12px;">{{ substr($details['body'], -4) }}</p>
                            </div>

                            <p style="margin:0 0 6px;color:#9CA3AF;font-size:13px;line-height:1.6;">
                                This code expires in <strong style="color:#374151;">10 minutes</strong>. If you did not create an account, you can safely ignore this email.
                            </p>
                        </td>
                    </tr>

                    {{-- Divider --}}
                    <tr>
                        <td style="padding:0 40px;">
                            <hr style="border:none;border-top:1px solid #E8EDF2;margin:0;">
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="padding:24px 40px;text-align:center;">
                            <p style="margin:0;color:#9CA3AF;font-size:12px;line-height:1.6;">
                                This is an automated message from <strong style="color:#374151;">Seminar Library Management System</strong>.<br>
                                Please do not reply to this email.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
