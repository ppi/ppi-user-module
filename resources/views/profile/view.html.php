<?php $view->extend('::base.html.php'); ?>

<?php $view['slots']->start('include_css') ?>
<link rel="stylesheet" href="<?php echo $view['assets']->getUrl('user/css/profile.css') ?>" />
<link rel="stylesheet" href="<?php echo $view['assets']->getUrl('css/libs/prettyPhoto.css') ?>" />
<?php $view['slots']->stop(); ?>

<?php $view['slots']->start('include_js_body') ?>
<script src="<?php echo $view['assets']->getUrl('js/libs/jquery.prettyPhoto.js') ?>"></script>
<script src="<?php echo $view['assets']->getUrl('js/libs/soundcloud.api.js') ?>"></script>
<script src="<?php echo $view['assets']->getUrl('user/js/profile.js') ?>"></script>
<?php $view['slots']->stop(); ?>

<div class="container" id="profile-page">
    
    <div class="row">
            
        <div class="span8">
            
            <h1 class="user-name"><?=$view->escape($user->getFullName());?></h1>
            
            <?php if($userMeta->has('job_title')): ?>
            <p class="job-title"><?=$view->escape($userMeta->get('job_title')->getUserValue());?></p>
            <?php endif; ?>
            
            <?php if($userMeta->has('biography')): ?>
            <div class="well user-bio"><?=nl2br($view->escape($userMeta->get('biography')->getUserValue()));?></div>
            <?php endif; ?>

            <?php if ($gallery) : ?>
            <div class="user-pictures">
                <div class="heading"><i class="icon-white icon-picture"></i> Gallery</div>

                <ul class="gallery clearfix">
                    <?php foreach ($gallery as $picture) : ?>
                    <li>
                        <a class="gallery-element picture" href="<?=$view['assets']->getUrl('uploads/gallery/' . $picture->getFileName());?>" alt="<?=$user->getFullName();?>" data-filename='<?=$picture->getFileName();?>' data-fileid='<?=$picture->getId();?>' rel="prettyPhoto[pp_gal]">
                            <img src="<?=$view['assets']->getUrl('uploads/gallery/' . $picture->getFileName());?>" alt="<?=$user->getFullName();?>" />
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>

                <div class="lightbox hide fade" tabindex="-1" role="dialog" aria-hidden='true'>
                    <div class='lightbox-header'>
                        <button type="button" class="close" data-dismiss="lightbox" aria-hidden="true">&times;</button>
                    </div>
                    <div class='lightbox-content'>
                        <img src="" />
                    </div>
                </div>

                <div class="clear"></div>
            </div>
            <?php endif; ?>

            <?php if ($videos) : ?>
            <div class="user-videos">

                <div class="heading"><i class="icon-white icon-facetime-video"></i> Videos</div>

                <?php
                foreach ($videos as $video):
                    parse_str( parse_url($video->getLink(), PHP_URL_QUERY), $vars );
                    $videoID = $vars['v'];
                ?>
                <div class="video">
                    <iframe src="http://www.youtube.com/embed/<?=$videoID;?>" frameborder="0" allowfullscreen></iframe>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="clear"></div>
            <?php endif;?>

            <?php if ($music) : ?>
            <div class="user-music">
                <div class="heading"><i class="icon-white icon-headphones"></i> Music</div>

                <iframe class="iframe"
                        width="100%"
                        height="180"
                        scrolling="no"
                        frameborder="no">
                </iframe>

                <ul class="songs">
                    <?php foreach ($music as $song) : ?>
                        <li><a class="music-element song" href="<?=$song->getLink();?>"><?=$song->getTitle();?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif;?>

        </div>

        <div class="span4 sidebar">
            
            <div class="profile-image">
                <?php if ($avatar) : ?>
                    <img src="<?=$view['assets']->getUrl('uploads/gallery/' . $avatar->getFileName());?>" alt="Avatar of <?=$user->getFullName();?>" />
                <?php endif;?>
            </div>
            
<!--            --><?php //if($userMeta->has('company_name')): ?>
<!--            <p class="company-name">--><?//=$view->escape($userMeta->get('company_name')->getUserValue());?><!--</p>-->
<!--            --><?php //endif; ?>
            
            <?php if($userMeta->has('website')): ?>
            <p class="website"></p>
            <?php endif; ?>
            
            <p class="sidebar-heading">Social Media</p>
            
            <?php if($userMeta->has('twitter')): ?>
            <p class="twitter-handle">
                <a href="http://www.twitter.com/<?=$view->escape($userMeta->get('twitter')->getUserValue());?>"
                   title="@<?=$view->escape($userMeta->get('twitter')->getUserValue());?>"
                   target="_blank"
                   class="btn btn-large">
                    <img src="<?=$view['assets']->getUrl('user/images/twitter-profile-icon.png');?>" alt=""> <?=$view->escape($userMeta->get('twitter')->getUserValue());?>
                    
                    
                    
                </a>
            </p>
            <?php endif; ?>
            
            <?php if($userMeta->has('facebook')): ?>
            <p class="twitter-handle">
                <a href="http://www.facebook.com/<?=$view->escape($userMeta->get('facebook')->getUserValue());?>"
                   title="@<?=$view->escape($userMeta->get('facebook')->getUserValue());?>"
                   target="_blank"
                   class="btn btn-large">
                    <img src="<?=$view['assets']->getUrl('user/images/facebook-profile-icon.png');?>" alt=""> <?=$view->escape($userMeta->get('facebook')->getUserValue());?>
                    
                    
                    
                </a>
            </p>
            <?php endif; ?>
            
        </div>
        
    </div>
        
</div>