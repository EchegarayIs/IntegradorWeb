// Modelo simulado de productos
const ProductModel = {
  key: 'eg_products',
  getAll(){ return JSON.parse(localStorage.getItem(this.key) || '[]') },
  saveAll(arr){ localStorage.setItem(this.key, JSON.stringify(arr)) },
  seed(){
    const sample = [
      {id:1,name:'Tacos al pastor',price:14,cat:'Tacos'},
      {id:2,name:'Tacos de chorizo',price:19,cat:'Tacos'},
      {id:3,name:'Tacos de arrachera',price:57,cat:'Tacos'},
      {id:4,name:'Tacos de bistec',price:17,cat:'Tacos'}
      
    ];
    this.saveAll(sample); return sample;
  },
  find(id){ return this.getAll().find(p=>p.id==id) }
};
