<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
use Joomla\Component\Content\Site\Helper\RouteHelper;

// Obter o idioma atual
$app = Factory::getApplication();
$languageTag = $app->getLanguage()->getTag();

$doc = Factory::getDocument();
$doc->addStyleSheet(JUri::base() . 'templates/' . $this->template . '/css/custom-article.css'); // Adicione seu CSS personalizado

// Acessa os campos personalizados do artigo e filtra os do grupo "Ficha Técnica"
$fichaTecnicaFields = array_filter($this->item->jcfields, function($field) {
    return $field->group_title === 'Ficha Técnica'; // Ajuste o nome para o título exato do seu grupo
});

?>

<!-- Título e Conteúdo do Artigo -->
<section class="manifesto casesDetalhe">
    <div class="container">
        <div class="titulo">
            <h1><?php echo $this->item->title; ?></h1>
            <h5><?php echo ($languageTag == 'pt-BR') ? 'Por' : 'By'; ?> <?php echo $this->item->author; ?>, <?php echo JHtml::_('date', $this->item->publish_up, 'd/m/Y H:i'); ?></h5>
        </div>
        <article>
            <?php 
            $images = json_decode($this->item->images);
            $imageSrc = $images->image_intro;
            ?>
            <?php if (!empty($imageSrc)) : ?>
                <figure>
                    <img src="<?php echo $imageSrc; ?>" alt="<?php echo htmlspecialchars($this->item->title); ?>">
                </figure>
            <?php endif; ?>
            <div class="artigo-conteudo">
                <?php echo $this->item->text; ?>
            </div>
        </article>
    </div>
</section>
