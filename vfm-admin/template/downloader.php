<?php
/**
 * VFM - veno file manager: include/downloader.php
 * Show download buttons for shared links
 *
 * PHP version >= 5.3
 *
 * @category  PHP
 * @package   VenoFileManager
 * @author    Nicola Franchini <support@veno.it>
 * @copyright 2013 Nicola Franchini
 * @license   Exclusively sold on CodeCanyon
 * @link      http://filemanager.veno.it/
 */
if (!defined('VFM_APP')) {
    return;
}
/**
 * Downloader
 */
$expired = true;

$share_path = basename(dirname(dirname(__FILE__))) == '_content' ? dirname(dirname(dirname(__FILE__))) : dirname(dirname(__FILE__));
$share_json = $share_path.'/_content/share/'.$getdownloadlist.'.json';

if ($getdownloadlist && file_exists($share_json)) {
    $expired = false;

    $datarray = json_decode(file_get_contents($share_json), true);
    $passa = true;
    $passcap = true;
    $passpass = true;

    $pass = (isset($datarray['pass']) ? $datarray['pass'] : false);

    if ($pass) {
        $passa = false;
        $passpass = false;
        $postpass = isset($_POST['dwnldpwd']) ? $_POST['dwnldpwd'] : false;
        if ($postpass) {
            if (md5($postpass) === $pass) {
                $passa = true;
                $passpass = true;
            }
        }
    }

    if (!Utils::checkCaptcha('show_captcha_download')) {
        $passa = false;
        $passcap = false;
    }

    $hash = $datarray['hash'];
    $time = $datarray['time'];
    $lifetime = isset($datarray['lifetime']) ? (int)$datarray['lifetime'] : (int)$setUp->getConfig('lifetime');
    $sh = md5($time.$hash);

    if ($passa === true) {
        $direct_links = $setUp->getConfig('direct_links');
        $target = '';

        $countfiles = 0;

        if ($downloader->checkTime($time, $lifetime)) {
            $onetime_download = $setUp->getConfig('one_time_download') ? $getdownloadlist : '0';
            include_once 'vfm-admin/icons/vfm-icons.php';
            $pieces = explode(",", $datarray['attachments']);
            $totalsize = 0;

            if (count($pieces) > 1) {
                ?>
            <div class="col-12 bigzip text-center my-4">
                <button type="button" class="btn btn-primary btn-lg centertext zipshare" data-time="<?php echo $time; ?>" data-hash="<?php echo $hash; ?>" data-downloadlist="<?php echo $datarray['attachments']; ?>" data-onetime="<?php echo $onetime_download; ?>">
                    <i class="bi bi-archive fs-1"></i> .zip
                </button>
            </div>
                <?php
            } ?>

            <div class="col-12">
                <div class="row shared-links">
            <?php


            foreach ($pieces as $count => $pezzo) {
                $myfile = urldecode(base64_decode($pezzo));

                if (file_exists($myfile)) {
                    $filepathinfo = Utils::mbPathinfo($myfile);
                    $filename = $filepathinfo['basename'];
                    $extension = strtolower($filepathinfo['extension']);
                    $filesize = Utils::getFileSize($myfile);
                    $totalsize += $filesize;
                    $thisicon = array_key_exists($extension, $_IMAGES) ? $_IMAGES[$extension] : 'file-earmark';

                    // Set pretty links
                    if ($setUp->getConfig('enable_prettylinks') == true) {
                        $downlink = 'download/'.$countfiles.'/sh/'.$sh.'/share/'.$getdownloadlist;
                        $modal_downlink = $countfiles.'/sh/'.$sh.'/share/'.$getdownloadlist;
                    } else {
                        $downlink = 'vfm-admin/vfm-downloader.php?q='.$countfiles.'&sh='.$sh.'&share='.$getdownloadlist;
                        $modal_downlink = $countfiles.'&sh='.$sh.'&share='.$getdownloadlist;
                    }
                    $countfiles++;

                    // Set link to direct file
                    if ($direct_links === true || $extension === 'pdf') {
                        $target = 'target="_blank"';
                    }

                    $imgdata = 'data-ext="'.$extension.'"';
                    $icon = '<a class="btn btn-primary service-btn d-flex align-items-center justify-content-center" href="'.$downlink.'" '.$target.'><div style="width:2rem;"><i class="bi bi-'.$thisicon.'"></i></div></a>';
                    $audiotypes = array(
                        'mp3',
                        'wav',
                        'flac',
                        'aac',
                    );

                    if (in_array($extension, $audiotypes) && $setUp->getConfig('share_playmusic') === true) {
                        $imgdata .= ' data-type="audio"';
                        $icon = '<a type="audio/mp3" id="vfm-audio-share-'.$count.'" class="sm2_button sm2_share btn btn-primary service-btn d-flex align-items-center justify-content-center" href="'.$downlink.'&audio=play">
                            <div style="width:2rem;"><i class="trackload bi bi-arrow-clockwise vfm-spin"></i>
                            <i class="trackpause bi bi-pause-circle"></i>
                            <i class="trackplay bi bi-disc vfm-spin"></i>
                            <i class="trackstop bi bi-play-circle"></i></div></a>';
                    }

                    $imagetypes = array(
                        'jpg',
                        'jpeg',
                        'gif',
                        'png',
                    );

                    $videotypes = array(
                        'mp4',
                        'webm',
                        'ogg',
                    );
                    $typeclass = false;

                    $iconimg = '<div style="width:2rem;"><i class="bi bi-'.$thisicon.'"></i></div>';

                    if ((in_array($extension, $videotypes) && $setUp->getConfig('share_playvideo') === true ) || (in_array($extension, $imagetypes) && $setUp->getConfig('share_thumbnails') === true)) {
                        if (in_array($extension, $imagetypes) && $setUp->getConfig('share_thumbnails') === true) {
                            $typeclass = 'thumb m-0 p-0';
                            // $iconclass = 'bi-eye';
                            $iconimg = '<img style="height:3.5rem; width:3.5rem; max-width:none;" src="'.$imageServer->showThumbnail(base64_decode($pezzo), true).'?in=1">';
                        }
                        if (in_array($extension, $videotypes) && $setUp->getConfig('share_playvideo') === true) {
                            $typeclass = 'vid';
                           // $iconclass = 'bi-play-btn';
                            $iconimg = '<div style="width:2rem"><i class="bi bi-play-btn"></i></div>';
                        }
                        // if (in_array($extension, $videotypes) && $setUp->getConfig('share_playvideo') === true) {
                        $imgdata .= ' data-name="'.$filename.'" data-link="'.$pezzo.'" data-linkencoded="'.$modal_downlink.'"';
                        $icon = '<a '.$imgdata.' class="btn btn-primary '.$typeclass.' vfm-gall service-btn d-flex align-items-center justify-content-center" href="'.$downlink.'">'.$iconimg.'</i></a>';
                    }

                    $download_btn = '<a class="btn btn-primary service-btn d-flex align-items-center justify-content-center" href="'.$downlink.'" '.$target.'><i class="bi bi-download"></i></a>';
                    ?>
                    <div class="col-md-6">
                        <div class="btn-group w-100 mb-4">
                            <?php echo $icon; ?>
                            <a class="btn btn-primary main-btn py-3 d-flex w-100" href="<?php echo $downlink; ?>" <?php echo $target; ?>>
                                <div class="wrap-title">
                                <span class="small overflowed">
                                    <?php echo $filename; ?>
                                </span>
                                </div>
                                <span class="ms-auto small itemsize">
                                    <?php echo $setUp->formatsize($filesize); ?>
                                </span>
                            </a>
                            <?php echo $download_btn; ?>
                        </div>
                    </div>
                    <?php
                }
            } ?>
            </div></div>
            <?php
        }

        // download link time expired
        // or no more file available
        if ($countfiles < 1 || $downloader->checkTime($time, $lifetime) == false) {
            unlink($share_json);
            $expired = true;
        }
    } // END if $passa == true

    if ($passa !== true) { ?>
        <div class="row" id="dwnldpwd">
            <div class="col-sm-4">
            </div>
            <div class="col-sm-4 card">
                <div class="card-body">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);?>">
                <?php
                if (strlen($pass) > 0) {
                    if ($postpass && $passpass !== true) {
                        ?>
                        <script type="text/javascript">
                            var $error2 = $('<div class="alert-wrap container py-4"><div class="nope alert alert-danger alert-dismissible fade show" role="alert">'
                            + ' <?php echo $setUp->getString("wrong_pass"); ?>'
                            + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>');
                            $('#error').append($error2);
                        </script>
                        <?php
                    } ?>
                    <div class="form-group mb-3">
                        <label class="form-label" for="dwnldpwd"><?php echo $setUp->getString("password"); ?></label>
                        <input type="password" name="dwnldpwd" class="form-control" placeholder="******">
                    </div>
                    <?php
                }
                /* ************************ CAPTCHA ************************* */
                if ($setUp->getConfig("show_captcha_download") == true) {
                    $capath = "vfm-admin/";
                    include "vfm-admin/include/captcha.php";
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $passcap !== true) { 
                        ?>
                        <script type="text/javascript">
                            var $error = $('<div class="alert-wrap container py-4"><div class="nope alert alert-danger alert-dismissible fade show" role="alert">'
                            + ' <?php echo $setUp->getString("wrong_captcha"); ?>'
                            + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>');
                            $('#error').append($error);
                        </script>  
                        <?php
                    }
                } ?>
                    <div class="form-group mb-3">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i></button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
            <div class="col-sm-4"></div>
        </div>
        <?php
    }
}

if ($expired === true) { ?>
    <div class="col-12 text-center">
        <a class="btn btn-primary btn-lg" href="./"><?php echo $setUp->getString("link_expired"); ?></a>
    </div>
    <?php
}
