document.addEventListener("DOMContentLoaded", () => {
    const unitBuyPriceInput = document.getElementById('unit_buy_price');
    const unitSellPriceInput = document.getElementById('unit_sell_price');

    // Function to clean input value.
    const sanitizeInput = (e) => {
        e.target.value = e.target.value.replace(/£/g, '');
    };

    // Attach input event listeners to remove "£" from input values.
    unitBuyPriceInput.addEventListener('input', sanitizeInput);
    unitSellPriceInput.addEventListener('input', sanitizeInput);
});
