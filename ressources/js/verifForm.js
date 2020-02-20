$(".page-link").click(function () {
    console.log('click');
    $(".page-link").parent().addClass("active");
});
$('div p.password-popup').hide();
$('div p.pseudo-popup').hide();

$('input.password').click(function () {
   $('div p.password-popup').toggle();
});

$('input.pseudo').click(function () {
    $('div p.pseudo-popup').toggle();
});

function surligne(champ, erreur) {
    if (erreur) {
        champ.style.color = "red";
    } else {
        champ.style.color = "green";
    }
}

function verifEmail(champ) {
    var regex = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
    if(!regex.test(champ.value))
    {
        surligne(champ, true);
        console.log("le champ email n'est pas bon !");
        return false;
    } else {
        surligne(champ, false);
        return true;
    }
}

function verifPseudo(champ) {
    if(champ.value.length < 1 || champ.value.length > 30)
    {
        surligne(champ, true);
        console.log("le champ pseudo n'est pas bon !");
        return false;
    } else {
        surligne(champ, false);
        return true;
    }
}

function verifPassword(champ) {
    var regex = /^\S*(?=\S{10,64})(?=\S+[a-z])(?=\S+[A-Z])(?=\S+[\d])(?=\S+[@\-()_&*!%:,;#~^])\S+$/;
    var forbiddenRegex = /^(?=\S[éç+àè`[\]{,}°|\\'?"\/])\S+$/;
    if (champ.value.length < 10 || champ.value.length > 64)
    {
        surligne(champ, true);
        console.log("le champs password n'est pas bon");
        return false;
    } else {
        if (!regex.test(champ.value)) {
           console.log("Vous devez entrer au moins un caractère spécial de la liste");
        } else {
            surligne(champ, false);
            return true;
        }
    }
}

function verifCgu(champ) {
    if (champ.value === 1) {
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
        console.log(verifCgu().value);
        alert("Veuillez remplir correctement tous les champs");
        return false;
    }
}