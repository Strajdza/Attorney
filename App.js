import logo from './logo.svg';
import './App.css';
import { BrowserRouter, Routes, Route, Link, useNavigate } from 'react-router-dom';
import Log from './Log'
import Login from './Login'
import Profile from './Profile';
import { useEffect, useState } from 'react';
import Pallete from './palleteph.png';

import Loggedout from './Loggedout';
function Home({setSuccess,success}) {
  const username= localStorage.getItem("userName");
  const [loaded,setLoaded]=useState(true);
  const [recom,setRecom]=useState([]);
  const [disp,setDisp]=useState(false);
  const [custom,setCustom]=useState(1);
  const [theme, setTheme] = useState({
  colour1: "#00ffff",
  colour2: "#ff00ff",
  colour3: "#000000"
});
  const navigate = useNavigate()
  async function loadTheme() {
  const res = await fetch("http://localhost/MYAPPL/getColours.php", {
    credentials: "include",
  });

  const data = await res.json();

  if (!data || data.error) return;

  document.documentElement.style.setProperty("--glow-colour", data.colour1);
  document.documentElement.style.setProperty("--glow-colour2", data.colour2);
  document.documentElement.style.setProperty("--glowensi", data.colour3);

  setTheme({
    colour1: data.colour1,
    colour2: data.colour2,
    colour3: data.colour3
  });
}
   async function CheckSesh(){
    const response = await fetch("http://localhost/MYAPPL/checkSession.php", {
    credentials: "include",
  });

  const data = await response.json();
  setSuccess(data.loggedIn);
  }
  async function GetRecom(){
    const response = await fetch("http://localhost/MYAPPL/Recommend.php",{
      method:"POST",
      credentials: 'include'
    });
    const data = await response.json();
    setRecom(data.users || []);
  }
  useEffect(()=>{
    async function funcs(){
      if(!success){
        navigate("/Loggedout");
      }
      setLoaded(true);
  await CheckSesh();
  await GetRecom();
  await loadTheme();
  setLoaded(false)
    }
    funcs();
    },[success]);
    function DispDesign(){
        if(disp){
          setDisp(false);
        }else{
          setDisp(true);
        }
    }
   async function saveTheme() {
  const root = getComputedStyle(document.documentElement);
  const payload = {
    colour1: root.getPropertyValue("--glow-colour").trim(),
    colour2: root.getPropertyValue("--glow-colour2").trim(),
    colour3: root.getPropertyValue("--glowensi").trim(),
  };
 console.log("sending:", payload);
  await fetch("http://localhost/MYAPPL/saveColours.php", {
    method: "POST",
    credentials: "include",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(payload),
  });
}
  if(loaded){
    return null;
  }
  return (
    <div id="layout">
    <><nav className="app_nav">
      <a className='app_nav_a'>About</a>
      <p>|</p>
      <a className='app_nav_a'>Posts</a>
      <p>|</p>
      <p className='app_nav_p'>{success ? (<Link to="/Profile">{username}</Link>):(<Link to="/Login">LogIN</Link>)}</p>
      <div id="Customization">
      <img src={Pallete} onClick={DispDesign}></img>
      <div className={disp?"Displayed":"Hidden"}>
        <div id="customs">
          <div className='UI'><p>Primary Colour 1:</p><input
  type="color"
  value={theme.colour1}
  onChange={(e) => {
    const color = e.target.value;

    document.documentElement.style.setProperty("--glow-colour", color);

    setTheme(prev => ({
      ...prev,
      colour1: color
    }));
  }}
/></div>
          <div className='UI'><p>Primary Colour 2:</p><input
  type="color"
  value={theme.colour2}
  onChange={(e) => {
    const color = e.target.value;

    document.documentElement.style.setProperty("--glow-colour2", color);

    setTheme(prev => ({
      ...prev,
      colour2: color
    }));
  }}
/></div>
          <div className='UI'><p>Primary Colour 3:</p><input
  type="color"
  value={theme.colour3}
  onChange={(e) => {
    const color = e.target.value;

    document.documentElement.style.setProperty("--glowensi", color);

    setTheme(prev => ({
      ...prev,
      colour3: color
    }));
  }}
/></div>
        </div>
        <button onClick={saveTheme} id='UISave'>Save</button>
      </div>
      </div>
    </nav>
    <div className="option">
      <h1>Explore</h1>
      </div>
      <div id='recomdiv'>
        {recom.map((users,index) => (
          <div key={users.id||index} className='UserDisp'>
          <img className="Gamesimg" src={users.image ? (`http://localhost/MYAPPL/uploads/user_uploads/${users.image}`):(`http://localhost/MYAPPL/uploads/user_uploads/default.png`)}></img>
          <p>{users.user}</p>
          </div>
        ))}
      </div>
      </>
      </div>
  );
}
function App(){
  const [success, setSuccess]= useState(localStorage.getItem("loggedIn")==="true");
  
  return(
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Home setSuccess={setSuccess} success={success}/>} />
        <Route path="/Login" element={<Login setSuccess={setSuccess} success={success}/>}/>
        <Route path="/log" element={<Log setSuccess={setSuccess} success={success}/>} />      
        <Route path="/Profile" element={<Profile setSuccess={setSuccess} success={success}/>}/> 
        <Route path="/Loggedout" element={<Loggedout/>}/>
      </Routes>
    </BrowserRouter>
      
  );
}

export default App;
