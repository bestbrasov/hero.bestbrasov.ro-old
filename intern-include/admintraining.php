<?php
if ($_SESSION['intern-acces'] != 3) {
    include "404.php";
    die();
}
?>

<div class="pageheader">
    <div class="pageicon"><span class="iconfa-cogs"></span></div>
    <div class="pagetitle">
        <h5>Categoriile pentru sesiunile de training</h5>
        <h1>Administrare categorii de training</h1>
    </div>
</div><!--pageheader-->

<div class="maincontent">
    <div class="maincontentinner">
        <?php
        // Verificare pentru editare
        if (isset($_GET['edit']) && check_category_exists($_GET['edit'])) {
            $info = get_category($_GET['edit']);
            if (isset($_POST['go']) && $_POST['go'] == "y") {
                $message = edit_category($_POST['csrf'], $_GET['edit'], $_POST['name']);
                echo "<div class='alert alert-success'>$message</div>";
                $info = get_category($_GET['edit']); // Actualizează informațiile după editare
            }
            ?>
            <div class="widgetbox">
                <h4 class="widgettitle">Editeaza categorie</h4>
                <div class="widgetcontent nopadding">
                    <form class="stdform stdform2" method="post" action="">
                        <p>
                            <label>Nume</label>
                            <span class="field">
                                <input class="form-control input-lg" type="text" name="name" value="<?php echo htmlspecialchars($info['nume']); ?>">
                            </span>
                        </p>
                        <p class="stdformbutton">
                            <input type="hidden" name="csrf" value="<?php echo $_SESSION['intern-csrf']; ?>">
                            <input type="hidden" name="go" value="y">
                            <button class="btn btn-primary">Editeaza</button>
                        </p>
                    </form>
                </div>
            </div>
            <?php
        } else {
            // Adăugare categorie nouă
            if (isset($_POST['go']) && $_POST['go'] == "y") {
                $message = add_category($_POST['csrf'], $_POST['name']);
                echo "<div class='alert alert-success'>$message</div>";
            }
            ?>
            <div class="widgetbox">
                <h4 class="widgettitle">Adauga categorie noua</h4>
                <div class="widgetcontent nopadding">
                    <form class="stdform stdform2" method="post" action="">
                        <p>
                            <label>Nume</label>
                            <span class="field">
                                <input class="form-control input-lg" type="text" name="name">
                            </span>
                        </p>
                        <p class="stdformbutton">
                            <input type="hidden" name="csrf" value="<?php echo $_SESSION['intern-csrf']; ?>">
                            <input type="hidden" name="go" value="y">
                            <button class="btn btn-primary">Adauga</button>
                        </p>
                    </form>
                </div>
            </div>
            <?php
        }

        // Ștergerea unei categorii
        if (isset($_GET['del'])) {
            del_category($_GET['del']);
        }

        $categorii = get_training_categories();
        if (count($categorii) > 0) {
            ?>
            <div class="peoplelist">
                <?php
                $i = 0;
                foreach ($categorii as $categorie) {
                    $i++;
                    if ($i % 4 == 1) {
                        echo '<div class="row">';
                    }
                    ?>
                    <div class="col-md-3">
                        <div class="peoplewrapper" style="height:80px;">
                            <div class="peopleinfo" style="margin-left:0;">
                                <h4><?php echo htmlspecialchars($categorie['nume']); ?></h4>
                                <ul>
                                    <li><a href="dashboard.php?pagina=admintraining&edit=<?php echo $categorie['ID']; ?>">Editeaza</a> | <a href="dashboard.php?pagina=admintraining&del=<?php echo $categorie['ID']; ?>">Sterge</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php
                    if ($i % 4 == 0 || $i == count($categorii)) {
                        echo '</div>';
                    }
                }
                ?>
            </div>
            <?php
        }
        ?>