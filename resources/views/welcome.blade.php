<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Convites — Invitaciones de boda digitales</title>
    <meta name="description" content="Invitaciones de boda digitales a medida: cuenta regresiva, confirmación de asistencia con control de pases, galería, música y mapa. Diseñadas una por una.">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=cormorant-garamond:500,600,700|great-vibes|inter:300,400,500,600" rel="stylesheet" />
    <style>
        :root {
            --color-bg: #12151c;
            --color-surface: #1b212c;
            --color-ink: #ede7d9;
            --color-ink-soft: #a7adbb;
            --color-gold: #cba45c;
            --color-gold-light: #e3c589;
            --color-gold-wash: rgba(203, 164, 92, .14);
            --color-border: #2a3140;
            --color-paper: #f7f1e4;
            --color-paper-ink: #3a3222;
            --shadow-sm: 0 2px 12px rgba(0, 0, 0, .35);
            --shadow-md: 0 16px 40px rgba(0, 0, 0, .5);
            --shadow-lg: 0 30px 70px rgba(0, 0, 0, .55);
            --radius-sm: 8px;
            --radius-md: 16px;
            --radius-lg: 24px;
            --ease-out: cubic-bezier(.16, .8, .24, 1);
            --ease-spring: cubic-bezier(.34, 1.56, .64, 1);
        }
        * { box-sizing: border-box; }
        html { -webkit-text-size-adjust: 100%; scroll-behavior: smooth; }
        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(120% 60% at 50% -10%, #1a2029 0%, var(--color-bg) 55%);
            color: var(--color-ink);
            margin: 0;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }
        h1, h2, h3 { font-family: 'Cormorant Garamond', serif; font-weight: 700; margin: 0; }
        a { color: inherit; }
        button { font-family: inherit; }
        :focus-visible { outline: 2px solid var(--color-gold); outline-offset: 3px; border-radius: 4px; }
        .script { font-family: 'Great Vibes', cursive; font-weight: 400; color: var(--color-gold-light); }

        .shell { max-width: 1120px; margin: 0 auto; padding: 0 28px; }

        .ornament { display: flex; align-items: center; gap: 14px; }
        .ornament .line { height: 1px; width: 40px; background: linear-gradient(90deg, transparent, var(--color-gold)); opacity: .55; }
        .ornament .dot { width: 5px; height: 5px; background: var(--color-gold); transform: rotate(45deg); flex-shrink: 0; }

        .reveal { opacity: 0; transform: translateY(28px); transition: opacity .8s var(--ease-out), transform .8s var(--ease-out); }
        .reveal.is-visible { opacity: 1; transform: translateY(0); }
        @media (prefers-reduced-motion: reduce) { .reveal { opacity: 1; transform: none; transition: none; } }

        /* Nav */
        nav.top { position: relative; z-index: 5; }
        nav.top .shell { display: flex; align-items: center; justify-content: space-between; padding: 28px 28px; }
        .brand { font-family: 'Cormorant Garamond', serif; font-size: 1.5rem; font-weight: 700; letter-spacing: .5px; }
        .brand span { color: var(--color-gold-light); }
        .nav-cta { font-size: .85rem; padding: 10px 22px; border: 1px solid var(--color-gold); border-radius: 999px; color: var(--color-gold-light); text-decoration: none; font-weight: 500; transition: background .2s var(--ease-out), color .2s var(--ease-out); }
        .nav-cta:hover { background: var(--color-gold); color: #1a1508; }

        /* Hero */
        .hero { padding: 24px 0 80px; display: grid; grid-template-columns: 1.05fr .95fr; gap: 40px; align-items: center; }
        .hero .eyebrow { text-transform: uppercase; letter-spacing: 4px; font-size: .78rem; font-weight: 500; color: var(--color-gold); margin: 0 0 18px; }
        .hero h1 { font-size: clamp(2.4rem, 4.6vw, 3.6rem); line-height: 1.15; letter-spacing: -.5px; }
        .hero p.lede { margin-top: 22px; font-size: 1.1rem; color: var(--color-ink-soft); max-width: 460px; line-height: 1.7; }
        .hero .actions { display: flex; gap: 14px; margin-top: 34px; flex-wrap: wrap; }
        .btn-primary { background: var(--color-gold); color: #1a1508; padding: 15px 28px; border-radius: var(--radius-sm); text-decoration: none; font-weight: 700; font-size: .95rem; transition: transform .2s var(--ease-out), box-shadow .2s var(--ease-out); display: inline-block; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }
        .btn-ghost { padding: 15px 24px; border-radius: var(--radius-sm); text-decoration: none; font-weight: 600; font-size: .95rem; color: var(--color-ink); border: 1px solid var(--color-border); transition: border-color .2s var(--ease-out); }
        .btn-ghost:hover { border-color: var(--color-gold); }
        .hero .trust { margin-top: 30px; font-size: .82rem; color: var(--color-ink-soft); display: flex; align-items: center; gap: 10px; }
        .hero .trust svg { color: var(--color-gold); flex-shrink: 0; }

        /* Envelope mockup */
        .mock { display: flex; align-items: center; justify-content: center; position: relative; min-height: 420px; }
        .mock-hint { position: absolute; bottom: -6px; left: 50%; transform: translateX(-50%); font-size: .72rem; letter-spacing: 2px; text-transform: uppercase; color: var(--color-gold); white-space: nowrap; opacity: .85; }
        .envelope-demo { appearance: none; background: none; border: 0; padding: 0; position: relative; width: 260px; height: 176px; cursor: pointer; transition: transform .3s var(--ease-out); filter: drop-shadow(0 25px 50px rgba(0,0,0,.5)); }
        .envelope-demo:hover { transform: translateY(-4px) rotate(-1deg); }
        .envelope-demo .body { position: absolute; inset: 0; top: 24px; background: var(--color-surface); border-radius: 6px; border: 1px solid var(--color-border); }
        .envelope-demo .seal { position: absolute; top: 72px; left: 50%; transform: translate(-50%, -50%); width: 58px; height: 58px; border-radius: 50%; background: var(--color-gold); color: #1a1508; display: flex; align-items: center; justify-content: center; font-family: 'Cormorant Garamond', serif; font-size: 1.1rem; font-weight: 700; z-index: 3; box-shadow: 0 4px 16px rgba(203,164,92,.35); transition: opacity .3s ease, transform .3s ease; }
        .envelope-demo .flap { position: absolute; top: 24px; left: 0; width: 0; height: 0; border-left: 130px solid transparent; border-right: 130px solid transparent; border-top: 82px solid #242b38; transform-origin: top center; transition: transform .9s var(--ease-spring); z-index: 2; }
        .envelope-demo.open .flap { transform: rotateX(180deg); }
        .envelope-demo.open .seal { opacity: 0; transform: translate(-50%, -50%) scale(.4); }

        .card-reveal { position: absolute; width: 280px; padding: 34px 24px; background: var(--color-paper); color: var(--color-paper-ink); border-radius: 4px; box-shadow: var(--shadow-lg); text-align: center; opacity: 0; transform: translateY(14px) scale(.96); transition: opacity .5s var(--ease-out) .15s, transform .5s var(--ease-out) .15s; pointer-events: none; }
        .card-reveal.visible { opacity: 1; transform: translateY(0) scale(1); pointer-events: auto; }
        .card-reveal .eyebrow-mini { text-transform: uppercase; letter-spacing: 3px; font-size: .65rem; color: #8a7a4f; font-weight: 600; }
        .card-reveal .names { font-family: 'Great Vibes', cursive; font-size: 2.1rem; margin-top: 10px; color: #3a3222; line-height: 1; }
        .card-reveal .date { margin-top: 12px; font-size: .8rem; letter-spacing: 1px; color: #6b6248; }
        .card-reveal .rule { width: 30px; height: 1px; background: #b79a5f; margin: 14px auto; }

        /* Preview strip section */
        .preview-section { padding: 60px 0 90px; }
        .preview-frame { border-radius: var(--radius-lg); border: 1px solid var(--color-border); background: var(--color-surface); padding: 10px; box-shadow: var(--shadow-lg); }
        .preview-frame .titlebar { display: flex; gap: 6px; padding: 10px 14px; }
        .preview-frame .titlebar span { width: 9px; height: 9px; border-radius: 50%; background: var(--color-border); }
        .preview-body { border-radius: var(--radius-md); background: radial-gradient(120% 100% at 50% 0%, #1a2029 0%, #0e1117 60%); padding: 56px 24px; text-align: center; }
        .preview-body .names { font-family: 'Great Vibes', cursive; font-size: 2.6rem; color: var(--color-gold-light); }
        .preview-body .eyebrow-mini { text-transform: uppercase; letter-spacing: 3px; font-size: .7rem; color: var(--color-gold); font-weight: 500; }
        .preview-countdown { display: flex; gap: 12px; justify-content: center; margin-top: 30px; }
        .preview-countdown div { background: var(--color-surface); border: 1px solid var(--color-border); border-radius: var(--radius-sm); padding: 14px 18px; min-width: 66px; }
        .preview-countdown span { display: block; font-family: 'Cormorant Garamond', serif; font-size: 1.5rem; font-weight: 700; color: var(--color-gold-light); }
        .preview-countdown small { display: block; margin-top: 2px; text-transform: uppercase; font-size: .62rem; letter-spacing: 1px; color: var(--color-ink-soft); }
        .preview-rsvp { margin-top: 30px; display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: var(--color-gold-wash); border: 1px solid var(--color-gold); border-radius: 999px; font-size: .82rem; color: var(--color-gold-light); font-weight: 600; }

        /* Section shell */
        .section { padding: 90px 0; border-top: 1px solid var(--color-border); }
        .section .heading { max-width: 560px; }
        .section .eyebrow { text-transform: uppercase; letter-spacing: 3px; font-size: .75rem; font-weight: 500; color: var(--color-gold); margin: 0 0 14px; }
        .section h2 { font-size: clamp(1.9rem, 3vw, 2.5rem); line-height: 1.25; }
        .section .heading p { margin-top: 16px; color: var(--color-ink-soft); font-size: 1.02rem; line-height: 1.75; max-width: 480px; }

        /* Process steps */
        .steps { margin-top: 56px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 0; }
        .step { position: relative; padding: 0 28px 0 0; border-right: 1px solid var(--color-border); }
        .step:last-child { border-right: 0; padding-right: 0; }
        .step:not(:first-child) { padding-left: 28px; }
        .step .num { font-family: 'Cormorant Garamond', serif; font-size: 2.6rem; font-weight: 600; color: var(--color-gold-light); line-height: 1; }
        .step h3 { font-size: 1.2rem; margin-top: 14px; font-weight: 700; color: var(--color-ink); }
        .step p { margin-top: 10px; font-size: .95rem; color: var(--color-ink-soft); line-height: 1.7; }

        /* Feature list */
        .features { margin-top: 56px; display: grid; grid-template-columns: 1fr 1fr; column-gap: 56px; }
        .feature-row { display: flex; justify-content: space-between; align-items: baseline; padding: 20px 0; border-bottom: 1px solid var(--color-border); gap: 20px; }
        .feature-row .name { font-family: 'Cormorant Garamond', serif; font-size: 1.25rem; font-weight: 600; color: var(--color-ink); white-space: nowrap; }
        .feature-row .desc { font-size: .9rem; color: var(--color-ink-soft); text-align: right; }

        /* Final CTA */
        .cta-final { padding: 100px 0; text-align: center; border-top: 1px solid var(--color-border); }
        .cta-final .ornament { justify-content: center; margin: 0 auto 22px; }
        .cta-final h2 { font-size: clamp(2rem, 4vw, 2.9rem); max-width: 640px; margin: 0 auto; }
        .cta-final p { margin-top: 18px; color: var(--color-ink-soft); max-width: 460px; margin-left: auto; margin-right: auto; }
        .cta-final .actions { margin-top: 32px; display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }

        footer { padding: 36px 0 48px; border-top: 1px solid var(--color-border); }
        footer .shell { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; }
        footer .brand { font-size: 1.1rem; }
        footer .meta { font-size: .82rem; color: var(--color-ink-soft); }

        @media (max-width: 880px) {
            .hero { grid-template-columns: 1fr; padding-top: 8px; }
            .mock { order: -1; min-height: 300px; }
            .steps { grid-template-columns: 1fr; row-gap: 40px; }
            .step { border-right: 0 !important; padding: 0 !important; }
            .features { grid-template-columns: 1fr; column-gap: 0; }
            nav.top .shell { padding: 22px 20px; }
        }
    </style>
</head>
<body>

<nav class="top">
    <div class="shell">
        <div class="brand">Con<span>vites</span></div>
        <a href="#contacto" class="nav-cta">Quiero la mía</a>
    </div>
</nav>

<header class="hero shell">
    <div class="hero-copy">
        <p class="eyebrow">Invitaciones de boda digitales</p>
        <h1>La primera impresión de tu boda, antes de que empiece.</h1>
        <p class="lede">Diseñamos la invitación de tu boda como una pieza a medida: se abre como un sobre real, cuenta los días, reúne las confirmaciones y guarda cada detalle en un solo link que envías por WhatsApp.</p>
        <div class="actions">
            <a href="#contacto" class="btn-primary">Cotizar la mía</a>
            <a href="#como-funciona" class="btn-ghost">Ver cómo funciona</a>
        </div>
        <div class="trust">
            <svg width="16" height="16" viewBox="0 0 20 20" fill="none"><circle cx="10" cy="10" r="9" stroke="currentColor" stroke-width="1.4"/><path d="M6.5 10.2l2.3 2.3 4.7-5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Confirmaciones con control de pases y exportación a Excel incluidos
        </div>
    </div>

    <div class="mock">
        <button type="button" class="envelope-demo" id="envelopeDemo" aria-label="Ver invitación de muestra">
            <span class="body"></span>
            <span class="flap"></span>
            <span class="seal">C&V</span>
        </button>
        <div class="card-reveal" id="cardReveal">
            <p class="eyebrow-mini">Nos casamos</p>
            <p class="names">Camila &amp; Valentín</p>
            <div class="rule"></div>
            <p class="date">14 de noviembre, 2026 — Santa Cruz</p>
        </div>
        <p class="mock-hint">Toca el sobre</p>
    </div>
</header>

<section class="preview-section shell reveal">
    <div class="preview-frame">
        <div class="titlebar"><span></span><span></span><span></span></div>
        <div class="preview-body">
            <p class="eyebrow-mini">Nos casamos</p>
            <p class="names">Camila &amp; Valentín</p>
            <div class="preview-countdown">
                <div><span>42</span><small>días</small></div>
                <div><span>08</span><small>horas</small></div>
                <div><span>17</span><small>min</small></div>
            </div>
            <div class="preview-rsvp">✓ Ya confirmaron 86 de 120 invitados</div>
        </div>
    </div>
</section>

<section class="section shell reveal" id="como-funciona">
    <div class="heading">
        <p class="eyebrow">Cómo funciona</p>
        <h2>De la historia al "sí, asistiré".</h2>
    </div>
    <div class="steps">
        <div class="step">
            <div class="num">01</div>
            <h3>Nos cuentan su historia</h3>
            <p>Nombres, fecha, lugar, itinerario y fotos. Nos dicen qué tono quieren: clásico, romántico, minimalista.</p>
        </div>
        <div class="step">
            <div class="num">02</div>
            <h3>Diseñamos la invitación</h3>
            <p>Armamos la página con su historia, mapa, galería, música y el sobre animado con su sello.</p>
        </div>
        <div class="step">
            <div class="num">03</div>
            <h3>Comparten el link y siguen las confirmaciones</h3>
            <p>Cada invitado abre su propio link, confirma cuántos pases usa, y ustedes ven todo en un panel en vivo.</p>
        </div>
    </div>
</section>

<section class="section shell reveal">
    <div class="heading">
        <p class="eyebrow">Todo incluido</p>
        <h2>Pensada para no perseguir a nadie por WhatsApp.</h2>
        <p>Cada invitación lleva estas piezas listas, no como extras.</p>
    </div>
    <div class="features">
        <div class="feature-row"><span class="name">Confirmación por invitado</span><span class="desc">Link único con límite de pases por familia</span></div>
        <div class="feature-row"><span class="name">Exportar a Excel</span><span class="desc">Lista final de invitados y confirmados con un clic</span></div>
        <div class="feature-row"><span class="name">Cuenta regresiva</span><span class="desc">En vivo, hasta el día de la boda</span></div>
        <div class="feature-row"><span class="name">Mapa e itinerario</span><span class="desc">Google Maps, Waze y el orden del día</span></div>
        <div class="feature-row"><span class="name">Galería y música</span><span class="desc">Fotos de la pareja y una canción de fondo</span></div>
        <div class="feature-row"><span class="name">Mesa de regalos</span><span class="desc">Datos de cuenta o link a la lista de regalos</span></div>
    </div>
</section>

<section class="cta-final shell reveal" id="contacto">
    <div class="ornament"><span class="line"></span><span class="dot"></span><span class="line" style="background: linear-gradient(90deg, var(--color-gold), transparent);"></span></div>
    <h2>Empecemos con la invitación de ustedes.</h2>
    <p>Cuéntanos la fecha y el nombre de los dos. El resto lo armamos con ustedes en unos días.</p>
    <div class="actions">
        <a href="#" class="btn-primary">Escribir por WhatsApp</a>
    </div>
</section>

<footer>
    <div class="shell">
        <div class="brand">Con<span style="color: var(--color-gold-light)">vites</span></div>
        <div class="meta">Invitaciones de boda digitales — hechas en Santa Cruz, Bolivia</div>
    </div>
</footer>

<script>
    (function () {
        var btn = document.getElementById('envelopeDemo');
        var card = document.getElementById('cardReveal');
        var opened = false;
        btn.addEventListener('click', function () {
            opened = !opened;
            btn.classList.toggle('open', opened);
            if (opened) { setTimeout(function () { card.classList.add('visible'); }, 500); }
            else { card.classList.remove('visible'); }
        });
    })();

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
    })();
</script>
</body>
</html>
