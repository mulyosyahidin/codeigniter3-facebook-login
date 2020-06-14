<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charst="UTF-8">
    <meta name="viewport" content="width=device-width; initial-scale=1">

    <title><?php echo $data->name; ?></title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-8 ml-auto mr-auto text-center mt-5">
                <?php if ($flash) : ?>
                    <div class="alert alert-info mt-5"><?php echo $flash; ?></div>
                <?php endif; ?>

                <div class="text-center mb-3">
                    <img src="<?php echo base_url('assets/users/' . $data->profile_picture); ?>">
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <td>
                                Nama
                            </td>
                            <td>
                                <b><?php echo $data->name; ?></b>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Email
                            </td>
                            <td>
                                <b><?php echo $data->email; ?></b>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                OAuth ID
                            </td>
                            <td>
                                <b><?php echo $data->oauth_uid; ?></b>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="text-center mt-3">
                    <a href="<?php echo site_url('dashboard/logout'); ?>" class="btn btn-danger">Log Out</a>
                </div>
            </div>
        </div>
</body>
</html>