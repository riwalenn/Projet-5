$(".page-link").click(function () {
    $(".page-link").parent().addClass("active");
});
$('div p.password-popup').hide();
$('div p.pseudo-popup').hide();

$('i.password').click(function () {
   $('div p.password-popup').toggle();
});

$('i.pseudo').click(function () {
    $('div p.pseudo-popup').toggle();
});
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});

function ConfirmMessage() {
    if (confirm("Etes-vous sûr de vouloir supprimer ce favori ?")) {
        return true;
    } else {
        return false;
    }
}

function ConfirmMessageAdmin() {
    if (confirm("Etes-vous sûr de vouloir purger cette liste ?")) {
        return true;
    } else {
        return false;
    }
}

function ConfirmDeconnexion() {
    if (confirm("Etes-vous sûr de vouloir vous déconnecter ?")) {
        return true;
    } else {
        return false;
    }
}

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

function verifName(champ) {
    if (champ.value.length < 2 || champ.value.length > 40)
    {
        surligne(champ, true);
        alert("Le nom est trop petit ou trop grand !");
        return false;
    } else {
        regex = /[a-zA-Z]\s/;
        if (!regex.test(champ.value))
        {
            surligne(champ, true);
            alert("Le nom ne doit ni contenir de caractères spéciaux ni de chiffres !");
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

function verifPasswordBis(value) {
    var form = document.getElementById('formModifPassword');
    var regex = /^\S*(?=\S{10,64})(?=\S+[a-z])(?=\S+[A-Z])(?=\S+[\W])\S+$/;
    if (form.value.length < 10 || form.value.length > 64)
    {
        surligne(form, true);
        return false;
    } else {
        if (regex.test(form.value)) {
            surligne(form, false);
            return true;
        } else {
            surligne(form, true);
            return false;
        }
    }
}

function comparePasswords(f) {
    var password = this.verifPassword(f.password);
    var passwordBis = this.verifPasswordBis(f.passwordBis);
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
        alert("Le message est trop petit ou trop grand !");
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

function verifFormMail(f) {
    var emailOk = verifEmail(f.email);
    if (emailOk) {
        return true;
    } else {
        alert("Veuillez remplir le champ par votre email");
        return false;
    }
}

function verifFormPassword(f) {
    var passwordOk = verifPassword(f.password);
    var passwordOkBis = verifPasswordBis(f.passwordBis);
    if (passwordOk && passwordOkBis) {
        return !!comparePasswords(f);
    } else {
        alert("Veuillez remplir les champs par votre mot de passe");
        return false;
    }
}

