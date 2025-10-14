// Modelo simulado de productos
const ProductModel = {
  key: 'eg_products',
  getAll(){ return JSON.parse(localStorage.getItem(this.key) || '[]') },
  saveAll(arr){ localStorage.setItem(this.key, JSON.stringify(arr)) },
  seed(){
    const sample = [
      {id:1,name:'Torta de Jamon',price:14,cat:'Tortas'},
      {id:2,name:'Torta de bistec',price:19,cat:'Tortas'},
      {id:3,name:'Torta de Pollo',price:57,cat:'Tortas'},
      {id:4,name:'Torta de chorizo',price:17,cat:'Tortas'}
    ];
    this.saveAll(sample); return sample;
  },
  find(id){ return this.getAll().find(p=>p.id==id) }
};
