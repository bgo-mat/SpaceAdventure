<?php


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token");

$requestData = json_decode(file_get_contents("php://input"), true);

$dataName = isset($requestData['planetName']) ? $requestData['planetName'] : '';
$type = isset($requestData['type']) ? $requestData['type'] : '';
$starOrSun = isset($requestData['starOrSun']) ? $requestData['starOrSun'] : '';

use modeleUser\User;

include __DIR__ . "/request.php";

$create = new User();
$lastJsonData = $create->getAllPlanets();
$existNames = array();

foreach ($lastJsonData as $item) {
    if (isset($item['name'])) {
        $existNames[] = $item['name'];
    }
}
$lastNamesString = implode(", ", $existNames);


if($dataName){

}else{
    $prompt = "Trouve un nom d'étoile ou de planète ou de trou noir ( à toi de choisir entre les 3 ) imaginaire .
    Tu me retournera uniquement le nom sans introduction ou phrase superflue.
    pas de points à la fin de ta réponse, renvoie juste un seul et unique nom.
    (exemple de chose à ne PAS m'envoyer : 'Planète : nom de la planète' 'Étoile : nom de l'étoile'.
    exemple de la chose attendue : 'nom de l'étoile'. c'est tout)
    Le nom ne doit absolument pas faire parti de cet liste : ".$lastNamesString;

    $system = "Tu est un expert en astronomie et en invention de nom de planètes et étoiles.";

    $temperature = 0.5;
    $token = 50;
    $model = "gpt-3.5-turbo-0125";
    $endpoint = "https://api.openai.com/v1/chat/completions";
    $param = 1;
    $response = executeCall($prompt, $system, $temperature, $token, $model, $endpoint, $param);
    if($response){
        $name = json_decode($response, true);
        $dataName = $name['choices'][0]['message']['content'];
    }
}



