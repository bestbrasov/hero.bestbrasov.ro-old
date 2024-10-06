<div class="pageheader">
    <?php
    if($_SESSION['intern-acces'] >= 2) {
        ?>
        <form action="results.html" method="post" class="searchbar">
            <a href="dashboard.php?pagina=adaugaeveniment" class="btn btn-primary" style="color:white;">Anunta eveniment nou</a>
        </form>
        <?php
    }
    ?>
    <div class="pageicon"><span class="iconfa-group"></span></div>
    <div class="pagetitle">
        <h5>Evenimentele noastre</h5>
        <h1>Evenimente</h1>
    </div>
</div><!--pageheader-->

<?php
if($_SESSION['intern-acces'] === 3 && !empty($_GET['del'])) {
    del_event($_GET['del']);
}
?>
<div class="maincontent">
    <div class="maincontentinner">

        <div class="row">
            <div id="dashboard-left" class="col-md-8">
                <h4 class="widgettitle">Evenimente</h4>
                <table class="table responsive">
                    <thead>
                    <tr>
                        <th>Nume</th>
                        <th>Perioada</th>
                        <th>Actiuni</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $current_page = isset($_GET['pag']) ? (int)$_GET['pag'] : 0;
                    $logs = get_events($current_page);
                    foreach($logs as $log) {
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($log['nume'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo ($log['datai'] == $log['dataf']) ? ddate($log['datai']) : ddate($log['datai']) . " - " . ddate($log['dataf']); ?></td>
                            <td>
                                <a href="dashboard.php?pagina=evenimente&pag=<?php echo $current_page; ?>&show=<?php echo (int) $log['ID']; ?>">
                                    <span class="iconfa-eye-open"></span>
                                </a>
                                <?php if($_SESSION['intern-acces'] >= 2) { ?>
                                    &nbsp;&nbsp;&nbsp;<a href="dashboard.php?pagina=editeazaeveniment&id=<?php echo (int) $log['ID']; ?>">
                                        <span class="iconfa-pencil"></span>
                                    </a>
                                <?php } ?>
                                <?php if ($_SESSION['intern-acces'] == 3) { ?>
                                    &nbsp;&nbsp;&nbsp;<a href="dashboard.php?pagina=evenimente&pag=<?php echo $current_page ?>&del=<?php echo (int) $log['ID']; ?>">
                                        <span class="iconfa-trash"></span>
                                    </a>
                                <?php } ?>

                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>

                <?php if (events_next_page($current_page)) { ?>
                    <a href="dashboard.php?pagina=appevenimente&pag=<?php echo $current_page - 1; ?>" class="btn btn-primary" style="color:white;">Pagina anterioara</a>&nbsp;
                <?php } ?>
                <?php if (events_next_page($current_page)) { ?>
                    <a href="dashboard.php?pagina=appevenimente&pag=<?php echo $current_page + 1; ?>" class="btn btn-primary" style="color:white;">Pagina urmatoare</a>
                <?php } ?>

            </div>
            <div id="dashboard-left" class="col-md-4">
                <?php
                if(isset($_GET['show']) && check_event_exists($_GET['show'])) {
                    $eventData = get_event_data($_GET['show']);
                    ?>
                    <h4 class="widgettitle">Descrierea evenimentului <?php echo htmlspecialchars($eventData['nume'], ENT_QUOTES, 'UTF-8'); ?></h4>
                    <div class="widgetcontent">
                        <?php
                        $description = $eventData['descriere'] ?: "<em>Nu a fost adaugata nici o descriere.</em>";
                        echo $description;
                        ?>
                    </div>

                    <h4 class="widgettitle">Participanti la evenimentul <?php echo htmlspecialchars($eventData['nume'], ENT_QUOTES, 'UTF-8'); ?> (<?php echo count_pax_event($_GET['show']); ?>)</h4>
                    <div class="widgetcontent" style="overflow-x: hidden;overflow-y: auto;height:235px;">
                        <?php
                        $ranks = get_pax_event($_GET['show']);
                        foreach($ranks as $rank) {
                            echo '<span class="iconfa-user"></span> ' . show_user($rank['IDutilizator']) . " (".$rank['rank'].")<br />";
                        }
                        ?>
                    </div>

                    <h4 class="widgettitle">Am participat la acest eveniment</h4>
                    <div class="widgetcontent">
                        <?php
                        if($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['go'] === "y") {
                            part_event($_GET['show'], $_POST['nume']);
                        }
                        $status = get_event_status_for_user($_GET['show']);
                        if($status === 0) {
                            ?>
                            <form method="post">
                    <span class="field">
                         <input type="text" class="form-control input-default" name="nume" value="<?php echo htmlspecialchars($data['nume'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Numele responsabilitatii tale">
                    </span>
                                <br />
                                <input type="hidden" name="go" value="y">
                                <button class="btn btn-primary">Am participat</button>
                            </form>
                            <?php
                        } elseif($status == "-1") {
                            echo "Participarea urmeaza sa-ti fie aprobata.";
                        } else {
                            echo "Esti marcat deja ca ai participat la eveniment.";
                        } ?>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
