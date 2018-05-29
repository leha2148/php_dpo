<?include('header.php');
    include('/database/connection.php');

    function redTo($value=''){
        echo "<script> window.location.replace('$value'); </script>";
    }

    //get video
    $video_id=$_GET['video_id'];
    $request_number=$_GET['request_number'];

    $q="SELECT * FROM video INNER JOIN reques WHERE video.video_id=$video_id and video.request_number=reques.request_number";

    $row=$connection->query($q)->fetch(PDO::FETCH_LAZY);
    //old video paameters
   
        $video_name=$row['video_name'];
        $video_format=$row['video_format'];
        $video_genre=$row['video_genre'];
        $video_description=$row['video_description'];
        $request_state=$row['request_state'];
        $video_id=$row['video_id'];
        
    //new video paameters
    $video_name_=$_POST['video_name'];
    $video_format_=$_POST['video_format'];
    $video_genre_=$_POST['video_genre'];
    $video_description_=$_POST['video_description'];
    $request_state_=$_POST['request_state'];

    $id_user=$_SESSION['id_user'];

    $q=" UPDATE video SET video_name='$video_name_',video_format='$video_format_',video_genre='$video_genre_',video_description='$video_description_' WHERE video_id=$video_id";

    $connection->query($q);

    if($request_number && $video_name_ && $video_format_ && $video_genre_ && $video_description_){
        $q="UPDATE `reques` SET `request_state` = '$request_state_' WHERE `reques`.`request_number` = $request_number;";
        $connection->exec($q);
    }
    /*
    if($request_number && $video_name && $video_format && $video_genre && $video_description){
        $connection->exec($q);
        $q="UPDATE `reques` SET `request_state` = 'выполняется' WHERE `reques`.`request_number` = $request_number;";
        $connection->exec($q);
        echo "<p>Видео успешно создано)</p>";
    }
*/
?>

	<div class="container-fluid">


    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <h2>Мои видео</h2>
            <hr>
        </div>
    </div>

        <form class="form-horizontal" role="form" method="POST" >
           
            <div class="row">
                <div class="col-md-3 field-label-responsive">
                    <label for="name">Название видео</label>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                            <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-user"></i></div>
                            <input type="text" name="video_name" class="form-control" id="name"
                                placeholder="Выпуск влога для Макса №15" required autofocus
                                value="<?=$video_name?>"    
                            >
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-control-feedback">
                            <span class="text-danger align-middle">
                                <!-- Put name validation error messages here -->
                            </span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 field-label-responsive">
                    <label for="last_name">Формат видео</label>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                            <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-user"></i></div>
                            <input type="text" name="video_format" class="form-control" id="last_name"
                                placeholder="4к 60fps" required autofocus  value="<?=$video_format?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-control-feedback">
                            <span class="text-danger align-middle">
                                <!-- Put name validation error messages here -->
                            </span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 field-label-responsive">
                    <label for="email">Жанр</label>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                            <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-at"></i></div>
                            <input type="text" name="video_genre" class="form-control" id="email"
                                placeholder="vlog" required autofocus  value="<?=$video_genre?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-control-feedback">
                            <span class="text-danger align-middle">
                                <!-- Put e-mail validation error messages here -->
                            </span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 field-label-responsive">
                    <label for="email">Описание</label>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                            <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-at"></i></div>
                            <input type="text" name="video_description" class="form-control" id="email"
                                placeholder="Небольшое описание в пару слов" required autofocus  value="<?=$video_description?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-control-feedback">
                            <span class="text-danger align-middle">
                                <!-- Put e-mail validation error messages here -->
                            </span>
                    </div>
                </div>
            </div>

             <label for="exampleFormControlSelect5">Состояние заказа</label>

            <select class="form-control" id="exampleFormControlSelect5" name="request_state">
               
                   <option value='новый' <?if($request_state=='новый') echo 'selected'?>>новый</option>
                   <option value='выполняется' <?if($request_state=='выполняется') echo 'selected'?>>выполняется</option>
                   <option value='готов' <?if($request_state=='готов') echo 'selected'?>>готов</option>
               
            </select>

<!--
            <label for="exampleFormControlSelect4">Выберите заказ для выполнения</label>
                <select class="form-control" id="exampleFormControlSelect4" name="request_number">
                <?/*
                
                $sql = "SELECT * FROM `reques` WHERE reques.request_state='новый'";

                foreach($connection->query($sql) as $key=>$row) 
                {
                    echo '<option value='.$row['request_number'].'>'."Заказ номер ".$row['request_number'].'</option>';
                }

               */ ?>
        </select>
-->
           
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-success"><i class="fa fa-user-plus"></i>Сохранить изменения</button>
                    <a href="profile_operator.php" class="btn btn-success"><i class="fa fa-user-plus"></i> Назад</a>
                </div>
            </div>
           
        </form>

        

    </div>



 <? include('footer.php')?>
		