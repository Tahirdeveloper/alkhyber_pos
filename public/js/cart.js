
    const $cartBody = $('#cartBody');
    const $totalAmount = $('#totalAmount');
    const $barcodeForm = $('#barcodeForm');
    const $barcodeInput = $('#barcodeInput');
    const $customerSelect = $('#customerSelect');
    const $searchInput = $('#searchInput');
    const $cancelBtn = $('#cancelBtn');
    const $payMultipleBtn = $('#payMultipleBtn');
    const $payAllBtn = $('#payAllBtn');

    function loadCart() {
        $.get('/cart', function (cart) {
            $cartBody.empty();
            let totalAmount = 0;
            cart.forEach(function (item) {
                totalAmount += item.price * item.pivot.quantity;
                const row = `<tr>
                    <td>${item.name}</td>
                    <td>
                        <input type="text" class="form-control form-control-sm qty mx-1" value="${item.pivot.quantity}" />
                        <button class="btn btn-danger btn-sm" data-product-id="${item.id}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                    <td> <input type="number" step="0.5" placeholder="00" name="short" value="${(item.price).toFixed(2)}"> </td>
                    <td class="text-right">${window.APP.currency_symbol} ${(item.price * item.pivot.quantity).toFixed(2)}</td>
                </tr>`;
                $cartBody.append(row);
            });
            $totalAmount.text(window.APP.currency_symbol + totalAmount.toFixed(2));
            updateButtons();
        });
    }

    function updateButtons() {
        const cartLength = $cartBody.find('tr').length;
        $cancelBtn.prop('disabled', cartLength === 0);
        $payMultipleBtn.prop('disabled', cartLength === 0);
        $payAllBtn.prop('disabled', cartLength === 0);
    }

    function scanBarcode(barcode) {
        $.post('/cart', { barcode }, function (res) {
            loadCart();
        }).fail(function (err) {
            Swal.fire('Error!', err.responseJSON.message, 'error');
        });
    }

    // function changeQty(productId, qty) {
    //     $.post('/cart/change-qty', { product_id: productId, quantity: qty }, function (res) {
    //         loadCart();
    //     }).fail(function (err) {
    //         Swal.fire('Error!', err.responseJSON.message, 'error');
    //     });
    // }

    function deleteProduct(productId) {
        $.post('/cart/delete', { product_id: productId }, function () {
            loadCart();
        });
    }

    // Event listeners
    $barcodeForm.on('submit', function (event) {
        event.preventDefault();
        const barcode = $barcodeInput.val();
        if (!!barcode) {
            scanBarcode(barcode);
            $barcodeInput.val('');
        }
    });

    $cartBody.on('change', '.qty', function () {
        const $this = $(this);
        const productId = $this.closest('tr').find('.btn-danger').data('product-id');
        const quantity = $this.val();
        changeQty(productId, quantity);
    });

    $cartBody.on('click', '.btn-danger', function () {
        const productId = $(this).data('product-id');
        deleteProduct(productId);
    });

    $searchInput.on('keydown', function (event) {
        if (event.keyCode === 13) {
            const search = $searchInput.val();
            if (search.trim() !== '') {
                $.get('/cart/products', { search }, function (products) {
                    $('.order-product').empty();
                    products.forEach(function (product) {
                        const item = `<div class="item" data-barcode="${product.barcode}" data-product-id="${product.id}">
                            <img src="${product.image_url}" alt="${product.name}" />
                            <h5 class="${product.quantity < window.APP.warning_quantity ? 'text-danger' : ''}">
                                ${product.name} (${product.quantity})
                            </h5>
                        </div>`;
                        $('.order-product').append(item);
                    });
                });
            }
        }
    });
    

    $('.order-product').on('click', '.item', function () {
        const barcode = $(this).data('barcode');
        scanBarcode(barcode);
    });

    // Initial load
    loadCart();
