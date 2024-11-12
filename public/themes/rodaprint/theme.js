/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./src/js/theme.js":
/*!*************************!*\
  !*** ./src/js/theme.js ***!
  \*************************/
/***/ (() => {

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
  var Select2Cascade = function (window, $) {
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
          success: function success(items) {
            var newOptions = '<option value="">-- SELECCIONE DIRECCIÓN --</option>';
            for (var i = 0; i < items.length; i++) {
              var item = items[i];
              newOptions += '<option value="' + item.id + '">' + item.direccion_destino + "</option>";
            }
            child.select2("destroy").html(newOptions).prop("disabled", false).select2(options);
            afterActions.forEach(function (callback) {
              callback(parent, child, items);
            });
          },
          error: function error(xhr, status, _error) {
            console.error("Error fetching data:", _error);
          }
        });
      });
    }
    return Select2Cascade;
  }(window, $);
  $(document).ready(function () {
    var select2Options = {
      width: 'resolve',
      theme: 'bootstrap-5'
    };
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
        url: '/fetchClientes',
        // Update with your actual URL for fetching servicio data
        dataType: 'json',
        type: "GET",
        quietMillis: 20,
        delay: 250,
        data: function data(params) {
          return {
            q: params.term || '',
            page: params.page || 1
          };
        },
        processResults: function processResults(data) {
          return {
            results: $.map(data, function (item) {
              return {
                id: item.id,
                text: item.razon_social
              };
            })
          };
        },
        cache: true
      }
    });

    // Fetch and populate productos using Select2
    var productosDropdown = $('#productoDropdown');
    productosDropdown.select2({
      placeholder: "-- SELECCIONAR PRODUCTO --",
      allowClear: true,
      theme: "bootstrap-5",
      ajax: {
        url: '/fetchProductos',
        // Update with your actual URL for fetching servicio data
        dataType: 'json',
        type: "GET",
        quietMillis: 20,
        delay: 250,
        data: function data(params) {
          return {
            q: params.term || '',
            page: params.page || 1
          };
        },
        processResults: function processResults(data) {
          return {
            results: $.map(data, function (item) {
              return {
                id: item.id,
                text: item.descripcion
              };
            })
          };
        },
        cache: true
      }
    });
    $('#agregarProducto').click(function (e) {
      productosDropdown.val(null).trigger('change');
    });
  });
})(jQuery);

/***/ }),

/***/ "./src/scss/style.scss":
/*!*****************************!*\
  !*** ./src/scss/style.scss ***!
  \*****************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/theme": 0,
/******/ 			"style": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunkrodaprint_custom"] = self["webpackChunkrodaprint_custom"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["style"], () => (__webpack_require__("./src/js/theme.js")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["style"], () => (__webpack_require__("./src/scss/style.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;