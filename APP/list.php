<?php
include_once 'head.php';

$data = json_decode(file_get_contents('http://localhost/API/'));

if (isset($_REQUEST['delete']) && isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    $apiUrl = "http://localhost/API/$id";

    $ch = curl_init($apiUrl);

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');

    $response = curl_exec($ch);
    header("Location: list.php");
}
if (isset($_REQUEST['update']) && isset($_REQUEST['id'])) { 

    $id = $_REQUEST['id'];
    $apiUrl = "http://localhost/API/$id";
    if ($_REQUEST['update'] == 'plate') {
        $matricula = $_REQUEST['plate'];
        $data = array(
            'matricula'     => $matricula
        );
    } else {
        $data = array(
            'vendido'       => '1'
        );
    }

    $data = json_encode($data);

    var_dump($data);

    $ch = curl_init($apiUrl);

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');

    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $response = curl_exec($ch);
    curl_close($ch);
    header("Location: list.php");
}
?>
<div class="container">
    <div class="row">
        <table class="table">
            <thead>
                <td>Id</td>
                <td>Marca</td>
                <td>Modelo</td>
                <td>Color</td>
                <td>Matricula</td>
                <td>Vendido</td>
                <td>Eliminar</td>
            </thead>
            <tbody>
                <?php
                foreach ($data as $key => $value) {
                    echo "<tr><td>$value->id</td>
                                <td>$value->marca</td>
                                <td>$value->modelo</td>
                                <td>$value->color</td>
                                <td><form action=" . $_SERVER['PHP_SELF'] . " method=GET><input type='text' name='plate'
                                value=$value->matricula>&nbsp;&nbsp;<input type='submit' value='Cambiar'>
                                <input type=hidden name=id value=$value->id>
                                <input type=hidden name=update value=plate></form></td>";
                    if ($value->vendido) {
                        echo "<td>Vendido</td>";
                    } else {
                        echo "<td><a href='list.php?update=1&&id=$value->id'>Vender</a></td>";
                    }
                    echo "<td><a href='list.php?delete=1&&id=$value->id'><i class='fa-solid fa-trash'></i></a></td>
                            </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>