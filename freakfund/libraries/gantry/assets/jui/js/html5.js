/*
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2013 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */
/*! HTML5 Shiv vpre3.6 | @afarkas @jdalton @jon_neal @rem | MIT/GPL2 Licensed
  Uncompressed source: https://github.com/aFarkas/html5shiv  */
(function(x,w){function q(f,e){var h=f.createElement("p"),g=f.getElementsByTagName("head")[0]||f.documentElement;
return h.innerHTML="x<style>"+e+"</style>",g.insertBefore(h.lastChild,g.firstChild);}function p(){var b=m.elements;return typeof b=="string"?b.split(" "):b;
}function o(e){var d={},j=e.createElement,i=e.createDocumentFragment,h=i();e.createElement=function(b){if(!m.shivMethods){return j(b);}var c;return d[b]?c=d[b].cloneNode():t.test(b)?c=(d[b]=j(b)).cloneNode():c=j(b),c.canHaveChildren&&!u.test(b)?h.appendChild(c):c;
},e.createDocumentFragment=Function("h,f","return function(){var n=f.cloneNode(),c=n.createElement;h.shivMethods&&("+p().join().replace(/\w+/g,function(b){return j(b),h.createElement(b),'c("'+b+'")';
})+");return n}")(m,h);}function n(d){var c;return d.documentShived?d:(m.shivCSS&&!s&&(c=!!q(d,"article,aside,details,figcaption,figure,footer,header,hgroup,nav,section{display:block}audio{display:none}canvas,video{display:inline-block;*display:inline;*zoom:1}[hidden]{display:none}audio[controls]{display:inline-block;*display:inline;*zoom:1}mark{background:#FF0;color:#000}")),r||(c=!o(d)),c&&(d.documentShived=c),d);
}var v=x.html5||{},u=/^<|^(?:button|form|map|select|textarea|object|iframe|option|optgroup)$/i,t=/^<|^(?:a|b|button|code|div|fieldset|form|h1|h2|h3|h4|h5|h6|i|iframe|img|input|label|li|link|ol|option|p|param|q|script|select|span|strong|style|table|tbody|td|textarea|tfoot|th|thead|tr|ul)$/i,s,r;
(function(){var a=w.createElement("a");a.innerHTML="<xyz></xyz>",s="hidden" in a,s&&typeof injectElementWithStyles=="function"&&injectElementWithStyles("#modernizr{}",function(c){c.hidden=!0,s=(x.getComputedStyle?getComputedStyle(c,null):c.currentStyle).display=="none";
}),r=a.childNodes.length==1||function(){try{w.createElement("a");}catch(b){return !0;}var d=w.createDocumentFragment();return typeof d.cloneNode=="undefined"||typeof d.createDocumentFragment=="undefined"||typeof d.createElement=="undefined";
}();})();var m={elements:v.elements||"abbr article aside audio bdi canvas data datalist details figcaption figure footer header hgroup mark meter nav output progress section summary time video",shivCSS:v.shivCSS!==!1,shivMethods:v.shivMethods!==!1,type:"default",shivDocument:n};
x.html5=m,n(w);})(this,document);