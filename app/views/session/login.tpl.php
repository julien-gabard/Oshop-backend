<div class="container my-4">
    <h2>Se connecter</h2>

    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $currentError) : ?>
                <div><?= $currentError ?></div>
            <?php endforeach ?>
        </div>
    <?php endif ?>
    
    <form action="" method="POST" class="mt-5">
        <input type="hidden" name="tokenCSRF" value="<?= $tokenCSRF ?>">
        <div class="form-group">
            <label for="email">Adresse email</label>
            <input name="email" value="<?= $user ? $user->getEmail() : '' ?>" type="email" class="form-control" placeholder="name@exemple.com" id="email" aria-describedby="emailHelp">
        </div>
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input name="password" type="password" class="form-control" id="password">
            <small id="emailHelp" class="form-text text-muted">Ne partager jamais votre mot de passe avec quelqu'un d'autre.</small>
        </div>
        <button type="submit" class="btn btn-primary float-left">Connexion</button>
    </form>
    <ul class="nav justify-content-end">
        <li class="nav-item">
            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Mot de passe oublié.</a>
        </li>
    </ul>

</div>