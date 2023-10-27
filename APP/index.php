<?php
include_once'head.php';

$data = json_decode(file_get_contents('http://localhost/API/'));

?>
<div class="container">
    <div class="row">
<?php
foreach ($data as $key => $value) {
    echo "<div class='col-lg-2 col-md-4 col-sm-6 col-12'>
            <div class='card'>
                <div class='card-body'>
                    <a href='card.php?id=$value->id'>$value->modelo</a>
                </div>
            </div>
        </div>";
}
?>
    </div>
</div>