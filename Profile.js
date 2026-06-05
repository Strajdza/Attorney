import { useState, useEffect, useRef } from "react";
import "./Profile.css";
import Cropper from "react-easy-crop";
import { Link } from "react-router-dom";
import steam from "./steam.png";
import ps from "./ps.png";
import Archive from "./Archive.png";

function createImage(url) {
  return new Promise((resolve) => {
    const image = new Image();
    image.src = url;
    image.onload = () => resolve(image);
  });
}

async function getCroppedImage(imagesrc, crop) {
  const image = await createImage(imagesrc);

  const canvas = document.createElement("canvas");
  const ctx = canvas.getContext("2d");

  canvas.width = crop.width;
  canvas.height = crop.height;

  ctx.drawImage(
    image,
    crop.x,
    crop.y,
    crop.width,
    crop.height,
    0,
    0,
    crop.width,
    crop.height
  );

  return new Promise((resolve) => {
    canvas.toBlob((blob) => {
      if (!blob) {
        console.log("Blob failed");
        resolve(null);
        return;
      }

      const file = new File([blob], "profile.jpg", {
        type: "image/jpeg",
      });

      resolve(file);
    }, "image/jpeg");
  });
}

function Profile({ success, setSuccess }) {
  const rawgCache = useRef(new Map())
  const [imagesrc, setImagesrc] = useState(null);
  const [profile, setProfile] = useState(null);
  const [username, setUsername] = useState("");
  const [loadingGames, setLoadingGames] = useState(true);
  const [crop, setCrop] = useState({ x: 0, y: 0 });
  const [zoom, setZoom] = useState(1);
  const [croppedAreaPixels, setCroppedAreaPixels] = useState(null);
  const [steamUrl, setUrl] = useState("");
  const [text, setText] = useState([]);
  const sortedGames = [...text].sort((a, b) =>
  a.name.localeCompare(b.name));
  const [loaded,setLoaded]=useState(false);
  const [pstext,setPSText]=useState([]);
  const [search,setSearch]=useState("");
  const [active, setActive] = useState(1);
  const filteredGames = sortedGames.filter((game) =>
  game.name.toLowerCase().includes(search.toLowerCase())
);
  const [searchResults, setSearchResults] = useState([]);
const [query, setQuery] = useState("");
  const displayedGames = search !==""? filteredGames:sortedGames;

  async function getRawgImage(name) {
  const res = await fetch(
    `http://localhost/MYAPPL/rawgLookup.php?name=${encodeURIComponent(name)}`
  );

  const data = await res.json();
  return data.rawg_image;
}

  async function getPsGames(){
      const response = await fetch("http://localhost/MYAPPL/GetPSGames.php",{
        method: "POST",
        credentials: "include"
      });
      const data = await response.json();
      console.log(data);
      setPSText(Array.isArray(data) ? data : data.psgames || []);
    }
    async function LoadPicture() {
      const response = await fetch("http://localhost/MYAPPL/GetUserInfo.php", {
    method: "POST",
    credentials: "include",
  });
  const data = await response.json();

  setProfile(data.profile_picture);
    }LoadPicture();
    async function SyncSteam(){
      
      const response= await fetch("http://localhost/MYAPPL/syncSteam.php",{
        method: "POST",
        credentials:"include"
      });
      
    await LoadGames();
      
    }
    
    async function getUser(){
      const response = await fetch("http://localhost/MYAPPL/getUser.php",{
        method:"POST",
        credentials: "include",
      
      });
      const data = await response.json();
      if(data.success){
      setUsername(data.username)
      }
    }
    
  async function LoadGames() {
      setLoadingGames(true)
      const response = await fetch("http://localhost/MYAPPL/getGames.php", {
        method: "POST",
        credentials: "include",
      });

      const data = await response.json();

      setText(data.games || []);
      setLoadingGames(false)
    }

  function handleFile(e) {
    const file = e.target.files[0];

    if (!file) {
      console.log("No file selected");
      return;
    }

    e.target.value = "";
    setImagesrc(URL.createObjectURL(file));
  }

  const changeColor = (color) => {
    document.documentElement.style.setProperty("--bgcolor", color);
  };

  async function Logout() {
    await fetch("http://localhost/MYAPPL/Logout.php", {
      credentials: "include"
    });
    setSuccess(false);
    setUsername(null);
    setLoaded(false);
    localStorage.clear();
  }

  function onCropComplete(croppedArea, croppedAreaPixels) {
    setCroppedAreaPixels(croppedAreaPixels);
  }

  async function saveCroppedImage() {
    const croppedFile = await getCroppedImage(imagesrc, croppedAreaPixels);

    if (!croppedFile) {
      console.log("No cropped file created");
      return;
    }

    await uploadImage(croppedFile);
    setImagesrc(null);
  }

  useEffect(() => {
    getUser();
    LoadGames();
    getPsGames();
  }, []);
  async function searchRAWG() {
  const res = await fetch(
    `https://api.rawg.io/api/games?key=01cc9075754b4483baae5789d6316d6a&search=${encodeURIComponent(query)}`
  );

  const data = await res.json();
  setSearchResults(data.results || []);
}
async function addGame(game) {
   console.log("CLICKED ADD:", game);
  const payload = {
    appID: game?.id ?? null,
    name: game?.name ?? null,
    image: game?.background_image ?? "",
    source: "rawg"
  };

  console.log("SENDING:", payload);

  const res = await fetch("http://localhost/MYAPPL/addGame.php", {
    method: "POST",
    credentials: "include",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(payload),
  });

  const text = await res.text();
console.log(text);

  await LoadGames();

}
  async function apiHandle(e) {
    e.preventDefault();

    const response = await fetch("http://localhost/MYAPPL/steamImport.php", {
      method: "POST",
      credentials: "include",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        steamUrl: steamUrl,
      }),
    });
    await LoadGames();
  }

  async function uploadImage(file) {
    const formData = new FormData();

    formData.append("image", file);

    const response = await fetch("http://localhost/MYAPPL/ProfilePicture.php", {
      method: "POST",
      credentials: "include",
      body: formData,
    });

    const data = await response.json();

    setProfile(data.profile_picture);
    console.log(data);
  }
 

  return (
    <>
      <div id="Display">
        <input
          id="pfpinp"
          type="file"
          accept="image/*"
          onChange={handleFile}
        />

        <label htmlFor="pfpinp" style={{ cursor: "pointer" }}>
          <div id="hovey">
            <p>Click here to upload a new image</p>
          </div>

          {profile ? (
            <img
              id="pfp"
              src={`http://localhost/MYAPPL/uploads/user_uploads/${profile}?t=${Date.now()}`}
              loading="eager"
              alt="Profile"
              onLoad={()=>setLoaded(true)}
              className={loaded? "Loaded":"Loading"}
            />
          ) : (
            <img className={loaded? "Loaded":"Loading"} onLoad={()=>setLoaded(true)} id="pfp" src={`http://localhost/MYAPPL/uploads/user_uploads/default.webp`} alt="Default profile" />
          )}
        </label>

        <div>
          <p id="user_name" onLoad={()=>setLoaded(true)}
              className={loaded? "Loaded":"Loading"}>{username}</p>

          <Link to="/">
            <button id="logout" onClick={Logout}>
              Logout
            </button>
          </Link>
        </div>
      </div>

      <div id="Display_games">
        <div id="Platforms_disp">
          <div
            onClick={() => {
              setActive(1);
              changeColor("gray");
            }}
            className="Platforms_prop"
            id={active === 1 ? "Activated" : ""}
          >
            <img src={Archive} className="Platforms" alt="Archive" />
          </div>

          <div
            onClick={() => {
              setActive(2);
              changeColor("rgb(0, 12, 117)");
            }}
            className="Platforms_prop"
            id={active === 2 ? "Activated" : ""}
          >
            <img src={steam} className="Platforms" alt="Steam" />
          </div>

          <div
            onClick={() => {
              setActive(3);
              changeColor("white");
            }}
            className="Platforms_prop"
            id={active === 3 ? "Activated" : ""}
          >
            <img src={ps} className="Platforms" alt="PlayStation" />
          </div>
        </div>

        <div id="listOfGames">
          <input id="searchbar" type="Text" onChange={(e)=>setSearch(e.target.value)}></input>
          <div id="Archive">
          {loadingGames ?(<p></p>):
          (<>{active === 1 && (<div>
  <input
    type="text"
    placeholder="Search games..."
    value={query}
    onChange={(e) => setQuery(e.target.value)}
  />

  <button onClick={searchRAWG}>Search</button>

  {searchResults.map((game) => (
    <div className="Games" key={game.id}>
      <img src={game.rawg_image || game.image} className="Gamesimg" width="200" />
      <p>{game.name}</p>
       <button
       type="button"
      onClick={()=>addGame(game)}
      className="addBtn"
    >
      + Add to Library
    </button>
    </div>
  ))}
</div>)}
          {active === 2 && (
  text.length > 0 ? (
    displayedGames.map((game, index) => (
     <div className="Games" key={game.appid||index} background_image={game.rawg_image || game.image} >
      <img src={game.rawg_image || game.image} className="Gamesimg" width="200" />
      <p>{game.name}</p>
    </div>
    ))
  ) : (
    <form onSubmit={apiHandle}>
      <div id="connbtn">
        <input
          type="text"
          name="url"
          onChange={(e) => setUrl(e.target.value)}
        />
        <button id="Steambtn">Connect Steam</button>
      </div>
    </form>
  )
)}

          {active === 3 && <p>Something</p>}</>
        )}
        </div>
        </div>
      </div>

      {imagesrc && (
        <div className="cropModal">
          <div className="cropBox">
            <Cropper
              image={imagesrc}
              crop={crop}
              zoom={zoom}
              aspect={1}
              onCropChange={setCrop}
              onZoomChange={setZoom}
              onCropComplete={onCropComplete}
            />
          </div>

          <input
            type="range"
            min={1}
            max={3}
            step={0.1}
            value={zoom}
            onChange={(e) => setZoom(Number(e.target.value))}
          />

          <button onClick={saveCroppedImage}>Save</button>
        </div>
      )}
    </>
  );
}

export default Profile;