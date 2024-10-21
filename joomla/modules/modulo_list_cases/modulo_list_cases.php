<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Helper\ModuleHelper;

$catid = $params->get('catid');
$db = Factory::getDbo();
$app = Factory::getApplication();

// Obtém os filtros selecionados
$regiao = $app->input->getInt('regiao');
$categoria = $app->input->getInt('categoria');

// Cria a consulta para buscar artigos
$query = $db->getQuery(true)
    ->select('a.id, a.title, a.introtext, a.images, a.catid')
    ->from($db->quoteName('#__content', 'a'))
    ->where($db->quoteName('a.catid') . ' = ' . (int) $catid)
    ->where($db->quoteName('a.state') . ' = 1')
    ->order($db->quoteName('a.created') . ' DESC');

// Aplica filtros de região e categoria se selecionados
if ($regiao) {
    $query->join('LEFT', $db->quoteName('#__fields_values', 'fv') . ' ON a.id = fv.item_id')
          ->where('fv.field_id = (SELECT id FROM #__fields WHERE name = "regiao") AND fv.value = ' . (int) $regiao);
}
if ($categoria) {
    $query->where($db->quoteName('a.catid') . ' = ' . (int) $categoria);
}

$db->setQuery($query);
$cases = $db->loadObjectList();
?>

<section class="listaNoticias">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="filtro">
                    <form method="get" action="">
                        <div class="row justify-content-center align-items-end">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <p class="mb-1">Cases do</p>
                                <select name="regiao" id="regiao" class="form-select" onchange="this.form.submit()">
                                    <option value="">Todos</option>
                                    <option value="88" <?= $regiao == 88 ? 'selected' : '' ?>>Brasil</option>
                                    <option value="89" <?= $regiao == 89 ? 'selected' : '' ?>>Centro-Oeste</option>
                                    <option value="90" <?= $regiao == 90 ? 'selected' : '' ?>>Internacional</option>
                                    <option value="91" <?= $regiao == 91 ? 'selected' : '' ?>>Nordeste</option>
                                    <option value="92" <?= $regiao == 92 ? 'selected' : '' ?>>Norte</option>
                                    <option value="93" <?= $regiao == 93 ? 'selected' : '' ?>>Sudeste</option>
                                    <option value="94" <?= $regiao == 94 ? 'selected' : '' ?>>Sul</option>
                               </select>
                            </div>
                            <!-- Seção de categorias -->
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <p class="mb-1">Categorias</p>
                                <select name="categoria" id="categoria" class="form-select" onchange="this.form.submit()">
                                    <option value="">Todos</option>
                                    <?php foreach ($cases as $case): ?>
                                        <option value="<?= $case->catid ?>" <?= $categoria == $case->catid ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($case->title); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                                <div class="icon_search" onclick="this.form.submit()"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <?php foreach ($cases as $case): ?>
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <div class="boxNoticia">
                        <figure>
                            <a href="<?= Route::_('index.php?option=com_content&view=article&id=' . $case->id); ?>" title="<?= htmlspecialchars($case->title); ?>">
                                <img src="CAMINHO/IMAGEM" alt="<?= htmlspecialchars($case->title); ?>">
                            </a>
                        </figure>
                        <div class="txt">
                            <h3>
                                <a href="<?= Route::_('index.php?option=com_content&view=article&id=' . $case->id); ?>" title="<?= htmlspecialchars($case->title); ?>">
                                    <?= htmlspecialchars($case->title); ?>
                                </a>
                            </h3>
                            <p><?= htmlspecialchars($case->introtext); ?></p>
                        </div>
                        <a href="<?= Route::_('index.php?option=com_content&view=article&id=' . $case->id); ?>" class="btn btSaibaMais">Acessar</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
