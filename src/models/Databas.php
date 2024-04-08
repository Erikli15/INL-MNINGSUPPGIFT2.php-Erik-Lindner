<?php
require_once ("src/models/Product.php");
require_once ("src/models/Catagory.php");
require_once ("src/models/userDatabas.php");
class Databas
{
    private $pdo;
    private $userDatabas;

    function getUserDatabas()
    {
        return $this->userDatabas;
    }
    function __construct()
    {
        $host = $_ENV["host"];
        $db = $_ENV["db"];
        $user = $_ENV['user'];
        $pass = $_ENV['pass'];
        $dsn = "mysql:host=$host;dbname=$db";
        $this->pdo = new PDO($dsn, $user, $pass);
        $this->userDatabas = new userDatabas($this->pdo);
        $this->ifTabletNotExist();
        $this->ifProductsNotExist();
    }
    function getAllCategories()
    {
        return $this->pdo->query('SELECT * FROM category')->fetchAll(PDO::FETCH_CLASS, 'Catagory');

    }

    function searchProducts($sortCol, $sortOrder, $q, $categoryId)
    {
        if ($sortCol == null) {
            $sortCol = "id";
        }
        if ($sortOrder == null) {
            $sortOrder = "asc";
        }
        $sql = "SELECT * FROM products";
        $paramsArray = [];
        $addedWhere = false;
        if ($q != null && strlen($q) > 0) {
            if (!$addedWhere) {
                $sql = $sql . " WHERE ";
                $addedWhere = true;
            } else {
                $sql = $sql . " AND ";
            }
            $sql = $sql . " (productName like :q";
            $sql = $sql . " or price like :q)";
            $paramsArray["q"] = "%" . $q . "%";
        }
        if ($categoryId != null && strlen($categoryId) > 0) {
            if (!$addedWhere) {
                $sql = $sql . " WHERE";
                $addedWhere = true;
            } else {
                $sql = $sql . " AND ";
            }
            $sql = $sql . " (categoryId = :categoryId)";
            $paramsArray["categoryId"] = $categoryId;
        }


        $sql .= " ORDER BY $sortCol $sortOrder ";

        $prep = $this->pdo->prepare($sql);
        $prep->setFetchMode(PDO::FETCH_CLASS, "Product");
        $prep->execute($paramsArray);

        return $prep->fetchAll();
    }
    function getProduct($id)
    {
        $prep = $this->pdo->prepare('SELECT * FROM products where id=:id');
        $prep->setFetchMode(PDO::FETCH_CLASS, 'Product');
        $prep->execute(['id' => $id]);
        return $prep->fetch();
    }
    function getProductByTitle($productName)
    {
        $prep = $this->pdo->prepare('SELECT * FROM products where productName=:productName');
        $prep->setFetchMode(PDO::FETCH_CLASS, 'Product');
        $prep->execute(['productName' => $productName]);
        return $prep->fetch();
    }

    function getCategoryByTitle($title)
    {
        $prep = $this->pdo->prepare('SELECT * FROM category where title=:title');
        $prep->setFetchMode(PDO::FETCH_CLASS, 'Catagory');
        $prep->execute(['title' => $title]);
        return $prep->fetch();
    }

