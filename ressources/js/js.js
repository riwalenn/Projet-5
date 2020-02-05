$(".page-link").click(function () {
    console.log('click');
    $(".page-link").parent().addClass("active");
});
$('div.password-popup').hide();

$('input.password').click(function () {
   $('div.password-popup').toggle();
});

var clearButton = document.getElementById('clear');
var searchForm = document.getElementById('search-form');
clearButton.addEventListener('click', function () {
    searchForm.reset();
});