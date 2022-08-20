menu_icon.onclick = function(){
    $(menu_icon).css("display","none")
    $(menu_close).css("display","block")
    $(".scrolling").each(function(){
        $(this).toggleClass("activemen");
    })
    $(".ul-list").toggleClass("active");
    $("body").toggleClass("body-scroll");
}
menu_close.onclick = function(){
    $(menu_icon).css("display","block")
    $(menu_close).css("display","none")
    $(".scrolling").each(function(){
        $(this).toggleClass("activemen");
    })
    $(".ul-list").toggleClass("active");
    $("body").toggleClass("body-scroll");
}
let navbarscroll = document.querySelector(".navbar-scrolling")
window.addEventListener("scroll",(e)=>{
    if(this.scrollY>= $(".navbar-scrolling")[0].offsetTop){
        $(".navbar-scrolling").addClass("fixed-top")
    }
    if(this.scrollY<= $(".navbar-scrolling")[0].offsetTop){
        $(".navbar-scrolling").removeClass("fixed-top")
    }
})