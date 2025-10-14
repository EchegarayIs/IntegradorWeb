document.addEventListener("DOMContentLoaded", () => {
  const btn = document.querySelector(".submenu-btn");
  const submenu = document.querySelector(".submenu");

  btn.addEventListener("click", () => {
    submenu.classList.toggle("show");
    // Cambia el símbolo ▾ / ▴
    btn.textContent = submenu.classList.contains("show")
      ? "Menú ▴"
      : "Menú ▾";
  });
});
