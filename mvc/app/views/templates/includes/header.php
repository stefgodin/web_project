<?php
/**
 * @var PageConfig[] $allConfigs
 */
$allConfigs = $_data["configs"];
/**
 * @type User $user
 */
$user = !empty($_SESSION["user"]) ? $_SESSION["user"] : "" ;
if(!empty($user)){
    $this->model("User");
}
?>
<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="<?= GlobalHelper::pageLink("home/index"); ?>">OOZE</a>
</div>
<!-- /.navbar-header -->

<ul class="nav navbar-top-links navbar-right">
    <?php if(empty($user)){ ?>
        <li>
            <a title="<?= $allConfigs["user/login"]->getTitle(); ?>" href="<?= GlobalHelper::pageLink("user/login"); ?>">
                <i class="glyphicon glyphicon-log-in"></i>
            </a>
        </li>
    <?php } else { ?>
        <div>Bonjour <?= $user->getFirstName()," ",$user->getLastName(); ?></div>
        <li>
            <a title="<?= $allConfigs["user/logout"]->getTitle(); ?>" href="<?= GlobalHelper::pageLink("user/logout"); ?>">
                <i class="glyphicon glyphicon-log-out"></i>
            </a>
        </li>
        <li>
            <a title="<?= $allConfigs["user/profile"]->getTitle(); ?>" href="<?= GlobalHelper::pageLink("user/profile"); ?>">
                <i class="glyphicon glyphicon-user"></i>
            </a>
        </li>
    <?php } ?>

    <li>
        <a title="<?= $allConfigs["user/cart"]->getTitle(); ?>" href="<?= GlobalHelper::pageLink("user/cart"); ?>">
            <i class="glyphicon glyphicon-shopping-cart"></i>
        </a>
    </li>
</ul>
<!-- /.navbar-top-links -->