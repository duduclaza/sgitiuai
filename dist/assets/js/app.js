document.addEventListener('DOMContentLoaded', () => {
  if (window.lucide) {
    window.lucide.createIcons();
  }

  document.querySelectorAll('[data-password-toggle]').forEach((button) => {
    button.addEventListener('click', () => {
      const input = document.getElementById(button.dataset.passwordToggle || '');
      if (!input) return;

      const visible = input.type === 'text';
      input.type = visible ? 'password' : 'text';
      button.setAttribute('aria-label', visible ? 'Mostrar senha' : 'Ocultar senha');
      button.innerHTML = `<i data-lucide="${visible ? 'eye' : 'eye-off'}" class="h-5 w-5"></i>`;
      if (window.lucide) {
        window.lucide.createIcons();
      }
    });
  });

  document.querySelectorAll('[data-public-tab]').forEach((button) => {
    button.addEventListener('click', () => {
      const target = button.dataset.publicTab || 'formulario';
      document.querySelectorAll('[data-public-tab]').forEach((tab) => {
        tab.classList.toggle('is-active', tab.dataset.publicTab === target);
      });
      document.querySelectorAll('[data-public-panel]').forEach((panel) => {
        panel.classList.toggle('hidden', panel.dataset.publicPanel !== target);
      });
    });
  });

  document.querySelectorAll('canvas[data-particles]').forEach((canvas) => {
    const ctx = canvas.getContext('2d');
    if (!ctx) return;

    const particles = [];
    let width = 0;
    let height = 0;
    let ratio = window.devicePixelRatio || 1;

    const resize = () => {
      ratio = window.devicePixelRatio || 1;
      width = window.innerWidth;
      height = window.innerHeight;
      canvas.width = width * ratio;
      canvas.height = height * ratio;
      canvas.style.width = `${width}px`;
      canvas.style.height = `${height}px`;
      ctx.setTransform(ratio, 0, 0, ratio, 0, 0);
      const count = Math.min(90, Math.max(38, Math.floor(width / 18)));
      particles.length = 0;
      for (let i = 0; i < count; i += 1) {
        particles.push({
          x: Math.random() * width,
          y: Math.random() * height,
          vx: (Math.random() - 0.5) * 0.28,
          vy: (Math.random() - 0.5) * 0.28,
          r: Math.random() * 1.6 + 0.7,
        });
      }
    };

    const draw = () => {
      ctx.clearRect(0, 0, width, height);
      ctx.fillStyle = 'rgba(147, 197, 253, 0.62)';
      particles.forEach((p, index) => {
        p.x += p.vx;
        p.y += p.vy;
        if (p.x < 0 || p.x > width) p.vx *= -1;
        if (p.y < 0 || p.y > height) p.vy *= -1;

        ctx.beginPath();
        ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
        ctx.fill();

        for (let j = index + 1; j < particles.length; j += 1) {
          const other = particles[j];
          const dx = p.x - other.x;
          const dy = p.y - other.y;
          const distance = Math.sqrt(dx * dx + dy * dy);
          if (distance < 115) {
            ctx.strokeStyle = `rgba(96, 165, 250, ${0.14 * (1 - distance / 115)})`;
            ctx.lineWidth = 1;
            ctx.beginPath();
            ctx.moveTo(p.x, p.y);
            ctx.lineTo(other.x, other.y);
            ctx.stroke();
          }
        }
      });
      requestAnimationFrame(draw);
    };

    resize();
    window.addEventListener('resize', resize, { passive: true });
    draw();
  });

  const compact = localStorage.getItem('sidebarCompact') === '1';
  document.body.classList.toggle('sidebar-compact', compact);

  document.querySelectorAll('[data-sidebar-toggle]').forEach((button) => {
    button.addEventListener('click', () => {
      const isMobile = window.matchMedia('(max-width: 1024px)').matches;
      if (isMobile) {
        document.body.classList.toggle('sidebar-open');
        return;
      }

      document.body.classList.toggle('sidebar-compact');
      localStorage.setItem('sidebarCompact', document.body.classList.contains('sidebar-compact') ? '1' : '0');
    });
  });

  document.querySelectorAll('[data-sidebar-close]').forEach((el) => {
    el.addEventListener('click', () => document.body.classList.remove('sidebar-open'));
  });

  document.querySelectorAll('[data-confirm]').forEach((form) => {
    form.addEventListener('submit', (event) => {
      if (!confirm(form.dataset.confirm || 'Confirmar ação?')) {
        event.preventDefault();
      }
    });
  });

  document.querySelectorAll('canvas[data-chart]').forEach((canvas) => {
    const data = JSON.parse(canvas.dataset.chart || '[]');
    const ctx = canvas.getContext('2d');
    if (!ctx || data.length === 0) return;

    const rect = canvas.getBoundingClientRect();
    const ratio = window.devicePixelRatio || 1;
    canvas.width = rect.width * ratio;
    canvas.height = rect.height * ratio;
    ctx.scale(ratio, ratio);

    const width = rect.width;
    const height = rect.height;
    const type = canvas.dataset.chartType || 'bar';
    const max = Math.max(...data.map((item) => Number(item.total || 0)), 1);
    const padding = 24;
    const usableWidth = width - padding * 2;

    ctx.clearRect(0, 0, width, height);
    ctx.font = '12px Inter, system-ui';

    if (type === 'area') {
      const points = data.map((item, index) => {
        const x = padding + (data.length === 1 ? usableWidth / 2 : (usableWidth / (data.length - 1)) * index);
        const y = height - 34 - ((height - 76) * Number(item.total || 0)) / max;
        return { x, y, label: item.mes || item.nome || item.status || '', value: Number(item.total || 0) };
      });

      ctx.strokeStyle = 'rgba(226, 232, 240, 0.9)';
      ctx.lineWidth = 1;
      for (let i = 0; i < 4; i += 1) {
        const y = 22 + ((height - 62) / 3) * i;
        ctx.beginPath();
        ctx.moveTo(padding, y);
        ctx.lineTo(width - padding, y);
        ctx.stroke();
      }

      const area = ctx.createLinearGradient(0, 20, 0, height - 30);
      area.addColorStop(0, 'rgba(37, 99, 235, 0.22)');
      area.addColorStop(1, 'rgba(37, 99, 235, 0.02)');

      ctx.beginPath();
      points.forEach((point, index) => {
        if (index === 0) ctx.moveTo(point.x, point.y);
        else ctx.lineTo(point.x, point.y);
      });
      ctx.lineTo(points[points.length - 1].x, height - 34);
      ctx.lineTo(points[0].x, height - 34);
      ctx.closePath();
      ctx.fillStyle = area;
      ctx.fill();

      ctx.beginPath();
      points.forEach((point, index) => {
        if (index === 0) ctx.moveTo(point.x, point.y);
        else ctx.lineTo(point.x, point.y);
      });
      ctx.strokeStyle = '#2563eb';
      ctx.lineWidth = 3;
      ctx.lineJoin = 'round';
      ctx.stroke();

      points.forEach((point) => {
        ctx.fillStyle = '#fff';
        ctx.beginPath();
        ctx.arc(point.x, point.y, 5, 0, Math.PI * 2);
        ctx.fill();
        ctx.strokeStyle = '#2563eb';
        ctx.lineWidth = 2;
        ctx.stroke();
        ctx.fillStyle = '#64748b';
        ctx.fillText(String(point.label), point.x - 18, height - 12);
      });
      return;
    }

    const barWidth = Math.max(18, usableWidth / data.length - 10);
    data.forEach((item, index) => {
      const value = Number(item.total || 0);
      const barHeight = ((height - 64) * value) / max;
      const x = padding + index * (barWidth + 10);
      const y = height - 34 - barHeight;
      const gradient = ctx.createLinearGradient(0, y, 0, height);
      gradient.addColorStop(0, '#2563eb');
      gradient.addColorStop(1, '#bfdbfe');
      ctx.fillStyle = gradient;
      ctx.beginPath();
      ctx.roundRect(x, y, barWidth, barHeight, 8);
      ctx.fill();
      ctx.fillStyle = '#64748b';
      ctx.fillText(String(item.mes || item.nome || item.status || ''), x, height - 12, barWidth + 16);
    });
  });
});
