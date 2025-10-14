// Maneja login y registro
document.addEventListener('DOMContentLoaded', ()=>{
  const loginForm = document.getElementById('loginForm');
  const regForm = document.getElementById('registerForm');

  if(loginForm){
    loginForm.addEventListener('submit', e=>{
      e.preventDefault();
      const email = document.getElementById('email').value;
      const password = document.getElementById('password').value;
      const user = UserModel.login(email,password);
      const msg = document.getElementById('loginMsg');
      if(user){ msg.textContent = 'Ingreso exitoso.'; setTimeout(()=>location.href='index.html',600); }
      else msg.textContent = 'Correo o contraseña incorrectos';
    });
  }

  if(regForm){
    regForm.addEventListener('submit', e=>{
      e.preventDefault();
      const nombre = document.getElementById('nombre').value;
      const apellidos = document.getElementById('apellidos').value;
      const email = document.getElementById('email').value;
      const password = document.getElementById('password').value;
      if(UserModel.findByEmail(email)){ document.getElementById('registerMsg').textContent='El correo ya existe'; return; }
      UserModel.create({nombre,apellidos,email,password});
      document.getElementById('registerMsg').textContent='Registro exitoso. Puedes iniciar sesión.';
    });
  }
});
