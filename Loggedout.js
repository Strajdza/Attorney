import { Link } from "react-router-dom";
import './Loggedout.css';
function Loggedout(){
    return(
        <div id="layoutout">
    <><nav className="app_nav">
      <a className="app_nav_a">About</a>
      <p>|</p>
      <a className="app_nav_a">Posts</a>
      <p>|</p>
      <p className="app_nav_p"><Link to="/Login">LogIN</Link></p>
      </nav>
      </>
      </div>
    )
}
export default Loggedout;