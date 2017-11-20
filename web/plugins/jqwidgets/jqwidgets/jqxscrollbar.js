/*
jQWidgets v4.5.4 (2017-June)
Copyright (c) 2011-2017 jQWidgets.
License: http://jqwidgets.com/license/
*/
!function(a){a.jqx.jqxWidget("jqxScrollBar","",{}),a.extend(a.jqx._jqxScrollBar.prototype,{defineInstance:function(){var b={height:null,width:null,vertical:!1,min:0,max:1e3,value:0,step:10,largestep:50,thumbMinSize:10,thumbSize:0,thumbStep:"auto",roundedCorners:"all",showButtons:!0,disabled:!1,touchMode:"auto",touchModeStyle:"auto",thumbTouchSize:0,_triggervaluechanged:!0,rtl:!1,areaDownCapture:!1,areaUpCapture:!1,_initialLayout:!1,offset:0,reference:0,velocity:0,frame:0,timestamp:0,ticker:null,amplitude:0,target:0};return this===a.jqx._jqxScrollBar.prototype?b:(a.extend(!0,this,b),b)},createInstance:function(a){this.render()},render:function(){this._mouseup=new Date;var b=this,c="<div id='jqxScrollOuterWrap' style='box-sizing: content-box; width:100%; height: 100%; align:left; border: 0px; valign:top; position: relative;'><div id='jqxScrollWrap' style='box-sizing: content-box; width:100%; height: 100%; left: 0px; top: 0px; align:left; valign:top; position: absolute;'><div id='jqxScrollBtnUp' style='box-sizing: content-box; align:left; valign:top; left: 0px; top: 0px; position: absolute;'><div></div></div><div id='jqxScrollAreaUp' style='box-sizing: content-box; align:left; valign:top; left: 0px; top: 0px; position: absolute;'></div><div id='jqxScrollThumb' style='box-sizing: content-box; align:left; valign:top; left: 0px; top: 0px; position: absolute;'></div><div id='jqxScrollAreaDown' style='box-sizing: content-box; align:left; valign:top; left: 0px; top: 0px; position: absolute;'></div><div id='jqxScrollBtnDown' style='box-sizing: content-box; align:left; valign:top; left: 0px; top: 0px; position: absolute;'><div></div></div></div></div>";if(a.jqx.utilities&&"hidden"==a.jqx.utilities.scrollBarButtonsVisibility&&(this.showButtons=!1),b.WinJS?MSApp.execUnsafeLocalFunction(function(){b.host.html(c)}):this.element.innerHTML=c,void 0!=this.width&&parseInt(this.width)>0&&this.host.width(parseInt(this.width)),void 0!=this.height&&parseInt(this.height)>0&&this.host.height(parseInt(this.height)),this.isPercentage=!1,null!=this.width&&-1!=this.width.toString().indexOf("%")&&(this.host.width(this.width),this.isPercentage=!0),null!=this.height&&-1!=this.height.toString().indexOf("%")&&(this.host.height(this.height),this.isPercentage=!0),this.isPercentage){var d=this;a.jqx.utilities.resize(this.host,function(){d._arrange()},!1)}this.thumbCapture=!1,this.scrollOuterWrap=a(this.element.firstChild),this.scrollWrap=a(this.scrollOuterWrap[0].firstChild),this.btnUp=a(this.scrollWrap[0].firstChild),this.areaUp=a(this.btnUp[0].nextSibling),this.btnThumb=a(this.areaUp[0].nextSibling),this.arrowUp=a(this.btnUp[0].firstChild),this.areaDown=a(this.btnThumb[0].nextSibling),this.btnDown=a(this.areaDown[0].nextSibling),this.arrowDown=a(this.btnDown[0].firstChild);var e=this.element.id;if(this.btnUp[0].id="jqxScrollBtnUp"+e,this.btnDown[0].id="jqxScrollBtnDown"+e,this.btnThumb[0].id="jqxScrollThumb"+e,this.areaUp[0].id="jqxScrollAreaUp"+e,this.areaDown[0].id="jqxScrollAreaDown"+e,this.scrollWrap[0].id="jqxScrollWrap"+e,this.scrollOuterWrap[0].id="jqxScrollOuterWrap"+e,!this.host.jqxRepeatButton)throw new Error("jqxScrollBar: Missing reference to jqxbuttons.js.");this.btnUp.jqxRepeatButton({_ariaDisabled:!0,overrideTheme:!0,disabled:this.disabled}),this.btnDown.jqxRepeatButton({_ariaDisabled:!0,overrideTheme:!0,disabled:this.disabled}),this.btnDownInstance=a.data(this.btnDown[0],"jqxRepeatButton").instance,this.btnUpInstance=a.data(this.btnUp[0],"jqxRepeatButton").instance,this.areaUp.jqxRepeatButton({_scrollAreaButton:!0,_ariaDisabled:!0,overrideTheme:!0}),this.areaDown.jqxRepeatButton({_scrollAreaButton:!0,_ariaDisabled:!0,overrideTheme:!0}),this.btnThumb.jqxButton({_ariaDisabled:!0,overrideTheme:!0,disabled:this.disabled}),this.propertyChangeMap.value=function(a,b,c,d){isNaN(d)||c!=d&&a.setPosition(parseFloat(d),!0)},this.propertyChangeMap.width=function(a,b,c,d){void 0!=a.width&&parseInt(a.width)>0&&(a.host.width(parseInt(a.width)),a._arrange())},this.propertyChangeMap.height=function(a,b,c,d){void 0!=a.height&&parseInt(a.height)>0&&(a.host.height(parseInt(a.height)),a._arrange())},this.propertyChangeMap.theme=function(a,b,c,d){a.setTheme()},this.propertyChangeMap.max=function(a,b,c,d){isNaN(d)||c!=d&&(a.max=parseInt(d),a.min>a.max&&(a.max=a.min+1),a._arrange(),a.setPosition(a.value))},this.propertyChangeMap.min=function(a,b,c,d){isNaN(d)||c!=d&&(a.min=parseInt(d),a.min>a.max&&(a.max=a.min+1),a._arrange(),a.setPosition(a.value))},this.propertyChangeMap.disabled=function(a,b,c,d){c!=d&&(d?a.host.addClass(a.toThemeProperty("jqx-fill-state-disabled")):a.host.removeClass(a.toThemeProperty("jqx-fill-state-disabled")),a.btnUp.jqxRepeatButton("disabled",a.disabled),a.btnDown.jqxRepeatButton("disabled",a.disabled),a.btnThumb.jqxButton("disabled",a.disabled))},this.propertyChangeMap.touchMode=function(a,b,c,d){c!=d&&(a._updateTouchBehavior(),!0===d?(a.showButtons=!1,a.refresh()):!1===d&&(a.showButtons=!0,a.refresh()))},this.propertyChangeMap.rtl=function(a,b,c,d){c!=d&&a.refresh()},this.buttonUpCapture=!1,this.buttonDownCapture=!1,this._updateTouchBehavior(),this.setPosition(this.value),this._addHandlers(),this.setTheme()},resize:function(a,b){this.width=a,this.height=b,this._arrange()},_updateTouchBehavior:function(){if(this.isTouchDevice=a.jqx.mobile.isTouchDevice(),1==this.touchMode){if(a.jqx.browser.msie&&a.jqx.browser.version<9)return void this.setTheme();this.isTouchDevice=!0,a.jqx.mobile.setMobileSimulator(this.btnThumb[0]),this._removeHandlers(),this._addHandlers(),this.setTheme()}else 0==this.touchMode&&(this.isTouchDevice=!1)},_addHandlers:function(){var b=this,c=!1;try{("ontouchstart"in window||window.DocumentTouch&&document instanceof DocumentTouch)&&(c=!0,this._touchSupport=!0)}catch(a){}if((b.isTouchDevice||c)&&(this.addHandler(this.btnThumb,a.jqx.mobile.getTouchEventName("touchend"),function(a){var c=b.vertical?b.toThemeProperty("jqx-scrollbar-thumb-state-pressed"):b.toThemeProperty("jqx-scrollbar-thumb-state-pressed-horizontal"),d=b.toThemeProperty("jqx-fill-state-pressed");return b.btnThumb.removeClass(c),b.btnThumb.removeClass(d),b.disabled||b.handlemouseup(b,a),!1}),this.addHandler(this.btnThumb,a.jqx.mobile.getTouchEventName("touchstart"),function(a){if(!b.disabled){if(1==b.touchMode)a.clientX=a.originalEvent.clientX,a.clientY=a.originalEvent.clientY;else{var c=a;c.originalEvent.touches&&c.originalEvent.touches.length?(a.clientX=c.originalEvent.touches[0].clientX,a.clientY=c.originalEvent.touches[0].clientY):(a.clientX=a.originalEvent.clientX,a.clientY=a.originalEvent.clientY)}b.handlemousedown(a),a.preventDefault&&a.preventDefault()}}),a.jqx.mobile.touchScroll(this.element,b.max,function(a,c,d,e,f){if("visible"==b.host.css("visibility")){if(1==b.touchMode)f.clientX=f.originalEvent.clientX,f.clientY=f.originalEvent.clientY;else{var g=f;g.originalEvent.touches&&g.originalEvent.touches.length?(f.clientX=g.originalEvent.touches[0].clientX,f.clientY=g.originalEvent.touches[0].clientY):(f.clientX=f.originalEvent.clientX,f.clientY=f.originalEvent.clientY)}var h=b.vertical?b.toThemeProperty("jqx-scrollbar-thumb-state-pressed"):b.toThemeProperty("jqx-scrollbar-thumb-state-pressed-horizontal");b.btnThumb.addClass(h),b.btnThumb.addClass(b.toThemeProperty("jqx-fill-state-pressed")),b.thumbCapture=!0,b.handlemousemove(f)}},b.element.id,b.host,b.host)),!this.isTouchDevice){try{if((""!=document.referrer||window.frameElement)&&null!=window.top&&window.top!=window.self){var d=null;if(window.parent&&document.referrer&&(d=document.referrer),d&&-1!=d.indexOf(document.location.host)){var e=function(a){b.disabled||b.handlemouseup(b,a)};window.top.document.addEventListener?window.top.document.addEventListener("mouseup",e,!1):window.top.document.attachEvent&&window.top.document.attachEvent("onmouseup",e)}}}catch(a){}this.addHandler(this.btnDown,"click mouseup mousedown",function(a){var c=b.step;switch(Math.abs(b.max-b.min)<=c&&(c=1),b.rtl&&!b.vertical&&(c=-b.step),a.type){case"click":b.buttonDownCapture&&!b.isTouchDevice?b.disabled||b.setPosition(b.value+c):!b.disabled&&b.isTouchDevice&&b.setPosition(b.value+c);break;case"mouseup":if(!b.btnDownInstance.base.disabled&&b.buttonDownCapture)return b.buttonDownCapture=!1,b.btnDown.removeClass(b.toThemeProperty("jqx-scrollbar-button-state-pressed")),b.btnDown.removeClass(b.toThemeProperty("jqx-fill-state-pressed")),b._removeArrowClasses("pressed","down"),b.handlemouseup(b,a),b.setPosition(b.value+c),!1;break;case"mousedown":if(!b.btnDownInstance.base.disabled)return b.buttonDownCapture=!0,b.btnDown.addClass(b.toThemeProperty("jqx-fill-state-pressed")),b.btnDown.addClass(b.toThemeProperty("jqx-scrollbar-button-state-pressed")),b._addArrowClasses("pressed","down"),!1}}),this.addHandler(this.btnUp,"click mouseup mousedown",function(a){var c=b.step;switch(Math.abs(b.max-b.min)<=c&&(c=1),b.rtl&&!b.vertical&&(c=-b.step),a.type){case"click":b.buttonUpCapture&&!b.isTouchDevice?b.disabled||b.setPosition(b.value-c):!b.disabled&&b.isTouchDevice&&b.setPosition(b.value-c);break;case"mouseup":if(!b.btnUpInstance.base.disabled&&b.buttonUpCapture)return b.buttonUpCapture=!1,b.btnUp.removeClass(b.toThemeProperty("jqx-scrollbar-button-state-pressed")),b.btnUp.removeClass(b.toThemeProperty("jqx-fill-state-pressed")),b._removeArrowClasses("pressed","up"),b.handlemouseup(b,a),b.setPosition(b.value-c),!1;break;case"mousedown":if(!b.btnUpInstance.base.disabled)return b.buttonUpCapture=!0,b.btnUp.addClass(b.toThemeProperty("jqx-fill-state-pressed")),b.btnUp.addClass(b.toThemeProperty("jqx-scrollbar-button-state-pressed")),b._addArrowClasses("pressed","up"),!1}})}var f="click";if(this.isTouchDevice&&(f=a.jqx.mobile.getTouchEventName("touchend")),this.addHandler(this.areaUp,f,function(a){if(!b.disabled){var c=b.largestep;return b.rtl&&!b.vertical&&(c=-b.largestep),b.setPosition(b.value-c),!1}}),this.addHandler(this.areaDown,f,function(a){if(!b.disabled){var c=b.largestep;return b.rtl&&!b.vertical&&(c=-b.largestep),b.setPosition(b.value+c),!1}}),this.addHandler(this.areaUp,"mousedown",function(a){if(!b.disabled)return b.areaUpCapture=!0,!1}),this.addHandler(this.areaDown,"mousedown",function(a){if(!b.disabled)return b.areaDownCapture=!0,!1}),this.addHandler(this.btnThumb,"mousedown dragstart",function(a){if("dragstart"===a.type)return!1;b.disabled||b.handlemousedown(a),a.preventDefault&&a.preventDefault()}),this.addHandler(a(document),"mouseup."+this.element.id,function(a){b.disabled||b.handlemouseup(b,a)}),!this.isTouchDevice&&(this.mousemoveFunc=function(a){b.disabled||b.handlemousemove(a)},this.addHandler(a(document),"mousemove."+this.element.id,this.mousemoveFunc),this.addHandler(a(document),"mouseleave."+this.element.id,function(a){b.disabled||b.handlemouseleave(a)}),this.addHandler(a(document),"mouseenter."+this.element.id,function(a){b.disabled||b.handlemouseenter(a)}),!b.disabled)){this.addHandler(this.btnUp,"mouseenter mouseleave",function(a){"mouseenter"===a.type?b.disabled||b.btnUpInstance.base.disabled||1==b.touchMode||(b.btnUp.addClass(b.toThemeProperty("jqx-scrollbar-button-state-hover")),b.btnUp.addClass(b.toThemeProperty("jqx-fill-state-hover")),b._addArrowClasses("hover","up")):b.disabled||b.btnUpInstance.base.disabled||1==b.touchMode||(b.btnUp.removeClass(b.toThemeProperty("jqx-scrollbar-button-state-hover")),b.btnUp.removeClass(b.toThemeProperty("jqx-fill-state-hover")),b._removeArrowClasses("hover","up"))});var g=b.toThemeProperty("jqx-scrollbar-thumb-state-hover");b.vertical||(g=b.toThemeProperty("jqx-scrollbar-thumb-state-hover-horizontal")),this.addHandler(this.btnThumb,"mouseenter mouseleave",function(a){"mouseenter"===a.type?b.disabled||1==b.touchMode||(b.btnThumb.addClass(g),b.btnThumb.addClass(b.toThemeProperty("jqx-fill-state-hover"))):b.disabled||1==b.touchMode||(b.btnThumb.removeClass(g),b.btnThumb.removeClass(b.toThemeProperty("jqx-fill-state-hover")))}),this.addHandler(this.btnDown,"mouseenter mouseleave",function(a){"mouseenter"===a.type?b.disabled||b.btnDownInstance.base.disabled||1==b.touchMode||(b.btnDown.addClass(b.toThemeProperty("jqx-scrollbar-button-state-hover")),b.btnDown.addClass(b.toThemeProperty("jqx-fill-state-hover")),b._addArrowClasses("hover","down")):b.disabled||b.btnDownInstance.base.disabled||1==b.touchMode||(b.btnDown.removeClass(b.toThemeProperty("jqx-scrollbar-button-state-hover")),b.btnDown.removeClass(b.toThemeProperty("jqx-fill-state-hover")),b._removeArrowClasses("hover","down"))})}},destroy:function(){var b=this.btnUp,c=this.btnDown,d=this.btnThumb,e=(this.scrollWrap,this.areaUp),f=this.areaDown;this.arrowUp.remove(),delete this.arrowUp,this.arrowDown.remove(),delete this.arrowDown,f.removeClass(),e.removeClass(),c.removeClass(),b.removeClass(),d.removeClass(),b.jqxRepeatButton("destroy"),c.jqxRepeatButton("destroy"),e.jqxRepeatButton("destroy"),f.jqxRepeatButton("destroy"),d.jqxButton("destroy");var g=a.data(this.element,"jqxScrollBar");this._removeHandlers(),this.btnUp=null,this.btnDown=null,this.scrollWrap=null,this.areaUp=null,this.areaDown=null,this.scrollOuterWrap=null,delete this.mousemoveFunc,delete this.btnDownInstance,delete this.btnUpInstance,delete this.scrollOuterWrap,delete this.scrollWrap,delete this.btnDown,delete this.areaDown,delete this.areaUp,delete this.btnDown,delete this.btnUp,delete this.btnThumb,delete this.propertyChangeMap.value,delete this.propertyChangeMap.min,delete this.propertyChangeMap.max,delete this.propertyChangeMap.touchMode,delete this.propertyChangeMap.disabled,delete this.propertyChangeMap.theme,delete this.propertyChangeMap,g&&delete g.instance,this.host.removeData(),this.host.remove(),delete this.host,delete this.set,delete this.get,delete this.call,delete this.element},_removeHandlers:function(){this.removeHandler(this.btnUp,"mouseenter"),this.removeHandler(this.btnDown,"mouseenter"),this.removeHandler(this.btnThumb,"mouseenter"),this.removeHandler(this.btnUp,"mouseleave"),this.removeHandler(this.btnDown,"mouseleave"),this.removeHandler(this.btnThumb,"mouseleave"),this.removeHandler(this.btnUp,"click"),this.removeHandler(this.btnDown,"click"),this.removeHandler(this.btnDown,"mouseup"),this.removeHandler(this.btnUp,"mouseup"),this.removeHandler(this.btnDown,"mousedown"),this.removeHandler(this.btnUp,"mousedown"),this.removeHandler(this.areaUp,"mousedown"),this.removeHandler(this.areaDown,"mousedown"),this.removeHandler(this.areaUp,"click"),this.removeHandler(this.areaDown,"click"),this.removeHandler(this.btnThumb,"mousedown"),this.removeHandler(this.btnThumb,"dragstart"),this.removeHandler(a(document),"mouseup."+this.element.id),this.mousemoveFunc?this.removeHandler(a(document),"mousemove."+this.element.id,this.mousemoveFunc):this.removeHandler(a(document),"mousemove."+this.element.id),this.removeHandler(a(document),"mouseleave."+this.element.id),this.removeHandler(a(document),"mouseenter."+this.element.id)},_addArrowClasses:function(a,b){"pressed"==a&&(a="selected"),""!=a&&(a="-"+a),this.vertical?("up"!=b&&void 0!=b||this.arrowUp.addClass(this.toThemeProperty("jqx-icon-arrow-up"+a)),"down"!=b&&void 0!=b||this.arrowDown.addClass(this.toThemeProperty("jqx-icon-arrow-down"+a))):("up"!=b&&void 0!=b||this.arrowUp.addClass(this.toThemeProperty("jqx-icon-arrow-left"+a)),"down"!=b&&void 0!=b||this.arrowDown.addClass(this.toThemeProperty("jqx-icon-arrow-right"+a)))},_removeArrowClasses:function(a,b){"pressed"==a&&(a="selected"),""!=a&&(a="-"+a),this.vertical?("up"!=b&&void 0!=b||this.arrowUp.removeClass(this.toThemeProperty("jqx-icon-arrow-up"+a)),"down"!=b&&void 0!=b||this.arrowDown.removeClass(this.toThemeProperty("jqx-icon-arrow-down"+a))):("up"!=b&&void 0!=b||this.arrowUp.removeClass(this.toThemeProperty("jqx-icon-arrow-left"+a)),"down"!=b&&void 0!=b||this.arrowDown.removeClass(this.toThemeProperty("jqx-icon-arrow-right"+a)))},setTheme:function(){var b=this.btnUp,c=this.btnDown,d=this.btnThumb,e=this.scrollWrap,f=(this.areaUp,this.areaDown,this.arrowUp),g=this.arrowDown;this.scrollWrap[0].className=this.toThemeProperty("jqx-reset"),this.scrollOuterWrap[0].className=this.toThemeProperty("jqx-reset");var h=this.toThemeProperty("jqx-reset");this.areaDown[0].className=h,this.areaUp[0].className=h;var i=this.toThemeProperty("jqx-scrollbar")+" "+this.toThemeProperty("jqx-widget")+" "+this.toThemeProperty("jqx-widget-content");this.host.addClass(i),this.isTouchDevice&&this.host.addClass(this.toThemeProperty("jqx-scrollbar-mobile")),c[0].className=this.toThemeProperty("jqx-scrollbar-button-state-normal"),b[0].className=this.toThemeProperty("jqx-scrollbar-button-state-normal");var j="";if(this.vertical?(f[0].className=h+" "+this.toThemeProperty("jqx-icon-arrow-up"),g[0].className=h+" "+this.toThemeProperty("jqx-icon-arrow-down"),j=this.toThemeProperty("jqx-scrollbar-thumb-state-normal")):(f[0].className=h+" "+this.toThemeProperty("jqx-icon-arrow-left"),g[0].className=h+" "+this.toThemeProperty("jqx-icon-arrow-right"),j=this.toThemeProperty("jqx-scrollbar-thumb-state-normal-horizontal")),j+=" "+this.toThemeProperty("jqx-fill-state-normal"),d[0].className=j,this.disabled?(e.addClass(this.toThemeProperty("jqx-fill-state-disabled")),e.removeClass(this.toThemeProperty("jqx-scrollbar-state-normal"))):(e.addClass(this.toThemeProperty("jqx-scrollbar-state-normal")),e.removeClass(this.toThemeProperty("jqx-fill-state-disabled"))),"all"==this.roundedCorners)if(this.host.addClass(this.toThemeProperty("jqx-rc-all")),this.vertical){var k=a.jqx.cssroundedcorners("top");k=this.toThemeProperty(k),b.addClass(k);var l=a.jqx.cssroundedcorners("bottom");l=this.toThemeProperty(l),c.addClass(l)}else{var m=a.jqx.cssroundedcorners("left");m=this.toThemeProperty(m),b.addClass(m);var n=a.jqx.cssroundedcorners("right");n=this.toThemeProperty(n),c.addClass(n)}else{var o=a.jqx.cssroundedcorners(this.roundedCorners);o=this.toThemeProperty(o),elBtnUp.addClass(o),elBtnDown.addClass(o)}var o=a.jqx.cssroundedcorners(this.roundedCorners);o=this.toThemeProperty(o),d.hasClass(o)||d.addClass(o),"none"===b.css("display")&&(this.showButtons=!1,this.touchModeStyle=!0,d.addClass(this.toThemeProperty("jqx-scrollbar-thumb-state-normal-touch"))),this.isTouchDevice&&0!=this.touchModeStyle&&(this.showButtons=!1,d.addClass(this.toThemeProperty("jqx-scrollbar-thumb-state-normal-touch")))},isScrolling:function(){return void 0!=this.thumbCapture&&void 0!=this.buttonDownCapture&&void 0!=this.buttonUpCapture&&void 0!=this.areaDownCapture&&void 0!=this.areaUpCapture&&(this.thumbCapture||this.buttonDownCapture||this.buttonUpCapture||this.areaDownCapture||this.areaUpCapture)},track:function(){var a,b,c,d;a=Date.now(),b=a-this.timestamp,this.timestamp=a,c=this.offset-this.frame,this.frame=this.offset,d=1e3*c/(1+b),this.velocity=.2*d+.2*this.velocity},handlemousedown:function(b){if(void 0==this.thumbCapture||0==this.thumbCapture){this.thumbCapture=!0;var c=this.btnThumb;null!=c&&(c.addClass(this.toThemeProperty("jqx-fill-state-pressed")),this.vertical?c.addClass(this.toThemeProperty("jqx-scrollbar-thumb-state-pressed")):c.addClass(this.toThemeProperty("jqx-scrollbar-thumb-state-pressed-horizontal")))}var d=this;this.thumbCapture&&a.jqx.scrollAnimation&&function(a){d.reference=parseInt(d.btnThumb[0].style.top),d.offset=parseInt(d.btnThumb[0].style.top),d.vertical||(d.reference=parseInt(d.btnThumb[0].style.left),d.offset=parseInt(d.btnThumb[0].style.left)),d.velocity=d.amplitude=0,d.frame=d.offset,d.timestamp=Date.now(),clearInterval(d.ticker),d.ticker=setInterval(function(){d.track()},100)}(),this.dragStartX=b.clientX,this.dragStartY=b.clientY,this.dragStartValue=this.value},toggleHover:function(a,b){},refresh:function(){this._arrange()},_setElementPosition:function(a,b,c){isNaN(b)||parseInt(a[0].style.left)!=parseInt(b)&&(a[0].style.left=b+"px"),isNaN(c)||parseInt(a[0].style.top)!=parseInt(c)&&(a[0].style.top=c+"px")},_setElementTopPosition:function(a,b){isNaN(b)||(a[0].style.top=b+"px")},_setElementLeftPosition:function(a,b){isNaN(b)||(a[0].style.left=b+"px")},handlemouseleave:function(a){var b=this.btnUp,c=this.btnDown;if((this.buttonDownCapture||this.buttonUpCapture)&&(b.removeClass(this.toThemeProperty("jqx-scrollbar-button-state-pressed")),c.removeClass(this.toThemeProperty("jqx-scrollbar-button-state-pressed")),this._removeArrowClasses("pressed")),1==this.thumbCapture){var d=this.btnThumb,e=this.vertical?this.toThemeProperty("jqx-scrollbar-thumb-state-pressed"):this.toThemeProperty("jqx-scrollbar-thumb-state-pressed-horizontal");d.removeClass(e),d.removeClass(this.toThemeProperty("jqx-fill-state-pressed"))}},handlemouseenter:function(a){var b=this.btnUp,c=this.btnDown;if(this.buttonUpCapture&&(b.addClass(this.toThemeProperty("jqx-scrollbar-button-state-pressed")),b.addClass(this.toThemeProperty("jqx-fill-state-pressed")),this._addArrowClasses("pressed","up")),this.buttonDownCapture&&(c.addClass(this.toThemeProperty("jqx-scrollbar-button-state-pressed")),c.addClass(this.toThemeProperty("jqx-fill-state-pressed")),this._addArrowClasses("pressed","down")),1==this.thumbCapture){var d=this.btnThumb;this.vertical?d.addClass(this.toThemeProperty("jqx-scrollbar-thumb-state-pressed")):d.addClass(this.toThemeProperty("jqx-scrollbar-thumb-state-pressed-horizontal")),d.addClass(this.toThemeProperty("jqx-fill-state-pressed"))}},handlemousemove:function(a){var b=this.btnUp,c=this.btnDown;if(null!=c&&null!=b){if(null!=b&&null!=c&&void 0!=this.buttonDownCapture&&void 0!=this.buttonUpCapture&&(this.buttonDownCapture&&0==a.which?(c.removeClass(this.toThemeProperty("jqx-scrollbar-button-state-pressed")),c.removeClass(this.toThemeProperty("jqx-fill-state-pressed")),this._removeArrowClasses("pressed","down"),this.buttonDownCapture=!1):this.buttonUpCapture&&0==a.which&&(b.removeClass(this.toThemeProperty("jqx-scrollbar-button-state-pressed")),b.removeClass(this.toThemeProperty("jqx-fill-state-pressed")),this._removeArrowClasses("pressed","up"),this.buttonUpCapture=!1)),1!=this.thumbCapture)return!1;var d=this.btnThumb;if(0==a.which&&!this.isTouchDevice&&!this._touchSupport){this.thumbCapture=!1,this._arrange();var e=this.vertical?this.toThemeProperty("jqx-scrollbar-thumb-state-pressed"):this.toThemeProperty("jqx-scrollbar-thumb-state-pressed-horizontal");return d.removeClass(e),d.removeClass(this.toThemeProperty("jqx-fill-state-pressed")),!0}void 0!=a.preventDefault&&a.preventDefault(),null!=a.originalEvent&&(a.originalEvent.mouseHandled=!0),void 0!=a.stopPropagation&&a.stopPropagation();var f=0;try{f=this.vertical?a.clientY-this.dragStartY:a.clientX-this.dragStartX;var g=this._btnAndThumbSize;this._btnAndThumbSize||(g=this.vertical?b.height()+c.height()+d.height():b.width()+c.width()+d.width());var h=(this.max-this.min)/(this.scrollBarSize-g);if("auto"!=this.thumbStep){if(f*=h,Math.abs(this.dragStartValue+f-this.value)>=parseInt(this.thumbStep)){var i=Math.round(parseInt(f)/this.thumbStep)*this.thumbStep;return this.rtl&&!this.vertical?this.setPosition(this.dragStartValue-i):this.setPosition(this.dragStartValue+i),!1}return!1}f*=h;var i=f;this.rtl&&!this.vertical&&(i=-f),this.setPosition(this.dragStartValue+i),this.offset=parseInt(d[0].style.left),this.vertical&&(this.offset=parseInt(d[0].style.top))}catch(a){alert(a)}return!1}},handlemouseup:function(b,c){function d(){var a,b;if(h.amplitude)if(a=Date.now()-h.timestamp,(b=-h.amplitude*Math.exp(-a/325))>.5||b<-.5){var c=(h.max-h.min)/(h.scrollBarSize-h._btnAndThumbSize),e=c*(h.target+b),f=e;h.rtl&&!h.vertical&&(f=-e),h.setPosition(h.dragStartValue+f),requestAnimationFrame(d)}else{var c=(h.max-h.min)/(h.scrollBarSize-h._btnAndThumbSize),e=c*(h.target+b),f=e;h.rtl&&!h.vertical&&(f=-e),h.setPosition(h.dragStartValue+f)}}var e=!1;if(this.thumbCapture){this.thumbCapture=!1;var f=this.btnThumb,g=this.vertical?this.toThemeProperty("jqx-scrollbar-thumb-state-pressed"):this.toThemeProperty("jqx-scrollbar-thumb-state-pressed-horizontal");if(f.removeClass(g),f.removeClass(this.toThemeProperty("jqx-fill-state-pressed")),e=!0,this._mouseup=new Date,a.jqx.scrollAnimation){var h=this;clearInterval(this.ticker),(this.velocity>25||this.velocity<-25)&&(this.amplitude=.8*this.velocity,this.target=Math.round(this.offset+this.amplitude),this.vertical,this.target-=this.reference,this.timestamp=Date.now(),requestAnimationFrame(d))}}if(this.areaDownCapture=this.areaUpCapture=!1,this.buttonUpCapture||this.buttonDownCapture){var i=this.btnUp,j=this.btnDown;this.buttonUpCapture=!1,this.buttonDownCapture=!1,i.removeClass(this.toThemeProperty("jqx-scrollbar-button-state-pressed")),j.removeClass(this.toThemeProperty("jqx-scrollbar-button-state-pressed")),i.removeClass(this.toThemeProperty("jqx-fill-state-pressed")),j.removeClass(this.toThemeProperty("jqx-fill-state-pressed")),this._removeArrowClasses("pressed"),e=!0,this._mouseup=new Date}e&&(void 0!=c.preventDefault&&c.preventDefault(),null!=c.originalEvent&&(c.originalEvent.mouseHandled=!0),void 0!=c.stopPropagation&&c.stopPropagation())},setPosition:function(b,c){this.element;if(void 0!=b&&NaN!=b||(b=this.min),b>=this.max&&(b=this.max),b<this.min&&(b=this.min),this.value!==b||1==c){if(b==this.max){var d=new a.Event("complete");this.host.trigger(d)}var e=this.value;if(this._triggervaluechanged){var f=new a.Event("valueChanged");f.previousValue=this.value,f.currentValue=b}this.value=b,this._positionelements(),this._triggervaluechanged&&this.host.trigger(f),this.valueChanged&&this.valueChanged({currentValue:this.value,previousvalue:e})}return b},val:function(a){return function(b){for(var c in b)if(b.hasOwnProperty(c))return!1;return"number"!=typeof a&&("date"!=typeof a&&("boolean"!=typeof a&&"string"!=typeof a))}(a)||0==arguments.length?this.value:(this.setPosition(a),a)},_getThumbSize:function(a){var b=this.max-this.min,c=0;return b>1?c=a/(b+a)*a:1==b?c=a-1:0==b&&(c=a),this.thumbSize>0&&(c=this.thumbSize),c<this.thumbMinSize&&(c=this.thumbMinSize),Math.min(c,a)},_positionelements:function(){var a=(this.element,this.areaUp),b=this.areaDown,c=(this.btnUp,this.btnDown,this.btnThumb),d=(this.scrollWrap,this._height?this._height:this.host.height()),e=this._width?this._width:this.host.width(),f=this.vertical?e:d;this.showButtons||(f=0);var g=this.vertical?d:e;this.scrollBarSize=g;var h=this._getThumbSize(g-2*f);h=Math.floor(h),h<this.thumbMinSize&&(h=this.thumbMinSize),(NaN==d||d<10)&&(d=10),(NaN==e||e<10)&&(e=10),f+=2,this.btnSize=f;var i=this._btnAndThumbSize;if(!this._btnAndThumbSize){var i=this.vertical?2*this.btnSize+c.outerHeight():2*this.btnSize+c.outerWidth();i=Math.round(i)}var j=(g-i)/(this.max-this.min)*(this.value-this.min);if(this.rtl&&!this.vertical&&(j=(g-i)/(this.max-this.min)*(this.max-this.value-this.min)),j=Math.round(j),j<0&&(j=0),this.vertical){var k=g-j-i;k<0&&(k=0),b[0].style.height=k+"px",a[0].style.height=j+"px",this._setElementTopPosition(a,f),this._setElementTopPosition(c,f+j),this._setElementTopPosition(b,f+j+h)}else a[0].style.width=j+"px",b[0].style.width=g-j-i>=0?g-j-i+"px":"0px",this._setElementLeftPosition(a,f),this._setElementLeftPosition(c,f+j),this._setElementLeftPosition(b,2+f+j+h)},_arrange:function(){var a=this;if(a._initialLayout)return void(a._initialLayout=!1);if(a.min>a.max){var b=a.min;a.min=a.max,a.max=b}if(a.min<0){var c=a.max-a.min;a.min=0,a.max=c}var d=(a.element,a.areaUp),e=a.areaDown,f=a.btnUp,g=a.btnDown,h=a.btnThumb,i=a.scrollWrap,j=parseInt(a.element.style.height),k=parseInt(a.element.style.width);if(a.isPercentage)var j=a.host.height(),k=a.host.width();isNaN(j)&&(j=0),isNaN(k)&&(k=0),a._width=k,a._height=j;var l=a.vertical?k:j;a.showButtons||(l=0),f[0].style.width=l+"px",f[0].style.height=l+"px",g[0].style.width=l+"px",g[0].style.height=l+"px",a.vertical?i[0].style.width=k+2+"px":i[0].style.height=j+2+"px",a._setElementPosition(f,0,0);var m=l+2;a.vertical?a._setElementPosition(g,0,j-m):a._setElementPosition(g,k-m,0);var n=a.vertical?j:k;a.scrollBarSize=n;var o=a._getThumbSize(n-2*m);(o=Math.floor(o-2))<a.thumbMinSize&&(o=a.thumbMinSize);var p=!1;a.isTouchDevice&&0!=a.touchModeStyle&&(p=!0),a.vertical?(h[0].style.width=k+"px",h[0].style.height=o+"px",p&&0!==a.thumbTouchSize&&(h.css({width:a.thumbTouchSize+"px"}),h.css("margin-left",(a.host.width()-a.thumbTouchSize)/2))):(h[0].style.width=o+"px",h[0].style.height=j+"px",p&&0!==a.thumbTouchSize&&(h.css({height:a.thumbTouchSize+"px"}),h.css("margin-top",(a.host.height()-a.thumbTouchSize)/2))),(NaN==j||j<10)&&(j=10),(NaN==k||k<10)&&(k=10),a.btnSize=l;var q=a.vertical?2*m+(2+parseInt(h[0].style.height)):2*m+(2+parseInt(h[0].style.width));q=Math.round(q),a._btnAndThumbSize=q;var r=(n-q)/(a.max-a.min)*(a.value-a.min);if(a.rtl&&!a.vertical&&(r=(n-q)/(a.max-a.min)*(a.max-a.value-a.min)),r=Math.round(r),(isNaN(r)||r<0||r===-1/0||r===1/0)&&(r=0),a.vertical){var s=n-r-q;s<0&&(s=0),e[0].style.height=s+"px",e[0].style.width=k+"px",d[0].style.height=r+"px",d[0].style.width=k+"px";var t=parseInt(a.element.style.height);a.isPercentage&&(t=a.host.height()),h[0].style.visibility="inherit",(t-3*parseInt(l)<0||t<q)&&(h[0].style.visibility="hidden"),a._setElementPosition(d,0,m),a._setElementPosition(h,0,m+r),a._setElementPosition(e,0,m+r+o)}else{r>0&&(d[0].style.width=r+"px"),j>0&&(d[0].style.height=j+"px");var u=n-r-q;u<0&&(u=0),e[0].style.width=u+"px",e[0].style.height=j+"px";var v=parseInt(a.element.style.width);a.isPercentage&&(v=a.host.width()),h[0].style.visibility="inherit",(v-3*parseInt(l)<0||v<q)&&(h[0].style.visibility="hidden"),a._setElementPosition(d,m,0),a._setElementPosition(h,m+r,0),a._setElementPosition(e,m+r+o,0)}}})}(jqxBaseFramework);

