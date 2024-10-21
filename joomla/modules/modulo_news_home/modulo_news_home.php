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
    ->select('*')
    ->from($db->quoteName('#__content'))
    ->where($db->quoteName('catid') . ' = ' . $db->quote(10))
    ->where($db->quoteName('state') . ' = 1')
    ->where($db->quoteName('language') . ' = ' . $db->quote($languageTag)) // Filtrar pelo idioma atual
    ->order($db->quoteName('created') . ' DESC')
    ->setLimit(8);

$db->setQuery($query);
$articles = $db->loadObjectList();
?>

<div class="">
    <?php if (!empty($articles)) : ?>
        <section class="noticias" id="noticias">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h2><span><?php echo ($languageTag == 'pt-BR') ? 'Notícias' : 'News'; ?></span></h2>
                    </div>
                </div>
                <div class="row">
                    <div class="listaNoticias slider ">
                        <?php foreach ($articles as $article) : ?>
                            <div>
                                <div class="boxNoticia">
                                    <div class="txt">
                                        <?php if (!empty($article->images)) : ?>
                                            <figure>
                                                <a href="<?php echo ($languageTag == 'pt-BR') ? '/noticias/' . $article->alias : '/news/' . $article->alias; ?>"
   title="<?php echo htmlspecialchars($article->title); ?>">
   <img src="<?php echo htmlspecialchars(json_decode($article->images)->image_intro); ?>" alt="<?php echo htmlspecialchars($article->title); ?>">
</a>
                                            </figure>
                                        <?php endif; ?>
                                        <h3>
                                            <a href="/noticias/<?php echo $article->alias; ?>"
                                                title="<?php echo $article->title; ?>">
                                                <?php echo substr(strip_tags($article->title), 0, 30) . '...'; ?>
                                            </a>
                                        </h3>
                                        <p><?php echo substr(strip_tags($article->introtext), 0, 80) . '...'; ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                       <a class="btn btSaibaMais" href="<?php echo ($languageTag == 'pt-BR') ? '/noticias/' : '/news/'; ?>">
    <?php echo ($languageTag == 'pt-BR') ? 'Veja todas as notícias' : 'See all news'; ?>
</a>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
</div>
