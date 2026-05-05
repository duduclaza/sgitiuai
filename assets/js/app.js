document.addEventListener('DOMContentLoaded', () => {
  if (window.lucide) {
    window.lucide.createIcons();
  }

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
    const max = Math.max(...data.map((item) => Number(item.total || 0)), 1);
    const padding = 24;
    const barWidth = Math.max(18, (width - padding * 2) / data.length - 10);

    ctx.clearRect(0, 0, width, height);
    ctx.font = '12px Inter, system-ui';
    data.forEach((item, index) => {
      const value = Number(item.total || 0);
      const barHeight = ((height - 64) * value) / max;
      const x = padding + index * (barWidth + 10);
      const y = height - 34 - barHeight;
      const gradient = ctx.createLinearGradient(0, y, 0, height);
      gradient.addColorStop(0, '#2563eb');
      gradient.addColorStop(1, '#93c5fd');
      ctx.fillStyle = gradient;
      ctx.beginPath();
      ctx.roundRect(x, y, barWidth, barHeight, 8);
      ctx.fill();
      ctx.fillStyle = '#64748b';
      ctx.fillText(String(item.mes || item.nome || item.status || ''), x, height - 12, barWidth + 16);
    });
  });
});
