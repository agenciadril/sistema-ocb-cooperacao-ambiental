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
<!-- Ficha Técnica -->
<section class="fichaTecnica">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="box">
                    <div class="titulo">
                        <a href="#" class=""><?php echo ($languageTag == 'pt-BR') ? 'Ficha Técnica' : 'Technical Sheet'; ?></a>
                    </div>
                    <div class="detalhe" id="detalhe_ficha" style="display: none;">
                        <?php foreach ($fichaTecnicaFields as $field): ?>
                            <?php if ($field->name === 'cooperativa'): ?>
                                <p><strong><?php echo ($languageTag == 'pt-BR') ? 'Cooperativa:' : 'Cooperative:'; ?></strong> <?= htmlspecialchars($field->value); ?></p>
                            <?php elseif ($field->name === 'regiao'): ?>
                                <p><strong><?php echo ($languageTag == 'pt-BR') ? 'Região:' : 'Region:'; ?></strong> <?= htmlspecialchars($field->value); ?></p>
                            <?php elseif ($field->name === 'categoria'): ?>
                                <p><strong><?php echo ($languageTag == 'pt-BR') ? 'Categoria:' : 'Category:'; ?></strong> <?= htmlspecialchars($field->value); ?></p>
                            <?php elseif ($field->name === 'acao'): ?>
                                <p><strong><?php echo ($languageTag == 'pt-BR') ? 'Ação:' : 'Action:'; ?></strong> <?= htmlspecialchars($field->value); ?></p>
                            <?php elseif ($field->name === 'ods2'): ?>
                                <p><strong><?php echo ($languageTag == 'pt-BR') ? 'ODSs:' : 'SDGs:'; ?></strong></p>
                                <ul>
                                    <?php foreach (explode("\n", $field->value) as $ods): ?>
                                        <li><?= htmlspecialchars($ods); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php elseif ($field->name === 'resultados'): ?>
                                <p><strong><?php echo ($languageTag == 'pt-BR') ? 'Resultados:' : 'Results:'; ?></strong></p>
                                <ul>
                                    <?php foreach (explode("\n", $field->value) as $resultado): ?>
                                        <li><?= htmlspecialchars($resultado); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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

<!-- Veja Mais -->
<section class="cases casesInterna">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2><span><?php echo ($languageTag == 'pt-BR') ? 'Veja Mais' : 'See More'; ?></span></h2>
            </div>
        </div>
        <div class="row">
            <?php
            // Consulta de artigos relacionados na mesma categoria, excluindo o artigo atual
            $db = Factory::getDbo();
            $query = $db->getQuery(true)
                ->select('a.id, a.title, a.introtext, a.images, a.catid, a.publish_up')
                ->from($db->quoteName('#__content', 'a'))
                ->where($db->quoteName('a.catid') . ' = ' . (int) $this->item->catid)
                ->where($db->quoteName('a.id') . ' != ' . (int) $this->item->id)
                ->where($db->quoteName('a.state') . ' = 1')
                ->order('RAND()')
                ->setLimit(4);

            $db->setQuery($query);
            $relatedArticles = $db->loadObjectList();

            foreach ($relatedArticles as $related) :
                $relatedUrl = Route::_(RouteHelper::getArticleRoute($related->id, $related->catid));
                $relatedDate = JHtml::_('date', $related->publish_up, 'd/m/Y');
                $relatedImages = json_decode($related->images);
                $relatedImageSrc = $relatedImages->image_intro ?: 'URL/IMAGEM/DEFAULT.jpg';
            ?>
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <div class="boxListCases2">
                    <div class="box ">
                        <figure>
                            <a href="<?php echo $relatedUrl; ?>" title="<?php echo htmlspecialchars($related->title); ?>">
                                <img src="<?php echo htmlspecialchars($relatedImageSrc); ?>" alt="">
                            </a>
                        </figure>
                        <div class="txt">
                            <h5><?php echo $relatedDate; ?></h5>
                            <?php 
                            // Limita o título a 60 caracteres, removendo tags HTML
                            $title = strip_tags($related->title);
                            $title = strlen($title) > 60 ? substr($title, 0, 60) . '...' : $title;
                            ?>
                            <h3>
                                <a href="<?php echo $relatedUrl; ?>" title="<?php echo htmlspecialchars($related->title); ?>">
                                    <?php echo htmlspecialchars($title); ?>
                                </a>
                            </h3>
                            <p><?php echo htmlspecialchars(substr(strip_tags($related->introtext), 0, 80)) . '...'; ?></p>
                        </div>
                    </div>    
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
