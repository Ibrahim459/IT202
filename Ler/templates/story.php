<?php
//TODO making it dynamically load boostrap if we're not using the routing sample
if (!isset($container)) {
    require(__DIR__ . "/../bootstrap.php");
}
if(isset($_GET['story'])){
    $story_id = $_GET['story'];
    $story_service = $container->getStories();
    $result = $story_service->get_story($story_id);
    if($result['status'] == 'success'){
        $story = $result['story'];
    }
    else{
        Utils::flash(Utils::get($result, "message") . ": " . Utils::get($result, "errorInfo"));
    }
}
if(isset($_GET["restart"])){
    $user = Utils::getLoggedInUser();
    $user_id = -1;//anonymous user
    if($user) {
        $user_id = $user->getId();
    }
    if($user_id > -1) {
        $history_service = $container->getHistory();
        $result = $history_service->delete_story_progress($user_id, $story_id);
        Utils::flash(Utils::get($result, "message"));
    }
}
?>
<?php if(isset($story) && !empty($story)):?>
<div class="card">
    <div class="card-body">
        <h4 class="card-title">
            <?php Utils::show($story, "title");?>
        </h4>
        <?php include(__DIR__."/../partials/favorite.story.partial.php");?>
        <h6>by <?php Utils::show($story, "username");?></h6>
        <?php
            if(!isset($favorites_service)){
                $favorites_service = $container->getFavorites();
            }
            $result = $favorites_service->get_story_stats($story_id);
            $favs = Utils::get($result, "favorites", 0);
            $act = Utils::get($result, "progress", 0);
        ?>
        <div><i class="fas fa-heart"></i></i>&nbsp;<?php echo $favs;?>&nbsp;
            <i class="fab fa-readme"></i>&nbsp;<?php echo $act;?></div>
        <pre class="card-body" style="overflow: auto;">
            <?php echo htmlspecialchars_decode(Utils::get($story,"summary"));?>
        </pre>
        <footer>
            <a class="btn btn-success"
            href="index.php?arc/view&arc=<?php Utils::show($story, "starting_arc");?>"
            >Begin</a>
        </footer>
    </div>
</div>
<?php else:?>
<div class="alert alert-danger">There was an error loading the story.</div>
<?php endif;?>
