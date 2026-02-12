<?php
session_start();
require('../config/local_db.php'); 
require('../assets/plugins/fpdf/fpdf.php');

$QNumber = $_GET['QNUMBER'] ?? $_POST['QNumber'];

if (!$QNumber) {
    die("No QNumber provided.");
}

/*User Contact number*/
$AdminUserName = $_SESSION['UserName'];
$AdminStmt = $conn->prepare("CALL UserContact_Procedure(?)");
$AdminStmt->execute([$AdminUserName]);
$adminrow = $AdminStmt->fetch(PDO::FETCH_ASSOC);
$AdminStmt->closeCursor();

$Landline           = $adminrow['Landline'];
$Mobile             = $adminrow['Mobile'];


/* Query for Quotation */
$Quotation = $conn->prepare("CALL QNumber_Procedure(?);");
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
$Signature          = $row['Signature'];
$Branch             = $row['Branch'];
$BranchAddress      = $row['BranchAddress'];
$GrandTotal         = $row['GrandTotal'];
$DeliveryCharge     = $row['DeliveryCharge'];
$APPROVER           = $row['APPROVER'];
$ApproverPosition   = $row['ApproverPosition'];
$ApproverSignature  = $row['ApproverSignature'];
$Approveddate       = $row['Approveddate'];
$QNumber            = $row['QNumber'];
$ContactNumber      = $row['ContactNumber'];
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
      

/* Query for Orders */
$Orders = $conn->prepare("CALL QuoteOrder_Procedure(?);");
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
$Termsconditon = $conn->prepare("CALL QuoteTerms_Procedure(?);");
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
$DefaultTerms = $conn->prepare("CALL DefTermsCondition_Procedure();");
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
$Warranty = $conn->prepare("CALL QuoteWarranty_Procedure(?);");
$Warranty->execute([$QNumber]);
$warrantyRows = $Warranty->fetchAll(PDO::FETCH_ASSOC);
$Warranty->closeCursor();
$warrantyList = [];
foreach ($warrantyRows as $terms) {
    $warrantyList[] = [
        'Warranty'        => $terms['Warranty'],
    ];
}

/*Query for header*/
$QHeader = $conn->prepare("CALL PDFHeader_Procedure(?)");
$QHeader->execute([$CorpCode]);
$headerrow = $QHeader->fetch(PDO::FETCH_ASSOC);
$QHeader->closeCursor();

$Header           = $headerrow['Header'];



/* Query for Customer Address if Personal */
$UserPersonal = $conn->prepare("CALL CustomerDetails_Procedure(?)");
$UserPersonal->execute([$QNumber]);
$customerrow = $UserPersonal->fetch(PDO::FETCH_ASSOC);
$UserPersonal->closeCursor();

if ($customerrow && is_array($customerrow)) {
    $Barangay     = $customerrow['Barangay'];
    $Municipality = $customerrow['Municipality'];
    $Province     = $customerrow['Province'];
} 



/* Extend FPDF class to add custom header */
class PDF extends FPDF {
    /* Quotation Header */
    /*function loadHeader() {
        $this->SetTitle('Imperial Appliance Plaza');
        $logoFile = '../assets/image/header/SOLU.png';
        $logoWidth = 170;
        $pageWidth = $this->GetPageWidth();
        $x = ($pageWidth - $logoWidth) / 2;
        $this->Image($logoFile, $x, 3, $logoWidth);
        $this->SetY(50);
    }*/
    function loadHeader($Header) {
        $this->SetTitle('Imperial Appliance Plaza');
        if (!file_exists($Header)) {
            throw new Exception("Header image not found: " . $Header);
        }

        $logoWidth = 170;
        $pageWidth = $this->GetPageWidth();
        $x = ($pageWidth - $logoWidth) / 2;

        $this->Image($Header, $x, 3, $logoWidth);
        $this->SetY(50);
    }


    /* Branch Address */
    function loadAddress($address, $x = 50, $y = 24, $style = '') {
        $this->SetXY($x, $y);
        $this->SetFont('Arial', $style, 9);
        $this->SetTextColor(209, 24, 26); // #d1181a
        $this->MultiCell(0, 5, $address, 0, 'L'); 
    }

