<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
use Joomla\Component\Content\Site\Helper\RouteHelper;

// Obter o idioma atual
$app = Factory::getApplication();
$languageTag = $app->getLanguage()->getTag();

// Acessar informações da categoria
$category = $this->category;
$articles = $this->items;
$db = Factory::getDbo();

// Define o ID da categoria "cases"
$caseCategoryId = 8;

// Obtém os filtros selecionados
$regiao = $app->input->getInt('regiao');
$categoria = $app->input->getInt('categoria', $category->id); // Padrão para categoria atual

// Cria a consulta para buscar as subcategorias no idioma atual
$subcategoriesQuery = $db->getQuery(true)
    ->select($db->quoteName(['id', 'title']))
    ->from($db->quoteName('#__categories'))
    ->where($db->quoteName('parent_id') . ' = ' . (int) $category->id)
    ->where($db->quoteName('published') . ' = 1')
    ->where($db->quoteName('language') . ' = ' . $db->quote($languageTag)); // Filtrar pelo idioma atual

$db->setQuery($subcategoriesQuery);
$subcategories = $db->loadObjectList();

// Filtrar artigos no idioma atual
$filteredArticles = array_filter($articles, function($article) use ($languageTag) {
    return $article->language === $languageTag || $article->language === '*'; // Inclui artigos no idioma ativo ou em todos os idiomas
});
?>

<section class="listaNoticias">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!-- Verifica se a categoria atual é "cases" -->
                <?php if ($category->id == $caseCategoryId): ?>
                    <!-- Filtro -->
                    <div class="filtro">
                        <form method="get" action="">
                            <div class="row justify-content-center align-items-end">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <p class="mb-1"><?php echo ($languageTag == 'pt-BR') ? 'Cases do' : 'Cases from'; ?></p>
                                    <select name="regiao" id="regiao" class="form-select" onchange="this.form.submit()">
                                        <option value=""><?php echo ($languageTag == 'pt-BR') ? 'Todos' : 'All'; ?></option>
                                        <option value="88" <?= $regiao == 88 ? 'selected' : '' ?>><?php echo ($languageTag == 'pt-BR') ? 'Brasil' : 'Brazil'; ?></option>
                                        <option value="89" <?= $regiao == 89 ? 'selected' : '' ?>><?php echo ($languageTag == 'pt-BR') ? 'Centro-Oeste' : 'Midwest'; ?></option>
                                        <option value="90" <?= $regiao == 90 ? 'selected' : '' ?>><?php echo ($languageTag == 'pt-BR') ? 'Internacional' : 'International'; ?></option>
                                        <option value="91" <?= $regiao == 91 ? 'selected' : '' ?>><?php echo ($languageTag == 'pt-BR') ? 'Nordeste' : 'Northeast'; ?></option>
                                        <option value="92" <?= $regiao == 92 ? 'selected' : '' ?>><?php echo ($languageTag == 'pt-BR') ? 'Norte' : 'North'; ?></option>
                                        <option value="93" <?= $regiao == 93 ? 'selected' : '' ?>><?php echo ($languageTag == 'pt-BR') ? 'Sudeste' : 'Southeast'; ?></option>
                                        <option value="94" <?= $regiao == 94 ? 'selected' : '' ?>><?php echo ($languageTag == 'pt-BR') ? 'Sul' : 'South'; ?></option>
                                    </select>
                                </div>
                                <!-- Filtro de categorias -->
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <p class="mb-1"><?php echo ($languageTag == 'pt-BR') ? 'Categorias' : 'Categories'; ?></p>
                                    <select name="categoria" id="categoria" class="form-select" onchange="this.form.submit()">
                                        <option value="<?= $category->id ?>" <?= $categoria == $category->id ? 'selected' : '' ?>>
                                            <?php echo ($languageTag == 'pt-BR') ? 'Todos' : 'All'; ?>
                                        </option>
                                        <?php foreach ($subcategories as $subcategory): ?>
                                            <option value="<?= $subcategory->id ?>" <?= $categoria == $subcategory->id ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($subcategory->title); ?>
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
                    <!-- Fim do Filtro -->
                <?php endif; ?>
            </div>
        </div>

        <div class="row">
            <?php foreach ($filteredArticles as $article): ?>
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
                                    <a href="<?= $articleUrl; ?>" title="<?= htmlspecialchars($article->title); ?>">
                                        <?= htmlspecialchars($article->title); ?>
                                    </a>
                                </h3>
                                <?php 
                                // Limita o texto de introdução a 150 caracteres, removendo tags HTML
                                $introtext = strip_tags($article->introtext);
                                $introtext = strlen($introtext) > 150 ? substr($introtext, 0, 150) . '...' : $introtext;
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
