<?php

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\String\StringHelper; // Adicionado para manipulação de strings

$show_description = $this->params->get('show_description', 1);

if ($show_description) {
    // Prepara a descrição e limita a 400 caracteres
    $description = $this->result->description;

    // Limita a descrição a 400 caracteres
    $description = HTMLHelper::_('string.truncate', $description, 400, true, false);
}

$start_date = '';
if ($this->result->start_date && $this->params->get('show_date', 1)) {
    $start_date = HTMLHelper::_('date', $this->result->start_date, 'd.m.Y \à\s H:i');
}

?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 lat_b_1">
    <div class="titulo">
        <?php if ($start_date) : ?>
            <h5><?php echo $start_date; ?></h5>
        <?php endif; ?>

        <?php if ($this->result->route) : ?>
            <h3><a href="<?php echo Route::_($this->result->route); ?>"><?php echo $this->result->title; ?></a></h3>
        <?php else : ?>
            <h3><?php echo $this->result->title; ?></h3>
        <?php endif; ?>

        <?php if (!empty($this->result->section)) : ?>
            <h4><?php echo $this->result->section; ?></h4>
        <?php endif; ?>
    </div>
    <?php if ($show_description && !empty($description)) : ?>
        <div class="intro">
            <p><?php echo $description; ?></p>
        </div>
    <?php endif; ?>
</div>