    /*Function Subheader Details*/
    function loadSubHeader($customer, $company, $approvedDate, $qNumber, $x = 15, $y = 30, $lineHeight = 4) {
        $pageWidth = $this->GetPageWidth();
        $this->SetFont('Arial', 'B', 9);
        $this->SetXY($x, $y);
        $this->Cell(100, $lineHeight, $approvedDate, 0, 0, 'L');
        $this->SetFont('Arial', 'B', 9);
        $this->SetXY($pageWidth - 79, $y);
        $this->Cell(60, $lineHeight, $qNumber, 0, 1, 'R');
        $this->SetFont('Arial', 'B', 9);
        $this->SetXY($x, $y + $lineHeight + 2);
        $this->Cell(100, $lineHeight, $customer, 0, 1, 'L');
        if (strtolower(trim($company)) !== 'personal') {
            $this->SetX($x);
            $this->Cell(100, $lineHeight, $company, 0, 1, 'L');
        } else {
            global $Barangay, $Municipality, $Province; 
            $addressLine = trim($Barangay) . ', ' . trim($Municipality) . ', ' . trim($Province);
            $this->SetX($x);
            $this->Cell(100, $lineHeight, $addressLine, 0, 1, 'L');
        }

        // Reset text color back to black
        $this->SetTextColor(0, 0, 0);
    }

    /*Function Item Orders*/
    function loadOrdersTable(
        $ordersList, 
        $x = 15, 
        $y = 50, 
        $lineHeight = 6, 
        $deliveryCharge = 0, 
        $grandTotal = 0
    ) {
        $this->SetXY($x, $y);
        $this->SetFont('Arial', '', 9);
        $this->Cell(0, $lineHeight, "Dear Sir/Ma'am,", 0, 0, 'L');
        $y = $this->GetY() + 4;
        $this->SetXY($x, $y);
        $this->SetFont('Arial', '', 9);
        $this->Cell(0, $lineHeight, "Imperial Appliance Plaza is pleased to submit a quotation for the following:", 0, 1, 'C');
        $y = $this->GetY() + 0;
        $widths = [15, 70, 30, 30, 30];
        $header = ['QTY', 'BRAND/MODEL', 'UNIT PRICE', 'DISCOUNTED PRICE', 'TOTAL AMOUNT'];
        $totalWidth = array_sum($widths);
        $startX = ($this->GetPageWidth() - $totalWidth) / 2;
        $this->SetXY($startX, $y);
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(253, 237, 7);
        $this->SetDrawColor(0);
        foreach ($header as $i => $col) {
            $align = ($i == 1) ? 'C' : 'C'; 
            $this->Cell($widths[$i], $lineHeight, $col, 1, 0, $align, true);
        }
        $this->Ln();
        $this->SetFont('Arial', '', 8);
        foreach ($ordersList as $order) {
            $this->SetX($startX); 
            $this->Cell($widths[0], $lineHeight, $order['Quantity'], 1, 0, 'C');
            $this->Cell($widths[1], $lineHeight, $order['Brand'] . " / " . $order['Model'], 1, 0, 'L');
            $this->Cell($widths[2], $lineHeight, number_format($order['SellingPrice'], 2), 1, 0, 'C'); 
            $this->Cell($widths[3], $lineHeight, number_format($order['DiscountedAmountPerUnit'], 2), 1, 0, 'C'); 
            $this->Cell($widths[4], $lineHeight, number_format($order['GrossTotal'], 2), 1, 0, 'C'); 
            $this->Ln();
        }
        $this->SetX($startX);
        $this->SetFont('Arial', 'B', 8); 
        $this->Cell(array_sum(array_slice($widths, 0, 4)), $lineHeight, 'DELIVERY CHARGE', 1, 0, 'C');
        $this->SetFont('Arial', '', 8); 
        $this->Cell($widths[4], $lineHeight, number_format($deliveryCharge, 2), 1, 0, 'C');
        $this->Ln();
        $this->SetX($startX);
        $this->SetFont('Arial', 'B', 8); 
        $this->Cell(array_sum(array_slice($widths, 0, 4)), $lineHeight, 'GRAND TOTAL', 1, 0, 'C');
        $this->SetFont('Arial', '', 8); 
        $this->Cell($widths[4], $lineHeight, number_format($grandTotal, 2), 1, 0, 'C');
        $this->Ln();
    }


