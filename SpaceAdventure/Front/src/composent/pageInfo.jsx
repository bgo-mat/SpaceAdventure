import "../App.css";
import { useEffect, useState,useContext } from 'react';
import React from 'react';
import searchFleche from "../assets/flecheSearch.png"
import SpaceContext from "../SpaceContext.jsx";


// eslint-disable-next-line react/prop-types
function InfoPage({display, dataProps, onToggleLoading,onToggleNext}) {

    const [urlImage, setUrlImage] = useState();
    const [planetsDesc, setPlanetsDesc] = useState();
    const [planetsName, setPlanetsName] = useState();
    const { loadSearch, setLoadSearch,rdmIdProps,  setRdmId,spaceData } = useContext(SpaceContext);

    useEffect(() => {
        if(dataProps){
            // eslint-disable-next-line react/prop-types
            setUrlImage(dataProps.image_link)
            // eslint-disable-next-line react/prop-types
            setPlanetsName(dataProps.name)
            // eslint-disable-next-line react/prop-types
            setPlanetsDesc(dataProps.description)
        }

    }, [dataProps]);

    const close = () => {

        onToggleLoading();
    };

    const antiClick = (e) => {
        e.stopPropagation();
    };

    const nextPlanet = () => {

       if(spaceData>rdmIdProps){
            setRdmId(rdmIdProps+1);
        }else{
           setRdmId(0);
        }

        onToggleNext("next");
    };

    const previousPlanet = () => {
       if(rdmIdProps<=0){
            setRdmId(spaceData);
        }else{
setRdmId(rdmIdProps-1)
        }

        onToggleNext("previous");
    };

    ////
    ////
    ////Auto scroll
    ////
    ////

    const [timer, setTimer] = useState(null);

    useEffect(() => {
        const handleActivity = () => {
            if (timer) {
                clearTimeout(timer);
                setTimer(null);
            }
            const newTimer = setTimeout(() => {

                const scrollX = 1;
                window.scrollBy({
                    top: scrollX,
                    behavior: 'smooth'
                });
            }, 1); // 5 secondes d'inactivité avant de déclencher le scroll

            setTimer(newTimer);
        };

        window.addEventListener('mousemove', handleActivity);
        window.addEventListener('keypress', handleActivity);
        window.addEventListener('scroll', handleActivity);

        return () => {
            window.removeEventListener('mousemove', handleActivity);
            window.removeEventListener('keypress', handleActivity);
            window.removeEventListener('scroll', handleActivity);
            if (timer) {
                clearTimeout(timer);
            }
        };
    }, [timer]);

    return (
        <div className="blocPageInfo" style={{display: display ? 'flex' : 'none'}} onClick={close}>
            <img src={searchFleche} alt="Galaxie" className="flecheRetour" onClick={(event)=>{
                antiClick(event); previousPlanet()}}/>
            <div className="carte" onClick={antiClick}>
                <img src={urlImage} alt="Galaxie" className="carte-image"/>
                <div className="carte-contenu">
                    <h1 className="textInfoPage">{planetsName}</h1>
                    <p className="textInfoPage">{planetsDesc}</p>
                    <button onClick={close}>close</button>
                </div>
            </div>
            <img src={searchFleche} alt="Galaxie" className="flecheSuivant" onClick={(event)=>{
                antiClick(event); nextPlanet()}}/>
        </div>
    );

}

export default InfoPage;