function callDesc($starOrSun, $dataName,$type)
{
    if ($starOrSun === "planet") {
        if($type==="gazeuse"){
            $prompt = "invente une description pour une planète gazeuse fictive. 
            La déscription doit être dans un style cool mais quand même crédible, avec des thermes un peu scientifique.
            Si tu souhaite parler de données comme la tempêrature ou des distances, 
            ta description est a destination d'un publique français, 
            tu devras donc parlé en degré celsius (℃) et en mètre kilomètre etc.. (M, KM,etc..). 
            Tu me retournera uniquement la déscription sans introduction ou phrase superflue.
            Tu devras respecter une limite de 540 carctère maximum (en comptant les espaces).
             La description devra se baser sur ce nom :".$dataName ;

            $system = "Tu est un expert en astronomie et en invention de déscription de planètes et étoiles. 
        Tu devras respecter une limite de 540 caractères maximum(espace compris). 
        Tu devras donc faire attention a bien finir ta dernière phrases avant d'atteindre cet limite de 540 caractère";

            $temperature = 0.5;
            $token = 200;
            $model = "gpt-4-0125-preview";
            $endpoint = "https://api.openai.com/v1/chat/completions";
            $param = 1;
            return executeCall($prompt, $system, $temperature, $token, $model, $endpoint, $param);
        }
        if($type==="liquide"){
            $prompt = "invente une description pour une planète liquide fictive. 
            La déscription doit être dans un style cool mais quand même crédible, avec des thermes un peu scientifique.
            Si tu souhaite parler de données comme la tempêrature ou des distances, 
            ta description est a destination d'un publique français, 
            tu devras donc parlé en degré celsius (℃) et en mètre kilomètre etc.. (M, KM,etc..).
             Tu me retournera uniquement la déscription sans introduction ou phrase superflue.
Tu devras respecter une limite de 540 carctère maximum (en comptant les espaces).
             La description devra se baser sur ce nom :".$dataName ;

            $system = "Tu est un expert en astronomie et en invention de déscription de planètes et étoiles. 
        Tu devras respecter une limite de 540 caractères maximum(espace compris). 
        Tu devras donc faire attention a bien finir ta dernière phrases avant d'atteindre cet limite de 540 caractère";

            $temperature = 0.5;
            $token = 200;
            $model = "gpt-4-0125-preview";
            $endpoint = "https://api.openai.com/v1/chat/completions";
            $param = 1;
            return executeCall($prompt, $system, $temperature, $token, $model, $endpoint, $param);
        }
        if($type==="rocheuse"){
            $prompt = "invente une description pour une planète telluriques fictive. 
            La déscription doit être dans un style cool mais quand même crédible, avec des thermes un peu scientifique .
            Si tu souhaite parler de données comme la tempêrature ou des distances, 
            ta description est a destination d'un publique français, 
            tu devras donc parlé en degré celsius (℃) et en mètre kilomètre etc.. (M, KM,etc..).
            Tu me retournera uniquement la déscription sans introduction ou phrase superflue.
Tu devras respecter une limite de 540 carctère maximum (en comptant les espaces).
             La description devra se baser sur ce nom :".$dataName ;

            $system = "Tu est un expert en astronomie et en invention de déscription de planètes et étoiles. 
        Tu devras respecter une limite de 540 caractères maximum(espace compris). 
        Tu devras donc faire attention a bien finir ta dernière phrases avant d'atteindre cet limite de 540 caractère";

            $temperature = 0.5;
            $token = 200;
            $model = "gpt-4-0125-preview";
            $endpoint = "https://api.openai.com/v1/chat/completions";
            $param = 1;
            return executeCall($prompt, $system, $temperature, $token, $model, $endpoint, $param);
        }
        if($type==="none"){
            $prompt = "invente une description pour une planète fictive. La planète peut être de tout type (gazeux, telluriques,etc...). 
            La déscription doit être dans un style cool mais quand même crédible, avec des thermes un peu scientifique .
            Si tu souhaite parler de données comme la tempêrature ou des distances, 
            ta description est a destination d'un publique français, 
            tu devras donc parlé en degré celsius (℃) et en mètre kilomètre etc.. (M, KM,etc..). 
            Tu me retournera uniquement la déscription sans introduction ou phrase superflue.
Tu devras respecter une limite de 540 carctère maximum (en comptant les espaces).
             La description devra se baser sur ce nom :".$dataName ;

            $system = "Tu est un expert en astronomie et en invention de déscription de planètes et étoiles. 
        Tu devras respecter une limite de 540 caractères maximum(espace compris). 
        Tu devras donc faire attention a bien finir ta dernière phrases avant d'atteindre cet limite de 540 caractère";

            $temperature = 0.5;
            $token = 200;
            $model = "gpt-4-0125-preview";
            $endpoint = "https://api.openai.com/v1/chat/completions";
            $param = 1;
            return executeCall($prompt, $system, $temperature, $token, $model, $endpoint, $param);
        }

    }

    if ($starOrSun === "star") {
        if($type==="naine"){
            $prompt = "invente une description pour une étoile naine fictive. 
            La déscription doit être dans un style cool mais quand même crédible, avec des thermes un peu scientifique .
            Si tu souhaite parler de données comme la tempêrature ou des distances, 
            ta description est a destination d'un publique français, 
            tu devras donc parlé en degré celsius (℃) et en mètre kilomètre etc.. (M, KM,etc..).
            Tu me retournera uniquement la déscription sans introduction ou phrase superflue.
Tu devras respecter une limite de 540 carctère maximum (en comptant les espaces).
             La description devra se baser sur ce nom :".$dataName ;

            $system = "Tu est un expert en astronomie et en invention de déscription de planètes et étoiles. 
        Tu devras respecter une limite de 540 caractères maximum(espace compris). 
        Tu devras donc faire attention a bien finir ta dernière phrases avant d'atteindre cet limite de 540 caractère";

            $temperature = 0.5;
            $token = 200;
            $model = "gpt-4-0125-preview";
            $endpoint = "https://api.openai.com/v1/chat/completions";
            $param = 1;
            return executeCall($prompt, $system, $temperature, $token, $model, $endpoint, $param);
        }
        if($type==="giant"){
            $prompt = "invente une description pour une étoile géante fictive. 
            La déscription doit être dans un style cool mais quand même crédible, avec des thermes un peu scientifique .
            Si tu souhaite parler de données comme la tempêrature ou des distances, 
            ta description est a destination d'un publique français, 
            tu devras donc parlé en degré celsius (℃) et en mètre kilomètre etc.. (M, KM,etc..).
            Tu me retournera uniquement la déscription sans introduction ou phrase superflue.
Tu devras respecter une limite de 540 carctère maximum (en comptant les espaces).
             La description devra se baser sur ce nom :".$dataName ;

            $system = "Tu est un expert en astronomie et en invention de déscription de planètes et étoiles. 
        Tu devras respecter une limite de 540 caractères maximum(espace compris). 
        Tu devras donc faire attention a bien finir ta dernière phrases avant d'atteindre cet limite de 540 caractère";

            $temperature = 0.5;
            $token = 200;
            $model = "gpt-4-0125-preview";
            $endpoint = "https://api.openai.com/v1/chat/completions";
            $param = 1;
            return executeCall($prompt, $system, $temperature, $token, $model, $endpoint, $param);
        }
        if($type==="supergiant"){
            $prompt = "invente une description pour une étoile supergéante fictive. 
            La déscription doit être dans un style cool mais quand même crédible, avec des thermes un peu scientifique . 
            Si tu souhaite parler de données comme la tempêrature ou des distances, 
            ta description est a destination d'un publique français, 
            tu devras donc parlé en degré celsius (℃) et en mètre kilomètre etc.. (M, KM,etc..).
            Tu me retournera uniquement la déscription sans introduction ou phrase superflue.
Tu devras respecter une limite de 540 carctère maximum (en comptant les espaces).
             La description devra se baser sur ce nom :".$dataName ;

            $system = "Tu est un expert en astronomie et en invention de déscription de planètes et étoiles. 
        Tu devras respecter une limite de 540 caractères maximum(espace compris). 
        Tu devras donc faire attention a bien finir ta dernière phrases avant d'atteindre cet limite de 540 caractère";

            $temperature = 0.5;
            $token = 200;
            $model = "gpt-4-0125-preview";
            $endpoint = "https://api.openai.com/v1/chat/completions";
            $param = 1;
            return executeCall($prompt, $system, $temperature, $token, $model, $endpoint, $param);
        }
        if($type==="none"){
            $prompt = "invente une description pour une étoile fictive. L'étoile peut être de tout type (naine, géante, supergéante,etc...). 
            La déscription doit être dans un style cool mais quand même crédible, avec des thermes un peu scientifique.
            Si tu souhaite parler de données comme la tempêrature ou des distances, 
            ta description est a destination d'un publique français, 
            tu devras donc parlé en degré celsius (℃) et en mètre kilomètre etc.. (M, KM,etc..).
            Tu me retournera uniquement la déscription sans introduction ou phrase superflue.
            Tu devras respecter une limite de 540 carctère maximum (en comptant les espaces).
             La description devra se baser sur ce nom :".$dataName ;

            $system = "Tu est un expert en astronomie et en invention de déscription de planètes et étoiles. 
        Tu devras respecter une limite de 540 caractères maximum(espace compris). 
        Tu devras donc faire attention a bien finir ta dernière phrases avant d'atteindre cet limite de 540 caractère";

            $temperature = 0.5;
            $token = 200;
            $model = "gpt-4-0125-preview";
            $endpoint = "https://api.openai.com/v1/chat/completions";
            $param = 1;
            return executeCall($prompt, $system, $temperature, $token, $model, $endpoint, $param);
        }


    }

    if($starOrSun==="none"){

            $prompt = "invente une description pour une étoile ou une planète ou un trou noir (a toi de choisir entre étoile ou planète ou trou noir) fictive. 
            L'étoile, la planète ou le trou noir peut être de tout type (naine, géante, supergéante, gazeuse, solide, etc...). 
            La déscription doit être dans un style cool mais quand même crédible, avec des thermes un peu scientifique.
            Si tu souhaite parler de données comme la tempêrature ou des distances, 
            ta description est a destination d'un publique français, 
            tu devras donc parlé en degré celsius (℃) et en mètre kilomètre etc.. (M, KM,etc..).
            Tu me retournera uniquement la déscription sans introduction ou phrase superflue.
            Tu devras respecter une limite de 540 carctère maximum (en comptant les espaces).
             La description devra se baser sur ce nom :".$dataName ;


        $system = "Tu est un expert en astronomie et en invention de déscription de planètes, d'étoiles et de trou noir. 
        Tu devras respecter une limite de 540 caractères maximum(espace compris). 
        Tu devras donc faire attention a bien finir ta dernière phrases avant d'atteindre cet limite de 540 caractère";

        $temperature = 0.5;
        $token = 200;
        $model = "gpt-4-0125-preview";
        $endpoint = "https://api.openai.com/v1/chat/completions";
        $param = 1;
        return executeCall($prompt, $system, $temperature, $token, $model, $endpoint, $param);

    }


    if ($starOrSun === "hole") {

        $prompt = "invente une description pour un trou noir fictife. 
            La déscription doit être dans un style cool mais quand même crédible, avec des thermes un peu scientifique.
            Si tu souhaite parler de données comme la tempêrature ou des distances, 
            ta description est a destination d'un publique français, 
            tu devras donc parlé en degré celsius (℃) et en mètre kilomètre etc.. (M, KM,etc..).
            Tu me retournera uniquement la déscription sans introduction ou phrase superflue.
            Tu devras respecter une limite de 540 carctère maximum (en comptant les espaces).
             La description devra se baser sur ce nom :".$dataName ;


        $system = "Tu est un expert en astronomie et en invention de déscription de trou noir. 
        Tu devras respecter une limite de 540 caractères maximum(espace compris). 
        Tu devras donc faire attention a bien finir ta dernière phrases avant d'atteindre cet limite de 540 caractère";

        $temperature = 0.5;
        $token = 200;
        $model = "gpt-4-0125-preview";
        $endpoint = "https://api.openai.com/v1/chat/completions";
        $param = 1;
        return executeCall($prompt, $system, $temperature, $token, $model, $endpoint, $param);


    }
}



