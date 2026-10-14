<?php
// Security headers for the existing single-file UI. Inline scripts remain enabled for compatibility.
error_reporting(0);
ini_set('display_errors', '0');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('Referrer-Policy: strict-origin-when-cross-origin');
header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com data:; img-src 'self' data: blob:; connect-src 'self'; object-src 'none'; base-uri 'self'; form-action 'self'; frame-ancestors 'self'");
if (!empty($_SERVER['HTTPS']) && strtolower((string)$_SERVER['HTTPS']) !== 'off') header('Strict-Transport-Security: max-age=15552000');
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"><title>Universal AI Costing Builder</title>
<style>
:root{--bg:#f6f7f9;--pn:#fff;--tx:#1c2430;--mu:#66707e;--ln:#dde1e7;--ac:#1f5f8b;--ac2:#e8f0f6;--wa:#b45309;box-sizing:border-box;padding-top:env(safe-area-inset-top,0px);padding-bottom:env(safe-area-inset-bottom,0px)}
@media (prefers-color-scheme:dark){:root:not([data-theme="light"]){--bg:#14181d;--pn:#1c222a;--tx:#e6e9ee;--mu:#98a2b0;--ln:#2e3742;--ac:#6fb1dd;--ac2:#22303c;--wa:#f0a64a}}
:root[data-theme="dark"]{--bg:#14181d;--pn:#1c222a;--tx:#e6e9ee;--mu:#98a2b0;--ln:#2e3742;--ac:#6fb1dd;--ac2:#22303c;--wa:#f0a64a}
html{scroll-padding-top:env(safe-area-inset-top,0px)}
*{box-sizing:border-box}body{margin:0;background:var(--bg);color:var(--tx);font:14px/1.45 "IBM Plex Sans",system-ui,-apple-system,"Segoe UI",sans-serif}
header{position:sticky;top:env(safe-area-inset-top,0px);background:var(--pn);border-bottom:1px solid var(--ln);z-index:5;padding:8px 14px}
header b{font-size:15px}nav{display:flex;gap:4px;overflow-x:auto;margin-top:6px}
nav button{white-space:nowrap;background:none;border:0;padding:6px 10px;border-radius:6px;color:var(--mu);font:inherit;cursor:pointer}
nav button.on{background:var(--ac2);color:var(--ac);font-weight:600}
main{max-width:1000px;margin:0 auto;padding:16px 14px 60px}
h2{margin:4px 0 8px;font-size:20px}h3{margin:18px 0 6px;font-size:15px}
.mu{color:var(--mu)}.pn{background:var(--pn);border:1px solid var(--ln);border-radius:8px;padding:12px;margin:10px 0}
.g{display:grid;grid-template-columns:repeat(auto-fit,minmax(130px,1fr));gap:10px}
label{display:block;font-size:12px;color:var(--mu)}
input,select,textarea,button{font:inherit;color:inherit}
input,select,textarea{width:100%;padding:6px 8px;border:1px solid var(--ln);border-radius:6px;background:var(--bg)}
input[type=checkbox]{width:auto}
button{padding:6px 12px;border:1px solid var(--ln);border-radius:6px;background:var(--pn);cursor:pointer}
button.pri{background:var(--ac);border-color:var(--ac);color:#fff}button:disabled{opacity:.5;cursor:not-allowed}
button.x{padding:2px 8px}.row{display:flex;gap:8px;flex-wrap:wrap;align-items:center;margin:8px 0}
.tw{overflow-x:auto}table{border-collapse:collapse;width:100%;min-width:560px}
th,td{text-align:left;padding:5px 6px;border-bottom:1px solid var(--ln);vertical-align:middle}th{font-size:12px;color:var(--mu);font-weight:600}
td input,td select{min-width:70px}.r{text-align:right}.tot td{font-weight:700}
.warn{color:var(--wa)}.big{font-size:22px;font-weight:700}
.steps{display:flex;gap:6px;flex-wrap:wrap;color:var(--mu)}
#toast{position:fixed;left:50%;transform:translateX(-50%);bottom:calc(20px + env(safe-area-inset-bottom,0px));background:var(--tx);color:var(--bg);padding:8px 14px;border-radius:6px;display:none}
@media print{header,.row,.noprint{display:none!important}}
.ov{position:fixed;inset:0;background:rgba(0,0,0,.4);display:flex;align-items:center;justify-content:center;z-index:9}.ov .pn{max-width:320px;margin:0}

:root{--bg:#f2f4f8;--pn:#fff;--tx:#152033;--mu:#637188;--ln:#e2e7ee;--ac:#0f5c7a;--ac2:#e5f0f5;--g:#b08d57;--sb:#0e1b2c}
body{font-family:"Inter","IBM Plex Sans",system-ui,-apple-system,"Segoe UI",sans-serif}
header{background:var(--sb);color:#e8edf3;border-bottom:0;padding:12px 16px}
header b{font:600 18px "Source Serif 4",Georgia,serif;color:#fff}
header .mu{color:#93a4b8}header .x{background:transparent;color:#cdd6e2;border-color:rgba(255,255,255,.22)}
nav button{color:#a9b6c7;border-radius:8px}nav button:hover{background:rgba(255,255,255,.06);color:#fff}
nav button.on{background:rgba(255,255,255,.1);color:#fff;box-shadow:inset 3px 0 0 var(--g)}
.pn{border-radius:12px;box-shadow:0 1px 2px rgba(14,27,44,.05),0 6px 20px rgba(14,27,44,.04)}
h2{font:600 24px "Source Serif 4",Georgia,serif;letter-spacing:-.01em}.big{font-family:"Source Serif 4",Georgia,serif}
button{border-radius:8px}button:hover:not(:disabled){border-color:var(--ac)}button.pri:hover:not(:disabled){filter:brightness(1.12)}
input,select,textarea{border-radius:8px}input:focus,select:focus,textarea:focus{outline:2px solid var(--ac);outline-offset:-1px;border-color:var(--ac)}
th{background:var(--ac2);color:var(--ac)}tr:hover td{background:rgba(15,92,122,.04)}
body.auth{display:block}body.auth header{display:none}body.auth main{max-width:none;padding:0}
.au{display:grid;grid-template-columns:1.05fr 1fr;min-height:100vh}
.au .l{background:var(--sb);color:#e8edf3;padding:56px;display:flex;flex-direction:column;justify-content:space-between;border-right:3px solid var(--g)}
.au .bd{font:600 22px "Source Serif 4",Georgia,serif;color:#fff}.au .hl{font:600 34px/1.2 "Source Serif 4",Georgia,serif;color:#fff;max-width:420px}
.au .l p{color:#aab7c8;max-width:400px}.au .sm{color:#8798ad;font-size:12px}
.au .r{display:flex;align-items:center;justify-content:center;padding:32px}.au .f{width:100%;max-width:380px}.au .f h2{margin-bottom:6px}
.au .f label{margin-top:12px}.au .f .row{margin-top:18px}.au .f button.pri{width:100%;padding:10px}
@media(max-width:800px){.au{grid-template-columns:1fr}.au .l{display:none}}
@media(min-width:900px){body:not(.auth){display:grid;grid-template-columns:250px minmax(0,1fr);align-items:start}
body:not(.auth) header{position:sticky;top:0;height:100vh;display:flex;flex-direction:column;padding:24px 14px}
body:not(.auth) nav{flex-direction:column;overflow:visible;margin-top:24px;order:2}body:not(.auth) nav button{text-align:left;padding:9px 12px}
body:not(.auth) #who{order:3;float:none;margin-top:auto;font-size:12px}body:not(.auth) main{max-width:1080px;width:100%;margin:0;padding:32px 36px 70px}}
.pvo{align-items:flex-start;overflow:auto;padding:16px}.pvw{width:100%;max-width:820px;margin:auto}
.pvp{background:#fff;color:#152033;box-shadow:0 10px 40px rgba(0,0,0,.3);font-size:13px;min-height:560px;display:flex;flex-direction:column;text-align:left}
.pvh{display:flex;justify-content:space-between;align-items:flex-start;padding:26px 30px;color:#fff}.pvn{font:600 24px "Source Serif 4",Georgia,serif}.pvt{font-size:12px;opacity:.8}
.pvbd{padding:26px 30px;flex:1}.pvr{display:flex;justify-content:space-between;margin-bottom:14px}.pvs{border-top:1px solid #e2e7ee;padding-top:14px;gap:12px;justify-content:flex-start}.pvs>div{min-width:140px}
.pvp small{display:block;font-size:10px;font-weight:700;color:#6e7682;letter-spacing:.04em}.pvb{font:600 17px "Source Serif 4",Georgia,serif}
.pvl{columns:2;margin:8px 0 18px;padding-left:18px}.pvl li::marker{color:#b08d57}
.pvbox{display:flex;justify-content:space-between;background:#f4f6f8;padding:18px 22px;margin:14px 0 22px}
.pvtb{width:100%;min-width:0;font-size:12px}.pvtb th,.pvtb td{padding:6px 8px;border:0;background:none;color:inherit}.pvtb tr:nth-child(even) td{background:#f6f7f9}
.pvsum{margin:14px 0 0 auto;width:min(340px,100%)}.pvsum div{display:flex;justify-content:space-between;padding:4px 0}.pvsum .pvtot{color:#fff;padding:8px 10px;margin:6px 0}
.pvf{display:flex;justify-content:space-between;padding:12px 30px;border-top:1px solid #e2e7ee;font-size:11px;color:#6e7682}

.q-tabs-panel{padding:8px 10px;margin-top:10px}.q-proposal-tabs{display:flex;gap:7px;flex-wrap:wrap}.q-tab{border:1px solid var(--ln);background:var(--pn);padding:7px 11px;border-radius:8px;font-weight:600;color:var(--mu)}.q-tab span{display:inline-block;min-width:20px;margin-left:4px;padding:1px 6px;border-radius:999px;background:var(--ac2);color:var(--ac);font-size:11px}.q-tab.on{background:var(--ac);border-color:var(--ac);color:#fff}.q-tab.on span{background:rgba(255,255,255,.18);color:#fff}.q-proposal-list th:last-child{min-width:430px}.q-actions{white-space:normal;min-width:430px}.q-actions button{margin:2px 3px 2px 0}.q-status-edit{min-width:125px;width:auto;padding:5px 8px}.q-action-edit{font-weight:700}.q-proposal-list td{vertical-align:top}
.q-summary-input{width:100%;min-width:100px;box-sizing:border-box}.q-product-input{min-width:150px}.q-summary-qty{width:70px}.qv-editor{min-width:190px}.qv-editor select,.qv-editor input{width:100%;box-sizing:border-box;margin-bottom:4px}.qv-result{font-size:11px;color:#64748b}.q-summary-backend th,.q-summary-backend td{vertical-align:middle}.q-summary-backend .danger{color:#b91c1c;border-color:#fecaca;background:#fff}.q-summary-total td{font-weight:700}

.invoice-brand{display:grid;grid-template-columns:110px 1fr 190px;align-items:center;gap:14px;padding:14px 18px;margin-bottom:14px;border-radius:12px;background:#fff;border:1px solid #dfe5ec;border-top:5px solid var(--accent,#1f5f86);box-shadow:0 2px 10px rgba(20,40,60,.06)}
.invoice-brand-logo{display:flex;align-items:center;justify-content:center;min-height:58px;border-right:1px solid #e1e6eb;padding-right:12px}.invoice-brand-name{font-size:21px;font-weight:800;color:#163b57}.invoice-brand-tag{font-size:12px;color:#6a7886;margin-top:3px}.invoice-brand-contact{font-size:11px;color:#3e4d5c;margin-top:5px}.invoice-brand-title{text-align:right;font-size:22px;font-weight:800;letter-spacing:.8px;color:#163b57}
.tax-invoice-editor-brand{display:grid;grid-template-columns:100px 1fr 160px;align-items:center;gap:12px;padding:12px 14px;background:#f5f8fb;border-left:5px solid var(--accent,#1f5f86);margin-bottom:14px}.tax-invoice-editor-brand img{max-width:84px;max-height:50px;object-fit:contain}.tax-invoice-editor-brand .name{font-size:18px;font-weight:800;color:#163b57}.tax-invoice-editor-brand .title{text-align:right;font-size:18px;font-weight:800;color:#163b57}

@media(max-width:800px){
  body:not(.auth) main{padding:18px 10px 60px}
  .g{grid-template-columns:1fr}
  .pn{padding:10px}
  h2{font-size:21px}
  .au .r{padding:18px}
  table{min-width:720px}
  .invoice-brand{grid-template-columns:72px 1fr;padding:10px}
  .invoice-brand-title{font-size:17px}
  .invoice-brand-logo{min-height:45px}
}
.q-amount-words{margin-top:10px;padding:8px 10px;border:1px solid #dfe5ec;background:#f8fafc;font-size:11px}

.spec-grid{grid-template-columns:repeat(auto-fit,minmax(155px,1fr));align-items:end}.spec-grid .row{gap:6px}.spec-grid .row input{flex:1}.spec-grid select{min-height:34px}

.door-accordion{border:1px solid var(--ln);border-radius:10px;margin:10px 0;overflow:hidden;background:var(--pn)}
.door-accordion-head{width:100%;display:flex;justify-content:space-between;align-items:center;text-align:left;padding:12px 14px;border:0;border-radius:0;background:var(--pn);font-size:14px}
.door-accordion-head:hover{background:var(--ac2)}
.door-accordion-body{padding:12px 14px;border-top:1px solid var(--ln)}
.door-accordion.closed .door-accordion-body{display:none}
.door-source-card{display:flex;justify-content:space-between;align-items:center;gap:12px;padding:10px 12px;margin-top:10px;border:1px solid var(--ln);border-radius:8px;background:var(--bg)}
.door-source-empty{padding:10px;margin-top:10px;border:1px dashed var(--ln);border-radius:8px}
.door-total-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:10px}
.door-total-grid>div{padding:12px;border:1px solid var(--ln);border-radius:8px;background:var(--bg)}
.door-total-grid label{margin-bottom:4px}.door-total-grid b{display:block}
@media(max-width:800px){.door-total-grid{grid-template-columns:1fr 1fr}}
</style><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Source+Serif+4:wght@600&display=swap"><script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script><style id="quotation-preview-fix">.ov.pvo{background:rgba(15,23,42,.78)!important;z-index:9999!important;overflow:auto!important;padding:18px!important;align-items:flex-start!important}.ov.pvo .q-wrap{width:100%;max-width:210mm;margin:0 auto;background:#fff}.ov.pvo .q-page{width:100%;max-width:210mm;min-height:297mm;margin:0 auto 18px;background:#fff;box-shadow:0 8px 35px rgba(0,0,0,.25)}@media(max-width:900px){.ov.pvo .q-page{min-height:auto;padding-top:38mm}.ov.pvo .q-summary{width:55%}}</style>
<style id="quotation-backend-ui">
.q-backend-title{background:#193b57;color:#fff;border-radius:14px;padding:18px 22px;margin-bottom:18px}
.q-backend-title h2{font-size:25px;letter-spacing:.5px}
.q-backend-sub{font-size:14px;opacity:.82;margin-top:3px}
.q-backend-section{color:#193b57;font-size:21px;margin:0 0 12px;padding-bottom:9px;border-bottom:2px solid #d9e2ea}
.q-summary-backend th{background:#e7eff4!important;color:#193b57!important}
.q-summary-backend td,.q-summary-backend th{vertical-align:middle}
.q-summary-total td{background:#edf4f8!important;font-weight:700}
.q-detail-section-title{margin:28px 0 12px}
.q-detail-card{scroll-margin-top:18px}
.q-tg{padding:2px 9px;margin-right:10px;font-size:12px;line-height:1.4}.q-collapsed .q-detail-body{display:none}.q-collapsed .q-detail-head{margin-bottom:0}.q-detail-head{display:flex;justify-content:space-between;align-items:center;background:#edf4f8;border-radius:9px;padding:11px 14px;margin-bottom:12px}
.q-detail-head>div:first-child{display:flex;align-items:center;gap:10px}
.q-detail-no{width:28px;height:28px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;background:#193b57;color:#fff;font-weight:700}
.q-detail-price{display:flex;align-items:center;gap:10px;color:#526579}
.q-detail-price b{font-size:18px;color:#193b57}
.q-detail-price span:first-child{font-size:12px;text-transform:uppercase}
.q-detail-meta{margin-bottom:6px}
.q-detail-description{min-width:240px;line-height:1.45}
.q-detail-total-row td{background:#edf4f8!important}
@media(max-width:800px){
 .q-detail-head{align-items:flex-start;gap:10px;flex-direction:column}
 .q-detail-price{width:100%;justify-content:flex-end}
 .q-detail-description{min-width:180px}
}
.cost-bom{padding:0!important;overflow:hidden}.cost-bom summary{cursor:pointer;list-style:none;padding:12px 14px;font-weight:600}.cost-bom summary::-webkit-details-marker{display:none}.cost-bom summary:before{content:'▶';display:inline-block;margin-right:7px;font-size:10px}.cost-bom[open] summary:before{content:'▼'}.cost-bom .tw{margin-top:0;border-top:1px solid var(--bd)}

.q-loss-row td{background:#fff0f0!important;color:#a40000}.q-loss-row td:nth-child(6),.q-loss-row td:nth-child(7){font-weight:700;color:#b00020}.q-more-menu button{display:block;width:150px;text-align:left;border:0;background:#fff;padding:7px 9px}.q-more-menu button:hover{background:#f1f5f9}
</style>
</head><body>
<header><b id="brand">Costing Builder</b><span id="who" class="noprint" style="float:right"></span><nav id="nav"></nav></header><main id="main"></main><div id="toast"></div>
<script>
const K='ucb1',CATS=['Material','Hardware','Labour','Electricity','Packaging','Transport','Other'];
const M={qty:'Qty × Price',area:'Area (sq ft) × Price',rft:'Running ft × Price',rm:'Running m × Price',kg:'Kg × Price',fixed:'Fixed cost',pct:'% of subtotal'};
const NAV=[['dash','Dashboard'],['shutter','Shutter Costing'],['frame','Frame Costing'],['door','Cost to Company'],['quote','Quotation'],['invoice','Tax Invoice'],['crm','CRM'],['master','Master Data'],['hist','History'],['set','Settings']];
const esc=s=>String(s??'').replace(/[&<>"]/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]));
const today=()=>new Date().toISOString().slice(0,10),$=s=>document.querySelector(s);
const clone=x=>JSON.parse(JSON.stringify(x));
const fmt=n=>(db.cur||'₹')+(+n||0).toLocaleString('en-IN',{minimumFractionDigits:2,maximumFractionDigits:2});
const mat=id=>db.materials.find(m=>m.id==id);
const opts=(a,sel,v=x=>x.id,l=x=>x.name)=>`<option value=""${sel===''?' selected':''}>None</option>`+a.map(x=>`<option value="${esc(v(x))}"${v(x)==sel?' selected':''}>${esc(l(x))}</option>`).join('');
const CO0={name:'Your Company',tag:'',contact:'',color:'#1f3a4d',terms:'',footerName:'',footerMobile:'',footerEmail:'',logo:''};
let db=seed(),cu=null,ready=false,st=null,lastJ='',AS='load',SU={},UL=[],LH=[],CSRF='';
let page='dash',S={shutter:null,frame:null},D=null,ai=null,mtab='materials',mEdit=null,DL=null;
let histPg=1, crmFilters={q:'',status:'',owner:''};
let qSelectedCostings=[];
let qTab='recent';

function save(){if(!cu||!ready)return;clearTimeout(st);st=setTimeout(push,500)}
async function push(){const d={...db};delete d.users;delete d.logins;const j=JSON.stringify(d);if(j==lastJ)return;const r=await api('save',{data:d});if(r.error)toast(r.error);else lastJ=j}
async function api(a,b){
 try{
  const payload={...(b||{})};
  if(CSRF && !['me','setup_start','setup_verify','login'].includes(a))payload.csrf=CSRF;
  const r=await fetch('api.php?a='+encodeURIComponent(a),{method:'POST',headers:{'Content-Type':'application/json'},credentials:'same-origin',body:JSON.stringify(payload)});
  const j=await r.json(); if(j.csrf)CSRF=j.csrf; return j;
 }catch(e){return{error:'Cannot reach the server'}}
}
function log(a){db.audit.unshift({ts:new Date().toLocaleString(),a:(cu?cu.name+': ':'')+a});db.audit=db.audit.slice(0,30)}
let tt=null;function toast(t,ms=2200){const e=$('#toast');e.textContent=t;e.style.display='block';clearTimeout(tt);tt=setTimeout(()=>e.style.display='none',ms)}
function seed(){
 const mt=[['Ply','Material','sq ft',5],['Laminate','Material','sq ft',5],['Core Material','Material','sq ft',3],['Base Ply','Material','rft',5],['Base Laminate','Material','rft',5],['Cover Moulding','Material','rft',5],['GI Sheet 1.2 mm','Material','sq ft',3],['Honeycomb Core','Material','sq ft',3],['Fevicol','Material','kg',0],['Nails','Hardware','nos',0],['Hinges','Hardware','nos',0],['Handle','Hardware','nos',0],['Lock','Hardware','nos',0],['Panic Bar','Hardware','nos',0],['Door Closer','Hardware','nos',0],['Other Hardware','Hardware','nos',0],['Labour','Labour','unit',0],['Electricity','Electricity','unit',0],['Packaging','Packaging','unit',0],['Transport','Transport','unit',0],['Other Cost','Other','unit',0]];
 const materials=mt.map((r,i)=>({id:'m'+i,name:r[0],cat:r[1],unit:r[2],price:0,wastage:r[3],supplier:'',active:true,updated:today()}));
 const L=(n,method,qty=1)=>({mid:'m'+mt.findIndex(r=>r[0]==n),method,qty});
 const tail=[L('Labour','fixed'),L('Electricity','fixed'),L('Packaging','fixed'),L('Transport','fixed'),L('Other Cost','fixed')];
 const sh=[L('Ply','area'),L('Laminate','area'),L('Core Material','area'),L('Fevicol','kg',0.1),L('Hinges','qty',3),L('Handle','qty'),L('Lock','qty'),L('Other Hardware','qty'),...tail];
 const fire=[L('GI Sheet 1.2 mm','area'),L('Honeycomb Core','area'),L('Fevicol','kg',0.1),L('Hinges','qty',3),L('Lock','qty'),L('Panic Bar','qty'),L('Door Closer','qty'),...tail];
 const fr=[L('Base Ply','rft'),L('Base Laminate','rft'),L('Cover Moulding','rft'),L('Fevicol','kg',0.05),L('Nails','qty',20),L('Other Hardware','qty'),L('Labour','fixed'),L('Electricity','fixed'),L('Transport','fixed'),L('Other Cost','fixed')];
 const shutterBases=[
  {type:'shutter',name:'Post Forming - Both Side',shutterType:'Post Forming',side:'Both Side',bom:sh},
  {type:'shutter',name:'Post Forming - Single Side',shutterType:'Post Forming',side:'Single Side',bom:sh},
  {type:'shutter',name:'Square - Both Side',shutterType:'Square',side:'Both Side',bom:sh},
  {type:'shutter',name:'Square - Single Side',shutterType:'Square',side:'Single Side',bom:sh},
  {type:'shutter',name:'Edge Banding - Both Side',shutterType:'Edge Banding',side:'Both Side',finishOption:'Laminate + Edge Banding',bom:sh},
  {type:'shutter',name:'Edge Banding - Single Side',shutterType:'Edge Banding',side:'Single Side',finishOption:'Laminate + Edge Banding',bom:sh}
 ];
 const frameBases=[];
 [['Post Forming','Wall to Wall Standard'],['Post Forming','Double Rivet'],['Square Frame','Wall to Wall'],['Square Frame','Double Rivet']].forEach(([ft,sub])=>['25+18','18+12'].forEach(th=>frameBases.push({type:'frame',name:`${ft} - ${sub} - ${th}`,frameType:ft,subCategory:sub,thickness:th,bom:fr})));
 frameBases.push({type:'frame',name:'Standard Frame - As per existing',frameType:'Standard Frame',subCategory:'As per existing',thickness:'As per existing',bom:fr});
 const templates=[...shutterBases,...frameBases].map((t,i)=>({...clone(t),id:'t'+i,active:true}));
 return{fieldOptions:{shutterType:['Post Forming','Square','Edge Banding'],shutterSide:['Both Side','Single Side'],shutterFinish:['Veneer','Laminate + FRP Coating','Laminate + Edge Banding','Add-on: Groove Design','Veneer Polish Costing'],frameType:['Post Forming','Square Frame','Standard Frame'],frameSubCategory:['Standard','Wall to Wall','Single Rivet','Double Rivet'],frameThickness:['25+18','18+12','As per existing'],quotationFields:['Project Name','Delivery Location','Contact Person']},materials,templates,history:[],quotations:[],taxInvoices:[],seq:1,qseq:1,invseq:1,cur:'₹',audit:[],mid:100,tid:100,co:{name:'Your Company',tag:'',contact:'',color:'#1f3a4d',terms:'',footerName:'',footerMobile:'',footerEmail:'',logo:''},pdfT:'quote',users:[],logins:[],termTemplates:[
  {id:'tt1',name:'Standard Commercial',payment:'50% Mobilization Advance against Purchase Order.\n40% payment at the time of delivery.\n10% against final bill.',terms:'Prices are valid for 15 days. GST extra as applicable. Delivery timeline will be confirmed against the purchase order.'},
  {id:'tt2',name:'Short Terms',payment:'50% advance with order. Balance against final bill.',terms:'Prices exclude GST. Quotation valid for 15 days.'}
]}}
function costingSpecsValid(s){
 return true;
}
function costingMissingLabel(s){
 return [];
}
function calc(s){
 const dm=(w,h)=>({sq:w*h/92903.04,rf:(s.type=='frame'?2*h+w:2*(w+h))/304.8}),P=dm(s.w,s.h),rows=[];let sub=0;
 s.lines.forEach(l=>{const m=mat(l.mid)||{name:l.name||'(imported item)',cat:l.cat||'Material',unit:l.unit||'qty',price:+(l.masterPrice||l.price||0),wastage:+(l.wastage||0)};
  const p=(l.price!=null && +l.price>0)?+l.price:m.price,w=l.wastage!=null?+l.wastage:m.wastage,q=+l.qty||0,D=l.size=='own'?dm(+l.w||0,+l.h||0):P;let a=0;
  if(l.method!='pct'){a={qty:q,area:D.sq*q,rft:D.rf*q,rm:D.rf*.3048*q,kg:q,fixed:1}[l.method]*p*(1+w/100);sub+=a}
  rows.push({l,m,p,w,a})});
 rows.forEach(r=>{if(r.l.method=='pct')r.a=sub*r.p/100});
 const valid=costingSpecsValid(s);
 if(!valid) rows.forEach(r=>r.a=0);
 const by={};CATS.forEach(c=>by[c]=0);let waste=0,unit=0;
 rows.forEach(r=>{by[r.m.cat]=(by[r.m.cat]||0)+r.a;unit+=r.a;if(r.l.method!='pct')waste+=r.a-r.a/(1+r.w/100)});
 return{rows,by,unit,total:unit*(+s.qty||0),waste,sq:P.sq,rf:P.rf}}
function lineSqFt(s,l){const w=l.size==='own'?+l.w||0:+s.w||0,h=l.size==='own'?+l.h||0:+s.h||0;return w*h/92903.04}
function startCost(type,tid,keep){
 const t=db.templates.find(x=>x.id==tid),o=S[type];
 S[type]={type,tid,terms:keep&&o.terms!=null?o.terms:(db.co.terms||''),customer:keep?o.customer:'',w:keep&&o.w?o.w:1050,h:keep&&o.h?o.h:(type=='frame'?2100:2400),t:keep&&o.t!=null?o.t:(t.thickness||(type==='frame'?((db.fieldOptions?.frameThickness||['25+18'])[0]||''):'')),qty:keep&&o.qty?o.qty:1,sell:keep&&o.sell!=null?o.sell:'',method:keep&&o.method?o.method:'Manual',rid:keep&&o.rid?o.rid:null,costingName:keep&&o.costingName?o.costingName:'',lines:clone(t.bom),frameType:t.frameType||(type==='frame'?(db.fieldOptions?.frameType||['Post Forming'])[0]||'':''),subCategory:t.subCategory||(type==='frame'?(db.fieldOptions?.frameSubCategory||['Wall to Wall Standard'])[0]||'':''),side:t.side||(type==='shutter'?(db.fieldOptions?.shutterSide||['Both Side'])[0]||'':''),shutterType:t.shutterType||(type==='shutter'?(db.fieldOptions?.shutterType||['Post Forming'])[0]||'':''),finishOption:t.finishOption||(type==='shutter'?(db.fieldOptions?.shutterFinish||['Veneer'])[0]||'':'')} }
function templateLabel(t){
 const bits=[t.type==='shutter'?'Shutter':'Frame',t.name||'Unnamed template'];
 const meta=t.type==='shutter'?[t.shutterType,t.side,t.finishOption]:[t.frameType,t.subCategory,t.thickness];
 meta.filter(Boolean).forEach(v=>{if(!bits.includes(v))bits.push(v)});
 return bits.join(' · ');
}
function activeTemplates(type){return (db.templates||[]).filter(t=>t.type===type&&t.active!==false)}
function uniqueMeta(type,key,fallback=[]){
 const a=activeTemplates(type).map(t=>String(t[key]||'').trim()).filter(Boolean);
 return [...new Set([...fallback,...a])];
}
function selectMasterTemplate(type,id){
 const s=S[type];
 if(!s)return;
 if(!id){s.tid='';render();return;}
 const t=db.templates.find(x=>x.id===id&&x.type===type&&x.active!==false);
 if(!t)return;
 startCost(type,t.id,1);render();
}
function costView(type){
 const ts=activeTemplates(type);
 if(!S[type]&&ts[0])startCost(type,ts[0].id);
 const s=S[type];if(!s)return'<p>No active templates. Add one in Master Data.</p>';
 const r=calc(s),hasPrice=db.materials.some(m=>m.price>0),sp=+s.sell||0,pr=sp-r.unit;
 const f=(k,lab,t='number')=>`<div><label>${lab}</label><input type="${t}" value="${esc(s[k]??'')}" ${k==='costingName'?'placeholder="e.g. Main Door Shutter - Client Name"':''} onchange="setF('${type}','${k}',this.value)"></div>`;
 const sel=(label,value,options,key)=>`<div><label>${label}</label><select onchange="setCostSpec('${type}','${key}',this.value)"><option value=""${value===''?' selected':''}>None</option>${options.map(v=>`<option value="${esc(v)}"${v===value?' selected':''}>${esc(v)}</option>`).join('')}</select></div>`;
 const templateSel=`<div style="grid-column:1/-1"><label>${type==='shutter'?'Shutter':'Frame'} Master Template</label><select onchange="selectMasterTemplate('${type}',this.value)"><option value="">None</option>${ts.map(t=>`<option value="${esc(t.id)}"${t.id===s.tid?' selected':''}>${esc(templateLabel(t))}</option>`).join('')}</select><div class="mu" style="margin-top:4px">Selecting a template loads its BOM and recalculates prices immediately. Template price overrides are managed in Master Data; blank overrides use current material master prices.</div></div>`;
 let spec='';
 if(type==='frame'){
   const ft=[...(db.fieldOptions?.frameType||['Post Forming','Square Frame','Standard Frame'])];
   const currentFT=s.frameType!==undefined?s.frameType:ft[0];
   const subs=[...(db.fieldOptions?.frameSubCategory||['Standard','Wall to Wall','Single Rivet','Double Rivet'])];
   const ths=[...(db.fieldOptions?.frameThickness||['25+18','18+12','As per existing'])];
   const currentSub=s.subCategory!==undefined?s.subCategory:(subs[0]||'');
   const currentTh=s.t!==undefined&&s.t!==''?s.t:(s.thickness!==undefined?s.thickness:(ths[0]||''));
   spec=`<div class="g spec-grid">${f('customer','Customer Name','text')}${f('costingName','Costing Name','text')}${templateSel}${sel('Type of Frame',currentFT,ft,'frameType')}${sel('Sub-category',currentSub,subs,'subCategory')}${sel('Thickness',currentTh,ths,'thickness')}<div><label>Size (W × H mm)</label><div class="row" style="margin:0"><input type="number" style="min-width:0" value="${esc(s.w)}" placeholder="Width" onchange="setF('${type}','w',this.value)"><span>×</span><input type="number" style="min-width:0" value="${esc(s.h)}" placeholder="Height" onchange="setF('${type}','h',this.value)"></div></div>${f('qty','Quantity')}<div><label>Area / Unit (Sq. Ft.)</label><input value="${r.sq.toFixed(2)}" readonly></div><div><label>Total Area (Sq. Ft.)</label><input value="${(r.sq*(+s.qty||0)).toFixed(2)}" readonly></div></div>`;
 }else{
   const types=[...(db.fieldOptions?.shutterType||['Post Forming','Square','Edge Banding'])];
   const sides=[...(db.fieldOptions?.shutterSide||['Both Side','Single Side'])];
   const finishes=[...(db.fieldOptions?.shutterFinish||['Veneer','Laminate + FRP Coating','Laminate + Edge Banding','Add-on: Groove Design','Veneer Polish Costing'])];
   const currentType=s.shutterType!==undefined?s.shutterType:types[0];
   const currentSide=s.side!==undefined?s.side:(sides[0]||'');
   const currentFinish=s.finishOption!==undefined?s.finishOption:(finishes[0]||'');
   spec=`<div class="g spec-grid">${f('customer','Customer Name','text')}${f('costingName','Costing Name','text')}${templateSel}${sel('Type',currentType,types,'shutterType')}${sel('Side',currentSide,sides,'side')}${sel('Finish / Sub-option',currentFinish,finishes,'finishOption')}<div><label>Size (W × H mm)</label><div class="row" style="margin:0"><input type="number" style="min-width:0" value="${esc(s.w)}" placeholder="Width" onchange="setF('${type}','w',this.value)"><span>×</span><input type="number" style="min-width:0" value="${esc(s.h)}" placeholder="Height" onchange="setF('${type}','h',this.value)"></div></div>${f('t','Thickness (mm)')}${f('qty','Quantity')}<div><label>Area / Unit (Sq. Ft.)</label><input value="${r.sq.toFixed(2)}" readonly></div><div><label>Total Area (Sq. Ft.)</label><input value="${(r.sq*(+s.qty||0)).toFixed(2)}" readonly></div></div>`;
 }
 return`<h2>${type==='shutter'?'Shutter':'Frame'} Costing${s.rid?' · '+s.rid:''}</h2>
 <div class="steps noprint">Select Master Template → ${type==='frame'?'Type of Frame → Sub-category → Thickness → Size':'Type → Side → Finish / Sub-option → Size'} → Enter quantity → Verify BOM → Calculate</div>
 ${hasPrice?'':'<p class="warn">All prices are 0. Set prices in Master Data › Materials.</p>'}
 <div class="pn">${spec}${costingMissingLabel(s).length?`<p class="warn">Complete required fields before calculation: ${esc(costingMissingLabel(s).join(', '))}.</p>`:''}</div>
 <div class="pn cost-bom"><div style="padding:12px 14px;font-weight:600;border-bottom:1px solid var(--bd)"><b>Bill of materials</b> <span class="mu">· ${r.rows.length} components</span></div><div class="tw"><table><tr><th>Component</th><th>Size from</th><th class="r">Sq. Ft.</th><th>Method</th><th>Qty / factor</th><th>Price (blank = master)</th><th class="r">Amount / unit</th><th></th></tr>
 ${r.rows.map((x)=>({x,i:s.lines.indexOf(x.l)})).map(({x,i})=>`<tr><td>${esc(x.m.name)}<div class="mu">${esc(x.m.cat)} · ${esc(x.m.unit||'')}</div></td>${sizeCell(type,i,x.l)}<td class="r">${lineSqFt(s,x.l).toFixed(2)}</td><td><select onchange="setL('${type}',${i},'method',this.value)">${mopts(x.l.method)}</select></td><td><input type="number" step="any" value="${x.l.qty}" onchange="setL('${type}',${i},'qty',this.value)"></td><td><input type="number" step="any" value="${esc(x.l.price!=null&&+x.l.price>0?x.l.price:x.m.price)}" placeholder="${x.m.price}" title="Effective price: template override when set; otherwise Material Master price" onchange="setL('${type}',${i},'price',this.value)"></td><td class="r">${fmt(x.a)}</td><td style="white-space:nowrap"><button class="x" title="Move up" ${i===0?'disabled':''} onclick="moveL('${type}',${i},-1)">↑</button> <button class="x" title="Move down" ${i===s.lines.length-1?'disabled':''} onclick="moveL('${type}',${i},1)">↓</button> <button class="x" onclick="delL('${type}',${i})">✕</button></td></tr>`).join('')}</table></div></div>
 <div class="row noprint"><select onchange="addL('${type}',this.value)" style="max-width:260px"><option value="">+ Add component…</option>${opts(db.materials.filter(m=>m.active),'')}</select><button onclick="startCost('${type}',S['${type}'].tid,1);render()">Reset BOM</button><button type="button" onclick="openPasteCosting('${type}')">Paste / Import Excel or Google Sheet</button></div>
 <div class="pn"><h3 style="margin-top:0">Costing result</h3><div class="tw"><table>${CATS.map(c=>`<tr><td>${c==='Material'?'Raw material':c}</td><td class="r">${fmt(r.by[c])}</td></tr>`).join('')}<tr><td class="mu">of which wastage</td><td class="r mu">${fmt(r.waste)}</td></tr><tr class="tot"><td>Total cost per unit</td><td class="r">${fmt(r.unit)}</td></tr><tr class="tot"><td>Total manufacturing cost (× ${+s.qty||0})</td><td class="r big">${fmt(r.total)}</td></tr></table></div><div class="g" style="margin-top:10px"><div><label>Selling price / unit (optional)</label><input type="number" value="${esc(s.sell)}" onchange="setF('${type}','sell',this.value)"></div><div><label>Profit / unit</label><b>${sp?fmt(pr):'—'}</b></div><div><label>Margin</label><b>${sp?(pr/sp*100).toFixed(1)+'%':'—'}</b></div></div></div>
 <div class="noprint"><label>Terms &amp; conditions (printed on the quotation PDF)</label><textarea rows="3" onchange="setF('${type}','terms',this.value)">${esc(s.terms||'')}</textarea></div>
 <div class="row noprint"><button class="pri" onclick="saveCost('${type}')">Save costing</button>${pdfSel()}<button onclick="pdfView(S['${type}'],S['${type}'].rid)">Preview PDF</button><button onclick="saveCost('${type}',1);pdf(S['${type}'],S['${type}'].rid)">Download PDF</button>${can('tpl')?`<button onclick="setMaster('${type}')">Update master template</button><input id="nt" placeholder="New template name" style="max-width:180px"><button onclick="newFromCost('${type}')">Save as new template</button>`:''}</div>
 <p class="mu noprint">Changes here affect only this costing. Master price and template change only when you use the buttons above or edit Master Data.</p>`}
function pasteCostingTypeLabel(type){return type==='shutter'?'Shutter':'Frame'}
function openPasteCosting(type){
 const s=S[type]||{};
 const o=document.createElement('div');o.className='ov pvo';o.id='pasteCostingModal';
 o.innerHTML=`<div class="pn" style="max-width:1000px;width:100%;margin:0 auto"><h2 style="margin-top:0">Paste / Import ${pasteCostingTypeLabel(type)} Costing</h2><p class="mu">Copy rows directly from Excel or Google Sheets and paste them below. The importer accepts tab-separated data.</p><div class="g"><div><label>Customer / Project</label><input id="pc_customer" value="${esc(s.customer||'')}" placeholder="Customer name"></div><div><label>Costing Name</label><input id="pc_name" value="${esc(s.costingName||'')}" placeholder="e.g. Main Door Shutter"></div><div><label>Width (mm)</label><input id="pc_w" type="number" value="${esc(s.w||'')}" placeholder="Optional"></div><div><label>Height (mm)</label><input id="pc_h" type="number" value="${esc(s.h||'')}" placeholder="Optional"></div><div><label>Thickness (mm)</label><input id="pc_t" type="number" value="${esc(s.t||'')}" placeholder="Optional"></div><div><label>Quantity</label><input id="pc_qty" type="number" value="${esc(s.qty||1)}"></div></div><div class="row" style="margin:10px 0"><button type="button" class="pri" onclick="pasteClipboardIntoCosting()">Paste from Clipboard</button><button type="button" onclick="openCostingSheet()">Open Google Sheet / Excel Web</button></div><textarea id="pc_data" rows="12" style="width:100%;font-family:monospace" placeholder="Component\tDescription\tQty\tUnit\tRate\tAmount\nPly\t30 mm BWP Pinewood\t23.68\tSq.ft\t180\t4262.40\nLaminate\tSide 1\t23.68\tSq.ft\t45\t1065.60"></textarea><div class="row" style="margin-top:12px;justify-content:flex-end"><button type="button" onclick="this.closest('.ov').remove()">Cancel</button><button type="button" class="pri" onclick="importPastedCosting('${type}')">Import into ${pasteCostingTypeLabel(type)} Costing</button></div><p class="mu">Supported columns: Component/Material, Description, Qty, Unit, Rate/Price, Amount/Total, Method, Wastage. Amount is recalculated by the software.</p></div>`;
 document.body.appendChild(o);setTimeout(()=>$('#pc_data')?.focus(),50);
}
async function pasteClipboardIntoCosting(){
 try{const txt=await navigator.clipboard.readText();if(!txt)return toast('Clipboard is empty');const el=$('#pc_data');if(el){el.value=txt;toast('Clipboard data pasted')};}
 catch(e){toast('Clipboard permission blocked. Press Ctrl+V inside the box.')}
}
function openCostingSheet(){
 const url=prompt('Paste your Google Sheet or Excel Online URL');
 if(url){window.open(url,'_blank','noopener');toast('Sheet opened. Copy the costing rows and paste them here.');}
}
function parsePastedCosting(text){
 const rows=String(text||'').replace(/\r/g,'').split('\n').map(x=>x.split('\t').map(v=>v.trim()));
 const non=rows.filter(r=>r.some(v=>v!==''));if(!non.length)return {lines:[],headers:[]};
 const norm=x=>String(x||'').toLowerCase().replace(/[\s_\-\/().]+/g,'');
 const headerWords=['component','material','item','name','description','qty','quantity','unit','rate','price','cost','amount','total','method','wastage','waste'];
 let hi=0, best=-1;non.slice(0,3).forEach((r,i)=>{const score=r.reduce((a,v)=>a+(headerWords.some(w=>norm(v).includes(w))?1:0),0);if(score>best){best=score;hi=i}});
 const hr=non[hi]||[];const h=hr.map(norm);const idx=(names,def)=>{for(const n of names){const i=h.findIndex(x=>x===norm(n)||x.includes(norm(n)));if(i>=0)return i}return def};
 const ci=idx(['component','material','item','name'],0),di=idx(['description','specification','details'],1),qi=idx(['qty','quantity'],2),ui=idx(['unit','uom'],3),ri=idx(['rate','price','cost'],4),ai=idx(['amount','total'],5),mi=idx(['method','calculation'],-1),wi=idx(['wastage','waste'],-1);
 const data=non.slice(best>=0?hi+1:0);const lines=[];
 data.forEach(r=>{if(!r.some(v=>v!==''))return;const name=r[ci]||'';if(!name)return;const desc=r[di]||'';const qty=parseFloat(String(r[qi]||'').replace(/,/g,''))||1;const unit=r[ui]||'';const rate=parseFloat(String(r[ri]||'').replace(/[₹,\s]/g,''));const waste=wi>=0?parseFloat(String(r[wi]||'').replace(/%/g,''))||0:0;let method=mi>=0?String(r[mi]||'').toLowerCase():'';if(!method){const u=unit.toLowerCase();method=u.includes('sq')||u.includes('ft²')||u.includes('sqft')?'area':u.includes('rft')||u.includes('running')?'rft':u.includes('kg')?'kg':u.includes('job')||u.includes('fixed')||u.includes('unit')?'fixed':'qty'}else if(method.includes('area'))method='area';else if(method.includes('rft')||method.includes('running'))method='rft';else if(method.includes('kg'))method='kg';else if(method.includes('fixed')||method.includes('job'))method='fixed';else if(method.includes('%'))method='pct';else method='qty';const existing=(db.materials||[]).find(m=>norm(m.name)===norm(name));lines.push({mid:existing?existing.id:'',name,cat:existing?existing.cat:'Material',unit:unit||existing?.unit||'qty',method,qty,price:isFinite(rate)?rate:null,masterPrice:existing?.price||0,wastage:waste,description:desc});});
 return {lines,headers:hr};
}
function importPastedCosting(type){
 const raw=$('#pc_data')?.value||'';const parsed=parsePastedCosting(raw);if(!parsed.lines.length)return toast('No costing rows found. Paste the Excel/Google Sheet table first.');const s=S[type]||{};s.customer=$('#pc_customer')?.value.trim()||s.customer||'';s.costingName=$('#pc_name')?.value.trim()||s.costingName||'Imported '+pasteCostingTypeLabel(type)+' Costing';if($('#pc_w')?.value)s.w=+$('#pc_w').value;if($('#pc_h')?.value)s.h=+$('#pc_h').value;if($('#pc_t')?.value)s.t=+$('#pc_t').value;if($('#pc_qty')?.value)s.qty=+$('#pc_qty').value||1;s.lines=parsed.lines;s.method='Excel / Google Sheet Import';document.getElementById('pasteCostingModal')?.remove();render();toast(`${pasteCostingTypeLabel(type)} costing imported: ${parsed.lines.length} rows`);}
function setCostSpec(type,key,value){
 const s=S[type];if(!s)return;
 s[key]=value;
 if(value===''){
   if(key==='thickness')s.t='';
   if(key==='frameType'||key==='subCategory'||key==='shutterType'||key==='side'||key==='finishOption')s[key]='';
   render();return;
 }
 if(key==='frameType'){
   const candidates=activeTemplates('frame').filter(t=>t.frameType===value);
   if(candidates.length){
     const t=candidates.find(t=>t.subCategory===s.subCategory&&t.thickness===s.t)||candidates[0];
     s.tid=t.id;s.lines=clone(t.bom);s.frameType=t.frameType||value;s.subCategory=t.subCategory||'';s.t=t.thickness||'';
   }
 }else if(key==='subCategory'||key==='thickness'){
   const t=activeTemplates('frame').find(x=>x.frameType===s.frameType&&x.subCategory===s.subCategory&&x.thickness===s.t);
   if(t){s.tid=t.id;s.lines=clone(t.bom);}
 }else if(type==='shutter'&&(key==='shutterType'||key==='side'||key==='finishOption')){
   const candidates=activeTemplates('shutter').filter(t=>
     (!s.shutterType||!t.shutterType||t.shutterType===s.shutterType) &&
     (!s.side||!t.side||t.side===s.side) &&
     (!s.finishOption||!t.finishOption||t.finishOption===s.finishOption)
   );
   const t=candidates.find(x=>x.shutterType===s.shutterType&&x.side===s.side&&x.finishOption===s.finishOption)||candidates[0];
   if(t){s.tid=t.id;s.lines=clone(t.bom);s.shutterType=t.shutterType||s.shutterType;s.side=t.side||s.side;s.finishOption=t.finishOption||s.finishOption;}
 }
 render()
}
function setF(t,k,v){S[t][k]=['w','h','t','qty','sell'].includes(k)?(v===''?'':+v):v;render()}
function setT(t,id){startCost(t,id,1);render()}
function getLines(r){return r.startsWith('T:')?db.templates.find(t=>t.id==r.slice(2)).bom:S[r].lines}
function setL(t,i,k,v){const l=getLines(t)[i];l[k]=k=='price'?(v===''?null:+v):['qty','w','h'].includes(k)?+v:v;render()}
function addL(t,id){if(!id)return;getLines(t).push({mid:id,method:unitMethod(mat(id)),qty:1});render()}
function delL(t,i){getLines(t).splice(i,1);render()}
function moveL(t,i,dir){const a=getLines(t),j=i+dir;if(j<0||j>=a.length)return;const [item]=a.splice(i,1);a.splice(j,0,item);save();render()}
function unitMethod(m){return{'sq ft':'area',rft:'rft',kg:'kg',unit:'fixed'}[m.unit]||'qty'}
function saveCost(type,q){
 const s=S[type];
 if(!String(s.costingName||'').trim())return toast('Enter a Costing Name before saving');
 const r=calc(s);
 const t=db.templates.find(x=>x.id==s.tid),id=s.rid||'C-'+String(db.seq++).padStart(4,'0');
 const rec={id,date:today(),customer:s.customer,terms:s.terms,type,tid:s.tid,tname:String(s.costingName|| (t?t.name:'')).trim() || (t?t.name:''),costingName:String(s.costingName||'').trim(),templateName:t?t.name:'',qty:s.qty,method:s.method,user:cu?cu.name:'',userId:cu?.id||null,w:s.w,h:s.h,t:s.t,sqFt:r.sq,totalSqFt:r.sq*(+s.qty||0),sell:s.sell,
  lines:r.rows.map(x=>({mid:x.l.mid,name:x.l.name||x.m.name,cat:x.l.cat||x.m.cat,unit:x.l.unit||x.m.unit,method:x.l.method,qty:x.l.qty,size:x.l.size,w:x.l.w,h:x.l.h,price:x.p,wastage:x.w,masterPrice:x.l.masterPrice||null,description:x.l.description||''})),frameType:s.frameType||'',subCategory:s.subCategory||'',side:s.side||'',shutterType:s.shutterType||'',finishOption:s.finishOption||'',mat:r.by.Material,hw:r.by.Hardware,lab:r.by.Labour,oth:r.unit-r.by.Material-r.by.Hardware-r.by.Labour,per:r.unit,total:r.total};
 const i=db.history.findIndex(h=>h.id==id);i>=0?db.history[i]=rec:db.history.unshift(rec);s.rid=id;save();render();if(!q)toast('Saved '+id)}
function setMaster(type){const s=S[type],t=db.templates.find(x=>x.id==s.tid);if(!t)return;
 ask('Overwrite the BOM and effective prices of "'+t.name+'" with this costing?',()=>{const r=calc(s);t.bom=s.lines.map((l,i)=>({...tl(l),price:r.rows[i]?.p??(l.price==null?null:+l.price)}));log('Template BOM and effective prices updated: '+t.name);save();toast('Master template and prices updated')})}
const tl=l=>({mid:l.mid,method:l.method,qty:l.qty,size:l.size,w:l.w,h:l.h,price:l.price==null||l.price===''?null:+l.price,wastage:l.wastage==null||l.wastage===''?null:+l.wastage,masterPrice:l.masterPrice==null?null:+l.masterPrice});
function newFromCost(type){const s=S[type],n=$('#nt').value.trim();if(!n)return toast('Enter a template name');
 const r=calc(s);db.templates.push({id:'t'+db.tid++,type,name:n,active:true,shutterType:s.shutterType||'',side:s.side||'',finishOption:s.finishOption||'',frameType:s.frameType||'',subCategory:s.subCategory||'',thickness:s.t||'',bom:s.lines.map((l,i)=>({...tl(l),price:r.rows[i]?.p??(l.price==null?null:+l.price)}))});log('Template and effective prices created: '+n);save();toast('Template and prices saved');render()}

function doorCostings(){return (db.history||[]).filter(x=>x.type==='door').sort((a,b)=>String(b.id).localeCompare(String(a.id)))}
function doorSource(id,type){if(!id)return null;return (db.history||[]).find(x=>String(x.id)===String(id)&&x.type===type)||null}
function doorDefaultComponents(d){
 if(Array.isArray(d.components)&&d.components.length)return d.components.map(c=>({...c}));
 return [
  {type:'shutter',sourceId:d.shutterId||'',qty:1,rate:0,closed:false},
  {type:'frame',sourceId:d.frameId||'',qty:1,rate:0,closed:false},
  {type:'labour',sourceId:'',qty:d.labourQty==null?1:+d.labourQty||0,rate:+d.labourRate||0,closed:false}
 ];
}
function doorComponentAmount(c){
 if(c.type==='shutter'){const x=doorSource(c.sourceId,'shutter');return x?(+x.per||0)*(+c.qty||1):0}
 if(c.type==='frame'){const x=doorSource(c.sourceId,'frame');return x?(+x.per||0)*(+c.qty||1):0}
 if(c.type==='labour')return (+c.qty||0)*(+c.rate||0);
 return 0;
}
function doorCalc(d){
 const comps=doorDefaultComponents(d),out={sh:[],fr:[],lab:[],shutterCTC:0,frameCTC:0,labourCTC:0};
 comps.forEach(c=>{const a=doorComponentAmount(c);if(c.type==='shutter'){out.sh.push({...c,source:doorSource(c.sourceId,'shutter'),amount:a});out.shutterCTC+=a}else if(c.type==='frame'){out.fr.push({...c,source:doorSource(c.sourceId,'frame'),amount:a});out.frameCTC+=a}else if(c.type==='labour'){out.lab.push({...c,amount:a});out.labourCTC+=a}});
 const unit=out.shutterCTC+out.frameCTC+out.labourCTC,qty=Math.max(0,+d.qty||0);return {...out,components:comps,unit,qty,total:unit*qty}
}
function doorSourceOptions(type,selected){
 const list=(db.history||[]).filter(x=>x.type===type).sort((a,b)=>String(b.id).localeCompare(String(a.id)));
 return `<option value=""${selected?'':' selected'}>None</option>`+list.map(x=>`<option value="${esc(x.id)}"${String(x.id)===String(selected)?' selected':''}>${esc(x.type==='shutter'?'Shutter':x.type==='frame'?'Frame':'Door')} · ${esc(x.tname||x.costingName||x.id)} · ${esc(x.id)} · ${fmt(x.per||0)}</option>`).join('')
}
function doorSourceCard(title,src,emptyText){
 if(!src)return `<div class="door-source-empty mu">${emptyText}</div>`;
 const size=(src.w||src.h)?`${src.w||'-'} × ${src.h||'-'} mm${src.t?` · ${src.t} mm`:''}`:'';
 return `<div class="door-source-card"><div><b>${esc(src.tname||src.id)}</b><div class="mu">${esc(src.id)}${size?' · '+esc(size):''}</div></div><strong>${fmt(src.per||0)}</strong></div>`
}
function doorComponentTitle(c,i){return c.type==='shutter'?'Shutter':c.type==='frame'?'Frame':c.type==='labour'?'Labour / Installation':'Component'}
function doorComponentBody(c,i,z){
 if(c.type==='shutter')return `<div class="g"><div><label>Saved Shutter Costing</label><select onchange="setDoorComponent(${i},'sourceId',this.value)">${doorSourceOptions('shutter',c.sourceId)}</select></div><div><label>Quantity</label><input type="number" min="0" step="any" value="${esc(c.qty==null?1:c.qty)}" onchange="setDoorComponentNum(${i},'qty',this.value)"></div></div>${doorSourceCard('Shutter',doorSource(c.sourceId,'shutter'),'Select a saved Shutter Costing.')}`;
 if(c.type==='frame')return `<div class="g"><div><label>Saved Frame Costing</label><select onchange="setDoorComponent(${i},'sourceId',this.value)">${doorSourceOptions('frame',c.sourceId)}</select></div><div><label>Quantity</label><input type="number" min="0" step="any" value="${esc(c.qty==null?1:c.qty)}" onchange="setDoorComponentNum(${i},'qty',this.value)"></div></div>${doorSourceCard('Frame',doorSource(c.sourceId,'frame'),'Select a saved Frame Costing.')}`;
 if(c.type==='labour')return `<div class="g"><div><label>Installation / Labour Qty</label><input type="number" min="0" step="any" value="${esc(c.qty==null?1:c.qty)}" onchange="setDoorComponentNum(${i},'qty',this.value)"></div><div><label>Installation / Labour Rate</label><input type="number" min="0" step="any" value="${esc(c.rate==null?0:c.rate)}" onchange="setDoorComponentNum(${i},'rate',this.value)"></div></div><p class="mu">Labour / installation can be added multiple times if required.</p>`;
 return `<p class="mu">Select a component type to continue.</p>`;
}
function doorCostView(){
 if(!D)D={rid:null,name:'Main Door',customer:'',qty:1,components:[{type:'shutter',sourceId:'',qty:1,rate:0,closed:false},{type:'frame',sourceId:'',qty:1,rate:0,closed:false},{type:'labour',sourceId:'',qty:1,rate:0,closed:false}],notes:''};
 if(!Array.isArray(D.components)||!D.components.length)D.components=doorDefaultComponents(D);
 const z=doorCalc(D),saved=doorCostings();
 const savedRows=saved.map(x=>`<tr><td><b>${esc(x.id)}</b></td><td>${esc(x.tname||'-')}</td><td>${esc(x.customer||'-')}</td><td>${x.qty||1}</td><td class="r">${fmt(x.per||0)}</td><td class="r">${fmt(x.total||0)}</td><td style="white-space:nowrap"><button onclick="openDoorCosting('${esc(x.id)}')">Edit</button> <button onclick="openDoorCosting('${esc(x.id)}',true)">Copy</button> <button onclick="deleteDoorCosting('${esc(x.id)}')">Delete</button></td></tr>`).join('');
 const section=(c,i)=>{const amount=doorComponentAmount(c),title=doorComponentTitle(c,i);return `<div class="door-accordion ${c.closed?'closed':''}"><div class="door-accordion-head"><button type="button" style="all:unset;cursor:pointer;flex:1;display:flex;justify-content:space-between;align-items:center" onclick="toggleDoorComponent(${i})"><span><b>${c.closed?'▶':'▼'}</b> ${i+1}. ${title}</span><strong>${fmt(amount)}</strong></button><button type="button" title="Delete component" onclick="deleteDoorComponent(${i})" style="margin-left:10px">Delete</button></div><div class="door-accordion-body">${c.closed?'':`<div class="g"><div><label>Component Type</label><select onchange="setDoorComponent(${i},'type',this.value)"><option value="shutter"${c.type==='shutter'?' selected':''}>Shutter</option><option value="frame"${c.type==='frame'?' selected':''}>Frame</option><option value="labour"${c.type==='labour'?' selected':''}>Labour / Installation</option></select></div></div>${doorComponentBody(c,i,z)}`}</div></div>`};
 return `<h2>Cost to Company</h2>
 <div class="pn"><div class="row"><button class="pri" onclick="newDoorCosting()">+ New Door Costing</button><button type="button" onclick="addDoorComponent()">+ Add Component</button><span class="mu">Build one complete door cost from any combination of Shutter, Frame and Labour.</span></div><div class="g"><div><label>Door Name</label><input value="${esc(D.name||'')}" placeholder="e.g. Main Door" onchange="setDoor('name',this.value)"></div><div><label>Customer / Project</label><input value="${esc(D.customer||'')}" placeholder="Optional" onchange="setDoor('customer',this.value)"></div><div><label>Door Quantity</label><input type="number" min="1" value="${esc(D.qty||1)}" onchange="setDoorNum('qty',this.value)"></div></div></div>
 <div class="pn"><div class="steps">Door → Add / Remove Components → Complete Door CTC</div>${z.components.length?z.components.map(section).join(''):'<p class="mu">No components added. Click + Add Component.</p>'}<div class="row" style="margin-top:12px"><button type="button" onclick="addDoorComponent()">+ Add Component</button></div></div>
 <div class="pn"><h3 style="margin-top:0">Complete Door Cost</h3><div class="door-total-grid"><div><label>Shutter</label><b>${fmt(z.shutterCTC)}</b></div><div><label>Frame</label><b>${fmt(z.frameCTC)}</b></div><div><label>Labour</label><b>${fmt(z.labourCTC)}</b></div><div><label>Cost / Door</label><b class="big">${fmt(z.unit)}</b></div><div><label>Quantity</label><b>${z.qty}</b></div><div><label>Total Cost</label><b class="big">${fmt(z.total)}</b></div></div><div class="row" style="margin-top:12px"><button class="pri" onclick="saveDoorCosting()">Save Door Costing</button><button onclick="newDoorCosting()">Clear / New</button></div></div>
 <div class="pn"><label>Internal Notes</label><textarea rows="2" placeholder="Optional internal note" onchange="setDoor('notes',this.value)">${esc(D.notes||'')}</textarea></div>
 ${saved.length?`<h3>Saved Door Costings</h3><div class="tw"><table><tr><th>ID</th><th>Door</th><th>Customer / Project</th><th>Qty</th><th class="r">Cost / Door</th><th class="r">Total Cost</th><th></th></tr>${savedRows}</table></div>`:'<p class="mu">No Door Costings saved yet.</p>'}`
}
function toggleDoorComponent(i){if(!D||!D.components?.[i])return;D.components[i].closed=!D.components[i].closed;render()}
function setDoorComponent(i,k,v){if(!D||!D.components?.[i])return;const c=D.components[i];c[k]=v;if(k==='type'){c.sourceId='';c.qty=1;c.rate=0}render()}
function setDoorComponentNum(i,k,v){if(!D||!D.components?.[i])return;D.components[i][k]=v===''?'':+v;render()}
function addDoorComponent(){if(!D)D={rid:null,name:'Main Door',customer:'',qty:1,components:[],notes:''};if(!Array.isArray(D.components))D.components=doorDefaultComponents(D);D.components.push({type:'shutter',sourceId:'',qty:1,rate:0,closed:false});render()}
function deleteDoorComponent(i){if(!D||!Array.isArray(D.components)||!D.components[i])return;ask('Delete this component from the Door Costing?',()=>{D.components.splice(i,1);render()})}
function setDoor(k,v){if(!D)return;D[k]=v;render()}
function setDoorNum(k,v){if(!D)return;D[k]=v===''?'':+v;render()}
function newDoorCosting(){D={rid:null,name:'Main Door',customer:'',qty:1,components:[{type:'shutter',sourceId:'',qty:1,rate:0,closed:false},{type:'frame',sourceId:'',qty:1,rate:0,closed:false},{type:'labour',sourceId:'',qty:1,rate:0,closed:false}],notes:''};render()}
function openDoorCosting(id,copy){const x=doorCostings().find(a=>String(a.id)===String(id));if(!x)return;D={rid:copy?null:x.id,name:x.tname||'Main Door',customer:x.customer||'',qty:+x.qty||1,components:doorDefaultComponents(x),notes:x.notes||''};render()}
function deleteDoorCosting(id){ask('Delete this Door Costing?',()=>{db.history=(db.history||[]).filter(x=>String(x.id)!==String(id));if(D&&String(D.rid)===String(id))newDoorCosting();else{save();render()}})}
function saveDoorCosting(){
 if(!D||!String(D.name||'').trim())return toast('Enter a Door Name');
 const z=doorCalc(D);if(z.unit<=0)return toast('Add a Shutter, Frame or Labour cost first');
 const comps=z.components.map(c=>({...c})),firstSh=comps.find(c=>c.type==='shutter'&&c.sourceId),firstFr=comps.find(c=>c.type==='frame'&&c.sourceId),lab=comps.filter(c=>c.type==='labour'),firstLb=lab[0]||{};
 const id=D.rid||'DOR-'+String(db.seq++).padStart(4,'0');
 const rec={id,date:today(),customer:D.customer||'',terms:'',type:'door',tid:'',tname:String(D.name).trim(),qty:+D.qty||1,method:'Door Costing',user:cu?cu.name:'',userId:cu?.id||null,w:z.sh?.[0]?.source?.w||z.fr?.[0]?.source?.w||0,h:z.sh?.[0]?.source?.h||z.fr?.[0]?.source?.h||0,t:z.sh?.[0]?.source?.t||z.fr?.[0]?.source?.t||'',sell:'',shutterId:firstSh?.sourceId||'',frameId:firstFr?.sourceId||'',shutterCTC:z.shutterCTC,frameCTC:z.frameCTC,labourQty:firstLb.qty==null?0:+firstLb.qty||0,labourRate:firstLb.rate==null?0:+firstLb.rate||0,labour:z.labourCTC,components:comps,notes:D.notes||'',mat:z.shutterCTC+z.frameCTC,hw:0,lab:z.labourCTC,oth:0,per:z.unit,total:z.total,sqFt:0,totalSqFt:0,lines:[]};
 const i=(db.history||[]).findIndex(h=>String(h.id)===String(id));if(i>=0)db.history[i]=rec;else db.history.unshift(rec);D.rid=id;save();render();toast('Saved '+id+' · '+fmt(z.unit)+' per door')
}
function aiView(){
 const tp=db.templates.filter(t=>t.active),a=ai;
 let h=`<h2>AI Costing</h2><p class="mu">Type the requirement. Fields are extracted and matched to master templates and materials. You confirm before anything is calculated; prices always come from Master Data.</p>
 <textarea id="aitx" rows="4" placeholder="5 fire rated doors, 1050 x 2400 mm, 50 mm thick, GI sheet, honeycomb core, panic bar and door closer">${esc(a?a.text:'')}</textarea>
 <div class="row"><button class="pri" onclick="runAI()">Extract</button><button disabled title="Needs a backend AI service">Image / PDF / Excel upload</button></div>
 <p class="mu">This version uses rule-based text matching. Image, PDF and Excel reading needs a backend AI service.</p>`;
 if(a){const c=v=>v==null?'<span class="warn">verify</span>':`<span class="mu">${Math.round(v*100)}%</span>`;
  const inp=(k,l)=>`<div><label>${l} ${c(a.c[k])}</label><input type="number" value="${esc(a[k])}" onchange="setAI('${k}',this.value)"></div>`;
  h+=`<div class="pn"><h3 style="margin-top:0">Extracted</h3>
  ${a.tid?'':'<p class="warn">No matching master template found. Select an existing template below, or create one in Master Data.</p>'}
  <div class="g"><div><label>Template ${c(a.c.tid)}</label><select onchange="setAI('tid',this.value)"><option value="">— select —</option>${opts(tp,a.tid)}</select></div>
  ${inp('w','Width mm')}${inp('h','Height mm')}${inp('t','Thickness mm')}${inp('qty','Quantity')}</div>
  <h3>Materials found in master data</h3>${a.mats.length?`<div class="tw"><table>${a.mats.map(m=>`<tr><td>${esc(mat(m.mid).name)}</td><td>${c(m.c)}</td><td class="mu">${mat(m.mid).price?fmt(mat(m.mid).price)+' master price':'<span class="warn">no price set</span>'}</td></tr>`).join('')}</table></div>`:'<p class="mu">None detected.</p>'}
  <p class="mu">A material that is not in Master Data is not listed. Add it there, then extract again.</p>
  <div class="row"><button class="pri" ${a.tid?'':'disabled'} onclick="confirmAI()">Confirm &amp; Calculate</button></div></div>`}
 return h}
function runAI(){
 const raw=$('#aitx').value,t=raw.toLowerCase().replace(/(\d)\s*mm/g,'$1 mm');
 const q=t.match(/(?:quantity|qty)\s*[:=]?\s*(\d+)/)||t.match(/(?<![\d.])(\d+)(?!\s*mm)(?:\s+[a-z-]+){0,3}\s+(?:doors?|shutters?|frames?|nos|pcs|units?)\b/);
 const sz=t.match(/(\d{3,4})\s*[x×*]\s*(\d{3,4})/),th=t.match(/(?<![\d.])(\d{2}) mm/);
 let best=null;db.templates.filter(x=>x.active).forEach(x=>{const k=x.name.toLowerCase().replace(/ (shutter|frame)$/,'');
  if(t.includes(k)&&(!best||k.length>best.k.length||(k.length==best.k.length&&(x.type=='frame')==t.includes('frame'))))best={k,x}});
 const mats=[];db.materials.filter(m=>m.active).forEach(m=>{const n=m.name.toLowerCase(),p=n.split(' ').slice(0,2).join(' ');
  if(t.includes(n))mats.push({mid:m.id,c:.95});else if(t.includes(p)&&p.length>3)mats.push({mid:m.id,c:.87})});
 ai={text:raw,tid:best?best.x.id:'',w:sz?+sz[1]:'',h:sz?+sz[2]:'',t:th?+th[1]:'',qty:q?+q[1]:1,mats,
  c:{tid:best?.96:null,w:sz?.93:null,h:sz?.93:null,t:th?.9:null,qty:q?.9:null}};render()}
function setAI(k,v){ai[k]=k=='tid'?v:+v;if(k=='tid')ai.c.tid=v?1:null;render()}
function confirmAI(){const t=db.templates.find(x=>x.id==ai.tid),type=t.type;startCost(type,t.id);const s=S[type];
 Object.assign(s,{w:ai.w||s.w,h:ai.h||s.h,t:ai.t||s.t,qty:ai.qty||1,method:'AI Text'});
 ai.mats.forEach(m=>{if(!s.lines.some(l=>l.mid==m.mid))s.lines.push({mid:m.mid,method:unitMethod(mat(m.mid)),qty:1})});go(type)}
function masterView(){
 const tab=(k,l)=>`<button class="${mtab==k?'pri':''}" onclick="mtab='${k}';render()">${l}</button>`;
 if(!can('*'))mtab='templates';let h=`<h2>Master Data</h2><div class="row">${can('*')?tab('materials','Materials &amp; price master'):''}${tab('templates','Templates')}${can('*')?tab('shutterFields','Shutter Fields'):''}${can('*')?tab('frameFields','Frame Fields'):''}${can('*')?tab('quotationFields','Quotation Fields'):''}</div>`;
 if(mtab=='materials'){const i=(m,k,t='text')=>`<td><input type="${t}" ${t=='number'?'step="any"':''} value="${esc(m[k])}" onchange="setM('${m.id}','${k}',this.value)"></td>`;
  h+=`<div class="tw"><table><tr><th>Name</th><th>Category</th><th>Unit</th><th>Price</th><th>Wastage %</th><th>Supplier</th><th>Updated</th><th>Active</th><th></th></tr>
  ${db.materials.map(m=>`<tr>${i(m,'name')}<td><select onchange="setM('${m.id}','cat',this.value)">${`<option value=""${m.cat===""?" selected":""}>None</option>`+CATS.map(c=>`<option${c==m.cat?' selected':''}>${c}</option>`).join('')}</select></td>${i(m,'unit')}${i(m,'price','number')}${i(m,'wastage','number')}${i(m,'supplier')}
  <td class="mu">${m.updated}</td><td><input type="checkbox" ${m.active?'checked':''} onchange="setM('${m.id}','active',this.checked)"></td>
  <td style="white-space:nowrap"><button class="x" onclick="dupM('${m.id}')">Copy</button> <button class="x" onclick="delM('${m.id}')">✕</button></td></tr>`).join('')}</table></div>
  <div class="row"><button onclick="addM()">+ Add material</button></div>`}
 else if(mtab==='shutterFields'||mtab==='frameFields'||mtab==='quotationFields'){const groups=mtab==='shutterFields'?[['shutterType','Shutter Type'],['shutterSide','Side'],['shutterFinish','Finish / Sub-option']]:mtab==='frameFields'?[['frameType','Frame Type'],['frameSubCategory','Frame Sub-category'],['frameThickness','Thickness']]:[['quotationFields','Custom Quotation Field Labels']];h+=`<p class="mu">Manage dropdown choices here. Changes are saved to Master Data and appear in the relevant module.</p>${groups.map(([key,label])=>`<div class="pn"><h3>${label}</h3><div class="tw"><table><tr><th>Option</th><th>Action</th></tr>${(db.fieldOptions[key]||[]).map((v,i)=>`<tr><td><input value="${esc(v)}" onchange="setFieldOption('${key}',${i},this.value)"></td><td><button class="x" onclick="deleteFieldOption('${key}',${i})">Delete</button></td></tr>`).join('')}</table></div><div class="row"><input id="newField_${key}" placeholder="Add ${label.toLowerCase()}" style="max-width:300px"><button onclick="addFieldOption('${key}')">+ Add option</button></div></div>`).join('')}`}
 else h+=`<div class="tw"><table><tr><th>Name</th><th>Type</th><th>Specification</th><th>Components</th><th>Active</th><th></th></tr>
  ${db.templates.filter(t=>t.active!==false && !(t.type==='shutter' && ['30 mm Shutter','35 mm Shutter','40 mm Shutter','45 mm Shutter','50 mm Shutter'].includes(t.name))).map(t=>`<tr><td><input value="${esc(t.name)}" onchange="setTp('${t.id}','name',this.value)"></td><td>${t.type}</td><td>${t.type==='frame'?[t.frameType,t.subCategory,t.thickness].filter(Boolean).join(' / '):[t.shutterType,t.side,t.finishOption].filter(Boolean).join(' / ')}</td><td>${t.bom.length}</td>
  <td><input type="checkbox" ${t.active?'checked':''} onchange="setTp('${t.id}','active',this.checked)"></td>
  <td style="white-space:nowrap"><button class="x" onclick="editT('${t.id}')">Edit BOM</button> <button class="x" onclick="dupT('${t.id}')">Copy</button> <button class="x" onclick="delT('${t.id}')">✕</button></td></tr>`).join('')}</table></div>
  ${mEdit?tplEditor(mEdit):''}<div class="row"><button onclick="addT('shutter')">+ Shutter template</button><button onclick="addT('frame')">+ Frame template</button></div>`;
 return h}
function setM(id,k,v){const m=mat(id);m[k]=['price','wastage'].includes(k)?+v:v;if(k=='price'){m.updated=today();log(`Price ${m.name} → ${v}`)}save();render()}
function addM(){db.materials.push({id:'m'+db.mid++,name:'New material',cat:'Material',unit:'nos',price:0,wastage:0,supplier:'',active:true,updated:today()});save();render()}
function dupM(id){const m=clone(mat(id));m.id='m'+db.mid++;m.name+=' (copy)';db.materials.push(m);save();render()}
function delM(id){ask('Delete this material? BOM lines using it will show as deleted.',()=>{db.materials=db.materials.filter(m=>m.id!=id);log('Material deleted');save();render()})}
function setTp(id,k,v){db.templates.find(t=>t.id==id)[k]=v;save();render()}
function addFieldOption(key){const e=document.getElementById('newField_'+key),v=(e?.value||'').trim();if(!v)return toast('Enter an option name');db.fieldOptions=db.fieldOptions||{};db.fieldOptions[key]=db.fieldOptions[key]||[];if(db.fieldOptions[key].some(x=>x.toLowerCase()===v.toLowerCase()))return toast('This option already exists');db.fieldOptions[key].push(v);log('Master Data option added: '+v);save();render()}
function setFieldOption(key,i,v){v=String(v||'').trim();if(!v)return toast('Option cannot be blank');db.fieldOptions[key][i]=v;save();render()}
function deleteFieldOption(key,i){const v=db.fieldOptions[key]?.[i];ask('Delete option '+v+'? Existing saved costings are not automatically renamed.',()=>{db.fieldOptions[key].splice(i,1);log('Master Data option deleted: '+v);save();render()})}
function addT(type){const id='t'+db.tid++;const o=type==='shutter'?{shutterType:'Post Forming',side:'Both Side',finishOption:'Veneer'}:{frameType:'Post Forming',subCategory:'Wall to Wall Standard',thickness:'25+18'};db.templates.push({id,type,name:type==='shutter'?'New Shutter Template':'New Frame Template',active:true,bom:[],...o});save();render()}
function dupT(id){const t=clone(db.templates.find(x=>x.id==id));t.id='t'+db.tid++;t.name+=' (copy)';db.templates.push(t);save();render()}
function delT(id){ask('Delete this template?',()=>{db.templates=db.templates.filter(t=>t.id!=id);log('Template deleted');save();render()})}
function editT(id){mEdit=mEdit==id?null:id;render()}
function useT(id){const t=db.templates.find(x=>x.id==id);startCost(t.type,id);go(t.type)}
function dashView(){
 const qs=db.quotations||[],month=today().slice(0,7);
 const thisMonth=qs.filter(q=>String(q.date||'').slice(0,7)===month).length;
 const sentValue=qs.filter(q=>['Sent','Follow-up','Negotiation'].includes(qStatusOf(q))).reduce((a,q)=>a+qCalc(q).grand,0);
 const wonValue=qs.filter(q=>qStatusOf(q)==='Won').reduce((a,q)=>a+qCalc(q).grand,0);
 const pending=(db.crm||[]).filter(r=>r.nextFollowup&&r.nextFollowup<=today()&&!['Won','Lost','Expired'].includes(r.status)).length;
 return `<h2>Dashboard</h2><div class="row"><button class="pri" onclick="go('shutter')">+ New Shutter</button><button class="pri" onclick="go('frame')">+ New Frame</button><button class="pri" onclick="go('door')">+ New Door</button><button onclick="go('quote')">+ New Quotation</button></div><div class="g"><div class="pn"><label>Quotations This Month</label><div class="big">${thisMonth}</div></div><div class="pn"><label>Value Sent</label><div class="big">${qMoney(sentValue)}</div></div><div class="pn"><label>Won Value</label><div class="big">${qMoney(wonValue)}</div></div><div class="pn"><label>Pending Follow-ups</label><div class="big">${pending}</div></div></div><div class="pn"><h3 style="margin-top:0">Recent Quotations</h3><div class="tw"><table><tr><th>Quotation</th><th>Customer</th><th>Status</th><th>Follow-up</th><th class="r">Value</th></tr>${qs.slice(0,5).map(q=>{const r=(db.crm||[]).find(x=>x.quotationId===q.id);const st=qStatusOf(q);return `<tr><td><b>${esc(qLabel(q))}</b></td><td>${esc(q.customer||'-')}</td><td>${esc(st)}</td><td>${esc(r?.nextFollowup||'-')}</td><td class="r">${qMoney(qCalc(q).grand)}</td></tr>`}).join('')||'<tr><td colspan="5" class="mu">No quotations yet.</td></tr>'}</table></div></div>`
}

function histView(){
 const all=(db.history||[]).filter(x=>x.type!=='door');
 const q=(document.getElementById('histSearch')?.value||window._histSearch||'').toLowerCase();
 const typeFilter=window._histType||'all';
 const filtered=all.filter(x=>{
   const matchesType=typeFilter==='all'||x.type===typeFilter;
   const searchable=[x.id,x.date,x.customer,x.tname,x.costingName,x.templateName,x.method,x.type].join(' ').toLowerCase();
   return matchesType&&searchable.includes(q);
 });
 const per=20,totalPages=Math.max(1,Math.ceil(filtered.length/per));histPg=Math.min(histPg,totalPages);const start=(histPg-1)*per,rows=filtered.slice(start,start+per);
 const typeLabel=x=>x.type==='shutter'?'Shutter':x.type==='frame'?'Frame':String(x.type||'Costing');
 return `<h2>Costing History</h2><div class="row"><input id="histSearch" placeholder="Search ID, name, customer..." value="${esc(window._histSearch||'')}" oninput="window._histSearch=this.value;histPg=1;render()" style="max-width:280px"><label style="display:flex;align-items:center;gap:8px;margin:0">Costing Type <select id="histTypeFilter" onchange="window._histType=this.value;histPg=1;render()"><option value="all"${typeFilter==='all'?' selected':''}>All Costings</option><option value="shutter"${typeFilter==='shutter'?' selected':''}>Shutter</option><option value="frame"${typeFilter==='frame'?' selected':''}>Frame</option></select></label><input id="masterClientName" placeholder="Client name for Master Costing" style="max-width:260px"><button class="pri" onclick="masterCostingPDF()">Generate Master Costing Sheet PDF</button><button onclick="masterCostingPreview()">Preview</button>${pdfSel()}<button onclick="exportCSV()">Export CSV</button></div><p class="mu">Showing ${filtered.length?start+1:0}-${Math.min(start+per,filtered.length)} of ${filtered.length} ${typeFilter==='all'?'costings':typeLabel({type:typeFilter}).toLowerCase()+' costings'}.</p>${filtered.length?`<div class="tw"><table><tr><th><input type="checkbox" onchange="toggleAllCostings(this.checked)"></th><th>Costing Name</th><th>Type</th><th>Date</th><th>Customer</th><th>Size</th><th>Qty</th><th class="r">Sq. Ft./Unit</th><th class="r">Total Sq. Ft.</th><th class="r">Total Cost</th><th></th></tr>
 ${rows.map(x=>`<tr><td><input class="mcsel" type="checkbox" value="${esc(x.id)}"></td><td><b>${esc(x.costingName||x.tname||x.id)}</b><div class="mu">Ref: ${esc(x.id)}</div>${x.templateName?`<div class="mu">Template: ${esc(x.templateName)}</div>`:''}</td><td><span class="badge">${esc(typeLabel(x))}</span></td><td>${esc(x.date||'')}</td><td>${esc(x.customer||'-')}</td><td>${esc((x.w||0)+' × '+(x.h||0)+' MM')}</td><td>${esc(x.qty||1)}</td><td class="r">${(+x.sqFt||0).toFixed(2)}</td><td class="r">${(+x.totalSqFt||0).toFixed(2)}</td><td class="r">${fmt(x.total)}</td><td style="white-space:nowrap"><button class="x" onclick="openRec('${esc(x.id)}')">Edit</button> <button class="x" onclick="openRec('${esc(x.id)}',1)">Copy</button> <button class="x" onclick="pdfRec('${esc(x.id)}',1)">Preview</button> <button class="x" onclick="pdfRec('${esc(x.id)}')">PDF</button> ${can('del')?`<button class="x" onclick="delRec('${esc(x.id)}')">✕</button>`:''}</td></tr>`).join('')}</table></div><div class="row"><button ${histPg<=1?'disabled':''} onclick="histPg--;render()">← Previous</button><span class="mu">Page ${histPg} / ${totalPages}</span><button ${histPg>=totalPages?'disabled':''} onclick="histPg++;render()">Next →</button></div>`:'<p class="mu">No saved costings match this filter. Create and save a Shutter or Frame costing, giving it a Costing Name.</p>'}`
}

function toggleAllCostings(on){document.querySelectorAll('.mcsel').forEach(x=>x.checked=on)}
function masterCostingData(){
 const ids=[...document.querySelectorAll('.mcsel:checked')].map(x=>x.value);
 if(!ids.length){toast('Select at least one costing');return null}
 const client=(document.querySelector('#masterClientName')?.value||'').trim()||'Client';
 const rows=ids.map(id=>db.history.find(x=>String(x.id)===String(id))).filter(Boolean);
 const totalSq=rows.reduce((a,x)=>a+(+x.totalSqFt||0),0), totalCost=rows.reduce((a,x)=>a+(+x.total||0),0);
 return {client,rows,totalSq,totalCost,co:db.co||{}};
}
function masterCostingHTML(data){
 const {client,rows,totalSq,totalCost,co}=data;
 const esc2=s=>String(s??'').replace(/[&<>\"]/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','\"':'&quot;'}[c]));
 const logo=co.logo?`<img src="${co.logo}" style="max-height:62px;max-width:150px;object-fit:contain">`:'';
 const body=rows.map((x,i)=>`<tr><td>${i+1}</td><td>${esc2(x.tname)}</td><td>${esc2((x.w||0)+' × '+(x.h||0)+' MM')}</td><td>${x.qty||1}</td><td>${(+x.totalSqFt||0).toFixed(2)}</td><td>${fmt(x.total)}</td></tr>`).join('');
 return `<!doctype html><html><head><meta charset="utf-8"><title>Master Costing Sheet - ${esc2(client)}</title><style>@page{size:A4;margin:12mm}body{font-family:Arial,sans-serif;color:#111;font-size:12px;margin:0;padding:6mm}.pgb{position:fixed;left:0;top:0;right:0;bottom:0;border:2.5px solid ${co.color||'#1f3a4d'};outline:1px solid ${co.color||'#1f3a4d'};outline-offset:-6px;pointer-events:none}.head{display:grid;grid-template-columns:160px 1fr 130px;border-bottom:3px solid ${co.color||'#1f3a4d'};padding-bottom:10px;align-items:center}.logo{text-align:left}.company{text-align:center}.company h1{margin:0;font-size:18px}.company p{margin:4px 0;font-size:10px}.sheet{text-align:right;font-weight:700;font-size:16px}.title{margin:18px 0 12px;font-size:16px;font-weight:700}.client{font-size:14px;font-weight:700;margin-bottom:12px}table{width:100%;border-collapse:collapse}th,td{border:1px solid #777;padding:7px 6px}th{background:#f1f3f5;text-align:left}td:nth-child(1),td:nth-child(4),td:nth-child(5),td:nth-child(6){text-align:right}.tot{margin-top:16px;margin-left:auto;width:45%;border-collapse:collapse}.tot td{font-weight:700}.foot{margin-top:45px;border-top:1px solid #aaa;padding-top:10px;font-size:10px;display:flex;justify-content:space-between}@media print{button{display:none}}</style></head><body><div class="pgb"></div><div class="head"><div class="logo">${logo}</div><div class="company"><h1>${esc2(co.name||'Your Company')}</h1><p>${esc2(co.tag||'')}</p><p>${esc2(co.contact||'')}</p></div><div class="sheet">COST SHEET</div></div><div class="title">Master Costing Sheet</div><div class="client">Cost of: ${esc2(client)}</div><table><thead><tr><th>Sr.</th><th>Costing</th><th>Size</th><th>Qty</th><th>Sq. Ft.</th><th>Cost</th></tr></thead><tbody>${body}</tbody></table><table class="tot"><tr><td>Total Sq. Ft.</td><td>${totalSq.toFixed(2)}</td></tr><tr><td>Total Cost</td><td>${fmt(totalCost)}</td></tr></table><div class="foot"><div>${esc2(co.footerName||'')}</div><div>${esc2([co.footerMobile,co.footerEmail].filter(Boolean).join(' · '))}</div></div></body></html>`;
}
function masterCostingStyle(co){return `<style>.mcs-pg .mcs-title{margin:2mm 0 3mm;font-size:16px;font-weight:700;color:#000}.mcs-pg .mcs-client{font-size:12px;font-weight:600;margin-bottom:4mm}.mcs-pg table{width:100%;min-width:0;border-collapse:collapse;font-size:10px}.mcs-pg th{background:#07569a;color:#fff;padding:7px 6px;text-align:left;border:1px solid #07569a}.mcs-pg td{border:1px solid #dfe4ea;padding:7px 6px;color:#182334;background:none}.mcs-pg td:nth-child(1),.mcs-pg td:nth-child(4),.mcs-pg td:nth-child(5),.mcs-pg td:nth-child(6),.mcs-pg th:nth-child(1),.mcs-pg th:nth-child(4),.mcs-pg th:nth-child(5),.mcs-pg th:nth-child(6){text-align:right}.mcs-pg table.mcs-tot{margin-top:6mm;margin-left:auto;width:48%}.mcs-pg .mcs-tot td{font-weight:700;text-align:left!important;border:0;border-bottom:1px solid #dfe4ea;font-size:11px}.mcs-pg .mcs-tot td:last-child{text-align:right!important}.mcs-pg .mcs-tot tr:last-child td{background:#07569a;color:#fff;border:0;padding:9px 6px}</style>`}
function masterCostingAllStyle(co){return qStyle()+masterCostingStyle(co)}
function masterCostingPagesHTML(data){
 const {client,rows,totalSq,totalCost,co}=data,e=v=>esc(v==null?'':v);
 const header=qHeaderHTML('COST SHEET',`<b>MASTER COSTING</b><br>${qDate(today())}`);
 const cap=16,chunks=[];for(let i=0;i<rows.length;i+=cap)chunks.push(rows.slice(i,i+cap));
 if(!chunks.length)chunks.push([]);
 if(chunks[chunks.length-1].length>cap-4)chunks.push([]);
 let idx=0;
 return chunks.map((ch,pi)=>{
  const last=pi===chunks.length-1,start=idx;idx+=ch.length;
  const body=ch.map((x,j)=>`<tr><td>${start+j+1}</td><td>${e(x.tname)}</td><td>${e((x.w||0)+' × '+(x.h||0)+' MM')}</td><td>${x.qty||1}</td><td>${(+x.totalSqFt||0).toFixed(2)}</td><td>${fmt(x.total)}</td></tr>`).join('');
  return `<div class="q-page mcs-pg">${header}<div class="mcs-title">Master Costing Sheet${pi?' (contd.)':''}</div><div class="mcs-client">Cost of: ${e(client)}</div><table><thead><tr><th>Sr.</th><th>Costing</th><th>Size</th><th>Qty</th><th>Sq. Ft.</th><th>Cost</th></tr></thead><tbody>${body}</tbody></table>${last?`<table class="mcs-tot"><tr><td>Total Sq. Ft.</td><td>${totalSq.toFixed(2)}</td></tr><tr><td>Total Cost</td><td>${fmt(totalCost)}</td></tr></table>`:''}<div class="q-footer"><span>${e(co.name||'Your Company')}</span><span>Master Costing Sheet  |  Page ${pi+1} of ${chunks.length}</span></div></div>`}).join('');
}
function masterCostingPreview(){
 const d=masterCostingData();if(!d)return;
 const o=document.createElement('div');o.className='ov pvo';
 o.innerHTML=`${masterCostingAllStyle(d.co)}<div style="width:100%;max-width:1000px;margin:0 auto"><div class="row" style="position:sticky;top:0;z-index:20;background:#f2f4f8;padding:8px;margin:0 0 8px"><button class="pri" id="mcDl">Download PDF</button><button onclick="this.closest('.ov').remove()">Close</button></div>${masterCostingPagesHTML(d)}</div>`;
 document.body.appendChild(o);document.getElementById('mcDl').onclick=()=>masterCostingPDF(d)}
async function masterCostingPDF(d){
 d=(d&&d.rows)?d:masterCostingData();if(!d)return;
 const nm=String(d.client||'Client').replace(/[^\w\- ]+/g,'').trim().replace(/\s+/g,'-')||'Client';
 try{await downloadHTMLPagesPDF(masterCostingPagesHTML(d),'.mcs-pg','Master-Costing-'+nm+'.pdf',masterCostingAllStyle(d.co));toast('Master Costing Sheet PDF downloaded')}
 catch(err){console.error(err);toast('Master Costing PDF error: '+(err?.message||err))}}
function openRec(id,dup,pr){const x=db.history.find(h=>h.id==id);if(!x)return;
 S[x.type]={type:x.type,tid:x.tid,terms:x.terms,customer:x.customer,w:x.w,h:x.h,t:x.t,qty:x.qty,sell:x.sell,method:x.method,rid:dup?null:x.id,costingName:dup?'':(x.costingName||x.tname||''),frameType:x.frameType||'',subCategory:x.subCategory||'',side:x.side||'',shutterType:x.shutterType||'',finishOption:x.finishOption||'',lines:clone(x.lines)};go(x.type);if(pr)setTimeout(()=>{try{window.print()}catch(e){}},200)}
function delRec(id){ask('Delete '+id+'?',()=>{db.history=db.history.filter(h=>h.id!=id);save();render()})}
async function loadBackups(){
 const r=await api('backups');if(r.error)return toast(r.error);
 const e=document.getElementById('backupList');if(!e)return;
 e.innerHTML=r.backups.length?`<div class="tw"><table><tr><th>Backup</th><th>Created</th><th>Size</th><th></th></tr>${r.backups.map(b=>`<tr><td>${esc(b.name)}</td><td>${esc(b.modified)}</td><td>${Math.round(b.size/1024)} KB</td><td><button onclick="downloadBackup('${esc(b.name)}')">Download</button><button onclick="restoreBackup('${esc(b.name)}')">Restore</button></td></tr>`).join('')}</table></div>`:'No server backups yet.';
}
async function downloadBackup(name){const r=await api('backup_download',{name});if(r.error)return toast(r.error);saveFile(name,JSON.stringify(r.data,null,2));}
async function downloadLatestBackup(){const r=await api('backups');if(r.error||!r.backups?.length)return toast(r.error||'No backups found');downloadBackup(r.backups[0].name)}
function restoreBackup(name){ask('Restore '+name+'? Current server data will be replaced by this snapshot.',async()=>{const r=await api('backup_restore',{name});if(r.error)return toast(r.error);await loadData();toast('Backup restored');render()})}
function setView(){return`<h2>Settings</h2>${coForm()}<div class="pn"><div class="g"><div><label>Currency symbol</label><input value="${esc(db.cur)}" onchange="db.cur=this.value;save();render()"></div>
 <div><label>Theme</label><select onchange="document.documentElement.dataset.theme=this.value"><option value="">None</option><option value="system">System</option><option value="light">Light</option><option value="dark">Dark</option></select></div></div>
 <div class="row"><button onclick="exportMaster()">Export master data (JSON)</button><button onclick="resetAll()">Reset all data</button>${cu?.role==='admin'?`<button onclick="go('users')">Manage Users</button>`:''}<button onclick="go('invoice')">Tax Invoices</button></div>
 ${cu?.role==='admin'?`<hr><h4>Server Backup &amp; Restore</h4><p class="mu">The server keeps an automatic daily snapshot before the first save of each day. Download or restore a snapshot below.</p><div class="row"><button onclick="loadBackups()">Refresh backups</button><button onclick="downloadLatestBackup()">Download latest backup</button></div><div id="backupList" class="mu">Click Refresh backups to view server snapshots.</div>`:''}</div>
 <p class="mu">Costing, quotation and invoice data is stored in the server database. Browser downloads are exports only.</p>
 <h3>Change log</h3>${db.audit.length?`<table>${db.audit.map(a=>`<tr><td class="mu">${a.ts}</td><td>${esc(a.a)}</td></tr>`).join('')}</table>`:'<p class="mu">No changes yet.</p>'}`}
const mopts=sel=>`<option value=""${sel===''?' selected':''}>None</option>`+Object.entries(M).map(([k,v])=>`<option value="${k}"${k==sel?' selected':''}>${v}</option>`).join('');
function sizeCell(ref,i,l){if(!['area','rft','rm'].includes(l.method))return'<td class="mu">not used</td>';
 return`<td><select onchange="setL('${ref}',${i},'size',this.value)"><option value="">None</option><option value="prod">Product size</option><option value="own"${l.size=='own'?' selected':''}>Own size</option></select>${l.size=='own'?`<div class="row" style="margin:4px 0"><input type="number" style="width:76px;min-width:0" placeholder="W mm" value="${l.w??''}" onchange="setL('${ref}',${i},'w',this.value)"><input type="number" style="width:76px;min-width:0" placeholder="H mm" value="${l.h??''}" onchange="setL('${ref}',${i},'h',this.value)"></div>`:''}</td>`}
function tplEditor(id){const t=db.templates.find(x=>x.id==id);if(!t)return'';const ref='T:'+id;
 return`<div class="pn"><h3 style="margin-top:0">Edit BOM: ${esc(t.name)}</h3><div class="tw"><table><tr><th>Component</th><th>Size from</th><th>Method</th><th>Qty / factor</th><th>Price override (blank = material master)</th><th></th></tr>
 ${t.bom.map((l,i)=>{const m=mat(l.mid)||{name:'(deleted item)',cat:'',unit:'',price:0};return`<tr><td>${esc(m.name)}<div class="mu">${esc(m.cat)} · ${esc(m.unit||'')}</div></td>${sizeCell(ref,i,l)}
 <td><select onchange="setL('${ref}',${i},'method',this.value)">${mopts(l.method)}</select></td><td><input type="number" step="any" value="${l.qty}" onchange="setL('${ref}',${i},'qty',this.value)"></td><td><input type="number" min="0" step="any" value="${l.price??''}" placeholder="${esc(m.price||0)}" title="Leave blank to use the current material master price" onchange="setL('${ref}',${i},'price',this.value)"></td>
 <td><button class="x" onclick="delL('${ref}',${i})">✕</button></td></tr>`}).join('')}</table></div>
 <div class="row"><select onchange="addL('${ref}',this.value)" style="max-width:240px"><option value="">+ Add component…</option>${opts(db.materials.filter(m=>m.active),'')}</select><button onclick="useT('${id}')">Use in costing</button><button onclick="mEdit=null;render()">Close</button></div>
 <p class="mu">Changes save to the master template immediately.</p></div>`}
function ask(msg,fn){const o=document.createElement('div');o.className='ov';o.innerHTML=`<div class="pn"><p>${esc(msg)}</p><div class="row"><button class="pri" id="ay">Yes</button><button id="an">Cancel</button></div></div>`;document.body.appendChild(o);$('#an').onclick=()=>o.remove();$('#ay').onclick=()=>{o.remove();fn()}}
function resetAll(){ask('Reset all data to the starting templates? Users and login history are kept.',()=>{db=seed();S={shutter:null,frame:null};D=null;save();render()})}
async function saveFile(name,data){if(DL && !(data instanceof Blob)){try{const r=await DL.save({filename:name,data});toast(r.status=='saved'?name+' sent to your browser downloads. Check your Downloads folder.':'File delivered',5000)}catch(e){toast(e&&e.code=='declined'?'Download cancelled':'Download failed ('+((e&&e.code)||'error')+')',5000)}return}
 const a=document.createElement('a');a.href=URL.createObjectURL(data instanceof Blob?data:new Blob([data]));a.download=name;document.body.appendChild(a);a.click();a.remove()}
function exportCSV(){const q=v=>'"'+String(v??'').replace(/"/g,'""')+'"',rows=[['ID','Type','Date','Customer','Costing Name','Template','Qty','Sq Ft / Unit','Total Sq Ft','Input','Material','Hardware','Labour','Other','Per unit','Total']];
 db.history.filter(x=>x.type!=='door').forEach(x=>rows.push([x.id,x.type,x.date,x.customer,x.costingName||x.tname,x.tname,x.qty,x.sqFt||0,x.totalSqFt||0,x.method,x.mat,x.hw,x.lab,x.oth,x.per,x.total]));saveFile('costing-history.csv',rows.map(r=>r.map(q).join(',')).join('\n'))}
function exportMaster(){saveFile('master-data.json',JSON.stringify({materials:db.materials,templates:db.templates},null,1))}
function pdfRec(id,v){const x=db.history.find(h=>h.id==id);(v?pdfView:pdf)({type:x.type,tid:x.tid,customer:x.customer,terms:x.terms,w:x.w,h:x.h,t:x.t,qty:x.qty,sell:x.sell,lines:x.lines},x.id)}
const rgb=h=>[1,3,5].map(i=>parseInt(h.slice(i,i+2),16)||0);
const pdfSel=()=>`<select style="max-width:210px" onchange="db.pdfT=this.value;save()"><option value="">None</option><option value="quote"${db.pdfT!='cost'?' selected':''}>PDF: Client quotation</option><option value="cost"${db.pdfT=='cost'?' selected':''}>PDF: Detailed cost sheet</option></select>`;
function uploadCompanyLogo(input){
 const file=input.files&&input.files[0]; if(!file)return;
 if(!/^image\/(png|jpeg|jpg|svg\+xml|svg)$/.test(file.type))return toast('Please upload PNG, JPG or SVG logo');
 if(file.size>2*1024*1024)return toast('Logo must be 2 MB or smaller');
 const reader=new FileReader();
 reader.onload=()=>{
   const src=reader.result;
   const img=new Image();
   img.onload=()=>{
     const maxW=900,maxH=350,scale=Math.min(1,maxW/img.naturalWidth,maxH/img.naturalHeight);
     const w=Math.max(1,Math.round(img.naturalWidth*scale)),h=Math.max(1,Math.round(img.naturalHeight*scale));
     const cv=document.createElement('canvas');cv.width=w;cv.height=h;
     const cx=cv.getContext('2d');cx.fillStyle='#ffffff';cx.fillRect(0,0,w,h);cx.drawImage(img,0,0,w,h);
     db.co.logo=cv.toDataURL('image/png');save();render();toast('Quotation logo updated');
   };
   img.onerror=()=>toast('Could not read logo. Please use PNG or JPG.');
   img.src=src;
 };
 reader.onerror=()=>toast('Could not read logo');
 reader.readAsDataURL(file);
}
function removeCompanyLogo(){db.co.logo='';save();render();toast('Quotation logo removed')}
function coForm(){
 const c=db.co||{},f=(k,l,t='text')=>`<div><label>${l}</label><input type="${t}" value="${esc(c[k]||'')}" oninput="db.co.${k}=this.value;save()" onchange="db.co.${k}=this.value;save();render()"></div>`;
 return`<div class="pn"><h3 style="margin-top:0">Company &amp; Quotation Branding</h3>
 <div class="g">${f('name','Company name')}${f('tag','Tagline')}${f('contact','Address / phone / GST (one line)')}
 <div><label>Quotation Header Colour</label><div class="row" style="gap:8px;align-items:center"><input type="color" value="${esc(c.color||'#1f3a4d')}" style="width:58px;height:38px;padding:2px" oninput="db.co.color=this.value;save()"><input value="${esc(c.color||'#1f3a4d')}" oninput="if(/^#[0-9a-fA-F]{6}$/.test(this.value)){db.co.color=this.value;save()}" placeholder="#1f3a4d"></div></div></div>
 <h4>Quotation Logo</h4>
 <div style="padding:12px;border:1px solid #dfe4ea;border-radius:8px;background:#f8fafc">
   <input type="file" accept="image/png,image/jpeg,image/svg+xml" onchange="uploadCompanyLogo(this)">
   <div class="mu" style="margin-top:6px">PNG, JPG or SVG · Maximum 2 MB</div>
   ${c.logo?`<div style="margin-top:10px"><img src="${c.logo}" alt="Quotation Logo" style="max-width:220px;max-height:70px;object-fit:contain;border:1px solid #e5e7eb;background:#fff;padding:6px;border-radius:5px"><div class="row" style="margin-top:8px"><button onclick="removeCompanyLogo()">Remove Logo</button></div></div>`:`<div class="mu" style="margin-top:10px">No quotation logo uploaded.</div>`}
 </div>
 <h4>Quotation Authority / Signatory</h4><div class="g">${f('footerName','Authorized Person Name')}${f('footerMobile','Authorized Person Mobile')}${f('footerEmail','Authorized Person Email','email')}</div>
 <label style="margin-top:8px">Terms &amp; conditions (shown on quotation)</label><textarea rows="4" oninput="db.co.terms=this.value;save()">${esc(c.terms||'')}</textarea></div>`}

const SH={qty:'Qty',area:'Area sq ft',rft:'Run ft',rm:'Run m',kg:'Kg',fixed:'Fixed',pct:'% of subtotal'};
function pdfHtml(s,id){
 const co=db.co||{},r=calc(s),t=db.templates.find(x=>x.id===s.tid),Q=db.pdfT!='cost',A=co.color||'#07569a',sp=+s.sell||0,rs=n=>(db.cur||'₹')+(+n||0).toLocaleString('en-IN',{minimumFractionDigits:2,maximumFractionDigits:2});
 const logo=co.logo?`<img src="${co.logo}" alt="Logo" style="width:155px;max-width:100%;height:100px;object-fit:contain;display:block;margin:auto">`:'';
 const footerName=co.footerName||'',footerMobile=co.footerMobile||'',footerEmail=co.footerEmail||'';
 const footerParts=[footerName,footerMobile,footerEmail].filter(Boolean).join('  | ');
 const head=qHeaderHTML(Q?'QUOTATION':'COSTING SHEET',`<b>${esc(id||'Draft')}</b><br>${qDate(today())}${Q&&s.validTill?`<br>Valid till ${qDate(s.validTill)}`:''}`);
 const info=`<div class="pvr"><div><small>${Q?'PREPARED FOR':'CUSTOMER'}</small><div class="pvb">${esc(s.customer||'-')}</div></div><div style="text-align:right"><small>PRODUCT</small><div class="pvb">${esc(t?t.name:'-')}</div></div></div><div class="pvr pvs">${[['SIZE',(s.w||0)+' x '+(s.h||0)+' mm'],['THICKNESS',s.t?s.t+' mm':'-'],['QUANTITY',s.qty]].map(c=>`<div><small>${c[0]}</small><b>${esc(c[1])}</b></div>`).join('')}</div>`;
 let body;
 if(Q){const L=r.rows.filter(x=>['Material','Hardware'].includes(x.m.cat));body=`<small>SPECIFICATION</small><ul class="pvl">${L.map(x=>`<li>${esc(x.m.name)}</li>`).join('')}</ul><div class="pvbox"><div><small>RATE PER UNIT</small><div class="pvb">${sp?rs(sp):'To be confirmed'}</div></div><div><small>QUANTITY</small><div class="pvb">${esc(s.qty)}</div></div><div style="text-align:right"><small>TOTAL</small><div class="pvb" style="font-size:22px">${sp?rs(sp*(+s.qty||0)):'-'}</div></div></div>`}
 else body=`<div class="cost-section-title">Cost to Company — Detailed Cost Breakdown</div><table class="pvtb"><tr><th>Component</th><th>Basis</th><th>Sq. Ft.</th><th>Qty</th><th>Rate</th><th>Amount</th></tr>${r.rows.map(x=>`<tr><td>${esc(x.m.name)}</td><td>${SH[x.l.method]}${x.l.size=='own'&&['area','rft','rm'].includes(x.l.method)?' ('+x.l.w+' x '+x.l.h+')':''}</td><td>${lineSqFt(s,x.l).toFixed(2)}</td><td>${x.l.qty}</td><td>${x.p}</td><td>${rs(x.a)}</td></tr>`).join('')}</table><div class="pvsum">${CATS.filter(c=>r.by[c]).map(c=>`<div><span>${c=='Material'?'Raw material':c}</span><span>${rs(r.by[c])}</span></div>`).join('')}<div><span>Wastage included</span><span>${rs(r.waste)}</span></div><div class="pvtot" style="background-color:#07569a!important;background:#07569a!important;color:#ffffff!important;padding:9px 10px;margin:6px 0;font-weight:700;display:flex;justify-content:space-between;align-items:center;-webkit-print-color-adjust:exact;print-color-adjust:exact"><span style="color:#ffffff!important">Cost per unit</span><span style="color:#ffffff!important;font-weight:700">${rs(r.unit)}</span></div><div class="pvgrand" style="background-color:#07569a!important;background:#07569a!important;color:#ffffff!important;padding:10px 10px;margin:6px 0;display:flex;justify-content:space-between;align-items:center;font-weight:700;-webkit-print-color-adjust:exact;print-color-adjust:exact"><b style="color:#ffffff!important">Total Cost (× ${esc(s.qty)})</b><b style="font-size:18px;color:#ffffff!important">${rs(r.total)}</b></div>${sp?`<div><span>Selling price / unit</span><span>${rs(sp)}</span></div><div><span>Profit / unit</span><span>${rs(sp-r.unit)}</span></div><div><span>Margin</span><span>${((sp-r.unit)/sp*100).toFixed(1)}%</span></div>`:''}</div>`;
 const footer=`<div class="cost-footer"><span>${esc(footerParts||co.contact||co.name||'')}</span><span>Costing Sheet</span></div>`;
 return`${qStyle()}<style>.cost-section-title{font-size:16px;font-weight:700;color:#111;margin:22px 0 10px}.pvtb{width:100%;border-collapse:collapse;font-size:9px}.pvtb th{background:#07569a!important;color:#fff;padding:8px}.pvtb td{padding:7px;border:1px solid #d9e1e7}.pvsum .pvtot{background:#07569a!important;background-color:#07569a!important;color:#fff!important;padding:9px 10px;margin:6px 0;font-weight:700;-webkit-print-color-adjust:exact;print-color-adjust:exact}.pvsum .pvtot span{color:#fff!important}.pvtot span:last-child{font-weight:700}.pvsum .pvgrand{background:#07569a!important;color:#fff!important;padding:9px 10px;margin:6px 0;display:flex;justify-content:space-between;align-items:center;font-weight:700;border-radius:0}.pvsum .pvgrand b{color:#fff!important}.pvp{font-family:Arial,sans-serif;color:#182334;width:210mm;height:297mm;box-sizing:border-box;padding:49mm 15mm 18mm;background:#fff;position:relative;border:2.5px solid ${A};outline:1px solid ${A};outline-offset:-6px;overflow:hidden;page-break-after:always}.pvp:before{content:'';position:absolute;left:1.6mm;top:1.6mm;right:1.6mm;bottom:1.6mm;border:1px solid ${A};pointer-events:none;z-index:5}.pvp .q-header{border-bottom:0}.pvp .cost-footer{margin-top:20mm;padding-top:4mm;border-top:1px solid #d9e1e7;display:flex;justify-content:space-between;font-size:8px;color:#6d7880}</style><div class="pvp">${head}<div class="pvbd">${info}${body}</div>${footer}</div>`}
function pdfView(s,id){const o=document.createElement('div');o.className='ov pvo';o.innerHTML=`<div class="pvw"><div class="row" style="margin-top:0"><button class="pri" id="pv_d">Download PDF</button><button id="pv_c">Close</button></div>${pdfHtml(s,id)}</div>`;document.body.appendChild(o);$('#pv_c').onclick=()=>o.remove();$('#pv_d').onclick=()=>pdf(s,id)}
async function pdf(s,id){
 try{
   const name=String(id||s.costingName||'Costing').replace(/[^a-z0-9_-]+/gi,'-');
   await downloadHTMLPagesPDF(pdfHtml(s,id),'.pvp',`${name}.pdf`, '');
   toast('PDF downloaded');
 }catch(err){console.error(err);toast('PDF error: '+(err?.message||err));}
}

try{claude.use('downloads').then(d=>{DL=d;render()})}catch(e){}
const ROLES=['admin','manager','estimator','viewer'],P={manager:['cost','save','tpl','del'],estimator:['cost','save'],viewer:[]},PG={dash:1,hist:1,shutter:'cost',frame:'cost',door:'cost',quote:'cost',invoice:'cost',crm:'cost',master:'tpl',set:'*',users:'*'};
const can=a=>!!cu&&(cu.role=='admin'||(P[cu.role]||[]).includes(a)),allowed=p=>PG[p]===1||can(PG[p]);
async function ensureMasterSpecs(){
 const legacySh=['30 mm Shutter','35 mm Shutter','40 mm Shutter','45 mm Shutter','50 mm Shutter'];
 db.templates=(db.templates||[]).filter(t=>!legacySh.includes(String(t.name||'')));
 const mt=db.materials||[];
 const byName=n=>mt.find(m=>m.name===n);
 const L=(n,method,qty=1)=>{const m=byName(n);return m?{mid:m.id,method,qty}:null};
 const shBom=[L('Ply','area'),L('Laminate','area'),L('Core Material','area'),L('Fevicol','kg',0.1),L('Hinges','qty',3),L('Handle','qty'),L('Lock','qty'),L('Other Hardware','qty'),L('Labour','fixed'),L('Electricity','fixed'),L('Packaging','fixed'),L('Transport','fixed'),L('Other Cost','fixed')].filter(Boolean);
 const frBom=[L('Base Ply','rft'),L('Base Laminate','rft'),L('Cover Moulding','rft'),L('Fevicol','kg',0.05),L('Nails','qty',20),L('Other Hardware','qty'),L('Labour','fixed'),L('Electricity','fixed'),L('Transport','fixed'),L('Other Cost','fixed')].filter(Boolean);
 const add=(o)=>{if(!db.templates.some(t=>t.type===o.type && (o.type==='shutter'?t.shutterType===o.shutterType&&t.side===o.side:t.frameType===o.frameType&&t.subCategory===o.subCategory&&t.thickness===o.thickness))){db.templates.push({...o,id:'t'+(db.tid++),active:true,bom:clone(o.type==='shutter'?shBom:frBom)})}};
 [['Post Forming','Both Side'],['Post Forming','Single Side'],['Square','Both Side'],['Square','Single Side']].forEach(([a,b])=>add({type:'shutter',name:`${a} - ${b}`,shutterType:a,side:b}));
 [['Post Forming','Wall to Wall Standard'],['Post Forming','Double Rivet'],['Square Frame','Wall to Wall'],['Square Frame','Double Rivet']].forEach(([ft,sub])=>['25+18','18+12'].forEach(th=>add({type:'frame',name:`${ft} - ${sub} - ${th}`,frameType:ft,subCategory:sub,thickness:th})));
 add({type:'frame',name:'Standard Frame - As per existing',frameType:'Standard Frame',subCategory:'As per existing',thickness:'As per existing'});
 db.tid=Math.max(100,...db.templates.map(t=>parseInt(String(t.id).replace(/\D/g,''),10)||0))+1;
}
async function boot(){render();const r=await api('me');if(r.error)AS='err';else if(r.user){cu=r.user;await loadData()}else AS=r.setup?'setup':'login';render()}
async function loadData(){const r=await api('load'),d=r.data;db=Object.assign(seed(),d||{});db.fieldOptions=Object.assign({},seed().fieldOptions,db.fieldOptions||{});ensureMasterSpecs();db.quotations=db.quotations||[];db.quotations.forEach(normalizeQuotation);db.taxInvoices=db.taxInvoices||[];db.crm=db.crm||[];db.qseq=db.qseq||1;db.invseq=db.invseq||1;db.co=Object.assign({...CO0},db.co||{});db.pdfT=db.pdfT||'quote';ready=true;page='dash';AS='app';
 if(d){const x={...db};delete x.users;delete x.logins;lastJ=JSON.stringify(x)}else{lastJ='';save()}}
function authView(){
 const brand=esc(db.co.name&&db.co.name!='Your Company'?db.co.name:'Costing Builder'),
 W=h=>`<div class="au"><div class="l"><div class="bd">${brand}</div><div><div class="hl">Costing for door, shutter and frame manufacturers.</div><p>Pick a template, enter the size and quantity, and get the full manufacturing cost with a client-ready quotation.</p></div><div class="sm">Sign-in is protected by email verification.</div></div><div class="r"><div class="f">${h}</div></div></div>`;
 if(AS=='load')return W('<p class="mu">Loading…</p>');
 if(AS=='err')return W('<h2>Cannot reach the server</h2><p class="mu">Upload api.php next to index.html and make sure PHP is enabled.</p><div class="row"><button class="pri" onclick="boot()">Try again</button></div>');
 if(AS=='setup')return W(`<h2>Set up the master admin</h2><p class="mu">This is done once. We email a 6-digit code to confirm the address.</p><label>Full name</label><input id="an_n" value="${esc(SU.n||'')}"><label>Email</label><input id="an_e" type="email" value="${esc(SU.e||'')}"><label>Password (8+ characters)</label><input id="an_p" type="password" onkeydown="if(event.key==='Enter')doSetup()"><div class="row"><button class="pri" onclick="doSetup()">Send verification code</button></div>`);
 if(AS=='otp')return W(`<h2>Check your email</h2><p class="mu">We sent a 6-digit code to ${esc(SU.e)}. It expires in 10 minutes.</p><label>Verification code</label><input id="an_o" inputmode="numeric" maxlength="6" autocomplete="one-time-code" onkeydown="if(event.key==='Enter')doVerify()"><div class="row"><button class="pri" onclick="doVerify()">Verify and continue</button></div><div class="row"><button class="x" onclick="sendOtp()">Send a new code</button><button class="x" onclick="AS='setup';render()">Change details</button></div>`);
 return W(`<h2>Sign in</h2><p class="mu">Use the email and password your admin gave you.</p><label>Email</label><input id="an_e" type="email" autocomplete="username"><label>Password</label><input id="an_p" type="password" autocomplete="current-password" onkeydown="if(event.key==='Enter')doLogin()"><div class="row"><button class="pri" onclick="doLogin()">Sign in</button></div>`)}
async function doSetup(){SU={n:$('#an_n').value.trim(),e:$('#an_e').value.trim().toLowerCase(),p:$('#an_p').value};await sendOtp()}
async function sendOtp(){const r=await api('setup_start',{name:SU.n,email:SU.e,password:SU.p});if(r.error)return toast(r.error);AS='otp';if(r.dev_otp)toast('Test code: '+r.dev_otp);render()}
async function doVerify(){const r=await api('setup_verify',{email:SU.e,otp:$('#an_o').value.trim()});if(r.error)return toast(r.error);SU={};cu=r.user;await loadData();render()}
async function doLogin(){const r=await api('login',{email:$('#an_e').value.trim().toLowerCase(),password:$('#an_p').value});if(r.error)return toast(r.error);cu=r.user;await loadData();render()}
async function logout(){await push();await api('logout');cu=null;ready=false;db=seed();S={shutter:null,frame:null};D=null;AS='login';render()}
async function loadUsers(){const r=await api('users');UL=r.users||[];LH=r.logins||[]}
function usersView(){const ro=sel=>`<option value=""${sel===''?' selected':''}>None</option>`+ROLES.map(x=>`<option${x==sel?' selected':''}>${x}</option>`).join('');
 return`<h2>Users</h2><div class="pn"><h3 style="margin-top:0">Add user</h3><div class="g"><div><label>Full name</label><input id="nu_n"></div><div><label>Email</label><input id="nu_u" type="email"></div><div><label>Password (8+)</label><input id="nu_p" type="password"></div><div><label>Role</label><select id="nu_r">${ro('estimator')}</select></div></div><div class="row"><button class="pri" onclick="addU()">Add user</button></div>
 <p class="mu">Admin: everything. Manager: costing, history, templates. Estimator: costing and history. Viewer: dashboard and history only.</p></div>
 <div class="tw"><table><tr><th>Name</th><th>Email</th><th>Role</th><th>Active</th><th>Last login</th><th></th></tr>
 ${UL.map(u=>`<tr><td>${esc(u.name)}${u.master?' <span class="mu">(master admin)</span>':''}</td><td>${esc(u.email)}</td><td>${u.master||u.id==cu.id?u.role:`<select onchange="setU(${u.id},'role',this.value)">${ro(u.role)}</select>`}</td>
 <td>${u.master||u.id==cu.id?'':`<input type="checkbox" ${u.active?'checked':''} onchange="setU(${u.id},'active',this.checked)">`}</td><td class="mu">${u.last||'-'}</td>
 <td style="white-space:nowrap"><button class="x" onclick="pw(${u.id})">Reset password</button>${u.master||u.id==cu.id?'':` <button class="x" onclick="delU(${u.id})">✕</button>`}</td></tr>`).join('')}</table></div>
 <h3>Login history</h3>${LH.length?`<div class="tw"><table><tr><th>Time</th><th>Email</th><th>Result</th><th>IP</th></tr>${LH.map(l=>`<tr><td class="mu">${l.ts}</td><td>${esc(l.email)}</td><td class="${/^(Success|Logout|Master)/.test(l.result)?'':'warn'}">${l.result}</td><td class="mu">${esc(l.ip)}</td></tr>`).join('')}</table></div>`:'<p class="mu">No logins yet.</p>'}`}
async function addU(){const r=await api('add_user',{name:$('#nu_n').value.trim(),email:$('#nu_u').value.trim().toLowerCase(),password:$('#nu_p').value,role:$('#nu_r').value});if(r.error)return toast(r.error);await loadUsers();render();toast('User added')}
async function setU(id,field,value){const r=await api('set_user',{id,field,value});if(r.error)toast(r.error);await loadUsers();render()}
function delU(id){const u=UL.find(x=>x.id==id);ask('Delete '+u.email+'?',async()=>{const r=await api('del_user',{id});if(r.error)toast(r.error);await loadUsers();render()})}
function pw(id){const self=!id||id==cu.id,u=self?cu:UL.find(x=>x.id==id),o=document.createElement('div');o.className='ov';
 o.innerHTML=`<div class="pn"><h3 style="margin-top:0">${self?'Change password':'Reset password: '+esc(u.email)}</h3>${self?'<label>Current password</label><input id="pw_o" type="password">':''}<label>New password (8+ characters)</label><input id="pw_n" type="password"><div class="row"><button class="pri" id="pw_s">Save</button><button id="pw_c">Cancel</button></div></div>`;
 document.body.appendChild(o);$('#pw_c').onclick=()=>o.remove();
 $('#pw_s').onclick=async()=>{const n=$('#pw_n').value;if(n.length<8)return toast('Use 8+ characters');const r=self?await api('change_password',{old:$('#pw_o').value,new:n}):await api('reset_password',{id:u.id,new:n});if(r.error)return toast(r.error);o.remove();toast('Password updated')}}
async function go(p){if(!allowed(p))return toast('Your role cannot open this page');if(p=='users')await loadUsers();page=p;render();scrollTo(0,0)}
/* ===== QUOTATION MODULE ===== */
function qMoney(n){return (db.cur||'₹')+(+n||0).toLocaleString('en-IN',{minimumFractionDigits:2,maximumFractionDigits:2})}
function qDate(d){return new Date(d||Date.now()).toLocaleDateString('en-GB',{day:'2-digit',month:'short',year:'numeric'})}
function qNextNo(){return 'Q-'+String(db.qseq++).padStart(4,'0')}
function uid(prefix='ID'){return prefix+'-'+Date.now().toString(36)+'-'+Math.random().toString(36).slice(2,8)}
function qGroups(lines){const g={'Shutter Construction':[],'Hardware':[],'Installation & Other':[]};(lines||[]).forEach((x)=>{const m=mat(x.mid)||{name:x.name||'Component',cat:x.cat||'Other',unit:x.unit||''};const item={name:m.name,unit:m.unit||x.unit||'Nos',qty:x.qty??1};if(m.cat==='Material')g['Shutter Construction'].push(item);else if(m.cat==='Hardware')g['Hardware'].push(item);else g['Installation & Other'].push(item)});return g}
function qItems(q){let a;if(Array.isArray(q.items))a=q.items;else if(q&&q.product)a=[{id:q.id,sourceId:q.sourceId||'',type:q.type||'Costing',product:q.product||'Custom Product',description:q.description||'',unit:q.unit||'Nos',qty:+q.qty||1,w:+q.w||0,h:+q.h||0,t:+q.t||0,costToCompany:q.costToCompany==null?null:+q.costToCompany,rate:+q.rate||0,lines:clone(q.lines||[]),sizeText:q.sizeText||'',manual:false}];else a=[];a.forEach(ensureBreakups);return a}
function qBreakups(x){if(Array.isArray(x.breakups)&&x.breakups.length)return x.breakups;return [{id:uid('QD'),title:x.product||'Detailed Item',sizeText:x.sizeText||((x.w||x.h)?`${x.w||'-'} × ${x.h||'-'} mm${x.t?' | '+x.t+' mm':''}`:''),description:x.description&&!x.descriptionAuto?x.description:qDescription(x),unit:x.unit||'Nos',rate:+x.rate||0,qty:1}]}
function qBreakupTotal(x){return qBreakups(x).reduce((a,b)=>a+(+b.rate||0)*(+b.qty||0),0)}
function ensureBreakups(x){x.breakups=qBreakups(x);return x}
function addQuotationBreakup(i){const x=ensureBreakups(window._qEdit.items[i]);x.breakups.push({id:uid('QD'),title:'New Detail',sizeText:'',description:'',unit:x.unit||'Nos',rate:0,qty:1});render()}
function removeQuotationBreakup(i,j){const x=ensureBreakups(window._qEdit.items[i]);if(x.breakups.length<=1)return toast('Keep at least one detailed item');x.breakups.splice(j,1);render()}
function qBreakupSet(i,j,k,v){const x=ensureBreakups(window._qEdit.items[i]);x.breakups[j][k]=v;if(k==='description')x.breakups[j].descriptionAuto=false;render()}
function qBreakupNumSet(i,j,k,v){const x=ensureBreakups(window._qEdit.items[i]);x.breakups[j][k]=v===''?'':+v;render()}

function normalizeQuotation(q){
 if(!q)return q;
 if(q.proposalPercent==null || !isFinite(+q.proposalPercent) || +q.proposalPercent<0)q.proposalPercent=25;
 (q.items||[]).forEach(x=>{
   if(x.costToCompany!=null && (+x.costToCompany||0)>0 && (+x.rate||0)<=0){
     x.qvMode='percent'; x.qvPercent=25; x.rate=(+x.costToCompany||0)*1.25; x.qvPrice=x.rate; qScaleBreakupToRate(x,x.rate);
   }
   if((+x.qvPercent||0)<0){x.qvMode='percent';x.qvPercent=25;if((+x.costToCompany||0)>0){x.rate=(+x.costToCompany||0)*1.25;x.qvPrice=x.rate;qScaleBreakupToRate(x,x.rate)}}
   if(!x.sizeText && (x.w||x.h))x.sizeText=`${x.w||'-'} × ${x.h||'-'} mm${x.t?' | '+x.t+' mm':''}`;
 });
 return q;
}
function quotationLoss(q){const z=qCalc(q);return z.sub+0.005<z.internalCost}
function qCalc(q){const items=qItems(q),internalCost=items.reduce((a,x)=>a+(x.costToCompany==null?0:(+x.costToCompany||0))*(+x.qty||0),0),proposalPercent=Math.max(0,+q.proposalPercent||0),proposalValue=internalCost*(1+proposalPercent/100),sub=items.reduce((a,x)=>a+(+x.rate||0)*(+x.qty||0),0),dp=Math.max(0,+q.discountPercent||0),da=sub*dp/100,tax=sub-da,gp=Math.max(0,+q.gstPercent||0),ga=tax*gp/100;return{sub,dp,da,tax,gp,ga,grand:tax+ga,items,internalCost,proposalPercent,proposalValue}}
function applyProposalPercent(){const q=window._qEdit;if(!q)return;const pct=Math.max(0,+q.proposalPercent||0),factor=1+pct/100;q.items=(q.items||[]).map(x=>{if(x.costToCompany==null)return x;const newRate=(+x.costToCompany||0)*factor,bs=qBreakups(x),oldTotal=qBreakupTotal(x);if(bs.length){if(oldTotal>0){const scale=newRate/oldTotal;bs.forEach(b=>b.rate=(+b.rate||0)*scale)}else{bs.forEach((b,i)=>b.rate=i===0?newRate:0)}x.breakups=bs}x.rate=newRate;return x});render();toast('Proposal % applied to quotation rates')}
function qDescription(x){
 if(x.description && !x.descriptionAuto && !/^(?:Size:|Supply \/ Construction:|Construction \/ Materials:|Hardware:|Hardware Included:|Labour \/ Installation:|Labour & Installation:|Other included works:|Other Included Works:)/i.test(String(x.description).trim()))return String(x.description).trim();
 const out=[];
 if(x.w||x.h)out.push(`Size: ${x.w||'-'} × ${x.h||'-'} mm`);
 if(x.t)out.push(`Shutter / Frame Thickness: ${x.t} mm`);
 const gs=qGroups(x.lines||[]);
 const mats=gs['Shutter Construction'].map(a=>a.name).filter(Boolean);
 const hw=gs['Hardware'].map(a=>a.name).filter(Boolean);
 const other=gs['Installation & Other'].map(a=>a.name).filter(Boolean);
 const labour=other.filter(n=>/labou?r|installation|fixing|fitting|electric|workmanship/i.test(n));
 const other2=other.filter(n=>!labour.includes(n));
 if(mats.length){out.push('Construction / Materials:');mats.forEach(n=>out.push('• '+n));}
 if(hw.length){out.push('Hardware Included:');hw.forEach(n=>out.push('• '+n));}
 if(labour.length){out.push('Labour & Installation:');labour.forEach(n=>out.push('• '+n));}
 if(other2.length){out.push('Other Included Works:');other2.forEach(n=>out.push('• '+n));}
 return out.join('\n')||'Supply and installation as per approved specification.'
}
function qLabel(q){return `${q.id||'DRAFT'}${q.revision?` Rev ${q.revision}`:''}`}
function qWords(n){
 n=Math.round(+n||0);if(!n)return 'Zero Rupees Only';
 const ones=['','One','Two','Three','Four','Five','Six','Seven','Eight','Nine','Ten','Eleven','Twelve','Thirteen','Fourteen','Fifteen','Sixteen','Seventeen','Eighteen','Nineteen'];
 const tens=['','','Twenty','Thirty','Forty','Fifty','Sixty','Seventy','Eighty','Ninety'];
 const two=x=>x<20?ones[x]:tens[Math.floor(x/10)]+(x%10?' '+ones[x%10]:'');
 const seg=x=>{let a=[];if(x>=100){a.push(ones[Math.floor(x/100)]+' Hundred');x%=100}if(x)a.push(two(x));return a.join(' ')};
 let a=[];if(n>=10000000){a.push(seg(Math.floor(n/10000000))+' Crore');n%=10000000}if(n>=100000){a.push(seg(Math.floor(n/100000))+' Lakh');n%=100000}if(n>=1000){a.push(seg(Math.floor(n/1000))+' Thousand');n%=1000}if(n)a.push(seg(n));return a.join(' ')+' Rupees Only';
}
function qApplyTemplate(id){
 const t=(db.termTemplates||[]).find(x=>x.id===id);if(!t||!window._qEdit)return;
 window._qEdit.payment=t.payment||'';window._qEdit.terms=t.terms||'';render();toast('Quotation terms template applied');
}
function qSaveTemplate(){
 if(!window._qEdit)return;
 const name=prompt('Template name');if(!name)return;
 db.termTemplates=db.termTemplates||[];db.termTemplates.push({id:uid('TT'),name:name.trim(),payment:window._qEdit.payment||'',terms:window._qEdit.terms||''});
 save();render();toast('Terms template saved');
}
function duplicateQuotation(id){
 const q=savedQ(id);if(!q)return;
 const n=clone(q);n.id=qNextNo();n.revision=1;n.revisionHistory=[];n.savedAt='';n.createdAt=new Date().toISOString();n.userId=cu?.id||null;n.user=cu?.name||'';window._qEdit=n;window._qPick=null;render();toast('Quotation copied as '+qLabel(n));
}
function convertQuotationToInvoice(id){
 const q=savedQ(id);if(!q)return toast('Quotation not found');
 const z=qCalc(q),inv=blankInvoice();
 inv.billed.name=q.customer||'';inv.consignee.name=q.customer||'';inv.building=q.company||'';inv.woNo=qLabel(q);inv.nature=q.subject||'WOOD DOORS SUPPLY';inv.terms=q.terms||'';
 inv.items=z.items.map(x=>({particular:x.product||'Supply & Installation',hsn:x.hsn||'',qty:+x.qty||1,unit:x.unit||'Nos',rate:+x.rate||0}));
 inv.sourceQuotationId=q.id;window._invEdit=inv;window._invPick=null;go('invoice');toast('Quotation '+qLabel(q)+' converted to Tax Invoice');
}
function qStatusOf(q){const r=(db.crm||[]).find(x=>x.quotationId===q.id);const st=r?.status||q.status||'Draft';if(q.validTill&&q.validTill<today()&&!['Won','Lost'].includes(st))return 'Expired';return st}
function qSetStatus(id,status){
 const q=savedQ(id);if(!q)return;
 q.status=status||'Draft';
 const r=syncCRMForQuotation(q);r.status=status||'Draft';
 q.savedAt=new Date().toISOString();
 db.audit.unshift({ts:new Date().toLocaleString(),a:(cu?cu.name+': ':'')+'changed quotation '+qLabel(q)+' status to '+r.status});
 save();render();toast(qLabel(q)+' status updated to '+r.status);
}
function qTabSet(tab){qTab=tab;render()}
function quotationView(){
 const qs=db.quotations||[];
 if(window._qEdit){return `<div class="row" style="margin-bottom:10px"><button onclick="closeQuotationEditor()">← Back to Quotations</button></div>${quotationEditor(window._qEdit)}${window._qPick?quotationPicker():''}`;}
 const statuses=['Draft','Sent','Follow-up','Negotiation','Won','Lost','Expired'];
 const counts=Object.fromEntries(statuses.map(st=>[st,qs.filter(q=>qStatusOf(q)===st).length]));
 let filtered=qs;
 if(qTab==='all') filtered=qs;
 else if(qTab==='recent') filtered=qs.slice(0,5);
 else filtered=qs.filter(q=>qStatusOf(q)===qTab);
 return `<h2>Quotation</h2>
 <div class="pn"><div class="row"><button type="button" class="pri" id="qNewBtn">+ New Quotation</button><button type="button" id="qAddCostBtn">+ Add from Costing</button></div><p class="mu">Quotation is separate from costing. You can combine multiple saved Shutter/Frame costings, add manual items, edit client-facing descriptions and independently set selling rates.</p></div>
 <div class="pn q-tabs-panel"><div class="q-proposal-tabs">
   <button class="q-tab ${qTab==='recent'?'on':''}" onclick="qTabSet('recent')">Recent <span>${Math.min(5,qs.length)}</span></button>
   <button class="q-tab ${qTab==='all'?'on':''}" onclick="qTabSet('all')">All Proposals <span>${qs.length}</span></button>
   ${statuses.map(st=>`<button class="q-tab ${qTab===st?'on':''}" onclick="qTabSet('${st}')">${st} <span>${counts[st]||0}</span></button>`).join('')}
 </div></div>
 ${filtered.length?`<div class="pn"><div class="row" style="justify-content:space-between;margin-top:0"><b>${qTab==='recent'?'Recent Proposals':qTab==='all'?'All Proposals':qTab+' Proposals'}</b><span class="mu">${filtered.length} proposal${filtered.length===1?'':'s'}</span></div><div class="tw"><table class="q-proposal-list"><tr><th>Quotation</th><th>Date</th><th>Customer</th><th>Items</th><th>Internal Cost</th><th>Quotation Value</th><th>Status</th><th>Actions</th></tr>${filtered.map(q=>{const z=qCalc(q),cost=z.items.reduce((a,x)=>a+(x.costToCompany==null?0:(+x.costToCompany||0))*(+x.qty||0),0),status=qStatusOf(q);return `<tr class="${quotationLoss(q)?'q-loss-row':''}"><td><b>${esc(qLabel(q))}</b><div class="mu" style="font-size:11px">Rev. ${+q.revision||1}</div></td><td>${esc(q.date||'-')}</td><td>${esc(q.customer||'-')}</td><td>${z.items.length}</td><td>${qMoney(cost)}</td><td>${qMoney(z.grand)}${quotationLoss(q)?'<div class="mu" style="color:#b00020">Below internal cost</div>':''}</td><td><select class="q-status-edit" onchange="qSetStatus('${q.id}',this.value)">${['Draft','Sent','Follow-up','Negotiation','Won','Lost','Expired'].map(st=>`<option value="${st}"${status===st?' selected':''}>${st}</option>`).join('')}</select></td><td class="q-actions"><button class="q-action-edit pri" onclick="editQuotation('${q.id}')">Edit</button><button onclick="previewSavedQuotation('${q.id}')">Preview</button><button onclick="downloadSavedQuotationPDF('${q.id}')">PDF</button><button onclick="showQuotationMore('${q.id}',this)">⋯</button></td></tr>`}).join('')}</table></div></div>`:'<div class="pn"><p class="mu">No quotations in this tab.</p></div>'}
 ${window._qEdit?`<div class="row" style="margin-bottom:10px"><button onclick="closeQuotationEditor()">← Back to Quotations</button></div>`+quotationEditor(window._qEdit):''}${window._qPick?quotationPicker():''}`
}
function closeQuotationEditor(){window._qEdit=null;window._qPick=null;qSelectedCostings=[];render()}
function qOpenAddPicker(){window._qPick='costing';qSelectedCostings=[];if(!window._qEdit)window._qEdit=blankQuotation();render()}
function qPickTypeSet(v){window._qPick=v||'costing';qSelectedCostings=[];render()}
function showQuotationMore(id,btn){const q=savedQ(id);if(!q)return;const menu=document.createElement('div');menu.className='q-more-menu';menu.innerHTML=`<button onclick="duplicateQuotation('${id}');this.parentElement.remove()">Duplicate</button><button onclick="downloadSavedQuotationWord('${id}');this.parentElement.remove()">Word</button><button onclick="convertQuotationToInvoice('${id}');this.parentElement.remove()">Invoice</button><button onclick="openCRMForQuotation('${id}');this.parentElement.remove()">CRM</button>`;menu.style.position='absolute';menu.style.zIndex=9999;menu.style.background='#fff';menu.style.border='1px solid #d9e2ea';menu.style.padding='6px';menu.style.borderRadius='8px';menu.style.boxShadow='0 8px 25px rgba(0,0,0,.15)';document.body.appendChild(menu);const r=btn.getBoundingClientRect();menu.style.left=(r.right-170)+'px';menu.style.top=(r.bottom+4)+'px';setTimeout(()=>document.addEventListener('click',function h(e){if(!menu.contains(e.target)){menu.remove();document.removeEventListener('click',h)}},{once:false}),0)}
function bindQuotationPageActions(){
 const b=(id,fn)=>{const el=document.getElementById(id);if(el){el.onclick=(e)=>{e.preventDefault();fn();};}};
 b('qNewBtn',newQuotation); b('qAddCostBtn',qOpenAddPicker); b('qImportBtn',quotationFromCosting); b('qImportShutterBtn',quotationFromShutter); b('qImportFrameBtn',quotationFromFrame); b('qImportDoorBtn',quotationFromDoor);
 const add=document.getElementById('qAddSelectedBtn'); if(add)add.onclick=(e)=>{e.preventDefault();importSelectedQuotations();};
 const close=document.getElementById('qPickerCloseBtn'); if(close)close.onclick=(e)=>{e.preventDefault();window._qPick=null;qSelectedCostings=[];render();};
}
function blankQuotation(){return {customFields:{},id:qNextNo(),date:today(),validTill:new Date(Date.now()+15*86400000).toISOString().slice(0,10),customer:'',subject:'Quotation for Supply & Installation of Door & Frame Works',product:'',unit:'Nos',qty:1,w:0,h:0,t:0,costToCompany:null,rate:0,discountPercent:0,proposalPercent:25,gstPercent:18,lines:[],items:[],terms:db.co.terms||'',payment:'50% Mobilization Advance against Purchase Order.\n40% payment at the time of delivery.\n10% against final bill.',attention:'',address:'',company:'',crmDescription:'',intro:'With reference to the subject matter, we hereby submit our quotation for supply & installation of door and frame works for your project.'}}
function newQuotation(){try{window._qEdit=blankQuotation();window._qPick=null;qSelectedCostings=[];render()}catch(e){console.error(e);toast('Could not create quotation: '+(e.message||e))}}
function quotationFromCosting(){window._qPick='costing';qSelectedCostings=[];if(!window._qEdit)window._qEdit=blankQuotation();render()}
function quotationFromShutter(){window._qPick='shutter';qSelectedCostings=[];if(!window._qEdit)window._qEdit=blankQuotation();render()}
function quotationFromFrame(){window._qPick='frame';qSelectedCostings=[];if(!window._qEdit)window._qEdit=blankQuotation();render()}
function quotationFromDoor(){window._qPick='door';qSelectedCostings=[];if(!window._qEdit)window._qEdit=blankQuotation();render()}
window.newQuotation=newQuotation;window.quotationFromCosting=quotationFromCosting;window.quotationFromShutter=quotationFromShutter;window.quotationFromFrame=quotationFromFrame
function quotationPicker(){if(!window._qPick)return '';let h=db.history||[];if(window._qPick==='costing')h=h.filter(x=>['shutter','frame','door'].includes(x.type));else h=h.filter(x=>x.type===window._qPick);return `<div class="ov pvo"><div class="pn" style="max-width:1000px;width:100%"><h3>Add from Costing</h3><div class="row"><label style="margin:0">Type <select onchange="qPickTypeSet(this.value)"><option value="costing"${window._qPick==='costing'?' selected':''}>All Costings</option><option value="shutter"${window._qPick==='shutter'?' selected':''}>Shutter</option><option value="frame"${window._qPick==='frame'?' selected':''}>Frame</option><option value="door"${window._qPick==='door'?' selected':''}>Door</option></select></label></div><p class="mu">Select one or more saved costings. Door Costing is a complete Shutter + Frame + Labour package; it can be imported directly into the quotation.</p><div class="tw"><table><tr><th><input type="checkbox" onchange="toggleAllCostings(this.checked)"></th><th>ID</th><th>Type</th><th>Date</th><th>Customer</th><th>Product</th><th>Cost / Unit</th><th>Qty</th></tr>${h.length?h.map(x=>`<tr><td><input class="qpick" type="checkbox" value="${esc(x.id)}" data-id="${esc(x.id)}" onchange="qPickChange(this)"></td><td>${esc(x.id)}</td><td>${esc(x.type==='shutter'?'Shutter Costing':x.type==='frame'?'Frame Costing':x.type==='door'?'Door Costing':x.type||'-')}</td><td>${esc(x.date)}</td><td>${esc(x.customer||'-')}</td><td>${esc(x.tname||'-')}</td><td>${qMoney(x.per)}</td><td>${x.qty||1}</td></tr>`).join(''):`<tr><td colspan="8" class="mu">No saved costings found.</td></tr>`}</table></div><div class="row" style="margin-top:10px"><button type="button" class="pri" id="qAddSelectedBtn">Add Selected Costings</button><button type="button" id="qPickerCloseBtn">Close</button></div></div></div>`}
function toggleAllCostings(on){document.querySelectorAll('.qpick').forEach(e=>{e.checked=on});qSelectedCostings=on?[...document.querySelectorAll('.qpick')].map(e=>String(e.dataset.id||e.value)):[];}
function qPickChange(el){const id=String(el.dataset.id||el.value||'');if(el.checked){if(!qSelectedCostings.includes(id))qSelectedCostings.push(id)}else{qSelectedCostings=qSelectedCostings.filter(x=>x!==id)}}
function costingToQuotationItem(x){
 const spec={w:x.w,h:x.h,t:x.t,lines:x.lines||[]};
 if(x.type==='door'){
   const rate=+x.sell>0?+x.sell:(+x.per||0)*1.25;
   const sh=+x.shutterCTC||0,fr=+x.frameCTC||0,lb=+x.labour||(+x.labourQty||0)*(+x.labourRate||0);
   return {id:uid('QI'),sourceId:x.id,type:'Door Costing',product:x.tname||'Door',customer:x.customer||'',description:`Complete door package: ${x.shutterId?'Shutter included':'No shutter costing selected'}; ${x.frameId?'Frame included':'No frame costing selected'}; Installation / Labour ${lb?fmt(lb):'not included'}.`,descriptionAuto:true,unit:'Nos',qty:+x.qty||1,w:+x.w||0,h:+x.h||0,t:+x.t||0,sizeText:(x.w||x.h)?`${x.w||'-'} × ${x.h||'-'} mm${x.t?' | '+x.t+' mm':''}`:'',costToCompany:+x.per||0,shutterCTC:sh,frameCTC:fr,labourCTC:lb,labourQty:+x.labourQty||1,labourRate:+x.labourRate||0,rate,qvMode:'percent',qvPercent:rate>0&&x.per?Math.max(0,(rate/(+x.per||1)-1)*100):25,qvPrice:rate,lines:[],manual:false,breakups:[{id:uid('QD'),title:'Shutter',sizeText:'',description:'Shutter as per selected Shutter Costing.',unit:'Nos',rate:sh,qty:sh?1:0},{id:uid('QD'),title:'Frame',sizeText:'',description:'Frame as per selected Frame Costing.',unit:'Nos',rate:fr,qty:fr?1:0},{id:uid('QD'),title:'Labour / Installation',sizeText:'',description:'Installation charges for complete door.',unit:'Nos',rate:lb,qty:lb?1:0}]}
 }
 const rate=x.sell==null?(+x.per||0):(+x.sell||0), isSh=x.type==='shutter',isFr=x.type==='frame';
 return {id:uid('QI'),sourceId:x.id,type:isSh?'Shutter Costing':(isFr?'Frame Costing':(x.type||'Costing')),product:x.tname||x.name||'Custom Product',customer:x.customer||'',description:qDescription(spec),descriptionAuto:true,unit:x.unit||'Nos',qty:+x.qty||1,w:+x.w||0,h:+x.h||0,t:+x.t||0,sizeText:(x.w||x.h)?`${x.w||'-'} × ${x.h||'-'} mm${x.t?' | '+x.t+' mm':''}`:'',costToCompany:x.per==null?null:+x.per,shutterCTC:isSh?(+x.per||0):0,frameCTC:isFr?(+x.per||0):0,labourCTC:0,labourQty:1,labourRate:0,rate,qvMode:(x.per==null?'price':'percent'),qvPercent:(x.per==null?0:((rate/(+x.per||1))-1)*100),qvPrice:rate,lines:clone(x.lines||[]),manual:false,breakups:[{id:uid('QD'),title:x.tname||x.name||'Detailed Item',sizeText:(x.w||x.h)?`${x.w||'-'} × ${x.h||'-'} mm${x.t?' | '+x.t+' mm':''}`:'',description:qDescription(spec),unit:x.unit||'Nos',rate,qty:1}]}
}
function importSelectedQuotations(){
 const boxes=[...document.querySelectorAll('.qpick')];
 const domIds=boxes.filter(e=>e.checked).map(e=>String(e.dataset.id||e.value||''));
 const ids=[...new Set([...qSelectedCostings,...domIds])].filter(Boolean);
 if(!ids.length){toast('Please select at least one costing');return}
 const history=Array.isArray(db.history)?db.history:[];
 const selected=[];
 ids.forEach(id=>{const x=history.find(h=>String(h.id)===id);if(x)selected.push(x)});
 if(!selected.length){toast('Selected costing could not be found in Costing History');return}
 if(!window._qEdit)window._qEdit=blankQuotation();
 if(!Array.isArray(window._qEdit.items))window._qEdit.items=[];
 const existing=new Set(window._qEdit.items.map(x=>String(x.sourceId||'')).filter(Boolean));
 let added=0;
 selected.forEach(x=>{if(existing.has(String(x.id)))return;window._qEdit.items.push(costingToQuotationItem(x));existing.add(String(x.id));added++});
 if(!added){toast('Selected costing is already added');window._qPick=null;render();return}
 window._qEdit.product=window._qEdit.items.length===1?window._qEdit.items[0].product:'Multiple Door / Frame Items';
 window._qEdit.qty=window._qEdit.items.length===1?window._qEdit.items[0].qty:1;
 window._qEdit.w=window._qEdit.items.length===1?window._qEdit.items[0].w:0;
 window._qEdit.h=window._qEdit.items.length===1?window._qEdit.items[0].h:0;
 window._qEdit.t=window._qEdit.items.length===1?window._qEdit.items[0].t:0;
 window._qPick=null;qSelectedCostings=[];
 render();
 toast(added+' costing item'+(added===1?'':'s')+' imported successfully');
}
function importQuotation(id){const x=db.history.find(h=>h.id===id);if(!x)return;window._qPick=null;window._qEdit={id:qNextNo(),date:today(),validTill:new Date(Date.now()+15*86400000).toISOString().slice(0,10),customer:x.customer||'',subject:'Quotation for Supply & Installation of Door & Frame Works',product:(x.type==='door'?'Main Door':(x.tname||'Main Door')),unit:'Nos',qty:+x.qty||1,w:+x.w||0,h:+x.h||0,t:+x.t||0,sizeText:(x.w||x.h)?`${x.w||'-'} × ${x.h||'-'} mm${x.t?' | '+x.t+' mm':''}`:'',costToCompany:+x.per||0,rate:+x.sell||((+x.per||0)*1.25),discountPercent:0,proposalPercent:25,gstPercent:18,lines:clone(x.lines||[]),items:[{id:uid('QI'),sourceId:x.id,type:x.type||'Costing',product:(x.type==='door'?'Main Door':(x.tname||'Main Door')),description:qDescription({w:x.w,h:x.h,t:x.t,lines:x.lines||[]}),descriptionAuto:true,unit:'Nos',qty:+x.qty||1,w:+x.w||0,h:+x.h||0,t:+x.t||0,sizeText:(x.w||x.h)?`${x.w||'-'} × ${x.h||'-'} mm${x.t?' | '+x.t+' mm':''}`:'',costToCompany:+x.per||0,rate:+x.sell||((+x.per||0)*1.25),lines:clone(x.lines||[]),manual:false}],terms:x.terms||db.co.terms||'',payment:'50% Mobilization Advance against Purchase Order.\n40% payment at the time of delivery.\n10% against final bill.',attention:'',address:'',company:'',crmDescription:''};render()}
function quotationEditor(q){
 const z=qCalc(q), items=z.items||[];
 const totalCost=items.reduce((a,x)=>a+(x.costToCompany==null?0:(+x.costToCompany||0))*(+x.qty||0),0);
 const totalQV=items.reduce((a,x)=>a+(+x.rate||0)*(+x.qty||0),0);
 const summaryRows=items.map((x,i)=>{
   const mode=x.qvMode||((x.costToCompany!=null)?'percent':'price');
   const base=+x.costToCompany||0;
   const pct=+x.qvPercent||0;
   const qvInput=mode==='percent'?pct:(+x.qvPrice||+x.rate||0);
   return `<tr>
   <td>${i+1}</td>
   <td>${esc(q.date||'-')}</td>
   <td><input class="q-summary-input" value="${esc(x.customer||q.customer||'')}" placeholder="Customer name" onchange="qItemSet(${i},'customer',this.value)"></td>
   <td><select class="q-summary-input q-product-input" onchange="qSetDoorType(${i},this.value)"><option value="">Custom Product</option>${['Main Door','Bed Door','Bath Door'].map(v=>`<option value="${v}"${x.product===v?' selected':''}>${v}</option>`).join('')}</select><input class="q-summary-input q-product-input" style="margin-top:4px" value="${esc(x.product||'')}" placeholder="Product / Door name" onchange="qItemSet(${i},'product',this.value)"></td>
   <td><input class="q-summary-qty" type="number" min="1" value="${x.qty||1}" onchange="qItemSetNum(${i},'qty',this.value)"></td>
   <td>${x.costToCompany==null?'—':qMoney(x.costToCompany)}</td>
   <td class="qv-editor">
      <select onchange="qSetQVMode(${i},this.value)">
        <option value="">None</option><option value="percent"${mode==='percent'?' selected':''}>% Markup</option>
        <option value="price"${mode==='price'?' selected':''}>Direct Price</option>
      </select>
      <input type="number" min="0" step="0.01" value="${qvInput}" onchange="qSetQVInput(${i},this.value)" title="${mode==='percent'?'Enter percentage markup':'Enter quotation price per unit'}">
      <div class="qv-result">${mode==='percent'?`${qvInput}% → ${qMoney(x.rate)}/unit`:`${qMoney(x.rate)}/unit`}</div>
   </td>
   <td><b>${qMoney((+x.rate||0)*(+x.qty||0))}</b></td>
   <td><button type="button" class="danger" onclick="removeQuotationItem(${i})">Delete</button></td>
 </tr>`;
 }).join('');
 const detailCards=items.map((x,i)=>`<div class="pn q-detail-card${(window._qCol||{})[x.id]?' q-collapsed':''}" id="qdet-${i}">
   <div class="q-detail-head">
     <button type="button" class="q-tg" onclick="qToggleItem(${i})" title="Minimise / Maximise">${(window._qCol||{})[x.id]?'▶':'▼'}</button>
     <div style="flex:1;cursor:pointer" onclick="qToggleItem(${i})"><span class="q-detail-no">${i+1}</span><div><h3 style="margin:0">${esc(x.product||'Quotation Item')}</h3><div class="mu">${esc(x.type||'Manual')} ${x.sizeText?`• ${esc(x.sizeText)}`:''}</div></div></div>
     <div class="q-detail-price"><span>QV Price</span><b>${qMoney((+x.rate||0))}</b><span>Qty ${+x.qty||1}</span></div>
      <button type="button" class="danger" onclick="removeQuotationItem(${i})" title="Delete this main item">Delete Main Item</button>
   </div>
   <div class="q-detail-body">
   <div class="g q-detail-meta">
     <div><label>Product / Item</label><input value="${esc(x.product||'')}" onchange="qItemSet(${i},'product',this.value)"></div>
     <div><label>Size</label><input value="${esc(x.sizeText||'')}" placeholder="e.g. 2200 X 1000 mm" onchange="qItemSet(${i},'sizeText',this.value)"></div>
     <div><label>Cost to Company</label><input value="${x.costToCompany==null?'—':qMoney(x.costToCompany)}" readonly></div>
     <div><label>Shutter CTC</label><input type="number" value="${(+x.shutterCTC||0).toFixed(2)}" onchange="qDoorPartSet(${i},'shutterCTC',this.value)"></div>
     <div><label>Frame CTC</label><input type="number" value="${(+x.frameCTC||0).toFixed(2)}" onchange="qDoorPartSet(${i},'frameCTC',this.value)"></div>
     <div><label>Labour Count</label><input type="number" min="0" step="any" value="${x.labourQty==null?1:x.labourQty}" onchange="qDoorPartSet(${i},'labourQty',this.value)"></div>
     <div><label>Labour Rate</label><input type="number" min="0" step="any" value="${(+x.labourRate||0).toFixed(2)}" onchange="qDoorPartSet(${i},'labourRate',this.value)"></div>
     <div><label>Cost / Door</label><input value="${qMoney((+x.shutterCTC||0)+(+x.frameCTC||0)+(+x.labourCTC||0))}" readonly></div>
     <div><label>Quotation Rate / Unit</label><input type="number" value="${(+x.rate||0).toFixed(2)}" onchange="qItemSetNum(${i},'rate',this.value)"></div>
     <div><label>Summary Qty</label><input type="number" min="1" value="${x.qty||1}" onchange="qItemSetNum(${i},'qty',this.value)"></div>
   </div>
   <div class="row" style="margin-top:12px"><button type="button" onclick="addQuotationBreakup(${i})">+ Add Detailed Row</button></div>
    <div class="tw" style="margin-top:8px">
    <table>
      <tr><th>Sr.</th><th>Size</th><th>Component / Description</th><th>Qty.</th><th>Rate</th><th>Total</th><th></th></tr>
      ${qBreakups(x).map((b,j)=>`<tr>
        <td>${j+1}</td>
        <td><input value="${esc(b.sizeText||'')}" placeholder="Size" onchange="qBreakupSet(${i},${j},'sizeText',this.value)"></td>
        <td>
          <input value="${esc(b.title||'')}" placeholder="Component / title" onchange="qBreakupSet(${i},${j},'title',this.value)">
          <textarea class="q-desc-editor q-detail-description" rows="5" placeholder="Client-facing description..." onchange="qBreakupSet(${i},${j},'description',this.value)">${esc(b.description||'')}</textarea>
        </td>
        <td><input type="number" min="1" value="${b.qty||1}" onchange="qBreakupNumSet(${i},${j},'qty',this.value)"></td>
        <td><input type="number" value="${(+b.rate||0).toFixed(2)}" onchange="qBreakupNumSet(${i},${j},'rate',this.value)"></td>
        <td><b>${qMoney((+b.rate||0)*(+b.qty||0))}</b></td>
        <td><button type="button" onclick="removeQuotationBreakup(${i},${j})">Delete</button></td>
      </tr>`).join('')}
      <tr class="q-detail-total-row"><td colspan="5" class="q-right"><b>TOTAL</b></td><td><b>${qMoney(qBreakupTotal(x))}</b></td><td></td></tr>
    </table>
   </div>
   <div class="row" style="margin-top:10px">
     <button type="button" onclick="addQuotationBreakup(${i})">+ Add Detailed Row</button>
     <span class="mu">Detailed total / unit: ${qMoney(qBreakupTotal(x))}</span>
     <span class="mu">Quotation rate / unit: ${qMoney(x.rate)}</span>
     <button type="button" class="danger" onclick="removeQuotationItem(${i})" style="margin-left:auto">Delete Main Item</button>
   </div>
   ${(+x.rate||0)<=0 || Math.abs(qBreakupTotal(x)-(+x.rate||0))>.01
     ?`<div class="warn" style="margin-top:8px">Detailed breakup total must equal the Quotation Rate before final quotation.</div>`
     :`<div class="mu" style="margin-top:8px">✓ Detailed breakup matches the quotation rate.</div>`}
 </div>
 </div>`).join('');

 return `<div class="pn q-backend-title">
   <div><h2 style="margin:0">QUOTATION</h2><div class="q-backend-sub">Quotation summary &amp; detailed costing</div></div>
 </div>
 <div class="pn">
   <h2 class="q-backend-section">Client &amp; Subject Details</h2>
   <div class="g">
    <div><label>Client Name (To)</label><input value="${esc(q.customer||'')}" placeholder="e.g. Ganesh Magar" onchange="qSet('customer',this.value)"></div>
    <div><label>Company / Project</label><input value="${esc(q.company||'')}" placeholder="e.g. ABC Pvt Ltd" onchange="qSet('company',this.value)"></div>
    <div><label>Kind Attention</label><input value="${esc(q.attention||'')}" placeholder="Contact person" onchange="qSet('attention',this.value)"></div>
    <div><label>Quotation Date</label><input type="date" value="${esc(q.date||'')}" onchange="qSet('date',this.value)"></div>
    <div><label>Valid Till</label><input type="date" value="${esc(q.validTill||'')}" onchange="qSet('validTill',this.value)"></div>
   </div>
   <label>Client Address</label><textarea rows="2" onchange="qSet('address',this.value)">${esc(q.address||'')}</textarea>
   <label>Subject</label><input value="${esc(q.subject||'')}" placeholder="e.g. Quotation for Supply &amp; Installation of Door &amp; Frame Works" onchange="qSet('subject',this.value)">
   <label>Description / Introduction (shown on quotation)</label><textarea rows="3" onchange="qSet('intro',this.value)">${esc(q.intro||'')}</textarea>
 ${((db.fieldOptions&&db.fieldOptions.quotationFields)||[]).length?`<h3>Additional Quotation Fields</h3><div class="g">${db.fieldOptions.quotationFields.map((label,i)=>`<div><label>${esc(label)}</label><input value="${esc((q.customFields||{})[label]||'')}" onchange="qCustomFieldSet(${JSON.stringify(label)},this.value)"></div>`).join('')}</div>`:''}
 </div>
 <div class="pn">
   <h2 class="q-backend-section">1. Summary</h2>
   <div class="row" style="margin-bottom:10px">
     <button class="pri" onclick="window._qPick='costing';render()">+ Import Multiple Costings</button>
     <button onclick="addManualQuotationItem()">+ Manual Item</button>
   </div>
   <div class="tw">
    <table class="q-summary-backend">
      <tr><th>S.No.</th><th>Date</th><th>Customer</th><th>Product / Item</th><th>Qty</th><th>Cost to Company</th><th>QV Price</th><th>Total QV</th><th>Action</th></tr>
      ${summaryRows || '<tr><td colspan="7" class="mu">No quotation items. Import a costing or add a manual item.</td></tr>'}
      ${items.length?`<tr class="q-summary-total"><td colspan="3"><b>TOTAL</b></td><td></td><td><b>${items.reduce((a,x)=>a+(+x.qty||0),0)}</b></td><td><b>${qMoney(totalCost)}</b></td><td></td><td><b>${qMoney(totalQV)}</b></td><td></td></tr>`:''}
    </table>
   </div>
 </div>
 <div>
   <h2 class="q-backend-section q-detail-section-title">2. Detailed Breakdown</h2>
   <div class="row" style="margin-bottom:10px"><button type="button" class="pri" onclick="addManualQuotationItem(true)">+ Add Main Item</button><button type="button" onclick="qToggleAll(true)">Minimise All</button><button type="button" onclick="qToggleAll(false)">Maximise All</button><span class="mu">Click an item's heading or arrow to minimise / maximise it.</span></div>
   ${detailCards || `<div class="pn"><div class="mu">No detailed quotation items yet.</div></div>`}
   <div class="row" style="margin-top:6px"><button type="button" class="pri" onclick="addManualQuotationItem(true)">+ Add Main Item</button></div>
 </div>
 <div class="pn">
   <h3 style="margin-top:0">Pricing</h3>
   <div class="g">
    <div><label>Internal Cost to Company</label><input value="${qMoney(z.internalCost)}" readonly></div>
    <div><label>Markup %</label><input type="number" min="0" step="0.01" value="${q.proposalPercent==null?25:q.proposalPercent}" onchange="qSetNum('proposalPercent',this.value)"></div>
    <div><label>Selling Price</label><input value="${qMoney(z.proposalValue)}" readonly></div>
    <div><label>Quotation Value</label><b>${qMoney(z.sub)}</b></div>
    <div><label>Profit</label><b>${qMoney(z.sub-z.internalCost)} (${z.internalCost>0?((z.sub-z.internalCost)/z.internalCost*100).toFixed(1):'0.0'}%)</b></div>
    <div><label>Discount (%)</label><input type="number" min="0" max="100" value="${q.discountPercent}" onchange="qSetNum('discountPercent',this.value)"></div>
    <div><label>GST (%)</label><input type="number" min="0" value="${q.gstPercent}" onchange="qSetNum('gstPercent',this.value)"></div>
   </div>
   <div class="row" style="margin-top:10px"><button onclick="applyProposalPercent()">Apply Proposal % to Quotation Rates</button><span class="mu">Proposal Value = Internal Cost × (1 + Proposal % / 100)</span></div>
   <div class="pn" style="margin-top:12px"><div class="g"><b>Subtotal ${qMoney(z.sub)}</b><b>Discount ${qMoney(z.da)}</b><b>Taxable ${qMoney(z.tax)}</b><b>GST ${qMoney(z.ga)}</b><b class="big">Grand Total ${qMoney(z.grand)}</b></div></div>
 </div>
 <div class="pn">
   <h3 style="margin-top:0">Client-facing Document</h3>
   <div class="row"><select onchange="qApplyTemplate(this.value)" style="max-width:260px"><option value="">Apply saved terms &amp; payment template…</option>${(db.termTemplates||[]).map(t=>`<option value="${esc(t.id)}">${esc(t.name)}</option>`).join('')}</select><button type="button" onclick="qSaveTemplate()">Save current as template</button></div>
   <div class="pn" style="margin:8px 0"><b>Amount in Words:</b> ${esc(qWords(z.grand))}</div>
   <p class="mu">Raw BOM, Cost to Company, profit, margin and supplier prices are never shown in the client quotation.</p>
   <label>Payment Terms</label><textarea rows="4" onchange="qSet('payment',this.value)">${esc(q.payment||'')}</textarea>
   <label>Terms &amp; Conditions</label><textarea rows="5" onchange="qSet('terms',this.value)">${esc(q.terms||'')}</textarea>
 </div>
 <div class="row">
   <button class="pri" onclick="saveQuotation()">Save Quotation</button>
   <button onclick="saveQuotation();openCRMForQuotation('${q.id}')">Save + CRM</button>
   <button onclick="previewQuotationById('${q.id}')">Preview</button>
   <button onclick="downloadSavedQuotationPDF('${q.id}')">Download PDF</button>
   <button onclick="downloadSavedQuotationWord('${q.id}')">Download Word</button>
   <button onclick="window._qEdit=null;render()">Close</button>
 </div>`;
}
function qScaleBreakupToRate(x,newRate){const bs=qBreakups(x),old=qBreakupTotal(x);if(bs.length){if(old>0){const scale=(+newRate||0)/old;bs.forEach(b=>b.rate=(+b.rate||0)*scale)}else{bs.forEach((b,j)=>b.rate=j===0?(+newRate||0):0)}x.breakups=bs}}
function qSetQVMode(i,mode){const x=window._qEdit.items[i];x.qvMode=mode==='percent'?'percent':'price';if(x.qvMode==='percent'){const c=+x.costToCompany||0;x.qvPercent=c>0?Math.max(0,((+x.rate||0)/c-1)*100):(+x.qvPercent||0);x.rate=c*(1+(+x.qvPercent||0)/100)}else{x.qvPrice=+x.rate||0}qScaleBreakupToRate(x,x.rate);render()}
function qSetQVInput(i,v){const x=window._qEdit.items[i];const n=v===''?0:+v;x.qvMode=x.qvMode||((x.costToCompany!=null)?'percent':'price');if(x.qvMode==='percent'){x.qvPercent=n;const c=+x.costToCompany||0;x.rate=c>0?c*(1+n/100):0}else{x.qvPrice=n;x.rate=n}qScaleBreakupToRate(x,x.rate);render()}
function qSetDoorType(i,v){const x=window._qEdit.items[i];if(!x)return;x.product=v||'Custom Product';if(v){x.doorType=v;x.breakups=qBreakups(x);while(x.breakups.length<3)x.breakups.push({id:uid('QD'),title:'New Detail',sizeText:'',description:'',unit:'Nos',rate:0,qty:1});x.breakups[0].title='Shutter';x.breakups[1].title='Frame';x.breakups[2].title='Labour & Installation';x.shutterCTC=+x.shutterCTC||0;x.frameCTC=+x.frameCTC||0;x.labourQty=x.labourQty==null?1:+x.labourQty||0;x.labourRate=+x.labourRate||0;x.labourCTC=(+x.labourQty||0)*(+x.labourRate||0);x.costToCompany=(+x.shutterCTC||0)+(+x.frameCTC||0)+(+x.labourCTC||0);x.breakups[0].rate=x.shutterCTC;x.breakups[1].rate=x.frameCTC;x.breakups[2].rate=x.labourCTC}render()}
function qDoorPartSet(i,k,v){const x=window._qEdit.items[i];if(!x)return;x[k]=v===''?'':+v;if(k==='labourQty'||k==='labourRate')x.labourCTC=(+x.labourQty||0)*(+x.labourRate||0);x.costToCompany=(+x.shutterCTC||0)+(+x.frameCTC||0)+(+x.labourCTC||0);if(x.qvMode==='percent'){x.rate=x.costToCompany*(1+(+x.qvPercent||0)/100)}else if(x.qvMode!=='price'&&x.costToCompany){x.rate=x.costToCompany}const bs=qBreakups(x);if(bs.length>=3){bs[0].title='Shutter';bs[0].rate=+x.shutterCTC||0;bs[1].title='Frame';bs[1].rate=+x.frameCTC||0;bs[2].title='Labour & Installation';bs[2].rate=+x.labourCTC||0;x.breakups=bs}render()}
function qItemSet(i,k,v){window._qEdit.items[i][k]=v;if(k==='description')window._qEdit.items[i].descriptionAuto=false;render()}
function qItemSetNum(i,k,v){window._qEdit.items[i][k]=v===''?'':+v;render()}
function addManualQuotationItem(scroll){const n=(window._qEdit.items||(window._qEdit.items=[])).length;(window._qEdit.items).push({id:uid('QI'),sourceId:'',type:'Manual',product:'Manual Item',customer:'',sizeText:'',description:'',unit:'Nos',qty:1,w:0,h:0,t:0,costToCompany:null,shutterCTC:0,frameCTC:0,labourCTC:0,labourQty:1,labourRate:0,rate:0,qvMode:'price',qvPercent:0,qvPrice:0,lines:[],manual:true,breakups:[{id:uid('QD'),title:'Shutter',sizeText:'',description:'',unit:'Nos',rate:0,qty:1},{id:uid('QD'),title:'Frame',sizeText:'',description:'',unit:'Nos',rate:0,qty:1},{id:uid('QD'),title:'Labour & Installation',sizeText:'',description:'',unit:'Nos',rate:0,qty:1}]});render();if(scroll)setTimeout(()=>{const e=document.getElementById('qdet-'+n);if(e){e.scrollIntoView({behavior:'smooth',block:'start'});const p=e.querySelector('input');if(p){p.focus();p.select()}}},60)}
function qToggleItem(i){const it=(window._qEdit.items||[])[i];if(!it)return;window._qCol=window._qCol||{};window._qCol[it.id]=!window._qCol[it.id];const c=document.getElementById('qdet-'+i);if(c){c.classList.toggle('q-collapsed',!!window._qCol[it.id]);const b=c.querySelector('.q-tg');if(b)b.textContent=window._qCol[it.id]?'▶':'▼'}}
function qToggleAll(c){window._qCol=window._qCol||{};(window._qEdit.items||[]).forEach(x=>{window._qCol[x.id]=!!c});render()}
function removeQuotationItem(i){const it=window._qEdit.items[i];if(!it)return;if(!confirm('Delete main item '+(i+1)+(it.product?' ('+it.product+')':'')+' and all its detailed rows?'))return;window._qEdit.items.splice(i,1);render();toast('Main item deleted')}
function qSet(k,v){window._qEdit[k]=v;render()}
function qCustomFieldSet(k,v){const q=window._qEdit;if(!q)return;q.customFields=q.customFields||{};q.customFields[k]=v;render()}
function qSetNum(k,v){let n=v===''?'':+v;if(k==='proposalPercent')n=n===''?'':Math.max(0,n);window._qEdit[k]=n;render()}
function saveQuotation(){
 const q=normalizeQuotation(clone(window._qEdit));q.items=qItems(q);
 if(!q.items.length){toast('Add at least one quotation item');return}
 const totalQV=q.items.reduce((a,x)=>a+(+x.rate||0)*(+x.qty||0),0);
 if(totalQV<=0){toast('Quotation value must be greater than ₹0 before saving');return}
 if(q.proposalPercent<0){toast('Markup cannot be negative');return}
 q.product=q.items.length===1?q.items[0].product:'Multiple Door / Frame Items';
 q.items.forEach(ensureBreakups);const bad=q.items.find(x=>Math.abs(qBreakupTotal(x)-(+x.rate||0))>.01);if(bad){toast('Detailed breakup total must equal quotation rate for '+(bad.product||'item'));return}q.savedAt=new Date().toISOString();q.userId=cu?.id||null;q.user=cu?.name||'';q.createdById=cu?.id||null;q.createdByName=cu?.name||'';
 const i=(db.quotations||[]).findIndex(x=>x.id===q.id);
 if(i>=0){
   const old=clone(db.quotations[i]);
   q.revision=Math.max(1,+old.revision||1)+1;
   q.revisionHistory=Array.isArray(old.revisionHistory)?old.revisionHistory:[];
   q.revisionHistory.push({...old,revision:old.revision||1});
   q.createdAt=old.createdAt||q.savedAt;
   db.quotations[i]=q;
   db.audit.unshift({ts:new Date().toLocaleString(),a:(cu?cu.name+': ':'')+'edited quotation '+qLabel(q)});
 }else{
   q.revision=1;q.revisionHistory=[];q.createdAt=q.savedAt;db.quotations.unshift(q);
   db.audit.unshift({ts:new Date().toLocaleString(),a:(cu?cu.name+': ':'')+'created quotation '+qLabel(q)});
 }
 window._qEdit=q;
 syncCRMForQuotation(q);
 save();render();toast('Quotation '+q.id+' saved and CRM entry updated')
}
function editQuotation(id){const q=db.quotations.find(x=>x.id===id);if(q){q.items=qItems(q);window._qEdit=clone(q);render()}}
function savedQ(id){return db.quotations.find(x=>x.id===id)}
function previewSavedQuotation(id){previewQuotationById(id)}
function previewQuotationById(id){const q=savedQ(id)||window._qEdit;if(!q)return;const o=document.createElement('div');o.className='ov pvo';o.innerHTML=`${qStyle()}<div style="width:100%;max-width:1000px;margin:0 auto"><div class="row" style="position:sticky;top:0;z-index:20;background:#f2f4f8;padding:8px;margin:0 0 8px"><button class="pri" onclick="downloadSavedQuotationPDF('${q.id}')">Download PDF</button><button onclick="downloadSavedQuotationWord('${q.id}')">Download Word</button><button onclick="this.closest('.ov').remove()">Close</button></div>${quotationHTMLFor(q)}</div>`;document.body.appendChild(o)}
function qCRMNo(){const used=(db.crm||[]).map(x=>parseInt(String(x.id||'').replace(/\D/g,''),10)||0);return 'CRM-'+String((used.length?Math.max(...used):0)+1).padStart(4,'0')}
function crmDate(d){const x=d?new Date(d):new Date();if(isNaN(x))return String(d||'');return x.toLocaleDateString('en-GB',{day:'2-digit',month:'short',year:'numeric'}).replace(/(\w{3}) /,'$1 ')}
function crmDateTime(){const x=new Date();return crmDate(x)+', '+x.toLocaleTimeString('en-US',{hour:'numeric',minute:'2-digit'})}
function syncCRMForQuotation(q){
 db.crm=db.crm||[];
 let r=db.crm.find(x=>x.quotationId===q.id);
 if(!r){r={id:qCRMNo(),quotationId:q.id,customer:'',company:'',project:'',contact:'',mobile:'',email:'',address:'',description:'',value:0,gst:0,total:0,createdDate:crmDate(q.date),sentDate:'',sentVia:'',pdfAttached:'Not attached',quotationDate:'',validTill:'',assignedTo:cu?.name||'',status:'Draft',nextFollowup:'',notes:'',activities:[]};db.crm.unshift(r)}
 const z=qCalc(q);
 r.customer=q.customer||r.customer||'';r.company=q.company||r.company||'';r.project=q.project||r.project||'';r.contact=q.attention||r.contact||'';r.address=q.address||r.address||'';r.description=q.crmDescription||r.description||q.intro||q.subject||'';
 r.value=z.tax;r.gst=z.ga;r.total=z.grand;r.createdDate=r.createdDate||crmDate(q.date);r.quotationDate=q.date||'';r.validTill=q.validTill||'';r.assignedTo=r.assignedTo||cu?.name||'';
  if(r.validTill && r.validTill<today() && !['Won','Lost'].includes(r.status))r.status='Expired';
  r.quotationLabel=qLabel(q);
  return r
}
function createCRMForQuotation(id){const q=savedQ(id)||window._qEdit;if(!q)return;const r=syncCRMForQuotation(q);save();go('crm');toast('CRM entry '+r.id+' ready')}
function crmCSV(){
 const q=v=>'"'+String(v??'').replace(/"/g,'""')+'"';
 const rows=[['CRM ID','Quotation','Client','Value','GST','Total','Created','Sent','Status','Sent Via','Next Follow-up','Owner','Notes']];
 (db.crm||[]).forEach(r=>rows.push([r.id,r.quotationLabel||r.quotationId,r.company||r.customer,r.value,r.gst,r.total,r.createdDate,r.sentDate,r.status,r.sentVia,r.nextFollowup,r.assignedTo,r.notes]));
 saveFile('crm-export.csv',rows.map(x=>x.map(q).join(',')).join('\n'));
}
function crmSetFilter(k,v){crmFilters[k]=v;render()}
function crmView(){
 const opt=(arr,v)=>`<option value=""${v===''?'selected':''}>None</option>`+arr.filter(s=>s!=='').map(s=>`<option ${v===s?'selected':''}>${esc(s)}</option>`).join('');
 const all=db.crm||[],owners=[...new Set(all.map(r=>r.assignedTo).filter(Boolean))].sort();
 const todayS=today(),due=all.filter(r=>r.nextFollowup&&r.nextFollowup<=todayS&&!['Won','Lost','Expired'].includes(r.status));
 const filtered=all.filter(r=>{
   const q=(crmFilters.q||'').toLowerCase();
   const hay=[r.id,r.quotationLabel,r.quotationId,r.company,r.customer,r.project,r.assignedTo,r.notes].join(' ').toLowerCase();
   return (!q||hay.includes(q))&&(!crmFilters.status||r.status===crmFilters.status)&&(!crmFilters.owner||r.assignedTo===crmFilters.owner);
 });
 const rows=filtered.map(r=>`<tr>
  <td><b>${esc(r.id)}</b></td><td><b>${esc(r.quotationLabel||r.quotationId||'-')}</b></td>
  <td style="min-width:140px">${esc(r.company||r.customer||r.project||'-')}</td><td class="r">${qMoney(r.value)}</td><td class="r">${qMoney(r.gst)}</td><td class="r"><b>${qMoney(r.total||r.value)}</b></td>
  <td>${esc(r.createdDate||crmDate(r.quotationDate))}</td><td style="min-width:170px"><input value="${esc(r.sentDate||'')}" placeholder="Auto when Sent" onchange="crmSet('${r.id}','sentDate',this.value)"></td>
  <td style="min-width:120px"><select onchange="crmSet('${r.id}','status',this.value)">${opt(['Draft','Sent','Follow-up','Negotiation','Won','Lost','Expired'],r.status)}</select></td>
  <td style="min-width:140px"><select onchange="crmSet('${r.id}','sentVia',this.value)">${opt(['','Email','WhatsApp','Email / WhatsApp','By Hand'],r.sentVia||'')}</select></td>
  <td style="min-width:120px"><input type="date" value="${esc(r.nextFollowup||'')}" onchange="crmSet('${r.id}','nextFollowup',this.value)"></td>
  <td style="min-width:110px"><input value="${esc(r.assignedTo||'')}" onchange="crmSet('${r.id}','assignedTo',this.value)"></td>
  <td style="min-width:200px"><textarea rows="2" placeholder="e.g. Awaiting client response" onchange="crmSet('${r.id}','notes',this.value)">${esc(r.notes||'')}</textarea></td>
  <td><button onclick="crmActivity('${r.id}')">+ Activity</button></td></tr>`).join('');
 const openValue=all.filter(r=>!['Won','Lost'].includes(r.status)).reduce((a,r)=>a+(+r.total||0),0);
 const wonValue=all.filter(r=>r.status==='Won').reduce((a,r)=>a+(+r.total||0),0);
 return `<style>.crm-h{min-width:1750px;font-size:13px}.crm-h th{white-space:nowrap;color:var(--tx);background:#e8f0f6;padding:8px 6px}.crm-h td{vertical-align:middle}.crm-h td.r{text-align:right;white-space:nowrap}.crm-top{position:sticky;z-index:6;overflow-x:auto;overflow-y:hidden;height:16px;background:var(--bg);border-radius:8px;margin:0 0 4px}.crm-top>div{height:1px}</style>
 <h2>CRM</h2>
 <div class="g"><div class="pn"><label>Due today / overdue</label><div class="big">${due.length}</div></div><div class="pn"><label>Open pipeline</label><div class="big">${qMoney(openValue)}</div></div><div class="pn"><label>Won value</label><div class="big">${qMoney(wonValue)}</div></div></div>
 <div class="pn"><div class="row"><button class="pri" onclick="syncAllCRM()">Sync Saved Quotations</button><button onclick="go('quote')">Back to Quotations</button><button onclick="crmCSV()">Export CSV</button></div>
 <div class="row"><input placeholder="Search client / quotation / owner" value="${esc(crmFilters.q)}" oninput="crmSetFilter('q',this.value)" style="max-width:300px"><select onchange="crmSetFilter('status',this.value)" style="max-width:180px"><option value="">All statuses</option>${opt(['Draft','Sent','Follow-up','Negotiation','Won','Lost','Expired'],crmFilters.status)}</select><select onchange="crmSetFilter('owner',this.value)" style="max-width:180px"><option value="">All owners</option>${owners.map(o=>`<option ${crmFilters.owner===o?'selected':''}>${esc(o)}</option>`).join('')}</select></div>
 <p class="mu">${due.length?'Follow-ups due: '+due.map(r=>esc(r.quotationLabel||r.quotationId)).join(', '):'No follow-ups are due today.'}</p></div>
 <div id="crmTop" class="crm-top" onscroll="crmSyncScroll('top')"><div id="crmTopIn"></div></div><div id="crmBody" class="pn tw" onscroll="crmSyncScroll('body')"><table class="crm-h" id="crmTable"><tr><th>CRM ID</th><th>Quotation</th><th>Client</th><th>Proposal Value</th><th>GST</th><th>Total</th><th>Created Date</th><th>Sent Date</th><th>Status</th><th>Sent Via</th><th>Next Follow-up</th><th>Owner</th><th>Notes</th><th></th></tr>${rows||'<tr><td colspan="14" class="mu">No matching CRM records.</td></tr>'}</table></div>`+(setTimeout(crmInitScroll,0),'')
}

function crmInitScroll(){const t=document.getElementById('crmTop'),i=document.getElementById('crmTopIn'),b=document.getElementById('crmBody'),tb=document.getElementById('crmTable');if(!t||!b||!tb)return;i.style.width=tb.scrollWidth+'px';const h=document.querySelector('header');t.style.top=(h?h.getBoundingClientRect().height:0)+'px';t.scrollLeft=b.scrollLeft}
function crmSyncScroll(w){const t=document.getElementById('crmTop'),b=document.getElementById('crmBody');if(!t||!b)return;if(w==='top'){if(b.scrollLeft!==t.scrollLeft)b.scrollLeft=t.scrollLeft}else{if(t.scrollLeft!==b.scrollLeft)t.scrollLeft=b.scrollLeft}}
window.addEventListener('resize',()=>crmInitScroll());
function syncAllCRM(){(db.quotations||[]).forEach(q=>syncCRMForQuotation(q));save();render();toast('CRM synced with saved quotations')}
function crmSet(id,k,v){const r=(db.crm||[]).find(x=>x.id===id);if(!r)return;r[k]=v;if(k==='status'&&v==='Sent'&&!r.sentDate){r.sentDate=crmDateTime();if(!r.nextFollowup){const d=new Date(Date.now()+3*86400000);r.nextFollowup=d.toISOString().slice(0,10)}}r.activities=r.activities||[];r.activities.unshift({date:new Date().toLocaleString(),activity:k==='status'?'Status changed':k+' updated',notes:v,user:cu?.name||''});save();render()}
function crmActivity(id){const r=(db.crm||[]).find(x=>x.id===id);if(!r)return;const n=prompt('CRM activity / note');if(n){r.activities=r.activities||[];r.activities.unshift({date:new Date().toLocaleString(),activity:'Note',notes:n,user:cu?.name||''});save();render();toast('CRM activity added')}}
function openCRMForQuotation(id){createCRMForQuotation(id)}

function qHeaderHTML(title,metaHTML){const co=db.co||{};return `<div class="q-header"><div class="q-head-logo">${co.logo?`<img class="q-logo" src="${co.logo}" alt="Logo">`:''}</div><div class="q-head-company"><div class="q-company">${esc(co.name||'Your Company')}</div><div class="q-tagline">${esc(co.tag||'')}</div><div class="q-contact">${esc(co.contact||'')}</div></div><div class="q-head-right"><div class="q-title">${title}</div><div class="q-meta">${metaHTML}</div></div></div>`}
function quotationHTMLFor(q){
 const z=qCalc(q),items=z.items,co=db.co||{};
 const escN=v=>esc(v).replace(/\r?\n/g,'<br>');
 const desc=(x)=>escN(x.description||qDescription(x));
 const size=(x)=>x.sizeText||((x.w||x.h)?`${x.w||'-'} × ${x.h||'-'} mm${x.t?' | '+x.t+' mm':''}`:'-');
 const header=qHeaderHTML('QUOTATION',`<b>${esc(qLabel(q))}</b><br>${qDate(q.date)}<br>Valid till ${qDate(q.validTill)}`);
 const summaryRows=items.map((x,i)=>`<tr><td>${i+1}</td><td><b>${esc(x.product||'Item')}</b>${x.sizeText?`<br><span class="mu">${esc(x.sizeText)}</span>`:''}</td><td>${esc(x.unit||'Nos')}</td><td class="q-right">${qMoney(x.rate)}</td><td class="q-right">${x.qty||0}</td><td class="q-right">${qMoney((+x.rate||0)*(+x.qty||0))}</td></tr>`).join('');
  const rowH=b=>{const t=String(b.description||'');const ln=1+(b.sizeText?1:0)+(t?t.split(/\r?\n/).reduce((a,p)=>a+Math.max(1,Math.ceil(p.length/84)),0):0);return 9+ln*4.4};
  const detailPages=[];
  items.forEach((x,i)=>{
    const rows=qBreakups(x),chunks=[];let cur=[],used=0;let capNow=(i===0?168:184);
    rows.forEach(b=>{const hh=rowH(b);if(cur.length&&used+hh>capNow){chunks.push(cur);cur=[];used=0;capNow=200}cur.push(b);used+=hh});
    if(cur.length)chunks.push(cur);if(!chunks.length)chunks.push([]);
    let idx=0;
    chunks.forEach((ch,ci)=>{
      const last=ci===chunks.length-1,start=idx;idx+=ch.length;
      const body=ch.map((b,j)=>`<tr><td>${start+j+1}</td><td class="q-description-box"><b>${esc(b.title||'Detail')}</b>${b.sizeText?`<br><span class="mu">Size: ${esc(b.sizeText)}</span>`:''}${b.description?`<div class="q-breakup-desc">${escN(b.description)}</div>`:''}</td><td class="q-right">${esc(b.unit||x.unit||'Nos')}</td><td class="q-right">${qMoney(b.rate)}</td><td class="q-right">${b.qty||1}</td><td class="q-right">${qMoney((+b.rate||0)*(+b.qty||0))}</td></tr>`).join('');
      detailPages.push({first:i===0&&ci===0,html:`<div class="q-detail-item"><div class="q-detail-title">${i+1}. ${esc(x.product||'Item')}${ci?' (contd.)':''}</div><div class="q-detail-size"><b>Size:</b> ${esc(size(x))}</div><table class="q-desc-table"><tr><th>Sr.</th><th>Description</th><th class="q-right">Unit</th><th class="q-right">Rate</th><th class="q-right">Qty</th><th class="q-right">Total</th></tr>${body}${last?`<tr class="q-total-row"><td colspan="5" class="q-right"><b>Total Per Unit</b></td><td class="q-right"><b>${qMoney(qBreakupTotal(x))}</b></td></tr>`:''}</table></div>`});
    });
  });
 let h=`<div class="q-wrap"><div class="q-page">${header}<div class="q-to-block"><div class="q-label">TO</div><div class="q-value">${esc(q.customer||'Client Name')}</div>${q.company?`<div class="q-value">${esc(q.company)}</div>`:''}${q.address?`<div class="q-value">${esc(q.address)}</div>`:''}${q.attention?`<div class="q-value"><b>Attention:</b> ${esc(q.attention)}</div>`:''}</div><div class="q-subject-block"><div class="q-label">SUBJECT</div><div class="q-subject">${esc(q.subject||'Quotation for Supply & Installation')}</div></div><div class="q-intro">${esc(q.intro||'With reference to the subject matter, we hereby submit our quotation for supply & installation of door and frame works for your project.')}</div><div class="q-section-title">Summary of Quotation</div><table class="q-table"><tr><th>Sr.</th><th>Description</th><th>Unit</th><th class="q-right">Rate</th><th class="q-right">Qty</th><th class="q-right">Total</th></tr>${summaryRows}<tr class="q-total-row"><td colspan="5" class="q-right"><b>Total Amount</b></td><td class="q-right"><b>${qMoney(z.sub)}</b></td></tr></table><div class="q-summary"><div class="q-summary-row"><span>Subtotal</span><b>${qMoney(z.sub)}</b></div><div class="q-summary-row"><span>Discount (${q.discountPercent||0}%)</span><b>${qMoney(z.da)}</b></div><div class="q-summary-row"><span>Taxable Amount</span><b>${qMoney(z.tax)}</b></div><div class="q-summary-row"><span>GST (${q.gstPercent||0}%)</span><b>${qMoney(z.ga)}</b></div><div class="q-grand"><span>Grand Total</span><span>${qMoney(z.grand)}</span></div><div class="q-amount-words"><b>Amount in Words:</b> ${esc(qWords(z.grand))}</div></div>${qFooter(q)}</div>`;
 h+=detailPages.map(p=>`<div class="q-page">${header}${p.first?'<div class="q-section-title">Detailed Quotation</div>':''}${p.html}${qFooter(q)}</div>`).join('');
 h+=`<div class="q-page">${header}<div class="q-section-title">Commercial & Acceptance</div><div class="q-section-title small">Payment Terms</div><div class="q-list">${String(q.payment||'').split(/\r?\n/).filter(x=>x.trim()).map(x=>`<div>• ${esc(x.trim())}</div>`).join('')}</div>${String(q.terms||'').trim()?`<div class="q-section-title small">Terms & Conditions</div><div class="q-list">${String(q.terms).split(/\r?\n/).filter(x=>x.trim()).map(x=>`<div>• ${esc(x.trim())}</div>`).join('')}</div>`:''}<div class="q-sign"><b>For ${esc(co.name||'Your Company')}</b><br><br><br><b>${esc(co.footerName||'Authorized Person')}</b><br>${esc(co.footerMobile||'')}${co.footerEmail?`<br>${esc(co.footerEmail)}`:''}<br><br>Authorized Signatory<br><br>Signature: ____________________<br>Date: ____________________</div>${qFooter(q)}</div></div>`;
 return h;
}
function qFooter(q){const c=db.co||{};return `<div class="q-footer"><span>${esc(c.name||'Your Company')}</span><span>Quotation ${esc(q?.id||'')}</span></div>`}
function qStyle(){return `<style>.q-wrap{font-family:Arial,sans-serif;color:#182334;background:#fff}.q-page{width:210mm;min-height:297mm;padding:49mm 15mm 18mm;position:relative;background:#fff;box-sizing:border-box;page-break-after:always;border:2.5px solid ${(db.co&&db.co.color)||'#07569a'}}.q-page:before{content:'';position:absolute;left:1.6mm;top:1.6mm;right:1.6mm;bottom:1.6mm;border:1px solid ${(db.co&&db.co.color)||'#07569a'};pointer-events:none;z-index:5}.q-header{position:absolute;top:0;left:0;right:0;height:43mm;background:#fff;color:#17212b;padding:5mm 15mm 0;box-sizing:border-box;display:grid;grid-template-columns:39mm 1fr 49mm;column-gap:5mm;overflow:hidden}.q-head-logo{height:34mm;border-right:.6mm solid #1685c8;display:flex;align-items:center;justify-content:center;padding-right:4mm}.q-logo{width:32mm;height:27mm;object-fit:contain;display:block}.q-head-company{padding-top:2mm}.q-company{font-size:21px;font-weight:700;color:#07569a;line-height:1.1}.q-tagline{font-size:11px;margin-top:2mm;color:#71808e;letter-spacing:.2px}.q-contact{font-size:8.5px;margin-top:3mm;color:#263746;line-height:1.35;max-width:92mm}.q-head-right{border-left:.6mm solid #1685c8;padding-left:5mm;padding-top:0;text-align:left}.q-title{position:relative;background:#07569a;color:#fff;padding:3.2mm 4mm;font-size:15px;font-weight:700;letter-spacing:.4px;overflow:hidden;margin-bottom:3mm}.q-title:after{content:'';position:absolute;right:2mm;top:-2mm;width:3mm;height:120%;background:#f58220;transform:skew(-24deg)}.q-meta{font-size:9px;color:#394956;line-height:1.65;padding-left:4mm}.q-meta b{font-size:11px;color:#07569a}.q-header:after{content:'';position:absolute;left:5mm;right:5mm;bottom:0;height:1.1mm;background:#07569a}.q-to-block{margin-top:2mm}.q-subject-block{margin-top:5mm;padding-top:4mm;border-top:1px solid #e2e7ec}.q-label{color:#66758a;font-size:9px;font-weight:700;letter-spacing:.5px;margin-bottom:4px}.q-value{font-size:12px}.q-subject{font-size:12px;font-weight:600;margin-top:2mm}.q-intro{font-size:10px;line-height:1.6;margin:8mm 0 7mm}.q-section-title{font-size:16px;font-weight:700;color:#000;margin:7mm 0 4mm}.q-section-title.small{font-size:13px;color:#000;border-bottom:1px solid #dfe4ea;padding-bottom:3px}.q-table{width:100%;border-collapse:collapse;font-size:9px}.q-table th{background:#07569a;color:#fff;padding:7px 6px;text-align:left}.q-table td{border:1px solid #dfe4ea;padding:7px 6px}.q-total-row td{background:#fff;font-size:10px}.q-detail-item{margin:0 0 10mm}.q-detail-title{font-size:13px;font-weight:700;color:#000;border-bottom:1px solid #dfe4ea;padding-bottom:3px;margin-bottom:4px}.q-detail-size{font-size:10px;margin:4px 0 6px}.q-desc-table{width:100%;border-collapse:collapse;font-size:9px}.q-desc-table th{background:#07569a;color:#fff;padding:6px;text-align:left}.q-desc-table td{border:1px solid #cfd6df;padding:7px 6px;vertical-align:top}.q-desc-editor{min-height:150px;min-width:240px;resize:vertical;line-height:1.55}.q-description-box{min-height:20mm;line-height:1.5;white-space:normal}.q-breakup-desc{margin-top:5px;line-height:1.5;font-size:10px}.q-desc-table .q-right{white-space:nowrap}.q-table tr:nth-child(even) td{background:#f6f7f9}.q-right{text-align:right!important}.q-summary{width:48%;margin-left:auto;margin-top:7mm}.q-summary-row{display:flex;justify-content:space-between;padding:4px 0;font-size:10px}.q-grand{margin-top:4px;padding:9px 10px;background:#07569a;color:#fff;display:flex;justify-content:space-between;font-size:12px;font-weight:700}.q-list{padding-left:18px;font-size:10px;line-height:1.8}.q-sign{margin-top:15mm;font-size:10px;line-height:2}.q-footer{position:absolute;left:15mm;right:15mm;bottom:7mm;border-top:1px solid #dfe4ea;padding-top:4mm;display:flex;justify-content:space-between;color:#66758a;font-size:8px}@media print{.q-page{margin:0;box-shadow:none}}</style>`}
function downloadSavedQuotationPDF(id){const q=savedQ(id)||window._qEdit;if(!q)return toast('Quotation not found');downloadQuotationPDF2(q)}
async function downloadQuotationPDF2(q){
  try{
    if(!window.jspdf||!window.jspdf.jsPDF)return toast('PDF library is not loaded. Please refresh the page.');
    if(!window.html2canvas)return toast('PDF renderer is not loaded. Please refresh the page.');
    const host=document.createElement('div');host.id='pdf-render-host';host.style.cssText='position:fixed;left:-100000px;top:0;width:210mm;background:#fff;z-index:-1;';
    host.innerHTML=qStyle()+`<div class="q-wrap">${quotationHTMLFor(q)}</div>`;
    document.body.appendChild(host);
    const pages=[...host.querySelectorAll('.q-page')];
    const {jsPDF}=window.jspdf;const pdf=new jsPDF({unit:'mm',format:'a4',compress:true});
    for(let i=0;i<pages.length;i++){
      const page=pages[i];
      page.style.margin='0';page.style.boxShadow='none';page.style.width='210mm';page.style.minHeight='297mm';
      page.style.boxSizing='border-box';page.style.width='210mm';page.style.height='297mm';page.style.minHeight='297mm';page.style.maxHeight='297mm';page.style.overflow='hidden';
      const canvas=await html2canvas(page,{scale:3,useCORS:true,backgroundColor:'#fff',logging:false,windowWidth:794,windowHeight:1123});
      const img=canvas.toDataURL('image/png');
      if(i>0)pdf.addPage();
      pdf.addImage(img,'PNG',0,0,210,297,undefined,'FAST');
    }
    document.body.removeChild(host);
    pdf.save(`Quotation-${q.id||'DRAFT'}.pdf`);toast('Quotation PDF downloaded');
  }catch(err){const h=document.getElementById('pdf-render-host');if(h)h.remove();console.error(err);toast('Quotation PDF error: '+(err?.message||err));}
}
/* Word export: table-based HTML that Microsoft Word / LibreOffice open correctly (Word ignores absolute positioning, grid and flex) */
function quotationWordHTML(q){
  const z=qCalc(q),items=z.items||[],co=db.co||{};const NAVYB=co.color||'#07569a';
  const F='font-family:Arial,Helvetica,sans-serif;',NAVY=co.color||'#0e1b2c',MUTED='#66758a',LINE='#cfd6df',SOFT='#f4f6f8';
  const tbl='border-collapse:collapse;width:100%;table-layout:fixed;';
  const th=(t,al,w)=>`<td width="${w||''}" style="background:${NAVY};padding:7pt 6pt;text-align:${al||'left'};border:1px solid ${NAVY}"><b><font color="#ffffff" style="${F}font-size:9pt">${t}</font></b></td>`;
  const td=(t,al='left',bold=false,bg='')=>`<td ${bg?`bgcolor="${bg}"`:''} style="${F}font-size:9pt;border:1px solid ${LINE};padding:6pt;vertical-align:top;text-align:${al};line-height:1.35;word-wrap:break-word;overflow-wrap:break-word;${bg?`background:${bg};`:''}">${bold?`<b>${t}</b>`:t}</td>`;
  const h2=t=>`<p style="${F}font-size:16pt;font-weight:bold;margin:14pt 0 7pt;color:#000000">${t}</p>`;
  const h3=t=>`<p style="${F}font-size:11pt;font-weight:bold;color:#000000;margin:12pt 0 6pt;border-bottom:1px solid ${LINE};padding-bottom:3pt">${t}</p>`;
  const label=t=>`<font color="${MUTED}" style="${F}font-size:8pt"><b>${t}</b></font>`;
  const lines=s=>String(s||'').split(/\r?\n/).filter(x=>x.trim()).map(x=>`<p style="${F}font-size:9.5pt;margin:0 0 4pt 12pt;line-height:1.4">•&nbsp; ${esc(x.trim())}</p>`).join('');
  const foot=`<div style="mso-element:footer" id="f1"><table width="100%" cellspacing="0" cellpadding="0" style="${tbl}"><tr><td style="border:none;border-top:1px solid ${LINE};padding-top:6pt"><font color="${MUTED}" style="${F}font-size:8pt">${esc(co.name||'Your Company')}</font></td><td align="right" style="border:none;border-top:1px solid ${LINE};padding-top:6pt"><font color="${MUTED}" style="${F}font-size:8pt">Quotation ${esc(q.id||'DRAFT')}</font></td></tr></table></div>`;
  const brk=`<p style="page-break-before:always;margin:0;font-size:1pt;line-height:1pt">&nbsp;</p>`;
  const logoHTML=co.logo?`<img src="companylogo.png" width="78" height="44" style="display:block;width:78pt;height:44pt;object-fit:contain;background:#ffffff;padding:2pt" alt="Company Logo">`:'';
  const hdr=`<table width="100%" cellspacing="0" cellpadding="0" style="${tbl}"><tr><td width="24%" style="border:none;border-right:1.5pt solid #1685c8;padding:5pt 10pt 5pt 0;vertical-align:middle;text-align:center">${logoHTML}</td><td width="48%" style="border:none;padding:6pt 10pt;vertical-align:middle"><b><font color="#07569a" style="${F}font-size:19pt">${esc(co.name||'Your Company')}</font></b>${co.tag?`<br><font color="#71808e" style="${F}font-size:9pt">${esc(co.tag)}</font>`:''}${co.contact?`<br><font color="#263746" style="${F}font-size:7.5pt">${esc(co.contact)}</font>`:''}</td><td width="28%" style="border:none;border-left:1.5pt solid #1685c8;padding:4pt 0 4pt 10pt;vertical-align:top"><div style="background:#07569a;color:#ffffff;padding:7pt 9pt;font-weight:bold;font-size:13pt">QUOTATION</div><div style="padding:5pt 0 0 10pt;font-size:8.5pt;line-height:1.6"><b><font color="#07569a" style="${F}font-size:10.5pt">${esc(q.id||'DRAFT')}</font></b><br>${qDate(q.date)}<br>Valid till ${qDate(q.validTill)}</div></td></tr><tr><td colspan="3" style="border:none;padding:5pt 0 0"><table width="100%" cellspacing="0" cellpadding="0"><tr><td width="88%" style="border:none;height:3pt;background:#07569a">&nbsp;</td><td width="3%" style="border:none;height:3pt;background:#f58220">&nbsp;</td><td width="9%" style="border:none;height:3pt;background:#07569a">&nbsp;</td></tr></table></td></tr></table>`;
  let h=hdr;
  h+=`<table width="100%" cellspacing="0" cellpadding="0" style="${tbl}margin-top:14pt"><tr><td style="border:none;padding:0">${label('TO')}<br><font style="${F}font-size:12pt"><b>${esc(q.customer||'Client Name')}</b></font>${q.company?`<br><font color="${MUTED}" style="${F}font-size:9pt">${esc(q.company)}</font>`:''}${q.address?`<br><font color="${MUTED}" style="${F}font-size:9pt">${esc(q.address)}</font>`:''}${q.attention?`<br><font style="${F}font-size:9pt"><b>Attention:</b> ${esc(q.attention)}</font>`:''}</td></tr></table>`;
  h+=`<table width="100%" cellspacing="0" cellpadding="0" style="${tbl}margin-top:10pt"><tr><td style="border:none;border-top:1px solid ${LINE};padding-top:8pt">${label('SUBJECT')}<br><b><font style="${F}font-size:11pt">${esc(q.subject||'Quotation for Supply & Installation')}</font></b></td></tr></table>`;
  h+=`<p style="${F}font-size:9.5pt;line-height:1.5;margin:16pt 0 8pt">${esc(q.intro||'With reference to the subject matter, we are pleased to submit our quotation for the supply and installation of the item detailed below.')}</p>`;
  h+=h2('Summary of Quotation');
  h+=`<table width="100%" cellspacing="0" cellpadding="0" style="${tbl}"><tr>${th('Sr.','left','6%')}${th('Description','left','50%')}${th('Unit','left','9%')}${th('Rate','right','14%')}${th('Qty','right','8%')}${th('Total','right','13%')}</tr>`;
  items.forEach((x,i)=>{const size=x.sizeText||((x.w||x.h)?`${x.w||'-'} × ${x.h||'-'} mm${x.t?' | '+x.t+' mm':''}`:'');h+=`<tr>${td(String(i+1))}${td(`<b>${esc(x.product||'Item')}</b>${size?`<br><font color="${MUTED}" style="${F}font-size:8pt">${esc(size)}</font>`:''}`)}${td(esc(x.unit||'Nos'))}${td(qMoney(x.rate),'right')}${td(String(x.qty||0),'right')}${td(qMoney((+x.rate||0)*(+x.qty||0)),'right')}</tr>`});
  h+=`</table>`;
  const sr=(a,b)=>`<tr><td style="${F}font-size:10pt;color:${MUTED};padding:3pt 6pt;text-align:left">${a}</td><td align="right" style="${F}font-size:10pt;padding:3pt 6pt;text-align:right">${b}</td></tr>`;
  h+=`<br><table cellspacing="0" cellpadding="0" align="right" width="50%" style="border-collapse:collapse;width:50%;margin-left:auto">${sr('Total Amount',qMoney(z.sub))}${sr('Subtotal',qMoney(z.sub))}${sr('Discount ('+(q.discountPercent||0)+'%)',qMoney(z.da))}${sr('Taxable Amount',qMoney(z.tax))}${sr('GST ('+(q.gstPercent||0)+'%)',qMoney(z.ga))}<tr><td bgcolor="${NAVY}" style="background:${NAVY};padding:7pt"><b><font color="#ffffff" style="${F}font-size:11pt">Grand Total</font></b></td><td bgcolor="${NAVY}" align="right" style="background:${NAVY};padding:7pt;text-align:right"><b><font color="#ffffff" style="${F}font-size:11pt">${qMoney(z.grand)}</font></b></td></tr></table><br clear="all">`;
  h+=brk+h2('Detailed Quotation');
  items.forEach((x,i)=>{
    const size=x.sizeText||((x.w||x.h)?`${x.w||'-'} × ${x.h||'-'} mm${x.t?' | '+x.t+' mm':''}`:'-');
    if(i>0)h+=brk;
    h+=`<p style="${F}font-size:12pt;font-weight:bold;color:#000000;margin:10pt 0 3pt">${i+1}. ${esc(x.product||'Item')}</p><p style="${F}font-size:9pt;margin:0 0 6pt"><b>Size:</b> ${esc(size)}</p>`;
    h+=`<table width="100%" cellspacing="0" cellpadding="0" style="${tbl}"><tr>${th('Sr.','left','6%')}${th('Description','left','54%')}${th('Unit','right','9%')}${th('Rate','right','12%')}${th('Qty','right','8%')}${th('Total','right','11%')}</tr>`;
    qBreakups(x).forEach((b,j)=>{h+=`<tr>${td(String(j+1))}${td(`<b>${esc(b.title||'Detail')}</b>${b.sizeText?`<br><font color="${MUTED}" style="${F}font-size:8pt">Size: ${esc(b.sizeText)}</font>`:''}${b.description?`<div style="margin-top:5pt;line-height:1.45;font-size:10pt;${F}">${esc(b.description).replace(/\r?\n/g,'<br>')}</div>`:''}`)}${td(esc(b.unit||x.unit||'Nos'),'right')}${td(qMoney(b.rate),'right')}${td(String(b.qty||1),'right')}${td(qMoney((+b.rate||0)*(+b.qty||0)),'right')}</tr>`});
    h+=`<tr><td colspan="5" bgcolor="${SOFT}" style="${F}font-size:9pt;border:1px solid ${LINE};padding:7pt;text-align:right;background:${SOFT};"><b>Total Per Unit</b></td><td bgcolor="${SOFT}" style="${F}font-size:9pt;border:1px solid ${LINE};padding:7pt;text-align:right;background:${SOFT};"><b>${qMoney(qBreakupTotal(x))}</b></td></tr></table>`;
  });
  h+=foot+brk+h2('Commercial & Acceptance')+h3('Payment Terms')+lines(q.payment);
  if(String(q.terms||'').trim())h+=h3('Terms &amp; Conditions')+lines(q.terms);
  h+=h3('Authorized Signatory')+`<table width="100%" cellspacing="0" cellpadding="0" style="${tbl}margin-top:10pt"><tr><td width="55%" style="border:none;vertical-align:top"><b><font style="${F}font-size:10pt">For ${esc(co.name||'Your Company')}</font></b><br><br><br><font color="${MUTED}" style="${F}font-size:9pt">Authorized Signatory</font></td><td width="45%" style="border:none;vertical-align:top"><font style="${F}font-size:9pt"><b>${esc(co.footerName||'Authorized Person')}</b><br>${esc(co.footerMobile||'')}${co.footerEmail?`<br>${esc(co.footerEmail)}`:''}</font><br><br><font color="${MUTED}" style="${F}font-size:9pt">Signature: ____________________<br>Date: ________________________</font></td></tr></table>`;
  return '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word" xmlns:v="urn:schemas-microsoft-com:vml" xmlns="http://www.w3.org/TR/REC-html40"><head><meta charset="utf-8"><title>Quotation '+esc(q.id||'DRAFT')+'</title><!--[if gte mso 9]><xml><w:WordDocument><w:View>Print</w:View><w:Zoom>100</w:Zoom><w:DoNotOptimizeForBrowser/></w:WordDocument></xml><![endif]--><style>@page WordSection1{size:210mm 297mm;margin:14mm 17mm 18mm 17mm;mso-header-margin:8mm;mso-footer-margin:8mm;mso-paper-source:0;mso-footer:f1;border:solid '+NAVYB+' 2.25pt;mso-border-alt:solid '+NAVYB+' 2.25pt;padding:12pt 12pt 12pt 12pt;mso-page-border-surround-header:yes;mso-page-border-surround-footer:yes}div.WordSection1{page:WordSection1}body{font-family:Arial,Helvetica,sans-serif;color:#182334}table{border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0}p{margin:0}td{mso-padding-alt:6pt}</style></head><body><div class="WordSection1">'+h+'</div></body></html>';
}
function downloadSavedQuotationWord(id){
  const q=savedQ(id)||window._qEdit;if(!q)return toast('Quotation not found');
  const html=quotationWordHTML(q);
  const logo=db.co&&db.co.logo?String(db.co.logo):'';
  if(logo&&/^data:image\/png;base64,/i.test(logo)){
    const b64=logo.split(',')[1]||'';
    const boundary='----=_QuotationBuilder_'+Date.now().toString(36);
    const html64=btoa(unescape(encodeURIComponent(html)));
    const mhtml=[
      'MIME-Version: 1.0',
      'Content-Type: multipart/related; boundary="'+boundary+'"',
      '',
      '--'+boundary,
      'Content-Type: text/html; charset="utf-8"',
      'Content-Transfer-Encoding: base64',
      'Content-Location: quotation.html',
      '',
      html64.match(/.{1,76}/g)?.join('\r\n')||html64,
      '',
      '--'+boundary,
      'Content-Type: image/png',
      'Content-Transfer-Encoding: base64',
      'Content-Location: companylogo.png',
      'Content-ID: <companylogo>',
      '',
      b64.match(/.{1,76}/g)?.join('\r\n')||b64,
      '',
      '--'+boundary+'--',
      ''
    ].join('\r\n');
    const blob=new Blob([mhtml],{type:'application/msword'}),url=URL.createObjectURL(blob),a=document.createElement('a');
    a.href=url;a.download=`Quotation-${q.id||'DRAFT'}.doc`;document.body.appendChild(a);a.click();a.remove();setTimeout(()=>URL.revokeObjectURL(url),2000);toast('Word file downloaded');
  }else{
    const blob=new Blob(['\ufeff',html],{type:'application/msword'}),url=URL.createObjectURL(blob),a=document.createElement('a');a.href=url;a.download=`Quotation-${q.id||'DRAFT'}.doc`;document.body.appendChild(a);a.click();a.remove();setTimeout(()=>URL.revokeObjectURL(url),1500);toast('Word file downloaded');
  }
}


/* ===== TAX INVOICE MODULE ===== */
function invMoney(n){return (db.cur||'₹')+(+n||0).toLocaleString('en-IN',{minimumFractionDigits:2,maximumFractionDigits:2})}
function invNo(){return 'INV-'+String(db.invseq++).padStart(4,'0')}
function blankInvoice(){return {id:invNo(),date:today(),deliveryChallan:'',building:'',woNo:'',nature:'WOOD DOORS SUPPLY',billed:{name:'',address:'',state:'Maharashtra',code:'27',gstin:''},consignee:{name:'',address:'',state:'Maharashtra',code:'27',gstin:''},items:[{particular:'',hsn:'',qty:1,unit:'Nos',rate:0}],taxMode:'CGST_SGST',taxPercent:18,roundOff:true,bankName:'',ifsc:'',branch:'',account:'',terms:'',signatory:db.co.footerName||''}}
function invoiceCalc(inv){const items=(inv.items||[]).map(x=>{const qty=+x.qty||0,rate=+x.rate||0,taxable=qty*rate;return {...x,qty,rate,taxable,total:taxable}});const subtotal=items.reduce((a,x)=>a+x.taxable,0),tp=Math.max(0,+inv.taxPercent||0),tax=subtotal*tp/100;let cgst=0,sgst=0,igst=0;if(inv.taxMode==='IGST')igst=tax;else{cgst=tax/2;sgst=tax/2}const raw=subtotal+tax,rounded=inv.roundOff?Math.round(raw):raw,roundOff=rounded-raw;return {items,subtotal,tax,cgst,sgst,igst,roundOff,grand:rounded}}
function invWords(n){n=Math.round(+n||0);if(!n)return 'Zero Rupees Only';const ones=['','One','Two','Three','Four','Five','Six','Seven','Eight','Nine','Ten','Eleven','Twelve','Thirteen','Fourteen','Fifteen','Sixteen','Seventeen','Eighteen','Nineteen'],tens=['','','Twenty','Thirty','Forty','Fifty','Sixty','Seventy','Eighty','Ninety'];const two=x=>x<20?ones[x]:tens[Math.floor(x/10)]+(x%10?' '+ones[x%10]:'');const seg=(x)=>{let a=[];if(x>=100){a.push(ones[Math.floor(x/100)]+' Hundred');x%=100}if(x)a.push(two(x));return a.join(' ')};let a=[];if(n>=10000000){a.push(seg(Math.floor(n/10000000))+' Crore');n%=10000000}if(n>=100000){a.push(seg(Math.floor(n/100000))+' Lakh');n%=100000}if(n>=1000){a.push(seg(Math.floor(n/1000))+' Thousand');n%=1000}if(n)a.push(seg(n));return a.join(' ')+' Rupees Only'}
function invoiceView(){
 const list=db.taxInvoices||[];
 const co=db.co||{};
 const brand=co.logo?`<img src="${co.logo}" style="max-width:86px;max-height:48px;object-fit:contain">`:'';
 return `<div class="invoice-brand"><div class="invoice-brand-logo">${brand}</div><div><div class="invoice-brand-name">${esc(co.name||'Your Company')}</div><div class="invoice-brand-tag">${esc(co.tag||'Tax Invoice & GST Billing')}</div><div class="invoice-brand-contact">${esc(co.contact||'')}</div></div><div class="invoice-brand-title">TAX INVOICE</div></div>
 <div class="pn"><div class="row"><button class="pri" onclick="newTaxInvoice()">+ New Tax Invoice</button><button onclick="importTaxInvoiceFromQuotation()">Import From Quotation</button></div><p class="mu">Create GST tax invoices separately from quotations. Internal Cost, profit and margins are never printed on the tax invoice.</p></div>
 ${list.length?`<div class="tw"><table><tr><th>Invoice No.</th><th>Date</th><th>Billed To</th><th>Items</th><th>Taxable</th><th>Grand Total</th><th></th></tr>${list.map(x=>{const z=invoiceCalc(x);return `<tr><td><b>${esc(x.id)}</b></td><td>${esc(x.date)}</td><td>${esc(x.billed?.name||'-')}</td><td>${z.items.length}</td><td>${invMoney(z.subtotal)}</td><td>${invMoney(z.grand)}</td><td><button onclick="editTaxInvoice('${x.id}')">Open</button> <button onclick="previewTaxInvoice('${x.id}')">Preview</button> <button onclick="downloadTaxInvoicePDF('${x.id}')">PDF</button></td></tr>`}).join('')}</table></div>`:'<div class="pn"><p class="mu">No tax invoices yet.</p></div>'}
 ${window._invEdit?taxInvoiceEditor(window._invEdit):''}${window._invPick?taxInvoiceQuotationPicker():''}`
}
function taxInvoiceQuotationPicker(){
 const qs=db.quotations||[];
 return `<div class="ov pvo"><div class="pn" style="max-width:1050px;width:100%;margin:auto"><div class="row" style="justify-content:space-between"><div><h3 style="margin:0">Select Quotation for Tax Invoice</h3><p class="mu" style="margin:4px 0 0">Choose a saved quotation. Its customer, items, quantities and quotation rates will be imported into the Tax Invoice.</p></div><button onclick="window._invPick=null;render()">Close</button></div><div class="tw" style="margin-top:12px"><table><tr><th>Quotation</th><th>Date</th><th>Customer</th><th>Items</th><th>Quotation Value</th><th>Status</th><th></th></tr>${qs.length?qs.map(q=>{const z=qCalc(q),cost=z.items.reduce((a,x)=>a+(x.costToCompany==null?0:(+x.costToCompany||0))*(+x.qty||0),0);return `<tr><td><b>${esc(q.id)}</b></td><td>${esc(q.date||'-')}</td><td>${esc(q.customer||'-')}</td><td>${z.items.length}</td><td>${qMoney(z.grand)}</td><td>${esc(((db.crm||[]).find(r=>r.quotationId===q.id)||{}).status||'Draft')}</td><td><button class="pri" onclick="selectQuotationForTaxInvoice('${q.id}')">Select</button></td></tr>`}).join(''):`<tr><td colspan="7" class="mu">No saved quotations found.</td></tr>`}</table></div></div></div>`;
}
function selectQuotationForTaxInvoice(id){
 const q=savedQ(id);if(!q)return toast('Quotation not found');
 const z=qCalc(q);const inv=blankInvoice();
 inv.billed.name=q.customer||'';inv.consignee.name=q.customer||'';inv.building=q.company||'';inv.woNo=q.id||'';inv.nature=q.subject||'WOOD DOORS SUPPLY';inv.terms=q.terms||'';
 inv.items=z.items.map(x=>({particular:x.product||'Supply & Installation',hsn:'',qty:+x.qty||1,unit:x.unit||'Nos',rate:+x.rate||0}));
 window._invEdit=inv;window._invPick=null;render();toast('Quotation '+q.id+' imported into Tax Invoice');
}
function invField(label,key,val,type='text'){return `<div><label>${label}</label><input type="${type}" value="${esc(val||'')}" onchange="invSet('${key}',this.value)"></div>`}
function taxInvoiceEditor(inv){const z=invoiceCalc(inv);return `<div class="pn"><div class="tax-invoice-editor-brand"><div>${db.co&&db.co.logo?`<img src="${db.co.logo}">`:``}</div><div><div class="name">${esc(db.co&&db.co.name||'Your Company')}</div><div class="mu">${esc(db.co&&db.co.tag||'Professional GST Tax Invoice')}</div></div><div class="title">TAX INVOICE</div></div><h2 style="margin-top:0">Tax Invoice Editor</h2><div class="g">${invField('Invoice No.','id',inv.id)}${invField('Date','date',inv.date,'date')}${invField('Delivery Challan','deliveryChallan',inv.deliveryChallan)}${invField('Building','building',inv.building)}${invField('W/O No.','woNo',inv.woNo)}${invField('Nature & Description of Service','nature',inv.nature)}</div><div class="g" style="margin-top:10px"><div><label>Details of Receiver (Billed To)</label><input placeholder="Name" value="${esc(inv.billed.name)}" onchange="invPartySet('billed','name',this.value)"><textarea rows="2" placeholder="Address" onchange="invPartySet('billed','address',this.value)">${esc(inv.billed.address)}</textarea><input placeholder="State" value="${esc(inv.billed.state)}" onchange="invPartySet('billed','state',this.value)"><input placeholder="State Code" value="${esc(inv.billed.code)}" onchange="invPartySet('billed','code',this.value)"><input placeholder="GSTIN" value="${esc(inv.billed.gstin)}" onchange="invPartySet('billed','gstin',this.value)"></div><div><label>Details of Consignee (Shipped To)</label><input placeholder="Name" value="${esc(inv.consignee.name)}" onchange="invPartySet('consignee','name',this.value)"><textarea rows="2" placeholder="Address" onchange="invPartySet('consignee','address',this.value)">${esc(inv.consignee.address)}</textarea><input placeholder="State" value="${esc(inv.consignee.state)}" onchange="invPartySet('consignee','state',this.value)"><input placeholder="State Code" value="${esc(inv.consignee.code)}" onchange="invPartySet('consignee','code',this.value)"><input placeholder="GSTIN" value="${esc(inv.consignee.gstin)}" onchange="invPartySet('consignee','gstin',this.value)"></div></div><h3>Invoice Items</h3><div class="tw"><table><tr><th>SN</th><th>Particulars</th><th>HSN/SAC</th><th>Qty</th><th>Unit</th><th>Rate</th><th>Taxable Amount</th><th></th></tr>${(inv.items||[]).map((x,i)=>`<tr><td>${i+1}</td><td><input value="${esc(x.particular)}" onchange="invItemSet(${i},'particular',this.value)"></td><td><input value="${esc(x.hsn)}" onchange="invItemSet(${i},'hsn',this.value)"></td><td><input type="number" min="0" value="${x.qty||0}" onchange="invItemNum(${i},'qty',this.value)"></td><td><input value="${esc(x.unit||'Nos')}" onchange="invItemSet(${i},'unit',this.value)"></td><td><input type="number" min="0" step="0.01" value="${x.rate||0}" onchange="invItemNum(${i},'rate',this.value)"></td><td><b>${invMoney((+x.qty||0)*(+x.rate||0))}</b></td><td><button onclick="invDeleteItem(${i})">Delete</button></td></tr>`).join('')}</table></div><div class="row"><button onclick="invAddItem()">+ Add Item</button></div><div class="g" style="margin-top:12px"><div><label>Tax Type</label><select onchange="invSet('taxMode',this.value)"><option value="">None</option><option value="CGST_SGST"${inv.taxMode==='CGST_SGST'?' selected':''}>CGST + SGST</option><option value="IGST"${inv.taxMode==='IGST'?' selected':''}>IGST</option></select></div>${invField('GST %','taxPercent',inv.taxPercent,'number')}<div><label>Round Off</label><select onchange="invSet('roundOff',this.value==='true')"><option value="">None</option><option value="true"${inv.roundOff?' selected':''}>Yes</option><option value="false"${!inv.roundOff?' selected':''}>No</option></select></div></div><div class="pn" style="margin-top:12px"><div class="g"><b>Taxable Amount ${invMoney(z.subtotal)}</b>${inv.taxMode==='IGST'?`<b>IGST ${invMoney(z.igst)}</b>`:`<b>CGST ${invMoney(z.cgst)}</b><b>SGST ${invMoney(z.sgst)}</b>`}<b>Round Off ${invMoney(z.roundOff)}</b><b class="big">TOTAL INVOICE AMOUNT ${invMoney(z.grand)}</b></div><p><b>Amount in Words:</b> ${esc(invWords(z.grand))}</p></div><div class="g"><div><label>Bank Name</label><input value="${esc(inv.bankName)}" onchange="invSet('bankName',this.value)"><label>IFSC Code</label><input value="${esc(inv.ifsc)}" onchange="invSet('ifsc',this.value)"><label>Branch</label><input value="${esc(inv.branch)}" onchange="invSet('branch',this.value)"><label>Account No.</label><input value="${esc(inv.account)}" onchange="invSet('account',this.value)"></div><div><label>Authorized Signatory</label><input value="${esc(inv.signatory)}" onchange="invSet('signatory',this.value)"><label>Terms / Notes</label><textarea rows="6" onchange="invSet('terms',this.value)">${esc(inv.terms)}</textarea></div></div><div class="row"><button class="pri" onclick="saveTaxInvoice()">Save Tax Invoice</button><button onclick="previewTaxInvoice('${inv.id}')">Preview</button><button onclick="downloadTaxInvoicePDF('${inv.id}')">Download PDF</button><button onclick="window._invEdit=null;render()">Close</button></div></div>`}
function invSet(k,v){if(!window._invEdit)return;window._invEdit[k]=v;render()}
function invPartySet(p,k,v){window._invEdit[p][k]=v;render()}
function invItemSet(i,k,v){window._invEdit.items[i][k]=v;render()}
function invItemNum(i,k,v){window._invEdit.items[i][k]=v===''?'':+v;render()}
function invAddItem(){window._invEdit.items.push({particular:'',hsn:'',qty:1,unit:'Nos',rate:0});render()}
function invDeleteItem(i){if(window._invEdit.items.length<=1)return toast('Keep at least one item');window._invEdit.items.splice(i,1);render()}
function newTaxInvoice(){window._invEdit=blankInvoice();render()}
function editTaxInvoice(id){const x=(db.taxInvoices||[]).find(a=>a.id===id);if(x){window._invEdit=clone(x);render()}}
function savedInv(id){return (db.taxInvoices||[]).find(a=>a.id===id)}
function saveTaxInvoice(){const x=clone(window._invEdit);x.userId=cu?.id||null;x.user=cu?.name||'';const i=(db.taxInvoices||[]).findIndex(a=>a.id===x.id);if(i>=0)db.taxInvoices[i]=x;else db.taxInvoices.unshift(x);window._invEdit=x;save();render();toast('Tax Invoice '+x.id+' saved')}
function importTaxInvoiceFromQuotation(){const qs=db.quotations||[];if(!qs.length)return toast('No saved quotation found');window._invPick=true;window._invEdit=null;render()}
function invoiceHeaderPDF(d,inv){
  const co=db.co||{},accent=co.color||'#1f5f86',A=rgb(accent);d.setFillColor(255,255,255);d.rect(0,0,210,297,'F');
  d.setDrawColor(...A);d.setLineWidth(.5);d.rect(10,8,190,281);
  if(co.logo){try{let fmt=/image\/png/i.test(co.logo)?'PNG':(/image\/jpeg|image\/jpg/i.test(co.logo)?'JPEG':'PNG');d.addImage(co.logo,fmt,168,12,25,25,undefined,'FAST')}catch(e){}}
  d.setFillColor(...A);d.roundedRect(15,12,180,13,1.5,1.5,'F');d.setFont('helvetica','bold');d.setFontSize(15);d.setTextColor(255,255,255);d.text('TAX INVOICE',105,21,{align:'center'});
  d.setFont('helvetica','bold');d.setFontSize(14);d.setTextColor(25,55,80);d.text(co.name||'Your Company',18,34);
  if(co.tag){d.setFont('helvetica','normal');d.setFontSize(8);d.setTextColor(90,105,120);d.text(co.tag,18,39)}
  d.setFont('helvetica','normal');d.setFontSize(7.5);d.setTextColor(40,55,68);const lines=d.splitTextToSize(co.contact||'',142);d.text(lines,18,44);
  d.setDrawColor(...A);d.setLineWidth(.35);d.line(15,50,195,50);
  return 55;
}
function invoiceText(d,text,x,y,w,size=7.8,bold=false,color=[25,35,45]){d.setFont('helvetica',bold?'bold':'normal');d.setFontSize(size);d.setTextColor(...color);const lines=d.splitTextToSize(String(text||'-'),w);d.text(lines,x,y);return Math.max(1,lines.length)*3.8}
function taxInvoiceDocumentHTML(inv){
 const z=invoiceCalc(inv),co=db.co||{},A=co.color||'#07569a',logo=co.logo?`<img src="${co.logo}" class="ti-logo" alt="Logo">`:'';
 const escN=v=>esc(v==null?'':v).replace(/\r?\n/g,'<br>');
 const party=(title,p)=>`<div class="ti-party"><div class="ti-party-title">${title}</div><div><b>Name:</b> ${esc(p?.name||'-')}</div><div><b>Address:</b> ${escN(p?.address||'-')}</div><div><b>State:</b> ${esc(p?.state||'-')} &nbsp;&nbsp; <b>Code:</b> ${esc(p?.code||'-')}</div><div><b>GSTIN:</b> ${esc(p?.gstin||'-')}</div></div>`;
 const rows=(z.items||[]).map((x,i)=>`<tr><td class="c">${i+1}</td><td><b>${esc(x.particular||'-')}</b></td><td class="c">${esc(x.hsn||'-')}</td><td class="c">${esc(x.qty||0)}</td><td class="c">${esc(x.unit||'Nos')}</td><td class="r">${esc(invMoney(x.rate))}</td><td class="r">${esc(invMoney(x.taxable))}</td></tr>`).join('');
 const totals=`<table class="ti-total"><tr><td>Taxable Amount</td><td>${esc(invMoney(z.subtotal))}</td></tr>${inv.taxMode==='IGST'?`<tr><td>IGST @ ${(+inv.taxPercent||0)}%</td><td>${esc(invMoney(z.igst))}</td></tr>`:`<tr><td>CGST @ ${((+inv.taxPercent||0)/2)}%</td><td>${esc(invMoney(z.cgst))}</td></tr><tr><td>SGST @ ${((+inv.taxPercent||0)/2)}%</td><td>${esc(invMoney(z.sgst))}</td></tr>`}<tr><td>Round Off</td><td>${esc(invMoney(z.roundOff))}</td></tr><tr class="grand"><td>TOTAL INVOICE AMOUNT</td><td>${esc(invMoney(z.grand))}</td></tr></table>`;
 const unifiedHeader=qHeaderHTML('TAX INVOICE',`<b>${esc(inv.id||'-')}</b><br>${qDate(inv.date||today())}`);
 return `${qStyle()}<div class="ti-doc" style="--ti-ac:${A}"><div class="ti-page" style="border:2.5px solid ${A}">${unifiedHeader}
 <table class="ti-meta"><tr><td><b>Name</b></td><td>${esc(inv.billed?.name||'-')}</td><td><b>Building</b></td><td>${esc(inv.building||'-')}</td></tr><tr><td><b>Invoice No.</b></td><td>${esc(inv.id||'-')}</td><td><b>W/O No.</b></td><td>${esc(inv.woNo||'-')}</td></tr><tr><td><b>Date</b></td><td>${esc(inv.date||'-')}</td><td><b>Nature & Description of Service</b></td><td>${escN(inv.nature||'-')}</td></tr></table>
 <div class="ti-parties">${party('Details of Receiver (Billed To)',inv.billed)}${party('Details of Consignee (Shipped To)',inv.consignee)}</div>
 <table class="ti-items"><thead><tr><th>SN</th><th>PARTICULARS</th><th>HSN/SAC</th><th>QTY</th><th>UNIT</th><th>RATE</th><th>TAXABLE AMOUNT</th></tr></thead><tbody>${rows||'<tr><td colspan="7" class="c">No items</td></tr>'}</tbody></table>
 <div class="ti-summary">${totals}</div>
 <div class="ti-words"><b>Amount in Words</b><span>${esc(invWords(z.grand))}</span></div>
 <div class="ti-bottom"><div class="ti-bank"><div class="ti-bottom-title">BANK DETAILS</div><div>Bank: ${esc(inv.bankName||'-')}</div><div>IFSC: ${esc(inv.ifsc||'-')}</div><div>Branch: ${esc(inv.branch||'-')}</div><div>A/c No.: ${esc(inv.account||'-')}</div></div><div class="ti-sign"><div class="ti-bottom-title">For ${esc(co.name||'Your Company')}</div><div class="ti-sign-space"></div><b>${esc(inv.signatory||co.footerName||'Authorized Signatory')}</b><div class="ti-muted">Authorized Signatory</div><div>Signature: ____________________</div><div>Date: ________________________</div></div></div>
 <div class="ti-footer">This is a computer generated tax invoice.</div></div></div>`;
}
function taxInvoiceStyle(){return `<style id="tax-invoice-style">.ti-doc{font-family:Arial,Helvetica,sans-serif;color:#182334;background:#fff}.ti-page{width:210mm;min-height:297mm;box-sizing:border-box;padding:9mm 9mm 12mm;background:#fff;position:relative;border:2.5px solid #07569a}.ti-page:before{content:'';position:absolute;left:1.6mm;top:1.6mm;right:1.6mm;bottom:1.6mm;border:1px solid var(--ti-ac,#07569a);pointer-events:none}.ti-head{height:32mm;display:grid;grid-template-columns:34mm 1fr 45mm;gap:5mm;align-items:center}.ti-logo-box{height:28mm;border-right:1px solid #1685c8;display:flex;align-items:center;justify-content:center;padding-right:4mm}.ti-logo{max-width:31mm;max-height:25mm;object-fit:contain}.ti-company-name{font-size:19px;font-weight:700;color:#07569a}.ti-tag{font-size:9px;color:#71808e;margin-top:2mm}.ti-contact{font-size:7.8px;color:#263746;line-height:1.4;margin-top:2mm}.ti-title{font-size:16px;font-weight:700;color:#fff;background:#07569a;padding:4mm 3mm;position:relative;align-self:start;margin-top:1mm}.ti-title:after{content:'';position:absolute;right:2mm;top:-2mm;width:3mm;height:120%;background:#f58220;transform:skew(-24deg)}.ti-accent{height:1mm;background:#07569a;margin-bottom:5mm}.ti-meta,.ti-items{width:100%;border-collapse:collapse;table-layout:fixed}.ti-meta td{border:1px solid #aeb8c2;padding:2.5mm 2mm;font-size:8.5px;vertical-align:top}.ti-meta td:nth-child(1),.ti-meta td:nth-child(3){width:13%;background:#f5f7f9}.ti-meta td:nth-child(2){width:24%}.ti-meta td:nth-child(4){width:50%}.ti-parties{display:grid;grid-template-columns:1fr 1fr;margin-top:3mm}.ti-party{border:1px solid #aeb8c2;padding:3mm;min-height:32mm;font-size:8.5px;line-height:1.55}.ti-party+.ti-party{border-left:0}.ti-party-title{font-weight:700;font-size:9px;color:#07569a;margin-bottom:2mm}.ti-items{margin-top:4mm;font-size:8.5px}.ti-items th{background:var(--ti-ac);color:#fff;padding:2.5mm 1.5mm;border:1px solid var(--ti-ac);font-size:8px}.ti-items td{border:1px solid #aeb8c2;padding:2.5mm 1.5mm;vertical-align:top}.ti-items th:nth-child(1){width:5%}.ti-items th:nth-child(2){width:34%}.ti-items th:nth-child(3){width:12%}.ti-items th:nth-child(4){width:7%}.ti-items th:nth-child(5){width:8%}.ti-items th:nth-child(6){width:14%}.ti-items th:nth-child(7){width:20%}.ti-items .c{text-align:center}.ti-items .r{text-align:right;white-space:nowrap}.ti-summary{display:flex;justify-content:flex-end;margin-top:3mm}.ti-total{width:48%;border-collapse:collapse;font-size:8.5px}.ti-total td{padding:2.2mm 2mm;border-bottom:1px solid #d8dee5}.ti-total td:last-child{text-align:right;font-weight:700}.ti-total .grand td{background:var(--ti-ac);color:#fff;border:0;font-size:9.5px;padding:3mm 2mm}.ti-words{border:1px solid #aeb8c2;margin-top:3mm;padding:3mm;display:grid;grid-template-columns:32mm 1fr;gap:3mm;font-size:8.5px;line-height:1.5}.ti-words b{color:#07569a}.ti-bottom{display:grid;grid-template-columns:1fr 1fr;margin-top:3mm;border:1px solid #aeb8c2;min-height:39mm}.ti-bank,.ti-sign{padding:3mm;font-size:8.5px;line-height:1.7}.ti-sign{border-left:1px solid #aeb8c2}.ti-bottom-title{font-weight:700;color:#07569a;margin-bottom:2mm}.ti-sign-space{height:9mm}.ti-muted{color:#66758a;margin:1mm 0}.ti-footer{position:absolute;left:15mm;right:15mm;bottom:7mm;border-top:1px solid #d8dee5;padding-top:4mm;text-align:center;color:#66758a;font-size:8px}.ti-page{padding:49mm 15mm 18mm;overflow:hidden}.ti-page .q-header{position:absolute;top:0;left:0;right:0;width:auto;height:43mm;padding:5mm 15mm 0;box-sizing:border-box;display:grid;grid-template-columns:39mm 1fr 49mm;column-gap:5mm;overflow:hidden}.ti-page .q-head-logo{height:34mm;border-right:.6mm solid #1685c8;display:flex;align-items:center;justify-content:center;padding-right:4mm}.ti-page .q-logo{width:32mm;height:27mm;object-fit:contain;display:block}.ti-page .q-head-company{padding-top:2mm}.ti-page .q-company{font-size:21px;font-weight:700;color:#07569a;line-height:1.1}.ti-page .q-tagline{font-size:11px;margin-top:2mm;color:#71808e;letter-spacing:.2px}.ti-page .q-contact{font-size:8.5px;margin-top:3mm;color:#263746;line-height:1.35;max-width:92mm}.ti-page .q-head-right{border-left:.6mm solid #1685c8;padding-left:5mm;padding-top:0;text-align:left}.ti-page .q-title{position:relative;background:#07569a;color:#fff;padding:3.2mm 4mm;font-size:15px;font-weight:700;letter-spacing:.4px;overflow:hidden;margin-bottom:3mm}.ti-page .q-title:after{content:'';position:absolute;right:2mm;top:-2mm;width:3mm;height:120%;background:#f58220;transform:skew(-24deg)}.ti-page .q-meta{font-size:9px;color:#394956;line-height:1.65;padding-left:4mm}.ti-page .q-meta b{font-size:11px;color:#07569a}.ti-page .q-header:after{content:'';position:absolute;left:5mm;right:5mm;bottom:0;height:1.1mm;background:#07569a}@media print{.ti-page{margin:0;box-shadow:none}}</style>`}
function downloadHTMLPagesPDF(html,selector,filename,styleHTML=''){return new Promise(async(resolve,reject)=>{try{if(!window.jspdf?.jsPDF||!window.html2canvas)throw new Error('PDF renderer is not loaded');const host=document.createElement('div');host.style.cssText='position:fixed;left:-100000px;top:0;width:210mm;background:#fff;z-index:-1';host.innerHTML=styleHTML+html;document.body.appendChild(host);await new Promise(r=>requestAnimationFrame(()=>requestAnimationFrame(r)));const pages=[...host.querySelectorAll(selector)];if(!pages.length)throw new Error('No printable page found');const pdf=new window.jspdf.jsPDF({unit:'mm',format:'a4',compress:true});for(let i=0;i<pages.length;i++){pages[i].style.boxSizing='border-box';pages[i].style.width='210mm';pages[i].style.height='297mm';pages[i].style.minHeight='297mm';pages[i].style.maxHeight='297mm';pages[i].style.overflow='hidden';const canvas=await html2canvas(pages[i],{scale:3,useCORS:true,backgroundColor:'#fff',logging:false,windowWidth:794,windowHeight:1123});if(i)pdf.addPage();pdf.addImage(canvas.toDataURL('image/png'),'PNG',0,0,210,297,undefined,'FAST')}host.remove();pdf.save(filename);resolve()}catch(e){document.getElementById('pdf-render-host')?.remove();reject(e)}})}
async function downloadTaxInvoicePDF(id){const inv=savedInv(id)||window._invEdit;if(!inv)return toast('Tax Invoice not found');try{await downloadHTMLPagesPDF(taxInvoiceDocumentHTML(inv),'.ti-page',`Tax-Invoice-${inv.id}.pdf`,taxInvoiceStyle());toast('Tax Invoice PDF downloaded')}catch(err){console.error(err);toast('Tax Invoice PDF error: '+(err?.message||err))}}
function previewTaxInvoice(id){const inv=savedInv(id)||window._invEdit;if(!inv)return;const o=document.createElement('div');o.className='ov pvo';o.innerHTML=`<div style="width:100%;max-width:950px;margin:auto"><div class="row" style="position:sticky;top:0;z-index:20;background:#f2f4f8;padding:8px;margin:0 0 8px"><button class="pri" onclick="downloadTaxInvoicePDF('${inv.id}')">Download PDF</button><button onclick="this.closest('.ov').remove()">Close</button></div>${taxInvoiceStyle()}${taxInvoiceDocumentHTML(inv)}</div>`;document.body.appendChild(o)}
function downloadTaxInvoiceWord(id){const inv=savedInv(id)||window._invEdit;if(!inv)return toast('Tax Invoice not found');const html='<!DOCTYPE html><html><head><meta charset="utf-8"><title>Tax Invoice '+esc(inv.id)+'</title><style>@page{size:A4;margin:0}body{margin:0;background:#fff;font-family:Arial,Helvetica,sans-serif}table{border-collapse:collapse}*{box-sizing:border-box}.ti-page{page-break-after:always}</style></head><body>'+taxInvoiceStyle()+taxInvoiceDocumentHTML(inv)+'</body></html>';const blob=new Blob(['\ufeff',html],{type:'application/msword'}),url=URL.createObjectURL(blob),a=document.createElement('a');a.href=url;a.download=`Tax-Invoice-${inv.id}.doc`;document.body.appendChild(a);a.click();a.remove();setTimeout(()=>URL.revokeObjectURL(url),1500);toast('Tax Invoice Word downloaded')}

function render(){
 if(!cu){document.body.className='auth';$('#nav').innerHTML='';$('#who').innerHTML='';$('#main').innerHTML=authView();return}
 document.body.className='';$('#brand').textContent=db.co.name&&db.co.name!='Your Company'?db.co.name:'Costing Builder';
 if(!allowed(page))page='dash';
 $('#nav').innerHTML=NAV.filter(n=>allowed(n[0])).map(n=>`<button class="${page==n[0]?'on':''}" onclick="go('${n[0]}')">${n[1]}</button>`).join('');
 $('#who').innerHTML=`${esc(cu.name)} <span class="mu">(${cu.role})</span> <button class="x" onclick="pw()">Password</button> <button class="x" onclick="logout()">Logout</button>`;
 $('#main').innerHTML={dash:dashView,shutter:()=>costView('shutter'),frame:()=>costView('frame'),door:doorCostView,quote:quotationView,invoice:invoiceView,crm:crmView,master:masterView,hist:histView,set:setView,users:usersView}[page]();if(page==='quote')bindQuotationPageActions();save()}
window.addEventListener('beforeunload',e=>{
 if(st||window._qEdit||window._invEdit){e.preventDefault();e.returnValue='You have unsaved changes.';return e.returnValue}
});
boot();
</script></body></html>
