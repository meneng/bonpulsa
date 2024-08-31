<?php
date_default_timezone_set("Asia/jakarta");
//echo date("d-m-Y");

$data_resource = file_get_contents("data.txt");
$nama_resource = file_get_contents("nama.txt");
$data_array = explode("\n", $data_resource);
$total_bon = 0;
$total_bayar = 0;
for ($i = 0; $i < count($data_array)-1; $i++) {
   $isi = explode(" | ", $data_array[$i]);
   $total_bon += (int)$isi[3];
   $total_bayar += (int)$isi[4];
}
$total_sisa_bon = $total_bon - $total_bayar;
$names = explode(",", $nama_resource);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bon Pulsa localhost</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div id="container">
    <div id="total">
        <article class="item">
        <p class="flavor">Total Rp. <?php echo $total_sisa_bon;?></p>
        <p class="price" onclick="openNav()">
            <svg width="15" height="15">
                <path d="M 0,4.5 15,4.5 M 0,9.5 15,9.5 M 0,14.5 15,14.5" style="fill:none;stroke:black;stroke-width:2;align:center">
            </svg>
            &nbsp;&nbsp;&nbsp;
        </p>
    </article>
    </div> 
    <!-- <article class="item">
        <p class="flavor">Total Rp. <?php //echo $total_sisa_bon;?></p><p class="price">A</p>
    </article> -->
    <!-- disable button
    <button id="tombol" onclick="openNav()">Nama</button>
    -->
    <!-- Sidenav contents -->
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <?php
            for($i=0; $i < count($names)-1; $i++) {
                echo "<a href=\"#\" class=\"tablinks\" onclick=\"openTab(event, '".$names[$i]."')\">".$names[$i]."</a>";
            }
            echo "<a href=\"#\" class=\"tablinks\" onclick=\"openFormAdd()\">Tambah nama</a>";
        ?>
    </div>
    <!-- scroll horizontal menu -->
    <div class="scrollmenu">
    <?php
        //buat tablink urutkan nama berdasarkan nilai bon terbesar, bon = 0 tidak perlu ditampilkan, bon minus tampilkan paling belakang 
        $tab_link = array();
        $tab_name_bon = array();
        for($i=0; $i < count($names)-1; $i++) { //iterate over $names
            for($j=0; $j < count($data_array)-1; $j++) { //iterate over $data_array
                $isi = explode(" | ", $data_array[$j]);
                if (in_array($names[$i], $isi)) {
                    //echo("ada");
                    array_push($tab_link, $isi);
                }               
            }
            //echo("<pre>");
            //print_r($tab_link);
            //echo("</pre>");
            
            $bon = 0;
            if (count($tab_link) > 0) { //jika array tidak kosong
                //data array index[0]
                $pertama =(int)$tab_link[0][3] - (int)$tab_link[0][4];
                if (count($tab_link) == 1) { //jika hanya ada satu data
                    $bon = $pertama;
                } else {
                    //lanjut data array index[1] dan seterusnya
                    for($k=1; $k < count($tab_link); $k++) {
                        if ($k == 1){
                            $bon = ($pertama + (int)$tab_link[$k][3]) - (int)$tab_link[$k][4];
                        } else {
                            $bon = ($bon + (int)$tab_link[$k][3]) - (int)$tab_link[$k][4];
                        }   
                    }
                }
            }
            $tab_name_bon[$names[$i]] = $bon; //associative array
            $bon = 0; //reset bon  
            $tab_link = array(); //reset array
        }
        arsort($tab_name_bon); //sorting based on value decending
        $nilai_a_arr = sizeof($tab_name_bon);
        $count_down = $nilai_a_arr;
        //echo("<pre>");
        //var_dump($tab_name_bon);
        //echo("</pre>");
        
        foreach($tab_name_bon as $x=>$y) {
            if ($count_down - ($nilai_a_arr-1) == 1) {
                echo "<a href=\"#\" class=\"tablinks\" onclick=\"openTab(event, '".$x."')\" id=\"defaultOpen\">".$x."</a>";
            } else {
                if ((int)$y != 0) {
                    echo "<a href=\"#\" class=\"tablinks\" onclick=\"openTab(event, '".$x."')\">".$x."</a>";
                }
            }
            $count_down--;
            //echo $y. "<br>";
        }
        $tab_name_bon = array(); //kosongkan array
        //echo "<a href=\"#\" class=\"tablinks\" onclick=\"openTab(event, '".$names[0]."')\" id=\"defaultOpen\">".$names[0]."</a>";
        //for($i=1; $i < count($names)-1; $i++) {
        //    echo "<a href=\"#\" class=\"tablinks\" onclick=\"openTab(event, '".$names[$i]."')\">".$names[$i]."</a>";
        //}
    ?>
    </div>
    
    <!-- Tab links
    <div class="tab">
        <?php /*
            echo "<button class=\"tablinks\" onclick=\"openTab(event, '".$names[0]."')\" id=\"defaultOpen\">".$names[0]."</button>";
            for($i=1; $i < count($names)-1; $i++) {
                echo "<button class=\"tablinks\" onclick=\"openTab(event, '".$names[$i]."')\">".$names[$i]."</button>";
            } */
        ?>
    </div> -->

    <!-- Tab content -->
    <?php
        $data_tabel = array();
        $hutang = 0;
        for($i=0; $i < count($names)-1; $i++) {
            for($j=0; $j < count($data_array)-1; $j++) {
                $isi = explode(" | ", $data_array[$j]);
                if (in_array($names[$i], $isi)) {
                    //echo("ada");
                    array_push($data_tabel, $isi);
                }               
            }
            //echo("<pre>");
            //print_r($data_tabel);
            //echo("</pre>");          
            echo "<div id=\"".$names[$i]."\" class=\"tabcontent\">";
            echo "<h3>".strtoupper($names[$i])."</h3>";
            echo "<table>";
            echo "<tr><th>tgl</th><th>info</th><th>bon</th><th>byr</th><th>hutang</th></tr>"; //head tabel
            if (count($data_tabel) > 0) { //jika ada data trx
                //data array index[0]
                $first =(int)$data_tabel[0][3] - (int)$data_tabel[0][4];
                echo "<tr><td>".$data_tabel[0][0]."</td><td>".$data_tabel[0][2]."</td><td>".$data_tabel[0][3]."</td><td>".$data_tabel[0][4]."</td><td>". $first ."</td></tr>";
                //lanjut data array index[1] dan seterusnya
                for($k=1; $k < count($data_tabel); $k++) {
                    if ($k == 1){
                        $hutang = ($first + (int)$data_tabel[$k][3]) - (int)$data_tabel[$k][4];
                    } else {
                        $hutang = ($hutang + (int)$data_tabel[$k][3]) - (int)$data_tabel[$k][4];
                    }
                    echo "<tr><td>".$data_tabel[$k][0]."</td><td>".$data_tabel[$k][2]."</td><td>".$data_tabel[$k][3]."</td><td>".$data_tabel[$k][4]."</td><td>".$hutang."</td></tr>";
                    
                }
            }
            if (count($data_tabel) == 1) {
                echo "<tr style=\"background-color: skyblue\"><td colspan=\"4\" style=\"text-align: center\">Total Bon</td><td>".$first."</td></tr>";
            } else {
                echo "<tr style=\"background-color: skyblue\"><td colspan=\"4\" style=\"text-align: center\">Total Bon</td><td>".$hutang."</td></tr>";
            }
            echo "</table><br>";
            echo "<button onclick=\"openForm('".$names[$i]."')\">Update data</button>";
            echo "</div>";
            
            $data_tabel = array(); //reset array
            $first = 0; //reset $first
            $hutang = 0; //reset $hutang
        }
        
    ?>
    <br>
    <div id="myForm" class="sidenavform">
        <a href="javascript:void(0)" class="closebtn" onclick="closeForm()">&times;</a>
        
        <form action="proses_form_data.php" method="post" enctype="multipart/form-data">
        <fieldset>
        <legend>Update Data</legend>
        <p>
            <label for="nama">Nama : </label>
            <input type="text" name="nama" id="nama" readonly>
        </p>
        <p>
            <label for="bon">Bon : </label>
            <input type="text" name="bon" id="bon" value="0">
        </p>
        <p>
            <label for="byr">Bayar : </label>
            <input type="text" name="byr" id="byr" value="0">
        </p>
        <p>
            <label for="info">Info trx : </label>
            <input type="info" name="info" id="info" placeholder="info transaksi">
        </p>
        </fieldset>
        <br>
        <p>
            <input type="submit" name="submit" Value="Kirim">
        </p>
        </form>
    </div>
    <div id="nameForm" class="sidenavform">
        <a href="javascript:void(0)" class="closebtn" onclick="closeFormAdd()">&times;</a>
        
        <form action="proses_form_nama.php" method="post" enctype="multipart/form-data">
        <fieldset>
        <legend>Add data nama</legend>
        <p>
            <label for="namaadd">Nama : </label>
            <input type="text" name="namaadd" id="namaadd">
        </p>
        </fieldset>
        <br>
        <p>
            <input type="submit" name="submit" Value="Tambah">
        </p>
        </form>
    </div>
</div>

<script src="script.js" type="text/javascript"></script>
</body>
</html>