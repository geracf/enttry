var tlr = new TimelineMax({onComplete:function() {this.restart()}});

tlr.staggerFrom(".img1", .4,  {y:-100, opacity:0,ease:Back.easeOut,}, 0.3)
tlr.staggerTo(".img1", .4,  { delay:2, y:100, opacity:0, display:"none", autoAlpha: 0, ease:Back.easeOut,}, 0.3)
tlr.staggerFrom(".img2", .4,  {height:0, width:0, y:-100, opacity:0,ease:Back.easeOut,}, 0.3)
tlr.staggerTo(".img2", .4,  {delay:2, y:100, opacity:0, display:"none", autoAlpha: 0, ease:Back.easeOut,}, 0.3)
tlr.staggerFrom(".img3", .4,  {height:0, width:0, y:-100, opacity:0,ease:Back.easeOut,}, 0.3)
tlr.staggerTo(".img3", .4,  {delay:2, y:100, opacity:0, display:"none", autoAlpha: 0, ease:Back.easeOut,}, 0.3)
tlr.staggerFrom(".img4", .4,  {height:0, width:0, y:-100, opacity:0,ease:Back.easeOut,}, 0.3)
tlr.staggerTo(".img4", .4,  {delay:2, y:100, opacity:0, display:"none", autoAlpha: 0, ease:Back.easeOut,}, 0.3)
tlr.staggerFrom(".img5", .4,  {height:0, width:0, y:-100, opacity:0,ease:Back.easeOut,}, 0.3)
tlr.staggerTo(".img5", .4,  {delay:2, y:100, opacity:0, display:"none", autoAlpha: 0, ease:Back.easeOut,}, 0.3)
tlr.staggerFrom(".img6", .4,  {height:0, width:0, y:-100, opacity:0,ease:Back.easeOut,}, 0.3)
tlr.staggerTo(".img6", .4,  {delay:2, y:100, opacity:0, display:"none", autoAlpha: 0, ease:Back.easeOut,}, 0.3)

var tl = new TimelineMax();
tl.from(".navbar", .8,{y:-300, opacity:0,ease:Back.easeOut})
tl.from(".greeting-title", .8,{x:-100,opacity:0,ease:Expo.easeOut})
tl.from(".greeting-title2", .9,{x:-200, opacity:0,ease:Expo.easeOut})
tl.from(".begin", .8,{y:300, opacity:0,})

var tls = new TimelineMax();
tls.from(".circle", 1.3,{x:-1000,opacity:0,ease:Expo.easeOut})
tls.from(".description-title", .8,{x:-100,opacity:0,ease:Expo.easeOut})
tls.from(".description-text", .9,{x:-200, opacity:0,ease:Expo.easeOut})
tls.from(".mac", .8,{y:300, opacity:0,ease:Back.easeOut})

var controller = new ScrollMagic.Controller();

var scene = new ScrollMagic.Scene({
  triggerElement: ".description"
})
.setTween(tls)
.addTo(controller)

var tlc = new TimelineMax();
tls.from(".Cdescription-title", .8,{x:-100,opacity:0,ease:Expo.easeOut})
tls.from(".Cdescription-text", .9,{x:-200, opacity:0,ease:Expo.easeOut})
tls.from(".Cmac", .8,{y:300, opacity:0,ease:Back.easeOut})

var controller = new ScrollMagic.Controller();

var scene = new ScrollMagic.Scene({
  triggerElement: ".P2"
})
.setTween(tlc)
.addTo(controller)

var tll = new TimelineMax();
tll.from(".company-title", .8,{x:-100,opacity:0,ease:Expo.easeOut})


var controller = new ScrollMagic.Controller();

var scene = new ScrollMagic.Scene({
  triggerElement: ".company"
})
.setTween(tll)
.addTo(controller)

$( ".log" ).click(function() {
  TweenMax.to(".navbar", 1.5,{y:-100, opacity:0,autoAlpha: 0,ease:Back.easeOut})
  TweenMax.to(".logAccount", 1.5,{ opacity:1, display:"block", ease:Back.easeOut})
  TweenMax.to(".main",.1, {opacity:.3,})
});

$( ".register" ).click(function() {
  TweenMax.to(".navbar", 1.5,{y:-100, opacity:0,autoAlpha: 0,ease:Back.easeOut})
  TweenMax.to(".createAccount", 1.5,{ opacity:1, display:"block", ease:Back.easeOut})
  TweenMax.to(".main",.1, {opacity:.3,})
});

$( ".fa-times" ).click(function() {
  TweenMax.to(".navbar", 1,{y:0, opacity:1, autoAlpha: 1,ease:Back.easeOut})
  TweenMax.to(".createAccount", 1.5,{ opacity:0, display:"none", ease:Back.easeOut})
  TweenMax.to(".main",.1, {opacity:1,})
});

$( ".falog" ).click(function() {
  TweenMax.to(".navbar", 1,{y:0, opacity:1, autoAlpha: 1,ease:Back.easeOut})
  TweenMax.to(".logAccount", 1.5,{ opacity:0, display:"none", ease:Back.easeOut})
  TweenMax.to(".main",.1, {opacity:1,})
});

$( ".cont" ).click(function() {
  TweenMax.to(".aC1", 1,{opacity:0, autoAlpha: 0,ease:Back.easeOut})
  TweenMax.to(".aC2", 1,{opacity:1, autoAlpha: 1,display:"block",ease:Back.easeOut})
});

$( ".fa-arrow-left" ).click(function() {
  TweenMax.to(".aC2", 1,{opacity:0, autoAlpha: 0,ease:Back.easeOut})
  TweenMax.to(".aC1", 1,{opacity:1, autoAlpha: 1,display:"block",ease:Back.easeOut})
});
