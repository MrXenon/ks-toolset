<?php
/* Copyright (C) Kevin Schuit - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Kevin Schuit <info@kevinschuit.com>, April 2022
 */
// Include model:
include KS_TOOLSET_PLUGIN_MODEL_DIR . "/classBuilder.class.php";

$builder = new classBuilder();

$base_url = get_admin_url() . 'admin.php';
$params = array('page' => basename(__FILE__, ".php"));
$page = basename(__FILE__, ".php");

$base_url = add_query_arg($params, $base_url);


$get_array = $builder->getGetValues();


$action = FALSE;
if (!empty($get_array)) {

    if (isset($get_array['action'])) {
        $action = $builder->handleGetAction($get_array);
    }
}


$post_array = $builder->getPostValues();


$error = FALSE;

if (!empty($post_array['add'])) {


    $add = FALSE;

        $result = $builder->save($post_array);
        if ($result) {
            $add = TRUE;
        } else {

            $error = TRUE;
        }
}

if (!empty($post_array['update'])) {


    $update = FALSE;

    $result = $builder->update($post_array);
    if ($result) {

        $update = TRUE;
    } else {

        $update = FALSE;
    }
}

if (!empty($get_array['action'] == 'delete')) {

    $del = FALSE;

    $result = $builder->delete($post_array);
    if ($result) {

        $del = TRUE;
    } else {

        $del = FALSE;
    }
}
?>

<div class="container-fluid">
<section id="minimal-statistics">
    <h4 class="text-uppercase">Color changer</h4>
</div>
    <div class="container">
    <?php
    if (isset($add)) {
        echo($add ? "<p class='mt-5 alert alert-success'>".$_POST['colorDefault']." has been overwritten to".$_POST['colorNew'].".</p>" : "<p class='mt-5 alert alert-danger'>Color could not be added.</p>");
    }

    if (isset($update)) {
        echo($update ? "<p class='mt-5 alert alert-success'>Color has been updated.</p>" : "<p class='mt-5 alert alert-danger'>Color could not be updated.</p>");
    }

    if (isset($del)) {
        echo($del ? "<p class='mt-5 alert alert-success'>Color has been permanently deleted.</p>" : "<p class='mt-5 alert alert-danger'>Color could not be deleted.</p>");
    }

        if ($builder->getColorAmount() < 1) {
        if ($action !== 'update') {
            ?>
            <div class="row mb-5" id="formDiv">
                <form class="row g-3 needs-validation" method="post" action="<?=$base_url;?>" validate>
                    <div class="col-md-2 position-relative">
                        <input type="hidden" name="p" value="<?=$page;?>">
                        <label for="validationCustom01" class="form-label">Default color:</label>
                        <input type="color" class="form-control" maxlength="7" name="colorDefault" id="validationCustom01" placeholder="#000000" required>
                        <div class="valid-feedback">
                        Looks good!
                        </div>
                        <div class="invalid-feedback">
                        Please provide a valid color.
                        </div>
                    </div>
                    <div class="col-md-2 position-relative">
                    <label for="validationCustom02" class="form-label">New color:</label>
                        <input type="color" class="form-control" maxlength="7" name="colorNew" id="validationCustom01" placeholder="#efefef" required>
                        <div class="valid-feedback">
                        Looks good!
                        </div>
                        <div class="invalid-feedback">
                        Please provide a valid color.
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="add" class="btn btn-primary" value="Submit">
                    </div>
                </form>
            </div>
            <?php
        } 
    }
    echo(($action == 'update') ? '<form action="' . $base_url . '" method="post">' : '');
    ?>
<div>
    <table class="table table-light" id="networkDiv">
        <?php
        if ($builder->getColorAmount() < 1) {
            ?>
        <p class='alert alert-warning'>No color has been added yet!</p>
        <?php } else { ?>
            <thead>
                <tr>
                    <th width="400">Default color HEX</th>
                    <th width="400">Default color</th>
                    <th width="400">New color HEX</th>
                    <th width="400">New Color</th>
                    <th width="600"></th>
                    <th width="200" colspan="2">Actions</th>
                </tr>
            </thead>
            <?php
            $colors = $builder->getColors();

            foreach ($colors as $builder_obj) {
                $params = array('action' => 'update', 'id' => $builder_obj->getColorId());
                $upd_link = add_query_arg($params, $base_url);

                $params = array('action' => 'delete', 'id' => $builder_obj->getColorId(), 'p' => $page);
                $del_link = add_query_arg($params, $base_url);
                ?>

                <tr>
                    <?php
                    if (($action == 'update') && ($builder_obj->getColorId() == $get_array['id'])) {
                        ?>
                <div class="row">
                <div class="col-md-2 position-relative">
                    <label for="validationCustom01" class="form-label">Default color:</label>
                    <input type="hidden" name="id" value="<?=$builder_obj->getColorId();?>">
                    <input type="hidden" name="p" value="<?=$page;?>">
                    <input type="hidden" name="archive" value="false">
                    <input type="color" class="form-control" maxlength="7" name="colorDefault" id="validationCustom01" placeholder="" required value="<?= $builder_obj->getColorDefault(); ?>">
                    <div class="valid-feedback">
                    Looks good!
                    </div>
                    <div class="invalid-feedback">
                    Please provide a valid network color.
                    </div>
                </div>
                <div class="col-md-2 position-relative">
                    <label for="validationCustom05" class="form-label">New color:</label>
                    <input type="color" class="form-control" maxlength="7" name="colorNew" id="validationCustom02" placeholder="" required value="<?= $builder_obj->getColorNew(); ?>">
                    <div class="valid-feedback">
                    Looks good!
                    </div>
                    <div class="invalid-feedback">
                    Please provide a valid color.
                    </div>
                </div>
                <div class="col-12 mt-4 mb-4">
                    <input type="submit" name="update" class="btn btn-primary" value="Change">
                </div>
                    </div>
                    <?php } else { ?>
                        <td width="200"><?= $builder_obj->getColorDefault(); ?></td>
                        <td width="200" style="background-color:<?= $builder_obj->getColorDefault(); ?>"></td>
                        <td width="200"><?= $builder_obj->getColorNew(); ?></td>
                        <td width="200" style="background-color:<?= $builder_obj->getColorNew(); ?>"></td>
                        <td width="200"></td>
                        <?php if ($action !== 'update') {
                            ?>
                            <td><a href="<?= $upd_link; ?>"><div class="nftIconAdminCheck" data-toggle="tooltip" data-placement="bottom" title="Edit"></div></a></td>
                            <td><a href="<?= $del_link; ?>" onclick="return confirm('Are you sure you want to permanently delete this network?');"><div class="nftIconAdminX" data-toggle="tooltip" data-placement="bottom" title="Delete"></div></a></td>
                            <?php
                        } 
                        ?>
                    <?php }  ?>
                </tr>
                <?php
            }
            ?>
        <?php }
        ?>
    </table>
</div>
    <?php
    echo(($action == 'update') ? '</form>' : '');
?>
  </section>
</div>