// Modelo simulado de usuarios usando localStorage
const UserModel = {
  key: 'eg_users',
  currentKey: 'eg_current_user',
  getAll(){ return JSON.parse(localStorage.getItem(this.key) || '[]') },
  saveAll(users){ localStorage.setItem(this.key, JSON.stringify(users)) },
  create(user){
    const users = this.getAll();
    user.id = Date.now();
    users.push(user); this.saveAll(users);
    return user;
  },
  findByEmail(email){ return this.getAll().find(u=>u.email===email) },
  login(email,password){
    const u = this.findByEmail(email);
    if(u && u.password===password){ localStorage.setItem(this.currentKey, JSON.stringify(u)); return u; }
    return null;
  },
  logout(){ localStorage.removeItem(this.currentKey) },
  current(){ return JSON.parse(localStorage.getItem(this.currentKey) || 'null') },
  

};
