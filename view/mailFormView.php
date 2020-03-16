<div class="container views">
    <div class="row">
        <form action="index.php?action=forgotPasswordSendMail" method="post" onsubmit="return verifFormMail(this)" >
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-at"></i></span>
                </div>
                <input id="email" class="form-control form-control-sm" placeholder="entrez votre email ici" aria-label="email" type="email" name="email" onblur="verifEmail(this)" required>
            </div>
            <button class="btn btn-primary my-2 my-sm-0" aria-label="connexion" type="submit" value="connexion">Envoyer mon email</button>
        </form>
    </div>
    <div class='row helpmessage'>
        <div class='header'>
            <h3 class='popover-header'>Changer mon mot de passe :</h3>
        </div>
        <div class='popover-body'>
            <p><i class="fas fa-info-circle pseudo"></i> Merci de renseigner votre adresse email, vous recevrez par la suite un email avec un lien qui vous permettra de changer votre mot de passe.</p>
        </div>
    </div>
</div>