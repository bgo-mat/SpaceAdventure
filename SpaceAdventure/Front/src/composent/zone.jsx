import "../App.css";
import { useEffect, useState,useContext } from 'react';
import React from 'react';
import SpaceContext from '../SpaceContext.jsx';
import InfoPage from "./pageInfo.jsx";

function Zone({load}) {

    const { spaceData, dataProps, setDataProps, loadSearch, setLoadSearch,rdmIdProps,  setRdmId} = useContext(SpaceContext);

    ////
    ////
    //// Partie des mouvements sur la page grace au curseur
    ////
    ////

    const [isDragging, setIsDragging] = useState(false);
    const [startX, setStartX] = useState(0);
    const [startY, setStartY] = useState(0);
    const [velocityX, setVelocityX] = useState(0);
    const [velocityY, setVelocityY] = useState(0);

    const onMouseDown = (e) => {
        setIsDragging(true);
        setStartX(e.clientX);
        setStartY(e.clientY);
    };

    const onMouseMove = (e) => {
        if (!isDragging) return;
        const x = e.clientX;
        const y = e.clientY;

        const dx = x - startX;
        const dy = y - startY;

        setVelocityX(dx);
        setVelocityY(dy);

        window.scrollBy(-dx, -dy);
        setStartX(x);
        setStartY(y);
    };

    const onMouseUp = () => {
        setIsDragging(false);
        continueMovingWithInertia(velocityX, velocityY);
    };

    useEffect(() => {
        const x = (10000 - window.innerWidth) / 2;
        const y = (10000 - window.innerHeight) / 2;

        window.scrollTo(x, y);
    }, []);

    function continueMovingWithInertia(velocityX, velocityY) {
        let friction = 0.95;
        let stopThreshold = 0.5;

        function move() {
            window.scrollBy(-velocityX, -velocityY);

            velocityX *= friction;
            velocityY *= friction;

            if (Math.abs(velocityX) > stopThreshold || Math.abs(velocityY) > stopThreshold) {
                requestAnimationFrame(move);
            }
        }

        move();
    }

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


    ////
    ////
    //// REQUETE VERS BD NOM D'ETOILE
    ////puis
    ////Assigne un id random pour l'affichage au hover des planetes
    ////


    const [allData, setAllData]= useState([])
    const [numberSun, setNumberSun]= useState()

    const [urlImage, setUrlImage] = useState();
    const [planetsDesc, setPlanetsDesc] = useState("");
    const [planetsName, setPlanetsName] = useState("");


    useEffect(() => {
        fetch(`http://localhost:8000/controller.php`, {
            method: "GET",
        })
            .then((res3) => {return res3.json()})
            .then((res3) => {
                setAllData(res3);
                setNumberSun(res3.length)

            })
    }, [load]);

    function getAllData (){
        const rdmId = Math.floor(Math.random() * numberSun)
        setRdmId(rdmId)
        setPlanetsName(allData[rdmId]['name']);
        setPlanetsDesc(allData[rdmId]['description'])
        setUrlImage(allData[rdmId]['image_link'])
    }


    ////
    /////
    /////Génération des cercles
    ////

    const [circles, setCircles] = useState([]);
    const containerSize = 9700;
    const minCircleSize = 5;  // Taille minimale du cercle
    const maxCircleSize = 25; // Taille maximale du cercle
    const minSpacing = 5;
    const allColor = [
       /*
        [25,20,122, 0.8],
        [27,28,130, 0.8],
        [27,87,160, 0.8],
        [46,131,178, 0.8],
        [107,192,214, 0.8],
        [176,218,228, 0.8],
        [211,233,239, 0.8],
        [241,243,233, 0.8],*/
        [250,248,210, 0.8],/*
        [254,249,146, 0.8],
        [246,240,87, 0.8],
        [253,213,28, 0.8],
        [251,179,33, 0.8],
        [241,154,35, 0.8],
        [254,124,14, 0.8],
        [246,102,14, 0.8],
        [212,69,36, 0.8],
        [251,19,8, 0.8],
        [246,22,11, 0.8]*/
    ];

    useEffect(() => {
        const generateCircle = (existingCircles) => {
            while (true) {

                //Paramètre des cercles (css) :

                const rdmBlur= Math.floor(Math.random() * (8 - 5 + 1)) + 5
                const rdmBlurSize= Math.floor(Math.random() * (12 - 5 + 1)) + 5
                const rdmIndex =Math.floor(Math.random() * allColor.length);
                const id = Math.random();
                const color=`(${allColor[rdmIndex][0]},${allColor[rdmIndex][1]},${allColor[rdmIndex][2]}`;
                const shadow =`(${allColor[rdmIndex][0]},${allColor[rdmIndex][1]},${allColor[rdmIndex][2]}`;
                const circleSize = Math.floor(Math.random() * (maxCircleSize - minCircleSize + 1) + minCircleSize);
                const newCircle = {
                    id:id,
                    rdmBlur:rdmBlur,
                    rdmBlurSize:rdmBlurSize,
                    shadow:shadow,
                    color:color,
                    size: circleSize,
                    left: Math.random() * (containerSize - circleSize),
                    top: Math.random() * (containerSize - circleSize)
                };

                const isOverlapping = existingCircles.some(circle =>
                    Math.abs(circle.left - newCircle.left) < circleSize + minSpacing &&
                    Math.abs(circle.top - newCircle.top) < circleSize + minSpacing
                );

                if (!isOverlapping) {
                    return newCircle;
                }
            }
        };

        const newCircles = [];
        const totalCircles =maxStar(spaceData);


        for (let i = 0; i < totalCircles; i++) {
            newCircles.push(generateCircle(newCircles));
        }
        setCircles(newCircles);
    }, [spaceData,load]);

    function maxStar (input){
        if(input>1000){
            return 1000
        }else{
            return input;
        }
    }


    ////
    ////
    //Effet au survol des étoiles
    ///


    const [hoveredItem, setHoveredItem] = useState(null);
    const [lastVal, setLastVal] = useState(null);
    const [dataLoaded, setDataLoaded] = useState({});



    const handleMouseEnter = (index) => {

        if (!dataLoaded[index]) {
            if (lastVal !== index) {
                getAllData();
                setLastVal(index);
            }
            setDataLoaded({ ...dataLoaded, [index]: true });
        }
        setHoveredItem(index);
    };

    const handleMouseLeave = () => {
        setHoveredItem(null);
    };

    ///
    ///
    ///Affichage de plus d'informations sur les planètes au click
    ///
    ///

    const [isLoading, setIsLoading] = useState(false);


    function showInfo() {
           setIsLoading(!isLoading)
        setDataProps(allData[rdmIdProps])
    }

    function showInfo2(input) {

        if(input==="next"){
            if(rdmIdProps===allData.length){
                setDataProps(allData[0])
            }else{
                setDataProps(allData[rdmIdProps])
            }
        }else{
            if(rdmIdProps<2){

                setDataProps(allData[numberSun-1])
            }else{
                setDataProps(allData[rdmIdProps-2])
            }
        }

    }

    useEffect(() => {

    }, [dataProps]);


    useEffect(() => {
        if(loadSearch===true){
            setIsLoading(!isLoading)
            setDataProps(allData[rdmIdProps-1])
        }
    }, [loadSearch]);

    const toggleNext = (input) => {
        showInfo2(input)
    };

    useEffect(() => {

    }, [rdmIdProps]);

    const toggleLoading = () => {
        setIsLoading(prevIsLoading => !prevIsLoading);

    };

    return (
        <div className="blocZone"
             onMouseDown={onMouseDown}
             onMouseMove={onMouseMove}
             onMouseUp={onMouseUp}
             onMouseLeave={onMouseUp}>
            <InfoPage display={isLoading} dataProps={dataProps} onToggleNext={toggleNext} onToggleLoading={toggleLoading}/>
            {circles.map((circle, index) => {
                const renderHoveredItem = () => {
                    if (hoveredItem === index) {
                        return (
                            <div className="showOnHover"
                                 style={{
                                     left: `${circle.left}px`,
                                     top: `${circle.top}px`,
                                     id:`${circle.id}px`,
                                 }}>
                                <img src={urlImage} alt="Planète" className="showOnHoverImg"

                                />
                                <p className="showOnHoverText">{planetsName}</p>
                            </div>
                        );
                    }
                    return null;
                };

                return (
                    <React.Fragment key={index}>
                        <div className={`star star-moving`}
                             style={{
                                 boxShadow: hoveredItem === index ? `0 0 10px 16px rgb${circle.shadow}` : `0 0 ${circle.rdmBlur}px ${circle.rdmBlurSize}px rgb${circle.shadow}`,
                                 background: `rgba${circle.color}`,
                                 left: `${circle.left + 94}px`,
                                 top: `${circle.top + 300}px`,
                                 width: `${circle.size}px`,
                                 height: `${circle.size}px`,
                             }}
                             onMouseEnter={() => handleMouseEnter(index)}
                             onMouseLeave={handleMouseLeave}
                             onClick={() => showInfo()}
                        />
                        {renderHoveredItem()}
                    </React.Fragment>
                );
            })}
        </div>
    );

}

export default Zone;
