<div class="container my-4">
    <a href="<?= $router->generate('user-list') ?>" class="btn btn-success float-right">Retour</a>
    <h2><?= $user->getId() ? 'Modifier le compte ' : 'Créer un compte ' ?>utilisateur</h2>

    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $currentError) : ?>
                <div><?= $currentError ?></div>
            <?php endforeach ?>
        </div>
    <?php endif ?>

    <?php if (!empty($success)) : ?>
        <div class="alert alert-success">
            <div><?= $success ?></div>
        </div>
    <?php endif ?>

    <form action="" method="POST" class="mt-5">
        <input type="hidden" name="tokenCSRF" value="<?= $tokenCSRF ?>">
        <div class="form-group">
            <div class="form-row">
                <div class="col">
                    <label for="lastname">Nom</label>
                    <input name="lastname" value="<?= $user->getLastName() ?>" id="lastname" type="text" class="form-control" placeholder="Nom">
                </div>
                <div class="col">
                    <label for="firstname">Prénom</label>
                    <input name="firstname" value="<?= $user->getFirstName() ?>" id="firstname" type="text" class="form-control" placeholder="Prénom">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="email">Adresse email</label>
            <input name="email" value="<?= $user->getEmail() ?>" type="email" class="form-control" placeholder="name@exemple.com" id="email" aria-describedby="emailHelp">
        </div>
        <?php if($currentUser->isSuperAdmin()): ?>
        <div class="form-group">
            <label for="password"><?= $user->getId() ? 'Modifier le mot de passe' : 'Mot de passe' ?></label>
            <input name="password" value="<?= $user->getPassword() ?>" type="password" class="form-control" id="password">
            <small id="password" class="form-text text-muted">Ne partager jamais votre mot de passe avec quelqu'un d'autre.</small>
        </div>
        <?php endif ?>
        <div class="form-group">
            <label for="role">Rôle</label>
            <select name="role" class="custom-select" id="role" aria-describedby="roleHelpBlock">
                <option value="admin" <?php if ($user->isAdmin()) : ?> selected <?php endif ?>>Admin</option>
                <option value="catalog-manager" <?php if ($user->isCatalogManager()) : ?> selected <?php endif ?>>Catalog-manager</option>
                <?php if($currentUser->isSuperAdmin()): ?>
                <option value="super-admin" <?php if ($user->isSuperAdmin()) : ?> selected <?php endif ?>>Super-admin</option>
                <?php endif ?>
            </select>
            <small id="role" class="form-text text-muted">Définit le rôle du compte.</small>
        </div>
        <div class="form-group">
            <label for="status">Statut</label>
            <select name="status" class="custom-select" id="status" aria-describedby="statusHelpBlock">
                <option value="1" <?php if ($user->getStatus() == 1) : ?> selected <?php endif ?>>Actif</option>
                <option value="2" <?php if ($user->getStatus() == 2) : ?> selected <?php endif ?>>Dèsactivé / bloqué</option>
            </select>
            <small id="status" class="form-text text-muted">Définit le statut du compte.</small>
        </div>
        <button type="submit" class="btn btn-primary">Valider</button>
    </form>

</div>