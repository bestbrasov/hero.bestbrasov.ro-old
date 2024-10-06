
<div class="pageheader">
    <?php
    if ($_SESSION['intern-acces'] >= 2) {
        ?>
        <form action="results.html" method="post" class="searchbar">
            <a href="dashboard.php?pagina=adaugasedinta" class="btn btn-primary" style="color:white;">Anunta sedinta noua</a>
        </form>
        <?php
    }
    ?>
    <div class="pageicon"><span class="iconfa-comments"></span></div>
    <div class="pagetitle">
        <h5>Sedintele noastre</h5>
        <h1>Sedinte</h1>
    </div>
</div><!--pageheader-->

<?php
if ($_SESSION['intern-acces'] === 3 && !empty($_GET['del'])) {
    del_meeting($_GET['del']);
}
?>
<div class="maincontent">
    <div class="maincontentinner">

        <div class="row">
            <div id="dashboard-left" class="col-md-8">
                <h4 class="widgettitle">Sedinte</h4>
                <table class="table responsive">
                    <thead>
                    <tr>
                        <th>Nume</th>
                        <th>Tip</th>
                        <th>Anuntata de</th>
                        <th>Data</th>
                        <th>Actiuni</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $current_page = isset($_GET['pag']) ? (int)$_GET['pag'] : 0;
                    $logs = get_meetings($current_page); // Default to page 1 if 'pag' is not set
                    foreach ($logs as $log) {
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($log['nume'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars(get_catmeeting($log['categorie'])['nume'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo show_user($log['anuntat_de']); ?></td>
                            <td><?php echo ddate($log['data']); ?></td>
                            <td>
                                <a href="dashboard.php?pagina=sedinte&pag=<?php echo $current_page; ?>&show=<?php echo (int) $log['ID']; ?>">
                                    <span class="iconfa-eye-open"></span>
                                </a>
                                <?php if ($_SESSION['intern-acces'] >= 2) { ?>
                                    &nbsp;&nbsp;&nbsp;<a href="dashboard.php?pagina=editeazasedinta&id=<?php echo (int) $log['ID']; ?>">
                                        <span class="iconfa-pencil"></span>
                                    </a>
                                <?php } ?>
                                <?php if ($_SESSION['intern-acces'] == 3) { ?>
                                    &nbsp;&nbsp;&nbsp;<a href="dashboard.php?pagina=sedinte&pag=<?php echo $current_page ?>&del=<?php echo (int) $log['ID']; ?>">
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

                <?php if (meetings_prev_page($current_page)) { ?>
                    <a href="dashboard.php?pagina=sedinte&pag=<?php echo ($current_page - 1); ?>" class="btn btn-primary" style="color:white;">Pagina anterioara</a>&nbsp;
                <?php } ?>
                <?php if (meetings_next_page($current_page)) { ?>
                    <a href="dashboard.php?pagina=sedinte&pag=<?php echo ($current_page + 1); ?>" class="btn btn-primary" style="color:white;">Pagina urmatoare</a>
                <?php } ?>

            </div>
            <div id="dashboard-left" class="col-md-4">
                <?php
                if (isset($_GET['show']) && check_meeting_exists($_GET['show'])) {
                    $meetingData = get_meeting_data($_GET['show']);
                    ?>
                    <h4 class="widgettitle">Participanti la <?php echo htmlspecialchars($meetingData['nume'], ENT_QUOTES, 'UTF-8'); ?> (<?php echo count_pax_meeting($_GET['show']); ?>)</h4>
                    <div class="widgetcontent" style="overflow-x: hidden;overflow-y: auto;height:235px;">
                        <?php
                        $ranks = get_pax_meeting($_GET['show']);
                        foreach ($ranks as $rank) {
                            echo '<span class="iconfa-user"></span> ' . show_user($rank['IDutilizator']) . "<br />";
                        }
                        ?>
                    </div>

                    <h4 class="widgettitle">Am participat la aceasta sedinta</h4>
                    <div class="widgetcontent">
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['go'] === "y") {
                            part_meeting($_GET['show']);
                        }
                        $status = get_meeting_status_for_user($_GET['show']);
                        if ($status === 0) {
                            ?>
                            <form method="post">
                                <input type="hidden" name="go" value="y">
                                <button class="btn btn-primary">Am participat</button>
                            </form>
                            <?php
                        } elseif ($status == "-1") {
                            echo "Participarea urmeaza sa-ti fie aprobata.";
                        } else {
                            echo "Esti marcat deja ca ai participat la sedinta.";
                        }
                        ?>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
