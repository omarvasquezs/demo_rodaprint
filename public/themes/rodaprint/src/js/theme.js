(function ($) {
    "use strict";
    // Tabs and buttons
    jQuery(document).ready(function () {
        // Array of all tab-ids
        var tabs = ['informacion', 'envio', 'productos'];

        // Add click event listener to all 'Siguiente' buttons
        jQuery('.siguiente').click(function (e) {
            e.preventDefault();

            console.log('you clicked it');

            // Find the current active tab
            var activeTab = $('.nav-link.active').attr('id').split('-')[0];

            console.log(activeTab);

            // Find the index of the next tab
            var nextTabIndex = tabs.indexOf(activeTab) + 1;

            console.log(nextTabIndex);

            // If there is a next tab
            if (nextTabIndex < tabs.length) {
                // Remove 'active' class from current tab and pane
                jQuery('#' + activeTab + '-tab').removeClass('active');
                jQuery('#' + activeTab).removeClass('show active');

                // Add 'active' class to next tab and pane
                jQuery('#' + tabs[nextTabIndex] + '-tab').addClass('active');
                jQuery('#' + tabs[nextTabIndex]).addClass('show active');
            }
        });

        // Add click event listener to 'btn_anterior_1'
        jQuery('#btn_anterior_1').click(function (e) {
            e.preventDefault();

            // Remove 'active' class from current tab and pane
            var activeTab = jQuery('.nav-link.active').attr('id').split('-')[0];
            jQuery('#' + activeTab + '-tab').removeClass('active');
            jQuery('#' + activeTab).removeClass('show active');

            // Add 'active' class to first tab and pane
            jQuery('#informacion-tab').addClass('active');
            jQuery('#informacion').addClass('show active');
        });

        // Add click event listener to 'btn_anterior_2'
        jQuery('#btn_anterior_2').click(function (e) {
            e.preventDefault();

            // Remove 'active' class from current tab and pane
            var activeTab = jQuery('.nav-link.active').attr('id').split('-')[0];
            jQuery('#' + activeTab + '-tab').removeClass('active');
            jQuery('#' + activeTab).removeClass('show active');

            // Add 'active' class to second tab and pane
            jQuery('#envio-tab').addClass('active');
            jQuery('#envio').addClass('show active');
        });
    });

    // Select2 Dependent / Cascading Select List
    var Select2Cascade = (function (window, $) {
        function Select2Cascade(parent, child, url, select2Options) {
            var afterActions = [];
            var options = select2Options || {};

            // Register functions to be called after cascading data loading done
            this.then = function (callback) {
                afterActions.push(callback);
                return this;
            };

            parent.select2(select2Options).on("change", function (e) {
                child.prop("disabled", true);
                var _this = this;
                var parentId = $(this).val();

                // Fetch data using the fetchDestinos function
                $.ajax({
                    url: "/fetchDestinos/" + parentId,
                    type: "GET",
                    dataType: "json",
                    success: function (items) {
                        var newOptions = '<option value="">-- SELECCIONE DIRECCIÓN --</option>';
                        for (var i = 0; i < items.length; i++) {
                            var item = items[i];
                            newOptions +=
                                '<option value="' +
                                item.id +
                                '">' +
                                item.direccion_destino +
                                "</option>";
                        }
                        child.select2("destroy").html(newOptions).prop("disabled", false).select2(options);
                        afterActions.forEach(function (callback) {
                            callback(parent, child, items);
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error("Error fetching data:", error);
                    }
                });
            });
        }

        return Select2Cascade;
    })(window, $);

    $(document).ready(function () {
        var select2Options = { width: 'resolve', theme: 'bootstrap-5' };

        var apiUrl = ':parentId:.json';

        $('#clienteDropdown').select2(select2Options);
        $('#ClienteDestinoDropdown').select2(select2Options);
        $('#productoDropdown').select2(select2Options);
        $('#conductorDropdown').select2(select2Options);
        var cascadLoading = new Select2Cascade($('#clienteDropdown'), $('#ClienteDestinoDropdown'), apiUrl, select2Options);
        cascadLoading.then(function (parent, child, items) {
            // Dump response data
            console.log(items);
        });
    });

    // Event listener for the 'Agregar Producto' button
    document.getElementById('agregarProducto').addEventListener('click', function () {
        // Retrieve the selected product ID and description from the dropdown
        var selectedProduct = document.getElementById('productoDropdown').value;
        var selectedProductDescription = productoDropdown.options[productoDropdown.selectedIndex].text;

        // Proceed only if a product is selected
        if (selectedProduct != '') {
            // Create a new table row for the product
            var newRow = document.createElement('tr');
            newRow.className = 'align-middle'; // Ensure content is vertically centered

            // Create a cell for the product description
            var productCell = document.createElement('td');
            productCell.textContent = selectedProductDescription;
            productCell.style.minWidth = '12rem'; // Set a minimum width for the cell

            // Create a hidden input to store the product ID
            var hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.value = selectedProduct; // Set the value to the selected product ID
            hiddenInput.name = 'selectedProduct[]'; // Set the name for form submission

            // Append the hidden input to the product cell
            productCell.appendChild(hiddenInput);

            // Add the product cell to the new row
            newRow.appendChild(productCell);

            // Create a cell with an input for the product quantity
            var quantityCell = document.createElement('td');
            var quantityInput = document.createElement('input');
            quantityInput.type = 'number';
            quantityInput.value = '1'; // Default quantity to 1
            quantityInput.className = 'form-control'; // Style the input with Bootstrap
            quantityInput.style.width = '5rem'; // Set a fixed width for the input

            // Set the ID and name attributes for the quantity input
            quantityInput.id = 'productoCantidad[]';
            quantityInput.name = 'productoCantidad[]';

            // Add the quantity input to the quantity cell
            quantityCell.appendChild(quantityInput);

            // Add the quantity cell to the new row
            newRow.appendChild(quantityCell);

            // Create a cell for the remove button
            var actionCell = document.createElement('td');
            var removeButton = document.createElement('button');
            removeButton.innerHTML = '<i class="fas fa-trash"></i>'; // Use FontAwesome icon
            removeButton.className = 'btn btn-danger'; // Style the button with Bootstrap

            // Add click event to remove the product row
            removeButton.onclick = function () {
                this.closest('tr').remove(); // Remove the closest table row
            };

            // Add the remove button to the action cell
            actionCell.appendChild(removeButton);

            // Add the action cell to the new row
            newRow.appendChild(actionCell);

            // Append the new row to the product table
            document.getElementById('productTable').querySelector('tbody').appendChild(newRow);
        }
    });

    $(document).ready(function () {
        // Fetch and populate clientes using Select2
        var clientesDropdown = $('#clienteDropdown');

        clientesDropdown.select2({
            placeholder: "-- SELECCIONAR CLIENTE --",
            allowClear: true,
            theme: "bootstrap-5",

            ajax: {
                url: '/fetchClientes', // Update with your actual URL for fetching servicio data
                dataType: 'json',
                type: "GET",
                quietMillis: 20,
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term || '',
                        page: params.page || 1
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                id: item.id,
                                text: item.razon_social,
                            };
                        }),
                    };
                },
                cache: true,
            }
        });

        // Fetch and populate productos using Select2
        var productosDropdown = $('#productoDropdown');

        productosDropdown.select2({
            placeholder: "-- SELECCIONAR PRODUCTO --",
            allowClear: true,
            theme: "bootstrap-5",

            ajax: {
                url: '/fetchProductos', // Update with your actual URL for fetching servicio data
                dataType: 'json',
                type: "GET",
                quietMillis: 20,
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term || '',
                        page: params.page || 1
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                id: item.id,
                                text: item.descripcion,
                            };
                        }),
                    };
                },
                cache: true,
            }
        });
        $('#agregarProducto').click(function (e) {
            productosDropdown.val(null).trigger('change');
        });
    });

})(jQuery);