    function getCatagory($id)
    {
        $prep = $this->pdo->prepare('SELECT * FROM category where id=:id');
        $prep->setFetchMode(PDO::FETCH_CLASS, 'Catagory');
        $prep->execute(['id' => $id]);
        return $prep->fetch();
    }
    function ifProductsNotExist()
    {
        static $products = false;
        if ($products)
            return;

        $this->createIfNotExisting(
            'FIDS Zelo',
            18,
            'Ruggade Tablet PC:s',
            'FIDS Zelo är en mångsidig Tablet PC med hög kapacitet och som är kompatibel med en rad tillbehör för effektivt fältarbete (FIDS Zelo är även mycket lämplig för fordonsmontage). Högupplöst tydlig display, Night vision, kraftfull processor och operativsystemen Windows 10® eller Linux placerar FIDS Zelo i absoluta premiumsegmentet. Modellen är fläktlös och tystgående med överlägsen flexibilitet och extrem tålighet. Bildskärmen kan fås med Kapacitiv Touch eller Dual Mode med både Kapacitiv Touch och Aktiv Digitizer.',
            'src/poster/FIDSZelo.jpg'
        );
        $this->createIfNotExisting(
            'FIDS Enzi',
            19,
            'Ruggade Tablet PC:s',
            'FIDS Enzi erbjuder avancerade egenskaper och funktioner typiska för dyrare Tablets. Modellen har låg vikt och slimmad design, är klassad med MIL-STD 810 och IP65 för vatten-och damminträngning. Den kapacitiva 10.1" bildskärmen är klar och tydlig även i skarpt solljus.',
            'src/poster/FIDSEnzi.jpg'
        );
        $this->createIfNotExisting(
            'FIDS Yona Black',
            10,
            'Ruggade Tablet PC:s',
            'FIDS Yona Black (en vidareutveckling av storsäljaren FIDS Yona) är en av de mest stilrena men kompakta ruggade Tablet PC:s som finns på marknaden; 20 mm tunn med en vikt på 1.2 kg. Med en 11.6 tums fullt högupplöst (1920 x1080) 10 punkters Kapacitiv Touch display med exceptionellt klar och tydlig bildåtergivning, även i direkt solljus.',
            'src/poster/FIDSYonaBlack.jpg'
        );
        $this->createIfNotExisting(
            'Getac F110',
            22,
            'Ruggade Tablet PC:s',
            'Getac F110 har olika bildskärmslägen för Regn, Touch, Handske och Penna. Datorn är också en av de Tablets som kan väljas med Digitizer för exakt precisionsarbete. Ruggade Getac F110 har en stark processor och erbjuder en mångfald av portar, anslutningar och tillval.',
            'src/poster/GetacF110.jpg'
        );
        $this->createIfNotExisting(
            'Welo R10T',
            21,
            'Ruggade Tablet PC:s',
            'En mångsidig och energieff ektiv Windowsbaserad Tablet PC
        Welo R10T är en prisvärd och allsidig IP65- klassad Tablet PC, med klar bildåtergivning även i skarpt solljus.
        Med modul (tillval) för läsare av streckkoder och goda uppkopplingsmöjligheter är Welo R10T enkel att anpassa efter uppgiften och ger den mobile windowsanvändaren en lätthanterlig plattform för snabb och kostnadseff ektiv insamling och behandling av data.',
            'src/poster/WeloR10T.jpg'
        );
        $this->createIfNotExisting(
            'Welo R10S',
            25,
            'Ruggade Tablet PC:s',
            'Welo R10S är en IP65-klassad windowsbaserad Tablet PC, enkel att anpassa efter uppgift och användare. Displayen har en klar bildåtergivning, även i skarpt solljus. Med sina portar, anslutningar och läsare är den ett energieffektivt verktyg för snabb och kostnadseffektiv databehandling.',
            'src/poster/WeloR10S.jpg'
        );
        $this->createIfNotExisting(
            'Welo XR12E',
            30,
            'Ruggade Tablet PC:s',
            'Welo XR12E har den senaste och sömlösa multikommunikationen inklusive Wi-Fi 6, Bluetooth 5.0, 5G LTE- och NFC-läsare kan fältoperatörer uppleva snabbare dataöverföring, mindre latens och bredare täckning genom hela uppgiften.
        Utrustad med designen med dubbla batterier som kan bytas under värme gör att du kan njuta av en oavbruten arbetstid. denna unika design låter dig byta ett nytt batteri in medan du kör viktiga applikationer. exponering.',
            'src/poster/WeloXR12E.jpg'
        );
        $this->createIfNotExisting(
            'PX510',
            40,
            'Ruggade Tablet PC:s',
            'Ruggade PX510 Tablet PC är utvecklad för användare som vill ha utrustning som presterar obehindrat i alla väder. Med en effektiv Intel® Core™ i5 vPro™-processor innanför ett IP65- och MIL-STD-810G-klassat hölje klarar PX510 de extremer, allt ifrån fukt och väderomslag till stötar, slag och skakningar som utrustningen dagligen kan utsättas för i krävande miljöer.
        ',
            'src/poster/PX510.jpg'
        );
        $this->createIfNotExisting(
            'L10 IECEx/ATEX',
            97,
            'Ruggade Tablet PC:s',
            'L10 XPAD ATEX IECEx och XSLATE ATEX IECEx är högpresterande Tablets klassade med ATEX och IECEx, utöver IP65 och MIL-STD810G. Båda modellerna har låg vikt, hög tålighet och anpassas enkelt efter användare och uppgift. Uppkopplingen snabb och sömlös med Bluetooth, Wifi och 4GLTE. Finns i Windows- och Androidversion.',
            'src/poster/L10IECExATEX.jpg'
        );
        $this->createIfNotExisting(
            'Welo XR10',
            31,
            'Ruggade Tablet PC:s',
            'Skärm med god läsbarhet, förstärkt ram, väl skyddade portar och dämpande hörn gör Welo XR10 till ett pålitligt arbetsredskap. Vatten- och dammtålighet klassad enligt IP67, lång drifttid och möjlighet att enkelt kunna byta batteri ute i fält är bara några av fördelarna!',
            'src/poster/WeloXR10.jpg'
        );
        $this->createIfNotExisting(
            'XSLATE L10',
            21,
            'Ruggade Tablet PC:s',
            'XSLATE L10 är en tålig, stark och mycket användarvänlig Tablet, formgiven för att vara lätt att bära med sig. Utrustad med marknadens mest kraftfulla processorer och operativet Windows 10 Pro är XSLATE L10 redo att uppnå den fulla potentialen hos alla valda applikationer och program.',
            'src/poster/XSLATEL10.jpg'
        );
        $this->createIfNotExisting(
            'XPAD L10',
            38,
            'Ruggade Tablet PC:s',
            'XPAD L10 är en gedigen Pad med ett fast vridstyvt handtag med integrerad streckkodsläsare. Modellen är utvecklad i ergonomisk design för att vara bekväm att hantera och att alltid prestera snabb, driftsäker databehandling överallt;
        såväl på kontoret som ute i fält eller monterad i fordon.
        ',
            'src/poster/XPADL10.jpg'
        );
        $this->createIfNotExisting(
            'XBOOK L10 2-in-1',
            6,
            'Ruggade Tablet PC:s',
            'XBOOK L10 2-i-1 är ett mångsidigt alternativ till en 10.1
        tums Laptop. Med sitt avdockningsbara fullfunktions-tangentbord presterar den lika väl vid skrivbordet som
        ute i fält. Användare uppskattar mångsidigheten och enkelheten i att bara behöva använda en enda dator
        för alla uppgifter och all databehandling – överallt.
        ',
            'src/poster/XBOOKL102in1.jpg'
        );
        $this->createIfNotExisting(
            'Welo XR10G2',
            22,
            'Ruggade Tablet PC:s',
            'Welo XR10G2 är en flexibel Tablet PC, klassad med IP65 och MIL-STD-810G. Processorn väljs med i5 eller i7-processorer, operativsystemen med Windows 7 eller 10 alternativt Linux. WiFi, Bluetooth och 4G ger stabil uppkoppling. Med moduler
        kan användaren enkelt anpassa sin Tablet.
        ',
            'src/poster/WeloXR10G2.jpg'
        );
        $this->createIfNotExisting(
            'Getac A140',
            18,
            'Ruggade Tablet PC:s',
            'Getac A140 är en fullt ruggad Tablet PC (klassad enligt IP65) med en 14" display med vida betraktningsvinklar och generös arbetsyta. Bildskärmen är klar och distinkt, även i direkt solljus. Getac har hög datasäkerhet och en lång rad tillbehör som gör den redo för utmanande fältarbeten i tuffa miljöer.',
            'src/poster/GetacA140.jpg'
        );
        $this->createIfNotExisting(
            'ET80/ET85 2-i-1 Tablet PC',
            12,
            'Ruggade Tablet PC:s',
            'Tunna och lätta ET80/ET85, drivna av kraften i Intels Generation 11-processors är två Windows 2-i-1 Tablet PC:s. Båda är designade för högsta produktivitet och säkerhet i många olika branscher, med högsta funktion och prestanda både när den används som Tablet och som Laptop. Datorn och tangentbordet är båda ruggade och klassade med IP65.',
            'src/poster/ET80ET852i1TabletPC.jpg'
        );
        $this->createIfNotExisting(
            'MR14',
            39,
            'Ruggade Tablet PC:s',
            'MR14 är utrustad med den kraftfulla 8:e generationens Intel Quad Core-processor och en imponerande högupplöst 14 tums Kapacitiv Multi Touch bildskärm. Med NVIDIA GeForce GTX 1050 grafikkort för avancerade grafiska och video-intensiva program och en aktiv penna (tillval) för detaljerat bildskärmsarbete är MR14 ledande bland mobila plattformar för även de mest krävande fältapplikationer.',
            'src/poster/MR14.jpg'
        );
        $this->createIfNotExisting(
            'MR13',
            231,
            'Ruggade Tablet PC:s',
            'Ruggade MR13 (testad och klassad enligt IP65) har en 13" stor, ljusstark och mycket detaljrik display. Den snabba och kraftfulla processorn är redo för prestandakrävande applikationer och expansioner. SmartCard/CAC-läsare är standard. För utökad prestanda finns kameror, streckkodsläsare, GNSS, Mobilt Bredband och Dual Pass Through som tillval.',
            'src/poster/MR13.jpg'
        );
        $this->createIfNotExisting(
            'Welo XR10G2L',
            213,
            'Ruggade Tablet PC:s',
            'Welo XR10G2L är mångsidig och erbjuder läsare för streckkoder, fingeravtrycksidentifiering, NFC och RFID. Modellen är ruggad (IP65) med härdat Gorilla Glass i displayen, inbyggd GPS och en 8MP-kamera med videofunktion. Väljs med Windows 10 eller Linux.',
            'src/poster/WeloXR10G2L.jpg'
        );
        $this->createIfNotExisting(
            'Getac UX10 2-i-1',
            81,
            'Ruggade Tablet PC:s',
            'Getac UX10 är en ny ruggad Tablet som snabbt blir en laptop, redo för krävande fältarbete. Urvalet av portar och anslutningar är generöst. Den kapacitiva displayen har lägen för Regn, Touch, Handske och Penna. UX10 kan väljas med Digitizer för precisionsarbete med t ex kartor eller tabeller.',
            'src/poster/GetacUX102i1.jpg'
        );
        $this->createIfNotExisting(
            'Getac K120 2-i-1',
            10,
            'Ruggade Tablet PC:s',
            'Getac K120 är en ny ruggad Tablet som med tillvalet tangentbord snabbt blir en kraftfull laptop. Den kapacitiva displayen har lägen för Regn, Touch, Handske och Penna. Getac K120 kan också väljas med Digitizer för detaljerat arbete med t ex kartor eller tabeller. Urvalet av portar, anslutningar, tillval och tillbehör är mycket brett.',
            'src/poster/GetacK120 2i1.jpg'
        );
        $this->createIfNotExisting(
            'Welo XR12',
            21,
            'Ruggade Tablet PC:s',
            'Den generösa 12" skärmen är av härdat glas, ramen är förstärkt, display-ytan generös och portarna skyddade. Ruggade Welo XR12 har många tillbehör och tillval,
        som t ex streckkodsläsare, Clip On-keyboard, RFID-läsare och fingeravtrycksläsare. Operativet Microsoft Windows 10, Enterprise IoT eller Pro väljs av beställaren.',
            'src/poster/WeloXR12.jpg'
        );
        $this->createIfNotExisting(
            'RP70',
            9,
            'Ruggade Mini Tablet PC:s',
            'Mångsidiga och ruggade RP70 har extremt låg vikt, marginellt högre än hos många PDA:s. Formatet gör att denna Tablet PC – med sin stora och tydliga 7" solljusdisplay – kan få plats i fickan. Enheten är driftsäker, IP65-klassad och ger dig kraften i Microsoft® Windows 10® IoT.',
            'src/poster/RP70.jpg'
        );
        $this->createIfNotExisting(
            'Luna',
            231,
            'Ruggade Mini Tablet PC:s',
            'Luna är en kompakt ruggad crossover med unik kombination av egenskaper och funktioner. Trots den kompakta designen har Luna en generös bildskärm, kraftfull processor och snabbladdning mm. Bildskärmen på 8” har hela 1000 nits ljusstyrka, kapacitiv multi-touch med fl era driftslägen och äkta digitizer med aktiv penna. Luna är mycket kraftfull och utrustad med 11:e generationens Intel® CoreTM i5-processor, 4G/LTE och GNSS samt senaste Wi-Fi 6 och Bluetooth V5.2. Med MIL-STD 810H, 461G och IP65-certifi eringar klarar Luna de fl esta miljöer. Luna är utrustad med USB-C för laddning och kommunikation.',
            'src/poster/Luna.jpg'
        );
        $this->createIfNotExisting(
            'Getac T800',
            14,
            'Ruggade Mini Tablet PC:s',
            'Getac T800 är en ruggad kompact och flexibel Tablet PC, med flera inbyggda funktioner för förbättrad produktivitet. Enheten har en skarp, klar 8.1 högupplöst bildskärm med Multi Touch och LifeSupport™ Hot-Swap-teknologi för snabba batteribyten. Getac T800 har inbyggda funktioner för kommunikation och uppkoppling och är förberedd för ytterligare expansion med snap-on adds. Getac T800 levereras med Windows 10®.',
            'src/poster/GetacT800.jpg'
        );
        $this->createIfNotExisting(
            'Welo XR8',
            312,
            'Ruggade Mini Tablet PC:s',
            'Welo XR8 är en liten, men fullt ruggad Tablet PC. Med förstärkt ram, väl skyddade portar och dämpande hörn klarar den yrkeslivets utmaningar. Skärmen är av härdat glas och Welo XR8 har en vatten- och dammtålighet klassad enligt IP67.
        ',
            'src/poster/WeloXR8.jpg'
        );
        $this->createIfNotExisting(
            'Welo R8S',
            213,
            'Ruggade Mini Tablet PC:s',
            'Welo R8S är fullt ruggad med hög tålighet och ger dig alla möjligheter som finns i Windows 10®. Med Welo R8S har du hela världen i din hand. Eller i din ficka!
        ',
            'src/poster/WeloXR8.jpg'
        );
        $this->createIfNotExisting(
            'ARROW-serien',
            132,
            'GPS Precision',
            'RTK-mottagarna i serie Arrow tar emot och levererar positioner med hög noggrannhet - till i princip vilken enhet som helst: Smartphone, Tablet PC eller bärbar dator. Mottagarna är enkla att hantera genom Android, iOS och Windows och är redo för marknadens breda utbud av program och appar. Denna valfrihet är unik i branschen för mät- och kartteknik.',
            'src/poster/ARROWserien.jpg'
        );
        $this->createIfNotExisting(
            'EOS Bridge™ GNSS',
            231,
            'GPS Precision',
            'EOS Bridge™ gör det möjligt att – via Bluetooth eller seriell kabelförbindelse – ansluta utrustning, som laserinstrument (t ex TruPulse) och andra sensorer eller mätdatainsamlare så att all information samlas in av EOS Bridge och därifrån skickas vidare till fältdatorn eller SmartPhonen. Detta ger en unik möjlighet när man använder sig av Esri ArcGIS fältappar och framförallt tillsammans med iPhone/iPad, vilka normalt sett inte kan anslutas till sådan utrustning.',
            'src/poster/ARROWserien'
        );
        $this->createIfNotExisting(
            'FOIF-serien',
            321,
            'GPS Precision',
            'A70 Mini och A90 från FOIF är avancerade GNSS RTK-mottagare för professionellt bruk. Båda modellerna levererar pålitlig och stabil positionering med centimeterprecision. Båda är av typen ”Smart-antenn” med enkel uppstart och hantering.',
            'src/poster/FOIFserien.jpg'
        );
        $this->createIfNotExisting(
            'Garmin GLO™ 2',
            321,
            'GPS Precision',
            'Med Garmin GLO får du det bästa av två världar genom kombinationen av GPS/GLONASS-mottagare och Bluetooth®-teknik där du får en mycket noggrann positionsinformation i din PC eller Android-enhet med stöd för NMEA. Dessutom tar enheten emot gratis korrektion från SBAS (EGNOS).
        ',
            'src/poster/GarminGLO™2.jpg'
        );
        $this->createIfNotExisting(
            'RP70A',
            32,
            'Android',
            'Mångsidiga och ruggade RP70A har en extremt låg vikt och en storlek som bara är marginellt högre än hos många PDA:s. Formatet gör att denna Tablet – med sin stora och tydliga 7" solljusdisplay – kan få plats i fickan. Enheten är driftsäker och IP65-klassad och har Android 9.0 PIE® som operativsystem.',
            'src/poster/RP70A.jpg'
        );
        $this->createIfNotExisting(
            'Welo X10A',
            12,
            'Android',
            'Welo X10A är en prisvärd IP65-klassad ruggad Android Tablet, stark och tålig. Bland egenskaperna märks operativsystemet Android 9.0, en 10.1" bildskärm med Kapacitiv Touch, HotSwap-batteri, teknik för säker stabil uppkoppling och en design som gör underhåll och expansioner snabba och enkla.
        ',
            'src/poster/WeloX10A.jpg'
        );
        $this->createIfNotExisting(
            'Welo XR8A',
            14,
            'Android',
            'XR8A är den androidbaserade Mini Tablet som har högst ruggningsgrad (IP67, MIL-STD-810G). Formatet är behändigt och vikten är låg. På insidan arbetar en Qualcomm 8-processor och operativsystemet är användarvänliga Android 9.0.',
            'src/poster/WeloXR8A.jpg'
        );
        $this->createIfNotExisting(
            'Welo XR10A',
            18,
            'Android',
            'Androidbaserade Welo XR10A har en stark Qualcomm-processor och en ljusstark widescreen med Kapacitiv Touch. Tablet PC:n har lång driftstid, är ruggad enligt IP65 och har stöd för GPS (GLONASS) och ett batteri med lång driftstid.
        ',
            'src/poster/WeloXR10A.jpg'
        );
        $this->createIfNotExisting(
            'L10 Android',
            19,
            'Android',
            'L10 Android XPAD/XBOOK/XSLATE är en serie högpresterande ruggade Tablets, testade och klassade med IP65 och MIL-STD810G. Operativsystemet är Android 8.1™ och processorn en kraftfull Qualcomm Octacore Snapdragon™. Alla har låg vikt, hög tålighet och anpassas enkelt efter användare och uppgift. Uppkopplingen snabb och sömlös med Bluetooth, Wifi och 4GLTE.',
            'src/poster/L10Android.jpg'
        );
        $this->createIfNotExisting(
            'XSLATE D10',
            26,
            'Android',
            'Androidbaserade® XSLATE D10 är en ruggad Tablet PC, godkänd för säkert arbete i miljöer där gas eller damm kan göra atmosfären lättantändlig (ATEX). XSLATE har en
        invändig stomme av aluminiumlegering för vridstyvhet och gummidämpade hörn för hög stöttålighet.
        Displayen kontrolleras även med handskar och i väta.
        ',
            'src/poster/XSLATED10.jpg'
        );
        $this->createIfNotExisting(
            'Welo R10A',
            1,
            'Android',
            'Welo R10A är en IP65-klassad androidbaserad Tablet PC, enkel att anpassa efter uppgift och användare. Displayen har en klar bildåtergivning, även i skarpt solljus. Med bredd i portar, anslutningar och läsare är den ett energieffektivt verktyg för snabb och kostnadseffektiv databehandling. Finns även med Windows operativsystem.',
            'src/poster/WeloR10A.jpg'
        );
        $this->createIfNotExisting(
            'Welo R8A',
            18,
            'Android',
            'Welo R8A är fullt ruggad med hög tålighet och ger dig alla möjligheter som finns i Android 11®. Med Welo R8A har du hela världen i din hand. Eller i din ficka!',
            'src/poster/WeloR8A.jpg'
        );
        $this->createIfNotExisting(
            'Welo XR12A',
            2,
            'Android',
            'Welo XR12A med sin generösa display erbjuder stabil uppkoppling och tillval som läsare för NFC och streckkoder. Processorn är en Qualcomm (Octacore) 2.0GHz och operativet Android 10. Welo XR12A är ruggad enligt IP65 och MIL-STD-810G och stöder GLONASS med Beidou som tillval.',
            'src/poster/WeloXR12A.jpg'
        );
        $this->createIfNotExisting(
            'L10 ATEX (XSLATE, XPAD)',
            2,
            'Android',
            'L10 XPAD ATEX IECEx och XSLATE ATEX IECEx är högpresterande Tablets klassade med ATEX och IECEx, utöver IP65 och MIL-STD810G. Båda modellerna har låg vikt, hög tålighet och anpassas enkelt efter användare och uppgift. Uppkopplingen snabb och sömlös med Bluetooth, Wifi och 4GLTE. Finns i Windows- och Androidversion.
        ',
            'src/poster/L10ATEXXSLATEXPAD.jpg'
        );
        $this->createIfNotExisting(
            'Welo XR7A',
            14,
            'Android',
            'Welo XR7A har låg vikt och med sitt format på under 220 mm ryms den i fickan på många arbetskläder. Med ruggningsgrad IP65 plus tillbehör som t ex fordonsdocka passar denna Mini Tablet för rörliga jobb inom t ex inspektion, lager, militär eller lantbruk.',
            'src/poster/WeloXR7A.jpg'
        );
        $this->createIfNotExisting(
            'Welo R6S',
            46,
            'PDA',
            'En hög prestanda och mångsidig handhållen surfplatta i fi ckan med all kraften i Windows 10/11! Funktionaliteten hos en Windows-surfplatta, prestanda överallt hos en robust handdator - kombinera dem och du har WELO R6S. WELO R6S är en funktionsrik, robust handhållen med massor av datorkraft, en streckkodsläsare, kamera, NFC, 4G LTE plus alla funktioner och fördelar som kommer med Windows 10/11®.',
            'src/poster/WeloR6S.jpg'
        );
        $this->createIfNotExisting(
            'UT600',
            2,
            'PDA',
            'Ruggade Androidbaserade UT600 har högklassig GNSS, härdad HD-display och kapacitiv Touch som kan användas i väta eller med handskar på. Med trådlös uppkoppling, operativet Android 11 och Octa Core-processor är prisvärda UT600 redo för effektiv databehandling.',
            'src/poster/UT600.jpg'
        );
        $this->createIfNotExisting(
            'C66',
            3,
            'PDA',
            'Ruggade handhållna C66 har en generös skärm och är väl förberedd för utökade funktioner. HD-displayen är extremt klar och tydlig med härdat Corning Gorilla Glass™ för användning i utsatta miljöer. C66 erbjuder Google Play Store, NFC, sömlös kommunikation och GNSS som standard med streckkodsläsare som tillval.',
            'src/poster/C66.jpg'
        );
        $this->createIfNotExisting(
            'P8II',
            12,
            'PDA',
            'P8II är en ergonomiskt utformad robust Android handdator med alfanumeriskt tangentbord. Med generös Touch Display, 13 MP-kamera, Bluetooth, moduler för WiFi och GNSS och sina ruggade egenskaper (IP67) är enheten mycket lämplig för Androidanvändare på uppdrag inom GIS-GNSS, konstruktion, byggnad, teknik, skog eller servicenäring.',
            'src/poster/P8II.jpg'
        );
        $this->createIfNotExisting(
            'FIDS Vidi',
            4,
            'PDA',
            'FIDS Vidi kombinerar funktionerna i en Windowsbaserad Tablet PC med mobiliteten hos en ruggad handdator. Den mångsidiga enheten – som ryms i fickan – är utrustad med kamera, streckkodsläsare, NFC och 4G/LTE WWAN. FIDS Vidi arbetar med Intelprocessor och högupplöst 5.5-tums multi-touch display som stöder Stylus.',
            'src/poster/FIDSVidi.jpg'
        );
        $this->createIfNotExisting(
            'Gen2wave RP1300',
            1,
            'PDA',
            'RP1300 är flaggskeppet i Gen2wave-serien. En ruggad PDA och bland de mest flexibla i vårt sortiment med en vikt på endast 250g. Lätt att bära med sig i handen eller fickan under hela arbetsdagen i fält och utrustad med ett kraftfullt batteri som klarar hela arbetsdagen utan behov av extra laddning. Den skarpa 4.3" solljusbildskärmen med touch och dess tålighet mot väta och stötar gör denna enhet till den optimala fältdatorn. Välj om du önskar Android eller Windows Embedded.',
            'src/poster/Gen2waveRP1300.jpg'
        );
        $this->createIfNotExisting(
            'Gen2wave RP2000',
            6,
            'PDA',
            'RP2000 är en fullmatad Androidbaserad ruggad handdator för användare med krav på mobilitet och effektivitet. Vikten är endast 270 gram och storleken är mindre än 16 cm. PTT-knapp (Push-To-Talk) på sidan och högtalare på framsidan ger högkvalitativ mobil kommunikation, överallt. HD-displayen har härdat glas, tål väta och manövreras även med handskar.
        ',
            'src/poster/Gen2waveRP2000.jpg'
        );
        $this->createIfNotExisting(
            'C61',
            5,
            'PDA',
            'C61 erbjuder högkvalitativ datainsamling genom NFC, 13 MP-kamera och tillval som streckkodsläsare och UHF RFID. Batteridriven hållare för enhandsgrepp (pistol grip) finns som tillbehör. Allt gör handdatorn till ett bekvämt och tåligt arbetsredskap inom logistik, lagerhantering, tillverkning, återförsäljare, detaljhandel eller förvaltning.',
            'src/poster/C61.jpg'
        );
        $this->createIfNotExisting(
            'FIDS PPC',
            1,
            'All-In-One PC',
            'FIDS PPC är en 15.6 tums Panel PC med fläktlös konstruktion, klassad enligt IP65. Med Intel® Core™ i3-7100U processor och Windows 10® display med Kapacitiv Touch lämpar sig FIDS PPC väl för interaktiva applikationer inom industri, service, butik eller offentlig miljö och är en utmärkt plattform för handikappanpassning som t ex ögonstyrning med Eye Gaze.
        ',
            'src/poster/FIDSPPC.jpg'
        );
        $this->createIfNotExisting(
            'FIDS AIO 21.5',
            53,
            'All-In-One PC',
            'Eleganta FIDS AIO 21.5 med stark 8th Gen Intel® Coffee
        Lake-processor och kraftfullt systemminne är en väldigt allround Panel PC. Med projicerande kapacitiv multi-touch bildskärm och distinkt HD-ljud lämpar sig FIDS AIO väl som terminal för interaktiv skyltning eller självbetjäning. Inom lärande, eller habilitering med t ex Eye Gaze är modellen
        en lättanvänd plattform.',
            'src/poster/FIDSAIO215.jpg'
        );
        $this->createIfNotExisting(
            'AIO 24M',
            7,
            'All-In-One PC',
            'AIO 24M med sitt bakterieavvisande ytskikt är väl lämpad för program och applikationer inom hälso- och sjukvård. Tablet PC:n erbjuder en generös 23.6 tums Kapacitiv Touchskärm
        och en kraftfull och energieffektiv Intel® Core™ i-processor. SmartCard-läsare och extra batteripack (3 batterier)
        finns som tillval. HotSwap är standard för säker drift.
        ',
            'src/poster/AIO24M.jpg'
        );
        $this->createIfNotExisting(
            'AIO 21M',
            4,
            'All-In-One PC',
            'AIO 21M med sitt bakterieavvisande ytskikt är väl lämpad för program och applikationer inom hälso- och sjukvård. Tablet PC:n erbjuder en generös 21.5 tums Kapacitiv Touchskärm
        och en kraftfull och energieffektiv Intel® Core™ i-processor. SmartCard-läsare och extra batteripack (3 batterier)
        finns som tillval. HotSwap är standard för säker drift.',
            'src/poster/AIO21M.jpg'
        );
        $this->createIfNotExisting(
            'Ruggad Monitor',
            7,
            'Fordonsmonteraty',
            'Chaser Ruggad Monitor är en tålig bildskärm för effektivt fältarbete. Monitorn är ruggad (MIL-STD-810H) och stöt- och vibrationstålig med en vattentät front. Bildskärmen är en 11.6” ljusstark 1000 nits display med 10 punkters Multi-Touch som behandlats för att minska reflexer och avtryck från fingrar.
        ',
            'src/poster/RuggadMonitor.jpg'
        );
        $this->createIfNotExisting(
            'FIDS Zelo',
            24,
            'Fordonsmonterat',
            'FIDS Zelo är en mångsidig Tablet PC som är mycket lämplig för fordonsmontage. Högupplöst tydlig display, Night vision, kraftfull processor och operativsystemen Windows 10® eller Linux placerar FIDS Zelo i absoluta premiumsegmentet. Modellen är fläktlös och tystgående med överlägsen flexibilitet och extrem tålighet. Bildskärmen kan fås med Kapacitiv Touch eller Dual Mode med både Kapacitiv Touch och Aktiv Digitizer.',
            'src/poster/FIDSZelo.jpg'
        );
        $this->createIfNotExisting(
            'MR14',
            38,
            'Fordonsmonterat',
            'MR14 är en riktig cross-over, väl lämpad för fordonsmontage. Tablet PC:n är utrustad med den kraftfulla 8:e generationens Intel Quad Core-processor och en imponerande högupplöst 14 tums Kapacitiv Multi Touch bildskärm. Med NVIDIA GeForce GTX 1050 grafikkort för avancerade grafiska och video-intensiva program och en aktiv penna (tillval) för detaljerat bildskärmsarbete är MR14 ledande bland mobila plattformar för riktigt krävande fältapplikationer.',
            'src/poster/MR14.jpg'
        );
        $this->createIfNotExisting(
            'Fordonsmontage läs mer',
            7,
            'Fordonsmonterat',
            'Forest it Design tillhandahåller fordonsmontage och dockningsstationer till alla enheter som erbjuds i vårt sortiment, vare sig det handlar om Tablet PC:s, PDA:er, Androider, Laptops och Convertibles ...
        ',
            'src/poster/Fordonsmontageläsmer.jpg'
        );
        $this->createIfNotExisting(
            'FIDS Zeno',
            7,
            'Laptop & Convertibles',
            'Fullt ruggade FIDS Zeno är utvecklad för utmanande
        arbeten i extrema miljöer, där den kompromisslöst förenar användbarhet, funktion och prestanda. Laptopen har en generös högupplöst 14" bildskärm med touchfunktion, 8:e generationens Intel® Core™ processor, 16 timmars batteridriftstid, I/O-portar i särklass och många expansionsmöjligheter.',
            'src/poster/FIDSZeno.jpg'
        );
        $this->createIfNotExisting(
            'FIDS Regi RCL',
            55,
            'Laptop & Convertibles',
            'Eleganta semiruggade FIDS Regi är klassad med IP5X och MIL810G, redo för utomhusarbete. Den 15,6" stora Wide screen-displayen är generös, ljus, klar och tydlig. Intel® i5 CPU-processorn ger kraftfull prestanda. 4GLTE, Bluetooth 5.0 och Wi-Fi ger stabil och snabb uppkoppling.',
            'src/poster/FIDSRegiRCL.jpg'
        );
        $this->createIfNotExisting(
            'Getac V110',
            34,
            'Laptop & Convertibles',
            'Getac V110 är en ruggad Konvertibel, fullmatad med finesser. Datorn är slitstark trots att den både är lättare och tunnare än de flesta andra konvertibler på marknaden. Getac V110 är utrustad med 6:e generationens Intel™ Core i5 eller i7 processor och har en 11.6" Lumibond® 10 punkters kapacitiv bildskärm med hög läsbarhet. Kan även fås med Dual Mode med aktiv Digitizer (tillval).',
            'src/poster/Getac V110.jpg'
        );
        $this->createIfNotExisting(
            'Getac X600',
            7,
            'Laptop & Convertibles',
            'X600 kommer aldrig till kort med sin Intel 11:e generationens i5/i7/i9-processor, (upp till 8 kärnor), valfri NVIDIA® Quadro® RTX3000 diskret grafikkontroll och upp till 128 GB DDR4 RAM tillgängligt. Dess design med dubbla fläktar håller var och en av dessa datorkomponenter sval och kapabel, även under de mest intensiva uppgifterna, medan datalagring kan utökas upp till 6 TB med tre av användaren borttagbara PCIe SSD-enheter (SSD).',
            'src/poster/GetacX600.jpg'
        );
        $this->createIfNotExisting(
            'Rugged Convertible Laptop, RCL',
            7,
            'Laptop & Convertibles',
            'Forest it Rugged konvertibla bärbara datorer har integrering av konvertibla pekskärmar, Intel® 10:e generationens Core™ i-processorer och tangentbord i full storlek.
        Med en inbyggd smartkort/CAC-läsare samt valfria främre IR/RGB-kameror för ansiktsigenkänning ger dessa bärbara datorer avancerad identitetsverifiering för säker dataåtkomst.',
            'src/poster/RuggedConvertibleLaptopRCL.jpg'
        );
        $this->createIfNotExisting(
            'Rxiry Lasermätare',
            7,
            'Mätinstrument',
            'XR-serien från Rxiry tillhör senaste generationens lasermätare. Med dessa enheter kan avstånd, höjder och vinklar mätas utan vare sig reflektor eller transponder och med hög noggrannhet. Vissa modeller kan även mäta kompassvinklar för Azimuth, ange GNSS-position, hastighet samt temperatur. Samtliga modeller är ruggade och IP65-klassade. Enkelt handhavande med enbart två tangenter. Laddbart batteri och laddare är standard. Mätresultat kan avläsas i displayen samt överföras via Bluetooth. Antal användningsområden är så gott som oändligt med vanliga användningsområden är mätning av avstånd och trädhöjder inom skogsbruk. Avstånd, stolphöjd och kabelhöjd inom kraftindustrin. GPS-offset inom mätindustrin.',
            'src/poster/RxiryLasermätare.jpg'
        );
        $this->createIfNotExisting(
            'TruPulse Lasermätare',
            7,
            'Mätinstrument',
            'Laserteknologins engagemang för hög kvalitet och oöverträffad innovation har gjort det möjligt för TruPulse-serien att stå emot tidens tand. Dessa mycket sofistikerade och lättmanövrerade laseravståndsmätare som använder reflektorlös teknologi är designade för att leverera de mätningar som krävs av branschfolk. TruTargeting-teknologin är inbyggd i varje TruPulse-enhet och erbjuder användaren fyra inriktningslägen att välja mellan och visar alla datavärden direkt inom siktomfånget.',
            'src/poster/TruPulseLasermätare.jpg'
        );
        $this->createIfNotExisting(
            'Inventax Digitala Dataklave',
            7,
            'Mätinstrument',
            'Inventax Digitala Dataklave är utvecklad för trådlös mätning med högsta noggrannhet. Via Bluetooth kommunicerar dataklaven med en app i användarens telefon, dator eller annan Android- eller iOS-enhet. Modellen är ergonomisk, ruggad och klassad enligt IP67.',
            'src/poster/InventaxDigitalaDataklave.jpg'
        );
        $this->createIfNotExisting(
            'SR13M',
            17,
            'Medical Tablet PC',
            'Innanför det hygieniska höljet på SR13M döljer sig en energieffektiv processor för stabil drift och patientsäker dokumentation i känsliga miljöer. Tablet PC:n har ett
        inbyggt stödben på baksidan för stående placering,
        och en rad praktiska tillbehör, som t ex tangentbordet
        som snabbt gör Tablet PC:n till en funktionell laptop. Certifierad enligt ANSI/AAMI ES60601-1.',
            'src/poster/SR13M.jpg'
        );
        $this->createIfNotExisting(
            'SR16M',
            14,
            'Medical Tablet PC',
            'Med bakterieavvisande ytskikt är SR16M en hygienisk plattform för medicinska program och applikationer inom hälso- och sjukvård. Den UL60601-1-klassade Tablet PC:n har 16 tums kapacitiv touchskärm, energieffektiv Intel®-processor och HotSwap för batteribyten utan driftsstopp. 4G LTE/AWS mobilt bredband och NFC/RFID- och Smart Card/CAC-läsare finns som tillval.',
            'src/poster/SR16M.jpg'
        );
        $this->createIfNotExisting(
            'SR17M',
            8,
            'Medical Tablet PC',
            'SR17M är certifierad med UL60601-1 (internationell standard för elektrisk medicinsk utrustning) och har ett hygieniskt bakterieavvisande ytterhölje, enkelt att hålla rent. tablet PC:n är utmärkt som plattform för program och applikationer, som t.ex. Eye Gaze.',
            'src/poster/SR17M.jpg'
        );
        $this->createIfNotExisting(
            'AIO 21M',
            8,
            'Medical Tablet PC',
            'AIO 21M med sitt bakterieavvisande ytskikt är väl lämpad för program och applikationer inom hälso- och sjukvård. Tablet PC:n erbjuder en generös 21.5 tums Kapacitiv Touchskärm
        och en kraftfull och energieffektiv Intel® Core™ i-processor. SmartCard-läsare och extra batteripack (3 batterier)
        finns som tillval. HotSwap är standard för säker drift.
        ',
            'src/poster/AIO21M.jpg'
        );
        $this->createIfNotExisting(
            'AIO 24M',
            15,
            'Medical Tablet PC',
            'IO 24M med sitt bakterieavvisande ytskikt är väl lämpad för program och applikationer inom hälso- och sjukvård. Tablet PC:n erbjuder en generös 23.6 tums Kapacitiv Touchskärm
        och en kraftfull och energieffektiv Intel® Core™ i-processor. SmartCard-läsare och extra batteripack (3 batterier)
        finns som tillval. HotSwap är standard för säker drift.
        ',
            'src/poster/AIO24M.jpg'
        );
        $this->createIfNotExisting(
            'Ergo Pro Sele',
            15,
            'Utrustning',
            'Ergo Pro Sele är en innovativ och mycket bekväm bärutrustning som erbjuder suverän ergonomisk handsfree-lösning för alla som arbetar mobilt med datorer, mätinstrument, GNSS-controller etc.',
            'src/poster/ErgoProSele.jpg'
        );
        $this->createIfNotExisting(
            'Ergo Pro Kroken',
            10,
            'Utrustning',
            'Kroken är bärutrustningen för dig som värdesätter flexibilitet och att ha båda armarna fria under arbetsdagen. Denna skonsamma utrustning för din kropp är kompatibel med alla Tablet PC:s i vårt sortiment.
        ',
            'src/poster/ErgoProKroken.jpg'
        );
        $this->createIfNotExisting(
            '4-punktsele',
            9,
            'Utrustning',
            'Ergo Pro 4-punkts sele är en mycket kostnadseffektiv och bekväm bärutrusning för Tablets och fördelar tyngden effektivt och jämt över axlar och rygg. Datorn sitter i bekväm höjd och vinkel för att läsa och hantera. Eventuell inbyggd GPS får antennen i bra placering.',
            'src/poster/4punktsele.jpg'
        );
        $this->createIfNotExisting(
            'Ergo Pro polstrad axelrem',
            9,
            'Utrustning',
            'Polstrad mjuk bärrem som avlastar armarna och ger fria händer vid rörliga arbeten. Ergonomisk modell med vadderat axelparti som är skonsamt för nacke och axlar.',
            'src/poster/ErgoPropolstradaxelrem.jpg'
        );
        $this->createIfNotExisting(
            'Ergo Pro Flexbälte & Tillbehör',
            13,
            'Utrustning',
            'Ergo Pro Flexbälte erbjuder ett ergonomiskt och bekvämt sätt att bära med sig diverse utrustning. Den mjuka stoppning ger komfort både med tunna och tjocka kläder under. Runt bältet löper en plastskena på vilken löpare kan monteras på och på vilka sedan diverse hölster och väskor monteras. Dessa kan skjutas fram och tillbaka på bältet för bekväm position alternativt skjutas till baksidan för fri framsida. På ömse sidor om knäppningen finns en D-ring på vilka tillbehör kan monteras med t.ex. karbinhake.',
            'src/poster/ErgoProFlexbälte&Tillbehör.jpg'
        );
        $this->createIfNotExisting(
            'GNSS-utrustning',
            13,
            'Uthyrning',
            'Hyr din GPS/GNSS-utrustning! När du behöver kvalitativ teknik för ett tillfälligt arbete finns möjligheten att hyra utrustning.
        Forest it Design tillhandahåller toppmodern utrustning med högsta precision och kvalitet för den som vill skräddarsy sitt egna hyr-paket. Efter hyresperioden finns ofta möjlighet att köpa utrustningen till reducerat pris.',
            'src/poster/GNSSutrustning.jpg'
        );
        $this->createIfNotExisting(
            'Lasermätare',
            10000,
            'Uthyrning',
            'Vi har olika instrument för mätning av avstånd, höjd, lutning, riktning med mera och dessa kan användas både fristående och tillsammans med GNSS-utrustning för att enkelt och effektivt mäta in objekt på distans och med automatik placera in dessa på rätt plats på kartan.',
            'src/poster/Lasermätare.jpg'
        );
        $this->createIfNotExisting(
            'FIDS AIO M19',
            5000,
            'Tidigare Produkter',
            'FIDS AIO M19 levereras med Windows 10® och/eller Android 4.4®. Med tunn design, smart tilt-stöd och inbyggt batteri får du en portabel Tablet PC i storformat. Den 19,5" stora bildskärmen med betraktningsvidvinkel har hög läsbarhet. Displayen med 10-punkters multi-touchfunktion styrs med fingrarna eller med kapacitiv penna (tillval).',
            'src/poster/FIDSAIOM19.jpg'
        );
        $this->createIfNotExisting(
            'Getac MH132',
            20,
            'Tidigare Produkter',
            'MH132 är en fullt ruggad handdator. Kompakt som en mobiltelefon men kraftfull och smart som en dator. Får enkelt plats i byxfickan. Denna Smart PDA är det perfekta alternativet för fälthantering och kontaktbarhet både via telefon som e-post med det snabba mobila bredbandet med en nätverkshastighet på upp till 3,75G. Den inbyggda GPS:n navigerar dig till rätt adress...
        ',
            'src/poster/GetacMH132.jpg'
        );
        $this->createIfNotExisting(
            'Sahara Slate i440',
            50,
            'Tidigare Produkter',
            'i440T och i440D är de absoluta toppmodellerna i serien. Kraftfulla och fullmatade med finesser och ger de Dig maximal prestanda i alla lägen. Intel Core 2 Duo teknologi och upp till 4 GB RAM ger maximal datakraft även till tunga applikationer. Stöd för Windows 7 Professional men kan nedgraderas till XP Professional samt Linux. Balans är viktigt för en bärbar dator. En obalanserad dator känns tyngre och försämrar ergonomin. Datorerna i Sahara serien har det kraftfulla batteriet infällt på baksidan för oslagbar balans...
        ',
            'src/poster/SaharaSlatei440.jpg'
        );
        $this->createIfNotExisting(
            'Sahara Netslate',
            200,
            'Tidigare Produkter',
            'Sahara a230T och a230D är de senaste modellerna i serien. Utrustad med Intels Atom N270 processor har Netslate mycket lång batteridriftstid och ett lågt pris. Netslate kan även konfigureras med helt integrerad',
            'src/poster/SaharaNetslate.jpg'
        );
        $this->createIfNotExisting(
            'Sahara NetSlate a510',
            300,
            'Tidigare Produkter',
            'Storsäljaren Sahara NetSlate Tablet PC är nu här i andra generationen, Sahara NetSlate a510. Med det bästa från första generationen och nivån ”vassare” i allt vad gäller prestanda och mångsidighet. Designad för att öka produktiviteten och effektiviteten i er organisation till ett oslagbart pris. Optimal för volyminstallationer...',
            'src/poster/SaharaNetSlatea510.jpg'
        );
        $this->createIfNotExisting(
            'Sahara Slate i412',
            100,
            'Tidigare Produkter',
            'i412T är mellanmodellen i serien och kombinerar god prestanda med fördelaktigt pris. Egenskaper som gör att Sahara i412T ofta väljs för volyminstallationer. Intel Celeron processor och upp till 4 GB RAM ger god prestanda även till tunga applikationer. Stöd för Windows 7 Professional men kan nedgraderas till XP Professional samt Linux.',
            'src/poster/SaharaSlatei412.jpg'
        );
        $this->createIfNotExisting(
            'Armor X10al',
            80,
            'Tidigare Produkter',
            'Armor X10 är den tåligaste produkten i vårt sortiment och fortsätter fungera där andra alternativ gett upp sedan länge. DuraCase™ Skalet i aluminium med ShutOut™ teknologi ger stryktålighet. Varianten med aktiv digitizer har kemiskt härdat glas ger ytterligare tålighet.',
            'src/poster/ArmorX10al.jpg'
        );
        $this->createIfNotExisting(
            'Twinhead T8NY',
            350,
            'Tidigare Produkter',
            'T8NY är en mycket kraftfull och tålig Tablet PC för tuffa inom- och utomhusförhållanden. Den ergonomiska designen gör den smidig att arbeta med. T8NY har integrerad trådlös teknologi med bl.a. Bluetooth och WiFi. Med Pen/Touch kan Du arbeta såväl med fingrar som med elektronisk penna...',
            'src/poster/TwinheadT8NY.jpg'
        );
        $this->createIfNotExisting(
            'Trimble GeoExplorer 6000',
            15000,
            'Tidigare Produkter',
            'Trimble GeoExplorer 6000 XT/XH är handdatorn som tar GNSS produktiviteten till en helt ny nivå. Handdatorn levererar decimeter precision i realtid med dubblefrekvens L1/L2 och stöd för EGNOS. GeoExplorer har en 4,2” stor solljusbildskärm med touch och trådlösa kommunikationsverktyg som bluetooth, Wifi och 3,5G WWAN vilket är en perfekt arbetspartner i fält med 10h batteritid...',
            'src/poster/TrimbleGeoExplorer6000.jpg'
        );
        $products = true;

    }

