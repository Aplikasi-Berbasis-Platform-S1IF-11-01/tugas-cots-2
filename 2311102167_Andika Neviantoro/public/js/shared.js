/* ── SportZone shared JS ── */

// ── Logo SVG (inline, no external file) ──────────────────────
const LOGO_SVG = `
<svg width="240" height="46" viewBox="0 0 240 46" fill="none" xmlns="http://www.w3.org/2000/svg">
  <polygon points="23,2 43,13 43,35 23,46 3,35 3,13" fill="#E8FF00"/>
  <polygon points="23,7 38,16 38,32 23,41 8,32 8,16" fill="none" stroke="#0A0A0A" stroke-width="1" opacity="0.2"/>
  <path d="M27 7 L16 24 L22 24 L19 39 L30 22 L24 22 Z" fill="#0A0A0A"/>
  <text x="53" y="27" font-family="'Bebas Neue',sans-serif" font-size="28" letter-spacing="3" fill="#E8FF00">SPORT</text>
  <text x="121" y="27" font-family="'Bebas Neue',sans-serif" font-size="28" letter-spacing="3" fill="#FF4D00">ZONE</text>
  <rect x="121" y="30" width="62" height="2.5" rx="1.2" fill="#FF4D00" opacity="0.65"/>
  <text x="54" y="41" font-family="'DM Sans',sans-serif" font-size="7.5" font-weight="600" letter-spacing="1.6" fill="#666">SPORT EQUIPMENT STORE</text>
</svg>`;

// ── Inject navbar ke semua halaman ───────────────────────────
function renderNavbar(activePage) {
  const pages = [
    { href: '/',        icon: 'fa-table-list',  label: 'Data Produk' },
  ];

  const links = pages.map(p =>
    `<a href="${p.href}" class="${activePage === p.href ? 'active' : ''}">
      <i class="fa ${p.icon}"></i> ${p.label}
     </a>`
  ).join('');

  document.getElementById('navbar').innerHTML = `
    <nav class="sz-navbar">
      <a href="/" class="sz-logo">${LOGO_SVG}</a>
      <div class="sz-nav-links">${links}</div>
    </nav>`;
}

// ── Toast notification ────────────────────────────────────────
function showToast(msg, type = 'success') {
  let zone = document.getElementById('toastZone');
  if (!zone) {
    zone = document.createElement('div');
    zone.id = 'toastZone';
    zone.className = 'toast-zone';
    document.body.appendChild(zone);
  }
  const icons = { success: 'fa-circle-check', error: 'fa-circle-xmark', info: 'fa-circle-info' };
  const colors = { success: 'var(--success)', error: 'var(--accent)', info: 'var(--primary)' };
  const el = document.createElement('div');
  el.className = `sz-toast ${type}`;
  el.innerHTML = `<i class="fa ${icons[type]||icons.info}" style="color:${colors[type]};font-size:1rem;"></i><span>${msg}</span>`;
  zone.appendChild(el);
  setTimeout(() => { el.style.opacity = '0'; el.style.transform = 'translateX(110%)'; el.style.transition = '.3s'; setTimeout(() => el.remove(), 320); }, 3000);
}

// ── Format Rupiah ─────────────────────────────────────────────
function formatRupiah(n) {
  return 'Rp ' + Number(n).toLocaleString('id-ID');
}
