<?php
  // Desactivar la carga de entidades externas
  libxml_disable_entity_loader(true);

  $xmlfile = file_get_contents('php://input');
  $dom = new DOMDocument();

  // Cargar XML con la opción LIBXML_NOENT
  $dom->loadXML($xmlfile, LIBXML_NOENT);

  // Imprimir el contenido seguro
  echo htmlspecialchars($dom->textContent, ENT_QUOTES, 'UTF-8');
?>
