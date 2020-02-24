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

function verifPseudo(champ) {
    if(champ.value.length < 3 || champ.value.length > 30)
    {
        surligne(champ, true);
        return false;
    } else {
        surligne(champ, false);
        return true;
    }
}

function verifEmail(champ) {
    var regex = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{3,4}$/;
    if(!regex.test(champ.value))
    {
        surligne(champ, true);
        return false;
    } else {
        surligne(champ, false);
        return true;
    }
}

function verifName(champ) {
    if (champ.value.length < 2 || champ.value.length > 40)
    {
        surligne(champ, true);
        console.log("Le nom est trop petit ou trop grand !");
        return false;
    } else {
        regex = /[a-zA-Z]\s/;
        if (!regex.test(champ.value))
        {
            surligne(champ, true);
            console.log("Le nom ne doit ni contenir de caractères spéciaux ni de chiffres !");
            return false;
        } else {
            surligne(champ, false);
            return true;
        }
    }
}

function verifPassword(champ) {
    var regex = /^\S*(?=\S{10,64})(?=\S+[a-z])(?=\S+[A-Z])(?=\S+[\W])\S+$/;
    if (champ.value.length < 10 || champ.value.length > 64)
    {
        surligne(champ, true);
        return false;
    } else {
        if (regex.test(champ.value)) {
            surligne(champ, false);
            return true;
        } else {
            surligne(champ, true);
            return false;
        }
    }
}

function verifCgu(champ) {
    if (champ.value === '1') {
        surligne(champ, false);
        return true;
     } else {
        surligne(champ, true);
        return false;
    }
}

function verifMessage(champ) {
    if (champ.value.length < 150 || champ.value.length > 700) {
        surligne(champ, true);
        console.log("Le message est trop petit ou trop grand !");
        return false;
    } else {
        surligne(champ, false);
        return true;
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


function verifFormContact(f) {
    var nameOk = verifName(f.name);
    var emailOk = verifEmail(f.email);

    if (nameOk && emailOk) {
        return true;
    } else {
        alert("Veuillez remplir correctement tous les champs");
        return false;
    }
}
