<?php
// Impede o acesso direto ao arquivo
defined('_JEXEC') or die;

// Importa a classe Joomla Factory
use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;

// Obter o idioma atual
$app = Factory::getApplication();
$languageTag = $app->getLanguage()->getTag();

// Define o ID da categoria com base no idioma
$eventCategoryId = ($languageTag == 'pt-BR') ? 9 : 11; // 9 para "eventos" em Português, 11 para "events" em Inglês

// Define o ID da categoria de eventos
$eventCategoryId = 9; // Apenas eventos da categoria com ID 9

// Seção de Eventos
$db = Factory::getDbo();
// IDs dos campos personalizados no Joomla
$dataEventoFieldId = 1; // ID real do campo "data-evento"
$horaEventoFieldId = 2; //  ID real do campo "hora-evento"
$codigoDoVideo = 17; //  ID real do campo "link-evento"
$dataModalFieldId = 11; //  ID real do campo "data_modal"
$horarioModalFieldId = 12; //  ID real do campo "horario_modal"
$objetivoModalFieldId = 13; // ID real do campo "objetivo_modal"
$composicaoPainelModalFieldId = 18; //  real do campo "composicao_painel_modal_ac"
$participantesModalFieldId = 16; //  ID real do campo "participantes_modal"

// Construindo a query
$query = $db->getQuery(true)
    ->select('a.id, a.title, a.introtext, a.images, c.value as data_evento, c2.value as hora_evento, c3.value as codigo_do_video, c4.value as data_modal, c5.value as horario_modal, c6.value as objetivo_modal, c7.value as composicao_painel_modal_ac, c8.value as participantes_modalf')
    ->from($db->quoteName('#__content', 'a'))
    ->join('LEFT', $db->quoteName('#__fields_values', 'c') . ' ON a.id = c.item_id AND c.field_id = ' . (int) $dataEventoFieldId)
    ->join('LEFT', $db->quoteName('#__fields_values', 'c2') . ' ON a.id = c2.item_id AND c2.field_id = ' . (int) $horaEventoFieldId)
    ->join('LEFT', $db->quoteName('#__fields_values', 'c3') . ' ON a.id = c3.item_id AND c3.field_id = ' . (int) $codigoDoVideo)
    ->join('LEFT', $db->quoteName('#__fields_values', 'c4') . ' ON a.id = c4.item_id AND c4.field_id = ' . (int) $dataModalFieldId)
    ->join('LEFT', $db->quoteName('#__fields_values', 'c5') . ' ON a.id = c5.item_id AND c5.field_id = ' . (int) $horarioModalFieldId)
    ->join('LEFT', $db->quoteName('#__fields_values', 'c6') . ' ON a.id = c6.item_id AND c6.field_id = ' . (int) $objetivoModalFieldId)
    ->join('LEFT', $db->quoteName('#__fields_values', 'c7') . ' ON a.id = c7.item_id AND c7.field_id = ' . (int) $composicaoPainelModalFieldId)
    ->join('LEFT', $db->quoteName('#__fields_values', 'c8') . ' ON a.id = c8.item_id AND c8.field_id = ' . (int) $participantesModalFieldId)
    ->where($db->quoteName('a.catid') . ' = ' . $db->quote($eventCategoryId))
    ->where($db->quoteName('a.state') . ' = 1')
    ->where($db->quoteName('a.language') . ' = ' . $db->quote($languageTag)) // Filtrar pelo idioma ativo
    ->order($db->quoteName('c.value') . ' ASC')
    ->setLimit(8);

// Executando a query
$db->setQuery($query);


$db->setQuery($query);
$events = $db->loadObjectList();



// Seção de Cases de Cooperativas
$cooperativesQuery = $db->getQuery(true)
    ->select('a.id, a.title, a.alias, fv.value as cooperativas_name')
    ->from($db->quoteName('#__content', 'a'))
    ->join('LEFT', $db->quoteName('#__fields_values', 'fv') . ' ON a.id = fv.item_id AND fv.field_id = (SELECT id FROM #__fields WHERE name = "cooperativas-name")')
    ->where('a.catid = 8')
    ->where('a.state = 1')
    ->where('a.featured = 1')
    ->where($db->quoteName('a.language') . ' = ' . $db->quote($languageTag))
    ->order('a.created DESC');

$db->setQuery($cooperativesQuery);
$cooperatives = $db->loadObjectList();

// Obter o idioma atual
$app = Factory::getApplication();
$languageTag = $app->getLanguage()->getTag();

// Definir o ID do manifesto com base no idioma
$manifestoId = ($languageTag == 'en-GB') ? 112 : 110;

// Construir a query com o ID apropriado
$manifestoQuery = $db->getQuery(true)
    ->select('a.title, a.introtext')
    ->from($db->quoteName('#__content', 'a'))
    ->where('a.id = ' . (int) $manifestoId)
    ->where('a.state = 1');
$db->setQuery($manifestoQuery);
$manifesto = $db->loadObject();
?>

