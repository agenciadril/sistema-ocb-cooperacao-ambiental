<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

use Joomla\CMS\Router\Route;

$app       = Factory::getApplication();
$doc       = $app->getDocument();
$menu      = $app->getMenu();
$active    = $menu->getActive();
$sitename  = $app->get('sitename');
$option    = $app->input->getCmd('option', '');
$view      = $app->input->getCmd('view', '');
$id        = $app->input->getInt('id');
$ogImage   = Uri::base() . 'templates/' . $this->template . '/images/default-og-image.jpg'; // Imagem padrão

// Configuração do título
if ($option === 'com_content' && $view === 'article' && $id) {
    // Página de artigo
    $db    = Factory::getDbo();
    $query = $db->getQuery(true)
        ->select('*')
        ->from($db->quoteName('#__content'))
        ->where($db->quoteName('id') . ' = ' . $db->quote($id));
    $db->setQuery($query);
    $article = $db->loadObject();

    if ($article && !empty($article->title)) {
        $title = $article->title . ' - ' . $sitename;
        $doc->setTitle($title);

        // Descrição
        $description = strip_tags($article->introtext);
        if (empty($description)) {
            $description = strip_tags($article->fulltext);
        }

  

        // Imagem do artigo
        $images = json_decode($article->images);
        if (!empty($images->image_intro)) {
            $ogImage = Uri::base() . $images->image_intro;
        } elseif (!empty($images->image_fulltext)) {
            $ogImage = Uri::base() . $images->image_fulltext;
        }
    } else {
        // O artigo não foi encontrado
        $title = $sitename;
        $doc->setTitle($title);
        $description = $sitename;
        $doc->setDescription($description);
    }
} 
else {
    // Outras páginas
    if ($active && !empty($active->title)) {
        $title = $active->title . ' - ' . $sitename;
        $doc->setTitle($title);
    } else {
        $title = $sitename;
        $doc->setTitle($title);
    }
    $description = $doc->getDescription();
    if (empty($description)) {
        $description = $sitename;
    }
}

// Meta Tags Open Graph
$doc->setMetadata('og:title', $doc->getTitle());
$doc->setMetadata('og:description', $description);
$doc->setMetadata('og:image', $ogImage);
$doc->setMetadata('og:type', 'website');
$doc->setMetadata('og:url', Uri::current());
$doc->setMetadata('og:site_name', $sitename);

// Meta Tags do Twitter Card
$doc->setMetadata('twitter:card', 'summary_large_image');
$doc->setMetadata('twitter:title', $doc->getTitle());
$doc->setMetadata('twitter:description', $description);
$doc->setMetadata('twitter:image', $ogImage);

// Obter o idioma atual
$languageTag = $app->getLanguage()->getTag();
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <jdoc:include type="head" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/slick.css" />
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/cases.css" />
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/template.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
    <script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/template.js"></script>
</head>

