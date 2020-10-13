!function(a){if("object"==typeof exports&&"undefined"!=typeof module)module.exports=a();else if("function"==typeof define&&define.amd)define([],a);else{var b;b="undefined"!=typeof window?window:"undefined"!=typeof global?global:"undefined"!=typeof self?self:this,b.videojs=a()}}(function(){var a;return function a(b,c,d){function e(g,h){if(!c[g]){if(!b[g]){var i="function"==typeof require&&require;if(!h&&i)return i(g,!0);if(f)return f(g,!0);var j=new Error("Cannot find module '"+g+"'");throw j.code="MODULE_NOT_FOUND",j}var k=c[g]={exports:{}};b[g][0].call(k.exports,function(a){var c=b[g][1][a];return e(c?c:a)},k,k.exports,a,b,c,d)}return c[g].exports}for(var f="function"==typeof require&&require,g=0;g<d.length;g++)e(d[g]);return e}({1:[function(a,b,c){(function(c){var d="undefined"!=typeof c?c:"undefined"!=typeof window?window:{},e=a("min-document");if("undefined"!=typeof document)b.exports=document;else{var f=d["__GLOBAL_DOCUMENT_CACHE@4"];f||(f=d["__GLOBAL_DOCUMENT_CACHE@4"]=e),b.exports=f}}).call(this,"undefined"!=typeof global?global:"undefined"!=typeof self?self:"undefined"!=typeof window?window:{})},{"min-document":3}],2:[function(a,b,c){(function(a){"undefined"!=typeof window?b.exports=window:"undefined"!=typeof a?b.exports=a:"undefined"!=typeof self?b.exports=self:b.exports={}}).call(this,"undefined"!=typeof global?global:"undefined"!=typeof self?self:"undefined"!=typeof window?window:{})},{}],3:[function(a,b,c){},{}],4:[function(a,b,c){var d=a("../internal/getNative"),e=d(Date,"now"),f=e||function(){return(new Date).getTime()};b.exports=f},{"../internal/getNative":20}],5:[function(a,b,c){function h(a,b,c){function s(){m&&clearTimeout(m),i&&clearTimeout(i),o=0,i=m=n=void 0}function t(b,c){c&&clearTimeout(c),i=m=n=void 0,b&&(o=e(),j=a.apply(l,h),m||i||(h=l=void 0))}function u(){var a=b-(e()-k);a<=0||a>b?t(n,i):m=setTimeout(u,a)}function v(){t(q,m)}function w(){if(h=arguments,k=e(),l=this,n=q&&(m||!r),p===!1)var c=r&&!m;else{i||r||(o=k);var d=p-(k-o),f=d<=0||d>p;f?(i&&(i=clearTimeout(i)),o=k,j=a.apply(l,h)):i||(i=setTimeout(v,d))}return f&&m?m=clearTimeout(m):m||b===p||(m=setTimeout(u,b)),c&&(f=!0,j=a.apply(l,h)),!f||m||i||(h=l=void 0),j}var h,i,j,k,l,m,n,o=0,p=!1,q=!0;if("function"!=typeof a)throw new TypeError(f);if(b=b<0?0:+b||0,c===!0){var r=!0;q=!1}else d(c)&&(r=!!c.leading,p="maxWait"in c&&g(+c.maxWait||0,b),q="trailing"in c?!!c.trailing:q);return w.cancel=s,w}var d=a("../lang/isObject"),e=a("../date/now"),f="Expected a function",g=Math.max;b.exports=h},{"../date/now":4,"../lang/isObject":33}],6:[function(a,b,c){function f(a,b){if("function"!=typeof a)throw new TypeError(d);return b=e(void 0===b?a.length-1:+b||0,0),function(){for(var c=arguments,d=-1,f=e(c.length-b,0),g=Array(f);++d<f;)g[d]=c[b+d];switch(b){case 0:return a.call(this,g);case 1:return a.call(this,c[0],g);case 2:return a.call(this,c[0],c[1],g)}var h=Array(b+1);for(d=-1;++d<b;)h[d]=c[d];return h[b]=g,a.apply(this,h)}}var d="Expected a function",e=Math.max;b.exports=f},{}],7:[function(a,b,c){function g(a,b,c){var g=!0,h=!0;if("function"!=typeof a)throw new TypeError(f);return c===!1?g=!1:e(c)&&(g="leading"in c?!!c.leading:g,h="trailing"in c?!!c.trailing:h),d(a,b,{leading:g,maxWait:+b,trailing:h})}var d=a("./debounce"),e=a("../lang/isObject"),f="Expected a function";b.exports=g},{"../lang/isObject":33,"./debounce":5}],8:[function(a,b,c){function d(a,b){var c=-1,d=a.length;for(b||(b=Array(d));++c<d;)b[c]=a[c];return b}b.exports=d},{}],9:[function(a,b,c){function d(a,b){for(var c=-1,d=a.length;++c<d&&b(a[c],c,a)!==!1;);return a}b.exports=d},{}],10:[function(a,b,c){function d(a,b,c){c||(c={});for(var d=-1,e=b.length;++d<e;){var f=b[d];c[f]=a[f]}return c}b.exports=d},{}],11:[function(a,b,c){var d=a("./createBaseFor"),e=d();b.exports=e},{"./createBaseFor":18}],12:[function(a,b,c){function f(a,b){return d(a,b,e)}var d=a("./baseFor"),e=a("../object/keysIn");b.exports=f},{"../object/keysIn":39,"./baseFor":11}],13:[function(a,b,c){function l(a,b,c,m,n){if(!h(a))return a;var o=g(b)&&(f(b)||j(b)),p=o?void 0:k(b);return d(p||b,function(d,f){if(p&&(f=d,d=b[f]),i(d))m||(m=[]),n||(n=[]),e(a,b,f,l,c,m,n);else{var g=a[f],h=c?c(g,d,f,a,b):void 0,j=void 0===h;j&&(h=d),void 0===h&&(!o||f in a)||!j&&(h===h?h===g:g!==g)||(a[f]=h)}}),a}var d=a("./arrayEach"),e=a("./baseMergeDeep"),f=a("../lang/isArray"),g=a("./isArrayLike"),h=a("../lang/isObject"),i=a("./isObjectLike"),j=a("../lang/isTypedArray"),k=a("../object/keys");b.exports=l},{"../lang/isArray":30,"../lang/isObject":33,"../lang/isTypedArray":36,"../object/keys":38,"./arrayEach":9,"./baseMergeDeep":14,"./isArrayLike":21,"./isObjectLike":26}],14:[function(a,b,c){function k(a,b,c,k,l,m,n){for(var o=m.length,p=b[c];o--;)if(m[o]==p)return void(a[c]=n[o]);var q=a[c],r=l?l(q,p,c,a,b):void 0,s=void 0===r;s&&(r=p,g(p)&&(f(p)||i(p))?r=f(q)?q:g(q)?d(q):[]:h(p)||e(p)?r=e(q)?j(q):h(q)?q:{}:s=!1),m.push(p),n.push(r),s?a[c]=k(r,p,l,m,n):(r===r?r!==q:q===q)&&(a[c]=r)}var d=a("./arrayCopy"),e=a("../lang/isArguments"),f=a("../lang/isArray"),g=a("./isArrayLike"),h=a("../lang/isPlainObject"),i=a("../lang/isTypedArray"),j=a("../lang/toPlainObject");b.exports=k},{"../lang/isArguments":29,"../lang/isArray":30,"../lang/isPlainObject":34,"../lang/isTypedArray":36,"../lang/toPlainObject":37,"./arrayCopy":8,"./isArrayLike":21}],15:[function(a,b,c){function e(a){return function(b){return null==b?void 0:d(b)[a]}}var d=a("./toObject");b.exports=e},{"./toObject":28}],16:[function(a,b,c){function e(a,b,c){if("function"!=typeof a)return d;if(void 0===b)return a;switch(c){case 1:return function(c){return a.call(b,c)};case 3:return function(c,d,e){return a.call(b,c,d,e)};case 4:return function(c,d,e,f){return a.call(b,c,d,e,f)};case 5:return function(c,d,e,f,g){return a.call(b,c,d,e,f,g)}}return function(){return a.apply(b,arguments)}}var d=a("../utility/identity");b.exports=e},{"../utility/identity":42}],17:[function(a,b,c){function g(a){return f(function(b,c){var f=-1,g=null==b?0:c.length,h=g>2?c[g-2]:void 0,i=g>2?c[2]:void 0,j=g>1?c[g-1]:void 0;for("function"==typeof h?(h=d(h,j,5),g-=2):(h="function"==typeof j?j:void 0,g-=h?1:0),i&&e(c[0],c[1],i)&&(h=g<3?void 0:h,g=1);++f<g;){var k=c[f];k&&a(b,k,h)}return b})}var d=a("./bindCallback"),e=a("./isIterateeCall"),f=a("../function/restParam");b.exports=g},{"../function/restParam":6,"./bindCallback":16,"./isIterateeCall":24}],18:[function(a,b,c){function e(a){return function(b,c,e){for(var f=d(b),g=e(b),h=g.length,i=a?h:-1;a?i--:++i<h;){var j=g[i];if(c(f[j],j,f)===!1)break}return b}}var d=a("./toObject");b.exports=e},{"./toObject":28}],19:[function(a,b,c){var d=a("./baseProperty"),e=d("length");b.exports=e},{"./baseProperty":15}],20:[function(a,b,c){function e(a,b){var c=null==a?void 0:a[b];return d(c)?c:void 0}var d=a("../lang/isNative");b.exports=e},{"../lang/isNative":32}],21:[function(a,b,c){function f(a){return null!=a&&e(d(a))}var d=a("./getLength"),e=a("./isLength");b.exports=f},{"./getLength":19,"./isLength":25}],22:[function(a,b,c){var d=function(){try{Object({toString:0}+"")}catch(a){return function(){return!1}}return function(a){return"function"!=typeof a.toString&&"string"==typeof(a+"")}}();b.exports=d},{}],23:[function(a,b,c){function f(a,b){return a="number"==typeof a||d.test(a)?+a:-1,b=null==b?e:b,a>-1&&a%1==0&&a<b}var d=/^\d+$/,e=9007199254740991;b.exports=f},{}],24:[function(a,b,c){function g(a,b,c){if(!f(c))return!1;var g=typeof b;if("number"==g?d(c)&&e(b,c.length):"string"==g&&b in c){var h=c[b];return a===a?a===h:h!==h}return!1}var d=a("./isArrayLike"),e=a("./isIndex"),f=a("../lang/isObject");b.exports=g},{"../lang/isObject":33,"./isArrayLike":21,"./isIndex":23}],25:[function(a,b,c){function e(a){return"number"==typeof a&&a>-1&&a%1==0&&a<=d}var d=9007199254740991;b.exports=e},{}],26:[function(a,b,c){function d(a){return!!a&&"object"==typeof a}b.exports=d},{}],27:[function(a,b,c){function l(a){for(var b=i(a),c=b.length,j=c&&a.length,l=!!j&&g(j)&&(e(a)||d(a)||h(a)),m=-1,n=[];++m<c;){var o=b[m];(l&&f(o,j)||k.call(a,o))&&n.push(o)}return n}var d=a("../lang/isArguments"),e=a("../lang/isArray"),f=a("./isIndex"),g=a("./isLength"),h=a("../lang/isString"),i=a("../object/keysIn"),j=Object.prototype,k=j.hasOwnProperty;b.exports=l},{"../lang/isArguments":29,"../lang/isArray":30,"../lang/isString":35,"../object/keysIn":39,"./isIndex":23,"./isLength":25}],28:[function(a,b,c){function g(a){if(f.unindexedChars&&e(a)){for(var b=-1,c=a.length,g=Object(a);++b<c;)g[b]=a.charAt(b);return g}return d(a)?a:Object(a)}var d=a("../lang/isObject"),e=a("../lang/isString"),f=a("../support");b.exports=g},{"../lang/isObject":33,"../lang/isString":35,"../support":41}],29:[function(a,b,c){function i(a){return e(a)&&d(a)&&g.call(a,"callee")&&!h.call(a,"callee")}var d=a("../internal/isArrayLike"),e=a("../internal/isObjectLike"),f=Object.prototype,g=f.hasOwnProperty,h=f.propertyIsEnumerable;b.exports=i},{"../internal/isArrayLike":21,"../internal/isObjectLike":26}],30:[function(a,b,c){var d=a("../internal/getNative"),e=a("../internal/isLength"),f=a("../internal/isObjectLike"),g="[object Array]",h=Object.prototype,i=h.toString,j=d(Array,"isArray"),k=j||function(a){return f(a)&&e(a.length)&&i.call(a)==g};b.exports=k},{"../internal/getNative":20,"../internal/isLength":25,"../internal/isObjectLike":26}],31:[function(a,b,c){function h(a){return d(a)&&g.call(a)==e}var d=a("./isObject"),e="[object Function]",f=Object.prototype,g=f.toString;b.exports=h},{"./isObject":33}],32:[function(a,b,c){function l(a){return null!=a&&(d(a)?k.test(i.call(a)):f(a)&&(e(a)?k:g).test(a))}var d=a("./isFunction"),e=a("../internal/isHostObject"),f=a("../internal/isObjectLike"),g=/^\[object .+?Constructor\]$/,h=Object.prototype,i=Function.prototype.toString,j=h.hasOwnProperty,k=RegExp("^"+i.call(j).replace(/[\\^$.*+?()[\]{}|]/g,"\\$&").replace(/hasOwnProperty|(function).*?(?=\\\()| for .+?(?=\\\])/g,"$1.*?")+"$");b.exports=l},{"../internal/isHostObject":22,"../internal/isObjectLike":26,"./isFunction":31}],33:[function(a,b,c){function d(a){var b=typeof a;return!!a&&("object"==b||"function"==b)}b.exports=d},{}],34:[function(a,b,c){function m(a){var b;if(!g(a)||l.call(a)!=i||f(a)||e(a)||!k.call(a,"constructor")&&(b=a.constructor,"function"==typeof b&&!(b instanceof b)))return!1;var c;return h.ownLast?(d(a,function(a,b,d){return c=k.call(d,b),!1}),c!==!1):(d(a,function(a,b){c=b}),void 0===c||k.call(a,c))}var d=a("../internal/baseForIn"),e=a("./isArguments"),f=a("../internal/isHostObject"),g=a("../internal/isObjectLike"),h=a("../support"),i="[object Object]",j=Object.prototype,k=j.hasOwnProperty,l=j.toString;b.exports=m},{"../internal/baseForIn":12,"../internal/isHostObject":22,"../internal/isObjectLike":26,"../support":41,"./isArguments":29}],35:[function(a,b,c){function h(a){return"string"==typeof a||d(a)&&g.call(a)==e}var d=a("../internal/isObjectLike"),e="[object String]",f=Object.prototype,g=f.toString;b.exports=h},{"../internal/isObjectLike":26}],36:[function(a,b,c){function F(a){return e(a)&&d(a.length)&&!!C[E.call(a)]}var d=a("../internal/isLength"),e=a("../internal/isObjectLike"),f="[object Arguments]",g="[object Array]",h="[object Boolean]",i="[object Date]",j="[object Error]",k="[object Function]",l="[object Map]",m="[object Number]",n="[object Object]",o="[object RegExp]",p="[object Set]",q="[object String]",r="[object WeakMap]",s="[object ArrayBuffer]",t="[object Float32Array]",u="[object Float64Array]",v="[object Int8Array]",w="[object Int16Array]",x="[object Int32Array]",y="[object Uint8Array]",z="[object Uint8ClampedArray]",A="[object Uint16Array]",B="[object Uint32Array]",C={};C[t]=C[u]=C[v]=C[w]=C[x]=C[y]=C[z]=C[A]=C[B]=!0,C[f]=C[g]=C[s]=C[h]=C[i]=C[j]=C[k]=C[l]=C[m]=C[n]=C[o]=C[p]=C[q]=C[r]=!1;var D=Object.prototype,E=D.toString;b.exports=F},{"../internal/isLength":25,"../internal/isObjectLike":26}],37:[function(a,b,c){function f(a){return d(a,e(a))}var d=a("../internal/baseCopy"),e=a("../object/keysIn");b.exports=f},{"../internal/baseCopy":10,"../object/keysIn":39}],38:[function(a,b,c){var d=a("../internal/getNative"),e=a("../internal/isArrayLike"),f=a("../lang/isObject"),g=a("../internal/shimKeys"),h=a("../support"),i=d(Object,"keys"),j=i?function(a){var b=null==a?void 0:a.constructor;return"function"==typeof b&&b.prototype===a||("function"==typeof a?h.enumPrototypes:e(a))?g(a):f(a)?i(a):[]}:g;b.exports=j},{"../internal/getNative":20,"../internal/isArrayLike":21,"../internal/shimKeys":27,"../lang/isObject":33,"../support":41}],39:[function(a,b,c){function C(a){if(null==a)return[];j(a)||(a=Object(a));var b=a.length;b=b&&i(b)&&(f(a)||e(a)||k(a))&&b||0;for(var c=a.constructor,d=-1,m=g(c)&&c.prototype||x,n=m===a,o=Array(b),q=b>0,r=l.enumErrorProps&&(a===w||a instanceof Error),t=l.enumPrototypes&&g(a);++d<b;)o[d]=d+"";for(var C in a)t&&"prototype"==C||r&&("message"==C||"name"==C)||q&&h(C,b)||"constructor"==C&&(n||!z.call(a,C))||o.push(C);if(l.nonEnumShadows&&a!==x){var D=a===y?u:a===w?p:A.call(a),E=B[D]||B[s];for(D==s&&(m=x),b=v.length;b--;){C=v[b];var F=E[C];n&&F||(F?!z.call(a,C):a[C]===m[C])||o.push(C)}}return o}var d=a("../internal/arrayEach"),e=a("../lang/isArguments"),f=a("../lang/isArray"),g=a("../lang/isFunction"),h=a("../internal/isIndex"),i=a("../internal/isLength"),j=a("../lang/isObject"),k=a("../lang/isString"),l=a("../support"),m="[object Array]",n="[object Boolean]",o="[object Date]",p="[object Error]",q="[object Function]",r="[object Number]",s="[object Object]",t="[object RegExp]",u="[object String]",v=["constructor","hasOwnProperty","isPrototypeOf","propertyIsEnumerable","toLocaleString","toString","valueOf"],w=Error.prototype,x=Object.prototype,y=String.prototype,z=x.hasOwnProperty,A=x.toString,B={};B[m]=B[o]=B[r]={constructor:!0,toLocaleString:!0,toString:!0,valueOf:!0},B[n]=B[u]={constructor:!0,toString:!0,valueOf:!0},B[p]=B[q]=B[t]={constructor:!0,toString:!0},B[s]={constructor:!0},d(v,function(a){for(var b in B)if(z.call(B,b)){var c=B[b];c[a]=z.call(c,a)}}),b.exports=C},{"../internal/arrayEach":9,"../internal/isIndex":23,"../internal/isLength":25,"../lang/isArguments":29,"../lang/isArray":30,"../lang/isFunction":31,"../lang/isObject":33,"../lang/isString":35,"../support":41}],40:[function(a,b,c){var d=a("../internal/baseMerge"),e=a("../internal/createAssigner"),f=e(d);b.exports=f},{"../internal/baseMerge":13,"../internal/createAssigner":17}],41:[function(a,b,c){var d=Array.prototype,e=Error.prototype,f=Object.prototype,g=f.propertyIsEnumerable,h=d.splice,i={};!function(a){var b=function(){this.x=a},c={0:a,length:a},d=[];b.prototype={valueOf:a,y:a};for(var f in new b)d.push(f);i.enumErrorProps=g.call(e,"message")||g.call(e,"name"),i.enumPrototypes=g.call(b,"prototype"),i.nonEnumShadows=!/valueOf/.test(d),i.ownLast="x"!=d[0],i.spliceObjects=(h.call(c,0,1),!c[0]),i.unindexedChars="x"[0]+Object("x")[0]!="xx"}(1,0),b.exports=i},{}],42:[function(a,b,c){function d(a){return a}b.exports=d},{}],43:[function(a,b,c){"use strict";var d=a("object-keys");b.exports=function(){if("function"!=typeof Symbol||"function"!=typeof Object.getOwnPropertySymbols)return!1;if("symbol"==typeof Symbol.iterator)return!0;var b={},c=Symbol("test");if("string"==typeof c)return!1;var e=42;b[c]=e;for(c in b)return!1;if(0!==d(b).length)return!1;if("function"==typeof Object.keys&&0!==Object.keys(b).length)return!1;if("function"==typeof Object.getOwnPropertyNames&&0!==Object.getOwnPropertyNames(b).length)return!1;var f=Object.getOwnPropertySymbols(b);if(1!==f.length||f[0]!==c)return!1;if(!Object.prototype.propertyIsEnumerable.call(b,c))return!1;if("function"==typeof Object.getOwnPropertyDescriptor){var g=Object.getOwnPropertyDescriptor(b,c);if(g.value!==e||g.enumerable!==!0)return!1}return!0}},{"object-keys":49}],44:[function(a,b,c){"use strict";var d=a("object-keys"),e=a("function-bind"),f=function(a){return"undefined"!=typeof a&&null!==a},g=a("./hasSymbols")(),h=Object,i=e.call(Function.call,Array.prototype.push),j=e.call(Function.call,Object.prototype.propertyIsEnumerable);b.exports=function(b,c){if(!f(b))throw new TypeError("target must be an object");var k,l,m,n,o,p,q,e=h(b);for(k=1;k<arguments.length;++k){if(l=h(arguments[k]),n=d(l),g&&Object.getOwnPropertySymbols)for(o=Object.getOwnPropertySymbols(l),m=0;m<o.length;++m)q=o[m],j(l,q)&&i(n,q);for(m=0;m<n.length;++m)q=n[m],p=l[q],j(l,q)&&(e[q]=p)}return e}},{"./hasSymbols":43,"function-bind":48,"object-keys":49}],45:[function(a,b,c){"use strict";var d=a("define-properties"),e=a("./implementation"),f=a("./polyfill"),g=a("./shim");d(e,{implementation:e,getPolyfill:f,shim:g}),b.exports=e},{"./implementation":44,"./polyfill":51,"./shim":52,"define-properties":46}],46:[function(a,b,c){"use strict";var d=a("object-keys"),e=a("foreach"),f="function"==typeof Symbol&&"symbol"==typeof Symbol(),g=Object.prototype.toString,h=function(a){return"function"==typeof a&&"[object Function]"===g.call(a)},i=function(){var a={};try{Object.defineProperty(a,"x",{enumerable:!1,value:a});for(var b in a)return!1;return a.x===a}catch(a){return!1}},j=Object.defineProperty&&i(),k=function(a,b,c,d){(!(b in a)||h(d)&&d())&&(j?Object.defineProperty(a,b,{configurable:!0,enumerable:!1,value:c,writable:!0}):a[b]=c)},l=function(a,b){var c=arguments.length>2?arguments[2]:{},g=d(b);f&&(g=g.concat(Object.getOwnPropertySymbols(b))),e(g,function(d){k(a,d,b[d],c[d])})};l.supportsDescriptors=!!j,b.exports=l},{foreach:47,"object-keys":49}],47:[function(a,b,c){var d=Object.prototype.hasOwnProperty,e=Object.prototype.toString;b.exports=function(b,c,f){if("[object Function]"!==e.call(c))throw new TypeError("iterator must be a function");var g=b.length;if(g===+g)for(var h=0;h<g;h++)c.call(f,b[h],h,b);else for(var i in b)d.call(b,i)&&c.call(f,b[i],i,b)}},{}],48:[function(a,b,c){var d="Function.prototype.bind called on incompatible ",e=Array.prototype.slice,f=Object.prototype.toString,g="[object Function]";b.exports=function(b){var c=this;if("function"!=typeof c||f.call(c)!==g)throw new TypeError(d+c);for(var h=e.call(arguments,1),i=function(){if(this instanceof m){var a=c.apply(this,h.concat(e.call(arguments)));return Object(a)===a?a:this}return c.apply(b,h.concat(e.call(arguments)))},j=Math.max(0,c.length-h.length),k=[],l=0;l<j;l++)k.push("$"+l);var m=Function("binder","return function ("+k.join(",")+"){ return binder.apply(this,arguments); }")(i);if(c.prototype){var n=function(){};n.prototype=c.prototype,m.prototype=new n,n.prototype=null}return m}},{}],49:[function(a,b,c){"use strict";var d=Object.prototype.hasOwnProperty,e=Object.prototype.toString,f=Array.prototype.slice,g=a("./isArguments"),h=!{toString:null}.propertyIsEnumerable("toString"),i=function(){}.propertyIsEnumerable("prototype"),j=["toString","toLocaleString","valueOf","hasOwnProperty","isPrototypeOf","propertyIsEnumerable","constructor"],k=function(a){var b=a.constructor;return b&&b.prototype===a},l={$console:!0,$frame:!0,$frameElement:!0,$frames:!0,$parent:!0,$self:!0,$webkitIndexedDB:!0,$webkitStorageInfo:!0,$window:!0},m=function(){if("undefined"==typeof window)return!1;for(var a in window)try{if(!l["$"+a]&&d.call(window,a)&&null!==window[a]&&"object"==typeof window[a])try{k(window[a])}catch(a){return!0}}catch(a){return!0}return!1}(),n=function(a){if("undefined"==typeof window||!m)return k(a);try{return k(a)}catch(a){return!1}},o=function(b){var c=null!==b&&"object"==typeof b,f="[object Function]"===e.call(b),k=g(b),l=c&&"[object String]"===e.call(b),m=[];if(!c&&!f&&!k)throw new TypeError("Object.keys called on a non-object");var o=i&&f;if(l&&b.length>0&&!d.call(b,0))for(var p=0;p<b.length;++p)m.push(String(p));if(k&&b.length>0)for(var q=0;q<b.length;++q)m.push(String(q));else for(var r in b)o&&"prototype"===r||!d.call(b,r)||m.push(String(r));if(h)for(var s=n(b),t=0;t<j.length;++t)s&&"constructor"===j[t]||!d.call(b,j[t])||m.push(j[t]);return m};o.shim=function(){if(Object.keys){var b=function(){return 2===(Object.keys(arguments)||"").length}(1,2);if(!b){var c=Object.keys;Object.keys=function(b){return c(g(b)?f.call(b):b)}}}else Object.keys=o;return Object.keys||o},b.exports=o},{"./isArguments":50}],50:[function(a,b,c){"use strict";var d=Object.prototype.toString;b.exports=function(b){var c=d.call(b),e="[object Arguments]"===c;return e||(e="[object Array]"!==c&&null!==b&&"object"==typeof b&&"number"==typeof b.length&&b.length>=0&&"[object Function]"===d.call(b.callee)),e}},{}],51:[function(a,b,c){"use strict";var d=a("./implementation"),e=function(){if(!Object.assign)return!1;for(var a="abcdefghijklmnopqrst",b=a.split(""),c={},d=0;d<b.length;++d)c[b[d]]=b[d];var e=Object.assign({},c),f="";for(var g in e)f+=g;return a!==f},f=function(){if(!Object.assign||!Object.preventExtensions)return!1;var a=Object.preventExtensions({1:2});try{Object.assign(a,"xy")}catch(b){return"y"===a[1]}};b.exports=function(){return Object.assign?e()?d:f()?d:Object.assign:d}},{"./implementation":44}],52:[function(a,b,c){"use strict";var d=a("define-properties"),e=a("./polyfill");b.exports=function(){var b=e();return d(Object,{assign:b},{assign:function(){return Object.assign!==b}}),b}},{"./polyfill":51,"define-properties":46}],53:[function(a,b,c){function d(a,b){var c,d=null;try{c=JSON.parse(a,b)}catch(a){d=a}return[d,c]}b.exports=d},{}],54:[function(a,b,c){function d(a){return a.replace(/\n\r?\s*/g,"")}b.exports=function(b){for(var c="",e=0;e<arguments.length;e++)c+=d(b[e])+(arguments[e+1]||"");return c}},{}],55:[function(a,b,c){"use strict";function i(a,b){for(var c=0;c<a.length;c++)b(a[c])}function j(a){for(var b in a)if(a.hasOwnProperty(b))return!1;return!0}function k(a,b,c){var d=a;return f(b)?(c=b,"string"==typeof a&&(d={uri:a})):d=h(b,{uri:a}),d.callback=c,d}function l(a,b,c){return b=k(a,b,c),m(b)}function m(a){function c(){4===k.readyState&&i()}function d(){var a=void 0;if(k.response?a=k.response:"text"!==k.responseType&&k.responseType||(a=k.responseText||k.responseXML),t)try{a=JSON.parse(a)}catch(a){}return a}function h(a){clearTimeout(u),a instanceof Error||(a=new Error(""+(a||"Unknown XMLHttpRequest Error"))),a.statusCode=0,b(a,f)}function i(){if(!n){var c;clearTimeout(u),c=a.useXDR&&void 0===k.status?200:1223===k.status?204:k.status;var e=f,h=null;0!==c?(e={body:d(),statusCode:c,method:p,headers:{},url:o,rawRequest:k},k.getAllResponseHeaders&&(e.headers=g(k.getAllResponseHeaders()))):h=new Error("Internal XMLHttpRequest Error"),b(h,e,e.body)}}var b=a.callback;if("undefined"==typeof b)throw new Error("callback argument missing");b=e(b);var f={body:void 0,headers:{},statusCode:0,method:p,url:o,rawRequest:k},k=a.xhr||null;k||(k=a.cors||a.useXDR?new l.XDomainRequest:new l.XMLHttpRequest);var m,n,u,o=k.url=a.uri||a.url,p=k.method=a.method||"GET",q=a.body||a.data||null,r=k.headers=a.headers||{},s=!!a.sync,t=!1;if("json"in a&&(t=!0,r.accept||r.Accept||(r.Accept="application/json"),"GET"!==p&&"HEAD"!==p&&(r["content-type"]||r["Content-Type"]||(r["Content-Type"]="application/json"),q=JSON.stringify(a.json))),k.onreadystatechange=c,k.onload=i,k.onerror=h,k.onprogress=function(){},k.ontimeout=h,k.open(p,o,!s,a.username,a.password),s||(k.withCredentials=!!a.withCredentials),!s&&a.timeout>0&&(u=setTimeout(function(){n=!0,k.abort("timeout");var a=new Error("XMLHttpRequest timeout");a.code="ETIMEDOUT",h(a)},a.timeout)),k.setRequestHeader)for(m in r)r.hasOwnProperty(m)&&k.setRequestHeader(m,r[m]);else if(a.headers&&!j(a.headers))throw new Error("Headers cannot be set on an XDomainRequest object");return"responseType"in a&&(k.responseType=a.responseType),"beforeSend"in a&&"function"==typeof a.beforeSend&&a.beforeSend(k),k.send(q),k}function n(){}var d=a("global/window"),e=a("once"),f=a("is-function"),g=a("parse-headers"),h=a("xtend");b.exports=l,l.XMLHttpRequest=d.XMLHttpRequest||n,l.XDomainRequest="withCredentials"in new l.XMLHttpRequest?l.XMLHttpRequest:d.XDomainRequest,i(["get","put","post","patch","head","delete"],function(a){l["delete"===a?"del":a]=function(b,c,d){return c=k(b,c,d),c.method=a.toUpperCase(),m(c)}})},{"global/window":2,"is-function":56,once:57,"parse-headers":60,xtend:61}],56:[function(a,b,c){function e(a){var b=d.call(a);return"[object Function]"===b||"function"==typeof a&&"[object RegExp]"!==b||"undefined"!=typeof window&&(a===window.setTimeout||a===window.alert||a===window.confirm||a===window.prompt)}b.exports=e;var d=Object.prototype.toString},{}],57:[function(a,b,c){function d(a){var b=!1;return function(){if(!b)return b=!0,a.apply(this,arguments)}}b.exports=d,d.proto=d(function(){Object.defineProperty(Function.prototype,"once",{value:function(){return d(this)},configurable:!0})})},{}],58:[function(a,b,c){function g(a,b,c){if(!d(b))throw new TypeError("iterator must be a function");arguments.length<3&&(c=this),"[object Array]"===e.call(a)?h(a,b,c):"string"==typeof a?i(a,b,c):j(a,b,c)}function h(a,b,c){for(var d=0,e=a.length;d<e;d++)f.call(a,d)&&b.call(c,a[d],d,a)}function i(a,b,c){for(var d=0,e=a.length;d<e;d++)b.call(c,a.charAt(d),d,a)}function j(a,b,c){for(var d in a)f.call(a,d)&&b.call(c,a[d],d,a)}var d=a("is-function");b.exports=g;var e=Object.prototype.toString,f=Object.prototype.hasOwnProperty},{"is-function":56}],59:[function(a,b,c){function d(a){return a.replace(/^\s*|\s*$/g,"")}c=b.exports=d,c.left=function(a){return a.replace(/^\s*/,"")},c.right=function(a){return a.replace(/\s*$/,"")}},{}],60:[function(a,b,c){var d=a("trim"),e=a("for-each"),f=function(a){return"[object Array]"===Object.prototype.toString.call(a)};b.exports=function(a){if(!a)return{};var b={};return e(d(a).split("\n"),function(a){var c=a.indexOf(":"),e=d(a.slice(0,c)).toLowerCase(),g=d(a.slice(c+1));"undefined"==typeof b[e]?b[e]=g:f(b[e])?b[e].push(g):b[e]=[b[e],g]}),b}},{"for-each":58,trim:59}],61:[function(a,b,c){function e(){for(var a={},b=0;b<arguments.length;b++){var c=arguments[b];for(var e in c)d.call(c,e)&&(a[e]=c[e])}return a}b.exports=e;var d=Object.prototype.hasOwnProperty},{}],62:[function(a,b,c){"use strict";function d(a){return a&&a.__esModule?a:{default:a}}function e(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function f(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var g=a("./button.js"),h=d(g),i=a("./component.js"),j=d(i),k=function(a){function b(c,d){e(this,b),a.call(this,c,d)}return f(b,a),b.prototype.buildCSSClass=function(){return"vjs-big-play-button"},b.prototype.handleClick=function(){this.player_.play()},b}(h.default);k.prototype.controlText_="Play Video",j.default.registerComponent("BigPlayButton",k),c.default=k,b.exports=c.default},{"./button.js":63,"./component.js":66}],63:[function(a,b,c){"use strict";function d(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function e(a){return a&&a.__esModule?a:{default:a}}function f(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function g(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var h=a("./clickable-component.js"),i=e(h),j=a("./component"),k=e(j),l=a("./utils/events.js"),n=(d(l),a("./utils/fn.js")),p=(d(n),a("./utils/log.js")),q=e(p),r=a("global/document"),t=(e(r),a("object.assign")),u=e(t),v=function(a){function b(c,d){f(this,b),a.call(this,c,d)}return g(b,a),b.prototype.createEl=function(){var b=arguments.length<=0||void 0===arguments[0]?"button":arguments[0],c=arguments.length<=1||void 0===arguments[1]?{}:arguments[1],d=arguments.length<=2||void 0===arguments[2]?{}:arguments[2];c=u.default({className:this.buildCSSClass()},c),"button"!==b&&q.default.warn("Creating a Button with an HTML element of "+b+" is deprecated; use ClickableComponent instead."),d=u.default({type:"button","aria-live":"polite"},d);var e=k.default.prototype.createEl.call(this,b,c,d);return this.createControlTextEl(e),e},b.prototype.addChild=function(b){var c=arguments.length<=1||void 0===arguments[1]?{}:arguments[1],d=this.constructor.name;return q.default.warn("Adding an actionable (user controllable) child to a Button ("+d+") is not supported; use a ClickableComponent instead."),k.default.prototype.addChild.call(this,b,c)},b.prototype.handleKeyPress=function(c){32===c.which||13===c.which||a.prototype.handleKeyPress.call(this,c)},b}(i.default);k.default.registerComponent("Button",v),c.default=v,b.exports=c.default},{"./clickable-component.js":64,"./component":66,"./utils/events.js":132,"./utils/fn.js":133,"./utils/log.js":136,"global/document":1,"object.assign":45}],64:[function(a,b,c){"use strict";function d(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function e(a){return a&&a.__esModule?a:{default:a}}function f(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function g(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var h=a("./component"),i=e(h),j=a("./utils/dom.js"),k=d(j),l=a("./utils/events.js"),m=d(l),n=a("./utils/fn.js"),o=d(n),p=a("./utils/log.js"),q=e(p),r=a("global/document"),s=e(r),t=a("object.assign"),u=e(t),v=function(a){function b(c,d){f(this,b),a.call(this,c,d),this.emitTapEvents(),this.on("tap",this.handleClick),this.on("click",this.handleClick),this.on("focus",this.handleFocus),this.on("blur",this.handleBlur)}return g(b,a),b.prototype.createEl=function(){var c=arguments.length<=0||void 0===arguments[0]?"div":arguments[0],d=arguments.length<=1||void 0===arguments[1]?{}:arguments[1],e=arguments.length<=2||void 0===arguments[2]?{}:arguments[2];d=u.default({className:this.buildCSSClass(),tabIndex:0},d),"button"===c&&q.default.error("Creating a ClickableComponent with an HTML element of "+c+" is not supported; use a Button instead."),e=u.default({role:"button","aria-live":"polite"},e);var f=a.prototype.createEl.call(this,c,d,e);return this.createControlTextEl(f),f},b.prototype.createControlTextEl=function(b){return this.controlTextEl_=k.createEl("span",{className:"vjs-control-text"}),b&&b.appendChild(this.controlTextEl_),this.controlText(this.controlText_),this.controlTextEl_},b.prototype.controlText=function(b){return b?(this.controlText_=b,this.controlTextEl_.innerHTML=this.localize(this.controlText_),this):this.controlText_||"Need Text"},b.prototype.buildCSSClass=function(){return"vjs-control vjs-button "+a.prototype.buildCSSClass.call(this)},b.prototype.addChild=function(c){var d=arguments.length<=1||void 0===arguments[1]?{}:arguments[1];return a.prototype.addChild.call(this,c,d)},b.prototype.handleClick=function(){},b.prototype.handleFocus=function(){m.on(s.default,"keydown",o.bind(this,this.handleKeyPress))},b.prototype.handleKeyPress=function(c){32===c.which||13===c.which?(c.preventDefault(),this.handleClick(c)):a.prototype.handleKeyPress&&a.prototype.handleKeyPress.call(this,c)},b.prototype.handleBlur=function(){m.off(s.default,"keydown",o.bind(this,this.handleKeyPress))},b}(i.default);i.default.registerComponent("ClickableComponent",v),c.default=v,b.exports=c.default},{"./component":66,"./utils/dom.js":131,"./utils/events.js":132,"./utils/fn.js":133,"./utils/log.js":136,"global/document":1,"object.assign":45}],65:[function(a,b,c){"use strict";function d(a){return a&&a.__esModule?a:{default:a}}function e(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function f(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);
a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var g=a("./button"),h=d(g),i=a("./component"),j=d(i),k=function(a){function b(c,d){e(this,b),a.call(this,c,d),this.controlText(d&&d.controlText||this.localize("Close"))}return f(b,a),b.prototype.buildCSSClass=function(){return"vjs-close-button "+a.prototype.buildCSSClass.call(this)},b.prototype.handleClick=function(){this.trigger({type:"close",bubbles:!1})},b}(h.default);j.default.registerComponent("CloseButton",k),c.default=k,b.exports=c.default},{"./button":63,"./component":66}],66:[function(a,b,c){"use strict";function d(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function e(a){return a&&a.__esModule?a:{default:a}}function f(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}c.__esModule=!0;var g=a("global/window"),h=e(g),i=a("./utils/dom.js"),j=d(i),k=a("./utils/fn.js"),l=d(k),m=a("./utils/guid.js"),n=d(m),o=a("./utils/events.js"),p=d(o),q=a("./utils/log.js"),r=e(q),s=a("./utils/to-title-case.js"),t=e(s),u=a("object.assign"),v=e(u),w=a("./utils/merge-options.js"),x=e(w),y=function(){function a(b,c,d){if(f(this,a),!b&&this.play?this.player_=b=this:this.player_=b,this.options_=x.default({},this.options_),c=this.options_=x.default(this.options_,c),this.id_=c.id||c.el&&c.el.id,!this.id_){var e=b&&b.id&&b.id()||"no_player";this.id_=e+"_component_"+n.newGUID()}this.name_=c.name||null,c.el?this.el_=c.el:c.createEl!==!1&&(this.el_=this.createEl()),this.children_=[],this.childIndex_={},this.childNameIndex_={},c.initChildren!==!1&&this.initChildren(),this.ready(d),c.reportTouchActivity!==!1&&this.enableTouchActivity()}return a.prototype.dispose=function(){if(this.trigger({type:"dispose",bubbles:!1}),this.children_)for(var b=this.children_.length-1;b>=0;b--)this.children_[b].dispose&&this.children_[b].dispose();this.children_=null,this.childIndex_=null,this.childNameIndex_=null,this.off(),this.el_.parentNode&&this.el_.parentNode.removeChild(this.el_),j.removeElData(this.el_),this.el_=null},a.prototype.player=function(){return this.player_},a.prototype.options=function(b){return r.default.warn("this.options() has been deprecated and will be moved to the constructor in 6.0"),b?(this.options_=x.default(this.options_,b),this.options_):this.options_},a.prototype.el=function(){return this.el_},a.prototype.createEl=function(b,c,d){return j.createEl(b,c,d)},a.prototype.localize=function(b){var c=this.player_.language&&this.player_.language(),d=this.player_.languages&&this.player_.languages();if(!c||!d)return b;var e=d[c];if(e&&e[b])return e[b];var f=c.split("-")[0],g=d[f];return g&&g[b]?g[b]:b},a.prototype.contentEl=function(){return this.contentEl_||this.el_},a.prototype.id=function(){return this.id_},a.prototype.name=function(){return this.name_},a.prototype.children=function(){return this.children_},a.prototype.getChildById=function(b){return this.childIndex_[b]},a.prototype.getChild=function(b){return this.childNameIndex_[b]},a.prototype.addChild=function(c){var d=arguments.length<=1||void 0===arguments[1]?{}:arguments[1],e=arguments.length<=2||void 0===arguments[2]?this.children_.length:arguments[2],f=void 0,g=void 0;if("string"==typeof c){g=c,d||(d={}),d===!0&&(r.default.warn("Initializing a child component with `true` is deprecated. Children should be defined in an array when possible, but if necessary use an object instead of `true`."),d={});var h=d.componentClass||t.default(g);d.name=g;var i=a.getComponent(h);if(!i)throw new Error("Component "+h+" does not exist");if("function"!=typeof i)return null;f=new i(this.player_||this,d)}else f=c;if(this.children_.splice(e,0,f),"function"==typeof f.id&&(this.childIndex_[f.id()]=f),g=g||f.name&&f.name(),g&&(this.childNameIndex_[g]=f),"function"==typeof f.el&&f.el()){var j=this.contentEl().children,k=j[e]||null;this.contentEl().insertBefore(f.el(),k)}return f},a.prototype.removeChild=function(b){if("string"==typeof b&&(b=this.getChild(b)),b&&this.children_){for(var c=!1,d=this.children_.length-1;d>=0;d--)if(this.children_[d]===b){c=!0,this.children_.splice(d,1);break}if(c){this.childIndex_[b.id()]=null,this.childNameIndex_[b.name()]=null;var e=b.el();e&&e.parentNode===this.contentEl()&&this.contentEl().removeChild(b.el())}}},a.prototype.initChildren=function(){var c=this,d=this.options_.children;d&&!function(){var b=c.options_,e=function(d){var e=d.name,f=d.opts;if(void 0!==b[e]&&(f=b[e]),f!==!1){f===!0&&(f={}),f.playerOptions=c.options_.playerOptions;var g=c.addChild(e,f);g&&(c[e]=g)}},f=void 0,g=a.getComponent("Tech");f=Array.isArray(d)?d:Object.keys(d),f.concat(Object.keys(c.options_).filter(function(a){return!f.some(function(b){return"string"==typeof b?a===b:a===b.name})})).map(function(a){var b=void 0,e=void 0;return"string"==typeof a?(b=a,e=d[b]||c.options_[b]||{}):(b=a.name,e=a),{name:b,opts:e}}).filter(function(b){var c=a.getComponent(b.opts.componentClass||t.default(b.name));return c&&!g.isTech(c)}).forEach(e)}()},a.prototype.buildCSSClass=function(){return""},a.prototype.on=function(b,c,d){var e=this;return"string"==typeof b||Array.isArray(b)?p.on(this.el_,b,l.bind(this,c)):!function(){var a=b,f=c,g=l.bind(e,d),h=function(){return e.off(a,f,g)};h.guid=g.guid,e.on("dispose",h);var i=function(){return e.off("dispose",h)};i.guid=g.guid,b.nodeName?(p.on(a,f,g),p.on(a,"dispose",i)):"function"==typeof b.on&&(a.on(f,g),a.on("dispose",i))}(),this},a.prototype.off=function(b,c,d){if(!b||"string"==typeof b||Array.isArray(b))p.off(this.el_,b,c);else{var e=b,f=c,g=l.bind(this,d);this.off("dispose",g),b.nodeName?(p.off(e,f,g),p.off(e,"dispose",g)):(e.off(f,g),e.off("dispose",g))}return this},a.prototype.one=function(b,c,d){var e=this,f=arguments;return"string"==typeof b||Array.isArray(b)?p.one(this.el_,b,l.bind(this,c)):!function(){var a=b,g=c,h=l.bind(e,d),i=function b(){e.off(a,g,b),h.apply(null,f)};i.guid=h.guid,e.on(a,g,i)}(),this},a.prototype.trigger=function(b,c){return p.trigger(this.el_,b,c),this},a.prototype.ready=function(b){var c=!(arguments.length<=1||void 0===arguments[1])&&arguments[1];return b&&(this.isReady_?c?b.call(this):this.setTimeout(b,1):(this.readyQueue_=this.readyQueue_||[],this.readyQueue_.push(b))),this},a.prototype.triggerReady=function(){this.isReady_=!0,this.setTimeout(function(){var a=this.readyQueue_;this.readyQueue_=[],a&&a.length>0&&a.forEach(function(a){a.call(this)},this),this.trigger("ready")},1)},a.prototype.$=function(b,c){return j.$(b,c||this.contentEl())},a.prototype.$$=function(b,c){return j.$$(b,c||this.contentEl())},a.prototype.hasClass=function(b){return j.hasElClass(this.el_,b)},a.prototype.addClass=function(b){return j.addElClass(this.el_,b),this},a.prototype.removeClass=function(b){return j.removeElClass(this.el_,b),this},a.prototype.toggleClass=function(b,c){return j.toggleElClass(this.el_,b,c),this},a.prototype.show=function(){return this.removeClass("vjs-hidden"),this},a.prototype.hide=function(){return this.addClass("vjs-hidden"),this},a.prototype.lockShowing=function(){return this.addClass("vjs-lock-showing"),this},a.prototype.unlockShowing=function(){return this.removeClass("vjs-lock-showing"),this},a.prototype.width=function(b,c){return this.dimension("width",b,c)},a.prototype.height=function(b,c){return this.dimension("height",b,c)},a.prototype.dimensions=function(b,c){return this.width(b,!0).height(c)},a.prototype.dimension=function(b,c,d){if(void 0!==c)return null!==c&&c===c||(c=0),(""+c).indexOf("%")!==-1||(""+c).indexOf("px")!==-1?this.el_.style[b]=c:"auto"===c?this.el_.style[b]="":this.el_.style[b]=c+"px",d||this.trigger("resize"),this;if(!this.el_)return 0;var e=this.el_.style[b],f=e.indexOf("px");return f!==-1?parseInt(e.slice(0,f),10):parseInt(this.el_["offset"+t.default(b)],10)},a.prototype.emitTapEvents=function(){var b=0,c=null,d=10,e=200,f=void 0;this.on("touchstart",function(a){1===a.touches.length&&(c=v.default({},a.touches[0]),b=(new Date).getTime(),f=!0)}),this.on("touchmove",function(a){if(a.touches.length>1)f=!1;else if(c){var b=a.touches[0].pageX-c.pageX,e=a.touches[0].pageY-c.pageY,g=Math.sqrt(b*b+e*e);g>d&&(f=!1)}});var g=function(){f=!1};this.on("touchleave",g),this.on("touchcancel",g),this.on("touchend",function(a){if(c=null,f===!0){var d=(new Date).getTime()-b;d<e&&(a.preventDefault(),this.trigger("tap"))}})},a.prototype.enableTouchActivity=function(){if(this.player()&&this.player().reportUserActivity){var b=l.bind(this.player(),this.player().reportUserActivity),c=void 0;this.on("touchstart",function(){b(),this.clearInterval(c),c=this.setInterval(b,250)});var d=function(d){b(),this.clearInterval(c)};this.on("touchmove",b),this.on("touchend",d),this.on("touchcancel",d)}},a.prototype.setTimeout=function(b,c){b=l.bind(this,b);var d=h.default.setTimeout(b,c),e=function(){this.clearTimeout(d)};return e.guid="vjs-timeout-"+d,this.on("dispose",e),d},a.prototype.clearTimeout=function(b){h.default.clearTimeout(b);var c=function(){};return c.guid="vjs-timeout-"+b,this.off("dispose",c),b},a.prototype.setInterval=function(b,c){b=l.bind(this,b);var d=h.default.setInterval(b,c),e=function(){this.clearInterval(d)};return e.guid="vjs-interval-"+d,this.on("dispose",e),d},a.prototype.clearInterval=function(b){h.default.clearInterval(b);var c=function(){};return c.guid="vjs-interval-"+b,this.off("dispose",c),b},a.registerComponent=function(c,d){return a.components_||(a.components_={}),a.components_[c]=d,d},a.getComponent=function(c){return a.components_&&a.components_[c]?a.components_[c]:h.default&&h.default.videojs&&h.default.videojs[c]?(r.default.warn("The "+c+" component was added to the videojs object when it should be registered using videojs.registerComponent(name, component)"),h.default.videojs[c]):void 0},a.extend=function(c){c=c||{},r.default.warn("Component.extend({}) has been deprecated, use videojs.extend(Component, {}) instead");var d=c.init||c.init||this.prototype.init||this.prototype.init||function(){},e=function(){d.apply(this,arguments)};e.prototype=Object.create(this.prototype),e.prototype.constructor=e,e.extend=a.extend;for(var f in c)c.hasOwnProperty(f)&&(e.prototype[f]=c[f]);return e},a}();y.registerComponent("Component",y),c.default=y,b.exports=c.default},{"./utils/dom.js":131,"./utils/events.js":132,"./utils/fn.js":133,"./utils/guid.js":135,"./utils/log.js":136,"./utils/merge-options.js":137,"./utils/to-title-case.js":140,"global/window":2,"object.assign":45}],67:[function(a,b,c){"use strict";function d(a){return a&&a.__esModule?a:{default:a}}function e(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function f(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var g=a("../component.js"),h=d(g),i=a("./play-toggle.js"),k=(d(i),a("./time-controls/current-time-display.js")),m=(d(k),a("./time-controls/duration-display.js")),o=(d(m),a("./time-controls/time-divider.js")),q=(d(o),a("./time-controls/remaining-time-display.js")),s=(d(q),a("./live-display.js")),u=(d(s),a("./progress-control/progress-control.js")),w=(d(u),a("./fullscreen-toggle.js")),y=(d(w),a("./volume-control/volume-control.js")),A=(d(y),a("./volume-menu-button.js")),C=(d(A),a("./mute-toggle.js")),E=(d(C),a("./text-track-controls/chapters-button.js")),G=(d(E),a("./text-track-controls/subtitles-button.js")),I=(d(G),a("./text-track-controls/captions-button.js")),K=(d(I),a("./playback-rate-menu/playback-rate-menu-button.js")),M=(d(K),a("./spacer-controls/custom-control-spacer.js")),O=(d(M),function(a){function b(){e(this,b),a.apply(this,arguments)}return f(b,a),b.prototype.createEl=function(){return a.prototype.createEl.call(this,"div",{className:"vjs-control-bar"},{role:"group"})},b}(h.default));O.prototype.options_={loadEvent:"play",children:["playToggle","volumeMenuButton","currentTimeDisplay","timeDivider","durationDisplay","progressControl","liveDisplay","remainingTimeDisplay","customControlSpacer","playbackRateMenuButton","chaptersButton","subtitlesButton","captionsButton","fullscreenToggle"]},h.default.registerComponent("ControlBar",O),c.default=O,b.exports=c.default},{"../component.js":66,"./fullscreen-toggle.js":68,"./live-display.js":69,"./mute-toggle.js":70,"./play-toggle.js":71,"./playback-rate-menu/playback-rate-menu-button.js":72,"./progress-control/progress-control.js":77,"./spacer-controls/custom-control-spacer.js":79,"./text-track-controls/captions-button.js":82,"./text-track-controls/chapters-button.js":83,"./text-track-controls/subtitles-button.js":86,"./time-controls/current-time-display.js":89,"./time-controls/duration-display.js":90,"./time-controls/remaining-time-display.js":91,"./time-controls/time-divider.js":92,"./volume-control/volume-control.js":94,"./volume-menu-button.js":96}],68:[function(a,b,c){"use strict";function d(a){return a&&a.__esModule?a:{default:a}}function e(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function f(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var g=a("../button.js"),h=d(g),i=a("../component.js"),j=d(i),k=function(a){function b(){e(this,b),a.apply(this,arguments)}return f(b,a),b.prototype.buildCSSClass=function(){return"vjs-fullscreen-control "+a.prototype.buildCSSClass.call(this)},b.prototype.handleClick=function(){this.player_.isFullscreen()?(this.player_.exitFullscreen(),this.controlText("Fullscreen")):(this.player_.requestFullscreen(),this.controlText("Non-Fullscreen"))},b}(h.default);k.prototype.controlText_="Fullscreen",j.default.registerComponent("FullscreenToggle",k),c.default=k,b.exports=c.default},{"../button.js":63,"../component.js":66}],69:[function(a,b,c){"use strict";function d(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function e(a){return a&&a.__esModule?a:{default:a}}function f(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function g(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var h=a("../component"),i=e(h),j=a("../utils/dom.js"),k=d(j),l=function(a){function b(c,d){f(this,b),a.call(this,c,d),this.updateShowing(),this.on(this.player(),"durationchange",this.updateShowing)}return g(b,a),b.prototype.createEl=function(){var c=a.prototype.createEl.call(this,"div",{className:"vjs-live-control vjs-control"});return this.contentEl_=k.createEl("div",{className:"vjs-live-display",innerHTML:'<span class="vjs-control-text">'+this.localize("Stream Type")+"</span>"+this.localize("LIVE")},{"aria-live":"off"}),c.appendChild(this.contentEl_),c},b.prototype.updateShowing=function(){this.player().duration()===1/0?this.show():this.hide()},b}(i.default);i.default.registerComponent("LiveDisplay",l),c.default=l,b.exports=c.default},{"../component":66,"../utils/dom.js":131}],70:[function(a,b,c){"use strict";function d(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function e(a){return a&&a.__esModule?a:{default:a}}function f(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function g(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var h=a("../button"),i=e(h),j=a("../component"),k=e(j),l=a("../utils/dom.js"),m=d(l),n=function(a){function b(c,d){f(this,b),a.call(this,c,d),this.on(c,"volumechange",this.update),c.tech_&&c.tech_.featuresVolumeControl===!1&&this.addClass("vjs-hidden"),this.on(c,"loadstart",function(){this.update(),c.tech_.featuresVolumeControl===!1?this.addClass("vjs-hidden"):this.removeClass("vjs-hidden")})}return g(b,a),b.prototype.buildCSSClass=function(){return"vjs-mute-control "+a.prototype.buildCSSClass.call(this)},b.prototype.handleClick=function(){this.player_.muted(!this.player_.muted())},b.prototype.update=function(){var b=this.player_.volume(),c=3;0===b||this.player_.muted()?c=0:b<.33?c=1:b<.67&&(c=2);var d=this.player_.muted()?"Unmute":"Mute";this.controlText()!==d&&this.controlText(d);for(var e=0;e<4;e++)m.removeElClass(this.el_,"vjs-vol-"+e);m.addElClass(this.el_,"vjs-vol-"+c)},b}(i.default);n.prototype.controlText_="Mute",k.default.registerComponent("MuteToggle",n),c.default=n,b.exports=c.default},{"../button":63,"../component":66,"../utils/dom.js":131}],71:[function(a,b,c){"use strict";function d(a){return a&&a.__esModule?a:{default:a}}function e(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function f(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var g=a("../button.js"),h=d(g),i=a("../component.js"),j=d(i),k=function(a){function b(c,d){e(this,b),a.call(this,c,d),this.on(c,"play",this.handlePlay),this.on(c,"pause",this.handlePause)}return f(b,a),b.prototype.buildCSSClass=function(){return"vjs-play-control "+a.prototype.buildCSSClass.call(this)},b.prototype.handleClick=function(){this.player_.paused()?this.player_.play():this.player_.pause()},b.prototype.handlePlay=function(){this.removeClass("vjs-paused"),this.addClass("vjs-playing"),this.controlText("Pause")},b.prototype.handlePause=function(){this.removeClass("vjs-playing"),this.addClass("vjs-paused"),this.controlText("Play")},b}(h.default);k.prototype.controlText_="Play",j.default.registerComponent("PlayToggle",k),c.default=k,b.exports=c.default},{"../button.js":63,"../component.js":66}],72:[function(a,b,c){"use strict";function d(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function e(a){return a&&a.__esModule?a:{default:a}}function f(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function g(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var h=a("../../menu/menu-button.js"),i=e(h),j=a("../../menu/menu.js"),k=e(j),l=a("./playback-rate-menu-item.js"),m=e(l),n=a("../../component.js"),o=e(n),p=a("../../utils/dom.js"),q=d(p),r=function(a){function b(c,d){f(this,b),a.call(this,c,d),this.updateVisibility(),this.updateLabel(),this.on(c,"loadstart",this.updateVisibility),this.on(c,"ratechange",this.updateLabel)}return g(b,a),b.prototype.createEl=function(){var c=a.prototype.createEl.call(this);return this.labelEl_=q.createEl("div",{className:"vjs-playback-rate-value",innerHTML:1}),c.appendChild(this.labelEl_),c},b.prototype.buildCSSClass=function(){return"vjs-playback-rate "+a.prototype.buildCSSClass.call(this)},b.prototype.createMenu=function(){var b=new k.default(this.player()),c=this.playbackRates();if(c)for(var d=c.length-1;d>=0;d--)b.addChild(new m.default(this.player(),{rate:c[d]+"x"}));return b},b.prototype.updateARIAAttributes=function(){this.el().setAttribute("aria-valuenow",this.player().playbackRate())},b.prototype.handleClick=function(){for(var b=this.player().playbackRate(),c=this.playbackRates(),d=c[0],e=0;e<c.length;e++)if(c[e]>b){d=c[e];break}this.player().playbackRate(d)},b.prototype.playbackRates=function(){return this.options_.playbackRates||this.options_.playerOptions&&this.options_.playerOptions.playbackRates},b.prototype.playbackRateSupported=function(){return this.player().tech_&&this.player().tech_.featuresPlaybackRate&&this.playbackRates()&&this.playbackRates().length>0},b.prototype.updateVisibility=function(){this.playbackRateSupported()?this.removeClass("vjs-hidden"):this.addClass("vjs-hidden")},b.prototype.updateLabel=function(){this.playbackRateSupported()&&(this.labelEl_.innerHTML=this.player().playbackRate()+"x")},b}(i.default);r.prototype.controlText_="Playback Rate",o.default.registerComponent("PlaybackRateMenuButton",r),c.default=r,b.exports=c.default},{"../../component.js":66,"../../menu/menu-button.js":103,"../../menu/menu.js":105,"../../utils/dom.js":131,"./playback-rate-menu-item.js":73}],73:[function(a,b,c){"use strict";function d(a){return a&&a.__esModule?a:{default:a}}function e(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function f(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var g=a("../../menu/menu-item.js"),h=d(g),i=a("../../component.js"),j=d(i),k=function(a){function b(c,d){e(this,b);var f=d.rate,g=parseFloat(f,10);d.label=f,d.selected=1===g,a.call(this,c,d),this.label=f,this.rate=g,this.on(c,"ratechange",this.update)}return f(b,a),b.prototype.handleClick=function(){a.prototype.handleClick.call(this),this.player().playbackRate(this.rate)},b.prototype.update=function(){this.selected(this.player().playbackRate()===this.rate)},b}(h.default);k.prototype.contentElType="button",j.default.registerComponent("PlaybackRateMenuItem",k),c.default=k,b.exports=c.default},{"../../component.js":66,"../../menu/menu-item.js":104}],74:[function(a,b,c){"use strict";function d(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function e(a){return a&&a.__esModule?a:{default:a}}function f(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function g(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var h=a("../../component.js"),i=e(h),j=a("../../utils/dom.js"),k=d(j),l=function(a){function b(c,d){f(this,b),a.call(this,c,d),this.on(c,"progress",this.update)}return g(b,a),b.prototype.createEl=function(){return a.prototype.createEl.call(this,"div",{className:"vjs-load-progress",innerHTML:'<span class="vjs-control-text"><span>'+this.localize("Loaded")+"</span>: 0%</span>"})},b.prototype.update=function(){var b=this.player_.buffered(),c=this.player_.duration(),d=this.player_.bufferedEnd(),e=this.el_.children,f=function(b,c){var d=b/c||0;return 100*(d>=1?1:d)+"%"};this.el_.style.width=f(d,c);for(var g=0;g<b.length;g++){var h=b.start(g),i=b.end(g),j=e[g];j||(j=this.el_.appendChild(k.createEl())),j.style.left=f(h,d),j.style.width=f(i-h,d)}for(var g=e.length;g>b.length;g--)this.el_.removeChild(e[g-1])},b}(i.default);i.default.registerComponent("LoadProgressBar",l),c.default=l,b.exports=c.default},{"../../component.js":66,"../../utils/dom.js":131}],75:[function(a,b,c){"use strict";function d(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function e(a){return a&&a.__esModule?a:{default:a}}function f(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function g(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var h=a("../../component.js"),i=e(h),j=a("../../utils/dom.js"),k=d(j),l=a("../../utils/fn.js"),m=d(l),n=a("../../utils/format-time.js"),o=e(n),p=a("lodash-compat/function/throttle"),q=e(p),r=function(a){function b(c,d){var e=this;f(this,b),a.call(this,c,d),this.update(0,0),c.on("ready",function(){e.on(c.controlBar.progressControl.el(),"mousemove",q.default(m.bind(e,e.handleMouseMove),25))})}return g(b,a),b.prototype.createEl=function(){return a.prototype.createEl.call(this,"div",{className:"vjs-mouse-display"})},b.prototype.handleMouseMove=function(b){var c=this.player_.duration(),d=this.calculateDistance(b)*c,e=b.pageX-k.findElPosition(this.el().parentNode).left;this.update(d,e)},b.prototype.update=function(b,c){var d=o.default(b,this.player_.duration());this.el().style.left=c+"px",this.el().setAttribute("data-current-time",d)},b.prototype.calculateDistance=function(b){return k.getPointerPosition(this.el().parentNode,b).x},b}(i.default);i.default.registerComponent("MouseTimeDisplay",r),c.default=r,b.exports=c.default},{"../../component.js":66,"../../utils/dom.js":131,"../../utils/fn.js":133,"../../utils/format-time.js":134,"lodash-compat/function/throttle":7}],76:[function(a,b,c){"use strict";function d(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function e(a){return a&&a.__esModule?a:{default:a}}function f(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function g(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var h=a("../../component.js"),i=e(h),j=a("../../utils/fn.js"),k=d(j),l=a("../../utils/format-time.js"),m=e(l),n=function(a){function b(c,d){f(this,b),a.call(this,c,d),this.updateDataAttr(),this.on(c,"timeupdate",this.updateDataAttr),c.ready(k.bind(this,this.updateDataAttr))}return g(b,a),b.prototype.createEl=function(){return a.prototype.createEl.call(this,"div",{className:"vjs-play-progress vjs-slider-bar",innerHTML:'<span class="vjs-control-text"><span>'+this.localize("Progress")+"</span>: 0%</span>"})},b.prototype.updateDataAttr=function(){var b=this.player_.scrubbing()?this.player_.getCache().currentTime:this.player_.currentTime();this.el_.setAttribute("data-current-time",m.default(b,this.player_.duration()))},b}(i.default);i.default.registerComponent("PlayProgressBar",n),c.default=n,b.exports=c.default},{"../../component.js":66,"../../utils/fn.js":133,"../../utils/format-time.js":134}],77:[function(a,b,c){"use strict";function d(a){return a&&a.__esModule?a:{default:a}}function e(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function f(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var g=a("../../component.js"),h=d(g),i=a("./seek-bar.js"),k=(d(i),a("./mouse-time-display.js")),m=(d(k),function(a){function b(){e(this,b),a.apply(this,arguments)}return f(b,a),b.prototype.createEl=function(){return a.prototype.createEl.call(this,"div",{className:"vjs-progress-control vjs-control"})},b}(h.default));m.prototype.options_={children:["seekBar"]},h.default.registerComponent("ProgressControl",m),c.default=m,b.exports=c.default},{"../../component.js":66,"./mouse-time-display.js":75,"./seek-bar.js":78}],78:[function(a,b,c){"use strict";function d(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function e(a){return a&&a.__esModule?a:{default:a}}function f(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function g(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var h=a("../../slider/slider.js"),i=e(h),j=a("../../component.js"),k=e(j),l=a("./load-progress-bar.js"),n=(e(l),a("./play-progress-bar.js")),p=(e(n),a("../../utils/fn.js")),q=d(p),r=a("../../utils/format-time.js"),s=e(r),t=a("object.assign"),v=(e(t),function(a){function b(c,d){f(this,b),a.call(this,c,d),this.on(c,"timeupdate",this.updateARIAAttributes),c.ready(q.bind(this,this.updateARIAAttributes))}return g(b,a),b.prototype.createEl=function(){return a.prototype.createEl.call(this,"div",{className:"vjs-progress-holder"},{"aria-label":"video progress bar"})},b.prototype.updateARIAAttributes=function(){var b=this.player_.scrubbing()?this.player_.getCache().currentTime:this.player_.currentTime();this.el_.setAttribute("aria-valuenow",(100*this.getPercent()).toFixed(2)),this.el_.setAttribute("aria-valuetext",s.default(b,this.player_.duration()))},b.prototype.getPercent=function(){var b=this.player_.currentTime()/this.player_.duration();return b>=1?1:b},b.prototype.handleMouseDown=function(c){a.prototype.handleMouseDown.call(this,c),this.player_.scrubbing(!0),this.videoWasPlaying=!this.player_.paused(),this.player_.pause()},b.prototype.handleMouseMove=function(b){var c=this.calculateDistance(b)*this.player_.duration();c===this.player_.duration()&&(c-=.1),this.player_.currentTime(c)},b.prototype.handleMouseUp=function(c){a.prototype.handleMouseUp.call(this,c),this.player_.scrubbing(!1),this.videoWasPlaying&&this.player_.play()},b.prototype.stepForward=function(){this.player_.currentTime(this.player_.currentTime()+5)},b.prototype.stepBack=function(){this.player_.currentTime(this.player_.currentTime()-5)},b}(i.default));v.prototype.options_={children:["loadProgressBar","mouseTimeDisplay","playProgressBar"],barName:"playProgressBar"},v.prototype.playerEvent="timeupdate",k.default.registerComponent("SeekBar",v),c.default=v,b.exports=c.default},{"../../component.js":66,"../../slider/slider.js":113,"../../utils/fn.js":133,"../../utils/format-time.js":134,"./load-progress-bar.js":74,"./play-progress-bar.js":76,"object.assign":45}],79:[function(a,b,c){"use strict";function d(a){return a&&a.__esModule?a:{default:a}}function e(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function f(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var g=a("./spacer.js"),h=d(g),i=a("../../component.js"),j=d(i),k=function(a){function b(){e(this,b),a.apply(this,arguments);
}return f(b,a),b.prototype.buildCSSClass=function(){return"vjs-custom-control-spacer "+a.prototype.buildCSSClass.call(this)},b.prototype.createEl=function(){var c=a.prototype.createEl.call(this,{className:this.buildCSSClass()});return c.innerHTML="&nbsp;",c},b}(h.default);j.default.registerComponent("CustomControlSpacer",k),c.default=k,b.exports=c.default},{"../../component.js":66,"./spacer.js":80}],80:[function(a,b,c){"use strict";function d(a){return a&&a.__esModule?a:{default:a}}function e(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function f(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var g=a("../../component.js"),h=d(g),i=function(a){function b(){e(this,b),a.apply(this,arguments)}return f(b,a),b.prototype.buildCSSClass=function(){return"vjs-spacer "+a.prototype.buildCSSClass.call(this)},b.prototype.createEl=function(){return a.prototype.createEl.call(this,"div",{className:this.buildCSSClass()})},b}(h.default);h.default.registerComponent("Spacer",i),c.default=i,b.exports=c.default},{"../../component.js":66}],81:[function(a,b,c){"use strict";function d(a){return a&&a.__esModule?a:{default:a}}function e(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function f(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var g=a("./text-track-menu-item.js"),h=d(g),i=a("../../component.js"),j=d(i),k=function(a){function b(c,d){e(this,b),d.track={kind:d.kind,player:c,label:d.kind+" settings",selectable:!1,default:!1,mode:"disabled"},d.selectable=!1,a.call(this,c,d),this.addClass("vjs-texttrack-settings"),this.controlText(", opens "+d.kind+" settings dialog")}return f(b,a),b.prototype.handleClick=function(){this.player().getChild("textTrackSettings").show(),this.player().getChild("textTrackSettings").el_.focus()},b}(h.default);j.default.registerComponent("CaptionSettingsMenuItem",k),c.default=k,b.exports=c.default},{"../../component.js":66,"./text-track-menu-item.js":88}],82:[function(a,b,c){"use strict";function d(a){return a&&a.__esModule?a:{default:a}}function e(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function f(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var g=a("./text-track-button.js"),h=d(g),i=a("../../component.js"),j=d(i),k=a("./caption-settings-menu-item.js"),l=d(k),m=function(a){function b(c,d,f){e(this,b),a.call(this,c,d,f),this.el_.setAttribute("aria-label","Captions Menu")}return f(b,a),b.prototype.buildCSSClass=function(){return"vjs-captions-button "+a.prototype.buildCSSClass.call(this)},b.prototype.update=function(){var c=2;a.prototype.update.call(this),this.player().tech_&&this.player().tech_.featuresNativeTextTracks&&(c=1),this.items&&this.items.length>c?this.show():this.hide()},b.prototype.createItems=function(){var c=[];return this.player().tech_&&this.player().tech_.featuresNativeTextTracks||c.push(new l.default(this.player_,{kind:this.kind_})),a.prototype.createItems.call(this,c)},b}(h.default);m.prototype.kind_="captions",m.prototype.controlText_="Captions",j.default.registerComponent("CaptionsButton",m),c.default=m,b.exports=c.default},{"../../component.js":66,"./caption-settings-menu-item.js":81,"./text-track-button.js":87}],83:[function(a,b,c){"use strict";function d(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function e(a){return a&&a.__esModule?a:{default:a}}function f(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function g(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var h=a("./text-track-button.js"),i=e(h),j=a("../../component.js"),k=e(j),l=a("./text-track-menu-item.js"),m=e(l),n=a("./chapters-track-menu-item.js"),o=e(n),p=a("../../menu/menu.js"),q=e(p),r=a("../../utils/dom.js"),s=d(r),t=a("../../utils/fn.js"),v=(d(t),a("../../utils/to-title-case.js")),w=e(v),x=a("global/window"),z=(e(x),function(a){function b(c,d,e){f(this,b),a.call(this,c,d,e),this.el_.setAttribute("aria-label","Chapters Menu")}return g(b,a),b.prototype.buildCSSClass=function(){return"vjs-chapters-button "+a.prototype.buildCSSClass.call(this)},b.prototype.createItems=function(){var b=[],c=this.player_.textTracks();if(!c)return b;for(var d=0;d<c.length;d++){var e=c[d];e.kind===this.kind_&&b.push(new m.default(this.player_,{track:e}))}return b},b.prototype.createMenu=function(){for(var b=this,c=this.player_.textTracks()||[],d=void 0,e=this.items=[],f=0,g=c.length;f<g;f++){var h=c[f];if(h.kind===this.kind_){d=h;break}}var i=this.menu;if(void 0===i&&(i=new q.default(this.player_),i.contentEl().appendChild(s.createEl("li",{className:"vjs-menu-title",innerHTML:w.default(this.kind_),tabIndex:-1}))),d&&null==d.cues){d.mode="hidden";var j=this.player_.remoteTextTrackEls().getTrackElementByTrack_(d);j&&j.addEventListener("load",function(a){return b.update()})}if(d&&d.cues&&d.cues.length>0){for(var k=d.cues,l=void 0,f=0,m=k.length;f<m;f++){l=k[f];var n=new o.default(this.player_,{track:d,cue:l});e.push(n),i.addChild(n)}this.addChild(i)}return this.items.length>0&&this.show(),i},b}(i.default));z.prototype.kind_="chapters",z.prototype.controlText_="Chapters",k.default.registerComponent("ChaptersButton",z),c.default=z,b.exports=c.default},{"../../component.js":66,"../../menu/menu.js":105,"../../utils/dom.js":131,"../../utils/fn.js":133,"../../utils/to-title-case.js":140,"./chapters-track-menu-item.js":84,"./text-track-button.js":87,"./text-track-menu-item.js":88,"global/window":2}],84:[function(a,b,c){"use strict";function d(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function e(a){return a&&a.__esModule?a:{default:a}}function f(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function g(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var h=a("../../menu/menu-item.js"),i=e(h),j=a("../../component.js"),k=e(j),l=a("../../utils/fn.js"),m=d(l),n=function(a){function b(c,d){f(this,b);var e=d.track,g=d.cue,h=c.currentTime();d.label=g.text,d.selected=g.startTime<=h&&h<g.endTime,a.call(this,c,d),this.track=e,this.cue=g,e.addEventListener("cuechange",m.bind(this,this.update))}return g(b,a),b.prototype.handleClick=function(){a.prototype.handleClick.call(this),this.player_.currentTime(this.cue.startTime),this.update(this.cue.startTime)},b.prototype.update=function(){var b=this.cue,c=this.player_.currentTime();this.selected(b.startTime<=c&&c<b.endTime)},b}(i.default);k.default.registerComponent("ChaptersTrackMenuItem",n),c.default=n,b.exports=c.default},{"../../component.js":66,"../../menu/menu-item.js":104,"../../utils/fn.js":133}],85:[function(a,b,c){"use strict";function d(a){return a&&a.__esModule?a:{default:a}}function e(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function f(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var g=a("./text-track-menu-item.js"),h=d(g),i=a("../../component.js"),j=d(i),k=function(a){function b(c,d){e(this,b),d.track={kind:d.kind,player:c,label:d.kind+" off",default:!1,mode:"disabled"},d.selectable=!0,a.call(this,c,d),this.selected(!0)}return f(b,a),b.prototype.handleTracksChange=function(b){for(var c=this.player().textTracks(),d=!0,e=0,f=c.length;e<f;e++){var g=c[e];if(g.kind===this.track.kind&&"showing"===g.mode){d=!1;break}}this.selected(d)},b}(h.default);j.default.registerComponent("OffTextTrackMenuItem",k),c.default=k,b.exports=c.default},{"../../component.js":66,"./text-track-menu-item.js":88}],86:[function(a,b,c){"use strict";function d(a){return a&&a.__esModule?a:{default:a}}function e(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function f(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var g=a("./text-track-button.js"),h=d(g),i=a("../../component.js"),j=d(i),k=function(a){function b(c,d,f){e(this,b),a.call(this,c,d,f),this.el_.setAttribute("aria-label","Subtitles Menu")}return f(b,a),b.prototype.buildCSSClass=function(){return"vjs-subtitles-button "+a.prototype.buildCSSClass.call(this)},b}(h.default);k.prototype.kind_="subtitles",k.prototype.controlText_="Subtitles",j.default.registerComponent("SubtitlesButton",k),c.default=k,b.exports=c.default},{"../../component.js":66,"./text-track-button.js":87}],87:[function(a,b,c){"use strict";function d(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function e(a){return a&&a.__esModule?a:{default:a}}function f(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function g(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var h=a("../../menu/menu-button.js"),i=e(h),j=a("../../component.js"),k=e(j),l=a("../../utils/fn.js"),m=d(l),n=a("./text-track-menu-item.js"),o=e(n),p=a("./off-text-track-menu-item.js"),q=e(p),r=function(a){function b(c,d){f(this,b),a.call(this,c,d);var e=this.player_.textTracks();if(this.items.length<=1&&this.hide(),e){var g=m.bind(this,this.update);e.addEventListener("removetrack",g),e.addEventListener("addtrack",g),this.player_.on("dispose",function(){e.removeEventListener("removetrack",g),e.removeEventListener("addtrack",g)})}}return g(b,a),b.prototype.createItems=function(){var b=arguments.length<=0||void 0===arguments[0]?[]:arguments[0];b.push(new q.default(this.player_,{kind:this.kind_}));var c=this.player_.textTracks();if(!c)return b;for(var d=0;d<c.length;d++){var e=c[d];e.kind===this.kind_&&b.push(new o.default(this.player_,{selectable:!0,track:e}))}return b},b}(i.default);k.default.registerComponent("TextTrackButton",r),c.default=r,b.exports=c.default},{"../../component.js":66,"../../menu/menu-button.js":103,"../../utils/fn.js":133,"./off-text-track-menu-item.js":85,"./text-track-menu-item.js":88}],88:[function(a,b,c){"use strict";function d(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function e(a){return a&&a.__esModule?a:{default:a}}function f(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function g(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var h=a("../../menu/menu-item.js"),i=e(h),j=a("../../component.js"),k=e(j),l=a("../../utils/fn.js"),m=d(l),n=a("global/window"),o=e(n),p=a("global/document"),q=e(p),r=function(a){function b(c,d){var e=this;f(this,b);var g=d.track,h=c.textTracks();d.label=g.label||g.language||"Unknown",d.selected=g.default||"showing"===g.mode,a.call(this,c,d),this.track=g,h&&!function(){var a=m.bind(e,e.handleTracksChange);h.addEventListener("change",a),e.on("dispose",function(){h.removeEventListener("change",a)})}(),h&&void 0===h.onchange&&!function(){var a=void 0;e.on(["tap","click"],function(){if("object"!=typeof o.default.Event)try{a=new o.default.Event("change")}catch(a){}a||(a=q.default.createEvent("Event"),a.initEvent("change",!0,!0)),h.dispatchEvent(a)})}()}return g(b,a),b.prototype.handleClick=function(c){var d=this.track.kind,e=this.player_.textTracks();if(a.prototype.handleClick.call(this,c),e)for(var f=0;f<e.length;f++){var g=e[f];g.kind===d&&(g===this.track?g.mode="showing":g.mode="disabled")}},b.prototype.handleTracksChange=function(b){this.selected("showing"===this.track.mode)},b}(i.default);k.default.registerComponent("TextTrackMenuItem",r),c.default=r,b.exports=c.default},{"../../component.js":66,"../../menu/menu-item.js":104,"../../utils/fn.js":133,"global/document":1,"global/window":2}],89:[function(a,b,c){"use strict";function d(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function e(a){return a&&a.__esModule?a:{default:a}}function f(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function g(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var h=a("../../component.js"),i=e(h),j=a("../../utils/dom.js"),k=d(j),l=a("../../utils/format-time.js"),m=e(l),n=function(a){function b(c,d){f(this,b),a.call(this,c,d),this.on(c,"timeupdate",this.updateContent)}return g(b,a),b.prototype.createEl=function(){var c=a.prototype.createEl.call(this,"div",{className:"vjs-current-time vjs-time-control vjs-control"});return this.contentEl_=k.createEl("div",{className:"vjs-current-time-display",innerHTML:'<span class="vjs-control-text">Current Time </span>0:00'},{"aria-live":"off"}),c.appendChild(this.contentEl_),c},b.prototype.updateContent=function(){var b=this.player_.scrubbing()?this.player_.getCache().currentTime:this.player_.currentTime(),c=this.localize("Current Time"),d=m.default(b,this.player_.duration());this.contentEl_.innerHTML='<span class="vjs-control-text">'+c+"</span> "+d},b}(i.default);i.default.registerComponent("CurrentTimeDisplay",n),c.default=n,b.exports=c.default},{"../../component.js":66,"../../utils/dom.js":131,"../../utils/format-time.js":134}],90:[function(a,b,c){"use strict";function d(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function e(a){return a&&a.__esModule?a:{default:a}}function f(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function g(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var h=a("../../component.js"),i=e(h),j=a("../../utils/dom.js"),k=d(j),l=a("../../utils/format-time.js"),m=e(l),n=function(a){function b(c,d){f(this,b),a.call(this,c,d),this.on(c,"timeupdate",this.updateContent),this.on(c,"loadedmetadata",this.updateContent)}return g(b,a),b.prototype.createEl=function(){var c=a.prototype.createEl.call(this,"div",{className:"vjs-duration vjs-time-control vjs-control"});return this.contentEl_=k.createEl("div",{className:"vjs-duration-display",innerHTML:'<span class="vjs-control-text">'+this.localize("Duration Time")+"</span> 0:00"},{"aria-live":"off"}),c.appendChild(this.contentEl_),c},b.prototype.updateContent=function(){var b=this.player_.duration();if(b){var c=this.localize("Duration Time"),d=m.default(b);this.contentEl_.innerHTML='<span class="vjs-control-text">'+c+"</span> "+d}},b}(i.default);i.default.registerComponent("DurationDisplay",n),c.default=n,b.exports=c.default},{"../../component.js":66,"../../utils/dom.js":131,"../../utils/format-time.js":134}],91:[function(a,b,c){"use strict";function d(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function e(a){return a&&a.__esModule?a:{default:a}}function f(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function g(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var h=a("../../component.js"),i=e(h),j=a("../../utils/dom.js"),k=d(j),l=a("../../utils/format-time.js"),m=e(l),n=function(a){function b(c,d){f(this,b),a.call(this,c,d),this.on(c,"timeupdate",this.updateContent)}return g(b,a),b.prototype.createEl=function(){var c=a.prototype.createEl.call(this,"div",{className:"vjs-remaining-time vjs-time-control vjs-control"});return this.contentEl_=k.createEl("div",{className:"vjs-remaining-time-display",innerHTML:'<span class="vjs-control-text">'+this.localize("Remaining Time")+"</span> -0:00"},{"aria-live":"off"}),c.appendChild(this.contentEl_),c},b.prototype.updateContent=function(){if(this.player_.duration()){var b=this.localize("Remaining Time"),c=m.default(this.player_.remainingTime());this.contentEl_.innerHTML='<span class="vjs-control-text">'+b+"</span> -"+c}},b}(i.default);i.default.registerComponent("RemainingTimeDisplay",n),c.default=n,b.exports=c.default},{"../../component.js":66,"../../utils/dom.js":131,"../../utils/format-time.js":134}],92:[function(a,b,c){"use strict";function d(a){return a&&a.__esModule?a:{default:a}}function e(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function f(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var g=a("../../component.js"),h=d(g),i=function(a){function b(){e(this,b),a.apply(this,arguments)}return f(b,a),b.prototype.createEl=function(){return a.prototype.createEl.call(this,"div",{className:"vjs-time-control vjs-time-divider",innerHTML:"<div><span>/</span></div>"})},b}(h.default);h.default.registerComponent("TimeDivider",i),c.default=i,b.exports=c.default},{"../../component.js":66}],93:[function(a,b,c){"use strict";function d(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function e(a){return a&&a.__esModule?a:{default:a}}function f(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function g(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var h=a("../../slider/slider.js"),i=e(h),j=a("../../component.js"),k=e(j),l=a("../../utils/fn.js"),m=d(l),n=a("./volume-level.js"),p=(e(n),function(a){function b(c,d){f(this,b),a.call(this,c,d),this.on(c,"volumechange",this.updateARIAAttributes),c.ready(m.bind(this,this.updateARIAAttributes))}return g(b,a),b.prototype.createEl=function(){return a.prototype.createEl.call(this,"div",{className:"vjs-volume-bar vjs-slider-bar"},{"aria-label":"volume level"})},b.prototype.handleMouseMove=function(b){this.checkMuted(),this.player_.volume(this.calculateDistance(b))},b.prototype.checkMuted=function(){this.player_.muted()&&this.player_.muted(!1)},b.prototype.getPercent=function(){return this.player_.muted()?0:this.player_.volume()},b.prototype.stepForward=function(){this.checkMuted(),this.player_.volume(this.player_.volume()+.1)},b.prototype.stepBack=function(){this.checkMuted(),this.player_.volume(this.player_.volume()-.1)},b.prototype.updateARIAAttributes=function(){var b=(100*this.player_.volume()).toFixed(2);this.el_.setAttribute("aria-valuenow",b),this.el_.setAttribute("aria-valuetext",b+"%")},b}(i.default));p.prototype.options_={children:["volumeLevel"],barName:"volumeLevel"},p.prototype.playerEvent="volumechange",k.default.registerComponent("VolumeBar",p),c.default=p,b.exports=c.default},{"../../component.js":66,"../../slider/slider.js":113,"../../utils/fn.js":133,"./volume-level.js":95}],94:[function(a,b,c){"use strict";function d(a){return a&&a.__esModule?a:{default:a}}function e(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function f(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var g=a("../../component.js"),h=d(g),i=a("./volume-bar.js"),k=(d(i),function(a){function b(c,d){e(this,b),a.call(this,c,d),c.tech_&&c.tech_.featuresVolumeControl===!1&&this.addClass("vjs-hidden"),this.on(c,"loadstart",function(){c.tech_.featuresVolumeControl===!1?this.addClass("vjs-hidden"):this.removeClass("vjs-hidden")})}return f(b,a),b.prototype.createEl=function(){return a.prototype.createEl.call(this,"div",{className:"vjs-volume-control vjs-control"})},b}(h.default));k.prototype.options_={children:["volumeBar"]},h.default.registerComponent("VolumeControl",k),c.default=k,b.exports=c.default},{"../../component.js":66,"./volume-bar.js":93}],95:[function(a,b,c){"use strict";function d(a){return a&&a.__esModule?a:{default:a}}function e(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function f(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var g=a("../../component.js"),h=d(g),i=function(a){function b(){e(this,b),a.apply(this,arguments)}return f(b,a),b.prototype.createEl=function(){return a.prototype.createEl.call(this,"div",{className:"vjs-volume-level",innerHTML:'<span class="vjs-control-text"></span>'})},b}(h.default);h.default.registerComponent("VolumeLevel",i),c.default=i,b.exports=c.default},{"../../component.js":66}],96:[function(a,b,c){"use strict";function d(a){return a&&a.__esModule?a:{default:a}}function e(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function f(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function g(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var h=a("../utils/fn.js"),i=e(h),j=a("../component.js"),k=d(j),l=a("../popup/popup.js"),m=d(l),n=a("../popup/popup-button.js"),o=d(n),p=a("./mute-toggle.js"),q=d(p),r=a("./volume-control/volume-bar.js"),s=d(r),t=a("global/document"),u=d(t),v=function(a){function b(c){function e(){c.tech_&&c.tech_.featuresVolumeControl===!1?this.addClass("vjs-hidden"):this.removeClass("vjs-hidden")}var d=arguments.length<=1||void 0===arguments[1]?{}:arguments[1];f(this,b),void 0===d.inline&&(d.inline=!0),void 0===d.vertical&&(d.inline?d.vertical=!1:d.vertical=!0),d.volumeBar=d.volumeBar||{},d.volumeBar.vertical=!!d.vertical,a.call(this,c,d),this.on(c,"volumechange",this.volumeUpdate),this.on(c,"loadstart",this.volumeUpdate),e.call(this),this.on(c,"loadstart",e),this.on(this.volumeBar,["slideractive","focus"],function(){this.addClass("vjs-slider-active")}),this.on(this.volumeBar,["sliderinactive","blur"],function(){this.removeClass("vjs-slider-active")}),this.on(this.volumeBar,["focus"],function(){this.addClass("vjs-lock-showing")}),this.on(this.volumeBar,["blur"],function(){this.removeClass("vjs-lock-showing")})}return g(b,a),b.prototype.buildCSSClass=function(){var c="";return c=this.options_.vertical?"vjs-volume-menu-button-vertical":"vjs-volume-menu-button-horizontal","vjs-volume-menu-button "+a.prototype.buildCSSClass.call(this)+" "+c},b.prototype.createPopup=function(){var b=new m.default(this.player_,{contentElType:"div"}),c=new s.default(this.player_,this.options_.volumeBar);return b.addChild(c),this.volumeBar=c,this.attachVolumeBarEvents(),b},b.prototype.handleClick=function(){q.default.prototype.handleClick.call(this),a.prototype.handleClick.call(this)},b.prototype.attachVolumeBarEvents=function(){this.on(["mousedown","touchdown"],this.handleMouseDown)},b.prototype.handleMouseDown=function(b){this.on(["mousemove","touchmove"],i.bind(this.volumeBar,this.volumeBar.handleMouseMove)),this.on(u.default,["mouseup","touchend"],this.handleMouseUp)},b.prototype.handleMouseUp=function(b){this.off(["mousemove","touchmove"],i.bind(this.volumeBar,this.volumeBar.handleMouseMove))},b}(o.default);v.prototype.volumeUpdate=q.default.prototype.update,v.prototype.controlText_="Mute",k.default.registerComponent("VolumeMenuButton",v),c.default=v,b.exports=c.default},{"../component.js":66,"../popup/popup-button.js":109,"../popup/popup.js":110,"../utils/fn.js":133,"./mute-toggle.js":70,"./volume-control/volume-bar.js":93,"global/document":1}],97:[function(a,b,c){"use strict";function d(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function e(a){return a&&a.__esModule?a:{default:a}}function f(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function g(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var h=a("./component"),i=e(h),j=a("./modal-dialog"),k=e(j),l=a("./utils/dom"),n=(d(l),a("./utils/merge-options")),o=e(n),p=function(a){function b(c,d){f(this,b),a.call(this,c,d),this.on(c,"error",this.open)}return g(b,a),b.prototype.buildCSSClass=function(){return"vjs-error-display "+a.prototype.buildCSSClass.call(this)},b.prototype.content=function(){var b=this.player().error();return b?this.localize(b.message):""},b}(k.default);p.prototype.options_=o.default(k.default.prototype.options_,{fillAlways:!0,temporary:!1,uncloseable:!0}),i.default.registerComponent("ErrorDisplay",p),c.default=p,b.exports=c.default},{"./component":66,"./modal-dialog":106,"./utils/dom":131,"./utils/merge-options":137}],98:[function(a,b,c){"use strict";function d(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}c.__esModule=!0;var e=a("./utils/events.js"),f=d(e),g=function(){};g.prototype.allowedEvents_={},g.prototype.on=function(a,b){var c=this.addEventListener;this.addEventListener=Function.prototype,f.on(this,a,b),this.addEventListener=c},g.prototype.addEventListener=g.prototype.on,g.prototype.off=function(a,b){f.off(this,a,b)},g.prototype.removeEventListener=g.prototype.off,g.prototype.one=function(a,b){f.one(this,a,b)},g.prototype.trigger=function(a){var b=a.type||a;"string"==typeof a&&(a={type:b}),a=f.fixEvent(a),this.allowedEvents_[b]&&this["on"+b]&&this["on"+b](a),f.trigger(this,a)},g.prototype.dispatchEvent=g.prototype.trigger,c.default=g,b.exports=c.default},{"./utils/events.js":132}],99:[function(a,b,c){"use strict";function d(a){return a&&a.__esModule?a:{default:a}}c.__esModule=!0;var e=a("./utils/log"),f=d(e),g=function(b,c){if("function"!=typeof c&&null!==c)throw new TypeError("Super expression must either be null or a function, not "+typeof c);b.prototype=Object.create(c&&c.prototype,{constructor:{value:b,enumerable:!1,writable:!0,configurable:!0}}),c&&(b.super_=c)},h=function(b){var c=arguments.length<=1||void 0===arguments[1]?{}:arguments[1],d=function(){b.apply(this,arguments)},e={};"object"==typeof c?("function"==typeof c.init&&(f.default.warn("Constructor logic via init() is deprecated; please use constructor() instead."),c.constructor=c.init),c.constructor!==Object.prototype.constructor&&(d=c.constructor),e=c):"function"==typeof c&&(d=c),g(d,b);for(var h in e)e.hasOwnProperty(h)&&(d.prototype[h]=e[h]);return d};c.default=h,b.exports=c.default},{"./utils/log":136}],100:[function(a,b,c){"use strict";function d(a){return a&&a.__esModule?a:{default:a}}c.__esModule=!0;for(var e=a("global/document"),f=d(e),g={},h=[["requestFullscreen","exitFullscreen","fullscreenElement","fullscreenEnabled","fullscreenchange","fullscreenerror"],["webkitRequestFullscreen","webkitExitFullscreen","webkitFullscreenElement","webkitFullscreenEnabled","webkitfullscreenchange","webkitfullscreenerror"],["webkitRequestFullScreen","webkitCancelFullScreen","webkitCurrentFullScreenElement","webkitCancelFullScreen","webkitfullscreenchange","webkitfullscreenerror"],["mozRequestFullScreen","mozCancelFullScreen","mozFullScreenElement","mozFullScreenEnabled","mozfullscreenchange","mozfullscreenerror"],["msRequestFullscreen","msExitFullscreen","msFullscreenElement","msFullscreenEnabled","MSFullscreenChange","MSFullscreenError"]],i=h[0],j=void 0,k=0;k<h.length;k++)if(h[k][1]in f.default){j=h[k];break}if(j)for(var k=0;k<j.length;k++)g[i[k]]=j[k];c.default=g,b.exports=c.default},{"global/document":1}],101:[function(a,b,c){"use strict";function d(a){return a&&a.__esModule?a:{default:a}}function e(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function f(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var g=a("./component"),h=d(g),i=function(a){function b(){e(this,b),a.apply(this,arguments)}return f(b,a),b.prototype.createEl=function(){return a.prototype.createEl.call(this,"div",{
className:"vjs-loading-spinner"})},b}(h.default);h.default.registerComponent("LoadingSpinner",i),c.default=i,b.exports=c.default},{"./component":66}],102:[function(a,b,c){"use strict";function d(a){return a&&a.__esModule?a:{default:a}}c.__esModule=!0;var e=a("object.assign"),f=d(e),g=function a(b){"number"==typeof b?this.code=b:"string"==typeof b?this.message=b:"object"==typeof b&&f.default(this,b),this.message||(this.message=a.defaultMessages[this.code]||"")};g.prototype.code=0,g.prototype.message="",g.prototype.status=null,g.errorTypes=["MEDIA_ERR_CUSTOM","MEDIA_ERR_ABORTED","MEDIA_ERR_NETWORK","MEDIA_ERR_DECODE","MEDIA_ERR_SRC_NOT_SUPPORTED","MEDIA_ERR_ENCRYPTED"],g.defaultMessages={1:"You aborted the media playback",2:"A network error caused the media download to fail part-way.",3:"The media playback was aborted due to a corruption problem or because the media used features your browser did not support.",4:"The media could not be loaded, either because the server or network failed or because the format is not supported.",5:"The media is encrypted and we do not have the keys to decrypt it."};for(var h=0;h<g.errorTypes.length;h++)g[g.errorTypes[h]]=h,g.prototype[g.errorTypes[h]]=h;c.default=g,b.exports=c.default},{"object.assign":45}],103:[function(a,b,c){"use strict";function d(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function e(a){return a&&a.__esModule?a:{default:a}}function f(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function g(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var h=a("../clickable-component.js"),i=e(h),j=a("../component.js"),k=e(j),l=a("./menu.js"),m=e(l),n=a("../utils/dom.js"),o=d(n),p=a("../utils/fn.js"),q=d(p),r=a("../utils/to-title-case.js"),s=e(r),t=function(a){function b(c){var d=arguments.length<=1||void 0===arguments[1]?{}:arguments[1];f(this,b),a.call(this,c,d),this.update(),this.el_.setAttribute("aria-haspopup",!0),this.el_.setAttribute("role","menuitem"),this.on("keydown",this.handleSubmenuKeyPress)}return g(b,a),b.prototype.update=function(){var b=this.createMenu();this.menu&&this.removeChild(this.menu),this.menu=b,this.addChild(b),this.buttonPressed_=!1,this.el_.setAttribute("aria-expanded",!1),this.items&&0===this.items.length?this.hide():this.items&&this.items.length>1&&this.show()},b.prototype.createMenu=function(){var b=new m.default(this.player_);if(this.options_.title&&b.contentEl().appendChild(o.createEl("li",{className:"vjs-menu-title",innerHTML:s.default(this.options_.title),tabIndex:-1})),this.items=this.createItems(),this.items)for(var c=0;c<this.items.length;c++)b.addItem(this.items[c]);return b},b.prototype.createItems=function(){},b.prototype.createEl=function(){return a.prototype.createEl.call(this,"div",{className:this.buildCSSClass()})},b.prototype.buildCSSClass=function(){var c="vjs-menu-button";return c+=this.options_.inline===!0?"-inline":"-popup","vjs-menu-button "+c+" "+a.prototype.buildCSSClass.call(this)},b.prototype.handleClick=function(){this.one("mouseout",q.bind(this,function(){this.menu.unlockShowing(),this.el_.blur()})),this.buttonPressed_?this.unpressButton():this.pressButton()},b.prototype.handleKeyPress=function(c){27===c.which||9===c.which?(this.buttonPressed_&&this.unpressButton(),9!==c.which&&c.preventDefault()):38===c.which||40===c.which?this.buttonPressed_||(this.pressButton(),c.preventDefault()):a.prototype.handleKeyPress.call(this,c)},b.prototype.handleSubmenuKeyPress=function(b){27!==b.which&&9!==b.which||(this.buttonPressed_&&this.unpressButton(),9!==b.which&&b.preventDefault())},b.prototype.pressButton=function(){this.buttonPressed_=!0,this.menu.lockShowing(),this.el_.setAttribute("aria-expanded",!0),this.menu.focus()},b.prototype.unpressButton=function(){this.buttonPressed_=!1,this.menu.unlockShowing(),this.el_.setAttribute("aria-expanded",!1),this.el_.focus()},b}(i.default);k.default.registerComponent("MenuButton",t),c.default=t,b.exports=c.default},{"../clickable-component.js":64,"../component.js":66,"../utils/dom.js":131,"../utils/fn.js":133,"../utils/to-title-case.js":140,"./menu.js":105}],104:[function(a,b,c){"use strict";function d(a){return a&&a.__esModule?a:{default:a}}function e(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function f(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var g=a("../clickable-component.js"),h=d(g),i=a("../component.js"),j=d(i),k=a("object.assign"),l=d(k),m=function(a){function b(c,d){e(this,b),a.call(this,c,d),this.selectable=d.selectable,this.selected(d.selected),this.selectable?this.el_.setAttribute("role","menuitemcheckbox"):this.el_.setAttribute("role","menuitem")}return f(b,a),b.prototype.createEl=function(c,d,e){return a.prototype.createEl.call(this,"li",l.default({className:"vjs-menu-item",innerHTML:this.localize(this.options_.label),tabIndex:-1},d),e)},b.prototype.handleClick=function(){this.selected(!0)},b.prototype.selected=function(b){this.selectable&&(b?(this.addClass("vjs-selected"),this.el_.setAttribute("aria-checked",!0),this.controlText(", selected")):(this.removeClass("vjs-selected"),this.el_.setAttribute("aria-checked",!1),this.controlText(" ")))},b}(h.default);j.default.registerComponent("MenuItem",m),c.default=m,b.exports=c.default},{"../clickable-component.js":64,"../component.js":66,"object.assign":45}],105:[function(a,b,c){"use strict";function d(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function e(a){return a&&a.__esModule?a:{default:a}}function f(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function g(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var h=a("../component.js"),i=e(h),j=a("../utils/dom.js"),k=d(j),l=a("../utils/fn.js"),m=d(l),n=a("../utils/events.js"),o=d(n),p=function(a){function b(c,d){f(this,b),a.call(this,c,d),this.focusedChild_=-1,this.on("keydown",this.handleKeyPress)}return g(b,a),b.prototype.addItem=function(b){this.addChild(b),b.on("click",m.bind(this,function(){this.unlockShowing()}))},b.prototype.createEl=function(){var c=this.options_.contentElType||"ul";this.contentEl_=k.createEl(c,{className:"vjs-menu-content"}),this.contentEl_.setAttribute("role","menu");var d=a.prototype.createEl.call(this,"div",{append:this.contentEl_,className:"vjs-menu"});return d.setAttribute("role","presentation"),d.appendChild(this.contentEl_),o.on(d,"click",function(a){a.preventDefault(),a.stopImmediatePropagation()}),d},b.prototype.handleKeyPress=function(b){37===b.which||40===b.which?(b.preventDefault(),this.stepForward()):38!==b.which&&39!==b.which||(b.preventDefault(),this.stepBack())},b.prototype.stepForward=function(){var b=0;void 0!==this.focusedChild_&&(b=this.focusedChild_+1),this.focus(b)},b.prototype.stepBack=function(){var b=0;void 0!==this.focusedChild_&&(b=this.focusedChild_-1),this.focus(b)},b.prototype.focus=function(){var b=arguments.length<=0||void 0===arguments[0]?0:arguments[0],c=this.children();c.length>0&&(b<0?b=0:b>=c.length&&(b=c.length-1),this.focusedChild_=b,c[b].el_.focus())},b}(i.default);i.default.registerComponent("Menu",p),c.default=p,b.exports=c.default},{"../component.js":66,"../utils/dom.js":131,"../utils/events.js":132,"../utils/fn.js":133}],106:[function(a,b,c){"use strict";function d(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function e(a){return a&&a.__esModule?a:{default:a}}function f(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function g(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var h=a("global/document"),i=e(h),j=a("./utils/dom"),k=d(j),l=a("./utils/fn"),m=d(l),n=a("./utils/log"),p=(e(n),a("./component")),q=e(p),r=a("./close-button"),t=(e(r),"vjs-modal-dialog"),u=27,v=function(a){function b(c,d){f(this,b),a.call(this,c,d),this.opened_=this.hasBeenOpened_=this.hasBeenFilled_=!1,this.closeable(!this.options_.uncloseable),this.content(this.options_.content),this.contentEl_=k.createEl("div",{className:t+"-content"},{role:"document"}),this.descEl_=k.createEl("p",{className:t+"-description vjs-offscreen",id:this.el().getAttribute("aria-describedby")}),k.textContent(this.descEl_,this.description()),this.el_.appendChild(this.descEl_),this.el_.appendChild(this.contentEl_)}return g(b,a),b.prototype.createEl=function(){return a.prototype.createEl.call(this,"div",{className:this.buildCSSClass(),tabIndex:-1},{"aria-describedby":this.id()+"_description","aria-hidden":"true","aria-label":this.label(),role:"dialog"})},b.prototype.buildCSSClass=function(){return t+" vjs-hidden "+a.prototype.buildCSSClass.call(this)},b.prototype.handleKeyPress=function(b){b.which===u&&this.closeable()&&this.close()},b.prototype.label=function(){return this.options_.label||this.localize("Modal Window")},b.prototype.description=function(){var b=this.options_.description||this.localize("This is a modal window.");return this.closeable()&&(b+=" "+this.localize("This modal can be closed by pressing the Escape key or activating the close button.")),b},b.prototype.open=function(){if(!this.opened_){var b=this.player();this.trigger("beforemodalopen"),this.opened_=!0,(this.options_.fillAlways||!this.hasBeenOpened_&&!this.hasBeenFilled_)&&this.fill(),this.wasPlaying_=!b.paused(),this.wasPlaying_&&b.pause(),this.closeable()&&this.on(i.default,"keydown",m.bind(this,this.handleKeyPress)),b.controls(!1),this.show(),this.el().setAttribute("aria-hidden","false"),this.trigger("modalopen"),this.hasBeenOpened_=!0}return this},b.prototype.opened=function(b){return"boolean"==typeof b&&this[b?"open":"close"](),this.opened_},b.prototype.close=function(){if(this.opened_){var b=this.player();this.trigger("beforemodalclose"),this.opened_=!1,this.wasPlaying_&&b.play(),this.closeable()&&this.off(i.default,"keydown",m.bind(this,this.handleKeyPress)),b.controls(!0),this.hide(),this.el().setAttribute("aria-hidden","true"),this.trigger("modalclose"),this.options_.temporary&&this.dispose()}return this},b.prototype.closeable=function a(b){if("boolean"==typeof b){var a=this.closeable_=!!b,c=this.getChild("closeButton");if(a&&!c){var d=this.contentEl_;this.contentEl_=this.el_,c=this.addChild("closeButton"),this.contentEl_=d,this.on(c,"close",this.close)}!a&&c&&(this.off(c,"close",this.close),this.removeChild(c),c.dispose())}return this.closeable_},b.prototype.fill=function(){return this.fillWith(this.content())},b.prototype.fillWith=function(b){var c=this.contentEl(),d=c.parentNode,e=c.nextSibling;return this.trigger("beforemodalfill"),this.hasBeenFilled_=!0,d.removeChild(c),this.empty(),k.insertContent(c,b),this.trigger("modalfill"),e?d.insertBefore(c,e):d.appendChild(c),this},b.prototype.empty=function(){return this.trigger("beforemodalempty"),k.emptyEl(this.contentEl()),this.trigger("modalempty"),this},b.prototype.content=function(b){return"undefined"!=typeof b&&(this.content_=b),this.content_},b}(q.default);v.prototype.options_={temporary:!0},q.default.registerComponent("ModalDialog",v),c.default=v,b.exports=c.default},{"./close-button":65,"./component":66,"./utils/dom":131,"./utils/fn":133,"./utils/log":136,"global/document":1}],107:[function(a,b,c){"use strict";function d(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function e(a){return a&&a.__esModule?a:{default:a}}function f(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function g(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var h=a("./component.js"),i=e(h),j=a("global/document"),k=e(j),l=a("global/window"),m=e(l),n=a("./utils/events.js"),o=d(n),p=a("./utils/dom.js"),q=d(p),r=a("./utils/fn.js"),s=d(r),t=a("./utils/guid.js"),u=d(t),v=a("./utils/browser.js"),x=(d(v),a("./utils/log.js")),y=e(x),z=a("./utils/to-title-case.js"),A=e(z),B=a("./utils/time-ranges.js"),C=a("./utils/buffer.js"),D=a("./utils/stylesheet.js"),E=d(D),F=a("./fullscreen-api.js"),G=e(F),H=a("./media-error.js"),I=e(H),J=a("safe-json-parse/tuple"),K=e(J),L=a("object.assign"),M=e(L),N=a("./utils/merge-options.js"),O=e(N),P=a("./tracks/text-track-list-converter.js"),Q=e(P),R=a("./tech/loader.js"),T=(e(R),a("./poster-image.js")),V=(e(T),a("./tracks/text-track-display.js")),X=(e(V),a("./loading-spinner.js")),Z=(e(X),a("./big-play-button.js")),_=(e(Z),a("./control-bar/control-bar.js")),ba=(e(_),a("./error-display.js")),da=(e(ba),a("./tracks/text-track-settings.js")),fa=(e(da),a("./modal-dialog")),ga=e(fa),ha=a("./tech/tech.js"),ia=e(ha),ja=a("./tech/html5.js"),la=(e(ja),function(a){function b(c,d,e){var g=this;if(f(this,b),c.id=c.id||"vjs_video_"+u.newGUID(),d=M.default(b.getTagSettings(c),d),d.initChildren=!1,d.createEl=!1,d.reportTouchActivity=!1,a.call(this,null,d,e),!this.options_||!this.options_.techOrder||!this.options_.techOrder.length)throw new Error("No techOrder specified. Did you overwrite videojs.options instead of just changing the properties you want to override?");this.tag=c,this.tagAttributes=c&&q.getElAttributes(c),this.language(this.options_.language),d.languages?!function(){var a={};Object.getOwnPropertyNames(d.languages).forEach(function(b){a[b.toLowerCase()]=d.languages[b]}),g.languages_=a}():this.languages_=b.prototype.options_.languages,this.cache_={},this.poster_=d.poster||"",this.controls_=!!d.controls,c.controls=!1,this.scrubbing_=!1,this.el_=this.createEl();var h=O.default(this.options_);d.plugins&&!function(){var a=d.plugins;Object.getOwnPropertyNames(a).forEach(function(b){"function"==typeof this[b]?this[b](a[b]):y.default.error("Unable to find plugin:",b)},g)}(),this.options_.playerOptions=h,this.initChildren(),this.isAudio("audio"===c.nodeName.toLowerCase()),this.controls()?this.addClass("vjs-controls-enabled"):this.addClass("vjs-controls-disabled"),this.isAudio()&&this.addClass("vjs-audio"),this.flexNotSupported_()&&this.addClass("vjs-no-flex"),b.players[this.id_]=this,this.userActive(!0),this.reportUserActivity(),this.listenForUserActivity_(),this.on("fullscreenchange",this.handleFullscreenChange_),this.on("stageclick",this.handleStageClick_)}return g(b,a),b.prototype.dispose=function(){this.trigger("dispose"),this.off("dispose"),this.styleEl_&&this.styleEl_.parentNode&&this.styleEl_.parentNode.removeChild(this.styleEl_),b.players[this.id_]=null,this.tag&&this.tag.player&&(this.tag.player=null),this.el_&&this.el_.player&&(this.el_.player=null),this.tech_&&this.tech_.dispose(),a.prototype.dispose.call(this)},b.prototype.createEl=function(){var c=this.el_=a.prototype.createEl.call(this,"div"),d=this.tag;d.removeAttribute("width"),d.removeAttribute("height");var e=q.getElAttributes(d);Object.getOwnPropertyNames(e).forEach(function(a){"class"===a?c.className=e[a]:c.setAttribute(a,e[a])}),d.playerId=d.id,d.id+="_html5_api",d.className="vjs-tech",d.player=c.player=this,this.addClass("vjs-paused"),this.styleEl_=E.createStyleElement("vjs-styles-dimensions");var f=q.$(".vjs-styles-defaults"),g=q.$("head");return g.insertBefore(this.styleEl_,f?f.nextSibling:g.firstChild),this.width(this.options_.width),this.height(this.options_.height),this.fluid(this.options_.fluid),this.aspectRatio(this.options_.aspectRatio),d.initNetworkState_=d.networkState,d.parentNode&&d.parentNode.insertBefore(c,d),q.insertElFirst(d,c),this.children_.unshift(d),this.el_=c,c},b.prototype.width=function(b){return this.dimension("width",b)},b.prototype.height=function(b){return this.dimension("height",b)},b.prototype.dimension=function(b,c){var d=b+"_";if(void 0===c)return this[d]||0;if(""===c)this[d]=void 0;else{var e=parseFloat(c);if(isNaN(e))return y.default.error('Improper value "'+c+'" supplied for for '+b),this;this[d]=e}return this.updateStyleEl_(),this},b.prototype.fluid=function(b){return void 0===b?!!this.fluid_:(this.fluid_=!!b,void(b?this.addClass("vjs-fluid"):this.removeClass("vjs-fluid")))},b.prototype.aspectRatio=function(b){if(void 0===b)return this.aspectRatio_;if(!/^\d+\:\d+$/.test(b))throw new Error("Improper value supplied for aspect ratio. The format should be width:height, for example 16:9.");this.aspectRatio_=b,this.fluid(!0),this.updateStyleEl_()},b.prototype.updateStyleEl_=function(){var b=void 0,c=void 0,d=void 0,e=void 0;d=void 0!==this.aspectRatio_&&"auto"!==this.aspectRatio_?this.aspectRatio_:this.videoWidth()?this.videoWidth()+":"+this.videoHeight():"16:9";var f=d.split(":"),g=f[1]/f[0];b=void 0!==this.width_?this.width_:void 0!==this.height_?this.height_/g:this.videoWidth()||300,c=void 0!==this.height_?this.height_:b*g,e=/^[^a-zA-Z]/.test(this.id())?"dimensions-"+this.id():this.id()+"-dimensions",this.addClass(e),E.setTextContent(this.styleEl_,"\n      ."+e+" {\n        width: "+b+"px;\n        height: "+c+"px;\n      }\n\n      ."+e+".vjs-fluid {\n        padding-top: "+100*g+"%;\n      }\n    ")},b.prototype.loadTech_=function(b,c){this.tech_&&this.unloadTech_(),"Html5"!==b&&this.tag&&(ia.default.getTech("Html5").disposeMediaElement(this.tag),this.tag.player=null,this.tag=null),this.techName_=b,this.isReady_=!1;var d=M.default({nativeControlsForTouch:this.options_.nativeControlsForTouch,source:c,playerId:this.id(),techId:this.id()+"_"+b+"_api",textTracks:this.textTracks_,autoplay:this.options_.autoplay,preload:this.options_.preload,loop:this.options_.loop,muted:this.options_.muted,poster:this.poster(),language:this.language(),"vtt.js":this.options_["vtt.js"]},this.options_[b.toLowerCase()]);this.tag&&(d.tag=this.tag),c&&(this.currentType_=c.type,c.src===this.cache_.src&&this.cache_.currentTime>0&&(d.startTime=this.cache_.currentTime),this.cache_.src=c.src);var e=ia.default.getTech(b);e||(e=i.default.getComponent(b)),this.tech_=new e(d),this.tech_.ready(s.bind(this,this.handleTechReady_),!0),Q.default.jsonToTextTracks(this.textTracksJson_||[],this.tech_),this.on(this.tech_,"loadstart",this.handleTechLoadStart_),this.on(this.tech_,"waiting",this.handleTechWaiting_),this.on(this.tech_,"canplay",this.handleTechCanPlay_),this.on(this.tech_,"canplaythrough",this.handleTechCanPlayThrough_),this.on(this.tech_,"playing",this.handleTechPlaying_),this.on(this.tech_,"ended",this.handleTechEnded_),this.on(this.tech_,"seeking",this.handleTechSeeking_),this.on(this.tech_,"seeked",this.handleTechSeeked_),this.on(this.tech_,"play",this.handleTechPlay_),this.on(this.tech_,"firstplay",this.handleTechFirstPlay_),this.on(this.tech_,"pause",this.handleTechPause_),this.on(this.tech_,"progress",this.handleTechProgress_),this.on(this.tech_,"durationchange",this.handleTechDurationChange_),this.on(this.tech_,"fullscreenchange",this.handleTechFullscreenChange_),this.on(this.tech_,"error",this.handleTechError_),this.on(this.tech_,"suspend",this.handleTechSuspend_),this.on(this.tech_,"abort",this.handleTechAbort_),this.on(this.tech_,"emptied",this.handleTechEmptied_),this.on(this.tech_,"stalled",this.handleTechStalled_),this.on(this.tech_,"loadedmetadata",this.handleTechLoadedMetaData_),this.on(this.tech_,"loadeddata",this.handleTechLoadedData_),this.on(this.tech_,"timeupdate",this.handleTechTimeUpdate_),this.on(this.tech_,"ratechange",this.handleTechRateChange_),this.on(this.tech_,"volumechange",this.handleTechVolumeChange_),this.on(this.tech_,"texttrackchange",this.handleTechTextTrackChange_),this.on(this.tech_,"loadedmetadata",this.updateStyleEl_),this.on(this.tech_,"posterchange",this.handleTechPosterChange_),this.usingNativeControls(this.techGet_("controls")),this.controls()&&!this.usingNativeControls()&&this.addTechControlsListeners_(),this.tech_.el().parentNode===this.el()||"Html5"===b&&this.tag||q.insertElFirst(this.tech_.el(),this.el()),this.tag&&(this.tag.player=null,this.tag=null)},b.prototype.unloadTech_=function(){this.textTracks_=this.textTracks(),this.textTracksJson_=Q.default.textTracksToJson(this.tech_),this.isReady_=!1,this.tech_.dispose(),this.tech_=!1},b.prototype.tech=function(b){if(b&&b.IWillNotUseThisInPlugins)return this.tech_;var c="\n      Please make sure that you are not using this inside of a plugin.\n      To disable this alert and error, please pass in an object with\n      `IWillNotUseThisInPlugins` to the `tech` method. See\n      https://github.com/videojs/video.js/issues/2617 for more info.\n    ";throw m.default.alert(c),new Error(c)},b.prototype.addTechControlsListeners_=function(){this.removeTechControlsListeners_(),this.on(this.tech_,"mousedown",this.handleTechClick_),this.on(this.tech_,"touchstart",this.handleTechTouchStart_),this.on(this.tech_,"touchmove",this.handleTechTouchMove_),this.on(this.tech_,"touchend",this.handleTechTouchEnd_),this.on(this.tech_,"tap",this.handleTechTap_)},b.prototype.removeTechControlsListeners_=function(){this.off(this.tech_,"tap",this.handleTechTap_),this.off(this.tech_,"touchstart",this.handleTechTouchStart_),this.off(this.tech_,"touchmove",this.handleTechTouchMove_),this.off(this.tech_,"touchend",this.handleTechTouchEnd_),this.off(this.tech_,"mousedown",this.handleTechClick_)},b.prototype.handleTechReady_=function(){this.triggerReady(),this.cache_.volume&&this.techCall_("setVolume",this.cache_.volume),this.handleTechPosterChange_(),this.handleTechDurationChange_(),this.src()&&this.tag&&this.options_.autoplay&&this.paused()&&(delete this.tag.poster,this.play())},b.prototype.handleTechLoadStart_=function(){this.removeClass("vjs-ended"),this.error(null),this.paused()?(this.hasStarted(!1),this.trigger("loadstart")):(this.trigger("loadstart"),this.trigger("firstplay"))},b.prototype.hasStarted=function(b){return void 0!==b?(this.hasStarted_!==b&&(this.hasStarted_=b,b?(this.addClass("vjs-has-started"),this.trigger("firstplay")):this.removeClass("vjs-has-started")),this):!!this.hasStarted_},b.prototype.handleTechPlay_=function(){this.removeClass("vjs-ended"),this.removeClass("vjs-paused"),this.addClass("vjs-playing"),this.hasStarted(!0),this.trigger("play")},b.prototype.handleTechWaiting_=function(){this.addClass("vjs-waiting"),this.trigger("waiting")},b.prototype.handleTechCanPlay_=function(){this.removeClass("vjs-waiting"),this.trigger("canplay")},b.prototype.handleTechCanPlayThrough_=function(){this.removeClass("vjs-waiting"),this.trigger("canplaythrough")},b.prototype.handleTechPlaying_=function(){this.removeClass("vjs-waiting"),this.trigger("playing")},b.prototype.handleTechSeeking_=function(){this.addClass("vjs-seeking"),this.trigger("seeking")},b.prototype.handleTechSeeked_=function(){this.removeClass("vjs-seeking"),this.trigger("seeked")},b.prototype.handleTechFirstPlay_=function(){this.options_.starttime&&this.currentTime(this.options_.starttime),this.addClass("vjs-has-started"),this.trigger("firstplay")},b.prototype.handleTechPause_=function(){this.removeClass("vjs-playing"),this.addClass("vjs-paused"),this.trigger("pause")},b.prototype.handleTechProgress_=function(){this.trigger("progress")},b.prototype.handleTechEnded_=function(){this.addClass("vjs-ended"),this.options_.loop?(this.currentTime(0),this.play()):this.paused()||this.pause(),this.trigger("ended")},b.prototype.handleTechDurationChange_=function(){this.duration(this.techGet_("duration"))},b.prototype.handleTechClick_=function(b){0===b.button&&this.controls()&&(this.paused()?this.play():this.pause())},b.prototype.handleTechTap_=function(){this.userActive(!this.userActive())},b.prototype.handleTechTouchStart_=function(){this.userWasActive=this.userActive()},b.prototype.handleTechTouchMove_=function(){this.userWasActive&&this.reportUserActivity()},b.prototype.handleTechTouchEnd_=function(b){b.preventDefault()},b.prototype.handleFullscreenChange_=function(){this.isFullscreen()?this.addClass("vjs-fullscreen"):this.removeClass("vjs-fullscreen")},b.prototype.handleStageClick_=function(){this.reportUserActivity()},b.prototype.handleTechFullscreenChange_=function(b,c){c&&this.isFullscreen(c.isFullscreen),this.trigger("fullscreenchange")},b.prototype.handleTechError_=function(){var b=this.tech_.error();this.error(b&&b.code)},b.prototype.handleTechSuspend_=function(){this.trigger("suspend")},b.prototype.handleTechAbort_=function(){this.trigger("abort")},b.prototype.handleTechEmptied_=function(){this.trigger("emptied")},b.prototype.handleTechStalled_=function(){this.trigger("stalled")},b.prototype.handleTechLoadedMetaData_=function(){this.trigger("loadedmetadata")},b.prototype.handleTechLoadedData_=function(){this.trigger("loadeddata")},b.prototype.handleTechTimeUpdate_=function(){this.trigger("timeupdate")},b.prototype.handleTechRateChange_=function(){this.trigger("ratechange")},b.prototype.handleTechVolumeChange_=function(){this.trigger("volumechange")},b.prototype.handleTechTextTrackChange_=function(){this.trigger("texttrackchange")},b.prototype.getCache=function(){return this.cache_},b.prototype.techCall_=function(b,c){if(this.tech_&&!this.tech_.isReady_)this.tech_.ready(function(){this[b](c)},!0);else try{this.tech_[b](c)}catch(a){throw y.default(a),a}},b.prototype.techGet_=function(b){if(this.tech_&&this.tech_.isReady_)try{return this.tech_[b]()}catch(a){throw void 0===this.tech_[b]?y.default("Video.js: "+b+" method not defined for "+this.techName_+" playback technology.",a):"TypeError"===a.name?(y.default("Video.js: "+b+" unavailable on "+this.techName_+" playback technology element.",a),this.tech_.isReady_=!1):y.default(a),a}},b.prototype.play=function(){return this.techCall_("play"),this},b.prototype.pause=function(){return this.techCall_("pause"),this},b.prototype.paused=function(){return this.techGet_("paused")!==!1},b.prototype.scrubbing=function(b){return void 0!==b?(this.scrubbing_=!!b,b?this.addClass("vjs-scrubbing"):this.removeClass("vjs-scrubbing"),this):this.scrubbing_},b.prototype.currentTime=function(b){return void 0!==b?(this.techCall_("setCurrentTime",b),this):this.cache_.currentTime=this.techGet_("currentTime")||0},b.prototype.duration=function(b){return void 0===b?this.cache_.duration||0:(b=parseFloat(b)||0,b<0&&(b=1/0),b!==this.cache_.duration&&(this.cache_.duration=b,b===1/0?this.addClass("vjs-live"):this.removeClass("vjs-live"),this.trigger("durationchange")),this)},b.prototype.remainingTime=function(){return this.duration()-this.currentTime()},b.prototype.buffered=function a(){var a=this.techGet_("buffered");return a&&a.length||(a=B.createTimeRange(0,0)),a},b.prototype.bufferedPercent=function(){return C.bufferedPercent(this.buffered(),this.duration())},b.prototype.bufferedEnd=function(){var b=this.buffered(),c=this.duration(),d=b.end(b.length-1);return d>c&&(d=c),d},b.prototype.volume=function(b){var c=void 0;return void 0!==b?(c=Math.max(0,Math.min(1,parseFloat(b))),this.cache_.volume=c,this.techCall_("setVolume",c),this):(c=parseFloat(this.techGet_("volume")),isNaN(c)?1:c)},b.prototype.muted=function(b){return void 0!==b?(this.techCall_("setMuted",b),this):this.techGet_("muted")||!1},b.prototype.supportsFullScreen=function(){return this.techGet_("supportsFullScreen")||!1},b.prototype.isFullscreen=function(b){return void 0!==b?(this.isFullscreen_=!!b,this):!!this.isFullscreen_},b.prototype.requestFullscreen=function(){var b=G.default;return this.isFullscreen(!0),b.requestFullscreen?(o.on(k.default,b.fullscreenchange,s.bind(this,function a(c){this.isFullscreen(k.default[b.fullscreenElement]),this.isFullscreen()===!1&&o.off(k.default,b.fullscreenchange,a),this.trigger("fullscreenchange")})),this.el_[b.requestFullscreen]()):this.tech_.supportsFullScreen()?this.techCall_("enterFullScreen"):(this.enterFullWindow(),this.trigger("fullscreenchange")),this},b.prototype.exitFullscreen=function(){var b=G.default;return this.isFullscreen(!1),b.requestFullscreen?k.default[b.exitFullscreen]():this.tech_.supportsFullScreen()?this.techCall_("exitFullScreen"):(this.exitFullWindow(),this.trigger("fullscreenchange")),this},b.prototype.enterFullWindow=function(){this.isFullWindow=!0,this.docOrigOverflow=k.default.documentElement.style.overflow,o.on(k.default,"keydown",s.bind(this,this.fullWindowOnEscKey)),k.default.documentElement.style.overflow="hidden",q.addElClass(k.default.body,"vjs-full-window"),this.trigger("enterFullWindow")},b.prototype.fullWindowOnEscKey=function(b){27===b.keyCode&&(this.isFullscreen()===!0?this.exitFullscreen():this.exitFullWindow())},b.prototype.exitFullWindow=function(){this.isFullWindow=!1,o.off(k.default,"keydown",this.fullWindowOnEscKey),k.default.documentElement.style.overflow=this.docOrigOverflow,q.removeElClass(k.default.body,"vjs-full-window"),this.trigger("exitFullWindow")},b.prototype.canPlayType=function(b){for(var c=void 0,d=0,e=this.options_.techOrder;d<e.length;d++){var f=A.default(e[d]),g=ia.default.getTech(f);if(g||(g=i.default.getComponent(f)),g){if(g.isSupported()&&(c=g.canPlayType(b)))return c}else y.default.error('The "'+f+'" tech is undefined. Skipped browser support check for that tech.')}return""},b.prototype.selectSource=function(b){console.log(this.options_.techOrder);var c=this.options_.techOrder.map(A.default).map(function(a){return[a,ia.default.getTech(a)||i.default.getComponent(a)]}).filter(function(a){var b=a[0],c=a[1];return c?c.isSupported():(y.default.error('The "'+b+'" tech is undefined. Skipped browser support check for that tech.'),!1)}),d=function(b,c,d){var e=void 0;return b.some(function(a){return c.some(function(b){if(e=d(a,b))return!0})}),e},e=void 0,f=function(b){return function(a,c){return b(c,a)}},g=function(b,c){var d=b[0],e=b[1];if(e.canPlaySource(c))return{source:c,tech:d}};return e=this.options_.sourceOrder?d(b,c,f(g)):d(c,b,g),e||!1},b.prototype.src=function(b){if(void 0===b)return this.techGet_("src");var c=ia.default.getTech(this.techName_);return c||(c=i.default.getComponent(this.techName_)),Array.isArray(b)?this.sourceList_(b):"string"==typeof b?this.src({src:b}):b instanceof Object&&(b.type&&!c.canPlaySource(b)?this.sourceList_([b]):(this.cache_.src=b.src,this.currentType_=b.type||"",this.ready(function(){c.prototype.hasOwnProperty("setSource")?this.techCall_("setSource",b):this.techCall_("src",b.src),"auto"===this.options_.preload&&this.load(),this.options_.autoplay&&this.play()},!0))),this},b.prototype.sourceList_=function(b){var c=this.selectSource(b);console.log(c),c?c.tech===this.techName_?this.src(c.source):this.loadTech_(c.tech,c.source):(this.setTimeout(function(){this.error({code:4,message:this.localize(this.options_.notSupportedMessage)})},0),this.triggerReady())},b.prototype.load=function(){return this.techCall_("load"),this},b.prototype.reset=function(){return this.loadTech_(A.default(this.options_.techOrder[0]),null),this.techCall_("reset"),this},b.prototype.currentSrc=function(){return this.techGet_("currentSrc")||this.cache_.src||"";
},b.prototype.currentType=function(){return this.currentType_||""},b.prototype.preload=function(b){return void 0!==b?(this.techCall_("setPreload",b),this.options_.preload=b,this):this.techGet_("preload")},b.prototype.autoplay=function(b){return void 0!==b?(this.techCall_("setAutoplay",b),this.options_.autoplay=b,this):this.techGet_("autoplay",b)},b.prototype.loop=function(b){return void 0!==b?(this.techCall_("setLoop",b),this.options_.loop=b,this):this.techGet_("loop")},b.prototype.poster=function(b){return void 0===b?this.poster_:(b||(b=""),this.poster_=b,this.techCall_("setPoster",b),this.trigger("posterchange"),this)},b.prototype.handleTechPosterChange_=function(){!this.poster_&&this.tech_&&this.tech_.poster&&(this.poster_=this.tech_.poster()||"",this.trigger("posterchange"))},b.prototype.controls=function(b){return void 0!==b?(b=!!b,this.controls_!==b&&(this.controls_=b,this.usingNativeControls()&&this.techCall_("setControls",b),b?(this.removeClass("vjs-controls-disabled"),this.addClass("vjs-controls-enabled"),this.trigger("controlsenabled"),this.usingNativeControls()||this.addTechControlsListeners_()):(this.removeClass("vjs-controls-enabled"),this.addClass("vjs-controls-disabled"),this.trigger("controlsdisabled"),this.usingNativeControls()||this.removeTechControlsListeners_())),this):!!this.controls_},b.prototype.usingNativeControls=function(b){return void 0!==b?(b=!!b,this.usingNativeControls_!==b&&(this.usingNativeControls_=b,b?(this.addClass("vjs-using-native-controls"),this.trigger("usingnativecontrols")):(this.removeClass("vjs-using-native-controls"),this.trigger("usingcustomcontrols"))),this):!!this.usingNativeControls_},b.prototype.error=function(b){return void 0===b?this.error_||null:null===b?(this.error_=b,this.removeClass("vjs-error"),this.errorDisplay.close(),this):(b instanceof I.default?this.error_=b:this.error_=new I.default(b),this.addClass("vjs-error"),y.default.error("(CODE:"+this.error_.code+" "+I.default.errorTypes[this.error_.code]+")",this.error_.message,this.error_),this.trigger("error"),this)},b.prototype.ended=function(){return this.techGet_("ended")},b.prototype.seeking=function(){return this.techGet_("seeking")},b.prototype.seekable=function(){return this.techGet_("seekable")},b.prototype.reportUserActivity=function(b){this.userActivity_=!0},b.prototype.userActive=function(b){return void 0!==b?(b=!!b,b!==this.userActive_&&(this.userActive_=b,b?(this.userActivity_=!0,this.removeClass("vjs-user-inactive"),this.addClass("vjs-user-active"),this.trigger("useractive")):(this.userActivity_=!1,this.tech_&&this.tech_.one("mousemove",function(a){a.stopPropagation(),a.preventDefault()}),this.removeClass("vjs-user-active"),this.addClass("vjs-user-inactive"),this.trigger("userinactive"))),this):this.userActive_},b.prototype.listenForUserActivity_=function(){var b=void 0,c=void 0,d=void 0,e=s.bind(this,this.reportUserActivity),f=function(b){b.screenX===c&&b.screenY===d||(c=b.screenX,d=b.screenY,e())},g=function(){e(),this.clearInterval(b),b=this.setInterval(e,250)},h=function(c){e(),this.clearInterval(b)};this.on("mousedown",g),this.on("mousemove",f),this.on("mouseup",h),this.on("keydown",e),this.on("keyup",e);var i=void 0;this.setInterval(function(){if(this.userActivity_){this.userActivity_=!1,this.userActive(!0),this.clearTimeout(i);var a=this.options_.inactivityTimeout;a>0&&(i=this.setTimeout(function(){this.userActivity_||this.userActive(!1)},a))}},250)},b.prototype.playbackRate=function(b){return void 0!==b?(this.techCall_("setPlaybackRate",b),this):this.tech_&&this.tech_.featuresPlaybackRate?this.techGet_("playbackRate"):1},b.prototype.isAudio=function(b){return void 0!==b?(this.isAudio_=!!b,this):!!this.isAudio_},b.prototype.networkState=function(){return this.techGet_("networkState")},b.prototype.readyState=function(){return this.techGet_("readyState")},b.prototype.textTracks=function(){return this.tech_&&this.tech_.textTracks()},b.prototype.remoteTextTracks=function(){return this.tech_&&this.tech_.remoteTextTracks()},b.prototype.remoteTextTrackEls=function(){return this.tech_&&this.tech_.remoteTextTrackEls()},b.prototype.addTextTrack=function(b,c,d){return this.tech_&&this.tech_.addTextTrack(b,c,d)},b.prototype.addRemoteTextTrack=function(b){return this.tech_&&this.tech_.addRemoteTextTrack(b)},b.prototype.removeRemoteTextTrack=function(b){this.tech_&&this.tech_.removeRemoteTextTrack(b)},b.prototype.videoWidth=function(){return this.tech_&&this.tech_.videoWidth&&this.tech_.videoWidth()||0},b.prototype.videoHeight=function(){return this.tech_&&this.tech_.videoHeight&&this.tech_.videoHeight()||0},b.prototype.language=function(b){return void 0===b?this.language_:(this.language_=(""+b).toLowerCase(),this)},b.prototype.languages=function(){return O.default(b.prototype.options_.languages,this.languages_)},b.prototype.toJSON=function(){var b=O.default(this.options_),c=b.tracks;b.tracks=[];for(var d=0;d<c.length;d++){var e=c[d];e=O.default(e),e.player=void 0,b.tracks[d]=e}return b},b.prototype.createModal=function(b,c){var d=this;c=c||{},c.content=b||"";var e=new ga.default(d,c);return d.addChild(e),e.on("dispose",function(){d.removeChild(e)}),e.open()},b.getTagSettings=function(b){var c={sources:[],tracks:[]},d=q.getElAttributes(b),e=d["data-setup"];if(null!==e){var f=K.default(e||"{}"),g=f[0],h=f[1];g&&y.default.error(g),M.default(d,h)}if(M.default(c,d),b.hasChildNodes())for(var i=b.childNodes,j=0,k=i.length;j<k;j++){var l=i[j],m=l.nodeName.toLowerCase();"source"===m?c.sources.push(q.getElAttributes(l)):"track"===m&&c.tracks.push(q.getElAttributes(l))}return c},b}(i.default));la.players={};var ma=m.default.navigator;la.prototype.options_={techOrder:["html5","flash"],html5:{},flash:{},defaultVolume:0,inactivityTimeout:2e3,playbackRates:[],children:["mediaLoader","posterImage","textTrackDisplay","loadingSpinner","bigPlayButton","controlBar","errorDisplay","textTrackSettings"],language:k.default.getElementsByTagName("html")[0].getAttribute("lang")||ma.languages&&ma.languages[0]||ma.userLanguage||ma.language||"en",languages:{},notSupportedMessage:"No compatible source was found for this video."},la.prototype.handleLoadedMetaData_,la.prototype.handleLoadedData_,la.prototype.handleUserActive_,la.prototype.handleUserInactive_,la.prototype.handleTimeUpdate_,la.prototype.handleTechEnded_,la.prototype.handleVolumeChange_,la.prototype.handleError_,la.prototype.flexNotSupported_=function(){var a=k.default.createElement("i");return!("flexBasis"in a.style||"webkitFlexBasis"in a.style||"mozFlexBasis"in a.style||"msFlexBasis"in a.style||"msFlexOrder"in a.style)},i.default.registerComponent("Player",la),c.default=la,b.exports=c.default},{"./big-play-button.js":62,"./component.js":66,"./control-bar/control-bar.js":67,"./error-display.js":97,"./fullscreen-api.js":100,"./loading-spinner.js":101,"./media-error.js":102,"./modal-dialog":106,"./poster-image.js":111,"./tech/html5.js":116,"./tech/loader.js":117,"./tech/tech.js":118,"./tracks/text-track-display.js":122,"./tracks/text-track-list-converter.js":124,"./tracks/text-track-settings.js":126,"./utils/browser.js":128,"./utils/buffer.js":129,"./utils/dom.js":131,"./utils/events.js":132,"./utils/fn.js":133,"./utils/guid.js":135,"./utils/log.js":136,"./utils/merge-options.js":137,"./utils/stylesheet.js":138,"./utils/time-ranges.js":139,"./utils/to-title-case.js":140,"global/document":1,"global/window":2,"object.assign":45,"safe-json-parse/tuple":53}],108:[function(a,b,c){"use strict";function d(a){return a&&a.__esModule?a:{default:a}}c.__esModule=!0;var e=a("./player.js"),f=d(e),g=function(b,c){f.default.prototype[b]=c};c.default=g,b.exports=c.default},{"./player.js":107}],109:[function(a,b,c){"use strict";function d(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function e(a){return a&&a.__esModule?a:{default:a}}function f(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function g(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var h=a("../clickable-component.js"),i=e(h),j=a("../component.js"),k=e(j),l=a("./popup.js"),n=(e(l),a("../utils/dom.js")),p=(d(n),a("../utils/fn.js")),r=(d(p),a("../utils/to-title-case.js")),t=(e(r),function(a){function b(c){var d=arguments.length<=1||void 0===arguments[1]?{}:arguments[1];f(this,b),a.call(this,c,d),this.update()}return g(b,a),b.prototype.update=function(){var b=this.createPopup();this.popup&&this.removeChild(this.popup),this.popup=b,this.addChild(b),this.items&&0===this.items.length?this.hide():this.items&&this.items.length>1&&this.show()},b.prototype.createPopup=function(){},b.prototype.createEl=function(){return a.prototype.createEl.call(this,"div",{className:this.buildCSSClass()})},b.prototype.buildCSSClass=function(){var c="vjs-menu-button";return c+=this.options_.inline===!0?"-inline":"-popup","vjs-menu-button "+c+" "+a.prototype.buildCSSClass.call(this)},b}(i.default));k.default.registerComponent("PopupButton",t),c.default=t,b.exports=c.default},{"../clickable-component.js":64,"../component.js":66,"../utils/dom.js":131,"../utils/fn.js":133,"../utils/to-title-case.js":140,"./popup.js":110}],110:[function(a,b,c){"use strict";function d(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function e(a){return a&&a.__esModule?a:{default:a}}function f(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function g(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var h=a("../component.js"),i=e(h),j=a("../utils/dom.js"),k=d(j),l=a("../utils/fn.js"),m=d(l),n=a("../utils/events.js"),o=d(n),p=function(a){function b(){f(this,b),a.apply(this,arguments)}return g(b,a),b.prototype.addItem=function(b){this.addChild(b),b.on("click",m.bind(this,function(){this.unlockShowing()}))},b.prototype.createEl=function(){var c=this.options_.contentElType||"ul";this.contentEl_=k.createEl(c,{className:"vjs-menu-content"});var d=a.prototype.createEl.call(this,"div",{append:this.contentEl_,className:"vjs-menu"});return d.appendChild(this.contentEl_),o.on(d,"click",function(a){a.preventDefault(),a.stopImmediatePropagation()}),d},b}(i.default);i.default.registerComponent("Popup",p),c.default=p,b.exports=c.default},{"../component.js":66,"../utils/dom.js":131,"../utils/events.js":132,"../utils/fn.js":133}],111:[function(a,b,c){"use strict";function d(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function e(a){return a&&a.__esModule?a:{default:a}}function f(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function g(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var h=a("./clickable-component.js"),i=e(h),j=a("./component.js"),k=e(j),l=a("./utils/fn.js"),m=d(l),n=a("./utils/dom.js"),o=d(n),p=a("./utils/browser.js"),q=d(p),r=function(a){function b(c,d){f(this,b),a.call(this,c,d),this.update(),c.on("posterchange",m.bind(this,this.update))}return g(b,a),b.prototype.dispose=function(){this.player().off("posterchange",this.update),a.prototype.dispose.call(this)},b.prototype.createEl=function(){var b=o.createEl("div",{className:"vjs-poster",tabIndex:-1});return q.BACKGROUND_SIZE_SUPPORTED||(this.fallbackImg_=o.createEl("img"),b.appendChild(this.fallbackImg_)),b},b.prototype.update=function(){var b=this.player().poster();this.setSrc(b),b?this.show():this.hide()},b.prototype.setSrc=function(b){if(this.fallbackImg_)this.fallbackImg_.src=b;else{var c="";b&&(c='url("'+b+'")'),this.el_.style.backgroundImage=c}},b.prototype.handleClick=function(){this.player_.paused()?this.player_.play():this.player_.pause()},b}(i.default);k.default.registerComponent("PosterImage",r),c.default=r,b.exports=c.default},{"./clickable-component.js":64,"./component.js":66,"./utils/browser.js":128,"./utils/dom.js":131,"./utils/fn.js":133}],112:[function(a,b,c){"use strict";function d(a){return a&&a.__esModule?a:{default:a}}function e(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}c.__esModule=!0;var f=a("./utils/events.js"),g=e(f),h=a("global/document"),i=d(h),j=a("global/window"),k=d(j),l=!1,m=void 0,n=function(){var b=i.default.getElementsByTagName("video"),c=i.default.getElementsByTagName("audio"),d=[];if(b&&b.length>0)for(var e=0,f=b.length;e<f;e++)d.push(b[e]);if(c&&c.length>0)for(var e=0,f=c.length;e<f;e++)d.push(c[e]);if(d&&d.length>0)for(var e=0,f=d.length;e<f;e++){var g=d[e];if(!g||!g.getAttribute){o(1);break}if(void 0===g.player){var h=g.getAttribute("data-setup");if(null!==h){m(g)}}}else l||o(1)},o=function(b,c){m=c,setTimeout(n,b)};"complete"===i.default.readyState?l=!0:g.one(k.default,"load",function(){l=!0});var p=function(){return l};c.autoSetup=n,c.autoSetupTimeout=o,c.hasLoaded=p},{"./utils/events.js":132,"global/document":1,"global/window":2}],113:[function(a,b,c){"use strict";function d(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function e(a){return a&&a.__esModule?a:{default:a}}function f(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function g(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var h=a("../component.js"),i=e(h),j=a("../utils/dom.js"),k=d(j),l=a("global/document"),m=e(l),n=a("object.assign"),o=e(n),p=function(a){function b(c,d){f(this,b),a.call(this,c,d),this.bar=this.getChild(this.options_.barName),this.vertical(!!this.options_.vertical),this.on("mousedown",this.handleMouseDown),this.on("touchstart",this.handleMouseDown),this.on("focus",this.handleFocus),this.on("blur",this.handleBlur),this.on("click",this.handleClick),this.on(c,"controlsvisible",this.update),this.on(c,this.playerEvent,this.update)}return g(b,a),b.prototype.createEl=function(c){var d=arguments.length<=1||void 0===arguments[1]?{}:arguments[1],e=arguments.length<=2||void 0===arguments[2]?{}:arguments[2];return d.className=d.className+" vjs-slider",d=o.default({tabIndex:0},d),e=o.default({role:"slider","aria-valuenow":0,"aria-valuemin":0,"aria-valuemax":100,tabIndex:0},e),a.prototype.createEl.call(this,c,d,e)},b.prototype.handleMouseDown=function(b){b.preventDefault(),k.blockTextSelection(),this.addClass("vjs-sliding"),this.trigger("slideractive"),this.on(m.default,"mousemove",this.handleMouseMove),this.on(m.default,"mouseup",this.handleMouseUp),this.on(m.default,"touchmove",this.handleMouseMove),this.on(m.default,"touchend",this.handleMouseUp),this.handleMouseMove(b)},b.prototype.handleMouseMove=function(){},b.prototype.handleMouseUp=function(){k.unblockTextSelection(),this.removeClass("vjs-sliding"),this.trigger("sliderinactive"),this.off(m.default,"mousemove",this.handleMouseMove),this.off(m.default,"mouseup",this.handleMouseUp),this.off(m.default,"touchmove",this.handleMouseMove),this.off(m.default,"touchend",this.handleMouseUp),this.update()},b.prototype.update=function(){if(this.el_){var b=this.getPercent(),c=this.bar;if(c){("number"!=typeof b||b!==b||b<0||b===1/0)&&(b=0);var d=(100*b).toFixed(2)+"%";this.vertical()?c.el().style.height=d:c.el().style.width=d}}},b.prototype.calculateDistance=function(b){var c=k.getPointerPosition(this.el_,b);return this.vertical()?c.y:c.x},b.prototype.handleFocus=function(){this.on(m.default,"keydown",this.handleKeyPress)},b.prototype.handleKeyPress=function(b){37===b.which||40===b.which?(b.preventDefault(),this.stepBack()):38!==b.which&&39!==b.which||(b.preventDefault(),this.stepForward())},b.prototype.handleBlur=function(){this.off(m.default,"keydown",this.handleKeyPress)},b.prototype.handleClick=function(b){b.stopImmediatePropagation(),b.preventDefault()},b.prototype.vertical=function(b){return void 0===b?this.vertical_||!1:(this.vertical_=!!b,this.vertical_?this.addClass("vjs-slider-vertical"):this.addClass("vjs-slider-horizontal"),this)},b}(i.default);i.default.registerComponent("Slider",p),c.default=p,b.exports=c.default},{"../component.js":66,"../utils/dom.js":131,"global/document":1,"object.assign":45}],114:[function(a,b,c){"use strict";function d(a){return a.streamingFormats={"rtmp/mp4":"MP4","rtmp/flv":"FLV"},a.streamFromParts=function(a,b){return a+"&"+b},a.streamToParts=function(a){var b={connection:"",stream:""};if(!a)return b;var c=a.search(/&(?!\w+=)/),d=void 0;return c!==-1?d=c+1:(c=d=a.lastIndexOf("/")+1,0===c&&(c=d=a.length)),b.connection=a.substring(0,c),b.stream=a.substring(d,a.length),b},a.isStreamingType=function(b){return b in a.streamingFormats},a.RTMP_RE=/^rtmp[set]?:\/\//i,a.isStreamingSrc=function(b){return a.RTMP_RE.test(b)},a.rtmpSourceHandler={},a.rtmpSourceHandler.canPlayType=function(b){return a.isStreamingType(b)?"maybe":""},a.rtmpSourceHandler.canHandleSource=function(b){var c=a.rtmpSourceHandler.canPlayType(b.type);return c?c:a.isStreamingSrc(b.src)?"maybe":""},a.rtmpSourceHandler.handleSource=function(b,c){var d=a.streamToParts(b.src);c.setRtmpConnection(d.connection),c.setRtmpStream(d.stream)},a.registerSourceHandler(a.rtmpSourceHandler),a}c.__esModule=!0,c.default=d,b.exports=c.default},{}],115:[function(a,b,c){"use strict";function d(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function e(a){return a&&a.__esModule?a:{default:a}}function f(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function g(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}function B(a){var b=a.charAt(0).toUpperCase()+a.slice(1);y["set"+b]=function(b){return this.el_.vjs_setProperty(a,b)}}function C(a){y[a]=function(){return this.el_.vjs_getProperty(a)}}c.__esModule=!0;for(var h=a("./tech"),i=e(h),j=a("../utils/dom.js"),k=d(j),l=a("../utils/url.js"),m=d(l),n=a("../utils/time-ranges.js"),o=a("./flash-rtmp"),p=e(o),q=a("../component"),r=e(q),s=a("global/window"),t=e(s),u=a("object.assign"),v=e(u),w=t.default.navigator,x=function(a){function b(c,d){f(this,b),a.call(this,c,d),c.source&&this.ready(function(){this.setSource(c.source)},!0),c.startTime&&this.ready(function(){this.load(),this.play(),this.currentTime(c.startTime)},!0),t.default.videojs=t.default.videojs||{},t.default.videojs.Flash=t.default.videojs.Flash||{},t.default.videojs.Flash.onReady=b.onReady,t.default.videojs.Flash.onEvent=b.onEvent,t.default.videojs.Flash.onError=b.onError,this.on("seeked",function(){this.lastSeekTarget_=void 0})}return g(b,a),b.prototype.createEl=function(){var c=this.options_;c.swf||(c.swf="//vjs.zencdn.net/swf/5.0.1/video-js.swf");var d=c.techId,e=v.default({readyFunction:"videojs.Flash.onReady",eventProxyFunction:"videojs.Flash.onEvent",errorEventProxyFunction:"videojs.Flash.onError",autoplay:c.autoplay,preload:c.preload,loop:c.loop,muted:c.muted},c.flashVars),f=v.default({wmode:"opaque",bgcolor:"#000000"},c.params),g=v.default({id:d,name:d,class:"vjs-tech"},c.attributes);return this.el_=b.embed(c.swf,e,f,g),this.el_.tech=this,this.el_},b.prototype.play=function(){this.ended()&&this.setCurrentTime(0),this.el_.vjs_play()},b.prototype.pause=function(){this.el_.vjs_pause()},b.prototype.src=function(b){return void 0===b?this.currentSrc():this.setSrc(b)},b.prototype.setSrc=function(b){if(b=m.getAbsoluteURL(b),this.el_.vjs_src(b),this.autoplay()){var c=this;this.setTimeout(function(){c.play()},0)}},b.prototype.seeking=function(){return void 0!==this.lastSeekTarget_},b.prototype.setCurrentTime=function(c){var d=this.seekable();d.length&&(c=c>d.start(0)?c:d.start(0),c=c<d.end(d.length-1)?c:d.end(d.length-1),this.lastSeekTarget_=c,this.trigger("seeking"),this.el_.vjs_setProperty("currentTime",c),a.prototype.setCurrentTime.call(this))},b.prototype.currentTime=function(b){return this.seeking()?this.lastSeekTarget_||0:this.el_.vjs_getProperty("currentTime")},b.prototype.currentSrc=function(){return this.currentSource_?this.currentSource_.src:this.el_.vjs_getProperty("currentSrc")},b.prototype.load=function(){this.el_.vjs_load()},b.prototype.poster=function(){this.el_.vjs_getProperty("poster")},b.prototype.setPoster=function(){},b.prototype.seekable=function(){var b=this.duration();return 0===b?n.createTimeRange():n.createTimeRange(0,b)},b.prototype.buffered=function(){var b=this.el_.vjs_getProperty("buffered");return 0===b.length?n.createTimeRange():n.createTimeRange(b[0][0],b[0][1])},b.prototype.supportsFullScreen=function(){return!1},b.prototype.enterFullScreen=function(){return!1},b}(i.default),y=x.prototype,z="rtmpConnection,rtmpStream,preload,defaultPlaybackRate,playbackRate,autoplay,loop,mediaGroup,controller,controls,volume,muted,defaultMuted".split(","),A="networkState,readyState,initialTime,duration,startOffsetTime,paused,ended,videoTracks,audioTracks,videoWidth,videoHeight".split(","),D=0;D<z.length;D++)C(z[D]),B(z[D]);for(var D=0;D<A.length;D++)C(A[D]);x.isSupported=function(){return x.version()[0]>=10},i.default.withSourceHandlers(x),x.nativeSourceHandler={},x.nativeSourceHandler.canPlayType=function(a){return a in x.formats?"maybe":""},x.nativeSourceHandler.canHandleSource=function(a){function c(a){var b=m.getFileExtension(a);return b?"video/"+b:""}var b;return b=a.type?a.type.replace(/;.*/,"").toLowerCase():c(a.src),x.nativeSourceHandler.canPlayType(b)},x.nativeSourceHandler.handleSource=function(a,b){b.setSrc(a.src)},x.nativeSourceHandler.dispose=function(){},x.registerSourceHandler(x.nativeSourceHandler),x.formats={"video/flv":"FLV","video/x-flv":"FLV","video/mp4":"MP4","video/m4v":"MP4"},x.onReady=function(a){var b=k.getEl(a),c=b&&b.tech;c&&c.el()&&x.checkReady(c)},x.checkReady=function(a){a.el()&&(a.el().vjs_getProperty?a.triggerReady():this.setTimeout(function(){x.checkReady(a)},50))},x.onEvent=function(a,b){var c=k.getEl(a).tech;c.trigger(b)},x.onError=function(a,b){var c=k.getEl(a).tech;return"srcnotfound"===b?c.error(4):void c.error("FLASH: "+b)},x.version=function(){var a="0,0,0";try{a=new t.default.ActiveXObject("ShockwaveFlash.ShockwaveFlash").GetVariable("$version").replace(/\D+/g,",").match(/^,?(.+),?$/)[1]}catch(b){try{w.mimeTypes["application/x-shockwave-flash"].enabledPlugin&&(a=(w.plugins["Shockwave Flash 2.0"]||w.plugins["Shockwave Flash"]).description.replace(/\D+/g,",").match(/^,?(.+),?$/)[1])}catch(a){}}return a.split(",")},x.embed=function(a,b,c,d){var e=x.getEmbedCode(a,b,c,d),f=k.createEl("div",{innerHTML:e}).childNodes[0];return f},x.getEmbedCode=function(a,b,c,d){var e='<object type="application/x-shockwave-flash" ',f="",g="",h="";return b&&Object.getOwnPropertyNames(b).forEach(function(a){f+=a+"="+b[a]+"&amp;"}),c=v.default({movie:a,flashvars:f,allowScriptAccess:"always",allowNetworking:"all"},c),Object.getOwnPropertyNames(c).forEach(function(a){g+='<param name="'+a+'" value="'+c[a]+'" />'}),d=v.default({data:a,width:"100%",height:"100%"},d),Object.getOwnPropertyNames(d).forEach(function(a){h+=a+'="'+d[a]+'" '}),""+e+h+">"+g+"</object>"},p.default(x),r.default.registerComponent("Flash",x),i.default.registerTech("Flash",x),c.default=x,b.exports=c.default},{"../component":66,"../utils/dom.js":131,"../utils/time-ranges.js":139,"../utils/url.js":141,"./flash-rtmp":114,"./tech":118,"global/window":2,"object.assign":45}],116:[function(a,b,c){"use strict";function d(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function e(a){return a&&a.__esModule?a:{default:a}}function f(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function g(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var h=a("./tech.js"),i=e(h),j=a("../component"),k=e(j),l=a("../utils/dom.js"),m=d(l),n=a("../utils/url.js"),o=d(n),p=a("../utils/fn.js"),q=d(p),r=a("../utils/log.js"),s=e(r),t=a("../utils/browser.js"),u=d(t),v=a("global/document"),w=e(v),x=a("global/window"),y=e(x),z=a("object.assign"),A=e(z),B=a("../utils/merge-options.js"),C=e(B),D=function(a){function b(c,d){f(this,b),a.call(this,c,d);var e=c.source;if(e&&(this.el_.currentSrc!==e.src||c.tag&&3===c.tag.initNetworkState_)?this.setSource(e):this.handleLateInit_(this.el_),this.el_.hasChildNodes()){for(var g=this.el_.childNodes,h=g.length,i=[];h--;){var j=g[h],k=j.nodeName.toLowerCase();"track"===k&&(this.featuresNativeTextTracks?(this.remoteTextTrackEls().addTrackElement_(j),this.remoteTextTracks().addTrack_(j.track)):i.push(j))}for(var l=0;l<i.length;l++)this.el_.removeChild(i[l])}this.featuresNativeTextTracks&&(this.handleTextTrackChange_=q.bind(this,this.handleTextTrackChange),this.handleTextTrackAdd_=q.bind(this,this.handleTextTrackAdd),this.handleTextTrackRemove_=q.bind(this,this.handleTextTrackRemove),this.proxyNativeTextTracks_()),(u.TOUCH_ENABLED&&c.nativeControlsForTouch===!0||u.IS_IPHONE||u.IS_NATIVE_ANDROID)&&this.setControls(!0),this.triggerReady()}return g(b,a),b.prototype.dispose=function(){var d=this.el().textTracks,e=this.textTracks();d&&d.removeEventListener&&(d.removeEventListener("change",this.handleTextTrackChange_),d.removeEventListener("addtrack",this.handleTextTrackAdd_),d.removeEventListener("removetrack",this.handleTextTrackRemove_));for(var f=e.length;f--;)e.removeTrack_(e[f]);b.disposeMediaElement(this.el_),a.prototype.dispose.call(this)},b.prototype.createEl=function(){var c=this.options_.tag;if(!c||this.movingMediaElementInDOM===!1)if(c){var d=c.cloneNode(!0);c.parentNode.insertBefore(d,c),b.disposeMediaElement(c),c=d}else{c=w.default.createElement("video");var e=this.options_.tag&&m.getElAttributes(this.options_.tag),f=C.default({},e);u.TOUCH_ENABLED&&this.options_.nativeControlsForTouch===!0||delete f.controls,m.setElAttributes(c,A.default(f,{id:this.options_.techId,class:"vjs-tech"}))}for(var g=["autoplay","preload","loop","muted"],h=g.length-1;h>=0;h--){var i=g[h],j={};"undefined"!=typeof this.options_[i]&&(j[i]=this.options_[i]),m.setElAttributes(c,j)}return c},b.prototype.handleLateInit_=function(b){var c=this;if(0!==b.networkState&&3!==b.networkState){if(0===b.readyState){var d=function(){var a=!1,b=function(){a=!0};c.on("loadstart",b);var d=function(){a||this.trigger("loadstart")};return c.on("loadedmetadata",d),c.ready(function(){this.off("loadstart",b),this.off("loadedmetadata",d),a||this.trigger("loadstart")}),{v:void 0}}();if("object"==typeof d)return d.v}var e=["loadstart"];e.push("loadedmetadata"),b.readyState>=2&&e.push("loadeddata"),b.readyState>=3&&e.push("canplay"),b.readyState>=4&&e.push("canplaythrough"),this.ready(function(){e.forEach(function(a){this.trigger(a)},this)})}},b.prototype.proxyNativeTextTracks_=function(){var b=this.el().textTracks;b&&b.addEventListener&&(b.addEventListener("change",this.handleTextTrackChange_),b.addEventListener("addtrack",this.handleTextTrackAdd_),b.addEventListener("removetrack",this.handleTextTrackRemove_))},b.prototype.handleTextTrackChange=function(b){var c=this.textTracks();this.textTracks().trigger({type:"change",target:c,currentTarget:c,srcElement:c})},b.prototype.handleTextTrackAdd=function(b){this.textTracks().addTrack_(b.track)},b.prototype.handleTextTrackRemove=function(b){this.textTracks().removeTrack_(b.track)},b.prototype.play=function(){this.el_.play()},b.prototype.pause=function(){this.el_.pause()},b.prototype.paused=function(){return this.el_.paused},b.prototype.currentTime=function(){return this.el_.currentTime},b.prototype.setCurrentTime=function(b){try{this.el_.currentTime=b}catch(a){s.default(a,"Video is not ready. (Video.js)")}},b.prototype.duration=function(){return this.el_.duration||0},b.prototype.buffered=function(){return this.el_.buffered},b.prototype.volume=function(){return this.el_.volume},b.prototype.setVolume=function(b){this.el_.volume=b},b.prototype.muted=function(){return this.el_.muted},b.prototype.setMuted=function(b){this.el_.muted=b},b.prototype.width=function(){return this.el_.offsetWidth},b.prototype.height=function(){return this.el_.offsetHeight},b.prototype.supportsFullScreen=function(){if("function"==typeof this.el_.webkitEnterFullScreen){var b=y.default.navigator.userAgent;if(/Android/.test(b)||!/Chrome|Mac OS X 10.5/.test(b))return!0}return!1},b.prototype.enterFullScreen=function(){var b=this.el_;"webkitDisplayingFullscreen"in b&&this.one("webkitbeginfullscreen",function(){this.one("webkitendfullscreen",function(){this.trigger("fullscreenchange",{isFullscreen:!1})}),this.trigger("fullscreenchange",{isFullscreen:!0})}),b.paused&&b.networkState<=b.HAVE_METADATA?(this.el_.play(),this.setTimeout(function(){b.pause(),b.webkitEnterFullScreen()},0)):b.webkitEnterFullScreen()},b.prototype.exitFullScreen=function(){this.el_.webkitExitFullScreen()},b.prototype.src=function(b){return void 0===b?this.el_.src:void this.setSrc(b)},b.prototype.setSrc=function(b){this.el_.src=b},b.prototype.load=function(){this.el_.load()},b.prototype.reset=function(){b.resetMediaElement(this.el_)},b.prototype.currentSrc=function(){return this.currentSource_?this.currentSource_.src:this.el_.currentSrc},b.prototype.poster=function(){return this.el_.poster},b.prototype.setPoster=function(b){this.el_.poster=b},b.prototype.preload=function(){return this.el_.preload},b.prototype.setPreload=function(b){this.el_.preload=b},b.prototype.autoplay=function(){return this.el_.autoplay},b.prototype.setAutoplay=function(b){this.el_.autoplay=b},b.prototype.controls=function(){return this.el_.controls},b.prototype.setControls=function(b){this.el_.controls=!!b},b.prototype.loop=function(){return this.el_.loop},b.prototype.setLoop=function(b){this.el_.loop=b},b.prototype.error=function(){return this.el_.error},b.prototype.seeking=function(){return this.el_.seeking},b.prototype.seekable=function(){return this.el_.seekable},b.prototype.ended=function(){return this.el_.ended},b.prototype.defaultMuted=function(){return this.el_.defaultMuted},b.prototype.playbackRate=function(){return this.el_.playbackRate},b.prototype.played=function(){return this.el_.played},b.prototype.setPlaybackRate=function(b){this.el_.playbackRate=b},b.prototype.networkState=function(){return this.el_.networkState},b.prototype.readyState=function(){return this.el_.readyState},b.prototype.videoWidth=function(){return this.el_.videoWidth},b.prototype.videoHeight=function(){return this.el_.videoHeight},b.prototype.textTracks=function(){return a.prototype.textTracks.call(this)},b.prototype.addTextTrack=function(c,d,e){
return this.featuresNativeTextTracks?this.el_.addTextTrack(c,d,e):a.prototype.addTextTrack.call(this,c,d,e)},b.prototype.addRemoteTextTrack=function(){var c=arguments.length<=0||void 0===arguments[0]?{}:arguments[0];if(!this.featuresNativeTextTracks)return a.prototype.addRemoteTextTrack.call(this,c);var d=w.default.createElement("track");return c.kind&&(d.kind=c.kind),c.label&&(d.label=c.label),(c.language||c.srclang)&&(d.srclang=c.language||c.srclang),c.default&&(d.default=c.default),c.id&&(d.id=c.id),c.src&&(d.src=c.src),this.el().appendChild(d),this.remoteTextTrackEls().addTrackElement_(d),this.remoteTextTracks().addTrack_(d.track),d},b.prototype.removeRemoteTextTrack=function(c){if(!this.featuresNativeTextTracks)return a.prototype.removeRemoteTextTrack.call(this,c);var d=void 0,e=void 0,f=this.remoteTextTrackEls().getTrackElementByTrack_(c);for(this.remoteTextTrackEls().removeTrackElement_(f),this.remoteTextTracks().removeTrack_(c),d=this.$$("track"),e=d.length;e--;)c!==d[e]&&c!==d[e].track||this.el().removeChild(d[e])},b}(i.default);D.TEST_VID=w.default.createElement("video");var E=w.default.createElement("track");E.kind="captions",E.srclang="en",E.label="English",D.TEST_VID.appendChild(E),D.isSupported=function(){try{D.TEST_VID.volume=.5}catch(a){return!1}return!!D.TEST_VID.canPlayType},i.default.withSourceHandlers(D),D.nativeSourceHandler={},D.nativeSourceHandler.canPlayType=function(a){try{return D.TEST_VID.canPlayType(a)}catch(a){return""}},D.nativeSourceHandler.canHandleSource=function(a){var c;return a.type?D.nativeSourceHandler.canPlayType(a.type):a.src?(c=o.getFileExtension(a.src),D.nativeSourceHandler.canPlayType("video/"+c)):""},D.nativeSourceHandler.handleSource=function(a,b){b.setSrc(a.src)},D.nativeSourceHandler.dispose=function(){},D.registerSourceHandler(D.nativeSourceHandler),D.canControlVolume=function(){var a=D.TEST_VID.volume;return D.TEST_VID.volume=a/2+.1,a!==D.TEST_VID.volume},D.canControlPlaybackRate=function(){var a=D.TEST_VID.playbackRate;return D.TEST_VID.playbackRate=a/2+.1,a!==D.TEST_VID.playbackRate},D.supportsNativeTextTracks=function(){var a;return a=!!D.TEST_VID.textTracks,a&&D.TEST_VID.textTracks.length>0&&(a="number"!=typeof D.TEST_VID.textTracks[0].mode),a&&u.IS_FIREFOX&&(a=!1),!a||"onremovetrack"in D.TEST_VID.textTracks||(a=!1),a},D.Events=["loadstart","suspend","abort","error","emptied","stalled","loadedmetadata","loadeddata","canplay","canplaythrough","playing","waiting","seeking","seeked","ended","durationchange","timeupdate","progress","play","pause","ratechange","volumechange"],D.prototype.featuresVolumeControl=D.canControlVolume(),D.prototype.featuresPlaybackRate=D.canControlPlaybackRate(),D.prototype.movingMediaElementInDOM=!u.IS_IOS,D.prototype.featuresFullscreenResize=!0,D.prototype.featuresProgressEvents=!0,D.prototype.featuresNativeTextTracks=D.supportsNativeTextTracks();var F=void 0,G=/^application\/(?:x-|vnd\.apple\.)mpegurl/i,H=/^video\/mp4/i;D.patchCanPlayType=function(){u.ANDROID_VERSION>=4&&(F||(F=D.TEST_VID.constructor.prototype.canPlayType),D.TEST_VID.constructor.prototype.canPlayType=function(a){return a&&G.test(a)?"maybe":F.call(this,a)}),u.IS_OLD_ANDROID&&(F||(F=D.TEST_VID.constructor.prototype.canPlayType),D.TEST_VID.constructor.prototype.canPlayType=function(a){return a&&H.test(a)?"maybe":F.call(this,a)})},D.unpatchCanPlayType=function(){var a=D.TEST_VID.constructor.prototype.canPlayType;return D.TEST_VID.constructor.prototype.canPlayType=F,F=null,a},D.patchCanPlayType(),D.disposeMediaElement=function(a){if(a){for(a.parentNode&&a.parentNode.removeChild(a);a.hasChildNodes();)a.removeChild(a.firstChild);a.removeAttribute("src"),"function"==typeof a.load&&!function(){try{a.load()}catch(a){}}()}},D.resetMediaElement=function(a){if(a){for(var b=a.querySelectorAll("source"),c=b.length;c--;)a.removeChild(b[c]);a.removeAttribute("src"),"function"==typeof a.load&&!function(){try{a.load()}catch(a){}}()}},k.default.registerComponent("Html5",D),i.default.registerTech("Html5",D),c.default=D,b.exports=c.default},{"../component":66,"../utils/browser.js":128,"../utils/dom.js":131,"../utils/fn.js":133,"../utils/log.js":136,"../utils/merge-options.js":137,"../utils/url.js":141,"./tech.js":118,"global/document":1,"global/window":2,"object.assign":45}],117:[function(a,b,c){"use strict";function d(a){return a&&a.__esModule?a:{default:a}}function e(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function f(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var g=a("../component.js"),h=d(g),i=a("./tech.js"),j=d(i),k=a("global/window"),m=(d(k),a("../utils/to-title-case.js")),n=d(m),o=function(a){function b(c,d,f){if(e(this,b),a.call(this,c,d,f),d.playerOptions.sources&&0!==d.playerOptions.sources.length)c.src(d.playerOptions.sources);else for(var g=0,i=d.playerOptions.techOrder;g<i.length;g++){var k=n.default(i[g]),l=j.default.getTech(k);if(k||(l=h.default.getComponent(k)),l&&l.isSupported()){c.loadTech_(k);break}}}return f(b,a),b}(h.default);h.default.registerComponent("MediaLoader",o),c.default=o,b.exports=c.default},{"../component.js":66,"../utils/to-title-case.js":140,"./tech.js":118,"global/window":2}],118:[function(a,b,c){"use strict";function d(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function e(a){return a&&a.__esModule?a:{default:a}}function f(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function g(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var h=a("../component"),i=e(h),j=a("../tracks/html-track-element"),k=e(j),l=a("../tracks/html-track-element-list"),m=e(l),n=a("../utils/merge-options.js"),o=e(n),p=a("../tracks/text-track"),q=e(p),r=a("../tracks/text-track-list"),s=e(r),t=a("../utils/fn.js"),u=d(t),v=a("../utils/log.js"),w=e(v),x=a("../utils/time-ranges.js"),y=a("../utils/buffer.js"),z=a("../media-error.js"),A=e(z),B=a("global/window"),C=e(B),D=a("global/document"),E=e(D),F=function(a){function b(){var c=arguments.length<=0||void 0===arguments[0]?{}:arguments[0],d=arguments.length<=1||void 0===arguments[1]?function(){}:arguments[1];f(this,b),c.reportTouchActivity=!1,a.call(this,null,c,d),this.hasStarted_=!1,this.on("playing",function(){this.hasStarted_=!0}),this.on("loadstart",function(){this.hasStarted_=!1}),this.textTracks_=c.textTracks,this.featuresProgressEvents||this.manualProgressOn(),this.featuresTimeupdateEvents||this.manualTimeUpdatesOn(),c.nativeCaptions!==!1&&c.nativeTextTracks!==!1||(this.featuresNativeTextTracks=!1),this.featuresNativeTextTracks||this.on("ready",this.emulateTextTracks),this.initTextTrackListeners(),this.emitTapEvents()}return g(b,a),b.prototype.manualProgressOn=function(){this.on("durationchange",this.onDurationChange),this.manualProgress=!0,this.one("ready",this.trackProgress)},b.prototype.manualProgressOff=function(){this.manualProgress=!1,this.stopTrackingProgress(),this.off("durationchange",this.onDurationChange)},b.prototype.trackProgress=function(){this.stopTrackingProgress(),this.progressInterval=this.setInterval(u.bind(this,function(){var a=this.bufferedPercent();this.bufferedPercent_!==a&&this.trigger("progress"),this.bufferedPercent_=a,1===a&&this.stopTrackingProgress()}),500)},b.prototype.onDurationChange=function(){this.duration_=this.duration()},b.prototype.buffered=function(){return x.createTimeRange(0,0)},b.prototype.bufferedPercent=function(){return y.bufferedPercent(this.buffered(),this.duration_)},b.prototype.stopTrackingProgress=function(){this.clearInterval(this.progressInterval)},b.prototype.manualTimeUpdatesOn=function(){this.manualTimeUpdates=!0,this.on("play",this.trackCurrentTime),this.on("pause",this.stopTrackingCurrentTime)},b.prototype.manualTimeUpdatesOff=function(){this.manualTimeUpdates=!1,this.stopTrackingCurrentTime(),this.off("play",this.trackCurrentTime),this.off("pause",this.stopTrackingCurrentTime)},b.prototype.trackCurrentTime=function(){this.currentTimeInterval&&this.stopTrackingCurrentTime(),this.currentTimeInterval=this.setInterval(function(){this.trigger({type:"timeupdate",target:this,manuallyTriggered:!0})},250)},b.prototype.stopTrackingCurrentTime=function(){this.clearInterval(this.currentTimeInterval),this.trigger({type:"timeupdate",target:this,manuallyTriggered:!0})},b.prototype.dispose=function(){var c=this.textTracks();if(c)for(var d=c.length;d--;)this.removeRemoteTextTrack(c[d]);this.manualProgress&&this.manualProgressOff(),this.manualTimeUpdates&&this.manualTimeUpdatesOff(),a.prototype.dispose.call(this)},b.prototype.reset=function(){},b.prototype.error=function(b){return void 0!==b&&(b instanceof A.default?this.error_=b:this.error_=new A.default(b),this.trigger("error")),this.error_},b.prototype.played=function(){return this.hasStarted_?x.createTimeRange(0,0):x.createTimeRange()},b.prototype.setCurrentTime=function(){this.manualTimeUpdates&&this.trigger({type:"timeupdate",target:this,manuallyTriggered:!0})},b.prototype.initTextTrackListeners=function(){var b=u.bind(this,function(){this.trigger("texttrackchange")}),c=this.textTracks();c&&(c.addEventListener("removetrack",b),c.addEventListener("addtrack",b),this.on("dispose",u.bind(this,function(){c.removeEventListener("removetrack",b),c.removeEventListener("addtrack",b)})))},b.prototype.emulateTextTracks=function(){var b=this,c=this.textTracks();if(c){if(!C.default.WebVTT&&null!=this.el().parentNode){var d=E.default.createElement("script");d.src=this.options_["vtt.js"]||"https://cdn.rawgit.com/gkatsev/vtt.js/vjs-v0.12.1/dist/vtt.min.js",this.el().parentNode.appendChild(d),C.default.WebVTT=!0}var e=function(){return b.trigger("texttrackchange")},f=function(){e();for(var b=0;b<c.length;b++){var d=c[b];d.removeEventListener("cuechange",e),"showing"===d.mode&&d.addEventListener("cuechange",e)}};f(),c.addEventListener("change",f),this.on("dispose",function(){c.removeEventListener("change",f)})}},b.prototype.textTracks=function(){return this.textTracks_=this.textTracks_||new s.default,this.textTracks_},b.prototype.remoteTextTracks=function(){return this.remoteTextTracks_=this.remoteTextTracks_||new s.default,this.remoteTextTracks_},b.prototype.remoteTextTrackEls=function(){return this.remoteTextTrackEls_=this.remoteTextTrackEls_||new m.default,this.remoteTextTrackEls_},b.prototype.addTextTrack=function(b,c,d){if(!b)throw new Error("TextTrack kind is required but was not provided");return G(this,b,c,d)},b.prototype.addRemoteTextTrack=function(b){var c=o.default(b,{tech:this}),d=new k.default(c);return this.remoteTextTrackEls().addTrackElement_(d),this.remoteTextTracks().addTrack_(d.track),this.textTracks().addTrack_(d.track),d},b.prototype.removeRemoteTextTrack=function(b){this.textTracks().removeTrack_(b);var c=this.remoteTextTrackEls().getTrackElementByTrack_(b);this.remoteTextTrackEls().removeTrackElement_(c),this.remoteTextTracks().removeTrack_(b)},b.prototype.setPoster=function(){},b.prototype.canPlayType=function(){return""},b.isTech=function(c){return c.prototype instanceof b||c instanceof b||c===b},b.registerTech=function(c,d){if(b.techs_||(b.techs_={}),!b.isTech(d))throw new Error("Tech "+c+" must be a Tech");return b.techs_[c]=d,d},b.getTech=function(c){return b.techs_&&b.techs_[c]?b.techs_[c]:C.default&&C.default.videojs&&C.default.videojs[c]?(w.default.warn("The "+c+" tech was added to the videojs object when it should be registered using videojs.registerTech(name, tech)"),C.default.videojs[c]):void 0},b}(i.default);F.prototype.textTracks_;var G=function(b,c,d,e){var f=arguments.length<=4||void 0===arguments[4]?{}:arguments[4],g=b.textTracks();f.kind=c,d&&(f.label=d),e&&(f.language=e),f.tech=b;var h=new q.default(f);return g.addTrack_(h),h};F.prototype.featuresVolumeControl=!0,F.prototype.featuresFullscreenResize=!1,F.prototype.featuresPlaybackRate=!1,F.prototype.featuresProgressEvents=!1,F.prototype.featuresTimeupdateEvents=!1,F.prototype.featuresNativeTextTracks=!1,F.withSourceHandlers=function(a){a.registerSourceHandler=function(b,c){var d=a.sourceHandlers;d||(d=a.sourceHandlers=[]),void 0===c&&(c=d.length),d.splice(c,0,b)},a.canPlayType=function(b){for(var c=a.sourceHandlers||[],d=void 0,e=0;e<c.length;e++)if(d=c[e].canPlayType(b))return d;return""},a.selectSourceHandler=function(b){for(var c=a.sourceHandlers||[],d=void 0,e=0;e<c.length;e++)if(d=c[e].canHandleSource(b))return c[e];return null},a.canPlaySource=function(b){var c=a.selectSourceHandler(b);return c?c.canHandleSource(b):""};var b=["seekable","duration"];b.forEach(function(a){var b=this[a];"function"==typeof b&&(this[a]=function(){return this.sourceHandler_&&this.sourceHandler_[a]?this.sourceHandler_[a].apply(this.sourceHandler_,arguments):b.apply(this,arguments)})},a.prototype),a.prototype.setSource=function(b){var c=a.selectSourceHandler(b);return c||(a.nativeSourceHandler?c=a.nativeSourceHandler:w.default.error("No source hander found for the current source.")),this.disposeSourceHandler(),this.off("dispose",this.disposeSourceHandler),this.currentSource_=b,this.sourceHandler_=c.handleSource(b,this),this.on("dispose",this.disposeSourceHandler),this},a.prototype.disposeSourceHandler=function(){this.sourceHandler_&&this.sourceHandler_.dispose&&this.sourceHandler_.dispose()}},i.default.registerComponent("Tech",F),i.default.registerComponent("MediaTechController",F),F.registerTech("Tech",F),c.default=F,b.exports=c.default},{"../component":66,"../media-error.js":102,"../tracks/html-track-element":120,"../tracks/html-track-element-list":119,"../tracks/text-track":127,"../tracks/text-track-list":125,"../utils/buffer.js":129,"../utils/fn.js":133,"../utils/log.js":136,"../utils/merge-options.js":137,"../utils/time-ranges.js":139,"global/document":1,"global/window":2}],119:[function(a,b,c){"use strict";function d(a){return a&&a.__esModule?a:{default:a}}function e(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function f(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}c.__esModule=!0;var g=a("../utils/browser.js"),h=e(g),i=a("global/document"),j=d(i),k=function(){function a(){var b=arguments.length<=0||void 0===arguments[0]?[]:arguments[0];f(this,a);var c=this;if(h.IS_IE8){c=j.default.createElement("custom");for(var d in a.prototype)"constructor"!==d&&(c[d]=a.prototype[d])}c.trackElements_=[],Object.defineProperty(c,"length",{get:function(){return this.trackElements_.length}});for(var e=0,g=b.length;e<g;e++)c.addTrackElement_(b[e]);if(h.IS_IE8)return c}return a.prototype.addTrackElement_=function(b){this.trackElements_.push(b)},a.prototype.getTrackElementByTrack_=function(b){for(var c=void 0,d=0,e=this.trackElements_.length;d<e;d++)if(b===this.trackElements_[d].track){c=this.trackElements_[d];break}return c},a.prototype.removeTrackElement_=function(b){for(var c=0,d=this.trackElements_.length;c<d;c++)if(b===this.trackElements_[c]){this.trackElements_.splice(c,1);break}},a}();c.default=k,b.exports=c.default},{"../utils/browser.js":128,"global/document":1}],120:[function(a,b,c){"use strict";function d(a){return a&&a.__esModule?a:{default:a}}function e(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function f(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function g(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}c.__esModule=!0;var h=a("../utils/browser.js"),i=e(h),j=a("global/document"),k=d(j),l=a("../event-target"),m=d(l),n=a("../tracks/text-track"),o=d(n),p=0,q=1,r=2,s=3,t=function(a){function b(){var c=arguments.length<=0||void 0===arguments[0]?{}:arguments[0];f(this,b),a.call(this);var d=void 0,e=this;if(i.IS_IE8){e=k.default.createElement("custom");for(var g in b.prototype)"constructor"!==g&&(e[g]=b.prototype[g])}var h=new o.default(c);if(e.kind=h.kind,e.src=h.src,e.srclang=h.language,e.label=h.label,e.default=h.default,Object.defineProperty(e,"readyState",{get:function(){return d}}),Object.defineProperty(e,"track",{get:function(){return h}}),d=p,h.addEventListener("loadeddata",function(){d=r,e.trigger({type:"load",target:e})}),i.IS_IE8)return e}return g(b,a),b}(m.default);t.prototype.allowedEvents_={load:"load"},t.NONE=p,t.LOADING=q,t.LOADED=r,t.ERROR=s,c.default=t,b.exports=c.default},{"../event-target":98,"../tracks/text-track":127,"../utils/browser.js":128,"global/document":1}],121:[function(a,b,c){"use strict";function d(a){return a&&a.__esModule?a:{default:a}}function e(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function j(a){var b=this;if(g.IS_IE8){b=i.default.createElement("custom");for(var c in j.prototype)"constructor"!==c&&(b[c]=j.prototype[c])}if(j.prototype.setCues_.call(b,a),Object.defineProperty(b,"length",{get:function(){return this.length_}}),g.IS_IE8)return b}c.__esModule=!0;var f=a("../utils/browser.js"),g=e(f),h=a("global/document"),i=d(h);j.prototype.setCues_=function(a){var b=this.length||0,c=0,d=a.length;this.cues_=a,this.length_=a.length;var e=function(b){""+b in this||Object.defineProperty(this,""+b,{get:function(){return this.cues_[b]}})};if(b<d)for(c=b;c<d;c++)e.call(this,c)},j.prototype.getCueById=function(a){for(var b=null,c=0,d=this.length;c<d;c++){var e=this[c];if(e.id===a){b=e;break}}return b},c.default=j,b.exports=c.default},{"../utils/browser.js":128,"global/document":1}],122:[function(a,b,c){"use strict";function d(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function e(a){return a&&a.__esModule?a:{default:a}}function f(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function g(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}function z(a,b){return"rgba("+parseInt(a[1]+a[1],16)+","+parseInt(a[2]+a[2],16)+","+parseInt(a[3]+a[3],16)+","+b+")"}function A(a,b,c){try{a.style[b]=c}catch(a){}}c.__esModule=!0;var h=a("../component"),i=e(h),j=a("../menu/menu.js"),l=(e(j),a("../menu/menu-item.js")),n=(e(l),a("../menu/menu-button.js")),p=(e(n),a("../utils/fn.js")),q=d(p),r=a("global/document"),t=(e(r),a("global/window")),u=e(t),v="#222",w="#ccc",x={monospace:"monospace",sansSerif:"sans-serif",serif:"serif",monospaceSansSerif:'"Andale Mono", "Lucida Console", monospace',monospaceSerif:'"Courier New", monospace',proportionalSansSerif:"sans-serif",proportionalSerif:"serif",casual:'"Comic Sans MS", Impact, fantasy',script:'"Monotype Corsiva", cursive',smallcaps:'"Andale Mono", "Lucida Console", monospace, sans-serif'},y=function(a){function b(c,d,e){f(this,b),a.call(this,c,d,e),c.on("loadstart",q.bind(this,this.toggleDisplay)),c.on("texttrackchange",q.bind(this,this.updateDisplay)),c.ready(q.bind(this,function(){if(c.tech_&&c.tech_.featuresNativeTextTracks)return void this.hide();c.on("fullscreenchange",q.bind(this,this.updateDisplay));for(var a=this.options_.playerOptions.tracks||[],b=0;b<a.length;b++){var d=a[b];this.player_.addRemoteTextTrack(d)}}))}return g(b,a),b.prototype.toggleDisplay=function(){this.player_.tech_&&this.player_.tech_.featuresNativeTextTracks?this.hide():this.show()},b.prototype.createEl=function(){return a.prototype.createEl.call(this,"div",{className:"vjs-text-track-display"})},b.prototype.clearDisplay=function(){"function"==typeof u.default.WebVTT&&u.default.WebVTT.processCues(u.default,[],this.el_)},b.prototype.updateDisplay=function(){var b=this.player_.textTracks();if(this.clearDisplay(),b)for(var c=0;c<b.length;c++){var d=b[c];"showing"===d.mode&&this.updateForTrack(d)}},b.prototype.updateForTrack=function(b){if("function"==typeof u.default.WebVTT&&b.activeCues){for(var c=this.player_.textTrackSettings.getValues(),d=[],e=0;e<b.activeCues.length;e++)d.push(b.activeCues[e]);u.default.WebVTT.processCues(u.default,b.activeCues,this.el_);for(var f=d.length;f--;){var g=d[f];if(g){var h=g.displayState;if(c.color&&(h.firstChild.style.color=c.color),c.textOpacity&&A(h.firstChild,"color",z(c.color||"#fff",c.textOpacity)),c.backgroundColor&&(h.firstChild.style.backgroundColor=c.backgroundColor),c.backgroundOpacity&&A(h.firstChild,"backgroundColor",z(c.backgroundColor||"#000",c.backgroundOpacity)),c.windowColor&&(c.windowOpacity?A(h,"backgroundColor",z(c.windowColor,c.windowOpacity)):h.style.backgroundColor=c.windowColor),c.edgeStyle&&("dropshadow"===c.edgeStyle?h.firstChild.style.textShadow="2px 2px 3px "+v+", 2px 2px 4px "+v+", 2px 2px 5px "+v:"raised"===c.edgeStyle?h.firstChild.style.textShadow="1px 1px "+v+", 2px 2px "+v+", 3px 3px "+v:"depressed"===c.edgeStyle?h.firstChild.style.textShadow="1px 1px "+w+", 0 1px "+w+", -1px -1px "+v+", 0 -1px "+v:"uniform"===c.edgeStyle&&(h.firstChild.style.textShadow="0 0 4px "+v+", 0 0 4px "+v+", 0 0 4px "+v+", 0 0 4px "+v)),c.fontPercent&&1!==c.fontPercent){var i=u.default.parseFloat(h.style.fontSize);h.style.fontSize=i*c.fontPercent+"px",h.style.height="auto",h.style.top="auto",h.style.bottom="2px"}c.fontFamily&&"default"!==c.fontFamily&&("small-caps"===c.fontFamily?h.firstChild.style.fontVariant="small-caps":h.firstChild.style.fontFamily=x[c.fontFamily])}}}},b}(i.default);i.default.registerComponent("TextTrackDisplay",y),c.default=y,b.exports=c.default},{"../component":66,"../menu/menu-button.js":103,"../menu/menu-item.js":104,"../menu/menu.js":105,"../utils/fn.js":133,"global/document":1,"global/window":2}],123:[function(a,b,c){"use strict";c.__esModule=!0;var d={disabled:"disabled",hidden:"hidden",showing:"showing"},e={subtitles:"subtitles",captions:"captions",descriptions:"descriptions",chapters:"chapters",metadata:"metadata"};c.TextTrackMode=d,c.TextTrackKind=e},{}],124:[function(a,b,c){"use strict";c.__esModule=!0;var d=function(b){var c=["kind","label","language","id","inBandMetadataTrackDispatchType","mode","src"].reduce(function(a,c,d){return b[c]&&(a[c]=b[c]),a},{cues:b.cues&&Array.prototype.map.call(b.cues,function(a){return{startTime:a.startTime,endTime:a.endTime,text:a.text,id:a.id}})});return c},e=function(b){var c=b.$$("track"),e=Array.prototype.map.call(c,function(a){return a.track}),f=Array.prototype.map.call(c,function(a){var b=d(a.track);return a.src&&(b.src=a.src),b});return f.concat(Array.prototype.filter.call(b.textTracks(),function(a){return e.indexOf(a)===-1}).map(d))},f=function(b,c){return b.forEach(function(a){var b=c.addRemoteTextTrack(a).track;!a.src&&a.cues&&a.cues.forEach(function(a){return b.addCue(a)})}),c.textTracks()};c.default={textTracksToJson:e,jsonToTextTracks:f,trackToJson_:d},b.exports=c.default},{}],125:[function(a,b,c){"use strict";function d(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function e(a){return a&&a.__esModule?a:{default:a}}function n(a){var b=this;if(k.IS_IE8){b=m.default.createElement("custom");for(var c in n.prototype)"constructor"!==c&&(b[c]=n.prototype[c])}a=a||[],b.tracks_=[],Object.defineProperty(b,"length",{get:function(){return this.tracks_.length}});for(var d=0;d<a.length;d++)b.addTrack_(a[d]);if(k.IS_IE8)return b}c.__esModule=!0;var f=a("../event-target"),g=e(f),h=a("../utils/fn.js"),i=d(h),j=a("../utils/browser.js"),k=d(j),l=a("global/document"),m=e(l);n.prototype=Object.create(g.default.prototype),n.prototype.constructor=n,n.prototype.allowedEvents_={change:"change",addtrack:"addtrack",removetrack:"removetrack"};for(var o in n.prototype.allowedEvents_)n.prototype["on"+o]=null;n.prototype.addTrack_=function(a){var b=this.tracks_.length;""+b in this||Object.defineProperty(this,b,{get:function(){return this.tracks_[b]}}),a.addEventListener("modechange",i.bind(this,function(){this.trigger("change")})),this.tracks_.push(a),this.trigger({type:"addtrack",track:a})},n.prototype.removeTrack_=function(a){for(var b=void 0,c=0,d=this.length;c<d;c++)if(this[c]===a){b=this[c],b.off&&b.off(),this.tracks_.splice(c,1);break}b&&this.trigger({type:"removetrack",track:b})},n.prototype.getTrackById=function(a){for(var b=null,c=0,d=this.length;c<d;c++){var e=this[c];if(e.id===a){b=e;break}}return b},c.default=n,b.exports=c.default},{"../event-target":98,"../utils/browser.js":128,"../utils/fn.js":133,"global/document":1}],126:[function(a,b,c){"use strict";function d(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function e(a){return a&&a.__esModule?a:{default:a}}function f(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function g(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}function u(a){var b=void 0;return a.selectedOptions?b=a.selectedOptions[0]:a.options&&(b=a.options[a.options.selectedIndex]),b.value}function v(a,b){if(b){var c=void 0;for(c=0;c<a.options.length;c++){var d=a.options[c];if(d.value===b)break}a.selectedIndex=c}}function w(){var a='<div class="vjs-tracksettings">\n      <div class="vjs-tracksettings-colors">\n        <div class="vjs-fg-color vjs-tracksetting">\n            <label class="vjs-label">Foreground</label>\n            <select>\n              <option value="">---</option>\n              <option value="#FFF">White</option>\n              <option value="#000">Black</option>\n              <option value="#F00">Red</option>\n              <option value="#0F0">Green</option>\n              <option value="#00F">Blue</option>\n              <option value="#FF0">Yellow</option>\n              <option value="#F0F">Magenta</option>\n              <option value="#0FF">Cyan</option>\n            </select>\n            <span class="vjs-text-opacity vjs-opacity">\n              <select>\n                <option value="">---</option>\n                <option value="1">Opaque</option>\n                <option value="0.5">Semi-Opaque</option>\n              </select>\n            </span>\n        </div> <!-- vjs-fg-color -->\n        <div class="vjs-bg-color vjs-tracksetting">\n            <label class="vjs-label">Background</label>\n            <select>\n              <option value="">---</option>\n              <option value="#FFF">White</option>\n              <option value="#000">Black</option>\n              <option value="#F00">Red</option>\n              <option value="#0F0">Green</option>\n              <option value="#00F">Blue</option>\n              <option value="#FF0">Yellow</option>\n              <option value="#F0F">Magenta</option>\n              <option value="#0FF">Cyan</option>\n            </select>\n            <span class="vjs-bg-opacity vjs-opacity">\n                <select>\n                  <option value="">---</option>\n                  <option value="1">Opaque</option>\n                  <option value="0.5">Semi-Transparent</option>\n                  <option value="0">Transparent</option>\n                </select>\n            </span>\n        </div> <!-- vjs-bg-color -->\n        <div class="window-color vjs-tracksetting">\n            <label class="vjs-label">Window</label>\n            <select>\n              <option value="">---</option>\n              <option value="#FFF">White</option>\n              <option value="#000">Black</option>\n              <option value="#F00">Red</option>\n              <option value="#0F0">Green</option>\n              <option value="#00F">Blue</option>\n              <option value="#FF0">Yellow</option>\n              <option value="#F0F">Magenta</option>\n              <option value="#0FF">Cyan</option>\n            </select>\n            <span class="vjs-window-opacity vjs-opacity">\n                <select>\n                  <option value="">---</option>\n                  <option value="1">Opaque</option>\n                  <option value="0.5">Semi-Transparent</option>\n                  <option value="0">Transparent</option>\n                </select>\n            </span>\n        </div> <!-- vjs-window-color -->\n      </div> <!-- vjs-tracksettings -->\n      <div class="vjs-tracksettings-font">\n        <div class="vjs-font-percent vjs-tracksetting">\n          <label class="vjs-label">Font Size</label>\n          <select>\n            <option value="0.50">50%</option>\n            <option value="0.75">75%</option>\n            <option value="1.00" selected>100%</option>\n            <option value="1.25">125%</option>\n            <option value="1.50">150%</option>\n            <option value="1.75">175%</option>\n            <option value="2.00">200%</option>\n            <option value="3.00">300%</option>\n            <option value="4.00">400%</option>\n          </select>\n        </div> <!-- vjs-font-percent -->\n        <div class="vjs-edge-style vjs-tracksetting">\n          <label class="vjs-label">Text Edge Style</label>\n          <select>\n            <option value="none">None</option>\n            <option value="raised">Raised</option>\n            <option value="depressed">Depressed</option>\n            <option value="uniform">Uniform</option>\n            <option value="dropshadow">Dropshadow</option>\n          </select>\n        </div> <!-- vjs-edge-style -->\n        <div class="vjs-font-family vjs-tracksetting">\n          <label class="vjs-label">Font Family</label>\n          <select>\n            <option value="">Default</option>\n            <option value="monospaceSerif">Monospace Serif</option>\n            <option value="proportionalSerif">Proportional Serif</option>\n            <option value="monospaceSansSerif">Monospace Sans-Serif</option>\n            <option value="proportionalSansSerif">Proportional Sans-Serif</option>\n            <option value="casual">Casual</option>\n            <option value="script">Script</option>\n            <option value="small-caps">Small Caps</option>\n          </select>\n        </div> <!-- vjs-font-family -->\n      </div>\n    </div>\n    <div class="vjs-tracksettings-controls">\n      <button class="vjs-default-button">Defaults</button>\n      <button class="vjs-done-button">Done</button>\n    </div>';return a}c.__esModule=!0;var h=a("../component"),i=e(h),j=a("../utils/events.js"),k=d(j),l=a("../utils/fn.js"),m=d(l),n=a("../utils/log.js"),o=e(n),p=a("safe-json-parse/tuple"),q=e(p),r=a("global/window"),s=e(r),t=function(a){function b(c,d){f(this,b),a.call(this,c,d),this.hide(),void 0===d.persistTextTrackSettings&&(this.options_.persistTextTrackSettings=this.options_.playerOptions.persistTextTrackSettings),k.on(this.$(".vjs-done-button"),"click",m.bind(this,function(){this.saveSettings(),this.hide()})),k.on(this.$(".vjs-default-button"),"click",m.bind(this,function(){this.$(".vjs-fg-color > select").selectedIndex=0,
this.$(".vjs-bg-color > select").selectedIndex=0,this.$(".window-color > select").selectedIndex=0,this.$(".vjs-text-opacity > select").selectedIndex=0,this.$(".vjs-bg-opacity > select").selectedIndex=0,this.$(".vjs-window-opacity > select").selectedIndex=0,this.$(".vjs-edge-style select").selectedIndex=0,this.$(".vjs-font-family select").selectedIndex=0,this.$(".vjs-font-percent select").selectedIndex=2,this.updateDisplay()})),k.on(this.$(".vjs-fg-color > select"),"change",m.bind(this,this.updateDisplay)),k.on(this.$(".vjs-bg-color > select"),"change",m.bind(this,this.updateDisplay)),k.on(this.$(".window-color > select"),"change",m.bind(this,this.updateDisplay)),k.on(this.$(".vjs-text-opacity > select"),"change",m.bind(this,this.updateDisplay)),k.on(this.$(".vjs-bg-opacity > select"),"change",m.bind(this,this.updateDisplay)),k.on(this.$(".vjs-window-opacity > select"),"change",m.bind(this,this.updateDisplay)),k.on(this.$(".vjs-font-percent select"),"change",m.bind(this,this.updateDisplay)),k.on(this.$(".vjs-edge-style select"),"change",m.bind(this,this.updateDisplay)),k.on(this.$(".vjs-font-family select"),"change",m.bind(this,this.updateDisplay)),this.options_.persistTextTrackSettings&&this.restoreSettings()}return g(b,a),b.prototype.createEl=function(){return a.prototype.createEl.call(this,"div",{className:"vjs-caption-settings vjs-modal-overlay",innerHTML:w()})},b.prototype.getValues=function(){var b=u(this.$(".vjs-edge-style select")),c=u(this.$(".vjs-font-family select")),d=u(this.$(".vjs-fg-color > select")),e=u(this.$(".vjs-text-opacity > select")),f=u(this.$(".vjs-bg-color > select")),g=u(this.$(".vjs-bg-opacity > select")),h=u(this.$(".window-color > select")),i=u(this.$(".vjs-window-opacity > select")),j=s.default.parseFloat(u(this.$(".vjs-font-percent > select"))),k={backgroundOpacity:g,textOpacity:e,windowOpacity:i,edgeStyle:b,fontFamily:c,color:d,backgroundColor:f,windowColor:h,fontPercent:j};for(var l in k)(""===k[l]||"none"===k[l]||"fontPercent"===l&&1===k[l])&&delete k[l];return k},b.prototype.setValues=function(b){v(this.$(".vjs-edge-style select"),b.edgeStyle),v(this.$(".vjs-font-family select"),b.fontFamily),v(this.$(".vjs-fg-color > select"),b.color),v(this.$(".vjs-text-opacity > select"),b.textOpacity),v(this.$(".vjs-bg-color > select"),b.backgroundColor),v(this.$(".vjs-bg-opacity > select"),b.backgroundOpacity),v(this.$(".window-color > select"),b.windowColor),v(this.$(".vjs-window-opacity > select"),b.windowOpacity);var c=b.fontPercent;c&&(c=c.toFixed(2)),v(this.$(".vjs-font-percent > select"),c)},b.prototype.restoreSettings=function(){var b=q.default(s.default.localStorage.getItem("vjs-text-track-settings")),c=b[0],d=b[1];c&&o.default.error(c),d&&this.setValues(d)},b.prototype.saveSettings=function(){if(this.options_.persistTextTrackSettings){var b=this.getValues();try{Object.getOwnPropertyNames(b).length>0?s.default.localStorage.setItem("vjs-text-track-settings",JSON.stringify(b)):s.default.localStorage.removeItem("vjs-text-track-settings")}catch(a){}}},b.prototype.updateDisplay=function(){var b=this.player_.getChild("textTrackDisplay");b&&b.updateDisplay()},b}(i.default);i.default.registerComponent("TextTrackSettings",t),c.default=t,b.exports=c.default},{"../component":66,"../utils/events.js":132,"../utils/fn.js":133,"../utils/log.js":136,"global/window":2,"safe-json-parse/tuple":53}],127:[function(a,b,c){"use strict";function d(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function e(a){return a&&a.__esModule?a:{default:a}}function A(){var a=arguments.length<=0||void 0===arguments[0]?{}:arguments[0];if(!a.tech)throw new Error("A tech was not provided.");var b=this;if(m.IS_IE8){b=u.default.createElement("custom");for(var c in A.prototype)"constructor"!==c&&(b[c]=A.prototype[c])}b.tech_=a.tech;var d=o.TextTrackMode[a.mode]||"disabled",e=o.TextTrackKind[a.kind]||"subtitles",f=a.label||"",h=a.language||a.srclang||"",j=a.id||"vjs_text_track_"+k.newGUID();"metadata"!==e&&"chapters"!==e||(d="hidden"),b.cues_=[],b.activeCues_=[];var l=new g.default(b.cues_),n=new g.default(b.activeCues_),p=!1,q=i.bind(b,function(){this.activeCues,p&&(this.trigger("cuechange"),p=!1)});if("disabled"!==d&&b.tech_.on("timeupdate",q),Object.defineProperty(b,"kind",{get:function(){return e},set:Function.prototype}),Object.defineProperty(b,"label",{get:function(){return f},set:Function.prototype}),Object.defineProperty(b,"language",{get:function(){return h},set:Function.prototype}),Object.defineProperty(b,"id",{get:function(){return j},set:Function.prototype}),Object.defineProperty(b,"mode",{get:function(){return d},set:function(b){o.TextTrackMode[b]&&(d=b,"showing"===d&&this.tech_.on("timeupdate",q),this.trigger("modechange"))}}),Object.defineProperty(b,"cues",{get:function(){return this.loaded_?l:null},set:Function.prototype}),Object.defineProperty(b,"activeCues",{get:function(){if(!this.loaded_)return null;if(0===this.cues.length)return n;for(var b=this.tech_.currentTime(),c=[],d=0,e=this.cues.length;d<e;d++){var f=this.cues[d];f.startTime<=b&&f.endTime>=b?c.push(f):f.startTime===f.endTime&&f.startTime<=b&&f.startTime+.5>=b&&c.push(f)}if(p=!1,c.length!==this.activeCues_.length)p=!0;else for(var d=0;d<c.length;d++)D.call(this.activeCues_,c[d])===-1&&(p=!0);return this.activeCues_=c,n.setCues_(this.activeCues_),n},set:Function.prototype}),a.src?(b.src=a.src,C(a.src,b)):b.loaded_=!0,m.IS_IE8)return b}c.__esModule=!0;var f=a("./text-track-cue-list"),g=e(f),h=a("../utils/fn.js"),i=d(h),j=a("../utils/guid.js"),k=d(j),l=a("../utils/browser.js"),m=d(l),n=a("./text-track-enums"),o=d(n),p=a("../utils/log.js"),q=e(p),r=a("../event-target"),s=e(r),t=a("global/document"),u=e(t),v=a("global/window"),w=e(v),x=a("../utils/url.js"),y=a("xhr"),z=e(y);A.prototype=Object.create(s.default.prototype),A.prototype.constructor=A,A.prototype.allowedEvents_={cuechange:"cuechange"},A.prototype.addCue=function(a){var b=this.tech_.textTracks();if(b)for(var c=0;c<b.length;c++)b[c]!==this&&b[c].removeCue(a);this.cues_.push(a),this.cues.setCues_(this.cues_)},A.prototype.removeCue=function(a){for(var b=!1,c=0,d=this.cues_.length;c<d;c++){var e=this.cues_[c];e===a&&(this.cues_.splice(c,1),b=!0)}b&&this.cues.setCues_(this.cues_)};var B=function(b,c){var d=new w.default.WebVTT.Parser(w.default,w.default.vttjs,w.default.WebVTT.StringDecoder());d.oncue=function(a){c.addCue(a)},d.onparsingerror=function(a){q.default.error(a)},d.onflush=function(){c.trigger({type:"loadeddata",target:c})},d.parse(b),d.flush()},C=function(b,c){var d={uri:b},e=x.isCrossOrigin(b);e&&(d.cors=e),z.default(d,i.bind(this,function(a,b,d){return a?q.default.error(a,b):(c.loaded_=!0,void("function"!=typeof w.default.WebVTT?w.default.setTimeout(function(){B(d,c)},100):B(d,c)))}))},D=function(b,c){if(null==this)throw new TypeError('"this" is null or not defined');var d=Object(this),e=d.length>>>0;if(0===e)return-1;var f=+c||0;if(Math.abs(f)===1/0&&(f=0),f>=e)return-1;for(var g=Math.max(f>=0?f:e-Math.abs(f),0);g<e;){if(g in d&&d[g]===b)return g;g++}return-1};c.default=A,b.exports=c.default},{"../event-target":98,"../utils/browser.js":128,"../utils/fn.js":133,"../utils/guid.js":135,"../utils/log.js":136,"../utils/url.js":141,"./text-track-cue-list":121,"./text-track-enums":123,"global/document":1,"global/window":2,xhr:55}],128:[function(a,b,c){"use strict";function d(a){return a&&a.__esModule?a:{default:a}}c.__esModule=!0;var e=a("global/document"),f=d(e),g=a("global/window"),h=d(g),i=h.default.navigator.userAgent,j=/AppleWebKit\/([\d.]+)/i.exec(i),k=j?parseFloat(j.pop()):null,l=/iPad/i.test(i);c.IS_IPAD=l;var m=/iPhone/i.test(i)&&!l;c.IS_IPHONE=m;var n=/iPod/i.test(i);c.IS_IPOD=n;var o=m||l||n;c.IS_IOS=o;var p=function(){var a=i.match(/OS (\d+)_/i);if(a&&a[1])return a[1]}();c.IOS_VERSION=p;var q=/Android/i.test(i);c.IS_ANDROID=q;var r=function(){var b,c,a=i.match(/Android (\d+)(?:\.(\d+))?(?:\.(\d+))*/i);return a?(b=a[1]&&parseFloat(a[1]),c=a[2]&&parseFloat(a[2]),b&&c?parseFloat(a[1]+"."+a[2]):b?b:null):null}();c.ANDROID_VERSION=r;var s=q&&/webkit/i.test(i)&&r<2.3;c.IS_OLD_ANDROID=s;var t=q&&r<5&&k<537;c.IS_NATIVE_ANDROID=t;var u=/Firefox/i.test(i);c.IS_FIREFOX=u;var v=/Chrome/i.test(i);c.IS_CHROME=v;var w=/MSIE\s8\.0/.test(i);c.IS_IE8=w;var x=!!("ontouchstart"in h.default||h.default.DocumentTouch&&f.default instanceof h.default.DocumentTouch);c.TOUCH_ENABLED=x;var y="backgroundSize"in f.default.createElement("video").style;c.BACKGROUND_SIZE_SUPPORTED=y},{"global/document":1,"global/window":2}],129:[function(a,b,c){"use strict";function e(a,b){var e,f,c=0;if(!b)return 0;a&&a.length||(a=d.createTimeRange(0,0));for(var g=0;g<a.length;g++)e=a.start(g),f=a.end(g),f>b&&(f=b),c+=f-e;return c/b}c.__esModule=!0,c.bufferedPercent=e;var d=a("./time-ranges.js")},{"./time-ranges.js":139}],130:[function(a,b,c){"use strict";function d(a){return a&&a.__esModule?a:{default:a}}c.__esModule=!0;var e=a("./log.js"),f=d(e),g={get:function(b,c){return b[c]},set:function(b,c,d){return b[c]=d,!0}};c.default=function(a){var b=arguments.length<=1||void 0===arguments[1]?{}:arguments[1];if("function"==typeof Proxy){var c=function(){var c={};return Object.keys(b).forEach(function(a){g.hasOwnProperty(a)&&(c[a]=function(){return f.default.warn(b[a]),g[a].apply(this,arguments)})}),{v:new Proxy(a,c)}}();if("object"==typeof c)return c.v}return a},b.exports=c.default},{"./log.js":136}],131:[function(a,b,c){"use strict";function e(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function f(a){return a&&a.__esModule?a:{default:a}}function g(a,b){return a.raw=b,a}function r(a){return"string"==typeof a&&/\S/.test(a)}function s(a){if(/\s/.test(a))throw new Error("class has illegal whitespace characters")}function t(a){return new RegExp("(^|\\s)"+a+"($|\\s)")}function u(a){return function(b,c){return r(b)?(r(c)&&(c=i.default.querySelector(c)),(O(c)?c:i.default)[a](b)):i.default[a](null)}}function v(a){return 0===a.indexOf("#")&&(a=a.slice(1)),i.default.getElementById(a)}function w(){var a=arguments.length<=0||void 0===arguments[0]?"div":arguments[0],b=arguments.length<=1||void 0===arguments[1]?{}:arguments[1],c=arguments.length<=2||void 0===arguments[2]?{}:arguments[2],e=i.default.createElement(a);return Object.getOwnPropertyNames(b).forEach(function(a){var c=b[a];a.indexOf("aria-")!==-1||"role"===a||"type"===a?(o.default.warn(q.default(d,a,c)),e.setAttribute(a,c)):e[a]=c}),Object.getOwnPropertyNames(c).forEach(function(a){c[a];e.setAttribute(a,c[a])}),e}function x(a,b){"undefined"==typeof a.textContent?a.innerText=b:a.textContent=b}function y(a,b){b.firstChild?b.insertBefore(a,b.firstChild):b.appendChild(a)}function B(a){var b=a[A];return b||(b=a[A]=m.newGUID()),z[b]||(z[b]={}),z[b]}function C(a){var b=a[A];return!!b&&!!Object.getOwnPropertyNames(z[b]).length}function D(a){var b=a[A];if(b){delete z[b];try{delete a[A]}catch(b){a.removeAttribute?a.removeAttribute(A):a[A]=null}}}function E(a,b){return a.classList?a.classList.contains(b):(s(b),t(b).test(a.className))}function F(a,b){return a.classList?a.classList.add(b):E(a,b)||(a.className=(a.className+" "+b).trim()),a}function G(a,b){return a.classList?a.classList.remove(b):(s(b),a.className=a.className.split(/\s+/).filter(function(a){return a!==b}).join(" ")),a}function H(a,b,c){var d=E(a,b);if("function"==typeof c&&(c=c(a,b)),"boolean"!=typeof c&&(c=!d),c!==d)return c?F(a,b):G(a,b),a}function I(a,b){Object.getOwnPropertyNames(b).forEach(function(c){var d=b[c];null===d||"undefined"==typeof d||d===!1?a.removeAttribute(c):a.setAttribute(c,d===!0?"":d)})}function J(a){var b,c,d,e,f;if(b={},c=",autoplay,controls,loop,muted,default,",a&&a.attributes&&a.attributes.length>0){d=a.attributes;for(var g=d.length-1;g>=0;g--)e=d[g].name,f=d[g].value,"boolean"!=typeof a[e]&&c.indexOf(","+e+",")===-1||(f=null!==f),b[e]=f}return b}function K(){i.default.body.focus(),i.default.onselectstart=function(){return!1}}function L(){i.default.onselectstart=function(){return!0}}function M(a){var b=void 0;if(a.getBoundingClientRect&&a.parentNode&&(b=a.getBoundingClientRect()),!b)return{left:0,top:0};var c=i.default.documentElement,d=i.default.body,e=c.clientLeft||d.clientLeft||0,f=k.default.pageXOffset||d.scrollLeft,g=b.left+f-e,h=c.clientTop||d.clientTop||0,j=k.default.pageYOffset||d.scrollTop,l=b.top+j-h;return{left:Math.round(g),top:Math.round(l)}}function N(a,b){var c={},d=M(a),e=a.offsetWidth,f=a.offsetHeight,g=d.top,h=d.left,i=b.pageY,j=b.pageX;return b.changedTouches&&(j=b.changedTouches[0].pageX,i=b.changedTouches[0].pageY),c.y=Math.max(0,Math.min(1,(g-i+f)/f)),c.x=Math.max(0,Math.min(1,(j-h)/e)),c}function O(a){return!!a&&"object"==typeof a&&1===a.nodeType}function P(a){return!!a&&"object"==typeof a&&3===a.nodeType}function Q(a){for(;a.firstChild;)a.removeChild(a.firstChild);return a}function R(a){return"function"==typeof a&&(a=a()),(Array.isArray(a)?a:[a]).map(function(a){return"function"==typeof a&&(a=a()),O(a)||P(a)?a:"string"==typeof a&&/\S/.test(a)?i.default.createTextNode(a):void 0}).filter(function(a){return a})}function S(a,b){return R(b).forEach(function(b){return a.appendChild(b)}),a}function T(a,b){return S(Q(a),b)}c.__esModule=!0,c.getEl=v,c.createEl=w,c.textContent=x,c.insertElFirst=y,c.getElData=B,c.hasElData=C,c.removeElData=D,c.hasElClass=E,c.addElClass=F,c.removeElClass=G,c.toggleElClass=H,c.setElAttributes=I,c.getElAttributes=J,c.blockTextSelection=K,c.unblockTextSelection=L,c.findElPosition=M,c.getPointerPosition=N,c.isEl=O,c.isTextNode=P,c.emptyEl=Q,c.normalizeContent=R,c.appendContent=S,c.insertContent=T;var d=g(["Setting attributes in the second argument of createEl()\n                has been deprecated. Use the third argument instead.\n                createEl(type, properties, attributes). Attempting to set "," to ","."],["Setting attributes in the second argument of createEl()\n                has been deprecated. Use the third argument instead.\n                createEl(type, properties, attributes). Attempting to set "," to ","."]),h=a("global/document"),i=f(h),j=a("global/window"),k=f(j),l=a("./guid.js"),m=e(l),n=a("./log.js"),o=f(n),p=a("tsml"),q=f(p),z={},A="vdata"+(new Date).getTime(),U=u("querySelector");c.$=U;var V=u("querySelectorAll");c.$$=V},{"./guid.js":135,"./log.js":136,"global/document":1,"global/window":2,tsml:54}],132:[function(a,b,c){"use strict";function d(a){return a&&a.__esModule?a:{default:a}}function e(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function n(a,b,c){if(Array.isArray(b))return t(n,a,b,c);var d=g.getElData(a);d.handlers||(d.handlers={}),d.handlers[b]||(d.handlers[b]=[]),c.guid||(c.guid=i.newGUID()),d.handlers[b].push(c),d.dispatcher||(d.disabled=!1,d.dispatcher=function(b,c){if(!d.disabled){b=r(b);var e=d.handlers[b.type];if(e)for(var f=e.slice(0),g=0,h=f.length;g<h&&!b.isImmediatePropagationStopped();g++)f[g].call(a,b,c)}}),1===d.handlers[b].length&&(a.addEventListener?a.addEventListener(b,d.dispatcher,!1):a.attachEvent&&a.attachEvent("on"+b,d.dispatcher))}function o(a,b,c){if(g.hasElData(a)){var d=g.getElData(a);if(d.handlers){if(Array.isArray(b))return t(o,a,b,c);var e=function(c){d.handlers[c]=[],s(a,c)};if(b){var h=d.handlers[b];if(h){if(!c)return void e(b);if(c.guid)for(var i=0;i<h.length;i++)h[i].guid===c.guid&&h.splice(i--,1);s(a,b)}}else for(var f in d.handlers)e(f)}}}function p(a,b,c){var d=g.hasElData(a)?g.getElData(a):{},e=a.parentNode||a.ownerDocument;if("string"==typeof b&&(b={type:b,target:a}),b=r(b),d.dispatcher&&d.dispatcher.call(a,b,c),e&&!b.isPropagationStopped()&&b.bubbles===!0)p.call(null,e,b,c);else if(!e&&!b.defaultPrevented){var f=g.getElData(b.target);b.target[b.type]&&(f.disabled=!0,"function"==typeof b.target[b.type]&&b.target[b.type](),f.disabled=!1)}return!b.defaultPrevented}function q(a,b,c){if(Array.isArray(b))return t(q,a,b,c);var d=function d(){o(a,b,d),c.apply(this,arguments)};d.guid=c.guid=c.guid||i.newGUID(),n(a,b,d)}function r(a){function b(){return!0}function c(){return!1}if(!a||!a.isPropagationStopped){var d=a||k.default.event;a={};for(var e in d)"layerX"!==e&&"layerY"!==e&&"keyLocation"!==e&&"webkitMovementX"!==e&&"webkitMovementY"!==e&&("returnValue"===e&&d.preventDefault||(a[e]=d[e]));if(a.target||(a.target=a.srcElement||m.default),a.relatedTarget||(a.relatedTarget=a.fromElement===a.target?a.toElement:a.fromElement),a.preventDefault=function(){d.preventDefault&&d.preventDefault(),a.returnValue=!1,d.returnValue=!1,a.defaultPrevented=!0},a.defaultPrevented=!1,a.stopPropagation=function(){d.stopPropagation&&d.stopPropagation(),a.cancelBubble=!0,d.cancelBubble=!0,a.isPropagationStopped=b},a.isPropagationStopped=c,a.stopImmediatePropagation=function(){d.stopImmediatePropagation&&d.stopImmediatePropagation(),a.isImmediatePropagationStopped=b,a.stopPropagation()},a.isImmediatePropagationStopped=c,null!=a.clientX){var f=m.default.documentElement,g=m.default.body;a.pageX=a.clientX+(f&&f.scrollLeft||g&&g.scrollLeft||0)-(f&&f.clientLeft||g&&g.clientLeft||0),a.pageY=a.clientY+(f&&f.scrollTop||g&&g.scrollTop||0)-(f&&f.clientTop||g&&g.clientTop||0)}a.which=a.charCode||a.keyCode,null!=a.button&&(a.button=1&a.button?0:4&a.button?1:2&a.button?2:0)}return a}function s(a,b){var c=g.getElData(a);0===c.handlers[b].length&&(delete c.handlers[b],a.removeEventListener?a.removeEventListener(b,c.dispatcher,!1):a.detachEvent&&a.detachEvent("on"+b,c.dispatcher)),Object.getOwnPropertyNames(c.handlers).length<=0&&(delete c.handlers,delete c.dispatcher,delete c.disabled),0===Object.getOwnPropertyNames(c).length&&g.removeElData(a)}function t(a,b,c,d){c.forEach(function(c){a(b,c,d)})}c.__esModule=!0,c.on=n,c.off=o,c.trigger=p,c.one=q,c.fixEvent=r;var f=a("./dom.js"),g=e(f),h=a("./guid.js"),i=e(h),j=a("global/window"),k=d(j),l=a("global/document"),m=d(l)},{"./dom.js":131,"./guid.js":135,"global/document":1,"global/window":2}],133:[function(a,b,c){"use strict";c.__esModule=!0;var d=a("./guid.js"),e=function(b,c,e){c.guid||(c.guid=d.newGUID());var f=function(){return c.apply(b,arguments)};return f.guid=e?e+"_"+c.guid:c.guid,f};c.bind=e},{"./guid.js":135}],134:[function(a,b,c){"use strict";function d(a){var b=arguments.length<=1||void 0===arguments[1]?a:arguments[1];return function(){a=a<0?0:a;var c=Math.floor(a%60),d=Math.floor(a/60%60),e=Math.floor(a/3600),f=Math.floor(b/60%60),g=Math.floor(b/3600);return(isNaN(a)||a===1/0)&&(e=d=c="-"),e=e>0||g>0?e+":":"",d=((e||f>=10)&&d<10?"0"+d:d)+":",c=c<10?"0"+c:c,e+d+c}()}c.__esModule=!0,c.default=d,b.exports=c.default},{}],135:[function(a,b,c){"use strict";function e(){return d++}c.__esModule=!0,c.newGUID=e;var d=1},{}],136:[function(a,b,c){"use strict";function d(a){return a&&a.__esModule?a:{default:a}}function h(a,b){var c=Array.prototype.slice.call(b),d=function(){},e=f.default.console||{log:d,warn:d,error:d};a?c.unshift(a.toUpperCase()+":"):a="log",g.history.push(c),c.unshift("VIDEOJS:"),e[a].apply?e[a].apply(e,c):e[a](c.join(" "))}c.__esModule=!0;var e=a("global/window"),f=d(e),g=function(){h(null,arguments)};g.history=[],g.error=function(){h("error",arguments)},g.warn=function(){h("warn",arguments)},c.default=g,b.exports=c.default},{"global/window":2}],137:[function(a,b,c){"use strict";function d(a){return a&&a.__esModule?a:{default:a}}function g(a){return!!a&&"object"==typeof a&&"[object Object]"===a.toString()&&a.constructor===Object}function i(){var a=Array.prototype.slice.call(arguments);return a.unshift({}),a.push(h),f.default.apply(null,a),a[0]}c.__esModule=!0,c.default=i;var e=a("lodash-compat/object/merge"),f=d(e),h=function(b,c){return g(c)?g(b)?void 0:i(c):c};b.exports=c.default},{"lodash-compat/object/merge":40}],138:[function(a,b,c){"use strict";function d(a){return a&&a.__esModule?a:{default:a}}c.__esModule=!0;var e=a("global/document"),f=d(e),g=function(b){var c=f.default.createElement("style");return c.className=b,c};c.createStyleElement=g;var h=function(b,c){b.styleSheet?b.styleSheet.cssText=c:b.textContent=c};c.setTextContent=h},{"global/document":1}],139:[function(a,b,c){"use strict";function d(a){return a&&a.__esModule?a:{default:a}}function g(a,b){return Array.isArray(a)?h(a):void 0===a||void 0===b?h():h([[a,b]])}function h(a){return void 0===a||0===a.length?{length:0,start:function(){throw new Error("This TimeRanges object is empty")},end:function(){throw new Error("This TimeRanges object is empty")}}:{length:a.length,start:i.bind(null,"start",0,a),end:i.bind(null,"end",1,a)}}function i(a,b,c,d){return void 0===d&&(f.default.warn("DEPRECATED: Function '"+a+"' on 'TimeRanges' called without an index argument."),d=0),j(a,d,c.length-1),c[d][b]}function j(a,b,c){if(b<0||b>c)throw new Error("Failed to execute '"+a+"' on 'TimeRanges': The index provided ("+b+") is greater than or equal to the maximum bound ("+c+").")}c.__esModule=!0,c.createTimeRanges=g;var e=a("./log.js"),f=d(e);c.createTimeRange=g},{"./log.js":136}],140:[function(a,b,c){"use strict";function d(a){return a.charAt(0).toUpperCase()+a.slice(1)}c.__esModule=!0,c.default=d,b.exports=c.default},{}],141:[function(a,b,c){"use strict";function d(a){return a&&a.__esModule?a:{default:a}}c.__esModule=!0;var e=a("global/document"),f=d(e),g=a("global/window"),h=d(g),i=function(b){var c=["protocol","hostname","port","pathname","search","hash","host"],d=f.default.createElement("a");d.href=b;var e=""===d.host&&"file:"!==d.protocol,g=void 0;e&&(g=f.default.createElement("div"),g.innerHTML='<a href="'+b+'"></a>',d=g.firstChild,g.setAttribute("style","display:none; position:absolute;"),f.default.body.appendChild(g));for(var h={},i=0;i<c.length;i++)h[c[i]]=d[c[i]];return"http:"===h.protocol&&(h.host=h.host.replace(/:80$/,"")),"https:"===h.protocol&&(h.host=h.host.replace(/:443$/,"")),e&&f.default.body.removeChild(g),h};c.parseUrl=i;var j=function(b){if(!b.match(/^https?:\/\//)){var c=f.default.createElement("div");c.innerHTML='<a href="'+b+'">x</a>',b=c.firstChild.href}return b};c.getAbsoluteURL=j;var k=function(b){if("string"==typeof b){var c=/^(\/?)([\s\S]*?)((?:\.{1,2}|[^\/]+?)(\.([^\.\/\?]+)))(?:[\/]*|[\?].*)$/i,d=c.exec(b);if(d)return d.pop().toLowerCase()}return""};c.getFileExtension=k;var l=function(b){var c=h.default.location,d=i(b),e=":"===d.protocol?c.protocol:d.protocol,f=e+d.host!==c.protocol+c.host;return f};c.isCrossOrigin=l},{"global/document":1,"global/window":2}],142:[function(b,c,d){"use strict";function e(a){if(a&&a.__esModule)return a;var b={};if(null!=a)for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&(b[c]=a[c]);return b.default=a,b}function f(a){return a&&a.__esModule?a:{default:a}}d.__esModule=!0;var g=b("global/document"),h=f(g),i=b("./setup"),j=e(i),k=b("./utils/stylesheet.js"),l=e(k),m=b("./component"),n=f(m),o=b("./event-target"),p=f(o),q=b("./utils/events.js"),r=e(q),s=b("./player"),t=f(s),u=b("./plugins.js"),v=f(u),w=b("../../src/js/utils/merge-options.js"),x=f(w),y=b("./utils/fn.js"),z=e(y),A=b("./tracks/text-track.js"),B=f(A),C=b("object.assign"),E=(f(C),b("./utils/time-ranges.js")),F=b("./utils/format-time.js"),G=f(F),H=b("./utils/log.js"),I=f(H),J=b("./utils/dom.js"),K=e(J),L=b("./utils/browser.js"),M=e(L),N=b("./utils/url.js"),O=e(N),P=b("./extend.js"),Q=f(P),R=b("lodash-compat/object/merge"),S=f(R),T=b("./utils/create-deprecation-proxy.js"),U=f(T),V=b("xhr"),W=f(V),X=b("./tech/tech.js"),Y=f(X),Z=b("./tech/html5.js"),_=(f(Z),b("./tech/flash.js"));f(_);"undefined"==typeof HTMLVideoElement&&(h.default.createElement("video"),h.default.createElement("audio"),h.default.createElement("track"));var ba=function a(b,c,d){var e=void 0;if("string"==typeof b){if(0===b.indexOf("#")&&(b=b.slice(1)),a.getPlayers()[b])return c&&I.default.warn('Player "'+b+'" is already initialised. Options will not be applied.'),d&&a.getPlayers()[b].ready(d),a.getPlayers()[b];e=K.getEl(b)}else e=b;if(!e||!e.nodeName)throw new TypeError("The element or ID supplied is not valid. (videojs)");return e.player||t.default.players[e.playerId]||new t.default(e,c,d)},ca=K.$(".vjs-styles-defaults");if(!ca){ca=l.createStyleElement("vjs-styles-defaults");var da=K.$("head");da.insertBefore(ca,da.firstChild)}j.autoSetupTimeout(1,ba),ba.VERSION="5.7.1",ba.options=t.default.prototype.options_,ba.getPlayers=function(){return t.default.players},ba.players=U.default(t.default.players,{get:"Access to videojs.players is deprecated; use videojs.getPlayers instead",set:"Modification of videojs.players is deprecated"}),ba.getComponent=n.default.getComponent,ba.registerComponent=function(a,b){Y.default.isTech(b)&&I.default.warn("The "+a+" tech was registered as a component. It should instead be registered using videojs.registerTech(name, tech)"),n.default.registerComponent.call(n.default,a,b)},ba.getTech=Y.default.getTech,ba.registerTech=Y.default.registerTech,ba.browser=M,ba.TOUCH_ENABLED=M.TOUCH_ENABLED,ba.extend=Q.default,ba.mergeOptions=x.default,ba.bind=z.bind,ba.plugin=v.default,ba.addLanguage=function(a,b){var c;return a=(""+a).toLowerCase(),S.default(ba.options.languages,(c={},c[a]=b,c))[a]},ba.log=I.default,ba.createTimeRange=ba.createTimeRanges=E.createTimeRanges,ba.formatTime=G.default,ba.parseUrl=O.parseUrl,ba.isCrossOrigin=O.isCrossOrigin,ba.EventTarget=p.default,ba.on=r.on,ba.one=r.one,ba.off=r.off,ba.trigger=r.trigger,ba.xhr=W.default,ba.TextTrack=B.default,ba.isEl=K.isEl,ba.isTextNode=K.isTextNode,ba.createEl=K.createEl,ba.hasClass=K.hasElClass,ba.addClass=K.addElClass,ba.removeClass=K.removeElClass,ba.toggleClass=K.toggleElClass,ba.setAttributes=K.setElAttributes,ba.getAttributes=K.getElAttributes,ba.emptyEl=K.emptyEl,ba.appendContent=K.appendContent,ba.insertContent=K.insertContent,"function"==typeof a&&a.amd?a("videojs",[],function(){return ba}):"object"==typeof d&&"object"==typeof c&&(c.exports=ba),d.default=ba,c.exports=d.default},{"../../src/js/utils/merge-options.js":137,"./component":66,"./event-target":98,"./extend.js":99,"./player":107,"./plugins.js":108,"./setup":112,"./tech/flash.js":115,"./tech/html5.js":116,"./tech/tech.js":118,"./tracks/text-track.js":127,"./utils/browser.js":128,"./utils/create-deprecation-proxy.js":130,"./utils/dom.js":131,"./utils/events.js":132,"./utils/fn.js":133,"./utils/format-time.js":134,"./utils/log.js":136,"./utils/stylesheet.js":138,"./utils/time-ranges.js":139,"./utils/url.js":141,"global/document":1,"lodash-compat/object/merge":40,"object.assign":45,xhr:55}]},{},[142])(142)}),function(a){var b=a.vttjs={},c=b.VTTCue,d=b.VTTRegion,e=a.VTTCue,f=a.VTTRegion;b.shim=function(){b.VTTCue=c,b.VTTRegion=d},b.restore=function(){b.VTTCue=e,b.VTTRegion=f}}(this),function(a,b){function f(a){if("string"!=typeof a)return!1;var b=d[a.toLowerCase()];return!!b&&a.toLowerCase()}function g(a){if("string"!=typeof a)return!1;var b=e[a.toLowerCase()];return!!b&&a.toLowerCase()}function h(a){for(var b=1;b<arguments.length;b++){var c=arguments[b];for(var d in c)a[d]=c[d]}return a}function i(a,b,d){var e=this,i=/MSIE\s8\.0/.test(navigator.userAgent),j={};i?e=document.createElement("custom"):j.enumerable=!0,e.hasBeenReset=!1;var k="",l=!1,m=a,n=b,o=d,p=null,q="",r=!0,s="auto",t="start",u=50,v="middle",w=50,x="middle";if(Object.defineProperty(e,"id",h({},j,{get:function(){return k},set:function(a){k=""+a}})),Object.defineProperty(e,"pauseOnExit",h({},j,{get:function(){return l},set:function(a){l=!!a}})),Object.defineProperty(e,"startTime",h({},j,{get:function(){return m},set:function(a){if("number"!=typeof a)throw new TypeError("Start time must be set to a number.");m=a,this.hasBeenReset=!0}})),Object.defineProperty(e,"endTime",h({},j,{get:function(){return n},set:function(a){if("number"!=typeof a)throw new TypeError("End time must be set to a number.");n=a,this.hasBeenReset=!0}})),Object.defineProperty(e,"text",h({},j,{get:function(){return o},set:function(a){o=""+a,this.hasBeenReset=!0}})),Object.defineProperty(e,"region",h({},j,{get:function(){return p},set:function(a){p=a,this.hasBeenReset=!0}})),Object.defineProperty(e,"vertical",h({},j,{get:function(){return q},set:function(a){var b=f(a);if(b===!1)throw new SyntaxError("An invalid or illegal string was specified.");q=b,this.hasBeenReset=!0}})),Object.defineProperty(e,"snapToLines",h({},j,{get:function(){return r},set:function(a){r=!!a,this.hasBeenReset=!0}})),Object.defineProperty(e,"line",h({},j,{get:function(){return s},set:function(a){if("number"!=typeof a&&a!==c)throw new SyntaxError("An invalid number or illegal string was specified.");s=a,this.hasBeenReset=!0}})),Object.defineProperty(e,"lineAlign",h({},j,{get:function(){return t},set:function(a){var b=g(a);if(!b)throw new SyntaxError("An invalid or illegal string was specified.");t=b,this.hasBeenReset=!0}})),Object.defineProperty(e,"position",h({},j,{get:function(){return u},set:function(a){if(a<0||a>100)throw new Error("Position must be between 0 and 100.");u=a,this.hasBeenReset=!0}})),Object.defineProperty(e,"positionAlign",h({},j,{get:function(){return v},set:function(a){var b=g(a);if(!b)throw new SyntaxError("An invalid or illegal string was specified.");v=b,this.hasBeenReset=!0}})),Object.defineProperty(e,"size",h({},j,{get:function(){return w},set:function(a){if(a<0||a>100)throw new Error("Size must be between 0 and 100.");w=a,this.hasBeenReset=!0}})),Object.defineProperty(e,"align",h({},j,{get:function(){return x},set:function(a){var b=g(a);if(!b)throw new SyntaxError("An invalid or illegal string was specified.");x=b,this.hasBeenReset=!0}})),e.displayState=void 0,i)return e}var c="auto",d={"":!0,lr:!0,rl:!0},e={start:!0,middle:!0,end:!0,left:!0,right:!0};i.prototype.getCueAsHTML=function(){return WebVTT.convertCueToDOMTree(window,this.text)},a.VTTCue=a.VTTCue||i,b.VTTCue=i}(this,this.vttjs||{}),function(a,b){function d(a){if("string"!=typeof a)return!1;var b=c[a.toLowerCase()];return!!b&&a.toLowerCase()}function e(a){return"number"==typeof a&&a>=0&&a<=100}function f(){var a=100,b=3,c=0,f=100,g=0,h=100,i="";Object.defineProperties(this,{width:{enumerable:!0,get:function(){return a},set:function(b){if(!e(b))throw new Error("Width must be between 0 and 100.");a=b}},lines:{enumerable:!0,get:function(){return b},set:function(a){if("number"!=typeof a)throw new TypeError("Lines must be set to a number.");b=a}},regionAnchorY:{enumerable:!0,get:function(){return f},set:function(a){if(!e(a))throw new Error("RegionAnchorX must be between 0 and 100.");f=a}},regionAnchorX:{enumerable:!0,get:function(){return c},set:function(a){if(!e(a))throw new Error("RegionAnchorY must be between 0 and 100.");c=a}},viewportAnchorY:{enumerable:!0,get:function(){return h},set:function(a){if(!e(a))throw new Error("ViewportAnchorY must be between 0 and 100.");h=a}},viewportAnchorX:{enumerable:!0,get:function(){return g},set:function(a){if(!e(a))throw new Error("ViewportAnchorX must be between 0 and 100.");g=a}},scroll:{enumerable:!0,get:function(){return i},set:function(a){var b=d(a);if(b===!1)throw new SyntaxError("An invalid or illegal string was specified.");i=b}}})}var c={"":!0,up:!0};a.VTTRegion=a.VTTRegion||f,b.VTTRegion=f}(this,this.vttjs||{}),function(a){function c(a,b){this.name="ParsingError",this.code=a.code,this.message=b||a.message}function d(a){function b(a,b,c,d){return 3600*(0|a)+60*(0|b)+(0|c)+(0|d)/1e3}var c=a.match(/^(\d+):(\d{2})(:\d{2})?\.(\d{3})/);return c?c[3]?b(c[1],c[2],c[3].replace(":",""),c[4]):c[1]>59?b(c[1],c[2],0,c[4]):b(0,c[1],c[2],c[4]):null}function e(){this.values=b(null)}function f(a,b,c,d){var e=d?a.split(d):[a];for(var f in e)if("string"==typeof e[f]){var g=e[f].split(c);if(2===g.length){var h=g[0],i=g[1];b(h,i)}}}function g(a,b,g){function i(){var b=d(a);if(null===b)throw new c(c.Errors.BadTimeStamp,"Malformed timestamp: "+h);return a=a.replace(/^[^\sa-zA-Z-]+/,""),b}function j(a,b){var c=new e;f(a,function(a,b){switch(a){case"region":for(var d=g.length-1;d>=0;d--)if(g[d].id===b){c.set(a,g[d].region);break}break;case"vertical":c.alt(a,b,["rl","lr"]);break;case"line":
var e=b.split(","),f=e[0];c.integer(a,f),c.percent(a,f)?c.set("snapToLines",!1):null,c.alt(a,f,["auto"]),2===e.length&&c.alt("lineAlign",e[1],["start","middle","end"]);break;case"position":e=b.split(","),c.percent(a,e[0]),2===e.length&&c.alt("positionAlign",e[1],["start","middle","end"]);break;case"size":c.percent(a,b);break;case"align":c.alt(a,b,["start","middle","end","left","right"])}},/:/,/\s/),b.region=c.get("region",null),b.vertical=c.get("vertical",""),b.line=c.get("line","auto"),b.lineAlign=c.get("lineAlign","start"),b.snapToLines=c.get("snapToLines",!0),b.size=c.get("size",100),b.align=c.get("align","middle"),b.position=c.get("position",{start:0,left:0,middle:50,end:100,right:100},b.align),b.positionAlign=c.get("positionAlign",{start:"start",left:"start",middle:"middle",end:"end",right:"end"},b.align)}function k(){a=a.replace(/^\s+/,"")}var h=a;if(k(),b.startTime=i(),k(),"-->"!==a.substr(0,3))throw new c(c.Errors.BadTimeStamp,"Malformed time stamp (time stamps must be separated by '-->'): "+h);a=a.substr(3),k(),b.endTime=i(),k(),j(a,b)}function l(a,b){function c(){function a(a){return b=b.substr(a.length),a}if(!b)return null;var c=b.match(/^([^<]*)(<[^>]+>?)?/);return a(c[1]?c[1]:c[2])}function e(a){return h[a]}function f(a){for(;s=a.match(/&(amp|lt|gt|lrm|rlm|nbsp);/);)a=a.replace(s[0],e);return a}function g(a,b){return!k[b.localName]||k[b.localName]===a.localName}function l(b,c){var d=i[b];if(!d)return null;var e=a.document.createElement(d);e.localName=d;var f=j[b];return f&&c&&(e[f]=c.trim()),e}for(var o,m=a.document.createElement("div"),n=m,p=[];null!==(o=c());)if("<"!==o[0])n.appendChild(a.document.createTextNode(f(o)));else{if("/"===o[1]){p.length&&p[p.length-1]===o.substr(2).replace(">","")&&(p.pop(),n=n.parentNode);continue}var r,q=d(o.substr(1,o.length-2));if(q){r=a.document.createProcessingInstruction("timestamp",q),n.appendChild(r);continue}var s=o.match(/^<([^.\s\/0-9>]+)(\.[^\s\\>]+)?([^>\\]+)?(\\?)>?$/);if(!s)continue;if(r=l(s[1],s[3]),!r)continue;if(!g(n,r))continue;s[2]&&(r.className=s[2].substr(1).replace("."," ")),p.push(s[1]),n.appendChild(r),n=r}return m}function n(a){function e(a,b){for(var c=b.childNodes.length-1;c>=0;c--)a.push(b.childNodes[c])}function f(a){if(!a||!a.length)return null;var b=a.pop(),c=b.textContent||b.innerText;if(c){var d=c.match(/^.*(\n|\r)/);return d?(a.length=0,d[0]):c}return"ruby"===b.tagName?f(a):b.childNodes?(e(a,b),f(a)):void 0}var d,b=[],c="";if(!a||!a.childNodes)return"ltr";for(e(b,a);c=f(b);)for(var g=0;g<c.length;g++){d=c.charCodeAt(g);for(var h=0;h<m.length;h++)if(m[h]===d)return"rtl"}return"ltr"}function o(a){if("number"==typeof a.line&&(a.snapToLines||a.line>=0&&a.line<=100))return a.line;if(!a.track||!a.track.textTrackList||!a.track.textTrackList.mediaElement)return-1;for(var b=a.track,c=b.textTrackList,d=0,e=0;e<c.length&&c[e]!==b;e++)"showing"===c[e].mode&&d++;return++d*-1}function p(){}function q(a,b,c){var d=/MSIE\s8\.0/.test(navigator.userAgent),e="rgba(255, 255, 255, 1)",f="rgba(0, 0, 0, 0.8)";d&&(e="rgb(255, 255, 255)",f="rgb(0, 0, 0)"),p.call(this),this.cue=b,this.cueDiv=l(a,b.text);var g={color:e,backgroundColor:f,position:"relative",left:0,right:0,top:0,bottom:0,display:"inline"};d||(g.writingMode=""===b.vertical?"horizontal-tb":"lr"===b.vertical?"vertical-lr":"vertical-rl",g.unicodeBidi="plaintext"),this.applyStyles(g,this.cueDiv),this.div=a.document.createElement("div"),g={textAlign:"middle"===b.align?"center":b.align,font:c.font,whiteSpace:"pre-line",position:"absolute"},d||(g.direction=n(this.cueDiv),g.writingMode=""===b.vertical?"horizontal-tb":"lr"===b.vertical?"vertical-lr":"vertical-rl".stylesunicodeBidi="plaintext"),this.applyStyles(g),this.div.appendChild(this.cueDiv);var h=0;switch(b.positionAlign){case"start":h=b.position;break;case"middle":h=b.position-b.size/2;break;case"end":h=b.position-b.size}""===b.vertical?this.applyStyles({left:this.formatStyle(h,"%"),width:this.formatStyle(b.size,"%")}):this.applyStyles({top:this.formatStyle(h,"%"),height:this.formatStyle(b.size,"%")}),this.move=function(a){this.applyStyles({top:this.formatStyle(a.top,"px"),bottom:this.formatStyle(a.bottom,"px"),left:this.formatStyle(a.left,"px"),right:this.formatStyle(a.right,"px"),height:this.formatStyle(a.height,"px"),width:this.formatStyle(a.width,"px")})}}function r(a){var c,d,e,f,b=/MSIE\s8\.0/.test(navigator.userAgent);if(a.div){d=a.div.offsetHeight,e=a.div.offsetWidth,f=a.div.offsetTop;var g=(g=a.div.childNodes)&&(g=g[0])&&g.getClientRects&&g.getClientRects();a=a.div.getBoundingClientRect(),c=g?Math.max(g[0]&&g[0].height||0,a.height/g.length):0}this.left=a.left,this.right=a.right,this.top=a.top||f,this.height=a.height||d,this.bottom=a.bottom||f+(a.height||d),this.width=a.width||e,this.lineHeight=void 0!==c?c:a.lineHeight,b&&!this.lineHeight&&(this.lineHeight=13)}function s(a,b,c,d){function e(a,b){for(var e,f=new r(a),g=1,h=0;h<b.length;h++){for(;a.overlapsOppositeAxis(c,b[h])||a.within(c)&&a.overlapsAny(d);)a.move(b[h]);if(a.within(c))return a;var i=a.intersectPercentage(c);g>i&&(e=new r(a),g=i),a=new r(f)}return e||f}var f=new r(b),g=b.cue,h=o(g),i=[];if(g.snapToLines){var j;switch(g.vertical){case"":i=["+y","-y"],j="height";break;case"rl":i=["+x","-x"],j="width";break;case"lr":i=["-x","+x"],j="width"}var k=f.lineHeight,l=k*Math.round(h),m=c[j]+k,n=i[0];Math.abs(l)>m&&(l=l<0?-1:1,l*=Math.ceil(m/k)*k),h<0&&(l+=""===g.vertical?c.height:c.width,i=i.reverse()),f.move(n,l)}else{var p=f.lineHeight/c.height*100;switch(g.lineAlign){case"middle":h-=p/2;break;case"end":h-=p}switch(g.vertical){case"":b.applyStyles({top:b.formatStyle(h,"%")});break;case"rl":b.applyStyles({left:b.formatStyle(h,"%")});break;case"lr":b.applyStyles({right:b.formatStyle(h,"%")})}i=["+y","-x","+x","-y"],f=new r(b)}var q=e(f,i);b.move(q.toCSSCompatValues(c))}function t(){}var b=Object.create||function(){function a(){}return function(b){if(1!==arguments.length)throw new Error("Object.create shim only accepts one parameter.");return a.prototype=b,new a}}();c.prototype=b(Error.prototype),c.prototype.constructor=c,c.Errors={BadSignature:{code:0,message:"Malformed WebVTT signature."},BadTimeStamp:{code:1,message:"Malformed time stamp."}},e.prototype={set:function(a,b){this.get(a)||""===b||(this.values[a]=b)},get:function(a,b,c){return c?this.has(a)?this.values[a]:b[c]:this.has(a)?this.values[a]:b},has:function(a){return a in this.values},alt:function(a,b,c){for(var d=0;d<c.length;++d)if(b===c[d]){this.set(a,b);break}},integer:function(a,b){/^-?\d+$/.test(b)&&this.set(a,parseInt(b,10))},percent:function(a,b){var c;return!!((c=b.match(/^([\d]{1,3})(\.[\d]*)?%$/))&&(b=parseFloat(b),b>=0&&b<=100))&&(this.set(a,b),!0)}};var h={"&amp;":"&","&lt;":"<","&gt;":">","&lrm;":"‎","&rlm;":"‏","&nbsp;":" "},i={c:"span",i:"i",b:"b",u:"u",ruby:"ruby",rt:"rt",v:"span",lang:"span"},j={v:"title",lang:"lang"},k={rt:"ruby"},m=[1470,1472,1475,1478,1488,1489,1490,1491,1492,1493,1494,1495,1496,1497,1498,1499,1500,1501,1502,1503,1504,1505,1506,1507,1508,1509,1510,1511,1512,1513,1514,1520,1521,1522,1523,1524,1544,1547,1549,1563,1566,1567,1568,1569,1570,1571,1572,1573,1574,1575,1576,1577,1578,1579,1580,1581,1582,1583,1584,1585,1586,1587,1588,1589,1590,1591,1592,1593,1594,1595,1596,1597,1598,1599,1600,1601,1602,1603,1604,1605,1606,1607,1608,1609,1610,1645,1646,1647,1649,1650,1651,1652,1653,1654,1655,1656,1657,1658,1659,1660,1661,1662,1663,1664,1665,1666,1667,1668,1669,1670,1671,1672,1673,1674,1675,1676,1677,1678,1679,1680,1681,1682,1683,1684,1685,1686,1687,1688,1689,1690,1691,1692,1693,1694,1695,1696,1697,1698,1699,1700,1701,1702,1703,1704,1705,1706,1707,1708,1709,1710,1711,1712,1713,1714,1715,1716,1717,1718,1719,1720,1721,1722,1723,1724,1725,1726,1727,1728,1729,1730,1731,1732,1733,1734,1735,1736,1737,1738,1739,1740,1741,1742,1743,1744,1745,1746,1747,1748,1749,1765,1766,1774,1775,1786,1787,1788,1789,1790,1791,1792,1793,1794,1795,1796,1797,1798,1799,1800,1801,1802,1803,1804,1805,1807,1808,1810,1811,1812,1813,1814,1815,1816,1817,1818,1819,1820,1821,1822,1823,1824,1825,1826,1827,1828,1829,1830,1831,1832,1833,1834,1835,1836,1837,1838,1839,1869,1870,1871,1872,1873,1874,1875,1876,1877,1878,1879,1880,1881,1882,1883,1884,1885,1886,1887,1888,1889,1890,1891,1892,1893,1894,1895,1896,1897,1898,1899,1900,1901,1902,1903,1904,1905,1906,1907,1908,1909,1910,1911,1912,1913,1914,1915,1916,1917,1918,1919,1920,1921,1922,1923,1924,1925,1926,1927,1928,1929,1930,1931,1932,1933,1934,1935,1936,1937,1938,1939,1940,1941,1942,1943,1944,1945,1946,1947,1948,1949,1950,1951,1952,1953,1954,1955,1956,1957,1969,1984,1985,1986,1987,1988,1989,1990,1991,1992,1993,1994,1995,1996,1997,1998,1999,2e3,2001,2002,2003,2004,2005,2006,2007,2008,2009,2010,2011,2012,2013,2014,2015,2016,2017,2018,2019,2020,2021,2022,2023,2024,2025,2026,2036,2037,2042,2048,2049,2050,2051,2052,2053,2054,2055,2056,2057,2058,2059,2060,2061,2062,2063,2064,2065,2066,2067,2068,2069,2074,2084,2088,2096,2097,2098,2099,2100,2101,2102,2103,2104,2105,2106,2107,2108,2109,2110,2112,2113,2114,2115,2116,2117,2118,2119,2120,2121,2122,2123,2124,2125,2126,2127,2128,2129,2130,2131,2132,2133,2134,2135,2136,2142,2208,2210,2211,2212,2213,2214,2215,2216,2217,2218,2219,2220,8207,64285,64287,64288,64289,64290,64291,64292,64293,64294,64295,64296,64298,64299,64300,64301,64302,64303,64304,64305,64306,64307,64308,64309,64310,64312,64313,64314,64315,64316,64318,64320,64321,64323,64324,64326,64327,64328,64329,64330,64331,64332,64333,64334,64335,64336,64337,64338,64339,64340,64341,64342,64343,64344,64345,64346,64347,64348,64349,64350,64351,64352,64353,64354,64355,64356,64357,64358,64359,64360,64361,64362,64363,64364,64365,64366,64367,64368,64369,64370,64371,64372,64373,64374,64375,64376,64377,64378,64379,64380,64381,64382,64383,64384,64385,64386,64387,64388,64389,64390,64391,64392,64393,64394,64395,64396,64397,64398,64399,64400,64401,64402,64403,64404,64405,64406,64407,64408,64409,64410,64411,64412,64413,64414,64415,64416,64417,64418,64419,64420,64421,64422,64423,64424,64425,64426,64427,64428,64429,64430,64431,64432,64433,64434,64435,64436,64437,64438,64439,64440,64441,64442,64443,64444,64445,64446,64447,64448,64449,64467,64468,64469,64470,64471,64472,64473,64474,64475,64476,64477,64478,64479,64480,64481,64482,64483,64484,64485,64486,64487,64488,64489,64490,64491,64492,64493,64494,64495,64496,64497,64498,64499,64500,64501,64502,64503,64504,64505,64506,64507,64508,64509,64510,64511,64512,64513,64514,64515,64516,64517,64518,64519,64520,64521,64522,64523,64524,64525,64526,64527,64528,64529,64530,64531,64532,64533,64534,64535,64536,64537,64538,64539,64540,64541,64542,64543,64544,64545,64546,64547,64548,64549,64550,64551,64552,64553,64554,64555,64556,64557,64558,64559,64560,64561,64562,64563,64564,64565,64566,64567,64568,64569,64570,64571,64572,64573,64574,64575,64576,64577,64578,64579,64580,64581,64582,64583,64584,64585,64586,64587,64588,64589,64590,64591,64592,64593,64594,64595,64596,64597,64598,64599,64600,64601,64602,64603,64604,64605,64606,64607,64608,64609,64610,64611,64612,64613,64614,64615,64616,64617,64618,64619,64620,64621,64622,64623,64624,64625,64626,64627,64628,64629,64630,64631,64632,64633,64634,64635,64636,64637,64638,64639,64640,64641,64642,64643,64644,64645,64646,64647,64648,64649,64650,64651,64652,64653,64654,64655,64656,64657,64658,64659,64660,64661,64662,64663,64664,64665,64666,64667,64668,64669,64670,64671,64672,64673,64674,64675,64676,64677,64678,64679,64680,64681,64682,64683,64684,64685,64686,64687,64688,64689,64690,64691,64692,64693,64694,64695,64696,64697,64698,64699,64700,64701,64702,64703,64704,64705,64706,64707,64708,64709,64710,64711,64712,64713,64714,64715,64716,64717,64718,64719,64720,64721,64722,64723,64724,64725,64726,64727,64728,64729,64730,64731,64732,64733,64734,64735,64736,64737,64738,64739,64740,64741,64742,64743,64744,64745,64746,64747,64748,64749,64750,64751,64752,64753,64754,64755,64756,64757,64758,64759,64760,64761,64762,64763,64764,64765,64766,64767,64768,64769,64770,64771,64772,64773,64774,64775,64776,64777,64778,64779,64780,64781,64782,64783,64784,64785,64786,64787,64788,64789,64790,64791,64792,64793,64794,64795,64796,64797,64798,64799,64800,64801,64802,64803,64804,64805,64806,64807,64808,64809,64810,64811,64812,64813,64814,64815,64816,64817,64818,64819,64820,64821,64822,64823,64824,64825,64826,64827,64828,64829,64848,64849,64850,64851,64852,64853,64854,64855,64856,64857,64858,64859,64860,64861,64862,64863,64864,64865,64866,64867,64868,64869,64870,64871,64872,64873,64874,64875,64876,64877,64878,64879,64880,64881,64882,64883,64884,64885,64886,64887,64888,64889,64890,64891,64892,64893,64894,64895,64896,64897,64898,64899,64900,64901,64902,64903,64904,64905,64906,64907,64908,64909,64910,64911,64914,64915,64916,64917,64918,64919,64920,64921,64922,64923,64924,64925,64926,64927,64928,64929,64930,64931,64932,64933,64934,64935,64936,64937,64938,64939,64940,64941,64942,64943,64944,64945,64946,64947,64948,64949,64950,64951,64952,64953,64954,64955,64956,64957,64958,64959,64960,64961,64962,64963,64964,64965,64966,64967,65008,65009,65010,65011,65012,65013,65014,65015,65016,65017,65018,65019,65020,65136,65137,65138,65139,65140,65142,65143,65144,65145,65146,65147,65148,65149,65150,65151,65152,65153,65154,65155,65156,65157,65158,65159,65160,65161,65162,65163,65164,65165,65166,65167,65168,65169,65170,65171,65172,65173,65174,65175,65176,65177,65178,65179,65180,65181,65182,65183,65184,65185,65186,65187,65188,65189,65190,65191,65192,65193,65194,65195,65196,65197,65198,65199,65200,65201,65202,65203,65204,65205,65206,65207,65208,65209,65210,65211,65212,65213,65214,65215,65216,65217,65218,65219,65220,65221,65222,65223,65224,65225,65226,65227,65228,65229,65230,65231,65232,65233,65234,65235,65236,65237,65238,65239,65240,65241,65242,65243,65244,65245,65246,65247,65248,65249,65250,65251,65252,65253,65254,65255,65256,65257,65258,65259,65260,65261,65262,65263,65264,65265,65266,65267,65268,65269,65270,65271,65272,65273,65274,65275,65276,67584,67585,67586,67587,67588,67589,67592,67594,67595,67596,67597,67598,67599,67600,67601,67602,67603,67604,67605,67606,67607,67608,67609,67610,67611,67612,67613,67614,67615,67616,67617,67618,67619,67620,67621,67622,67623,67624,67625,67626,67627,67628,67629,67630,67631,67632,67633,67634,67635,67636,67637,67639,67640,67644,67647,67648,67649,67650,67651,67652,67653,67654,67655,67656,67657,67658,67659,67660,67661,67662,67663,67664,67665,67666,67667,67668,67669,67671,67672,67673,67674,67675,67676,67677,67678,67679,67840,67841,67842,67843,67844,67845,67846,67847,67848,67849,67850,67851,67852,67853,67854,67855,67856,67857,67858,67859,67860,67861,67862,67863,67864,67865,67866,67867,67872,67873,67874,67875,67876,67877,67878,67879,67880,67881,67882,67883,67884,67885,67886,67887,67888,67889,67890,67891,67892,67893,67894,67895,67896,67897,67903,67968,67969,67970,67971,67972,67973,67974,67975,67976,67977,67978,67979,67980,67981,67982,67983,67984,67985,67986,67987,67988,67989,67990,67991,67992,67993,67994,67995,67996,67997,67998,67999,68e3,68001,68002,68003,68004,68005,68006,68007,68008,68009,68010,68011,68012,68013,68014,68015,68016,68017,68018,68019,68020,68021,68022,68023,68030,68031,68096,68112,68113,68114,68115,68117,68118,68119,68121,68122,68123,68124,68125,68126,68127,68128,68129,68130,68131,68132,68133,68134,68135,68136,68137,68138,68139,68140,68141,68142,68143,68144,68145,68146,68147,68160,68161,68162,68163,68164,68165,68166,68167,68176,68177,68178,68179,68180,68181,68182,68183,68184,68192,68193,68194,68195,68196,68197,68198,68199,68200,68201,68202,68203,68204,68205,68206,68207,68208,68209,68210,68211,68212,68213,68214,68215,68216,68217,68218,68219,68220,68221,68222,68223,68352,68353,68354,68355,68356,68357,68358,68359,68360,68361,68362,68363,68364,68365,68366,68367,68368,68369,68370,68371,68372,68373,68374,68375,68376,68377,68378,68379,68380,68381,68382,68383,68384,68385,68386,68387,68388,68389,68390,68391,68392,68393,68394,68395,68396,68397,68398,68399,68400,68401,68402,68403,68404,68405,68416,68417,68418,68419,68420,68421,68422,68423,68424,68425,68426,68427,68428,68429,68430,68431,68432,68433,68434,68435,68436,68437,68440,68441,68442,68443,68444,68445,68446,68447,68448,68449,68450,68451,68452,68453,68454,68455,68456,68457,68458,68459,68460,68461,68462,68463,68464,68465,68466,68472,68473,68474,68475,68476,68477,68478,68479,68608,68609,68610,68611,68612,68613,68614,68615,68616,68617,68618,68619,68620,68621,68622,68623,68624,68625,68626,68627,68628,68629,68630,68631,68632,68633,68634,68635,68636,68637,68638,68639,68640,68641,68642,68643,68644,68645,68646,68647,68648,68649,68650,68651,68652,68653,68654,68655,68656,68657,68658,68659,68660,68661,68662,68663,68664,68665,68666,68667,68668,68669,68670,68671,68672,68673,68674,68675,68676,68677,68678,68679,68680,126464,126465,126466,126467,126469,126470,126471,126472,126473,126474,126475,126476,126477,126478,126479,126480,126481,126482,126483,126484,126485,126486,126487,126488,126489,126490,126491,126492,126493,126494,126495,126497,126498,126500,126503,126505,126506,126507,126508,126509,126510,126511,126512,126513,126514,126516,126517,126518,126519,126521,126523,126530,126535,126537,126539,126541,126542,126543,126545,126546,126548,126551,126553,126555,126557,126559,126561,126562,126564,126567,126568,126569,126570,126572,126573,126574,126575,126576,126577,126578,126580,126581,126582,126583,126585,126586,126587,126588,126590,126592,126593,126594,126595,126596,126597,126598,126599,126600,126601,126603,126604,126605,126606,126607,126608,126609,126610,126611,126612,126613,126614,126615,126616,126617,126618,126619,126625,126626,126627,126629,126630,126631,126632,126633,126635,126636,126637,126638,126639,126640,126641,126642,126643,126644,126645,126646,126647,126648,126649,126650,126651,1114109];p.prototype.applyStyles=function(a,b){b=b||this.div;for(var c in a)a.hasOwnProperty(c)&&(b.style[c]=a[c])},p.prototype.formatStyle=function(a,b){return 0===a?0:a+b},q.prototype=b(p.prototype),q.prototype.constructor=q,r.prototype.move=function(a,b){switch(b=void 0!==b?b:this.lineHeight,a){case"+x":this.left+=b,this.right+=b;break;case"-x":this.left-=b,this.right-=b;break;case"+y":this.top+=b,this.bottom+=b;break;case"-y":this.top-=b,this.bottom-=b}},r.prototype.overlaps=function(a){return this.left<a.right&&this.right>a.left&&this.top<a.bottom&&this.bottom>a.top},r.prototype.overlapsAny=function(a){for(var b=0;b<a.length;b++)if(this.overlaps(a[b]))return!0;return!1},r.prototype.within=function(a){return this.top>=a.top&&this.bottom<=a.bottom&&this.left>=a.left&&this.right<=a.right},r.prototype.overlapsOppositeAxis=function(a,b){switch(b){case"+x":return this.left<a.left;case"-x":return this.right>a.right;case"+y":return this.top<a.top;case"-y":return this.bottom>a.bottom}},r.prototype.intersectPercentage=function(a){var b=Math.max(0,Math.min(this.right,a.right)-Math.max(this.left,a.left)),c=Math.max(0,Math.min(this.bottom,a.bottom)-Math.max(this.top,a.top)),d=b*c;return d/(this.height*this.width)},r.prototype.toCSSCompatValues=function(a){return{top:this.top-a.top,bottom:a.bottom-this.bottom,left:this.left-a.left,right:a.right-this.right,height:this.height,width:this.width}},r.getSimpleBoxPosition=function(a){var b=a.div?a.div.offsetHeight:a.tagName?a.offsetHeight:0,c=a.div?a.div.offsetWidth:a.tagName?a.offsetWidth:0,d=a.div?a.div.offsetTop:a.tagName?a.offsetTop:0;a=a.div?a.div.getBoundingClientRect():a.tagName?a.getBoundingClientRect():a;var e={left:a.left,right:a.right,top:a.top||d,height:a.height||b,bottom:a.bottom||d+(a.height||b),width:a.width||c};return e},t.StringDecoder=function(){return{decode:function(a){if(!a)return"";if("string"!=typeof a)throw new Error("Error - expected string data.");return decodeURIComponent(encodeURIComponent(a))}}},t.convertCueToDOMTree=function(a,b){return a&&b?l(a,b):null};var u=.05,v="sans-serif",w="1.5%";t.processCues=function(a,b,c){function e(a){for(var b=0;b<a.length;b++)if(a[b].hasBeenReset||!a[b].displayState)return!0;return!1}if(!a||!b||!c)return null;for(;c.firstChild;)c.removeChild(c.firstChild);var d=a.document.createElement("div");if(d.style.position="absolute",d.style.left="0",d.style.right="0",d.style.top="0",d.style.bottom="0",d.style.margin=w,c.appendChild(d),e(b)){var g=[],h=r.getSimpleBoxPosition(d),i=Math.round(h.height*u*100)/100,j={font:i+"px "+v};!function(){for(var c,e,f=0;f<b.length;f++)e=b[f],c=new q(a,e,j),d.appendChild(c.div),s(a,c,h,g),e.displayState=c.div,g.push(r.getSimpleBoxPosition(c))}()}else for(var f=0;f<b.length;f++)d.appendChild(b[f].displayState)},t.Parser=function(a,b,c){c||(c=b,b={}),b||(b={}),this.window=a,this.vttjs=b,this.state="INITIAL",this.buffer="",this.decoder=c||new TextDecoder("utf8"),this.regionList=[]},t.Parser.prototype={reportOrThrowError:function(a){if(!(a instanceof c))throw a;this.onparsingerror&&this.onparsingerror(a)},parse:function(a){function d(){for(var a=b.buffer,c=0;c<a.length&&"\r"!==a[c]&&"\n"!==a[c];)++c;var d=a.substr(0,c);return"\r"===a[c]&&++c,"\n"===a[c]&&++c,b.buffer=a.substr(c),d}function h(a){var c=new e;if(f(a,function(a,b){switch(a){case"id":c.set(a,b);break;case"width":c.percent(a,b);break;case"lines":c.integer(a,b);break;case"regionanchor":case"viewportanchor":var d=b.split(",");if(2!==d.length)break;var f=new e;if(f.percent("x",d[0]),f.percent("y",d[1]),!f.has("x")||!f.has("y"))break;c.set(a+"X",f.get("x")),c.set(a+"Y",f.get("y"));break;case"scroll":c.alt(a,b,["up"])}},/=/,/\s/),c.has("id")){var d=new(b.vttjs.VTTRegion||b.window.VTTRegion);d.width=c.get("width",100),d.lines=c.get("lines",3),d.regionAnchorX=c.get("regionanchorX",0),d.regionAnchorY=c.get("regionanchorY",100),d.viewportAnchorX=c.get("viewportanchorX",0),d.viewportAnchorY=c.get("viewportanchorY",100),d.scroll=c.get("scroll",""),b.onregion&&b.onregion(d),b.regionList.push({id:c.get("id"),region:d})}}function i(a){f(a,function(a,b){switch(a){case"Region":h(b)}},/:/)}var b=this;a&&(b.buffer+=b.decoder.decode(a,{stream:!0}));try{var j;if("INITIAL"===b.state){if(!/\r\n|\n/.test(b.buffer))return this;j=d();var k=j.match(/^WEBVTT([ \t].*)?$/);if(!k||!k[0])throw new c(c.Errors.BadSignature);b.state="HEADER"}for(var l=!1;b.buffer;){if(!/\r\n|\n/.test(b.buffer))return this;switch(l?l=!1:j=d(),b.state){case"HEADER":/:/.test(j)?i(j):j||(b.state="ID");continue;case"NOTE":j||(b.state="ID");continue;case"ID":if(/^NOTE($|[ \t])/.test(j)){b.state="NOTE";break}if(!j)continue;if(b.cue=new(b.vttjs.VTTCue||b.window.VTTCue)(0,0,""),b.state="CUE",j.indexOf("-->")===-1){b.cue.id=j;continue}case"CUE":try{g(j,b.cue,b.regionList)}catch(a){b.reportOrThrowError(a),b.cue=null,b.state="BADCUE";continue}b.state="CUETEXT";continue;case"CUETEXT":var m=j.indexOf("-->")!==-1;if(!j||m&&(l=!0)){b.oncue&&b.oncue(b.cue),b.cue=null,b.state="ID";continue}b.cue.text&&(b.cue.text+="\n"),b.cue.text+=j;continue;case"BADCUE":j||(b.state="ID");continue}}}catch(a){b.reportOrThrowError(a),"CUETEXT"===b.state&&b.cue&&b.oncue&&b.oncue(b.cue),b.cue=null,b.state="INITIAL"===b.state?"BADWEBVTT":"BADCUE"}return this},flush:function(){var a=this;try{if(a.buffer+=a.decoder.decode(),(a.cue||"HEADER"===a.state)&&(a.buffer+="\n\n",a.parse()),"INITIAL"===a.state)throw new c(c.Errors.BadSignature)}catch(b){a.reportOrThrowError(b)}return a.onflush&&a.onflush(),this}},a.WebVTT=t}(this,this.vttjs||{}),!function(){!function(a){var b=a&&a.videojs;if(b){b.CDN_VERSION="5.7.1";var c="https:"===a.location.protocol?"https://":"http://";b.options.flash.swf=c+"vjs.zencdn.net/swf/5.0.1/video-js.swf"}}(window),function(a,b,c,d,e,f,g){b&&b.HELP_IMPROVE_VIDEOJS!==!1&&(e.random()>.01||(f=b.location,g=b.videojs||{},a.src="//www.google-analytics.com/__utm.gif?utmwv=5.4.2&utmac=UA-16505296-3&utmn=1&utmhn="+d(f.hostname)+"&utmsr="+b.screen.availWidth+"x"+b.screen.availHeight+"&utmul="+(c.language||c.userLanguage||"").toLowerCase()+"&utmr="+d(f.href)+"&utmp="+d(f.hostname+f.pathname)+"&utmcc=__utma%3D1."+e.floor(1e10*e.random())+".1.1.1.1%3B&utme=8(vjsv*cdnv)9("+g.VERSION+"*"+g.CDN_VERSION+")"))}(new Image,window,navigator,encodeURIComponent,Math)}(),window.current_time=0,window.ads_initialized=!1;
/*videojs-youtube global define, YT*/
;(function (root, factory) {
  if(typeof exports==='object' && typeof module!=='undefined') {
    module.exports = factory(require('video.js'));
  } else if(typeof define === 'function' && define.amd) {
    define(['videojs'], function(videojs){
      return (root.Youtube = factory(videojs));
    });
  } else {
    root.Youtube = factory(root.videojs);
  }
}(this, function(videojs) {

  var Tech = videojs.getComponent('Tech');

  var Youtube = videojs.extend(Tech, {

    constructor: function(options, ready) {
      Tech.call(this, options, ready);

      this.setPoster(options.poster);
      this.setSrc(this.options_.source, true);

      // Set the vjs-youtube class to the player
      // Parent is not set yet so we have to wait a tick
      setTimeout(function() {
        this.el_.parentNode.className += ' vjs-youtube';

        if (_isOnMobile) {
          this.el_.parentNode.className += ' vjs-youtube-mobile';
        }

        if (Youtube.isApiReady) {
          this.initYTPlayer();
        } else {
          Youtube.apiReadyQueue.push(this);
        }
      }.bind(this));
    },

    dispose: function() {
      if (this.ytPlayer) {
        //Dispose of the YouTube Player
        this.ytPlayer.stopVideo();
        this.ytPlayer.destroy();
      } else {
        //YouTube API hasn't finished loading or the player is already disposed
        var index = Youtube.apiReadyQueue.indexOf(this);
        if (index !== -1) {
          Youtube.apiReadyQueue.splice(index, 1);
        }
      }
      this.ytPlayer = null;

      this.el_.parentNode.className = this.el_.parentNode.className
        .replace(' vjs-youtube', '')
        .replace(' vjs-youtube-mobile', '');
      // this.el_.remove();

      //Needs to be called after the YouTube player is destroyed, otherwise there will be a null reference exception
      Tech.prototype.dispose.call(this);
    },

    createEl: function() {
      var div = document.createElement('div');
      div.setAttribute('id', this.options_.techId);
      div.setAttribute('style', 'width:100%;height:100%;top:0;left:0;position:absolute');
      div.setAttribute('class', 'vjs-tech');

      var divWrapper = document.createElement('div');
      divWrapper.appendChild(div);

      if (!_isOnMobile && !this.options_.ytControls) {
        var divBlocker = document.createElement('div');
        divBlocker.setAttribute('class', 'vjs-iframe-blocker');
        divBlocker.setAttribute('style', 'position:absolute;top:0;left:0;width:100%;height:100%');

        // In case the blocker is still there and we want to pause
        divBlocker.onclick = function() {
          this.pause();
        }.bind(this);

        divWrapper.appendChild(divBlocker);
      }

      return divWrapper;
    },

    initYTPlayer: function() {
      var playerVars = {
        controls: 0,
        modestbranding: 1,
        rel: 0,
        showinfo: 0,
        loop: this.options_.loop ? 1 : 0
      };

      // Let the user set any YouTube parameter
      // https://developers.google.com/youtube/player_parameters?playerVersion=HTML5#Parameters
      // To use YouTube controls, you must use ytControls instead
      // To use the loop or autoplay, use the video.js settings

      if (typeof this.options_.autohide !== 'undefined') {
        playerVars.autohide = this.options_.autohide;
      }

      if (typeof this.options_['cc_load_policy'] !== 'undefined') {
        playerVars['cc_load_policy'] = this.options_['cc_load_policy'];
      }

      if (typeof this.options_.ytControls !== 'undefined') {
        playerVars.controls = this.options_.ytControls;
      }

      if (typeof this.options_.disablekb !== 'undefined') {
        playerVars.disablekb = this.options_.disablekb;
      }

      if (typeof this.options_.end !== 'undefined') {
        playerVars.end = this.options_.end;
      }

      if (typeof this.options_.color !== 'undefined') {
        playerVars.color = this.options_.color;
      }

      if (!playerVars.controls) {
        // Let video.js handle the fullscreen unless it is the YouTube native controls
        playerVars.fs = 0;
      } else if (typeof this.options_.fs !== 'undefined') {
        playerVars.fs = this.options_.fs;
      }

      if (typeof this.options_.end !== 'undefined') {
        playerVars.end = this.options_.end;
      }

      if (typeof this.options_.hl !== 'undefined') {
        playerVars.hl = this.options_.hl;
      } else if (typeof this.options_.language !== 'undefined') {
        // Set the YouTube player on the same language than video.js
        playerVars.hl = this.options_.language.substr(0, 2);
      }

      if (typeof this.options_['iv_load_policy'] !== 'undefined') {
        playerVars['iv_load_policy'] = this.options_['iv_load_policy'];
      }

      if (typeof this.options_.list !== 'undefined') {
        playerVars.list = this.options_.list;
      } else if (this.url && typeof this.url.listId !== 'undefined') {
        playerVars.list = this.url.listId;
      }

      if (typeof this.options_.listType !== 'undefined') {
        playerVars.listType = this.options_.listType;
      }

      if (typeof this.options_.modestbranding !== 'undefined') {
        playerVars.modestbranding = this.options_.modestbranding;
      }

      if (typeof this.options_.playlist !== 'undefined') {
        playerVars.playlist = this.options_.playlist;
      }

      if (typeof this.options_.playsinline !== 'undefined') {
        playerVars.playsinline = this.options_.playsinline;
      }

      if (typeof this.options_.rel !== 'undefined') {
        playerVars.rel = this.options_.rel;
      }

      if (typeof this.options_.showinfo !== 'undefined') {
        playerVars.showinfo = this.options_.showinfo;
      }

      if (typeof this.options_.start !== 'undefined') {
        playerVars.start = this.options_.start;
      }

      if (typeof this.options_.theme !== 'undefined') {
        playerVars.theme = this.options_.theme;
      }

      this.activeVideoId = this.url ? this.url.videoId : null;
      this.activeList = playerVars.list;

      this.ytPlayer = new YT.Player(this.options_.techId, {
        videoId: this.activeVideoId,
        playerVars: playerVars,
        events: {
          onReady: this.onPlayerReady.bind(this),
          onPlaybackQualityChange: this.onPlayerPlaybackQualityChange.bind(this),
          onStateChange: this.onPlayerStateChange.bind(this),
          onError: this.onPlayerError.bind(this)
        }
      });
    },

    onPlayerReady: function() {
      this.playerReady_ = true;
      this.triggerReady();

      if (this.playOnReady) {
        this.play();
      } else if (this.cueOnReady) {
        this.ytPlayer.cueVideoById(this.url.videoId);
        this.activeVideoId = this.url.videoId;
      }
    },

    onPlayerPlaybackQualityChange: function() {

    },

    onPlayerStateChange: function(e) {
      var state = e.data;

      if (state === this.lastState || this.errorNumber) {
        return;
      }
      //update state only for playlist videos. otherwise state conflict is caused, and youtube video is being paused
      if( jQuery('body').hasClass('playlist-video') ) {
        this.lastState = state;
      }

      switch (state) {
        case -1:
          this.trigger('loadstart');
          this.trigger('loadedmetadata');
          this.trigger('durationchange');
          break;

        case YT.PlayerState.ENDED:
          this.trigger('ended');
          break;

        case YT.PlayerState.PLAYING:
          this.trigger('timeupdate');
          this.trigger('durationchange');
          this.trigger('playing');
          this.trigger('play');

          if (this.isSeeking) {
            this.onSeeked();
          }
          break;

        case YT.PlayerState.PAUSED:
          this.trigger('canplay');
          if (this.isSeeking) {
            this.onSeeked();
          } else {
            this.trigger('pause');
          }
          break;

        case YT.PlayerState.BUFFERING:
          this.player_.trigger('timeupdate');
          this.player_.trigger('waiting');
          break;
      }
    },

    onPlayerError: function(e) {
      this.errorNumber = e.data;
      this.trigger('error');

      this.ytPlayer.stopVideo();
    },

    error: function() {
      switch (this.errorNumber) {
        case 5:
          return { code: 'Error while trying to play the video' };

        case 2:
        case 100:
          return { code: 'Unable to find the video' };

        case 101:
        case 150:
          return { code: 'Playback on other Websites has been disabled by the video owner.' };
      }

      return { code: 'YouTube unknown error (' + this.errorNumber + ')' };
    },

    src: function(src) {
      if (src) {
        this.setSrc({ src: src });
      }

      return this.source;
    },

    poster: function() {
      // You can't start programmaticlly a video with a mobile
      // through the iframe so we hide the poster and the play button (with CSS)
      if (_isOnMobile) {
        return null;
      }

      return this.poster_;
    },

    setPoster: function(poster) {
      this.poster_ = poster;
    },

    setSrc: function(source) {
      if (!source || !source.src) {
        return;
      }

      delete this.errorNumber;
      this.source = source;
      this.url = Youtube.parseUrl(source.src);

      if (!this.options_.poster) {
        if (this.url.videoId) {
          // Set the low resolution first
          this.poster_ = 'https://img.youtube.com/vi/' + this.url.videoId + '/0.jpg';
          this.trigger('posterchange');

          // Check if their is a high res
          this.checkHighResPoster();
        }
      }

      if (this.options_.autoplay && !_isOnMobile) {
        if (this.isReady_) {
          this.play();
        } else {
          this.playOnReady = true;
        }
      } else if (this.activeVideoId !== this.url.videoId) {
        if (this.isReady_) {
          this.ytPlayer.cueVideoById(this.url.videoId);
          this.activeVideoId = this.url.videoId;
        } else {
          this.cueOnReady = true;
        }
      }
    },

    autoplay: function() {
      return this.options_.autoplay;
    },

    setAutoplay: function(val) {
      this.options_.autoplay = val;
    },

    loop: function() {
      return this.options_.loop;
    },

    setLoop: function(val) {
      this.options_.loop = val;
    },

    play: function() {
      if (!this.url || !this.url.videoId) {
        return;
      }

      this.wasPausedBeforeSeek = false;

      if (this.isReady_) {
        if (this.url.listId) {
          if (this.activeList === this.url.listId) {
            this.ytPlayer.playVideo();
          } else {
            this.ytPlayer.loadPlaylist(this.url.listId);
            this.activeList = this.url.listId;
          }
        }

        if (this.activeVideoId === this.url.videoId) {
          this.ytPlayer.playVideo();
        } else {
          this.ytPlayer.loadVideoById(this.url.videoId);
          this.activeVideoId = this.url.videoId;
        }
      } else {
        this.trigger('waiting');
        this.playOnReady = true;
      }
    },

    pause: function() {
      if (this.ytPlayer) {
        this.ytPlayer.pauseVideo();
      }
    },

    paused: function() {
      return (this.ytPlayer) ?
        (this.lastState !== YT.PlayerState.PLAYING && this.lastState !== YT.PlayerState.BUFFERING)
        : true;
    },

    currentTime: function() {
      return this.ytPlayer ? this.ytPlayer.getCurrentTime() : 0;
    },

    setCurrentTime: function(seconds) {
      if (this.lastState === YT.PlayerState.PAUSED) {
        this.timeBeforeSeek = this.currentTime();
      }

      if (!this.isSeeking) {
        this.wasPausedBeforeSeek = this.paused();
      }

      this.ytPlayer.seekTo(seconds, true);
      this.trigger('timeupdate');
      this.trigger('seeking');
      this.isSeeking = true;

      // A seek event during pause does not return an event to trigger a seeked event,
      // so run an interval timer to look for the currentTime to change
      if (this.lastState === YT.PlayerState.PAUSED && this.timeBeforeSeek !== seconds) {
        clearInterval(this.checkSeekedInPauseInterval);
        this.checkSeekedInPauseInterval = setInterval(function() {
          if (this.lastState !== YT.PlayerState.PAUSED || !this.isSeeking) {
            // If something changed while we were waiting for the currentTime to change,
            //  clear the interval timer
            clearInterval(this.checkSeekedInPauseInterval);
          } else if (this.currentTime() !== this.timeBeforeSeek) {
            this.trigger('timeupdate');
            this.onSeeked();
          }
        }.bind(this), 250);
      }
    },

    seeking: function () {
      return this.isSeeking;
    },

    seekable: function () {
      if(!this.ytPlayer || !this.ytPlayer.getVideoLoadedFraction) {
        return {
          length: 0,
          start: function() {
            throw new Error('This TimeRanges object is empty');
          },
          end: function() {
            throw new Error('This TimeRanges object is empty');
          }
        };
      }
      var end = this.ytPlayer.getDuration();

      return {
        length: this.ytPlayer.getDuration(),
        start: function() { return 0; },
        end: function() { return end; }
      };
    },

    onSeeked: function() {
      clearInterval(this.checkSeekedInPauseInterval);
      this.isSeeking = false;

      if (this.wasPausedBeforeSeek) {
        this.pause();
      }

      this.trigger('seeked');
    },

    playbackRate: function() {
      return this.ytPlayer ? this.ytPlayer.getPlaybackRate() : 1;
    },

    setPlaybackRate: function(suggestedRate) {
      if (!this.ytPlayer) {
        return;
      }

      this.ytPlayer.setPlaybackRate(suggestedRate);
      this.trigger('ratechange');
    },

    duration: function() {
      return this.ytPlayer ? this.ytPlayer.getDuration() : 0;
    },

    currentSrc: function() {
      return this.source && this.source.src;
    },

    ended: function() {
      return this.ytPlayer ? (this.lastState === YT.PlayerState.ENDED) : false;
    },

    volume: function() {
      return this.ytPlayer ? this.ytPlayer.getVolume() / 100.0 : 1;
    },

    setVolume: function(percentAsDecimal) {
      if (!this.ytPlayer) {
        return;
      }

      this.ytPlayer.setVolume(percentAsDecimal * 100.0);
      this.setTimeout( function(){
        this.trigger('volumechange');
      }, 50);

    },

    muted: function() {
      return this.ytPlayer ? this.ytPlayer.isMuted() : false;
    },

    setMuted: function(mute) {
      if (!this.ytPlayer) {
        return;
      }
      else{
        this.muted(true);
      }

      if (mute) {
        this.ytPlayer.mute();
      } else {
        this.ytPlayer.unMute();
      }
      this.setTimeout( function(){
        this.trigger('volumechange');
      }, 50);
    },

    buffered: function() {
      if(!this.ytPlayer || !this.ytPlayer.getVideoLoadedFraction) {
        return {
          length: 0,
          start: function() {
            throw new Error('This TimeRanges object is empty');
          },
          end: function() {
            throw new Error('This TimeRanges object is empty');
          }
        };
      }

      var end = this.ytPlayer.getVideoLoadedFraction() * this.ytPlayer.getDuration();

      return {
        length: this.ytPlayer.getDuration(),
        start: function() { return 0; },
        end: function() { return end; }
      };
    },

    // TODO: Can we really do something with this on YouTUbe?
    preload: function() {},
    load: function() {},
    reset: function() {},

    supportsFullScreen: function() {
      return true;
    },

    // Tries to get the highest resolution thumbnail available for the video
    checkHighResPoster: function(){
      var uri = 'https://img.youtube.com/vi/' + this.url.videoId + '/maxresdefault.jpg';

      try {
        var image = new Image();
        image.onload = function(){
          // Onload may still be called if YouTube returns the 120x90 error thumbnail
          if('naturalHeight' in image){
            if (image.naturalHeight <= 90 || image.naturalWidth <= 120) {
              return;
            }
          } else if(image.height <= 90 || image.width <= 120) {
            return;
          }

          this.poster_ = uri;
          this.trigger('posterchange');
        }.bind(this);
        image.onerror = function(){};
        image.src = uri;
      }
      catch(e){}
    }
  });

  Youtube.isSupported = function() {
    return true;
  };

  Youtube.canPlaySource = function(e) {
    return Youtube.canPlayType(e.type);
  };

  Youtube.canPlayType = function(e) {
    return (e === 'video/youtube');
  };

  var _isOnMobile = videojs.browser.IS_IOS || useNativeControlsOnAndroid();

  Youtube.parseUrl = function(url) {
    var result = {
      videoId: null
    };

    var regex = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
    var match = url.match(regex);

    if (match && match[2].length === 11) {
      result.videoId = match[2];
    }

    var regPlaylist = /[?&]list=([^#\&\?]+)/;
    match = url.match(regPlaylist);

    if(match && match[1]) {
      result.listId = match[1];
    }

    return result;
  };

  function apiLoaded() {
    YT.ready(function() {
      Youtube.isApiReady = true;

      for (var i = 0; i < Youtube.apiReadyQueue.length; ++i) {
        Youtube.apiReadyQueue[i].initYTPlayer();
      }
    });
  }

  function loadScript(src, callback) {
    var loaded = false;
    var tag = document.createElement('script');
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    tag.onload = function () {
      if (!loaded) {
        loaded = true;
        callback();
      }
    };
    tag.onreadystatechange = function () {
      if (!loaded && (this.readyState === 'complete' || this.readyState === 'loaded')) {
        loaded = true;
        callback();
      }
    };
    tag.src = src;
  }

  function injectCss() {
    var css = // iframe blocker to catch mouse events
              '.vjs-youtube .vjs-iframe-blocker { display: none; }' +
              '.vjs-youtube.vjs-user-inactive .vjs-iframe-blocker { display: block; }' +
              '.vjs-youtube .vjs-poster { background-size: cover; }' +
              '.vjs-youtube-mobile .vjs-big-play-button { display: none; }';

    var head = document.head || document.getElementsByTagName('head')[0];

    var style = document.createElement('style');
    style.type = 'text/css';

    if (style.styleSheet){
      style.styleSheet.cssText = css;
    } else {
      style.appendChild(document.createTextNode(css));
    }

    head.appendChild(style);
  }

  function useNativeControlsOnAndroid() {
    var stockRegex = window.navigator.userAgent.match(/applewebkit\/(\d*).*Version\/(\d*.\d*)/i);
    //True only Android Stock Browser on OS versions 4.X and below
    //where a Webkit version and a "Version/X.X" String can be found in
    //user agent.
    return videojs.browser.IS_ANDROID && videojs.browser.ANDROID_VERSION < 5 && stockRegex && stockRegex[2] > 0;
  }

  Youtube.apiReadyQueue = [];

  loadScript('https://www.youtube.com/iframe_api', apiLoaded);
  injectCss();

  // Older versions of VJS5 doesn't have the registerTech function
  if (typeof videojs.registerTech !== 'undefined') {

    videojs.registerTech('Youtube', Youtube);

  } else {

    videojs.registerComponent('Youtube', Youtube);

  }

}));
/*
  videojs-vimeo
  https://github.com/hendrathings/videojs-vimeo/blob/bug-api/src/Vimeo.js
 */

(function() {

  var VimeoState = {
    UNSTARTED: -1,
    ENDED: 0,
    PLAYING: 1,
    PAUSED: 2,
    BUFFERING: 3
  };

  var Tech = videojs.getComponent('Tech');

  var Vimeo = videojs.extend(Tech, {
    constructor: function(options, ready) {
      Tech.call(this, options, ready);
      if(options.poster != "") {this.setPoster(options.poster);}
      this.setSrc(this.options_.source.src, true);

      // Set the vjs-vimeo class to the player
      // Parent is not set yet so we have to wait a tick
      setTimeout(function() {
        this.el_.parentNode.className += ' vjs-vimeo';
        
        if (Vimeo.isApiReady) {
          this.initPlayer();
        } else {
          Vimeo.apiReadyQueue.push(this);
        }
      }.bind(this));
      
    },
    
    dispose: function() {
      this.el_.parentNode.className = this.el_.parentNode.className.replace(' vjs-vimeo', '');
      this.el_.remove();
      if (this.vimeo && this.vimeo.api) {
        this.vimeo.api('unload');
        delete this.vimeo;
      }

      this.vimeo = null;
      Tech.prototype.dispose.call(this);  

    },
    
    createEl: function() {
      this.vimeo = {};
      this.vimeoInfo = {};
      this.baseUrl = 'https://player.vimeo.com/video/';
      this.baseApiUrl = 'http://www.vimeo.com/api/v2/video/';
      this.videoId = Vimeo.parseUrl(this.options_.source.src).videoId;
      
      this.iframe = document.createElement('iframe');
      this.iframe.setAttribute('id', this.options_.techId);
      this.iframe.setAttribute('title', 'Vimeo Video Player');
      this.iframe.setAttribute('class', 'vimeoplayer');
      this.iframe.setAttribute('src', this.baseUrl + this.videoId + '?api=1&player_id=' + this.options_.techId);
      this.iframe.setAttribute('frameborder', '0');
      this.iframe.setAttribute('scrolling', 'no');
      this.iframe.setAttribute('marginWidth', '0');
      this.iframe.setAttribute('marginHeight', '0');
      this.iframe.setAttribute('webkitAllowFullScreen', '0');
      this.iframe.setAttribute('mozallowfullscreen', '0');
      this.iframe.setAttribute('allowFullScreen', '0');

      var divWrapper = document.createElement('div');
      divWrapper.setAttribute('style', 'width:100%; height:100%; overflow:hidden; margin:0 auto;');
      divWrapper.appendChild(this.iframe);

      if (!_isOnMobile && !this.options_.ytControls) {
        var divBlocker = document.createElement('div');
        divBlocker.setAttribute('class', 'vjs-iframe-blocker');
        divBlocker.setAttribute('style', 'position:absolute;top:0;left:0;width:100%;height:100%');

        // In case the blocker is still there and we want to pause
        divBlocker.onclick = function() {
          this.onPause();
        }.bind(this);

        divWrapper.appendChild(divBlocker);
      }
      
      if(this.options_.poster == "" && this.videoId != null) {
        jQuery.getJSON(this.baseApiUrl + this.videoId + '.json?callback=?', {format: "json"}, (function(_this){
          return function(data) {
            // Set the low resolution first
            _this.setPoster(data[0].thumbnail_large);
          };
        })(this));
      }

      return divWrapper;
    },
    
    initPlayer: function() {
      var self = this;
      
      jQuery(self.iframe).load(function(){
        var vimeoVideoID = Vimeo.parseUrl(self.options_.source.src).videoId;
        //load vimeo
        if (self.vimeo && self.vimeo.api) {
          self.vimeo.api('unload');
          delete self.vimeo;
        }
        
        self.vimeo = $f(self.iframe);
        
        self.vimeoInfo = {
          state: VimeoState.UNSTARTED,
          volume: 1,
          muted: false,
          muteVolume: 1,
          time: 0,
          duration: 0,
          buffered: 0,
          url: self.baseUrl + self.videoId,
          error: null,
          controls: 0
        };

        self.vimeo.addEvent('ready', function(id){
          self.onReady();

          self.vimeo.addEvent('loadProgress', function(data, id){ self.onLoadProgress(data); });
          self.vimeo.addEvent('playProgress', function(data, id){ self.onPlayProgress(data); });
          self.vimeo.addEvent('play', function(id){ self.onPlay(); });
          self.vimeo.addEvent('pause', function(id){ self.onPause(); });
          self.vimeo.addEvent('finish', function(id){ self.onFinish(); });
          self.vimeo.addEvent('seek', function(data, id){ self.onSeek(data); });

        });
      });
      
    },
    
    onReady: function(){
      this.playerReady_ = true;
      this.triggerReady();
      this.trigger('loadedmetadata');
      if (this.startMuted) {
        this.setMuted(true);
        this.startMuted = false;
      }
    },
    
    onLoadProgress: function(data) {
      var durationUpdate = !this.vimeoInfo.duration;
      this.vimeoInfo.duration = data.duration;
      this.vimeoInfo.buffered = data.percent;
      this.trigger('progress');
      if (durationUpdate) this.trigger('durationchange');
    },
    onPlayProgress: function(data) {
      this.vimeoInfo.time = data.seconds;
      this.trigger('timeupdate');
      this.trigger('durationchange');
      this.trigger('playing');
      this.trigger('play');
    },
    onPlay: function() {
      this.vimeoInfo.state = VimeoState.PLAYING;
      this.trigger('play');
    },
    onPause: function() {
      this.vimeoInfo.state = VimeoState.PAUSED;
      this.trigger('pause');
    },
    onFinish: function() {
      this.vimeoInfo.state = VimeoState.ENDED;
      this.trigger('ended');
    },
    onSeek: function(data) {
      this.trigger('seeking');
      this.vimeoInfo.time = data.seconds;
      this.trigger('timeupdate');
      this.trigger('seeked');
    },
    onError: function(error){
      this.error = error;
      this.trigger('error');
    },
    
    error: function() {
      switch (this.errorNumber) {
        case 2:
          return { code: 'Unable to find the video' };

        case 5:
          return { code: 'Error while trying to play the video' };

        case 100:
          return { code: 'Unable to find the video' };

        case 101:
        case 150:
          return { code: 'Playback on other Websites has been disabled by the video owner.' };
      }

      return { code: 'Vimeo unknown error (' + this.errorNumber + ')' };
    },
    
    src: function() {
      return this.source;
    },

    poster: function() {
      return this.poster_;
    },

    setPoster: function(poster) {
      this.poster_ = poster;
    },

    setSrc: function(source) {
      if (!source || !source.src) {
        return;
      }

      this.source = source;
      this.url = Vimeo.parseUrl(source.src);

      if (!this.options_.poster && this.url.videoId != null) {
          jQuery.getJSON(this.baseApiUrl + this.videoId + '.json?callback=?', {format: "json"}, (function(_this){
            return function(data) {
              // Set the low resolution first
              _this.poster_ = data[0].thumbnail_small;
            };
          })(this));

          // Check if their is a high res
          this.checkHighResPoster();
      }

      if (this.options_.autoplay && !_isOnMobile) {
        if (this.isReady_) {
          this.play();
        } else {
          this.playOnReady = true;
        }
      }
    },
    
    supportsFullScreen: function() {
      return true;
    },
    
    //TRIGGER
    load : function(){},
    play : function(){ this.vimeo.api('play'); },
    pause : function(){ this.vimeo.api('pause'); },
    paused : function(){
      return this.vimeoInfo.state !== VimeoState.PLAYING &&
             this.vimeoInfo.state !== VimeoState.BUFFERING;
    },

    ended: function(){
      return this.vimeoInfo.state === VimeoState.ENDED;
    },

    currentTime : function(){ return this.vimeoInfo.time || 0; },

    setCurrentTime :function(seconds){
      this.vimeo.api('seekTo', seconds);
      this.player_.trigger('timeupdate');
    },

    duration :function(){ return this.vimeoInfo.duration || 0; },
    buffered :function(){ return videojs.createTimeRange(0, (this.vimeoInfo.buffered*this.vimeoInfo.duration) || 0); },

    volume :function() { return (this.vimeoInfo.muted)? this.vimeoInfo.muteVolume : this.vimeoInfo.volume; },
    setVolume :function(percentAsDecimal){
      this.vimeo.api('setvolume', percentAsDecimal);
      this.vimeoInfo.volume = percentAsDecimal;
      this.player_.trigger('volumechange');
    },
    currentSrc :function() {
      return this.el_.src;
    },
    muted :function() { return this.vimeoInfo.muted || false; },
    setMuted :function(muted) {
      if (muted) {
        this.vimeoInfo.muteVolume = this.vimeoInfo.volume;
        this.setVolume(0);
      } else {
        this.setVolume(this.vimeoInfo.muteVolume);
      }

      this.vimeoInfo.muted = muted;
      this.player_.trigger('volumechange');
    },

    // Tries to get the highest resolution thumbnail available for the video
    checkHighResPoster: function(){
      var uri = '';

      try {
        if(this.url.videoId != null){
          jQuery.getJSON(this.baseApiUrl + this.videoId + '.json?callback=?', {format: "json"}, (function(_uri){
            return function(data) {
              // Set the low resolution first
              _uri = data[0].thumbnail_large;
            };
          })(uri));
          
          var image = new Image();
          image.onload = function(){
            // Onload thumbnail
            if('naturalHeight' in this){
              if(this.naturalHeight <= 90 || this.naturalWidth <= 120) {
                this.onerror();
                return;
              }
            } else if(this.height <= 90 || this.width <= 120) {
              this.onerror();
              return;
            }

            this.poster_ = uri;
            this.trigger('posterchange');
          }.bind(this);
          image.onerror = function(){};
          image.src = uri;
        }
      }
      catch(e){}
    }
  });

  Vimeo.isSupported = function() {
    return true;
  };

  Vimeo.canPlaySource = function(e) {
    return (e.type === 'video/vimeo');
  };

  var _isOnMobile = /(iPad|iPhone|iPod|Android)/g.test(navigator.userAgent);

  Vimeo.parseUrl = function(url) {
    var result = {
      videoId: null
    };

    var regex = /^.*(vimeo\.com\/)((channels\/[A-z]+\/)|(groups\/[A-z]+\/videos\/))?([0-9]+)/;
    var match = url.match(regex);

    if (match) {
      result.videoId = match[5];
    }

    return result;
  };

  function injectCss() {
    var css = // iframe blocker to catch mouse events
              '.vjs-vimeo { overflow: hidden }' +
              '.vjs-vimeo .vjs-iframe-blocker { display: none; }' +
              '.vjs-vimeo.vjs-user-inactive .vjs-iframe-blocker { display: block; }' +
              '.vimeoplayer {display:block; width:100%; height:100%; margin:0 auto;}';

    var head = document.head || document.getElementsByTagName('head')[0];

    var style = document.createElement('style');
    style.type = 'text/css';

    if (style.styleSheet){
      style.styleSheet.cssText = css;
    } else {
      style.appendChild(document.createTextNode(css));
    }

    head.appendChild(style);
  }

  Vimeo.apiReadyQueue = [];

  var vimeoIframeAPIReady = function() {
    Vimeo.isApiReady = true;
    injectCss();

    for (var i = 0; i < Vimeo.apiReadyQueue.length; ++i) {
      Vimeo.apiReadyQueue[i].initPlayer();
    }
  };

  vimeoIframeAPIReady();

  videojs.registerTech('Vimeo', Vimeo);
  
  
  
  // Froogaloop API -------------------------------------------------------------

  // From https://github.com/vimeo/player-api/blob/master/javascript/froogaloop.js
  // Init style shamelessly stolen from jQuery http://jquery.com
  var Froogaloop = (function(){
      // Define a local copy of Froogaloop
      function Froogaloop(iframe) {
          // The Froogaloop object is actually just the init constructor
          return new Froogaloop.fn.init(iframe);
      }

      var eventCallbacks = {},
          hasWindowEvent = false,
          isReady = false,
          slice = Array.prototype.slice,
          playerOrigin = '*';

      Froogaloop.fn = Froogaloop.prototype = {
          element: null,

          init: function(iframe) {
              if (typeof iframe === "string") {
                  iframe = document.getElementById(iframe);
              }

              this.element = iframe;

              return this;
          },

          /*
           * Calls a function to act upon the player.
           *
           * @param {string} method The name of the Javascript API method to call. Eg: 'play'.
           * @param {Array|Function} valueOrCallback params Array of parameters to pass when calling an API method
           *                                or callback function when the method returns a value.
           */
          api: function(method, valueOrCallback) {
              if (!this.element || !method) {
                  return false;
              }

              var self = this,
                  element = self.element,
                  target_id = element.id !== '' ? element.id : null,
                  params = !isFunction(valueOrCallback) ? valueOrCallback : null,
                  callback = isFunction(valueOrCallback) ? valueOrCallback : null;

              // Store the callback for get functions
              if (callback) {
                  storeCallback(method, callback, target_id);
              }

              postMessage(method, params, element);
              return self;
          },

          /*
           * Registers an event listener and a callback function that gets called when the event fires.
           *
           * @param eventName (String): Name of the event to listen for.
           * @param callback (Function): Function that should be called when the event fires.
           */
          addEvent: function(eventName, callback) {
              if (!this.element) {
                  return false;
              }

              var self = this,
                  element = self.element,
                  target_id = element.id !== '' ? element.id : null;


              storeCallback(eventName, callback, target_id);

              // The ready event is not registered via postMessage. It fires regardless.
              if (eventName != 'ready') {
                  postMessage('addEventListener', eventName, element);
              }
              else if (eventName == 'ready' && isReady) {
                  callback.call(null, target_id);
              }

              return self;
          },

          /*
           * Unregisters an event listener that gets called when the event fires.
           *
           * @param eventName (String): Name of the event to stop listening for.
           */
          removeEvent: function(eventName) {
              if (!this.element) {
                  return false;
              }

              var self = this,
                  element = self.element,
                  target_id = element.id !== '' ? element.id : null,
                  removed = removeCallback(eventName, target_id);

              // The ready event is not registered
              if (eventName != 'ready' && removed) {
                  postMessage('removeEventListener', eventName, element);
              }
          }
      };

      /**
       * Handles posting a message to the parent window.
       *
       * @param method (String): name of the method to call inside the player. For api calls
       * this is the name of the api method (api_play or api_pause) while for events this method
       * is api_addEventListener.
       * @param params (Object or Array): List of parameters to submit to the method. Can be either
       * a single param or an array list of parameters.
       * @param target (HTMLElement): Target iframe to post the message to.
       */
      function postMessage(method, params, target) {
          if (target.contentWindow == null || !target.contentWindow.postMessage) {
              return false;
          }

          var data = JSON.stringify({
              method: method,
              value: params
          });

          target.contentWindow.postMessage(data, playerOrigin);
      }

      /**
       * Event that fires whenever the window receives a message from its parent
       * via window.postMessage.
       */
      function onMessageReceived(event) {
          var data, method;

          try {
              data = JSON.parse(event.data);
              method = data.event || data.method;
          }
          catch(e)  {
              //fail silently... like a ninja!
          }

          if (method == 'ready' && !isReady) {
              isReady = true;
          }

          // Handles messages from the vimeo player only
          if (!(/^https?:\/\/player.vimeo.com/).test(event.origin)) {
              return false;
          }

          if (playerOrigin === '*') {
              playerOrigin = event.origin;
          }

          var value = data.value,
              eventData = data.data,
              target_id = target_id === '' ? null : data.player_id,

              callback = getCallback(method, target_id),
              params = [];

          if (!callback) {
              return false;
          }

          if (value !== undefined) {
              params.push(value);
          }

          if (eventData) {
              params.push(eventData);
          }

          if (target_id) {
              params.push(target_id);
          }

          return params.length > 0 ? callback.apply(null, params) : callback.call();
      }


      /**
       * Stores submitted callbacks for each iframe being tracked and each
       * event for that iframe.
       *
       * @param eventName (String): Name of the event. Eg. api_onPlay
       * @param callback (Function): Function that should get executed when the
       * event is fired.
       * @param target_id (String) [Optional]: If handling more than one iframe then
       * it stores the different callbacks for different iframes based on the iframe's
       * id.
       */
      function storeCallback(eventName, callback, target_id) {
          if (target_id) {
              if (!eventCallbacks[target_id]) {
                  eventCallbacks[target_id] = {};
              }
              eventCallbacks[target_id][eventName] = callback;
          }
          else {
              eventCallbacks[eventName] = callback;
          }
      }

      /**
       * Retrieves stored callbacks.
       */
      function getCallback(eventName, target_id) {
          if (target_id && eventCallbacks[target_id]) {
              return eventCallbacks[target_id][eventName];
          }
          else if (eventCallbacks[eventName]) {
              return eventCallbacks[eventName];
          }
      }

      function removeCallback(eventName, target_id) {
          if (target_id && eventCallbacks[target_id]) {
              if (!eventCallbacks[target_id][eventName]) {
                  return false;
              }
              eventCallbacks[target_id][eventName] = null;
          }
          else {
              if (!eventCallbacks[eventName]) {
                  return false;
              }
              eventCallbacks[eventName] = null;
          }

          return true;
      }

      function isFunction(obj) {
          return !!(obj && obj.constructor && obj.call && obj.apply);
      }

      function isArray(obj) {
          return toString.call(obj) === '[object Array]';
      }

      // Give the init function the Froogaloop prototype for later instantiation
      Froogaloop.fn.init.prototype = Froogaloop.fn;

      // Listens for the message event.
      // W3C
      if (window.addEventListener) {
          window.addEventListener('message', onMessageReceived, false);
      }
      // IE
      else {
          window.attachEvent('onmessage', onMessageReceived);
      }

      // Expose froogaloop to the global object
      return (window.Froogaloop = window.$f = Froogaloop);

  })();
})();

/*
 * Vast plugin
 */

(function(window, videojs, vast) {
  var extend = function(obj) {
    var arg, i, k;
    for (i = 1; i < arguments.length; i++) {
      arg = arguments[i];
      for (k in arg) {
        if (arg.hasOwnProperty(k)) {
          obj[k] = arg[k];
        }
      }
    }
    return obj;
  },

  defaults = {
    // seconds before skip button shows, negative values to disable skip button altogether
    skip: 5
  },

  Vast = function (player, settings) {

    // return vast plugin
    return {
      createSourceObjects: function (media_files) {

        var sourcesByFormat = {}, i, j, tech;
        var techOrder = player.options().techOrder;

        tech = videojs.getTech('Html5');

        var source =  {
          src: settings.src,
          type: "video/mp4"
        };

        var sources2 = [];

        sources2[0] = source;

        return sources2;
      },

      getContent: function () {

        // query vast url given in settings
        player.vast.sources = player.vast.createSourceObjects();
        player.vast.companion = undefined;


        if (!player.vastTracker) {
          // No pre-roll, start video
          player.trigger('adsready');
          player.trigger('adscanceled');
        }

        player.vastTracker = true;

      },

      setupEvents: function() {

        var errorOccurred = false,
          canplayFn = function(){
          },
          timeupdateFn = function(){
          },
          pauseFn = function(){
          },
          errorFn = function(){
            // Inform ad server we couldn't play the media file for this ad
            errorOccurred = true;
            player.trigger('ended');
          };

        player.on('canplay', canplayFn);
        player.on('timeupdate', timeupdateFn);
        player.on('pause', pauseFn);
        player.on('error', errorFn);

        player.one('vast-preroll-removed', function() {
          player.off('canplay', canplayFn);
          player.off('timeupdate', timeupdateFn);
          player.off('pause', pauseFn);
          player.off('error', errorFn);
          
        });
      },

      preroll: function() {

        player.ads.startLinearAdMode();
        
        player.vast.showControls = player.controls();
        if (player.vast.showControls) {
          player.controls(false);
        }

        // load linear ad sources and start playing them
        player.src(player.vast.sources);

        var clickthrough = settings.url;      

        var blocker = window.document.createElement("a");
            blocker.className = "vast-blocker";
            blocker.href = clickthrough || "#";
            blocker.target = "_blank";

            blocker.setAttribute('data-key', settings.key);

        blocker.onclick = function() {

          if ( player.paused() ) {
            player.play();
            return false;
          }

          setAdStatistics('clicks', settings.key);

          player.trigger("adclick");

        };

        player.vast.blocker = blocker;
        player.el().insertBefore(blocker, player.controlBar.el());

        var skipButton = window.document.createElement("div");
            skipButton.className = "vast-skip-button";
            skipButton.innerHTML = 'Skip';

        if ( settings.skip == false ) {
          skipButton.style.display = "none";
        }

        player.vast.skipButton = skipButton;
        player.el().appendChild(skipButton);

        player.on("timeupdate", player.vast.timeupdate);

        skipButton.onclick = function(e) {

          player.ads.endLinearAdMode();
          player.vast.tearDown();

          if(window.Event.prototype.stopPropagation !== undefined) {

            e.stopPropagation();

          } else {

            return false;

          }

        };

        player.vast.setupEvents();

        player.trigger('vast-preroll-ready');

        player.one('adended', player.vast.tearDown);

      },

      tearDown: function() {
        // remove preroll buttons
        player.vast.skipButton.parentNode.removeChild(player.vast.skipButton);
        player.vast.blocker.parentNode.removeChild(player.vast.blocker);

        // remove vast-specific events
        player.off('timeupdate', player.vast.timeupdate);
        player.off('ended', player.vast.tearDown);

        // end ad mode
        player.ads.endLinearAdMode();

        // show player controls for video
        if (player.vast.showControls) {
          player.controls(true);
        }

        player.trigger('vast-preroll-removed');


      },

      timeupdate: function(e) {

        player.loadingSpinner.el().style.display = "none";

        var timeLeft = Math.ceil(settings.skip - player.currentTime());

        if(timeLeft > 0) {

          player.vast.skipButton.innerHTML = "Skip in " + timeLeft + "...";

        } else {

          if((' ' + player.vast.skipButton.className + ' ').indexOf(' enabled ') === -1){
            player.vast.skipButton.className += " enabled";
            player.vast.skipButton.innerHTML = "Skip";
          }
        }
      },

    };

  },

  vastPlugin = function(options) {
    var player = this;
    var settings = extend({}, defaults, options || {});

    // check that we have the ads plugin
    if (player.ads === undefined) {
      window.console.error('vast video plugin requires videojs-contrib-ads, vast plugin not initialized');
      return null;
    }

    // set up vast plugin, then set up events here
    player.vast = new Vast(player, settings);

    player.on('vast-ready', function () {
      // vast is prepared with content, set up ads and trigger ready function
      player.trigger('adsready');
    });

    player.on('vast-preroll-ready', function () {
      // start playing preroll, note: this should happen this way no matter what, even if autoplay
      //  has been disabled since the preroll function shouldn't run until the user/autoplay has
      //  caused the main video to trigger this preroll function
      // @dev comment
      setAdStatistics('views');
      player.play();
    });

    player.on('vast-preroll-removed', function () {
      // preroll done or removed, start playing the actual video
      //@dev comment: on ipad video must be started by user action.
      if( !videojs.browser.IS_IOS && !videojs.browser.IS_ANDROID ) {
        player.play();
      }
    });

    player.on('contentupdate', function(){
      // videojs-ads triggers this when src changes
      player.vast.getContent();
    });

    player.on('readyforpreroll', function() {
      // if we don't have a vast url, just bail out
      if (!settings.src) {
        player.trigger('adscanceled');
        return null;
      }
      // set up and start playing preroll
      player.vast.preroll();
    });

    // make an ads request immediately so we're ready when the viewer hits "play"
    if (player.currentSrc()) {
      player.vast.getContent(settings.url);
    }

    // return player to allow this plugin to be chained
    return player;
  };

  videojs.plugin('vast', vastPlugin);

}(window, videojs));

/*-0------------------------------------------------------*/


/**
 * Basic Ad support plugin for video.js.
 *
 * Common code to support ad integrations.
 */
(function(window, videojs, undefined) {

var

  VIDEO_EVENTS = videojs.getComponent('Html5').Events,

  /**
   * Pause the player so that ads can play, then play again when ads are done.
   * This makes sure the player is paused during ad loading.
   *
   * The timeout is necessary because pausing a video element while processing a `play`
   * event on iOS can cause the video element to continuously toggle between playing and
   * paused states.
   *
   * @param {object} player The video player
   */
  cancelContentPlay = function(player) {
    if (player.ads.cancelPlayTimeout) {
      // another cancellation is already in flight, so do nothing
      return;
    }

    // Avoid content flash on non-iPad iOS
    if (videojs.browser.IS_IOS && !videojs.browser.IS_IPAD) {

      var width = player.currentWidth ? player.currentWidth() : player.width();
      var height = player.currentHeight ? player.currentHeight() : player.height();

      // A placeholder black box will be shown in the document while the player is hidden.
      // var placeholder = document.createElement('div');
      //     placeholder.style.width = width + 'px';
      //     placeholder.style.height = height + 'px';
      //     placeholder.style.background = 'black';
      //     player.el_.parentNode.insertBefore(placeholder, player.el_);

      // Hide the player. While in full-screen video playback mode on iOS, this
      // makes the player show a black screen instead of content flash.
      // player.el_.style.display = 'none';

      // // Unhide the player and remove the placeholder once we're ready to move on.
      // player.one(['adplaying', 'adtimeout', 'adserror', 'adscanceled', 'adskip',
      //             'contentplayback'], function() {
      //   player.el_.style.display = 'block';
      //   placeholder.remove();
      // });
    }
    
    player.ads.cancelPlayTimeout = window.setTimeout(function() {
      // deregister the cancel timeout so subsequent cancels are scheduled
      player.ads.cancelPlayTimeout = null;

      // pause playback so ads can be handled.
      if (!player.paused()) {
        player.pause();
      }

      // add a contentplayback handler to resume playback when ads finish.
      player.one('contentplayback', function() {
        if (player.paused()) {
          player.play();
        }
      });
    }, 1);
  },

  /**
   * Remove the poster attribute from the video element tech, if present. When
   * reusing a video element for multiple videos, the poster image will briefly
   * reappear while the new source loads. Removing the attribute ahead of time
   * prevents the poster from showing up between videos.
   * @param {object} player The videojs player object
   */
  removeNativePoster = function(player) {
    var tech = player.$('.vjs-tech');
    if (tech) {
      tech.removeAttribute('poster');
    }
  },

  /**
   * Returns an object that captures the portions of player state relevant to
   * video playback. The result of this function can be passed to
   * restorePlayerSnapshot with a player to return the player to the state it
   * was in when this function was invoked.
   * @param {object} player The videojs player object
   */
  getPlayerSnapshot = function(player) {

    var currentTime;

    if (videojs.browser.IS_IOS && player.ads.isLive(player)) {
      // Record how far behind live we are
      if (player.seekable().length > 0) {
        currentTime = player.currentTime() - player.seekable().end(0);
      } else {
        currentTime = player.currentTime();
      }
    } else {
      currentTime = player.currentTime();
    }

    var
      tech = player.$('.vjs-tech'),
      tracks = player.remoteTextTracks ? player.remoteTextTracks() : [],
      track,
      i,
      suppressedTracks = [],
      snapshot = {
        ended: player.ended(),
        currentSrc: player.currentSrc(),
        src: player.src(),
        currentTime: currentTime,
        type: player.currentType()
      };

    if (tech) {
      snapshot.nativePoster = tech.poster;
      snapshot.style = tech.getAttribute('style');
    }

    i = tracks.length;
    while (i--) {
      track = tracks[i];
      suppressedTracks.push({
        track: track,
        mode: track.mode
      });
      track.mode = 'disabled';
    }
    snapshot.suppressedTracks = suppressedTracks;

    return snapshot;
  },

  /**
   * Attempts to modify the specified player so that its state is equivalent to
   * the state of the snapshot.
   * @param {object} snapshot - the player state to apply
   */
  restorePlayerSnapshot = function(player, snapshot) {
    if (player.ads.disableNextSnapshotRestore === true) {
        player.ads.disableNextSnapshotRestore = false;
        return;
    }
    var
      // the playback tech
      tech = player.$('.vjs-tech'),

      // the number of remaining attempts to restore the snapshot
      attempts = 20,

      suppressedTracks = snapshot.suppressedTracks,
      trackSnapshot,
      restoreTracks =  function() {
        var i = suppressedTracks.length;
        while (i--) {
          trackSnapshot = suppressedTracks[i];
          trackSnapshot.track.mode = trackSnapshot.mode;
        }
      },

      // finish restoring the playback state
      resume = function() {
        var currentTime;

        if (videojs.browser.IS_IOS && player.ads.isLive(player)) {
          if (snapshot.currentTime < 0) {
            // Playback was behind real time, so seek backwards to match
            if (player.seekable().length > 0) {
              currentTime = player.seekable().end(0) + snapshot.currentTime;
            } else {
              currentTime = player.currentTime();
            }
            player.currentTime(currentTime);
          }
        } else {
          player.currentTime(snapshot.ended ? player.duration() : snapshot.currentTime);
        }

        // Resume playback if this wasn't a postroll
        if (!snapshot.ended) {
          // player.play();
        }
      },

      // determine if the video element has loaded enough of the snapshot source
      // to be ready to apply the rest of the state
      tryToResume = function() {

        // tryToResume can either have been called through the `contentcanplay`
        // event or fired through setTimeout.
        // When tryToResume is called, we should make sure to clear out the other
        // way it could've been called by removing the listener and clearing out
        // the timeout.
        player.off('contentcanplay', tryToResume);

        if (player.ads.tryToResumeTimeout_) {
          player.clearTimeout(player.ads.tryToResumeTimeout_);
          player.ads.tryToResumeTimeout_ = null;
        }

        // Tech may have changed depending on the differences in sources of the
        // original video and that of the ad
        // tech = player.el().querySelector('.vjs-tech');
        tech = player.tech_;

        if (tech.readyState > 1) {
          // some browsers and media aren't "seekable".
          // readyState greater than 1 allows for seeking without exceptions
          //@dev commented
          // return resume();
        }

        if (tech.seekable === undefined) {
          // if the tech doesn't expose the seekable time ranges, try to
          // resume playback immediately
          //@dev commented
          return resume();
        }

        if (tech.seekable.length > 0) {
          // if some period of the video is seekable, resume playback
          //@dev commented
          // return resume();
        }

        // delay a bit and then check again unless we're out of attempts
        if (attempts--) {
          // @dev commented
          // window.setTimeout(tryToResume, 50);
        } else {
          (function() {
            try {
              resume();
            } catch(e) {
              videojs.log.warn('Failed to resume the content after an advertisement', e);
            }
          })();
        }
      };

    if (snapshot.nativePoster) {
      tech.poster = snapshot.nativePoster;
    }

    if ('style' in snapshot) {
      // overwrite all css style properties to restore state precisely
      tech.setAttribute('style', snapshot.style || '');
    }

    // Determine whether the player needs to be restored to its state
    // before ad playback began. With a custom ad display or burned-in
    // ads, the content player state hasn't been modified and so no
    // restoration is required

    if (player.ads.videoElementRecycled()) {
      // on ios7, fiddling with textTracks too early will cause safari to crash
      player.one('contentloadedmetadata', restoreTracks);

      // if the src changed for ad playback, reset it
      player.src({ src: snapshot.currentSrc, type: snapshot.type });
      // safari requires a call to `load` to pick up a changed source
      player.load();
      // and then resume from the snapshots time once the original src has loaded
      // in some browsers (firefox) `canplay` may not fire correctly.
      // Reace the `canplay` event with a timeout.
      //@dev commented
      // player.one('contentcanplay', tryToResume);
      player.ads.tryToResumeTimeout_ = player.setTimeout(tryToResume, 50);
    } else if (!player.ended() || !snapshot.ended) {
      // if we didn't change the src, just restore the tracks
      restoreTracks();
      // the src didn't change and this wasn't a postroll
      // just resume playback at the current time.
      player.play();
    }
  },

  // ---------------------------------------------------------------------------
  // Ad Framework
  // ---------------------------------------------------------------------------

  // default framework settings
  defaults = {
    // maximum amount of time in ms to wait to receive `adsready` from the ad
    // implementation after play has been requested. Ad implementations are
    // expected to load any dynamic libraries and make any requests to determine
    // ad policies for a video during this time.
    timeout: 1000,

    // maximum amount of time in ms to wait for the ad implementation to start
    // linear ad mode after `readyforpreroll` has fired. This is in addition to
    // the standard timeout.
    prerollTimeout: 100,

    // maximum amount of time in ms to wait for the ad implementation to start
    // linear ad mode after `contentended` has fired.
    postrollTimeout: 100,

    // when truthy, instructs the plugin to output additional information about
    // plugin state to the video.js log. On most devices, the video.js log is
    // the same as the developer console.
    debug: true,

    // set this to true when using ads that are part of the content video
    stitchedAds: false
  },

  adFramework = function(options) {
    var player = this,
        settings = videojs.mergeOptions(defaults, options),
        fsmHandler;

    // prefix all video element events during ad playback
    // if the video element emits ad-related events directly,
    // plugins that aren't ad-aware will break. prefixing allows
    // plugins that wish to handle ad events to do so while
    // avoiding the complexity for common usage
    (function() {
      var videoEvents = VIDEO_EVENTS.concat([
        'firstplay',
        'loadedalldata'
      ]);

      var returnTrue = function() { return true; };

      var triggerEvent = function(type, event) {
        // pretend we called stopImmediatePropagation because we want the native
        // element events to continue propagating
        event.isImmediatePropagationStopped = returnTrue;
        event.cancelBubble = true;
        event.isPropagationStopped = returnTrue;
        player.trigger({
          type: type + event.type,
          state: player.ads.state,
          originalEvent: event
        });
      };

      player.on(videoEvents, function redispatch(event) {

        if (player.ads.state === 'ad-playback') {

          if (player.ads.videoElementRecycled() || player.ads.stitchedAds()) {
            triggerEvent('ad', event);
          }
          if( videojs.browser.IS_IOS && !videojs.browser.IS_IPAD ) {

            if( player.seeking() ) {
           
            }

            if( player.seeking() ) {
              if (window.current_time < player.currentTime()) {
                player.currentTime(0);
              }               
            }

            setInterval(function() {
              if ( !player.paused() && !player.seeking() ) {
                window.current_time = player.currentTime();
              }
            }, 1000);

          }

        } else if (player.ads.state === 'content-playback' && event.type === 'ended') {

          triggerEvent('content', event);

        } else if (player.ads.state === 'content-resuming') {

          if (player.ads.snapshot) {
            // the video element was recycled for ad playback
            if (player.currentSrc() !== player.ads.snapshot.currentSrc) {

              if (event.type === 'loadstart') {
                return;
              }

              return triggerEvent('content', event);

            // we ended playing postrolls and the video itself
            // the content src is back in place
            } else if (player.ads.snapshot.ended) {

              if ((event.type === 'pause' ||
                  event.type === 'ended')) {
                // after loading a video, the natural state is to not be started
                // in this case, it actually has, so, we do it manually
                player.addClass('vjs-has-started');
                // let `pause` and `ended` events through, naturally
                return;
              }
              // prefix all other events in content-resuming with `content`
              return triggerEvent('content', event);
            }
          }

          if (event.type !== 'playing') {

            triggerEvent('content', event);

          }

        }

      });
    })();

    // We now auto-play when an ad gets loaded if we're playing ads in the same video element as the content.
    // The problem is that in IE11, we cannot play in addurationchange but in iOS8, we cannot play from adcanplay.
    // This will allow ad-integrations from needing to do this themselves.
    player.on(['addurationchange', 'adcanplay'], function() {
      if (player.currentSrc() === player.ads.snapshot.currentSrc) {
        return;
      }

      player.play();
    });

    player.on('nopreroll', function() {
      player.ads.nopreroll_ = true;
    });

    player.on('nopostroll', function() {
      player.ads.nopostroll_ = true;
    });

    // replace the ad initializer with the ad namespace
    player.ads = {
      state: 'content-set',
      disableNextSnapshotRestore: false,

      // Call this when an ad response has been received and there are
      // linear ads ready to be played.
      startLinearAdMode: function() {
        if (player.ads.state === 'preroll?' ||
            player.ads.state === 'content-playback' ||
            player.ads.state === 'postroll?') {
          
          player.trigger('adstart');
        }
      },

      // Call this when a linear ad pod has finished playing.
      endLinearAdMode: function() {
        if (player.ads.state === 'ad-playback') {
          player.trigger('adend');
          // In the case of an empty ad response, we want to make sure that
          // the vjs-ad-loading class is always removed. We could probably check for
          // duration on adPlayer for an empty ad but we remove it here just to make sure
          player.removeClass('vjs-ad-loading');
        }
      },

      // Call this when an ad response has been received but there are no
      // linear ads to be played (i.e. no ads available, or overlays).
      // This has no effect if we are already in a linear ad mode.  Always
      // use endLinearAdMode() to exit from linear ad-playback state.
      skipLinearAdMode: function() {
        if (player.ads.state !== 'ad-playback') {
          player.trigger('adskip');
        }
      },

      stitchedAds: function(arg) {
        if (arg !== undefined) {
          this._stitchedAds = !!arg;
        }
        return this._stitchedAds;
      },

      // Returns whether the video element has been modified since the
      // snapshot was taken.
      // We test both src and currentSrc because changing the src attribute to a URL that
      // AdBlocker is intercepting doesn't update currentSrc.
      videoElementRecycled: function() {
        var srcChanged;
        var currentSrcChanged;

        if (!this.snapshot) {
          return false;
        }

        srcChanged = player.src() !== this.snapshot.src;
        currentSrcChanged = player.currentSrc() !== this.snapshot.currentSrc;

        return srcChanged || currentSrcChanged;
      },

      // Returns a boolean indicating if given player is in live mode.
      // Can be replaced when this is fixed: https://github.com/videojs/video.js/issues/3262
      isLive: function(player) {
        if (player.duration() === Infinity) {
          return true;
        } else if (videojs.browser.IOS_VERSION === "8" && player.duration() === 0) {
          return true;
        }
        return false;
      },

      // Return true if content playback should mute and continue during ad breaks.
      // This is only done during live streams on platforms where it's supported.
      // This improves speed and accuracy when returning from an ad break.
      shouldPlayContentBehindAd: function(player) {
        return !videojs.browser.IS_IOS &&
               !videojs.browser.IS_ANDROID &&
               player.duration() === Infinity;
      }

    };

    player.ads.stitchedAds(settings.stitchedAds);

    fsmHandler = function(event) {
      // Ad Playback State Machine
      var fsm = {
        'content-set': {
          events: {
            'adscanceled': function() {
              this.state = 'content-playback';
            },
            'adsready': function() {
              this.state = 'ads-ready';
            },
            'play': function() {
              this.state = 'ads-ready?';
              cancelContentPlay(player);
              // remove the poster so it doesn't flash between videos
              removeNativePoster(player);
            },
            'adserror': function() {
              this.state = 'content-playback';
            },
            'adskip': function() {
              this.state = 'content-playback';
            }
          }
        },
        'ads-ready': {
          events: {
            'play': function() {
              this.state = 'preroll?';
              cancelContentPlay(player);
            },
            'adskip': function() {
              this.state = 'content-playback';
            },
            'adserror': function() {
              this.state = 'content-playback';
            }
          }
        },
        'preroll?': {
          enter: function() {
            if (player.ads.nopreroll_) {
              // This will start the ads manager in case there are later ads
              player.trigger('readyforpreroll');

              // If we don't wait a tick, entering content-playback will cancel
              // cancelPlayTimeout, causing the video to not pause for the ad
              window.setTimeout(function() {
                // Don't wait for a preroll
                player.trigger('nopreroll');
              }, 1);
            } else {
              // change class to show that we're waiting on ads
              player.addClass('vjs-ad-loading');
              // schedule an adtimeout event to fire if we waited too long
              player.ads.adTimeoutTimeout = window.setTimeout(function() {
                player.trigger('adtimeout');
              }, settings.prerollTimeout);
              // signal to ad plugin that it's their opportunity to play a preroll
              player.trigger('readyforpreroll');
            }
          },
          leave: function() {
            window.clearTimeout(player.ads.adTimeoutTimeout);
            player.removeClass('vjs-ad-loading');
          },
          events: {
            'play': function() {
              cancelContentPlay(player);
            },
            'adstart': function() {
              this.state = 'ad-playback';
            },
            'adskip': function() {
              this.state = 'content-playback';
            },
            'adtimeout': function() {
              this.state = 'content-playback';
            },
            'adserror': function() {
              this.state = 'content-playback';
            },
            'nopreroll': function() {
              this.state = 'content-playback';
            }
          }
        },
        'ads-ready?': {
          enter: function() {
            player.addClass('vjs-ad-loading');
            player.ads.adTimeoutTimeout = window.setTimeout(function() {
              player.trigger('adtimeout');
            }, settings.timeout);
          },
          leave: function() {
            window.clearTimeout(player.ads.adTimeoutTimeout);
            player.removeClass('vjs-ad-loading');
          },
          events: {
            'play': function() {
              cancelContentPlay(player);
            },
            'adscanceled': function() {
              this.state = 'content-playback';
            },
            'adsready': function() {
              this.state = 'preroll?';
            },
            'adskip': function() {
              this.state = 'content-playback';
            },
            'adtimeout': function() {
              this.state = 'content-playback';
            },
            'adserror': function() {
              this.state = 'content-playback';
            }
          }
        },
        'ad-playback': {
          enter: function() {
            // capture current player state snapshot (playing, currentTime, src)
            if (!player.ads.shouldPlayContentBehindAd(player)) {
              this.snapshot = getPlayerSnapshot(player);
            }

            // Mute the player behind the ad
            if (player.ads.shouldPlayContentBehindAd(player)) {
              this.preAdVolume_ = player.volume();
              player.volume(0);
            }

            // add css to the element to indicate and ad is playing.
            player.addClass('vjs-ad-playing');

            // remove the poster so it doesn't flash between ads
            removeNativePoster(player);

            // We no longer need to supress play events once an ad is playing.
            // Clear it if we were.
            if (player.ads.cancelPlayTimeout) {
              // If we don't wait a tick, we could cancel the pause for cancelContentPlay,
              // resulting in content playback behind the ad
              window.setTimeout(function() {
                window.clearTimeout(player.ads.cancelPlayTimeout);
                player.ads.cancelPlayTimeout = null;
              }, 1);
            }
          },
          leave: function() {
            player.removeClass('vjs-ad-playing');
            if (!player.ads.shouldPlayContentBehindAd(player)) {
              restorePlayerSnapshot(player, this.snapshot);
            }

            // Reset the volume to pre-ad levels
            if (player.ads.shouldPlayContentBehindAd(player)) {
              player.volume(this.preAdVolume_);
            }
            
          },
          events: {
            'adend': function() {
              this.state = 'content-resuming';
            },
            'adserror': function() {
              this.state = 'content-resuming';
              //trigger 'adend' to notify that we are exiting 'ad-playback'
              player.trigger('adend');
            }
          }
        },
        'content-resuming': {
          enter: function() {
            if (this.snapshot && this.snapshot.ended) {
              window.clearTimeout(player.ads._fireEndedTimeout);
              // in some cases, ads are played in a swf or another video element
              // so we do not get an ended event in this state automatically.
              // If we don't get an ended event we can use, we need to trigger
              // one ourselves or else we won't actually ever end the current video.
              player.ads._fireEndedTimeout = window.setTimeout(function() {
                player.trigger('ended');
              }, 300);
            }
          },
          leave: function() {
            window.clearTimeout(player.ads._fireEndedTimeout);
          },
          events: {
            'contentupdate': function() {
              this.state = 'content-set';
            },
            contentresumed: function() {
              this.state = 'content-playback';
            },
            'playing': function() {
              this.state = 'content-playback';
            },
            'ended': function() {
              this.state = 'content-playback';
            }
          }
        },
        'postroll?': {
          enter: function() {
            this.snapshot = getPlayerSnapshot(player);
            if (player.ads.nopostroll_) {
              window.setTimeout(function() {
                // content-resuming happens after the timeout for backward-compatibility
                // with plugins that relied on a postrollTimeout before nopostroll was
                // implemented
                player.ads.state = 'content-resuming';
                player.trigger('ended');
              }, 1);
            } else {
              player.addClass('vjs-ad-loading');

              player.ads.adTimeoutTimeout = window.setTimeout(function() {
                player.trigger('adtimeout');
              }, settings.postrollTimeout);
            }
          },
          leave: function() {
            window.clearTimeout(player.ads.adTimeoutTimeout);
            player.removeClass('vjs-ad-loading');
          },
          events: {
            'adstart': function() {
              this.state = 'ad-playback';
            },
            'adskip': function() {
              this.state = 'content-resuming';
              window.setTimeout(function() {
                player.trigger('ended');
              }, 1);
            },
            'adtimeout': function() {
              this.state = 'content-resuming';
              window.setTimeout(function() {
                player.trigger('ended');
              }, 1);
            },
            'adserror': function() {
              this.state = 'content-resuming';
              window.setTimeout(function() {
                player.trigger('ended');
              }, 1);
            },
            'contentupdate': function() {
              this.state = 'ads-ready?';
            }
          }
        },
        'content-playback': {
          enter: function() {
            // make sure that any cancelPlayTimeout is cleared
            if (player.ads.cancelPlayTimeout) {
              window.clearTimeout(player.ads.cancelPlayTimeout);
              player.ads.cancelPlayTimeout = null;
            }
            // this will cause content to start if a user initiated
            // 'play' event was canceled earlier.
            player.trigger({
              type: 'contentplayback',
              triggerevent: player.ads.triggerevent
            });
          },
          events: {
            // in the case of a timeout, adsready might come in late.
            'adsready': function() {
              player.trigger('readyforpreroll');
            },
            'adstart': function() {
              this.state = 'ad-playback';
            },
            'contentupdate': function() {
              if (player.paused()) {
                this.state = 'content-set';
              } else {
                this.state = 'ads-ready?';
              }
              // When a new source is loaded into the player, we should remove the snapshot
              // to avoid confusing player state with the new content's state
              // i.e When new content is set, the player should fire the ended event
              if (this.snapshot && this.snapshot.ended) {
                this.snapshot = null;
              }
            },
            'contentended': function() {
              if (player.ads.snapshot && player.ads.snapshot.ended) {
                // player has already been here. content has really ended. good-bye
                return;
              }
              this.state = 'postroll?';
            },
            'play': function() {
              if (player.currentSrc() !== player.ads.contentSrc) {
                cancelContentPlay(player);
              }
            }
          }
        }
      };

      (function(state) {
        var noop = function() {};

        // process the current event with a noop default handler
        ((fsm[state].events || {})[event.type] || noop).apply(player.ads);

        // check whether the state has changed
        if (state !== player.ads.state) {

          // record the event that caused the state transition
          player.ads.triggerevent = event.type;

          // execute leave/enter callbacks if present
          (fsm[state].leave || noop).apply(player.ads);
          (fsm[player.ads.state].enter || noop).apply(player.ads);

          // output debug logging
          if (settings.debug) {
            videojs.log('ads', player.ads.triggerevent + ' triggered: ' + state + ' -> ' + player.ads.state);
          }
        }

      })(player.ads.state);

    };

    // register for the events we're interested in
    player.on(VIDEO_EVENTS.concat([
      // events emitted by ad plugin
      'adtimeout',
      'contentupdate',
      'contentplaying',
      'contentended',
      'contentresumed',

      // events emitted by third party ad implementors
      'adsready',
      'adserror',
      'adscanceled',
      'adstart',  // startLinearAdMode()
      'adend',    // endLinearAdMode()
      'adskip',   // skipLinearAdMode()
      'nopreroll'
    ]), fsmHandler);

    // keep track of the current content source
    // if you want to change the src of the video without triggering
    // the ad workflow to restart, you can update this variable before
    // modifying the player's source
    player.ads.contentSrc = player.currentSrc();

    // implement 'contentupdate' event.
    (function(){
      var
        // check if a new src has been set, if so, trigger contentupdate
        checkSrc = function() {
          var src;
          if (player.ads.state !== 'ad-playback') {
            src = player.currentSrc();
            if (src !== player.ads.contentSrc) {
              player.trigger({
                type: 'contentupdate',
                oldValue: player.ads.contentSrc,
                newValue: src
              });
              player.ads.contentSrc = src;
            }
          }
        };
      // loadstart reliably indicates a new src has been set
      player.on('loadstart', checkSrc);
      // check immediately in case we missed the loadstart
      window.setTimeout(checkSrc, 1);
    })();

    // kick off the fsm
    if (!player.paused()) {
      // simulate a play event if we're autoplaying
      fsmHandler({type:'play'});
    }

  };

  // register the ad plugin framework
  videojs.plugin('ads', adFramework);

})(window, videojs);


/*
 * simpleoverlay
 * https://github.com/brightcove/videojs-simpleoverlay
 *
 * Copyright (c) 2013 Brightcove
 * Licensed under the Apache 2 license.
 */

(function(videojs) {

    /**
     * Copies properties from one or more objects onto an original.
     */
    extend = function(obj /*, arg1, arg2, ... */) {
      var arg, i, k;
      for (i = 1; i < arguments.length; i++) {
        arg = arguments[i];
        for (k in arg) {
          if (arg.hasOwnProperty(k)) {
            obj[k] = arg[k];
          }
        }
      }
      return obj;
    },

    // define some reasonable defaults
    defaults = {
      // don't show any overlays by default
    },

    // plugin initializer
    simpleOverlay = function(options) {
      var
        // save a reference to the player instance
        player = this,

        // merge options and defaults
        settings = extend({}, defaults, options || {}),
        
        i,
        overlay;

      // insert the overlays into the player but keep them hidden initially
      for (i in settings) {

        overlay = settings[i];

        // Create anchor.
        overlay.el = document.createElement('a');
        overlay.el.setAttribute('href', overlay.url );
        overlay.el.setAttribute('target', 'blank');
        overlay.el.setAttribute('rel', 'nofollow');
        overlay.el.setAttribute('data-key', overlay.key);

        // add classes
        overlay.el.className = 'tsz-overlay-ad ';

        overlay.el.className += i + ' vjs-hidden';     

        if( i === 'text' ) {

          //create text overlay.
          overlay.el.textContent += overlay.textContent;


        } else {
          //create img overlay
          var img = document.createElement('img');
              img.setAttribute('src', overlay.image );

          overlay.el.appendChild(img);

        }

        overlay.closer = document.createElement('span');
        overlay.closer.className = 'ad-closer icon-close';

        overlay.el.appendChild(overlay.closer);

        overlay.closer.onclick = function(evt){
          evt.preventDefault();
          overlay.el.remove();
          return false;
        }   
        
        overlay.el.onclick = function(){
          setAdStatistics('clicks', overlay.key);
        }

        player.el().appendChild(overlay.el);

        
      }
      
      // show and hide the overlays for this time period
      player.on('timeupdate', function() {
        var
          currentTime = player.currentTime(),
          i,
          overlay;

        // iterate over all the defined overlays
        for (i in settings) {
          overlay = settings[i];
          if (overlay.start <= currentTime && overlay.end > currentTime) {
            
            // if the overlay isn't already showing, show it
            if (/vjs-hidden/.test(overlay.el.className)) {
              overlay.el.className = overlay.el.className.replace(/\s?vjs-hidden/, '');
            }

          // if the overlay isn't already hidden, hide it
          } else if (!(/vjs-hidden/).test(overlay.el.className)) {
            overlay.el.className += ' vjs-hidden';
          }
        }
      });
    };
  
  // register the plugin with video.js
  videojs.plugin('simpleOverlay', simpleOverlay);

}(window.videojs));


function airkit_startVideoPlayer( post_ID ){

	if ( post_ID == 'body' ) {
		post_ID = '#' + jQuery('.videosingle').attr('id');
	}

	var videoPlayerContainer = jQuery(post_ID).parents('.video-figure-content');

	if( jQuery(post_ID).length > 0 ) {
	  
	  videojs( post_ID , {
	    controls: true,
	  }, function(){

	    var player = this;      

	      /**
	       * Start next playlist video.
	       */
	       if( jQuery('body').hasClass('playlist-video') ) {
	          // start autoplay if on desktop;
	          if( !videojs.browser.IS_IOS && !videojs.browser.IS_ANDROID ) {
	            player.play();
	          }
	          player.on('ended', function(){
				  
	              var currentPlaying = jQuery('.playlist-panel-content .playlist-item.active'),
	                  nextVideo = currentPlaying.next().find('a.post-link').attr('href');
	                  
	                  if( typeof nextVideo != 'undefined' ) {
	                  	window.location = nextVideo;
	                  }
	              
	          });
	      }

	      if( videojs.browser.IS_IOS ) {
	        jQuery(videoPlayerContainer).find('.gowatch-video-player').addClass('vjs-ios');
	      }

	      var conf = JSON.parse( jQuery(videoPlayerContainer).find('.tsz-gowatch-config').text() );

	      /*
	       * Read the ads and build them.
	       */  

	      //Ads defined    
	      if( typeof conf['ads'] !== 'undefined' && jQuery( conf['ads'] ).length > 0 ) {

	        //Check if not mobile, or if mobile & ads enabled for mobile.
	        var winWidth = jQuery(window).width();

	        if( winWidth > 960 || ( winWidth <= 768 && conf['mobile_ads'] == 'Y' ) ) {

	          jQuery.each(conf['ads'], function(index, val) {

	          	console.log(val);

	            if( val.video_ad_type === 'preroll' ) {

	              if( !window.ads_initialized ) {
	                player.ads();
	                window.ads_initialized = true;
	              }

	              player.vast({
	                url: val.ad_link,
	                src: val.preroll_video_file,
	                skip: val.preroll_video_skip,
	                key: val.banner_id,
	              });

	            }

	            if( val.video_ad_type === 'imageover' ){

	                player.simpleOverlay({

	                  'image': {
	                      start: val.ad_image_start,
	                      end: val.ad_image_start,
	                      image: val.ad_image,
	                      url: val.ad_link,
	                      key: val.banner_id,
	                  }

	                });

	            } 

	            if( val.video_ad_type === 'textover' ) {
	                player.simpleOverlay({

	                  'text': {
	                      start: val.ad_text_start,
	                      end: val.ad_text_end,
	                      textContent: val.ad_text,
	                      url: val.ad_link,
	                      key: val.banner_id,
	                  }

	                });
	            }         

	          });

	        }
	      }
	  }); 
	}

}


jQuery(document).ready(function(){
  airkit_startVideoPlayer('body');
});