import { Form, Link } from 'react-router-dom';
import { useState } from "react";
import './Log.css';
import Login from './Login'
function Log({setSuccess, success}){
     const [email, setEmail] = useState("");
    const [username, setUsername] = useState("");
    const [password, setPassword] = useState("");
    const [confirm, setConfirm] = useState("");
    const [successa,setSuccessa]= useState(null);
    const [message,setMessage]=useState("RND");
    async function SubmitHandle(e) {
        e.preventDefault();
        setSuccessa(false)
        if(!username||!password||!email||!confirm){
            setSuccess(false)
            setSuccessa(true)
            setMessage("Plesae fill out all of the boxes")
            return;
        }
        if(password!=confirm){
            setSuccess(false)
            setSuccessa(true)
            setMessage("The password and the confirm do not match")
            return;
        }
        if(password.length<8){
            setSuccess(false)
            setSuccessa(true)
            setMessage("The password needs to be at least 8 characters long")
            return;
        }
        
       const response = await fetch("http://localhost/MYAPPL/conndb.php", {
    method: "POST",
    credentials: "include",
    headers: {
        "Content-Type": "application/json"
    },
    body: JSON.stringify({
        email: email,
        user: username,
        password: password
    })

});

const text = await response.text();
console.log(text);

const data = JSON.parse(text);
    
    setSuccess(data.success);
    if(data.success){
        setSuccessa(false)
    }else{
        setSuccess(false)
        setSuccessa(true)
        setMessage(data.message)
    }
    }
    return(
        <div id="Signup">
        <form onSubmit={SubmitHandle}>
        <div>
        <p>E-Mail:</p>
        <input className ="inputs"type='Text' onChange={(e)=>setEmail(e.target.value)} name='email'></input>
        </div>
        <div>
        <p>Username:</p>
        <input className ="inputs" type='Text' onChange={(e)=>setUsername(e.target.value)}name='user'></input>
        </div>
        <div>
        <p>Password:</p>
        <input className ="inputs" type='Password' onChange={(e)=>setPassword(e.target.value)} name='password'></input>
        </div>
        <div>
        <p>Confirm:</p>
        <input className ="inputs" type='Password' onChange={(e)=>setConfirm(e.target.value)}></input>
        </div>
        <input id="button" type='submit' value='Sign Up'></input>
        </form>
        <p style={{color:"red", fontSize:"12px", justifySelf:"center", marginRight:"1rem",marginTop:"1rem",color: successa ? "red":"black"}}>{message}</p>
        <p id="sum"></p>
        <p>{success?(<>Account successfuly created! Log in <Link className="LogLinks"to={"/Login"}>here</Link></>):(<>Already have an account? Go to Log in <Link className="LogLinks"to={"/Login"}>here</Link></>)}</p>
        </div>
    );
}
export default Log