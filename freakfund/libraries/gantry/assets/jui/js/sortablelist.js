/*
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2013 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */
(function(a){a.JSortableList=function(n,k,i,h,o,f){var j=this;var l="";var g="";var c;var m;var e;if(i!="desc"){i="asc";}var d=a.extend({orderingIcon:"add-on",orderingWrapper:"input-prepend",orderingGroup:"sortable-group-id",sortableClassName:"dndlist-sortable",placeHolderClassName:"dnd-list-highlight dndlist-place-holder",sortableHandle:".sortable-handler"},o);
a("tr",n).removeClass(d.sortableClassName).addClass(d.sortableClassName);a(n).parents("table").css("position","relative");a(d.sortableHandle,n).css("cursor","move");
a("#"+k).attr("autocomplete","off");var b=a(d.sortableHandle,a(n)).length>0?d.sortableHandle:"";a(n).sortable({axis:"y",cursor:"move",handle:b,items:"tr."+d.sortableClassName,placeholder:d.placeHolderClassName,helper:function(q,p){a(p).css({left:"0px"});
p.children().each(function(){a(this).width(a(this).width());});a(p).children("td").addClass("dndlist-dragged-row");return p;},start:function(q,p){j.sortableGroupId=p.item.attr(d.orderingGroup);
if(j.sortableGroupId){j.sortableRange=a("tr["+d.orderingGroup+"="+j.sortableGroupId+"]");}else{j.sortableRange=a("."+d.sortableClassName);}j.disableOtherGroupSort(q,p);
if(f){j.hideChidlrenNodes(p.item.attr("item-id"));j.hideSameLevelChildrenNodes(p.item.attr("level"));a(n).sortable("refresh");}},stop:function(r,p){a("td",a(this)).removeClass("dndlist-dragged-row");
a(p.item).css({opacity:0});a(p.item).animate({opacity:1,},800,function(){a(p.item).css("opacity","");});j.enableOtherGroupSort(r,p);j.rearrangeOrderingValues(j.sortableGroupId,p);
if(h){j.cloneMarkedCheckboxes();var q=a("#"+k).serialize();q=q.replace("task","");a.post(h,q);j.removeClonedCheckboxes();}j.disabledOrderingElements="";
if(f){j.showChildrenNodes(p.item);j.showSameLevelChildrenNodes(p.item);a(n).sortable("refresh");}}});this.hideChidlrenNodes=function(p){j.childrenNodes=j.getChildrenNodes(p);
j.childrenNodes.hide();};this.showChildrenNodes=function(p){p.after(j.childrenNodes);j.childrenNodes.show();j.childrenNodes="";};this.hideSameLevelChildrenNodes=function(p){j.sameLevelNodes=j.getSameLevelNodes(p);
j.sameLevelNodes.each(function(){_childrenNodes=j.getChildrenNodes(a(this).attr("item-id"));_childrenNodes.addClass("child-nodes-tmp-hide");_childrenNodes.hide();
});};this.showSameLevelChildrenNodes=function(p){prevItem=p.prev();prevItemChildrenNodes=j.getChildrenNodes(prevItem.attr("item-id"));prevItem.after(prevItemChildrenNodes);
a("tr.child-nodes-tmp-hide").show().removeClass("child-nodes-tmp-hide");j.sameLevelNodes="";};this.disableOtherGroupSort=function(r,q){if(j.sortableGroupId){var p=a("tr["+d.orderingGroup+"!="+j.sortableGroupId+"]",a(n));
p.removeClass(d.sortableClassName).addClass("dndlist-group-disabled");a(n).sortable("refresh");}};this.enableOtherGroupSort=function(r,q){var p=a("tr",a(n)).removeClass(d.sortableClassName);
p.addClass(d.sortableClassName).removeClass("dndlist-group-disabled");a(n).sortable("refresh");};this.disableOrderingControl=function(){a("."+d.orderingWrapper+" .add-on a",j.sortableRange).hide();
};this.enableOrderingControl=function(){a("."+d.orderingWrapper+" .add-on a",j.disabledOrderingElements).show();};this.rearrangeOrderingControl=function(q,t){var p;
if(q){j.sortableRange=a("tr["+d.orderingGroup+"="+q+"]");}else{j.sortableRange=a("."+d.sortableClassName);}p=j.sortableRange;var s=p.length;var r=0;if(s>1){p.each(function(){var v=a("."+d.orderingWrapper+" .add-on:first a",a(this));
var u=a("."+d.orderingWrapper+" .add-on:last a",a(this));if(v.get(0)&&u.get(0)){}else{if(v.get(0)){v.removeAttr("title");v=a("."+d.orderingWrapper+" .add-on:first",a(this)).html();
u=v.replace("icon-uparrow","icon-downarrow");u=u.replace(".orderup",".orderdown");a("."+d.orderingWrapper+" .add-on:last",a(this)).html(u);}else{if(u.get(0)){u.removeAttr("title");
u=a("."+d.orderingWrapper+" .add-on:last",a(this)).html();v=u.replace("icon-downarrow","icon-uparrow");v=v.replace(".orderdown",".orderup");a("."+d.orderingWrapper+" .add-on:first",a(this)).html(v);
}}}});a("."+d.orderingWrapper+" .add-on:first a",p[0]).remove();a("."+d.orderingWrapper+" .add-on:last a",p[(s-1)]).remove();}};this.rearrangeOrderingValues=function(q,t){var p;
if(q){j.sortableRange=a("tr["+d.orderingGroup+"="+q+"]");}else{j.sortableRange=a("."+d.sortableClassName);}p=j.sortableRange;var s=p.length;var r=0;if(s>1){if(t.originalPosition.top>t.position.top){if(t.item.position().top!=t.originalPosition.top){a("[type=text]",t.item).attr("value",parseInt(a("[type=text]",t.item.next()).attr("value")));
}a(p).each(function(){var v=a(this).position().top;if(t.item.get(0)!==a(this).get(0)){if(v>t.item.position().top&&v<=t.originalPosition.top){if(i=="asc"){var u=parseInt(a("[type=text]",a(this)).attr("value"))+1;
}else{var u=parseInt(a("[type=text]",a(this)).attr("value"))-1;}a("[type=text]",a(this)).attr("value",u);}}});}else{if(t.originalPosition.top<t.position.top){if(t.item.position().top!=t.originalPosition.top){a("[type=text]",t.item).attr("value",parseInt(a("[type=text]",t.item.prev()).attr("value")));
}a(p).each(function(){var v=a(this).position().top;if(t.item.get(0)!==a(this).get(0)){if(v<t.item.position().top&&v>=t.originalPosition.top){if(i=="asc"){var u=parseInt(a("[type=text]",a(this)).attr("value"))-1;
}else{var u=parseInt(a("[type=text]",a(this)).attr("value"))+1;}a("[type=text]",a(this)).attr("value",u);}}});}}}};this.cloneMarkedCheckboxes=function(){a('[name="order[]"]',a(n)).attr("name","order-tmp");
a("[type=checkbox]",j.sortableRange).each(function(){var p=a(this).clone();a(p).attr({checked:"checked",shadow:"shadow",id:""});a("#"+k).append(a(p));a('[name="order-tmp"]',a(this).parents("tr")).attr("name","order[]");
});};this.removeClonedCheckboxes=function(){a("[shadow=shadow]").remove();a('[name="order-tmp"]',a(n)).attr("name","order[]");};this.getChildrenNodes=function(p){return a('tr[parents*=" '+p+'"]');
};this.getSameLevelNodes=function(p){return a("tr[level="+p+"]");};};})(jQuery);