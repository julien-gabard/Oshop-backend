<div class="container my-4">
    <a href="<?= $router->generate('category-list') ?>" class="btn btn-success float-right">Retour</a>
    <h2>Catégories mises en avant</h2>

    <?php if (!empty($success)) : ?>
        <div class="alert alert-success">
            <div><?= $success ?></div>
        </div>
    <?php endif ?>

    <form action="" method="POST" class="mt-5" id="homeOrderForm">
        <input type="hidden" name="tokenCSRF" value="<?= $tokenCSRF ?>">
        <div class="form-group">
            <label for="emplacement1">Emplacement #1</label>
            <select class="form-control" id="emplacement1" name="emplacement[]">
                <option value="">choisissez :</option>
                <?php foreach($categories as $category): ?>
                    <option value="<?= $category->getId() ?>" <?= $category->getHomeOrder() == 1 ? 'selected':'' ?>>
                        <?= $category->getName() ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="emplacement2">Emplacement #2</label>
            <select class="form-control" id="emplacement2" name="emplacement[]">
                <option value="">choisissez :</option>
                <?php foreach($categories as $category): ?>
                    <option value="<?= $category->getId() ?>" <?= $category->getHomeOrder() == 2 ? 'selected':'' ?>>
                        <?= $category->getName() ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="emplacement3">Emplacement #3</label>
            <select class="form-control" id="emplacement3" name="emplacement[]">
                <option value="">choisissez :</option>
                <?php foreach($categories as $category): ?>
                    <option value="<?= $category->getId() ?>" <?= $category->getHomeOrder() == 3 ? 'selected':'' ?>>
                        <?= $category->getName() ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="emplacement4">Emplacement #4</label>
            <select class="form-control" id="emplacement4" name="emplacement[]">
                <option value="">choisissez :</option>
                <?php foreach($categories as $category): ?>
                    <option value="<?= $category->getId() ?>" <?= $category->getHomeOrder() == 4 ? 'selected':'' ?>>
                        <?= $category->getName() ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="emplacement5">Emplacement #5</label>
            <select class="form-control" id="emplacement5" name="emplacement[]">
                <option value="">choisissez :</option>
                <?php foreach($categories as $category): ?>
                    <option value="<?= $category->getId() ?>" <?= $category->getHomeOrder() == 5 ? 'selected':'' ?>>
                        <?= $category->getName() ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Valider</button>
    </form>
</div>