document.addEventListener('DOMContentLoaded', ()=>{
  const user = UserModel.current();
  if(!user){ location.href='login.html'; return; }
  document.getElementById('userName').textContent = user.nombre + ' ' + user.apellidos;
  document.getElementById('userEmail').textContent = user.email;
  document.getElementById('logoutBtn').addEventListener('click', ()=>{
    UserModel.logout(); location.href='index.html';
  });
  const orders = JSON.parse(localStorage.getItem('eg_orders')||'[]');
  const el = document.getElementById('orders');
  el.innerHTML = orders.map(o=>`<div class="card"><h4>Pedido #${o.id}</h4><p>Total: $${o.total.toFixed(2)}</p><p>${new Date(o.date).toLocaleString()}</p></div>`).join('');
});
