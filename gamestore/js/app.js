/* ===========================
   GameStore Digital – app.js
   =========================== */

/* ---- Datos centralizados ---- */
const PRODUCTS = {
  gow: {
    id: "gow",
    title: "God of War Ragnarök",
    price: 30000,
    platform: "PS5"
  },
  tlou2: {
    id: "tlou2",
    title: "The Last of Us Parte II",
    price: 25000,
    platform: "PS4"
  },
  spiderman2: {
    id: "spiderman2",
    title: "Marvel’s Spider-Man 2",
    price: 50000,
    platform: "PS5"
  }
};

/* ---- Utilidades ---- */
const qs = (sel, ctx = document) => ctx.querySelector(sel);
function money(n) {
  return new Intl.NumberFormat("es-AR", {
    style: "currency",
    currency: "ARS",
    maximumFractionDigits: 0
  }).format(n);
}
function getParam(name) {
  const url = new URL(window.location.href);
  return url.searchParams.get(name);
}

/* ---- Carrito mínimo en localStorage ---- */
const CART_KEY = "gs_cart";

function readCart() {
  try {
    return JSON.parse(localStorage.getItem(CART_KEY)) || [];
  } catch {
    return [];
  }
}
function saveCart(cart) {
  localStorage.setItem(CART_KEY, JSON.stringify(cart));
  renderCartBadge();
}
function addToCart(id, qty = 1) {
  const cart = readCart();
  const item = cart.find(i => i.id === id);
  if (item) item.qty += qty;
  else cart.push({ id, qty });
  saveCart(cart);
}
function cartCount() {
  return readCart().reduce((sum, it) => sum + it.qty, 0);
}
function renderCartBadge() {
  const badge = qs("#cart-badge");
  if (badge) {
    const c = cartCount();
    badge.textContent = c > 0 ? c : "";
    badge.style.display = c > 0 ? "inline-block" : "none";
  }
}

/* ---- Comportamientos por página ---- */
document.addEventListener("DOMContentLoaded", () => {
  renderCartBadge();

  // Si estamos en comprar.html, configurar página
  if (location.pathname.endsWith("comprar.html")) {
    setupPurchasePage();
  }

  // Validación del formulario en comprar.html
  const form = qs("form.form");
  if (form) {
    form.addEventListener("submit", (e) => {
      const tel = qs("#telefono");
      const productoSelect = qs("#producto");

      let ok = true;
      const telOk = tel.value.trim().length >= 8;

      if (!telOk) {
        ok = false;
        tel.setCustomValidity("Ingresá un teléfono válido");
      } else tel.setCustomValidity("");

      if (productoSelect && !productoSelect.value) {
        ok = false;
        productoSelect.setCustomValidity("Seleccioná un producto");
      } else if (productoSelect) {
        productoSelect.setCustomValidity("");
      }

      if (!ok) {
        e.preventDefault();
        form.reportValidity();
      } else {
        if (productoSelect && PRODUCTS[productoSelect.value]) {
          addToCart(productoSelect.value, 1);
        }
        alert("¡Gracias por tu compra! (Demo académico – no se procesa pago real)");
      }
    });
  }
});

/* ---- Comprar.html: llenar resumen desde ?id= o desde carrito ---- */
function setupPurchasePage() {
  const id = getParam("id");
  const tableBody = qs("table.table tbody");
  const select = qs("#producto");
  if (!tableBody) return;

  if (select && select.options.length <= 1) {
    Object.values(PRODUCTS).forEach(p => {
      const opt = document.createElement("option");
      opt.value = p.id;
      opt.textContent = `${p.title} – ${money(p.price)}`;
      select.appendChild(opt);
    });
  }

  let rows = [];
  if (id && PRODUCTS[id]) {
    rows = [{ id, qty: 1 }];
    if (select) select.value = id;
  } else {
    rows = readCart();
  }

  tableBody.innerHTML = "";
  let total = 0;

  rows.forEach(({ id, qty }) => {
    const p = PRODUCTS[id];
    if (!p) return;
    const subtotal = p.price * qty;
    total += subtotal;

    const tr = document.createElement("tr");
tr.innerHTML = `
  <td>${p.title}</td>
  <td><span class="tag">${p.platform}</span></td>
  <td>${qty}</td>
  <td class="price">${money(p.price)}</td>
  <td class="price">${money(subtotal)}</td>
  <td><button class="btn small danger" onclick="removeFromCart('${id}')">Eliminar</button></td>
`;
tableBody.appendChild(tr);

  });

  const totalEl = qs("#total-compra");
  if (totalEl) totalEl.textContent = money(total);
}
function removeFromCart(id) {
  let cart = readCart();
  cart = cart.filter(item => item.id !== id);
  saveCart(cart);
  setupPurchasePage(); // refresca la tabla
}

function clearCart() {
  localStorage.removeItem(CART_KEY);
  renderCartBadge();
  setupPurchasePage();
}
function removeFromCart(id) {
  let cart = readCart();
  cart = cart.filter(item => item.id !== id);
  saveCart(cart);
  setupPurchasePage(); // refresca la tabla
}

function clearCart() {
  localStorage.removeItem(CART_KEY);
  renderCartBadge();
  setupPurchasePage();
}
