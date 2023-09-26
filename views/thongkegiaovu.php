<?php
require_once '../library/config.php';
require_once '../api/process.php';
require_once '../library/functions.php';
// sử dụng hàm kết nối csdl mysqli
$conn = new mysqli("localhost", "root", "", "db_event_management");
$records = getlopid();
//$full=getfulllop();
$tengvv= gettengv();
?>
<?php
$result = [];
if (isset($_GET["timKiem"])) {
    $sql = "SELECT * FROM tbl_thoikhoabieu WHERE 1=1 ";
    $giangvien = $_GET["giangvien"];
    if (isset($_GET["giangvien"]) && $giangvien != "") {
        $sql .= " and Subject='$giangvien' and Event=1";
    }
    $result = $conn->query($sql);
}
// Thực thi câu lệnh truy vấn

// printf($result->num_rows);
?>
<?php
$siso = [];
if (isset($_GET["timKiem"])) {
    $sql = "SELECT DISTINCT lop.siSo FROM lop INNER JOIN tbl_thoikhoabieu ON lop.idMaLop = tbl_thoikhoabieu.idMaLop WHERE 1=1 ";
    $lophocphan = $_GET["lophocphan"];
    if (isset($_GET["lophocphan"]) && $lophocphan != "") {
        $sql .= " and tbl_thoikhoabieu.Subject='$lophocphan'";
    }
    $siso = $conn->query($sql);
}
?>
<?php
$giangvien = [];
if (isset($_GET["timKiem"])) {
    $sql = "SELECT DISTINCT tbl_users.fullName FROM tbl_users INNER JOIN tbl_thoikhoabieu ON tbl_users.idName = tbl_thoikhoabieu.CBGD WHERE 1=1 ";
    $tengiangvien = $_GET["tengiangvien"];
    if (isset($_GET["tengiangvien"]) && $tengiangvien != "") {
        $sql .= " and tbl_thoikhoabieu.CBGD='$tengiangvien'";
    }
    $giangvien = $conn->query($sql);
}
?>
<?php
$resthucgiang = [];
if (isset($_GET["timKiem"])) {
    $sqlthucgiang = "SELECT DISTINCT soTinChi FROM tbl_thoikhoabieu WHERE 1=1";
    $lophocphan = $_GET["lophocphan"];
    if (isset($_GET["lophocphan"]) && $lophocphan != "") {
        $sqlthucgiang .= " and Subject  = '$lophocphan' ";
    }
    $resthucgiang = $conn->query($sqlthucgiang);
}
?>



