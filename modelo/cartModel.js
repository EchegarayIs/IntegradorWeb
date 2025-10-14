// Modelo de carrito simple
const CartModel = {
  key: 'eg_cart',
  get(){ return JSON.parse(localStorage.getItem(this.key) || '[]') },
  save(items){ localStorage.setItem(this.key, JSON.stringify(items)) },
  add(product,qty=1){
    const items = this.get();
    const found = items.find(i=>i.id===product.id);
    if(found) found.qty += qty; else items.push({...product,qty});
    this.save(items);
  },
  remove(id){ const items=this.get().filter(i=>i.id!==id); this.save(items) },
  clear(){ localStorage.removeItem(this.key) }
};