function getDetailOfDesc($descInput,$type){

    if($type==="star"){
        $prompt = "Bonjour, j'ai une description détaillée d'une étoile imaginaire qui comprend des éléments narratifs.
         Pourrais-tu extraire uniquement les éléments visuels clés qui sont nécessaires pour générer une image de cette étoile ? 
         J'aimerais que tu ignores les éléments narratifs et descriptifs qui ne contribuent pas directement à l'imagerie visuelle. 
         Tu me retournera uniquement la réponse sans introduction ou phrase superflue.
         Voici la description :".$descInput ;

        $system = "Tu es un expert en astronomie et en visualisation spatiale. Ton rôle est d'analyser des descriptions de corps célestes et de distiller les informations en éléments visuels précis et descriptifs. En se basant sur une description fournie, tu dois extraire les caractéristiques essentielles qui peuvent être illustrées visuellement, sans tenir compte des éléments narratifs ou littéraires superflus. Ta réponse doit être une liste claire et concise des détails visuels qui seront utilisés pour créer une image de cet étoile.";
        $temperature = 0.5;
        $token = 200;
        $model = "gpt-4-0125-preview";
        $endpoint = "https://api.openai.com/v1/chat/completions";
        $param = 1;
        return executeCall($prompt, $system, $temperature, $token, $model, $endpoint, $param);
    }
    if($type==="planet"){
        $prompt = "Bonjour, j'ai une description détaillée d'une planète imaginaire qui comprend des éléments narratifs.
         Pourrais-tu extraire uniquement les éléments visuels clés qui sont nécessaires pour générer une image de cette planète ? 
         J'aimerais que tu ignores les éléments narratifs et descriptifs qui ne contribuent pas directement à l'imagerie visuelle.
         Remplace aussi les données en kilomètre ou degré celsius part des mots 
         (exemple : 100000000 degrés = très chaud, 1 degré = froid,etc...., 
         1 killomètre = petit ou court, 10000000 kilomètre = grand ou loin,etc...). 
         Tu me retournera uniquement la réponse sans introduction ou phrase superflue.
         Voici la description :".$descInput ;

        $system = "Tu es un expert en astronomie et en visualisation spatiale. Ton rôle est d'analyser des descriptions de corps célestes et de distiller les informations en éléments visuels précis et descriptifs. En se basant sur une description fournie, tu dois extraire les caractéristiques essentielles qui peuvent être illustrées visuellement, sans tenir compte des éléments narratifs ou littéraires superflus. Ta réponse doit être une liste claire et concise des détails visuels qui seront utilisés pour créer une image de cette planète.";
        $temperature = 0.5;
        $token = 200;
        $model = "gpt-4-0125-preview";
        $endpoint = "https://api.openai.com/v1/chat/completions";
        $param = 1;
        return executeCall($prompt, $system, $temperature, $token, $model, $endpoint, $param);
    }
    if($type==="none"){
        $prompt = "Bonjour, j'ai une description détaillée d'une planète/étoile/trou noir imaginaire qui comprend des éléments narratifs.
         Pourrais-tu extraire uniquement les éléments visuels clés qui sont nécessaires pour générer une image de cette planète/étoile/trou noir ? 
         J'aimerais que tu ignores les éléments narratifs et descriptifs qui ne contribuent pas directement à l'imagerie visuelle.
         Remplace aussi les données en kilomètre ou degré celsius part des mots 
         (exemple : 100000000 degrés = très chaud, 1 degré = froid,etc...., 
         1 killomètre = petit ou court, 10000000 kilomètre = grand ou loin,etc...). 
         Tu me retournera uniquement la réponse sans introduction ou phrase superflue.
         Voici la description :".$descInput ;

        $system = "Tu es un expert en astronomie et en visualisation spatiale. Ton rôle est d'analyser des descriptions de corps célestes et de distiller les informations en éléments visuels précis et descriptifs. En se basant sur une description fournie, tu dois extraire les caractéristiques essentielles qui peuvent être illustrées visuellement, sans tenir compte des éléments narratifs ou littéraires superflus. Ta réponse doit être une liste claire et concise des détails visuels qui seront utilisés pour créer une image de cette planète/étoile/trou noir.";
        $temperature = 0.5;
        $token = 200;
        $model = "gpt-4-0125-preview";
        $endpoint = "https://api.openai.com/v1/chat/completions";
        $param = 1;
        return executeCall($prompt, $system, $temperature, $token, $model, $endpoint, $param);
    }
    if($type==="hole"){
        $prompt = "Bonjour, j'ai une description détaillée d'un trou noir imaginaire qui comprend des éléments narratifs.
         Pourrais-tu extraire uniquement les éléments visuels clés qui sont nécessaires pour générer une image de ce trou noir ? 
         J'aimerais que tu ignores les éléments narratifs et descriptifs qui ne contribuent pas directement à l'imagerie visuelle.
         Remplace aussi les données en kilomètre ou degré celsius part des mots 
         (exemple : 100000000 degrés = très chaud, 1 degré = froid,etc...., 
         1 killomètre = petit ou court, 10000000 kilomètre = grand ou loin,etc...). 
         Tu me retournera uniquement la réponse sans introduction ou phrase superflue.
         Voici la description :".$descInput ;

        $system = "Tu es un expert en astronomie et en visualisation spatiale. Ton rôle est d'analyser des descriptions de corps célestes et de distiller les informations en éléments visuels précis et descriptifs. En se basant sur une description fournie, tu dois extraire les caractéristiques essentielles qui peuvent être illustrées visuellement, sans tenir compte des éléments narratifs ou littéraires superflus. Ta réponse doit être une liste claire et concise des détails visuels qui seront utilisés pour créer une image de ce trou noir.";
        $temperature = 0.5;
        $token = 200;
        $model = "gpt-4-0125-preview";
        $endpoint = "https://api.openai.com/v1/chat/completions";
        $param = 1;
        return executeCall($prompt, $system, $temperature, $token, $model, $endpoint, $param);
    }



}

