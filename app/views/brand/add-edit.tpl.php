<div class="container my-4">
    <a href="<?= $router->generate('brand-list') ?>" class="btn btn-success float-right">Retour</a>
    <h2><?= $brand->getId() ? 'Modifier la' : 'Ajouter une' ?> marque</h2>
    
    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $currentError) : ?>
                <div><?= $currentError ?></div>
            <?php endforeach ?>
        </div>
    <?php endif ?>

    <form action="<?= $router->generate('brand-create-update', ['id'=>$brand->getId()]) ?>" method="POST" class="mt-5">
        <input type="hidden" name="tokenCSRF" value="<?= $tokenCSRF ?>">
            <input name="id" value="<?= $brand->getId() ?>" type="hidden">
        <div class="form-group">
            <label for="name">Nom</label>
            <input name="name" value="<?= $brand->getName() ?>" type="text" class="form-control" id="name" placeholder="Nom de la marque">
        </div>
        <button type="submit" class="btn btn-primary">Valider</button>
    </form>
</div>