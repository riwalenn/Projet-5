<div class="container views">
    <div class="row">
        <form action="index.php?action=modifierPassword" id="formModifPassword" method="post" onsubmit="return verifFormPassword(this)" >
            <input type="hidden" name="token" value="<?= $token ?>">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                </div>
                <input id="password" class="form-control form-control-sm classeMdp" placeholder="entrez votre mot de passe ici" aria-label="password" type="password" name="password" maxlength="64" minlength="10" onkeyup="verifPassword(this)" required>
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fas fa-info-circle password" data-toggle="tooltip" data-placement="right" title="Cliquez ici pour avoir plus d'infos !"></i></span>
                </div>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                </div>
                <input id="passwordBis" class="form-control form-control-sm classeMdp" placeholder="confirmez votre mot de passe" aria-label="password" type="password" name="passwordBis" maxlength="64" minlength="10" onkeyup="verifPasswordBis('formModifPassword')" required>
            </div>
            <button class="btn btn-primary my-2 my-sm-0" aria-label="connexion" type="submit" value="connexion">Envoyer mon email</button>
        </form>
    </div>
    <div class='ui fluid hidden helpmessage'>
        <div class='header'>
            <h3 class='popover-header'>Règles conçernant le pseudonyme et le mot de passe :</h3>
        </div>
        <div class='popover-body'>
            <p>Cliquez sur les <i class="fas fa-info-circle pseudo"></i> du formulaire pour avoir plus d'informations.</p>
            <?= $messagePassword ?>
        </div>
    </div>
</div>