function callImg($desc, $wichOne){
    if($wichOne==="planet"){
        $prompt = "Create a hyper-realistic image of a single planet dominating the center of the composition, 
        viewed from the vacuum of space with no other celestial bodies or artificial objects in view. 
        The planet should be depicted in rich detail, 
        with a realistic texture that evokes its unique atmospheric 
        and surface characteristics based on the following description: ".$desc.". 
        The background should be a clear, star-filled space, 
        devoid of any text or terrestrial features.";
        $system = "";
        $temperature = 1;
        $token = 120;
        $model = "dall-e-3";
        $endpoint = "https://api.openai.com/v1/images/generations";
        $param = 2;
        return executeCall($prompt, $system, $temperature, $token, $model, $endpoint, $param);
    }else if($wichOne==="star"){
        $prompt = "Generate a hyper-realistic image of 
        a single star shining brightly at the center of the composition, 
        viewed against the vastness of space. There should be no other celestial bodies 
        or artificial objects in the frame. The star should be detailed, 
        radiating light and energy, 
        and reflecting specific characteristics based on the following description: ". $desc.". 
        The background must be pure space, scattered with distant stars, 
        and without any text or planetary bodies.";
        $system = "";
        $temperature = 1;
        $token = 120;
        $model = "dall-e-3";
        $endpoint = "https://api.openai.com/v1/images/generations";
        $param = 2;
        return executeCall($prompt, $system, $temperature, $token, $model, $endpoint, $param);
    }else if($wichOne==="none"){

        $prompt = "Craft a hyper-realistic image of either a single planet or star or black hole, 
        as specified by the user, placed centrally in the composition, viewed from outer space. 
        The celestial body should be the sole focus, with no other planets, moons, or stars near it, 
        and must not contain any artificial satellites, text, 
        or elements from Earth's surface. 
        It should be a majestic and accurate portrayal as seen through a high-power telescope. 
        The backdrop should be the deep cosmos, speckled with far-off stars. 
        The specific details are as follows: ".  $desc;
        $system = "";
        $temperature = 1;
        $token = 120;
        $model = "dall-e-3";
        $endpoint = "https://api.openai.com/v1/images/generations";
        $param = 2;
        return executeCall($prompt, $system, $temperature, $token, $model, $endpoint, $param);
    }else if($wichOne==="hole"){

        $prompt = "Create a hyper-realistic image of a black hole dominating the center of the composition, 
        viewed from the vacuum of space with no other celestial bodies or artificial objects in view. 
        The black hole should be depicted in rich detail, 
        with a realistic texture that evokes its unique atmospheric 
        and surface characteristics based on the following description: ".$desc.". 
        The background should be a clear, star-filled space, 
        devoid of any text or terrestrial features.";
        $system = "";
        $temperature = 1;
        $token = 120;
        $model = "dall-e-3";
        $endpoint = "https://api.openai.com/v1/images/generations";
        $param = 2;
        return executeCall($prompt, $system, $temperature, $token, $model, $endpoint, $param);
    }


}

