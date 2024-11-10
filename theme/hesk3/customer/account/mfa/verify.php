<?php
global $hesk_settings, $hesklang;
/**
 * @var string $mfaMethod - The MFA method the user chose.  'EMAIL' for email, 'AUTH-APP' for authenticator app
 * @var array $model - A model of relevant data:
 *   - If $mfaMethod === 'EMAIL':
 *     - string 'emailSent' - `true` if email was successfully sent, `false` otherwise.
 *   - If $mfaMethod === 'AUTH-APP':
 *     - string 'secret' - The auth app secret
 *     - string 'qrCodeUri' - A base-64 encoded image that can be used to show a QR code
 * @var array $messages - Feedback messages to be displayed, if any
 * @var array $customerUserContext - User info for a customer if logged in.  `null` if a customer is not logged in.
 */

// This guard is used to ensure that users can't hit this outside of actual HESK code
if (!defined('IN_SCRIPT')) {
    die();
}

require_once(TEMPLATE_PATH . 'customer/util/alerts.php');
require_once(TEMPLATE_PATH . 'customer/partial/login-navbar-elements.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?php echo $hesk_settings['hesk_title']; ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo HESK_PATH; ?>img/favicon/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo HESK_PATH; ?>img/favicon/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo HESK_PATH; ?>img/favicon/favicon-16x16.png" />
    <link rel="manifest" href="<?php echo HESK_PATH; ?>img/favicon/site.webmanifest" />
    <link rel="mask-icon" href="<?php echo HESK_PATH; ?>img/favicon/safari-pinned-tab.svg" color="#5bbad5" />
    <link rel="shortcut icon" href="<?php echo HESK_PATH; ?>img/favicon/favicon.ico" />
    <meta name="msapplication-TileColor" content="#2d89ef" />
    <meta name="msapplication-config" content="<?php echo HESK_PATH; ?>img/favicon/browserconfig.xml" />
    <meta name="theme-color" content="#ffffff" />
    <meta name="format-detection" content="telephone=no" />
    <link rel="stylesheet" media="all" href="<?php echo TEMPLATE_PATH; ?>customer/css/app<?php echo $hesk_settings['debug_mode'] ? '' : '.min'; ?>.css?<?php echo $hesk_settings['hesk_version']; ?>" />
    <!--[if IE]>
    <link rel="stylesheet" media="all" href="<?php echo TEMPLATE_PATH; ?>customer/css/ie9.css" />
    <![endif]-->
    <?php include(TEMPLATE_PATH . '../../head.txt'); ?>
</head>

<body class="cust-help">
<?php include(TEMPLATE_PATH . '../../header.txt'); ?>
<div class="wrapper">
    <main class="main">
        <header class="header">
            <div class="contr">
                <div class="header__inner">
                    <a href="<?php echo $hesk_settings['hesk_url']; ?>" class="header__logo">
                        <?php echo $hesk_settings['hesk_title']; ?>
                    </a>
                    <?php renderLoginNavbarElements($customerUserContext); ?>
                    <?php if ($hesk_settings['can_sel_lang']): ?>
                        <div class="header__lang">
                            <form method="get" action="" style="margin:0;padding:0;border:0;white-space:nowrap;">
                                <div class="dropdown-select center out-close">
                                    <select name="language" onchange="this.form.submit()">
                                        <?php hesk_listLanguages(); ?>
                                    </select>
                                </div>
                                <?php foreach (hesk_getCurrentGetParameters() as $key => $value): ?>
                                    <input type="hidden" name="<?php echo hesk_htmlentities($key); ?>"
                                           value="<?php echo hesk_htmlentities($value); ?>">
                                <?php endforeach; ?>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </header>
        <div class="breadcrumbs">
            <div class="contr">
                <div class="breadcrumbs__inner">
                    <a href="<?php echo $hesk_settings['site_url']; ?>">
                        <span><?php echo $hesk_settings['site_title']; ?></span>
                    </a>
                    <svg class="icon icon-chevron-right">
                        <use xlink:href="<?php echo TEMPLATE_PATH; ?>customer/img/sprite.svg#icon-chevron-right"></use>
                    </svg>
                    <a href="<?php echo $hesk_settings['hesk_url']; ?>">
                        <span><?php echo $hesk_settings['hesk_title']; ?></span>
                    </a>
                    <svg class="icon icon-chevron-right">
                        <use xlink:href="<?php echo TEMPLATE_PATH; ?>customer/img/sprite.svg#icon-chevron-right"></use>
                    </svg>
                    <a href="profile.php">
                        <span><?php echo $hesklang['customer_profile']; ?></span>
                    </a>
                    <svg class="icon icon-chevron-right">
                        <use xlink:href="<?php echo TEMPLATE_PATH; ?>customer/img/sprite.svg#icon-chevron-right"></use>
                    </svg>
                    <div class="last"><?php echo $hesklang['mfa']; ?></div>
                </div>
            </div>
        </div>
        <div class="main__content">
            <div class="contr">
                <div style="margin-bottom: 20px;">
                    <?php hesk3_show_messages($messages); ?>
                </div>
                <h3 class="article__heading article__heading--form">
                    <div class="icon-in-circle">
                        <svg class="icon icon-document">
                            <use xlink:href="<?php echo TEMPLATE_PATH; ?>customer/img/sprite.svg#icon-lock"></use>
                        </svg>
                    </div>
                    <span class="ml-1"><?php echo $hesklang['mfa']; ?></span>
                </h3>
                <form id="verify-form" action="manage_mfa.php" method="post" name="form1" id="formNeedValidation" class="form form-submit-ticket ticket-create" novalidate>
                    <div data-step="2">
                        <ul class="step-bar no-click">
                            <li data-link="1" data-all="3">
                                <?php echo $hesklang['mfa_step_method']; ?>
                            </li>
                            <li data-link="2" data-all="3">
                                <?php echo $hesklang['mfa_step_verification']; ?>
                            </li>
                            <li data-link="3" data-all="3">
                                <?php echo $hesklang['mfa_step_complete']; ?>
                            </li>
                        </ul>
                    </div>
                    <div class="step-item step-2">
                        <?php if ($mfaMethod === 'EMAIL') { ?>
                            <div>
                                <h3><?php echo sprintf($hesklang['mfa_verification_header'], $hesklang['mfa_method_email']); ?></h3>
                                <?php
                                if ($model['emailSent']) {
                                    hesk_show_notice(sprintf($hesklang['mfa_verification_email_intro'], $_SESSION['customer']['email']), ' ', false);
                                }
                                ?>
                            </div>
                        <?php } elseif ($mfaMethod === 'AUTH-APP') { ?>
                            <div>
                                <h3><?php echo sprintf($hesklang['mfa_verification_header'], $hesklang['mfa_method_auth_app']); ?></h3>
                                <p><?php echo $hesklang['mfa_verification_auth_app_intro']; ?></p>
                                <img src="<?php echo $model['qrCodeUri']; ?>" alt="QR Code">
                                <?php
                                hesk_show_info(sprintf($hesklang['mfa_verification_auth_app_cant_scan'], chunk_split($model['secret'], 4, ' ')), ' ', false);
                                ?>
                                <p>&nbsp;</p>
                                <p><?php echo $hesklang['mfa_verification_auth_app_enter_code']; ?><br>&nbsp;</p>
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <label><?php echo $hesklang['mfa_code']; ?></label>
                            <input name="verification-code" id="verify-input" type="text" class="form-control" maxlength="6" placeholder="000000" autocomplete="off">
                            <input type="hidden" name="current-step" value="2">
                            <input type="hidden" name="mfa-method" value="<?php echo $mfaMethod; ?>">
                            <button type="submit" class="btn btn-full" ripple="ripple"><?php echo $hesklang['mfa_verify']; ?></button>
                        </div>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <a href="manage_mfa.php">
                            <button type="button" class="btn btn--blue-border"><?php echo $hesklang['wizard_back']; ?></button>
                        </a>
                    </div>
                </form>
            </div>
        </div>
        <?php
        /*******************************************************************************
        The code below handles HESK licensing and must be included in the template.

        Removing this code is a direct violation of the HESK End User License Agreement,
        will void all support and may result in unexpected behavior.

        To purchase a HESK license and support future HESK development please visit:
        https://www.hesk.com/buy.php
         *******************************************************************************/
        $hesk_settings['hesk_license']('Qo8Zm9vdGVyIGNsYXNzPSJmb290ZXIiPg0KICAgIDxwIGNsY
XNzPSJ0ZXh0LWNlbnRlciI+UG93ZXJlZCBieSA8YSBocmVmPSJodHRwczovL3d3dy5oZXNrLmNvbSIgY
2xhc3M9ImxpbmsiPkhlbHAgRGVzayBTb2Z0d2FyZTwvYT4gPHNwYW4gY2xhc3M9ImZvbnQtd2VpZ2h0L
WJvbGQiPkhFU0s8L3NwYW4+PGJyPk1vcmUgSVQgZmlyZXBvd2VyPyBUcnkgPGEgaHJlZj0iaHR0cHM6L
y93d3cuc3lzYWlkLmNvbS8/dXRtX3NvdXJjZT1IZXNrJmFtcDt1dG1fbWVkaXVtPWNwYyZhbXA7dXRtX
2NhbXBhaWduPUhlc2tQcm9kdWN0X1RvX0hQIiBjbGFzcz0ibGluayI+U3lzQWlkPC9hPjwvcD4NCjwvZ
m9vdGVyPg0K',"\104", "a809404e0adf9823405ee0b536e5701fb7d3c969");
        /*******************************************************************************
        END LICENSE CODE
         *******************************************************************************/
        ?>
    </main>
</div>
<?php include(TEMPLATE_PATH . '../../footer.txt'); ?>
<script src="<?php echo TEMPLATE_PATH; ?>customer/js/jquery-3.5.1.min.js"></script>
<script src="<?php echo TEMPLATE_PATH; ?>customer/js/hesk_functions.js?<?php echo $hesk_settings['hesk_version']; ?>"></script>
<script>
    var $verifyForm = $('#verify-form');
    $verifyForm.preventDoubleSubmission();
    $verifyForm.submit(function() {
        $(this).find('button[type="submit"]')
            .attr('disabled', 'disabled')
            .addClass('disabled');
    });
    $('#verify-input').keyup(function() {
        if (this.value.length === 6) {
            $('#verify-form').submit();
        }
    });
</script>
<script src="<?php echo TEMPLATE_PATH; ?>customer/js/svg4everybody.min.js"></script>
<script src="<?php echo TEMPLATE_PATH; ?>customer/js/selectize.min.js?<?php echo $hesk_settings['hesk_version']; ?>"></script>
<script src="<?php echo TEMPLATE_PATH; ?>customer/js/jquery.modal.min.js"></script>
<script src="<?php echo TEMPLATE_PATH; ?>customer/js/app<?php echo $hesk_settings['debug_mode'] ? '' : '.min'; ?>.js?<?php echo $hesk_settings['hesk_version']; ?>"></script>
<?php if (defined('RECAPTCHA')) : ?>
    <script src="https://www.google.com/recaptcha/api.js?hl=<?php echo $hesklang['RECAPTCHA']; ?>" async defer></script>
    <script>
        function recaptcha_submitForm() {
            document.getElementById("form1").submit();
        }
    </script>
<?php endif; ?>
</body>
</html>