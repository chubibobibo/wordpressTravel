!function(e){var t={};function n(r){if(t[r])return t[r].exports;var o=t[r]={i:r,l:!1,exports:{}};return e[r].call(o.exports,o,o.exports,n),o.l=!0,o.exports}n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)n.d(r,o,function(t){return e[t]}.bind(null,o));return r},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=401)}({0:function(e,t){e.exports=window.wp.element},10:function(e,t){e.exports=window.wp.data},115:function(e,t,n){var r=n(76);e.exports=function(e){if(Array.isArray(e))return r(e)},e.exports.default=e.exports,e.exports.__esModule=!0},116:function(e,t){e.exports=function(e){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(e))return Array.from(e)},e.exports.default=e.exports,e.exports.__esModule=!0},117:function(e,t){e.exports=function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")},e.exports.default=e.exports,e.exports.__esModule=!0},118:function(e,t){e.exports=function(e){if(Array.isArray(e))return e},e.exports.default=e.exports,e.exports.__esModule=!0},119:function(e,t){e.exports=function(e,t){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(e)){var n=[],r=!0,o=!1,l=void 0;try{for(var a,c=e[Symbol.iterator]();!(r=(a=c.next()).done)&&(n.push(a.value),!t||n.length!==t);r=!0);}catch(e){o=!0,l=e}finally{try{r||null==c.return||c.return()}finally{if(o)throw l}}return n}},e.exports.default=e.exports,e.exports.__esModule=!0},120:function(e,t){e.exports=function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")},e.exports.default=e.exports,e.exports.__esModule=!0},19:function(e,t){e.exports=window.wp.hooks},20:function(e,t){e.exports=function(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e},e.exports.default=e.exports,e.exports.__esModule=!0},23:function(e,t,n){var r=n(115),o=n(116),l=n(77),a=n(117);e.exports=function(e){return r(e)||o(e)||l(e)||a()},e.exports.default=e.exports,e.exports.__esModule=!0},32:function(e,t){e.exports=window.wp.apiFetch},4:function(e,t){e.exports=window.wp.i18n},401:function(e,t,n){"use strict";n.r(t);var r=n(23),o=n.n(r),l=n(19),a=n(4),c=n(20),s=n.n(c),i=n(84),u=n.n(i),p=n(0),b=n(5),f=n(10),d=n(32),m=n.n(d);function _(e,t){var n=Object.keys(e);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(e);t&&(r=r.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),n.push.apply(n,r)}return n}function O(e){for(var t=1;t<arguments.length;t++){var n=null!=arguments[t]?arguments[t]:{};t%2?_(Object(n),!0).forEach((function(t){s()(e,t,n[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(n)):_(Object(n)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(n,t))}))}return e}var w=function(e){var t=e.allData,n=t.enable_gutenberg,r=t.enable_custom_template,o=t.selected_template,l=t.options.templates,c=Object(f.dispatch)("WPTravel/Admin").updateSettings,s=Object(p.useState)({resetting:!1,showMigrateCompleteNotice:!1}),i=u()(s,2),d=i[0],_=d.resetting,w=d.showMigrateCompleteNotice,j=i[1],v=function(e){j((function(t){return O(O({},t),e)}))};return setTimeout((function(){void 0!==w&&w&&v({showMigrateCompleteNotice:!1})}),5e3),Object(p.createElement)("div",{className:"wp-travel-ui wp-travel-ui-card settings-blocks"},Object(p.createElement)("h2",null,Object(a.__)("Block Settings","wp-travel")),Object(p.createElement)(b.PanelRow,null,Object(p.createElement)("label",null,Object(a.__)("Enable Gutenberg","wp-travel")),Object(p.createElement)("div",{className:"wp-travel-field-value"},Object(p.createElement)(b.ToggleControl,{checked:"yes"==n,onChange:function(){c(O(O({},t),{},{enable_gutenberg:"yes"===n?"no":"yes"}))}}),Object(p.createElement)("p",{className:"description"},Object(a.__)("This will enable Gutenberg in trip edit page","wp-travel")))),"yes"===n&&Object(p.createElement)(p.Fragment,null,Object(p.createElement)(b.PanelRow,null,Object(p.createElement)("label",null,Object(a.__)("Enable Custom Template","wp-travel")),Object(p.createElement)("div",{className:"wp-travel-field-value"},Object(p.createElement)(b.ToggleControl,{checked:"yes"==r,onChange:function(){c(O(O({},t),{},{enable_custom_template:"yes"===r?"no":"yes"}))}}),Object(p.createElement)("p",{className:"description"},Object(a.__)("This will enable Default template in trip edit page","wp-travel")))),"yes"===r&&Object(p.createElement)(b.PanelRow,null,Object(p.createElement)("label",null,Object(a.__)("Select Template","wp-travel")),Object(p.createElement)("div",{className:"wp-travel-field-value"},Object(p.createElement)(b.SelectControl,{value:o,options:l,onChange:function(e){c(O(O({},t),{},{selected_template:e}))}}),Object(p.createElement)("p",{className:"description"},l.length<2?Object(a.__)("Please add your templates form 'WP Travel > Templates'"):Object(a.__)("If you don't select template, default template will be used.","wp-travel")))),Object(p.createElement)(b.PanelRow,null,Object(p.createElement)("label",null,Object(a.__)("Reset All trip templates","wp-travel")," ",_&&Object(p.createElement)(b.Spinner,null)," ",w&&Object(p.createElement)("p",{className:"text-success"},"All Templates reset successfully!!")),Object(p.createElement)("div",{className:"wp-travel-field-value"},Object(p.createElement)(b.CheckboxControl,{onChange:function(){confirm("This will reset all trips template. Do you want to continue?")&&(v({resetting:!0}),m()({url:"".concat(ajaxurl,"?action=wptravel_reset_templates&_nonce=").concat(_wp_travel_admin._nonce),data:{reset_template:!0},method:"post"}).then((function(e){v({resetting:!1,showMigrateCompleteNotice:!0})})))}}),Object(p.createElement)("p",{className:"description"},Object(a.__)("This will replace all trips with default template selected above. This action can not be undo.","wp-travel-blocks"))))))};Object(l.addFilter)("wptravel_settings_tab_content_block_settings","WPTravelBlock/Settings/BlockSettings",(function(e,t){return[].concat(o()(e),[Object(p.createElement)(w,{allData:t,key:"BlockSettings"})])}),10),Object(l.addFilter)("wp_travel_settings_tabs","wp_travel",(function(e){return e=[].concat(o()(e),[{name:"block-settings",title:Object(a.__)("Block Settings","wp-travel"),className:"tab-block-settings"}])}))},5:function(e,t){e.exports=window.wp.components},76:function(e,t){e.exports=function(e,t){(null==t||t>e.length)&&(t=e.length);for(var n=0,r=new Array(t);n<t;n++)r[n]=e[n];return r},e.exports.default=e.exports,e.exports.__esModule=!0},77:function(e,t,n){var r=n(76);e.exports=function(e,t){if(e){if("string"==typeof e)return r(e,t);var n=Object.prototype.toString.call(e).slice(8,-1);return"Object"===n&&e.constructor&&(n=e.constructor.name),"Map"===n||"Set"===n?Array.from(e):"Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)?r(e,t):void 0}},e.exports.default=e.exports,e.exports.__esModule=!0},84:function(e,t,n){var r=n(118),o=n(119),l=n(77),a=n(120);e.exports=function(e,t){return r(e)||o(e,t)||l(e,t)||a()},e.exports.default=e.exports,e.exports.__esModule=!0}});