<?php

use backend\models\Menu;

?>

<ul class="sidebar navbar-nav">
    <?php foreach(Menu::elements as $ix => $el): ?>
        <?php if (Menu::renderiza($el)): ?>
            <?php if (array_key_exists('submenu', $el)): ?>
            <li class="nav-item active">
                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-<?= $ix ?>" aria-controls="submenu-<?= $ix ?>">
                    <i class="fas fa-cogs"></i><?= $el['name'] ?>
                </a>
                <div id="submenu-<?= $ix ?>" class="collapse submenu" style="">
                <?php foreach($el['submenu'] as $subel): ?>
                    <?php if (Menu::renderiza($subel)): ?>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $subel['href'] ?>"><?= $subel['name'] ?></a>
                        </li>
                    </ul>
                    <?php endif; ?>
                <?php endforeach; ?>
                </div>
            </li>
            <?php else: ?>
            <li class="nav-item active">
                <a class="nav-link" href="<?= $el['href'] ?>">
                    <i class="<?= $el['icon'] ?>"></i><?= $el['name'] ?>
                </a>
            </li>
            <?php endif; ?>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>