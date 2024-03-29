/*
 * Date Format 1.2.3
 * (c) 2007-2009 Steven Levithan <stevenlevithan.com>
 * MIT license
 *
 * Includes enhancements by Scott Trenda <scott.trenda.net>
 * and Kris Kowal <cixar.com/~kris.kowal/>
 *
 * Includes PHP strftime flags, prefixed via $ rather than %
 * by Djamil Legato @ RocketTheme, LLC.
 *
 * Accepts a date, a mask, or a date and a mask.
 * Returns a formatted version of the given date.
 * The date defaults to the current date/time.
 * The mask defaults to dateFormat.masks.default.
 */
var dateFormat=function(){var a=/d{1,4}|(\$[a-zA-Z]){1}|m{1,4}|yy(?:yy)?|([HhMsTt])\1?|[LloSZ]|"[^"]*"|'[^']*'/g,b=/\b(?:[PMCEA][SDP]T|(?:Pacific|Mountain|Central|Eastern|Atlantic) (?:Standard|Daylight|Prevailing) Time|(?:GMT|UTC)(?:[-+]\d{4})?)\b/g,d=/[^-+\dA-Z]/g,c=function(f,e){f=String(f);
e=e||2;while(f.length<e){f="0"+f;}return f;};return function(i,v,q){var g=dateFormat;if(arguments.length==1&&Object.prototype.toString.call(i)=="[object String]"&&!/\d/.test(i)){v=i;
i=undefined;}i=i?new Date(i):new Date();if(isNaN(i)){throw SyntaxError("invalid date");}v=String(g.masks[v]||v||g.masks["default"]);if(v.slice(0,4)=="UTC:"){v=v.slice(4);
q=true;}var t=q?"getUTC":"get",l=i[t+"Date"](),e=i[t+"Day"](),j=i[t+"Month"](),p=i[t+"FullYear"](),r=i[t+"Hours"](),k=i[t+"Minutes"](),u=i[t+"Seconds"](),n=i[t+"Milliseconds"](),f=q?0:i.getTimezoneOffset(),h={d:l,$e:l,dd:c(l),$d:c(l),ddd:g.i18n.dayNames[e],$a:g.i18n.dayNames[e],dddd:g.i18n.dayNames[e+7],$A:g.i18n.dayNames[e+7],m:j+1,mm:c(j+1),$m:c(j+1),mmm:g.i18n.monthNames[j],$h:g.i18n.monthNames[j],mmmm:g.i18n.monthNames[j+12],$B:g.i18n.monthNames[j+12],yy:String(p).slice(2),$y:String(p).slice(2),yyyy:p,$Y:p,h:r%12||12,$l:r%12||12,hh:c(r%12||12),$I:c(r%12||12),H:r,$H:r,HH:c(r),M:k,MM:c(k),$M:c(k),s:u,ss:c(u),$S:c(u),l:c(n,3),L:c(n>99?Math.round(n/10):n),t:r<12?"a":"p",tt:r<12?"am":"pm",$P:r<12?"am":"pm",T:r<12?"A":"P",TT:r<12?"AM":"PM",$p:r<12?"AM":"PM",Z:q?"UTC":(String(i).match(b)||[""]).pop().replace(d,""),o:(f>0?"-":"+")+c(Math.floor(Math.abs(f)/60)*100+Math.abs(f)%60,4),S:["th","st","nd","rd"][l%10>3?0:(l%100-l%10!=10)*l%10]};
return v.replace(a,function(m){return m in h?h[m]:m.slice(1,m.length-1);});};}();dateFormat.masks={"default":"ddd mmm dd yyyy HH:MM:ss",shortDate:"m/d/yy",mediumDate:"mmm d, yyyy",longDate:"mmmm d, yyyy",fullDate:"dddd, mmmm d, yyyy",shortTime:"h:MM TT",mediumTime:"h:MM:ss TT",longTime:"h:MM:ss TT Z",isoDate:"yyyy-mm-dd",isoTime:"HH:MM:ss",isoDateTime:"yyyy-mm-dd'T'HH:MM:ss",isoUtcDateTime:"UTC:yyyy-mm-dd'T'HH:MM:ss'Z'"};
dateFormat.i18n={dayNames:["Sun","Mon","Tue","Wed","Thu","Fri","Sat","Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],monthNames:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec","January","February","March","April","May","June","July","August","September","October","November","December"]};
Date.prototype.format=function(a,b){return dateFormat(this,a,b);};