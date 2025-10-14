document.addEventListener('DOMContentLoaded', ()=>{
  const el = document.getElementById('cart-items');
  function render(){
    const items = CartModel.get();
    if(!items.length){ el.innerHTML='<p>Tu carrito está vacío.</p>'; document.getElementById('totals').textContent='Subtotal: $0.00'; return; }
    el.innerHTML = items.map(i=>`<div class="card"><h4>${i.name}</h4><p>$${i.price} x ${i.qty}</p><button class="btn remove" data-id="${i.id}">-</button></div>`).join('');
    const total = items.reduce((s,it)=>s+it.price*it.qty,0);
    document.getElementById('totals').textContent = 'Subtotal: $' + total.toFixed(2);
  }
  el.addEventListener('click', e=>{
    if(e.target.matches('.remove')){ CartModel.remove(parseInt(e.target.dataset.id,10)); render(); }
  });
  render();
});
