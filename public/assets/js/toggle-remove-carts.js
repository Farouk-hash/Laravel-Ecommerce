// Toggle all remove checkboxes
        function toggleAll(source) {
            const checkboxes = document.querySelectorAll('.remove-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = source.checked;
            });
        }

        // Toggle all buy now checkboxes
        function toggleBuyNowAll(source) {
            const checkboxes = document.querySelectorAll('.buy-now-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = source.checked;
            });
            updateTotals();
        }

        // Update totals based on selected items
        function updateTotals() {
            let subtotal = 0;
            const shipping = 45;
            
            // Get all checked buy-now items
            const checkedItems = document.querySelectorAll('.buy-now-checkbox:checked');
            
            checkedItems.forEach(checkbox => {
                const row = checkbox.closest('tr');
                const totalCell = row.querySelector('.product-total');
                const total = parseFloat(totalCell.dataset.total);
                subtotal += total;
            });
            
            // Update display
            document.getElementById('subtotal-display').textContent = `$ ${subtotal.toFixed(2)}`;
            document.getElementById('shipping-display').textContent = subtotal > 0 ? `$${shipping}` : '$0';
            document.getElementById('total-display').textContent = `$ ${(subtotal + (subtotal > 0 ? shipping : 0)).toFixed(2)}`;
        }

        // Initialize totals on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateTotals();
        });