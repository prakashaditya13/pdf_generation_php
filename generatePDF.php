<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once('db/connectionDB.php');


try {
    $readDB = DB::connectReadDB();
    echo "connected";
} catch (PDOException $ex) {
    error_log("Connection Error - ". $ex);
    exit();
}


//Fetching data from Database
try {
    $query = $readDB->prepare('select Inv_no, created_At, due_date, customer0Cust_name, customer0address, customer0email, company0comp_name, company0address, company0email from mytable');
    $query->execute();

    //Returning a Row
    $row_count = $query->rowCount();

    if($row_count === 0){
        //Displaying none of data
    }
    $row = $query->fetch(PDO::FETCH_ASSOC);
    //Stored a Invoice Data into array
    $Invoice_no = $row['Inv_no'];
    $created_at = $row['created_At'];
    $due_d = $row['due_date'];
    $cust_name = $row['customer0Cust_name'];
    $cust_addr = $row['customer0address'];
    $cust_email = $row['customer0email'];
    $comp_name = $row['company0comp_name'];
    $comp_addr = $row['company0address'];
    $comp_email = $row['company0email'];

} catch (PDOException $ex) {
    error_log("Database error - ".$ex);
    exit();
}

//Generate Template from HTML
$PDF_TEMP = "<!doctype html>
<html>
<head>
    <meta charset='utf-8'>
    <title>Invoices</title>
    
    <style>
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }
    
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }
    
    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }
    
    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }
    
    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }
    
    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }
    
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    
    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }
    
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }
    
    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }
    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }
        
        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }
    
    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }
    
    .rtl table {
        text-align: right;
    }
    
    .rtl table tr td:nth-child(2) {
        text-align: left;
    }
    </style>
</head>

<body>
    <div class='invoice-box'>
        <table cellpadding='0' cellspacing='0'>
            <tr class='top'>
                <td colspan='2'>
                    <table>
                        <tr>
                            <td class='title'>
                                <img src='logos/icon-1.jpeg' style='width:150px; height:70px;'>
                            </td>
                            
                            <td>
                                Order Id #: $Invoice_no<br>
                                Created: $created_at<br>
                                Due: $due_d
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class='information'>
                <td colspan='2'>
                    <table>
                        <tr>
                            <td>
                                $cust_name<br>
                                $cust_email<br>
                                $cust_addr
                            </td>
                            
                            <td>
                                $comp_name<br>
                                $comp_addr<br>
                                $comp_email
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class='heading'>
                <td>
                    Payment Method
                </td>
                
                <td>
                    Check #
                </td>
            </tr>
            
            <tr class='details'>
                <td>
                    Check
                </td>
                
                <td>
                    1000
                </td>
            </tr>
            
            <tr class='heading'>
                <td>
                    Item
                </td>
                
                <td>
                    Price
                </td>
            </tr>
            
            <tr class='item'>
                <td>
                    Website design
                </td>
                
                <td>
                    $300.00
                </td>
            </tr>
            
            <tr class='item'>
                <td>
                    Hosting (3 months)
                </td>
                
                <td>
                    $75.00
                </td>
            </tr>
            
            <tr class='item last'>
                <td>
                    Domain name (1 year)
                </td>
                
                <td>
                    $10.00
                </td>
            </tr>
            
            <tr class='total'>
                <td></td>
                
                <td>
                   Total: $385.00
                </td>
            </tr>
        </table>
    </div>
</body>
</html>";

//Generate PDF file for the data
if(isset($_POST['pdf_gen'])){
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($PDF_TEMP);
    $mpdf->Output();
}