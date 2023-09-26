<?PHP
require_once '../library/config.php';
require_once '../library/functions.php';
require_once '../library/mail.php';
require_once '../Classes/PHPExcel.php';

if(isset($_POST['btnSave'])){
    $file = $_FILES['file']['tmp_name'];
	//tạo một đối tượng gọi đến class PHPExcel_IODactory và phương thức createReaderForFile để đọc và load sheet trong file excel mà ta sẽ import vào 
    
    $objReader = PHPExcel_IOFactory::createReaderForFile($file);
    $objReader ->setLoadSheetsOnly('LichImport');

    $objExcel = $objReader ->load($file);
    //Chuyển file sang kiểu mảng và insert dữ liệu vào database
    
    $sheetData = $objExcel->getActiveSheet()->toArray('null',true,true,true);
     $highestRow = $objExcel ->setActiveSheetIndex()->getHighestRow(); 
    for($row=2; $row<=$highestRow; $row++){
        $Subject = $sheetData[$row]['A'];
        $startDate = $sheetData[$row]['B'];
        $startTime = $sheetData[$row]['C'];
        $endDate = $sheetData[$row]['D'];
        $endTime = $sheetData[$row]['E'];
        $Event = $sheetData[$row]['F'];
        $Description = $sheetData[$row]['G'];
        $Location = $sheetData[$row]['H'];
        $CBGD = $sheetData[$row]['I'];
        $soTiet = $sheetData[$row]['J'];
        $soTinChi = $sheetData[$row]['K'];
        $maLop = $sheetData[$row]['L'];
        $sql = "Insert into tbl_thoikhoabieu(Subject,startDate,startTime,endDate,
        endTime,Event,Description,Location,CBGD,soTiet,soTinChi,idMaLop) 
        values('$Subject','$startDate','$startTime','$endDate','$endTime','$Event',
        '$Description','$Location','$CBGD','$soTiet','$soTinChi','$maLop')";
        dbQuery($sql);
    }
    

	
}

?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><b>Thêm kế hoạch giảng dạy</b></h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="v" value="DB" />
        <input type="file" name="file">
        <!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" name="btnSave" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>