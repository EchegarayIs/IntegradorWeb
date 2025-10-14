// Carga productos populares en la página principal
document.addEventListener('DOMContentLoaded', ()=>{
  const el = document.getElementById('popular-list');
  const p = JSON.parse(localStorage.getItem('eg_products')||'[]').slice(0,3);
  el.innerHTML = p.map(x=>`<div class="card"><h4>${x.name}</h4><p>$${x.price.toFixed(2)}</p></div>`).join('');
});
