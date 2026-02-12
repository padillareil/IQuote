<?php
require('fpdf/fpdf.php');   
require_once "../../../../config/connection.php";
session_start();
$userId = $_SESSION['UserName'] ?? '';
if (empty($userId)) {
    echo 'User ID is not set.';
    exit;
}
$QuotationID = isset($_GET['QID']) ? intval($_GET['QID']) : 0;
if ($QuotationID <= 0) {
    echo 'Invalid QID.';
    exit;
}
$QuotationQuery = "
    SELECT 
        q.CSTMER, q.CNUMBER, q.TIN, q.CMPNY, q.PVINCE, q.Name, q.MUNICPLTY, q.BRGY, 
        q.STRT, q.ZIPCODE, q.PTERMS, q.ACCNUM, q.QNumber, q.CREATED_DATE, q.QID, q.GTOTAL, 
        q.RMARKS, q.DCHARGE, q.PRINTSTATUS, q.QSTATUS, 
        o.BRND, o.MDL, o.SRP, o.QTY, o.AMNT, o.DSCNT, o.ORDR_ID,
        t.QID, t.TRMS_ID, t.TRMS, o.TAMOUNT, w.WRRNTY, w.WRRNTY_ID
    FROM QTATION q
    LEFT JOIN ORDR o ON o.QID = q.QID
    LEFT JOIN TERMS t ON t.QID = q.QID
    LEFT JOIN WARRANTY w ON w.QID = q.QID
    WHERE q.QID = ?
