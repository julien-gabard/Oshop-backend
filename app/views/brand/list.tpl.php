<div class="container my-4">

    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $currentError) : ?>
                <div><?= $currentError ?></div>
            <?php endforeach ?>
        </div>
    <?php endif ?>

    <?php if (!empty($success)) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <div><?= $success ?></div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif ?>

    <a href="<?= $router->generate('brand-add') ?>" class="btn btn-success float-right">Ajouter</a>
    <h2>Liste des marques</h2>
    <table class="table table-hover mt-4">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nom</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>

        <?php foreach($brands as $brand): ?>
            <tr>
                <th scope="row"><?= $brand->getId() ?></th>
                <td><?= $brand->getName() ?></td>
                <td class="text-right">
                    <a title="Modifier la catégorie" href="<?= $router->generate('brand-edit', ['id' => $brand->getId()]) ?>" class="btn btn-sm btn-warning">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </a>
                    <!-- Example single danger button -->
                    <div class="btn-group">
                        <button type="button" title="Supprimer la catégorie" class="btn btn-sm btn-danger dropdown-toggle"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?= $router->generate('brand-delete', ['id' => $brand->getId()]) ?>?tokenCSRF=<?= $tokenCSRF ?>">Oui, je veux supprimer</a>
                            <a class="dropdown-item" href="#" data-toggle="dropdown">Oups !</a>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach ?>
            
        </tbody>
    </table>
</div>