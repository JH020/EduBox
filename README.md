## GitHub Algemeen ##

-) Iedereen werkt in branches die uit de 'dev' branch zijn afgeleid.
-) Voor alle onderdelen voor de website wordt een aparte branch aangemaakt, om zo fouten te voorkomen.
-) Elke pagina krijgt een eigen CSS bestand om merge fouten te voorkomen.
-) Wanneer pagina's informatie uitwisselen moet gecommuniceerd worden met de andere groepsleden.

## Pagina's ##

-) Alle pagina's worden aangemaakt in '/pages' als een .php of .html bestand.
-) Gebruik als gehele breedte van je content op de pagina 'width: var(--contentWidth);', op deze manier kan dit met een mobiel responsive worden gemaakt.
-) Gebruik de /pages/template.php en /css/template.css als voorbeeld voor een nieuwe pagina.
-) Vermijd met linken van bestanden een / te gebruiken (kan conflicten geven wanneer mensen een een andere bestandsomgeving hebben).
-) Vermijd met linken van pagina's .html of .php te gebruiken. Voorbeeld: http://localhost/EduBox/index (Ziet er aan de voorkant beter uit namelijk).

## CSS ##

-) Maak voor elke pagina een nieuw CSS bestand aan met dezelfde naam als de pagina.
-) Maak vooral gebruik van grids om de blokken op de pagina in te delen. Eenmaal in een blok mag ook flex worden gebruikt.