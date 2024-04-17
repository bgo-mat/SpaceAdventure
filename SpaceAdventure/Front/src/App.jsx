import './App.css';
import Zone from "./composent/zone.jsx";
import {BrowserRouter as Router, Routes, Route,Outlet} from "react-router-dom";
import {useEffect, useState,useContext} from 'react';
import logo from "./assets/logo.svg";
import waitGif from "./assets/waitGif2.gif"
import searchFleche from "./assets/flecheSearch.png"
import SpaceContext from './SpaceContext';


function Header() {

    const [isLoading, setIsLoading] = useState(false);
    const [loadAffichageNumber, setLoadAffichageNumber] = useState();
    const { setNouvelleDonnee, loadSearch,setLoadSearch,rdmIdProps, setRdmId } = useContext(SpaceContext);
    const [spaceObjectType, setSpaceObjectType] = useState('none');
    const [errorText, setError] = useState('');
    const [showError, setShowError] = useState("none");
    const [errorText2, setError2] = useState('');
    const [showError2, setShowError2] = useState("none");
    const [numberSun, setNumberSun]= useState();
    const [allDataBrut, setAllDataBrut]= useState();
    const { setSpaceData, setDataProps } = useContext(SpaceContext);
    const [loadingText, setLoadingText] = useState("Chargement en cours...");
    const texts = [
        "Le saviez-vous ? <br><br> Les étoiles filantes sont en fait des météorites brûlantes.",
        "Le saviez-vous ? <br><br> Venus tourne à l'opposé de la Terre.",
        "Le saviez-vous ? <br><br> Un jour sur Vénus dure plus longtemps qu'une année.",
        "Le saviez-vous ? <br><br> Il y a des montagnes sur Mars de 21 km de haut.",
        "Le saviez-vous ? <br><br> Une année sur Mercure dure 88 jours terrestres.",
        "Le saviez-vous ? <br><br> Jupiter a le plus grand océan de l'univers.",
        "Le saviez-vous ? <br><br> Les aurores de Saturne sont uniques.",
        "Le saviez-vous ? <br><br> Uranus tourne sur le côté.",
        "Le saviez-vous ? <br><br> Neptune a les vents les plus rapides.",
        "Le saviez-vous ? <br><br> Un costume spatial coûte 12 millions de dollars.",
        "Le saviez-vous ? <br><br> La Station Spatiale Internationale file à 28 000 km/h.",
        "Le saviez-vous ? <br><br> L'empreinte d'Apollo est toujours sur la Lune.",
        "Le saviez-vous ? <br><br> Il pleut des diamants sur Jupiter et Saturne.",
        "Le saviez-vous ? <br><br> Le soleil fait 99,86% de la masse du système solaire.",
        "Le saviez-vous ? <br><br> Un an lumière équivaut à 9,5 trillion km.",
        "Le saviez-vous ?<br><br> La Voie lactée mesure 105 700 années-lumière de large.",
        "Le saviez-vous ?<br><br> Mars a le plus grand canyon du système solaire.",
        "Le saviez-vous ?<br><br> L'espace est complètement silencieux.",
        "Le saviez-vous ?<br><br> La gravité crée des vagues d'espace-temps.",
        "Le saviez-vous ?<br><br> Il existe des lacs de méthane sur Titan.",
        "Le saviez-vous ? <br><br>Les galaxies s'éloignent les unes des autres.",
        "Le saviez-vous ?<br><br> Les trous noirs ne sont pas des tunnels.",
        "Le saviez-vous ? <br><br>Pluton est plus petite que la Russie.",
        "Le saviez-vous ? <br><br>Le Soleil voyage à 220 km/s.",
        "Le saviez-vous ? <br><br>Les étoiles à neutrons sont super denses.",
        "Le saviez-vous ? <br><br>Vénus est plus chaude que Mercure.",
        "Le saviez-vous ?<br><br> Il y a un nuage d'alcool dans l'espace.",
        "Le saviez-vous ? <br><br>Les pulsars émettent des ondes radio.",
        "Le saviez-vous ? <br><br>L'espace déforme le temps.",
        "Le saviez-vous ?<br><br> L'Univers est en expansion constante.",
        "Le saviez-vous ? <br><br>La lumière du soleil met 8 minutes à nous atteindre.",
        "Le saviez-vous ? <br><br>La Voie Lactée et Andromède vont se percuter dans 4 milliards d'années.",
        "Le saviez-vous ? <br><br>Le plus grand volcan du système solaire est sur Mars.",
        "Le saviez-vous ? <br><br>Les planètes naines sont plus nombreuses que les planètes classiques.",
        "Le saviez-vous ? <br><br>L'oxygène dans l'atmosphère de la Terre vient des plantes.",
        "Le saviez-vous ? <br><br>Le Soleil contient 99,8% de toute la matière dans le système solaire.",
        "Le saviez-vous ? <br><br>Les empreintes sur la Lune peuvent rester des millions d'années.",
        "Le saviez-vous ? <br><br>Les taches solaires peuvent être plus grandes que la Terre.",
        "Le saviez-vous ? <br><br>Les astronautes grandissent dans l'espace.",
        "Le saviez-vous ? <br><br>Il existe des tempêtes de sable sur Mars.",
        "Le saviez-vous ? <br><br>Le jour le plus long dans le système solaire est sur Vénus.",
        "Le saviez-vous ? <br><br>La gravité de la Lune crée les marées sur Terre.",
        "Le saviez-vous ? <br><br>Il fait -224°C sur Neptune.",
        "Le saviez-vous ? <br><br>Les anneaux de Saturne sont faits de glace et de roches.",
        "Le saviez-vous ? <br><br>Un jour martien dure 24 heures et 37 minutes.",
        "Le saviez-vous ? <br><br>Les comètes sont surnommées les 'étoiles filantes'.",
        "Le saviez-vous ? <br><br>La Grande Tache Rouge de Jupiter est une tempête géante.",
        "Le saviez-vous ? <br><br>Les étoiles se forment dans des nuages de gaz et de poussière.",
        "Le saviez-vous ? <br><br>La galaxie d'Andromède est la plus proche de la Voie Lactée.",
        "Le saviez-vous ? <br><br>Un astéroïde a causé l'extinction des dinosaures.",
        "Le saviez-vous ? <br><br>La Voie Lactée contient environ 100 milliards d'étoiles.",
        "Le saviez-vous ? <br><br>Les ondes gravitationnelles ont été prédites par Einstein.",
        "Le saviez-vous ? <br><br>Les télescopes spatiaux observent des galaxies lointaines."
    ];




    const sendData = () => {
        let planetName = document.getElementsByClassName("inputPlanetCreate")[0].value;
        let planetToShow = planetName;
        let nameExists = false;

        for (let i = 0; i < allDataBrut.length; i++) {
            if (allDataBrut[i]['name'].toUpperCase() === planetName.toUpperCase()) {
                nameExists = true;
                break;
            }
        }

        if (nameExists) {
            setError("Ce nom existe déjà...")
            setShowError("block");
            return;
        }

        setShowError("none");
        setIsLoading(true);

        const starOrSun = document.getElementsByClassName("inputPlanetSelector")[0].value;

        if(planetName){
        }else{
            planetToShow = "quelque chose"
        }

        const initialLoadingText = `Construction cosmique en cours : ${planetToShow} prend forme dans l'univers !`;
        texts.unshift(initialLoadingText);

        let index = 0;
        setLoadingText(texts[index]);

        const intervalId = setInterval(() => {
            let randomIndex;
            do {
                randomIndex = Math.floor(Math.random() * texts.length);
            } while (randomIndex === 0);

            setLoadingText(texts[randomIndex]);
        }, 5000);

        let type;
        if (starOrSun === "none" || starOrSun === "hole") {
            type = "none";
        } else {
            type = document.getElementsByClassName("inputPlanetSelectorType")[0].value;
        }

        const jsonData = {
            planetName: planetName,
            type: type,
            starOrSun: starOrSun
        }

        fetch(`http://localhost:8000/controllerInput.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(jsonData)
        })
            .then((res3) => {return res3.json()})
            .then((res3) => {
                setLoadAffichageNumber(res3)
                document.getElementsByClassName('inputPlanetCreate')[0].value="";
                document.getElementsByClassName('inputPlanetSelector')[0].value="none";
                setSpaceObjectType("none")
            })
            .catch(error => {
                console.error('Erreur:', error);
            })
            .finally(() => {
                setIsLoading(false);
                clearInterval(intervalId)
            });
    };


    useEffect(() => {
        fetch(`http://localhost:8000/controller.php`, {
            method: "GET",
        })
            .then((res3) => {return res3.json()})
            .then((res3) => {
                setNumberSun(res3.length);
                setSpaceData(res3.length);
                setNouvelleDonnee(res3)
                setAllDataBrut(res3)
            })
    }, [loadAffichageNumber, loadSearch]);

    useEffect(() => {
        setNumberSun(numberSun)
    }, [numberSun]);

    const [showBlocAllInput, setShowBlocAllInput] = useState(false);

    const search =()=>{
        const searchValue =document.getElementsByClassName("inputPlanet")[0].value;
        const jsonData = {
            input: searchValue,
        };

        fetch(`http://localhost:8000/controllerGetByName.php`, {
            method: "POST",
            body: JSON.stringify(jsonData),
            headers: {
                "Accept": "application/json",
                "Content-Type": "application/json"
            }

        })
            .then((res2) => res2.json())
            .then((res2) => {
                if(res2['result']===true){
                    if(loadSearch===false){
                        setLoadSearch(true);
                    }else{
                        setLoadSearch(false);
                    }
                    setShowError2("none");
                    setRdmId(res2['val']['id'])
                    setShowBlocAllInput(!showBlocAllInput)
                    document.getElementsByClassName('inputPlanet')[0].value="";
                }else{
                    setError2("Ce nom n'existe pas...")
                    setShowError2("block");
                }
            });
    }

    return (
<>
    <header className="blocHead">
        <div className="blocWait" style={{display: isLoading ? 'flex' : 'none'}}>
            <img className="waitGif" src={waitGif}/>
            <div className="blocTextWait" dangerouslySetInnerHTML={{ __html: loadingText }} />
        </div>

        <img src={logo} className="logo"/>
        <img src={searchFleche} alt="Arrow"
             className={`flecheSearch ${showBlocAllInput ? 'rotate180' : 'rotate90'}`}
             onClick={() => setShowBlocAllInput(!showBlocAllInput)}/>
        <div className={`blocAllInput ${showBlocAllInput ? "show" : ""}`}>
            <div className="searchBloc">
                <p className="textInput">Search :</p>
                <input className="inputPlanet" type="text" id="name"/>
                <button className="inputPlanetBtn margin-top" onClick={search}>Search</button>
                <p className="text-error" style={{display: showError2}}>{errorText2}</p>
                <div className="blocInfo">
                    <p className="textInfo">Total : {numberSun}</p>
                </div>
            </div>
            <div className="blocCreate">
                <p className="textInput">Create one :</p>
                <input className="inputPlanetCreate" type="text" id="name" placeholder="Name"/>
                <select
                    value={spaceObjectType}
                    className="inputPlanetSelector"
                    onChange={(e) => setSpaceObjectType(e.target.value)}
                >
                    <option value="none">Choose</option>
                    <option value="planet">Planète</option>
                    <option value="star">Étoile</option>
                    <option value="hole">Trou noir</option>
                </select>

                {spaceObjectType === 'planet' && (
                    <select className="inputPlanetSelectorType">
                        <option value="none">Détails</option>
                        <option value="gazeuse">Gazeuse</option>
                        <option value="rocheuse">Telluriques</option>
                    </select>
                )}
                {spaceObjectType === 'star' && (
                    <select className="inputPlanetSelectorType">
                        <option value="none">Détails</option>
                        <option value="naine">Naine</option>
                        <option value="giant">Géante</option>
                        <option value="supergiant">Supergéante</option>
                    </select>
                )}
                <button className="inputPlanetBtn" onClick={sendData}>Create</button>
                <p className="text-error" style={{display: showError}}>{errorText}</p>

            </div>
        </div>
    </header>
    <Outlet/>
</>
    )
}

function App() {

    const [spaceData, setSpaceData] = useState({});
    const [nouvelleDonnee, setNouvelleDonnee] = useState();
    const [dataProps, setDataProps] = useState();
    const [loadSearch, setLoadSearch] = useState(false);
    const [rdmIdProps, setRdmId] = useState();

    const providerValue = {
        spaceData,
        setSpaceData,
        nouvelleDonnee,
        setNouvelleDonnee,
        dataProps,
        setDataProps,
        loadSearch,
        setLoadSearch,
        rdmIdProps,
        setRdmId
    };

    return (
        <SpaceContext.Provider value={providerValue}>
        <Router>
            <Routes>
                <Route path={"/"} element={<Header/>}>
                    <Route path={""} element={<Zone load={nouvelleDonnee}/>}/>
                </Route>
            </Routes>
        </Router>
        </SpaceContext.Provider>
    )
}

export default App