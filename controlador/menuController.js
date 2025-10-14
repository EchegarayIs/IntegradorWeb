// Renderiza el menú y permite agregar al carrito
document.addEventListener('DOMContentLoaded', ()=>{
  const el = document.getElementById('menu-list');
  let products = ProductModel.getAll();
  if(!products.length) products = ProductModel.seed();
  el.innerHTML = products.map(p=>`<div class="card"><h4>${p.name}</h4><p>$${p.price.toFixed(2)}</p><button class="btn add" data-id="${p.id}">+ Añadir</button></div>`).join('');
  el.addEventListener('click', e=>{
    if(e.target.matches('.add')){
      const id = parseInt(e.target.dataset.id,10);
      const prod = ProductModel.find(id);
      CartModel.add(prod,1);
      alert('Añadido al carrito');
    }
  });
});
