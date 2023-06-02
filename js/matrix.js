const canvas = document.getElementById('matrix-canvas');
const ctx = canvas.getContext('2d');

canvas.height = window.innerHeight;
canvas.width = window.innerWidth;

const binary = '01';
const columns = canvas.width / 10; 

const drops = [];

for (let x = 0; x < columns; x++) {
  drops[x] = 1;
}

function drawMatrix() {
  ctx.fillStyle = 'rgba(0, 0, 0, 0.05)';
  ctx.fillRect(0, 0, canvas.width, canvas.height);

  if (document.body.classList.contains('dark')) {
    ctx.fillStyle = '#FFFFFF';  // This color will be used for dark theme
  } else {
    ctx.fillStyle = '#FB1100';  // This color will be used for light theme
  }

  ctx.font = '10pt arial';

  for (let i = 0; i < drops.length; i++) {
    const text = binary[Math.floor(Math.random() * binary.length)];

    ctx.fillText(text, i * 10, drops[i] * 10);

    if (drops[i] * 10 > canvas.height && Math.random() > 0.975) drops[i] = 0;

    drops[i]++;
  }
}

setInterval(drawMatrix, 30);