    /*Function load Terms and condition*/
    function loadTermsCondition(
        $deftermsList,
        $TermsconditionList = [], 
        $PaymentTerms = '',
        $Installment = '',
        $Downpayment = '',
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
                    $down = $Downpayment ?: "N/A";
                    $inst = $Installment ?: "N/A";

                    $texts = [
                        "For installment payments, the payment term is {$inst}, and a {$down} down payment is required before processing the order.",
                        "Payment can also be made via cash, or bank transfer to the following:\n    Bank: {$Bank}\n    Account Name: {$AccountName}\n    Account Number: {$AccountNumber}",
                        "Alternative bank transfer or check payment:\n    Bank: {$CashBank}\n    Account Name: {$CashAccountName}\n    Account Number: {$CashAccountNumber}\n    a. On-Us check requires 3 banking days to clear.\n    b. Interbank check requires 3 banking days to clear.",
                        "Delivery lead time:\n    On-hand Stock: 1 to 2 days after payment confirmation, depending on availability and branch delivery schedule."
                    ];

                    foreach ($texts as $text) {
                        $this->MultiCell(0, $lineHeight, "{$termIndex}. {$text}", 0, 'L');
                        $y = $this->GetY();
                        $this->SetXY($x, $y);
                        $termIndex++;
                    }
                    break;

                case 'Cash':
                    $texts = [
                        "Payment can be made in cash.",
                        "Bank transfer or check payment:\n    Bank: {$CorpBank}\n    Account Name: {$CorpAccountName}\n    Account Number: {$CorpAccountNumber}",
                        "Delivery lead time:\n    On-hand Stock: 1 to 2 days after payment confirmation, depending on availability and branch delivery schedule."
                    ];

                    foreach ($texts as $text) {
                        $this->MultiCell(0, $lineHeight, "{$termIndex}. {$text}", 0, 'L');
                        $y = $this->GetY();
                        $this->SetXY($x, $y);
                        $termIndex++;
                    }
                    break;

                case 'Check':
                    $texts = [
                        "Payment can be made via check or bank transfer:\n    Bank: {$Bank}\n    Account Name: {$AccountName}\n    Account Number: {$AccountNumber}",
                        "Delivery lead time:\n    On-hand Stock: 1 to 2 days after payment confirmation, depending on availability and branch delivery schedule."
                    ];

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

    /*Function load Warranty*/
    function loadWarranty(
        $warrantyList, 
        $x = 15, 
        $y = 180, 
        $lineHeight = 6, 
        $contactNumber = ''
    ) {
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
        $y += $lineHeight;
        $this->SetXY($x, $y);
        if (!empty($contactNumber)) {
            $this->MultiCell(0, $lineHeight, "For further information, please feel free to call us: $contactNumber", 0, 'L');
            $y = $this->GetY();
            $this->SetXY($x, $y);
        }
        $closingText = "Thank you very much, and we shall be looking forward to a beneficial business relationship with you in the future.";
        $this->MultiCell(0, $lineHeight, $closingText, 0, 'L');
    }



    /*Function Approver and creator*/
    function loadAuthorities(
        $preparedBy, $preparedPosition, $preparedSignature, 
        $approver, $approverPosition, $approverSignature, 
        $y = 260,
        $signatureWidth = 50, 
        $signatureHeight = 50,
        $preparedSigOffsetY = 30,   
        $approverSigOffsetY = 30    
    ) {
        $pageWidth       = $this->GetPageWidth();
        $labelHeight     = -80; 
        $nameHeight      = 4; 
        $positionHeight  = 4; 
        $leftX           = 5;
        if (!empty($preparedSignature)) {
            $preparedSignature = '../' . ltrim($preparedSignature, '/');
        }
        if (!empty($approverSignature)) {
            $approverSignature = '../' . ltrim($approverSignature, '/');
        }

        // ===== LEFT COLUMN =====
        // Label
        $this->SetFont('Arial', '', 8);
        $this->SetXY($leftX, $y);
        $this->Cell(60, $labelHeight, "Prepared by:", 0, 0, 'C');

        // Name + Position (aligned with label)
        $this->SetFont('Arial', 'B', 9);
        $this->SetXY($leftX, $y + $labelHeight + $signatureHeight + 6);
        $this->Cell(60, $nameHeight, $preparedBy, 0, 0, 'C');

        $this->SetFont('Arial', '', 9);
        $this->SetXY($leftX, $y + $labelHeight + $signatureHeight + 10);
        $this->Cell(60, $positionHeight, $preparedPosition, 0, 0, 'C');

        // Signature (separate positioning)
        if (!empty($preparedSignature) && file_exists($preparedSignature)) {
            $this->Image(
                $preparedSignature,
                $leftX + (60 - $signatureWidth) / 2,
                $y + $labelHeight + $preparedSigOffsetY,
                $signatureWidth,
                $signatureHeight
            );
        }

        // ===== RIGHT COLUMN =====
        $rightX = $pageWidth - 70;

        // Label
        $this->SetFont('Arial', '', 8);
        $this->SetXY($rightX, $y);
        $this->Cell(60, $labelHeight, "Approved by:", 0, 0, 'C');

        // Name + Position (aligned with label)
        $this->SetFont('Arial', 'B', 9);
        $this->SetXY($rightX, $y + $labelHeight + $signatureHeight + 6);
        $this->Cell(60, $nameHeight, $approver, 0, 0, 'C');

        $this->SetFont('Arial', '', 9);
        $this->SetXY($rightX, $y + $labelHeight + $signatureHeight + 10);
        $this->Cell(60, $positionHeight, $approverPosition, 0, 0, 'C');

        // Signature (separate positioning)
        if (!empty($approverSignature) && file_exists($approverSignature)) {
            $this->Image(
                $approverSignature,
                $rightX + (60 - $signatureWidth) / 2,
                $y + $labelHeight + $approverSigOffsetY,
                $signatureWidth,
                $signatureHeight
            );
        }
    }

    /*Function Footer*/
    function Footer() {
        $footerFile = '../assets/image/footer/footer.jpg';
        $footerWidth = 180; 
        $pageWidth   = $this->GetPageWidth();
        $pageHeight  = $this->GetPageHeight();
        $x = ($pageWidth - $footerWidth) / 2;
        list($imgWidth, $imgHeight) = getimagesize($footerFile);
        $footerHeight = ($footerWidth / $imgWidth) * $imgHeight;
        $y = $pageHeight - $footerHeight - 10; 
        if (!empty($this->PrintStatus) && $this->PrintStatus > 0) {
            $this->SetFont('Arial', 'I', 8);
            $this->SetTextColor(0, 0, 0); // black text
            $this->SetXY(0, $y - 20); // adjust position above footer
            $this->Cell($pageWidth, 10, '*** Re-Printed ***', 0, 0, 'C');
        }
        $this->SetFont('Arial', 'I', 9);
        $this->SetTextColor(0, 0, 0);    
        $this->SetXY(10, $y - 5); 
        $this->Cell($pageWidth - 20, 5, "*** Please present this quotation and required documents when claiming the items or processing your request ***", 0, 0, 'C');
        $this->Image($footerFile, $x, $y, $footerWidth);
    }


}


// Create new PDF
$pdf = new PDF('P', 'mm', 'A4');
$pdf->AddPage(); 

$HeaderPath = '../' . $headerrow['Header']; // prepend ../
$pdf->loadHeader($HeaderPath); 

// Orders table (fixed Y = 50 is okay)
$pdf->loadOrdersTable($ordersList, 15, 50, 6, $DeliveryCharge, $GrandTotal);

// --- Terms & Conditions ---
$y = $pdf->GetY() + 10; 
$pdf->loadTermsCondition(
    $deftermsList,
    $TermsconditionList, 
    $row['PaymentTerms'],
    $row['Installment'],
    $row['Downpayment'],
    $row['Bank'],
    $row['AccountName'],
    $row['AccountNumber'],
    $row['CorpBank'],
    $row['CorpAccountName'],
    $row['CorpAccountNumber'],
    $row['CashBank'],
    $row['CashAccountName'],
    $row['CashAccountNumber'],
    15,
    $y,
    4
);

// --- Warranty ---
$y = $pdf->GetY() + 10;
$pdf->loadWarranty($warrantyList, 15, $y, 4, $ContactNumber);

// --- Authorities (Prepared by / Approved by) ---
$y = $pdf->GetY() + 20;
if ($y > 200) { // prevent overlap with footer
    $pdf->AddPage();
    $y = 50; // reset starting Y on new page
}

$preparedSignature = '' . $Signature;
$approverSignature = '' . $ApproverSignature;

$pdf->loadAuthorities(
    $Preparedby, $Position, $preparedSignature,
    $APPROVER, $ApproverPosition, $approverSignature,
    260,     // Y base
    50, 50,  // Signature width/height
    30,      // Prepared sig offset Y (move up)
    30       // Approver sig offset Y (move down)
);


// --- SubHeader & Address (these stay where they were) ---
$pdf->loadSubHeader($Customer, $Company, $Approveddate, $QNumber);
$address = !empty($BranchAddress) ? $BranchAddress : "Unknown Address";
$pdf->loadAddress($address, 50, 24, 'B');

$pdf->SetFont('Arial', '', 12);
$pdfFileName = "Quotation.pdf";
$pdf->Output('I', $pdfFileName);

?>