<div id="container">
    <form method="get">
        <input type="hidden" name="v" value="TKTG" />
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Danh sách lớp học</h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-bordered">
                    <tr>
                      

                       
                                <td> <label>Giảng viên <span>(*)</span></label><br>
                            <select class="form-control" name="giangvien" id="giangvien"
                                value="<?php if (isset($_GET["giangvien"])) echo $_GET["giangvien"]; ?>">
                                <option>Chọn</option>
                                <?php
                                foreach ($tengvv as $rec) {
                                    extract($rec);
                                ?>
                                <option><?php echo $tfullName; ?> </option>
                                <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan='4'>
                            <button style="margin-left: 10px;" type="submit" class="btn btn-info" name="timKiem"><i
                                    aria-hidden="true" value="Xem thống kê"></i>&nbsp;Xem thống kê</button>
                            <!-- <input type="submit" value="Xem thống kê" name="confirm" class="btn btn-success" /> -->
                        <td>
                    </tr>
                </table>
                <div class="box-body table-responsive">
                    <table class="table table-striped">
                        <thead class="bg-success">
                            <tr>
                                <th>STT</th>
                                <th>Giảng viên </th>
                                <th>Tên học phần</th>
                                <th>Thực giảng</th>
                                <th>Sĩ số</th>
                                <th>Lớp học </th>
                                <th>Ghi chú</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stt = 0;
                            $sum = 0;
                            $sum1 = 0;
                            if ($result) {
                                while ($row = $result->fetch_assoc()) :
                                    $stt++;
                                    $thucgiang = $row["Event"];
                                    if ($row["Event"] == 0) {
                                        $thucgiang = 0;
                                    } else {
                                        $thucgiang = $row["soTiet"];
                                    }
                                    if ($row["Event"] == 0) {
                                        $thieusot = $row["soTiet"];
                                    } else {
                                        $thieusot = 0;
                                    }
                                    $sum1 += $thieusot;
                                    $sum += $thucgiang;
                            ?>
                            <tr>
                                <th class="text-center"><?php echo $stt; ?></th>
                                <td><?php echo $row["startDate"]; ?></td>
                                <td><?php echo $row["soTiet"]; ?></td>
                                <td> <?php echo $thucgiang; ?> </td>
                                <td> <?php echo $thieusot; ?> </td>
                                <td><?php echo $row["Location"]; ?></td>
                                <td> </td>
                                <td><?php echo $row["siSo"]; ?></td>
                                <td><?php echo $row["noiDung"]; ?></td>
                                <td><?php echo $row["nhanXet"]; ?></td>
                                <td></td>
                                <td></td>

                            </tr>
                            <?php
                                endwhile;
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <th colspan=2>Tổng</th>
                            <th> <?php
                                    if ($resthucgiang) :
                                        while ($khoa = $resthucgiang->fetch_array()) :
                                            $soTiet = $khoa["soTinChi"];
                                            echo $soTiet * 15;
                                        endwhile;
                                    endif;
                                    ?></th>
                            <th><?php echo $sum; ?></th>
                            <th><?php echo $sum1; ?></th>
                            <th></th>
                            <th> <?php
                                    if ($siso) :
                                        while ($lop = $siso->fetch_assoc()) :
                                            $sS = $lop["siSo"];
                                            echo $sS;
                                        endwhile;
                                    endif;
                                    ?></th>
                        </tfoot>
                    </table>
                </div>
                <button name="btnExport" class="btn btn-success" type="submit"
                    style="margin-top:20px;margin-left:20px">Xuất File </button>

            </div>
    </form>
    <?php
        require_once '../Classes/PHPExcel.php';

        if(isset($_GET['btnExport'])){
           print_r($result);
       
           die();
        $data = [
            [
               $row["startDate"], 
               $row["soTiet"], 
               $thucgiang,
               $thieusot, 
               $row["Location"], 
                $row["siSo"],
                $row["noiDung"], 
                $row["nhanXet"] ],
        ];
       
        
        //Khởi tạo đối tượng
        
        $excel = new PHPExcel();
        
        //Chọn trang cần ghi (là số từ 0->n)
        
        $excel->setActiveSheetIndex(0);
        $excel->getActiveSheet()->setTitle('Báo cáo thực giảng');            //Tạo tiêu đề cho trang. (có thể không cần)
        
        //Xét chiều rộng cho từng, nếu muốn set height thì dùng setRowHeight()
        
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
        $excel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
        $excel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
        $excel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
        $excel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
        //Xét in đậm cho khoảng cột
        
        $excel->getActiveSheet()->getStyle('A1:K1')->getFont()->setBold(true);
        
        //Tạo tiêu đề cho từng cột
        
        //Vị trí có dạng như sau:
        
        /**
        
         * |A1|B1|C1|..|n1|
        
         * |A2|B2|C2|..|n1|
        
         * |..|..|..|..|..|
        
         * |An|Bn|Cn|..|nn|
        
         */
        
        $excel->getActiveSheet()->setCellValue('A1', 'Ngày chấm');
        $excel->getActiveSheet()->setCellValue('B1', 'Kế hoạch');
        $excel->getActiveSheet()->setCellValue('C1', 'Thực giảng');
        $excel->getActiveSheet()->setCellValue('D1', 'Chưa giảng dạy');
        $excel->getActiveSheet()->setCellValue('E1', 'Lớp học');
        $excel->getActiveSheet()->setCellValue('F1', 'Sĩ số');
        $excel->getActiveSheet()->setCellValue('G1', 'Số SV có mặt');
        $excel->getActiveSheet()->setCellValue('H1', 'Nội dung bài giảng');
        $excel->getActiveSheet()->setCellValue('I1', 'Nhận xét');
        $excel->getActiveSheet()->setCellValue('J1', 'Kí tên');
        $excel->getActiveSheet()->setCellValue('K1', 'Ghi chú');
        
        
        
        // thực hiện thêm dữ liệu vào từng ô bằng vòng lặp
        
        // dòng bắt đầu = 2
        
        $numRow = 2;
        foreach ($data as $row) {
            $excel->getActiveSheet()->setCellValue('A' . $numRow, $row[0]);
            $excel->getActiveSheet()->setCellValue('B' . $numRow, $row[1]);
            $excel->getActiveSheet()->setCellValue('C' . $numRow, $row[2]);
            $excel->getActiveSheet()->setCellValue('D' . $numRow, $row[3]);
            $excel->getActiveSheet()->setCellValue('E' . $numRow, $row[4]);
            $excel->getActiveSheet()->setCellValue('F' . $numRow, $row[5]);
            $excel->getActiveSheet()->setCellValue('G' . $numRow, $row[6]);
            $excel->getActiveSheet()->setCellValue('H' . $numRow, $row[7]);
            $excel->getActiveSheet()->setCellValue('I' . $numRow, $row[8]);
            $excel->getActiveSheet()->setCellValue('J' . $numRow, $row[9]);
            $excel->getActiveSheet()->setCellValue('K' . $numRow, $row[10]);
            $numRow++;
        }
        
        // Khởi tạo đối tượng PHPExcel_IOFactory để thực hiện ghi file
        
        // ở đây mình lưu file dưới dạng excel2007
        
        PHPExcel_IOFactory::createWriter($excel, 'Excel2007')->save('data.xlsx');
        
        //Nếu bạn muốn xuất kết quả ra cửa sổ download thì sửa phần cuối thành:
        
        header('Content-type: application/vnd.ms-excel');
        
        header('Content-Disposition: attachment; filename=”data.xlsx”');
        
        PHPExcel_IOFactory::createWriter($excel, 'Excel2007')->save('php://output');
       }
    //EXPORT EXCEL
    // if(isset($_GET['btnExport'])){
    //     $objExcel = new PHPExcel;
    //     $objExcel -> setActiveSheetIndex(0);
    //     $sheet=$objExcel->getActiveSheet()->setTitle('aa');
    //  //tieu de cot
    //     $rowCount = 1;
    //     $sheet->setCellValue('A'.$rowCount,'Ngày chấm');
    //     $sheet->setCellValue('B'.$rowCount,'Kế hoạch');
    //     $sheet->setCellValue('C'.$rowCount,'Thực giảng');
    //     $sheet->setCellValue('D'.$rowCount,'CHua giảng dạy');
    //     $sheet->setCellValue('E'.$rowCount,'Lớp học');
    //     $sheet->setCellValue('F'.$rowCount,'Sĩ số');
    //     $sheet->setCellValue('G'.$rowCount,'Số SV có mặt');
    //     $sheet->setCellValue('H'.$rowCount,'Nội dung bài giảng');
    //     $sheet->setCellValue('I'.$rowCount,'Nhận xét');
    //     $sheet->setCellValue('J'.$rowCount,'Kí tên');
    //     $sheet->setCellValue('K'.$rowCount,'Ghi chú');

    //     $sheet->getColumnDimension('A')->setAutoSize(true);
    //     //A1:D1 la độ dài của bảng
    //     $sheet->setStyle('A1:K1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00ffff00');
    //     $sheet->setStyle('A1:K1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    //     //select gia tri cua bang
    //     $result = $mysqli->query("Select...  from...   where... ");
    //     while($row = mysqli_fetch_array($result)){
    //         $rowCount++;
    //         $sheet->setCellValue('A'.$rowCount,$row['name']);
    //         $sheet->setCellValue('A'.$rowCount,$row['name']);
    //         $sheet->setCellValue('A'.$rowCount,$row['name']);
    //         $sheet->setCellValue('A'.$rowCount,$row['name']);
    //         $sheet->setCellValue('A'.$rowCount,$row['name']);
    //         $sheet->setCellValue('A'.$rowCount,$row['name']);
    //         $sheet->setCellValue('A'.$rowCount,$row['name']);
    //         $sheet->setCellValue('A'.$rowCount,$row['name']);
    //     }
    // //tinh trung binh cong gia tri trong cot (D là cột muốn tính)
    //     $sheet->setCellValue('D'.($rowCount+1),"=SUM(D2:D$rowCount)/COUNT(D2:D$rowCount)");
    //     $sheet->setCellValue('A'.($rowCount+1),);
    //     $sheet->getStyle('A'.($rowCount+1))->setFort()->setBold(true);


    //     //Định dạng 
    //     $styleArray=Array(
    //         'borders'=> array(
    //             'allborders'=> array(
    //                 'style'=>PHPExcel_Style_Border::BORDER_THIN
    //             )
    //         )
    //     );
    //     $sheet->getStyle('A1:' . 'D'.($rowCount+1))->applyFromArray($styleArray);

    //     $objWrite=new PHPExcel_Write_Excel2007($objExcel);
    //     $filename='export.xlsx';
    //     $objWrite->save($filename);

    //     header('Content-Disposition: attachment; filename="' .$filename . '"');
    //     header('Content-Type: application/vnd.openxmlformatsofficedocument.spreadsheetml.sheet');
    //     header('Content-Length: ' . filesize($filename));
    //     header('Content-Transfer-Encoding: binary');
    //     header('Cache-Control: must-revalidate');
    //     header('Pragma: no-cache');
    //     readfile($filename);
    //     return;
    // }


    //END EXPORT EXCEL
    ?>

</div>