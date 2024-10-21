<?php
defined('_JEXEC') or die;

// Acessar informações da categoria
$category = $this->category;
$articles = $this->items;
?>

<section class="listaNoticias">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h1><?php echo $category->title; ?></h1>
                <p><?php echo $category->description; ?></p>
            </div>
        </div>

        <div class="row">
            <?php foreach ($articles as $article): ?>
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 p-2">
                    <div class="boxListCases">
                        <div class="box">
                            <figure>
                                <?php
                                // Gera a URL do artigo utilizando ContentHelperRoute::getArticleRoute()
                                $articleUrl = JRoute::_(ContentHelperRoute::getArticleRoute($article->id, $article->catid));
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
                                <a href="<?= $articleUrl; ?>" class="btn btnaccess">Acessar</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
