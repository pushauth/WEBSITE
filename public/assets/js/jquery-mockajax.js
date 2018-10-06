!function(e,t){"use strict";if("function"==typeof define&&define.amd&&define.amd.jQuery)define(["jquery"],function(n){return t(n,e)});else{if("object"!=typeof exports)return t(e.jQuery||e.$,e);module.exports=t}}(this,function(e,t){"use strict";function n(n){void 0===t.DOMParser&&t.ActiveXObject&&(t.DOMParser=function(){},DOMParser.prototype.parseFromString=function(e){var t=new ActiveXObject("Microsoft.XMLDOM");return t.async="false",t.loadXML(e),t});try{var r=(new DOMParser).parseFromString(n,"text/xml");if(!e.isXMLDoc(r))throw new Error("Unable to parse XML");var s=e("parsererror",r);if(1===s.length)throw new Error("Error: "+e(r).text());return r}catch(o){var a=void 0===o.name?o:o.name+": "+o.message;return void e(document).trigger("xmlParseError",[a])}}function r(t,n){var s=!0;return"string"==typeof n?e.isFunction(t.test)?t.test(n):t===n:(e.each(t,function(o){return void 0===n[o]?s=!1:void("object"==typeof n[o]&&null!==n[o]?(s&&e.isArray(n[o])&&(s=e.isArray(t[o])&&n[o].length===t[o].length),s=s&&r(t[o],n[o])):s=t[o]&&e.isFunction(t[o].test)?s&&t[o].test(n[o]):s&&t[o]===n[o])}),s)}function s(t,n){return t[n]===e.mockjaxSettings[n]}function o(t,n){if(e.isFunction(t))return t(n);if(e.isFunction(t.url.test)){if(!t.url.test(n.url))return null}else{var s=t.url.indexOf("*");if(t.url!==n.url&&s===-1||!new RegExp(t.url.replace(/[-[\]{}()+?.,\\^$|#\s]/g,"\\$&").replace(/\*/g,".+")).test(n.url))return null}if(t.requestHeaders){if(void 0===n.headers)return null;var o=!1;if(e.each(t.requestHeaders,function(e,t){var r=n.headers[e];if(r!==t)return o=!0,!1}),o)return null}return!t.data||n.data&&r(t.data,n.data)?t&&t.type&&t.type.toLowerCase()!==n.type.toLowerCase()?null:t:null}function a(e){return"number"==typeof e&&e>=0}function i(t){if(e.isArray(t)&&2===t.length){var n=t[0],r=t[1];if(a(n)&&a(r))return Math.floor(Math.random()*(r-n))+n}else if(a(t))return t;return w}function u(t,r,o){var a=function(s){return function(){return function(){this.status=t.status,this.statusText=t.statusText,this.readyState=1;var a=function(){this.readyState=4;var s;"json"===r.dataType&&"object"==typeof t.responseText?this.responseText=JSON.stringify(t.responseText):"xml"===r.dataType?"string"==typeof t.responseXML?(this.responseXML=n(t.responseXML),this.responseText=t.responseXML):this.responseXML=t.responseXML:"object"==typeof t.responseText&&null!==t.responseText?(t.contentType="application/json",this.responseText=JSON.stringify(t.responseText)):this.responseText=t.responseText,"number"!=typeof t.status&&"string"!=typeof t.status||(this.status=t.status),"string"==typeof t.statusText&&(this.statusText=t.statusText),s=this.onreadystatechange||this.onload,e.isFunction(s)?(t.isTimeout&&(this.status=-1),s.call(this,t.isTimeout?"timeout":void 0)):t.isTimeout&&(this.status=-1)};if(e.isFunction(t.response)){if(2===t.response.length)return void t.response(o,function(){a.call(s)});t.response(o)}a.call(s)}.apply(s)}}(this);t.proxy?m({global:!1,url:t.proxy,type:t.proxyType,data:t.data,dataType:"script"===r.dataType?"text/plain":r.dataType,complete:function(e){t.responseXML=e.responseXML,t.responseText=e.responseText,s(t,"status")&&(t.status=e.status),s(t,"statusText")&&(t.statusText=e.statusText),this.responseTimer=setTimeout(a,i(t.responseTime))}}):r.async===!1?a():this.responseTimer=setTimeout(a,i(t.responseTime))}function c(t,n,r,s){return t=e.extend(!0,{},e.mockjaxSettings,t),"undefined"==typeof t.headers&&(t.headers={}),"undefined"==typeof n.headers&&(n.headers={}),t.contentType&&(t.headers["content-type"]=t.contentType),{status:t.status,statusText:t.statusText,readyState:1,open:function(){},send:function(){s.fired=!0,u.call(this,t,n,r)},abort:function(){clearTimeout(this.responseTimer)},setRequestHeader:function(e,t){n.headers[e]=t},getResponseHeader:function(e){return t.headers&&t.headers[e]?t.headers[e]:"last-modified"===e.toLowerCase()?t.lastModified||(new Date).toString():"etag"===e.toLowerCase()?t.etag||"":"content-type"===e.toLowerCase()?t.contentType||"text/plain":void 0},getAllResponseHeaders:function(){var n="";return t.contentType&&(t.headers["Content-Type"]=t.contentType),e.each(t.headers,function(e,t){n+=e+": "+t+"\n"}),n}}}function l(e,t,n){if(p(e),e.dataType="json",e.data&&M.test(e.data)||M.test(e.url)){x(e,t,n);var r=/^(\w+:)?\/\/([^\/?#]+)/,s=r.exec(e.url),o=s&&(s[1]&&s[1]!==location.protocol||s[2]!==location.host);if(e.dataType="script","GET"===e.type.toUpperCase()&&o){var a=f(e,t,n);return!a||a}}return null}function p(e){"GET"===e.type.toUpperCase()?M.test(e.url)||(e.url+=(/\?/.test(e.url)?"&":"?")+(e.jsonp||"callback")+"=?"):e.data&&M.test(e.data)||(e.data=(e.data?e.data+"&":"")+(e.jsonp||"callback")+"=?")}function f(t,n,r){var s=r&&r.context||t,o=e.Deferred?new e.Deferred:null;if(n.response&&e.isFunction(n.response))n.response(r);else if("object"==typeof n.responseText)e.globalEval("("+JSON.stringify(n.responseText)+")");else{if(n.proxy)return m({global:!1,url:n.proxy,type:n.proxyType,data:n.data,dataType:"script"===t.dataType?"text/plain":t.dataType,complete:function(r){e.globalEval("("+r.responseText+")"),d(t,n,s,o)}}),o;e.globalEval("("+n.responseText+")")}return d(t,n,s,o),o}function d(t,n,r,s){var o;if(setTimeout(function(){y(t,r,n),h(t,r)},i(n.responseTime)),s){try{o=e.parseJSON(n.responseText)}catch(a){}s.resolveWith(r,[o||n.responseText])}}function x(e,n,r){var s=r&&r.context||e,o=e.jsonpCallback||"jsonp"+S++;e.data&&(e.data=(e.data+"").replace(M,"="+o+"$1")),e.url=e.url.replace(M,"="+o+"$1"),t[o]=t[o]||function(){y(e,s,n),h(e,s),t[o]=void 0;try{delete t[o]}catch(r){}}}function y(t,n,r){t.success&&t.success.call(n,r.responseText||"","success",{}),t.global&&(t.context?e(t.context):e.event).trigger("ajaxSuccess",[{},t])}function h(t,n){t.complete&&t.complete.call(n,{statusText:"success",status:200},"success"),t.global&&(t.context?e(t.context):e.event).trigger("ajaxComplete",[{},t]),t.global&&!--e.active&&e.event.trigger("ajaxStop")}function g(t,n){var r,s,a,i;"object"==typeof t?(n=t,t=void 0):(n=n||{},n.url=t),s=e.ajaxSetup({},n),s.type=s.method=s.method||s.type,i=function(t,r){var s=n[t.toLowerCase()];return function(){e.isFunction(s)&&s.apply(this,[].slice.call(arguments)),r["onAfter"+t]()}};for(var u=0;u<v.length;u++)if(v[u]&&(a=o(v[u],s)))return j.push(s),e.mockjaxSettings.log(a,s),s.dataType&&"JSONP"===s.dataType.toUpperCase()&&(r=l(s,a,n))?r:(a.cache=s.cache,a.timeout=s.timeout,a.global=s.global,a.isTimeout&&(a.responseTime>1?n.timeout=a.responseTime-1:(a.responseTime=2,n.timeout=1)),e.isFunction(a.onAfterSuccess)&&(n.success=i("Success",a)),e.isFunction(a.onAfterError)&&(n.error=i("Error",a)),e.isFunction(a.onAfterComplete)&&(n.complete=i("Complete",a)),T(a,n),function(t,n,s,o){r=m.call(e,e.extend(!0,{},s,{xhr:function(){return c(t,n,s,o)}}))}(a,s,n,v[u]),r);if(b.push(n),e.mockjaxSettings.throwUnmocked===!0)throw new Error("AJAX not mocked: "+n.url);return m.apply(e,[n])}function T(e,t){if(e.url instanceof RegExp&&e.hasOwnProperty("urlParams")){var n=e.url.exec(t.url);if(1!==n.length){n.shift();var r=0,s=n.length,o=e.urlParams.length,a=Math.min(s,o),i={};for(r;r<a;r++){var u=e.urlParams[r];i[u]=n[r]}t.urlParams=i}}}var m=e.ajax,v=[],j=[],b=[],M=/=\?(&|$)/,S=(new Date).getTime();e.extend({ajax:g});var w=500;return e.mockjaxSettings={log:function(n,r){if(n.logging!==!1&&("undefined"!=typeof n.logging||e.mockjaxSettings.logging!==!1)&&t.console&&console.log){var s="MOCK "+r.type.toUpperCase()+": "+r.url,o=e.ajaxSetup({},r);if("function"==typeof console.log)console.log(s,o);else try{console.log(s+" "+JSON.stringify(o))}catch(a){console.log(s)}}},logging:!0,status:200,statusText:"OK",responseTime:w,isTimeout:!1,throwUnmocked:!1,contentType:"text/plain",response:"",responseText:"",responseXML:"",proxy:"",proxyType:"GET",lastModified:null,etag:"",headers:{etag:"IJF@H#@923uf8023hFO@I#H#","content-type":"text/plain"}},e.mockjax=function(e){var t=v.length;return v[t]=e,t},e.mockjax.clear=function(e){e||0===e?v[e]=null:v=[],j=[],b=[]},e.mockjax.handler=function(e){if(1===arguments.length)return v[e]},e.mockjax.mockedAjaxCalls=function(){return j},e.mockjax.unfiredHandlers=function(){for(var e=[],t=0,n=v.length;t<n;t++){var r=v[t];null===r||r.fired||e.push(r)}return e},e.mockjax.unmockedAjaxCalls=function(){return b},e.mockjax});