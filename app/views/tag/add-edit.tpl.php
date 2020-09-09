<div class="container my-4">
    <a href="<?= $router->generate('tag-list') ?>" class="btn btn-success float-right">Retour</a>
    <h2><?= $tag->getId() ? 'Modifier le' : 'Ajouter un' ?> tag</h2>
    
    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $currentError) : ?>
                <div><?= $currentError ?></div>
            <?php endforeach ?>
        </div>
    <?php endif ?>

    <form action="<?= $router->generate('tag-create-update', ['id'=>$tag->getId()]) ?>" method="POST" class="mt-5">
        <input type="hidden" name="tokenCSRF" value="<?= $tokenCSRF ?>">
            <input name="id" value="<?= $tag->getId() ?>" type="hidden">
        <div class="form-group">
            <label for="name">Nom</label>
            <input name="name" value="<?= $tag->getName() ?>" type="text" class="form-control" id="name" placeholder="Nom du tag">
        </div>
        <button type="submit" class="btn btn-primary">Valider</button>
    </form>
</div>