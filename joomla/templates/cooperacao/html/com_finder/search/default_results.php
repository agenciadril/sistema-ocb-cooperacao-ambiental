<?php

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

?>
<?php
    // Calcula o início e fim dos resultados exibidos
    $start = (int) $this->pagination->limitstart + 1;
    $total = (int) $this->pagination->total;
    $limit = (int) $this->pagination->limit * $this->pagination->pagesCurrent;
    $limit = min($limit, $total);
?>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h2><span><?php echo Text::_('Mostrando resultados para'); ?></span> "<?php echo $this->escape($this->query->input); ?>"</h2>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h5 class="total"><?php echo $total; ?> resultado(s), exibindo <?php echo $start; ?> a <?php echo $limit; ?></h5>
    </div>
</div>

<?php // Mensagem de nenhum resultado encontrado ?>
<?php if (($this->total === 0) || ($this->total === null)) : ?>
    <div id="search-result-empty" class="alert alert-warning">
        <h2><?php echo Text::_('COM_FINDER_SEARCH_NO_RESULTS_HEADING'); ?></h2>
        <?php $multilang = Factory::getApplication()->getLanguageFilter() ? '_MULTILANG' : ''; ?>
        <p><?php echo Text::sprintf('COM_FINDER_SEARCH_NO_RESULTS_BODY' . $multilang, $this->escape($this->query->input)); ?></p>
    </div>
    <?php return; ?>
<?php endif; ?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <?php $this->baseUrl = Uri::getInstance()->toString(['scheme', 'host', 'port']); ?>
            <?php foreach ($this->results as $i => $result) : ?>
                <?php $this->result = &$result; ?>
                <?php $this->result->counter = $i + 1; ?>
                <?php $layout = $this->getLayoutFile($this->result->layout); ?>
                <?php echo $this->loadTemplate($layout); ?>
            <?php endforeach; ?>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <hr>
            </div>
        </div>
    </div>
</div>

<?php // Exibe a paginação ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php if ($this->params->get('show_pagination', 1)) : ?>
            <nav class="paginacao">
                <?php echo $this->pagination->getPagesLinks(); ?>
            </nav>
        <?php endif; ?>
    </div>
</div>
