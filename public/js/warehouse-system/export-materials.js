/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/lang/index.js":
/*!************************************!*\
  !*** ./resources/js/lang/index.js ***!
  \************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
var lang = document.querySelector('html').getAttribute('lang');
var translations = {};

var requireModules = __webpack_require__("./resources/js/lang/translations sync \\.js$");

requireModules.keys().forEach(function (modulePath) {
  var key = modulePath.replace(/(^.\/)|(.js$)/g, '');
  translations[key] = requireModules(modulePath)["default"];
});

var t = function t(text) {
  return translations[lang][text] || text;
};

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (t);

/***/ }),

/***/ "./resources/js/lang/translations/en.js":
/*!**********************************************!*\
  !*** ./resources/js/lang/translations/en.js ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _vi__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./vi */ "./resources/js/lang/translations/vi.js");

var en = {};
Object.keys(_vi__WEBPACK_IMPORTED_MODULE_0__["default"]).forEach(function (key) {
  en[key] = key;
});
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (en);

/***/ }),

/***/ "./resources/js/lang/translations/ko.js":
/*!**********************************************!*\
  !*** ./resources/js/lang/translations/ko.js ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({});

/***/ }),

/***/ "./resources/js/lang/translations/vi.js":
/*!**********************************************!*\
  !*** ./resources/js/lang/translations/vi.js ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
var _NumberOfRecords_M;

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_NumberOfRecords_M = {
  "Number of records _MENU_": "S??? l?????ng b???n ghi _MENU_",
  "Showing _START_ to _END_ of _TOTAL_ entries": "B???n ghi t??? _START_ ?????n _END_ c???a _TOTAL_ b???n ghi",
  "Name": "T??n",
  "Symbols": "M??",
  "Type": "Lo???i",
  "Note": "Ghi ch??",
  "User Created": "Ng?????i t???o",
  "Time Created": "Th???i gian t???o",
  "User Updated": "Ng?????i c???p nh???t",
  "Time Updated": "Th???i gian c???p nh???t",
  "Action": "H??nh ?????ng",
  "Edit": "S???a",
  "Delete": "X??a",
  "Start Time": "Th???i Gian B???t ?????u",
  "End Time": "Th???i Gian K???t Th??c",
  "Cycle Time": "Chu K?? S???n Xu???t 1 S???n Ph???m ",
  "Detail": "Chi Ti???t",
  "Month": "Th??ng",
  "Year": "N??m",
  "Location Take Materials": "V??? Tr?? L???y H??ng",
  "Materials Return Location": "V??? Tr?? Tr??? H??ng",
  "Destroy": "H???y"
}, _defineProperty(_NumberOfRecords_M, "Detail", "Chi Ti???t"), _defineProperty(_NumberOfRecords_M, "Success", "Ho??n Th??nh"), _defineProperty(_NumberOfRecords_M, "Product", "S???n Ph???m"), _defineProperty(_NumberOfRecords_M, "Machine", "M??y S???n Xu???t"), _defineProperty(_NumberOfRecords_M, "Dont Production", "Ch??a S???n Xu???t"), _defineProperty(_NumberOfRecords_M, "Are Production", "??ang S???n Xu???t"), _defineProperty(_NumberOfRecords_M, "Success Production", "Ho??n Th??nh S???n Xu???t"), _defineProperty(_NumberOfRecords_M, "Status", "Tr???ng Th??i"), _defineProperty(_NumberOfRecords_M, "Export", "Xu???t Kho"), _defineProperty(_NumberOfRecords_M, "Materials", "Nguy??n V???t Li???u"), _defineProperty(_NumberOfRecords_M, "Dont Export", "Ch??a Xu???t"), _defineProperty(_NumberOfRecords_M, "Are Export", "??ang Xu???t"), _defineProperty(_NumberOfRecords_M, "Success Export", "Ho??n Th??nh Xu???t"), _defineProperty(_NumberOfRecords_M, "Stock Min", "T???n Gi???i H???n"), _defineProperty(_NumberOfRecords_M, "Cavity", "Cavity"), _defineProperty(_NumberOfRecords_M, "Mold", "Khu??n"), _defineProperty(_NumberOfRecords_M, "Quantity Mold", "S??? L?????ng Khu??n"), _defineProperty(_NumberOfRecords_M, "Quantity", "S??? L?????ng"), _defineProperty(_NumberOfRecords_M, "Date", "Ng??y"), _defineProperty(_NumberOfRecords_M, "Unit", "????n V??? T??nh"), _defineProperty(_NumberOfRecords_M, "Parking", "????n V??? ????ng G??i"), _defineProperty(_NumberOfRecords_M, "History", "L???ch S???"), _defineProperty(_NumberOfRecords_M, "Return", "Kh??i Ph???c"), _defineProperty(_NumberOfRecords_M, "Update", "C???p Nh???t"), _defineProperty(_NumberOfRecords_M, "Delete", "X??a"), _defineProperty(_NumberOfRecords_M, "Processing", "??ang Th???c Hi???n"), _defineProperty(_NumberOfRecords_M, "Enable", "K??ch Ho???t"), _defineProperty(_NumberOfRecords_M, "Disable", "V?? Hi???u H??a"), _defineProperty(_NumberOfRecords_M, "Part", "B??? Ph???n"), _defineProperty(_NumberOfRecords_M, "Time Start", "Th???i Gian B???t ?????u"), _defineProperty(_NumberOfRecords_M, "Time End", "Th???i Gian K???t Th??c"), _defineProperty(_NumberOfRecords_M, "Manager AGV", "Ng?????i Qu???n L?? AGV"), _defineProperty(_NumberOfRecords_M, "Maintenance Time", "Th???i Gian B???o Tr??"), _defineProperty(_NumberOfRecords_M, "Maintenance Date", "Ng??y B???o D?????ng"), _defineProperty(_NumberOfRecords_M, "Warehouse", "Kho"), _defineProperty(_NumberOfRecords_M, "Plan", "K??? Ho???ch"), _defineProperty(_NumberOfRecords_M, "Production", "S???n Xu???t"), _defineProperty(_NumberOfRecords_M, "Output", "S???n L?????ng"), _defineProperty(_NumberOfRecords_M, "End", "K???t Th??c"), _defineProperty(_NumberOfRecords_M, "Error", "L???i"), _defineProperty(_NumberOfRecords_M, "Time Real Start", "B???t ?????u Th???c T???"), _defineProperty(_NumberOfRecords_M, "Time Real End", "K???t Th??c Th???c T???"), _defineProperty(_NumberOfRecords_M, "Symbols Plan", "M?? Ch??? Th???"), _defineProperty(_NumberOfRecords_M, "Infor", "Th??ng Tin"), _defineProperty(_NumberOfRecords_M, "Normal", "Xu???t Th?????ng"), _defineProperty(_NumberOfRecords_M, "Cancel", "H???y"), _defineProperty(_NumberOfRecords_M, "Confirm", "X??c nh???n"), _defineProperty(_NumberOfRecords_M, "Close", "????ng"), _defineProperty(_NumberOfRecords_M, "Start", "B???t ?????u"), _defineProperty(_NumberOfRecords_M, "User Name", "T??n ????ng Nh???p"), _defineProperty(_NumberOfRecords_M, "ENABLE", "K??ch Ho???t"), _defineProperty(_NumberOfRecords_M, "DISABLE", "Kh??ng K??ch Ho???t"), _defineProperty(_NumberOfRecords_M, "Action Name", "Ki???u H??nh ?????ng"), _defineProperty(_NumberOfRecords_M, "INSERT", "Th??m M???i"), _defineProperty(_NumberOfRecords_M, "Insert", "Th??m M???i"), _defineProperty(_NumberOfRecords_M, "OEE", "Hi???u Su???t T???ng Th???"), _defineProperty(_NumberOfRecords_M, "Availability", "Kh??? D???ng"), _defineProperty(_NumberOfRecords_M, "Performance", "Hi???u Su???t"), _defineProperty(_NumberOfRecords_M, "Quality", "Ch???t L?????ng"), _defineProperty(_NumberOfRecords_M, "shift", "ca"), _defineProperty(_NumberOfRecords_M, "Shift", "ca"), _defineProperty(_NumberOfRecords_M, "day", "ng??y"), _defineProperty(_NumberOfRecords_M, "Description", "Ch?? Th??ch"), _defineProperty(_NumberOfRecords_M, "Find AGV", "T??m AGV"), _defineProperty(_NumberOfRecords_M, "Role", "Vai Tr??"), _defineProperty(_NumberOfRecords_M, "Waiting for AGV", "Ch??? AGV"), _defineProperty(_NumberOfRecords_M, "AGV Shipping", "AGV ??ang Chuy???n H??ng"), _defineProperty(_NumberOfRecords_M, "IsDelete", "X??a"), _defineProperty(_NumberOfRecords_M, "To", "T???i"), _defineProperty(_NumberOfRecords_M, "Command", "L???nh"), _defineProperty(_NumberOfRecords_M, "INSERT_USER", "Th??m M???i T??i Kho???n"), _defineProperty(_NumberOfRecords_M, "INSERT_ROLE", "Th??m M???i Vai Tr??"), _defineProperty(_NumberOfRecords_M, "Update_User", "C???p Nh???t T??i Kho???n"), _defineProperty(_NumberOfRecords_M, "Delete_Role", "X??a Vai Tr??"), _defineProperty(_NumberOfRecords_M, "Command AGV Was Destroy", "L???nh AGV ???? b??? h???y"), _defineProperty(_NumberOfRecords_M, "Select machine", "Ch???n m??y s???n xu???t"), _defineProperty(_NumberOfRecords_M, "Loading data", "??ang t???i d??? li???u"), _defineProperty(_NumberOfRecords_M, "Mold code", "M?? khu??n"), _defineProperty(_NumberOfRecords_M, "Actual start time", "B???t ?????u th???c t???"), _defineProperty(_NumberOfRecords_M, "Cycle time", "Th???i gian ????ng m??? khu??n"), _defineProperty(_NumberOfRecords_M, "Quantity NG", "S??? l?????ng s???n ph???m l???i"), _defineProperty(_NumberOfRecords_M, "Quantity NG of", "S??? l?????ng s???n ph???m l???i c???a"), _defineProperty(_NumberOfRecords_M, "OEE parameter chart", "Bi???u ????? th??ng s??? hi???u su???t OEE"), _defineProperty(_NumberOfRecords_M, "Active timeline chart", "Bi???u ????? th???i gian ho???t ?????ng"), _defineProperty(_NumberOfRecords_M, "minute", "ph??t"), _defineProperty(_NumberOfRecords_M, "minutes", "ph??t"), _defineProperty(_NumberOfRecords_M, "hour", "gi???"), _defineProperty(_NumberOfRecords_M, "Machine stop logs", "D???ng m??y"), _defineProperty(_NumberOfRecords_M, "Defective products", "S???n ph???m l???i"), _defineProperty(_NumberOfRecords_M, "Statistical chart of OEE by machine", "Bi???u ????? th???ng k?? hi???u su???t theo m??y"), _defineProperty(_NumberOfRecords_M, "Statistical chart of OEE by day", "Bi???u ????? th???ng k?? hi???u su???t theo ng??y"), _defineProperty(_NumberOfRecords_M, "View", "Xem"), _defineProperty(_NumberOfRecords_M, "Rows per page", "S??? l?????ng b???n ghi"), _defineProperty(_NumberOfRecords_M, "Error stop and no-error stop rate chart", "Bi???u ????? t??? l??? d???ng l???i v?? kh??ng l???i"), _defineProperty(_NumberOfRecords_M, "Machine error rate chart", "Bi???u ????? t??? l??? l???i m??y s???n xu???t"), _defineProperty(_NumberOfRecords_M, "No-error stop rate chart", "Bi???u ????? t??? l??? d???ng kh??ng l???i"), _defineProperty(_NumberOfRecords_M, "Machine stop rate chart due to quality", "Bi???u ????? t??? l??? d???ng m??y cho ch???t l?????ng"), _defineProperty(_NumberOfRecords_M, "Statistics chart of machine time stop", "Bi???u ????? th???ng k?? th???i gian d???ng m??y"), _defineProperty(_NumberOfRecords_M, "Statistics chart of defective product", "Bi???u ????? th???ng k?? s???n ph???m l???i"), _defineProperty(_NumberOfRecords_M, "Stop Time", "Th???i Gian D???ng"), _defineProperty(_NumberOfRecords_M, "Error Code", "M?? L???i"), _defineProperty(_NumberOfRecords_M, "Error Type", "Lo???i L???i"), _defineProperty(_NumberOfRecords_M, "Quantity Error", "S??? l?????ng l???i"), _defineProperty(_NumberOfRecords_M, "Iot disconnect", "M???t k???t n???i Iot"), _defineProperty(_NumberOfRecords_M, "All machine", "T???t c??? m??y s???n xu???t"), _defineProperty(_NumberOfRecords_M, "Quantity produced", "S??? l?????ng ???? s???n xu???t"), _defineProperty(_NumberOfRecords_M, "Quantity produced of", "S??? l?????ng ???? s???n xu???t c???a"), _defineProperty(_NumberOfRecords_M, "run", "Ch???y"), _defineProperty(_NumberOfRecords_M, "stopError", "D???ng do l???i"), _defineProperty(_NumberOfRecords_M, "stopNotError", "D???ng kh??ng l???i"), _defineProperty(_NumberOfRecords_M, "stop due to error", "D???ng do l???i"), _defineProperty(_NumberOfRecords_M, "stop not error", "D???ng kh??ng l???i"), _defineProperty(_NumberOfRecords_M, "stop due to quality", "D???ng do ch???t l?????ng"), _defineProperty(_NumberOfRecords_M, "machine stop", "D???ng m??y"), _defineProperty(_NumberOfRecords_M, "products", "s???n ph???m"), _defineProperty(_NumberOfRecords_M, "Export excel", "Xu???t excel"), _defineProperty(_NumberOfRecords_M, "Duration", "Th???i l?????ng"), _defineProperty(_NumberOfRecords_M, "Total stop time", "T???ng th???i gian d???ng"), _NumberOfRecords_M);

/***/ }),

