<div class="pageheader">
    <div class="pageicon"><span class="iconfa-user"></span></div>
    <div class="pagetitle">
        <h5>Lista cu utilizatorii platformei</h5>
        <h1>Utilizatori</h1>
    </div>
</div>
<div class="maincontent">
    <div class="maincontentinner">
        <ul class="peoplegroup">
            <?php
            // Define statuses in an array for easier management
            $statuses = [
                '' => 'Toti',
                '0' => 'Membri baby',
                '2' => 'Membri activi',
                '4' => 'Membri cu drept de vot',
                '5' => 'Membri alumni',
                '3' => 'Membri former',
                '1' => 'Membri exclusi',
            ];

            // Iterate over statuses to create list items
            foreach ($statuses as $key => $label) {
                $activeClass = (isset($_GET['status']) && $_GET['status'] == $key) ? ' class="active"' : '';
                $count = get_members_status_count($key);
                echo "<li$activeClass><a href='dashboard.php?pagina=utilizatori&status=$key'>$label ($count)</a></li>";
            }
            ?>
        </ul>

        <div class="peoplelist">
            <?php
            // Get status from GET, default to empty string if not set
            $status = $_GET['status'] ?? '';
            $users = get_users_list($status);
            $nr = get_users_count();
            $i = 0;

            foreach($users as $user) {
                if ($i % 3 == 0) {
                    echo '<div class="row">';
                }
                ?>
                <div class="col-md-4">
                    <div class="peoplewrapper">
                        <div class="thumb">
                            <a href="dashboard.php?pagina=profil&id=<?php echo $user['ID']; ?>">
                                <img src="<?php echo htmlspecialchars($user['poza']); ?>" alt="Poza lui <?php echo htmlspecialchars($user['nume']); ?>" style="height:80px;" />
                            </a>
                        </div>
                        <div class="peopleinfo">
                            <h4>
                                <a href="dashboard.php?pagina=profil&id=<?php echo $user['ID']; ?>"><?php echo htmlspecialchars($user['nume']); ?></a>
                            </h4>
                            <ul>
                                <li><span>Statut:</span>
                                    <?php echo get_lbg_status($user['statut']); ?>
                                </li>
                                <li><span>Email:</span>
                                    <?php echo htmlspecialchars($user['email']); ?></li>
                                <li><span>Numar de telefon:</span>
                                    <?php echo show_phone($user['nrtelefon']); ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php
                $i++;
                if ($i % 3 == 0 || $i == $nr) {
                    echo '</div>'; // Close row after every 3 users or if it's the last user
                }
            }
            ?>
        </div>

