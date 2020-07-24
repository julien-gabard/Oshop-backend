<div class="container my-4">
    <a href="<?= $router->generate('user-add') ?>" class="btn btn-success float-right">Créer</a>
    <h2>Liste des comptes utilisateurs</h2>

    <?php if (!empty($success)) : ?>
        <div class="alert alert-success">
            <div><?= $success ?></div>
        </div>
    <?php endif ?>

    <table class="table table-hover mt-4">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nom</th>
                <th scope="col">Prénom</th>
                <th scope="col">Email</th>
                <th scope="col">Rôle</th>
                <th scope="col">Statut du profil</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($users as $user) : ?>
                    <tr class="<?= !$user->isActive() ? 'table-danger' : '' ?>">
                        <th scope="row"><?=$user->getID()?></th>
                        <td><?= $user->getFirstname() ?></td>
                        <td><?= $user->getLastname() ?></td>
                        <td><?= $user->getEmail() ?></td>
                        <td><?= $user->getRole() ?></td>
                        <td><?= $user->getStatus()==='1' ? 'Actif' : 'Dèsactivé / bloqué' ?></td>
                        <td class="text-right">
                            <a title="Modifier l'utilisateur" href="<?= $router->generate('user-edit', ['id'=>$user->getId()]) ?>" class="btn btn-sm btn-warning">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </a>
                            <!-- Example single danger button -->
                            <div class="btn-group">
                                <button type="button" title="Supprimer l'utilisateur'" class="btn btn-sm btn-danger dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="<?= $router->generate('user-delete', ['id'=>$user->getId()]) ?>?tokenCSRF=<?= $tokenCSRF ?>">Oui, je veux supprimer</a>
                                    <a class="dropdown-item" href="#" data-toggle="dropdown">Oups !</a>
                                </div>
                            </div>
                        </td>
                    </tr>
            <?php endforeach ?>
            
        </tbody>
    </table>
</div>