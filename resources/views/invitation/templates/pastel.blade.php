<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $wedding->groom_name }} &amp; {{ $wedding->bride_name }}</title>
    <meta property="og:title" content="Boda de {{ $wedding->groom_name }} y {{ $wedding->bride_name }}">
    <meta property="og:description" content="{{ $guest->name }}, estas invitado/a a nuestra boda.">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=cormorant:400,500,600,700|great-vibes|jost:300,400,500,600" rel="stylesheet" />
    <style>
        :root {
            --cream: #fbf6f1;
            --surface: #fffdfb;
            --blush: #f7e9e6;
            --rose: #b76e79;
            --rose-deep: #9d5461;
            --rose-soft: #e7c3c6;
            --sage: #8ca38b;
            --sage-deep: #6f8a6e;
            --sage-soft: #d6e0d2;
            --peach: #f1cba9;
            --lavender: #cfc3e6;
            --gold-rose: #c39c94;
            --ink: #5a4a50;
            --ink-strong: #47373d;
            --ink-soft: #8a7a80;
            --border: #ece0d9;
            --shadow-sm: 0 3px 14px rgba(120, 80, 90, .07);
            --shadow-md: 0 16px 40px rgba(120, 80, 90, .14);
            --radius-sm: 10px;
            --radius-md: 18px;
            --radius-lg: 28px;
            --ease-out: cubic-bezier(.16, .8, .24, 1);
            --ease-spring: cubic-bezier(.34, 1.56, .64, 1);
        }
        * { box-sizing: border-box; }
        html { -webkit-text-size-adjust: 100%; }
        body {
            font-family: 'Jost', sans-serif;
            color: var(--ink);
            margin: 0;
            overflow-x: hidden;
            line-height: 1.7;
            font-weight: 300;
            -webkit-font-smoothing: antialiased;
            background:
                radial-gradient(38% 30% at 12% 8%, rgba(207, 195, 230, .35) 0%, transparent 60%),
                radial-gradient(40% 32% at 88% 4%, rgba(241, 203, 169, .35) 0%, transparent 60%),
                radial-gradient(45% 35% at 90% 55%, rgba(214, 224, 210, .4) 0%, transparent 60%),
                radial-gradient(45% 35% at 6% 60%, rgba(231, 195, 198, .38) 0%, transparent 60%),
                var(--cream);
            background-attachment: fixed;
        }
        body:not(.revealed) { overflow: hidden; height: 100vh; }
        h1, h2 { font-family: 'Cormorant', serif; font-weight: 600; margin: 0; color: var(--ink-strong); }
        .script { font-family: 'Great Vibes', cursive; font-weight: 400; }
        a { color: inherit; }
        button { font-family: inherit; }

        :focus-visible { outline: 2px solid var(--rose-deep); outline-offset: 3px; border-radius: 4px; }

        .wrap { max-width: 600px; margin: 0 auto; padding: 64px 26px 100px; text-align: center; }

        /* Botanical divider */
        .botanical { display: block; margin: 26px auto; width: 132px; height: auto; color: var(--sage); }
        .botanical.small { width: 92px; margin: 18px auto; }

        /* Scroll reveal */
        .reveal { opacity: 0; transform: translateY(30px); transition: opacity .9s var(--ease-out), transform .9s var(--ease-out); }
        .reveal.is-visible { opacity: 1; transform: translateY(0); }
        @media (prefers-reduced-motion: reduce) { .reveal { opacity: 1; transform: none; transition: none; } }

        /* Hero */
        .hero { position: relative; }
        .monogram { width: 92px; height: 92px; border-radius: 50%; border: 1.5px solid var(--gold-rose); display: flex; align-items: center; justify-content: center; margin: 0 auto 18px; background: var(--surface); box-shadow: var(--shadow-sm); font-family: 'Cormorant', serif; font-weight: 600; font-size: 1.3rem; letter-spacing: 1px; color: var(--rose-deep); white-space: nowrap; }
        .hero .eyebrow { letter-spacing: 5px; text-transform: uppercase; font-size: .72rem; font-weight: 500; color: var(--sage-deep); margin: 0; }
        .hero .names { font-family: 'Great Vibes', cursive; font-size: clamp(3.4rem, 15vw, 5rem); line-height: 1.05; color: var(--rose); margin: 8px 0 4px; }
        .hero .date-chip { display: inline-block; margin-top: 10px; padding: 7px 20px; border: 1px solid var(--rose-soft); border-radius: 999px; background: var(--surface); font-size: .82rem; letter-spacing: 2px; text-transform: uppercase; color: var(--rose-deep); }
        .guest-name { font-size: 1.05rem; color: var(--ink); margin: 26px auto 0; max-width: 400px; }
        .guest-name strong { color: var(--rose-deep); font-weight: 500; }

        .section { margin-top: 26px; padding-top: 30px; }
        .section h2 { font-size: 1.9rem; letter-spacing: .3px; }
        .section .sub { letter-spacing: 4px; text-transform: uppercase; font-size: .7rem; color: var(--sage-deep); font-weight: 500; margin: 0 0 4px; }
        .section p { line-height: 1.8; color: var(--ink); font-size: 1rem; }
        .section > p { max-width: 460px; margin-left: auto; margin-right: auto; }

        /* Countdown */
        #countdown { display: grid; grid-auto-flow: column; gap: 14px; justify-content: center; margin-top: 20px; }
        #countdown div { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 18px 14px; min-width: 74px; box-shadow: var(--shadow-sm); }
        #countdown span { display: block; font-family: 'Cormorant', serif; font-weight: 700; font-size: 2rem; font-variant-numeric: tabular-nums; color: var(--rose-deep); line-height: 1; }
        #countdown small { display: block; margin-top: 6px; letter-spacing: 1.5px; text-transform: uppercase; font-size: .64rem; color: var(--ink-soft); }

        /* Dress code */
        .dress-code { display: inline-flex; align-items: center; gap: 8px; margin-top: 16px; padding: 9px 20px; background: var(--sage-soft); border-radius: 999px; font-size: .85rem; color: var(--sage-deep); font-weight: 500; }

        /* Map */
        .map-frame { width: 100%; height: 240px; border: 0; border-radius: var(--radius-md); margin-top: 22px; box-shadow: var(--shadow-sm); display: block; }
        .map-links { margin-top: 16px; display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
        .map-links a { font-size: .85rem; padding: 12px 22px; border-radius: 999px; text-decoration: none; font-weight: 500; transition: transform .2s var(--ease-out), box-shadow .2s var(--ease-out); display: inline-block; }
        .map-links a.primary { background: var(--rose-deep); color: #fff; }
        .map-links a.secondary { background: var(--surface); color: var(--rose-deep); border: 1px solid var(--rose-soft); }
        .map-links a:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }
        .map-links a:active { transform: translateY(0); }

        /* Itinerary */
        .itinerary { list-style: none; padding: 0; margin: 26px auto 0; text-align: left; max-width: 330px; position: relative; }
        .itinerary::before { content: ''; position: absolute; left: 58px; top: 10px; bottom: 10px; width: 2px; background: linear-gradient(var(--rose-soft), var(--sage-soft)); border-radius: 2px; }
        .itinerary li { position: relative; padding: 0 0 30px 90px; }
        .itinerary li:last-child { padding-bottom: 0; }
        .itinerary .time { position: absolute; left: 0; top: 0; width: 58px; text-align: right; padding-right: 20px; font-weight: 600; font-size: .9rem; color: var(--rose-deep); font-variant-numeric: tabular-nums; }
        .itinerary .time::after { content: ''; position: absolute; right: -6px; top: 3px; width: 11px; height: 11px; border-radius: 50%; background: var(--surface); border: 2px solid var(--rose); box-shadow: 0 0 0 4px var(--cream); }
        .itinerary .title { font-size: 1rem; color: var(--ink-strong); font-weight: 400; }

        /* Gallery */
        .gallery { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-top: 22px; }
        .gallery img { width: 100%; height: 130px; object-fit: cover; border-radius: var(--radius-sm); box-shadow: var(--shadow-sm); transition: transform .35s var(--ease-out); }
        .gallery img:hover { transform: scale(1.04); }

        /* Gift */
        .gift-box { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 22px; margin-top: 20px; text-align: left; white-space: pre-wrap; font-size: .92rem; color: var(--ink); box-shadow: var(--shadow-sm); max-width: 420px; margin-left: auto; margin-right: auto; }
        .gift-btn { display: inline-block; margin-top: 16px; padding: 13px 30px; background: var(--rose-deep); color: #fff; border-radius: 999px; text-decoration: none; font-size: .92rem; font-weight: 500; transition: transform .2s var(--ease-out), box-shadow .2s var(--ease-out); }
        .gift-btn:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }

        /* RSVP card */
        .rsvp-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 32px 26px; margin-top: 26px; box-shadow: var(--shadow-md); }
        form.rsvp { text-align: left; max-width: 380px; margin: 0 auto; }
        .field { margin-top: 18px; }
        .field .text-label { display: block; font-size: .82rem; font-weight: 500; color: var(--ink); margin-bottom: 7px; letter-spacing: .3px; }
        .radio-group { display: flex; gap: 10px; }
        .radio-pill { flex: 1; position: relative; }
        .radio-pill input { position: absolute; opacity: 0; width: 100%; height: 100%; margin: 0; cursor: pointer; }
        .radio-pill span { display: flex; align-items: center; justify-content: center; min-height: 50px; padding: 10px 12px; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-size: .92rem; text-align: center; color: var(--ink); background: var(--cream); transition: border-color .2s var(--ease-out), background .2s var(--ease-out), color .2s var(--ease-out); }
        .radio-pill:has(input:checked) span { border-color: var(--rose); background: var(--blush); color: var(--rose-deep); font-weight: 500; }
        .radio-pill:has(input:focus-visible) span { outline: 2px solid var(--rose-deep); outline-offset: 2px; }
        form.rsvp input[type=number], form.rsvp textarea { width: 100%; padding: 13px 14px; margin-top: 4px; border: 1.5px solid var(--border); border-radius: var(--radius-sm); box-sizing: border-box; font-family: inherit; font-size: .95rem; background: var(--cream); color: var(--ink); transition: border-color .2s var(--ease-out); }
        form.rsvp input[type=number]:focus, form.rsvp textarea:focus { border-color: var(--rose); outline: none; }
        form.rsvp button[type=submit] { margin-top: 26px; width: 100%; background: var(--rose-deep); color: #fff; padding: 16px; border: 0; border-radius: 999px; font-size: 1rem; font-weight: 500; letter-spacing: .5px; cursor: pointer; transition: transform .2s var(--ease-out), box-shadow .2s var(--ease-out), background .2s var(--ease-out); }
        form.rsvp button[type=submit]:hover { background: var(--rose); transform: translateY(-2px); box-shadow: var(--shadow-md); }
        form.rsvp button[type=submit]:active { transform: translateY(0); }

        .status { margin: 0 0 18px; padding: 14px 16px; border-radius: var(--radius-sm); display: flex; align-items: center; gap: 10px; font-size: .92rem; background: var(--sage-soft); color: var(--sage-deep); }
        .status svg { flex-shrink: 0; }
        .rsvp-done { text-align: center; font-size: 1.05rem; color: var(--ink); }
        .rsvp-done svg { display: block; margin: 0 auto 14px; color: var(--rose); }

        /* Footer flourish */
        .footer { margin-top: 40px; }
        .footer .thanks { font-family: 'Great Vibes', cursive; font-size: 2rem; color: var(--rose); }

        /* Music toggle */
        #music-toggle { position: fixed; bottom: 22px; right: 22px; width: 52px; height: 52px; border-radius: 50%; background: var(--rose-deep); color: #fff; border: 0; cursor: pointer; box-shadow: var(--shadow-md); z-index: 10; display: flex; align-items: center; justify-content: center; transition: transform .2s var(--ease-out); }
        #music-toggle:hover { transform: scale(1.07); }
        #music-toggle:active { transform: scale(.95); }
        #music-toggle svg { width: 18px; height: 18px; }

        /* Envelope overlay */
        #envelope-overlay { position: fixed; inset: 0; background: radial-gradient(120% 100% at 50% 20%, #fdeee9 0%, #f3ddd9 55%, #e9cfcf 100%); display: flex; flex-direction: column; align-items: center; justify-content: center; z-index: 9999; transition: opacity .6s var(--ease-out), visibility .6s; }
        #envelope-overlay.hidden { opacity: 0; visibility: hidden; pointer-events: none; }
        .envelope { appearance: none; background: none; border: 0; padding: 0; position: relative; width: 236px; height: 160px; cursor: pointer; transition: transform .25s var(--ease-out); }
        .envelope:hover { transform: translateY(-3px); }
        .envelope:active { transform: scale(.97); }
        .envelope .body { position: absolute; inset: 0; top: 22px; background: #fffaf6; border-radius: 8px; box-shadow: 0 18px 40px rgba(150, 90, 100, .25); }
        .envelope .body::before { content: ''; position: absolute; inset: 0; border: 1px solid var(--rose-soft); border-radius: 8px; }
        .envelope .seal { position: absolute; top: 66px; left: 50%; transform: translate(-50%, -50%); width: 58px; height: 58px; border-radius: 50%; background: var(--rose); color: #fff; display: flex; align-items: center; justify-content: center; font-family: 'Cormorant', serif; font-weight: 600; font-size: 1.05rem; letter-spacing: .5px; z-index: 3; box-shadow: 0 5px 16px rgba(157, 84, 97, .4); transition: opacity .3s ease, transform .3s ease; }
        .envelope .flap { position: absolute; top: 22px; left: 0; width: 0; height: 0; border-left: 118px solid transparent; border-right: 118px solid transparent; border-top: 76px solid #f6e2dd; transform-origin: top center; transition: transform .9s var(--ease-spring); z-index: 2; }
        .envelope.open .flap { transform: rotateX(180deg); }
        .envelope.open .seal { opacity: 0; transform: translate(-50%, -50%) scale(.4); }
        .envelope-hint { margin-top: 30px; color: var(--rose-deep); font-size: .78rem; letter-spacing: 3px; text-transform: uppercase; font-weight: 500; }

        @media (max-width: 380px) {
            .wrap { padding: 48px 18px 84px; }
            #countdown { gap: 9px; }
            #countdown div { min-width: 64px; padding: 14px 8px; }
            #countdown span { font-size: 1.7rem; }
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

@php
    $sprig = '<svg class="botanical" viewBox="0 0 140 34" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M70 4v26" stroke="currentColor" stroke-width="1" stroke-linecap="round"/><path d="M70 24c-8 0-15-3-20-9M70 24c8 0 15-3 20-9M70 16c-6 0-11-2-15-7M70 16c6 0 11-2 15-7M70 9c-4 0-7-1-10-4M70 9c4 0 7-1 10-4" stroke="currentColor" stroke-width="1" stroke-linecap="round"/><circle cx="70" cy="31" r="1.6" fill="currentColor"/><path d="M2 17h44M94 17h44" stroke="currentColor" stroke-width="1" stroke-linecap="round" opacity=".55"/><circle cx="48" cy="17" r="1.3" fill="currentColor" opacity=".7"/><circle cx="92" cy="17" r="1.3" fill="currentColor" opacity=".7"/></svg>';
@endphp

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
        <p class="eyebrow">Nos vamos a casar</p>
        <div class="names">{{ $wedding->groom_name }} <span style="font-size:.6em">&amp;</span> {{ $wedding->bride_name }}</div>
        @if ($wedding->wedding_date)
            <div class="date-chip">{{ $wedding->wedding_date->locale('es')->isoFormat('D [de] MMMM, YYYY') }}</div>
        @endif
        {!! $sprig !!}
        <div class="guest-name">Querido/a <strong>{{ $guest->name }}</strong>, con todo nuestro cariño te invitamos a celebrar este día tan especial.</div>
    </div>

    @if ($wedding->loveStory())
        <div class="section reveal">
            <p class="sub">Nuestra historia</p>
            <h2>Así comenzó todo</h2>
            {!! $sprig !!}
            <p>{{ $wedding->loveStory() }}</p>
        </div>
    @endif

    @if ($wedding->wedding_date)
        <div class="section reveal">
            <p class="sub">Falta poco</p>
            <h2>Cuenta regresiva</h2>
            <div id="countdown"></div>
        </div>
    @endif

    @if ($wedding->venue_name || $wedding->venue_address || $wedding->dressCode())
        <div class="section reveal">
            <p class="sub">Te esperamos</p>
            <h2>El lugar</h2>
            {!! $sprig !!}
            <p>{{ $wedding->venue_name }}<br>{{ $wedding->venue_address }}</p>
            @if ($wedding->dressCode())
                <span class="dress-code">Vestimenta: {{ $wedding->dressCode() }}</span>
            @endif
            @if ($wedding->mapsEmbedUrl())
                <iframe class="map-frame" src="{{ $wedding->mapsEmbedUrl() }}" loading="lazy" title="Mapa de ubicación de la boda"></iframe>
                <div class="map-links">
                    <a class="primary" href="{{ $wedding->mapsUrl() }}" target="_blank" rel="noopener">Ver en Google Maps</a>
                    <a class="secondary" href="{{ $wedding->wazeUrl() }}" target="_blank" rel="noopener">Abrir en Waze</a>
                </div>
            @endif
        </div>
    @endif

    @if (count($wedding->itinerary()))
        <div class="section reveal">
            <p class="sub">El gran día</p>
            <h2>Itinerario</h2>
            {!! $sprig !!}
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
            <p class="sub">Recuerdos</p>
            <h2>Nuestra galería</h2>
            {!! $sprig !!}
            <div class="gallery">
                @foreach ($wedding->gallery() as $path)
                    <img src="{{ asset('storage/'.$path) }}" alt="Foto de {{ $wedding->groom_name }} y {{ $wedding->bride_name }}" loading="lazy">
                @endforeach
            </div>
        </div>
    @endif

    @if ($wedding->giftBankDetails() || $wedding->giftRegistryUrl())
        <div class="section reveal">
            <p class="sub">Tu presencia es nuestro regalo</p>
            <h2>Mesa de regalos</h2>
            {!! $sprig !!}
            @if ($wedding->giftBankDetails())
                <div class="gift-box">{{ $wedding->giftBankDetails() }}</div>
            @endif
            @if ($wedding->giftRegistryUrl())
                <a href="{{ $wedding->giftRegistryUrl() }}" target="_blank" rel="noopener" class="gift-btn">Ver lista de regalos</a>
            @endif
        </div>
    @endif

    <div class="section reveal">
        <p class="sub">No faltes</p>
        <h2>Confirma tu asistencia</h2>
        {!! $sprig !!}

        <div class="rsvp-card">
            @if (session('status'))
                <div class="status">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"><circle cx="10" cy="10" r="9" stroke="currentColor" stroke-width="1.5"/><path d="M6.5 10.2l2.3 2.3 4.7-5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            @if ($guest->rsvp_status !== 'pending')
                <div class="rsvp-done">
                    <svg width="34" height="34" viewBox="0 0 32 32" fill="none"><circle cx="16" cy="16" r="14.5" stroke="currentColor" stroke-width="1.5"/><path d="M10.5 16.3l3.6 3.6 7.4-8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    @if ($guest->rsvp_status === 'confirmed')
                        Ya confirmaste tu asistencia con {{ $guest->passes_confirmed }} pase(s). ¡Gracias, te esperamos!
                    @else
                        Registramos que no podrás acompañarnos. ¡Gracias por avisar!
                    @endif
                </div>
            @else
                <form class="rsvp" method="POST" action="{{ route('invitation.rsvp', $guest) }}">
                    @csrf
                    <div class="field">
                        <span class="text-label">¿Nos acompañarás?</span>
                        <div class="radio-group">
                            <label class="radio-pill"><input type="radio" name="attending" value="yes" required><span>Sí, asistiré</span></label>
                            <label class="radio-pill"><input type="radio" name="attending" value="no" required><span>No podré ir</span></label>
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

    <div class="footer reveal">
        {!! str_replace('botanical', 'botanical small', $sprig) !!}
        <div class="thanks">¡Gracias!</div>
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

    // Scroll reveal (with a debounced sweep so fast/instant scroll jumps never leave a section stuck invisible)
    (function () {
        var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        var targets = Array.prototype.slice.call(document.querySelectorAll('.reveal'));
        if (reduce || !('IntersectionObserver' in window)) {
            targets.forEach(function (el) { el.classList.add('is-visible'); });
            return;
        }
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) { entry.target.classList.add('is-visible'); io.unobserve(entry.target); }
            });
        }, { threshold: 0, rootMargin: '0px 0px -10% 0px' });
        targets.forEach(function (el) { io.observe(el); });

        function sweep() {
            var vh = window.innerHeight;
            targets.forEach(function (el) {
                if (el.classList.contains('is-visible')) return;
                if (el.getBoundingClientRect().top < vh) { el.classList.add('is-visible'); io.unobserve(el); }
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
