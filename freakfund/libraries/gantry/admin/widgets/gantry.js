/*
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2013 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */
var Gantry={init:function(){if(document.id("gantry-mega-form")){document.id("gantry-mega-form").set("autocomplete","off");}Gantry.cookie=Cookie.read("gantry-admin");
Gantry.cleanance();Gantry.initTabs();Gantry.inputs();Gantry.selectedSets();Gantry.Overlay=new Gantry.Layer();Gantry.Tips.init();Gantry.notices();Gantry.badges();
Gantry.toolbarButtons();Gantry.loadDefaults();},load:function(){},toolbarButtons:function(){var g=document.getElements("[data-g4-toolbaraction]");g.each(function(i){var h=i.get("data-g4-toolbaraction");
if(h=="template.apply"){return;}i.addEvent("click",function(j){Joomla.submitbutton(h);});});var a=document.getElement('[data-g4-toolbaraction="template.apply"]');
if(a){var f=$$(document.getElements("#g4-toolbar .g4-actions > .rok-button").slice(0,-1));var e=document.id("adminForm");var b=null;var d=new Request({url:GantryAjaxURL,method:"post",onRequest:function(){},onSuccess:function(h){growl.alert("Gantry",h,{duration:6000});
}});a.addEvent("click",function(i){b=a;var h=e.toQueryString().parseQueryString();Object.each(h,(function(k,j){if(j.contains("[]")){delete h[j];h[j.replace("[]","")]=(typeof k=="string")?[k]:k;
}}));d.post(Object.merge(h,{model:"template-save",action:"save",task:"ajax"}));});}var c=document.id("toolbar-purge");if(c){c.addEvent("click",function(j){j.preventDefault();
if(Gantry.defaults){var i,h;Gantry.defaults.each(function(m,k){i=document.id(k);if(i){i.set("value",m);if(i.get("tag")=="select"){i.fireEvent("change");
}if(i.hasClass("toggle-input")){h=i.getParent(".toggle");if(m=="0"&&!h.hasClass("toggle-off")){h.removeClass("toggle-on").addClass("toggle-off");}else{if(m=="1"&&!h.hasClass("toggle-on")){h.removeClass("toggle-off").addClass("toggle-on");
}}}else{if(i.hasClass("slider")||i.hasClass("layouts-input")){var l=window.sliders[(i.id.replace(/-/,"_")).replace("-","_")];l.hiddenEl.fireEvent("set",m);
}else{if(i.id.contains("_font_family")){if(!m.contains(":")){m="s:"+m;}i.set("value",m);}else{if(i.className.contains("picker-input")){document.getElement("[data-moorainbow-trigger="+i.id+"] .overlay").setStyle("background-color",m);
}}}}}});Scroller.involved.setStyle("display","none");document.getElements(".preset-info").dispose();growl.alert("Gantry","Fields have been reset to default values.",{duration:6000});
}});}},notices:function(){Gantry.NoticeBox=document.id("system-message");var b=Gantry.NoticeBox.getElement(".close");if(b){Gantry.NoticeBoxFx=new Fx.Tween(Gantry.NoticeBox,{duration:200,link:"ignore",onStart:function(){Gantry.NoticeBox.setStyle("display","block");
}});b.addEvent("click",function(){Gantry.NoticeBoxFx.start("opacity",0).chain(function(){Gantry.NoticeBox.setStyle("display","none");});});}var a=$$(".overrides-button.button-del");
a.addEvent("click",function(d){var c=confirm(GantryLang.are_you_sure);if(!c){d.preventDefault();}});},dropdown:function(){var b=document.id("overrides-inside"),e=document.id("overrides-first"),c=null;
var a=new Fx.Slide("overrides-inside",{duration:100,onStart:function(){var g=document.id("overrides-actions").getSize().x-4;b.setStyle("width",g);this.wrapper.setStyle("width",g+4);
},onComplete:function(){if(!this.open){e.removeClass("slide-down");}}}).hide();b.setStyle("display","block");var d=function(){if(b.hasClass("slidedown")){a.slideIn();
e.addClass("slide-down");}};var f=function(){if(b.hasClass("slideup")){a.slideOut();}};$$("#overrides-toggle, #overrides-inside").addEvents({mouseenter:function(){$clear(c);
b.removeClass("slideup").addClass("slidedown");c=d();},mouseleave:function(){$clear(c);b.removeClass("slidedown").addClass("slideup");f.delay(300);}});
Gantry.dropdownActions();},dropdownActions:function(){var g=document.id("overrides-actions"),e=document.id("overrides-toolbar"),f=document.id("overrides-first");
var a=document.id("overrides-toggle");if(e){var d=e.getElement(".button-add"),b=e.getElement(".button-del"),c=e.getElement(".button-edit");if(c){c.addEvent("click",function(){if(f.getElement("input")){f.getElement("input").empty().dispose();
a.removeClass("hidden");return;}a.addClass("hidden");var h=new Element("input",{type:"text","class":"add-edit-input",value:f.get("text").clean().trim()});
h.addEvent("keydown",function(k){if(k.key=="esc"){this.empty().dispose();a.removeClass("hidden");}else{if(k.key=="enter"){k.preventDefault();var j=document.id("overrides-inside").getElements("a");
var i=j.get("text").indexOf(this.value);if(i!=-1){this.highlight("#ff4b4b","#fff");return;}document.getElement("input[name=override_name]").set("value",this.value);
i=j.get("text").indexOf(f.get("text").clean().trim());if(i!=-1){j[i].set("text",this.value);}this.empty().dispose();a.removeClass("hidden");f.getElement("a").set("text",this.value);
}}});h.inject(f,"top").focus();});}}},inputs:function(){var a=$$(".text-short, .text-medium, .text-long, .text-color");a.addEvents({attach:function(){this.removeClass("disabled");
},detach:function(){this.addClass("disabled");},set:function(b){this.value=b;},keydown:function(b){if(this.hasClass("disabled")){b.preventDefault();return;
}},focus:function(){if(this.hasClass("disabled")){this.blur();}},keyup:function(b){if(this.hasClass("disabled")){b.preventDefault();return;}}});},selectedSets:function(){var a=$$(".selectedset-switcher select");
a.each(function(e,c){var d=e.id.replace("_type","");e.store("gantry:values",e.getElements("option").get("value"));e.addEvent("change",function(){this.retrieve("gantry:values").each(function(g){var f=document.id("set-"+g);
if(f){f.removeClass("selectedset-hidden-field");f.setStyle("display",(g==this.value)?"table-row-group":"none");if(window.selectboxes&&g==this.value){f.getElements(".selectbox-wrapper").each(function(h){h.getElements(".selectbox-top, .selectbox-dropdown").set("style","");
window.selectboxes.updateSizes(h);});}}},this);});e.fireEvent("change");});$$(".selectedset-enabler input[id]").each(function(d,c){d.store("gantry:values",a[c].retrieve("gantry:values"));
d.addEvent("onChange",function(){this.retrieve("gantry:values").each(function(f){var e=document.id("set-"+f);if(e){if(!this.value.toInt()){e.setStyle("display","none");
}else{e.removeClass("selectedset-hidden-field");e.setStyle("display",(f==a[c].get("value"))?"table-row-group":"none");}}},this);});});var b=document.id("jform_params_menu_type");
if(b){b.fireEvent("change");}},cleanance:function(){Gantry.overridesBadges();Gantry.tabs=[];Gantry.panels=[];var e=document.getElement(".pane-sliders")||document.getElement("#g4-panels");
var g=e.getChildren();var c=g.getElement(".panelform"),a,d;Gantry.tabs=document.getElements(".g4-tabs li");if(!a){a=document.getElement(".g4-wrapper");
}if(!d){d=document.getElement("#g4-panels");}var i=document.getElements("#widget-list .widget .widget-top, #wp_inactive_widgets .widget .widget-top");if(i.length){i.each(function(l){var k=l.getParent();
if(k.id.contains("gantrydivider")){k.addClass("gantry-divider");}});}var b=c.getElements(".inner-tabs ul li").flatten();var h=c.getElements(".inner-panels .inner-panel").flatten();
b=$$(b);h=$$(h);b.each(function(l,k){l.addEvents({mouseenter:function(){this.addClass("hover");},mouseleave:function(){this.removeClass("hover");},click:function(){$$(h).setStyle("position","absolute");
h.fade("out");h[k].setStyles({position:"relative","float":"left",top:0,"z-index":5}).fade("in");b.removeClass("active");this.addClass("active");}});});
Gantry.panels=$$(".g4-panel");Gantry.wrapper=a;Gantry.container=d;Gantry.tabs=$$(Gantry.tabs);var f=document.id("cache-clear-wrap");if(f){var j=new Asset.image("images/wpspin_dark.gif",{onload:function(){this.setStyles({display:"none"}).addClass("ajax-loading").inject(f,"top");
}});f.addEvent("click",function(k){k.preventDefault();new Request.HTML({url:AdminURI,onRequest:function(){j.setStyle("display","block");},onSuccess:function(){window.location.reload();
}}).post({action:"gantry_admin",model:"cache",gantry_action:"clear"});});}},overridesBadges:function(){$$(".overrides-involved").filter(function(a){return a.get("text").trim().clean().toInt();
}).setStyles({display:"block",opacity:1,visibility:"visible"});},initTabs:function(){var a=0;Gantry.panels.setStyles({position:"absolute"});var b=document.getElement("#g4-panels .active-panel");
(b||Gantry.panels[0]).setStyles({position:"relative",display:"inline-block",zIndex:15});Gantry.panels.set("tween",{duration:"short",onComplete:function(){if(!this.to[0].value){this.element.setStyle("display","none");
}}});Gantry.panels.each(function(d,e){var c=d.retrieve("gantry:height");Gantry.tabs[e].addEvents({mouseenter:function(){this.addClass("hover");},mouseleave:function(){this.removeClass("hover");
},click:function(){Cookie.write("gantry-admin-tab",e);if(this.hasClass("active")){return;}$$(Gantry.panels).removeClass("active-panel").setStyle("display","none");
d.addClass("active-panel");Gantry.panels.setStyle("position","absolute");Gantry.panels.setStyles({visibility:"hidden",opacity:0,"z-index":5,display:"none"});
d.set("morph",{duration:330});d.setStyles({display:"inline-block",visibility:"visible",position:"relative",top:-20,"z-index":15}).morph({top:0,opacity:1});
Gantry.tabs.removeClass("active");this.addClass("active");}});});},badges:function(){var d=$$("#menu-assignment input[type=checkbox][disabled!=disabled]");
var a=$$("button.jform-rightbtn");var b=$$(".menuitems-involved span");if(d.length&&b.length){b=b[0];var c=b.get("html").clean().toInt();d.addEvent("click",function(){if(this.checked){c+=1;
}else{c-=1;}b.set("html",c);});}if(a.length){a=a[0];a.addEvent("click",function(){var e=document.getElements("#menu-assignment input[type=checkbox][disabled!=disabled]");
if(e.length){e=e.filter(function(f){return f.checked;});c=e.length;b.set("html",c);}});}},loadDefaults:function(){Gantry.defaultsXHR=new Request({url:GantryAjaxURL,onSuccess:function(a){Gantry.defaults=new Hash(JSON.decode(a));
}}).post({model:"overrides",action:(GantryIsMaster)?"get_default_values":"get_base_values"});}};Gantry.Tips={init:function(){if(typeof GantryPanelsTips!="undefined"){var b=null;
Object.each(GantryPanelsTips,function(d,e){Object.each(d,function(f,g){b=document.id(GantryParamsPrefix+g+"-lbl");if(b){b.set("data-original-title",f.content).addClass("g4-tooltips");
}});});}document.getElements(".g4-tooltips").twipsy({placement:"above-left",offset:{x:-10,y:-8}});document.getElements(".hasTip").each(function(d){d.removeClass("hasTip").addClass("sprocket-tip");
d.set("title",d.get("title").split("::").pop());d.twipsy({placement:"below-right",offset:{x:5,y:5},html:true});});var a=$$(".g4-panel"),c;if(document.id(document.body).getElement(".defaults-wrap")){c=a.getElements(".g4-panel-left .gantry-field > label:not(.rokchecks), .g4-panel-left .gantry-field span[class!=chain-label][class!=group-label] > label:not(.rokchecks)");
}else{c=a.getElements(".g4-panel-left .gantry-field .base-label label");}c.each(function(d,e){if(d.length){d.addEvent("mouseenter",function(){var h=d.indexOf(this);
var f=a[e];if(f){var i=(!this.id)?false:"tip-"+this.id.replace(GantryParamsPrefix,"").replace(/-lbl$/,"");var g=f.getElement(".gantrytips-left");if(g){if(!i||!document.id(i)){g.fireEvent("jumpTo",h+1);
}else{g.fireEvent("jumpById",i);}}}});}});}};Gantry.Layer=new Class({Implements:[Events,Options],options:{duration:200,opacity:0.8},initialize:function(b){var a=this;
this.setOptions(b);this.id=new Element("div",{id:"gantry-layer"}).inject(document.body);this.fx=new Fx.Tween(this.id,{duration:this.options.duration,link:"cancel",onStart:function(){this.id.setStyle("visibility","visible");
}.bind(this),onComplete:function(){if(!this.to[0].value){a.open=false;a.id.setStyle("visibility","hidden");}else{a.open=true;a.fireEvent("show");}}}).set("opacity",0);
this.id.setStyle("visibility","hidden");this.open=false;},show:function(){this.fx.start("opacity",this.options.opacity);},hide:function(){this.fireEvent("hide");
this.fx.start("opacity",0);},toggle:function(){this[this.open?"hide":"show"]();},calcSizes:function(){this.id.setStyles({width:window.getScrollSize().x,height:window.getScrollSize().y});
}});if(!Browser.Engine){if(Browser.Platform.ios){Browser.Platform.ipod=true;}Browser.Engine={};var setEngine=function(b,a){Browser.Engine.name=b;Browser.Engine[b+a]=true;
Browser.Engine.version=a;};if(Browser.ie){Browser.Engine.trident=true;switch(Browser.version){case 6:setEngine("trident",4);break;case 7:setEngine("trident",5);
break;case 8:setEngine("trident",6);}}if(Browser.firefox){Browser.Engine.gecko=true;if(Browser.version>=3){setEngine("gecko",19);}else{setEngine("gecko",18);
}}if(Browser.safari||Browser.chrome){Browser.Engine.webkit=true;switch(Browser.version){case 2:setEngine("webkit",419);break;case 3:setEngine("webkit",420);
break;case 4:setEngine("webkit",525);}}if(Browser.opera){Browser.Engine.presto=true;if(Browser.version>=9.6){setEngine("presto",960);}else{if(Browser.version>=9.5){setEngine("presto",950);
}else{setEngine("presto",925);}}}if(Browser.name=="unknown"){switch((ua.match(/(?:webkit|khtml|gecko)/)||[])[0]){case"webkit":case"khtml":Browser.Engine.webkit=true;
break;case"gecko":Browser.Engine.gecko=true;}}}window.addEvent("domready",Gantry.init);