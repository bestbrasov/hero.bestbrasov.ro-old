<?php
if($_SESSION['intern-acces'] < 2)
{
    include "404.php";
    die();
}
?>       <div class="pageheader">
    <div class="pageicon"><span class="iconfa-cogs"></span></div>
    <div class="pagetitle">
        <h5>Modifica sedintele la care a participat utilizatorul</h5>
        <h1>Modifica sedintele la care a participat </h1>
    </div>
</div><!--pageheader-->

<div class="maincontent">
    <div class="maincontentinner">
        <?php
        if (isset($_GET['utilizator']) && check_exists($_GET['utilizator'])) {
            if (isset($_POST['go2']) && $_POST['go2'] == "y") {
                // Process form submission
                // Call the set_participation_meetings function
                $response = set_participation_meetings($_POST, $_GET['utilizator']);
                echo $response; // Display the response from the function
            }

            // Get user data if utilizator exists
            $data = get_user_data($_GET['utilizator']);
            ?>
            <div class="row">
                <h4 class="widgettitle">Modifică ședințele</h4>
            </div>
            <div class="widgetcontent nopadding row">
                <form class="stdform custom-form" method="post">
                    <div class="row cards-container">
                        <?php
                        $meetings = get_all_meetings();
                        foreach ($meetings as $meeting) {
                            ?>
                            <div class="col-md-3 col-sm-6 custom-card-parent">
                                <div class="card custom-card">
                                    <div class="card-header">
                                        <h5 class="custom-card-title"><?php echo $meeting['nume']; ?></h5>
                                    </div>
                                    <div class="card-body">
                                        <label class="custom-card-date"><?php echo $meeting['data']; ?></label>
                                        <input type="hidden" name="training_<?php echo $meeting['ID']; ?>" value="0"> <!-- Hidden input -->
                                        <span class="field checkbox">
                                            <input type="checkbox" name="training_<?php echo $meeting['ID'];?>" value="p"<?php if(check_participation_meeting($meeting['ID'],$_GET['utilizator'])){echo "checked";} ?>> Participat
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <p class="custom-form-button">
                        <input type="hidden" name="go2" value="y">
                        <input type="hidden" name="csrf" value="<?php echo $_SESSION['intern-csrf']; ?>">
                        <button class="btn btn-primary">Modifică</button>
                    </p>
                </form>
            </div>

            <?php
        } else {
            echo '<div class="alert alert-danger">Utilizatorul nu există sau datele nu sunt valide.</div>';
        }
        ?>


