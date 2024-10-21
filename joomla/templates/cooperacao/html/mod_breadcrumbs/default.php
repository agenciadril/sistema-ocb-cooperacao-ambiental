<?php
defined('_JEXEC') or die;

?>

<section class="breadcrump">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <p>
                    <?php foreach ($list as $key => $item): ?>
                        <?php if ($key > 0): ?>
                            » <a href="<?php echo $item->link; ?>"><?php echo $item->name; ?></a>
                        <?php else: ?>
                            <a href="<?php echo $item->link; ?>"><?php echo $item->name; ?></a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </p>
            </div>
        </div>
    </div>
</section>

<section class="tituloTopo">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h1><?php echo htmlspecialchars(JFactory::getApplication()->getMenu()->getActive()->title); ?></h1>
            </div>
        </div>
    </div>
</section>
