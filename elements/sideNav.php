<div id="main-sidenav" data-ax="sidenav" class="sidenav right-aligned shadow-1 large fixed neu-blue">
    <div class="sidenav-header">
        <button data-target="main-sidenav" class="sidenav-trigger "><i class="fas fa-times"></i></button>
        <span class="logoFont textshadow-2 FontSize1-6rem lh-6">CrecheCalendar</span>
        <a class="sidenav-link hide-md-up m-2 lh-6 neu-flat neu-lighten rounded-2" data-neu-click="neu-pressed"
           id="tooltip" data-ax="tooltip" data-tooltip-content="Tooltip"
           href="<?= $router->generate('home') ?>"><i class="fas fa-home"></i> Home</a>
        <?php if (!$boolConnected): ?>
            <a class="sidenav-link hide-md-up m-2 lh-6 neu-flat neu-lighten rounded-2" data-neu-click="neu-pressed"
               href="<?= $router->generate('register') ?>"><i class="fas fa-user-shield"></i> S'enregister </a>
        <?php endif; ?>
        <a class="sidenav-link hide-md-up m-2 lh-6 neu-flat neu-lighten rounded-2" data-neu-click="neu-pressed"
           href="<?= $router->generate(($boolConnected) ? 'logout' : 'login', ['logout' => 0]) ?>"><i
                    class="fas fa-key"></i> <?= ($boolConnected) ? 'Déconnexion' : 'Se connecter'; ?></a>
    </div>


    <?php
    if ($boolConnected && !empty($arrayCreches)
    && ($role === 'Modérateur' || $role === 'Employé')) :
    ?>
    <a class="sidenav-link collapsible-trigger neu-blue neu-flat lh-6" data-target="crechesList" href=""><i
                class="fas fa-school mr-2"></i>Crèche(s)</a>
    <div>
        <?php
        if ($boolConnected && !empty($arrayCreches)) :
        ?>
        <form class="m-1" method="post" action="" id="formSelectedCreche" name="formSelectedCreche">
            <select id="selectedCreche" name="selectedCreche" class="truncate w100" onchange="this.form.submit()">

                <?php
                foreach ($arrayCreches as $key => $value) {
                # créé les liens vers la ou les crèches
                ?>
                <option value="<?= $value['creche_id'] ?>" <?= (isset($selectedCrecheId) && $selectedCrecheId === intval($value['creche_id'])) ? 'selected' : '' ?>>
                    <?= $value['crecheName'] ?>
                </option>
                <?php
                }
        endif;
        ?>
            </select>
        </form>
    </div>
    <div class="d-flex fx-col fx-center p-0 m-0">
        <div class="collapsible" id="crechesList" data-ax="collapsible">
            <?php
            if ($boolConnected && !empty($arrayCreches)
                && ($role === 'Modérateur' || $role === 'Employé')) :
            ?>
                <div class="d-flex fx-row fx-space-around neu-flat neu-convex">
                    <a href="<?= $router->generate('addCreche') ?>"
                       data-neu-click="neu-pressed" title="Planing de la crèche"
                       class="sidenav-link my-2 p-0 btn small circle neu-concave">
                        <i class="far fa-calendar-alt textshadow-2 txt-yellow txt-dark-1"></i>
                    </a>
                    <a href="<?= $router->generate('addCreche') ?>"
                       data-neu-click="neu-pressed" title="Ajouter une crèche"
                       class="sidenav-link my-2 p-0 btn small circle neu-concave">
                        <i class="fas fa-plus textshadow-2"></i>
                    </a>
                    <a href="<?= $router->generate('addCreche') ?>"
                       data-neu-click="neu-pressed" title="Modifier la crèche"
                       class="sidenav-link my-2 p-0 btn small circle neu-concave">
                        <i class="fas fa-cog textshadow-2 txt-green txt-dark-1"></i>
                    </a>
                    <form class="p-0 m-0" action="<?= $router->generate('deleteCreche') ?>" method="post"
                          id="deleteCreche" name="deleteCreche">
                        <input name="selectedCrecheId" hidden="hidden" value="<?= $selectedCrecheId ?>">
                        <button data-neu-click="neu-pressed" title="Supprimer la crèche" type="submit" class="btn small circle my-2 neu-concave"><i
                                    class="fas fa-trash-alt txt-red textshadow-2  txt-light-1"></i></button>
                    </form>

                </div>
            <?php
            endif;
            ?>

        </div>

    </div>
    <a class="sidenav-link collapsible-trigger neu-blue neu-flat lh-6" data-target="sectionsList" href="#"><i
                class="fas fa-puzzle-piece"></i> Section(s)</a>
    <div>
        <?php
        if ($boolConnected && !empty($arrayCrecheSection)
        && ($role === 'Modérateur' || $role === 'Employé')) :
        ?>
        <form class="mb-1 mx-1" method="post" action="" id="formSelectedCrecheSection" name="formSelectedCrecheSection">
            <select id="selectedCrecheSection" name="selectedCrecheSection" class="truncate w100"
                    onchange="this.form.submit()">

                <?php
                foreach ($arrayCrecheSection as $key => $value) {
                    # créé les liens vers la ou les crèches
                    ?>
                    <option value="<?= $value['section_id'] ?>" <?= (isset($selectedCrecheSectionId) && $selectedCrecheSectionId === intval($value['section_id'])) ? 'selected' : '' ?>>
                        <?= $value['section_Name'] ?>
                    </option>
                <?php
                }
                ?>

            </select>
        </form>
        <?php
        endif;
        ?>
    </div>
    <div>
        <div class="collapsible center" id="sectionsList" data-ax="collapsible">
            <?php
            if ($boolConnected && !empty($arrayCrecheSection)) :
                ?>
                <div class="d-flex fx-row fx-space-around neu-flat neu-convex">
                    <a href="<?= $router->generate('addSection') ?>"
                       data-neu-click="neu-pressed" title="Planing de la section"
                       class="sidenav-link my-2 mx-auto p-0 btn small circle neu-concave">
                        <i class="far fa-calendar-alt textshadow-2 txt-yellow txt-dark-1"></i>
                    </a>
            <?php
            endif;
            if ($boolConnected && !empty($arrayCreches)) :
            ?>
                    <a href="<?= $router->generate('addSection') ?>"
                       data-neu-click="neu-pressed" title="Ajouter une section"
                       class="sidenav-link my-2 mx-auto p-0 btn small circle neu-concave">
                        <i class="fas fa-plus textshadow-2"></i>
                    </a>
            <?php
            endif;
            if ($boolConnected && !empty($arrayCrecheSection)) :
            ?>
                    <a href="<?= $router->generate('addSection') ?>"
                       data-neu-click="neu-pressed" title="Modifier la section"
                       class="sidenav-link my-2 p-0 mx-auto btn small circle neu-concave">
                        <i class="fas fa-cog textshadow-2 txt-green txt-dark-1"></i>
                    </a>
                    <form class="p-0 my-0 mx-auto" action="<?= $router->generate('deleteSection') ?>" method="post"
                          id="deleteCreche" name="deleteSection">
                        <input name="selectedSectionId" hidden="hidden" value="<?= $selectedCrecheSectionId ?>">
                        <button data-neu-click="neu-pressed" title="Supprimer la section" type="submit" class="btn small circle my-2 neu-concave"><i
                                    class="fas fa-trash-alt txt-red textshadow-2  txt-light-1"></i></button>
                    </form>

                </div>
            <?php
            endif;
            ?>
        </div>
    </div>


    <a class="sidenav-link collapsible-trigger" data-target="employeesList" href=""><i
                class="fas fa-house-user"></i> Employé(es)</a>
    <div>
        <div class="collapsible" id="employeesList" data-ax="collapsible">
            <a href="<?= $router->generate('addEmployee') ?>" class="sidenav-link"><i class="fas fa-plus"></i>
                Ajouter un Employé
            </a>
        </div>
    </div>
    <?php endif; ?>
    <a class="sidenav-link collapsible-trigger" data-target="childsList" href=""><i class="fas fa-baby"></i>
        Enfants</a>
    <div>
        <div class="d-flex fx-row fx-space-around neu-flat neu-convex">
            <a href="<?= $router->generate('addCreche') ?>"
               data-neu-click="neu-pressed" title="Planing de l'enfant"
               class="sidenav-link my-2 p-0 btn small circle neu-concave">
                <i class="far fa-calendar-alt textshadow-2 txt-yellow txt-dark-1"></i>
            </a>
            <?php
            if ($boolConnected && !empty($arrayCreches)
            && ($role === 'Modérateur' || $role === 'Employé')) :
            ?>
            <a href="<?= $router->generate('addChild') ?>"
               data-neu-click="neu-pressed" title="Ajouter un enfant"
               class="sidenav-link my-2 p-0 btn small circle neu-concave">
                <i class="fas fa-plus textshadow-2"></i>
            </a>
            <?php endif; ?>
            <a href="<?= $router->generate('listCrecheChilds') ?>"
               data-neu-click="neu-pressed" title="Administrer"
               class="sidenav-link my-2 p-0 btn small circle neu-concave">
                <i class="fas fa-cog textshadow-2 txt-green txt-dark-1"></i>
            </a>
        </div>
    </div>

</div>