";
try {
    $stmt = $conn->prepare($QuotationQuery);
    if (!$stmt) {
        throw new Exception('Failed to prepare the SQL statement.');
    }
    $stmt->bindParam(1, $QuotationID, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($results)) {
        echo 'No data found.';
        exit;
    }
    $quotes = [];
    foreach ($results as $row) {
        $quotationId = $row['QID'];
        if (!isset($quotes[$quotationId])) {
            $quotes[$quotationId] = [
                'PVINCE' => $row['PVINCE'],
                'MUNICPLTY' => $row['MUNICPLTY'],
                'BRGY' => $row['BRGY'],
                'STRT' => $row['STRT'],
                'Name' => $row['Name'],
                'ZIPCODE' => $row['ZIPCODE'],
                'QNumber' => $row['QNumber'],
                'CREATED_DATE' => $row['CREATED_DATE'],
                'CSTMER' => $row['CSTMER'],
                'CMPNY' => $row['CMPNY'],
                'MUNICPLTY' => $row['MUNICPLTY'],
                'CNUMBER' => $row['CNUMBER'],
                'DSCNT' => $row['DSCNT'],
                'GTOTAL' => $row['GTOTAL'],
                'DCHARGE' => $row['DCHARGE'],
                'RMARKS' => $row['RMARKS'],
                'items' => [],
                'terms' => [], 
                'warranty' => [] 
            ];
        }
        if ($row['ORDR_ID'] && !isset($quotes[$quotationId]['items'][$row['ORDR_ID']])) {
            $quotes[$quotationId]['items'][$row['ORDR_ID']] = [
                'BRND' => $row['BRND'],
                'MDL' => $row['MDL'],
                'SRP' => $row['SRP'],
                'QTY' => $row['QTY'],
                'AMNT' => $row['AMNT'],
                'TAMOUNT' => $row['TAMOUNT'],
                'DSCNT' => $row['DSCNT']
            ];
        }
        if ($row['TRMS'] && !in_array($row['TRMS'], $quotes[$quotationId]['terms'])) {
            $quotes[$quotationId]['terms'][] = $row['TRMS'];
        }
        if ($row['WRRNTY'] && !in_array($row['WRRNTY'], $quotes[$quotationId]['warranty'])) {
            $quotes[$quotationId]['warranty'][] = $row['WRRNTY'];
        }
    }

    $quote = reset($quotes); 
} catch (PDOException $e) {
    echo 'Database Error: ' . htmlspecialchars($e->getMessage());
    exit;
} catch (Exception $e) {
    echo 'Error: ' . htmlspecialchars($e->getMessage());
    exit;
}
function formatCurrency($amount) {
    $amount = floatval(str_replace(',', '', $amount));
    return number_format($amount, 2, '.', ',');
}
if (!empty($quote)) {
    $pdf = new FPDF('P', 'mm', 'Legal');
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 2);
    $logoFile = '../../../../assets/image/header/header.png';
    $logoWidth = 240;  
    $logoHeight = 0;  
    $pdf->Image($logoFile, -15, -35, $logoWidth, $logoHeight);
    $pdf->SetXY(10 + $logoWidth + 20, 10); 
    $pdf->SetFont('Arial', '', 9);
    $pdf->SetXY(10 + $logoWidth + 5, 20); 
    $pdf->SetXY(10, 45);
    $pdf->SetFont('Arial', '', 11);
    $pdf->SetFont('Arial', '', 11);
    $createdDate = !empty($quote['CREATED_DATE']) ? date('F d, Y', strtotime($quote['CREATED_DATE'])) : date('F d, Y');
    $pdf->Cell(0, 10, htmlspecialchars($createdDate), 0, 1, 'L');
    $pdf->SetXY(160, 45); 
    $pdf->Cell(39, 10, htmlspecialchars($quote['QNumber'] ?? 'N/A'), 0, 1, 'R');
    $pdf->SetXY(10, 55); 
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 5, htmlspecialchars($quote['CSTMER'] ?? 'N/A'), 0, 1);
    if ($quote['CMPNY'] !== 'Personal') {
        $pdf->Cell(0, 5, htmlspecialchars($quote['CMPNY'] ?? 'N/A'), 0, 1);
    }
    $pdf->Cell(0, 5, htmlspecialchars(
       ($quote['BRGY'] ?? '') . ', ' . 
       ($quote['MUNICPLTY'] ?? '') . ', ' . 
       ($quote['PVINCE'] ?? '')
   ), 0, 1);
   $pdf->Cell(0, 5, htmlspecialchars(
       ($quote['STRT'] ?? '')
   ), 0, 1);
    $pdf->Ln(10); 
    $pdf->SetFont('Arial', '', 10); 
    $pdf->SetXY(10, $pdf->GetY());
    $pdf->Cell(0, -3, 'Dear Sir:', 0, 1, 'L');
    $pdf->Ln(8);  
    $pdf->SetFont('Arial', '', 10); 
    $pdf->SetXY(0, $pdf->GetY()); 
    $pdf->Cell(0, 5, 'Imperial Appliance Plaza is pleased to submit a quotation for the following:', 0, 1, 'C'); 
    $colWidths = [20, 82, 10, 0, 15, 30, 30]; 
    $pdf->SetFillColor(255, 255, 0); 
    $pdf->SetFont('Arial', 'B', 8);  
    $pdf->Cell($colWidths[4], 8, 'QTY', 1, 0, 'C', true);  
    $pdf->Cell($colWidths[1], 8, 'BRAND/MODEL', 1, 0, 'C', true);  
    $pdf->Cell($colWidths[5], 8, 'UNIT PRICE', 1, 0, 'C', true);  
    $pdf->Cell($colWidths[5], 8, 'DISCOUNTED PRICE', 1, 0, 'C', true);  
    $pdf->Cell($colWidths[6], 8, 'TOTAL AMOUNT', 1, 1, 'C', true); 

    $pdf->SetFont('Arial', '', 8);
    $rowHeight = 8;  
    $yStart = $pdf->GetY();  
    if (isset($quote['items']) && is_array($quote['items'])) {
        foreach ($quote['items'] as $item) {
            if ($pdf->GetY() + $rowHeight > 356) {  
                $pdf->AddPage();  
                $pdf->SetXY(10, 45);  
                $pdf->Cell(0, 10, 'Continuing from the previous page...', 0, 1, 'C');
            }
            $pdf->Cell($colWidths[4], $rowHeight, intval($item['QTY']), 1, 0, 'C');  
            $pdf->Cell($colWidths[1], $rowHeight, htmlspecialchars($item['BRND']) . ' ' . htmlspecialchars($item['MDL']), 1, 0, 'C');  
            $pdf->Cell($colWidths[5], $rowHeight, formatCurrency($item['SRP']), 1, 0, 'C');  
            $pdf->Cell($colWidths[5], $rowHeight, formatCurrency($item['AMNT']), 1, 0, 'C');  
            $pdf->Cell($colWidths[6], $rowHeight, formatCurrency($item['TAMOUNT']), 1, 1, 'C');  
        }
    } else {
        $pdf->Cell(array_sum($colWidths), $rowHeight, 'No items found.', 1, 1, 'C');
    }
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(array_sum($colWidths) - $colWidths[6], $rowHeight, 'DELIVERY CHARGE', 1, 0, 'C'); 
    $pdf->Cell($colWidths[6], $rowHeight, formatCurrency($quote['DCHARGE']), 1, 1, 'C');
    $pdf->Cell(array_sum($colWidths) - $colWidths[6], $rowHeight, 'GRAND TOTAL', 1, 0, 'C'); 
    $pdf->Cell($colWidths[6], $rowHeight, formatCurrency($quote['GTOTAL']), 1, 1, 'C');
    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 10, 'Terms and Conditions', 0, 1); 
    $pdf->SetFont('Arial', '', 10);
   $termIndex = 3; 
   $pdf->MultiCell(0, 3, 
          "1. Price Validity is 7 days upon receipt of quotation.\n\n" . 
          "2. Please confirm stocks availability before preparing P.O.\n\n");
      foreach ($quote['terms'] as $term) {
          $pdf->MultiCell(0, 3, "{$termIndex}. " . htmlspecialchars($term) . "\n\n", 0, 'L');
          $termIndex++; 
      }
      if (!empty($quote['warranty'])) {
          $pdf->SetFont('Arial', 'B', 10); 
          $pdf->Cell(0, 5, "Warranty", 0, 1, 'L'); 
          $pdf->SetFont('Arial', '', 10); 
          foreach ($quote['warranty'] as $warrantyDetail) {
              $pdf->MultiCell(0, 3, htmlspecialchars($warrantyDetail) . "\n\n", 0, 'L');
          }
      }
   $pdf->SetFont('Arial', '', 10); 
   $pdf->Cell(0, 5, "For further information, please feel free to call us:", 0, 1, 'L'); 
   $pdf->SetFont('Arial', 'B', 10); 
   $pdf->Cell(0, 5, "336-4671, 501-0702 or 09173037626/09062289908.", 0, 1, 'L'); 
   $pdf->SetFont('Arial', '', 10); 
   $pdf->MultiCell(0, 6, 
       "Thank you very much, and we shall be looking forward to a beneficial business relationship with you in the future.\n\n", 0, 'L');
   $pdf->Ln(10);  
   $currentY = $pdf->GetY();  
   $signatureY = $currentY + 5;  
   if ($signatureY > 270) {  
       $pdf->AddPage();  
       $signatureY = 20;  
   }
   $pdf->SetFont('Arial', '', 10);
   $pdf->SetXY(40, $signatureY);  
   $pdf->Cell(28, 3, "Very truly yours,", 0, 1, 'L');
   $pdf->SetFont('Arial', 'B', 10);
   $pdf->SetXY(40, $signatureY + 5);  
   $pdf->Cell(0, 3, htmlspecialchars($quote['Name'] ?? 'N/A'), 0, 1, 'L');
   ob_end_clean();
   $pdf->Output();
}
?>
