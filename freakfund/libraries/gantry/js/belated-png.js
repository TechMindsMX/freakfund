/*
 * DD_belatedPNG: Adds IE6 support: PNG images for CSS background-image and HTML <IMG/>.
 * Author: Drew Diller
 * Email: drew.diller@gmail.com
 * URL: http://www.dillerdesign.com/experiment/DD_belatedPNG/
 * Version: 0.0.8a
 * Licensed under the MIT License: http://dillerdesign.com/experiment/DD_belatedPNG/#license
 *
 * Example usage:
 * DD_belatedPNG.fix('.png_bg'); // argument is a CSS selector
 * DD_belatedPNG.fixPng( someNode ); // argument is an HTMLDomElement
 */
var DD_belatedPNG={ns:"DD_belatedPNG",imgSize:{},delay:10,nodesFixed:0,createVmlNameSpace:function(){if(document.namespaces&&!document.namespaces[this.ns]){document.namespaces.add(this.ns,"urn:schemas-microsoft-com:vml");
}},createVmlStyleSheet:function(){var c,d;c=document.createElement("style");c.setAttribute("media","screen");document.documentElement.firstChild.insertBefore(c,document.documentElement.firstChild.firstChild);
if(c.styleSheet){c=c.styleSheet;c.addRule(this.ns+"\\:*","{behavior:url(#default#VML)}");c.addRule(this.ns+"\\:shape","position:absolute;");c.addRule("img."+this.ns+"_sizeFinder","behavior:none; border:none; position:absolute; z-index:-1; top:-10000px; visibility:hidden;");
this.screenStyleSheet=c;d=document.createElement("style");d.setAttribute("media","print");document.documentElement.firstChild.insertBefore(d,document.documentElement.firstChild.firstChild);
d=d.styleSheet;d.addRule(this.ns+"\\:*","{display: none !important;}");d.addRule("img."+this.ns+"_sizeFinder","{display: none !important;}");}},readPropertyChange:function(){var d,f,e;
d=event.srcElement;if(!d.vmlInitiated){return;}if(event.propertyName.search("background")!=-1||event.propertyName.search("border")!=-1){DD_belatedPNG.applyVML(d);
}if(event.propertyName=="style.display"){f=(d.currentStyle.display=="none")?"none":"block";for(e in d.vml){if(d.vml.hasOwnProperty(e)){d.vml[e].shape.style.display=f;
}}}if(event.propertyName.search("filter")!=-1){DD_belatedPNG.vmlOpacity(d);}},vmlOpacity:function(c){if(c.currentStyle.filter.search("lpha")!=-1){var d=c.currentStyle.filter;
d=parseInt(d.substring(d.lastIndexOf("=")+1,d.lastIndexOf(")")),10)/100;c.vml.color.shape.style.filter=c.currentStyle.filter;c.vml.image.fill.opacity=d;
}},handlePseudoHover:function(b){setTimeout(function(){DD_belatedPNG.applyVML(b);},1);},fix:function(e){if(this.screenStyleSheet){var f,d;f=e.split(",");
for(d=0;d<f.length;d++){this.screenStyleSheet.addRule(f[d],"behavior:expression(DD_belatedPNG.fixPng(this))");}}},applyVML:function(b){b.runtimeStyle.cssText="";
this.vmlFill(b);this.vmlOffsets(b);this.vmlOpacity(b);if(b.isImg){this.copyImageBorders(b);}},attachHandlers:function(h){var m,n,j,l,a,k;m=this;n={resize:"vmlOffsets",move:"vmlOffsets"};
if(h.nodeName=="A"){l={mouseleave:"handlePseudoHover",mouseenter:"handlePseudoHover",focus:"handlePseudoHover",blur:"handlePseudoHover"};for(a in l){if(l.hasOwnProperty(a)){n[a]=l[a];
}}}for(k in n){if(n.hasOwnProperty(k)){j=function(){m[n[k]](h);};h.attachEvent("on"+k,j);}}h.attachEvent("onpropertychange",this.readPropertyChange);},giveLayout:function(b){b.style.zoom=1;
if(b.currentStyle.position=="static"){b.style.position="relative";}},copyImageBorders:function(d){var f,e;f={borderStyle:true,borderWidth:true,borderColor:true};
for(e in f){if(f.hasOwnProperty(e)){d.vml.color.shape.style[e]=d.currentStyle[e];}}},vmlFill:function(l){if(!l.currentStyle){return;}else{var m,k,j,h,i,n;
m=l.currentStyle;}for(h in l.vml){if(l.vml.hasOwnProperty(h)){l.vml[h].shape.style.zIndex=m.zIndex;}}l.runtimeStyle.backgroundColor="";l.runtimeStyle.backgroundImage="";
k=true;if(m.backgroundImage!="none"||l.isImg){if(!l.isImg){l.vmlBg=m.backgroundImage;l.vmlBg=l.vmlBg.substr(5,l.vmlBg.lastIndexOf('")')-5);}else{l.vmlBg=l.src;
}j=this;if(!j.imgSize[l.vmlBg]){i=document.createElement("img");j.imgSize[l.vmlBg]=i;i.className=j.ns+"_sizeFinder";i.runtimeStyle.cssText="behavior:none; position:absolute; left:-10000px; top:-10000px; border:none; margin:0; padding:0;";
n=function(){this.width=this.offsetWidth;this.height=this.offsetHeight;j.vmlOffsets(l);};i.attachEvent("onload",n);i.src=l.vmlBg;i.removeAttribute("width");
i.removeAttribute("height");document.body.insertBefore(i,document.body.firstChild);}l.vml.image.fill.src=l.vmlBg;k=false;}l.vml.image.fill.on=!k;l.vml.image.fill.color="none";
l.vml.color.shape.style.backgroundColor=m.backgroundColor;l.runtimeStyle.backgroundImage="none";l.runtimeStyle.backgroundColor="transparent";},vmlOffsets:function(x){var t,b,y,w,u,c,v,o,q,s,p;
t=x.currentStyle;b={W:x.clientWidth+1,H:x.clientHeight+1,w:this.imgSize[x.vmlBg].width,h:this.imgSize[x.vmlBg].height,L:x.offsetLeft,T:x.offsetTop,bLW:x.clientLeft,bTW:x.clientTop};
y=(b.L+b.bLW==1)?1:0;w=function(a,g,f,h,e,d){a.coordsize=h+","+e;a.coordorigin=d+","+d;a.path="m0,0l"+h+",0l"+h+","+e+"l0,"+e+" xe";a.style.width=h+"px";
a.style.height=e+"px";a.style.left=g+"px";a.style.top=f+"px";};w(x.vml.color.shape,(b.L+(x.isImg?0:b.bLW)),(b.T+(x.isImg?0:b.bTW)),(b.W-1),(b.H-1),0);w(x.vml.image.shape,(b.L+b.bLW),(b.T+b.bTW),(b.W),(b.H),1);
u={X:0,Y:0};if(x.isImg){u.X=parseInt(t.paddingLeft,10)+1;u.Y=parseInt(t.paddingTop,10)+1;}else{for(q in u){if(u.hasOwnProperty(q)){this.figurePercentage(u,b,q,t["backgroundPosition"+q]);
}}}x.vml.image.fill.position=(u.X/b.W)+","+(u.Y/b.H);c=t.backgroundRepeat;v={T:1,R:b.W+y,B:b.H,L:1+y};o={X:{b1:"L",b2:"R",d:"W"},Y:{b1:"T",b2:"B",d:"H"}};
if(c!="repeat"||x.isImg){s={T:(u.Y),R:(u.X+b.w),B:(u.Y+b.h),L:(u.X)};if(c.search("repeat-")!=-1){p=c.split("repeat-")[1].toUpperCase();s[o[p].b1]=1;s[o[p].b2]=b[o[p].d];
}if(s.B>b.H){s.B=b.H;}x.vml.image.shape.style.clip="rect("+s.T+"px "+(s.R+y)+"px "+s.B+"px "+(s.L+y)+"px)";}else{x.vml.image.shape.style.clip="rect("+v.T+"px "+v.R+"px "+v.B+"px "+v.L+"px)";
}},figurePercentage:function(k,l,i,h){var g,j;j=true;g=(i=="X");switch(h){case"left":case"top":k[i]=0;break;case"center":k[i]=0.5;break;case"right":case"bottom":k[i]=1;
break;default:if(h.search("%")!=-1){k[i]=parseInt(h,10)/100;}else{j=false;}}k[i]=Math.ceil(j?((l[g?"W":"H"]*k[i])-(l[g?"w":"h"]*k[i])):parseInt(h,10));
if(k[i]%2===0){k[i]++;}return k[i];},fixPng:function(l){l.style.behavior="none";var i,e,j,h,k;if(l.nodeName=="BODY"||l.nodeName=="TD"||l.nodeName=="TR"){return;
}l.isImg=false;if(l.nodeName=="IMG"){if(l.src.toLowerCase().search(/\.png$/)!=-1){l.isImg=true;l.style.visibility="hidden";}else{return;}}else{if(l.currentStyle.backgroundImage.toLowerCase().search(".png")==-1){return;
}}i=DD_belatedPNG;l.vml={color:{},image:{}};e={shape:{},fill:{}};for(h in l.vml){if(l.vml.hasOwnProperty(h)){for(k in e){if(e.hasOwnProperty(k)){j=i.ns+":"+k;
l.vml[h][k]=document.createElement(j);}}l.vml[h].shape.stroked=false;l.vml[h].shape.appendChild(l.vml[h].fill);l.parentNode.insertBefore(l.vml[h].shape,l);
}}l.vml.image.shape.fillcolor="none";l.vml.image.fill.type="tile";l.vml.color.fill.on=false;i.attachHandlers(l);i.giveLayout(l);i.giveLayout(l.offsetParent);
l.vmlInitiated=true;i.applyVML(l);}};try{document.execCommand("BackgroundImageCache",false,true);}catch(r){}DD_belatedPNG.createVmlNameSpace();DD_belatedPNG.createVmlStyleSheet();
