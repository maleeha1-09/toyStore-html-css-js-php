const products = [
    { name: "Toy Car", price: 10, image: "images/Car1.jpg" },
    { name: "Doll", price: 15, image: "images/doll1.jpg" },
    { name: "Puzzle", price: 8, image: "images/puzzle.jpg" },
    { name: "Robot", price: 20, image: "images/robot.jpg" },
    { name: "Lego Set", price: 25, image: "images/legoSet.jpg" },
    { name: "Stuffed Bear", price: 18, image: "images/bear.jpg" },
    { name: "Remote Car", price: 30, image: "images/remoteCar.jpg" },
    { name: "Board Game", price: 22, image: "images/boardGame.jpg" },
    { name: "Toy Train", price: 35, image: "images/train.jpg" },
];

// Render Products
const productGrid = document.getElementById('product-grid');
products.forEach(product => {
    const productCard = document.createElement('div');
    productCard.classList.add('product-card');
    productCard.innerHTML = `
        <img src="${product.image}" alt="${product.name}" class="product-img">
        <h4>${product.name}</h4>
        <p>Price: $${product.price}</p>
        <button onclick="addToCart('${product.name}', ${product.price})">Add to Cart</button>
    `;
    productGrid.appendChild(productCard);
});


// Cart Management
let cart = [];
let cartOpen = false;

function addToCart(productName, price) {
    cart.push({ productName, price });
    updateCartUI();
    showPopup(`${productName} added to cart!`);
}

function updateCartUI() {
    const cartItems = document.getElementById('cart-items');
    const cartTotal = document.getElementById('cart-total');
    cartItems.innerHTML = '';
    let total = 0;

    cart.forEach(item => {
        cartItems.innerHTML += `<li>${item.productName} - $${item.price}</li>`;
        total += item.price;
    });

    cartTotal.textContent = `Total: $${total}`;
}

function toggleCart() {
    const cartPanel = document.getElementById('cart-panel');
    cartOpen = !cartOpen;
    cartPanel.classList.toggle('open', cartOpen);
}

function checkout() {
    if (cart.length === 0) {
        showPopup("Your cart is empty!");
        return;
    }
    
    window.location.href="placeOrder.php";

}

// Popup
function showPopup(message) {
    const popupModal = document.getElementById('popup-modal');
    const popupMessage = document.getElementById('popup-message');
    popupMessage.textContent = message;
    popupModal.style.display = 'flex';
}

function closePopup() {
    document.getElementById('popup-modal').style.display = 'none';
}

// Scroll
function scrollToSection(id) {
    document.getElementById(id).scrollIntoView({ behavior: 'smooth' });
}
