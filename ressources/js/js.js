$(".page-link").click(function () {
    console.log('click');
    $(".page-link").parent().addClass("active");
});
$('div.password-popup').hide();

$('input.password').click(function () {
   $('div.password-popup').toggle();
});

function surligne(champ, erreur) {
    if (erreur) {
        champ.style.borderColor = "red";
    } else {
        champ.style.borderColor = "green";
    }
}

function verifEmail(champ) {
    var regex = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
    if(!regex.test(champ.value))
    {
        surligne(champ, true);
        return false;
    } else {
        surligne(champ, false);
        return true;
    }
}

function verifPseudo(champ) {
    if(champ.value.length < 4 || champ.value.length > 25)
    {
        surligne(champ, true);
        return false;
    } else {
        surligne(champ, false);
        return true;
    }
}

function verifPassword(champ) {
    if (champ.value.length < 10 || champ.value().length > 64)
    {
        surligne(champ, true);
        return false;
    } else {
        surligne(champ, false);
        return true;
    }
}

function verifCgu(champ) {
    if (champ.value() === 1) {
        surligne(champ, false);
        return true;
     } else {
        surligne(champ, true);
        return false;
    }
}

function verifForm(f) {
    var pseudoOk = verifPseudo(f.pseudo);
    var emailOk = verifEmail(f.email);
    var passwordOk = verifPassword(f.password);
    var cguOk = verifCgu(f.cgu);

    if (pseudoOk && emailOk && passwordOk && cguOk) {
        return true;
    } else {
        alert("Veuillez remplir correctement tous les champs");
        return false;
    }
}

var searchForm = document.getElementById('search-form');
clearButton.addEventListener('click', function () {
    searchForm.reset();
});