<body>

    <div>
        <div class="navFixed">
            <div class="barra">
                <div class="container">
                    <div class="row">

                    <?php
                    // Obter o idioma atual
                    $app = Factory::getApplication();
                    $languageTag = $app->getLanguage()->getTag();
                    ?>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <a href="https://www.somoscooperativismo.coop.br/" target="_blank">
                                    <img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/bg/bg_sistema.svg" alt="Sistema" class="lg_sistema">
                                </a>
                                <ul class="lista">
                                    <li>
                                        <a href="https://somos.coop.br/conheca-o-coop" target="_blank" title="<?php echo ($languageTag == 'pt-BR') ? 'Cooperativismo' : 'Cooperativism'; ?>">
                                            <?php echo ($languageTag == 'pt-BR') ? 'Cooperativismo' : 'Cooperativism'; ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.somoscooperativismo.coop.br/solucoes" target="_blank" title="<?php echo ($languageTag == 'pt-BR') ? 'Soluções' : 'Solutions'; ?>">
                                            <?php echo ($languageTag == 'pt-BR') ? 'Soluções' : 'Solutions'; ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.somoscooperativismo.coop.br/contatos" target="_blank" title="<?php echo ($languageTag == 'pt-BR') ? 'Contatos' : 'Contacts'; ?>">
                                            <?php echo ($languageTag == 'pt-BR') ? 'Contatos' : 'Contacts'; ?>
                                        </a>
                                    </li>
                                </ul>
                                <!-- <div class="subMenu">
                                    <a href="#" class="bt_Mais" title="<?php echo ($languageTag == 'pt-BR') ? 'Mais' : 'Plus'; ?>">
                                        <img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/bg/bg_mais.png" alt="<?php echo ($languageTag == 'pt-BR') ? 'Mais' : 'Plus'; ?>" class="bg_mais">
                                    </a>
                                    <ul class="subMenu">
                                        <li>
                                            <a href="#" title="<?php echo ($languageTag == 'pt-BR') ? 'Institucional' : 'Institutional'; ?>">
                                                <?php echo ($languageTag == 'pt-BR') ? 'Institucional' : 'Institutional'; ?>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" title="<?php echo ($languageTag == 'pt-BR') ? 'Contatos' : 'Contacts'; ?>">
                                                <?php echo ($languageTag == 'pt-BR') ? 'Contatos' : 'Contacts'; ?>
                                            </a>
                                        </li>
                                    </ul>
                                </div> -->
                            </div>
                    </div>
                </div>
            </div>

            <header>
                <div class="container">
                    <div class="row">
                        <div class="col-2 col-sm-3 col-md-1 col-lg-3 col-xl-2 col-xxl-2 posicao">
                            <h1><a href="<?php echo $this->baseurl ?>" title="Esg Coop">Esg Coop</a></h1>
                        </div>
                        <div class="col-5 col-sm-9 col-md-2 col-lg-9 col-xl-9 col-xxl-6">
                            <nav>
                                <jdoc:include type="modules" name="menu" />
                            </nav>
                        </div>
                        <div class="col-5 col-sm-9 col-md-2 col-lg-9 col-xl-6 col-xxl-4">
                            <div class="busca">
                              <jdoc:include type="modules" name="busca" />
                                
                            </div>
                            <div class="idiomas">
                                <ul class="listaIdiomas">
                                    <li><a href="/pt/" title="Português"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/bg/b_1.jpg" alt="Português"></a></li>
                                    <li><a href="/en/" title="Inglês"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/bg/b_2.jpg" alt="Inglês"></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
        </div>
        <section class="banner_home">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                        
                        <?php 
                            // Exibir conteúdo dependendo do idioma
                            if ($languageTag == 'pt-BR') {
                                ?>
                                <div class="txt">
                                    <h1>Cooperação Ambiental</h1>
                                    <p>O cooperativismo cuida das pessoas, das comunidades e do meio ambiente.</p>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="txt">
                                    <h1>Environmental Cooperation</h1>
                                    <p>Cooperativism cares for people, communities, and the environment.</p>
                                </div>
                                <?php
                            }
                            ?>
                    </div>
                </div>
            </div>
        </section>
        <div class="">
            <jdoc:include type="modules" name="breadcrumbs" />
        </div>
        <div class="">
            <jdoc:include type="modules" name="title" />
        </div>
        
        
        <div class="">
            <jdoc:include type="modules" name="home" />
        </div>
        
        <!-- Conteúdo Principal -->
        <section id="content">
            <div class="container">
                <jdoc:include type="component" />
            </div>
        </section>
      <jdoc:include type="modules" name="submitcase" />
        <div class="">
            <jdoc:include type="modules" name="footer" />
        </div>
    </div>
    <!-- Modal -->
    <div id="modal" class="modal">
    <div class="modal-content">
        <span class="close-btn">
            <img src="/templates/cooperacao/images/bg/x.svg" alt="">
        </span>
        <div class="ant-card ">
            <div class="ant-card-content">
                <h1 class="title">
                    <?php echo ($languageTag == 'pt-BR') ? 'COOP NA COP28' : 'COOP AT COP28'; ?>
                </h1>
                <p class="text-content">
                    <?php echo ($languageTag == 'pt-BR') 
                        ? 'Realizada no ano de 2023, em Dubai, nos Emirados Árabes Unidos, o Sistema OCB participou de quatro painéis e compartilhou as boas práticas promovidas pelo cooperativismo que reafirmam o protagonismo do movimento na preservação dos recursos naturais e na produção responsável, de forma inclusiva e ambientalmente correta.'
                        : "Held in 2023 in Dubai, United Arab Emirates, the OCB System participated in four panels and shared the best practices promoted by cooperativism, reaffirming the movement's leadership in preserving natural resources and promoting responsible production, in an inclusive and environmentally correct manner."; ?>
                </p>
            </div>
            <div>
                <div class="btns-28">
                    <div class="group-btn-28">
                        <a href="https://www.youtube.com/watch?v=PzA2aqKbXQM" target="_blank">
                            <?php echo ($languageTag == 'pt-BR') ? 'Painel 1' : 'Panel 1'; ?>
                        </a>
                        <p>
                            <?php echo ($languageTag == 'pt-BR') 
                                ? 'Cooperativas: aliadas da sustentabilidade ambiental e segurança alimentar' 
                                : 'Cooperatives: allies for environmental sustainability and food security'; ?>
                        </p>
                    </div>
                    <div class="group-btn-28">
                        <a href="https://www.youtube.com/watch?v=UmH9aLW5thc" target="_blank">
                            <?php echo ($languageTag == 'pt-BR') ? 'Painel 2' : 'Panel 2'; ?>
                        </a>
                        <p>
                            <?php echo ($languageTag == 'pt-BR') 
                                ? 'Plano ABC+ e seu papel na segurança alimentar' 
                                : 'ABC+ Plan and its role in food security'; ?>
                        </p>
                    </div>
                </div>
                <div class="btns-28">
                    <div class="group-btn-28">
                        <a href="https://www.youtube.com/watch?v=OxLSjUZko_8" target="_blank">
                            <?php echo ($languageTag == 'pt-BR') ? 'Painel 3' : 'Panel 3'; ?>
                        </a>
                        <p>
                            <?php echo ($languageTag == 'pt-BR') 
                                ? 'Territórios Indígenas: segurança para o planeta, lar para quem protege' 
                                : 'Indigenous Territories: security for the planet, home for those who protect'; ?>
                        </p>
                    </div>
                    <div class="group-btn-28">
                        <a href="https://www.youtube.com/watch?v=VcgIRnGmln0" target="_blank">
                            <?php echo ($languageTag == 'pt-BR') ? 'Painel 4' : 'Panel 4'; ?>
                        </a>
                        <p>
                            <?php echo ($languageTag == 'pt-BR') 
                                ? 'Trade House Pavilion' 
                                : 'Trade House Pavilion'; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="ant-card mt-69">
            <div class="ant-card-content">
                <h1 class="title">
                    <?php echo ($languageTag == 'pt-BR') ? 'COOP NA COP27' : 'COOP AT COP27'; ?>
                </h1>
                <p class="text-content">
                    <?php echo ($languageTag == 'pt-BR') 
                        ? 'Energias renováveis e neutralidade de carbono são as temáticas do momento quando o assunto é sustentabilidade. Na COP 27, mostramos a atuação das coops agro nessas frentes e os impactos positivos para o meio ambiente.'
                        : 'Renewable energies and carbon neutrality are the trending topics when it comes to sustainability. At COP 27, we showcased the efforts of agro coops in these areas and the positive impacts on the environment.'; ?>
                </p>
            </div>
            <a href="https://www.youtube.com/watch?v=kkJSMe1ynu4" target="_blank">
                <?php echo ($languageTag == 'pt-BR') ? 'ASSISTA AO PAINEL' : 'WATCH THE PANEL'; ?>
            </a>
        </div>
        <div class="ant-card mt-69">
            <div class="ant-card-content">
                <h1 class="title">
                    <?php echo ($languageTag == 'pt-BR') ? 'COOP NA COP26' : 'COOP AT COP26'; ?>
                </h1>
                <p class="text-content">
                    <?php echo ($languageTag == 'pt-BR') 
                        ? 'Práticas sustentáveis têm tudo a ver com o cooperativismo. Fomos até a COP26 para mostrar ao mundo porque somos referência em sustentabilidade. Confira a apresentação da gerente geral da OCB, Fabíola Nader Motta.'
                        : 'Sustainable practices are all about cooperativism. We went to COP26 to show the world why we are a reference in sustainability. Check out the presentation by the OCB general manager, Fabíola Nader Motta.'; ?>
                </p>
            </div>
            <a href="https://cooperacaoambiental.coop.br/wp-content/uploads/2023/11/apresentacao_01_cop26.pptx" target="_blank">
                <?php echo ($languageTag == 'pt-BR') ? 'BAIXE AQUI A APRESENTAÇÃO' : 'DOWNLOAD THE PRESENTATION HERE'; ?>
            </a>
        </div>
    </div>
