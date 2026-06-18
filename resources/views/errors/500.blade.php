<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Terjadi Kesalahan — {{ config('app.name') }}</title>
    <style>
        :root { --ink:#201515; --primary:#ff4f00; --canvas:#fffefb; --body:#605d52; --soft:#f8f4f0; }
        * { box-sizing: border-box; }
        body {
            margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center;
            background: var(--canvas); color: var(--body);
            font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, sans-serif;
            background-image: radial-gradient(circle, rgba(32,21,21,.06) 1px, transparent 1px);
            background-size: 22px 22px;
            padding: 24px;
        }
        .card { max-width: 560px; text-align: center; }
        .badge {
            display: inline-block; background: var(--soft); color: var(--ink);
            border-radius: 9999px; padding: 6px 14px; font-size: 14px; font-weight: 500;
        }
        .num { font-size: 96px; font-weight: 600; color: var(--ink); line-height: 1; margin: 18px 0 8px; }
        .num span { color: var(--primary); }
        h1 { color: var(--ink); font-size: 26px; font-weight: 600; margin: 0 0 8px; }
        p { font-size: 17px; line-height: 1.6; margin: 0 0 24px; }
        a.btn {
            display: inline-block; background: var(--primary); color: var(--canvas);
            text-decoration: none; font-weight: 600; padding: 12px 24px; border-radius: 12px;
        }
        a.btn:hover { filter: brightness(.95); }
    </style>
</head>
<body>
    <div class="card">
        <span class="badge">500 — Terjadi kesalahan</span>
        <div class="num">5<span>0</span>0</div>
        <h1>Ada gangguan sejenak di sisi kami</h1>
        <p>Maaf, terjadi kesalahan saat memproses permintaan Anda. Tim kami sedang menanganinya. Silakan coba beberapa saat lagi.</p>
        <a class="btn" href="{{ url('/') }}">Kembali ke Beranda</a>
    </div>
</body>
</html>
