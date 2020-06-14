<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
    <head>
        <meta charst="UTF-8">
        <meta name="viewport" content="width=device-width; initial-scale=1">

        <title>Login Akun</title>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-8 ml-auto mr-auto text-center mt-5">
                    <a href="<?php echo $facebook_login_url; ?>"
                        class="btn btn-primary">Login dengan Facebook</a>
                        <br>
                        Belum punya akun? <a href="<?php echo site_url('register'); ?>">Daftar disini!</a>

                        <?php if ($flash) : ?>
                            <div class="alert alert-info mt-5"><?php echo $flash; ?></div>
                        <?php endif; ?>
                </div>
            </div>
        </div>
    </body>
</html>