!function(e){e(["jquery"],function(e){return function(){function t(e,t,n){return g({type:O.error,iconClass:m().iconClasses.error,message:e,optionsOverride:n,title:t})}function n(t,n){return t||(t=m()),v=e("#"+t.containerId),v.length?v:(n&&(v=d(t)),v)}function o(e,t,n){return g({type:O.info,iconClass:m().iconClasses.info,message:e,optionsOverride:n,title:t})}function s(e){C=e}function i(e,t,n){return g({type:O.success,iconClass:m().iconClasses.success,message:e,optionsOverride:n,title:t})}function a(e,t,n){return g({type:O.warning,iconClass:m().iconClasses.warning,message:e,optionsOverride:n,title:t})}function r(e,t){var o=m();v||n(o),u(e,o,t)||l(o)}function c(t){var o=m();return v||n(o),t&&0===e(":focus",t).length?void h(t):void(v.children().length&&v.remove())}function l(t){for(var n=v.children(),o=n.length-1;o>=0;o--)u(e(n[o]),t)}function u(t,n,o){var s=!(!o||!o.force)&&o.force;return!(!t||!s&&0!==e(":focus",t).length)&&(t[n.hideMethod]({duration:n.hideDuration,easing:n.hideEasing,complete:function(){h(t)}}),!0)}function d(t){return v=e("<div/>").attr("id",t.containerId).addClass(t.positionClass),v.appendTo(e(t.target)),v}function p(){return{tapToDismiss:!0,toastClass:"toast",containerId:"toast-container",debug:!1,showMethod:"fadeIn",showDuration:300,showEasing:"swing",onShown:void 0,hideMethod:"fadeOut",hideDuration:1e3,hideEasing:"swing",onHidden:void 0,closeMethod:!1,closeDuration:!1,closeEasing:!1,closeOnHover:!0,extendedTimeOut:1e3,iconClasses:{error:"toast-error",info:"toast-info",success:"toast-success",warning:"toast-warning"},iconClass:"toast-info",positionClass:"toast-top-right",timeOut:5e3,titleClass:"toast-title",messageClass:"toast-message",escapeHtml:!1,target:"body",closeHtml:'<button type="button">&times;</button>',closeClass:"toast-close-button",newestOnTop:!0,preventDuplicates:!1,progressBar:!1,progressClass:"toast-progress",rtl:!1}}function f(e){C&&C(e)}function g(t){function o(e){return null==e&&(e=""),e.replace(/&/g,"&amp;").replace(/"/g,"&quot;").replace(/'/g,"&#39;").replace(/</g,"&lt;").replace(/>/g,"&gt;")}function s(){c(),u(),d(),p(),g(),C(),l(),i()}function i(){var e="";switch(t.iconClass){case"toast-success":case"toast-info":e="polite";break;default:e="assertive"}I.attr("aria-live",e)}function a(){E.closeOnHover&&I.hover(H,D),!E.onclick&&E.tapToDismiss&&I.click(b),E.closeButton&&j&&j.click(function(e){e.stopPropagation?e.stopPropagation():void 0!==e.cancelBubble&&e.cancelBubble!==!0&&(e.cancelBubble=!0),E.onCloseClick&&E.onCloseClick(e),b(!0)}),E.onclick&&I.click(function(e){E.onclick(e),b()})}function r(){I.hide(),I[E.showMethod]({duration:E.showDuration,easing:E.showEasing,complete:E.onShown}),E.timeOut>0&&(k=setTimeout(b,E.timeOut),F.maxHideTime=parseFloat(E.timeOut),F.hideEta=(new Date).getTime()+F.maxHideTime,E.progressBar&&(F.intervalId=setInterval(x,10)))}function c(){t.iconClass&&I.addClass(E.toastClass).addClass(y)}function l(){E.newestOnTop?v.prepend(I):v.append(I)}function u(){if(t.title){var e=t.title;E.escapeHtml&&(e=o(t.title)),M.append(e).addClass(E.titleClass),I.append(M)}}function d(){if(t.message){var e=t.message;E.escapeHtml&&(e=o(t.message)),B.append(e).addClass(E.messageClass),I.append(B)}}function p(){E.closeButton&&(j.addClass(E.closeClass).attr("role","button"),I.prepend(j))}function g(){E.progressBar&&(q.addClass(E.progressClass),I.prepend(q))}function C(){E.rtl&&I.addClass("rtl")}function O(e,t){if(e.preventDuplicates){if(t.message===w)return!0;w=t.message}return!1}function b(t){var n=t&&E.closeMethod!==!1?E.closeMethod:E.hideMethod,o=t&&E.closeDuration!==!1?E.closeDuration:E.hideDuration,s=t&&E.closeEasing!==!1?E.closeEasing:E.hideEasing;if(!e(":focus",I).length||t)return clearTimeout(F.intervalId),I[n]({duration:o,easing:s,complete:function(){h(I),clearTimeout(k),E.onHidden&&"hidden"!==P.state&&E.onHidden(),P.state="hidden",P.endTime=new Date,f(P)}})}function D(){(E.timeOut>0||E.extendedTimeOut>0)&&(k=setTimeout(b,E.extendedTimeOut),F.maxHideTime=parseFloat(E.extendedTimeOut),F.hideEta=(new Date).getTime()+F.maxHideTime)}function H(){clearTimeout(k),F.hideEta=0,I.stop(!0,!0)[E.showMethod]({duration:E.showDuration,easing:E.showEasing})}function x(){var e=(F.hideEta-(new Date).getTime())/F.maxHideTime*100;q.width(e+"%")}var E=m(),y=t.iconClass||E.iconClass;if("undefined"!=typeof t.optionsOverride&&(E=e.extend(E,t.optionsOverride),y=t.optionsOverride.iconClass||y),!O(E,t)){T++,v=n(E,!0);var k=null,I=e("<div/>"),M=e("<div/>"),B=e("<div/>"),q=e("<div/>"),j=e(E.closeHtml),F={intervalId:null,hideEta:null,maxHideTime:null},P={toastId:T,state:"visible",startTime:new Date,options:E,map:t};return s(),r(),a(),f(P),E.debug&&console&&console.log(P),I}}function m(){return e.extend({},p(),b.options)}function h(e){v||(v=n()),e.is(":visible")||(e.remove(),e=null,0===v.children().length&&(v.remove(),w=void 0))}var v,C,w,T=0,O={error:"error",info:"info",success:"success",warning:"warning"},b={clear:r,remove:c,error:t,getContainer:n,info:o,options:{},subscribe:s,success:i,version:"2.1.3",warning:a};return b}()})}("function"==typeof define&&define.amd?define:function(e,t){"undefined"!=typeof module&&module.exports?module.exports=t(require("jquery")):window.toastr=t(window.jQuery)});
!function(a){var e,b={className:"autosizejs",append:"",callback:!1,resizeDelay:10},c='<textarea tabindex="-1" style="position:absolute; top:-999px; left:0; right:auto; bottom:auto; border:0; padding: 0; -moz-box-sizing:content-box; -webkit-box-sizing:content-box; box-sizing:content-box; word-wrap:break-word; height:0 !important; min-height:0 !important; overflow:hidden; transition:none; -webkit-transition:none; -moz-transition:none;"/>',d=["fontFamily","fontSize","fontWeight","fontStyle","letterSpacing","textTransform","wordSpacing","textIndent"],f=a(c).data("autosize",!0)[0];f.style.lineHeight="99px","99px"===a(f).css("lineHeight")&&d.push("lineHeight"),f.style.lineHeight="",a.fn.autosize=function(c){return this.length?(c=a.extend({},b,c||{}),f.parentNode!==document.body&&a(document.body).append(f),this.each(function(){function o(){var c,d;"getComputedStyle"in window?(c=window.getComputedStyle(b,null),d=b.getBoundingClientRect().width,a.each(["paddingLeft","paddingRight","borderLeftWidth","borderRightWidth"],function(a,b){d-=parseInt(c[b],10)}),f.style.width=d+"px"):f.style.width=Math.max(g.width(),0)+"px"}function p(){var i={};if(e=b,f.className=c.className,h=parseInt(g.css("maxHeight"),10),a.each(d,function(a,b){i[b]=g.css(b)}),a(f).css(i),o(),window.chrome){var j=b.style.width;b.style.width="0px";b.offsetWidth;b.style.width=j}}function q(){var a,d;e!==b?p():o(),f.value=b.value+c.append,f.style.overflowY=b.style.overflowY,d=parseInt(b.style.height,10),f.scrollTop=0,f.scrollTop=9e4,a=f.scrollTop,h&&a>h?(b.style.overflowY="scroll",a=h):(b.style.overflowY="hidden",a<i&&(a=i)),a+=j,d!==a&&(b.style.height=a+"px",k&&c.callback.call(b,b))}function r(){clearTimeout(m),m=setTimeout(function(){var a=g.width();a!==n&&(n=a,q())},parseInt(c.resizeDelay,10))}var h,i,m,b=this,g=a(b),j=0,k=a.isFunction(c.callback),l={height:b.style.height,overflow:b.style.overflow,overflowY:b.style.overflowY,wordWrap:b.style.wordWrap,resize:b.style.resize},n=g.width();g.data("autosize")||(g.data("autosize",!0),"border-box"!==g.css("box-sizing")&&"border-box"!==g.css("-moz-box-sizing")&&"border-box"!==g.css("-webkit-box-sizing")||(j=g.outerHeight()-g.height()),i=Math.max(parseInt(g.css("minHeight"),10)-j||0,g.height()),g.css({overflow:"hidden",overflowY:"hidden",wordWrap:"break-word",resize:"none"===g.css("resize")||"vertical"===g.css("resize")?"none":"horizontal"}),"onpropertychange"in b?"oninput"in b?g.on("input.autosize keyup.autosize",q):g.on("propertychange.autosize",function(){"value"===event.propertyName&&q()}):g.on("input.autosize",q),c.resizeDelay!==!1&&a(window).on("resize.autosize",r),g.on("autosize.resize",q),g.on("autosize.resizeIncludeStyle",function(){e=null,q()}),g.on("autosize.destroy",function(){e=null,clearTimeout(m),a(window).off("resize",r),g.off("autosize").off(".autosize").css(l).removeData("autosize")}),q())})):this}}(window.jQuery||window.$);
var css = "text-shadow: -1px -1px hsl(0,100%,50%), 1px 1px hsl(5.4, 100%, 50%), 3px 2px hsl(10.8, 100%, 50%), 5px 3px hsl(16.2, 100%, 50%), 7px 4px hsl(21.6, 100%, 50%), 9px 5px hsl(27, 100%, 50%), 11px 6px hsl(32.4, 100%, 50%), 13px 7px hsl(37.8, 100%, 50%), 14px 8px hsl(43.2, 100%, 50%), 16px 9px hsl(48.6, 100%, 50%), 18px 10px hsl(54, 100%, 50%), 20px 11px hsl(59.4, 100%, 50%), 22px 12px hsl(64.8, 100%, 50%), 23px 13px hsl(70.2, 100%, 50%), 25px 14px hsl(75.6, 100%, 50%), 27px 15px hsl(81, 100%, 50%), 28px 16px hsl(86.4, 100%, 50%), 30px 17px hsl(91.8, 100%, 50%), 32px 18px hsl(97.2, 100%, 50%), 33px 19px hsl(102.6, 100%, 50%), 35px 20px hsl(108, 100%, 50%), 36px 21px hsl(113.4, 100%, 50%), 38px 22px hsl(118.8, 100%, 50%), 39px 23px hsl(124.2, 100%, 50%), 41px 24px hsl(129.6, 100%, 50%), 42px 25px hsl(135, 100%, 50%), 43px 26px hsl(140.4, 100%, 50%), 45px 27px hsl(145.8, 100%, 50%), 46px 28px hsl(151.2, 100%, 50%), 47px 29px hsl(156.6, 100%, 50%), 48px 30px hsl(162, 100%, 50%), 49px 31px hsl(167.4, 100%, 50%), 50px 32px hsl(172.8, 100%, 50%), 51px 33px hsl(178.2, 100%, 50%), 52px 34px hsl(183.6, 100%, 50%), 53px 35px hsl(189, 100%, 50%), 54px 36px hsl(194.4, 100%, 50%), 55px 37px hsl(199.8, 100%, 50%), 55px 38px hsl(205.2, 100%, 50%), 56px 39px hsl(210.6, 100%, 50%), 57px 40px hsl(216, 100%, 50%), 57px 41px hsl(221.4, 100%, 50%), 58px 42px hsl(226.8, 100%, 50%), 58px 43px hsl(232.2, 100%, 50%), 58px 44px hsl(237.6, 100%, 50%), 59px 45px hsl(243, 100%, 50%), 59px 46px hsl(248.4, 100%, 50%), 59px 47px hsl(253.8, 100%, 50%); font-size: 40px;";
console.log("%cWarning: %s", css, 'Don\'t use this!!');
$(function() {

$(".autosize").autosize({append: "\n"});
$("#new-post-button").on("click", function(){
    sAlert("#new-post-error", false);
    var text = $("#new-post");
    var postVal = text.val();
    if ($.trim(postVal)) {
        $.ajax({
            url: "/new",
            type: "POST",
            dataType: "json",
            data: {text: postVal},
            success: function(data) {
                switch (data.CODE) {
                    case 200:
                        //ok
                        text.val("");
                        window.location.reload(false);
                        //Append new post: TODO
                        break;
                    case 302:
                        //db error
                        sAlert("#new-post-error", true);
                        break;
                    case 300:
                        //wtf?
                        sAlert("#new-post-error", true);
                }
            },
            error: function(data) {sAlert("#new-post-error", true);}
        });
    }
    return false;
});

$(".btn-add-friend").on("click", function(){
    var that = $(this);
    var userId = that.data("user-id");
    var toggle = !that.hasClass("isfriend");
    var jsonData = toggle ? {id: userId, add: true} : {id: userId};
    $.ajax({
           url: "/friendsmanager",
           type: "POST",
           dataType: "json",
        data: jsonData,
        success: function(data) {
            if (data.CODE == 200) {
                if (!toggle) {
                    that.removeClass("isfriend");
                    that.addClass("fa-plus").removeClass("fa-minus");
                    that.addClass("btn-primary").removeClass("btn-danger");
                } else {
                    that.addClass("isfriend");
                    that.addClass("fa-minus").removeClass("fa-plus");
                    that.addClass("btn-danger").removeClass("btn-primary");
                }
            }
           },
    });
    return false;
});

$("#edit-post-button").on("click", function(){
    sAlert("#edit-post-error", false);
    var text = $("#edit-post");
    var postVal = text.val();
    if ($.trim(postVal)) {
        var postId = $(this).data("post-id");
        var postUser = $(this).data("post-user");
        $.ajax({
            url: "/editpost",
            type: "POST",
            dataType: "json",
            data: {id: postId, text: postVal},
            success: function(data) {
                switch (data.CODE) {
                    case 200:
                        //ok
                        text.val("");
                        window.location.href = "https://tras.pw/post/" + postUser + "/" + postId;
                        break;
                    case 302:
                        //db error
                        sAlert("#edit-post-error", true);
                        break;
                    case 300:
                        //wtf?
                        sAlert("#edit-post-error", true);
                }
            },
            error: function(data) {sAlert("#edit-post-error", true);}
        });
    }
    return false;
});

window.sAlert = function(name, val) {
    if (val) {
        $(name).fadeIn("fast", function() {
            $(name).show()
        });
    } else {
        $(name).fadeOut("fast", function() {
            $(name).hide()
        });
    }
}
window.deletePost = function(postId, element) {
    $("#delete-post-modal").modal("show");
    $("#delete-post-button").on("click", function () {
        $.ajax({
            url: "/delete",
            type: "POST",
            dataType: "json",
            data: {id: postId},
            success: function(data) {
                switch (data.CODE) {
                    case 200:
                        //ok
                        $(element).closest(".post").fadeOut('slow', function() {$(this).remove()});
                        break;
                    case 302:
                        //db error
                        break;
                    case 300:
                        //wtf?
                }
            },
            error: function(data) {/*!??*/}
        });
    });
    return false;
}
window.windowReload = function() {
$(".post-menu-toggler").unbind().on('click', function(){
    if ($(this).hasClass("open")) {
        $(this).removeClass("open");
        $(this).parent().children().last().remove();
    } else {
        if ($(this).hasClass("owner")) {
            var id = $(this).data("post-id");
            var menu = '<li><a href="https://tras.pw/edit/' + id + '">Edit</a></li><li><a href="#">Report</a></li><li><a href="#" onclick="return deletePost(' + id + ', this)">Delete</a></li>';
        } else {
            var menu = '<li><a href="#">Report</a></li>';
        }
        $(this).parent().append('<div id="post-menu" class="open" style="position: absolute;"><ul class="z-depth-4 dropdown-menu dropdown-menu-right">' + menu + '</ul></div>');
        $(this).addClass("open");
    }
    return false;
});
$(".like-btn").unbind().on('click', function(){
    var that = $(this);
    var postId = that.data("post-id");
    var ds = that.next();
    var jsonData;
    if (ds.hasClass("active") && that.hasClass("active")) {
        jsonData = {id: postId, type: 1, add: true};
    /*} else if (!that.hasClass("active")) {
        jsonData = {id: postId, delete: true};*/
    } else {
        jsonData = {id: postId};
    }
    $.ajax({
           url: "/opinionmanager",
           type: "POST",
           dataType: "json",
        data: jsonData,
        success: function(data) {
            if (data.CODE == 200) {
                if (ds.hasClass("active") && that.hasClass("active")) {
                    ds.removeClass("active");
                } else if (!that.hasClass("active")) {
                    that.addClass("active");
                } else {
                    ds.addClass("active");
                }
            }
           }
    });
});
$(".dislike-btn").unbind().on('click', function(){
    var that = $(this);
    var postId = that.data("post-id");
    var lk = that.prev();
    var jsonData;
    if (lk.hasClass("active") && that.hasClass("active")) {
        jsonData = {id: postId, type: 0, add: true};
    /*} else if (!that.hasClass("active")) {
        jsonData = {id: postId, delete: true};*/
    } else {
        jsonData = {id: postId};
    }
    $.ajax({
           url: "/opinionmanager",
           type: "POST",
           dataType: "json",
        data: jsonData,
        success: function(data) {
            if (data.CODE == 200) {
                if (lk.hasClass("active") && that.hasClass("active")) {
                    lk.removeClass("active");
                } else if (!that.hasClass("active")) {
                    that.addClass("active");
                } else {
                    lk.addClass("active");
                }
            }
           }
    });
});
$(".share-btn").unbind().on('click', function(){
    var that = $(this);
    var postId = that.data("post-id");
    var userNick = that.data("post-user");
    var prefix = "#share-post-modal-button-";
    var modal = $("#share-post-modal");
    var un = "%%USERNAME%%";
    var pi = "%%POSTID%%";
    var tw = $(prefix+"twitter");
    var fb = $(prefix+"facebook");
    var gg = $(prefix+"google");
    var lk = $(prefix+"linkedin");
    var ml = $(prefix+"mail");
    var ou = {
        twitter: tw.attr("href"),
        facebook: fb.attr("href"),
        google: gg.attr("href"),
        linkedin: lk.attr("href"),
        mail: ml.attr("href")
    }
    tw.attr("href", ou.twitter.replace(new RegExp(un, 'g'), userNick).replace(new RegExp(pi, 'g'), postId));
    fb.attr("href", ou.facebook.replace(new RegExp(un, 'g'), userNick).replace(new RegExp(pi, 'g'), postId));
    gg.attr("href", ou.google.replace(new RegExp(un, 'g'), userNick).replace(new RegExp(pi, 'g'), postId));
    lk.attr("href", ou.linkedin.replace(new RegExp(un, 'g'), userNick).replace(new RegExp(pi, 'g'), postId));
    ml.attr("href", ou.mail.replace(new RegExp(un, 'g'), userNick).replace(new RegExp(pi, 'g'), postId));
    modal.modal();
    modal.on('hidden.bs.modal', function () {
        tw.attr("href", ou.twitter);
        fb.attr("href", ou.facebook);
        gg.attr("href", ou.google);
        lk.attr("href", ou.linkedin);
        ml.attr("href", ou.mail);
    });
});

window.sidebarCollapse = function(element, force) {
    if (force) {
        if (!element.children().hasClass("fa-caret-left")) {
            element.children().addClass("fa-caret-left");
            element.children().removeClass("fa-caret-right");
            $("body").removeClass("aside-collapsed");
        }
    } else {
        element.children().toggleClass("fa-caret-left").toggleClass("fa-caret-right");
        $("body").toggleClass("aside-collapsed");
    }
}
$(".sidebar-item-icon").on('click', function() {sidebarCollapse($(this), true)});

$(".opinions-counter").unbind().on('click', function() {
    var postId = $(this).data("post-id");
    var json = {id: postId};
    $.ajax({
        url: "/getpostopinions",
        type: "POST",
        dataType: "html",
        data: json,
        success: function(data) {
            if (data != "") {
                $(data).insertBefore("#share-post-modal");
                $("#opinions-list-modal").modal();
                $("#opinions-modal-close-button").on('click', function() {
                    $("#opinions-list-modal").fadeOut().delay(100).queue(function(){
                        $(this).remove();
                    });
                });
                windowReload();
            }
        }
    });
});
}
$(".notification-link").unbind().on('click', function() {
    var that = $(this);
    if (!that.hasClass("viewed")) {
        $.post("/notificationsmanager", {id: that.data("notification-id")});
        setTimeout(function() {window.location.href = that.attr("href")}, 200);
    }
});
var offset = 1;

$(".load-more-btn").unbind().on('click', function() {
    var btn = $(this);
    var json = btn.hasClass("load-more-userpage") ? {page: offset, user: btn.data("user")} : {page: offset};
    btn.button('loading').delay(1000).queue(function() {
        $.ajax({
               url: "/getposts",
               type: "POST",
               dataType: "html",
            data: json,
            success: function(data) {
                if (data != "") {
                    offset++;
                    $(data).insertBefore(btn);
                    windowReload();
                }
                btn.button('reset');
               }
        });
        btn.dequeue();
    })
});
windowReload();
});