</div>

    <!-- Incluir o Slick Slider Script -->
    <script>
        jQuery(document).ready(function ($) {
            $('.events-slider').slick({
                infinite: true,
                slidesToShow: 2,
                slidesToScroll: 1,
                dots: true,
                arrows: true,
                responsive: [{
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 500,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
                ]
            });
        });
    </script>
    <!-- Slider JS -->
    <script>
        jQuery(document).ready(function ($) {
            $('.slider').slick({
                infinite: true,
                slidesToShow: 4, // Exibe 4 slides por padrão
                slidesToScroll: 1,
                dots: false,
                arrows: true,
                responsive: [
                    {
                        breakpoint: 768, // Para telas menores que 768px (tablets)
                        settings: {
                            slidesToShow: 3, // Exibe 3 slides
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 500, // Para telas menores que 500px (mobile)
                        settings: {
                            slidesToShow: 2, // Exibe 2 slides
                            slidesToScroll: 1
                        }
                    }
                ]
            });
        });
    </script>
  
   <!-- JavaScript -->
  <script>
    // Seleciona os elementos do modal e botão
    const modal = document.getElementById("modal");
    const openModalBtn = document.getElementById("openModalBtn");
    const closeModalBtn = document.querySelector(".close-btn");

    // Abrir modal
    openModalBtn.addEventListener("click", () => {
      modal.classList.add("active"); // Adiciona a classe 'active'
    });

    // Fechar modal clicando no 'x'
    closeModalBtn.addEventListener("click", () => {
      modal.classList.remove("active"); // Remove a classe 'active'
    });

    // Fechar modal clicando fora do conteúdo do modal
    window.addEventListener("click", (event) => {
      if (event.target === modal) {
        modal.classList.remove("active");
      }
    });

  </script>
</body>

</html>
