<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
$lab_users = $lab_users ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Users · Lab</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
  :root{
    --bg:#081410;
    --bg-hero:#0a1a14;
    --panel:#0d1a15;
    --border:#1a3327;
    --border-soft:#132720;
    --text:#dcf3e6;
    --muted:#6f9583;
    --muted-dim:#4d6b5c;
    --primary:#34d399;
    --primary-soft:rgba(52,211,153,0.14);
    --primary-dim:#1f7a58;
    --teal:#2dd4bf;
    --amber:#fbbf24;
    --mono:'JetBrains Mono', ui-monospace, Consolas, monospace;
    --sans:'Inter', system-ui, -apple-system, Segoe UI, sans-serif;
  }

  *{box-sizing:border-box;}

  body{
    margin:0;
    background:var(--bg);
    background-image:
      radial-gradient(ellipse 900px 500px at 15% -10%, rgba(52,211,153,0.10), transparent 60%),
      radial-gradient(ellipse 700px 500px at 100% 0%, rgba(45,212,191,0.06), transparent 55%);
    color:var(--text);
    font-family:var(--sans);
    -webkit-font-smoothing:antialiased;
  }

  .shell{max-width:1000px;margin:0 auto;padding:3rem 1.5rem 4rem;}

  /* ---------- Hero ---------- */
  .hero{
    display:flex;
    align-items:flex-end;
    justify-content:space-between;
    gap:2rem;
    flex-wrap:wrap;
    padding-bottom:2rem;
    margin-bottom:2rem;
    border-bottom:1px solid var(--border-soft);
  }
  .hero-left .kicker{
    display:flex;
    align-items:center;
    gap:0.5rem;
    font-family:var(--mono);
    font-size:0.78rem;
    color:var(--muted);
    margin-bottom:0.9rem;
  }
  .pulse-dot{
    width:7px;height:7px;border-radius:50%;
    background:var(--primary);
    box-shadow:0 0 0 0 rgba(52,211,153,0.6);
    animation:pulse 2.2s ease-out infinite;
    flex-shrink:0;
  }
  @keyframes pulse{
    0%{box-shadow:0 0 0 0 rgba(52,211,153,0.55);}
    70%{box-shadow:0 0 0 8px rgba(52,211,153,0);}
    100%{box-shadow:0 0 0 0 rgba(52,211,153,0);}
  }
  .hero-stat{
    font-family:var(--sans);
    font-weight:800;
    font-size:clamp(3rem, 8vw, 4.75rem);
    line-height:0.95;
    letter-spacing:-0.03em;
    color:var(--text);
    margin:0;
  }
  .hero-stat span{
    font-size:0.32em;
    font-weight:600;
    color:var(--muted);
    letter-spacing:-0.01em;
    margin-left:0.6rem;
  }
  .hero-sub{
    font-size:0.95rem;
    color:var(--muted);
    margin-top:0.5rem;
    max-width:34ch;
  }
  .hero-right{
    display:flex;
    gap:0.75rem;
  }
  .mini-stat{
    font-family:var(--mono);
    text-align:right;
    padding-right:1rem;
    border-right:1px solid var(--border-soft);
  }
  .mini-stat:last-child{border-right:none;padding-right:0;}
  .mini-stat .n{display:block;font-size:1.4rem;font-weight:700;color:var(--primary);}
  .mini-stat .l{display:block;font-size:0.68rem;color:var(--muted-dim);margin-top:0.15rem;}

  /* ---------- Panel ---------- */
  .panel{
    background:var(--panel);
    border:1px solid var(--border);
    border-radius:12px;
    overflow:hidden;
  }
  .panel-head{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:1rem;
    padding:1.1rem 1.4rem;
    flex-wrap:wrap;
  }
  .panel-head .title{
    display:flex;
    align-items:center;
    gap:0.6rem;
    font-weight:600;
    font-size:0.95rem;
  }
  .panel-head .title svg{stroke:var(--primary);width:16px;height:16px;flex-shrink:0;}

  .search-wrap{
    position:relative;
    width:100%;
    max-width:300px;
  }
  .search-wrap svg{
    position:absolute;left:0.75rem;top:50%;transform:translateY(-50%);
    width:14px;height:14px;stroke:var(--muted-dim);pointer-events:none;
  }
  .search-wrap input{
    width:100%;
    background:var(--bg);
    border:1px solid var(--border);
    border-radius:7px;
    padding:0.5rem 0.8rem 0.5rem 2.1rem;
    color:var(--text);
    font-family:var(--mono);
    font-size:0.83rem;
    outline:none;
    transition:border-color .15s ease, box-shadow .15s ease;
  }
  .search-wrap input:focus{
    border-color:var(--primary-dim);
    box-shadow:0 0 0 3px var(--primary-soft);
  }
  .search-wrap input::placeholder{color:var(--muted-dim);}

  .table-scroll{width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;}
  table{width:100%;border-collapse:collapse;font-size:0.88rem;min-width:600px;}
  thead th{
    text-align:left;
    font-family:var(--mono);
    font-weight:500;
    font-size:0.72rem;
    color:var(--muted-dim);
    padding:0 1.4rem 0.7rem;
    border-bottom:1px solid var(--border);
    white-space:nowrap;
  }
  tbody td{
    padding:0.7rem 1.4rem;
    border-bottom:1px solid var(--border-soft);
    vertical-align:middle;
  }
  tbody tr:last-child td{border-bottom:none;}
  tbody tr{transition:background .12s ease;}
  tbody tr:hover{background:rgba(52,211,153,0.045);}

  .id-cell{font-family:var(--mono);color:var(--muted-dim);}

  .who-cell{display:flex;align-items:center;gap:0.65rem;}
  .avatar{
    width:28px;height:28px;border-radius:7px;
    display:flex;align-items:center;justify-content:center;
    font-family:var(--mono);font-size:0.68rem;font-weight:700;
    background:var(--primary-soft);
    color:var(--primary);
    flex-shrink:0;
  }
  .who-name{font-weight:500;}

  .email-cell{color:var(--teal);font-family:var(--mono);font-size:0.83rem;}
  .username-cell{font-family:var(--mono);font-size:0.83rem;color:var(--text);}
  .username-cell::before{content:'@';color:var(--muted-dim);}

  mark{
    background:rgba(251,191,36,0.28);
    color:var(--amber);
    border-radius:3px;
    padding:0 2px;
  }

  .no-results{
    display:none;
    padding:3rem 1.4rem;
    text-align:center;
    color:var(--muted-dim);
    font-family:var(--mono);
    font-size:0.85rem;
  }
  .no-results svg{stroke:var(--muted-dim);width:22px;height:22px;margin-bottom:0.6rem;}

  .foot-note{
    font-family:var(--mono);
    font-size:0.72rem;
    color:var(--muted-dim);
    text-align:center;
    margin-top:1.6rem;
  }

  @media (prefers-reduced-motion: reduce){
    .pulse-dot{animation:none;}
  }

  @media (max-width: 640px){
    .shell{padding:2rem 1rem 3rem;}
    .hero{flex-direction:column;align-items:flex-start;gap:1.25rem;}
    .hero-right{width:100%;justify-content:space-between;}
    .mini-stat{text-align:left;padding-right:0.75rem;}
    .panel-head{align-items:stretch;}
    .search-wrap{max-width:100%;}
    thead th, tbody td{padding:0.6rem 0.9rem;}
    table{min-width:540px;}
  }
