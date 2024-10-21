<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
use Joomla\Component\Content\Site\Helper\RouteHelper;

$doc = Factory::getDocument();
$doc->addStyleSheet(JUri::base() . 'templates/' . $this->template . '/css/custom-article.css'); // Adicione seu CSS personalizado
?>

<!-- Título e Conteúdo do Artigo -->
<section class="manifesto">
    <div class="container">
      <div class="titulo">
                                <h1><?php echo $this->item->title; ?></h1>
                               
                            </div>
        <article>
        <?php if (!empty($this->item->images->image_fulltext)) : ?>
            <figure>
                <img src="<?php echo $this->item->images->image_fulltext; ?>" alt="<?php echo htmlspecialchars($this->item->title); ?>">
            </figure>
        <?php endif; ?>
        <div class="artigo-conteudo">
            <?php echo $this->item->text; ?>
        </div>
        </article>
        
    </div>
</section>
