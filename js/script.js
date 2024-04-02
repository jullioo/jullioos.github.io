const products = [
    {id: 1, name: "Product 1", price: 9.99, imageUrl: "images/2697.jpg"},
    {id: 2, name: "Product 2", price: 9.99, imageUrl: "images/2699.jpg"},
    {id: 3, name: "Product 3", price: 9.99, imageUrl: "images/2700.jpg"},
    {id: 4, name: "Product 4", price: 9.99, imageUrl: "images/2701.jpg"},
    {id: 5, name: "Product 5", price: 9.99, imageUrl: "images/2702.jpg"},
    {id: 6, name: "Product 6", price: 9.99, imageUrl: "images/2703.jpg"},
    {id: 7, name: "Product 7", price: 9.99, imageUrl: "images/2704.jpg"},
    {id: 8, name: "Product 8", price: 9.99, imageUrl: "images/2705.jpg"},
    {id: 9, name: "Product 9", price: 9.99, imageUrl: "images/2706.jpg"},
    {id: 10, name: "Product 10", price: 9.99, imageUrl: "images/2707.jpg"},
    {id: 11, name: "Product 11", price: 9.99, imageUrl: "images/2708.jpg"},
    {id: 12, name: "Product 12", price: 9.99, imageUrl: "images/2710.jpg"},
    {id: 13, name: "Product 13", price: 9.99, imageUrl: "images/2711.jpg"},
    {id: 14, name: "Product 14", price: 9.99, imageUrl: "images/2712.jpg"},
    {id: 15, name: "Product 15", price: 9.99, imageUrl: "images/2715.jpg"},
    {id: 16, name: "Product 16", price: 9.99, imageUrl: "images/2716.jpg"},
    {id: 17, name: "Product 17", price: 9.99, imageUrl: "images/2717.jpg"},
    {id: 18, name: "Product 18", price: 9.99, imageUrl: "images/2718.jpg"},
    {id: 19, name: "Product 19", price: 9.99, imageUrl: "images/2728.jpg"},
    {id: 20, name: "Product 20", price: 9.99, imageUrl: "images/2730.jpg"},
];

function saveCart(cart) {
    sessionStorage.setItem('cart', JSON.stringify(cart));
}

function loadCart() {
    const cart = sessionStorage.getItem('cart');
    return cart ? JSON.parse(cart) : [];
}

document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('product-container');
    const cart = loadCart();

    products.forEach(product => {
        const productElement = document.createElement('div');
        productElement.className = 'product';
        productElement.innerHTML = `
            <img src="${product.imageUrl}" alt="${product.name}">
            <h2>${product.name}</h2>
            <p>$${product.price}</p>
            <button onclick="addToCart(${product.id})">Add to Cart</button>
        `;
        container.appendChild(productElement);
    });

    updateCartCounter();
});

function addToCart(productId) {
    const cart = loadCart();
    const productIndex = cart.findIndex(item => item.id === productId);
    if (productIndex > -1) {
        cart[productIndex].quantity += 1;
    } else {
        const productToAdd = products.find(product => product.id === productId);
        if (productToAdd) {
            cart.push({...productToAdd, quantity: 1});
        }
    }
    saveCart(cart);
    updateCartCounter();
}

function updateCartCounter() {
    const cart = loadCart();
    const itemCount = cart.reduce((total, product) => total + product.quantity, 0);
    document.getElementById('cart-counter').innerText = `Cart (${itemCount})`;
}

function showCart() {
    window.location.href = 'cart.html'; // Navigate to the cart page
}