/***/ "./resources/js/lang/translations sync \\.js$":
/*!*****************************************************************!*\
  !*** ./resources/js/lang/translations/ sync nonrecursive \.js$ ***!
  \*****************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var map = {
	"./en.js": "./resources/js/lang/translations/en.js",
	"./ko.js": "./resources/js/lang/translations/ko.js",
	"./vi.js": "./resources/js/lang/translations/vi.js"
};


function webpackContext(req) {
	var id = webpackContextResolve(req);
	return __webpack_require__(id);
}
function webpackContextResolve(req) {
	if(!__webpack_require__.o(map, req)) {
		var e = new Error("Cannot find module '" + req + "'");
		e.code = 'MODULE_NOT_FOUND';
		throw e;
	}
	return map[req];
}
webpackContext.keys = function webpackContextKeys() {
	return Object.keys(map);
};
webpackContext.resolve = webpackContextResolve;
module.exports = webpackContext;
webpackContext.id = "./resources/js/lang/translations sync \\.js$";

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
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
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
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
(() => {
"use strict";
/*!***********************************************************!*\
  !*** ./resources/js/warehouse-system/export-materials.js ***!
  \***********************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _lang__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../lang */ "./resources/js/lang/index.js");
$('.select2').select2();

var route = "".concat(window.location.origin, "/api/warehouse-system/export");
var route_show = "".concat(window.location.origin, "/setting/setting-unit/show");
console.log(route);
var table = $('table').DataTable({
  scrollX: true,
  aaSorting: [],
  language: {
    lengthMenu: (0,_lang__WEBPACK_IMPORTED_MODULE_0__["default"])('Number of records _MENU_'),
    info: (0,_lang__WEBPACK_IMPORTED_MODULE_0__["default"])('Showing _START_ to _END_ of _TOTAL_ entries'),
    paginate: {
      previous: '???',
      next: '???'
    }
  },
  processing: true,
  serverSide: true,
  searching: false,
  lengthMenu: [10, 15, 20, 25, 50],
  dom: 'rt<"bottom"flp><"clear">',
  ajax: {
    url: route,
    dataSrc: 'data',
    data: function data(d) {
      d.page = d.start / d.length + 1;
      d.materials = $('.materials').val();
      d.machine = $('.machine').val();
      d.status = $('.status').val();
      d.type = $('.Type').val();
    }
  },
  columns: [{
    data: 'ID',
    defaultContent: '',
    title: 'ID'
  }, {
    data: 'plan.Symbols',
    defaultContent: '',
    title: (0,_lang__WEBPACK_IMPORTED_MODULE_0__["default"])('Symbols Plan'),
    render: function render(data) {
      if (data) {
        var explode = data.split("--"); // console.log(explode);

        return "<p>" + explode[0] + "</p><p>-" + explode[1] + "-" + explode[2] + "</p>";
      } else {
        return "";
      }
    }
  }, {
    data: 'product.Symbols',
    defaultContent: '',
    title: (0,_lang__WEBPACK_IMPORTED_MODULE_0__["default"])('Product'),
    render: function render(data) {
      // console.log(data)
      return "<p>" + data + "</p>";
    }
  }, {
    data: 'machine.Name',
    defaultContent: '',
    title: (0,_lang__WEBPACK_IMPORTED_MODULE_0__["default"])('Machine')
  }, {
    data: 'Quantity_Export',
    defaultContent: '',
    title: (0,_lang__WEBPACK_IMPORTED_MODULE_0__["default"])('Quantity') + ' ' + (0,_lang__WEBPACK_IMPORTED_MODULE_0__["default"])('Export') + '(Kg)',
    render: function render(data) {
      // console.log(data)
      if (data) {
        return "<p>" + parseFloat(data) + "</p>";
      } else {
        return 0;
      }
    }
  }, {
    data: 'Type',
    title: (0,_lang__WEBPACK_IMPORTED_MODULE_0__["default"])('Type'),
    render: function render(data, status) {
      if (data == 1) {
        return (0,_lang__WEBPACK_IMPORTED_MODULE_0__["default"])('AGV');
      } else if (data == 2) {
        return (0,_lang__WEBPACK_IMPORTED_MODULE_0__["default"])('Normal');
      } else {
        return "";
      }
    }
  }, {
    data: 'Note',
    title: (0,_lang__WEBPACK_IMPORTED_MODULE_0__["default"])('Note'),
    render: function render(data) {
      return (0,_lang__WEBPACK_IMPORTED_MODULE_0__["default"])(data);
    }
  }, {
    data: 'user_updated.username',
    defaultContent: '',
    title: (0,_lang__WEBPACK_IMPORTED_MODULE_0__["default"])('User Updated')
  }, {
    data: 'Time_Updated',
    defaultContent: '',
    title: (0,_lang__WEBPACK_IMPORTED_MODULE_0__["default"])('Time Updated')
  }, {
    data: 'Status',
    title: (0,_lang__WEBPACK_IMPORTED_MODULE_0__["default"])('Status'),
    render: function render(data, status) {
      if (data == 0) {
        return "<p style=\"color:red\">" + (0,_lang__WEBPACK_IMPORTED_MODULE_0__["default"])('Dont Export') + "</p>";
      } else if (data == 1) {
        return "<p style=\"color:blue\">" + (0,_lang__WEBPACK_IMPORTED_MODULE_0__["default"])('Are Export') + '(' + (0,_lang__WEBPACK_IMPORTED_MODULE_0__["default"])('Waiting for AGV') + ')' + "</p>";
      } else if (data == 2) {
        return "<p style=\"color:blue\">" + (0,_lang__WEBPACK_IMPORTED_MODULE_0__["default"])('Are Export') + '(' + (0,_lang__WEBPACK_IMPORTED_MODULE_0__["default"])('AGV Shipping') + ')' + "</p>";
      } else {
        return "<p style=\"color:green\">" + (0,_lang__WEBPACK_IMPORTED_MODULE_0__["default"])('Success Export') + "</p>";
      }
    }
  }, {
    data: {
      id: 'ID',
      status: 'Status'
    },
    title: (0,_lang__WEBPACK_IMPORTED_MODULE_0__["default"])('Action'),
    render: function render(data) {
      if (data.Status == 0) {
        return "\n                    <button id=\"ex-" + data.ID + "\" class=\"btn btn-success btn-export\" >\n                    " + (0,_lang__WEBPACK_IMPORTED_MODULE_0__["default"])('Export') + "\n                    </button>\n                    <button id=\"del-" + data.ID + "\" class=\"btn btn-danger btn-delete\" >\n                    " + (0,_lang__WEBPACK_IMPORTED_MODULE_0__["default"])('Cancel') + "\n                    </button>\n                ";
      } else if (data.Status == 1 && data.Type == 2) {
        return "<button id=\"suc-" + data.ID + "\" class=\"btn btn-success btn-success\" >\n                    " + (0,_lang__WEBPACK_IMPORTED_MODULE_0__["default"])('Success') + "\n                    </button>";
      } else {
        return "";
      }
    }
  }]
});
$('table').on('page.dt', function () {
  console.log(table.page.info());
});
$('.filter').on('click', function () {
  table.ajax.reload();
});
$(document).on('click', '.btn-delete', function () {
  var id = $(this).attr('id');
  var name = $(this).parent().parent().children('td').first().text();
  var currentRow = $(this).closest("tr");
  var col1 = currentRow.find("td:eq(1)").text();
  $('#modalRequestCan').modal();
  $('#nameDel').text(col1);
  $('#idCan').val(id.split('-')[1]);
});
$(document).on('click', '.btn-export', function () {
  var id = $(this).attr('id');
  var currentRow = $(this).closest("tr");
  var col1 = currentRow.find("td:eq(0)").html();
  var col2 = currentRow.find("td:eq(2)").text();
  var col3 = currentRow.find("td:eq(3)").text();
  var name = $(this).parent().parent().children('td').first().text();
  $('#modalAddOrUpdate').modal();
  $('#Machine').val(col3);
  $('#Materials').val(col2);
  $('#idex').val(id.split('-')[1]);
});
var mater = 0;
socket.on('export-materials', function (message) {
  mater++;
  $('#modal_alert_export').modal();
  $('#alert').text('C?? ' + mater + ' NVL c???n Xu???t');
  table.ajax.reload();
});
socket.on('update-status-agv', function (message) {
  console.log(message);
  table.ajax.reload();
});
})();

/******/ })()
;