<section class="home">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="c29">
                <h2>
                    <span class="d-none d-lg-inline"><?php echo ($languageTag == 'pt-BR') ? 'Coop na COP29' : 'Coop at COP29'; ?></span>
                    <span class="d-lg-none d-inline"><?php echo ($languageTag == 'pt-BR') ? 'Cop 29' : 'Cop 29'; ?></span>
                </h2>
            </div>
        </div>

        <!-- Listagem de Eventos -->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="listaCoops events-slider">
                        <?php if (!empty($events)) : ?>
                            <?php foreach ($events as $event) : ?>
                                <div>
                                    <div class="coop">
                                        <div class="data">
                                            <h3><?php echo $event->data_evento ?></h3>
                                        </div>
                                        <div class="txt">
                                            <?php echo $event->introtext; ?>
                                            <p><strong><?php echo ($languageTag == 'pt-BR') ? 'Horário em Brasília:' : 'Brasília Time:'; ?></strong> <?php echo $event->hora_evento; ?></p>
                                            <div class="group-btn-txt">
                                                <a onclick="openModalEventos(
    '<?php echo $event->introtext; ?>',
    '<?php echo $event->codigo_do_video; ?>',
    '<?php echo $event->data_modal; ?>',
    '<?php echo $event->horario_modal; ?>',
    '<?php echo $event->objetivo_modal; ?>',
    '<?php echo $event->composicao_painel_modal_ac; ?>',
    '<?php echo $event->participantes_modalf; ?>'
)" class="btn">
                                                    <?php echo ($languageTag == 'pt-BR') ? 'SAIBA MAIS' : 'LEARN MORE'; ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cases de Cooperativas -->
        <div class="row mt-86">
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <div class="boxCooperativas">
                    <div class="tit">
                        <h3><?php echo ($languageTag == 'pt-BR') ? 'Cases de cooperativas' : 'Cooperative Cases'; ?></h3>
                    </div>
                    <div class="txt">
                        <p><?php echo ($languageTag == 'pt-BR') ? 'Conheça os cases das cooperativas que estarão nos painéis da COP29' : 'Learn about some cooperative cases working on sustainability.'; ?></p>
                        <ul class="lista">
                            <?php foreach ($cooperatives as $coop): ?>
                                <li><a href="/cases/<?php echo $coop->alias; ?>"><?php echo htmlspecialchars($coop->cooperativas_name); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Manifesto -->
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <div class="boxManifesto">
                    <div class="tit">
                        <h3><?php echo ($languageTag == 'pt-BR') ? 'Manifesto' : 'Manifest'; ?></h3>
                    </div>
                    <div class="txt">
                        <h4><?php echo htmlspecialchars(mb_strimwidth($manifesto->title, 0, 60, '...')); ?></h4>
                        <p><?php echo htmlspecialchars(mb_strimwidth(strip_tags($manifesto->introtext), 0, 350, '...')); ?></p>
                    </div>
                    <div class="veja-mais">
                        <a class="btn btSaibaMaisFine" href="/manifesto"><?php echo ($languageTag == 'pt-BR') ? 'Leia mais' : 'Read more'; ?></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Conheça as Edições Anteriores -->
        <div class="row" id="ant">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <a class="btn btSaibaMais" id="openModalBtn"><?php echo ($languageTag == 'pt-BR') ? 'Conheça as edições anteriores' : 'Learn about previous editions'; ?></a>
            </div>
        </div>
    </div>

    <div id="modal-eventos" class="modal">
    <div class="modal-content">
      <span class="close-btn-ev">
        <img src="/templates/cooperacao/images/bg/x.svg" alt="Fechar">
      </span>
      <p class="title-pa">Painel</p>
      <div id="modal-eventos-content">

      </div>
    </div>
  </div>
</section>

<script>
    // Função para abrir o modal com os parâmetros fornecidos
    function openModalEventos(introText, linkEvento, dataModal, horarioModal, objetivoModal, composicaoPainelModal, participantesModal) {
      const modal = document.getElementById('modal-eventos');
      const contentContainer = document.getElementById('modal-eventos-content');
      const closeModalBtn = document.querySelector(".close-btn-ev");

      // Conteúdo do modal
      contentContainer.innerHTML = `
      
          <div class="intro-text">${introText}</div>
          <p><strong>Data:</strong> ${dataModal}</p>
          <p><strong>Horário:</strong> ${horarioModal}</p>
          <p><strong>Objetivo:</strong> ${objetivoModal}</p>
          <p class="partici"><strong>Composição do Painel:</strong> </p>
          <div class="content-color">
          ${composicaoPainelModal}
          </div>
          ${participantesModal ? `<p class="partici"><strong>Participantes:</strong> </p> <div class="content-color">${participantesModal}</div>` : ''}
          ${linkEvento ? `<iframe class="w-full h-[410px]" src="https://www.youtube.com/embed/${linkEvento}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>` : ''}
      `;

      // Abrir modal
      modal.classList.add("active"); // Adiciona a classe 'active'

      // Fechar modal ao clicar no botão de fechar
      closeModalBtn.addEventListener("click", () => {
        modal.classList.remove("active"); // Remove a classe 'active'
      });

      // Fechar modal ao clicar fora do conteúdo
      window.addEventListener("click", (event) => {
        if (event.target === modal) {
          modal.classList.remove("active");
        }
      });
    }
  </script>
