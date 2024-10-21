<?php
// Impede o acesso direto ao arquivo
defined('_JEXEC') or die;

// Importa a classe Joomla Factory
use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;

// Obter o idioma atual
$app = Factory::getApplication();
$languageTag = $app->getLanguage()->getTag();

// Define o ID da categoria com base no idioma
$eventCategoryId = ($languageTag == 'pt-BR') ? 9 : 11; // 9 para "eventos" em Português, 11 para "events" em Inglês

// Define o ID da categoria de eventos
$eventCategoryId = 9; // Apenas eventos da categoria com ID 9

// Seção de Eventos
$db = Factory::getDbo();
$query = $db->getQuery(true)
    ->select('a.id, a.title, a.introtext, a.images, c.value as data_evento, c2.value as hora_evento, c3.value as link_evento')
    ->from($db->quoteName('#__content', 'a'))
    ->join('LEFT', $db->quoteName('#__fields_values', 'c') . ' ON a.id = c.item_id AND c.field_id = (SELECT id FROM #__fields WHERE name = "data-evento")')
    ->join('LEFT', $db->quoteName('#__fields_values', 'c2') . ' ON a.id = c2.item_id AND c2.field_id = (SELECT id FROM #__fields WHERE name = "hora-evento")')
    ->join('LEFT', $db->quoteName('#__fields_values', 'c3') . ' ON a.id = c3.item_id AND c3.field_id = (SELECT id FROM #__fields WHERE name = "link-evento")')
    ->where($db->quoteName('a.catid') . ' = ' . $db->quote($eventCategoryId))
    ->where($db->quoteName('a.state') . ' = 1')
    ->where($db->quoteName('a.language') . ' = ' . $db->quote($languageTag)) // Filtrar pelo idioma ativo
    ->order($db->quoteName('c.value') . ' ASC')
    ->setLimit(8);

$db->setQuery($query);
$events = $db->loadObjectList();


// Seção de Cases de Cooperativas
$cooperativesQuery = $db->getQuery(true)
    ->select('a.id, a.title, a.alias, fv.value as cooperativas_name')
    ->from($db->quoteName('#__content', 'a'))
    ->join('LEFT', $db->quoteName('#__fields_values', 'fv') . ' ON a.id = fv.item_id AND fv.field_id = (SELECT id FROM #__fields WHERE name = "cooperativas-name")')
    ->where('a.catid = 8')
    ->where('a.state = 1')
    ->where('a.featured = 1')
    ->where($db->quoteName('a.language') . ' = ' . $db->quote($languageTag))
    ->order('a.created DESC');

$db->setQuery($cooperativesQuery);
$cooperatives = $db->loadObjectList();

// Obter o idioma atual
$app = Factory::getApplication();
$languageTag = $app->getLanguage()->getTag();

// Definir o ID do manifesto com base no idioma
$manifestoId = ($languageTag == 'en-GB') ? 112 : 110;

// Construir a query com o ID apropriado
$manifestoQuery = $db->getQuery(true)
    ->select('a.title, a.introtext')
    ->from($db->quoteName('#__content', 'a'))
    ->where('a.id = ' . (int) $manifestoId)
    ->where('a.state = 1');
$db->setQuery($manifestoQuery);
$manifesto = $db->loadObject();
?>

<section class="home">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="c29">
                <h2>
                    <span class="d-none d-lg-inline"><?php echo ($languageTag == 'pt-BR') ? 'Coop na Cop29' : 'Coop at Cop29'; ?></span>
                    <span class="d-lg-none d-inline"><?php echo ($languageTag == 'pt-BR') ? 'Cop 29' : 'Cop 29'; ?></span>
                </h2>
            </div>
        </div>

        <!-- Listagem de Eventos -->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="listaCoops events-slider">
                        <?php if (!empty($events)) : ?>
                            <?php foreach ($events as $event) : ?>
                                <div>
                                    <div class="coop">
                                        <div class="data">
                                            <h3><?php echo $event->data_evento ?></h3>
                                            <h4><?php echo $event->title; ?></h4>
                                            <a href="<?php echo $event->link_evento ? $event->link_evento : Route::_('index.php?option=com_content&view=article&id=' . $event->id); ?>" class="btn">
                                                <?php echo ($languageTag == 'pt-BR') ? 'ACESSE' : 'ACCESS'; ?>
                                            </a>
                                        </div>
                                        <div class="txt">
                                            <p><?php echo $event->introtext; ?></p>
                                            <p><strong><?php echo ($languageTag == 'pt-BR') ? 'Horário em Brasília:' : 'Brasília Time:'; ?></strong> <?php echo $event->hora_evento; ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cases de Cooperativas -->
        <div class="row mt-86">
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <div class="boxCooperativas">
                    <div class="tit">
                        <h3><?php echo ($languageTag == 'pt-BR') ? 'Cases de cooperativas' : 'Cooperative Cases'; ?></h3>
                    </div>
                    <div class="txt">
                        <p><?php echo ($languageTag == 'pt-BR') ? 'Conheça os cases das cooperativas que estarão nos painéis da Cop29' : 'Learn about some cooperative cases working on sustainability.'; ?></p>
                        <ul class="lista">
                            <?php foreach ($cooperatives as $coop): ?>
                                <li><a href="/cases/<?php echo $coop->alias; ?>"><?php echo htmlspecialchars($coop->cooperativas_name); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="veja-mais">
                        <a class="btn btSaibaMaisFine" href="/cases/"><?php echo ($languageTag == 'pt-BR') ? 'Veja mais cases' : 'See more cases'; ?></a>
                    </div>
                </div>
            </div>

            <!-- Manifesto -->
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <div class="boxManifesto">
                    <div class="tit">
                        <h3><?php echo ($languageTag == 'pt-BR') ? 'Manifesto' : 'Manifest'; ?></h3>
                    </div>
                    <div class="txt">
                        <h4><?php echo htmlspecialchars(mb_strimwidth($manifesto->title, 0, 60, '...')); ?></h4>
                        <p><?php echo htmlspecialchars(mb_strimwidth(strip_tags($manifesto->introtext), 0, 350, '...')); ?></p>
                    </div>
                    <div class="veja-mais">
                        <a class="btn btSaibaMaisFine" href="/manifesto"><?php echo ($languageTag == 'pt-BR') ? 'Leia mais' : 'Read more'; ?></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Conheça as Edições Anteriores -->
        <div class="row" id="ant">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <a class="btn btSaibaMais" id="openModalBtn"><?php echo ($languageTag == 'pt-BR') ? 'Conheça as edições anteriores' : 'Learn about previous editions'; ?></a>
            </div>
        </div>
    </div>
</section>
