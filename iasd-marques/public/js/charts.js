// Very small chart utility using Canvas API (no external deps)
export function renderBarChart(canvasId, labels, values) {
  const canvas = document.getElementById(canvasId);
  if (!canvas) return;
  const ctx = canvas.getContext('2d');
  const width = canvas.width;
  const height = canvas.height;
  ctx.clearRect(0,0,width,height);

  const padding = 30;
  const maxVal = Math.max(...values, 1);
  const barWidth = (width - padding * 2) / values.length - 10;
  const scale = (height - padding * 2) / maxVal;

  ctx.font = '12px sans-serif';
  ctx.fillStyle = '#111827';

  values.forEach((v, i) => {
    const x = padding + i * (barWidth + 10);
    const barHeight = v * scale;
    const y = height - padding - barHeight;
    ctx.fillStyle = '#0b5ed7';
    ctx.fillRect(x, y, barWidth, barHeight);
    ctx.fillStyle = '#111827';
    ctx.fillText(labels[i], x, height - padding + 15);
    ctx.fillText(String(v), x, y - 4);
  });
}

