<?php
defined('_JEXEC') or die;

// Acessar informações da categoria
$category = $this->category;
$articles = $this->items;

use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
use Joomla\Component\Content\Site\Helper\RouteHelper;

// Obter o idioma atual
$app = Factory::getApplication();
$languageTag = $app->getLanguage()->getTag();

$db = Factory::getDbo();

// Obtém os filtros selecionados
$regiao = $app->input->getInt('regiao');
$categoria = $app->input->getInt('categoria', $category->id); // Padrão para categoria atual

// Cria a consulta para buscar as subcategorias de "cases"
$subcategoriesQuery = $db->getQuery(true)
    ->select('id, title')
    ->from($db->quoteName('#__categories'))
    ->where($db->quoteName('parent_id') . ' = ' . (int) $category->id)
    ->where($db->quoteName('published') . ' = 1');

$db->setQuery($subcategoriesQuery);
$subcategories = $db->loadObjectList();
?>

<section class="listaNoticias">
    <div class="container">
        <div class="row">
            <?php foreach ($articles as $article): ?>
                <?php
                // Filtra artigos com base no filtro selecionado
                if ($categoria != $category->id && $article->catid != $categoria) {
                    continue;
                }
                if ($regiao) {
                    $query = $db->getQuery(true)
                        ->select('value')
                        ->from('#__fields_values')
                        ->where('item_id = ' . $article->id)
                        ->where('field_id = (SELECT id FROM #__fields WHERE name = "regiao")');
                    $db->setQuery($query);
                    $articleRegion = $db->loadResult();
                    if ($articleRegion != $regiao) {
                        continue;
                    }
                }
                ?>
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 p-2">
                    <div class="boxListCases">
                        <div class="box">
                            <figure>
                                <?php
                                // Gera a URL do artigo utilizando ContentHelperRoute::getArticleRoute()
                                $articleUrl = Route::_(RouteHelper::getArticleRoute($article->id, $article->catid));
                                $images = json_decode($article->images);
                                $imageSrc = $images->image_intro ?: 'URL/IMAGEM/DEFAULT.jpg';
                                ?>
                                <a href="<?= $articleUrl; ?>" title="<?= htmlspecialchars($article->title); ?>">
                                    <img src="<?= htmlspecialchars($imageSrc); ?>" alt="<?= htmlspecialchars($article->title); ?>">
                                </a>
                            </figure>
                            <div class="txt">
                                <h3>
                                    <a href="<?= $articleUrl; ?>" title="<?= htmlspecialchars(strlen($article->title) > 100 ? substr($article->title, 0, 100) . '...' : $article->title); ?>">
                                        <?= htmlspecialchars(strlen($article->title) > 35 ? substr($article->title, 0, 35) . '...' : $article->title); ?>
                                    </a>
                                </h3>
                                <?php 
                                // Limita o texto de introdução a 150 caracteres, removendo tags HTML
                                $introtext = strip_tags($article->introtext);
                                $introtext = strlen($introtext) > 100 ? substr($introtext, 0, 100) . '...' : $introtext;
                                ?>
                                <p><?= htmlspecialchars($introtext); ?></p>
                                <a href="<?= $articleUrl; ?>" class="btn btnaccess"><?php echo ($languageTag == 'pt-BR') ? 'Acessar' : 'Access'; ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
