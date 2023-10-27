<?php
include_once'head.php';

if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    $data = json_decode(file_get_contents("http://localhost/API/$id"));?>
    <div class="container">
        <div class="row">
            <div class="card" style="width: 18rem;">
                <div class="card-header">
                    <?=$data->modelo?>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><?=$data->marca?></li>
                    <li class="list-group-item"><?=$data->modelo?></li>
                    <li class="list-group-item"><img src=<?=$data->imagen?>></li>
                </ul>
            </div>  
        </div>
    </div>
    <?php
} else {
    header('Locatio: index.php');
}
