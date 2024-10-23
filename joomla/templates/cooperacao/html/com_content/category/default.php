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
$regiao = $app->input->getString('regiao');
$categoriaUnica = $app->input->getString('categoriaUnica');
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

// Cria arrays vazios para armazenar as regiões e categorias únicas
$regioesUnicas = [];
$categoriasUnicas = [];

// Preenche os arrays de regiões e categorias antes de aplicar filtros aos artigos
foreach ($filteredArticles as $article): ?>
    <?php
    // Recupera os campos "Região" e "Categoria" da ficha técnica
    $fichaTecnicaQuery = $db->getQuery(true)
        ->select('f.value, fld.title')
        ->from($db->quoteName('#__fields_values', 'f'))
        ->join('LEFT', $db->quoteName('#__fields', 'fld') . ' ON fld.id = f.field_id')
        ->where('f.item_id = ' . (int) $article->id)
        ->where('fld.title IN ("Região", "Categoria")'); // Filtra por "Região" e "Categoria"

    $db->setQuery($fichaTecnicaQuery);
    $fichaTecnicaResults = $db->loadObjectList();

    // Percorre os resultados e armazena os valores de Região e Categoria
    foreach ($fichaTecnicaResults as $field) {
        if ($field->title === 'Região' && !in_array($field->value, $regioesUnicas)) {
            // Adiciona o valor da Região ao array se for único
            $regioesUnicas[] = $field->value;
        }
        if ($field->title === 'Categoria' && !in_array($field->value, $categoriasUnicas)) {
            // Adiciona o valor da Categoria ao array se for único
            $categoriasUnicas[] = $field->value;
        }
    }
    ?>
<?php endforeach; ?>

<?php
// Agora filtra os artigos com base nos filtros selecionados
$filteredArticles = array_filter($filteredArticles, function($article) use ($regiao, $categoriaUnica, $categoria, $db) {
    // Filtra artigos com base no filtro de região
    if ($regiao) {
        $query = $db->getQuery(true)
            ->select('value')
            ->from('#__fields_values')
            ->where('item_id = ' . (int) $article->id)
            ->where('field_id = (SELECT id FROM #__fields WHERE name = "regiao")');
        $db->setQuery($query);
        $articleRegion = $db->loadResult();
        if ($articleRegion != $regiao) {
            return false; // Exclui o artigo se a região não bater
        }
    }

    // Filtra artigos com base no filtro de categoriaUnica (ficha técnica)
    if ($categoriaUnica) {
        $query = $db->getQuery(true)
            ->select('value')
            ->from('#__fields_values')
            ->where('item_id = ' . (int) $article->id)
            ->where('field_id = (SELECT id FROM #__fields WHERE name = "categoria")');
        $db->setQuery($query);
        $articleCategoria = $db->loadResult();
        if ($articleCategoria != $categoriaUnica) {
            return false; // Exclui o artigo se a categoria não bater
        }
    }

    // Filtra artigos com base no filtro de categoria (categoria padrão)
    if ($categoria && $article->catid != $categoria) {
        return false; // Exclui o artigo se a categoria não bater
    }

    return true; // Inclui o artigo se passar pelos filtros
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
                                    <select name="regiao" id="regiao" class="form-select" >
                                        <option value=""><?php echo ($languageTag == 'pt-BR') ? 'Todos' : 'All'; ?></option>
                                        <?php foreach ($regioesUnicas as $regiaoUnica): ?>
                                            <option value="<?= htmlspecialchars($regiaoUnica); ?>" <?= $regiao == $regiaoUnica ? 'selected' : '' ?>>
                                                <?php echo htmlspecialchars($regiaoUnica); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <!-- Filtro de categorias -->
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <p class="mb-1"><?php echo ($languageTag == 'pt-BR') ? 'Categorias' : 'Categories'; ?></p>
                                    <select name="categoriaUnica" id="categoria" class="form-select" >
                                        <option value=""><?php echo ($languageTag == 'pt-BR') ? 'Todos' : 'All'; ?></option>
                                        <?php foreach ($categoriasUnicas as $catUnica): ?>
                                            <option value="<?= htmlspecialchars($catUnica); ?>" <?= $categoriaUnica == $catUnica ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($catUnica); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                                    <button class="icon_search" onclick="this.form.submit()"></button>
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
