<?php
// Impede o acesso direto ao arquivo
defined('_JEXEC') or die;

// Importa a classe Joomla Factory para obter o idioma atual
use Joomla\CMS\Factory;

// Obter o idioma atual
$app = Factory::getApplication();
$languageTag = $app->getLanguage()->getTag();
?>

<section class="banner_cases">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 conteudo">
                <div class="txt">
                    <h1>
                        <?php if ($languageTag == 'pt-BR'): ?>
                            Sua coop tem um <br class="d-lg-none d-block"> bom case?<br>
                            <strong>Envie pra gente!</strong>
                        <?php else: ?>
                            Does your coop have a good case?<br class="d-lg-none d-block">
                            <strong>Send it to us!</strong>
                        <?php endif; ?>
                    </h1>
                    <a href="/" class="btn btEnviarCase">
                        <?php echo ($languageTag == 'pt-BR') ? 'Enviar case' : 'Submit case'; ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
