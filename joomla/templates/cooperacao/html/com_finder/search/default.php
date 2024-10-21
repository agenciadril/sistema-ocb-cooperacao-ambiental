<?php

defined('_JEXEC') or die;

$this->document->getWebAssetManager()
    ->useStyle('com_finder.finder')
    ->useScript('com_finder.finder');

?>
<section class="descricaoTopo menuForum listaMenuramos boxBuscaLista">
    <div class="container">
        <?php if ($this->params->get('show_page_heading')) : ?>
            <div class="row">
                <div class="col-lg-12">
                    <h1>
                        <?php if ($this->escape($this->params->get('page_heading'))) : ?>
                            <?php echo $this->escape($this->params->get('page_heading')); ?>
                        <?php else : ?>
                            <?php echo $this->escape($this->params->get('page_title')); ?>
                        <?php endif; ?>
                    </h1>
                </div>
            </div>
        <?php endif; ?>

        <?php // Carrega o layout de resultados de busca se estiver realizando uma busca. ?>
        <?php if ($this->query->search === true) : ?>
            <?php echo $this->loadTemplate('results'); ?>
        <?php endif; ?>
    </div>
</section>