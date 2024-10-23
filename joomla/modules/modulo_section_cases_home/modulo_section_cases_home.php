<?php

// Impede o acesso direto ao arquivo
defined('_JEXEC') or die;

// Importa a classe Joomla Factory
use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;

// Obter o idioma atual
$app = Factory::getApplication();
$languageTag = $app->getLanguage()->getTag();

$db = Factory::getDbo();

$query = $db->getQuery(true)
    ->select('id, title, introtext, images, alias, created')
    ->from($db->quoteName('#__content'))
    ->where($db->quoteName('catid') . ' = ' . $db->quote(8))
    ->where($db->quoteName('state') . ' = 1')
    ->where($db->quoteName('language') . ' = ' . $db->quote($languageTag)) // Filtro para o idioma atual
    ->order($db->quoteName('created') . ' DESC') // Ordena pela data de criação de forma decrescente
    ->setLimit(4);

$db->setQuery($query);
$items = $db->loadObjectList();
if (!empty($items)) : ?>

    <section class="cases casesHome" id="cases">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h2><span><?php echo ($languageTag == 'pt-BR') ? 'CASES' : 'CASES'; ?></span></h2>
                </div>
            </div>
            <div class="row m-0">
                <div class="row m-0">
                    <!-- Card grande -->
                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 col-12 p-0 px-lg-2">
                        <div class="destaque">
                            <div class="txt">
                                <h5><?php echo substr(strip_tags($items[0]->title), 0, 50) . '...'; ?></h5>
                                <h3><a href="/cases/<?php echo $items[0]->alias; ?>">
                                        <?php echo substr(strip_tags($items[0]->introtext), 0, 50) . '...'; ?></a></h3>
                            </div>
                            <?php if (!empty($items[0]->images)) : ?>
                                <figure><img src="<?php echo json_decode($items[0]->images)->image_intro; ?>" alt="<?php echo $items[0]->title; ?>"></figure>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 d-none d-lg-block">
                        <div class="noticia">
                            <figure><a href="<?php echo Route::_('index.php?option=com_content&view=article&catid=8&alias=' . $items[1]->alias); ?>" title="<?php echo substr(strip_tags($items[1]->introtext), 0, 50) . '...'; ?>"><img src="<?php echo json_decode($items[1]->images)->image_intro; ?>" alt=""></a></figure>
                            <h5><?php echo date('d/m/Y', strtotime($items[1]->created)); ?></h5>
                            <h3><a href="/cases/<?php echo $items[1]->alias; ?>" title="<?php echo substr(strip_tags($items[1]->introtext), 0, 50) . '...'; ?>">
                                    <?php echo substr(strip_tags($items[1]->title), 0, 30) . '...'; ?>
                                </a></h3>
                            <p><?php echo substr(strip_tags($items[1]->introtext), 0, 100) . '...'; ?></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php for ($i = 2; $i < 4; $i++) : ?>
                        <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                            <div class="noticia modelo_2">
                                <figure><a href="<?php echo Route::_('index.php?option=com_content&view=article&catid=8&alias=' . $items[$i]->alias); ?>" title="<?php echo substr(strip_tags($items[$i]->introtext), 0, 50) . '...'; ?>"><img src="<?php echo json_decode($items[$i]->images)->image_intro; ?>" alt=""></a></figure>
                                <h5><?php echo date('d/m/Y', strtotime($items[$i]->created)); ?></h5>
                                <h3><a href="/cases/<?php echo $items[$i]->alias; ?>" title="<?php echo substr(strip_tags($items[$i]->introtext), 0, 50) . '...'; ?>">
                                        <?php echo substr(strip_tags($items[$i]->title), 0, 20) . '...'; ?></a></h3>
                                <p><?php echo substr(strip_tags($items[$i]->introtext), 0, 70) . '...'; ?></p>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <a class="btn btSaibaMais" href="/cases/"><?php echo ($languageTag == 'pt-BR') ? 'Veja mais cases' : 'See more cases'; ?></a>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
