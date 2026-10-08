(() => {
  const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* Nav: estado al hacer scroll + menú móvil */
  const nav = document.getElementById('nav');
  const burger = document.getElementById('burger');
  const onScroll = () => nav.classList.toggle('is-scrolled', window.scrollY > 30);
  onScroll();
  window.addEventListener('scroll', onScroll, { passive: true });

  const closeMenu = () => {
    nav.classList.remove('is-open');
    burger.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
  };
  burger.addEventListener('click', () => {
    const open = !nav.classList.contains('is-open');
    nav.classList.toggle('is-open', open);
    burger.setAttribute('aria-expanded', String(open));
    document.body.style.overflow = open ? 'hidden' : '';
  });
  document.querySelectorAll('#navLinks a').forEach(a => a.addEventListener('click', closeMenu));

  /* Enlace activo según sección visible */
  const links = [...document.querySelectorAll('.nav__links a[href^="#"]:not(.nav__mcta)')];
  const sections = [document.getElementById('inicio'), ...links.map(a => document.querySelector(a.getAttribute('href')))].filter(Boolean);
  const spy = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if (!e.isIntersecting) return;
      links.forEach(a => a.classList.toggle('is-active', a.getAttribute('href') === '#' + e.target.id));
    });
  }, { rootMargin: '-45% 0px -50% 0px' });
  sections.forEach(s => spy.observe(s));

  /* Reveal escalonado */
  const groups = new Map();
  document.querySelectorAll('.reveal').forEach(el => {
    const parent = el.parentElement;
    const i = groups.get(parent) || 0;
    el.style.setProperty('--d', `${Math.min(i, 6) * 0.08}s`);
    groups.set(parent, i + 1);
  });
  const io = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if (e.isIntersecting) { e.target.classList.add('is-in'); io.unobserve(e.target); }
    });
  }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
  document.querySelectorAll('.reveal').forEach(el => io.observe(el));

  /* Contadores */
  const count = el => {
    const to = Number(el.dataset.to);
    if (reduce) { el.textContent = to; return; }
    const dur = 1600, t0 = performance.now();
    const tick = t => {
      const p = Math.min((t - t0) / dur, 1);
      el.textContent = Math.round(to * (1 - Math.pow(1 - p, 3)));
      if (p < 1) requestAnimationFrame(tick);
    };
    requestAnimationFrame(tick);
  };
  const co = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if (e.isIntersecting) { count(e.target); co.unobserve(e.target); }
    });
  }, { threshold: 0.6 });
  document.querySelectorAll('.counter').forEach(el => co.observe(el));

  /* Barra de progreso del método */
  const progress = document.querySelector('.progress');
  if (progress) {
    new IntersectionObserver(([e], obs) => {
      if (e.isIntersecting) { progress.classList.add('is-on'); obs.disconnect(); }
    }, { threshold: 1 }).observe(progress);
  }

  /* Brillo que sigue al cursor en tarjetas de servicio */
  document.querySelectorAll('.svc').forEach(card => {
    card.addEventListener('pointermove', e => {
      const r = card.getBoundingClientRect();
      card.style.setProperty('--mx', `${e.clientX - r.left}px`);
      card.style.setProperty('--my', `${e.clientY - r.top}px`);
    });
  });

  /* Parallax suave en la textura del método */
  const mBg = document.querySelector('.method__bg');
  const method = document.querySelector('.method');
  if (mBg && !reduce) {
    const par = () => {
      const r = method.getBoundingClientRect();
      if (r.bottom < 0 || r.top > innerHeight) return;
      const p = (r.top + r.height / 2 - innerHeight / 2) / innerHeight;
      mBg.style.transform = `translate3d(0, ${p * -60}px, 0)`;
    };
    window.addEventListener('scroll', par, { passive: true });
    par();
  }

  /* Líneas fluidas (fondo generativo) */
  const NS = 'http://www.w3.org/2000/svg';
  const makeFlow = (svg, opts) => {
    if (!svg) return;
    const { lines, color1, color2, amp, speed } = opts;
    let W = 0, H = 0;
    const defs = document.createElementNS(NS, 'defs');
    const grad = document.createElementNS(NS, 'linearGradient');
    const gid = svg.id + '-g';
    grad.setAttribute('id', gid);
    grad.innerHTML = `<stop offset="0" stop-color="${color1}" stop-opacity="0"/><stop offset=".55" stop-color="${color1}" stop-opacity=".55"/><stop offset="1" stop-color="${color2}" stop-opacity=".9"/>`;
    defs.appendChild(grad);
    svg.appendChild(defs);
    const paths = Array.from({ length: lines }, (_, i) => {
      const p = document.createElementNS(NS, 'path');
      p.setAttribute('stroke', `url(#${gid})`);
      p.setAttribute('stroke-opacity', (0.18 + (i / lines) * 0.5).toFixed(2));
      svg.appendChild(p);
      return p;
    });
    const size = () => {
      const r = svg.getBoundingClientRect();
      W = r.width; H = r.height;
      svg.setAttribute('viewBox', `0 0 ${W} ${H}`);
    };
    size();
    window.addEventListener('resize', size);

    let visible = true;
    new IntersectionObserver(([e]) => { visible = e.isIntersecting; }).observe(svg);

    const draw = t => {
      const seg = 28;
      paths.forEach((p, i) => {
        const k = i / lines;
        const baseY = H * (0.25 + k * 0.7);
        let d = '';
        for (let s = 0; s <= seg; s++) {
          const x = (s / seg) * W;
          const nx = s / seg;
          const y = baseY
            + Math.sin(nx * 3.2 + t * speed + k * 2.4) * amp * (0.4 + nx)
            + Math.sin(nx * 7.1 - t * speed * 0.7 + k * 5) * amp * 0.25
            - nx * H * 0.18 * (1 - k);
          d += (s ? ' L' : 'M') + x.toFixed(1) + ' ' + y.toFixed(1);
        }
        p.setAttribute('d', d);
      });
    };
    if (reduce) { draw(0); return; }
    const loop = now => {
      if (visible) draw(now / 1000);
      requestAnimationFrame(loop);
    };
    requestAnimationFrame(loop);
  };
  makeFlow(document.getElementById('flow'), { lines: 22, color1: '#10BB82', color2: '#99E17A', amp: 46, speed: 0.35 });
  makeFlow(document.getElementById('flow2'), { lines: 16, color1: '#99E17A', color2: '#FFFFFF', amp: 36, speed: 0.25 });

  /* Formulario */
  const form = document.getElementById('form');
  const msg = document.getElementById('formMsg');
  form.addEventListener('submit', e => {
    e.preventDefault();
    let ok = true;
    form.querySelectorAll('[required]').forEach(f => {
      const bad = !f.value.trim() || (f.type === 'email' && !/^\S+@\S+\.\S+$/.test(f.value));
      f.classList.toggle('is-invalid', bad);
      if (bad) ok = false;
    });
    msg.classList.toggle('is-error', !ok);
    if (!ok) { msg.textContent = 'Revisa los campos marcados para continuar.'; return; }
    const nombre = form.nombre.value.trim().split(' ')[0];
    msg.textContent = `Gracias, ${nombre}. Un especialista de Totech te contactará en breve.`;
    form.reset();
  });
  form.addEventListener('input', e => e.target.classList.remove('is-invalid'));

  document.getElementById('year').textContent = new Date().getFullYear();
})();
