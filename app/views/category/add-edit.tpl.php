<div class="container my-4">
    <a href="<?= $router->generate('category-list') ?>" class="btn btn-success float-right">Retour</a>
    <h2><?= $category->getId() ? 'Modifier la' : 'Ajouter une' ?> catégorie</h2>
    
    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $currentError) : ?>
                <div><?= $currentError ?></div>
            <?php endforeach ?>
        </div>
    <?php endif ?>

    <?php if (!empty($_GET['success'])) : ?>
        <div class="alert alert-success">
            <div>La catégorie a été modifier</div>
        </div>
    <?php endif ?>

    <form action="<?= $router->generate('category-create-update', ['id'=>$category->getId()]) ?>" method="POST" class="mt-5">
        <input type="hidden" name="tokenCSRF" value="<?= $tokenCSRF ?>">
            <input name="id" value="<?= $category->getId() ?>" type="hidden">
        <div class="form-group">
            <label for="name">Nom</label>
            <input name="name" value="<?= $category->getName() ?>" type="text" class="form-control" id="name" placeholder="Nom de la catégorie">
        </div>
        <div class="form-group">
            <label for="subtitle">Sous-titre</label>
            <input name="subtitle" value="<?= $category->getSubtitle() ?>" type="text" class="form-control" id="subtitle" placeholder="Sous-titre" aria-describedby="subtitleHelpBlock">
            <small id="subtitleHelpBlock" class="form-text text-muted">
                Sera affiché sur la page d'accueil comme bouton devant l'image
            </small>
        </div>
        <div class="form-group">
            <label for="picture">Image</label>
            <input name="picture" value="<?= $category->getPicture() ?>" type="text" class="form-control" id="picture" placeholder="image jpg, gif, svg, png" aria-describedby="pictureHelpBlock">
            <small id="pictureHelpBlock" class="form-text text-muted">
                URL relative d'une image (jpg, gif, svg ou png) fournie sur <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
            </small>
        </div>
        <button type="submit" class="btn btn-primary">Valider</button>
    </form>
</div>