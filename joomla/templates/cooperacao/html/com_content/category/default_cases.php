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

// Obtém os filtros selecionados
$regiao = $app->input->getString('regiao');
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
                <!-- Filtro -->
                <div class="filtro">
                    <form method="get" action="">
                        <div class="row justify-content-center align-items-end">
                            <!-- Filtro por Região -->
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <p class="mb-1"><?php echo ($languageTag == 'pt-BR') ? 'Cases do' : 'Cases from'; ?></p>
                                <select name="regiao" id="regiao" class="form-select" onchange="this.form.submit()">
                                    <option value=""><?php echo ($languageTag == 'pt-BR') ? 'Todos' : 'All'; ?></option>
                                    <option value="Brasil" <?= $regiao == 'Brasil' ? 'selected' : '' ?>>Brasil</option>
                                    <option value="Centro-Oeste" <?= $regiao == 'Centro-Oeste' ? 'selected' : '' ?>><?php echo ($languageTag == 'pt-BR') ? 'Centro-Oeste' : 'Midwest'; ?></option>
                                    <option value="Internacional" <?= $regiao == 'Internacional' ? 'selected' : '' ?>><?php echo ($languageTag == 'pt-BR') ? 'Internacional' : 'International'; ?></option>
                                    <option value="Nordeste" <?= $regiao == 'Nordeste' ? 'selected' : '' ?>><?php echo ($languageTag == 'pt-BR') ? 'Nordeste' : 'Northeast'; ?></option>
                                    <option value="Norte" <?= $regiao == 'Norte' ? 'selected' : '' ?>><?php echo ($languageTag == 'pt-BR') ? 'Norte' : 'North'; ?></option>
                                    <option value="Sudeste" <?= $regiao == 'Sudeste' ? 'selected' : '' ?>><?php echo ($languageTag == 'pt-BR') ? 'Sudeste' : 'Southeast'; ?></option>
                                    <option value="Sul" <?= $regiao == 'Sul' ? 'selected' : '' ?>><?php echo ($languageTag == 'pt-BR') ? 'Sul' : 'South'; ?></option>
                                </select>
                            </div>
                            <!-- Filtro de Categorias -->
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <p class="mb-1"><?php echo ($languageTag == 'pt-BR') ? 'Categorias' : 'Categories'; ?></p>
                                <select name="categoria" id="categoria" class="form-select" onchange="this.form.submit()">
                                    <option value="<?= $category->id ?>" <?= $categoria == $category->id ? 'selected' : '' ?>><?php echo ($languageTag == 'pt-BR') ? 'Todos' : 'All'; ?></option>
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
            </div>
        </div>

        <!-- Listagem de Artigos -->
        <div class="row">
            <?php foreach ($articles as $article): ?>
                <?php
                // Verifica a categoria selecionada no filtro
                if ($categoria != $category->id && $article->catid != $categoria) {
                    continue;
                }

                // Verifica a região selecionada no filtro, se aplicável
                if ($regiao) {
                    $query = $db->getQuery(true)
                        ->select('value')
                        ->from('#__fields_values')
                        ->where('item_id = ' . (int)$article->id)
                        ->where('field_id = (SELECT id FROM #__fields WHERE name = "regiao")');
                    $db->setQuery($query);
                    $articleRegion = $db->loadResult();
                    
                    if ($articleRegion !== $regiao) {
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
                                // Limita o texto de introdução a 150 caracteres
                                $introtext = strip_tags($article->introtext);
                                $introtext = strlen($introtext) > 130 ? substr($introtext, 0, 130) . '...' : $introtext;
                                ?>
                                <p><?= htmlspecialchars($introtext); ?></p>
                                <a href="<?= $articleUrl; ?>" class="btn btnaccess"><?php echo ($languageTag == 'pt-BR') ? 'Acessar' : 'Access'; ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <!-- Fim da Listagem de Artigos -->
    </div>
</section>
