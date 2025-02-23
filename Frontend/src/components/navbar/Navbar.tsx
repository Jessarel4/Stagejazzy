import "./navbar.scss"

import logo from '../../LoginAssets/logoMMRS.png';
const Navbar = () => {
  return (
    <div className="navbar">
      <div className="logo">
        {/* <img src="miners.jpg" alt="" /> */}
        <img src={logo} alt="Logo Image" />
      </div>
      <div className="icons">
        <img src="search.svg" alt="" className="icon"/>
        <img src="app.svg" alt="" className="icon"/>
        <img src="expand.svg" alt="" className="icon"/>
        <div className="notification">
          <img src="notifications.svg" alt="" />
          <span>1</span>
        </div>
        <div className="user">
          <img src="jazzy.jpg" alt="" />
          <span>Jahaziela</span>
        </div>

        <img src="settings.svg" alt="" className="icon"/>
      </div>


    </div>
  )
}

export default Navbar