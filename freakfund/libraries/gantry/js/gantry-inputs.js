/*
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2013 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */
var InputsExclusion=[".content_vote"];var InputsMorph={version:1.7,init:function(){InputsMorph.rtl=document.id(document.body).getStyle("direction")=="rtl";
InputsMorph.list=new Hash({all:[]});var a=$$("input[type=radio]");var d=$$(InputsExclusion.join(" input[type=radio], ")+" input[type=radio]");d.each(function(b){a=a.erase(b);
});a.each(function(b,c){InputsMorph.setArray("list","all",b);if(InputsMorph.list.has(b.name)){InputsMorph.setArray("list",b.name,b);}else{InputsMorph.list.set(b.name,[b]);
}InputsMorph.morph(b,"radios").addEvent(b,"radios");});a=$$("input[type=checkbox]");d=$$(InputsExclusion.join(" input[type=checkbox], ")+" input[type=checkbox]");
d.each(function(b){a=a.erase(b);});a.each(function(b,c){InputsMorph.setArray("list","all",b);if(InputsMorph.list.has(b.name)){InputsMorph.setArray("list",b.name,b);
}else{InputsMorph.list.set(b.name,[b]);}InputsMorph.morph(b,"checks").addEvent(b,"checks");});},morph:function(e,d){var h=e.getNext(),g=e.getParent(),f=e.name.replace("[","").replace("]","");
if(h&&h.get("tag")=="label"){e.setStyles({position:"absolute",left:"-10000px"});if(InputsMorph.rtl&&Browser.Engine.gecko){e.setStyles({position:"absolute",right:"-10000px"});
}else{e.setStyles({position:"absolute",left:"-10000px"});}if(InputsMorph.rtl&&(Browser.Engine.presto||Browser.Engine.trident)){e.setStyle("display","none");
}if(Browser.Engine.trident5){e.setStyle("display","none");}h.addClass("rok"+d+" rok"+f);if(e.checked){h.addClass("rok"+d+"-active");}}else{if(g&&g.get("tag")=="label"){if(InputsMorph.rtl&&Browser.Engine.gecko){e.setStyles({position:"absolute",right:"-10000px"});
}else{e.setStyles({position:"absolute",left:"-10000px"});}if(InputsMorph.rtl&&(Browser.Engine.presto||Browser.Engine.trident)){e.setStyle("display","none");
}g.addClass("rok"+d+" rok"+f);if(e.checked){g.addClass("rok"+d+"-active");}}}return InputsMorph;},addEvent:function(e,d){e.addEvent("click",function(){if(Browser.Engine.presto||Browser.Engine.trident){if(e.opera){InputsMorph.switchReplacement(e,d);
}e.opera=(d=="checks")?false:true;}else{InputsMorph.switchReplacement(e,d);}});if(Browser.Engine.presto||Browser.Engine.trident||(e.getNext()&&!e.getNext().getProperty("for"))){var g=e.getNext(),f=e.getParent();
if(g&&g.get("tag")=="label"&&(Browser.Engine.trident||(Browser.Engine.presto&&!e.opera))){g.addEvent("click",function(){if((Browser.Engine.presto||Browser.Engine.trident)&&!e.opera){e.opera=true;
}e.fireEvent("click");});}else{if(f&&f.get("tag")=="label"||(e.getParent()&&!e.getParent().getProperty("for"))){f.addEvent("click",function(){e.fireEvent("click");
});}}}return InputsMorph;},switchReplacement:function(l,k){if(k=="checks"){var j=l.getNext(),c=l.getParent(),a="rok"+k+"-active";var i=((j)?j.get("tag")=="label":false);
var b=((c)?c.get("tag")=="label":false);if(i||b){if(i){if(j.hasClass(a)&&i){j.removeClass(a);if(l.checked){l.checked=false;}}else{if(!j.hasClass(a)&&i){j.addClass(a);
if(!l.checked){l.checked=true;}}}}else{if(b){if(c.hasClass(a)&&b){c.removeClass(a);if(l.checked){l.checked=false;}}else{if(!c.hasClass(a)&&b){c.addClass(a);
if(!l.checked){l.checked=true;}}}}}}}else{InputsMorph.list.get(l.name).each(function(e){var d=e.getNext(),f=e.getParent();var h=l.getNext(),g=l.getParent();
if(d){$$(d).removeClass("rok"+k+"-active");}if(f){$$(f).removeClass("rok"+k+"-active");}if(d&&d.get("tag")=="label"&&h==d){e.setProperty("checked","checked");
d.addClass("rok"+k+"-active");}else{if(f&&f.get("tag")=="label"&&g==f){f.addClass("rok"+k+"-active");e.setProperty("checked","checked");}}});}},setArray:function(f,e,h){var g=InputsMorph[f].get(e);
g.push(h);return InputsMorph[f].set(e,g);}};window.addEvent("domready",InputsMorph.init);