document.addEventListener('DOMContentLoaded', ()=>{
  const el = document.getElementById('admin-products');
  function render(){ const ps = ProductModel.getAll(); el.innerHTML = ps.map(p=>`<div class="card"><strong>${p.name}</strong><p>$${p.price}</p></div>`).join(''); }
  document.getElementById('seedBtn').addEventListener('click', ()=>{ ProductModel.seed(); render(); });
  render();
});
