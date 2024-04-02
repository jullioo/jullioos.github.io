document.addEventListener('DOMContentLoaded', function() {
    loadCartItems();

    document.getElementById('clear-cart').addEventListener('click', function() {
        clearCart();
    });
});

function loadCartItems() {
    const cartContainer = document.getElementById('cart-items');
    const cart = JSON.parse(sessionStorage.getItem('cart')) || [];

    cartContainer.innerHTML = ''; // Clear the container

    if (cart.length === 0) {
        cartContainer.innerHTML = "<p>Your cart is empty.</p>";
    } else {
        cart.forEach(item => {
            const itemElement = document.createElement('div');
            itemElement.className = 'cart-item';
            itemElement.innerHTML = `
                <img src="${item.imageUrl}" alt="${item.name}" style="width:100px; height:auto;">
                <div>
                    <h3>${item.name}</h3>
                    <p>Price: $${item.price}</p>
                    <p>Quantity: ${item.quantity}</p>
                    <p>Total: $${(item.price * item.quantity).toFixed(2)}</p>
                </div>
            `;
            cartContainer.appendChild(itemElement);
        });
    }
}

function clearCart() {
    sessionStorage.removeItem('cart');
    loadCartItems(); // Refresh cart display
}
