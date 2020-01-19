$(".page-link").click(function () {
    console.log('click');
    $(".page-link").parent().addClass("active");
});