</style>
</head>
<body>
<div class="shell">

  <div class="hero">
    <div class="hero-left">
      <div class="kicker"><span class="pulse-dot"></span>lab_users · live table</div>
      <p class="hero-stat"><?= count($lab_users) ?><span>registered</span></p>
      <p class="hero-sub">Everyone currently provisioned in this lab environment, searchable by name, email or username.</p>
    </div>
    <div class="hero-right">
      <div class="mini-stat">
        <span class="n"><?= count($lab_users) ?></span>
        <span class="l">total rows</span>
      </div>
      <div class="mini-stat">
        <span class="n"><?= count(array_unique(array_map(fn($u) => substr($u['email'] ?? '', strpos($u['email'] ?? '', '@')), $lab_users))) ?></span>
        <span class="l">domains</span>
      </div>
    </div>
  </div>

  <div class="panel">
    <div class="panel-head">
      <div class="title">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 5h18M3 12h18M3 19h18"/></svg>
        Users
      </div>
      <div class="search-wrap">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" id="userSearch" placeholder="Search users…" autocomplete="off">
      </div>
    </div>

    <div class="table-scroll">
      <table id="userTable">
        <thead>
          <tr>
            <th>id</th>
            <th>name</th>
            <th>email</th>
            <th>username</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($lab_users as $u):
            $initials = strtoupper(substr($u['firstname'] ?? '', 0, 1) . substr($u['lastname'] ?? '', 0, 1));
          ?>
          <tr>
            <td class="id-cell"><?= htmlspecialchars($u['id']) ?></td>
            <td>
              <div class="who-cell">
                <div class="avatar"><?= htmlspecialchars($initials) ?></div>
                <span class="who-name"><?= htmlspecialchars($u['firstname']) ?> <?= htmlspecialchars($u['lastname']) ?></span>
              </div>
            </td>
            <td class="email-cell"><?= htmlspecialchars($u['email']) ?></td>
            <td class="username-cell"><?= htmlspecialchars($u['username']) ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <div class="no-results" id="noResults">
      <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      <div>No users match your search.</div>
    </div>
  </div>

  <p class="foot-note" id="footNote"><?= count($lab_users) ?> of <?= count($lab_users) ?> users shown</p>

</div>

<script>
(function(){
  const input = document.getElementById('userSearch');
  const rows = Array.from(document.querySelectorAll('#userTable tbody tr'));
  const noResults = document.getElementById('noResults');
  const footNote = document.getElementById('footNote');
  const total = rows.length;

  // cache original cell text once, per cell
  rows.forEach(row => {
    row.querySelectorAll('td').forEach(c => { c.dataset.original = c.innerHTML; });
  });

  function highlightText(node, term){
    // Only touch text-bearing leaf nodes so avatar markup stays intact
    node.querySelectorAll('.who-name, .email-cell, .username-cell, .id-cell').forEach(el => {
      const text = el.textContent;
      if(!term){ el.innerHTML = text; return; }
      const idx = text.toLowerCase().indexOf(term.toLowerCase());
      if(idx === -1){ el.innerHTML = text; return; }
      el.innerHTML = text.slice(0, idx) + '<mark>' + text.slice(idx, idx + term.length) + '</mark>' + text.slice(idx + term.length);
    });
  }

  input.addEventListener('input', function(){
    const term = this.value.trim();
    let visible = 0;

    rows.forEach(row => {
      const haystack = row.textContent.toLowerCase();
      const match = !term || haystack.includes(term.toLowerCase());
      row.style.display = match ? '' : 'none';
      if(match) visible++;
      highlightText(row, match ? term : '');
    });

    footNote.textContent = `${visible} of ${total} users shown`;
    noResults.style.display = visible === 0 ? 'block' : 'none';
  });
})();
</script>
</body>
</html>