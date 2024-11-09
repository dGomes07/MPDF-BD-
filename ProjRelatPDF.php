<?php
require_once 'vendor/autoload.php';

$host = 'localhost';
$dbname = 'biblioteca';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host='.$hostname.';dbname='.$dbanme.';charset=utf8",
    $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT titulo, autor, ano_publicacao, resumo FROM livros";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    $livros = stmt->fetchAll(PDO::FETCH_ASSOC);

    $mpdf = new \Mpdf\Mpdf();

    $html = '<h1>Biblioteca - Lista de livros </h1>';
    $html .= '<table border="1" cellpading="10" cellspacing="0" width="100%">';
    $html .= '<tr>
            <td>Título</td>
            <td>Autor</td>
            <td>Ano de Publicação</td>
            <td>Resumo</td>
        </tr>' ;

        foreach ($livros as $livro) {
            $html .= '<tr>';
            $html .= '<td>' . htmlspecialchars($livro['titulo']) . '</td>';
            $html .= '<td>' . htmlspecialchars($livro['autor']) . '</td>';
            $html .= '<td>' . htmlspecialchars($livro['ano_publicacao']) . '</td>';
            $html .= '<td>' . htmlspecialchars($livro['resumo']) . '</td>';
            $html .= '<tr>';
        }
    $html .= '</table>';
     
    $mpdf->WriteHTML($html);
    
    $mpdf->Output('lista_de_livros.pdf',\Mpdf\Output\Destination::DOWNLOAD);
}catch (PDOException $e) {
    echo "Erro na conexão com o banco de dados: " . $e->getMessege();
} catch (\Mpdf\MpdfPDOException $e) {
    echo "Erro ao gerar o PDF: " . $e->getMessege();
}


?>

