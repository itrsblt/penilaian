<!DOCTYPE html>
<html>
<head>
    <title>Penilaian Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
   <script  src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <style>
      <style>
        .below-diagonal {
            background-color: lightgray; /* Ganti dengan warna yang Anda inginkan */
        }
    </style>
    </style>
</head>
<body>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
          <div class="container-fluid">           
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" aria-current="page" href="index.php">Kedisiplinan</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="keramahan.php">Keramahan</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="loyalitas.php">Loyalitas</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="smartservices.php">Komitmen laksanakan smart service</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="tanggungjawab.php">Tanggung Jawab</a>
                </li>
                 <li class="nav-item">
                  <a class="nav-link" href="kerjasama.php">Kerjasama</a>
                </li>                  
              </ul>
            </div>
          </div>
        </nav>
        <div class="row">
            <div class="col-md-12">
              
        <?php
        include "config.php";
        if(!isset($_SESSION)){
            session_start();
        } 
           $ruangan  = $_SESSION['ruangan'];
           $userbaru = $_SESSION['user'];
           $peg      = $_SESSION['nama_peg']; 
           $id_pe    = $_SESSION['id_peg'];
        
           $sqll = "SELECT * FROM penilaian where input_by = $id_pe";

           $queryq = mysqli_query($con,$sqll);
           $count  = mysqli_num_rows($queryq);                     
           if($count>0)
           {
            ?>
                </br><b>Kategori : Kedisiplinan / Kehadiran</b>
                <div class="bg bg-success py-2 text-center text-white mt-2" style="">Terima kasih <b><?= $peg;?></b> Sudah berpartisipasi dalam penilaian ini </br> Data penilaian Anda sudah tersimpan </div> </br>
                 
                <a href="logout.php" class="btn btn-primary btn-sm mb-2 mt-2">Logout</a>
            <?php
           }
           else{
                  
            echo '<script>';
echo 'function updateDiagonal(input, row, col) {';
echo '    console.log(\'Input Value:\', input.value);';
echo '    console.log(\'Row:\', row);';
echo '    console.log(\'Column:\', col);';
echo '';
echo '    var diagonalInput = document.querySelector(\'input[name="nilai_\' + row + \'_\' + col + \'"]\');';
echo '    if (diagonalInput !== null) {';
echo '        diagonalInput.value = input.value === "1" ? "0" : "1";';
echo '        console.log(\'Diagonal Input Value:\', diagonalInput.value);';
echo '    }';
echo '}';
echo '</script>';
                 ?>          
            </br>
            Selamat datang <?= $peg;?> di <b>Sistem Penilaian Pegawai</b> 
            </br><b>Kategori : Kedisiplinan / Kehadiran</b></br></br>
            <a href="logout.php" class="btn btn-primary btn-sm mb-2">Logout</a>
            <form method="post" action="kedisiplinansubmit.php">               
                <table class="table table-bordered table-sm" style="font-size:10px;">
                    <thead>
                    <tr>
                        <th>Nama Pegawai</th>
                        <?php
                        $kategori_query = "SELECT id_peg, nama_peg FROM user_log where ruangan = '$ruangan' and username != $userbaru";
                        $kategori_result = mysqli_query($con,$kategori_query);
                        $nop=1;
                        if (mysqli_num_rows($kategori_result) > 0) {
                            while ($kategori = mysqli_fetch_array($kategori_result)) {
                         
                                $namaArray = explode(" ", $kategori["nama_peg"]); 
                                $kataPertama = implode(" ", array_slice($namaArray, 0, 2));;
                                echo '<th class="text-center" syle="text-align:center">' . $kataPertama . ' ('.$nop.')</th>';
                                $nop++;
                            }
                        }                          
                        ?>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        //ambil pegawai loop ke bawah
                        $pegawai_query  = "SELECT id_peg, nama_peg FROM user_log where ruangan = '$ruangan' and username != $userbaru";
                        $pegawai_result = mysqli_query($con,$pegawai_query);
                        
                        //ambil kategori  untuk di masukkan ke table penilaian
                        $kat    = mysqli_query($con,"SELECT * FROM kategori_penilaian where nama_kategori = 'Kedisiplinan'");
                        $rowkat = mysqli_fetch_array($kat);
                                                                       

                        if (mysqli_num_rows($pegawai_result) > 0) {
                          $cekkat = $rowkat['id_kategori']; 
                          $no = 1;
                          
                          echo '<form method="post" action="">'; // Buka tag form
                          
                          while ($pegawai = mysqli_fetch_array($pegawai_result)) {
                              $pegawai_id = $pegawai["id_peg"];
                              $pegawai_nama = $pegawai["nama_peg"];
                              
                              echo '<tr>';
                              echo '<td style="text-align:center">' . $pegawai_nama .  ' <b>('.$no.')</b></td>';
                              echo '<input type="hidden" class="text-center" name="kategorinama" value="'.$cekkat.'">';
                              
                              $pegawai_query2 = "SELECT id_peg, nama_peg FROM user_log where ruangan = '$ruangan' and username != $userbaru";
                              $pegawai_result2 = mysqli_query($con,$pegawai_query2);
                              $noq = 1;
                              
                              while ($pegawai2 = mysqli_fetch_array($pegawai_result2)) {
                                  $pegawai2_id = $pegawai2["id_peg"];
                                  echo '<td style="text-align:center">';
                                  
                                  if ($pegawai_id === $pegawai2_id) {
                                      echo '<input type="text" class="text-center" style="width: 5em"  value="0" disabled>';
                                  } else {
                                      $nilai_default = ($noq > $no - 1) ? 0 : 1; // Atas diagonal: 0, Bawah diagonal: 1
                                      
                                      if (isset($_POST['nilai'][$noq][$pegawai_id])) {
                                          $nilai_default = $_POST['nilai'][$noq][$pegawai_id];
                                      }                                      
                                      echo '<input type="text" class="text-center" name="nilai_' . $noq . '_'.$pegawai_id.'" style="width: 5em" min="0" max="1" value="'.$nilai_default.'" onchange="updateDiagonal(this, ' . $noq . ', '.$pegawai_id.')">';
                                  }
                                  
                                  echo '</td>';
                                  $noq++;
                              }
                              
                              echo '</tr>';
                              $no++;
                          }
                          
                          echo '</form>'; // Tutup tag form
                      } else {
                          echo '<tr><td colspan="' . ($kategori_result->num_rows + 1) . '">Tidak ada data pegawai.</td></tr>';
                      }


                      ?>


                    </tbody>
                </table>
                                       

       
               
                <input type="submit" value="Submit">
                 <br>
                </br>
            </form>
                    </div>
                </div>
                <?php
                  }
                ?>
          </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  </body>
</body>
</html>
