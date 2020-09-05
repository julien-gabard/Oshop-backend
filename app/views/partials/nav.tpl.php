<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?= $router->generate('main-home') ?>">oShop</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <?php $page = $_SERVER['REQUEST_URI'];?>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item <?= $controllerName === 'category' ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= $router->generate('category-list') ?>">Catégories</a>
                </li>
                <li class="nav-item <?= $controllerName === 'product' ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= $router->generate('product-list') ?>">Produits</a>
                </li>
                <li class="nav-item <?= $controllerName === 'type' ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= $router->generate('type-list') ?>">Types</a>
                </li>
                <li class="nav-item <?= $controllerName === 'brand' ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= $router->generate('brand-list') ?>">Marques</a>
                </li>
                <li class="nav-item <?= $controllerName === 'tag' ? 'active' : '' ?>">
                    <a class="nav-link" href="#">Tags</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" size="19" type="search" placeholder="Rechercher" aria-label="Rechercher">
                <button class="btn btn-outline-info my-2 my-sm-0 mr-3" type="submit">Rechercher</button>
            </form>
            <ul class="navbar-nav">
                <?php if(!$currentUser->exist()): ?>
                    <img src="/../assets/images/connexion.png" width="40" height="40" alt="compte.png">
                <?php endif ?>
                <?php if($currentUser->exist()): ?>
                    <img src="/../assets/images/connexionOK.png" width="40" height="40" alt="compte.png">
                <?php endif ?>
                <li class="nav-item dropdown <?php if($page=="/login"||$page=="/user/add"||$page=="user/edit"){echo "active";} ?>">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?= (!$currentUser->exist()) ? 'compte' : 'Bienvenue '.$currentUser->getFirstname() ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <?php if(!$currentUser->exist()): ?>
                        <a class="dropdown-item" href="<?= $router->generate('login') ?>">Connexion</a>
                    <?php endif ?>
                    <?php if($currentUser->exist()): ?>
                        <a class="dropdown-item" href="<?= $router->generate('user-list') ?>">Liste des utilisateurs</a>
                        <a class="dropdown-item" href="<?= $router->generate('logout') ?>">Déconnexion</a>
                    <?php endif ?>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>