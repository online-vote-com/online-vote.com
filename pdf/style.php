<style>
:root {
    --primary: #9C04DA;
    --primary-dark: #530274;
    --accent: #FFEB3B;

    --bg: #ffffff;
    --text: #1a1a1a;
    --muted: #6b6b6b;
    --border: #e9e9e9;
    --soft: #f7f7f7;
}

/* ================= PRINT ================= */
@page {
    margin: 30px 25px;
}

body {
    font-family: "Segoe UI", Roboto, Arial, sans-serif;
    font-size: 12px;
    color: var(--text);
    background: var(--bg);
    line-height: 1.5;
}

/* ================= HEADER ================= */
.header {
    text-align: center;
    padding-bottom: 12px;
    margin-bottom: 18px;
    border-bottom: 1px solid var(--border);
}

.logo {
    font-size: 20px;
    font-weight: 800;
    letter-spacing: 0.5px;
    color: var(--primary);
}

/* ================= HERO ================= */
.hero {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: #fff;
    padding: 18px;
    border-radius: 14px;
    margin-bottom: 18px;
}

.hero h1 {
    margin: 0;
    font-size: 17px;
    font-weight: 800;
}

.hero p {
    margin-top: 6px;
    font-size: 11px;
    opacity: 0.9;
}

/* ================= KPI ================= */
.grid {
    display: table;
    width: 100%;
    table-layout: fixed;
    margin: 18px 0;
    border-spacing: 10px;
}

.card {
    display: table-cell;
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 14px;
    vertical-align: top;
    position: relative;
}

/* KPI NUMBER */
.card h2 {
    margin: 0;
    font-size: 22px;
    font-weight: 800;
    color: var(--primary);
}

/* LABEL */
.card p {
    margin: 4px 0 0;
    font-size: 10px;
    color: var(--muted);
}

/* ACCENT BAR */
.card::after {
    content: "";
    position: absolute;
    bottom: 10px;
    left: 14px;
    width: 28px;
    height: 3px;
    background: var(--accent);
    border-radius: 20px;
}

/* ================= TABLE ================= */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 16px;
}

th {
    text-align: left;
    font-size: 10px;
    text-transform: uppercase;
    color: var(--muted);
    padding: 10px 8px;
    border-bottom: 1px solid var(--border);
    letter-spacing: 0.4px;
}

td {
    padding: 10px 8px;
    font-size: 11px;
    border-bottom: 1px solid #f3f3f3;
}

/* ROW HOVER (utile si preview écran) */
tr:hover td {
    background: var(--soft);
}

/* TOP RANKING STYLE */
tr:nth-child(1) td {
    font-weight: 800;
    color: var(--primary);
}

tr:nth-child(2) td {
    font-weight: 700;
}

tr:nth-child(3) td {
    font-weight: 600;
}

/* ================= FOOTER ================= */
.footer {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    text-align: center;
    font-size: 9px;
    color: var(--muted);
    border-top: 1px solid var(--border);
    padding: 6px 0;
    background: #fff;
}
</style>