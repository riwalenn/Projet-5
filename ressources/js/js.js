$(".page-link").click(function () {
    console.log('click');
    $(".page-link").parent().addClass("active");
});

var clearButton = document.getElementById('clear');
var searchForm = document.getElementById('search-form');
clearButton.addEventListener('click', function () {
   searchForm.reset();
});