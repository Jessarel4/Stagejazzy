import Home from "./pages/home/Home"


import {
  createBrowserRouter,
  RouterProvider,
  Outlet
} from "react-router-dom";
import Products from "./pages/products/Products";
import Users from "./pages/users/Users";
import Navbar from "./components/navbar/Navbar";
import Footer from "./components/footer/Footer";
import Menu from "./components/menu/Menu";
import Login from "./pages/login/Login";
import "./styles/global.scss"
import LpInfo from "./pages/LpInfo/LpInfo";
import Ze from "./pages/Ze/Ze";
import Direction from "./pages/Direction/Direction";
import Lpinfochart from "./pages/Lpinfochart/Lpinfochart";
import Commune from "./pages/Commune/Commune";
import ZeChart from "./pages/ZeChart/ZeChart";
import Singin from "./pages/singin/Singin";


function App() {

  const Layout = ()=>{
    return(
      <div className="main">
        <Navbar/>
        <div className="container">
          <div className="menuContainer">
            <Menu/>
          </div>
          <div className="contentContainer">
            <Outlet/>

          </div>
        </div>
        <Footer/>
      </div>
    )
  }

  const router = createBrowserRouter([
    {
      path: "/",
      element:<Layout/>,
      children:[
        {
          path:"/",
          element:<Home/>
        },
        {
          path:"/users",
          element:<Users/>
        },
        {
          path:"/products",
          element:<Products/>
        },
        {
          path:"/LpInfo",
          element:<LpInfo/>
        },
        {
          path:"/Ze",
          element:<Ze/>
        },
        {
          path:"/Direction",
          element:<Direction/>
        },
        {
          path:"/Lpinfochart",
          element:<Lpinfochart/>
        },
        {
          path:"/Commune",
          element:<Commune/>
        },
        {
          path:"/ZeChart",
          element:<ZeChart/>
        },
      ]
    },
    {
      path:"/login",
      element:<Login/>
    },
    {
      path:"/Singin",
      element:<Singin/>
    },
    
  ]);


  return (
    <RouterProvider router={router}/>
  )
}

export default App
