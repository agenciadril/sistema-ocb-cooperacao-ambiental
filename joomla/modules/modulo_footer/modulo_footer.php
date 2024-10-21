<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory; // Importar a classe Factory do Joomla
// Obter o idioma atual
$app = Factory::getApplication();
$languageTag = $app->getLanguage()->getTag();
?>

<footer>
    <div class="container">
        <div class="acompanhe">
            <p><?php echo ($languageTag == 'pt-BR') ? 'Acompanhe nosso trabalho' : 'Follow our work'; ?></p>
            <div class="redes">
                <img src="/templates/cooperacao/images/bg/Face-1.svg" alt="<?php echo ($languageTag == 'pt-BR') ? 'Facebook' : 'Facebook'; ?>">
                <div class="barra-lat"></div>
                <img src="/templates/cooperacao/images/bg/insta-1.svg" alt="<?php echo ($languageTag == 'pt-BR') ? 'Instagram' : 'Instagram'; ?>">
                <div class="barra-lat"></div>
                <img src="/templates/cooperacao/images/bg/x-1.svg" alt="<?php echo ($languageTag == 'pt-BR') ? 'Twitter' : 'Twitter'; ?>">
                <div class="barra-lat"></div>
                <img src="/templates/cooperacao/images/bg/flickr-1.svg" alt="<?php echo ($languageTag == 'pt-BR') ? 'Flickr' : 'Flickr'; ?>">
                <div class="barra-lat"></div>
                <img src="/templates/cooperacao/images/bg/likedin-1.svg" alt="<?php echo ($languageTag == 'pt-BR') ? 'LinkedIn' : 'LinkedIn'; ?>">
                <div class="barra-lat"></div>
                <img src="/templates/cooperacao/images/bg/youtube-1.svg" alt="<?php echo ($languageTag == 'pt-BR') ? 'YouTube' : 'YouTube'; ?>">
                <div class="barra-lat"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-4 col-md-12 col-sm-12 col-xs-12">
                <div class="links">
                    <h3 class="pai"><?php echo ($languageTag == 'pt-BR') ? 'Home' : 'Home'; ?></h3>
                    <ul>
                        <li class="filho"><a href="/#c29" title="<?php echo ($languageTag == 'pt-BR') ? 'Cop 29' : 'Cop 29'; ?>"><?php echo ($languageTag == 'pt-BR') ? 'Cop 29' : 'Cop 29'; ?></a></li>
                        <li class="filho"><a href="/#cases" title="<?php echo ($languageTag == 'pt-BR') ? 'Cases' : 'Cases'; ?>"><?php echo ($languageTag == 'pt-BR') ? 'Cases' : 'Cases'; ?></a></li>
                        <li class="filho"><a href="/#noticias" title="<?php echo ($languageTag == 'pt-BR') ? 'Notícias' : 'News'; ?>"><?php echo ($languageTag == 'pt-BR') ? 'Notícias' : 'News'; ?></a></li>
                        <li class="filho"><a href="/#ant" title="<?php echo ($languageTag == 'pt-BR') ? 'Conheça edições anteriores' : 'Know previous editions'; ?>"><?php echo ($languageTag == 'pt-BR') ? 'Conheça edições anteriores' : 'Know previous editions'; ?></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-3 col-md-12 col-sm-12 col-xs-12">
                <div class="links">
                    <h3 class="pai"><?php echo ($languageTag == 'pt-BR') ? 'Manifesto' : 'Manifest'; ?></h3>
                    <ul>
                        <li class="filho">
    <a href="<?php echo ($languageTag == 'pt-BR') ? '/manifesto' : '/manifest'; ?>" 
       title="<?php echo ($languageTag == 'pt-BR') ? 'Carta aberta COP28' : 'Open letter COP28'; ?>">
        <?php echo ($languageTag == 'pt-BR') ? 'Carta aberta COP28' : 'Open letter COP28'; ?>
    </a>