    function createIfNotExisting($productName, $price, $categoryName, $description, $imgUrl)
    {
        $existing = $this->getProductByTitle($productName);
        if ($existing) {
            return;
        }
        ;
        return $this->addProduct($productName, $price, $categoryName, $description, $imgUrl);
    }

    function addCategory($title)
    {
        $prep = $this->pdo->prepare('INSERT INTO category (title) VALUES(:title )');
        $prep->execute(["title" => $title]);
        return $this->pdo->lastInsertId();
    }

    function addProduct($productName, $price, $categoryName, $description, $imgUrl)
    {
        $category = $this->getCategoryByTitle($categoryName);
        if ($category == false) {
            $this->addCategory($categoryName);
            $category = $this->getCategoryByTitle($categoryName);
        }
        $prep = $this->pdo->prepare('INSERT INTO products (productName, price, categoryId, description, imgUrl) VALUES(:productName, :price, :categoryId, :description, :imgUrl)');
        $prep->execute(["productName" => $productName, "price" => $price, "categoryId" => $category->id, "description" => $description, "imgUrl" => $imgUrl]);
        return $this->pdo->lastInsertId();
    }

    function updateProuct($id, $productName, $price, $categoryId, $descrption, $imgUrl)
    {
        $prep = $this->pdo->prepare("UPDATE Product SET
        productName=:productName, price=:price ,categoryId=:categoryId, descrption=:descrption, imgUrl=:imgUrl
        WHERE id= :id");
        $prep->execute(["productName" => $productName, "price" => $price, "categoryId" => $categoryId, "descrption" => $descrption, "imgUrl" => $imgUrl, "id" => $id]);
    }

    function addProuct($productName, $price, $categoryId, $description, $imgUrl)
    {
        $prep = $this->pdo->prepare("UPDATE INTO Product
        (productName, price, categoryId, descrption imgUrl) 
        (:productName, :price, :categoryId, :descrption, :imgUrl);");
        $prep->execute([
            "productName" => $productName,
            "price" => $price,
            "categoryId" => $categoryId,
            "description" => $description,
            "imgUrl" => $imgUrl
        ]);
        return $this->pdo->lastInsertId();
    }

    function ifTabletNotExist()
    {

        static $initialized = false;
        if ($initialized)
            return;


        $sql = "CREATE TABLE IF NOT EXISTS `category` (
            `id` INT AUTO_INCREMENT NOT NULL,
            `title` varchar(200) NOT NULL,
            PRIMARY KEY (`id`)
            ) ";

        $this->pdo->exec($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `products` (
            `id` INT AUTO_INCREMENT NOT NULL,
            `productName` varchar(200) NOT NULL,
            `price` INT,
            `categoryId` INT NOT NULL,
            `description` varchar(1000),
            `imgUrl` VARCHAR(500),
            PRIMARY KEY (`id`),
            FOREIGN KEY (`categoryId`)
            REFERENCES category(id)
            ) ";

        $this->pdo->exec($sql);

        $this->userDatabas->setUpUser();
        $this->userDatabas->seedUser();

        $initialized = true;
    }

}
