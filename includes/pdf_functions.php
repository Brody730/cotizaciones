<?php
function generarPDFCotizacion($nombre_cliente, $email, $tipo_servicio, $complejidad, $plazo, $descripcion, $cotizacion) {
    $pdf = new FPDF();
    $pdf->AddPage();
    
    // Encabezado
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Cotizacion de Servicios', 0, 1, 'C');
    $pdf->Ln(10);
    
    // Información del cliente
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, "Cliente: $nombre_cliente", 0, 1);
    $pdf->Cell(0, 10, "Email: $email", 0, 1);
    $pdf->Ln(10);
    
    // Detalles del servicio
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Detalles del Servicio', 0, 1);
    $pdf->SetFont('Arial', '', 12);
    
    $pdf->Cell(50, 10, 'Tipo de Servicio:', 0, 0);
    $pdf->Cell(0, 10, ucfirst(str_replace('_', ' ', $tipo_servicio)), 0, 1);
    
    $pdf->Cell(50, 10, 'Nivel de Complejidad:', 0, 0);
    $pdf->Cell(0, 10, ucfirst($complejidad), 0, 1);
    
    $pdf->Cell(50, 10, 'Plazo de Entrega:', 0, 0);
    $pdf->Cell(0, 10, "$plazo dias", 0, 1);
    $pdf->Ln(10);
    
    // Descripción
    $pdf->MultiCell(0, 10, "Descripcion del Proyecto:\n$descripcion");
    $pdf->Ln(10);
    
    // Desglose de costos
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Desglose de Costos', 0, 1);
    $pdf->SetFont('Arial', '', 12);
    
    $pdf->Cell(100, 10, 'Precio Base:', 0, 0);
    $pdf->Cell(0, 10, '$' . number_format($cotizacion['precio_base'], 2), 0, 1);
    
    $pdf->Cell(100, 10, 'Multiplicador por Complejidad:', 0, 0);
    $pdf->Cell(0, 10, 'x' . $cotizacion['multiplicador_complejidad'], 0, 1);
    
    $pdf->Cell(100, 10, 'Ajuste por Plazo:', 0, 0);
    $pdf->Cell(0, 10, 'x' . number_format($cotizacion['ajuste_plazo'], 2), 0, 1);
    
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(100, 10, 'Total Estimado:', 0, 0);
    $pdf->Cell(0, 10, '$' . number_format($cotizacion['total'], 2), 0, 1);
    $pdf->Ln(15);
    
    // Notas
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->MultiCell(0, 8, "Nota: Esta cotizacion es una estimacion basada en la informacion proporcionada. El precio final puede variar luego de una evaluacion mas detallada del proyecto.");
    
    // Generar nombre de archivo único
    $filename = 'cotizacion_' . date('Ymd_His') . '_' . substr(md5(uniqid()), 0, 8) . '.pdf';
    $filepath = 'logs/' . $filename;
    
    // Guardar PDF
    $pdf->Output('F', $filepath);
    
    return $filename;
}
?>