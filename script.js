document.addEventListener("DOMContentLoaded", function () {
  // Cart variables
  const productBoxes = document.querySelectorAll(".box");
  const cartIcon = document.querySelector(".icons .fa-shopping-cart");
  const cartCount = document.querySelector(".cart-count");
  const cartMenu = document.getElementById("cart-menu");
  const closeCartBtn = document.getElementById("close-cart");
  const cartItemsList = document.getElementById("cart-items");

  // Initialize the cart items and prices as empty objects
  let cartItemPrices = {};

  // Function to update the cart items and prices
  const updateCart = (productName, productPrice) => {
    if (!cartItemPrices[productName]) {
      cartItemPrices[productName] = {
        quantity: 1,
        price: productPrice,
      };
    } else {
      cartItemPrices[productName].quantity += 1;
    }

    // Update the cart count, icon, and menu
    updateCartDisplay();
    updateCartMenu();
  };

  // Function to calculate the total cost of items in the cart
  const calculateTotalCost = () => {
    return Object.values(cartItemPrices).reduce(
      (acc, { quantity, price }) => acc + quantity * price,
      0
    );
  };

  // Function to update the cart count and icon
  const updateCartDisplay = () => {
    const itemCount = Object.values(cartItemPrices).reduce(
      (acc, { quantity }) => acc + quantity,
      0
    );
    cartCount.textContent = itemCount;

    // Update the cart icon class to indicate items in the cart
    cartIcon.classList.toggle("items-in-cart", itemCount > 0);
  };

  // Function to update the cart menu with items and prices
  const updateCartMenu = () => {
    cartItemsList.innerHTML = "";

    for (const [itemName, { quantity, price }] of Object.entries(
      cartItemPrices
    )) {
      const listItem = document.createElement("li");
      listItem.classList.add("cart-item");
      listItem.innerHTML = `
        <span>${itemName}</span>
        <span>Quantity: ${quantity}</span>
        <span>Cost: $${(quantity * price).toFixed(2)}</span>
        <span class="remove-item" data-item="${itemName}">&times;</span>
      `;

      // Add a click event listener to remove items
      listItem
        .querySelector(".remove-item")
        .addEventListener("click", (event) => {
          const itemToRemove = event.target.dataset.item;
          removeItemFromCart(itemToRemove);
        });

      cartItemsList.appendChild(listItem);
    }

    // Add the total cost to the cart menu
    const totalCost = calculateTotalCost();
    const totalElement = document.createElement("div");
    totalElement.classList.add("cart-total");
    totalElement.textContent = `Total: $${totalCost.toFixed(2)}`;

    cartItemsList.appendChild(totalElement);
  };

  // Function to remove an item from the cart
  const removeItemFromCart = (itemName) => {
    if (cartItemPrices[itemName]) {
      cartItemPrices[itemName].quantity -= 1;

      if (cartItemPrices[itemName].quantity <= 0) {
        delete cartItemPrices[itemName];
      }
    }

    // Update the cart display and menu
    updateCartDisplay();
    updateCartMenu();
  };

  // Event listener for the cart icon to show the cart menu
  cartIcon.addEventListener("click", () => {
    cartMenu.classList.add("show");
  });

  // Event listener for closing the cart menu
  closeCartBtn.addEventListener("click", () => {
    cartMenu.classList.remove("show");
  });

  // Event listener for adding items to the cart
  productBoxes.forEach((box) => {
    const productName = box.dataset.productName;
    const priceElement = box.querySelector(".price");

    if (priceElement) {
      const productPrice = parseFloat(
        priceElement.textContent.replace("$", "")
      );

      // Event listener for the "Add to Cart" button
      box.querySelector(".cart-btn").addEventListener("click", (event) => {
        event.preventDefault();
        updateCart(productName, productPrice);
      });
    }
  });
});


