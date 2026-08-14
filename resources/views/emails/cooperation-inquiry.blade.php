<!DOCTYPE html>
<html lang="{{ $language }}">
<head>
    <meta charset="UTF-8">
    <title>{{ $labels['heading'] }}</title>
</head>
<body style="color:#202a33;font-family:Arial,sans-serif;line-height:1.6;margin:0;padding:28px;">
    <div style="margin:0 auto;max-width:680px;">
        <p style="color:#1d5c83;font-size:12px;font-weight:700;letter-spacing:.12em;margin:0 0 8px;text-transform:uppercase;">IANUBIH</p>
        <h1 style="color:#12243a;font-family:Georgia,serif;font-size:30px;margin:0 0 28px;">{{ $labels['heading'] }}</h1>

        <table role="presentation" style="border-collapse:collapse;width:100%;">
            <tr><td style="border-top:1px solid #d9dfe3;padding:12px 16px 12px 0;width:180px;"><strong>{{ $labels['name'] }}</strong></td><td style="border-top:1px solid #d9dfe3;padding:12px 0;">{{ $inquiry['name'] }}</td></tr>
            <tr><td style="border-top:1px solid #d9dfe3;padding:12px 16px 12px 0;"><strong>{{ $labels['email'] }}</strong></td><td style="border-top:1px solid #d9dfe3;padding:12px 0;"><a href="mailto:{{ $inquiry['email'] }}">{{ $inquiry['email'] }}</a></td></tr>
            <tr><td style="border-top:1px solid #d9dfe3;padding:12px 16px 12px 0;"><strong>{{ $labels['organization'] }}</strong></td><td style="border-top:1px solid #d9dfe3;padding:12px 0;">{{ $inquiry['organization'] ?: $labels['not_provided'] }}</td></tr>
            <tr><td style="border-top:1px solid #d9dfe3;padding:12px 16px 12px 0;"><strong>{{ $labels['partner_type'] }}</strong></td><td style="border-top:1px solid #d9dfe3;padding:12px 0;">{{ $partnerType }}</td></tr>
            <tr><td style="border-top:1px solid #d9dfe3;padding:12px 16px 12px 0;"><strong>{{ $labels['initiative_title'] }}</strong></td><td style="border-top:1px solid #d9dfe3;padding:12px 0;">{{ $inquiry['initiative_title'] }}</td></tr>
        </table>

        <h2 style="color:#12243a;font-family:Georgia,serif;font-size:22px;margin:30px 0 10px;">{{ $labels['message'] }}</h2>
        <div style="background:#f6f4ee;border-left:4px solid #c9a44c;padding:18px 22px;white-space:pre-line;">{{ $inquiry['message'] }}</div>
    </div>
</body>
</html>