</li>

                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-2 col-md-12 col-sm-12 col-xs-12">
                <div class="links">
                    <h3 class="pai"><a href="/cases" title="<?php echo ($languageTag == 'pt-BR') ? 'Cases' : 'Cases'; ?>"><?php echo ($languageTag == 'pt-BR') ? 'Cases' : 'Cases'; ?></a></h3>
                </div>
            </div>
            <div class="col-lg-3 col-2 col-md-12 col-sm-12 col-xs-12">
                <div class="links">
                    <h3 class="pai"><a href="/noticias" title="<?php echo ($languageTag == 'pt-BR') ? 'Notícias' : 'News'; ?>"><?php echo ($languageTag == 'pt-BR') ? 'Notícias' : 'News'; ?></a></h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 d-lg-block d-none">
                <div class="logos_1">
                    <img src="/templates/cooperacao/images/bg/logo-ocb-1.svg" alt="<?php echo ($languageTag == 'pt-BR') ? 'Somos coop' : 'We are coop'; ?>" class="logos_1">
                    <div class="redes">
                        <ul class="redes">
                            <li><a href="https://www.facebook.com/somoscoop" target="_blank" class="redes" title="Facebook"><img src="/templates/cooperacao/images/bg/facebook.svg" class="rede"></a></li>
                            <li><a href="https://www.flickr.com/photos/sistemaocb/" target="_blank" class="redes" title="Flickr"><img src="/templates/cooperacao/images/bg/flickr-1-mob.svg" class="rede"></a></li>
                            <li><a href="https://www.youtube.com/@SomosCoop" target="_blank" class="redes" title="YouTube"><img src="/templates/cooperacao/images/bg/youtube.svg" class="rede"></a></li>
                            <li><a href="https://www.instagram.com/sistemaocb" target="_blank" class="redes" title="Instagram"><img src="/templates/cooperacao/images/bg/instagram.svg" class="rede"></a></li>
                            <li><a href="https://www.instagram.com/sistemaocb" target="_blank" class="redes" title="LinkedIn"><img src="/templates/cooperacao/images/bg/likedin-1-mob.svg" class="rede"></a></li>
                        </ul>
                    </div>
                </div>
                <div class="logos">
                    <img src="/templates/cooperacao/images/bg/somos_coop.svg" class="logos_2" alt="<?php echo ($languageTag == 'pt-BR') ? 'Somos coop' : 'We are coop'; ?>">
                    <div class="redes">
                        <ul class="redes">
                            <li><a href="https://www.instagram.com/somoscoop" target="_blank" class="redes" title="Instagram"><img src="/templates/cooperacao/images/bg/instagram.svg" class="rede"></a></li>
                            <li><a href="https://www.youtube.com/@SomosCoop" target="_blank" class="redes" title="YouTube"><img src="/templates/cooperacao/images/bg/youtube.svg" class="rede"></a></li>
                            <li><a href="https://www.tiktok.com/@somoscoop" target="_blank" class="redes" title="TikTok"><img src="/templates/cooperacao/images/bg/tiktok.svg" class="rede"></a></li>
                            <li><a href="https://open.spotify.com/user/31ptfugxqjt2o2l262ebziye72ra?si=3be5fcfcd5374ab1" target="_blank" class="redes" title="Spotify"><img src="/templates/cooperacao/images/bg/spotify.svg" class="rede"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 meio d-lg-block d-none">
                <address><?php echo ($languageTag == 'pt-BR') ? 'Sistema OCB © Todos os direitos reservados.' : 'Sistema OCB © All rights reserved.'; ?></address>
            </div>
            <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 d-lg-block d-none">
                <img src="/templates/cooperacao/images/bg/coop-logo.svg" alt="Coop" class="logos_2">
            </div>
        </div>
        <div class="text-b d-lg-none d-block">
            <p><?php echo ($languageTag == 'pt-BR') ? 'Sistema OCB © Todos os direitos reservados.' : 'Sistema OCB © All rights reserved.'; ?></p>
        </div>
    </div>
</footer>
