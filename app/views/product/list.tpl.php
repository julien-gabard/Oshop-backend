<div class="container my-4">

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

    <a href="<?= $router->generate('product-add') ?>" class="btn btn-success float-right">Ajouter</a>
    <h2>Liste des produits</h2>
    <table class="table table-hover mt-4">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nom</th>
                <th scope="col">Description</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>

            <?php foreach($productList as $product): ?>
            <tr>
                <th scope="row"><?= $product->getId() ?></th>
                <td><?= $product->getName() ?></td>
                <td><?= $product->getDescription() ?></td>
                <td class="d-flex flex-column">
                    <a title="Modifier le produit" href="<?= $router->generate('product-edit', ['id' => $product->getId()]) ?>" class="btn btn-sm btn-warning">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </a>
                    <!-- Example single danger button -->
                    <div class="btn-group mt-1">
                        <button type="button" title="Supprimer le produit" class="btn btn-sm btn-danger dropdown-toggle"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?= $router->generate('product-delete', ['id' => $product->getId()]) ?>?tokenCSRF=<?= $tokenCSRF ?>">Oui, je veux supprimer</a>
                            <a class="dropdown-item" href="#" data-toggle="dropdown">Oups !</a>
                        </div>
                    </div>
                </td>
            </tr>
            <?php endforeach ?>

        </tbody>
    </table>
</div>