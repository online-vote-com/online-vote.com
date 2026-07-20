<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Online‑Vote permet d’organiser des élections, sondages et concours avec OTP, résultats en temps réel et paiements Orange Money ou MTN MoMo.">
<meta name="theme-color" content="#241a35">
<meta property="og:title" content="Online‑Vote — Le vote digital, simple, fiable et accessible">
<meta property="og:description" content="Créez des scrutins gratuits ou des concours payants avec Mobile Money, OTP et suivi en temps réel.">
<meta property="og:type" content="website">
<title>Online‑Vote — Le vote digital, simple et fiable</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
<style>
:root {
  --primary: #9C04DA;
  --primary-dark: #530274;
  --primary-soft: #ede7f5;
  --secondary: #c8933b;
  --success: #16a06a;
  --ink: #1a1329;
  --muted: #6b6577;
  --surface: #ffffff;
  --surface-alt: #f6f5f8;
  --border: #e2deeb;
  --dark: #251a35;
  --shadow-sm: 0 10px 30px rgba(26,19,41,.08);
  --shadow-lg: 0 28px 80px rgba(26,19,41,.16);
  --radius: 22px;
}
*{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth;scroll-padding-top:92px}
body{font-family:'DM Sans',sans-serif;color:var(--ink);background:#fff;line-height:1.6;-webkit-font-smoothing:antialiased;overflow-x:hidden}
body.menu-open{overflow:hidden}
a{text-decoration:none;color:inherit}
button,input{font:inherit}
img,svg{display:block;max-width:100%}
ul{list-style:none}
.wrap{width:min(1180px,calc(100% - 40px));margin-inline:auto}
.skip-link{position:absolute;left:-999px;top:8px;background:#fff;color:#000;padding:10px 14px;border-radius:10px;z-index:999}
.skip-link:focus{left:12px}

header{position:sticky;top:0;z-index:100;background:rgba(255,255,255,.86);border-bottom:1px solid rgba(231,226,238,.8);backdrop-filter:blur(18px)}
.nav{height:78px;display:flex;align-items:center;justify-content:space-between;gap:24px}
.logo{display:flex;align-items:center;gap:11px;font:800 1.08rem 'Manrope',sans-serif;letter-spacing:-.03em}
.logo-mark{width:38px;height:38px;border-radius:12px;display:grid;place-items:center;background:linear-gradient(135deg,var(--primary),var(--primary-dark));color:#fff;box-shadow:0 10px 24px rgba(92,66,132,.28)}
.nav-links{display:flex;align-items:center;gap:30px;color:#5e5869;font-size:.92rem;font-weight:600}
.nav-links a{position:relative;padding:10px 0}
.nav-links a::after{content:"";position:absolute;left:0;right:100%;bottom:4px;height:2px;border-radius:2px;background:var(--primary);transition:.2s}
.nav-links a:hover::after{right:0}
.nav-actions{display:flex;align-items:center;gap:10px}
.btn{display:inline-flex;align-items:center;justify-content:center;gap:9px;min-height:46px;padding:0 20px;border:1px solid transparent;border-radius:14px;font-weight:700;font-size:.92rem;transition:.2s ease;cursor:pointer}
.btn:hover{transform:translateY(-2px)}
.btn-primary{color:#fff;background:linear-gradient(135deg,var(--primary),var(--primary-dark));box-shadow:0 12px 28px rgba(92,66,132,.25)}
.btn-primary:hover{box-shadow:0 16px 34px rgba(92,66,132,.32)}
.btn-secondary{background:#fff;border-color:var(--border);color:var(--ink)}
.btn-secondary:hover{border-color:#cfc4ef;background:var(--primary-soft)}
.btn-light{background:#fff;color:var(--dark);box-shadow:var(--shadow-sm)}
.btn-ghost-light{border-color:rgba(255,255,255,.28);color:#fff;background:rgba(255,255,255,.06)}
.btn-sm{min-height:40px;padding:0 16px;border-radius:12px;font-size:.86rem}
.menu-toggle{display:none;width:44px;height:44px;border:1px solid var(--border);border-radius:12px;background:#fff;place-items:center;cursor:pointer}
.menu-toggle span,.menu-toggle::before,.menu-toggle::after{content:"";width:20px;height:2px;background:var(--ink);display:block;transition:.2s}
.menu-toggle span{margin:4px 0}
.mobile-panel{display:none}

.hero{position:relative;padding:92px 0 76px;overflow:hidden;background:
radial-gradient(circle at 88% 16%,rgba(92,66,132,.13),transparent 26%),
radial-gradient(circle at 12% 82%,rgba(200,147,59,.10),transparent 24%),
linear-gradient(180deg,#fff 0%,#fbfaff 100%)}
.hero::before{content:"";position:absolute;inset:0;background-image:linear-gradient(rgba(92,66,132,.035) 1px,transparent 1px),linear-gradient(90deg,rgba(92,66,132,.035) 1px,transparent 1px);background-size:42px 42px;mask-image:linear-gradient(to bottom,rgba(0,0,0,.5),transparent 80%);pointer-events:none}
.hero-grid{position:relative;display:grid;grid-template-columns:1.02fr .98fr;align-items:center;gap:64px}
.badge{display:inline-flex;align-items:center;gap:9px;padding:8px 13px;border:1px solid #e2deeb;background:rgba(255,255,255,.75);border-radius:999px;color:var(--primary-dark);font-weight:700;font-size:.77rem;text-transform:uppercase;letter-spacing:.055em;box-shadow:0 8px 22px rgba(26,19,41,.06)}
.badge-dot{width:8px;height:8px;border-radius:50%;background:var(--success);box-shadow:0 0 0 5px rgba(22,160,106,.12)}
.hero h1{font:800 clamp(2.7rem,5.3vw,4.65rem)/1.02 'Manrope',sans-serif;letter-spacing:-.055em;margin:24px 0 22px;max-width:680px}
.hero h1 span{color:var(--primary)}
.hero-copy{font-size:1.12rem;color:var(--muted);max-width:590px;line-height:1.75}
.hero-actions{display:flex;flex-wrap:wrap;gap:13px;margin:32px 0 28px}
.trust-list{display:flex;flex-wrap:wrap;gap:18px;color:#5f596a;font-size:.88rem;font-weight:600}
.trust-list li{display:flex;align-items:center;gap:8px}
.trust-icon{width:20px;height:20px;border-radius:50%;display:grid;place-items:center;background:#e7f7f0;color:var(--success)}

.dashboard-shell{position:relative;min-height:520px;display:grid;place-items:center}
.dashboard{position:relative;width:min(100%,500px);padding:18px;background:rgba(255,255,255,.82);border:1px solid rgba(255,255,255,.9);border-radius:28px;box-shadow:var(--shadow-lg);backdrop-filter:blur(15px);transform:rotate(1deg)}
.browser-bar{display:flex;align-items:center;justify-content:space-between;padding:7px 7px 16px}
.browser-dots{display:flex;gap:6px}.browser-dots i{width:8px;height:8px;border-radius:50%;background:#d7d1df}.browser-dots i:first-child{background:#ff7f73}.browser-dots i:nth-child(2){background:#f5c451}.browser-dots i:nth-child(3){background:#57c785}
.browser-chip{font-size:.72rem;font-weight:700;color:#777080;background:#f3f0f7;padding:6px 10px;border-radius:999px}
.vote-card{background:linear-gradient(145deg,#2c2140,#1a1329);color:#fff;border-radius:22px;padding:25px;overflow:hidden;position:relative}
.vote-card::after{content:"";position:absolute;width:220px;height:220px;border-radius:50%;background:rgba(92,66,132,.28);right:-90px;top:-100px}
.vote-top{display:flex;justify-content:space-between;align-items:flex-start;position:relative;z-index:1}.vote-label{font-size:.75rem;color:#c8bdd8;text-transform:uppercase;letter-spacing:.08em;font-weight:700}.live{display:flex;align-items:center;gap:6px;font-size:.74rem;color:#95e4bf;font-weight:700}.live::before{content:"";width:7px;height:7px;border-radius:50%;background:#39d98a;box-shadow:0 0 0 5px rgba(57,217,138,.12)}
.vote-card h3{font:700 1.35rem 'Manrope',sans-serif;margin:10px 0 24px;position:relative;z-index:1}
.candidate{display:grid;grid-template-columns:46px 1fr auto;align-items:center;gap:12px;padding:13px 0;border-top:1px solid rgba(255,255,255,.09);position:relative;z-index:1}
.avatar{width:46px;height:46px;border-radius:14px;display:grid;place-items:center;font-weight:800;background:linear-gradient(135deg,#f5c451,#d98b26);color:#271b0b}.avatar.alt{background:linear-gradient(135deg,#8a71ab,#4b3568);color:#fff}.candidate strong{display:block;font-size:.9rem}.candidate small{display:block;color:#aaa0b9;margin-top:2px}.score{font:800 1.12rem 'Manrope',sans-serif}
.analytics{display:grid;grid-template-columns:1.15fr .85fr;gap:14px;margin-top:14px}
.metric{background:#fff;border:1px solid var(--border);border-radius:17px;padding:17px}.metric small{color:var(--muted);font-weight:600}.metric strong{font:800 1.65rem 'Manrope',sans-serif;display:block;margin-top:4px}.trend{color:var(--success);font-size:.76rem;font-weight:700}.bars{display:flex;align-items:end;gap:6px;height:62px;margin-top:10px}.bars i{flex:1;border-radius:5px 5px 2px 2px;background:linear-gradient(180deg,#8a71ab,#5c4284);opacity:.82}.bars i:nth-child(1){height:28%}.bars i:nth-child(2){height:42%}.bars i:nth-child(3){height:34%}.bars i:nth-child(4){height:65%}.bars i:nth-child(5){height:51%}.bars i:nth-child(6){height:82%}.bars i:nth-child(7){height:100%}
.float-card{position:absolute;display:flex;align-items:center;gap:10px;padding:12px 15px;background:#fff;border:1px solid var(--border);border-radius:15px;box-shadow:var(--shadow-sm);font-size:.82rem;font-weight:700;animation:float 5s ease-in-out infinite}.float-card.one{top:45px;left:-10px}.float-card.two{right:-18px;bottom:58px;animation-delay:.8s}.float-icon{width:34px;height:34px;border-radius:10px;display:grid;place-items:center;color:#fff}.float-icon.green{background:var(--success)}.float-icon.orange{background:var(--secondary)}
@keyframes float{50%{transform:translateY(-9px)}}

section{padding:94px 0}.section-head{max-width:690px;margin-bottom:48px}.section-head.center{text-align:center;margin-inline:auto}.kicker{display:inline-block;color:var(--primary);text-transform:uppercase;letter-spacing:.08em;font-size:.76rem;font-weight:800;margin-bottom:12px}.section-head h2{font:800 clamp(2rem,3.4vw,3.1rem)/1.12 'Manrope',sans-serif;letter-spacing:-.045em;margin-bottom:15px}.section-head p{font-size:1.03rem;color:var(--muted);line-height:1.75}
.features{background:var(--surface-alt)}
.feature-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px}.feature-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:28px;box-shadow:0 8px 28px rgba(36,26,53,.035);transition:.25s}.feature-card:hover{transform:translateY(-6px);border-color:#cfc3fa;box-shadow:var(--shadow-sm)}.feature-icon{width:48px;height:48px;border-radius:14px;display:grid;place-items:center;background:var(--primary-soft);color:var(--primary);margin-bottom:20px}.feature-card h3{font:700 1.08rem 'Manrope',sans-serif;margin-bottom:10px}.feature-card p{color:var(--muted);font-size:.91rem;line-height:1.7}

.process{background:var(--dark);color:#fff;position:relative;overflow:hidden}.process::before{content:"";position:absolute;inset:0;background:radial-gradient(circle at 10% 20%,rgba(92,66,132,.3),transparent 26%),radial-gradient(circle at 90% 80%,rgba(200,147,59,.12),transparent 22%)}.process .wrap{position:relative}.process .section-head p{color:#bdb4c8}.process .section-head h2{color:#fff}.process .kicker{color:#c9b8de}.path-tabs{display:flex;justify-content:center;gap:10px;margin-bottom:28px}.tab-btn{border:1px solid rgba(255,255,255,.14);background:rgba(255,255,255,.04);color:#c9c1d2;border-radius:12px;padding:11px 16px;font-weight:700;cursor:pointer}.tab-btn.active{background:#fff;color:var(--dark);border-color:#fff}.path-panel{display:none}.path-panel.active{display:grid}.path-panel{grid-template-columns:.85fr 1.15fr;gap:24px;align-items:stretch}.path-intro,.step-box{border:1px solid rgba(255,255,255,.12);background:rgba(255,255,255,.045);border-radius:24px;padding:32px}.path-chip{display:inline-flex;padding:7px 12px;border-radius:999px;font-size:.74rem;text-transform:uppercase;letter-spacing:.06em;font-weight:800;background:rgba(92,66,132,.32);color:#d6c9e8}.path-chip.paid{background:rgba(200,147,59,.2);color:#ffd28b}.path-intro h3{font:700 1.65rem 'Manrope',sans-serif;margin:20px 0 12px}.path-intro p{color:#bdb4c8}.path-benefit{margin-top:28px;padding-top:22px;border-top:1px solid rgba(255,255,255,.1);display:flex;gap:12px;color:#e7e1ec;font-size:.9rem}.step-list{display:grid;gap:13px}.step{display:grid;grid-template-columns:38px 1fr;gap:14px;align-items:start;padding:16px;border-radius:16px;background:rgba(255,255,255,.045)}.step-num{width:38px;height:38px;border-radius:12px;display:grid;place-items:center;background:rgba(92,66,132,.32);color:#ded2ed;font-weight:800}.step h4{font:700 .98rem 'Manrope',sans-serif;margin:1px 0 4px}.step p{color:#bdb4c8;font-size:.86rem}

.payments{padding-top:74px;padding-bottom:74px}.payment-panel{display:grid;grid-template-columns:1.1fr .9fr;gap:35px;align-items:center;padding:42px;border:1px solid var(--border);border-radius:28px;background:linear-gradient(135deg,#fff,#f8f5ff);box-shadow:var(--shadow-sm)}.payment-panel h2{font:800 clamp(1.8rem,3vw,2.6rem)/1.15 'Manrope',sans-serif;letter-spacing:-.04em;margin-bottom:14px}.payment-panel p{color:var(--muted);max-width:580px}.payment-logos{display:flex;justify-content:flex-end;gap:14px;flex-wrap:wrap}.payment-pill{min-width:150px;background:#fff;border:1px solid var(--border);border-radius:17px;padding:18px;display:flex;align-items:center;gap:12px;font-weight:800;box-shadow:0 8px 22px rgba(35,26,50,.05)}.network-dot{width:34px;height:34px;border-radius:11px;display:grid;place-items:center;color:#fff}.network-dot.orange{background:#ff7900}.network-dot.mtn{background:#ffcb05;color:#241a35}

.use-cases-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px}.case{border:1px solid var(--border);border-radius:22px;padding:27px;background:#fff}.case-number{font:800 2.2rem 'Manrope',sans-serif;color:#ded6f7}.case h3{font:700 1.08rem 'Manrope',sans-serif;margin:10px 0}.case p{color:var(--muted);font-size:.9rem}

.testimonial{background:var(--surface-alt)}.quote{max-width:780px;margin:auto;text-align:center}.quote .kicker{display:block}.quote blockquote{margin-top:14px;font:600 clamp(1.4rem,2.6vw,2.05rem)/1.5 'Manrope',sans-serif;letter-spacing:-.025em}

.faq-list{max-width:820px;margin:auto;border-top:1px solid var(--border)}.faq-item{border-bottom:1px solid var(--border)}.faq-question{width:100%;display:flex;justify-content:space-between;align-items:center;gap:24px;padding:22px 0;background:none;border:0;text-align:left;color:var(--ink);font-weight:700;cursor:pointer}.faq-question .plus{width:30px;height:30px;border-radius:10px;display:grid;place-items:center;background:var(--surface-alt);transition:.2s}.faq-item.open .plus{transform:rotate(45deg);background:var(--primary-soft);color:var(--primary)}.faq-answer{display:grid;grid-template-rows:0fr;transition:grid-template-rows .25s ease}.faq-answer>div{overflow:hidden}.faq-answer p{color:var(--muted);padding:0 48px 22px 0;font-size:.94rem}.faq-item.open .faq-answer{grid-template-rows:1fr}

.final{padding-top:50px}.final-card{position:relative;overflow:hidden;text-align:center;padding:72px 30px;border-radius:30px;color:#fff;background:linear-gradient(135deg,#5c4284 0%,#3c2b56 54%,#251a35 100%);box-shadow:0 30px 80px rgba(60,43,86,.28)}.final-card::before,.final-card::after{content:"";position:absolute;border-radius:50%;background:rgba(255,255,255,.07)}.final-card::before{width:370px;height:370px;right:-120px;top:-190px}.final-card::after{width:240px;height:240px;left:-120px;bottom:-120px}.final-card>*{position:relative}.final-card h2{font:800 clamp(2rem,4vw,3.2rem)/1.12 'Manrope',sans-serif;letter-spacing:-.05em}.final-card p{max-width:620px;margin:17px auto 28px;color:#ded7ee}.final-actions{display:flex;justify-content:center;gap:12px;flex-wrap:wrap}

footer{background:#171020;color:#a9a1b2;margin-top:94px;padding:62px 0 28px}.footer-grid{display:grid;grid-template-columns:1.5fr repeat(3,1fr);gap:44px;padding-bottom:42px;border-bottom:1px solid rgba(255,255,255,.09)}.footer-brand .logo{color:#fff;margin-bottom:16px}.footer-brand p{max-width:330px;font-size:.88rem}.footer-col h4{color:#fff;font:700 .82rem 'Manrope',sans-serif;text-transform:uppercase;letter-spacing:.07em;margin-bottom:15px}.footer-col ul{display:grid;gap:10px;font-size:.87rem}.footer-col a:hover{color:#fff}.footer-bottom{display:flex;justify-content:space-between;gap:18px;align-items:center;padding-top:25px;font-size:.8rem}.footer-links{display:flex;gap:18px;flex-wrap:wrap}

.reveal{opacity:0;transform:translateY(18px);transition:opacity .55s ease,transform .55s ease}.reveal.visible{opacity:1;transform:none}

@media(max-width:980px){
 .nav-links,.nav-actions .btn-secondary{display:none}.menu-toggle{display:grid}.mobile-panel{position:fixed;inset:79px 0 auto;background:#fff;border-bottom:1px solid var(--border);padding:18px 20px 24px;box-shadow:var(--shadow-sm);transform:translateY(-130%);transition:.25s;display:block}.mobile-panel.open{transform:none}.mobile-panel nav{display:grid;gap:8px}.mobile-panel a{padding:12px;border-radius:10px;font-weight:700}.mobile-panel a:hover{background:var(--surface-alt)}.mobile-actions{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:14px}
 .hero-grid{grid-template-columns:1fr}.hero-copy{max-width:680px}.dashboard-shell{min-height:500px}.feature-grid,.use-cases-grid{grid-template-columns:repeat(2,1fr)}.path-panel{grid-template-columns:1fr}.payment-panel{grid-template-columns:1fr}.payment-logos{justify-content:flex-start}.footer-grid{grid-template-columns:1.4fr 1fr 1fr}.footer-col:last-child{grid-column:2/4}
}
@media(max-width:680px){
 .wrap{width:min(100% - 28px,1180px)}.nav{height:70px}.mobile-panel{inset:71px 0 auto}.nav-actions .btn-primary{display:none}.hero{padding:66px 0 52px}.hero h1{font-size:clamp(2.45rem,12vw,3.45rem)}.hero-actions{display:grid}.hero-actions .btn{width:100%}.dashboard-shell{min-height:420px}.dashboard{transform:none;padding:12px}.float-card{display:none}.analytics{grid-template-columns:1fr}.feature-grid,.use-cases-grid{grid-template-columns:1fr}section{padding:68px 0}.path-tabs{display:grid;grid-template-columns:1fr 1fr}.path-intro,.step-box{padding:24px}.payment-panel{padding:28px 22px}.payment-logos{display:grid;grid-template-columns:1fr}.payment-pill{min-width:0}.final-card{padding:54px 20px}.footer-grid{grid-template-columns:1fr}.footer-col:last-child{grid-column:auto}.footer-bottom{align-items:flex-start;flex-direction:column}.mobile-actions{grid-template-columns:1fr}.trust-list{gap:12px}.vote-card{padding:20px}.candidate{grid-template-columns:42px 1fr auto}.avatar{width:42px;height:42px}.section-head{margin-bottom:36px}
}
@media(prefers-reduced-motion:reduce){html{scroll-behavior:auto}*,*::before,*::after{animation:none!important;transition:none!important}.reveal{opacity:1;transform:none}}
</style>
</head>
<body>

<header>
  <div class="wrap ">
   <!-- <a href="#" class="logo" aria-label="Online‑Vote, accueil"><span class="logo-mark">✓</span>Online‑Vote</a>
   <nav class="nav-links" aria-label="Navigation principale">
      <a href="#fonctionnalites">Fonctionnalités</a><a href="#fonctionnement">Fonctionnement</a><a href="#paiement">Paiements</a><a href="#faq">FAQ</a>
    </nav> -->
    <div class="nav-actions">
     <!--  <a href="https://online-vote.com/login" class="btn btn-secondary btn-sm">Connexion</a>
      <a href="register" class="btn btn-primary btn-sm">Créer un scrutin</a>
-->
      <button class="menu-toggle" type="button" aria-label="Ouvrir le menu" aria-expanded="false"><span></span></button>
    </div>
  </div>
  <div class="mobile-panel" id="mobileMenu">
  <!--  <nav aria-label="Navigation mobile"><a href="#fonctionnalites">Fonctionnalités</a><a href="#fonctionnement">Fonctionnement</a><a href="#paiement">Paiements</a><a href="#faq">FAQ</a></nav>
    <div class="mobile-actions"><a href="login" class="btn btn-secondary">Connexion</a><a href="https://online-vote.com/signup.php" class="btn btn-primary">Créer un scrutin</a></div>
 -->
</div>
</header>

<main id="contenu">
<section class="hero">
  <div class="wrap hero-grid">
    <div>
     <!-- <span class="badge"><span class="badge-dot"></span>Solution de vote électronique au Cameroun</span>-->
      <h1>Des votes plus simples, plus sûrs et <span>plus engageants.</span></h1>
      <!--   <p class="hero-copy">Organisez une élection, un sondage ou un concours en quelques minutes. Online‑Vote réunit authentification OTP, résultats en temps réel et paiement Mobile Money dans une expérience fluide pour chaque participant.</p>
      -->
      <div class="hero-actions">
        <a href="admin/dash" class="btn btn-primary">Créer mon scrutin</a>
        <a href="concours" class="btn btn-secondary">Découvrir les concours</a>
      </div>
      <ul class="trust-list" aria-label="Garanties principales">
       <!-- <li><span class="trust-icon">✓</span>Vote chiffré</li><li><span class="trust-icon">✓</span>Accès sans friction</li><li><span class="trust-icon">✓</span>Orange Money & MTN MoMo</li> -->
      </ul>
    </div>
    <div class="dashboard-shell" aria-label="Aperçu du tableau de bord Online‑Vote">
      <div class="float-card one"><span class="float-icon green">✓</span>Vote validé</div>
      <div class="dashboard">
        <div class="browser-bar"><div class="browser-dots"><i></i><i></i><i></i></div><span class="browser-chip">Tableau de bord</span></div>
        <div class="vote-card">
          <div class="vote-top"><span class="vote-label">Concours culturel 2026</span><span class="live">En direct</span></div>
          <h3>Classement des candidats</h3>
          <div class="candidate"><div class="avatar">AM</div><div><strong>Amina M.</strong><small>Candidate n°04</small></div><div class="score">42%</div></div>
          <div class="candidate"><div class="avatar alt">JN</div><div><strong>Joël N.</strong><small>Candidat n°07</small></div><div class="score">31%</div></div>
        </div>
        <div class="analytics"><div class="metric"><small>Votes enregistrés</small><strong>12 480</strong><span class="trend">+18,4 % aujourd’hui</span></div><div class="metric"><small>Activité</small><div class="bars"><i></i><i></i><i></i><i></i><i></i><i></i><i></i></div></div></div>
      </div>
      <div class="float-card two"><span class="float-icon orange">₣</span>Paiement confirmé</div>
    </div>
  </div>
</section>

<section class="features" id="fonctionnalites">
  <div class="wrap">
    <div class="section-head reveal"><span class="kicker">Fonctionnalités</span><h2>Tout ce qu’il faut pour piloter un scrutin professionnel</h2><p>De la création du vote à la publication des résultats, chaque étape est conçue pour être simple, lisible et sécurisée.</p></div>
    <div class="feature-grid">
      <article class="feature-card reveal"><div class="feature-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="10" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg></div><h3>Bulletins sécurisés</h3><p>Les votes sont enregistrés de manière protégée afin de préserver l'intégrité du scrutin et la confidentialité des participants.</p></article>
      <article class="feature-card reveal"><div class="feature-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 21v-1a8 8 0 0116 0v1"/></svg></div><h3>Authentification OTP</h3><p>Un code à usage unique permet de vérifier le votant et de réduire les risques de participation multiple.</p></article>
      <article class="feature-card reveal"><div class="feature-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg></div><h3>Mobile Money intégré</h3><p>Les concours payants acceptent Orange Money et MTN MoMo directement dans le parcours de vote.</p></article>
      <article class="feature-card reveal"><div class="feature-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12l2-2 4 4 8-8 2 2"/><path d="M3 20h18"/></svg></div><h3>Résultats en temps réel</h3><p>Suivez l'évolution des votes, visualisez les tendances et exportez les données utiles depuis votre espace.</p></article>
      <article class="feature-card reveal"><div class="feature-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 11-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09a1.65 1.65 0 00-1-1.51 1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 11-2.83-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09a1.65 1.65 0 001.51-1 1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 112.83-2.83l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 112.83 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg></div><h3>Configuration flexible</h3><p>Personnalisez les candidats, les dates, les règles, le prix des voix et la visibilité des résultats.</p></article>
      <article class="feature-card reveal"><div class="feature-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/></svg></div><h3>Assistance continue</h3><p>Un accompagnement intégré aide organisateurs et participants à progresser facilement à chaque étape.</p></article>
    </div>
  </div>
</section>

<section class="process" id="fonctionnement">
  <div class="wrap">
    <div class="section-head center reveal"><span class="kicker">Fonctionnement</span><h2>Deux parcours, une même expérience fluide</h2><p>Choisissez le modèle adapté à votre besoin. Online‑Vote orchestre ensuite le parcours de bout en bout.</p></div>
    <div class="path-tabs" role="tablist" aria-label="Types de scrutin"><button class="tab-btn active" data-tab="gratuit" role="tab" aria-selected="true">Vote gratuit</button><button class="tab-btn" data-tab="payant" role="tab" aria-selected="false">Vote payant</button></div>
    <div class="path-panel active" id="gratuit" role="tabpanel">
      <div class="path-intro"><span class="path-chip">Élections & sondages</span><h3>Un vote vérifié, rapide et accessible</h3><p>Idéal pour les associations, écoles, entreprises et organisations qui souhaitent consulter ou élire leur communauté.</p><div class="path-benefit"><span>✓</span><span>Une seule participation autorisée par votant selon les règles définies.</span></div></div>
      <div class="step-box"><div class="step-list"><div class="step"><div class="step-num">1</div><div><h4>Accès au scrutin</h4><p>Le participant ouvre le lien sécurisé depuis son téléphone ou son ordinateur.</p></div></div><div class="step"><div class="step-num">2</div><div><h4>Vérification OTP</h4><p>Un code unique confirme son identité ou son droit de participation.</p></div></div><div class="step"><div class="step-num">3</div><div><h4>Sélection du candidat</h4><p>Le choix est effectué dans une interface claire et adaptée au mobile.</p></div></div><div class="step"><div class="step-num">4</div><div><h4>Enregistrement du bulletin</h4><p>Le vote est validé et ajouté aux résultats selon les paramètres du scrutin.</p></div></div></div></div>
    </div>
    <div class="path-panel" id="payant" role="tabpanel">
      <div class="path-intro"><span class="path-chip paid">Concours & événements</span><h3>Transformez l’engagement en participation mesurable</h3><p>Le votant soutient son candidat grâce à un paiement Mobile Money intégré, sans créer de compte complexe.</p><div class="path-benefit"><span>✓</span><span>Chaque transaction confirmée déclenche automatiquement l’attribution des voix.</span></div></div>
      <div class="step-box"><div class="step-list"><div class="step"><div class="step-num">1</div><div><h4>Choix du candidat</h4><p>Le participant sélectionne la personne ou le projet qu’il souhaite soutenir.</p></div></div><div class="step"><div class="step-num">2</div><div><h4>Nombre de voix</h4><p>Il choisit la quantité souhaitée selon le prix défini par l’organisateur.</p></div></div><div class="step"><div class="step-num">3</div><div><h4>Paiement Mobile Money</h4><p>La transaction est initiée avec Orange Money ou MTN MoMo.</p></div></div><div class="step"><div class="step-num">4</div><div><h4>Mise à jour automatique</h4><p>Après confirmation, le compteur du candidat est actualisé immédiatement.</p></div></div></div></div>
    </div>
  </div>
</section>

<section class="payments" id="paiement"><div class="wrap"><div class="payment-panel reveal"><div><span class="kicker">Paiements locaux</span><h2>Conçu pour les habitudes numériques camerounaises</h2><p>Pas besoin de carte bancaire. Les participants utilisent les moyens de paiement qu’ils connaissent déjà, directement depuis leur téléphone.</p></div><div class="payment-logos"><div class="payment-pill"><span class="network-dot orange">O</span>Orange Money</div><div class="payment-pill"><span class="network-dot mtn">M</span>MTN MoMo</div></div></div></div></section>

<section><div class="wrap"><div class="section-head center reveal"><span class="kicker">Cas d’usage</span><h2>Une solution adaptée à vos événements</h2><p>Online‑Vote accompagne aussi bien les consultations internes que les concours ouverts au grand public.</p></div><div class="use-cases-grid"><article class="case reveal"><div class="case-number">01</div><h3>Élections associatives</h3><p>Élisez un bureau, un représentant ou un comité dans un cadre structuré et transparent.</p></article><article class="case reveal"><div class="case-number">02</div><h3>Concours culturels</h3><p>Valorisez les candidats, mobilisez leurs communautés et gérez les votes payants.</p></article><article class="case reveal"><div class="case-number">03</div><h3>Sondages privés</h3><p>Collectez rapidement l’avis d’une équipe, d’une promotion ou d’une communauté ciblée.</p></article></div></div></section>

<section class="testimonial"><div class="wrap quote reveal"><span class="kicker">Notre engagement</span><blockquote>Une seule plateforme pour la simplicité d'un parcours mobile, la flexibilité du vote hybride et l'intégration des paiements locaux.</blockquote></div></section>

<section id="faq"><div class="wrap"><div class="section-head center reveal"><span class="kicker">Questions fréquentes</span><h2>Les réponses essentielles avant de commencer</h2></div><div class="faq-list">
  <div class="faq-item"><button class="faq-question" aria-expanded="false">Puis-je voter sans créer de compte ?<span class="plus">+</span></button><div class="faq-answer"><div><p>Oui. Pour un concours payant, le participant peut voter directement à l’aide de son numéro Mobile Money. Pour un scrutin gratuit, une vérification OTP peut être demandée selon les règles choisies.</p></div></div></div>
  <div class="faq-item"><button class="faq-question" aria-expanded="false">Comment limiter les votes multiples ?<span class="plus">+</span></button><div class="faq-answer"><div><p>La plateforme peut combiner plusieurs contrôles, notamment l’OTP, la session de navigation et les règles d’unicité configurées par l’organisateur.</p></div></div></div>
  <div class="faq-item"><button class="faq-question" aria-expanded="false">Quels moyens de paiement sont disponibles ?<span class="plus">+</span></button><div class="faq-answer"><div><p>Online‑Vote prend en charge Orange Money et MTN MoMo pour les parcours payants destinés au marché camerounais.</p></div></div></div>
  <div class="faq-item"><button class="faq-question" aria-expanded="false">Puis-je suivre les résultats en direct ?<span class="plus">+</span></button><div class="faq-answer"><div><p>Oui. L’organisateur dispose d’un tableau de bord pour suivre l’évolution des votes. La visibilité publique des résultats dépend des paramètres du scrutin.</p></div></div></div>
</div></div></section>

<section class="final"><div class="wrap"><div class="final-card reveal"><h2>Votre prochain scrutin peut être prêt aujourd’hui.</h2><p>Créez votre espace, configurez vos candidats et partagez le lien de vote avec votre communauté.</p><div class="final-actions"><a href="admin/dash" class="btn btn-light">Créer un scrutin gratuitement</a><a href="concours" class="btn btn-ghost-light">Voir les concours</a></div></div></div></section>
</main>

<footer><div class="wrap"><div class="footer-grid"><div class="footer-brand"><a href="#" class="logo"><span class="logo-mark"></span>Online‑Vote</a><p>Une plateforme de vote électronique conçue pour simplifier les élections, sondages et concours en ligne.</p></div><div class="footer-col"><h4>Plateforme</h4><ul><li><a href="#fonctionnalites">Fonctionnalités</a></li><li><a href="#fonctionnement">Fonctionnement</a></li><li><a href="https://online-vote.com/concours.php">Concours</a></li></ul></div><div class="footer-col"><h4>Compte</h4><ul><li><a href="https://online-vote.com/login">Connexion</a></li><li><a href="https://online-vote.com/signup.php">Créer un scrutin</a></li><li><a href="#faq">Centre d’aide</a></li></ul></div><div class="footer-col"><h4>Contact</h4><ul><li>Yaoundé, Cameroun</li><li><a href="tel:+237650082325">+237 650 082 325</a></li><li><a href="mailto:contact@online-vote.com">contact@online-vote.com</a></li></ul></div></div><div class="footer-bottom"><span>© 2026 Online‑Vote. Tous droits réservés.</span><div class="footer-links"><a href="#">Mentions légales</a><a href="#">Confidentialité</a><a href="#">CGU</a></div></div></div></footer>

<script>
const menuButton=document.querySelector('.menu-toggle');
const mobileMenu=document.getElementById('mobileMenu');
menuButton.addEventListener('click',()=>{const open=mobileMenu.classList.toggle('open');menuButton.setAttribute('aria-expanded',String(open));document.body.classList.toggle('menu-open',open)});
mobileMenu.querySelectorAll('a').forEach(a=>a.addEventListener('click',()=>{mobileMenu.classList.remove('open');menuButton.setAttribute('aria-expanded','false');document.body.classList.remove('menu-open')}));

document.querySelectorAll('.tab-btn').forEach(btn=>btn.addEventListener('click',()=>{document.querySelectorAll('.tab-btn').forEach(b=>{b.classList.remove('active');b.setAttribute('aria-selected','false')});document.querySelectorAll('.path-panel').forEach(p=>p.classList.remove('active'));btn.classList.add('active');btn.setAttribute('aria-selected','true');document.getElementById(btn.dataset.tab).classList.add('active')}));

document.querySelectorAll('.faq-question').forEach(button=>button.addEventListener('click',()=>{const item=button.closest('.faq-item');const wasOpen=item.classList.contains('open');document.querySelectorAll('.faq-item').forEach(i=>{i.classList.remove('open');i.querySelector('.faq-question').setAttribute('aria-expanded','false')});if(!wasOpen){item.classList.add('open');button.setAttribute('aria-expanded','true')}}));

const observer=new IntersectionObserver(entries=>entries.forEach(entry=>{if(entry.isIntersecting){entry.target.classList.add('visible');observer.unobserve(entry.target)}}),{threshold:.12});
document.querySelectorAll('.reveal').forEach(el=>observer.observe(el));
</script>
</body>
</html>
