import { useState } from "react";
import { Link } from "react-router-dom";
import './Login.css';
import { useNavigate } from "react-router-dom";
import { redirect } from "react-router-dom";
import userEvent from "@testing-library/user-event";
function Login({setSuccess,success}){
    const [user,setUsername]=useState("")
    const [password,setPassword]=useState("")
    const navigate = useNavigate();
    async function SubmitLogin(e) {
        e.preventDefault();
        const response = await fetch("http://localhost/MYAPPL/logindb.php", {
            method: "POST",
            credentials: "include",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                user: user,
                password: password,
            })        });
        const data =await response.json();
        if(data.success){
            console.log(data);
            localStorage.setItem("loggedIn","true")
            localStorage.setItem("userName",user)
            localStorage.setItem("ID",data.ID)
            setSuccess(true)
            console.log(data.ID)
            navigate("/")
            
        }else{
            console.log(data);
        }
    }
    return(
        <div id="Login">
        <form onSubmit={SubmitLogin}>
        <div>
        <p>E-mail/Username:</p>
        <input className ="inputs" type='Text' onChange={(e)=>{setUsername(e.target.value)}}name='user'></input>
        </div>
        <div>
        <p>Password:</p>
        <input className ="inputs" type='Password' onChange={(e)=>setPassword(e.target.value)} name='password'></input>
        </div>
        <input id="button" type='submit' value='Login'></input>
        </form>
        <p id="confirmation">Don't have an account? Click <Link to="/log">here</Link> to sign in</p>
        </div>
    );
}
export default Login;