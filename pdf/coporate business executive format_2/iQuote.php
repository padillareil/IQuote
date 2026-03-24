<?php
session_start();
require('../../config/local_db.php'); 
require('../../assets/plugins/fpdf/fpdf.php');

$QNumber = $_GET['QNUMBER'] ?? $_POST['QNumber'];

if (!$QNumber) {
    die("No QNumber provided.");
}

/*Function Decrypt Encrypted Information*/
function reil_decrypt(string $encryptedData): string {
    $key = hash('sha256', 'Greek2001', true);
    $data = base64_decode($encryptedData);
    if ($data === false || strlen($data) < 17) return '';
    $iv = substr($data, 0, 16);
    $cipher = substr($data, 16);
    $plain = openssl_decrypt($cipher, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
    return $plain === false ? '' : $plain;
}


/*User Contact number*/
// $AdminUserName = $_SESSION['UserName'];
// $AdminStmt = $conn->prepare("EXEC dbo.[USERCONTACT_PROCEDURE] ?");
// $AdminStmt->execute([$AdminUserName]);
// $adminrow = $AdminStmt->fetch(PDO::FETCH_ASSOC);
// $AdminStmt->closeCursor();

// $Landline           = $adminrow['Mobile']; /*Change to Email*/
// $Mobile             = $adminrow['Email'];



/* Query for Quotation */
$Quotation = $conn->prepare("EXEC dbo.[QNUMBER_PROCEDURE] ?;");
$Quotation->execute([$QNumber]);
$row = $Quotation->fetch(PDO::FETCH_ASSOC);
$Quotation->closeCursor(); 
if (!$row) {
    die("Quotation not found.");
}

$Customer           = $row['Customer'];
$Tin                = $row['TIN'];
$Company            = $row['Company'];
$Province           = $row['Province'];
$Municipality       = $row['Municipality'];
$Barangay           = $row['Barangay'];
$Street             = $row['Street'];
$Zipcode            = $row['Zipcode'];
$Position           = $row['Position'];
$Preparedby         = $row['Preparedby']; /* Creator */
$Signature          = $row['PSignature'];
$Branch             = $row['Branch'];
$BranchAddress      = $row['BranchAddress'];
$GrandTotal         = $row['GrandTotal'];
$DeliveryCharge     = $row['DeliveryCharge'];
$APPROVER           = $row['APPROVER'];
$ApproverPosition   = $row['ApproverPosition'];
$ApproverSignature  = $row['ApproverSignature'];
$Approveddate       = $row['Approveddate'];
$QNumber            = $row['QNumber'];
/*$ContactNumber      = $row['ContactNumber'];*/
$Mbile              = $row['Mobile'];
$Lndline            = $row['Landline'];
$PaymentTerms       = $row['PaymentTerms'];
$Installment        = $row['Installment'];
$Downpayment        = $row['Downpayment'];
$Bank               = $row['Bank'];
$AccountName        = $row['AccountName'];
$AccountNumber      = $row['AccountNumber'];
$CorpBank           = $row['CorpBank'];
$CorpAccountName    = $row['CorpAccountName'];
$CorpAccountNumber  = $row['CorpAccountNumber'];
$CashBank           = $row['CashBank'];
$CashAccountName    = $row['CashAccountName'];
$CashAccountNumber  = $row['CashAccountNumber'];
$PrintStatus        = $row['PrintStatus'];
$CorpCode           = $row['CorpCode'];

$Landline           = $row['Mobile']; /*Change to Email*/
$Mobile             = $row['Email'];


/* Convert VARBINARY signatures to base64 */
$PrepSignature = !empty($Signature) ? base64_encode($Signature) : null;
$ApproverSignature = !empty($ApproverSignature) ? base64_encode($ApproverSignature) : null;

/* Query for Orders */
$Orders = $conn->prepare("EXEC dbo.[QUOTEORDER_PROCEDURE] ?;");
$Orders->execute([$QNumber]);
$orderRows = $Orders->fetchAll(PDO::FETCH_ASSOC);
$Orders->closeCursor();
$ordersList = [];
foreach ($orderRows as $order) {
    $ordersList[] = [
        'Brand'        => $order['Brand'],
        'Model'        => $order['Model'],
        'SellingPrice' => $order['SellingPrice'],
        'DiscountedAmountPerUnit' => $order['DiscountedAmountPerUnit'],
        'Category'     => $order['CATEGORY'],
        'Quantity'     => $order['Quantity'],
        'GrossTotal'   => $order['GrossTotal']
    ];
}

/*Query Terms and Condition*/
$Termsconditon = $conn->prepare("EXEC dbo.[QUOTETERMS_PROCEDURE] ?;");
$Termsconditon->execute([$QNumber]);
$termsRows = $Termsconditon->fetchAll(PDO::FETCH_ASSOC);
$Termsconditon->closeCursor();
$TermsconditionList = [];
foreach ($termsRows as $terms) {
    $TermsconditionList[] = [
        'TermsCondition' => $terms['TermsCondition'], 
    ];
}

/*Default Terms and Condition*/
$DefaultTerms = $conn->prepare("EXEC dbo.[DEFTERMSCONDITION_PROCEDURE];");
$DefaultTerms->execute();
$DefaultTermsRows = $DefaultTerms->fetchAll(PDO::FETCH_ASSOC);
$DefaultTerms->closeCursor();
$deftermsList = [];
foreach ($DefaultTermsRows as $defterms) {  
    $deftermsList[] = [
        'DefaultTerms' => $defterms['DefaultTerms'],
    ];
}

/*Query Warranty*/
$Warranty = $conn->prepare("EXEC dbo.QUOTEWARRANTY_PROCEDURE @mQNumber = ?");
$Warranty->execute([$QNumber]);
$warrantyRows = $Warranty->fetchAll(PDO::FETCH_ASSOC);
$Warranty->closeCursor();

$warrantyList = [];
foreach ($warrantyRows as $terms) {
    $warrantyList[] = [
        'Warranty' => $terms['Warranty'],
    ];
}


/*Query for header*/
$QHeader = $conn->prepare("EXEC dbo.[PDFHEADER_PROCEDURE] ?;");
$QHeader->execute([$CorpCode]);
$headerrow = $QHeader->fetch(PDO::FETCH_ASSOC);
$QHeader->closeCursor();

$Header           = $headerrow['Header'];



/* Query for Customer Address if Personal */
$UserPersonal = $conn->prepare("EXEC dbo.[CUSTOMERDETAILS_PROCEDURE] ?;");
$UserPersonal->execute([$QNumber]);
$customerrow = $UserPersonal->fetch(PDO::FETCH_ASSOC);
$UserPersonal->closeCursor();

if ($customerrow && is_array($customerrow)) {
    $Barangay     = $customerrow['Barangay'];
    $Municipality = $customerrow['Municipality'];
    $Province     = $customerrow['Province'];
    $Company     = $customerrow['Company'];
} 

/*Website Links*/
$Website = $conn->prepare("EXEC dbo.[WEBLINKS_IMPERIAL]");
$Website->execute();
$Websiterow = $Website->fetchAll(PDO::FETCH_ASSOC);
$Website->closeCursor();

$Web_url = $Websiterow[0]['Website'];




/* Extend FPDF class to add custom header */
class PDF extends FPDF {
    public $PrintStatus = 0;
    public $HeaderPath = '';


    public $QNumber;
    public $BranchAddress;

    function Header() {

        /* Logo */
        if (!empty($this->HeaderPath) && file_exists($this->HeaderPath)) {
            $logoWidth = 170;
            $x = ($this->GetPageWidth() - $logoWidth) / 2;
            $this->Image($this->HeaderPath, $x, 3, $logoWidth);
        }

        /* PAGE 2+ : show ONLY QNumber */
        if ($this->PageNo() > 1 && !empty($this->QNumber)) {

            $this->SetFont('Arial', 'B', 9);

            // Right-aligned quotation number (same alignment as loadSubHeader)
            $this->SetXY($this->GetPageWidth() - 79, 30);
            $this->Cell(60, 4, $this->QNumber, 0, 1, 'R');
        }

        /* Branch Address (ALL pages) */
        if (!empty($this->BranchAddress)) {
            $this->loadAddress($this->BranchAddress, 50, 24, 'B');
        }

        /* Content start */
        $this->SetY(50);
    }



    /* Branch Address */
    function loadAddress($address, $x = 50, $y = 24, $style = '') {
        $this->SetXY($x, $y);
        $this->SetFont('Arial', $style, 9);
        $this->SetTextColor(209, 24, 26);
        $this->MultiCell(0, 5, $address, 0, 'L'); 
        $this->SetTextColor(0,0,0);
    }

    function loadSubHeader($customer, $company, $approvedDate, $qNumber, $x = 15, $y = 30, $lineHeight = 4) {
        global $Barangay, $Municipality, $Province; 
        $pageWidth = $this->GetPageWidth();
        $approvedDateFormatted = '';
        if (!empty($approvedDate)) {
            $approvedDateFormatted = date("F j, Y", strtotime($approvedDate));
        }
        $this->SetFont('Arial', 'B', 9);
        $this->SetXY($x, $y);
        $this->Cell(100, $lineHeight, $approvedDateFormatted, 0, 0, 'L');

        $this->SetXY($pageWidth - 79, $y);
        $this->Cell(60, $lineHeight, $qNumber, 0, 1, 'R');
        $addressLine = trim($Barangay) . ', ' . trim($Municipality) . ', ' . trim($Province);
        if (strtolower(trim($company)) === 'personal') {
            $this->SetXY($x, $y + $lineHeight + 2);
            $this->Cell(100, $lineHeight, $customer, 0, 1, 'L');
            $this->SetX($x);
            $this->Cell(100, $lineHeight, $addressLine, 0, 1, 'L');
        } else {
            $this->SetXY($x, $y + $lineHeight + 2);
            $this->Cell(100, $lineHeight, $company, 0, 1, 'L');
            $this->SetX($x);
            $this->Cell(100, $lineHeight, $addressLine, 0, 1, 'L');
        }
    }





    /* Orders Table with automatic page breaks */
   function loadOrdersTable($ordersList, $HeaderPath, $x = 15, $y = 50, $lineHeight = 6, $deliveryCharge = 0, $grandTotal = 0) {
       $this->HeaderPath = $HeaderPath; // for repeated header

       $this->SetXY($x, $y);
       $this->SetFont('Arial', '', 9);

       // Intro text
       $this->Cell(0, $lineHeight, "Dear Sir/Ma'am,", 0, 0, 'L');
       $y = $this->GetY() + 4;
       $this->SetXY($x, $y);
       $this->Cell(0, $lineHeight, "Imperial Appliance Plaza is pleased to submit a quotation for the following:", 0, 1, 'C');
       $y = $this->GetY() + 2;

       $widths = [15, 70, 30, 30, 30];
       $header = ['QTY', 'BRAND/MODEL', 'UNIT PRICE', 'DISCOUNTED PRICE', 'TOTAL AMOUNT'];
       $totalWidth = array_sum($widths);
       $startX = ($this->GetPageWidth() - $totalWidth) / 2;

       // Table header
       $printTableHeader = function() use ($startX, $widths, $lineHeight, $header) {
           $this->SetXY($startX, $this->GetY());
           $this->SetFont('Arial', 'B', 8);
           $this->SetFillColor(253, 237, 7);
           $this->SetDrawColor(0);
           foreach ($header as $i => $col) {
               $this->Cell($widths[$i], $lineHeight, $col, 1, 0, 'C', true);
           }
           $this->Ln();
           $this->SetFont('Arial', '', 8);
       };

       $printTableHeader();

       foreach ($ordersList as $order) {
           // Page break
           if ($this->GetY() + $lineHeight + 60 > ($this->GetPageHeight() - 70)) { 
               $this->AddPage();
               $this->loadHeader($this->HeaderPath);
               $printTableHeader();
           }

           $x = $startX;
           $y = $this->GetY();

           // 1️⃣ QTY cell (fixed)
           $this->SetXY($x, $y);

           // 2️⃣ Brand/Model MultiCell (calculate dynamic height)
           $this->SetXY($x + $widths[0], $y); // move right of QTY
           $currentX = $this->GetX();
           $currentY = $this->GetY();
           $this->MultiCell($widths[1], $lineHeight, $order['Brand'] . " / " . $order['Model'], 1, 'L');
           $brandHeight = $this->GetY() - $currentY;

           // 3️⃣ Draw QTY with the same height
           $this->SetXY($x, $y);
           $this->Cell($widths[0], $brandHeight, $order['Quantity'], 1, 0, 'C');

           // 4️⃣ Draw Unit Price, Discounted Price, Total Amount
           $this->SetXY($x + $widths[0] + $widths[1], $y);
           $this->Cell($widths[2], $brandHeight, number_format($order['SellingPrice'], 2), 1, 0, 'C');
           $this->Cell($widths[3], $brandHeight, number_format($order['DiscountedAmountPerUnit'], 2), 1, 0, 'C');
           $this->Cell($widths[4], $brandHeight, number_format($order['GrossTotal'], 2), 1, 0, 'C');

           // 5️⃣ Move to next row
           $this->Ln($brandHeight);
       }

       // Delivery Charge
       $this->SetX($startX);
       $this->SetFont('Arial', 'B', 8);
       $this->Cell(array_sum(array_slice($widths, 0, 4)), $lineHeight, 'DELIVERY CHARGE', 1, 0, 'C');
       $this->Cell($widths[4], $lineHeight, number_format($deliveryCharge, 2), 1, 0, 'C');
       $this->Ln();

       // Grand Total
       $this->SetX($startX);
       $this->Cell(array_sum(array_slice($widths, 0, 4)), $lineHeight, 'GRAND TOTAL', 1, 0, 'C');
       $this->Cell($widths[4], $lineHeight, number_format($grandTotal, 2), 1, 0, 'C');
       $this->Ln();
   }

    /* Terms & Conditions */
    function loadTermsCondition(
        $deftermsList,
        $TermsconditionList = [], 
        $PaymentTerms = '',
        $Installment = '',
        $Downpayment = '',
        $Company = '',
        $Bank = '',
        $AccountName = '',
        $AccountNumber = '',
        $CorpBank = '',
        $CorpAccountName = '',
        $CorpAccountNumber = '',
        $CashBank = '',
        $CashAccountName = '',
        $CashAccountNumber = '',
        $x = 15,
        $y = 110,
        $lineHeight = 4
    ) {
        $this->SetXY($x, $y);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(0, $lineHeight, "Terms & Conditions", 0, 1, 'L');

        $y = $this->GetY() + 2;
        $this->SetXY($x, $y);
        $this->SetFont('Arial', '', 8);

        $termIndex = 1;

        // 1. Default Terms
        foreach ($deftermsList as $term) {
            $text = "{$termIndex}. " . $term['DefaultTerms'];
            $this->MultiCell(0, $lineHeight, $text, 0, 'L');
            $y = $this->GetY();
            $this->SetXY($x, $y);
            $termIndex++;
        }

        // 2. Payment Terms (switch)
        if (!empty($PaymentTerms)) {
            switch ($PaymentTerms) {
                case 'Installment':

                   if (trim($Company) === 'PERSONAL') {
                        // Terms for Personal customers
                        $texts = [
                            "For installment payments, the payment term is {$Installment}, and a {$Downpayment} down payment is required before processing the order.",
                            "The payment may be made in cash, or alternatively, via bank transfer to the following details:\n         Bank: BDO\n         Account Name: IMPERIAL APPLIANCE PLAZA\n         Account Number: 0031-004-313-10",
                            "The payment can be made via check with the following details:\n         Bank: {$CashBank}\n         Account Name: {$CashAccountName}\n         Account Number: {$CashAccountNumber}",
                            "Delivery lead time:\n        a. On-hand Stock: 1 to 2 days after payment confirmation, depending on availability and branch delivery schedule."
                        ];
                    } else {
                        // Terms for Corporate customers
                        $texts = [
                            "For installment payments, the payment term is {$Installment}, and a {$Downpayment} down payment is required before processing the order.",
                            "Payment can be made in cash.",
                            "Payment can be made through bank transfer or by check using the following details:\n         Bank: {$CorpBank}\n         Account Name: {$CorpAccountName}\n         Account Number: {$CorpAccountNumber}\n         For check payment,\n         a. On-Us Check (issued by the same bank) requires 3-banking days clearing period.\n         b. An Interbank Check (from a different bank) also requires 3-banking days clearing period.",
                          
                            "Delivery lead time:\n        a. On-hand Stock: 1 to 2 days after payment confirmation, depending on availability and branch delivery schedule."
                        ];
                    }

                    foreach ($texts as $text) {
                        $this->MultiCell(0, $lineHeight, "{$termIndex}. {$text}", 0, 'L');
                        $y = $this->GetY();
                        $this->SetXY($x, $y);
                        $termIndex++;
                    }

                    break;

                case 'Cash':
                   if (trim($Company) === 'PERSONAL') {
                        // Terms for Personal customers
                        $texts = [
                            "The payment may be made in cash, or alternatively, via bank transfer to the following details:\n         Bank: BDO\n         Account Name: IMPERIAL APPLIANCE PLAZA\n         Account Number: 0031-004-313-10",
                            "The payment can be made via check with the following details:\n         Bank: {$CashBank}\n         Account Name: {$CashAccountName}\n         Account Number: {$CashAccountNumber}\n         a. On-Us Check (from the same bank) will require a 3-banking day clearing period.\n         b. An Interbank (from a different bank) will also require a 3-banking day clearing period.",
                            "Delivery lead time:\n        a. On-hand Stock: 1 to 2 days after payment confirmation, depending on availability and the branch delivery schedule."
                        ];
                    } else {
                        // Terms for Corporate customers
                        $texts = [
                            "Payment can be made in cash.",
                            "Payment can be made through bank transfer or by check using the following details:\n         Bank: {$CorpBank}\n         Account Name: {$CorpAccountName}\n         Account Number: {$CorpAccountNumber}\n         For check payment,\n         a. On-Us Check (issued by the same bank) requires 3-banking days clearing period.\n         b. An Interbank Check (from a different bank) also requires 3-banking days clearing period.",
                          
                            "Delivery lead time:\n        a. On-hand Stock: 1 to 2 days after payment confirmation, depending on availability and branch delivery schedule."
                        ];
                    }

                    foreach ($texts as $text) {
                        $this->MultiCell(0, $lineHeight, "{$termIndex}. {$text}", 0, 'L');
                        $y = $this->GetY();
                        $this->SetXY($x, $y);
                        $termIndex++;
                    }
                    break;

                case 'Debit/Credit Card':
                   if (trim($Company) === 'PERSONAL') {
                        // Terms for Personal customers
                        $texts = [
                            "For payment via debit/credit card, the card must be presented by the card holder to process the payment.",
                            "The payment can be made in cash, or alternatively, via bank transfer to the following details:\n         Bank: BDO\n         Account Name: IMPERIAL APPLIANCE PLAZA\n         Account Number: 0031-004-313-10\n         a. On-Us Check (from the same bank) will require a 3-banking day clearing period.\n         b. An Interbank (from a different bank) will also require a 3-banking day clearing period.",
                            "The payment can be made via check with the following details:\n         Bank: {$CashBank}\n         Account Name: {$CashAccountName}\n         Account Number: {$CashAccountNumber}\n         a. An On-Us Check (from the same bank) will require a 3-banking day clearing period.\n         b. An Interbank (from the other bank) will also require 3-banking day clearing period.",
                            
                            "Delivery lead time:\n        a. On-hand Stock: 1 to 2 days after payment confirmation, depending on availability and the branch delivery schedule."
                        ];
                    } else {
                        // Terms for Corporate customers
                        $texts = [
                            "For payment via debit/credit card, the card must be presented by the card holder to process the payment.",
                            "Payment can be made in cash.",
                            "Payment can be made through bank transfer or by check using the following details:\n         Bank: {$CorpBank}\n         Account Name: {$CorpAccountName}\n         Account Number: {$CorpAccountNumber}\n         For check payment,\n         a. On-Us Check (issued by the same bank) requires 3-banking days clearing period.\n         b. An Interbank Check (from a different bank) also requires 3-banking days clearing period.",
                          
                            "Delivery lead time:\n        a. On-hand Stock: 1 to 2 days after payment confirmation, depending on availability and branch delivery schedule."
                        ];
                    }

                    foreach ($texts as $text) {
                        $this->MultiCell(0, $lineHeight, "{$termIndex}. {$text}", 0, 'L');
                        $y = $this->GetY();
                        $this->SetXY($x, $y);
                        $termIndex++;
                    }
                    break;

                case 'Bank Transfer':
                   if (trim(strtolower($Company)) === 'PERSONAL') {
                        // Terms for Personal customers
                        $texts = [
                            "Payment can be made in cash.",
                            "The payment can be made via bank transfer to the following details:\n         Bank: {$Bank}\n         Account Name: {$AccountName}\n         Account Number: {$AccountNumber}",

                            "The payment can be made via check with the following details:\n         Bank: {$CashBank}\n         Account Name: {$CashAccountName}\n         Account Number: {$CashAccountNumber}\n         a. On-Us Check (from the same bank) will require a 3-banking day clearing period.\n         b. An Interbank (from a different bank) will also require a 3-banking day clearing period.",


                            "Delivery lead time:\n        a. On-hand Stock: 1 to 2 days after payment confirmation, depending on availability and the branch delivery schedule."
                        ];
                    } else {
                        // Terms for Corporate customers
                        $texts = [
                            "Payment can be made in cash.",
                            "Payment can be made through bank transfer or by check using the following details:\n         Bank: {$Bank}\n         Account Name: {$AccountName}\n         Account Number: {$AccountNumber}\n         For check payment,\n         a. On-Us Check (issued by the same bank) requires 3-banking days clearing period.\n         b. An Interbank Check (from a different bank) also requires 3-banking days clearing period.",
                          
                            "Delivery lead time:\n        a. On-hand Stock: 1 to 2 days after payment confirmation, depending on availability and branch delivery schedule."
                        ];
                    }

                    foreach ($texts as $text) {
                        $this->MultiCell(0, $lineHeight, "{$termIndex}. {$text}", 0, 'L');
                        $y = $this->GetY();
                        $this->SetXY($x, $y);
                        $termIndex++;
                    }
                    break;
                
                case 'Check':
                    if (trim(strtolower($Company)) === 'PERSONAL') {
                         // Terms for Personal customers
                         $texts = [
                             "The payment may be made in cash, or alternatively, via bank transfer to the following details:\n         Bank: BDO\n         Account Name: IMPERIAL APPLIANCE PLAZA\n         Account Number: 0031-004-313-10",
                             "The payment can be made via check with the following details:\n         Bank: {$CashBank}\n         Account Name: {$CashAccountName}\n         Account Number: {$CashAccountNumber}\n         a. On-Us Check (from the same bank) will require a 3-banking day clearing period.\n         b. An Interbank (from a different bank) will also require a 3-banking day clearing period.",
                             "Delivery lead time:\n        a. On-hand Stock: 1 to 2 days after payment confirmation, depending on availability and the branch delivery schedule."
                         ];
                     } else {
                         // Terms for Corporate customers
                         $texts = [
                             "Payment can be made in cash.",
                             "Payment can be made through bank transfer or by check using the following details:\n         Bank: {$Bank}\n         Account Name: {$AccountName}\n         Account Number: {$AccountNumber}\n         For check payment,\n         a. On-Us Check (issued by the same bank) requires 3-banking days clearing period.\n         b. An Interbank Check (from a different bank) also requires 3-banking days clearing period.",
                           
                             "Delivery lead time:\n        a. On-hand Stock: 1 to 2 days after payment confirmation, depending on availability and branch delivery schedule."
                         ];
                     }

                     foreach ($texts as $text) {
                         $this->MultiCell(0, $lineHeight, "{$termIndex}. {$text}", 0, 'L');
                         $y = $this->GetY();
                         $this->SetXY($x, $y);
                         $termIndex++;
                     }
                     break;
            }
        }


        // 3. Quotation-specific Terms (user-created)
        foreach ($TermsconditionList as $term) {
            $this->MultiCell(0, $lineHeight, "{$termIndex}. " . $term['TermsCondition'], 0, 'L');
            $termIndex++;
            $y = $this->GetY();
            $this->SetXY($x, $y);
        }
    }

    function loadWarranty($warrantyList, $x = 15, $y = 180, $lineHeight = 6) {
        $this->SetXY($x, $y);
        $this->SetFont('Arial', 'B', 9); // Bold for title
        $this->Cell(0, $lineHeight, "Warranty", 0, 1, 'L');

        $y = $this->GetY() + 2;
        $this->SetXY($x, $y);
        $this->SetFont('Arial', '', 8);

        $counter = 1;
        foreach ($warrantyList as $w) {
            $text = $counter . ". " . $w['Warranty'];
            $this->MultiCell(0, $lineHeight, $text, 0, 'L');
            $y = $this->GetY();
            $this->SetXY($x, $y);
            $counter++;
        }
    }

    function loadCompanyNotes($x = 15, $y = null, $lineHeight = 6, $landline = '', $mobile = '', $Web_url = '') {
        if ($y === null) $y = $this->GetY() + 10;
        $this->SetXY($x, $y);

        // Reset font
        $this->SetFont('Arial', '', 8);
        $this->SetTextColor(0, 0, 0);

        // --------------------------
        // Contact Info
        // --------------------------
        $contactText = '';
        if (!empty($landline) && !empty($mobile)) {
            $contactText = "For further information, please feel free to contact us: $landline | $mobile.";
        } elseif (!empty($landline)) {
            $contactText = "For further information, please feel free to contact us: $landline.";
        } elseif (!empty($mobile)) {
            $contactText = "For further information, please feel free to contact us: $mobile.";
        }

        if (!empty($contactText)) {
            $this->SetX($x);
            $this->MultiCell(0, $lineHeight, $contactText, 0, 'L');
        }

        // --------------------------
        // Closing Text
        // --------------------------
        $this->SetX($x);
        $closingText = "Thank you very much, and we shall be looking forward to a beneficial business relationship with you in the future.";
        $this->MultiCell(0, $lineHeight, $closingText, 0, 'L');

        // --------------------------
        // Website
        // --------------------------
        if (!empty($Web_url)) {
            $this->SetX($x);
            $this->SetFont('', '');
            $this->SetTextColor(0, 0, 0);
            $this->Write($lineHeight, "You can visit our website: ");
            $this->SetTextColor(0, 0, 255);
            $this->SetFont('', 'U');
            $this->Write($lineHeight, $Web_url, $Web_url);
            $this->SetFont('', '');
            $this->SetTextColor(0, 0, 0);
            $this->Ln($lineHeight); // add spacing after website
        }

        // --------------------------
        // Note for next page
        // --------------------------
        $this->Ln(5);
        $note = "Page 1 of 2 - continued on next page.";
        $this->SetX($x);              // align with contact & website
        $this->SetFont('Arial', 'I', 8); // italic note
        $this->SetTextColor(0, 0, 0);
        $this->MultiCell(0, $lineHeight, $note, 0, 'L');
    }




    function loadAuthorities(
        $preparedBy, 
        $preparedPosition, 
        $preparedSignature, // base64
        $approver, 
        $approverPosition, 
        $approverSignature, // base64
        $y = 250,
        $signatureWidth = 50, 
        $signatureHeight = 50,
        $preparedSigOffsetY = 35,   
        $approverSigOffsetY = 35    
    ) {
        $pageWidth       = $this->GetPageWidth();
        $labelHeight     = -80; 
        $nameHeight      = 4; 
        $positionHeight  = 4; 
        $leftX           = 5;

        // ===== LEFT COLUMN (Prepared by) =====
        $this->SetFont('Arial', '', 8);
        $this->SetXY($leftX, $y);
        $this->Cell(60, $labelHeight, "Prepared by:", 0, 0, 'C');

        $this->SetFont('Arial', 'B', 9);
        $this->SetXY($leftX, $y + $labelHeight + $signatureHeight + 6);
        $this->Cell(60, $nameHeight, $preparedBy, 0, 0, 'C');

        $this->SetFont('Arial', '', 8);
        $this->SetXY($leftX, $y + $labelHeight + $signatureHeight + 10);
        $this->Cell(60, $positionHeight, $preparedPosition, 0, 0, 'C');

        // Draw Prepared Signature
        if (!empty($preparedSignature)) {
            $tmpFile = tempnam(sys_get_temp_dir(), 'prep_sig_') . '.png';
            file_put_contents($tmpFile, base64_decode($preparedSignature));

            $this->Image(
                $tmpFile,
                $leftX + (60 - $signatureWidth) / 2,
                $y + $labelHeight + $preparedSigOffsetY,
                $signatureWidth,
                $signatureHeight
            );

            unlink($tmpFile); // delete temp file after use
        }

        // ===== RIGHT COLUMN (Approved by) =====
        if (trim(strtolower($approver)) !== trim(strtolower($preparedBy))) {
            $rightX = $pageWidth - 70;

            $this->SetFont('Arial', '', 8);
            $this->SetXY($rightX, $y);
            $this->Cell(60, $labelHeight, "Approved by:", 0, 0, 'C');

            $this->SetFont('Arial', 'B', 9);
            $this->SetXY($rightX, $y + $labelHeight + $signatureHeight + 6);
            $this->Cell(60, $nameHeight, $approver, 0, 0, 'C');

            $this->SetFont('Arial', '', 8);
            $this->SetXY($rightX, $y + $labelHeight + $signatureHeight + 10);
            $this->Cell(60, $positionHeight, $approverPosition, 0, 0, 'C');

            if (!empty($approverSignature)) {
                $tmpFile = tempnam(sys_get_temp_dir(), 'appr_sig_') . '.png';
                file_put_contents($tmpFile, base64_decode($approverSignature));

                $this->Image(
                    $tmpFile,
                    $rightX + (60 - $signatureWidth) / 2,
                    $y + $labelHeight + $approverSigOffsetY,
                    $signatureWidth,
                    $signatureHeight
                );

                unlink($tmpFile);
            }
        }
    }


   function Footer() {
       $footerFile = '../../assets/image/footer/footer.jpg';
       $footerWidth = 180;
       $pageWidth = $this->GetPageWidth();
       $pageHeight = $this->GetPageHeight();
       $x = ($pageWidth - $footerWidth) / 2;

       // Calculate footer image height
       list($imgWidth, $imgHeight) = getimagesize($footerFile);
       $footerHeight = ($footerWidth / $imgWidth) * $imgHeight;
       $y = $pageHeight - $footerHeight - 10;

       // Optional Re-Printed note
       if (!empty($this->PrintStatus) && $this->PrintStatus > 1) {
           $this->SetFont('Arial', 'I', 8);
           $this->SetXY(0, $y - 20);
           $this->Cell($pageWidth, 10, '', 0, 0, 'C');
           /*$this->Cell($pageWidth, 10, '*** Re-Printed ***', 0, 0, 'C');*/ /*Supposed to be this is the original for reprinted*/

       }

       // Warning / Instruction text above footer image
       $this->SetFont('Arial', 'I', 9);
       $this->SetXY(10, $y - 5);
       $this->Cell(
           $pageWidth - 20,
           5,
           "*** Please present this quotation and required documents when claiming the items or processing your request ***",
           0,
           0,
           'C'
       );

       // Footer image
       $this->Image($footerFile, $x, $y, $footerWidth);

       // -------------------------------
       // Centered page number BELOW footer
       // -------------------------------
       $this->SetFont('Arial', 'I', 8);
       $this->SetXY(0, $y + $footerHeight + 2); // 2mm below footer image
       $this->Cell($pageWidth, 5, 'Page ' . $this->PageNo(), 0, 0, 'C');
   }

}


$orderCount = count($ordersList);

// ==========================
// Initialize PDF
// ==========================
$pdf = new PDF('P', 'mm', 'Letter');
$pdf->PrintStatus = intval($row['PrintStatus']);
$pdf->HeaderPath = '../../' . $headerrow['Header']; // header auto-repeat on all pages
$pdf->QNumber       = $QNumber;
$pdf->BranchAddress = !empty($BranchAddress) ? $BranchAddress : "";

// ==========================
// PAGE 1: Header, SubHeader, Orders, Signatures, Company Notes
// ==========================
$pdf->AddPage();

// SubHeader & Address
$pdf->loadSubHeader($Customer, $Company, $Approveddate, $QNumber);
$address = !empty($BranchAddress) ? $BranchAddress : "";
$pdf->loadAddress($address, 50, 24, 'B');

// Orders Table
$pdf->loadOrdersTable(
    $ordersList,
    $pdf->HeaderPath,
    15,     // X position
    50,     // Y start
    6,      // Line height
    $DeliveryCharge,
    $GrandTotal
);

// Place Company Notes (contact info, closing, website) below signatures
$pdf->loadCompanyNotes(15, null, 6, $Landline, $Mobile, $Web_url);
// Place Signatures immediately after Orders
$y = $pdf->GetY() + 10; // margin below orders table
$pdf->loadAuthorities(
    $Preparedby,
    $Position,
    $PrepSignature,        // base64
    $APPROVER,
    $ApproverPosition,
    $ApproverSignature     // base64
);



// ==========================
// PAGE 2: Terms & Warranty (if not enough space on first page)
// ==========================
$y = $pdf->GetY() + 15; // start after signatures/notes
$termsHeight = 80; 
$spaceLeft = $pdf->GetPageHeight() - $y - 70; // reserve footer space

if ($spaceLeft < $termsHeight) {
    $pdf->AddPage();  // add a new page for Terms & Warranty
    $y = 40;          // margin below header
}

// Terms & Conditions
$pdf->loadTermsCondition(
    $deftermsList,
    $TermsconditionList,
    $row['PaymentTerms'],
    $row['Installment'],
    $row['Downpayment'],
    $Company,
    $row['Bank'],
    reil_decrypt($row['AccountName']),
    reil_decrypt($row['AccountNumber']),
    $row['CorpBank'],
    reil_decrypt($row['CorpAccountName']),
    reil_decrypt($row['CorpAccountNumber']),
    $row['CashBank'],
    reil_decrypt($row['CashAccountName']),
    reil_decrypt($row['CashAccountNumber']),
    15,     // X position
    $y,     // Y position
    4       // line height
);

// Warranty Section (optional on page 2 or remaining space)
$y = $pdf->GetY() + 10;
$pdf->loadWarranty($warrantyList, 15, $y, 4);

// ==========================
// Output PDF
// ==========================
$pdf->Output('I', "Quotation.pdf");

?>
