document.addEventListener('DOMContentLoaded', ()=>{
  const payBtn = document.getElementById('payBtn');
  const radios = document.getElementsByName('pay');
  const cardForm = document.getElementById('cardForm');
  radios.forEach(r=>r.addEventListener('change', ()=> cardForm.style.display = (document.querySelector('input[name=pay]:checked').value==='card') ? 'block' : 'none'));
  payBtn.addEventListener('click', ()=>{
    const items = CartModel.get();
    if(!items.length){ document.getElementById('payMsg').textContent='El carrito está vacío.'; return; }
    // Simula creación de pedido
    const orders = JSON.parse(localStorage.getItem('eg_orders')||'[]');
    orders.push({id:Date.now(),items, total: items.reduce((s,i)=>s+i.qty*i.price,0), date:new Date().toISOString()});
    localStorage.setItem('eg_orders', JSON.stringify(orders));
    CartModel.clear();
    document.getElementById('payMsg').textContent='Pago registrado. Gracias por tu compra.';
  });
});
