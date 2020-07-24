<div class="container my-4">
    <a href="<?= $router->generate('product-list') ?>" class="btn btn-success float-right">Retour</a>
    <h2><?= $product->getId() ? 'Modifier le' : 'Ajouter un' ?> produit</h2>

    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $currentError) : ?>
                <div><?= $currentError ?></div>
            <?php endforeach ?>
        </div>
    <?php endif ?>

    <?php if (!empty($_GET['success'])) : ?>
        <div class="alert alert-success">
            <div>La sauvegarde a réussi</div>
        </div>
    <?php endif ?>

    <form action="<?= $router->generate('product-create-update', ['id'=>$product->getId()]) ?>" method="POST" class="mt-5">
        <input type="hidden" name="tokenCSRF" value="<?= $tokenCSRF ?>">
        <input name="id" value="<?= $product->getId() ?>" type="hidden">
        <div class="form-group">
            <label for="name">Nom</label>
            <input name="name" value="<?= $product->getName() ?>" type="text" class="form-control" id="name" placeholder="Nom de la catégorie">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input name="description" value="<?= $product->getDescription() ?>" type="text" class="form-control" id="description" placeholder="Description du produit" aria-describedby="descriptionHelpBlock">
            <small id="descriptionHelpBlock" class="form-text text-muted">
                Sera affiché sur la page du produit a droite de l'image
            </small>
        </div>
        <div class="form-group">
            <label for="picture">Image</label>
            <input name="picture" value="<?= $product->getPicture() ?>" type="text" class="form-control" id="picture" placeholder="image jpg, gif, svg, png" aria-describedby="pictureHelpBlock">
            <small id="pictureHelpBlock" class="form-text text-muted">
                URL relative d'une image (jpg, gif, svg ou png) fournie sur <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
            </small>
        </div>
        <div class="form-group">
            <label for="price">Prix</label>
            <input name="price" value="<?= $product->getPrice() ?>" type="text" class="form-control" id="price" placeholder="Prix en €" aria-describedby="priceHelpBlock">
            <small id="priceHelpBlock" class="form-text text-muted">
                Sera affiché au dessus de la description
            </small>
        </div>
        <div class="form-group">
            <label for="rate">Note</label>
            <input name="rate" value="<?= $product->getRate() ?>" type="number" min="1" max="5" class="form-control" id="rate" aria-describedby="rateHelpBlock">
            <small id="rateHelpBlock" class="form-text text-muted">
                La note du produit sur 5
            </small>
        </div>
        <div class="form-group">
            <label for="status">Statut</label>
            <select name="status" class="custom-select" id="status" aria-describedby="statusHelpBlock">
                <option value="1" <?= $product->getStatus() === '1' ? 'selected' : '' ?>>Disponible</option>
                <option value="2" <?= $product->getStatus() === '2' ? 'selected' : '' ?>>Pas disponible</option>
            </select>
            <small id="categoryHelpBlock" class="form-text text-muted">
                Statut du produit
            </small>
        </div>
        <div class="form-group">
            <label for="category">Categorie</label>
            <select name="category_id" class="custom-select" id="category" aria-describedby="categoryHelpBlock">
                <?php foreach($categories as $category): ?>
                    <option value="<?= $category->getId() ?>" <?= ($product->getCategoryId() === $category->getId()) ? 'selected' : '' ?>><?= $category->getName() ?></option>
                <?php endforeach ?>
            </select>
            <small id="categoryHelpBlock" class="form-text text-muted">
                La catégorie du produit
            </small>
        </div>
        <div class="form-group">
            <label for="brand">Marque</label>
            <select name="brand_id" class="custom-select" id="brand" aria-describedby="brandHelpBlock">
                <?php foreach($brands as $brand): ?>
                    <option value="<?= $brand->getId() ?>" <?= ($product->getBrandId() === $brand->getId()) ? 'selected' : '' ?>><?= $brand->getName() ?></option>
                <?php endforeach ?>
            </select>
            <small id="brandHelpBlock" class="form-text text-muted">
                La marque du produit 
            </small>
        </div>
        <div class="form-group">
        <label for="type">Type</label>
            <select name="type_id" class="custom-select" id="type" aria-describedby="typeHelpBlock">
                <?php foreach($types as $type): ?>
                    <option value="<?= $type->getId() ?>" <?= ($product->getTypeId() === $type->getId()) ? 'selected' : '' ?>><?= $type->getName() ?></option>
                <?php endforeach ?>
            </select>
            <small id="typeHelpBlock" class="form-text text-muted">
                Le type du produit 
            </small>
        </div>
        <label for="type">Tag</label>
        <div class="form-group">
            <?php foreach($tagsList as $index => $tag): ?>
                <label for="tag<?= $index ?>"><?= $tag->getName() ?></label>
                <input class="mr-2" type="checkbox" name="tags[]" id="tag<?= $index ?>" value="<?= $tag->getId() ?>">
            <?php endforeach; ?>
        </div>
        <button type="submit" class="btn btn-primary">Valider</button>
    </form>
</div>