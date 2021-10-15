<?php
if(!defined('ABSPATH')){
    die();
}

if(isset($_POST['iws_save_premission'])){
    $set_permission = json_decode(get_option(IWS_CAN_UPLODE_WEBP));
    isset($_POST['iws_editor']) ? $set_permission->editor = 1 : $set_permission->editor = 0;
    isset($_POST['iws_author']) ? $set_permission->author = 1 : $set_permission->author = 0;
    isset($_POST['iws_contributor']) ? $set_permission->contributor = 1 : $set_permission->contributor = 0;
    isset($_POST['iws_subscriber']) ? $set_permission->subscriber = 1 : $set_permission->subscriber = 0;

    $set_permission = json_encode($set_permission);
    $result = update_option(IWS_CAN_UPLODE_WEBP, $set_permission);
    if($result){
        echo '<div class="notice notice-success is-dismissible"><p>Permissions Saved.</p></div>';
    }
}

$permited_to = json_decode(get_option(IWS_CAN_UPLODE_WEBP));
?>

<div class="wrap">
    <h1>Enable WebP</h1>
    <h3>Select who can upload WebP images</h3>
    <form action="options-general.php?page=iws-enable-webp" method="post">
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row">
                        <label for="iws-editor">Editor</label>
                    </th>
                    <td>
                        <input type="checkbox" name="iws_editor" id="iws-editor" value="<?php echo $permited_to->editor ? 0 : 1;?>" <?php echo $permited_to->editor ? 'checked' : '';?> />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="iws-author">Author</label>
                    </th>
                    <td>
                        <input type="checkbox" name="iws_author" id="iws-author" value="<?php echo $permited_to->author ? 0 : 1;?>" <?php echo $permited_to->author ? 'checked' : '';?> />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="iws-contributor">Contributor</label>
                    </th>
                    <td>
                        <input type="checkbox" name="iws_contributor" id="iws-contributor" value="<?php echo $permited_to->contributor ? 0 : 1;?>" <?php echo $permited_to->contributor ? 'checked' : '';?> />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="iws-subscriber">Subscriber</label>
                    </th>
                    <td>
                        <input type="checkbox" name="iws_subscriber" id="iws-subscriber" value="<?php echo $permited_to->subscriber ? 0 : 1;?>" <?php echo $permited_to->subscriber ? 'checked' : '';?> />
                    </td>
                </tr>
            </tbody>
        </table>
        <p>
            <input type="submit" class="button button-primary" name="iws_save_premission" value="Save" />
        </p>
    </form>
</div>