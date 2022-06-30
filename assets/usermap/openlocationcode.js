!function(e,r){"function"==typeof define&&define.amd?define(function(){return e.returnExportsGlobal=r()}):"object"==typeof module&&module.exports?module.exports=r():e.OpenLocationCode=r()}(this,function(){var e={CODE_PRECISION_NORMAL:10,CODE_PRECISION_EXTRA:11},r="23456789CFGHJMPQRVWX",t=r.length,n=Math.pow(t,4),o=Math.pow(t,3),i=[20,1,.05,.0025,125e-6],a=Math.pow(5,4),u=Math.pow(4,4),f=o*Math.pow(5,5),h=o*Math.pow(4,5);e.getAlphabet=function(){return r};var l=e.isValid=function(e){if(!e||"string"!=typeof e)return!1;if(-1==e.indexOf("+"))return!1;if(e.indexOf("+")!=e.lastIndexOf("+"))return!1;if(1==e.length)return!1;if(e.indexOf("+")>8||e.indexOf("+")%2==1)return!1;if(e.indexOf("0")>-1){if(e.indexOf("+")<8)return!1;if(0==e.indexOf("0"))return!1;var t=e.match(new RegExp("(0+)","g"));if(t.length>1||t[0].length%2==1||t[0].length>6)return!1;if("+"!=e.charAt(e.length-1))return!1}if(e.length-e.indexOf("+")-1==1)return!1;for(var n=0,o=(e=e.replace(new RegExp("\\++"),"").replace(new RegExp("0+"),"")).length;n<o;n++){var i=e.charAt(n).toUpperCase();if("+"!=i&&-1==r.indexOf(i))return!1}return!0},d=e.isShort=function(e){return!!l(e)&&(e.indexOf("+")>=0&&e.indexOf("+")<8)},s=e.isFull=function(e){if(!l(e))return!1;if(d(e))return!1;if(r.indexOf(e.charAt(0).toUpperCase())*t>=180)return!1;if(e.length>1&&r.indexOf(e.charAt(1).toUpperCase())*t>=360)return!1;return!0},p=e.encode=function(n,o,i){if(n=Number(n),o=Number(o),i=void 0===i?e.CODE_PRECISION_NORMAL:Math.min(15,Number(i)),isNaN(n)||isNaN(o)||isNaN(i))throw new Error("ValueError: Parameters are not numbers");if(i<2||i<10&&i%2==1)throw new Error("IllegalArgumentException: Invalid Open Location Code length");n=g(n),o=C(o),90==n&&(n-=M(i));var a="",u=Math.floor(Math.round((n+90)*f*1e6)/1e6),l=Math.floor(Math.round((o+180)*h*1e6)/1e6);if(i>10)for(var d=0;d<5;d++){a=r.charAt(4*(u%5)+l%4)+a,u=Math.floor(u/5),l=Math.floor(l/4)}else u=Math.floor(u/Math.pow(5,5)),l=Math.floor(l/Math.pow(4,5));for(d=0;d<5;d++)a=r.charAt(l%t)+a,a=r.charAt(u%t)+a,u=Math.floor(u/t),l=Math.floor(l/t);return a=a.substring(0,8)+"+"+a.substring(8),i>=8?a.substring(0,i+1):a.substring(0,i)+Array(8-i+1).join("0")+"+"},c=e.decode=function(e){if(!s(e))throw new Error("IllegalArgumentException: Passed Open Location Code is not a valid full code: "+e);e=e.replace("+","").replace(/0/g,"").toLocaleUpperCase("en-US");for(var i=-90*o,l=-180*o,d=0,p=0,c=Math.min(e.length,10),g=n,M=0;M<c;M+=2)i+=r.indexOf(e.charAt(M))*g,l+=r.indexOf(e.charAt(M+1))*g,M<c-2&&(g/=t);var C=g/o,O=g/o;if(e.length>10){var x=a,E=u;c=Math.min(e.length,15);for(M=10;M<c;M++){var m=r.indexOf(e.charAt(M));d+=Math.floor(m/4)*x,p+=m%4*E,M<c-1&&(x/=5,E/=4)}C=x/f,O=E/h}var N=i/o+d/f,b=l/o+p/h;return new w(Math.round(1e14*N)/1e14,Math.round(1e14*b)/1e14,Math.round(1e14*(N+C))/1e14,Math.round(1e14*(b+O))/1e14,Math.min(e.length,15))};e.recoverNearest=function(e,r,t){if(!d(e)){if(s(e))return e.toUpperCase();throw new Error("ValueError: Passed short code is not valid: "+e)}if(r=Number(r),t=Number(t),isNaN(r)||isNaN(t))throw new Error("ValueError: Reference position are not numbers");r=g(r),t=C(t);var n=8-(e=e.toUpperCase()).indexOf("+"),o=Math.pow(20,2-n/2),i=o/2,a=c(p(r,t).substr(0,n)+e);return r+i<a.latitudeCenter&&a.latitudeCenter-o>=-90?a.latitudeCenter-=o:r-i>a.latitudeCenter&&a.latitudeCenter+o<=90&&(a.latitudeCenter+=o),t+i<a.longitudeCenter?a.longitudeCenter-=o:t-i>a.longitudeCenter&&(a.longitudeCenter+=o),p(a.latitudeCenter,a.longitudeCenter,a.codeLength)},e.shorten=function(e,r,t){if(!s(e))throw new Error("ValueError: Passed code is not valid and full: "+e);if(-1!=e.indexOf("0"))throw new Error("ValueError: Cannot shorten padded codes: "+e);e=e.toUpperCase();var n=c(e);if(n.codeLength<6)throw new Error("ValueError: Code length must be at least 6");if(r=Number(r),t=Number(t),isNaN(r)||isNaN(t))throw new Error("ValueError: Reference position are not numbers");r=g(r),t=C(t);for(var o=Math.max(Math.abs(n.latitudeCenter-r),Math.abs(n.longitudeCenter-t)),a=i.length-2;a>=1;a--)if(o<.3*i[a])return e.substring(2*(a+1));return e};var g=function(e){return Math.min(90,Math.max(-90,e))},M=function(e){return e<=10?Math.pow(t,Math.floor(e/-2+2)):Math.pow(t,-3)/Math.pow(5,e-10)},C=function(e){for(;e<-180;)e+=360;for(;e>=180;)e-=360;return e},w=e.CodeArea=function(r,t,n,o,i){return new e.CodeArea.fn.Init(r,t,n,o,i)};return w.fn=w.prototype={Init:function(e,r,t,n,o){this.latitudeLo=e,this.longitudeLo=r,this.latitudeHi=t,this.longitudeHi=n,this.codeLength=o,this.latitudeCenter=Math.min(e+(t-e)/2,90),this.longitudeCenter=Math.min(r+(n-r)/2,180)}},w.fn.Init.prototype=w.fn,e});