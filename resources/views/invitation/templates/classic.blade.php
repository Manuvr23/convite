<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $wedding->groom_name }} &amp; {{ $wedding->bride_name }}</title>
    <meta property="og:title" content="Boda de {{ $wedding->groom_name }} y {{ $wedding->bride_name }}">
    <meta property="og:description" content="{{ $guest->name }}, estas invitado/a a nuestra boda.">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:500,600,700,800|inter:300,400,500,600" rel="stylesheet" />
    <style>
        :root {
            --color-bg: #fbf7f1;
            --color-surface: #ffffff;
            --color-ink: #362a22;
            --color-ink-soft: #6f5f51;
            --color-gold: #b08d57;
            --color-gold-dark: #96703e;
            --color-gold-soft: #e4d3b6;
            --color-border: #e9ddc9;
            --color-success-bg: #eaf3e6;
            --color-success-ink: #33562f;
            --shadow-sm: 0 2px 10px rgba(54, 42, 34, .06);
            --shadow-md: 0 12px 32px rgba(54, 42, 34, .10);
            --radius-sm: 8px;
            --radius-md: 16px;
            --radius-lg: 24px;
            --ease-out: cubic-bezier(.16, .8, .24, 1);
            --ease-spring: cubic-bezier(.34, 1.56, .64, 1);
        }
        * { box-sizing: border-box; }
        html { -webkit-text-size-adjust: 100%; }
        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(120% 80% at 50% -10%, #fffdfa 0%, var(--color-bg) 55%);
            color: var(--color-ink);
            margin: 0;
            overflow-x: hidden;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }
        body:not(.revealed) { overflow: hidden; height: 100vh; }
        h1, h2 { font-family: 'Playfair Display', serif; font-weight: 700; margin: 0; }
        a { color: inherit; }
        button { font-family: inherit; }

        :focus-visible {
            outline: 2px solid var(--color-gold-dark);
            outline-offset: 3px;
            border-radius: 4px;
        }

        .wrap { max-width: 600px; margin: 0 auto; padding: 64px 28px 96px; text-align: center; }

        /* Ornamental divider */
        .ornament { display: flex; align-items: center; justify-content: center; gap: 14px; margin: 22px 0; }
        .ornament .line { height: 1px; width: 56px; background: linear-gradient(90deg, transparent, var(--color-gold-soft)); }
        .ornament .line.flip { background: linear-gradient(90deg, var(--color-gold-soft), transparent); }
        .ornament .dot { width: 6px; height: 6px; background: var(--color-gold); transform: rotate(45deg); flex-shrink: 0; }

        /* Scroll reveal */
        .reveal { opacity: 0; transform: translateY(26px); transition: opacity .8s var(--ease-out), transform .8s var(--ease-out); }
        .reveal.is-visible { opacity: 1; transform: translateY(0); }
        @media (prefers-reduced-motion: reduce) {
            .reveal { opacity: 1; transform: none; transition: none; }
        }

        /* Hero */
        .monogram { width: 78px; height: 78px; border-radius: 50%; border: 1.5px solid var(--color-gold); display: flex; align-items: center; justify-content: center; margin: 0 auto 22px; font-family: 'Playfair Display', serif; font-size: 1.15rem; letter-spacing: .5px; color: var(--color-gold-dark); white-space: nowrap; }
        .hero p.eyebrow { letter-spacing: 4px; text-transform: uppercase; font-size: .78rem; font-weight: 500; color: var(--color-gold-dark); margin: 0; }
        .hero h1 { font-size: clamp(2.5rem, 7vw, 3.4rem); line-height: 1.15; margin-top: 14px; }
        .guest-name { font-size: 1.05rem; color: var(--color-ink-soft); margin-top: 28px; max-width: 380px; margin-left: auto; margin-right: auto; }
        .guest-name strong { color: var(--color-ink); font-weight: 600; }

        .section { margin-top: 72px; padding-top: 40px; border-top: 1px solid var(--color-border); }
        .section h2 { font-size: 1.6rem; letter-spacing: .2px; }
        .section p { line-height: 1.75; color: var(--color-ink-soft); font-size: 1rem; }
        .section > p { max-width: 460px; margin-left: auto; margin-right: auto; }

        /* Countdown */
        #countdown { display: grid; grid-auto-flow: column; gap: 12px; justify-content: center; margin-top: 24px; }
        #countdown div { background: var(--color-surface); border: 1px solid var(--color-border); border-radius: var(--radius-md); padding: 16px 14px; min-width: 72px; box-shadow: var(--shadow-sm); }
        #countdown span { display: block; font-family: 'Playfair Display', serif; font-size: 1.7rem; font-weight: 700; font-variant-numeric: tabular-nums; color: var(--color-ink); }
        #countdown small { display: block; margin-top: 4px; letter-spacing: 1px; text-transform: uppercase; font-size: .68rem; color: var(--color-gold-dark); }

        /* Dress code badge */
        .dress-code { display: inline-flex; align-items: center; gap: 6px; margin-top: 16px; padding: 8px 18px; background: var(--color-surface); border: 1px solid var(--color-gold-soft); border-radius: 999px; font-size: .85rem; color: var(--color-gold-dark); font-weight: 500; }

        /* Map */
        .map-frame { width: 100%; height: 240px; border: 0; border-radius: var(--radius-md); margin-top: 24px; box-shadow: var(--shadow-sm); display: block; }
        .map-links { margin-top: 14px; display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; }
        .map-links a { font-size: .85rem; padding: 12px 20px; border-radius: var(--radius-sm); background: var(--color-ink); color: #fff; text-decoration: none; font-weight: 500; transition: transform .2s var(--ease-out), box-shadow .2s var(--ease-out); display: inline-block; }
        .map-links a:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }
        .map-links a:active { transform: translateY(0); }

        /* Itinerary timeline */
        .itinerary { list-style: none; padding: 0; margin: 32px auto 0; text-align: left; max-width: 340px; position: relative; }
        .itinerary::before { content: ''; position: absolute; left: 60px; top: 8px; bottom: 8px; width: 1px; background: var(--color-border); }
        .itinerary li { position: relative; padding: 0 0 28px 88px; min-height: 24px; }
        .itinerary li:last-child { padding-bottom: 0; }
        .itinerary .time { position: absolute; left: 0; top: 1px; width: 60px; text-align: right; padding-right: 18px; font-weight: 600; font-size: .88rem; color: var(--color-gold-dark); font-variant-numeric: tabular-nums; }
        .itinerary .time::after { content: ''; position: absolute; right: -3.5px; top: 4px; width: 8px; height: 8px; border-radius: 50%; background: var(--color-gold); box-shadow: 0 0 0 4px var(--color-bg); }
        .itinerary .title { font-size: .98rem; color: var(--color-ink); }

        /* Gallery */
        .gallery { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-top: 24px; }
        .gallery img { width: 100%; height: 128px; object-fit: cover; border-radius: var(--radius-sm); box-shadow: var(--shadow-sm); transition: transform .35s var(--ease-out); }
        .gallery img:hover { transform: scale(1.04); }

        /* Gift */
        .gift-box { background: var(--color-surface); border: 1px solid var(--color-border); border-radius: var(--radius-md); padding: 20px; margin-top: 20px; text-align: left; white-space: pre-wrap; font-size: .92rem; color: var(--color-ink-soft); box-shadow: var(--shadow-sm); max-width: 420px; margin-left: auto; margin-right: auto; }
        .gift-btn { display: inline-block; margin-top: 16px; padding: 13px 28px; background: var(--color-gold-dark); color: #fff; border-radius: var(--radius-sm); text-decoration: none; font-size: .92rem; font-weight: 500; transition: transform .2s var(--ease-out), box-shadow .2s var(--ease-out); }
        .gift-btn:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }

        /* RSVP */
        form.rsvp { text-align: left; max-width: 380px; margin: 28px auto 0; }
        .field { margin-top: 18px; }
        .field label.text-label { display: block; font-size: .85rem; font-weight: 500; color: var(--color-ink-soft); margin-bottom: 6px; }
        .radio-group { display: flex; gap: 10px; }
        .radio-pill { flex: 1; position: relative; }
        .radio-pill input { position: absolute; opacity: 0; width: 100%; height: 100%; margin: 0; cursor: pointer; }
        .radio-pill span { display: flex; align-items: center; justify-content: center; min-height: 48px; padding: 10px 12px; border: 1.5px solid var(--color-border); border-radius: var(--radius-sm); font-size: .92rem; text-align: center; transition: border-color .2s var(--ease-out), background .2s var(--ease-out), color .2s var(--ease-out); }
        .radio-pill:has(input:checked) span { border-color: var(--color-gold); background: var(--color-gold-soft); color: var(--color-gold-dark); font-weight: 600; }
        .radio-pill:has(input:focus-visible) span { outline: 2px solid var(--color-gold-dark); outline-offset: 2px; }
        form.rsvp input[type=number], form.rsvp textarea { width: 100%; padding: 12px 14px; margin-top: 4px; border: 1.5px solid var(--color-border); border-radius: var(--radius-sm); box-sizing: border-box; font-family: inherit; font-size: .95rem; background: var(--color-surface); color: var(--color-ink); transition: border-color .2s var(--ease-out); }
        form.rsvp input[type=number]:focus, form.rsvp textarea:focus { border-color: var(--color-gold); outline: none; }
        form.rsvp button[type=submit] { margin-top: 24px; width: 100%; background: var(--color-ink); color: #fff; padding: 15px; border: 0; border-radius: var(--radius-sm); font-size: 1rem; font-weight: 600; cursor: pointer; transition: transform .2s var(--ease-out), box-shadow .2s var(--ease-out), background .2s var(--ease-out); }
        form.rsvp button[type=submit]:hover { background: var(--color-gold-dark); transform: translateY(-2px); box-shadow: var(--shadow-md); }
        form.rsvp button[type=submit]:active { transform: translateY(0); }

        .status { margin-top: 20px; padding: 14px 16px; border-radius: var(--radius-sm); display: flex; align-items: center; gap: 10px; font-size: .92rem; }
        .status.ok { background: var(--color-success-bg); color: var(--color-success-ink); }
        .status svg { flex-shrink: 0; }
        .rsvp-done { margin-top: 24px; padding: 24px; background: var(--color-surface); border: 1px solid var(--color-border); border-radius: var(--radius-md); font-size: 1rem; box-shadow: var(--shadow-sm); }
        .rsvp-done svg { display: block; margin: 0 auto 12px; color: var(--color-gold-dark); }

        /* Music toggle */
        #music-toggle { position: fixed; bottom: 22px; right: 22px; width: 50px; height: 50px; border-radius: 50%; background: var(--color-ink); color: #fff; border: 0; cursor: pointer; box-shadow: var(--shadow-md); z-index: 10; display: flex; align-items: center; justify-content: center; transition: transform .2s var(--ease-out); }
        #music-toggle:hover { transform: scale(1.06); }
        #music-toggle:active { transform: scale(.96); }
        #music-toggle svg { width: 18px; height: 18px; }

        /* Envelope overlay */
        #envelope-overlay { position: fixed; inset: 0; background: radial-gradient(120% 100% at 50% 30%, #fbf3e4 0%, #efe0c4 100%); display: flex; flex-direction: column; align-items: center; justify-content: center; z-index: 9999; transition: opacity .5s var(--ease-out), visibility .5s; }
        #envelope-overlay.hidden { opacity: 0; visibility: hidden; pointer-events: none; }
        .envelope { appearance: none; background: none; border: 0; padding: 0; position: relative; width: 230px; height: 156px; cursor: pointer; transition: transform .25s var(--ease-out); }
        .envelope:hover { transform: translateY(-3px); }
        .envelope:active { transform: scale(.97); }
        .envelope .body { position: absolute; inset: 0; top: 22px; background: #fffaf1; border-radius: 6px; box-shadow: 0 16px 36px rgba(54, 42, 34, .22); }
        .envelope .body::before { content: ''; position: absolute; inset: 0; border: 1px solid var(--color-gold-soft); border-radius: 6px; }
        .envelope .seal { position: absolute; top: 64px; left: 50%; transform: translate(-50%, -50%); width: 54px; height: 54px; border-radius: 50%; background: var(--color-gold-dark); color: #fff; display: flex; align-items: center; justify-content: center; font-family: 'Playfair Display', serif; font-size: 1rem; letter-spacing: .5px; z-index: 3; box-shadow: 0 4px 14px rgba(150, 112, 62, .4); transition: opacity .3s ease, transform .3s ease; }
        .envelope .flap { position: absolute; top: 22px; left: 0; width: 0; height: 0; border-left: 115px solid transparent; border-right: 115px solid transparent; border-top: 74px solid #f2e4c8; transform-origin: top center; transition: transform .9s var(--ease-spring); z-index: 2; }
        .envelope.open .flap { transform: rotateX(180deg); }
        .envelope.open .seal { opacity: 0; transform: translate(-50%, -50%) scale(.4); }
        .envelope-hint { margin-top: 28px; color: var(--color-gold-dark); font-size: .8rem; letter-spacing: 2px; text-transform: uppercase; font-weight: 500; }

        @media (max-width: 380px) {
            .wrap { padding: 48px 20px 80px; }
            #countdown { gap: 8px; }
            #countdown div { min-width: 62px; padding: 12px 8px; }
        }
    </style>
</head>
<body>
<script>
    if ('scrollRestoration' in history) { history.scrollRestoration = 'manual'; }
    window.scrollTo(0, 0);
    window.addEventListener('load', function () { window.scrollTo(0, 0); });
    window.addEventListener('pageshow', function () { window.scrollTo(0, 0); });
</script>

<div id="envelope-overlay">
    <button type="button" class="envelope" id="envelope" aria-label="Abrir invitación">
        <span class="body"></span>
        <span class="flap"></span>
        <span class="seal">{{ $wedding->initials() }}</span>
    </button>
    <p class="envelope-hint">Toca el sobre para abrir</p>
</div>

<div class="wrap">
    <div class="hero reveal">
        <div class="monogram">{{ $wedding->initials() }}</div>
        <p class="eyebrow">Nos casamos</p>
        <h1>{{ $wedding->groom_name }} &amp; {{ $wedding->bride_name }}</h1>
        <div class="ornament"><span class="line"></span><span class="dot"></span><span class="line flip"></span></div>
        <div class="guest-name">Estimado/a <strong>{{ $guest->name }}</strong>, con mucho cariño te invitamos a celebrar con nosotros.</div>
    </div>

    @if ($wedding->loveStory())
        <div class="section reveal">
            <h2>Nuestra historia</h2>
            <p>{{ $wedding->loveStory() }}</p>
        </div>
    @endif

    @if ($wedding->wedding_date)
        <div class="section reveal">
            <h2>Cuenta regresiva</h2>
            <div id="countdown"></div>
        </div>
    @endif

    @if ($wedding->venue_name || $wedding->venue_address || $wedding->dressCode())
        <div class="section reveal">
            <h2>Lugar</h2>
            <p>{{ $wedding->venue_name }}<br>{{ $wedding->venue_address }}</p>
            @if ($wedding->dressCode())
                <span class="dress-code">Vestimenta: {{ $wedding->dressCode() }}</span>
            @endif
            @if ($wedding->mapsEmbedUrl())
                <iframe class="map-frame" src="{{ $wedding->mapsEmbedUrl() }}" loading="lazy" title="Mapa de ubicación de la boda"></iframe>
                <div class="map-links">
                    <a href="{{ $wedding->mapsUrl() }}" target="_blank" rel="noopener">Ver en Google Maps</a>
                    <a href="{{ $wedding->wazeUrl() }}" target="_blank" rel="noopener">Abrir en Waze</a>
                </div>
            @endif
        </div>
    @endif

    @if (count($wedding->itinerary()))
        <div class="section reveal">
            <h2>Itinerario</h2>
            <ul class="itinerary">
                @foreach ($wedding->itinerary() as $item)
                    <li>
                        <span class="time">{{ $item['time'] }}</span>
                        <span class="title">{{ $item['title'] }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (count($wedding->gallery()))
        <div class="section reveal">
            <h2>Galería</h2>
            <div class="gallery">
                @foreach ($wedding->gallery() as $path)
                    <img src="{{ asset('storage/'.$path) }}" alt="Foto de {{ $wedding->groom_name }} y {{ $wedding->bride_name }}" loading="lazy">
                @endforeach
            </div>
        </div>
    @endif

    @if ($wedding->giftBankDetails() || $wedding->giftRegistryUrl())
        <div class="section reveal">
            <h2>Mesa de regalos</h2>
            @if ($wedding->giftBankDetails())
                <div class="gift-box">{{ $wedding->giftBankDetails() }}</div>
            @endif
            @if ($wedding->giftRegistryUrl())
                <a href="{{ $wedding->giftRegistryUrl() }}" target="_blank" rel="noopener" class="gift-btn">Ver lista de regalos</a>
            @endif
        </div>
    @endif

    <div class="section reveal">
        <h2>Confirma tu asistencia</h2>

        @if (session('status'))
            <div class="status ok">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"><circle cx="10" cy="10" r="9" stroke="currentColor" stroke-width="1.5"/><path d="M6.5 10.2l2.3 2.3 4.7-5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        @if ($guest->rsvp_status !== 'pending')
            <div class="rsvp-done">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none"><circle cx="16" cy="16" r="14.5" stroke="currentColor" stroke-width="1.5"/><path d="M10.5 16.3l3.6 3.6 7.4-8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                @if ($guest->rsvp_status === 'confirmed')
                    Ya confirmaste tu asistencia con {{ $guest->passes_confirmed }} pase(s). ¡Gracias!
                @else
                    Registramos que no podrás acompañarnos. ¡Gracias por avisar!
                @endif
            </div>
        @else
            <form class="rsvp" method="POST" action="{{ route('invitation.rsvp', $guest) }}">
                @csrf
                <div class="field">
                    <span class="text-label">¿Asistirás?</span>
                    <div class="radio-group">
                        <label class="radio-pill"><input type="radio" name="attending" value="yes" required><span>Sí, asistiré</span></label>
                        <label class="radio-pill"><input type="radio" name="attending" value="no" required><span>No podré asistir</span></label>
                    </div>
                </div>

                <div class="field">
                    <label class="text-label" for="passes_confirmed">Número de asistentes (máximo {{ $guest->passes_allocated }})</label>
                    <input id="passes_confirmed" type="number" name="passes_confirmed" min="1" max="{{ $guest->passes_allocated }}" value="{{ $guest->passes_allocated }}">
                </div>

                <div class="field">
                    <label class="text-label" for="dietary_notes">Restricciones alimenticias (opcional)</label>
                    <textarea id="dietary_notes" name="dietary_notes" rows="2"></textarea>
                </div>

                <button type="submit">Enviar confirmación</button>
            </form>
        @endif
    </div>
</div>

@if ($wedding->musicPath())
    <audio id="bg-music" loop src="{{ asset('storage/'.$wedding->musicPath()) }}"></audio>
    <button id="music-toggle" type="button" aria-label="Reproducir música" aria-pressed="false">
        <svg class="icon-play" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
        <svg class="icon-pause" viewBox="0 0 24 24" fill="currentColor" style="display:none"><path d="M7 5h4v14H7zM13 5h4v14h-4z"/></svg>
    </button>
    <script>
        (function () {
            var audio = document.getElementById('bg-music');
            var toggle = document.getElementById('music-toggle');
            var iconPlay = toggle.querySelector('.icon-play');
            var iconPause = toggle.querySelector('.icon-pause');
            function setPlaying(playing) {
                iconPlay.style.display = playing ? 'none' : '';
                iconPause.style.display = playing ? '' : 'none';
                toggle.setAttribute('aria-pressed', playing ? 'true' : 'false');
                toggle.setAttribute('aria-label', playing ? 'Pausar música' : 'Reproducir música');
            }
            toggle.addEventListener('click', function () {
                if (audio.paused) { audio.play().then(function () { setPlaying(true); }).catch(function () {}); }
                else { audio.pause(); setPlaying(false); }
            });
            window.__setMusicPlaying = setPlaying;
        })();
    </script>
@endif

<script>
    (function () {
        var overlay = document.getElementById('envelope-overlay');
        var envelope = document.getElementById('envelope');
        function openEnvelope() {
            envelope.classList.add('open');
            var audio = document.getElementById('bg-music');
            if (audio) {
                audio.play().then(function () { if (window.__setMusicPlaying) window.__setMusicPlaying(true); }).catch(function () {});
            }
            setTimeout(function () {
                overlay.classList.add('hidden');
                document.body.classList.add('revealed');
            }, 850);
        }
        envelope.addEventListener('click', openEnvelope);
    })();

    // Scroll reveal (with a sweep fallback so fast/instant scroll jumps never leave a section stuck invisible)
    (function () {
        var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        var targets = Array.prototype.slice.call(document.querySelectorAll('.reveal'));
        if (reduce || !('IntersectionObserver' in window)) {
            targets.forEach(function (el) { el.classList.add('is-visible'); });
            return;
        }
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    io.unobserve(entry.target);
                }
            });
        }, { threshold: 0, rootMargin: '0px 0px -10% 0px' });
        targets.forEach(function (el) { io.observe(el); });

        // Reveal anything at/above the viewport bottom edge once scrolling settles, so a
        // large instant jump (End key, scrollbar drag) never leaves a section stuck invisible.
        function sweep() {
            var vh = window.innerHeight;
            targets.forEach(function (el) {
                if (el.classList.contains('is-visible')) return;
                if (el.getBoundingClientRect().top < vh) {
                    el.classList.add('is-visible');
                    io.unobserve(el);
                }
            });
        }
        var settleTimer = null;
        window.addEventListener('scroll', function () {
            clearTimeout(settleTimer);
            settleTimer = setTimeout(sweep, 150);
        }, { passive: true });
        setTimeout(sweep, 800);
    })();
</script>

@if ($wedding->wedding_date)
<script>
    (function () {
        var target = new Date('{{ $wedding->wedding_date->format('Y-m-d') }}T00:00:00').getTime();
        var el = document.getElementById('countdown');
        function tick() {
            var diff = Math.max(0, target - Date.now());
            var d = Math.floor(diff / 86400000);
            var h = Math.floor((diff % 86400000) / 3600000);
            var m = Math.floor((diff % 3600000) / 60000);
            el.innerHTML =
                '<div><span>' + d + '</span><small>días</small></div>' +
                '<div><span>' + h + '</span><small>horas</small></div>' +
                '<div><span>' + m + '</span><small>min</small></div>';
        }
        tick();
        setInterval(tick, 30000);
    })();
</script>
@endif
</body>
</html>