function executeCall($prompt, $system, $temperature, $token, $model, $endpoint, $param)
{
    $endpoint = $endpoint;

    $apiKey = "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";

    if ($param === 1) {
        $data = array(
            "model" => $model,
            "messages" => array(
                array(
                    "role" => "system",
                    "content" => $system
                ),
                array(
                    "role" => "user",
                    "content" => $prompt
                )
            ),
            "max_tokens" => $token,
            "temperature" => $temperature
        );
    } elseif ($param === 2) {
        $data = array(
            "model" => $model,
            "prompt" => $prompt,
            "n" => $temperature,
            "size" => "1024x1024"
        );
    }



    $headers = array(
        "Content-Type: application/json",
        "Authorization: Bearer " . $apiKey
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $endpoint);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

function downloadImage($url, $savePath) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
    $raw = curl_exec($ch);
    curl_close($ch);

    if(file_exists($savePath)){
        unlink($savePath);
    }
    $fp = fopen($savePath,'x');
    fwrite($fp, $raw);
    fclose($fp);
}



$imgDir = "./img/";

$execCall = callDesc($starOrSun, $dataName,$type);
if($execCall){
    $valDesc=json_decode($execCall, true);
    if($valDesc){
        $descCle = $valDesc['choices'][0]['message']['content'];
       $detailDescJson= getDetailOfDesc($valDesc['choices'][0]['message']['content'],$starOrSun);
        $detailDesc = json_decode($detailDescJson, true);
       if($detailDesc){
           $valImg = callImg($detailDesc['choices'][0]['message']['content'],$starOrSun);
           $inputImg = json_decode($valImg, true);
           if($inputImg){

               $imageURL = $inputImg['data'][0]['url'];
               $imagePath = $imgDir .$dataName .".png";

               downloadImage($imageURL, $imagePath);

               $relativeImagePath = substr($imagePath, 6);
               $imageURLStocker = "http://localhost:8000/img/" . $relativeImagePath;

               $create->insertData($dataName,
                   $valDesc['choices'][0]['message']['content'],
                   $imageURLStocker);
               $retour="ok";
           }
       }
    }
}



header("Content-Type: application/json");


echo json_encode($retour);