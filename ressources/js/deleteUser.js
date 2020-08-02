function verifSameEmail(champ) {
    //importer l'adresse email du compte (copier via le DOM)
    //comparer avec l'adresse entrée dans le formulaire
}

function verifFormUser(f) {
    let emailOk = verifEmail(f.email);
    let sameEmailOk = verifSameEmail(f.email);

    if (emailOk && sameEmailOk) {
        return true;
    } else {
        alert("Veuillez entrer la bonne adresse email !");
        return false;
    }
}